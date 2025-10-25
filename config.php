<?php

use Illuminate\Support\Str;

return [
    'production' => false,
    'baseUrl' => 'http://leuver.ink.test/',
    'title' => 'Project X',
    'description' => '',
    'siteAuthor' => 'Willem Leuverink',
    'siteName' => 'Willem\'s Blog',

    'collections' => [
        'posts' => [
            'path' => 'blog/{date|Y-m-d}/{filename}',
            'sort' => '-date',
            'filter' => function ($item) {
                return $item->published;
            },
        ]
    ],

    'selected' => function ($page, $section) {
        return $page->getPath() === $section || Str::contains($page->getPath(), mb_ltrim($section, '/')) ? 'font-bold' : '';
    },

    'getExcerpt' => function ($page, $length = 255) {
        if ($page->excerpt) {
            return $page->excerpt;
        }

        if ($page->description) {
            return $page->description;
        }

        $content = preg_split('/<!-- more -->/m', $page->getContent(), 2);
        $cleaned = mb_trim(
            strip_tags(
                preg_replace(['/<pre>[\w\W]*?<\/pre>/', '/<h\d>[\w\W]*?<\/h\d>/'], '', $content[0]),
                '<code>'
            )
        );

        if (count($content) > 1) {
            return $cleaned;
        }

        $truncated = mb_substr($cleaned, 0, $length);

        if (mb_substr_count($truncated, '<code>') > mb_substr_count($truncated, '</code>')) {
            $truncated .= '</code>';
        }

        return mb_strlen($cleaned) > $length
            ? preg_replace('/\s+?(\S+)?$/', '', $truncated).'...'
            : $cleaned;
    },
];
