<?php

/*
|--------------------------------------------------------------------------
| Languages
|--------------------------------------------------------------------------
| English lives at the root (/word-counter). Every other language gets its own
| URL prefix (/es/word-counter) so each version can be indexed separately, and
| the pages are linked together with hreflang tags.
|
| Translations:
|   lang/{code}.json              interface text (buttons, labels, headings)
|   lang/{code}/tools.php         each tool's page content (SEO title, FAQs...)
|   lang/{code}/categories.php    category names and descriptions
|   lang/{code}/site.php          tagline and page titles
| Anything missing falls back to English, so a page never shows blank text.
|
| To add a language: add it here, then add its files in lang/.
*/

return [

    'default' => 'en',

    'supported' => [
        'en' => ['name' => 'English', 'native' => 'English', 'dir' => 'ltr', 'og' => 'en_US'],
        'es' => ['name' => 'Spanish', 'native' => 'Español', 'dir' => 'ltr', 'og' => 'es_ES'],
        'pt' => ['name' => 'Portuguese', 'native' => 'Português', 'dir' => 'ltr', 'og' => 'pt_BR'],
        'fr' => ['name' => 'French', 'native' => 'Français', 'dir' => 'ltr', 'og' => 'fr_FR'],
        'de' => ['name' => 'German', 'native' => 'Deutsch', 'dir' => 'ltr', 'og' => 'de_DE'],
        'it' => ['name' => 'Italian', 'native' => 'Italiano', 'dir' => 'ltr', 'og' => 'it_IT'],
        'pl' => ['name' => 'Polish', 'native' => 'Polski', 'dir' => 'ltr', 'og' => 'pl_PL'],
        'ur' => ['name' => 'Urdu', 'native' => 'اردو', 'dir' => 'rtl', 'og' => 'ur_PK'],
        'ko' => ['name' => 'Korean', 'native' => '한국어', 'dir' => 'ltr', 'og' => 'ko_KR'],
        'zh' => ['name' => 'Chinese (Traditional)', 'native' => '繁體中文', 'dir' => 'ltr', 'og' => 'zh_HK', 'hreflang' => 'zh-Hant'],
    ],

];
