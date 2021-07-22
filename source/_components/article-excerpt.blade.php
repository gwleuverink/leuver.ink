@props([
    'post' => new \Illuminate\Support\Fluent,
    'divider' => false
])

<article {{ $attributes }}
    x-data="{ shown: false }"
    x-intersect.once="shown = true"
    :class="shown ? 'opacity-100' : 'opacity-0'"
    class="transition-opacity duration-300 delay-300 ease-in"
>

    <header class="mb-6">
        <a href="{{ $post->getUrl() }}">

            <h2 class="max-w-lg text-2xl md:text-3xl font-bold leading-tight mb-1">
                {{ $post->title }}
            </h2>

            <p class="text-lg text-gray-700">
                <time datetime="2021-06-14T17:36:12+02:00">{{ date('F j, Y', $post->date) }}</time> – 3 minute read
            </p>

        </a>
    </header>

    <div class="prose prose-xl leading-relaxed">

        <p>
            {{ \Illuminate\Support\Str::limit($post->excerpt, 100, '...') }}
        </p>

        <a href="{{ $post->getUrl() }}" class="mt-6">
            Read more
        </a>

    </div>

    @if($divider) <x-separator /> @endif

</article>
