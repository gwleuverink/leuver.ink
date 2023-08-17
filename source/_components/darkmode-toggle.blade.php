
<button
    x-data
    x-title="darkmode-toggle"
    x-on:click="$store.darkMode.toggle()"
    :aria-checked="$store.darkMode.enabled"
    :class="$store.darkMode.enabled ? 'bg-slate-400' : 'bg-slate-300'"
    class="relative inline-flex py-1 ml-2 transition rounded-full w-14"
    :aria-label="$store.darkMode.enabled ? 'Disable darkmode' : 'Enable darmode'"
    type="button"
    role="switch"
>
    {{-- heroicon-m-sun --}}
    <svg
        x-show="!$store.darkMode.enabled"
        x-transition
        class="absolute w-5 h-5 left-1.5 text-slate-500"
        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
        <path d="M10 2a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 2zM10 15a.75.75 0 01.75.75v1.5a.75.75 0 01-1.5 0v-1.5A.75.75 0 0110 15zM10 7a3 3 0 100 6 3 3 0 000-6zM15.657 5.404a.75.75 0 10-1.06-1.06l-1.061 1.06a.75.75 0 001.06 1.06l1.06-1.06zM6.464 14.596a.75.75 0 10-1.06-1.06l-1.06 1.06a.75.75 0 001.06 1.06l1.06-1.06zM18 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 0118 10zM5 10a.75.75 0 01-.75.75h-1.5a.75.75 0 010-1.5h1.5A.75.75 0 015 10zM14.596 15.657a.75.75 0 001.06-1.06l-1.06-1.061a.75.75 0 10-1.06 1.06l1.06 1.06zM5.404 6.464a.75.75 0 001.06-1.06l-1.06-1.06a.75.75 0 10-1.061 1.06l1.06 1.06z" />
    </svg>

    {{-- heroicon-m-moon --}}
    <svg
        x-show="$store.darkMode.enabled"
        x-transition
        class="absolute w-4 h-4 mt-0.5 right-1.5 text-slate-300"
        xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
        <path fill-rule="evenodd" d="M7.455 2.004a.75.75 0 01.26.77 7 7 0 009.958 7.967.75.75 0 011.067.853A8.5 8.5 0 116.647 1.921a.75.75 0 01.808.083z" clip-rule="evenodd" />
    </svg>

    {{-- toggle indicator --}}
    <span
        :class="$store.darkMode.enabled ? 'translate-x-1' : 'translate-x-8'"
        class="w-5 h-5 transition bg-white rounded-full shadow-md"
        aria-hidden="true"
    ></span>

</button>
