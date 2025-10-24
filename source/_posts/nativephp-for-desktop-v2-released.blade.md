---
extends: _layouts.blog
section: article
tags: [NativePHP, Update]
published: true

title: NativePHP for Desktop v2 Released! 🚀
description: We're excited to announce the release of NativePHP for Desktop v2! This major version bump was necessary due to some backwards compatibility breaks, but also brings enhanced security defaults and some useful new features.
date: 2025-10-14
readTime: 8 minute read
---

Cross-posted on [NativePHP's blog](https://nativephp.com/blog/nativephp-for-desktop-v2-released)

We're excited to announce the release of NativePHP for Desktop v2! This major version bump was necessary due to some backwards compatibility breaks, but also brings enhanced security defaults and some useful new features.

Let's dive into what's new and what's changed.

### What's New in v2

#### 👋🏼 New Repo, Who Dis?

v2 has been released under a consolidated repository, [`nativephp/desktop`](https://github.com/nativephp/desktop). This merges the previous two repositories ([`nativephp/laravel`](https://github.com/nativephp/laravel) and [`nativephp/electron`](https://github.com/nativephp/electron)) into a single project.

As well as aligning nicely with `nativephp/mobile`, this makes the project overall more manageable and allows for further advancements to be rolled out more easily in the future.

The old repositories are still available and we will continue to support v1 for a time, but we encourage everyone to upgrade to v2 as soon as they can.

#### 🔒 Enhanced Security by Default

v2 ships with better security defaults out of the box. We've disabled `nodeIntegration` & enabled `contextIsolation` by default, following Electron's security best practices. This change helps protect your applications from potential security vulnerabilities.

**Need the old behavior?** No problem! You can easily re-enable nodeIntegration for specific windows using the `Window::webPreferences()` method when you need it.

[Docs](https://nativephp.com/docs/desktop/2/the-basics/windows#setting-webpage-features)

#### 🔧 Make adjustments to the Electron backend

If you need to make any specific adjustments to the underlying Electron app, you can publish it using:

```sh
php artisan native:install --publish
```

This will export the Electron project to `{project-root}/nativephp/electron` and allow you to fully control all of NativePHP's inner workings.

[Docs](https://nativephp.com/docs/desktop/2/getting-started/installation#publishing-the-electron-project)

#### 📦 Bundle Additional Files with Your App

One of the most requested features is finally here! v2 allows you to bundle additional files with your application that can be accessed at runtime. This is perfect for distributing additional resources with your app. Like pre-compiled executables.

This opens up entirely new possibilities for what your NativePHP applications can do.

[Docs](https://nativephp.com/docs/desktop/2/digging-deeper/files#bundling-application-resources)

#### ✨ New `ChildProcess::node()` method

We've added a convenient method to execute JavaScript files using the bundled Node.js runtime:

```php
ChildProcess::node(
    cmd: 'resources/js/filesystem-watcher.js',
    alias: 'filesystem-watcher'
);
```

- No need to compile JavaScript files beforehand
- Leverages the same Node.js version across all platforms

A corresponding method is available on the ChildProcess testing fake as well, so you can verify Node invocations with `ChildProcess::assertNode()`.

[Docs](https://nativephp.com/docs/desktop/2/digging-deeper/child-processes#node-scripts)

#### 🪟 WebPreferences for Menubar Windows

We've extended the `webPreferences` method to menubar windows! Previously, this powerful configuration option was only available for regular windows. Now you have the same level of control over your menubar applications.

[Docs](https://nativephp.com/docs/desktop/2/the-basics/menu-bar#setting-webpage-features)

#### 🐚 New `Shell` fake

Tests can now fake the `Shell` facade, letting you intercept and assert shell interactions (like opening files, revealing folders, or moving items to trash) without executing them.

```php
Shell::assertOpenedExternal('https://some-url.test');
```

[Docs](https://nativephp.com/docs/desktop/2/testing/shell)

#### Under the Hood: Electron v38

v2 upgrades to the latest Electron (v38), bringing you all the performance improvements, security enhancements, and new capabilities that come with a modern Electron foundation.

### Breaking Changes ⚠️

As with any major version, there are some breaking changes to be aware of:

#### macOS Support Changes

**Important:** v2 drops support for macOS **_Catalina_** and **_Big Sur_**. This change comes from the Electron v38 upgrade and aligns with Apple's supported OS versions. Most users should be unaffected, but please check your deployment targets before upgrading.

#### Security Defaults

As mentioned above, `nodeIntegration` is now disabled by default. While this improves security, it may affect applications that rely on this functionality. You can easily re-enable it using `Window::webPreferences()` where needed.

### Upgrading to v2

The package is now available at `nativephp/desktop` in a new repository. See our [upgrade guide](https://nativephp.com/docs/desktop/2/getting-started/upgrade-guide) for migration steps.

### Get Building!

v2 is available right now. Whether you're upgrading an existing application or starting a new project, we can't wait to see what you build with these new capabilities.

As always, NativePHP for Desktop remains **free and open source**. We welcome [contributions](https://github.com/nativephp) and [sponsorship](https://nativephp.com/sponsor) to keep this project thriving.

Happy building! 🚀

— Willem
