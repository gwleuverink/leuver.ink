---
extends: _layouts.blog
section: article
tags: [Laravel, Deployment, Static, Hosting]
published: true

title: Host Any Laravel Website Free on GitHub Pages
description: Skip the static site generator. A plain Laravel app, exported to static HTML and deployed to GitHub Pages straight from your terminal for free. Nothing new to learn, nothing to pay, and no rewrite the day it needs a server.
date: 2026-07-16
readTime: 7 minute read
---

Marketing sites, docs, portfolios, landing pages. Most of them don't need a server. They need HTML. And for years the answer has been to reach for a static site generator. Astro, Hugo, Eleventy, or for the Laravel inclined, <a href="https://jigsaw.tighten.com" target="_blank" rel="noopener">Jigsaw</a>. This very blog runs on it, and it's great.

But they all share the same problem. They're not Laravel. Even Jigsaw, which borrows Blade and feels wonderfully familiar, is still its own thing. Its own config, its own collections, its own event lifecycle, its own docs to keep open in a tab. It's Laravel-ish, and "ish" is exactly the part you keep tripping over.

Meanwhile you already know a fantastic tool for turning routes into HTML pages. You use it every day. So instead of learning a generator that mimics Laravel, use Laravel. A plain Laravel app, exported to static HTML, hosted on GitHub Pages for free. No new framework, no CI pipeline, no Netlify account, no VPS collecting dust. One command in your terminal and the site is live:

```bash
composer publish
```

That's the whole deploy. Let's look at the moving parts.

### The Idea

Laravel renders your pages, you just don't do it per-request. You do it once, at build time. <a href="https://github.com/spatie/laravel-export" target="_blank" rel="noopener">spatie/laravel-export</a> crawls your app and writes every page to disk as plain HTML. Then the <a href="https://github.com/tschaub/gh-pages" target="_blank" rel="noopener">gh-pages</a> CLI pushes that folder to a dedicated branch, which GitHub Pages serves for free.

Your main branch never sees a single build artifact. The `dist` folder stays gitignored, and the `gh-pages` branch is nothing but deploy snapshots. Two worlds, cleanly separated.

And because this is a real Laravel app, there is nothing new to learn. Routes are routes, views are views, `php artisan serve` just works. Blade components, view composers, collections mapping over content, Vite with Tailwind, route helpers, every package on Packagist. Your muscle memory is the static site generator. The only thing you give up is runtime PHP. Before we build anything, let's weigh that trade.

### What You Get for Free

Start with what this setup hands you without asking anything in return. GitHub Pages serves your site through a global CDN, so every page is edge cached close to your visitors. TLS certificates are provisioned and renewed automatically. Uptime is whatever GitHub's uptime is, which beats every $5 VPS I've ever babysat.

And it is fast. Here's the Lighthouse report for <a href="https://hummtuned.app" target="_blank" rel="noopener">hummtuned.app</a>, the latest site I shipped this way:

<img class="rounded-xl dark:hidden" src="/assets/images/hummtuned-lighthouse-light.png" alt="Lighthouse scores for hummtuned.app: 100 performance, 94 accessibility, 100 best practices, 100 SEO">
<img class="rounded-xl hidden dark:block" src="/assets/images/hummtuned-lighthouse-dark.png" alt="Lighthouse scores for hummtuned.app: 100 performance, 94 accessibility, 100 best practices, 100 SEO">

Landing page response times sit between **30 and 60 milliseconds**. No PHP to boot, no database to query, no cache to warm. That's not a fast server, that's no server at all.

### What You Give Up

No PHP runs at request time, so anything dynamic is out. Forms, auth, sessions, queues. If your site needs those, this isn't your deploy strategy.

In practice the line is easy to draw. A contact form can post to a service like Formspree or just be a `mailto:` link. Everything else, rendering markdown, looping over content, pulling data from an API at build time, works exactly like it always did. The site rebuilds when you publish, not when someone visits.

And when that line eventually moves, you're not stuck. The day the site needs a real form, a login, or a dashboard, you deploy the same repo to a server and it's a Laravel app again. Same routes, same views, same URLs, nothing to port. You just stop running the export. That's the part a static site generator can't offer you: outgrowing it means rewriting the whole thing.

Sold? Good. Let's build it.

### Exporting to Static

Pull in the export package:

```bash
composer require spatie/laravel-export
php artisan vendor:publish --provider="Spatie\Export\ExportServiceProvider" --tag=config
```

Running `php artisan export` crawls your site starting at `/`, follows every link it finds, and writes the result to a `dist` folder. Each route becomes a `route/index.html` file, so URLs keep working without any server-side rewrites.

The config needs little attention. These are the parts that matter:

```php
// config/export.php
return [
    // Follow links to discover all pages automatically
    'crawl' => true, // [tl! highlight]

    // Pages not linked from anywhere need to be listed manually
    'paths' => [
        '/', // [tl! highlight:2]
        'privacy',
        'terms',
    ],

    // But keep server-side files out of the static build
    'exclude_file_patterns' => [
        '/\.php$/', // [tl! highlight:1]
        '/public\/hot$/',
    ],

    // Copy the public folder into the export (compiled assets, favicons)
    'include_files' => [
        'public' => '',
    ],

    'clean_before_export' => true,
];
```

The crawler catches everything reachable from your homepage. Standalone pages like a privacy policy that only lives in your footer on some layouts, or an unlisted page, go in `paths` explicitly. When in doubt, list it. Duplicates cost nothing.

Don't forget to add `/dist` to your `.gitignore`.

### The Build Script

Here's the `build` script from hummtuned.app:

```json
"scripts": {
    "build": [
        "npm run build",
        "rm -f public/hot",
        "APP_ENV=production APP_URL=https://your-domain.com php artisan export" // [tl! highlight]
    ]
}
```

Three lines, hiding two lessons I learned the hard way.

**`rm -f public/hot`** removes Vite's hot file. If you've been running `npm run dev`, that file is still sitting in your public folder, and Laravel will happily render every asset URL pointing at your local dev server. Your production site then tries to load CSS from `localhost:5173`. Delete it before exporting, every time.

You might've noticed the export config also excludes this file. That only keeps it out of the `dist` folder. Laravel checks whether the file exists while rendering, so it has to be gone before the export starts. The exclude pattern is just a safety net.

**The inline environment variables** override your local `.env` for this one command. `APP_URL` matters because the exported HTML bakes in absolute URLs for canonical tags, og-images and sitemaps. `APP_ENV=production` makes sure no debug output leaks into your static pages. Your local `.env` stays untouched, so local dev keeps working like nothing happened.

At this point `composer build` gives you a `dist` folder you could drag onto any static host. But we're not dragging anything anywhere.

### Deploying from the CLI

This is where the gh-pages CLI comes in. It takes a folder, commits its contents to a branch, and force pushes that branch to your repo. No install needed, `npx` fetches it on demand:

```json
"scripts": {
    "publish": [
        "@composer run format",
        "@composer run build",
        "npx gh-pages --dist=dist --cname=your-domain.com --message=publish --nojekyll" // [tl! highlight]
    ]
}
```

Those flags do a fair bit of heavy lifting:

**`--dist=dist`** points at the export folder. Its contents become the root of the `gh-pages` branch.

**`--cname=your-domain.com`** writes a `CNAME` file into every deploy. GitHub Pages reads your custom domain from that file, and since the branch gets rewritten on every publish, it needs to be re-added every time. This flag handles that. Omit it if you're fine with the default `username.github.io/repo` URL.

**`--nojekyll`** adds a `.nojekyll` file. GitHub Pages runs every deploy through Jekyll by default, which ignores files starting with underscores and wastes time processing a site that's already built. This opts out.

**`--message=publish`** keeps the deploy branch history from looking like a changelog. Every commit on `gh-pages` is disposable anyway.

The `publish` script chains everything: Pint formats the code, the build compiles and exports, gh-pages ships it. From working copy to live site in one command, straight from your machine.

### Configuring GitHub

Fair warning: getting your DNS to play nice with GitHub can be a bit finicky. Propagation delays, a certificate that takes its sweet time provisioning, that one A record you fat-fingered. Budget an hour and don't panic when the first check fails. The good news is that it's a one-time job. Once your domain points at GitHub's servers, the rest is cake.

Start at your registrar and point the DNS at GitHub first, since propagation takes a while anyway. A `CNAME` record to `username.github.io` for subdomains, or <a href="https://docs.github.com/en/pages/configuring-a-custom-domain-for-your-github-pages-site/managing-a-custom-domain-for-your-github-pages-site" target="_blank" rel="noopener">A records for apex domains</a>.

While that percolates, run `composer publish` once so the `gh-pages` branch exists and is pushed. Then head to your repo's **Settings → Pages** and set the source to **Deploy from a branch**, pick `gh-pages` and the `/ (root)` folder. That's the mechanism this whole approach leans on: GitHub redeploys the site every time that branch is pushed, and our CLI pushes it on every publish.

Finally, fill in your custom domain under those same Pages settings and tick "Enforce HTTPS" once the certificate is provisioned. GitHub handles the certificate automatically.

One thing to watch out for: without a custom domain, project sites are served from a subpath like `username.github.io/my-repo/`. Vite's asset URLs are absolute, so they break on a subpath. Use a custom domain, or name the repo `username.github.io` so it serves from the root. Both sidestep the problem entirely.

Note that GitHub Pages is free for public repos. Private repos need a paid plan.

### Wrapping Up

Static site generators solve a real problem, but they all charge the same tax: another tool, another set of docs, another "how did this work again" six months later. This approach charges nothing. One package, two composer scripts, and everything else was Laravel all along.

Full Laravel while writing, static HTML while serving, a hosting bill of exactly zero, and no rewrite waiting for you the day it needs a server.

Next time you reach for a static site generator (or worse, a VPS) for a five-page marketing site, don't. Type `composer publish` and go do something fun instead.

— Willem
