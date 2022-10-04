<?php

use Illuminate\Support\Str;

return [
    'production' => false,
    'baseUrl' => 'http://localhost:3001/',
    'title' => 'Project X',
    'description' => 'Website description.',
    'siteAuthor' => 'Willem Leuverink',

    'collections' => [
        'posts' => [
            'path' => 'blog/{date|Y-m-d}/{filename}',
        ]
    ],

    'selected' => function ($page, $section) {
        return $page->getPath() === $section || Str::contains($page->getPath(), ltrim($section, '/')) ? 'font-bold text-black' : '';
    },

    'getExcerpt' => function ($page, $length = 255) {
        if ($page->excerpt) {
            return $page->excerpt;
        }

        $content = preg_split('/<!-- more -->/m', $page->getContent(), 2);
        $cleaned = trim(
            strip_tags(
                preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', $content[0]),
                '<code>'
            )
        );

        if (count($content) > 1) {
            return $cleaned;
        }

        $truncated = substr($cleaned, 0, $length);

        if (substr_count($truncated, '<code>') > substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated) . '...'
            : $cleaned;
    },
];
