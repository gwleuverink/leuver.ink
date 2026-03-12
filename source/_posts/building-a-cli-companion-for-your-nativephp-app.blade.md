---
extends: _layouts.blog
section: article
tags: [Series, NativePHP, Laravel, CLI]
published: true

title: Building a CLI Companion for Your NativePHP App
description: "Your NativePHP app has a SQLite database and can run a local API. That's all you need to build a CLI companion that extends your desktop app into the terminal."
date: 2026-03-12
readTime: 10 minute read
image: assets/images/dk-list-dark.png
---

In the <a href="/blog/2026-02-16/oauth-callback-server-in-nativephp/" target="_blank" rel="noopener">first post</a> of this series I showed how to spin up a local HTTP server inside a NativePHP app for OAuth callbacks. In the <a href="/blog/2026-02-17/exposing-a-local-api-in-nativephp/" target="_blank" rel="noopener">second</a>, I turned that into a local API that external tools can talk to.

This post ties it all together: a CLI companion that extends your desktop app into the terminal. Your NativePHP app already ships with PHP, so you can build a standalone CLI powered by that bundled binary. No PHP required on the user's machine. Think <a href="https://phpacker.dev" target="_blank" rel="noopener">phpacker</a>, but backed by your app's database and local API, with full <a href="https://laravel.com/docs/prompts" target="_blank" rel="noopener">Laravel Prompts</a> support.

The examples are taken from <a href="https://devkeepr.app" target="_blank" rel="noopener">Devkeepr</a>, a NativePHP desktop app I'm building for managing local dev environments. But the interesting part isn't what this specific CLI does. It's how a standalone executable discovers and communicates with a desktop application that may or may not be running.

<img class="rounded-xl dark:hidden" src="/assets/images/cli-install-light.png" alt="CLI install prompt">
<img class="rounded-xl drop-shadow-2xl hidden dark:block" src="/assets/images/cli-install-dark.png" alt="CLI install prompt">

> The examples here are macOS/Linux only. The architecture ports to Windows too. You'd swap the bash wrapper for a `.bat` or PowerShell script and adjust the install path.

### The Architecture

**Bash wrapper** → finds the right PHP binary and launches the CLI script.<br>
**PHP CLI application** → a Symfony Console app that handles user interaction.<br>
**SQLite database** → the CLI connects directly to the app's database for reads.<br>
**HTTP client** → talks to the desktop app's local API over `127.0.0.1`.<br>
**Local API server** → the same `ChildProcess` pattern from the previous posts, running inside the desktop app.

### The Local API Server

Same pattern from the <a href="/blog/2026-02-17/exposing-a-local-api-in-nativephp/" target="_blank" rel="noopener">API post</a>. The server grabs a free port, spawns PHP's built-in server, and writes a config file to `~/.devkeepr/cli.json`:

```php
namespace App\Services\Cli;

use Native\Desktop\Facades\ChildProcess;

class CliServer
{
    public const ALIAS = 'devkeepr-cli-server';

    public function start(): void
    {
        if ($this->isRunning()) {
            return;
        }

        // Grab a free port
        $port = $this->findAvailablePort();

        Cache::forever('cli.port', $port);

        // Spawn PHP's built-in server as a child process
        ChildProcess::php(
            cmd: ['-S', "127.0.0.1:{$port}", base_path('app/Services/Cli/server.php')], // [tl! highlight]
            alias: self::ALIAS,
            persistent: true,
        );

        // Write config so the CLI knows where to connect
        $this->writeCliConfig($port); // [tl! highlight]
    }

    protected function writeCliConfig(int $port): void
    {
        // Ensure the config directory exists
        $configDir = ($_SERVER['HOME'] ?? getenv('HOME')) . '/.devkeepr';

        if (! is_dir($configDir)) {
            mkdir($configDir, 0755, true);
        }

        // Write the port and database path for the CLI to discover
        file_put_contents(
            $configDir . '/cli.json',
            json_encode([
                'port' => $port, // [tl! highlight:1]
                'database' => config('database.connections.nativephp.database'),
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)
        );
    }

    // ...
}
```

That config file is the entire contract between the two processes. `port` tells the CLI where to send HTTP requests. `database` gives it direct read access to the SQLite file. The route file follows the same pattern from the previous post. Only `cli-api.php` is exposed, completely separate from your main application's routes.

### The Bash Wrapper

The CLI needs to work in two contexts: during development (where PHP is on your PATH) and inside a bundled `.app` (where PHP ships with the application).

```bash
#!/bin/bash

# Resolve the real path of this script (follows symlinks)
SOURCE="${BASH_SOURCE[0]}"
while [ -L "$SOURCE" ]; do
    DIR="$(cd -P "$(dirname "$SOURCE")" && pwd)"
    SOURCE="$(readlink "$SOURCE")"
    [[ "$SOURCE" != /* ]] && SOURCE="$DIR/$SOURCE"
done
SCRIPT_DIR="$(cd -P "$(dirname "$SOURCE")" && pwd)"
APP_ROOT="$(cd "$SCRIPT_DIR/.." && pwd)"

# Detect if running from a .app bundle or development
if [[ "$APP_ROOT" == *".app/Contents/Resources/build/app" ]]; then
    # Production: use bundled PHP
    PHP_BINARY="$(cd "$APP_ROOT/../php" && pwd)/php" # [tl! highlight]
else
    # Development: use system PHP
    PHP_BINARY=$(which php) # [tl! highlight]
fi

exec "$PHP_BINARY" "$SCRIPT_DIR/dk.php" "$@"
```

When a user runs `dk`, they're hitting a symlink at `/usr/local/bin/dk` that points into the `.app` bundle. The resolution loop follows that chain to find where the script actually lives, then checks the directory structure to decide which PHP binary to use.

### The PHP CLI Application

The bash wrapper launches `dk.php`. A standalone PHP script with no Laravel, no Artisan, no service container. It bootstraps what it needs manually:

```php
#!/usr/bin/env php
<?php

// Load Composer's autoloader (no Laravel, just the autoloader)
require __DIR__ . '/../vendor/autoload.php';

$_SERVER['PHP_SELF'] = 'dk';

// Read the config file the desktop app wrote on boot
$configFile = ($_SERVER['HOME'] ?? getenv('HOME')) . '/.devkeepr/cli.json'; // [tl! highlight]

if (! file_exists($configFile)) {
    error('Devkeepr is not running. Please start the app first.');
    exit(1);
}

$config = json_decode(file_get_contents($configFile), true); // [tl! highlight]
```

Here's an important architectural decision: **you don't need the API for most things.** NativePHP uses SQLite, so your CLI can read the database directly. You only need the HTTP API when the running app needs to know about a change. For pure reads, skip the API entirely.

The CLI connects to SQLite through Eloquent's Capsule manager, giving you the full ORM without booting Laravel:

```php
use Illuminate\Database\Capsule\Manager as Capsule;

// Set up the HTTP client for commands that need the running app
$client = new CliClient((int) $config['port']); // [tl! highlight]

// Connect directly to the app's SQLite database for reads
$capsule = new Capsule;
$capsule->addConnection([
    'driver' => 'sqlite',
    'database' => $config['database'], // [tl! highlight]
]);
$capsule->bootEloquent();
```

The application extends Symfony's `Application` with `cd` as the default command. Running `dk` with no arguments opens interactive project search, and any unrecognized command is treated as a search term. `dk myproject` doesn't throw an error, it searches your projects and teleports you there.

```php
$app = new class('Devkeepr CLI') extends Application
{
    public function doRun(InputInterface $input, OutputInterface $output): int
    {
        try {
            return parent::doRun($input, $output);
        } catch (CommandNotFoundException) {
            // Treat unknown command names as search argument for cd
            return parent::doRun( // [tl! highlight:3]
                new ArgvInput(['dk', 'cd', $input->getFirstArgument()]),
                $output,
            );
        }
    }
};

$app->addCommand(new ChangeDirectoryCommand($client));
$app->addCommand(new LinkCommand($client));
$app->addCommand(new ParkCommand($client));
// ...

$app->setDefaultCommand('cd'); // [tl! highlight]
```

### Database Commands

Some commands don't need the running app at all. They query SQLite directly and skip the API entirely.

The `cd` command is a good example. It queries the project database, presents an interactive search with <a href="https://laravel.com/docs/prompts" target="_blank" rel="noopener">Laravel Prompts</a>, and opens a subshell in the selected directory:

```php
class ChangeDirectoryCommand extends Command
{
    protected function configure(): void
    {
        $this->setName('cd')
            ->addArgument(
                'search', InputArgument::OPTIONAL,
                'Filter projects by name'
            );
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        // Query all projects directly from SQLite
        $projects = $this->projects();
        $query = $input->getArgument('search');

        // Skip the prompt if there's an exact match
        if ($path = $this->hasExactMatch($query ?? '', $projects)) {
            return $this->openShell($path);
        }

        // Show interactive fuzzy search
        $prompt = new SearchPrompt(
            label: 'Teleport to',
            options: function (string $value) use ($projects) {
                return $projects
                    ->filter(/* fuzzy match on project name */)
                    ->mapWithKeys(fn (Project $project) => [
                        $project->path => $this->formatLabel($project),
                    ])
                    ->all();
            },
        );

        return $this->openShell($prompt->prompt());
    }

    // ...
}
```

No HTTP involved. The desktop app doesn't even know about it. If the search term matches exactly one result, it skips the prompt and drops you straight in.

<img class="dark:hidden" src="/assets/images/dk-search-light.png" alt="CLI search prompt">
<img class="hidden dark:block" src="/assets/images/dk-search-dark.png" alt="CLI search prompt">

### API Commands

Commands that change state need the running app. The HTTP client is deliberately simple — no Guzzle, no external library. Just `file_get_contents` with a stream context pointing at `127.0.0.1`. If the request fails, the app isn't running.

For longer operations like hibernation, `spin()` from Laravel Prompts gives you a loading indicator while the request blocks:

```php
$response = spin(
    fn () => $this->client->post('/hibernate', ['path' => $path], timeout: 300),
    'Hibernating project...'
);
```

Because the API server runs a full Laravel instance, these requests can dispatch jobs, fire events, and broadcast to the desktop UI. The user runs a command in their terminal, and the app reacts in real time.

Take that same hibernation command. The controller dispatches the job synchronously, which does the heavy lifting — removing `vendor/`, `node_modules/`, whatever the project's stack dictates. When it's done, it fires a `HibernatedProject` event:

```php
class HibernatedProject
{
    use Dispatchable;

    public function __construct(
        public string $path,
        public int $bytesSaved,
    ) {}

    public function broadcastOn(): array // [tl! highlight:3]
    {
        return [new Channel('nativephp')];
    }
}
```

NativePHP picks up any event broadcast on the `nativephp` channel and pushes it to the frontend over IPC. In your Livewire component, you listen for it with the `native:` prefix:

```php
#[On('native:' . HibernatedProject::class)] // [tl! highlight]
public function onProjectHibernated(string $path): void
{
    // The UI updates instantly
}
```

The user types `dk hibernate` in their terminal. The CLI hits the API. The API dispatches the job. The job fires an event. The event broadcasts to the frontend. The desktop app updates. No polling, no refresh button. The terminal drives the app.

This works for any write operation. `dk link` registers a project and the overview page reflects it. `dk wake` restores dependencies and the project card updates its status. The CLI and the desktop app stay in sync through events, not through the CLI knowing anything about the UI.

### Installation

The CLI needs to land on the user's PATH. A symlink from `/usr/local/bin/dk` into the `.app` bundle does the trick:

```php
public function installCli(): void
{
    $source = base_path('bin/dk');
    $target = '/usr/local/bin/dk';

    // Symlink into /usr/local/bin with admin privileges
    Process::run([
        'osascript', '-e',
        "do shell script \"ln -sf {$source} {$target}\" with administrator privileges",
    ]);
}
```

One symlink, one elevation prompt. It points into the app bundle, so it always resolves to the correct version, even after updates. Uninstalling is just removing the symlink.

The desktop app writes `~/.devkeepr/cli.json` on boot and removes it on shutdown. The CLI checks for that file to know if the app is running. No heartbeats, no polling. The file is the signal.

Run the `list` command to verify everything is working 🧑‍🍳😙🤌

<img class="dark:hidden" src="/assets/images/dk-list-command-light.png" alt="CLI list command">
<img class="hidden dark:block" src="/assets/images/dk-list-command-dark.png" alt="CLI list command">

### Wrapping Up

None of this requires special NativePHP features. It's PHP, bash, SQLite, and HTTP, wired together in a way that turns a desktop application into something you can script from anywhere on your machine.

The key insight: most CLI operations can just read the database directly. The API is only necessary when changes need to reach the running app. That keeps the CLI fast and the architecture simple.

— Willem

</article>
<x-callouts.devkeepr-banner class="mt-12" />
