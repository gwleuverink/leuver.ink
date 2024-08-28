---
title: Software
---

@extends('_layouts.main')

@section('content')


<div
    x-title="filter"
    x-data="{
        query: '',

        matchesSearchCriteria(target) {
            return !this.query || this.fuzzySearch(this.query, target).match
        },

        fuzzySearch(query, target, threshold = 0.6) {
            // Convert search term and target string to lowercase for case-insensitive matching
            query = this.query.toLowerCase();
            target = target.toLowerCase();

            let bestMatch = '';
            let bestScore = 0;

            // Iterate through the target string, up to the length of the search term
            for (let i = 0; i <= target.length - query.length; i++) {
                // Check each character in the search term against the target string
                for (let j = 0; j < query.length; j++) {
                    // If the characters don't match, break out of the inner loop
                    if (target[i + j] !== query[j]) {
                        break;
                    }

                    // If we've reached the end of the search term, calculate the match score
                    if (j === query.length - 1) {
                        const matchScore = (j + 1) / query.length;

                        // If the match score meets the threshold and is better than the current best, update the best match and score
                        if (matchScore >= threshold && matchScore > bestScore) {
                            bestMatch = target.slice(i, i + j + 1);
                            bestScore = matchScore;
                        }
                    }

                }
            }

            return { match: bestMatch, score: bestScore };
        },

        state: {
            success: false,
            exception: false,
            submitting: false,
        },
    }"
    class="space-y-8"
>

    <x-input.group>
        <x-input.text
            type="text"
            name="search"
            placeholder="Search..."
            x-model.debounce.100ms="query"
            class="skew-x-0 rounded-md"
        />
    </x-input.group>


    <ul>

        <li>
            <x-callouts.bundle-banner
                x-show="matchesSearchCriteria('bundle laravel blade js javascript modules import export livewire package assets tool')"
            />
        </li>

        <li>
            <x-callouts.time-tracker-banner
                read-more="true"
                x-show="matchesSearchCriteria('native app electron clickup time tracker timetracker hours log logging sheet timesheet')"
            />
        </li>

        <li>
            <x-callouts.workspace-banner
                x-show="matchesSearchCriteria('workspace work space laravel package lint linter fix fixer static analysis staticanalysis ci workflows integration config tool')"
            />
        </li>

        <li>
            <x-callouts.phost-banner
                x-show="matchesSearchCriteria('phost post native app nativephp email e-mail debug debugging debugger development tool smtp server')"
            />
        </li>

        <li>
            <x-callouts.anonymous
                title="Asset Injector"
                x-show="matchesSearchCriteria('asset injector assetinjector laravel package tool')"
                description="Streamline Laravel package development by automatically inserting JS and CSS into web responses. Eliminate manual asset inclusion for your users"
                :buttons="[
                    'GitHub' => 'https://github.com/gwleuverink/asset-injector'
                ]"
                class="!bg-fuchsia-800"
            />
        </li>

        <li>
            <x-callouts.anonymous
                title="Livewire property groups"
                x-show="matchesSearchCriteria('livewire group grouped property properties attribute package')"
                description="Simplify property management, validation, and manipulation in Livewire components by organizing related properties into named groups"
                :buttons="[
                    'GitHub' => 'https://github.com/gwleuverink/livewire-property-group'
                ]"
                class="!bg-purple-900"
            />
        </li>

        <li>
            <x-callouts.anonymous
                title="Magic Todo"
                x-show="matchesSearchCriteria('magic todo laravel blade package key keystroke tool')"
                description="Aren't todo comments the worst? Turn them into interactive, in-your-face reminders with a single keystroke"
                :buttons="[
                    'GitHub' => 'https://github.com/gwleuverink/magic-todo'
                ]"
            />
        </li>

        <li>
            <x-callouts.anonymous
                title="Blade Hints"
                x-show="matchesSearchCriteria('blade hints bladehints laravel package directive auth authorization authentication check tool')"
                description="Mark usages of a variety of different Blade directives on your page, so you can easily spot missing authorization/auth/env checks. Especially handy for code reviews"
                :buttons="[
                    'GitHub' => 'https://github.com/gwleuverink/blade-hints'
                ]"
                class="!bg-purple-800"
            />
        </li>

    </ul>


    {{--
    <div class="flex flex-wrap justify-content-center">

        <pre class="text-xs font-extrabold text-pink-500 animate-pulse">
            @include('_partials.here-be-dragons')
        </pre>

    </div>
    --}}


</div>

@endsection
