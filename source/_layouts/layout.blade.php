<!DOCTYPE html>

<html lang="{{ $page->language ?? 'en' }}">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ $page->description }}">

    <title>{{ $page->title }}</title>
    <link rel="canonical" href="{{ $page->getUrl() }}">

    <!-- CSS Bundle -->
    <link href="{{ mix('css/app.css', 'assets/build') }}" rel="stylesheet">
    <link href="{{ mix('css/font.css', 'assets/build') }}" rel="preload stylesheet" as="style" crossorigin="anonymous" />

    <!-- Alpine JS -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>



</head>
<body x-init="$el.classList.remove('opacity-0')" class="font-sans text-gray-900 antialiased transition-opacity duration-300 opacity-0">

    {{-- WRAPPER --}}
    <div class="max-w-xl md:max-w-5xl mx-auto">

        <header class="mt-8 md:mt-12 mb-8 sm:mb-12 md:mb-16 px-4 md:px-8 bg-white leading-tight">

            <x-logo />

            {{-- MOBILE NAV --}}
            <div x-data="{ open: false }"
                x-effect="open
                    ? document.body.classList.add('overflow-hidden')
                    : document.body.classList.remove('overflow-hidden')"
                class="md:hidden relative flex flex-col"
            >

                <button x-on:click="open = !open" class="absolute right-0 -top-12 bg-gray-700 border-b-3 border-gray-900 text-white uppercase tracking-wider font-bold p-2 pb-1">
                    Menu
                </button>

                <nav x-show="open" x-cloak x-transition class="flex flex-col justify-center min-h-screen text-3xl text-center text-gray-00 -mt-20 px-8 pt-10 pb-2">

                    @include('_partials.nav-links')

                </nav>

            </div>
            {{-- END MOBILE NAV --}}

        </header>

        <div class="md:flex pb-12 text-xl">

            {{-- DESKTOP NAV --}}
            <aside class="hidden md:block w-1/4 lg:w-1/5 text-right leading-loose">

                <nav class="flex flex-col sticky top-4 border-r border-gray-200 text-gray-700 px-8 py-2 mb-16">

                    @include('_partials.nav-links')

                </nav>

            </aside>
            {{-- END DESKTOP NAV --}}

            <main  role="main" class="flex-1 min-w-0 px-4 md:px-12 lg:pl-24 lg:pr-16">

                @yield('content')

            </main>

        </div>

    </div>
    {{-- END WRAPPER --}}

    @include('_partials.svg-definitions')

</body>
</html>
