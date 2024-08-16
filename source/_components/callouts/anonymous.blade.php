<!-- __COMPONENT__ callouts.anonymous -->

@props([
    'title' => '',
    'description' => '',
    'buttons' => []
])

<div
    x-data="{ shown: false }"
    x-intersect.once="shown = true"
    :class="shown ? 'opacity-100' : 'opacity-0'"
    role="banner"
    {{ $attributes->class('
        transition-opacity duration-200 ease-in delay-100
        my-10 p-6 space-y-2 select-none rounded-2xl bg-indigo-900
    ') }}
>
    <div class="flex items-center space-x-4">
        <h3 class="text-xl font-semibold text-white">{{ $title }}</h3>
        <span>
            @foreach($buttons as $text => $url)
            <a href="{{ $url }}" target="_blank" class="inline-flex items-center px-2 py-1 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                {{ $text }}
            </a>
            @endforeach
        </span>
    </div>

    <div class="text-white">
        {{ $description }}
    </div>

</div>
<!-- __ENDCOMPONENT__ callouts.anonymous -->
