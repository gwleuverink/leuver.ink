---
pagination:
  collection: posts
  perPage: 15
---

@extends('_layouts.main')

@section('content')

    @foreach ($pagination->items as $post)

        <x-article-excerpt :post="$post" :divider="! $loop->last" />

    @endforeach

@endsection
