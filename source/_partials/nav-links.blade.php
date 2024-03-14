<!-- __PARTIAL__ nav-links -->
<a
    x-on:click.prevent="
        // Click on the logo instead (so animation triggers)
        Array.from(document.getElementsByClassName('logo')).every(el => {
            el.click()
            return false
        })
    "
    href="{{ $page->baseUrl }}"
    class="{{ $page->selected('/') }}">
    Home
</a>

<a href="{{ $page->baseUrl }}blog" class="{{ $page->selected('blog') }}">
    Writings
</a>

<a href="{{ $page->baseUrl }}software" class="{{ $page->selected('software') }}">
    Software
</a>

<a href="{{ $page->baseUrl }}about" class="mt-4 {{ $page->selected('about') }}">
    About
</a>


<div class="mt-8">
    <x-darkmode-toggle />
</div>
<!-- __ENDPARTIAL__ nav-links -->
