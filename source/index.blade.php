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

    {{-- <p>
        I've been utilizing these technologies for the past year and the results have been outstanding. I've become more productive and efficient in my development work, thanks to the seamless and lightning-fast interactions these technologies enable.
    </p> --}}

    <p>
        This blog is not just limited to my work as a developer. I have a diverse range of interests and I plan to venture out and share my thoughts and experiences. Whether it's building a bookshelf from scratch or exploring the great outdoors, I believe that we can all learn and grow from each other's experiences.
    </p>

    <p>
        So, join me on this journey as I share my experiences and insights on everything from web development to DIY projects, nature and beyond. I hope that this blog will serve as a source of inspiration and a place for us to connect and learn from one another.
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
