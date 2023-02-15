
<svg {{ $attributes }} xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" >

    @once
    @push('svg-definitions')
    <defs>
        <path id="arrow-long-left" style="stroke: url(#retro-gradient)" stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
    </defs>
    @endpush
    @endonce

    <use xlink:href="#arrow-long-left" />

</svg>
