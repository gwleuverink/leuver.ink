<!-- __COMPONENT__ callouts.anonymous -->

@props([
    'title' => '',
    'description' => '',
    'buttons' => []
])

<div
    x-transition
    x-data="{ shown: false }"
    x-intersect.once="shown = true"
    :class="shown ? 'opacity-100' : 'opacity-0'"
    role="banner"
    {{ $attributes->class('
        transition-opacity duration-200 ease-in delay-100
        my-10 p-6 space-y-2 select-none rounded-2xl
        bg-white ring-1 ring-black/5 shadow-sm
        dark:bg-white/[0.04] dark:ring-white/10 dark:shadow-none
    ') }}
>
    <div class="flex items-center space-x-4">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $title }}</h3>
        <span class="space-x-2">
            @foreach($buttons as $text => $url)
            <a href="{{ $url }}" target="_blank" class="inline-flex items-center px-2 py-1 text-sm font-medium transition-colors rounded-md text-gray-700 bg-black/5 hover:bg-black/10 dark:text-slate-200 dark:bg-white/10 dark:hover:bg-white/[0.16] focus:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">
                {{ $text }}
            </a>
            @endforeach
        </span>
    </div>

    <div class="text-gray-700 dark:text-slate-300">
        {{ $description }}
    </div>

</div>
<!-- __ENDCOMPONENT__ callouts.anonymous -->
