<div
x-data="{ shown: false }"
x-intersect.once="shown = true"
:class="shown ? 'opacity-100' : 'opacity-0'"
role="time-tracker-banner"
{{ $attributes->class('
    transition-opacity duration-200 ease-in delay-100
    flex flex-col sm:flex-row p-6 my-10 space-x-6 select-none rounded-2xl bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500
') }}
>

    <div class="flex justify-center">
        <img class="h-28 drop-shadow-xl" src="/assets/images/clickup-time-tracker-logo.png" alt="Time Tracker logo">
    </div>

    <div>
        <h3 class="text-xl font-semibold text-white">Time Tracker for ClickUp</h3>

        <div class="text-white">
            Frictionless real-time tracking for ClickUp
        </div>

        <a href="https://github.com/gwleuverink/clickup-time-tracker/releases/latest" target="_blank" class="inline-flex items-center px-4 py-2 mt-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            Download now
        </a>
    </div>
</div>
