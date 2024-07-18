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

    <title>{{ $page->title }}</title>
    <meta name="description" content="{{ $page->description }}">

    <!-- og tags -->
    <meta property="og:title" content="{{ $page->title }}" />
    <meta property="og:description" content="{{ $page->description }}" />
    <meta property="og:image" content="{{ $page->baseUrl . $page->image }}" />
    <meta property="og:url" content="{{ $page->getUrl() }}" />


    <!-- Twitter card -->
    <meta name="twitter:card" content="summary">
    <meta name="twitter:creator" content="@gwleuverink">
    <meta name="twitter:title" content="{{ $page->title }}">
    <meta name="twitter:description" content="{{ $page->description }}">
    @if($page->image)
    <meta name="twitter:image" content="{{ $page->baseUrl . $page->image }}">
    @endif

    <link rel="manifest" href="/app.webmanifest">
    <link rel="canonical" href="{{ $page->getUrl() }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/assets/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/favicon/favicon-16x16.png">

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-3V846Y2C35"></script>
    <script>
        window.dataLayer = window.dataLayer || []; function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', 'G-3V846Y2C35');
    </script>

    <!-- CSS Bundle -->
    <link href="{{ mix('css/app.css', 'assets/build') }}" rel="stylesheet">
    <link href="{{ mix('css/font.css', 'assets/build') }}" rel="preload stylesheet" as="style" crossorigin="anonymous" />

    <!-- JS Bundle -->
    <script defer src="{{ mix('js/app.js', 'assets/build') }}"></script>

    <!-- Script stack -->
    @stack('scripts')
</head>

<body class="font-sans antialiased text-gray-900 transition-colors bg-white dark:text-gray-100 dark:bg-slate-900">

    <!-- WRAPPER -->
    <div class="max-w-xl mx-auto md:max-w-6xl">

        <header class="px-4 mt-8 mb-8 leading-tight md:mt-12 sm:mb-12 md:mb-16 md:px-8">

            <x-logo class="translate-x-0 lg:-translate-x-4 xl:-translate-x-24" />

            {{-- MOBILE NAV --}}
            <div x-data="{ open: false }" class="relative flex flex-col md:hidden">

                <button x-on:click="open = !open" class="absolute right-0 p-2 pb-1 font-bold tracking-wider text-white uppercase bg-gray-700 border-gray-900 -top-14 border-b-3" aria-label="Toggle menu">
                    Menu
                </button>

                <nav x-cloak
                    x-show="open"
                    x-transition
                    x-trap.inert.noscroll="open"
                    aria-modal="true"
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
    <!-- END WRAPPER -->

    @include('_partials.svg-definitions')
    @include('_partials.konami-code')

</body>

</html>
