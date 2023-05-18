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
            <p>Before you you might see one of the great philosophers, staring into the distance, pondering the finer meaning of existence</p>
            <p>Looks can be deceiving however, it is just me</p>
        </div>
    </div>

    {{--
    <p>
        If you've got this far, I'd just like to say.. Hi mum, I know it's you. I've got my own website. Next time you ask me what it is I do, I'll just refer you back to this page.
    </p>
    --}}

    <p>
        I am a engineer by trade. Creative problem solving is what I do. Wherether that'd be by writing code or finding solutions that help businesses improve their efficiency.
    </p>

    {{--
    <p>
        A good program has much in common with written prose. It it is an expression of creativity. Clear in how it communicates it's intent and iterated over many times untill it is as perfect as can be.
    </p>

    <p>
        A hallmark of good software in my opinion is not only that is well designed, written with the right abstractions & rigourosly tested. But it also has a certain astetic only an seasoned programmer might appreciate.
        In that regard, I consider programming a highly creative endeavor. One that I pull a lot of satisfaction from.
    </p>
    --}}

    <x-separator />

    <p>
        Feel free to drop me a line! I'm available for your regular shop talk, freelance project work, consulting & pair sessions.
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

            <x-input.group label="What's your name" class="col-span-2 sm:col-span-1">
                <x-input.text x-model="form.name" name="name" autocomplete="given-name" required />
            </x-input.group>

            <x-input.group label="Drop me a line!" class="col-span-2">
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
                submit
            </x-input.submit>

        </div>

    </x-input.form>

</div>

@endsection
