@extends('_layouts.main')

@section('content')

<div class="prose prose-xl">

    <p>
        I'm not one whom toots their own horn, so I find it hard to beleive anyone cares a hoot about my so-called `using` page
    </p>

    <p>
        So, let's approach it a bit differently. I'd like to shout out a couple of awesome tools I use a lot. Check em out, give them some love
    </p>

    <div class="flex flex-col items-center mb-12 space-y-12 text-center">

        <p role="heading">
            Without furter ado
        </p>

        <x-svg.wiggly-downward-arrow class="w-24 ml-10 text-pink-600" />

        <p>
            Except for that giant arrow
        </p>

    </div>

    <h2>Visual Studio Code</h2>
    <p>
        VS Code has been my editor of choice for the last couple of years. Out of the box however, the PHP & Laravel
        experience is sub par and the UI is very busy. Too many bits and bobs you might never use or don't fit in your
        workflow.
    </p>
    <p>
        Great thing there is this course called <a href="https://makevscodeawesome.com/friends" target="_blank">Make VS
        Code Awesome </a> to guide you through setting things up <i>exactly</i> how you want them to be. Empowering you
        to do your best work and not get distracted by things that do not matter.
    </p>

    <h2>Spatie Laravel packages in general</h2>
    <p>
        I mean, c'mon the rate these people churn out amazingly usefull packages is uncanny. Great support, timely
        updates. Spatie deserves my undying gratitude. <a href="https://spatie.be/open-source" target="_blank">Check them out!</a>
    </p>

    <h2>Intelephense</h2>
    <p>
        The PHP language server implementation I use in VS Code. I have tried a couple in the past, but this one works
        the best for me. <a href="https://intelephense.com/" target="_blank">Give it a go!</a>
    </p>

    <h2>TablePlus</h2>
    <p>My database management tool of choice. There is not much to say exept I use this every day</p>

    <h2>DBngin</h2>
    <p>
        A database version management tool made by the people that do TablePlus. It is in my experience the easiest way to get up
        and running with any database. <a href="https://dbngin.com/" target="_blank">Definetly give it a look</a>. It's free!
    </p>

    <h2>Tinkerwell</h2>
    <p>
        Tinker in Laravel apps like a pro. Connect to any Forge server or local project & start executing PHP code right there from
        within the app. Just an amazing debugging utility and awesome for testing things out.
        <a href="https://tinkerwell.app/" target="_blank">Get it here</a>!
    </p>

    <h2>Helo</h2>
    <p>
        Painless & powerfull local email testing app. They describe it as <i>'The swiss-army-knife of email testing
        testing and debugging'</i>. That is true and then some. I use it regularly and is an essential essential
        tool in my toolbelt. Get the app <a href="https://usehelo.com/" target="_blank">here</a>.
    </p>

    <h2>iTerm</h2>
    <p>A highly customizible terminal app. I use it heavily every day</p>

</div>

@endsection
