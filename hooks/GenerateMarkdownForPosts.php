<?php

namespace Hooks;

use TightenCo\Jigsaw\Jigsaw;

class GenerateMarkdownForPosts
{
    public static function build(Jigsaw $jigsaw): void
    {
        $posts = $jigsaw->getCollection('posts');
        $sourcePath = $jigsaw->getSourcePath();
        $buildPath = $jigsaw->getDestinationPath();

        foreach ($posts as $post) {
            $slug = $post->getFilename();
            $sourceFile = self::findSourceFile($sourcePath, $slug);

            if (! $sourceFile) {
                continue;
            }

            $content = self::cleanContent(file_get_contents($sourceFile));

            $title = $post->title;
            $date = date('Y-m-d', $post->date);
            $url = rtrim($jigsaw->getConfig('baseUrl'), '/') . $post->getPath();

            $markdown = <<<MD
            ---
            title: {$title}
            date: {$date}
            author: Willem Leuverink
            url: {$url}
            ---

            {$content}
            MD;

            file_put_contents("{$buildPath}{$post->getPath()}.md", $markdown);
        }
    }

    protected static function findSourceFile(string $sourcePath, string $slug): ?string
    {
        foreach (['.blade.md', '.md'] as $ext) {
            $candidate = "{$sourcePath}/_posts/{$slug}{$ext}";

            if (file_exists($candidate)) {
                return $candidate;
            }
        }

        return null;
    }

    protected static function cleanContent(string $content): string
    {
        // Strip YAML front matter
        $content = preg_replace('/\A---\s*\n.*?\n---\s*\n/s', '', $content);

        // Protect code blocks from being modified
        $codeBlocks = [];
        $content = preg_replace_callback('/^```[\s\S]*?^```/m', function ($match) use (&$codeBlocks) {
            $placeholder = '%%CODEBLOCK_' . count($codeBlocks) . '%%';
            $block = $match[0];

            // Only strip Torchlight annotations inside code blocks
            $block = preg_replace('/\s*\/\/\s*\[tl![^\]]*\]/', '', $block);
            $block = preg_replace('/\s*\[tl![^\]]*\]/', '', $block);

            $codeBlocks[$placeholder] = $block;

            return $placeholder;
        }, $content);

        // Strip Blade components (self-closing and paired)
        $content = preg_replace('/<x-[^>]*\/>/s', '', $content);
        $content = preg_replace('/<\/?x-[^>]*>/s', '', $content);

        // Strip Blade directives (@php...@endphp blocks, @@escaped directives, etc.)
        $content = preg_replace('/@php\b.*?@endphp/s', '', $content);
        $content = preg_replace('/^@@\w+.*$/m', '', $content);

        // Convert <a> tags to markdown links
        $content = preg_replace('/<a\s[^>]*href="([^"]*)"[^>]*>(.*?)<\/a>/s', '[$2]($1)', $content);

        // Strip HTML comments
        $content = preg_replace('/<!--.*?-->/s', '', $content);

        // Strip multi-line HTML blocks (div, video) starting at line beginning — greedy to handle nesting
        $content = preg_replace('/^<(div|video)\b[^>]*>.*?^<\/\1>\s*$/ms', '', $content);

        // Unwrap <p> blocks (keep inner text, remove the tags)
        $content = preg_replace('/<p\b[^>]*>(.*?)<\/p>/s', '$1', $content);

        // Strip remaining standalone HTML tags
        $content = preg_replace('/^\s*<\/?(img|br|hr|source|article)\b[^>]*>\s*$/m', '', $content);

        // Restore code blocks
        $content = str_replace(array_keys($codeBlocks), array_values($codeBlocks), $content);

        // Clean up excessive blank lines
        $content = preg_replace('/\n{3,}/', "\n\n", $content);

        return trim($content);
    }
}
