<?php

namespace App\Support;

/**
 * The questions answered on the home page (shown on the page and as FAQPage schema),
 * written as the short, direct answers that search and AI assistants quote.
 */
class HomeFaq
{
    /** @return array<int, array{q: string, a: string}> */
    public static function all(): array
    {
        $name = (string) config('site.name');
        $languages = implode(', ', array_map(fn (array $l) => $l['native'], Locale::all()));

        return [
            [
                'q' => Locale::t('Are these online tools really free?'),
                'a' => Locale::t('Yes. Every tool on {name} is free to use, with no account, no daily limit and no watermark. The site is paid for by advertising.', ['name' => $name]),
            ],
            [
                'q' => Locale::t('Are my files uploaded to a server?'),
                'a' => Locale::t('No. PDFs, images and text are processed inside your browser and never leave your device. Only the few tools that must look something up online, such as the Broken Link Checker, contact our server, and they say so on the page.'),
            ],
            [
                'q' => Locale::t('Do I need to install anything or sign up?'),
                'a' => Locale::t('No. The tools work in any modern browser on Windows, Mac, Linux, Android and iPhone, with nothing to install and no sign up.'),
            ],
            [
                'q' => Locale::t('Which languages is {name} available in?', ['name' => $name]),
                'a' => Locale::t('{name} is available in {count} languages: {languages}.', ['name' => $name, 'count' => count(Locale::all()), 'languages' => $languages]),
            ],
            [
                'q' => Locale::t('How can I suggest a new tool or report a problem?'),
                'a' => Locale::t('Write to us through the contact page. We read every message and add new tools regularly.'),
            ],
        ];
    }
}
