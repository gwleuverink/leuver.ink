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
        I'm <a href="https://twitter.com/gwleuverink" target="_blank">Willem</a>, freelance engineer at <a href="https://trailheadlabs.co" target="_blank">Trailhead Labs</a> and <a href="https://nativephp.com" target="_blank">NativePHP</a> Desktop team.
        Hand me a messy problem and I'll turn it into something that ships, works, and holds up. On the web, or off it.
    </p>

    <p>
        If the years have taught me one thing, it's that the best software gets built shoulder to shoulder <x-svg.heart class="inline w-6 h-6 ml-1 mr-1.5" />
        Bring me in as a partner, not a pair of hands, and you get someone who owns the outcome as much as you do.
    </p>

    <p>
        When I'm not building for clients, I'm shipping <a href="{{ $page->baseUrl }}software">products of my own</a>. Around here you'll also find my <a href="{{ $page->baseUrl }}blog">writing</a> and how to <a href="{{ $page->baseUrl }}about">get in touch</a>.
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

<x-callouts.devkeepr-banner class="mt-12" />

@endsection
