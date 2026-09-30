<?php

/*
|--------------------------------------------------------------------------
| Tool categories
|--------------------------------------------------------------------------
| Each category gets its own SEO landing page at /category/{slug}.
*/

return [

    'text-tools' => [
        'name' => 'Text Tools',
        'short' => 'Text',
        'subtitle' => 'Count and convert your text',
        'icon' => 'text',
        'accent' => '#2563eb',
        'accent2' => '#3b82f6',
        'title' => 'Free Online Text Tools - Word Counter & Case Converter',
        'description' => 'Free online text tools to count words and characters, change text case and clean up your writing. Instant results in your browser, no sign up.',
        'intro' => 'Count words, check reading time and convert text case instantly. Everything runs in your browser, so your text stays private.',
        'content' => [
            ['heading' => 'Which text tool should I use?', 'body' => 'Use the Word Counter when you have a limit to hit: essays, cover letters, product descriptions, social media posts or SEO meta tags. It counts words, characters with and without spaces, sentences and paragraphs, and estimates reading and speaking time. Use the Case Converter when the words are right but the capitals are wrong: text typed with Caps Lock on, headings that need Title Case, or variable names in camelCase or snake_case.'],
            ['heading' => 'Are online text tools private?', 'body' => 'Both tools run entirely in your browser. The text you paste is processed on your own device and is never sent to our server, stored or logged, so they are safe to use with drafts, emails and confidential documents. Once the page has loaded they keep working even if your connection drops.'],
        ],
        'faqs' => [
            ['q' => 'How do I count the words in a document?', 'a' => 'Copy the text from Word, Google Docs or a PDF and paste it into the Word Counter. The totals update instantly, including characters, sentences, paragraphs and reading time.'],
            ['q' => 'How do I change text from uppercase to lowercase?', 'a' => 'Paste the text into the Case Converter and choose lowercase. You can also switch to Title Case, Sentence case, camelCase, snake_case and more, then copy the result.'],
            ['q' => 'Do these text tools cost anything?', 'a' => 'No. Both tools are free, with no sign up, no daily limit and no cap on text length.'],
        ],
    ],

    'image-tools' => [
        'name' => 'Image Tools',
        'short' => 'Image',
        'subtitle' => 'Compress, resize and convert',
        'icon' => 'image',
        'accent' => '#16a34a',
        'accent2' => '#22c55e',
        'title' => 'Free Online Image Tools - Compress, Resize & Convert Images',
        'description' => 'Compress, resize and convert JPG, PNG and WebP images for free. Images are processed in your browser and never uploaded to a server.',
        'intro' => 'Shrink image file sizes, resize photos to exact dimensions and convert between JPG, PNG and WebP. Your images never leave your device.',
        'content' => [
            ['heading' => 'Should I compress or resize an image?', 'body' => 'Compress when the image looks right but the file is too big, for example to get under an upload limit like 100 KB or to make a web page load faster: the Image Compressor keeps the dimensions and lowers the file size. Resize when the image has the wrong dimensions, such as a 4000-pixel photo that needs to be 1080 pixels wide for social media. Resizing a large photo down also makes the file much smaller.'],
            ['heading' => 'JPG, PNG or WebP: which format is best?', 'body' => 'JPG is best for photographs, PNG for logos, screenshots and anything that needs transparency, and WebP for the web because it gives the smallest files for both. Google reports that lossless WebP images are about 26% smaller than PNGs, and lossy WebP images 25-34% smaller than comparable JPEGs.'],
        ],
        'faqs' => [
            ['q' => 'How do I reduce an image to 100 KB?', 'a' => 'Open the Image Compressor, choose Target size and enter 100. The tool finds the best quality that fits and only shrinks the dimensions if it has to.'],
            ['q' => 'Can I convert PNG to JPG or WebP to PNG here?', 'a' => 'Yes. The Image Resizer & Converter switches between JPG, PNG and WebP, with or without resizing. Transparent areas become white when you save as JPG.'],
            ['q' => 'Are my photos uploaded to a server?', 'a' => 'No. Images are processed in your browser with the Canvas API and never leave your device.'],
        ],
    ],

    'pdf-tools' => [
        'name' => 'PDF Tools',
        'short' => 'PDF',
        'subtitle' => 'Merge, split and convert PDFs',
        'icon' => 'pdf',
        'accent' => '#e11d48',
        'accent2' => '#f43f5e',
        'title' => 'Free Online PDF Tools - Merge & Split PDF Files',
        'description' => 'Merge and split PDF files online for free. No uploads, no watermarks and no sign up. PDFs are processed privately in your browser.',
        'intro' => 'Combine several PDFs into one or pull out just the pages you need. Files are processed on your device, with no watermark and no size tricks.',
        'content' => [
            ['heading' => 'Merge or split: which PDF tool do I need?', 'body' => 'Use Merge PDF to join several files into one document in the order you choose, for example a CV, cover letter and certificates for a job application. Use Split PDF to do the opposite: pull selected pages out into a new file, cut a document into ranges, or save every page as its own PDF.'],
            ['heading' => 'Is it safe to edit PDFs online?', 'body' => 'With most PDF websites your document is uploaded to a server. Here both tools run inside your browser, so contracts, bank statements and other private files never leave your device, and the result has no watermark and no page limit.'],
        ],
        'faqs' => [
            ['q' => 'How do I combine PDF files into one?', 'a' => 'Open Merge PDF, add two or more files, put them in order with the arrows and click Merge PDF. The combined file downloads straight away.'],
            ['q' => 'How do I extract pages from a PDF?', 'a' => 'Open Split PDF, choose Extract pages, type the pages you need, such as 1-3, 5, and click Split PDF.'],
            ['q' => 'Can I merge password-protected PDFs?', 'a' => 'Not directly. Open the file with its password, save or print an unprotected copy, then merge that copy.'],
        ],
    ],

    'calculators' => [
        'name' => 'Calculators',
        'short' => 'Calculators',
        'subtitle' => 'Solve everyday maths',
        'icon' => 'calculator',
        'accent' => '#d97706',
        'accent2' => '#f59e0b',
        'title' => 'Free Online Calculators - Age & Percentage Calculator',
        'description' => 'Free online calculators for age, percentages, percentage change and more. Accurate, instant answers with the formula and working shown for every result.',
        'intro' => 'Quick, accurate calculators for everyday maths: exact age, percentages, increases and decreases.',
        'content' => [
            ['heading' => 'What can these calculators work out?', 'body' => 'The Age Calculator gives an exact age in years, months and days from a date of birth, the day of the week you were born and a countdown to your next birthday, and it handles leap years. The Percentage Calculator covers the common questions in one place: X% of Y, what percent X is of Y, the percentage increase or decrease between two numbers, and adding or removing a percentage such as a discount or tax.'],
            ['heading' => 'How do I check the answer?', 'body' => 'Every result shows the formula it used, so you can follow the working for homework, discounts, pay rises or reports. For example, the percentage change from 80 to 100 is (100 - 80) / 80 x 100 = 25%.'],
        ],
        'faqs' => [
            ['q' => 'How is age calculated exactly?', 'a' => 'Complete years are counted first, then complete months, then the remaining days. This is the same method used on official forms.'],
            ['q' => 'How do I calculate a percentage increase?', 'a' => 'Subtract the old value from the new one, divide by the old value and multiply by 100. The Percentage Calculator does this for you and shows the formula.'],
            ['q' => 'Are the calculators free?', 'a' => 'Yes. They are free, need no sign up and run in your browser, so nothing you enter is stored.'],
        ],
    ],

    'generators' => [
        'name' => 'Generators',
        'short' => 'Generators',
        'subtitle' => 'QR codes and passwords',
        'icon' => 'sparkles',
        'accent' => '#7c3aed',
        'accent2' => '#a855f7',
        'title' => 'Free Online Generators - QR Code & Password Generator',
        'description' => 'Generate QR codes for links and Wi-Fi, and strong, secure random passwords for free. No sign up, no tracking and nothing you create is stored.',
        'intro' => 'Create QR codes for links, Wi-Fi and contacts, and generate strong random passwords that are made on your device.',
        'content' => [
            ['heading' => 'QR codes and passwords, made on your device', 'body' => 'The QR Code Generator creates codes for website links, text, Wi-Fi networks, email, phone numbers and SMS, in your own colours and sizes, as PNG for screens or SVG for print. The Password Generator creates random passwords from 4 to 128 characters using your browser\'s cryptographically secure random number generator.'],
            ['heading' => 'Why don\'t these codes or passwords expire?', 'body' => 'The QR codes are static: your data is stored in the code itself rather than behind a redirect link, so they keep working forever and don\'t depend on this website. Passwords are generated on your device and never sent anywhere, so no copy exists on any server.'],
        ],
        'faqs' => [
            ['q' => 'How do I make a QR code for Wi-Fi?', 'a' => 'Choose Wi-Fi in the QR Code Generator, enter the network name, password and security type, then download the code. Guests scan it to join without typing the password.'],
            ['q' => 'How long should a password be?', 'a' => 'At least 15 characters, the minimum in NIST\'s current guidelines, and 16 or more for important accounts.'],
            ['q' => 'Can I use the QR codes commercially?', 'a' => 'Yes. The codes you create are free to use on packaging, menus, flyers and business cards.'],
        ],
    ],

    'games' => [
        'name' => 'Random & Games',
        'short' => 'Games',
        'subtitle' => 'Dice, coins and wheels',
        'icon' => 'dice',
        'accent' => '#db2777',
        'accent2' => '#ec4899',
        'title' => 'Dice Roller, Coin Flip & Spin the Wheel - Free Random Tools',
        'description' => 'Free online dice roller, coin flip, spin the wheel picker and random number generator. Fair, truly random results with fun animations. No sign up needed.',
        'intro' => 'Roll dice, flip a coin, spin a wheel or pick random numbers. Every result is generated fairly on your device with secure randomness.',
        'content' => [
            ['heading' => 'Which random tool should I use?', 'body' => 'Use the Dice Roller for board games and tabletop role-playing (D4 to D100, up to 10 dice at once). Flip a coin for a quick yes-or-no decision or to decide who goes first. Spin the Wheel to pick a name or option from a list of up to 100 entries, and use the Random Number Generator for raffles, lotteries and sampling, with or without repeats.'],
            ['heading' => 'Are the results really random?', 'body' => 'Every tool uses the Web Crypto API built into your browser, a cryptographically secure source of randomness, so each outcome is equally likely and cannot be predicted. The result is decided before the animation starts, so the animation cannot influence it.'],
        ],
        'faqs' => [
            ['q' => 'How do I pick a random name from a list?', 'a' => 'Paste the names into Spin the Wheel, one per line, and press Spin. Tick "Remove the winner after each spin" to draw several names without repeats.'],
            ['q' => 'How do I generate lottery numbers?', 'a' => 'Use the Random Number Generator with the "Lottery 6 of 49" preset, or set your own range and count with "No duplicates" ticked.'],
            ['q' => 'Is an online coin flip fair?', 'a' => 'Yes. Each flip has exactly a 50% chance of heads and a 50% chance of tails, generated by secure randomness.'],
        ],
    ],

    'time-tools' => [
        'name' => 'Time Tools',
        'short' => 'Time',
        'subtitle' => 'Timers, stopwatch and sleep',
        'icon' => 'stopwatch',
        'accent' => '#0891b2',
        'accent2' => '#14b8a6',
        'title' => 'Free Online Time Tools - Stopwatch & Countdown Timer',
        'description' => 'A precise online stopwatch with lap times and a countdown timer with an alarm and presets. Free, no sign up, and they keep exact time in a background tab.',
        'intro' => 'A precise stopwatch with laps and a countdown timer with an alarm. Both keep exact time, even when the tab is in the background.',
        'content' => [
            ['heading' => 'Stopwatch, timer or sleep calculator?', 'body' => 'Use the Stopwatch to measure how long something takes, with laps and split times to 1/100 of a second. Use the Countdown Timer when you know how long you have, for cooking, study sessions or a 25-minute Pomodoro, and want an alarm at the end. Use the Sleep Calculator to plan a bedtime or wake-up time around 90-minute sleep cycles, or to count how many hours you slept.'],
            ['heading' => 'Do they stay accurate in a background tab?', 'body' => 'Yes. Browsers slow down pages in background tabs, so these tools work out the time from a fixed start or end moment using your device\'s high-resolution clock instead of counting ticks. The reading is correct when you come back, and the Countdown Timer also shows the time left in the tab title.'],
        ],
        'faqs' => [
            ['q' => 'Can I keep a timer running while I use other tabs?', 'a' => 'Yes. Keep the tab open: the time stays exact and the alarm still sounds when the countdown ends.'],
            ['q' => 'Can I record lap times?', 'a' => 'Yes. Press Lap (or L) on the Stopwatch. Each lap shows its own time and the total, and you can copy them all at once.'],
            ['q' => 'How many hours of sleep do adults need?', 'a' => 'The National Sleep Foundation recommends 7 to 9 hours a night for adults aged 18 to 64.'],
        ],
    ],

    'developer-tools' => [
        'name' => 'Developer Tools',
        'short' => 'Dev',
        'subtitle' => 'Format, encode and inspect',
        'icon' => 'code',
        'accent' => '#4f46e5',
        'accent2' => '#6366f1',
        'title' => 'Free Developer Tools - JSON Formatter, Base64 & IP',
        'description' => 'Free online developer utilities: format and validate JSON, encode and decode Base64 text and files, and check your public IP address instantly.',
        'intro' => 'Everyday utilities for developers and IT folks: format JSON, encode Base64 and look up your IP address.',
        'content' => [
            ['heading' => 'Everyday developer utilities', 'body' => 'The JSON Formatter beautifies, validates and minifies JSON and points to the exact line and column of any error. The Base64 Encoder & Decoder converts text or files to and from Base64, including the URL-safe variant and data URLs for HTML and CSS. What Is My IP shows your public IP address, whether it is IPv4 or IPv6, and details about your browser and device.'],
            ['heading' => 'Is it safe to paste API data here?', 'body' => 'Yes. The JSON and Base64 tools run entirely in your browser, so API responses, tokens and configuration files are never sent to a server. The only request the site makes is the one What Is My IP needs to read your public address, which is shown to you and not stored.'],
        ],
        'faqs' => [
            ['q' => 'Why is my JSON invalid?', 'a' => 'The most common causes are trailing commas, single quotes instead of double quotes, keys without quotes and comments. Standard JSON allows none of these.'],
            ['q' => 'Is Base64 encryption?', 'a' => 'No. Base64 is an encoding that anyone can reverse, so never use it to protect passwords or secrets.'],
            ['q' => 'What is the difference between IPv4 and IPv6?', 'a' => 'IPv4 addresses look like 203.0.113.42 and have run out in most regions. IPv6 addresses, such as 2001:db8::1, were introduced to provide vastly more addresses.'],
        ],
    ],

];
