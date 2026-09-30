<?php

/*
|--------------------------------------------------------------------------
| Tool registry - the single source of truth for every tool page
|--------------------------------------------------------------------------
| The array key is the URL slug: 'word-counter' => https://yoursite.com/word-counter
|
| To add a tool:
|   1. Add an entry here (SEO text, FAQs, related tools)
|   2. Create resources/js/tools/YourTool.jsx
|   3. Register it in resources/js/tools/index.js with the same slug
| The page, sitemap entry, schema markup and internal links are generated
| automatically.
|
| SEO rules used for every entry:
|   - title: max ~60 characters, main keyword first, brand added automatically
|   - description: 140-160 characters, includes the keyword + a benefit
|   - h1: the exact main keyword people search for
|   - faqs: real questions people ask (shown on page + FAQPage schema)
*/

return [

    'word-counter' => [
        'name' => 'Word Counter',
        'category' => 'text-tools',
        'icon' => 'text',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'Word Counter - Count Words & Characters Online Free',
        'description' => 'Free online word counter. Count words, characters, sentences and paragraphs instantly, and see reading time and keyword density. No sign up needed.',
        'h1' => 'Word Counter',
        'tagline' => 'Count words, characters, sentences and reading time instantly.',
        'keywords' => ['word counter', 'character counter', 'word count', 'count words online', 'reading time calculator'],
        'intro' => 'A word counter is a tool that counts the words, characters, sentences and paragraphs in a piece of text. Paste or type your text below to count words, characters, sentences and paragraphs as you type. The word counter also shows estimated reading and speaking time plus your most used keywords, which is handy for essays, blog posts, social media captions and SEO meta descriptions.',
        'steps' => [
            'Type or paste your text into the box.',
            'Watch the word, character, sentence and paragraph counts update live.',
            'Check reading time, speaking time and keyword density below the box.',
            'Use Copy or Clear when you are done.',
        ],
        'features' => [
            'Live word, character, sentence and paragraph counts',
            'Characters with and without spaces',
            'Reading time (238 wpm) and speaking time (150 wpm)',
            'Top keyword density to avoid overusing words',
            'Works offline once loaded - your text is never uploaded',
        ],
        'content' => [
            [
                'heading' => 'Why word count matters',
                'body' => 'Schools, universities and publishers often set strict word limits, and social platforms cap the number of characters you can post. Search engines typically show around 155-160 characters of a meta description, and a title tag should stay under about 60 characters. Knowing your exact count helps you hit these targets without guesswork.',
            ],
            [
                'heading' => 'How words are counted',
                'body' => 'A word is any group of letters or numbers separated by spaces or line breaks. Punctuation on its own is not counted as a word. Sentences are counted by ending punctuation (. ! ?) and paragraphs by blank lines, so the numbers match what you would expect from word processors like Microsoft Word and Google Docs.',
            ],
        ],
        'faqs' => [
            ['q' => 'Is this word counter free?', 'a' => 'Yes. The word counter is completely free with no sign up and no limits on how much text you paste.'],
            ['q' => 'Is my text saved or uploaded?', 'a' => 'No. Counting happens entirely in your browser. Your text is never sent to our server or stored anywhere.'],
            ['q' => 'How is reading time calculated?', 'a' => 'Reading time uses an average adult silent reading speed of 238 words per minute. Speaking time uses 150 words per minute, a typical pace for presentations.'],
            ['q' => 'How many words is a 5 page essay?', 'a' => 'With double spacing and a 12pt font, one page is roughly 250-300 words, so a 5 page essay is about 1,250-1,500 words.'],
            ['q' => 'Does it count characters with spaces?', 'a' => 'Yes. You get both characters with spaces and characters without spaces, which is what most character limits refer to.'],
        ],
        'sources' => [
            ['title' => 'Brysbaert (2019), "How many words do we read per minute?", Journal of Memory and Language', 'url' => 'https://doi.org/10.1016/j.jml.2019.104047'],
        ],
        'related' => ['case-converter', 'json-formatter', 'password-generator'],
    ],

    'case-converter' => [
        'name' => 'Case Converter',
        'category' => 'text-tools',
        'icon' => 'text',
        'popular' => false,
        'updated' => '2026-09-30',
        'title' => 'Case Converter - Uppercase, Lowercase & Title Case',
        'description' => 'Convert text to UPPERCASE, lowercase, Title Case, Sentence case, camelCase, snake_case and more. Free online case converter, instant and private.',
        'h1' => 'Case Converter',
        'tagline' => 'Change text to upper, lower, title, sentence, camel or snake case in one click.',
        'keywords' => ['case converter', 'uppercase to lowercase', 'title case converter', 'sentence case', 'camelcase converter'],
        'intro' => 'A case converter is a tool that changes the capitalisation of text, for example from UPPERCASE to lowercase or Title Case. Accidentally typed with Caps Lock on, or need a heading in Title Case? Paste your text and click a button to convert it instantly. Developers can also switch between camelCase, PascalCase, snake_case, kebab-case and CONSTANT_CASE.',
        'steps' => [
            'Paste your text into the box.',
            'Click the case you want, for example Title Case or lowercase.',
            'Copy the converted text or download it as a .txt file.',
        ],
        'features' => [
            'UPPERCASE, lowercase, Title Case and Sentence case',
            'camelCase, PascalCase, snake_case, kebab-case, CONSTANT_CASE',
            'aLtErNaTiNg and InVeRsE case for fun posts',
            'Smart Title Case that keeps small words like "and" and "of" lowercase',
            'Copy or download the result',
        ],
        'content' => [
            [
                'heading' => 'Title Case vs Sentence case',
                'body' => 'Title Case capitalises the main words of a heading ("The Quick Guide to SEO"), while short words such as a, and, of and the stay lowercase unless they start the title. Sentence case only capitalises the first word of each sentence ("The quick guide to SEO"), which many modern websites prefer for readability.',
            ],
            [
                'heading' => 'Programming case styles',
                'body' => 'camelCase is common for JavaScript variables, PascalCase for class names, snake_case for Python and database columns, kebab-case for URLs and CSS classes, and CONSTANT_CASE for constants and environment variables.',
            ],
        ],
        'faqs' => [
            ['q' => 'How do I convert uppercase to lowercase?', 'a' => 'Paste your text and click "lowercase". Every letter is converted instantly, and you can copy the result with one click.'],
            ['q' => 'Does Title Case capitalise every word?', 'a' => 'No. It follows common style guides and keeps small words (a, an, the, and, but, or, of, in, on, at, to, for) lowercase unless they are the first or last word.'],
            ['q' => 'Is there a limit on text length?', 'a' => 'No practical limit. Conversion happens in your browser, so even long documents convert instantly.'],
            ['q' => 'Does it work with accented letters?', 'a' => 'Yes. Accented and non-English letters such as é, ü and ñ are converted correctly.'],
        ],
        'related' => ['word-counter', 'base64-encoder-decoder', 'json-formatter'],
    ],

    'password-generator' => [
        'name' => 'Password Generator',
        'category' => 'generators',
        'icon' => 'lock',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'Password Generator - Strong Random Passwords Free',
        'description' => 'Generate strong, random passwords with custom length, symbols and numbers. Created securely on your device and never sent anywhere. Free and instant.',
        'h1' => 'Strong Password Generator',
        'tagline' => 'Create secure, random passwords in one click - generated on your device.',
        'keywords' => ['password generator', 'strong password generator', 'random password generator', 'secure password'],
        'intro' => 'A password generator is a tool that creates random, hard-to-guess passwords from the characters you choose. Create a strong, random password that is almost impossible to guess. Choose the length and which characters to include, and the generator uses your browser\'s cryptographically secure random number generator. Passwords are never sent to our server.',
        'steps' => [
            'Choose a password length (16 or more is recommended).',
            'Tick the character types to include: uppercase, lowercase, numbers and symbols.',
            'Click Generate, then Copy to use your new password.',
        ],
        'features' => [
            'Length from 4 to 128 characters',
            'Uppercase, lowercase, numbers and symbols',
            'Option to exclude look-alike characters (l, 1, I, O, 0)',
            'Strength meter based on real entropy',
            'Uses crypto.getRandomValues - secure and unbiased',
        ],
        'content' => [
            [
                'heading' => 'What makes a password strong?',
                'body' => 'Length matters most. Every extra character multiplies the number of possible combinations. A 16 character password using upper and lowercase letters, numbers and symbols has more than 100 bits of entropy, which would take billions of years to brute-force with current hardware.',
            ],
            [
                'heading' => 'Password safety tips',
                'body' => 'Use a different password for every account, store them in a password manager, and turn on two-factor authentication wherever it is offered. Never reuse a password that has appeared in a data breach.',
            ],
        ],
        'faqs' => [
            ['q' => 'Is this password generator safe?', 'a' => 'Yes. Passwords are generated in your browser using the Web Crypto API. Nothing is sent to our server, logged or stored.'],
            ['q' => 'How long should my password be?', 'a' => 'At least 15 characters, which is the minimum in NIST\'s current password guidelines (SP 800-63B), and 16 or more for important accounts like email and banking.'],
            ['q' => 'What does "exclude similar characters" do?', 'a' => 'It removes characters that look alike, such as l, 1, I, O and 0, so the password is easier to read and type by hand.'],
            ['q' => 'What is password entropy?', 'a' => 'Entropy measures how unpredictable a password is, in bits. Each extra bit doubles the guesses an attacker needs. 80+ bits is strong and 100+ bits is excellent.'],
        ],
        'sources' => [
            ['title' => 'NIST SP 800-63B: Digital Identity Guidelines, Authentication', 'url' => 'https://pages.nist.gov/800-63-4/sp800-63b.html'],
            ['title' => 'MDN: Crypto.getRandomValues()', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues'],
        ],
        'related' => ['qr-code-generator', 'base64-encoder-decoder', 'what-is-my-ip'],
        'table' => [
            'caption' => 'Password length and strength (entropy in bits)',
            'headers' => ['Length', 'Letters and numbers (62 characters)', 'Letters, numbers and symbols (89 characters)'],
            'rows' => [
                ['8', '48', '52'],
                ['12', '71', '78'],
                ['16', '95', '104'],
                ['20', '119', '130'],
                ['32', '191', '207'],
            ],
        ],
    ],

    'qr-code-generator' => [
        'name' => 'QR Code Generator',
        'category' => 'generators',
        'icon' => 'qr',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'QR Code Generator - Free QR Codes for URL, WiFi & More',
        'description' => 'Create free QR codes for links, text, Wi-Fi, email, phone and SMS. Custom colours and sizes, download PNG or SVG. No sign up and codes never expire.',
        'h1' => 'Free QR Code Generator',
        'tagline' => 'Make QR codes for links, Wi-Fi, email, phone and SMS. Download PNG or SVG.',
        'keywords' => ['qr code generator', 'free qr code generator', 'wifi qr code', 'qr code maker', 'qr code for url'],
        'intro' => 'A QR code generator is a tool that turns a link, text or Wi-Fi details into a square barcode that phone cameras can scan. Create a QR code for a website link, plain text, Wi-Fi network, email, phone number or SMS in seconds. Pick your colours and size, then download a high-quality PNG for screens or an SVG for print. These are static QR codes, so they work forever and never expire.',
        'steps' => [
            'Choose the QR code type: URL, Text, Wi-Fi, Email, Phone or SMS.',
            'Fill in the details. The preview updates as you type.',
            'Adjust size, colours and error correction if you like.',
            'Download as PNG or SVG and test it with your phone camera.',
        ],
        'features' => [
            'URL, text, Wi-Fi, email, phone and SMS QR codes',
            'Custom foreground and background colours',
            'Sizes from 128px to 1024px',
            'Error correction levels L, M, Q and H',
            'PNG and SVG download - free for commercial use',
            'Static codes that never expire, with no tracking',
        ],
        'content' => [
            [
                'heading' => 'How to make a Wi-Fi QR code',
                'body' => 'Choose the Wi-Fi type, enter your network name (SSID), password and security type. Guests can then scan the code with their phone camera to join your network without typing the password, which is perfect for homes, cafés and offices.',
            ],
            [
                'heading' => 'Tips for QR codes that always scan',
                'body' => 'Keep strong contrast with a dark code on a light background, leave the quiet-zone margin around the code, and print it at least 2 x 2 cm (0.8 x 0.8 inches). Use a higher error correction level if the code may get scratched or dirty.',
            ],
        ],
        'faqs' => [
            ['q' => 'Do these QR codes expire?', 'a' => 'No. They are static QR codes with your data encoded directly, so they keep working forever and do not depend on our website.'],
            ['q' => 'Can I use the QR codes commercially?', 'a' => 'Yes. You can use generated QR codes on flyers, packaging, menus and business cards for free.'],
            ['q' => 'Should I download PNG or SVG?', 'a' => 'PNG is best for websites and documents. SVG is a vector format that stays sharp at any size, which is ideal for printing.'],
            ['q' => 'What is error correction?', 'a' => 'Error correction lets a QR code still scan when part of it is damaged. Level L restores about 7% of the code and level H about 30%, but higher levels make the code denser.'],
            ['q' => 'Why will my QR code not scan?', 'a' => 'Usually the colours are too similar or inverted (light code on dark background). Use a dark code on a light background with good contrast.'],
        ],
        'sources' => [
            ['title' => 'DENSO WAVE: QR Code error correction levels', 'url' => 'https://www.qrcode.com/en/about/error_correction.html'],
        ],
        'related' => ['password-generator', 'image-resizer', 'what-is-my-ip'],
        'table' => [
            'caption' => 'QR code error correction levels',
            'headers' => ['Level', 'Restores up to', 'Good for'],
            'rows' => [
                ['L', '7%', 'Clean screens and codes holding a lot of data'],
                ['M', '15%', 'Most everyday uses (the most common choice)'],
                ['Q', '25%', 'Printed codes that may get dirty'],
                ['H', '30%', 'Harsh conditions, such as factory labels'],
            ],
        ],
    ],

    'image-compressor' => [
        'name' => 'Image Compressor',
        'category' => 'image-tools',
        'icon' => 'image',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'Image Compressor - Compress JPG, PNG & WebP Online',
        'description' => 'Compress JPG, PNG and WebP images online for free. Reduce image size to 100KB or any target size with no visible quality loss. Images never leave your device.',
        'h1' => 'Image Compressor',
        'tagline' => 'Reduce JPG, PNG and WebP file sizes - even to an exact size like 100KB.',
        'keywords' => ['image compressor', 'compress image', 'compress image to 100kb', 'reduce image size', 'compress jpg'],
        'intro' => 'An image compressor is a tool that makes image files smaller while keeping them looking the same. Make your images smaller without losing visible quality. Drop in one or many JPG, PNG or WebP files, choose a quality level or a target size such as 100KB, and download the compressed images. Compression happens in your browser, so your photos are never uploaded.',
        'steps' => [
            'Drag and drop images or click to choose files (JPG, PNG or WebP).',
            'Pick a quality level, or set a target size such as 100 KB.',
            'Optionally choose an output format and maximum width.',
            'Download each image or all of them as a ZIP.',
        ],
        'features' => [
            'Batch compress up to 30 images at once',
            'Target file size mode, for example "compress to 100KB"',
            'Convert to WebP for the biggest savings',
            'Optional maximum width to shrink huge photos',
            'Before and after file sizes with % saved',
            '100% private - processed in your browser',
        ],
        'content' => [
            [
                'heading' => 'Why compress images?',
                'body' => 'Large images are the most common reason web pages load slowly, and page speed is a Google ranking factor. Smaller images also upload faster to forms and job portals that set limits such as 100KB, 200KB or 1MB.',
            ],
            [
                'heading' => 'Which format should I choose?',
                'body' => 'JPG is best for photos. PNG keeps transparency and sharp edges for logos and screenshots, but its files are large. WebP gives the smallest files for both photos and graphics and is supported by all modern browsers.',
            ],
        ],
        'faqs' => [
            ['q' => 'How do I compress an image to 100KB?', 'a' => 'Choose "Target size", enter 100 and click Compress. The tool finds the best quality that fits under 100KB and only scales the image down if it has to.'],
            ['q' => 'Are my images uploaded to a server?', 'a' => 'No. Images are compressed inside your browser using the Canvas API. They never leave your device.'],
            ['q' => 'Will compression reduce quality?', 'a' => 'At the default quality (75%) most people cannot see a difference, while file size often drops by 50-80%.'],
            ['q' => 'Why did my PNG barely get smaller?', 'a' => 'PNG is a lossless format. For big savings, set the output format to WebP or JPG. Use WebP if you need to keep transparency.'],
            ['q' => 'Is there a file size limit?', 'a' => 'Each image can be up to 50MB. Very large photos may take a few seconds on older phones.'],
        ],
        'sources' => [
            ['title' => 'Google for Developers: An image format for the Web (WebP)', 'url' => 'https://developers.google.com/speed/webp'],
        ],
        'related' => ['image-resizer', 'merge-pdf', 'qr-code-generator'],
        'table' => [
            'caption' => 'Which image format to use',
            'headers' => ['Format', 'Best for', 'Transparency'],
            'rows' => [
                ['JPG', 'Photos', 'No'],
                ['PNG', 'Logos, screenshots, sharp graphics', 'Yes'],
                ['WebP', 'Websites (smallest files for photos and graphics)', 'Yes'],
            ],
        ],
    ],

    'image-resizer' => [
        'name' => 'Image Resizer',
        'category' => 'image-tools',
        'icon' => 'resize',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'Image Resizer - Resize & Convert JPG, PNG, WebP Free',
        'description' => 'Resize images to exact pixels or by percentage and convert between JPG, PNG and WebP. Free online image resizer that keeps your photos private.',
        'h1' => 'Image Resizer & Converter',
        'tagline' => 'Resize to exact pixels or a percentage, and convert JPG, PNG and WebP.',
        'keywords' => ['image resizer', 'resize image', 'png to jpg', 'jpg to png', 'webp to jpg', 'image converter'],
        'intro' => 'An image resizer is a tool that changes the width and height of a picture, and a converter changes its file format. Resize a photo to exact dimensions for social media, a passport form or your website, or scale it by percentage. You can also convert the format, for example PNG to JPG or WebP to PNG. Everything happens in your browser.',
        'steps' => [
            'Choose or drop an image (JPG, PNG, WebP, GIF or BMP).',
            'Enter a new width and height, or pick a percentage.',
            'Choose the output format and quality.',
            'Click Download to save your resized image.',
        ],
        'features' => [
            'Resize by pixels or percentage',
            'Lock aspect ratio to avoid stretching',
            'Convert between JPG, PNG and WebP',
            'Quality control for JPG and WebP',
            'Live preview with the new file size',
        ],
        'content' => [
            [
                'heading' => 'Common image sizes',
                'body' => 'Instagram posts work well at 1080 x 1080 pixels, Facebook and LinkedIn share images at 1200 x 630, YouTube thumbnails at 1280 x 720, and website hero images usually need no more than 1920 pixels wide.',
            ],
            [
                'heading' => 'Converting PNG to JPG',
                'body' => 'JPG does not support transparency, so transparent areas are filled with white when you convert a PNG to JPG. If you need to keep transparency, choose PNG or WebP as the output format.',
            ],
        ],
        'faqs' => [
            ['q' => 'How do I resize an image without stretching it?', 'a' => 'Keep "Lock aspect ratio" ticked. When you change the width, the height updates automatically to keep the original proportions.'],
            ['q' => 'Can I convert WebP to JPG?', 'a' => 'Yes. Open your WebP image, choose JPG as the output format and download.'],
            ['q' => 'Does resizing reduce quality?', 'a' => 'Making an image smaller keeps it sharp. Making it much larger than the original can look blurry because no new detail can be created.'],
            ['q' => 'What is the maximum size?', 'a' => 'Output images can be up to 10,000 pixels on each side, which is within what all modern browsers can handle.'],
        ],
        'sources' => [
            ['title' => 'Google for Developers: An image format for the Web (WebP)', 'url' => 'https://developers.google.com/speed/webp'],
        ],
        'related' => ['image-compressor', 'qr-code-generator', 'merge-pdf'],
        'table' => [
            'caption' => 'Common image sizes',
            'headers' => ['Use', 'Size (pixels)'],
            'rows' => [
                ['Instagram square post', '1080 × 1080'],
                ['Facebook and LinkedIn shared image', '1200 × 630'],
                ['YouTube thumbnail', '1280 × 720'],
                ['Full-width website image', 'up to 1920 wide'],
            ],
        ],
    ],

    'merge-pdf' => [
        'name' => 'Merge PDF',
        'category' => 'pdf-tools',
        'icon' => 'pdf',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'Merge PDF - Combine PDF Files Online Free',
        'description' => 'Merge PDF files into one document online for free. Reorder files, no watermark, no sign up. PDFs are combined in your browser and never uploaded.',
        'h1' => 'Merge PDF Files',
        'tagline' => 'Combine multiple PDFs into one file - no watermark, no upload.',
        'keywords' => ['merge pdf', 'combine pdf', 'join pdf files', 'pdf merger', 'merge pdf online free'],
        'intro' => 'Merging PDFs means combining several PDF files into a single document. Combine several PDF files into a single document in the order you choose. Unlike many PDF sites, your files are merged inside your browser, so confidential documents never touch a server, and there is no watermark on the result.',
        'steps' => [
            'Add two or more PDF files by dropping them or clicking to browse.',
            'Put them in the right order with the up and down arrows.',
            'Click Merge PDF.',
            'Download your combined PDF.',
        ],
        'features' => [
            'Merge up to 50 PDF files at once',
            'Reorder or remove files before merging',
            'Shows the page count of each file',
            'No watermark and no page limits',
            'Private - files never leave your device',
        ],
        'content' => [
            [
                'heading' => 'Why merge PDFs?',
                'body' => 'Many job applications, visa forms and university portals only accept a single file. Merging your CV, cover letter and certificates into one PDF keeps everything together and in the right order.',
            ],
            [
                'heading' => 'Password-protected PDFs',
                'body' => 'Encrypted PDFs cannot be merged until the password protection is removed. Open the file in your PDF reader with the password and save or print a copy without protection, then merge that copy.',
            ],
        ],
        'faqs' => [
            ['q' => 'Is it safe to merge PDFs here?', 'a' => 'Yes. Files are processed locally in your browser with JavaScript and are never uploaded, so they stay completely private.'],
            ['q' => 'Is there a watermark?', 'a' => 'No. The merged PDF has no watermark, logo or added pages.'],
            ['q' => 'How many PDFs can I merge?', 'a' => 'Up to 50 files at a time. The practical limit depends on your device memory, and most devices handle a few hundred pages easily.'],
            ['q' => 'Will links and bookmarks be kept?', 'a' => 'Page content, images and text are kept exactly. Some interactive features such as bookmarks and form fields may not carry over.'],
        ],
        'related' => ['split-pdf', 'image-compressor', 'image-resizer'],
    ],

    'split-pdf' => [
        'name' => 'Split PDF',
        'category' => 'pdf-tools',
        'icon' => 'scissors',
        'popular' => false,
        'updated' => '2026-09-30',
        'title' => 'Split PDF - Extract Pages from PDF Online Free',
        'description' => 'Split a PDF into separate files or extract specific pages online for free. Select page ranges like 1-3, 5. No upload, no watermark, no sign up.',
        'h1' => 'Split PDF & Extract Pages',
        'tagline' => 'Extract pages or split a PDF into separate files - privately in your browser.',
        'keywords' => ['split pdf', 'extract pages from pdf', 'separate pdf pages', 'pdf splitter', 'split pdf online'],
        'intro' => 'Splitting a PDF means taking pages out of a document or dividing it into several smaller PDF files. Pull out just the pages you need from a PDF, or split it into separate files. Type page ranges such as 1-3, 5, 8-10, or split every page into its own PDF. Processing happens entirely in your browser.',
        'steps' => [
            'Choose the PDF you want to split.',
            'Pick a mode: extract pages into one PDF, split by ranges, or split every page.',
            'Enter page ranges, for example 1-3, 5, 8-10.',
            'Click Split PDF and download the result (multiple files come as a ZIP).',
        ],
        'features' => [
            'Extract selected pages into a new PDF',
            'Split by custom ranges into separate files',
            'Split every page into its own PDF',
            'Multiple files are bundled into a ZIP',
            'No watermark, no upload',
        ],
        'content' => [
            [
                'heading' => 'How to write page ranges',
                'body' => 'Separate ranges with commas. Use a hyphen for a range of pages, such as 1-5, or a single number for one page. For example, "1-3, 7, 10-12" selects pages 1, 2, 3, 7, 10, 11 and 12.',
            ],
        ],
        'faqs' => [
            ['q' => 'How do I extract one page from a PDF?', 'a' => 'Choose "Extract pages", type the page number (for example 4) and click Split PDF. You get a new PDF containing just that page.'],
            ['q' => 'Can I split every page into a separate file?', 'a' => 'Yes. Choose "Split every page" and you get a ZIP with one PDF per page.'],
            ['q' => 'Are my files uploaded?', 'a' => 'No. The PDF is split locally in your browser and never leaves your device.'],
            ['q' => 'Does splitting reduce quality?', 'a' => 'No. Pages are copied exactly as they are, so text and images keep their original quality.'],
        ],
        'related' => ['merge-pdf', 'image-compressor', 'word-counter'],
    ],

    'age-calculator' => [
        'name' => 'Age Calculator',
        'category' => 'calculators',
        'icon' => 'calendar',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'Age Calculator - Calculate Exact Age from Date of Birth',
        'description' => 'Calculate your exact age in years, months and days from your date of birth. See total days lived and a countdown to your next birthday. Free and instant.',
        'h1' => 'Age Calculator',
        'tagline' => 'Find your exact age in years, months and days, plus your next birthday.',
        'keywords' => ['age calculator', 'calculate age', 'date of birth calculator', 'how old am i', 'age calculator by date of birth'],
        'intro' => 'An age calculator works out exactly how old someone is, in years, months and days, from their date of birth. Enter a date of birth to find the exact age in years, months and days. You also get the total number of months, weeks, days and hours lived, the day of the week you were born and a countdown to your next birthday. You can also calculate age on any past or future date.',
        'steps' => [
            'Enter the date of birth.',
            'Keep today as the "age at" date, or choose another date.',
            'See the exact age and details instantly.',
        ],
        'features' => [
            'Exact age in years, months and days',
            'Total months, weeks, days and hours',
            'Countdown to the next birthday',
            'Day of the week you were born',
            'Handles leap years and 29 February birthdays',
        ],
        'content' => [
            [
                'heading' => 'How age is calculated',
                'body' => 'The calculator counts complete years first, then complete months, then the remaining days, which is the same method used on official forms. Leap years are handled automatically, and people born on 29 February celebrate on 28 February in non-leap years.',
            ],
        ],
        'faqs' => [
            ['q' => 'How do I calculate my exact age?', 'a' => 'Enter your date of birth and the calculator shows your age in years, months and days as of today, or as of any date you choose.'],
            ['q' => 'Can I calculate age on a specific date?', 'a' => 'Yes. Change the "Age at" date to see how old someone was or will be on that day, which is useful for school admissions and exam eligibility.'],
            ['q' => 'How are leap years handled?', 'a' => 'Leap years are counted exactly. For a 29 February birthday, the next birthday in a non-leap year is shown as 28 February.'],
            ['q' => 'Is my date of birth stored?', 'a' => 'No. The calculation runs in your browser and nothing is saved or sent anywhere.'],
        ],
        'related' => ['percentage-calculator', 'word-counter', 'password-generator'],
    ],

    'percentage-calculator' => [
        'name' => 'Percentage Calculator',
        'category' => 'calculators',
        'icon' => 'percent',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'Percentage Calculator - Percent, Change & Increase',
        'description' => 'Free percentage calculator: find X% of Y, what percent X is of Y, percentage increase or decrease, and add or subtract a percentage. Shows the formula.',
        'h1' => 'Percentage Calculator',
        'tagline' => 'Every common percentage calculation in one place, with the formula shown.',
        'keywords' => ['percentage calculator', 'percent calculator', 'percentage change calculator', 'percentage increase calculator', 'what percent of'],
        'intro' => 'A percentage calculator works out percentages, such as X% of Y or the percentage change between two numbers. Work out percentages quickly: what is 15% of 200, what percent 30 is of 120, the percentage increase from 80 to 100, and more. Each calculator shows the formula it used, so you can check the working for homework, discounts, tips, grades and business reports.',
        'steps' => [
            'Find the calculator that matches your question.',
            'Type your numbers into the boxes.',
            'Read the answer and the formula underneath.',
        ],
        'features' => [
            'What is X% of Y',
            'X is what percent of Y',
            'Percentage increase or decrease from X to Y',
            'X is Y% of what number',
            'Increase or decrease a number by a percentage',
            'Formula shown for every answer',
        ],
        'content' => [
            [
                'heading' => 'Percentage formulas',
                'body' => 'X% of Y = (X / 100) x Y. X as a percent of Y = (X / Y) x 100. Percentage change from A to B = ((B - A) / |A|) x 100. A positive result is an increase and a negative result is a decrease.',
            ],
        ],
        'faqs' => [
            ['q' => 'How do I calculate a percentage of a number?', 'a' => 'Divide the percentage by 100 and multiply by the number. For example, 15% of 200 = 0.15 x 200 = 30.'],
            ['q' => 'How do I calculate percentage increase?', 'a' => 'Subtract the old value from the new value, divide by the old value and multiply by 100. From 80 to 100: (100 - 80) / 80 x 100 = 25%.'],
            ['q' => 'How do I work out a discount?', 'a' => 'Use "Decrease a number by a percentage". For 20% off $50, the sale price is $50 x (1 - 0.20) = $40.'],
            ['q' => 'Why can\'t I calculate change from zero?', 'a' => 'Percentage change divides by the starting value, and dividing by zero is undefined, so a change from 0 cannot be expressed as a percentage.'],
        ],
        'related' => ['age-calculator', 'word-counter', 'json-formatter'],
        'table' => [
            'caption' => 'Percentage formulas with examples',
            'headers' => ['Question', 'Formula', 'Example'],
            'rows' => [
                ['What is X% of Y?', '(X / 100) × Y', '15% of 200 = 30'],
                ['X is what % of Y?', '(X / Y) × 100', '30 of 120 = 25%'],
                ['% change from A to B', '(B − A) / |A| × 100', '80 → 100 = +25%'],
                ['Increase Y by X%', 'Y × (1 + X / 100)', '50 + 20% = 60'],
                ['Decrease Y by X%', 'Y × (1 − X / 100)', '50 − 20% = 40'],
            ],
        ],
    ],

    'json-formatter' => [
        'name' => 'JSON Formatter',
        'category' => 'developer-tools',
        'icon' => 'code',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'JSON Formatter & Validator - Beautify JSON Online',
        'description' => 'Format, beautify, validate and minify JSON online for free. Finds errors with exact line and column numbers. Fast, private JSON formatter for developers.',
        'h1' => 'JSON Formatter & Validator',
        'tagline' => 'Beautify, validate and minify JSON with clear error messages.',
        'keywords' => ['json formatter', 'json validator', 'json beautifier', 'format json', 'json minify'],
        'intro' => 'A JSON formatter is a tool that makes JSON data readable with line breaks and indentation, and checks that it is valid. Paste JSON to beautify it with clean indentation, validate it, or minify it for production. If the JSON is invalid, you get a clear error message with the exact line and column, so you can fix it fast. Your data is processed locally and never sent anywhere.',
        'steps' => [
            'Paste your JSON into the input box, or click Sample.',
            'Click Format to beautify, or Minify to compress.',
            'Fix any errors using the line and column shown.',
            'Copy or download the result.',
        ],
        'features' => [
            'Beautify with 2 spaces, 4 spaces or tabs',
            'Minify JSON to a single line',
            'Validation with line and column of the error',
            'Optional alphabetical key sorting',
            'Copy and download as .json',
        ],
        'content' => [
            [
                'heading' => 'Common JSON errors',
                'body' => 'The most common mistakes are trailing commas after the last item, single quotes instead of double quotes, unquoted keys, and comments, none of which are allowed in standard JSON.',
            ],
        ],
        'faqs' => [
            ['q' => 'Is my JSON sent to a server?', 'a' => 'No. Formatting and validation run in your browser, so API keys and private data stay on your machine.'],
            ['q' => 'What is the difference between format and minify?', 'a' => 'Format adds line breaks and indentation to make JSON readable. Minify removes all unnecessary whitespace to make the file as small as possible.'],
            ['q' => 'Why does my JSON show an error?', 'a' => 'Check the line and column in the message. Trailing commas, single quotes and missing quotes around keys are the usual causes.'],
            ['q' => 'Can it handle large files?', 'a' => 'Yes. Files of several megabytes format in well under a second on most devices.'],
        ],
        'sources' => [
            ['title' => 'RFC 8259: The JavaScript Object Notation (JSON) Data Interchange Format', 'url' => 'https://www.rfc-editor.org/rfc/rfc8259'],
        ],
        'related' => ['base64-encoder-decoder', 'case-converter', 'what-is-my-ip'],
        'table' => [
            'caption' => 'Common JSON errors and how to fix them',
            'headers' => ['Problem', 'Invalid', 'Valid'],
            'rows' => [
                ['Trailing comma', '{"a": 1,}', '{"a": 1}'],
                ['Single quotes', '{\'a\': 1}', '{"a": 1}'],
                ['Key without quotes', '{a: 1}', '{"a": 1}'],
                ['Comment', '{"a": 1 // note}', '{"a": 1}'],
            ],
        ],
    ],

    'base64-encoder-decoder' => [
        'name' => 'Base64 Encode / Decode',
        'category' => 'developer-tools',
        'icon' => 'code',
        'popular' => false,
        'updated' => '2026-09-30',
        'title' => 'Base64 Encode & Decode Online - Text and Files',
        'description' => 'Encode text or files to Base64 and decode Base64 back to text online. Full UTF-8 and URL-safe support. Free, fast and private Base64 converter.',
        'h1' => 'Base64 Encoder & Decoder',
        'tagline' => 'Encode and decode Base64 text and files, with UTF-8 and URL-safe support.',
        'keywords' => ['base64 encode', 'base64 decode', 'base64 converter', 'base64 to text', 'image to base64'],
        'intro' => 'Base64 is a way to write any data, including files, using only 64 plain text characters; encoding converts to Base64 and decoding converts back. Convert text to Base64 or decode Base64 back to readable text, with full support for emoji and non-English characters. You can also turn a file or image into a Base64 data URL for embedding in HTML, CSS or JSON.',
        'steps' => [
            'Choose Text or File mode.',
            'For text, paste your input and click Encode or Decode.',
            'For files, choose a file to get its Base64 string or data URL.',
            'Copy the result.',
        ],
        'features' => [
            'Encode and decode text with full UTF-8 support',
            'URL-safe Base64 option (- and _ instead of + and /)',
            'File and image to Base64 or data URL',
            'Clear error message for invalid Base64',
            'Runs locally - nothing is uploaded',
        ],
        'content' => [
            [
                'heading' => 'What is Base64?',
                'body' => 'Base64 represents binary data using 64 safe text characters (A-Z, a-z, 0-9, + and /). It is used to embed images in HTML and CSS, send attachments in email, and pass data in URLs and APIs. Base64 is an encoding, not encryption, so it does not keep data secret.',
            ],
        ],
        'faqs' => [
            ['q' => 'Is Base64 encryption?', 'a' => 'No. Anyone can decode Base64. Use it for transporting data, never for protecting passwords or secrets.'],
            ['q' => 'What is URL-safe Base64?', 'a' => 'A variant that replaces + with - and / with _, and usually drops = padding, so the string can be used safely in URLs and file names.'],
            ['q' => 'Why is Base64 larger than the original?', 'a' => 'Base64 turns every 3 bytes into 4 characters, so encoded data is about 33% larger than the original.'],
            ['q' => 'How do I convert an image to Base64?', 'a' => 'Switch to File mode and choose your image. You get both the raw Base64 string and a ready-to-use data URL.'],
        ],
        'sources' => [
            ['title' => 'RFC 4648: The Base16, Base32, and Base64 Data Encodings', 'url' => 'https://www.rfc-editor.org/rfc/rfc4648'],
        ],
        'related' => ['json-formatter', 'password-generator', 'case-converter'],
        'table' => [
            'caption' => 'How much bigger Base64 makes data',
            'headers' => ['Original size', 'Base64 length'],
            'rows' => [
                ['3 bytes', '4 characters'],
                ['1 KB (1,024 bytes)', '1,368 characters'],
                ['1 MB (1,048,576 bytes)', '1,398,104 characters'],
            ],
        ],
    ],

    'what-is-my-ip' => [
        'name' => 'What Is My IP',
        'category' => 'developer-tools',
        'icon' => 'globe',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'What Is My IP Address? Check Your Public IP Instantly',
        'description' => 'See your public IP address instantly, check if it is IPv4 or IPv6, and view your browser, operating system, screen size and time zone. Free IP lookup.',
        'h1' => 'What Is My IP Address?',
        'tagline' => 'Your public IP address and browser details, instantly.',
        'keywords' => ['what is my ip', 'my ip address', 'ip address lookup', 'check my ip', 'what is my ip address'],
        'intro' => 'An IP address is the number that identifies your connection on the internet; your public IP is the one websites see. Your public IP address is the address websites see when you connect to the internet. It is assigned by your internet provider, or by your VPN if you use one. Below you can see your current IP address, whether it is IPv4 or IPv6, and details about your browser and device.',
        'steps' => [
            'Open this page - your IP address is shown at the top.',
            'Click Copy to copy it to your clipboard.',
            'Turn a VPN on or off and click Refresh to see your IP change.',
        ],
        'features' => [
            'Public IP address with one-click copy',
            'IPv4 or IPv6 detection',
            'Browser, operating system and device type',
            'Screen resolution, language and time zone',
            'Refresh to check your VPN is working',
        ],
        'content' => [
            [
                'heading' => 'IPv4 vs IPv6',
                'body' => 'IPv4 addresses look like 203.0.113.42 and there are only about 4.3 billion of them. IPv6 addresses, such as 2001:db8::1, were introduced because IPv4 addresses ran out. Many connections now support both.',
            ],
            [
                'heading' => 'Public vs private IP address',
                'body' => 'Your router gives each device at home a private IP address (often 192.168.x.x). The whole network shares one public IP address on the internet, which is the one shown on this page.',
            ],
        ],
        'faqs' => [
            ['q' => 'What is my IP address used for?', 'a' => 'Websites and services use your IP address to send data back to you. It can also reveal your approximate city and your internet provider.'],
            ['q' => 'Why does my IP address change?', 'a' => 'Most home internet providers assign dynamic IP addresses that can change when your router restarts. Mobile data IPs change frequently.'],
            ['q' => 'How can I hide my IP address?', 'a' => 'Use a VPN or a privacy network such as Tor. Websites then see the VPN\'s IP address instead of yours.'],
            ['q' => 'Do you store my IP address?', 'a' => 'No. This tool only displays your IP address to you and does not save it in a database.'],
        ],
        'sources' => [
            ['title' => 'ARIN: IPv4 address depletion', 'url' => 'https://www.arin.net/resources/guide/ipv4/'],
        ],
        'related' => ['password-generator', 'json-formatter', 'base64-encoder-decoder'],
    ],

    'dice-roller' => [
        'name' => 'Dice Roller',
        'category' => 'games',
        'icon' => 'dice',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'Dice Roller - Roll Virtual Dice Online (D6, D20 & More)',
        'description' => 'Roll 1 to 10 virtual dice online: D4, D6, D8, D10, D12, D20 or D100. Fair, random results with a 3D rolling animation, totals and roll history. Free.',
        'h1' => 'Dice Roller',
        'tagline' => 'Roll up to 10 dice, from D4 to D100, with a 3D animation and totals.',
        'keywords' => ['dice roller', 'roll dice online', 'virtual dice', 'd20 roller', 'random dice'],
        'intro' => 'A dice roller is an online tool that simulates throwing dice and gives a random result for each die. Lost the dice for a board game, or need a D20 for tabletop role-playing? This free dice roller throws up to ten virtual dice at once with a realistic 3D animation. Choose a standard six-sided die or any polyhedral die from D4 to D100, and see every value, the total and your recent rolls instantly.',
        'steps' => [
            'Pick the type of dice: D4, D6, D8, D10, D12, D20 or D100.',
            'Choose how many dice to roll, from 1 to 10.',
            'Press Roll (or tap the dice, or press R on your keyboard).',
            'Read each value and the total. Earlier rolls are kept in the history list.',
        ],
        'features' => [
            'Seven dice types: D4, D6, D8, D10, D12, D20 and D100',
            'Roll up to 10 dice at once with an automatic total',
            '3D tumbling six-sided dice with real pip layouts',
            'Fair results from your browser\'s secure random number generator',
            'Roll history and keyboard shortcuts (R, Space or Enter)',
        ],
        'content' => [
            [
                'heading' => 'Is an online dice roller fair?',
                'body' => 'Yes. Every roll uses the Web Crypto API built into your browser, the same source of randomness used to create passwords and encryption keys. Each face has exactly the same chance of landing, and the result is decided before the animation starts, so the animation cannot influence it. Physical dice, by comparison, can be slightly unbalanced by rounded edges or drilled pips.',
            ],
            [
                'heading' => 'Which dice do games use?',
                'body' => 'Most family board games, such as Monopoly, Ludo and Yahtzee, use six-sided dice (D6). Tabletop role-playing games like Dungeons & Dragons use a full set of polyhedral dice: D4, D6, D8, D10, D12 and D20, with two D10s or a D100 for percentile rolls. You can switch between them here with one click.',
            ],
        ],
        'faqs' => [
            ['q' => 'How many dice can I roll at once?', 'a' => 'You can roll from 1 to 10 dice at the same time. The dice roller shows each value and adds up the total for you.'],
            ['q' => 'Are the dice rolls truly random?', 'a' => 'Yes. Rolls use your browser\'s cryptographically secure random number generator, so every face is equally likely and results cannot be predicted.'],
            ['q' => 'Can I roll a D20 for Dungeons & Dragons?', 'a' => 'Yes. Choose D20 from the dice types and press Roll. D4, D8, D10, D12 and D100 are available too.'],
            ['q' => 'Can I use the dice roller without the animation?', 'a' => 'If your device is set to reduce motion, results appear instantly without the rolling animation.'],
            ['q' => 'Does the dice roller work on phones?', 'a' => 'Yes. It works in any modern browser on phones, tablets and computers, and you can tap the dice to roll.'],
        ],
        'sources' => [
            ['title' => 'MDN: Crypto.getRandomValues()', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues'],
        ],
        'related' => ['coin-flip', 'spin-the-wheel', 'random-number-generator'],
        'table' => [
            'caption' => 'Dice types and what they are used for',
            'headers' => ['Die', 'Faces', 'Common use'],
            'rows' => [
                ['D4', '4', 'Small damage rolls in role-playing games'],
                ['D6', '6', 'Board games such as Monopoly and Ludo'],
                ['D8, D10, D12', '8, 10, 12', 'Damage and skill rolls in role-playing games'],
                ['D20', '20', 'Attack rolls and checks in Dungeons & Dragons'],
                ['D100', '100', 'Percentile rolls'],
            ],
        ],
    ],

    'coin-flip' => [
        'name' => 'Coin Flip',
        'category' => 'games',
        'icon' => 'coin',
        'popular' => false,
        'updated' => '2026-09-30',
        'title' => 'Coin Flip - Flip a Coin Online (Heads or Tails)',
        'description' => 'Flip a coin online for heads or tails with a realistic 3D animation. Flip up to 100 coins at once and track totals and streaks. Fair, free and instant.',
        'h1' => 'Flip a Coin',
        'tagline' => 'Heads or tails? Toss a 3D coin, or flip up to 100 at once and see the stats.',
        'keywords' => ['coin flip', 'flip a coin', 'heads or tails', 'coin toss online', 'virtual coin'],
        'intro' => 'A coin flip is a quick way to choose between two options at random: heads or tails, each with a 50% chance. Settle a decision, pick who goes first or run a probability experiment with this free online coin flip. Toss a single 3D coin that spins through the air, or flip up to 100 coins at once. The tool keeps a running count of heads and tails, the percentage split and your current streak.',
        'steps' => [
            'Choose how many coins to flip: 1, 2, 5, 10, 25 or 100.',
            'Press Flip (or tap the coin, or press F).',
            'See the result, plus running totals, the heads/tails split and your streak.',
            'Press Reset stats to start a fresh experiment.',
        ],
        'features' => [
            'Realistic 3D coin toss animation',
            'Flip up to 100 coins in one go',
            'Running totals, percentage split and current streak',
            'Exactly 50/50 odds from secure randomness',
            'Keyboard shortcut: F, Space or Enter',
        ],
        'content' => [
            [
                'heading' => 'Is a coin flip really 50/50?',
                'body' => 'A virtual coin flip here is exactly 50/50: each result comes from your browser\'s secure random number generator, with no memory of earlier flips. Real coins are very slightly biased towards the side facing up when tossed, which researchers have measured at around 51%. Streaks of five or six of the same side are normal and do not mean the coin is unfair.',
            ],
            [
                'heading' => 'Fun ways to use a coin toss',
                'body' => 'Coin flips are used to decide who kicks off a match, to break ties, to make a quick yes or no decision, and in classrooms to teach probability. Flip 100 coins at once to see the law of large numbers in action: the more flips you make, the closer the split gets to 50%.',
            ],
        ],
        'faqs' => [
            ['q' => 'Is this coin flip fair?', 'a' => 'Yes. Each flip has exactly a 50% chance of heads and 50% of tails, generated by your browser\'s cryptographically secure randomness.'],
            ['q' => 'Can I flip more than one coin?', 'a' => 'Yes. Choose 2, 5, 10, 25 or 100 coins and they are all flipped at once, with a count of heads and tails.'],
            ['q' => 'Why did I get heads five times in a row?', 'a' => 'Streaks are a normal part of randomness. The chance of five heads in a row is about 3%, so it happens regularly over many flips.'],
            ['q' => 'Does it keep my results?', 'a' => 'Totals and your streak are kept while the page is open. Nothing is sent to a server, and Reset stats clears them.'],
        ],
        'sources' => [
            ['title' => 'Bartoš et al. (2023), "Fair coins tend to land on the same side they started: evidence from 350,757 flips"', 'url' => 'https://arxiv.org/abs/2310.04153'],
        ],
        'related' => ['dice-roller', 'spin-the-wheel', 'random-number-generator'],
    ],

    'spin-the-wheel' => [
        'name' => 'Spin the Wheel',
        'category' => 'games',
        'icon' => 'wheel',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'Spin the Wheel - Random Name & Choice Picker',
        'description' => 'Spin a wheel to pick a random name, winner or choice. Add up to 100 entries, spin with a smooth animation and remove winners as you go. Free wheel spinner.',
        'h1' => 'Spin the Wheel',
        'tagline' => 'Add names or choices, spin, and let the wheel pick a random winner.',
        'keywords' => ['spin the wheel', 'wheel spinner', 'random name picker', 'wheel of names', 'random choice picker'],
        'intro' => 'Spin the wheel is a random picker: you add names or options, spin, and the wheel stops on one at random. Can\'t decide what to eat, who goes next or who wins the giveaway? Type your options into the list, one per line, and spin the wheel. It spins several times and eases to a stop on a random entry, then announces the winner. You can remove each winner automatically to draw names one by one without repeats.',
        'steps' => [
            'Type or paste your entries, one per line (up to 100).',
            'Press Spin, click the centre of the wheel, or press S.',
            'Watch the wheel slow down and stop on the winner.',
            'Optionally tick "Remove the winner after each spin" to draw without repeats.',
        ],
        'features' => [
            'Up to 100 entries, each with its own coloured slice',
            'Smooth spin that eases to a stop, with a winner announcement',
            'Remove winners automatically or with one click',
            'Shuffle the order of entries',
            'Every entry has exactly the same chance of winning',
        ],
        'content' => [
            [
                'heading' => 'How the wheel picks a winner',
                'body' => 'When you press Spin, the winner is chosen first using your browser\'s secure random number generator, giving every entry an equal chance regardless of the length of its name. The wheel then calculates exactly how far to turn so that the chosen slice stops under the pointer, adding several full turns and a random stopping point inside the slice so that every spin looks different.',
            ],
            [
                'heading' => 'Ideas for using a wheel spinner',
                'body' => 'Teachers use name wheels to pick students fairly, streamers and shops run giveaways with them, and friends use them to decide on restaurants, films or chores. Turn on "Remove the winner after each spin" to draw a running order, split people into teams, or pick several prize winners without anyone winning twice.',
            ],
        ],
        'faqs' => [
            ['q' => 'Is the wheel spinner random?', 'a' => 'Yes. The winner is picked with cryptographically secure randomness before the wheel stops, so every entry has an equal chance.'],
            ['q' => 'How many names can I add?', 'a' => 'You can add up to 100 entries. Put each one on its own line.'],
            ['q' => 'Can I remove a name after it wins?', 'a' => 'Yes. Click the Remove button after a spin, or tick "Remove the winner after each spin" to do it automatically.'],
            ['q' => 'Are my entries saved or shared?', 'a' => 'No. Your list stays in your browser and is never uploaded.'],
        ],
        'sources' => [
            ['title' => 'MDN: Crypto.getRandomValues()', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues'],
        ],
        'related' => ['random-number-generator', 'dice-roller', 'coin-flip'],
    ],

    'random-number-generator' => [
        'name' => 'Random Number Generator',
        'category' => 'games',
        'icon' => 'hash',
        'popular' => false,
        'updated' => '2026-09-30',
        'title' => 'Random Number Generator - Pick Numbers in Any Range',
        'description' => 'Generate random numbers in any range, one or hundreds at a time, with or without duplicates. Great for raffles, lottery picks and games. Free and instant.',
        'h1' => 'Random Number Generator',
        'tagline' => 'Pick random numbers in any range, with no duplicates if you need them.',
        'keywords' => ['random number generator', 'random number', 'number picker', 'rng', 'lottery number generator'],
        'intro' => 'A random number generator is a tool that picks numbers by chance from a range you choose. Generate a random number between any two values, or a whole list of them. Choose the minimum, the maximum and how many numbers you need, then decide whether duplicates are allowed and whether the list should be sorted. It is ideal for raffles, lottery picks, classroom activities, sampling and games.',
        'steps' => [
            'Enter the minimum and maximum numbers (negative numbers work too).',
            'Choose how many numbers you want, up to 1,000.',
            'Tick "No duplicates" and "Sort low to high" if you need them.',
            'Press Generate, or use a preset such as 1-100 or 6 of 49.',
        ],
        'features' => [
            'Any whole-number range, including negative numbers',
            'Up to 1,000 numbers at once',
            'No-duplicates mode for raffles and lotteries',
            'Optional sorting and one-click copy of the results',
            'Secure, unbiased randomness from your browser',
        ],
        'content' => [
            [
                'heading' => 'How random are the numbers?',
                'body' => 'The numbers come from the Web Crypto API, a cryptographically secure random number generator built into every modern browser. The generator also uses rejection sampling, a technique that removes the small bias found in many simple random number tools, so every number in your range has exactly the same probability.',
            ],
            [
                'heading' => 'Picking numbers without duplicates',
                'body' => 'Turn on "No duplicates" when each number may only appear once, for example when drawing raffle tickets or lottery numbers. The tool checks that your range is big enough: you cannot pick 10 different numbers between 1 and 5. With duplicates allowed, each number is picked independently, like rolling a die several times.',
            ],
        ],
        'faqs' => [
            ['q' => 'Can I generate a random number between 1 and 100?', 'a' => 'Yes. Set the minimum to 1 and the maximum to 100, or click the 1-100 preset, then press Generate.'],
            ['q' => 'Can I generate lottery numbers?', 'a' => 'Yes. Use the "Lottery 6 of 49" preset, or choose your own range and count with "No duplicates" ticked.'],
            ['q' => 'How many numbers can I generate at once?', 'a' => 'Up to 1,000 numbers per click. You can copy them all with one button.'],
            ['q' => 'Can I use negative numbers?', 'a' => 'Yes. Any whole numbers work, for example a range from -50 to 50.'],
        ],
        'sources' => [
            ['title' => 'MDN: Crypto.getRandomValues()', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues'],
        ],
        'related' => ['spin-the-wheel', 'dice-roller', 'password-generator'],
    ],

    'stopwatch' => [
        'name' => 'Stopwatch',
        'category' => 'time-tools',
        'icon' => 'stopwatch',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'Online Stopwatch - Free Stopwatch with Lap Times',
        'description' => 'A free online stopwatch accurate to 1/100 of a second, with lap and split times, fastest and slowest laps, and keyboard shortcuts. Works in any browser.',
        'h1' => 'Online Stopwatch',
        'tagline' => 'Accurate to 1/100 of a second, with laps, splits and keyboard shortcuts.',
        'keywords' => ['stopwatch', 'online stopwatch', 'stopwatch with laps', 'timer', 'lap timer'],
        'intro' => 'A stopwatch measures how much time passes between starting and stopping it, and can record lap times. Time a run, a presentation, a recipe or a workout with this free online stopwatch. It counts to the hundredth of a second, records lap and split times, and highlights your fastest and slowest laps. Because it measures real elapsed time, it stays accurate even if you switch to another tab.',
        'steps' => [
            'Press Start (or the Space bar) to begin timing.',
            'Press Lap (or L) to record a lap without stopping the clock.',
            'Press Stop to pause, then Resume to carry on.',
            'Press Reset (or R) to clear the time and laps. Copy laps to paste them anywhere.',
        ],
        'features' => [
            'Accurate to 1/100 of a second',
            'Unlimited laps with lap and total (split) times',
            'Fastest and slowest laps highlighted',
            'Keyboard shortcuts: Space, L and R',
            'Keeps exact time in background tabs',
        ],
        'content' => [
            [
                'heading' => 'How accurate is an online stopwatch?',
                'body' => 'This stopwatch reads your device\'s high-resolution clock each time the display refreshes, rather than counting timer ticks, so small delays never add up. Browsers slow down pages in background tabs, but because the elapsed time is always calculated from the start moment, the reading is still correct when you come back.',
            ],
            [
                'heading' => 'Lap time vs split time',
                'body' => 'A lap time is how long one lap took on its own, for example 1:05 for the third lap of a track. A split (or total) time is the time since you started, for example 3:20 when the third lap ends. The laps table shows both, so you can see your pace and your overall progress at a glance.',
            ],
        ],
        'faqs' => [
            ['q' => 'Does the stopwatch keep running in another tab?', 'a' => 'Yes. It measures real elapsed time, so the reading is correct even after the tab has been in the background.'],
            ['q' => 'How do I record a lap?', 'a' => 'Press Lap while the stopwatch is running, or press the L key. Each lap shows its own time and the total time.'],
            ['q' => 'Can I use the keyboard?', 'a' => 'Yes. Space starts and stops, L records a lap and R resets when stopped.'],
            ['q' => 'Can I save my lap times?', 'a' => 'Press Copy laps to copy all lap and total times, then paste them into a spreadsheet, note or message.'],
        ],
        'sources' => [
            ['title' => 'MDN: Performance.now()', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Performance/now'],
        ],
        'related' => ['countdown-timer', 'age-calculator', 'dice-roller'],
    ],

    'countdown-timer' => [
        'name' => 'Countdown Timer',
        'category' => 'time-tools',
        'icon' => 'timer',
        'popular' => false,
        'updated' => '2026-09-30',
        'title' => 'Countdown Timer - Online Timer with Alarm',
        'description' => 'Set a countdown timer for seconds, minutes or hours with one-click presets. An alarm sounds when time is up and the tab title shows the time left. Free online.',
        'h1' => 'Countdown Timer',
        'tagline' => 'Set minutes or hours, or tap a preset. An alarm sounds when time is up.',
        'keywords' => ['countdown timer', 'online timer', 'timer with alarm', '5 minute timer', 'set a timer'],
        'intro' => 'A countdown timer counts down from a set amount of time to zero and then sounds an alarm. Set a timer for cooking, study sessions, workouts, meetings or exams. Type any length up to 99 hours or tap a preset like 5 minutes or 25 minutes. A ring counts down the time left, the browser tab shows the remaining time, and an alarm sounds when the countdown reaches zero.',
        'steps' => [
            'Type the hours, minutes and seconds, or tap a preset.',
            'Press Start (or Space). The ring and the tab title count down.',
            'Pause, resume or add a minute at any time.',
            'When the alarm sounds, press Stop alarm, then New timer to go again.',
        ],
        'features' => [
            'Any length from 1 second to 99 hours 59 minutes',
            'One-click presets from 30 seconds to 1 hour',
            'Alarm sound, with an option to turn it off',
            'Time left shown in the browser tab title',
            'Pause, resume and +1 minute, with keyboard shortcuts',
        ],
        'content' => [
            [
                'heading' => 'Will the timer work in a background tab?',
                'body' => 'Yes. The timer works out the exact moment it should end, so it stays accurate even when you switch tabs and your browser slows the page down. The remaining time is also shown in the tab title, so you can keep an eye on it while you work in another tab. Keep the tab open and your volume on to hear the alarm.',
            ],
            [
                'heading' => 'Popular timer lengths',
                'body' => 'Five minutes is ideal for tea, short breaks and quick exercises. Twenty-five minutes is the classic Pomodoro focus session, usually followed by a five-minute break. Longer timers of 30 or 60 minutes suit exams, meetings and baking. Use the presets for these, or type any other length.',
            ],
        ],
        'faqs' => [
            ['q' => 'Does the countdown timer make a sound?', 'a' => 'Yes. An alarm beeps when time is up, for up to 30 seconds or until you press Stop alarm. You can turn the sound off.'],
            ['q' => 'Why did I not hear the alarm?', 'a' => 'Check that your volume is up and the tab is still open. Browsers only allow sound after you click on the page, which happens when you press Start.'],
            ['q' => 'What is the longest timer I can set?', 'a' => 'Up to 99 hours, 59 minutes and 59 seconds.'],
            ['q' => 'Can I pause the timer?', 'a' => 'Yes. Press Pause (or Space) and Resume to carry on. You can also add a minute while it is running.'],
        ],
        'sources' => [
            ['title' => 'MDN: Performance.now()', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Performance/now'],
        ],
        'related' => ['stopwatch', 'age-calculator', 'percentage-calculator'],
    ],

    'sleep-calculator' => [
        'name' => 'Sleep Calculator',
        'category' => 'time-tools',
        'icon' => 'moon',
        'popular' => true,
        'updated' => '2026-09-30',
        'title' => 'Sleep Calculator - Best Time to Sleep & Wake Up',
        'description' => 'Find the best time to go to bed or wake up based on 90-minute sleep cycles, or count how many hours you slept. Wake up refreshed, not groggy. Free and instant.',
        'h1' => 'Sleep Calculator',
        'tagline' => 'Find the best bedtime or wake-up time, and count the hours you slept.',
        'keywords' => ['sleep calculator', 'sleep counter', 'bedtime calculator', 'sleep cycle calculator', 'when should I go to bed', 'hours of sleep'],
        'intro' => 'A sleep calculator suggests when to go to bed or wake up so that you wake at the end of a sleep cycle, when sleep is lightest. Waking up in the middle of a sleep cycle is why an alarm can leave you groggy even after a full night. This sleep calculator works with the natural rhythm of roughly 90-minute sleep cycles: tell it when you need to wake up and it suggests when to go to bed, or tell it when you are going to bed and it suggests the best alarm times. It can also count how many hours you slept and compare them with the recommended 7-9 hours.',
        'steps' => [
            'Choose what to work out: a bedtime, a wake-up time, "Sleep now" or hours slept.',
            'Enter your time. Adjust how long you usually take to fall asleep (15 minutes by default).',
            'Pick one of the suggested times. "Recommended" gives 7.5 hours and "Best rest" gives 9 hours of sleep.',
            'Tap a time to see a chart of your sleep cycles for that night.',
        ],
        'features' => [
            'Bedtimes for a chosen wake-up time, and wake-up times for a chosen bedtime',
            '"Sleep now" mode using your current time',
            'Hours-slept counter with the 7-9 hour guideline',
            'Adjustable time to fall asleep and 12 or 24-hour clock',
            'Animated chart of light, deep and REM sleep across the night',
        ],
        'content' => [
            [
                'heading' => 'What is a sleep cycle?',
                'body' => 'During the night you move through light sleep, deep sleep and REM (dreaming) sleep in cycles that last about 90 minutes, usually four to six times a night. Early cycles contain the most deep sleep, while later cycles contain more REM. Waking up at the end of a cycle, when sleep is lightest, usually feels easier than being woken from deep sleep.',
            ],
            [
                'heading' => 'How much sleep do you need?',
                'body' => 'Sleep health organisations recommend 7 to 9 hours a night for adults, 8 to 10 hours for teenagers and 9 to 12 hours for school-age children. Five full cycles (7.5 hours) or six cycles (9 hours) fit these guidelines for adults. Everyone is a little different and cycle length varies from person to person, so treat the suggested times as a helpful guide rather than an exact rule.',
            ],
        ],
        'faqs' => [
            ['q' => 'What time should I go to bed to wake up at 7 AM?', 'a' => 'For 7:00 AM, aim to fall asleep by 11:30 PM for five cycles (7.5 hours) or 10:00 PM for six cycles (9 hours). With 15 minutes to fall asleep, that means going to bed at 11:15 PM or 9:45 PM.'],
            ['q' => 'How long is one sleep cycle?', 'a' => 'A sleep cycle lasts about 90 minutes on average, though it can range from roughly 80 to 120 minutes between people and across the night.'],
            ['q' => 'Why do I feel tired after 8 hours of sleep?', 'a' => 'If your alarm goes off during deep sleep you can feel groggy even after a long night. Timing your alarm for the end of a cycle, and keeping a regular schedule, often helps.'],
            ['q' => 'How does the sleep counter work out hours slept?', 'a' => 'Choose "Hours slept", enter when you went to bed and when you woke up. It works across midnight, subtracts the time it took to fall asleep and compares the result with the 7-9 hours adults need.'],
            ['q' => 'Is this sleep calculator medical advice?', 'a' => 'No. It is a general guide based on average sleep cycles. If you regularly struggle with sleep, speak to a doctor.'],
        ],
        'sources' => [
            ['title' => 'National Sleep Foundation: How many hours of sleep do you really need?', 'url' => 'https://www.thensf.org/how-many-hours-of-sleep-do-you-really-need/'],
            ['title' => 'Sleep Foundation: How much sleep do you need? (AASM-endorsed recommendations)', 'url' => 'https://www.sleepfoundation.org/how-sleep-works/how-much-sleep-do-we-really-need'],
        ],
        'related' => ['stopwatch', 'countdown-timer', 'age-calculator'],
        'table' => [
            'caption' => 'Bedtimes for common wake-up times (15 minutes to fall asleep)',
            'headers' => ['Wake up at', '6 cycles (9 h)', '5 cycles (7.5 h)', '4 cycles (6 h)'],
            'rows' => [
                ['06:00', '20:45', '22:15', '23:45'],
                ['06:30', '21:15', '22:45', '00:15'],
                ['07:00', '21:45', '23:15', '00:45'],
                ['07:30', '22:15', '23:45', '01:15'],
                ['08:00', '22:45', '00:15', '01:45'],
            ],
        ],
    ],
];
