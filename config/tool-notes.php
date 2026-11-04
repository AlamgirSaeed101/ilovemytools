<?php

/*
|--------------------------------------------------------------------------
| "We tested it": first-hand results on the top tools (English pages)
|--------------------------------------------------------------------------
| Every number comes from running the live tool with scripts/tool-tests.mjs; the raw results are in
| resources/data/tool-tests.json. Re-run the script before changing a figure. Never write a result
| here that the script didn't produce.
*/

return [

    'merge-pdf' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'We merged three PDFs on this page: a 1-page cover, a 5-page report and a 2-page annex. The result had all 8 pages, in the order we set. The browser\'s network log showed no request carrying a file: 0 bytes were sent while the merge ran.',
        ],
        'limits' => [
            'Up to 50 files at a time.',
            'Very long documents depend on your device\'s memory, because the work happens on your device.',
            'A damaged file is reported by name and has to be removed before you can merge.',
        ],
    ],

    'compress-pdf' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'We compressed a 3-page PDF made of photos using the Recommended setting. It went from 716 KB to 122 KB, 83% smaller, and still had all 3 pages. No file was sent anywhere: the network log showed 0 bytes uploaded.',
            'That result comes from a photo-heavy test file, which is the best case. Recommended re-encodes the images and leaves the text alone, so a PDF that is mostly text has much less to gain.',
        ],
        'limits' => ['One PDF at a time, up to 200 MB.'],
    ],

    'split-pdf' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'We extracted pages 1-3 and 5 from a 12-page PDF. The download was a 4-page file named report-pages-1-3_5.pdf, and 0 bytes were uploaded. The range box accepts commas and semicolons, and Chinese and Urdu separators too.',
        ],
        'limits' => ['One PDF at a time, up to 200 MB.'],
    ],

    'pdf-to-jpg' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'Higher DPI means a sharper image and a larger file. We converted the same simple text page at each setting, with 0 bytes uploaded. A page full of photos will be much larger than these figures.',
        ],
        'table' => [
            'headers' => ['DPI', 'JPG size for one text page'],
            'rows' => [['72', '6 KB'], ['150', '18 KB'], ['300', '63 KB']],
        ],
        'limits' => ['One PDF at a time, up to 200 MB.'],
    ],

    'jpg-to-pdf' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'We combined three 484 KB photos into one PDF. It had 3 pages and came to 1,453 KB, about the same as the three images together, so expect the PDF to be roughly the size of your photos. If that is too big to send, shrink the images first with the Image Compressor. Nothing was uploaded.',
        ],
        'limits' => ['Up to 30 images at a time, 50 MB each.'],
    ],

    'edit-pdf' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'We opened a 2-page PDF and replaced the word "Contract" with "Agreement" using Find and Replace. The tool reported "Replaced 2 times" and saved a 2-page PDF, with 0 bytes uploaded. Our automated tests also read the saved file back on every release, to check that the old wording is gone rather than only covered.',
        ],
    ],

    'image-compressor' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'We tested a 1600 x 1067 photo-like JPG of 926 KB, generated for the test. No image was uploaded in either run.',
        ],
        'table' => [
            'headers' => ['Setting', 'Result', 'Saved'],
            'rows' => [['Quality 75%', '200 KB', '78%'], ['Target size 100 KB', '100 KB', '89%']],
        ],
        'limits' => ['Up to 30 images at a time, 50 MB each.', 'A very small target on a large photo can lower its quality or dimensions noticeably.'],
    ],

    'image-resizer' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'We set a 1600 x 1067 PNG to a width of 800 pixels. With the aspect ratio locked, the height filled in as 534, and the downloaded file measured exactly 800 x 534. Nothing was uploaded.',
        ],
        'limits' => ['Files up to 50 MB.'],
    ],

    'webp-to-png' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'Expect a much larger file. A 77 KB WebP photo became an 801 KB PNG, about 10 times the size, because PNG is lossless and photos compress poorly in it. For a photo that only needs to open everywhere, JPG is usually the better target. No image was uploaded.',
        ],
    ],

    'word-counter' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'Word counters differ on the tricky cases, so here is what this one does. We typed each sample and noted the count. Your text stays in your browser: 0 bytes were sent.',
        ],
        'table' => [
            'headers' => ['Text', 'Words counted', 'Why'],
            'rows' => [
                ['The quick brown fox jumps over the lazy dog.', '9', 'Plain sentence'],
                ['A state-of-the-art tool.', '3', 'A hyphenated term is one word'],
                ['Don\'t stop, it\'s fine.', '4', 'A contraction is one word'],
                ['In 2026 we paid 1,250.50 dollars.', '6', 'A number is one word'],
                ['Die Bachelorarbeit ist z. B. lang.', '6', 'A compound is one word; "z. B." is two'],
            ],
        ],
    ],

    'qr-code-generator' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'We made a QR code for a web address. The PNG download was 512 x 512 pixels and 8.6 KB, and the SVG download is vector, so it stays sharp at any print size. Scan a test print before you order a large batch.',
        ],
    ],

    'json-formatter' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'We pasted JSON with a stray comma at the end of an object. The tool pointed to the exact place and said what to do: "Invalid JSON: Expected double-quoted property name in JSON at position 31 (line 1, column 32). Remove the trailing comma before this bracket." With the comma removed, it reported "Valid JSON". Your JSON stays in your browser: 0 bytes were sent.',
        ],
    ],

    'password-generator' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'At the default settings, 16 characters using uppercase, lowercase, numbers and symbols, the tool showed 104 bits of entropy. No request sent the password anywhere: the network log showed 0 bytes uploaded.',
        ],
    ],

    'domain-authority-checker' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'We checked two very different sites. Our own new site has no score yet, which is normal for a young site with few links, so "Not found" does not mean anything is wrong. This tool does use our server: the request carried only the domain names, 50 bytes in this test.',
        ],
        'table' => [
            'headers' => ['Domain', 'Score (0-10)', 'Global rank', 'Referring domains'],
            'rows' => [['wikipedia.org', '9.63', '#36', '627,034'], ['ilovemytools.store', 'Not found', '-', '-']],
        ],
        'limits' => ['Up to 100 domains at a time.'],
    ],

    'domain-age-checker' => [
        'tested' => '2026-11-04',
        'paragraphs' => [
            'We looked up wikipedia.org. The tool reported it was created on January 13, 2001, an age of 25 years, 9 months and 22 days on the test date, along with its expiry, last update, registrar, status and nameservers. This tool does use our server: the request carried only the domain name.',
        ],
        'limits' => ['Up to 20 domains at a time.'],
    ],

];
