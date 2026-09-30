<?php

namespace Tests\Feature;

use App\Support\Locale;
use Tests\TestCase;

/**
 * Google shows about 60 characters of a title and about 160 of a description.
 * Anything longer is cut off with "…", so every page in every language must fit.
 */
class SeoLengthsTest extends TestCase
{
    public static function locales(): array
    {
        $config = require __DIR__.'/../../config/locales.php';

        return array_map(fn ($code) => [$code], array_combine(array_keys($config['supported']), array_keys($config['supported'])));
    }

    /** @dataProvider locales */
    public function test_titles_and_descriptions_fit_in_search_results(string $code): void
    {
        $paths = ['/', '/about', '/contact', '/privacy-policy', '/terms'];
        foreach (array_keys(config('tools')) as $slug) {
            $paths[] = '/'.$slug;
        }
        foreach (array_keys(config('categories')) as $slug) {
            $paths[] = '/category/'.$slug;
        }

        $problems = [];
        foreach ($paths as $path) {
            $url = $code === 'en' ? $path : '/'.$code.($path === '/' ? '' : $path);
            $html = $this->get($url)->assertOk()->getContent();
            Locale::flush();

            preg_match('#<title>(.*?)</title>#s', $html, $title);
            preg_match('#<meta name="description" content="([^"]*)"#', $html, $description);
            $title = html_entity_decode($title[1] ?? '', ENT_QUOTES);
            $description = html_entity_decode($description[1] ?? '', ENT_QUOTES);

            if (mb_strlen($title) > 60) {
                $problems[] = "$url title is ".mb_strlen($title).' characters: '.$title;
            }
            if (str_ends_with($description, '…') || mb_strlen($description) > 160) {
                $problems[] = "$url description is cut off (".mb_strlen($description).' characters)';
            }
            if (mb_strlen($description) < 70) {
                $problems[] = "$url description is too short (".mb_strlen($description).' characters)';
            }
        }

        $this->assertSame([], $problems, implode("\n", $problems));
    }
}
