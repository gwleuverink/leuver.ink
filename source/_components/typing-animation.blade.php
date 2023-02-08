@props([
'text' => ''
])

<span
    {{ $attributes }}
    x-title="typing-animation"
    x-modelable="typing"
    x-data="{
        typing: true
    }"
    class="inline-flex">

    @foreach (str_split($text) as $char)
    <span
        x-show="typing"
        x-transition:enter.duration.100ms.delay.{{ ($loop->iteration * 80) + 150 }}ms
        x-transition:leave.duration.100ms.delay.5s
        >
        {!! $char !== ' ' ? $char : '&nbsp;' !!}
    </span>
    @endforeach

</span>
