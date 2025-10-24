---
title: Latest writings
pagination:
    collection: posts
    perPage: 6
---

@extends('_layouts.main')

@section('content')

    @foreach ($pagination->items as $post)

        <x-article-excerpt :post="$post" :divider="!$loop->last" />

    @endforeach


    @if($pagination->currentPage === $pagination->totalPages)

        <x-highlight-banner>
            <p>You've reached the end. I've got a lot more TALL stack & Laravel related articles in the queue. Subscribe to <a href="/feed.atom">the feed</a> to get notified.</p>

        </x-highlight-banner>

    @endif


    @include('_partials.pagination-links', [
        'paginator' => $pagination
    ])

    <x-callouts.time-tracker-banner class="mt-12" />

@endsection
