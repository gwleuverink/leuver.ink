---
extends: _layouts.blog
section: article
tags: [NativePHP, Laravel, OAuth]
published: true

title: Adding an OAuth Callback Server to Your NativePHP App
description: NativePHP doesn't ship with OAuth support. Turns out you don't need it to. PHP's built-in server and a few lines of code is all it takes.
date: 2026-02-16
readTime: 5 minute read
---

One of the most requested features for [NativePHP Desktop](https://nativephp.com/docs/desktop/) is OAuth support. Connecting your desktop app to GitHub, Google, Slack, or any other provider requires a local HTTP server to receive the callback. NativePHP doesn't ship with one.

Here's the thing though: you don't need a framework feature for this. PHP's built-in server, a `ChildProcess`, and a dedicated route file. That's it. You get a fully isolated OAuth endpoint that boots its own Laravel instance, exposes nothing else from your app, and can be started or stopped on demand.

Let me walk you through it.

### The Server

The core of this is a service class that manages a PHP built-in server as a child process. It finds a free port, caches it, and spawns the server.

```php
namespace App\Services\OAuth;

use Illuminate\Support\Facades\Cache;
use Native\Desktop\Facades\ChildProcess;

class OAuthServer
{
    public const ALIAS = 'oauth-server';

    public function start(): void // [tl! focus:start]
    {
        if ($this->isRunning()) {
            return;
        }

        $port = $this->findAvailablePort();

        Cache::forever('oauth.port', $port);

        ChildProcess::php(
            cmd: ['-S', "127.0.0.1:{$port}", base_path('app/Services/OAuth/server.php')],
            alias: self::ALIAS,
            persistent: true,
        );
    } // [tl! focus:end]

    protected function findAvailablePort(): int
    {
        $socket = stream_socket_server('tcp://127.0.0.1:0');
        $name = stream_socket_get_name($socket, false);
        $port = (int) substr($name, strrpos($name, ':') + 1);
        fclose($socket);

        return $port;
    }

    // Other methods omitted for clarity, these are easy to imagine
    // Things like stop, restart, port, callbackUrl & isRunning
}
```

No hardcoded ports. `stream_socket_server` with port `0` asks the OS for a free one, we grab the assigned port, close the socket, and hand it to `php -S`. The port is cached so anything in your app can look it up later when constructing the redirect URI for your OAuth provider.

### The Entry Point

The `server.php` file is what gets served by PHP's built-in server. This is where it gets interesting. It bootstraps its own Laravel application with a **dedicated route file**. Not your `web.php`. Not your API routes. Just OAuth routes.

```php
<?php
// app/Services/OAuth/server.php

use Illuminate\Http\Request;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Middleware;

define('LARAVEL_START', microtime(true));

require __DIR__ . '/../../../vendor/autoload.php';

$app = Application::configure(basePath: dirname(__DIR__, 3)) // [tl! focus:start]
    ->withRouting(
        web: __DIR__ . '/../../../routes/oauth.php', // [tl! highlight]
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // The world is your oyster. You can do anything
    })
    ->create(); // [tl! focus:end]

$app->handleRequest(Request::capture());
```

This is a full Laravel instance. Config, cache, database, the lot. But it **only loads `routes/oauth.php`**. Your main application's routes, controllers, and middleware are completely invisible to this server. From the outside it's a tiny HTTP server with exactly the endpoints you choose to expose. Nothing more.

### The Routes

The `routes/oauth.php` file is a standard Laravel route file. Start simple:

```php
<?php
// routes/oauth.php

use Laravel\Socialite\Socialite;
use Illuminate\Support\Facades\Route;

Route::get('/github', function () {
    $user = Socialite::driver('github')->stateless()->user();

    // Do your thing here.

    event(new \App\Events\OAuthCallbackReceived('github')); // [tl! highlight]

    return 'Connected! You may close this window.';
});
```

That highlighted `event()` call is key. NativePHP dispatches all events to the main process over IPC, where Laravel handles them and [broadcasts](https://nativephp.com/docs/desktop/2/digging-deeper/broadcasting) them back to your frontend. Make your event implement `ShouldBroadcastNow`, listen for it in your Livewire component with the `native:` prefix, and the "Connect" button turns into "Connected" the moment the user completes the OAuth flow. No polling. No timers. Just events.

### Starting On Boot

Wire up the server in your `NativeAppServiceProvider` and it starts alongside your app:

```php
// app/Providers/NativeAppServiceProvider.php

public function boot(): void
{
    // ... other boot logic

    app(OAuthServer::class)->start(); // [tl! highlight]
}
```

Or don't start it on boot. Start it when the user navigates to your settings page. Stop it after the callback comes in. It's your server, you decide when it runs.

```php
// In a Livewire component
use Native\Desktop\Facades\Shell;
use App\Services\OAuth\OAuthServer;

public function connectGitHub(OAuthServer $server)
{
    $server->start();

    Shell::openExternal(
        "https://github.com/login/oauth/authorize?redirect_uri={$server->callbackUrl('github')}"
    );
}
```

### Why Not Just Add a Route to Your Main App?

Your NativePHP app is served by Electron's internal server. Adding an OAuth callback route to `web.php` means it's only accessible through the Electron window, not from an external browser redirect.

The PHP built-in server runs separately on `127.0.0.1` with its own port. GitHub (or any provider) can redirect to it just fine. And because it bootstraps its own `Application` instance with only `routes/oauth.php`, there's zero risk of accidentally exposing your entire app on a network-accessible port.

### Wrapping Up

The whole thing is three files: a server class, an entry point, and a route file. No packages. No complex infrastructure. Just PHP doing what PHP does. Serving HTTP requests.

The beauty of rolling your own is that you control everything. Want to add GitLab? Add a route. Want to stop the server after the first callback? Call `stop()`. Want to run it on a specific port range? Modify `findAvailablePort()`. It's your code. Go wild.

— Willem
