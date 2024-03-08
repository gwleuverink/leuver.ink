<!DOCTYPE html>

<html
    x-data
    x-effect="$el.classList.toggle('dark', $store.darkMode.enabled)"
    lang="{{ $page->language ?? 'en' }}"
>

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="{{ $page->description }}">

    <title>{{ $page->title }}</title>
    <link rel="manifest" href="/app.webmanifest">
    <link rel="canonical" href="{{ $page->getUrl() }}">

    <!-- CSS Bundle -->
    <link href="{{ mix('css/app.css', 'assets/build') }}" rel="stylesheet">
    <link href="{{ mix('css/font.css', 'assets/build') }}" rel="preload stylesheet" as="style" crossorigin="anonymous" />

    <!-- JS Bundle -->
    <script defer src="{{ mix('js/app.js', 'assets/build') }}"></script>

    <!-- Script stack -->
    @stack('scripts')
</head>

<body class="font-sans antialiased text-gray-900 transition-colors bg-white dark:text-gray-100 dark:bg-slate-900">

    {{-- WRAPPER --}}
    <div class="max-w-xl mx-auto md:max-w-6xl">

        <header class="px-4 mt-8 mb-8 leading-tight md:mt-12 sm:mb-12 md:mb-16 md:px-8">

            <x-logo class="translate-x-0 lg:-translate-x-4 xl:-translate-x-24" />

            {{-- MOBILE NAV --}}
            <div x-data="{ open: false }"
                aria-modal="true"
                role="mobile-nav"
                class="relative flex flex-col md:hidden">

                <button x-on:click="open = !open" class="absolute right-0 p-2 pb-1 font-bold tracking-wider text-white uppercase bg-gray-700 border-gray-900 -top-14 border-b-3" aria-label="Toggle menu">
                    Menu
                </button>

                <nav x-cloak
                    x-show="open"
                    x-transition
                    x-trap.inert.noscroll="open"
                    class="flex flex-col justify-center min-h-screen px-8 pt-10 pb-2 -mt-20 text-3xl text-center select-none">

                    @include('_partials.nav-links')

                </nav>

            </div>
            {{-- END MOBILE NAV --}}

        </header>

        <div class="pb-12 text-xl translate-x-0 md:flex md:-translate-x-14 lg:-translate-x-20 xl:-translate-x-24">

            {{-- DESKTOP NAV --}}
            <aside class="hidden w-1/4 leading-loose text-right md:block lg:w-1/5">

                <nav class="sticky flex flex-col px-8 py-2 mb-16 text-gray-700 border-r border-gray-200 select-none dark:text-slate-300 top-4">

                    @include('_partials.nav-links')

                </nav>

            </aside>
            {{-- END DESKTOP NAV --}}

            <main role="main"
                x-data="{ show: false }"
                x-show="show"
                x-init="() => $nextTick(() => show = true)"
                x-transition.opacity.0.duration.500ms
                class="flex-1 min-w-0 px-4 md:px-12 lg:pl-24 lg:pr-16">

                @yield('content')

            </main>

        </div>

    </div>
    {{-- END WRAPPER --}}


    @include('_partials.svg-definitions')
    @include('_partials.konami-code')

</body>

</html>
