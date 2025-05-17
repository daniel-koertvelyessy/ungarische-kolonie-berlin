<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Stringable;

class MarkdownService
{
    /**
     * Load and convert a Markdown file to HTML based on the current locale.
     *
     * @param  string  $filenameWithoutExtension  The base filename (e.g., 'welcome')
     * @param  string|null  $locale  Optional locale override; defaults to app()->getLocale()
     * @param  string  $fallbackLocale  Fallback locale if file for current locale is missing
     * @return Stringable HTML string or null if file not found
     *
     * @throws FileNotFoundException
     */
    public function getMarkdownAsHtml(string $filenameWithoutExtension, ?string $locale = null, string $fallbackLocale = 'hu'): \Illuminate\Support\Stringable
    {
        $locale = $locale ?? app()->getLocale();
        $basePath = resource_path('markdown');

        // Try locale-specific file (e.g., welcome.hu.md)
        $filePath = "{$basePath}/{$filenameWithoutExtension}.{$locale}.md";

        if (! File::exists($filePath)) {
            // Fallback to default locale (e.g., welcome.en.md)
            $filePath = "{$basePath}/{$filenameWithoutExtension}.{$fallbackLocale}.md";
            if (! File::exists($filePath)) {
                return Str::of('**Content file not found**')->markdown();
            }
        }

        $markdown = File::get($filePath);

        return Str::of($markdown)->markdown();
    }
}
