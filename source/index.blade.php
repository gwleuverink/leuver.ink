---
title: Willem's blog
description: Join me on my coding journey. This is where I document my learnings through articles and showcase side projects. Come geek out with me!
pagination:
  collection: posts
  perPage: 3
---

@extends('_layouts.main')

@section('content')

<div class="prose prose-xl">

    <p role="heading" aria-level="2">
        I'm <a href="https://twitter.com/gwleuverink" target="_blank">Willem</a>, I work as a full-stack web developer <a href="https://mediacode.nl" target="_blank">@mediacode</a>. Currently enamoured with
        <a href="https://laravel.com" target="_blank">Laravel</a>, <a href="https://laravel-livewire.com" target="_blank">Livewire</a>, <a href="https://www.alpinejs.dev" target="_blank">AlpineJS</a> & <a href="https://tailwindcss.com" target="_blank">Tailwind</a>.
        And let me be honest for a second, this thing has grown way past affection <x-svg.heart class="inline w-6 h-6 ml-1" />
    </p>

    <p>
        So heck, you've found yourself here. Here's what you can expect: Some programming related <a href="{{ $page->baseUrl }}blog">articles</a>, Some highlighted <a href="{{ $page->baseUrl }}software">side projects</a> I work on. And how to <a href="{{ $page->baseUrl }}software/time-tracker-for-clickup">get in touch</a>.
    </p>

    <p>
        It's a bit empty here now but I have a lot of articles in the queue. Check back soon!
    </p>

</div>

{{-- START | RSS BANNER --}}
<x-highlight-banner>
    <p>Below you'll find my latest writings. Check <a href="/blog">here</a> for the full archive, or subscribe to the <a href="/feed.atom">RSS feed</a></p>
</x-highlight-banner>
{{-- END | RSS BANNER --}}

@foreach ($pagination->items as $post)

<x-article-excerpt :post="$post" :divider="! $loop->last" />

@endforeach

<div class="flex justify-center my-8">
    <a href="/blog" class="flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        Check the full archive of articles
    </a>
</div>

<x-callouts.time-tracker-banner class="mt-12" />

@endsection
