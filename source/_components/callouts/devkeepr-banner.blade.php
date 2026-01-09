<!-- __COMPONENT__ callouts.devkeepr-banner -->

<div
    x-transition
    x-data="{ shown: false }"
    x-intersect.once="shown = true"
    :class="shown ? 'opacity-100' : 'opacity-0'"
    role="banner"
    {{ $attributes->class('
        transition-opacity duration-200 ease-in delay-100
        p-6 my-10 space-x-6 select-none rounded-2xl bg-gradient-to-b from-sky-500 to-blue-700
    ') }}
>

    <div class="flex items-center flex-shrink-0 mb-6 sm:mb-0">
        <img class="h-28 drop-shadow-xl" src="/assets/images/devkeepr-logo.png" alt="Devkeepr logo">
        <h3 class="ml-2.5 text-6xl tracking-tighter font-semibold text-white">Devkeepr</h3>
    </div>


    <div class="mt-2 mb-1 text-white">
        Your local environment supercharged. Run project scripts, monitor workflows, and intelligently manage disk space through smart hibernation
    </div>

    <div>
        <a href="https://devkeepr.app" target="_blank" class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Join Early Access!
        </a>

        {{-- <a href="https://github.com/devkeepr/releases" target="_blank" class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
            Download
        </a> --}}
    </div>

</div>
<!-- __ENDCOMPONENT__ callouts.devkeepr-banner -->
