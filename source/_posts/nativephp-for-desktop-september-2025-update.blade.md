---
extends: _layouts.blog
section: article
tags: [NativePHP, Update]
published: true

title: NativePHP for Desktop - September 2025 Update
date: 2025-09-17
readTime: 6 minute read
---

We're excited to announce new releases across the NativePHP for Desktop ecosystem! This September update brings additional window management capabilities, enhanced internationalization support, and important stability improvements to help you build more reliable desktop applications with Laravel.

Full release notes can always be seen on our [Release notes](https://nativephp.com/docs/desktop/1/getting-started/releasenotes) page.

### `nativephp/laravel` v1.3.0 and `nativephp/electron` v1.3.0

This release introduces several new window management features which are particularly useful for kiosk applications & embedded content scenarios.

#### Window Management Features

The new zoom control functionality allows you to programmatically adjust zoom levels at runtime, overcoming previous limitations where zoom factors would "stick" to domains.

You can now use `Window::current()->setZoomFactor(1.25)` for 125% zoom, which is useful for kiosk applications on large displays ([Docs](https://nativephp.com/docs/desktop/1/the-basics/windows#zoom-factor))

The `navigation control methods` provide better control over user browsing behavior:

- `preventLeaveDomain()` - Keep users within your trusted domain while allowing internal navigation

- `preventLeavePage()` - Lock users to specific pages (allows only anchors and URL parameters)

- `suppressNewWindows()` - Disable new window creation when clicking links with `target="_blank"`

These features are especially valuable for kiosk-style applications and scenarios where you need to display external content with controlled navigation. ([Docs](https://nativephp.com/docs/desktop/1/the-basics/windows#restrict-navigation-within-a-window))

#### Internationalization Support

The new locale detection methods make it easier to build internationally-aware applications:

```php
use Native\Laravel\Facades\App;

App::getLocale(); // e.g. "de", "fr-FR"
App::getLocaleCountryCode(); // e.g. "US", "DE"
App::getSystemLocale(); // e.g. "it-IT", "de-DE"
```

These methods enable automatic language switching and region-specific content delivery by detecting the user's system preferences. ([Docs](https://nativephp.com/docs/desktop/1/the-basics/application#locale-information))

### Bug Fixes and Stability Improvements

**Windows Port Conflicts**: Resolved port binding conflicts that prevented multiple NativePHP applications from running simultaneously on Windows. The enhanced port detection now properly validates port availability before binding.

**Scheduler Process Cleanup**: Fixed background process management to ensure scheduler processes are properly terminated, preventing orphaned processes.

**Seed Command**: Fixed the `native:seed` command which was failing due to missing input expectations from the base Laravel command.

**Build Speed**: Skip creating update files when not using auto updates.

**Build Compatibility**: Temporarily downgraded electron-builder from v26 to v25 to resolve Windows build issues caused by a faulty dependency compatibility check when creating the app's Asar archive. We're monitoring the electron-builder repository for fixes to enable upgrading back to v26.

### Upgrading

As always, all of this is just a `composer update` away 🚀

### Thank You to Our Contributors

These releases wouldn't be possible without the amazing contributions from our community.

But special recognition goes to [@JulianGlueck](https://github.com/JulianGlueck) who made multiple outstanding contributions to NativePHP, implementing multiple window management features including zoom control, locale detection, navigation restrictions, and pop-up suppression.

The quality and scope of these contributions demonstrate the collaborative spirit that makes NativePHP better with every release.

We're grateful for the effort and attention to detail that went into these features, and we look forward to more contributions from our growing community.

This September release brings practical improvements to window management and internationalization support. The stability improvements ensure a more reliable development experience, particularly for Windows users.

As always, NativePHP for Desktop remains free and open source. We welcome contributions and [sponsorship](https://nativephp.com/sponsor) to support our continued development.

Happy building! 🚀

— Willem
