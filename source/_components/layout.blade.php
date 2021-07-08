<!DOCTYPE html>

<html lang="en">
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

    <!-- SVG Definitions -->

</head>
<body x-init="$el.classList.remove('opacity-0')" class="font-sans text-gray-900 antialiased transition-opacity duration-300 opacity-0"> <!-- opacity-0 -->

    {{-- WRAPPER --}}
    <div class="max-w-xl md:max-w-5xl mx-auto">

        <header class="mt-8 md:mt-12 mb-8 sm:mb-12 md:mb-16 px-4 md:px-8 bg-white leading-tight">

            <div x-data="{ loaded: false }" x-init="$nextTick(() => loaded = true)" role="banner" class="flex space-x-4 overflow-hidden">

                <span class="w-16">
                    <svg x-show="loaded"
                        x-transition:enter="transition ease-out duration-500"
                        x-transition:enter-start="opacity-0 transform-gpu scale-90 translate-y-16"
                        x-transition:enter-end="opacity-100 transform-gpu scale-100 translate-y-0"
                        x-transition:leave="transition ease-in duration-500"
                        x-transition:leave-start="opacity-100 transform-gpu scale-100 translate-y-0"
                        x-transition:leave-end="opacity-0 transform-gpu scale-90 translate-y-16"
                        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 75.57 68.28" class="w-full text-pink-600"
                    >
                        <defs>
                            <linearGradient x1="50%" y1="92.034%" x2="50%" y2="7.2%" id="retro-gradient">
                            <stop offset="0%" stop-color="purple" />
                            <stop offset="100%" stop-color="currentColor" />
                            </linearGradient>
                        </defs>

                        <path fill="currentColor" style="fill: url(#retro-gradient)" fill-opacity=".8" d="M35.14 68.18C24 67.53 13 62.1 6.3 53a455.08 455.08 0 0167.09-7.3C67.51 60.72 50.8 69.34 35.14 68.18zM2.69 46.85a31 31 0 01-1.45-3.94c12.93-1.7 25.93-2.83 38.93-3.87 11.74-.61 23.48-1.34 35.24-1.25-.14 1-.26 2.08-.5 3.09-11.2.42-22.34 1.56-33.5 2.52-12.57 1.71-25.17 3.18-37.6 5.73-.41-.74-.81-1.51-1.12-2.28zM.51 39.69a26.42 26.42 0 01-.47-7c25-3.08 50.2-3.25 75.31-2.6.22.65 0 1.45.22 2V34A594.93 594.93 0 00.65 40.5c-.05-.27-.09-.5-.14-.81zm-.3-9.33a31.39 31.39 0 012-7.65c23.05-1.9 46.12-3.63 69.25-4.23a30.58 30.58 0 013.47 8.91c-24.95-.26-50 .35-74.75 3.84.03-.23-.07-.58.03-.87zm2.37-8.64C8.21 8.53 22.39.44 36.39 0c13.35-.45 27.17 5.8 34.33 17.32-22.79.75-45.52 2.59-68.23 4.58z"/>
                    </svg>
                </span>

                <div>
                    <h1 x-show="loaded" x-transition.delay.400ms class="text-3xl font-semibold text-purple-800">Hi, I’m Willem</h1>
                    <h2 x-show="loaded" x-transition.delay.550ms class="text-xl">and i make things</h2>
                </div>
            </div>


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

                {{ $slot }}

            </main>

        </div>

    </div>
    {{-- END WRAPPER --}}

</body>
</html>
