---
extends: _layouts.blog
section: article
tags: [NativePHP, Laravel, API]
published: true

title: Exposing a Local API in Your NativePHP App
description: The same pattern that powers OAuth callbacks can turn your NativePHP app into something external tools can talk to. CLI scripts, IDE extensions, browser plugins, you name it.
date: 2026-02-17
readTime: 6 minute read
---

In my <a href="/blog/2026-02-16/oauth-callback-server-in-nativephp/" target="_blank" rel="noopener">previous post</a> I showed how to spin up a local HTTP server for OAuth callbacks in <a href="https://nativephp.com/docs/desktop/" target="_blank" rel="noopener">NativePHP Desktop</a>. A `ChildProcess` running PHP's built-in server, bootstrapping Laravel with a dedicated route file.

That pattern is far more useful than just OAuth. It's a local API. A way for anything on your machine to securely interact with your running desktop application.

### The Problem

NativePHP apps live inside Electron. The PHP server that powers your UI is only accessible through Electron's internal process. You can't `curl` it. You can't hit it from a script. You can't point a webhook at it. It's sealed off by design.

That's great for security. Less great when you want your app to actually talk to the outside world.

### The Pattern

Same three files from the <a href="/blog/2026-02-16/oauth-callback-server-in-nativephp/" target="_blank" rel="noopener">OAuth post</a>. A service class that manages a `ChildProcess`, an entry point that bootstraps Laravel, and a dedicated route file. The only difference is what you put in that route file.

Instead of OAuth callbacks, you define API endpoints. And because it boots a full Laravel instance, you get everything you're used to: middleware, validation, Eloquent, jobs, events, Sanctum, gates. All of it.

```php
<?php
// routes/external.php

use Illuminate\Support\Facades\Route;

Route::get('/status', fn () => ['running' => true, 'version' => config('app.version')]);
Route::post('/actions/{action}', [ActionController::class, 'execute']);
```

Your main app's routes stay completely hidden. Only the endpoints in this file are exposed. You control the surface area down to the last route.

### What This Unlocks

Here's where it gets interesting. Once your desktop app has a local HTTP endpoint, all sorts of things become possible.

**CLI integration.** Write a companion CLI tool that talks to your running app. Trigger actions, query state, push data in. Your terminal and your desktop app, connected.

Write the port to a dotfile when the server starts, so external tools know where to find it:

```php
// In your server class, after finding the port
Storage::disk('user_home')->put('.myapp/port', $port);
```

```bash
# A companion CLI that talks to your running app
curl -s http://127.0.0.1:$(cat ~/.myapp/port)/status | jq .
```

**Git hooks.** A post-push hook that notifies your app, so it can kick off a deployment preview or update a dashboard in real time.

```bash
#!/bin/sh
# .git/hooks/post-push
curl -X POST http://127.0.0.1:$(cat ~/.myapp/port)/hooks/post-push \
  -H "Content-Type: application/json" \
  -d "{\"branch\": \"$(git branch --show-current)\"}"
```

**IDE extensions.** A VS Code extension that sends the current file path or selection to your app. Your NativePHP app becomes a companion to your editor.

**Browser extensions.** A Chrome extension that pushes URLs, page metadata, or form data into your desktop app. The browser talks HTTP, your app speaks HTTP. Done.

**Local webhooks.** Tools like Stripe CLI or ngrok can forward webhooks to your local API. Your desktop app processes them with full access to your database and services.

**Automation.** Alfred workflows, Raycast scripts, cron jobs, Shortcuts on macOS. Anything that can make an HTTP request can now interact with your app.

### Security

This server binds to `127.0.0.1`, not `0.0.0.0`. Only your machine can reach it. But "only your machine" still includes every process running on it, so you probably want some form of authentication.

A shared secret works well here. Generate one on first launch, write it to the same dotfile as your port, and require it via middleware on every request. Your CLI tools and scripts read the secret from that file. The server boots a full Laravel instance, so any auth mechanism you'd use in a regular Laravel app is available to you.

The port is random on every launch, which adds a layer of obscurity. Not security, obscurity. Don't rely on it. Use proper auth.

### Talking Back to the UI

Your local API can broadcast events to the frontend the same way the OAuth server does. Any request that comes in can dispatch an event implementing `ShouldBroadcastNow` on the `nativephp` channel, and your Livewire components pick it up instantly via the `native:` prefix.

```php
// In routes/external.php
Route::post('/hooks/post-push', function (Request $request) {
    event(new BuildTriggered($request->branch)); // Implements ShouldBroadcastNow

    return response()->noContent();
});

// In your Livewire component
#[On('native:BuildTriggered')]
public function handleBuild($branch)
{
    $this->latestBranch = $branch;
}
```

A git hook pings your API. Your API dispatches an event. Your UI updates. The user sees it happen in real time without lifting a finger.

### One Pattern, Many Servers

Nothing stops you from running multiple isolated servers. One for OAuth, one for your local API, one for webhooks. Each with its own route file, its own middleware, its own port. Or keep it simple and put everything behind one server with route groups. Your call.

### Wrapping Up

The OAuth callback server was the starting point. The local API is the destination. Same three files, same pattern, wildly different possibilities.

Your NativePHP app doesn't have to be an island. Give it an API and let the rest of your toolchain in.

— Willem

</article>
<x-callouts.devkeepr-banner class="mt-12" />
