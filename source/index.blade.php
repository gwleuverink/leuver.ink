---
pagination:
  collection: posts
  perPage: 5
---

@extends('_layouts.main')

@section('content')

    <div class="prose prose-xl">

        <p role="heading">Since you got this far, I might as well bore you with quick summary of what I do.</p>

        <p>
            I'm <a href="https://twitter.com/gwleuverink" target="_blank">@gwleuverink</a>, a full-stack developer. Currently enamoured with <a href="https://laravel-livewire.com" target="_blank">Livewire</a>, <a href="https://www.alpinejs.dev" target="_blank">AlpineJS</a> & <a href="https://tailwindcss.com" target="_blank">Tailwind</a>. And let me be honest for a second, this thing has grown way past affection ❤️
        </p>

        <p>
            I write about the things I make, which are usually Livewire/Laravel related, but I might venture to write about other things too. Like home automation, arduino projects or small woodworking things I tinker on.
        </p>

    </div>

    <div class="relative mt-10 mb-12 bg-gray-100 prose prose-xl">
        <div class="px-6 py-6">
            <p>Below you'll find my latest writings. Check <a href="#">here</a> for the full archive, or subscribe to the <a href="#">RSS feed</a></p>
        </div>

        <div class="absolute bottom-0 h-2 w-full bg-gradient-to-r from-purple-400 via-pink-500 to-red-500"></div>
    </div>

    @foreach ($pagination->items as $post)

        <x-article-excerpt :post="$post" :divider="! $loop->last" />

    @endforeach

@endsection
