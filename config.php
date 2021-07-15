<?php

use Illuminate\Support\Str;

return [
    'production' => false,
    'baseUrl' => 'http://localhost:3000/',
    'title' => 'Project X',
    'description' => 'Website description.',

    'collections' => [],

    'selected' => function ($page, $section) {
        return $page->getPath() === $section || Str::contains($page->getPath(), $section) ? 'font-bold text-black' : '';
    },
];
