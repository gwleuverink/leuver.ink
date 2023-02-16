@props([
    'label' => ''
])

<div {{ $attributes }}
    x-id="['input']"
>

    <label :for="$id('input')" class="block ml-1.5 text-xl text-gray-600 dark:text-slate-300">
        {{ $label }}
    </label>

    <div class="mt-1">
        {{ $slot }}
    </div>

</div>
