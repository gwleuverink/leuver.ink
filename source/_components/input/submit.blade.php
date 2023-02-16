
<button
    type="submit"
    {{ $attributes->merge([
        'class' => 'px-4 mt-8 -skew-x-6 transform-gpu bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 hover:from-indigo-500 hover:via-purple-500 hover:to-pink-500 hover:animate-pulse disabled:animate-none'
    ]) }}
>
    <span class="font-medium text-white uppercase skew-x-6">

        {{ $slot }}

    </span>
</button>
