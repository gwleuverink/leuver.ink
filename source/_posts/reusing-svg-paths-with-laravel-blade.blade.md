---
extends: _layouts.blog
section: article
tags: [Laravel, Blade, Performance]
published: true

title: Reusing svg paths with Laravel Blade
date: 2023-08-04
readTime: 10 minute read
---

As a webdeveloper I use SVG icons quite often.
In the server-side rendered world I inhabit it is common practice to extract these icons into their own components or use the excellent [Blade icons](https://blade-ui-kit.com/blade-icons) package. Simply slap the SVG markup it on the page and call it a day.

In 99% of cases this works perfectly fine. But imagine if you will, You are using 3 different SVG icons on a table which has 100 rows. This results in 300 inlined SVG's on the page (with probably multiple xml nodes each).

As you might imagine, this can result in large page responses due to all the duplicated markup that comes with the request. Not even speaking about the impact it can have when using a [DOM diffing algorithm](https://livewire.laravel.com/docs/morphing#how-morphing-works) like Livewire & AlpineJS do under the hood.

Therein lies a huge opportunity to reduce request sizes and squeeze more performance out of your page.

<!-- ### Measuring performance impact

For example; Measured on a Macbook Pro (Apple M2 Max) Using _3000_ svg's containing only _3_ path nodes each we see browser timings increase dramatically.

|              | With svg definitions | Without svg definitions |
| ------------ | -------------------- | ----------------------- |
| Blade render | **40ms**             | **10ms**                |
| DOM morphing | **734ms**            | **43ms**                |
| Memory usage | **1.4mb**            | **0.3mb**               |

Heck that makes quite a big difference! Free performance? I'm all about that shit. Let's dive right in. -->

### The `<use>` element

To solve this problem we can utilize the lesser known SVG `<use>` element. Using this element we can easily define a SVG path **once** and reuse it anywhere we want. It just needs a little bit of set-up which I will talk you through here.

<p>
    In fact, I use this strategy for every SVG on this site. If you inspect this heart shaped SVG <x-svg.heart class="inline w-5 h-5 mx-1"/> you'll see the following markup being rendered on the page:
</p>

```html
<svg
  class="w-5 h-5"
  xmlns="http://www.w3.org/2000/svg"
  viewBox="0 0 55.19 42.73"
>
  <use xlink:href="#heart"></use>
</svg>
```

The `<use>` element within the SVG only references a path definition that was registered elswhere somewhere near the body's closing tag.

```html
<svg class="absolute top-0 -left-96 z-[-999]">
  <defs>
    <path
      id="heart"
      fill="currentColor"
      style="fill: url(#retro-gradient)"
      fill-opacity=".8"
      d="M31.34,9.1C12.74-16.08-29.6,21.81,33,42.6a1.77,1.77,0,0,0,2.29-.93A2.29,2.29,0,0,0,35,40.22c4.72-.09,17.11-19.13,19.16-23.8C59.88-3.24,39.68-4.69,31.34,9.1Zm20.08,3.63c-3,9.78-11.05,17.12-16.91,25.29a1.53,1.53,0,0,0-.28,1.29c-1.62-1.21-4.69-1.57-6.14-2.67-9-3.58-18.06-8.45-23.14-17C-2.38,4.12,25.25-.61,29.45,12.55c-3.06,5.94,2.52,7.94,2.28,4.21a4.3,4.3,0,0,0,1.45-4.28C37.75,3.67,52.82-2.28,51.42,12.73Z"
    ></path>
  </defs>
</svg>
```

To make this work you need to define the path with a unique `id` and reference that `id` in the `xlink:href` attribute on the SVG itself.

Using this you can get very creative. Have multiple SVG's with different viewboxes that reference the same definition, or mix definitions together. But that's beside the point. We're here for performance optimizations! Read along for a step by step.

### Integrating with Blade

This is very cool and all, but a big hastle to manage. Naturally we don't want to define _all_ our SVG paths here, even when we don't need them.
So, how do we make this convenient so we don't even have to think about it?

Using Laravel blade's `@@stack` & `@@push` directives this is a fairly simple process. Firstly we need to create a component or partial that holds our definitions.

```blade
<!-- resources/views/components/svg/definitions.blade.php -->
<svg class="absolute top-0 -left-96 z-[-999]">
    @@stack('svg-definitions')
</svg>
```

And slap this component somewhere before the page's closing body tag.

```blade
<body>
    <!-- // -->

    {!! '<' !!}x-svg.definitions{!! ' />' !!}
</body>
```

Now, once we've got this scaffolding set up it's time to prepare your SVG's. This is a bit tedious, but you'll only have to set it up once for every SVG.

Though this approach bears more fruit with bigger svg's with lots of paths, lets use something simple as an example. Like Heroicon's [smile outline icon](https://github.com/tailwindlabs/heroicons/blob/master/src/24/outline/face-smile.svg).

<ol>
    <li>Create a new anonymous component</li>
    <li>Wrap our SVG content inside a `@@pushOnce` directive</li>
    <li>Forward all attributes on the wrapping `svg` element</li>
</ol>

```blade
<!-- Heroicons outline face-smile -->
<!-- resources/components/svg/heroicon-o-face-smile.blade.php -->
<svg
    @{{ $attributes }}
    xmlns="http://www.w3.org/2000/svg"
    fill="none"
    viewBox="0 0 24 24"
    stroke-width="1.5"
    stroke="currentColor"
>

    @@pushOnce('svg-definitions')
        <path id="heroicon-o-face-smile" stroke-linecap="round" stroke-linejoin="round" d="M15.182 15.182a4.5 4.5 0 01-6.364 0M21 12a9 9 0 11-18 0 9 9 0 0118 0zM9.75 9.75c0 .414-.168.75-.375.75S9 10.164 9 9.75 9.168 9 9.375 9s.375.336.375.75zm-.375 0h.008v.015h-.008V9.75zm5.625 0c0 .414-.168.75-.375.75s-.375-.336-.375-.75.168-.75.375-.75.375.336.375.75zm-.375 0h.008v.015h-.008V9.75z" />
    @@endpushOnce

    <use xlink:href="#heroicon-o-face-smile" />

</svg>
```

Afterwards you can simply use the component as many times you'd like. The svg markup will only be rendered on the page once and reused everywhere.

@php $component = '<x-svg.heroicon-o-face-smile class="w-6 h-6" />' @endphp

```blade
{!! $component !!}
```
