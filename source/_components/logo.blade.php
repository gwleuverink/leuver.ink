<div x-data="{ loaded: false }" x-init="$nextTick(() => loaded = true)" role="banner" class="flex space-x-4 overflow-hidden">

    <span class="w-16 min-h-[64px]">
        <x-svg.retro-sun x-show="loaded"
            x-transition:enter="transition ease-out duration-700"
            x-transition:enter-start="opacity-0 transform-gpu scale-90 translate-y-16"
            x-transition:enter-end="opacity-100 transform-gpu scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-700"
            x-transition:leave-start="opacity-100 transform-gpu scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 transform-gpu scale-90 translate-y-16"
            class="w-full" />
    </span>

    <div>
        <h1 x-show="loaded" x-transition.delay.450ms class="text-3xl font-semibold text-purple-800">Hi, I’m Willem</h1>
        <h2 x-show="loaded" x-transition.delay.600ms class="text-xl">and i make things</h2>
    </div>
</div>
