---
title: About
---

@extends('_layouts.main')

@section('content')

<div class="prose prose-xl">

    <div class="flex flex-col items-center mb-8 space-y-6 sm:space-x-6 sm:flex-row">
        <div class="inline-block overflow-hidden rounded-full shrink-0 grow-0 bg-gradient-to-r from-purple-400 via-pink-500 to-red-500">
           <img src="/assets/images/nature-boy-square-rect.jpg" class="pointer-events-none select-none m-1.5 rounded-full max-w-[180px] scale-x-[-1]" alt="That's me!">
        </div>

        <div>
            <p>Before you, you might envision one of the great philosophers, lost in contemplation, unraveling the profound enigmas of existence.</p>
            <p>Appearances can be deceptive, for it is just little ol' me.</p>
        </div>
    </div>



    <p>
        I am a engineer by trade. My craft lies in the realm of creative problem-solving. Whether coding up a storm or finding ways to streamline business efficiency, that's my jam.
    </p>

    <x-separator />

    <p>
        I'm always down for shop talk, freelance gigs, consulting, or pair programming sessions. Drop me a line anytime.
    </p>


     <x-input.form
        action="https://formkeep.com/f/c5d5525650bd"
        accept-charset="UTF-8"
        enctype="multipart/form-data"
        method="POST"
        class="my-10"
     >

        <input type="hidden" x-model="form.subscribe_c5d5525650bd_41440" name="subscribe_c5d5525650bd_41440" value="">

        <div class="grid grid-cols-2 mt-6 gap-y-6 gap-x-4">

            <x-input.group label="Where can I reach you?" class="col-span-2 sm:col-span-1">
                <x-input.text x-model="form.email" name="email" type="email" autocomplete="email" required />
            </x-input.group>

            <x-input.group label="What's your name?" class="col-span-2 sm:col-span-1">
                <x-input.text x-model="form.name" name="name" autocomplete="given-name" required />
            </x-input.group>

            <x-input.group label="Where lines should be dropped" class="col-span-2">
                <x-input.textarea x-model="form.message" name="message" required />
            </x-input.group>

        </div>

        <div class="flex items-center justify-end my-8 space-x-6">

            <span x-show="state.success" x-transition.opacity.scale.origin.right class="text-base text-slate-600 dark:text-slate-300">
                Message sent!
            </span>

            <span x-show="state.exception" x-transition.opacity.scale.origin.right class="text-base text-red-600 dark:text-red-400">
                Something went wrong. Please check the fields and retry
            </span>

            <span x-show="state.submitting" x-transition.opacity.scale.origin.right class="text-base text-slate-600 dark:text-slate-300">
                Working on it...
            </span>

            <x-input.submit ::disabled="state.success || state.submitting">
                Shoot me a message
            </x-input.submit>

        </div>

    </x-input.form>

</div>

@endsection
