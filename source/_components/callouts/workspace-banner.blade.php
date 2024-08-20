<!-- __COMPONENT__ callouts.workspace-banner -->

<div
    x-transitioninput
    x-data="{ shown: false }"
    x-intersect.once="shown = true"
    :class="shown ? 'opacity-100' : 'opacity-0'"
    role="banner"
    {{ $attributes->class('
        transition-opacity duration-200 ease-in delay-100
        flex flex-col sm:flex-row p-6 my-10 space-x-6 select-none rounded-2xl bg-blue-800
    ') }}
>

    <div class="flex justify-center flex-shrink-0 mt-2 mb-6 sm:mb-0">
        <img class="px-3 rounded-lg size-28 drop-shadow-xl bg-indigo-50" src="/assets/images/workspace-logo.svg" alt="Time Tracker logo">
    </div>

    <div>
        <h3 class="text-xl font-semibold text-white">Workspace for Laravel</h3>

        <div class="text-white">
            Sync linters, fixers, static analysis, CI workflows and editor integration configs across all your teams & projects
        </div>

        <a href="https://media-code.github.io/workspace/" target="_blank" class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Docs
        </a>

        <a href="https://github.com/media-code/workspace" target="_blank" class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            GitHub
        </a>
    </div>
</div>
<!-- __ENDCOMPONENT__ callouts.workspace-banner -->
