<!-- __PARTIAL__ konami-code -->

{{--
Flashes an isnspiring mesage after the konami code is entered
--}}

<div x-title="konami-code"
    x-show="open"
    x-transition
    x-trap.inert.noscroll="open"
    x-init="quote = selectRandom()"
    x-on:keyup.window="() => {
        // Listen for the konami code sequence
        // If the key pressed isn't the current key in the pattern, reset
        if ($event.key !== sequence[sequenceIndex]) {
            return current = 0;
        }

        // If complete, show quote & reset
        if (sequence.length === sequenceIndex + 1) {
            open = true
            sequenceIndex = 0
            quote = selectRandom()
            return setTimeout(() => { open = false }, 4000)
        }

        // Current sequence key is pressed, increment index
        sequenceIndex++;
    }"
    x-data="{
        open: false,
        quote: '',

        sequenceIndex: 0,
        sequence: ['ArrowUp', 'ArrowUp', 'ArrowDown', 'ArrowDown', 'ArrowLeft', 'ArrowRight', 'ArrowLeft', 'ArrowRight', 'b', 'a'],

        selectRandom: function() {
            random = this.quotes[Math.floor((Math.random()*this.quotes.length))]
            console.info(random)
            return random
        },
        {{-- printed with blade so it renders as a single line  --}}
        quotes: JSON.parse(`{{
            json_encode([
                'Be like water.',
                'In work, do what you enjoy.',
                'Do your work, then step back.',
                'The whole world belongs to you.',
                'The Master doesn\'t talk, he acts.',
                'Success is as dangerous as failure.',
                'The best athlete wants his opponent at his best.',
                'Nothing in the world is as soft and yielding as water.',
                'Care about people\'s approval and you will be their prisoner.',
                'Because she competes with no one, no one can compete with her.',
                'Knowing others is intelligence; knowing yourself is true wisdom.',
                'A good traveler has no fixed plans and is not intent upon arriving.',
                'If you look to others for fulfillment, you will never truly be fulfilled.',
                'If your happiness depends on money, you will never be happy with yourself.',
                'To attain knowledge, add things every day; To attain wisdom, subtract things every day.',
            ])
        }}`),
    }"
    class="fixed inset-0 flex items-center justify-center bg-white dark:bg-slate-900"
    role="alertdialog"
>
    <div class="prose prose-2xl">
        <blockquote x-text="quote"></blockquote>
    </div>
</div>
<!-- __ENDPARTIAL__ konami-code -->
