---
extends: _layouts.blog
section: article
tags: [NativePHP, Update]
published: true

title: NativePHP for Desktop - July 2025 Update
description: These updates bring enhanced features, improved compatibility, and important dependency upgrades to help you build better desktop applications with Laravel.
date: 2025-08-06
readTime: 5 minute read
---

Cross-posted on [NativePHP's blog](https://nativephp.com/blog/nativephp-for-desktop-july-2025-update)

We're excited to announce new releases for all NativePHP for Desktop packages! These updates bring enhanced features, improved compatibility, and important dependency upgrades to help you build better desktop applications with Laravel.

Full release notes can always be seen on our [Releases](https://nativephp.com/docs/desktop/1/getting-started/releasenotes) page.

### `nativephp/laravel` v1.2.0 & `nativephp/electron` v1.2.0

Our Laravel package and Electron driver have been updated in tandem with several coordinated improvements:

#### Key Features:

- **Azure Trusted Signing Support**: Both packages now support Azure code signing, making it easier to distribute trusted Windows applications ([Docs](https://nativephp.com/docs/desktop/1/publishing/building#windows))

- **Enhanced Printing Options**: Print settings can now be passed directly through the API with custom settings support, giving you more control over document output ([Docs](https://nativephp.com/docs/desktop/1/the-basics/system#print-settings))

- **New Window Management Options**: Added `skipTaskbar` and `hiddenInMissionControl` properties for better window control on different operating systems ([Docs](https://nativephp.com/docs/desktop/1/the-basics/windows#taskbar-and-mission-control-visibility))

- **Auto-Update Event Fix**: Fixed skip auto-update files creation when auto-updater is disabled

- **Windows Deep-Link Fix**: Resolved a critical bug that was causing deep links to crash on Windows

### Electron-Specific Improvements:

- **Improved Mac Notarization**: Notarization hooks now only trigger on Mac build targets, streamlining the build process

- **Better Certificate Handling**: Now uses the default vendor cacert.pem for custom binaries, improving SSL/TLS reliability

- **Build process**: Under the hood compatibility improvements

These releases work together to ensure your NativePHP applications run smoothly across all platforms with the latest Laravel versions.

### `nativephp/php-bin` v1.1.0

Our PHP binary package has been upgraded with critical updates:

#### Key Features:

- **mbregex Extension**: Added support for multibyte regular expressions - this extension is required for Laravel ^12.21 compatibility

- **SPC Updates**: Upgraded to static-php-cli (SPC) version 2.7.1

- **Fresh PHP Builds**: Updated PHP 8.3 and 8.4 builds to the very latest versions across all platforms (Windows, macOS, Linux) for both x64 and ARM64 architectures

### A Note on Laravel 12.21 Compatibility

We recently encountered compatibility challenges with Laravel 12.21 that took some time to resolve. This update to Laravel now requires the `mbregex` extension to be installed in PHP.

In most default PHP installations, this is most likely already enabled, but in our case, it wasn't. This required some upstream updates in the [static-php-cli](https://github.com/crazywhalecc/static-php-cli) repository that we rely on to build our PHP binaries.

We appreciate the community's patience while we worked with the maintainers to ensure everything plays nicely together.

The latest releases fully address these compatibility issues, and your applications should now work seamlessly with the latest Laravel versions.

### Upgrading

As always, all of this is just a `composer update` away 🚀

### Thank You to Our Contributors

These releases wouldn't be possible without the amazing work from our contributors and maintainers. Special thanks to:

- [@WINBIGFOX](https://github.com/WINBIGFOX) for implementing the window management options and auto-update event fixes

- [@faustbrian](https://github.com/faustbrian) for adding Azure Trusted Signing support across both Laravel and Electron packages

We're also grateful to the entire NativePHP community for your patience, feedback, and continued support.

### Looking Forward

These releases represent our continued commitment to making desktop application development with NativePHP as smooth and powerful as possible. Your contributions and feedback make NativePHP better with every release.

As a reminder, NativePHP for Desktop is (and will remain) free and open source. We welcome contributions and [sponsorship](https://nativephp.com/sponsor) to support this important project.

Happy building! 🚀

— Willem
