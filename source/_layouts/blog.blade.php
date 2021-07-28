@extends('_layouts.main')

@push('scripts')
<script defer src="https://unpkg.com/shiki@0.9.5/dist/index.unpkg.iife.js"></script>
@endpush

@section('content')
{{--
<div class="h-2 mb-6 w-full bg-gradient-to-r from-purple-400 via-pink-500 to-red-500"></div>
--}}

<header class="mb-6">

    <h2 class="max-w-lg text-2xl md:text-3xl font-bold leading-tight mb-1">
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
