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

    'how-to-calculate-a-tip-and-split-a-bill' => [
        'title' => 'How to Calculate a Tip and Split a Bill Correctly',
        'description' => 'Calculate the right tip and split a bill by hand or with a tip calculator, including rounding tricks, tipping on tax, and large-group splits. No sign up.',
        'h1' => 'How to calculate a tip and split a bill',
        'intro' => 'The bill arrives, everyone starts doing math in their head, and someone always gets it wrong. Working out a tip is simple arithmetic, but doing it fast, doing it fairly when a group is splitting the bill, and knowing whether to tip before or after tax trips people up more than it should. Here is how to do it correctly, by hand or with a calculator.',
        'tool' => 'tip-calculator',
        'related' => ['percentage-calculator', 'loan-calculator', 'mortgage-calculator'],
        'published' => '2026-10-19',
        'updated' => '2026-10-19',
        'sections' => [
            [
                'heading' => 'The quick mental-math method',
                'paragraphs' => [
                    'You do not need a calculator for a rough tip. Move the decimal point one place left to get 10% of the bill, then scale from there. On a $64 bill, 10% is $6.40. Double it for 20% ($12.80), or add half of the 10% figure to itself for 15% ($6.40 + $3.20 = $9.60).',
                    'This works because 10%, 15% and 20% are the three percentages almost everyone reaches for, and each one is a simple multiple of the easiest figure to find, 10%. The only place it goes wrong is on odd bill totals like $47.83, where it is faster to round the bill up to $48 first, tip on that, and treat the extra cents as part of the tip.',
                ],
            ],
            [
                'heading' => 'Tip percentage: a quick reference',
                'paragraphs' => [
                    'What counts as a "normal" tip depends on the country and the type of service. In the United States, 15-20% of the bill is the standard range for restaurant table service, and tipping is expected because service staff are often paid a lower base wage that assumes tips make up the difference. In most of Europe, a service charge is frequently already included in the bill, and an additional tip, if given at all, is usually a smaller rounding-up rather than a fixed percentage.',
                ],
                'table' => [
                    'headers' => ['Service', 'Typical US tip', 'Notes'],
                    'rows' => [
                        ['Restaurant, table service', '15-20%', '20% for good service is common; check if a service charge is already added'],
                        ['Bar / counter service', '$1-2 per drink, or 10-15%', 'Lower than table service'],
                        ['Food delivery', '10-15%, or a flat $3-5', 'Add more in bad weather or for a long drive'],
                        ['Taxi / rideshare', '10-15%', 'Round up to the nearest dollar is also common'],
                        ['Hairdresser / salon', '15-20%', 'Tip the person who did the work, not just the shop'],
                    ],
                ],
            ],
            [
                'heading' => 'Do you tip before or after tax?',
                'paragraphs' => [
                    'Tip on the subtotal, before sales tax is added, if you want to follow the most common etiquette advice. Sales tax goes to the government, not the server, so tipping on it just makes the tip a little larger without any real reason. In practice the difference is small: on a $40 meal with 8% tax, tipping 18% on the subtotal gives $7.20, while tipping 18% on the post-tax total of $43.20 gives $7.78, a difference of less than a dollar.',
                    'Because the amounts are so close, many people simply tip on the total shown at the bottom of the receipt and nobody minds. Use whichever is faster for you; the subtotal is the more "correct" choice, not the only acceptable one.',
                ],
            ],
            [
                'heading' => 'How to split a bill between a group',
                'paragraphs' => [
                    'Splitting fairly gets harder as the group gets bigger, especially if people ordered different amounts. There are two honest ways to do it.',
                ],
                'list' => [
                    'Even split: add the bill and tip together, divide by the number of people. Fast and fair only when everyone ate and drank roughly the same amount.',
                    'Itemized split: each person adds up only what they personally ordered, then applies the same tip percentage to their own subtotal. Fairer when orders are very different in price, but it takes longer and needs the itemized receipt.',
                    'For a group that ordered similarly, decide on one tip percentage first, then divide the bill plus tip evenly rather than letting each person pick their own percentage, which never adds up to the total.',
                    'If the total does not divide evenly in whole dollars or cents, round each person\'s share up rather than down, so the group does not come up short, and let the rounding go into the tip.',
                ],
            ],
            [
                'heading' => 'Using the Tip Calculator',
                'paragraphs' => [
                    'If you would rather not do the math at the table, the Tip Calculator on this site does it for you and works entirely in your browser.',
                ],
                'list' => [
                    'Enter the bill amount shown on the receipt (the subtotal, if you want to tip before tax).',
                    'Pick a preset tip percentage (15%, 18%, 20% or 25%) or type a custom one.',
                    'Set "Number of people" to how many are splitting the bill; leave it at 1 if nobody is.',
                    'Turn on "Round up" if you want each person\'s share to land on a whole dollar instead of an awkward amount with cents.',
                    'Read off the tip amount, the total with tip, and what each person owes.',
                ],
            ],
            [
                'heading' => 'Common mistakes',
                'paragraphs' => [
                    'A few habits cause most tipping disputes and short-changed servers.',
                ],
                'list' => [
                    'Tipping on a discounted total after a coupon or gift card, rather than on what the meal would normally have cost: the server did the same work either way.',
                    'Forgetting that a printed "service charge" or "gratuity" line on the bill, common for large groups, may already be the tip, so an extra 20% on top can mean tipping twice.',
                    'Splitting the bill evenly when one person ordered a $12 salad and another ordered a $45 steak: it feels fair in the moment but regularly annoys the lighter eater.',
                    'Using the tax-inclusive total for a "quick 10%" estimate on a bill with a high local sales tax, which can inflate the tip more than intended.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'What is a normal tip percentage in the US?', 'a' => 'For restaurant table service, 15-20% of the bill is the standard range, with 20% commonly given for good service. Delivery, bars and taxis typically run a bit lower, often 10-15%.'],
            ['q' => 'Should I tip on the pre-tax or post-tax amount?', 'a' => 'Most etiquette guidance says to tip on the subtotal before sales tax, since tax does not go to the staff. The dollar difference is usually small, so tipping on the final total is also widely accepted.'],
            ['q' => 'How do I split a bill fairly when people ordered different amounts?', 'a' => 'Have each person total up only their own items and apply the same tip percentage to their own subtotal. An even split across the whole group is faster but only fair when everyone ordered a similar amount.'],
        ],
        'sources' => [
            ['title' => 'Consumer Financial Protection Bureau, What is tipping and how much should I tip?', 'url' => 'https://www.consumerfinance.gov/ask-cfpb/what-is-tipping-and-how-much-should-i-tip-en-2104/'],
            ['title' => 'IRS, Tip Recordkeeping and Reporting', 'url' => 'https://www.irs.gov/businesses/small-businesses-self-employed/tip-recordkeeping-and-reporting'],
        ],
    ],

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
    'how-to-remove-background-from-image' => [
        'title' => 'How to Remove the Background From an Image (Free)',
        'description' => 'Remove a photo background in seconds without uploading it: how AI cut-outs work, how to get clean edges on hair and products, and when to use PNG or WebP.',
        'h1' => 'How to remove the background from an image',
        'intro' => 'A clean cut-out makes a product photo, a profile picture or a slide look far more professional. Doing it by hand in an editor takes patience; AI can now do most of the work in a few seconds. This guide explains how automatic background removal works, how to get the best result, and how to keep your photos private while you do it.',
        'tool' => 'remove-background',
        'related' => ['image-compressor', 'image-resizer', 'webp-to-png'],
        'published' => '2026-10-10',
        'updated' => '2026-10-10',
        'sections' => [
            [
                'heading' => 'How automatic background removal works',
                'paragraphs' => [
                    'Background removers use a type of AI model trained to find the main subject in a picture, a task researchers call salient object detection. The model looks at the whole image and produces a mask: a grey-scale map where white means "keep" and black means "remove". The mask is then used to make the background transparent.',
                    'Older tools sent your photo to a server to run the model. The Background Remover on this site runs the model inside your web browser instead, so the picture never leaves your device. The first run downloads the model once; after that it works quickly.',
                ],
            ],
            [
                'heading' => 'Step by step',
                'list' => [
                    'Open the Background Remover and drop in a JPG, PNG or WebP image.',
                    'Wait a few seconds while the AI finds the subject; the preview shows the cut-out on a checkerboard pattern, which means transparent.',
                    'If your device supports it, try the high-quality mode for difficult edges such as hair and fur.',
                    'Download the result as a PNG, which keeps the transparency.',
                ],
            ],
            [
                'heading' => 'Tips for a cleaner cut-out',
                'paragraphs' => [
                    'The AI does best when it can clearly tell the subject from the background. A few habits make a big difference before you even take the photo.',
                ],
                'list' => [
                    'Use good, even light so the edges of the subject are visible.',
                    'Choose a background that contrasts with the subject: a dark product on a light wall, for example.',
                    'Keep the subject sharp and in focus; motion blur confuses the edges.',
                    'Leave a little space around the subject instead of cropping it at the frame edge.',
                    'Start from the largest original you have; tiny images give jagged edges.',
                ],
            ],
            [
                'heading' => 'Which format should I save it in?',
                'paragraphs' => [
                    'Save cut-outs as PNG when you need them to work everywhere, for example in documents, presentations and marketplaces. PNG keeps full transparency. For a website, WebP also keeps transparency and is usually much smaller. Do not save a cut-out as JPG: JPG cannot be transparent, so the background turns white again.',
                    'If the PNG is large, run it through the Image Compressor and choose WebP output to shrink it while keeping the transparent background.',
                ],
            ],
            [
                'heading' => 'What background removal cannot do well',
                'paragraphs' => [
                    'Fine, semi-transparent details are the hardest part: wispy hair, glass, smoke and lace. The AI may leave a faint halo or cut a little too much. For a product listing that matters, check the edges at full size. Very busy scenes with several people or objects can also confuse the model about which one is the subject; cropping the photo around your subject first usually fixes that.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Is it free to remove a background here?', 'a' => 'Yes. There is no sign up, no watermark and no limit on the number of images.'],
            ['q' => 'Are my photos uploaded?', 'a' => 'No. The AI model runs in your browser, so the image stays on your device.'],
            ['q' => 'Why does the first image take longer?', 'a' => 'The AI model is downloaded the first time you use the tool. After that it is ready, and each image only takes a few seconds.'],
        ],
        'sources' => [
            ['title' => 'Qin et al. (2020), "U2-Net: Going Deeper with Nested U-Structure for Salient Object Detection", arXiv:2005.09007', 'url' => 'https://arxiv.org/abs/2005.09007'],
        ],
    ],

    'how-to-create-a-strong-password' => [
        'title' => 'How to Create a Strong Password: Current Guidance',
        'description' => 'What makes a password strong today, based on the latest NIST guidance: length over complexity, passphrases, no forced changes, and why a password manager helps.',
        'h1' => 'How to create a strong password',
        'intro' => 'For years we were told to mix capitals, numbers and symbols and change our passwords every few months. Security guidance has changed: length matters far more than odd characters, and forced changes often make passwords weaker. Here is what current advice from the US National Institute of Standards and Technology (NIST) says, in plain English.',
        'tool' => 'password-generator',
        'related' => ['random-number-generator', 'qr-code-generator', 'base64-encoder-decoder'],
        'published' => '2026-10-10',
        'updated' => '2026-10-10',
        'sections' => [
            [
                'heading' => 'Length beats complexity',
                'paragraphs' => [
                    'Every extra character multiplies the number of guesses an attacker needs. That is why NIST\'s digital identity guidelines (SP 800-63B) now say that a password used on its own, without a second factor, should be at least 15 characters long, and that websites should allow passwords of at least 64 characters.',
                    'Complexity rules such as "one capital, one number, one symbol" are no longer required by that guidance. They tend to produce predictable patterns, like a capital at the start and "1!" at the end, which attackers already try first.',
                ],
            ],
            [
                'heading' => 'Use a passphrase or a generated password',
                'paragraphs' => [
                    'There are two good ways to get a long password. The first is a passphrase: four or more random, unrelated words, such as "copper lantern meadow orbit". It is long and surprisingly easy to remember. Pick the words at random rather than using a quote, a song lyric or a phrase about yourself.',
                    'The second is a random password from a generator, which is ideal when a password manager remembers it for you. The Password Generator on this site creates passwords with your browser\'s cryptographic random number generator, and nothing is sent or stored.',
                ],
            ],
            [
                'heading' => 'Never reuse a password',
                'paragraphs' => [
                    'Reuse is the biggest real-world risk. When one website is breached, attackers try the leaked email and password on email, banking and shopping sites. A unique password for every account stops one breach from spreading. NIST also advises services to check new passwords against lists of passwords known to be compromised.',
                ],
            ],
            [
                'heading' => 'Change passwords when there is a reason, not on a schedule',
                'paragraphs' => [
                    'The same guidance says services should not force people to change passwords periodically. Forced changes lead to small, guessable edits such as "Summer2025" becoming "Autumn2025". Change a password when there is evidence it may be compromised, for example after a breach notice, if you shared it, or if you typed it on a device you do not trust.',
                ],
            ],
            [
                'heading' => 'A simple checklist',
                'list' => [
                    'At least 15 characters for any important account.',
                    'A random passphrase or a generated password, never personal details.',
                    'A different password for every account.',
                    'A password manager to store them.',
                    'Two-factor authentication on email, banking and social accounts.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'How long should a password be?', 'a' => 'At least 15 characters if it is the only thing protecting the account. Longer is better, and a passphrase of four or more random words reaches that easily.'],
            ['q' => 'Do I still need symbols and numbers?', 'a' => 'Not according to current NIST guidance, although some websites still require them. Length and uniqueness matter much more.'],
            ['q' => 'Is a password generator safe to use online?', 'a' => 'This one creates passwords in your browser with a cryptographic random number generator; nothing is sent to a server or saved.'],
        ],
        'sources' => [
            ['title' => 'NIST Special Publication 800-63B-4, Digital Identity Guidelines: Authentication and Authenticator Management', 'url' => 'https://pages.nist.gov/800-63-4/sp800-63b.html'],
        ],
    ],

    'how-to-convert-pdf-to-word' => [
        'title' => 'How to Convert PDF to Word and Keep the Formatting',
        'description' => 'Turn a PDF into an editable Word document: what converts well, what does not, how to handle scanned PDFs, and how to do it without uploading your file.',
        'h1' => 'How to convert a PDF to Word',
        'intro' => 'PDFs are designed to look the same everywhere, which is exactly why they are hard to edit. Converting one to a Word document lets you change the text, reuse paragraphs or fill in a form you only received as a PDF. This guide explains what to expect from a conversion and how to get the cleanest result.',
        'tool' => 'pdf-to-word',
        'related' => ['word-to-pdf', 'compress-pdf', 'pdf-to-excel'],
        'published' => '2026-10-10',
        'updated' => '2026-10-10',
        'sections' => [
            [
                'heading' => 'Why PDF to Word is never perfect',
                'paragraphs' => [
                    'A Word document stores text as paragraphs, headings and tables that flow from page to page. A PDF stores something quite different: individual pieces of text placed at exact positions on a page, like letters pinned to a board. A converter has to guess which pieces belong to the same line, paragraph or column.',
                    'Simple documents such as letters, reports and essays convert very well. Complex layouts with several columns, text boxes, decorative fonts or tables drawn as lines are harder, and usually need some tidying afterwards.',
                ],
            ],
            [
                'heading' => 'Step by step',
                'list' => [
                    'Open PDF to Word and drop in your PDF. The file is processed in your browser and not uploaded.',
                    'Wait while the text, paragraphs and headings are detected.',
                    'Download the .docx file and open it in Microsoft Word, Google Docs or LibreOffice.',
                    'Check headings, lists and tables, and fix any line breaks that landed in the wrong place.',
                ],
            ],
            [
                'heading' => 'What converts well, and what does not',
                'table' => [
                    'headers' => ['Content', 'Result'],
                    'rows' => [
                        ['Normal paragraphs of text', 'Converts well'],
                        ['Headings', 'Usually detected from the font size'],
                        ['Simple lists', 'Kept as separate lines'],
                        ['Multi-column layouts', 'May need re-arranging'],
                        ['Complex tables', 'Often need fixing by hand'],
                        ['Scanned pages (photos of text)', 'No text to extract'],
                    ],
                ],
            ],
            [
                'heading' => 'What about scanned PDFs?',
                'paragraphs' => [
                    'A scanned PDF is just a picture of a page. There is no actual text inside it, only pixels, so a normal converter has nothing to extract. To edit a scanned document you need OCR (optical character recognition), which reads the letters in the image. A quick test: if you cannot select a word in the PDF with your mouse, it is a scan.',
                ],
            ],
            [
                'heading' => 'Keeping your document private',
                'paragraphs' => [
                    'PDFs often contain contracts, CVs, bank statements and other personal information. Many online converters upload the file to their servers. This converter reads the PDF and builds the Word file entirely in your browser, using the open-source PDF.js library from Mozilla, so the document stays on your device.',
                    'When you have finished editing, Word to PDF turns the document back into a PDF that looks the same on every device.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Will the Word file look exactly like the PDF?', 'a' => 'Simple documents come close. Complex layouts, tables and special fonts usually need some adjustment after conversion.'],
            ['q' => 'Can I convert a scanned PDF to Word?', 'a' => 'Not directly: a scan contains images of text, not text. It needs OCR first.'],
            ['q' => 'Is there a page limit?', 'a' => 'There is no fixed limit. Very large PDFs simply take longer, because the work happens on your own device.'],
        ],
        'sources' => [
            ['title' => 'PDF.js, the PDF renderer by Mozilla', 'url' => 'https://mozilla.github.io/pdf.js/'],
            ['title' => 'Ecma International, ECMA-376 Office Open XML file formats (.docx)', 'url' => 'https://ecma-international.org/publications-and-standards/standards/ecma-376/'],
        ],
    ],

    'how-to-make-a-qr-code' => [
        'title' => 'How to Make a QR Code That Always Scans',
        'description' => 'Create a QR code for a link, Wi-Fi or contact details, choose the right size and error correction level, and test it before you print, all for free.',
        'h1' => 'How to make a QR code that always scans',
        'intro' => 'QR codes are everywhere: on menus, posters, business cards and parcels. Making one takes seconds, but a code that is too small, too low-contrast or printed without testing can fail at the worst moment. Here is how to create one that works every time.',
        'tool' => 'qr-code-generator',
        'related' => ['password-generator', 'image-resizer', 'jpg-to-pdf'],
        'published' => '2026-10-10',
        'updated' => '2026-10-10',
        'sections' => [
            [
                'heading' => 'What a QR code is',
                'paragraphs' => [
                    'QR stands for "Quick Response". The format was invented in 1994 by Denso Wave, a Japanese company, to track car parts, and it was later made an international standard. A QR code stores text, such as a web address, in a square grid of black and white modules that any phone camera can read.',
                ],
            ],
            [
                'heading' => 'Step by step',
                'list' => [
                    'Open the QR Code Generator and choose what the code should contain: a link, plain text, Wi-Fi details or contact information.',
                    'Type or paste the content. The code updates as you type.',
                    'Choose the size and, if you like, the colours. Keep strong contrast: dark code on a light background.',
                    'Download it as PNG for screens and documents, or SVG for printing at any size.',
                    'Scan it with at least two different phones before you print anything.',
                ],
            ],
            [
                'heading' => 'Error correction: why some damage is fine',
                'paragraphs' => [
                    'QR codes contain extra data so they still scan when part of the code is dirty, torn or covered. There are four levels: L restores about 7 percent of the code, M about 15 percent, Q about 25 percent and H about 30 percent. Level M is the most common choice. A higher level makes the code denser but tougher, which is useful for codes that will be printed on packaging or placed outdoors.',
                ],
            ],
            [
                'heading' => 'Size, contrast and placement',
                'list' => [
                    'Print it large enough: about 2 x 2 cm is a practical minimum for a short link held close to the camera; bigger for posters seen from a distance.',
                    'Keep a quiet zone, a plain margin around the code, so the camera can find its edges.',
                    'Use dark modules on a light background. Inverted or low-contrast codes fail on many phones.',
                    'Keep the content short. A short link produces a simpler code that scans faster.',
                ],
            ],
            [
                'heading' => 'Static codes never expire',
                'paragraphs' => [
                    'The codes made here are static: the link or text is stored inside the code itself, so the code works forever and does not depend on any service staying online. The trade-off is that you cannot change the destination after printing. If you might need to, point the code at a page on your own website that you can update.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Do these QR codes expire?', 'a' => 'No. The content is stored inside the code, so it keeps working as long as the link it points to works.'],
            ['q' => 'Can I add a logo to a QR code?', 'a' => 'A small logo in the centre can work with a high error correction level, but always test it on several phones before printing.'],
            ['q' => 'PNG or SVG?', 'a' => 'PNG for websites and documents, SVG for printing because it stays sharp at any size.'],
        ],
        'sources' => [
            ['title' => 'DENSO WAVE, History of QR Code', 'url' => 'https://www.qrcode.com/en/history/'],
            ['title' => 'DENSO WAVE, QR Code error correction feature', 'url' => 'https://www.qrcode.com/en/about/error_correction.html'],
        ],
    ],

    'how-to-calculate-percentages' => [
        'title' => 'How to Calculate Percentages: Formulas and Examples',
        'description' => 'The three percentage formulas you actually need, with worked examples for discounts, tips, grades and percentage change, plus common mistakes to avoid.',
        'h1' => 'How to calculate percentages',
        'intro' => 'Percentages show up in shopping discounts, restaurant tips, exam scores, pay rises and price increases. Almost every percentage question is one of three simple calculations. Learn those three and you can handle nearly anything, with or without a calculator.',
        'tool' => 'percentage-calculator',
        'related' => ['tip-calculator', 'loan-calculator', 'mortgage-calculator'],
        'published' => '2026-10-10',
        'updated' => '2026-10-10',
        'sections' => [
            [
                'heading' => 'What "percent" means',
                'paragraphs' => [
                    'Percent means "per hundred". 25 percent is 25 out of every 100, which is the same as the fraction 25/100 or the decimal 0.25. To turn a percentage into a decimal, divide it by 100; to turn a decimal into a percentage, multiply by 100.',
                ],
            ],
            [
                'heading' => '1. What is X% of a number?',
                'paragraphs' => [
                    'Multiply the number by the percentage and divide by 100. 20% of 80 is 80 x 20 / 100 = 16. A quick mental trick: 10% is the number divided by 10, so 20% is twice that, and 5% is half of it.',
                ],
                'table' => [
                    'headers' => ['Question', 'Calculation', 'Answer'],
                    'rows' => [
                        ['20% of 80', '80 x 20 / 100', '16'],
                        ['15% tip on 42', '42 x 15 / 100', '6.30'],
                        ['8% of 1,250', '1,250 x 8 / 100', '100'],
                    ],
                ],
            ],
            [
                'heading' => '2. X is what percent of Y?',
                'paragraphs' => [
                    'Divide the part by the whole and multiply by 100. If you scored 42 out of 50 on a test, your score is 42 / 50 x 100 = 84%. The same formula tells you what share of a budget went on rent, or what fraction of a task is finished.',
                ],
            ],
            [
                'heading' => '3. Percentage increase or decrease',
                'paragraphs' => [
                    'Subtract the old value from the new value, divide by the old value and multiply by 100. A price that goes from 50 to 60 has risen by (60 - 50) / 50 x 100 = 20%. A price that falls from 60 to 45 has dropped by (45 - 60) / 60 x 100 = -25%, a 25% decrease.',
                ],
            ],
            [
                'heading' => 'Common mistakes',
                'list' => [
                    'A rise and a fall of the same percentage do not cancel out: 100 up 10% is 110, and 110 down 10% is 99.',
                    'Always divide by the original value when working out a change, not the new one.',
                    'Two discounts multiply, they do not add: 20% off then another 10% off is 28% off in total, not 30%.',
                    'Percentage points are not percent: an interest rate moving from 3% to 4% is a rise of 1 percentage point, but 33% in relative terms.',
                ],
            ],
            [
                'heading' => 'Let the calculator do it',
                'paragraphs' => [
                    'The Percentage Calculator on this site has a box for each of these three questions and shows the formula it used, so you can check the working. For splitting a bill, the Tip Calculator does the percentage and the division in one go.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'How do I work out 15% of a number in my head?', 'a' => 'Find 10% by dividing by 10, then add half of that again. For 60: 10% is 6, half of 6 is 3, so 15% is 9.'],
            ['q' => 'How do I calculate a discount price?', 'a' => 'Multiply the price by (100 - discount) / 100. A 25% discount on 80 is 80 x 0.75 = 60.'],
            ['q' => 'What is the difference between percent and percentage points?', 'a' => 'Percentage points measure the gap between two percentages (3% to 4% is 1 point). Percent change measures it relative to the start (a 33% increase).'],
        ],
    ],

    'how-to-merge-pdf-files' => [
        'title' => 'How to Merge PDF Files Into One Document (Free)',
        'description' => 'Combine several PDFs into a single file in the right order, keep the quality intact, and avoid common mistakes, all without uploading your documents anywhere.',
        'h1' => 'How to merge PDF files into one',
        'intro' => 'A job application wants one file, not five. A tax return needs the form plus every receipt behind it. A school project needs each student\'s page in order. Merging PDFs solves all of these in a few clicks, but getting the order right, keeping quality intact and handling a locked file each trip people up. Here is how to do it properly.',
        'tool' => 'merge-pdf',
        'related' => ['split-pdf', 'compress-pdf', 'pdf-to-word'],
        'published' => '2026-10-10',
        'updated' => '2026-10-10',
        'sections' => [
            [
                'heading' => 'Why people merge PDFs',
                'paragraphs' => [
                    'Most forms, portals and inboxes are built around a single attachment, not a folder of files. A recruiter wants a CV, cover letter and certificates together; a mortgage lender wants a pay slip and bank statement in one upload; a court or government portal often rejects a submission with more than one PDF attached. Scanning paperwork page by page also tends to create one file per page, which then needs putting back together in the right order.',
                ],
                'list' => [
                    'Job applications: CV, cover letter and references as one file.',
                    'Tax and expense claims: the form plus each receipt or invoice.',
                    'Contracts: the main agreement plus signed amendments.',
                    'School and university work: a cover page, essay and appendix.',
                    'Scanned paperwork: single-page scans combined into one document.',
                ],
            ],
            [
                'heading' => 'How to merge PDF files step by step',
                'paragraphs' => [
                    'The Merge PDF tool on this site combines files inside your browser, so nothing is uploaded to a server. That matters for anything with personal details, such as payslips, IDs or signed contracts.',
                ],
                'list' => [
                    'Open the Merge PDF tool and drop in every file you want to combine, or click to browse for them.',
                    'Check the list: each file shows its page count, so you can confirm nothing is missing.',
                    'Put the files in the order you want using the up and down arrows. The first file in the list becomes the first pages of the result.',
                    'Remove any file you added by mistake before merging, rather than after.',
                    'Click Merge PDF, then download the combined file and open it once to check every page is there and in order.',
                ],
            ],
            [
                'heading' => 'Getting the order right the first time',
                'paragraphs' => [
                    'The most common mistake is merging files in the order they were added rather than the order they need to appear. Decide the final order before you start, and name files with a number prefix (01-cv.pdf, 02-cover-letter.pdf) if you are going to merge the same set more than once, so the correct order is obvious at a glance.',
                ],
                'table' => [
                    'headers' => ['Document', 'Typical order', 'Why'],
                    'rows' => [
                        ['Job application', 'Cover letter, CV, certificates', 'Reader sees your pitch first'],
                        ['Expense claim', 'Claim form, then receipts in date order', 'Matches how the approver checks it'],
                        ['Contract', 'Main agreement, then signed amendments', 'Amendments reference clauses above them'],
                        ['Scanned book or report', 'Cover, then pages in page-number order', 'Keeps the document readable start to finish'],
                    ],
                ],
            ],
            [
                'heading' => 'Does merging lose quality or change the file size?',
                'paragraphs' => [
                    'No. Merging copies the pages exactly as they are; it does not re-compress images or re-render text, so there is no loss of quality. The combined file is roughly the sum of the originals\' sizes, give or take a small amount of overhead from the file structure. If the result is too large to email, run it through the Compress PDF tool afterwards rather than before, so you only need to compress once.',
                ],
            ],
            [
                'heading' => 'Password-protected and scanned PDFs',
                'paragraphs' => [
                    'A PDF that is locked with a password cannot be merged until the protection is removed, because the merger cannot read pages it cannot open. Open the file in a PDF reader with the password, then save or print a copy without protection, and merge that copy instead. Scanned pages merge perfectly well as images; merging does not add or remove text, so if a scan has no selectable text before merging, it will not have any afterwards either.',
                    'If a scanned page needs to be searchable or copyable, run it through optical character recognition (OCR) before merging, not after. Adding OCR text afterwards means reprocessing the whole combined file instead of just the pages that need it.',
                ],
            ],
            [
                'heading' => 'Mixed page sizes and orientations',
                'paragraphs' => [
                    'Not every page in a merge has to be the same size. A merger that works page by page, rather than forcing every file onto one template, will happily combine a US Letter contract with an A4 invoice and a landscape spreadsheet printout: each page keeps its own dimensions and rotation inside the finished file. The only downside is appearance, not function - a reader will notice the page size change as they scroll, the way it would in a stapled paper bundle.',
                    'If a consistent look matters more than speed, for example in a polished proposal, rotate any sideways pages first with Rotate PDF so every page reads the same way, and consider resizing scans to match the rest of the document before merging rather than after.',
                ],
            ],
            [
                'heading' => 'Checklist before you send the merged file',
                'list' => [
                    'Open the final PDF and scroll through every page, not just the first and last.',
                    'Check the page count matches what you expect (sum of the originals).',
                    'Confirm the order matches what the recipient asked for.',
                    'Check the file size against the recipient\'s limit; compress afterwards if needed.',
                    'Rename the file something clear, such as smith-application-2026.pdf, instead of leaving it as merged.pdf.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does merging PDFs reduce quality?', 'a' => 'No. Pages are copied exactly as they are, with no re-compression, so text and images look identical to the originals.'],
            ['q' => 'Can I merge a password-protected PDF?', 'a' => 'Not directly. Remove the password first by opening the file with it and saving an unprotected copy, then merge that copy.'],
            ['q' => 'Is there a limit to how many PDFs I can merge?', 'a' => 'This tool allows up to 50 files in one go. Everything runs on your own device, so very large batches depend on your device\'s memory rather than a server limit.'],
        ],
        'sources' => [
            ['title' => 'ISO 32000-2:2020, Document management - Portable document format - Part 2: PDF 2.0', 'url' => 'https://www.iso.org/standard/75839.html'],
            ['title' => 'pdf-lib, create and modify PDF documents in JavaScript', 'url' => 'https://pdf-lib.js.org/'],
        ],
    ],

    'how-to-calculate-a-mortgage-payment' => [
        'title' => 'How to Calculate Your Mortgage Payment by Hand',
        'description' => 'The exact formula lenders use to work out a mortgage payment, a worked example you can check by hand, and the costs - tax, insurance, PMI - it never includes.',
        'h1' => 'How to calculate your mortgage payment',
        'intro' => 'A lender\'s pre-approval letter, a real estate listing and an online calculator can all show a different "monthly payment" for the same home, and it is rarely obvious why. Most of the gap comes down to one thing: the core mortgage formula only covers principal and interest. Everything else - property tax, insurance, PMI - gets added on top by whoever is quoting you. Here is the actual formula, a worked example you can check by hand, and a list of what typically gets left out.',
        'tool' => 'mortgage-calculator',
        'related' => ['loan-calculator', 'percentage-calculator', 'tip-calculator'],
        'published' => '2026-10-13',
        'updated' => '2026-10-13',
        'sections' => [
            [
                'heading' => 'The formula lenders actually use',
                'paragraphs' => [
                    'A fixed-rate mortgage payment comes from one formula: M = P x r / (1 - (1 + r)^-n). M is the monthly payment, P is the loan amount (the home price minus the down payment, not the home price itself), r is the monthly interest rate, and n is the total number of monthly payments.',
                    'Two details trip people up every time. First, r is the annual rate divided by 12, not the annual rate itself - a 6.5% annual rate is 0.065 / 12 = 0.0054167 per month. Second, n is the term in years multiplied by 12, so a 30-year mortgage has n = 360, not 30. Get either of those wrong and the result is off by a huge margin, not a rounding error.',
                ],
            ],
            [
                'heading' => 'A worked example',
                'paragraphs' => [
                    'Take a $300,000 loan (after the down payment) at a 6.5% annual rate. The monthly rate is 0.065 / 12 = 0.0054167, and a 30-year term gives n = 360 monthly payments. Plugging those into the formula gives a monthly principal-and-interest payment of $1,896.20, with $382,633.47 paid in interest over the full 30 years.',
                    'Shortening the term raises the monthly payment but cuts the total interest sharply, because the loan is outstanding for far fewer months. The table below uses the same $300,000 loan at the same 6.5% rate so only the term changes.',
                ],
                'table' => [
                    'headers' => ['Loan term', 'Monthly payment (P&I)', 'Total interest paid'],
                    'rows' => [
                        ['15 years', '$2,613.32', '$170,397.98'],
                        ['20 years', '$2,236.72', '$236,812.66'],
                        ['25 years', '$2,025.62', '$307,686.45'],
                        ['30 years', '$1,896.20', '$382,633.47'],
                    ],
                ],
            ],
            [
                'heading' => 'What this payment does not include',
                'paragraphs' => [
                    'The formula only produces principal and interest. Lenders and listings usually quote a larger number called PITI - Principal, Interest, Taxes and Insurance - plus mortgage insurance if your down payment is small. None of these follow a fixed formula, because they depend on where the home is and who insures it.',
                ],
                'list' => [
                    'Property tax: set by the local county or municipality, often paid monthly into an escrow account.',
                    'Homeowners insurance: required by the lender, priced by the insurer based on the home and area.',
                    'Private mortgage insurance (PMI): usually required in the US when the down payment is under 20%, and it drops off once enough equity builds up.',
                    'HOA or condo fees: a fixed monthly charge in some buildings and communities, unrelated to the loan itself.',
                ],
            ],
            [
                'heading' => 'Common mistakes when estimating a payment',
                'paragraphs' => [
                    'Most "my calculation does not match the bank" complaints trace back to one of a handful of slips.',
                ],
                'list' => [
                    'Using the annual rate as r instead of dividing it by 12 first.',
                    'Using the number of years as n instead of multiplying by 12.',
                    'Using the home price as P instead of the home price minus the down payment.',
                    'Comparing a principal-and-interest estimate to a lender\'s PITI quote and assuming the formula is wrong.',
                    'Forgetting that the rate a lender actually offers depends on credit score, loan type and current market rates, so it will not match a rate guessed from an old article or a friend\'s loan.',
                ],
            ],
            [
                'heading' => 'Why extra payments move the numbers so much',
                'paragraphs' => [
                    'Every dollar paid above the required monthly amount reduces the principal immediately, so it stops accruing interest for every remaining month of the loan. Because interest is largest early in the loan - when the outstanding balance is largest - extra payments made in the first few years save far more interest than the same extra payment made near the end.',
                ],
            ],
            [
                'heading' => 'Checklist: comparing two mortgage quotes fairly',
                'list' => [
                    'Confirm both quotes use the same loan amount (home price minus down payment, not the home price).',
                    'Confirm both quotes use the same term in years.',
                    'Check whether each quote is principal-and-interest only or a full PITI figure.',
                    'Ask whether PMI is included and when it is scheduled to end.',
                    'Compare the APR, not just the headline interest rate - the APR folds in certain lender fees.',
                ],
            ],
            [
                'heading' => 'Let the calculator do the arithmetic',
                'paragraphs' => [
                    'The Mortgage Calculator on this site runs the exact formula above, shows a full year-by-year amortization schedule, and lets you add an extra monthly payment to see how many months sooner the loan is paid off. For a loan that is not tied to a home purchase - a car, personal or student loan - the Loan Calculator uses the same math without a down payment field.',
                    'Both calculators run entirely in your browser, so the numbers you enter - loan amount, rate, term - are never sent to a server. That makes them a quick, private way to sanity-check a lender\'s pre-approval letter or compare two offers side by side before you commit to either one.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'What is the formula for a mortgage payment?', 'a' => 'M = P x r / (1 - (1 + r)^-n), where P is the loan amount, r is the annual interest rate divided by 12, and n is the loan term in years multiplied by 12. It gives principal and interest only.'],
            ['q' => 'Why is my lender\'s quote higher than my own calculation?', 'a' => 'Your calculation likely covers principal and interest only. Lenders usually quote PITI - principal, interest, property tax and insurance - plus PMI if the down payment is under 20%, none of which follow the payment formula.'],
            ['q' => 'Does paying a little extra each month really make a difference?', 'a' => 'Yes. Extra payments go straight to the principal and stop accruing interest for every month left on the loan, so even a modest extra amount paid consistently from early in the loan can cut years and a large amount of interest off a 30-year mortgage.'],
        ],
        'sources' => [
            ['title' => 'Consumer Financial Protection Bureau, Buying a house: tools and resources', 'url' => 'https://www.consumerfinance.gov/owning-a-home/'],
            ['title' => 'Consumer Financial Protection Bureau, What is amortization?', 'url' => 'https://www.consumerfinance.gov/ask-cfpb/what-is-amortization-and-how-could-it-affect-my-auto-loan-en-755/'],
        ],
    ],

    'how-to-resize-an-image-for-social-media' => [
        'title' => 'How to Resize an Image for Social Media (All Sizes)',
        'description' => 'The pixel sizes Instagram, Facebook, LinkedIn, X and YouTube actually use for posts, covers and thumbnails, plus a free way to resize any photo to fit.',
        'h1' => 'How to resize an image for social media',
        'intro' => 'Post the same photo to Instagram and paste it as a Facebook link, and one looks fine while the other gets cropped strangely or padded with grey bars. Every network resizes and crops whatever you upload to fit its own layout, so if your file is not close to the right shape, the platform decides what to cut - and it is not always kind to faces, logos or text near the edge. Here are the pixel sizes that matter today and a step-by-step way to hit them exactly.',
        'tool' => 'image-resizer',
        'related' => ['image-compressor', 'png-to-jpg', 'webp-to-png'],
        'published' => '2026-10-17',
        'updated' => '2026-10-17',
        'sections' => [
            [
                'heading' => 'Why the "right" size keeps changing',
                'paragraphs' => [
                    'Sizes vary by placement, not just by platform. A square Instagram grid post, a vertical Story and a YouTube thumbnail are three completely different shapes, and the same photo cannot fill all three without being resized for each one. Platforms also update their recommended dimensions from time to time, so treat any list - including this one - as a close current guide rather than a permanent spec, and double check on the platform\'s own help page before a campaign that really matters.',
                    'What does not change is the underlying problem: upload a photo whose proportions do not match the slot, and the platform will crop it from the center, stretch it, or letterbox it with bars. None of those outcomes look intentional.',
                ],
            ],
            [
                'heading' => 'Common social media image sizes',
                'paragraphs' => [
                    'These are the dimensions most creators and official help pages currently recommend for the most common placements.',
                ],
                'table' => [
                    'headers' => ['Platform & placement', 'Recommended size (pixels)', 'Shape'],
                    'rows' => [
                        ['Instagram feed - square post', '1080 x 1080', '1:1'],
                        ['Instagram feed - portrait post', '1080 x 1350', '4:5'],
                        ['Instagram Story / Reels cover', '1080 x 1920', '9:16'],
                        ['Facebook / LinkedIn shared link image', '1200 x 630', 'about 1.91:1'],
                        ['YouTube thumbnail', '1280 x 720', '16:9'],
                        ['X (Twitter) post image', '1200 x 675', '16:9'],
                    ],
                ],
            ],
            [
                'heading' => 'What actually happens if you upload the wrong shape',
                'paragraphs' => [
                    'YouTube\'s own thumbnail guidelines ask for an image at least 640 pixels wide with a 16:9 ratio; upload something narrower or a different shape and YouTube crops or pads it to fit the thumbnail slot shown in search and recommendations, which often cuts off whatever was near the edges of your original image.',
                    'Meta\'s sharing guidelines for Facebook recommend 1200 x 630 pixels for a shared link image, with a minimum of 200 x 200 pixels. A photo with a different aspect ratio gets cropped to fit that roughly 1.91:1 frame, which is why a tall portrait photo often loses the top and bottom of a logo or a face when it is pasted into a Facebook or LinkedIn link preview.',
                ],
            ],
            [
                'heading' => 'How to resize an image for a specific platform',
                'paragraphs' => [
                    'The Image Resizer on this site resizes to an exact pixel width and height, or by percentage, and converts between JPG, PNG and WebP - all in your browser, so the original photo is never uploaded anywhere.',
                ],
                'list' => [
                    'Pick the placement you are posting to and note its pixel size from the table above - for example 1080 x 1080 for an Instagram grid post.',
                    'If your original photo is already close to that shape, open the Image Resizer, drop the file in, and keep "Lock aspect ratio" switched on so nothing stretches.',
                    'If the shapes do not match - a landscape photo going into a square slot - crop the photo to the right proportions first in any photo editor. The resizer changes pixel size, not framing, so skipping this step squeezes faces and logos out of shape instead of cropping them cleanly.',
                    'Enter the exact width and height from the table, choose JPG for a photo or PNG if you need to keep transparency, and click Download.',
                    'Open the downloaded file at full size before you post. Most platforms still re-encode images on upload, so start from a sharp, correctly-sized file rather than one that has already been resized and saved more than once.',
                ],
            ],
            [
                'heading' => 'Why your image looks blurry after uploading',
                'paragraphs' => [
                    'Most platforms re-compress photos on upload to save bandwidth, and there is nothing you can do about that step. What you do control is the source file: resizing a photo down to a platform\'s target size keeps it sharp, because the resizer only removes detail that is already there. Stretching a small image up to fill a much bigger slot blurs it instead, because no new detail can be invented to fill the extra pixels. If a photo looks soft after resizing, check whether the original was actually smaller than the target size before assuming the tool is at fault.',
                ],
            ],
            [
                'heading' => 'Checklist before you post',
                'list' => [
                    'Pixel size matches the placement\'s recommended dimensions, not just the original photo\'s size.',
                    'Aspect ratio matches the slot, or the image was cropped first rather than stretched to fit.',
                    'File format is JPG for a plain photo, or PNG/WebP if you need to keep transparency.',
                    'Original file was at or above the target pixel size, so nothing had to be scaled up.',
                    'Preview opened at full size before publishing, checking faces, logos and text near the edges.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'What size should my Instagram post be?', 'a' => 'A square grid post is commonly sized at 1080 x 1080 pixels, a portrait post at 1080 x 1350, and a Story or Reels cover at 1080 x 1920. Keep the photo close to that shape before uploading so Instagram does not crop it for you.'],
            ['q' => 'Why does my Facebook link preview image look cropped?', 'a' => 'Meta\'s sharing guidelines recommend a 1200 x 630 pixel image for a shared link, close to a 1.91:1 rectangle. A photo with a different shape - a tall portrait, for instance - gets cropped from the center to fit that frame, which can cut off a face or logo near the top or bottom.'],
            ['q' => 'Will resizing an image make it blurry?', 'a' => 'Only when you scale it up. Resizing a photo down to a smaller target size keeps it sharp because you are only removing detail, not creating it. Enlarging a small photo to fill a much bigger slot is what causes blur.'],
        ],
        'sources' => [
            ['title' => 'Google, YouTube Help: Thumbnail guidelines', 'url' => 'https://support.google.com/youtube/answer/72431'],
            ['title' => 'Meta for Developers, Sharing: Images', 'url' => 'https://developers.facebook.com/docs/sharing/webmasters/images'],
        ],
    ],

    'how-to-add-a-watermark-to-a-pdf' => [
        'title' => 'How to Add a Watermark to a PDF for Free',
        'description' => 'Add a text or logo watermark to a PDF for free: pick the right opacity and position, and avoid the mistakes that make watermarks unreadable or useless.',
        'h1' => 'How to add a watermark to a PDF',
        'intro' => 'A watermark is the fastest way to tell people what a PDF is before they read a word of it: a draft, a sample, confidential, or property of a named person or company. Done badly, it either blocks the text underneath or is so faint nobody notices it is there. Here is how to get it right, including the settings people get wrong the first time.',
        'tool' => 'watermark-pdf',
        'related' => ['edit-pdf', 'sign-pdf', 'merge-pdf'],
        'published' => '2026-10-23',
        'updated' => '2026-10-23',
        'sections' => [
            [
                'heading' => 'Why watermark a PDF',
                'paragraphs' => [
                    'A watermark communicates the status of a document at a glance, without anyone having to open a cover page or read a footer. "DRAFT" tells a reviewer not to treat the wording as final. "CONFIDENTIAL" or "INTERNAL USE ONLY" sets expectations before a document is forwarded somewhere it should not go. A company name or logo across a sample report, course handout or price list marks it as the source\'s own work before it gets screenshotted and shared out of context.',
                ],
                'list' => [
                    'Draft contracts and proposals, so nobody signs the wrong version.',
                    'Confidential HR, legal or financial documents shared for review.',
                    'Sample reports, portfolios or course materials given out for free.',
                    'Scanned IDs or certificates shared with a third party, marked "COPY" so they cannot pass as the original.',
                    'Press kits and pre-release materials marked with an embargo date.',
                ],
            ],
            [
                'heading' => 'How to add a watermark step by step',
                'paragraphs' => [
                    'The Watermark PDF tool on this site runs entirely in your browser: the file is opened, watermarked and saved on your own device, and is never uploaded anywhere. That matters for anything confidential, since a draft contract or HR letter is exactly the kind of file you are watermarking in the first place.',
                ],
                'list' => [
                    'Open the Watermark PDF tool and choose your file.',
                    'Pick Text or Logo/Image. For text, type the wording and set its colour, size and whether it is bold; for a logo, upload a PNG or JPG.',
                    'Set the opacity and rotation. Lower opacity and a diagonal angle (the default) keep the watermark visible without hiding the content.',
                    'Choose a position: centre, a corner, or tiled repeatedly across the page.',
                    'Check the live preview of the first page before deciding anything else - it shows exactly what you will get.',
                    'Choose which pages: all of them, odd or even only, a range such as 1-3,5, or every page except the first (useful for a cover page).',
                    'Click Add Watermark and download the result, then open it and scroll through more than just the first page.',
                ],
            ],
            [
                'heading' => 'Text or logo - which one to use',
                'paragraphs' => [
                    'A short word or phrase works for status markers: DRAFT, CONFIDENTIAL, SAMPLE, COPY, or a company name. It needs no image file and reads clearly at any size. A logo earns its place when the watermark needs to show a specific brand mark rather than a word - for instance, marketing a sample document as yours at a glance. Use a PNG with a transparent background rather than a JPG: a JPG logo carries its own white or coloured rectangle, which shows up as a faint box behind the watermark instead of a clean shape.',
                ],
            ],
            [
                'heading' => 'The opacity and rotation mistake almost everyone makes the first time',
                'paragraphs' => [
                    'The most common result on a first attempt is a watermark that is either unreadable text underneath it, or so faint it is barely there. Both come from skipping the live preview. Opacity around 10-20% keeps body text fully legible while still being obviously present; anything above 40% starts to interfere with reading, especially over small print or dense tables. A diagonal rotation (commonly 45 degrees) is the default for a reason: a horizontal watermark sits in the gaps between paragraphs and can look like it belongs to the layout, while a diagonal one unmistakably reads as something stamped on top.',
                    'Tiling the watermark across the whole page, rather than placing one copy in the centre, matters most for anything that might get cropped or screenshotted - a single centred mark is trivial to crop out of a photo of the screen, while a tiled pattern survives almost any crop.',
                ],
            ],
            [
                'heading' => 'Behind the content or on top',
                'paragraphs' => [
                    'On top draws the watermark over the existing page, which is the simplest option and works well at low opacity. Behind the content draws the watermark first and the page\'s original text and images on top of it, so body text stays fully readable even with a stronger, more visible watermark - useful when the watermark needs to stand out more than a faint overlay allows, such as a bold "SAMPLE" across a document still meant to be read in full.',
                ],
            ],
            [
                'heading' => 'Flattening: when you need it and when you don\'t',
                'paragraphs' => [
                    'By default, the watermark sits in the PDF like any other content on the page. Flatten merges it into the page itself so it cannot be selected, moved or deleted as a separate element by someone editing the file afterwards. Skip it for an internal draft that is going to be revised and re-watermarked anyway; use it before sending a document outside your organisation, where you want the marking to stick.',
                ],
                'table' => [
                    'headers' => ['Goal', 'Type', 'Opacity', 'Position'],
                    'rows' => [
                        ['Mark a draft for internal review', 'Text ("DRAFT")', '15-20%', 'Centre, diagonal'],
                        ['Protect a confidential document', 'Text ("CONFIDENTIAL")', '10-15%, behind content', 'Tiled'],
                        ['Brand a free sample or portfolio', 'Logo (transparent PNG)', '20-30%', 'Corner or tiled'],
                        ['Mark a scanned ID or certificate as a copy', 'Text ("COPY")', '25-35%', 'Centre or tiled, flattened'],
                    ],
                ],
            ],
            [
                'heading' => 'Checklist before you share a watermarked PDF',
                'list' => [
                    'Open the downloaded file and check every page, not just the first - a page range or "except the first" setting can leave pages out by accident.',
                    'Read a paragraph of body text through the watermark to confirm it is still comfortable to read.',
                    'Zoom in on a corner of the logo (if used) to check there is no unwanted white box around it.',
                    'Flatten the watermark if the file is going outside your organisation or to someone who might try to remove it.',
                    'Rename the file so the watermark status is obvious without opening it, for example proposal-DRAFT.pdf.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Will the watermark cover up my text?', 'a' => 'Not if you keep the opacity low (around 10-20%) and check the live preview before downloading. For body-heavy documents, Behind the content keeps your original text fully readable even with a more visible watermark.'],
            ['q' => 'Can I remove a watermark after adding it?', 'a' => 'If you have not flattened it, the watermark is still a separate layer in the PDF and can be edited out with a PDF editor. Flattening merges it permanently into the page content, which is the point of using it before sharing a file outside your control.'],
            ['q' => 'Is my PDF uploaded anywhere to add the watermark?', 'a' => 'No. The watermark is drawn entirely in your browser with JavaScript, and the file never leaves your device.'],
        ],
        'sources' => [
            ['title' => 'pdf-lib, create and modify PDF documents in JavaScript', 'url' => 'https://pdf-lib.js.org/'],
            ['title' => 'Library of Congress, Sustainability of Digital Formats: PDF', 'url' => 'https://www.loc.gov/preservation/digital/formats/fdd/fdd000030.shtml'],
        ],
    ],

    'how-to-edit-text-in-a-pdf' => [
        'title' => 'How to Edit Text in a PDF for Free',
        'description' => 'Edit the text already inside a PDF for free, right in your browser: fix a typo, change a price, replace a word everywhere, and know when it will not work.',
        'h1' => 'How to edit text in a PDF',
        'intro' => 'Most "PDF editors" only let you draw a white box over the old text and type new text on top, which looks fine until someone zooms in and sees the mismatched font or the edge of the cover-up. Editing the text itself - in its own font, at its own size, in the same spot - is a different and much harder job, and it only works at all if the PDF actually contains real text rather than a scanned image of text. Here is how it works, what it can and cannot fix, and the mistakes that cause a strange-looking result.',
        'tool' => 'edit-pdf',
        'related' => ['watermark-pdf', 'sign-pdf', 'redact-pdf'],
        'published' => '2026-10-25',
        'updated' => '2026-10-25',
        'sections' => [
            [
                'heading' => 'Why editing PDF text is different from editing a Word document',
                'paragraphs' => [
                    'A PDF does not store text as paragraphs you can click into like a word processor. It stores a sequence of drawing instructions: put this exact glyph, from this exact font, at this exact x/y position on the page. A PDF editor has to read those instructions, work out which glyphs belong to the line you clicked, cover them, and draw replacement glyphs from the same font at the same position - essentially reverse-engineering a layout that was never meant to be edited. That is also why editing a PDF is slower and more limited than editing the original Word, Google Docs or InDesign file: if you still have the source document, edit that and re-export to PDF instead.',
                    'The other wrinkle is that a PDF usually does not embed a whole font, only the handful of letters, numbers and symbols the document actually uses. A contract that never needed the character "@" simply does not have it stored anywhere inside the file, even though the Calibri or Times font it uses obviously supports it.',
                ],
            ],
            [
                'heading' => 'Editing text already in the PDF, step by step',
                'paragraphs' => [
                    'This runs in your browser with no upload: the file is opened, edited and saved on your own device, which matters for anything with a name, address or financial figure in it.',
                ],
                'list' => [
                    'Open the Edit PDF tool and choose your file.',
                    'Click directly on the line of text you want to change. The editor finds the matching text run and opens it for editing.',
                    'Type the new wording. It is drawn in the PDF\'s own embedded font, at the same size, colour and position as the text it replaces; the old wording is covered first with the colour that was behind it.',
                    'To change the same word everywhere - a company name, a wrong date - use Find and replace instead of editing each line by hand.',
                    'If you need to remove something rather than retype it, switch to Whiteout, which covers the area without needing replacement text.',
                    'Click Save PDF and download the result, then open it and check every page you touched at 100% zoom.',
                ],
            ],
            [
                'heading' => 'When it will not work: scanned pages and missing letters',
                'paragraphs' => [
                    'If a page came from a scanner or a "print to PDF" of a photo, there is no text to click - the whole page is one image, and what looks like letters is just pixels. Clicking won\'t select a line because there is no line object to select. For a scanned page, use Whiteout to cover the old content and Add text to type the replacement in a font you choose, rather than trying to edit "in place".',
                    'The second limit shows up even on a real text PDF: if your replacement wording needs a letter, accent or symbol that never appeared anywhere in the original document, that specific line switches to the closest standard font (Arial/Helvetica, Times or Courier, or their free equivalents) because the embedded font has no glyph to draw. A good editor will tell you which letters triggered this, rather than silently swapping the font and leaving you to spot it later.',
                ],
                'table' => [
                    'headers' => ['Situation', 'Can you edit the text in place?', 'What to do instead'],
                    'rows' => [
                        ['Normal PDF exported from Word, Docs or a web page', 'Yes, click and retype', '-'],
                        ['Scanned page or photo saved as PDF', 'No - it is one image', 'Whiteout + Add text'],
                        ['New wording uses a letter/symbol not in the original', 'Partially - that line falls back to a standard font', 'Check the line after editing; retype in a different font if the mismatch bothers you'],
                        ['Need to change the same word on every page', 'Yes, faster with Find and replace', 'Use Find and replace, not line-by-line edits'],
                    ],
                ],
            ],
            [
                'heading' => 'Three things that go wrong the first time',
                'paragraphs' => [
                    'New text runs into the margin or the next column. The replacement is drawn at the original font size, so a shorter original word replaced with a much longer one can overflow its old space - the same problem you would have retyping a label on a printed form. Shorten the wording or reduce the size manually if it does not fit.',
                    'The cover-up leaves a visible edge. The old text is covered with the colour sampled from behind it, which works cleanly on a plain white or solid-colour background but can leave a faint rectangle on a gradient, a background image, or text sitting over a photo. For those cases, Whiteout with a manually matched colour, or redoing the whole block as an image edit, gives a cleaner result.',
                    'A date, name or number is changed in the visible text but an old copy survives elsewhere in the file - in a form field, a bookmark, or document metadata like the title or author. Always check the PDF\'s own Properties/metadata panel in a PDF reader after editing anything sensitive, and use Find and replace across the whole document rather than page by page so you do not miss a second mention.',
                ],
            ],
            [
                'heading' => 'Checklist before you send the edited PDF',
                'list' => [
                    'Open the saved file and zoom to 100% on every page you edited - small font-mismatch or overflow issues are easy to miss when the page is shrunk to fit the screen.',
                    'Search the document for the old wording to confirm you caught every instance, not just the one you saw first.',
                    'Check the file\'s metadata (title, author, subject) in your PDF reader if the document\'s origin matters.',
                    'For anything scanned, confirm you used Whiteout and Add text rather than expecting to click-and-edit an image.',
                    'Keep the original file until you have confirmed the edited copy looks right - edits are not reversible once you have saved over the only copy you have.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Can I edit any PDF\'s text this way?', 'a' => 'Only if the page has real, selectable text rather than a scanned image. A PDF exported from Word, Docs, a web page or most design tools qualifies; a scanned document or a photo saved as PDF does not, since the whole page is one image with no text to click.'],
            ['q' => 'Will the new text look exactly like the original?', 'a' => 'Usually yes, because the replacement is drawn in the PDF\'s own embedded font at the same size, colour and position. It can switch to a standard fallback font only on a line where your new wording needs a letter the original document never used.'],
            ['q' => 'Is my file uploaded to edit it?', 'a' => 'No. Opening, editing and saving all happen in your browser with JavaScript, and the PDF is never sent to a server.'],
        ],
        'sources' => [
            ['title' => 'pdf-lib, create and modify PDF documents in JavaScript', 'url' => 'https://pdf-lib.js.org/'],
            ['title' => 'Mozilla, PDF.js - a PDF renderer and text extraction library', 'url' => 'https://mozilla.github.io/pdf.js/'],
        ],
    ],

    'how-to-white-out-text-in-a-pdf' => [
        'title' => 'How to White Out Text in a PDF for Free',
        'description' => 'White out text, a stamp or an image in a PDF for free, right in your browser, and learn why whiteout is not the same as secure redaction before you rely on it.',
        'h1' => 'How to white out text in a PDF',
        'intro' => 'Sometimes you just want to cover something on a PDF page - an old signature block, a stray mark, a line of a form you no longer need - without retyping anything or removing a whole page. Whiteout does exactly that: it draws an opaque box over the area you choose. It is quick and it looks clean in the final file, but it is also the setting people most often reach for when what they actually need is proper redaction. Here is how whiteout works, when it is the right tool, and when it is not.',
        'tool' => 'edit-pdf',
        'related' => ['redact-pdf', 'edit-pdf', 'sign-pdf'],
        'published' => '2026-10-27',
        'updated' => '2026-10-27',
        'sections' => [
            [
                'heading' => 'What whiteout actually does',
                'paragraphs' => [
                    'Whiteout draws a solid rectangle in a colour you choose - usually white, to match the page - on top of the existing content at the position and size you set. It does not touch what is underneath: the original text, image or drawing instructions stay in the PDF\'s content stream exactly as they were, just covered by the new shape sitting above them in the page\'s stacking order.',
                    'That is the opposite of how the Edit PDF tool\'s in-place text editing works. When you click a line of real text and retype it, the old glyphs are deleted from the content stream and new ones are drawn in their place, so there is nothing left behind. Whiteout is simpler and works on anything - text, a logo, a signature, a scanned stamp - because it does not need to understand what it is covering, it only needs to know where to draw a box.',
                ],
            ],
            [
                'heading' => 'Whiting out something on a page, step by step',
                'paragraphs' => [
                    'This runs entirely in your browser; the PDF is opened, edited and saved on your own device and never uploaded.',
                ],
                'list' => [
                    'Open the Edit PDF tool and choose your file.',
                    'Switch to the Whiteout tool and drag a rectangle over the area you want hidden.',
                    'Resize or move the rectangle until it fully covers the content, with a small margin on each side rather than an exact fit.',
                    'If the page background is not plain white, pick a matching colour so the covered area does not stand out as an obvious patch.',
                    'Repeat for any other area, on this page or others - each whiteout box is its own element, so you can undo or remove just one.',
                    'Click Save PDF and download the result, then zoom in on each covered area to confirm nothing peeks out from under the edge.',
                ],
            ],
            [
                'heading' => 'Whiteout vs. redaction: the distinction that matters',
                'paragraphs' => [
                    'A white box only changes how the page looks when it is viewed or printed normally. The content underneath is still inside the file, which matters because a PDF can be read in more ways than one viewer window: copying the "blank" area and pasting it elsewhere can lift the hidden text, selecting all text on the page can include it, and some PDF tools or scripts can extract every text run in a file regardless of what is drawn above it. None of that requires special skill - it is the same copy-paste anyone already knows how to do.',
                    'Proper redaction is a different operation: it has to delete the hidden content from the file, not just draw over it, which is what the Redact PDF tool is for. Use whiteout for anything cosmetic - cleaning up a scan, removing an old date stamp, hiding a logo on a sample document you are sharing internally. Use redaction, not whiteout, the moment the hidden content is a name, account number, address, signature or anything else that would matter if someone else recovered it.',
                ],
                'table' => [
                    'headers' => ['Situation', 'Use whiteout', 'Use redaction instead'],
                    'rows' => [
                        ['Covering a stray mark or old stamp on a scan', 'Yes', '-'],
                        ['Hiding a logo before sharing a sample internally', 'Yes', '-'],
                        ['Hiding a social security number, account number or signature', 'No', 'Yes - the data must be deleted, not covered'],
                        ['Sharing the file outside your own team or company', 'Only for non-sensitive cosmetic fixes', 'Yes for anything personal or confidential'],
                    ],
                ],
            ],
            [
                'heading' => 'Three mistakes that undo a whiteout',
                'paragraphs' => [
                    'The box is too small. A rectangle that matches the text exactly can leave a sliver of a letter visible along the edge once the file is viewed at a different zoom level. Always leave a small margin.',
                    'The colour does not match the page. A whiteout coloured pure white on a page that is slightly off-white, textured or part of a scanned image leaves a visible, obviously edited patch - draw attention to exactly what you were trying to hide.',
                    'It is used on something that needed real redaction. If what you covered has any value to someone else - financial details, a password, personal information - treat the file as still containing it until you have used an actual redaction tool, not a white rectangle.',
                ],
            ],
            [
                'heading' => 'Checklist before you share a whited-out PDF',
                'list' => [
                    'Confirm what you are covering is cosmetic, not sensitive - if in doubt, use Redact PDF instead.',
                    'Zoom to 100% on every page you edited and check the edges of each whiteout box.',
                    'Try selecting and copying text from the covered area in a PDF reader to make sure nothing hidden comes through.',
                    'Check the file\'s metadata (title, author, subject) separately - whiteout does not touch metadata at all.',
                    'Keep the original file until you are certain the edited copy is correct.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Is whiting out text the same as redacting it?', 'a' => 'No. Whiteout draws an opaque box over content that is still present in the file underneath; redaction removes the content itself. Use Redact PDF, not whiteout, for anything sensitive.'],
            ['q' => 'Can I undo a whiteout box after adding it?', 'a' => 'Yes, as long as you have not saved yet. Click Undo to remove the most recent element, or remove a specific whiteout box individually before clicking Save PDF.'],
            ['q' => 'Does whiteout work on a scanned PDF?', 'a' => 'Yes - unlike in-place text editing, whiteout only draws a shape, so it works the same way on a scanned page, a photo saved as PDF, or a normal text PDF.'],
        ],
        'sources' => [
            ['title' => 'pdf-lib, create and modify PDF documents in JavaScript', 'url' => 'https://pdf-lib.js.org/'],
            ['title' => 'Mozilla, PDF.js - a PDF renderer and text extraction library', 'url' => 'https://mozilla.github.io/pdf.js/'],
            ['title' => 'Library of Congress, Sustainability of Digital Formats: PDF', 'url' => 'https://www.loc.gov/preservation/digital/formats/fdd/fdd000030.shtml'],
        ],
    ],
];
