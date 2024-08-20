<!-- __COMPONENT__ input.text -->
@props([
    'disabled' => isset($disabled)
])

<input
    {{ $attributes->merge([
        'type' => 'text',
        'class' => 'dark:bg-slate-800 dark:text-white dark:border-slate-700 bg-transparent block w-full text-lg -skew-x-[4deg] transform-gpu border-slate-300 shadow-sm focus:border-pink-500 focus:ring-pink-500 focus:animate-pulse'
    ]) }}
    :disabled="state.success || state.submitting || @js($disabled)"
    :id="$id('input')"
>
<!-- __ENDCOMPONENT__ input.text -->
