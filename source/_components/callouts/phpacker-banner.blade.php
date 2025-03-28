<!-- __COMPONENT__ callouts.phpacker-banner -->

<div
    x-transition
    x-data="{ shown: false }"
    x-intersect.once="shown = true"
    :class="shown ? 'opacity-100' : 'opacity-0'"
    role="banner"
    {{ $attributes->class('
        transition-opacity duration-200 ease-in delay-100
        p-6 my-10 space-x-6 select-none rounded-2xl bg-[#FFD5B4]
    ') }}
>
    <img class="mx-4 mt-2 mb-5 max-w-[540px]" src="/assets/images/phpacker-logo.jpg" alt="PHPacker">

    <h3 class="text-xl font-semibold text-white sr-only">PHPacker</h3>

    <div class="text-slate-900">
        Package any PHP script or PHAR into a self-contained, cross-platform executable. Build once, run anywhere 📦
    </div>

    <div>
        <a href="https://phpacker.dev" target="_blank" class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-[#E44C64] border border-transparent rounded-md shadow-sm hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#E44C64]">
            Docs
        </a>

        <a href="https://github.com/phpacker/phpacker" target="_blank" class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-[#E44C64] border border-transparent rounded-md shadow-sm hover:bg-rose-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#E44C64]">
            Github
        </a>
    </div>

</div>
<!-- __ENDCOMPONENT__ callouts.phpacker-banner -->
