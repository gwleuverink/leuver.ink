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
        <x-callouts.anonymous
            title="Magic Todo"
            description="Magically turn HTML comments into interactive hints in your Laravel Blade frontend"
            :buttons="[
                'GitHub' => 'https://github.com/gwleuverink/magic-todo'
            ]"
            class="bg-fuchsia-800"
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
