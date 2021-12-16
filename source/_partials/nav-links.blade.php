<a href="{{ $page->baseUrl }}" class="{{ $page->selected('/') }}">
    Home
</a>

<a href="{{ $page->baseUrl }}blog" class="{{ $page->selected('blog') }}">
    Writings
</a>

<a href="{{ $page->baseUrl }}about" class="mt-4 {{ $page->selected('about') }}">
    About
</a>

<a href="{{ $page->baseUrl }}using" class="{{ $page->selected('using') }}">
    Using
</a>
