@extends('_layouts.main')

@section('content')
{{--
<div class="w-full h-2 mb-6 bg-gradient-to-r from-purple-400 via-pink-500 to-red-500"></div>
--}}

<header class="mb-6">

    <h2 class="max-w-lg mb-1 text-2xl font-bold leading-tight text-gray-700 md:text-3xl dark:text-slate-300">
        {{ $page->title }}
    </h2>

    <p class="text-lg text-gray-700">
        <time datetime="{{ date('Y-m-d\TH:i:s') }}">{{ date('F j, Y', $page->date) }}</time> – {{ $page->readTime }}
    </p>

</header>

<article class="prose-xl">
    @yield('article')
</article>
@endsection
