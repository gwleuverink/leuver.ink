
@extends('_layouts.layout')


@section('content')
    <x-article-excerpt />

    <!-- SEPARATOR -->
    <div class="flex justify-center md:justify-start my-10">
        <x-svg.slash-wave class="h-4 " />
    </div>
    <!-- END SEPARATOR -->

    <x-article-excerpt />
@endsection
