<!-- __COMPONENT__ callouts.workspace-banner -->

<div
    x-data="{ shown: false }"
    x-intersect.once="shown = true"
    :class="shown ? 'opacity-100' : 'opacity-0'"
    role="bundle-banner"
    {{ $attributes->class('
        transition-opacity duration-200 ease-in delay-100
        p-6 space-x-6 select-none rounded-2xl bg-indigo-900
    ') }}
>
    <img class="mx-4 mt-2 mb-5 drop-shadow-xl" src="/assets/images/bundle-logo.svg" alt="Laravel Bundle">

    <h3 class="text-xl font-semibold text-white sr-only">Laravel Bundle</h3>

    <div class="text-white">
        Laravel Blade with JavaScript Superpowers! 🚀 Effortless page specific JavaScript modules in Laravel/Livewire apps.
    </div>

    <div>
        <a href="https://laravel-bundle.dev" target="_blank" class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Docs
        </a>

        <a href="https://github.com/gwleuverink/bundle" target="_blank" class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Github
        </a>
    </div>

</div>
<!-- __ENDCOMPONENT__ callouts.workspace-banner -->
