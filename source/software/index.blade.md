---
extends: _layouts.main
section: content

title: Software
---

<ul>
    <li>
        <x-callouts.bundle-banner />
    </li>
    <li>
        <x-callouts.time-tracker-banner read-more="true" />
    </li>
    <li>
        <x-callouts.workspace-banner />
    </li>
    <li>
        <x-callouts.phost-banner />
    </li>
    <li>
        <x-callouts.anonymous
            title="Asset Injector"
            description="Streamline Laravel package development by automatically inserting JS and CSS into web responses. Eliminate manual asset inclusion for your users"
            :buttons="[
                'GitHub' => 'https://github.com/gwleuverink/asset-injector'
            ]"
            class="!bg-fuchsia-800"
        />
    </li>
    <li>
        <x-callouts.anonymous
            title="Magic Todo"
            description="Aren't todo comments the worst? Turn them into interactive, in-your-face reminders with a single keystroke"
            :buttons="[
                'GitHub' => 'https://github.com/gwleuverink/magic-todo'
            ]"
        />
    </li>
    <li>
        <x-callouts.anonymous
            title="Blade Hints"
            description="Mark usages of a variety of different Blade directives on your page, so you can easily spot missing authorization/auth/env checks"
            :buttons="[
                'GitHub' => 'https://github.com/gwleuverink/blade-hints'
            ]"
        />
    </li>
</ul>
