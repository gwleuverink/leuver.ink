@extends('_layouts.main')

@section('content')

<div class="hidden w-full h-2 mb-6 -mt-10 md:block bg-gradient-to-r from-purple-400 via-pink-500 to-red-500"></div>


<header class="mb-6">

    <h2 class="mb-1 text-2xl font-bold leading-tight text-gray-700 md:text-3xl dark:text-slate-300">
        {{ $page->title }}
    </h2>

    <div class="flex items-center justify-between text-lg text-gray-700 dark:text-slate-300">
        <p>
            <time datetime="{{ date('Y-m-d\TH:i:s') }}">{{ date('F j, Y', $page->date) }}</time> – {{ $page->readTime }}
        </p>

        <a href="{{ $page->getUrl() }}.md" target="_blank" class="px-1.5 py-0.5 text-xs font-mono rounded-sm text-gray-500 dark:text-slate-400 hover:text-purple-500 hover:bg-black/5 dark:hover:bg-white/5 transition-colors">
            [ .md ]
        </a>
    </div>

</header>

<article class="prose prose-xl prose-pre:bg-transparent">
    @yield('article')
</article>
@endsection
