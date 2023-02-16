@props([
    'disabled' => isset($disabled)
])

<textarea
    {{ $attributes->merge([
        'rows' => 5,
        'class' => 'dark:bg-slate-800 dark:text-white bg-transparent block min-h-[4rem] max-h-[20rem] w-full text-lg -skew-x-[4deg] transform-gpu border-slate-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 focus:animate-pulse'
    ]) }}
    :disabled="state.success || state.submitting || @js($disabled)"
    :id="$id('input')"
></textarea>
