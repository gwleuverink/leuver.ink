---
pagination:
  collection: posts
  perPage: 5
---

@extends('_layouts.main')

@section('content')

    <div class="prose prose-xl">

        <p role="heading">
            I'm <a href="https://twitter.com/gwleuverink" target="_blank">Willem</a>, I work as a full-stack developer <a href="https://mediacode.nl" target="_blank">@mediacode</a>. Currently enamoured with <a href="https://laravel-livewire.com" target="_blank">Livewire</a>, <a href="https://www.alpinejs.dev" target="_blank">AlpineJS</a> & <a href="https://tailwindcss.com" target="_blank">Tailwind</a>. And let me be honest for a second, this thing has grown way past affection ❤️
        </p>

        <p>
            I'm just starting this blog fresh. Expect articles about the things I make, which are probably Livewire/Laravel related, but I might venture to write about other things too. Like home automation, arduino projects or small DIY things I tinker on.
        </p>

        <p>
            But hey, I might lose interest so no promises, let's see how it goes.
        </p>

    </div>

    {{-- START | RSS BANNER --}}
    <div class="relative mt-10 mb-12 prose prose-xl bg-zinc-100">
        <div class="px-6 py-6">
            <p>Below you'll find my latest writings. Check <a href="/blog">here</a> for the full archive, or subscribe to the <a href="/feed.atom">RSS feed</a></p>
        </div>

        <div class="absolute bottom-0 w-full h-2 bg-gradient-to-r from-purple-400 via-pink-500 to-red-500"></div>
    </div>
    {{-- END | RSS BANNER --}}

    @foreach ($pagination->items as $post)

        <x-article-excerpt :post="$post" :divider="! $loop->last" />

    @endforeach

    <x-time-tracker-banner class="mt-12" />
@endsection
