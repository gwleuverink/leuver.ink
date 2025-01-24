<!-- __COMPONENT__ callouts.phost-banner -->

<div
    x-transition
    x-data="{ shown: false }"
    x-intersect.once="shown = true"
    :class="shown ? 'opacity-100' : 'opacity-0'"
    role="banner"
    {{ $attributes->class('
        transition-opacity duration-200 ease-in delay-100
        flex flex-col sm:flex-row p-6 my-10 space-x-6 select-none rounded-2xl bg-gradient-to-b from-indigo-600 to-indigo-800
    ') }}
>

    <div class="flex justify-center flex-shrink-0 mb-6 sm:mb-0">
        <img class="h-28 drop-shadow-xl" src="/assets/images/relay-logo.png" alt="Relay logo">
    </div>

    <div>
        <h3 class="text-xl font-semibold text-white">Relay</h3>

        <div class="text-white">
            Monitor and manage your team's GitHub Workflow runs from your Mac menubar
        </div>

        <a href="https://github.com/gwleuverink/relay/releases/latest" target="_blank" class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Download now
        </a>

        <a href="https://github.com/gwleuverink/relay" target="_blank" class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-blue-500 border border-transparent rounded-md shadow-sm hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            GitHub
        </a>
    </div>
</div>
<!-- __ENDCOMPONENT__ callouts.phost-banner -->
