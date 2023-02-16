<a href="/"
    x-title="logo"
    x-init="$nextTick(() => animated = true)"
    x-data="{
        animated: $persist(false).using(sessionStorage).as('logo-animated'),
        revert: function (callback) {
            this.$event.preventDefault()
            this.$event.stopPropagation()

            this.animated = false

            this.$nextTick(
                setTimeout(() => callback(), 260)
            )
        }
    }"
    x-on:keydown.window.meta.r="() => revert(
        () => location.reload()
    )"
    x-on:click="() => revert(
        () => window.location = '/'
    )"
    {{ $attributes->class('logo inline-block -skew-x-12 select-none min-h-[60px] transition transform-gpu') }}
    role="banner"
    aria-label="Back to home">

    <div
        x-show="animated"
        x-transition.duration.300ms.delay.100ms.scale.160.opacity.0

        class="inline-block bg-gradient-to-r from-purple-400 via-pink-500 to-red-500">

        <h1 class="mx-3 my-0.5 text-3xl italic font-semibold text-white skew-x-12">
            <x-typing-animation text="Hi, I'm Willem" x-model="animated" />
        </h1>

    </div>


    <div
        x-show="animated"
        x-transition:enter.delay.1700ms
        x-transition:leave.delay.0ms
        class="ml-4 font-bold text-pink-600">
        and I make things
    </div>

</a>
