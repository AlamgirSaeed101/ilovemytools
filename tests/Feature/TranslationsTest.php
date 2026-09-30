<?php

namespace Tests\Feature;

use App\Support\Locale;
use Tests\TestCase;

/**
 * Every language has complete, well-formed page content for every tool and
 * category, and every localized page renders in its language.
 */
class TranslationsTest extends TestCase
{
    private const TOOL_TEXT = ['name', 'title', 'description', 'h1', 'tagline', 'intro'];

    public static function locales(): array
    {
        $config = require __DIR__.'/../../config/locales.php';

        return array_map(fn ($code) => [$code], array_values(array_filter(
            array_keys($config['supported']),
            fn ($code) => $code !== $config['default']
        )));
    }

    /** @dataProvider locales */
    public function test_tool_and_category_content_is_complete(string $code): void
    {
        $tools = require lang_path("$code/tools.php");
        $categories = require lang_path("$code/categories.php");
        $site = require lang_path("$code/site.php");

        $this->assertNotEmpty($site['tagline'] ?? null);
        $this->assertNotEmpty($site['description'] ?? null);

        foreach (config('tools') as $slug => $tool) {
            $this->assertArrayHasKey($slug, $tools, "$code is missing tool $slug");
            $tr = $tools[$slug];
            foreach (self::TOOL_TEXT as $field) {
                $this->assertIsString($tr[$field] ?? null, "$code/$slug.$field");
                $this->assertNotSame('', trim($tr[$field]), "$code/$slug.$field is empty");
            }
            $this->assertCount(count($tool['steps']), $tr['steps'], "$code/$slug steps");
            $this->assertCount(count($tool['features']), $tr['features'], "$code/$slug features");
            $this->assertCount(count($tool['content']), $tr['content'], "$code/$slug content");
            $this->assertCount(count($tool['faqs']), $tr['faqs'], "$code/$slug faqs");
            if (isset($tool['table'])) {
                $this->assertNotEmpty($tr['table']['caption'] ?? null, "$code/$slug table caption");
                $this->assertCount(count($tool['table']['headers']), $tr['table']['headers'] ?? [], "$code/$slug table headers");
                $this->assertCount(count($tool['table']['rows']), $tr['table']['rows'] ?? [], "$code/$slug table rows");
            }
            foreach ($tr['content'] as $section) {
                $this->assertNotEmpty($section['heading'] ?? null, "$code/$slug content heading");
                $this->assertNotEmpty($section['body'] ?? null, "$code/$slug content body");
            }
            foreach ($tr['faqs'] as $faq) {
                $this->assertNotEmpty($faq['q'] ?? null, "$code/$slug faq q");
                $this->assertNotEmpty($faq['a'] ?? null, "$code/$slug faq a");
            }
        }

        foreach (config('categories') as $slug => $category) {
            $this->assertArrayHasKey($slug, $categories, "$code is missing category $slug");
            foreach (['name', 'title', 'description', 'intro'] as $field) {
                $this->assertNotEmpty($categories[$slug][$field] ?? null, "$code/categories.$slug.$field");
            }
            $this->assertCount(count($category['content'] ?? []), $categories[$slug]['content'] ?? [], "$code/categories.$slug content");
            $this->assertCount(count($category['faqs'] ?? []), $categories[$slug]['faqs'] ?? [], "$code/categories.$slug faqs");
            foreach ($categories[$slug]['faqs'] ?? [] as $faq) {
                $this->assertNotEmpty($faq['q'] ?? null, "$code/categories.$slug faq q");
                $this->assertNotEmpty($faq['a'] ?? null, "$code/categories.$slug faq a");
            }
        }
    }

    /** @dataProvider locales */
    public function test_localized_pages_render_in_their_language(string $code): void
    {
        Locale::flush();
        $tools = require lang_path("$code/tools.php");
        $dir = Locale::all()[$code]['dir'];

        $html = $this->get("/$code/merge-pdf")->assertOk()->getContent();
        $this->assertStringContainsString('dir="'.$dir.'"', $html);
        $this->assertStringContainsString('<link rel="canonical" href="https://toolzy.test/'.$code.'/merge-pdf">', $html);
        $this->assertStringContainsString(e($tools['merge-pdf']['h1']), $html);
        $this->assertStringContainsString('hreflang="x-default"', $html);

        $this->get("/$code")->assertOk()->assertSee('lang="'.Locale::hreflang($code).'"', false);
        $this->getJson("/api/tools/word-counter?locale=$code")->assertOk()->assertJsonPath('h1', $tools['word-counter']['h1']);
    }
}
