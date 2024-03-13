---
extends: _layouts.blog
section: article
tags: [Tailwind, Laravel]
published: true

title: Debugging Tailwind CSS Breakpoints
date: 2024-01-13
readTime: 2 minute read
---

When working with Tailwind CSS, it's essential to ensure that your responsive styles are applied correctly across different screen sizes. However, debugging responsive styles can be a challenge, especially when you're unsure which breakpoint is currently active. Fortunately, there is a way to display the current breakpoint on the page, making it easier to identify and debug issues related to responsive styles.

<p>
    I use a Blade component for this, which I copy paste over to pretty much any new project. You can see it in action below
    <x-svg.wiggly-downward-arrow class="inline w-5 ml-1" viewBox="0 160 33.68 60" />
</p>

<!-- START | Example -->
<div class="flex items-center justify-center w-8 h-8 p-6 m-2 font-bold bg-white border border-slate-800 text-slate-800">
    <div class="xs:block sm:hidden">XS</div>
    <div class="hidden sm:block md:hidden">SM</div>
    <div class="hidden md:block lg:hidden">MD</div>
    <div class="hidden lg:block xl:hidden">LG</div>
    <div class="hidden xl:block 2xl:hidden">XL</div>
    <div class="hidden 2xl:block">2XL</div>
</div>
<!-- END | Example -->

Resize the page and see what happens! Pretty darn convenient right?

Below you'll find the code that the current breakpoint in the bottom-right corner of your page. This information can be invaluable when you're trying to identify which breakpoint is active and troubleshoot issues related to responsive styles.
I recommend plopping it in an [anonymous Blade component](https://laravel.com/docs/10.x/blade#anonymous-components) so it is easier to share between projects.

```blade
@@env('local')
    <div class="fixed bottom-0 right-0 flex items-center justify-center m-2 w-8 h-8 p-6 bg-white border border-slate-800 z-[9999999999] text-slate-800 font-bold">
        <div class="xs:block sm:hidden">
            XS
        </div>

        <div class="hidden sm:block md:hidden">
            SM
        </div>

        <div class="hidden md:block lg:hidden">
            MD
        </div>

        <div class="hidden lg:block xl:hidden">
            LG
        </div>

        <div class="hidden xl:block 2xl:hidden">
            XL
        </div>

        <div class="hidden 2xl:block">
            2XL
        </div>
    </div>
@@endenv
```
