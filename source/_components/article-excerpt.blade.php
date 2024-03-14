<!-- __COMPONENT__ layout.article-excerpt -->
@props([
    'post' => new \Illuminate\Support\Fluent,
    'divider' => false
])

<article {{ $attributes }}
    x-data="{ shown: false }"
    x-intersect.once="shown = true"
    :class="shown ? 'opacity-100' : 'opacity-0'"
    class="transition-opacity duration-300 ease-in delay-300"
    role="article"
>

    <header class="mb-6">
        <a href="{{ $post->getUrl() }}">

            <h2 class="mb-1 text-2xl font-semibold leading-tight text-gray-700 dark:text-slate-300 md:text-3xl">
                {{ $post->title }}
            </h2>

            <p class="text-lg text-gray-700 dark:text-slate-300">
                <time datetime="{{ date('Y-m-d\TH:i:s') }}">{{ date('F j, Y', $post->date) }}</time> – {{ $post->readTime }}
            </p>

            @if($post->tags)
                <div class="space-x-1">
                    @foreach ($post->tags as $tag)
                        <x-tag>{{ $tag }}</x-tag>
                    @endforeach
                </div>
            @endif

        </a>
    </header>

    <div class="leading-relaxed prose prose-xl prose-pre:bg-transparent">

        <p>
            {{ $post->getExcerpt() }}
        </p>

        <a href="{{ $post->getUrl() }}" class="mt-6" aria-label="Read the full article">
            Read more
        </a>

    </div>

    @if($divider) <x-separator /> @endif

</article>
<!-- __ENDCOMPONENT__ layout.article-excerpt -->
