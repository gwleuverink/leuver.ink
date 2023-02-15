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

    @include('_partials.pagination-links', [
        'paginator' => $pagination
    ])
@endsection
