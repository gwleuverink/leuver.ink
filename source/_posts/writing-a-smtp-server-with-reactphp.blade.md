---
extends: _layouts.blog
section: article
tags: [ReactPHP, Experiment]
published: true

title: Implementing a SMTP server with ReactPHP
date: 2024-07-02
readTime: 20 minute read
---

Let's be real - debugging emails in web development used to be a massive headache back in the day. Tools like [Helo](https://beyondco.de/software/helo) or services like [Mailtrap](https://mailtrap.io/) make testing emails easier than ever before. I've recently set out to build [Phost](https://github.com/gwleuverink/phost), a similar tool built with [NativePHP](https://nativephp.com/). Purely out of interest, to see if it could be done with PHP alone. The foundation of this side project is a local SMTP server, implemented with [ReactPHP](https://reactphp.org/).

_Here's a sneak preview of Phost in action 👀_
<img src="/assets/images/phost-filled-inbox.png" alt="Filled inbox screenshot" />

<!-- <img src="/assets/images/phost-settings.png" alt="User preferences screenshot" /> -->

In this blog post, we're going to dive into the SMTP protocol and get our hands dirty building a simple SMTP server with [ReactPHP](https://reactphp.org/). Buckle up, grab a snack, and get ready to level up your email/non-blocking PHP game!

### What we're building

Let's start off by defining how we'd like to interact with the API. In Phost I use a API similar to this.

```php
// Start a new server
App\Smtp\Server::new(2525)
    ->onMessageReceived(function ($content) {
        // Handle How you'd like to process the message in this callback
    })->serve();
```

I find providing callback hooks to classes to be a pretty versatile & scalable approach. It's easy to expand with additional hooks in the future & moves the responsibility for handling messages to the consuming class instead so it can be more easily extracted as a package in the futute. In Phost, I dispatch a Event from this callback.

<!-- Whenever this code is invoked it executes in a non-blocking manner on a new thread that keeps running after the execution of this code finishes. All we need to do is to make sure it keeps running. -->

### Let's review the SMTP protocol

The SMTP protocol built on top of the **TCP/IP protocol** that typically listens on port **25**. For the purposes of this post I'll omit the authentication handshake, since we're building a local SMTP server used for debugging there is no auth required. So, let's dig right in.

In essence, the SMTP protocol follows a straightforward request-response pattern between the client (sender) and the server (receiver). Here's a concise overview of the process:

1. Connection: The client establishes a TCP connection with the SMTP server.
2. Greeting: The server sends a greeting message, typically starting with code 220.
3. HELO/EHLO: The client identifies itself to the server using the HELO or EHLO command.
4. Mail Transaction:
   - MAIL FROM: The client specifies the sender's email address.
   - RCPT TO: The client specifies the recipient's email address (can be multiple).
   - DATA: The client indicates it's ready to send the message content. Once this command is received, the server begins accepting the actual message content.
5. Message Content: The client transmits the email content line by line, including headers and body.
6. End of Message: The client signals the end of the message with a single dot (.) on a line by itself.
7. Server Acceptance: The server acknowledges receipt of the message.
8. QUIT: The client ends the session.

Each command sent by the client is typically acknowledged by the server with a response code and message. Here's an example of this exchange:

```text

CLIENT: HELO example.com
SERVER: 250 Hello example.com

CLIENT: MAIL FROM:<sender@example.com>
SERVER: 250 OK

CLIENT: RCPT TO:<recipient@example.com>
SERVER: 250 OK

CLIENT: DATA
SERVER: 354 Start mail input; end with <CRLF>.<CRLF>

CLIENT: Subject: Test Email
CLIENT:
CLIENT: This is a test email.
CLIENT: .
SERVER: 250 OK

CLIENT: QUIT
SERVER: 221 Bye

```

This simplified explanation covers the basic flow of the SMTP protocol without delving into authentication or more complex scenarios. In our local SMTP server implementation with ReactPHP, we'll focus on handling these core commands to create a functional debugging tool.

For a visual representation of this process, refer to the following graphic from [PostmarkApp's SMTP guide](https://postmarkapp.com/guides/everything-you-need-to-know-about-smtp)):

<img class="mx-4 mt-2 mb-5 rounded-xl drop-shadow-2xl dark:invert" src="/assets/images/postmark-smtp-commands-overview.png" alt="SMTP Commands overview">

This diagram effectively illustrates the SMTP communication flow we've just discussed.

### Implementing the protocol with ReactPHP

Next, let's dive in to how we can implement these steps with ReactPHP. We'll start off with some boilerplate for our Server class for all the properties we'll need to make this work. Note that we'll implement te protocol inside the **serve** method. We'll dive into that later (note the ... sections are collapsable).

```php
class Server
{
    protected const HOST = '127.0.0.1';

    protected int $port;

    /** Holds our ReactPHP loop */
    protected LoopInterface $loop;

    /** Holds the ReactPHP server instance */
    protected ?ServerInterface $socket = null;

    /** @var callable(string):void */
    protected $onMessageReceivedCallback;

    public function __construct(int $port = 2525) // [tl! collapse:4]
    {
        $this->port = $port;
        $this->loop = new StreamSelectLoop;
    }

    /** Simple static constructor - Server::new(2525) */
    public static function new(int $port = 2525): self // [tl! collapse:3]
    {
        return new static($port);
    }

    /** Sets the messageReceived callback */
    public function onMessageReceived(callable $callback): self // [tl! collapse:5]
    {
        $this->onMessageReceivedCallback = $callback;

        return $this;
    }

    public function serve(): void
    {
        // This is where we'll implement the SMTP protocol.
    }

}
```

Okay, now we've set up the boilerplate, let's encapsulate those Commands & Responses according to the SMTP spec in an Enum so it communicates it's intent better. We don't want to read random numbers in our code after all.

```php
enum Command: string
{
    case EHLO = 'EHLO';
    case HELO = 'HELO';
    case DATA = 'DATA';
    case QUIT = 'QUIT';
    case RESET = 'RSET';
    case FROM_HEADER = 'MAIL FROM';
    case RECIPIENT_HEADER = 'RCPT TO';
}
```

```php
enum Reply: string
{
    case Ready = '220';
    case Goodbye = '221';
    case Okay = '250';
    case StartTransfer = '354';
    case CommandNotImplemented = '504';
}
```

Now all this is out of the way let's implement the protocol in the **serve** method.

Admittidly this method is very chunky, since we're basically sending & receiving messages within a big event loop. It's a bit of a challenge to get your mind around, but keeping it in a single method like this is probably the best way to convey how to implement the steps as described above. We'll refactor this later!

To make this a bit more readable, we'll assume this is run within a Laravel app. So we can use Laravel's [Fluent string](https://laravel.com/docs/11.x/strings#fluent-strings-method-list) methods to iterate over and match messages the client sends to the server.

So, let's go through the protocol step by step. All steps from the 'SMTP protocol in review' heading above are annotated in the comments so hopefully it's a bit easier to follow.

```php
public function serve(): void
{
    // First we'll create a new SocketServer.
    $this->socket = new SocketServer(self::HOST . ':' . $this->port, [], $this->loop);


    // Step 1 - Your server is running! Now, the `connection` callback is invoked when a client [tl! highlight:2]
    // establishes a SMTP connection. This is where the protocol implementation starts.
    $this->socket->on('connection', function (ConnectionInterface $connection) {

        logger("SMTP server | Established SMTP connection on: {$connection->getLocalAddress()}");

        // We'll define two variables to hold the message content & transferring state.
        $content = '';
        $transferring = false;


        // Step 2 - Instruct the client to start sending the data stream by dispatching a 220 Ready reply. [tl! highlight:1]
        $connection->write(Reply::Ready->value . " Ok!\r\n");

        // These were steps 1 & 2. The client will now initiate the data transfer.
        $connection->on('data', function ($data) use ($connection, &$content, &$transferring) {

            // This callback will be invoked whenever the server receives some part of the email ($data)
            // We need to go through these messages line by line in order to implement step 3 through 8
            str($data)
                ->explode(PHP_EOL)
                ->each(function (string $line) use ($connection, &$content, &$transferring) {

                    // Step 3 through 8 will be implemented in this closure [tl! highlight]

                });

        });

        $connection->on('close', function () use ($connection) {
            logger("SMTP server | Closed SMTP connection on: {$connection->getLocalAddress()}");
        });

    });

    // After all Commands & Replies are implemented we'll start the event loop! [tl! highlight:1]
    $this->loop->run();
}
```

Alright, now let's zoom in on that highlighted part where we process the incoming data line by line. This is where we'll implement step 3 through 8.

```php
str($data)
    ->explode(PHP_EOL)
    ->each(function (string $line) use ($connection, &$content, &$transferring) {

        $line = str($line)->trim();

        // ------------------------------------------------------------------- [tl! highlight:5]
        // Abort signals
        //
        // Since the client can send abort signals at any time we need to
        // prioritize these. We'll check for the RSET & QUIT commands
        // -------------------------------------------------------------------
        if ($line->startsWith(Command::RESET->value)) {
            // Reset the $content & $transferring state & reply with 250 Okay
            // in order to instruct the client to resend the message.

            logger('SMTP server | ' . Reply::Okay->value . ' - received RSET');

            $content = '';
            $transferring = false;
            $connection->write(Reply::Okay->value . "SMTP transfer reset!\r\n");

            return false;
        }

        if ($line->startsWith(Command::QUIT->value)) {
            // Close the connection

            logger('SMTP server | ' . Reply::Goodbye->value . ' - received QUIT');

            $transferring = false;
            $connection->end(Reply::Goodbye->value . " Goodbye!\r\n");

            return false;
        }


        // ------------------------------------------------------------------- [tl! highlight:6]
        // Preparing for transfer ($transferring === false)
        //
        // Step 3 & 4 as described earlier in this post. After HELO/EHLO,
        // Recipient & From headers are received the server will reply
        // reply with a 354 & set the $transferring state to 'true'.
        // -------------------------------------------------------------------

        if(! $transferring) {

            if ($line->startsWith(Command::EHLO->value)) {
                logger('SMTP server | ' . Reply::Okay->value . ' - received ' . $line->toString());
                $connection->write(Reply::Okay->value . " Ok!\r\n");

                return false;
            }

            if ($line->startsWith(Command::HELO->value)) {
                logger('SMTP server | ' . Reply::Okay->value . ' - received ' . $line->toString());
                $connection->write(Reply::Okay->value . " Ok!\r\n");

                return false;
            }

            if ($line->startsWith(Command::FROM_HEADER->value)) {
                logger('SMTP server | ' . Reply::Okay->value . ' - received MAIL FROM');

                $connection->write(Reply::Okay->value . " Ok!\r\n");

                return false;
            }

            if ($line->startsWith(Command::RECIPIENT_HEADER->value)) {
                logger('SMTP server | ' . Reply::Okay->value . ' - received RCPT TO');

                $connection->write(Reply::Okay->value . " Ok!\r\n");

                return false;
            }

            if ($line->toString() === Command::DATA->value) {
                logger('SMTP server | ' . Reply::StartTransfer->value . ' - starting message transfer');
                $connection->write(Reply::StartTransfer->value . " Start transfer\r\n");

                $transferring = true;

                return false;
            }

        }


        // ------------------------------------------------------------------- [tl! highlight:6]
        // Receiving the message content ($transferring === true)
        //
        // Step 5 & 8 as described earlier in this post. After the handshake
        // -------------------------------------------------------------------
        if ($transferring) {

            // If a '.' wasn't on a line by itself, we have'nt reached the end
            // of the message yet. Append the line to the $content variable
            if ($line->toString() !== '.') {
                // All ok. Append message content
                $content .= $line->append(PHP_EOL)->toString();

                return true;
            }


            // Otherwise, a '.' was on a line by itself, we've reached the end of the message.
            // Invoke the onMessageReceivedCallback & reply with a final 250 Okay response
            // to let the client know we've received the whole thing.
            logger('SMTP server | ' . Reply::Okay->value . ' - message received!');

            call_user_func($this->onMessageReceivedCallback, $content);

            $connection->write(Reply::Okay->value . " Ok!\r\n");
            $transferring = false;

            return false;
        }


        // ------------------------------------------------------------------- [tl! highlight:3]
        // Finally, catch any Commands that we haven't implemented.
        // Then close the connection.
        // -------------------------------------------------------------------
        logger('SMTP server | Not implemented - ' . $line->toString());
        $connection->write(Reply::CommandNotImplemented->value . " Not implemented\r\n"); // Okay
        $connection->close();

    });
```

Okay. This should cover our needs for a super basic SMTP server. It's a bit messy still, but will do the trick.
For this example I've shuffled things around a bit so the order is more aligned with the steps mentioned in the beginning. The [implementation I've used for Phost](https://github.com/gwleuverink/phost/blob/main/app/Services/Smtp/Server.php) is ordered differently and a bit more complete.

### Let's see if this works

Cool! I'd say it's high time to try it out. I'll use a Laravel command to start the server from the command line.

Open up your `routes/console.php` file and add the following:

```php
Artisan::command('smtp:serve', function () {

    App\Smtp\Server::new(2525)
        ->onMessageReceived(function ($content) {
            $this->info($content);
        })->serve();
});
```

Then start the server using `php artisan smtp:serve`.

Now, if you configure any local project to use localhost port 2525 as a SMTP server it will be received by the process you've just started & dump the raw email content in your terminal.

### Conclusion and What's Next

This by itself is pretty cool, but combined with the excellent [`zbateson/mail-mime-parser`](https://github.com/zbateson/mail-mime-parser) package you are able to extract all sorts of information from the raw email. Like, html & text versions, headers, attachments e.t.c.

These two components form the basis of Phost, the NativePHP project i'm experimenting with. At the time of writing the app is not yet released, But stay tuned for more and check out [the repo](https://github.com/gwleuverink/phost)!
