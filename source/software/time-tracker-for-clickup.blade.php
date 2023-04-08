---
title: Time Tracker for ClickUp
---

@extends('_layouts.main')

@section('content')

    <div class="prose prose-xl">
        <h2 class="mb-1 text-2xl font-bold leading-tight text-gray-700 md:text-3xl dark:text-slate-300">ClickUp Time Tracker</h2>

        <p>
            At the office we make use of ClickUp quite heavily. It's a pretty versatile productivity platform, but sadly not without it's quirks.
        </p>

        <p>
            The built-in time tracking capabilities are alright okay. But actually working it is very tedious and requires you to keep track of things across multiple tasks, boards or even spaces.
        </p>

        <p>
            When you're working with giant project boards with 500+ tasks things slow down quick. At peak hours the web app becomes somewhat unresponsive and retroactively logging hours becomes pretty much impossible.
        </p>

        <p>
            Tracking time should be as frictionless and orderly as possible. This is why I decided to create a tool to solve this endless struggle. Please welcome; the <b>ClickUp Time Tracker</b>.
        </p>
    </div>

    <x-time-tracker-banner />

    <div class="prose prose-xl">
        <p>
            The Time Tracker is a cross platform app. It works on MacOS, Linux & Windows.
        </p>

        <p>
            Out of the box you get a calendar like time tracking experience. Click and drag on the calendar to create a new entry. Attach a ClickUp task & after this you are free to rearrange, resize, duplicate. Basically work with it like you would in a calendar app.
        </p>

        <p>
            All changes you make are synced with ClickUp in real time!
        </p>

        <img src="/assets/images/clickup-time-tracker-screenshot.png" alt="Time Tracker for ClickUp Screenshot" class="scale-110">

        <h4>What's included</h4>

        <ul>
            <li>Changes synced with ClickUp in real-time</li>
            <li>Orderly Week calendar view (easily spot gaps)</li>
            <li>Intuitive drag & drop UI</li>
            <li>Convenient keyboard shortcuts</li>
            <li>A dedicated management view to get a live view of time tracking of any user (workspace admins only)</li>
            <li>Lower your cortisol levels at the end of the workday by 30% (results may vary)</li>
        </ul>

        <h4>Closing</h4>

        <p>
            I hope this tool is of some use to you! I'm sure if you work with ClickUp & need to do some time tracking. This tool works a heck of a lot better than anything ClickUp provides you out of the box.
        </p>

        <p>If you like this project, please give it a <a href="https://github.com/gwleuverink/clickup-time-tracker/stargazers" target="_blank">star on GitHub</a> or consider <a href="https://github.com/sponsors/gwleuverink" target="_blank">sponsoring the project</a> to support future development. Thank you!</p>

    </div>

@endsection
