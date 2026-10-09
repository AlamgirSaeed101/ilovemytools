<?php

/*
|--------------------------------------------------------------------------
| Guides - original, hand-written articles (English only)
|--------------------------------------------------------------------------
| The array key is the URL slug: /guides/{slug}. Each guide answers one real
| question in depth and links to the tool that does the job. Facts must be
| checkable (list them under 'sources'); never pad or invent numbers.
|
| sections: [heading, paragraphs[], list[]?, table{headers, rows}?]
*/

return [

    'how-to-compress-pdf-for-email' => [
        'title' => 'How to Compress a PDF for Email (Without Losing Quality)',
        'description' => 'Email attachment limits explained, plus a step-by-step way to shrink a PDF in your browser so it sends first time. No upload, no sign up, no watermark.',
        'h1' => 'How to compress a PDF for email',
        'intro' => 'You attach a PDF, press send, and the email bounces back: the file is too big. It happens all the time with scanned contracts, photo-heavy reports and brochures. This guide explains why it happens, how big an attachment can be, and how to make a PDF small enough to send without turning the text into a blurry mess.',
        'tool' => 'compress-pdf',
        'related' => ['split-pdf', 'pdf-to-jpg', 'protect-pdf'],
        'published' => '2026-10-10',
        'updated' => '2026-10-10',
        'sections' => [
            [
                'heading' => 'How big can an email attachment be?',
                'paragraphs' => [
                    'Every email service sets its own limit. Gmail and Yahoo Mail accept attachments up to 25 MB per message, and Outlook.com allows about 20 MB. Many company mail servers are stricter and stop at 10 MB, and the person receiving the email may have a lower limit than you do.',
                    'There is a second catch: email does not send files as they are. Attachments are encoded as text before they travel, which makes them roughly a third larger. A 19 MB PDF can therefore be rejected by a 25 MB limit. To be safe, aim for a PDF under about 10 MB, and under 5 MB if you are sending it to a large company or a government office.',
                ],
                'table' => [
                    'headers' => ['Email service', 'Attachment limit', 'Safe PDF size'],
                    'rows' => [
                        ['Gmail', '25 MB', 'under 15 MB'],
                        ['Yahoo Mail', '25 MB', 'under 15 MB'],
                        ['Outlook.com', 'about 20 MB', 'under 12 MB'],
                        ['Many company servers', 'often 10 MB', 'under 5 MB'],
                    ],
                ],
            ],
            [
                'heading' => 'Why is my PDF so large?',
                'paragraphs' => [
                    'Text takes up very little space. A 50-page report that contains only text is usually well under 1 MB. What makes a PDF heavy is images: scanned pages, photos, screenshots and high-resolution graphics. A single page scanned at high resolution can be several megabytes on its own.',
                    'That is good news, because it means compression should focus on the images and leave the text alone. Shrinking the pictures to a sensible resolution for a screen usually removes most of the size, while the words stay perfectly sharp.',
                ],
            ],
            [
                'heading' => 'How to compress a PDF step by step',
                'paragraphs' => [
                    'The Compress PDF tool on this site works entirely in your web browser, so the document is never uploaded anywhere. That matters for contracts, invoices, medical letters and anything else you would rather not hand to a stranger\'s server.',
                ],
                'list' => [
                    'Open the Compress PDF tool and drop your file onto the page (or click to choose it).',
                    'Pick Recommended mode first. It re-compresses the photos inside the PDF and keeps the text as real, selectable text.',
                    'Download the result and check the new size shown on the page. If it is now small enough, you are done.',
                    'If the file is still too big, try Strong mode. It turns each page into an image at the resolution you choose, which gives the smallest file, but the text can no longer be selected or searched.',
                    'Open the downloaded PDF once before you send it, to make sure every page still looks right.',
                ],
            ],
            [
                'heading' => 'Which compression setting should I choose?',
                'paragraphs' => [
                    'Use Recommended mode for anything people will read on screen and might want to copy text from: reports, CVs, forms and contracts. It only touches the images, so headings, tables and small print stay crisp.',
                    'Use Strong mode for scanned documents, where every page is already a picture, and for photo-heavy brochures that only need to look right. A resolution of 150 DPI is a good balance for reading on a screen; 100 DPI or lower is fine for a quick preview but small print may become hard to read.',
                    'If a PDF contains no photos at all, compression will not help much, because there is nothing heavy to shrink. In that case the tool keeps your original file and tells you so, instead of handing you a "compressed" copy that is not actually smaller.',
                ],
            ],
            [
                'heading' => 'Still too big? Other ways to send a large PDF',
                'paragraphs' => [
                    'Some documents are simply huge, such as a 300-page scanned book. You still have good options.',
                ],
                'list' => [
                    'Split it into parts with Split PDF and send two or three smaller emails.',
                    'Send only the pages that matter: remove the rest with Delete PDF Pages.',
                    'Share a link instead of an attachment, using a cloud drive such as Google Drive, OneDrive or Dropbox.',
                    'Avoid zipping the PDF. PDF files are already compressed internally, so a ZIP archive usually saves almost nothing.',
                ],
            ],
            [
                'heading' => 'Is it safe to compress a PDF online?',
                'paragraphs' => [
                    'It depends on the website. Many online compressors upload your file to their servers, process it there and keep it for a while. With a browser-based tool like this one, the work happens on your own computer or phone and the file never leaves your device. You can check this yourself: open your browser\'s developer tools, choose the Network tab and compress a file, and you will see that the PDF is not sent anywhere.',
                    'If a PDF is confidential, you can also add a password with Protect PDF after compressing it. Send the password separately, for example by text message, not in the same email.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does compressing a PDF reduce its quality?', 'a' => 'Only the images are affected. In Recommended mode text stays sharp and selectable; photos become slightly softer, which is rarely visible on screen. Strong mode turns pages into images, so choose a resolution of around 150 DPI if the document has small print.'],
            ['q' => 'What size should a PDF be for email?', 'a' => 'Under 10 MB is safe for most services, and under 5 MB if you are sending to a company or government address, because their mail servers often have lower limits than Gmail or Outlook.com.'],
            ['q' => 'Why is my compressed PDF not smaller?', 'a' => 'The PDF probably contains mostly text and vector graphics, which are already compact. There is nothing heavy to shrink, so the original is the best version to send.'],
        ],
        'sources' => [
            ['title' => 'Google, Gmail Help: Attachment size limits', 'url' => 'https://support.google.com/mail/answer/6584'],
            ['title' => 'IETF RFC 2045, MIME Base64 content transfer encoding', 'url' => 'https://www.rfc-editor.org/rfc/rfc2045'],
        ],
    ],

    'jpg-vs-png-vs-webp-vs-avif' => [
        'title' => 'JPG vs PNG vs WebP vs AVIF: Which Image Format to Use',
        'description' => 'A plain-English comparison of JPG, PNG, WebP and AVIF: quality, file size, transparency and browser support, with a simple rule for picking the right format.',
        'h1' => 'JPG vs PNG vs WebP vs AVIF: which image format should you use?',
        'intro' => 'Save an image and you are asked to choose between JPG, PNG, WebP and, more and more often, AVIF. Pick the wrong one and you get a blurry logo, a huge photo that slows your website down, or a picture that will not open on someone else\'s computer. Here is what each format is good at, in plain English, and a simple way to decide.',
        'tool' => 'image-compressor',
        'related' => ['avif-to-jpg', 'webp-to-png', 'png-to-jpg'],
        'published' => '2026-10-10',
        'updated' => '2026-10-10',
        'sections' => [
            [
                'heading' => 'The short answer',
                'paragraphs' => [
                    'Use JPG for photos that must open everywhere, PNG for logos, screenshots and anything with sharp edges or transparency, and WebP for images on a website. AVIF gives the smallest files of all and is a great choice for websites too, but a few older programs still cannot open it.',
                ],
                'table' => [
                    'headers' => ['Format', 'Best for', 'Transparency', 'Typical file size'],
                    'rows' => [
                        ['JPG', 'Photos, email, printing', 'No', 'Small'],
                        ['PNG', 'Logos, screenshots, text, graphics', 'Yes', 'Large for photos'],
                        ['WebP', 'Website images of any kind', 'Yes', 'Smaller than JPG'],
                        ['AVIF', 'Website photos where size matters most', 'Yes', 'Smallest'],
                    ],
                ],
            ],
            [
                'heading' => 'JPG: the universal photo format',
                'paragraphs' => [
                    'JPG (also written JPEG) has been around since the early 1990s and opens on practically every device, app and printer in the world. It uses lossy compression: it throws away detail the eye is unlikely to notice, which makes photos dramatically smaller.',
                    'The downside appears with sharp edges. Text, line drawings and logos saved as JPG get faint blotches around them, called compression artefacts, and every time you edit and re-save a JPG it loses a little more quality. JPG also cannot be transparent, so a logo on a coloured background always comes with a white box around it.',
                ],
            ],
            [
                'heading' => 'PNG: perfect for sharp graphics',
                'paragraphs' => [
                    'PNG uses lossless compression, which means it keeps every pixel exactly as it was. That makes it ideal for screenshots, diagrams, icons, logos and images that contain text. PNG also supports full transparency, so a logo can sit cleanly on any background.',
                    'The price is size. A photo saved as PNG is often several times larger than the same photo as a JPG, with no visible benefit. If you have a large PNG photo, converting it to JPG or WebP is usually the quickest way to make it smaller.',
                ],
            ],
            [
                'heading' => 'WebP: the modern all-rounder',
                'paragraphs' => [
                    'WebP was created by Google and can work in both lossy and lossless mode, with transparency and even animation. Google\'s own tests found lossy WebP files about 25 to 34 percent smaller than JPGs of the same visual quality, which is why many websites switched to it.',
                    'Every modern browser displays WebP, including Chrome, Edge, Firefox and Safari. Some older desktop software and a few online forms still refuse it; if that happens, convert the file to PNG or JPG and try again.',
                ],
            ],
            [
                'heading' => 'AVIF: the smallest files',
                'paragraphs' => [
                    'AVIF is the newest of the four. It is based on the AV1 video codec and is usually even more efficient than WebP: photos often end up around half the size of an equivalent JPG. It supports transparency, high dynamic range and wide colour.',
                    'Browser support is now good, in Chrome since version 85, Firefox since version 93 and Safari since version 16. The weak spot is older software: some image viewers, editors and upload forms still cannot open AVIF files. If someone sends you an AVIF you cannot open, convert it to JPG or PNG.',
                ],
            ],
            [
                'heading' => 'How to choose: a simple rule',
                'paragraphs' => [
                    'Ask two questions. First, is it a photo or a graphic? Photos suit JPG, WebP or AVIF; graphics, screenshots and anything with text suit PNG or lossless WebP. Second, where will it be used? For email, printing or sending to people with unknown software, choose JPG or PNG because they open everywhere. For your own website, choose WebP or AVIF to make pages load faster.',
                ],
                'list' => [
                    'Photo for email or print: JPG.',
                    'Logo, icon or screenshot: PNG.',
                    'Any image on a website: WebP (or AVIF for photos).',
                    'Image someone sent you that will not open: convert it to JPG or PNG.',
                ],
            ],
            [
                'heading' => 'How to convert or shrink an image',
                'paragraphs' => [
                    'All the converters on this site run inside your browser, so your pictures are never uploaded. Drop several files at once and download them together as a ZIP. To keep the same format but make the file smaller, use the Image Compressor, which can also aim for an exact size such as 100 KB.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Is WebP better than JPG?', 'a' => 'For websites, usually yes: WebP files are smaller at the same visual quality and can be transparent. For email or printing, JPG is safer because every program can open it.'],
            ['q' => 'Does converting JPG to PNG improve quality?', 'a' => 'No. Detail lost when the JPG was created cannot be brought back. PNG only preserves the image exactly as it is now, usually in a larger file.'],
            ['q' => 'Why will my AVIF image not open?', 'a' => 'Some older image viewers and editors do not support AVIF yet. Converting it to JPG or PNG makes it open everywhere.'],
        ],
        'sources' => [
            ['title' => 'Google for Developers, WebP compression study', 'url' => 'https://developers.google.com/speed/webp/docs/webp_study'],
            ['title' => 'Alliance for Open Media, AV1 Image File Format (AVIF)', 'url' => 'https://aomediacodec.github.io/av1-avif/'],
            ['title' => 'Can I use: AVIF image format browser support', 'url' => 'https://caniuse.com/avif'],
            ['title' => 'W3C, Portable Network Graphics (PNG) Specification', 'url' => 'https://www.w3.org/TR/png/'],
        ],
    ],

    'how-many-words-is-a-page' => [
        'title' => 'How Many Words Is a Page? Essay & Reading Time Guide',
        'description' => 'How many words fit on a page single- or double-spaced, how long a 5-page essay is, and how reading time is worked out, with a quick table for common lengths.',
        'h1' => 'How many words is a page?',
        'intro' => 'Your teacher asks for three pages, the job form wants 500 words, and you only know one of the two. Converting between pages and words is mostly a matter of spacing and font size. This guide gives the standard estimates, explains why they vary, and shows how long your text takes to read aloud or silently.',
        'tool' => 'word-counter',
        'related' => ['readability-checker', 'case-converter', 'ai-content-detector'],
        'published' => '2026-10-10',
        'updated' => '2026-10-10',
        'sections' => [
            [
                'heading' => 'The quick answer',
                'paragraphs' => [
                    'With a 12-point font such as Times New Roman or Arial and 1-inch margins, a double-spaced page holds about 250 to 300 words, and a single-spaced page about 500 to 600 words. These are the figures most schools and publishers have in mind when they talk about "pages".',
                ],
                'table' => [
                    'headers' => ['Pages', 'Double-spaced', 'Single-spaced'],
                    'rows' => [
                        ['1 page', '250-300 words', '500-600 words'],
                        ['2 pages', '500-600 words', '1,000-1,200 words'],
                        ['3 pages', '750-900 words', '1,500-1,800 words'],
                        ['5 pages', '1,250-1,500 words', '2,500-3,000 words'],
                        ['10 pages', '2,500-3,000 words', '5,000-6,000 words'],
                    ],
                ],
            ],
            [
                'heading' => 'Why the number of words per page varies',
                'paragraphs' => [
                    'A page is not a fixed amount of text. Four things change how much fits: the font, the font size, the line spacing and the margins. Arial is wider than Times New Roman, so the same essay runs slightly longer. Headings, short paragraphs, dialogue and bullet lists also leave white space and lower the count.',
                    'Because of this, many teachers and editors now give word counts instead of page counts. If you are given a page count, check which font, size and spacing are expected, and treat the table above as a guide rather than an exact rule.',
                ],
            ],
            [
                'heading' => 'Common writing lengths',
                'paragraphs' => [
                    'Some limits come up again and again. The Common App personal essay for US college applications allows up to 650 words. Most short-answer questions on application forms ask for 150 to 300 words. A typical blog post is anywhere from 800 to 2,000 words, and a search engine shows roughly the first 155 to 160 characters of a page description and about 60 characters of a title.',
                ],
                'list' => [
                    'Short paragraph: 50 to 100 words.',
                    'One double-spaced page: about 275 words.',
                    'Common App personal essay: up to 650 words.',
                    'Five-page essay, double-spaced: about 1,250 to 1,500 words.',
                ],
            ],
            [
                'heading' => 'How long does it take to read or say?',
                'paragraphs' => [
                    'A large review of reading research found that adults read non-fiction silently at about 238 words per minute on average. Speaking is slower: around 150 words per minute is a comfortable pace for a talk or presentation. So a 1,000-word essay takes about four minutes to read and roughly seven minutes to present.',
                    'These are averages. Technical text, a second language or a nervous speaker all slow things down, so leave a margin if you are timing a speech.',
                ],
                'table' => [
                    'headers' => ['Words', 'Reading time (238 wpm)', 'Speaking time (150 wpm)'],
                    'rows' => [
                        ['250', 'about 1 minute', 'about 1.5 minutes'],
                        ['500', 'about 2 minutes', 'about 3.5 minutes'],
                        ['1,000', 'about 4 minutes', 'about 7 minutes'],
                        ['2,000', 'about 8.5 minutes', 'about 13 minutes'],
                    ],
                ],
            ],
            [
                'heading' => 'How to count your words',
                'paragraphs' => [
                    'Paste your text into the Word Counter on this site. It shows words, characters with and without spaces, sentences, paragraphs, reading time and speaking time as you type, and it never uploads your text. Word processors such as Microsoft Word and Google Docs also have a built-in word count, usually under the Tools or Review menu.',
                    'If you need to cut words, look for filler phrases first: "in order to" becomes "to", "due to the fact that" becomes "because". The Readability Checker can then show you which long sentences are worth splitting.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'How many words is a 5-page essay?', 'a' => 'About 1,250 to 1,500 words double-spaced, or 2,500 to 3,000 words single-spaced, with a 12-point font and 1-inch margins.'],
            ['q' => 'Does a title or reference list count towards the word count?', 'a' => 'Usually not, but rules differ between schools and journals. Check the instructions, and if they are unclear, ask before you submit.'],
            ['q' => 'How many pages is 1,000 words?', 'a' => 'About 2 pages single-spaced or 4 pages double-spaced.'],
        ],
        'sources' => [
            ['title' => 'Brysbaert (2019), "How many words do we read per minute?", Journal of Memory and Language', 'url' => 'https://doi.org/10.1016/j.jml.2019.104047'],
            ['title' => 'Common App, First-year essay prompts', 'url' => 'https://www.commonapp.org/apply/essay-prompts'],
        ],
    ],
];
