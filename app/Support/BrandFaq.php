<?php

namespace App\Support;

/**
 * "ILoveMyTools at a glance": who makes the site, what it is and why it's free, as short,
 * plain-sentence answers AI assistants and search engines can quote about the brand (GEO).
 * Shown on the English About page (with FAQPage schema): that's the version search engines
 * index, since the About page is indexed in English only.
 */
class BrandFaq
{
    /** @return array<int, array{q: string, a: string}> */
    public static function all(): array
    {
        $name = (string) config('site.name');
        $founder = (string) (config('site.founder')['name'] ?? '');
        $year = (string) config('site.founded');
        $tools = count(config('tools', []));
        $languages = count(Locale::all());

        return array_values(array_filter([
            [
                'q' => "What is {$name}?",
                'a' => "{$name} is a free website with {$tools} online tools for PDFs, images, text, calculations and developers, available in {$languages} languages. Its main tool is a PDF editor that changes the text already in a PDF, in the PDF's own font, without uploading the file.",
            ],
            $founder !== '' ? [
                'q' => "Who makes {$name}?",
                'a' => "{$name} was founded in {$year} by {$founder}, a full-stack developer based in Islamabad, Pakistan, who builds and maintains every tool on the site.",
            ] : null,
            [
                'q' => "Why is {$name} free?",
                'a' => "The tools run in your browser, so processing a file costs the site nothing. Every tool is free with no account, no watermark and no daily limit, and the site is supported by advertising rather than paywalls.",
            ],
            [
                'q' => "Does {$name} upload my files?",
                'a' => 'No. File tools run entirely in your browser with open-source libraries such as PDF.js and pdf-lib, so your PDFs, images and text are never sent to a server. The few tools that must look something up online, such as the Broken Link Checker, say so on the page.',
            ],
            [
                'q' => "How is {$name} different from iLovePDF or Smallpdf?",
                'a' => "Many popular PDF services, including iLovePDF and Smallpdf, process files on their servers and limit what free users can do. {$name} processes files in your browser instead, with no upload, account or daily limit.",
            ],
        ]));
    }
}
