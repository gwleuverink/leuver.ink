<!-- __COMPONENT__ input.textarea -->
@props([
    'disabled' => isset($disabled)
])

<textarea
    {{ $attributes->merge([
        'rows' => 5,
        'class' => 'bg-white border-black/10 shadow-sm placeholder:text-gray-400 dark:bg-white/[0.04] dark:border-white/10 dark:shadow-none dark:text-white dark:placeholder:text-slate-500 block min-h-[4rem] max-h-[20rem] w-full text-lg -skew-x-[4deg] transform-gpu focus:border-pink-500 focus:ring-pink-500 focus:animate-pulse'
    ]) }}
    :disabled="state.success || state.submitting || @js($disabled)"
    :id="$id('input')"
></textarea>
<!-- __ENDCOMPONENT__ input.textarea -->
