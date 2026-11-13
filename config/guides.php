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
                    'If you would rather not do the math at the table, the [Tip Calculator](/tip-calculator) on this site does it for you and works entirely in your browser.',
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
                    'For percentages that are not tips, such as a discount or a pay rise, the [Percentage Calculator](/percentage-calculator) shows the answer and the formula.',
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
                    'The [Compress PDF](/compress-pdf) tool on this site works entirely in your web browser, so the document is never uploaded anywhere. That matters for contracts, invoices, medical letters and anything else you would rather not hand to a stranger\'s server.',
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
                    'When the recipient only needs to see a page or two, converting them with [PDF to JPG](/pdf-to-jpg) often gives a much smaller attachment than the whole PDF. Going the other way, [Merge PDF](/merge-pdf) combines several compressed files into one attachment.',
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
                    'All the converters on this site run inside your browser, so your pictures are never uploaded. Drop several files at once and download them together as a ZIP. To keep the same format but make the file smaller, use the [Image Compressor](/image-compressor), which can also aim for an exact size such as 100 KB.',
                    'To switch an image to the format you need, use [WebP to PNG](/webp-to-png), [AVIF to WebP](/avif-to-webp) or [PNG to JPG](/png-to-jpg). Each runs in your browser, so the images are not uploaded.',
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

    'avif-vs-webp-vs-jpg-file-size-test' => [
        'title' => 'AVIF vs WebP vs JPG: A Real File-Size Test (24 Images)',
        'description' => 'We encoded 24 test images as JPG, WebP and AVIF and measured every file. Median savings vs JPG: AVIF 50-69%, WebP 20-53%. Method, raw data, limits.',
        'h1' => 'AVIF vs WebP vs JPG: a real file-size test',
        'intro' => 'Most format comparisons repeat the same claim: WebP is about a third smaller than JPG, AVIF about half. We wanted our own numbers, so we built a small, reproducible test: 24 images in three kinds (photo-like scenes, app screenshots and transparent graphics), each saved as JPG, WebP and AVIF with the same widely used encoder library, then measured byte by byte. Every number below comes from that run, and the script and raw CSV are public so you can check or repeat it.',
        'tool' => 'avif-to-webp',
        'related' => ['image-compressor', 'avif-to-jpg', 'webp-to-png', 'png-to-jpg'],
        'published' => '2026-10-30',
        'updated' => '2026-10-30',
        'sections' => [
            [
                'heading' => 'The short answer',
                'paragraphs' => [
                    'At common default settings (JPG quality 80, WebP quality 80, AVIF quality 50), AVIF files were the smallest in all 24 images: a median 69% smaller than JPG for photo-like images, 62% for screenshots and 50% for graphics. WebP landed in between: 53%, 35% and 20% smaller than JPG.',
                    'The catch is quality. On the photo-like images, WebP and AVIF at those settings were usually slightly less faithful to the original than the JPG (WebP in 8 of 8, AVIF in 7 of 8). When we raised their quality until they matched the JPG on an objective score (SSIM), AVIF still came out smaller in 7 of 8 photos, but WebP grew larger than the JPG in 7 of 8. On screenshots and graphics both formats won clearly at equal quality.',
                ],
            ],
            [
                'heading' => 'How we tested',
                'paragraphs' => [
                    'Images: 24 test images drawn by a script from fixed random seeds, so anyone gets exactly the same set. We did not use real camera photos. The 8 "photo-like" images (1600 x 1067) are synthetic scenes built from fractal noise, soft shapes, lighting falloff and added grain; the 8 screenshots (1440 x 900) are rendered dashboard layouts with real text, charts, tables and buttons; the 8 graphics (800 x 800) are badges, icons and logos on a transparent background.',
                    'Encoder: sharp 0.35.5 on libvips 8.18.7, the image library behind many websites and build tools. JPG used mozjpeg at quality 80, WebP used libwebp 1.6.0 at quality 80, AVIF used libaom 3.15.1 at quality 50. Every other option was left at sharp\'s default. JPG cannot store transparency, so the graphics were flattened onto white for JPG only.',
                    'Quality check: we measured SSIM (structural similarity, 1.0 means identical) between each compressed file and the lossless original, on brightness, with transparent images composited onto white. Then, for WebP and AVIF, we searched for the lowest quality setting that reached at least the JPG\'s SSIM and recorded that size too.',
                ],
            ],
            [
                'heading' => 'Results: file size at fixed settings',
                'paragraphs' => [
                    'Median file size per image in each set, and the median saving compared with the JPG of the same image. Savings are worked out per image and then the median is taken, so they do not exactly match a division of the size columns.',
                ],
                'table' => [
                    'headers' => ['Image set (8 each)', 'JPG q80', 'WebP q80', 'AVIF q50', 'WebP saving', 'AVIF saving'],
                    'rows' => [
                        ['Photo-like, 1600 x 1067', '50.7 KB', '23.4 KB', '15.5 KB', '53.0%', '69.4%'],
                        ['Screenshot, 1440 x 900', '83.1 KB', '53.6 KB', '30.9 KB', '35.3%', '62.3%'],
                        ['Graphic with transparency, 800 x 800', '22.4 KB', '18.8 KB', '11.2 KB', '19.7%', '50.4%'],
                    ],
                ],
            ],
            [
                'heading' => 'Results: file size at the same quality as the JPG',
                'paragraphs' => [
                    'Fixed quality numbers do not mean the same thing in different formats, so this second table matches quality instead: each WebP and AVIF was re-encoded at the lowest setting whose SSIM was at least as high as the JPG q80 version. A negative saving means the file got bigger than the JPG.',
                ],
                'table' => [
                    'headers' => ['Image set', 'WebP: median setting needed', 'WebP saving vs JPG', 'AVIF: median setting needed', 'AVIF saving vs JPG'],
                    'rows' => [
                        ['Photo-like', 'q88.5', '-18.2% (larger in 7 of 8)', 'q67.5', '12.0% (smaller in 7 of 8)'],
                        ['Screenshot', 'q56', '49.4% (smaller in 8 of 8)', 'q39', '70.5% (smaller in 8 of 8)'],
                        ['Graphic with transparency', 'q22', '42.3% (smaller in 8 of 8)', 'q23', '71.7% (smaller in 8 of 8)'],
                    ],
                ],
            ],
            [
                'heading' => 'What the numbers say, by image type',
                'paragraphs' => [
                    'Photo-like images: the biggest raw savings, but partly bought with lost detail. At default settings WebP and AVIF scored a median SSIM of 0.9674 and 0.9681 against 0.9721 for JPG; both smooth away fine grain that JPG keeps. When forced to keep as much detail as the JPG, WebP needed quality 87 to 90 and ended up larger, while AVIF still saved a median 12%. If your photos are grainy or highly detailed, do not assume WebP will shrink them at the same visual quality; compare the results yourself.',
                    'Screenshots: here the modern formats win cleanly. Text and flat interface colours give JPG its familiar halos, and both WebP and AVIF reached a higher SSIM than JPG at their default settings while still being 35% and 62% smaller. Matched to JPG\'s quality, AVIF screenshots were about 70% smaller.',
                    'Graphics with transparency: JPG is the wrong tool twice over, because it also throws away the transparent background. WebP at quality 80 saved only 20% here, but it was far above JPG\'s quality; matched to JPG, it saved 42% and AVIF 72%, both keeping the transparency. For comparison, the lossless PNG originals had a median size of 48.3 KB.',
                ],
            ],
            [
                'heading' => 'Limitations: read these before quoting the numbers',
                'list' => [
                    'The images are synthetic. They mimic photos, screenshots and graphics but are not real camera pictures, so treat the photo row as indicative only.',
                    'One encoder per format, at default speed. Other encoders and settings (cwebp, avifenc at slower speeds, Photoshop, Squoosh) produce different sizes.',
                    'SSIM is a rough proxy for what people see: we measured brightness only, it ignores colour, and it rewards keeping noise. A perceptual metric or a viewing test could rank the formats differently.',
                    '"Quality 80" is not the same thing in JPG, WebP and AVIF; that is why the matched-quality table exists.',
                    'Lossless WebP and optimised PNG were not tested; this is a lossy comparison.',
                    'Encoding time was not measured. In practice AVIF is much slower to encode than JPG or WebP, which matters if you convert images on the fly.',
                ],
            ],
            [
                'heading' => 'Practical rules from this test',
                'list' => [
                    'Screenshots, UI images and diagrams for a website: AVIF first, WebP as the fallback. Both beat JPG at equal quality by a wide margin.',
                    'Logos, icons and anything transparent: AVIF or WebP, never JPG, which drops the transparency.',
                    'Photos for a website: AVIF gave the best size at equal quality; check grainy photos by eye before trusting WebP\'s default setting.',
                    'Files you send to people or upload to forms: JPG or PNG still open everywhere. Convert an AVIF to WebP or JPG when a program refuses it.',
                ],
            ],
            [
                'heading' => 'Try it on your own images',
                'paragraphs' => [
                    'Results vary by image, so the best test is your own files. The [Image Compressor](/image-compressor) shows the new size before you download, and can aim for an exact target such as 100 KB. To switch formats, use [AVIF to WebP](/avif-to-webp) when an AVIF will not open somewhere, [WebP to PNG](/webp-to-png) for transparent graphics that need to work everywhere, or [PNG to JPG](/png-to-jpg) for large PNG photos. All of them run in your browser, so your images are never uploaded.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Is AVIF always smaller than WebP?', 'a' => 'In our test, yes: at default settings AVIF was smaller than WebP in all 24 images, by a median of 34% for photo-like images and about 41% for screenshots and graphics. Other encoders and settings can change that gap.'],
            ['q' => 'Is WebP always smaller than JPG?', 'a' => 'At quality 80 it was smaller in all 24 images, by a median of 20% to 53% depending on the image type (one graphic saved only 0.4%). But on our photo-like images, WebP needed a much higher quality setting to keep as much detail as JPG and then became larger than the JPG in 7 of 8 cases.'],
            ['q' => 'Can I check or repeat this test?', 'a' => 'Yes. The script generates the same 24 images from fixed seeds and writes one CSV row per image. Install sharp, run the script, and you should get matching numbers with the same sharp and libvips versions.'],
            ['q' => 'Which format should I use on my website?', 'a' => 'AVIF for the smallest files, with WebP or JPG as a fallback for the few programs that cannot open AVIF. All current major browsers display both AVIF and WebP.'],
        ],
        'sources' => [
            ['title' => 'Benchmark script and raw CSV results (GitHub)', 'url' => 'https://github.com/AlamgirSaeed101/ilovemytools/tree/main/docs/benchmarks'],
            ['title' => 'sharp documentation, output options (JPEG, WebP, AVIF)', 'url' => 'https://sharp.pixelplumbing.com/api-output'],
            ['title' => 'libvips, the image processing library behind sharp', 'url' => 'https://www.libvips.org/'],
            ['title' => 'Can I use: AVIF image format', 'url' => 'https://caniuse.com/avif'],
            ['title' => 'Can I use: WebP image format', 'url' => 'https://caniuse.com/webp'],
            ['title' => 'Wang et al., Image quality assessment: from error visibility to structural similarity (SSIM), IEEE TIP 2004', 'url' => 'https://ieeexplore.ieee.org/document/1284395'],
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
        'updated' => '2026-11-10',
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
                'heading' => 'Going the other way: words to pages',
                'paragraphs' => [
                    'To turn a word count into pages, divide by the words per page. Using about 275 words for a double-spaced page and 550 for a single-spaced one gives a quick middle estimate.',
                    'Worked example: an assignment of 1,500 words is 1,500 / 275, roughly 5.5 pages double-spaced, or 1,500 / 550, roughly 2.7 pages single-spaced. A 2,000-word report is about 7 pages double-spaced and under 4 single-spaced. Round up when you plan, because headings and paragraph breaks always add a little.',
                ],
                'table' => [
                    'headers' => ['Words', 'Pages double-spaced', 'Pages single-spaced'],
                    'rows' => [
                        ['500', 'about 2', 'about 1'],
                        ['750', 'about 3', 'about 1.5'],
                        ['1,000', 'about 4', 'about 2'],
                        ['1,500', 'about 5.5', 'about 3'],
                        ['2,500', 'about 9', 'about 4.5'],
                    ],
                ],
            ],
            [
                'heading' => 'Why the number of words per page varies',
                'paragraphs' => [
                    'A page is not a fixed amount of text. Four things change how much fits: the font, the font size, the line spacing and the margins. Arial is wider than Times New Roman, so the same essay runs slightly longer. Headings, short paragraphs, dialogue and bullet lists also leave white space and lower the count.',
                    'Because of this, many teachers and editors now give word counts instead of page counts. If you are given a page count, check which font, size and spacing are expected, and treat the table above as a guide rather than an exact rule.',
                    'The kind of writing matters too. Academic prose with long words and long paragraphs packs more onto a page than a story full of dialogue, where many lines are only a few words long. A page of a script or a poem can hold far fewer words than either.',
                ],
            ],
            [
                'heading' => 'Meeting a page count without tricks',
                'paragraphs' => [
                    'Stretching the margins, choosing a wider font or setting 12.5-point text to fill three pages is the oldest trick in the book, and teachers who mark hundreds of essays tend to spot it immediately. If you are short, it is better to add substance: one more example, a counter-argument you answer, or a clearer explanation of a key term.',
                    'If you are over, cut before you shrink. Look for filler phrases first: "in order to" becomes "to", "due to the fact that" becomes "because". Then remove sentences that repeat the point of the sentence before. The [Readability Checker](/readability-checker) can show you which long sentences are worth splitting or trimming.',
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
                'heading' => 'Planning a speech by word count',
                'paragraphs' => [
                    'Turn the speaking pace around to plan a talk: multiply the minutes you have by 150. A 3-minute speech is about 450 words, a 5-minute speech about 750 words and a 10-minute presentation about 1,500 words. If you pause for slides, questions or laughter, aim a little lower.',
                    'Worked example: you have five minutes for a wedding toast. A draft of 900 words would take 900 / 150 = 6 minutes at a steady pace, so cut about 150 words. Read it aloud once with a timer, because your own pace may be faster or slower than the average.',
                ],
            ],
            [
                'heading' => 'How to count your words',
                'paragraphs' => [
                    'Paste your text into the [Word Counter](/word-counter) on this site. It shows words, characters with and without spaces, sentences, paragraphs and lines, plus reading time and speaking time, as you type. Your text is counted in your browser and never uploaded. Word processors such as Microsoft Word and Google Docs also have a built-in word count, usually under the Tools or Review menu.',
                    'The Word Counter also lists the top keywords in your text with how often each appears, leaving out very common words such as "the" and "and". That makes it easy to spot a word you have leaned on too often.',
                    'If your text arrives in capitals, or a heading needs title case, the [Case Converter](/case-converter) fixes it without retyping.',
                ],
            ],
            [
                'heading' => 'How we count words matters too',
                'paragraphs' => [
                    'Page estimates start from a word count, and word counters disagree on the awkward cases. In our test of the [Word Counter](/word-counter), "A state-of-the-art tool." counted as 3 words, "Don\'t stop, it\'s fine." as 4, and "In 2026 we paid 1,250.50 dollars." as 6. Microsoft Word may differ on a few of these, so if a deadline is strict, check your total in the program your teacher or publisher uses.',
                    'The rule behind those results is simple. The counter splits text at spaces and line breaks, so a hyphenated phrase or a contraction counts as one word, and a number counts as a word. A dash or symbol standing on its own between spaces does not count, because it contains no letters or digits. For languages written without spaces, such as Chinese, Japanese and Thai, it uses the browser\'s built-in word segmentation instead.',
                    'Reading and speaking times are worked out from the same count at 238 and 150 words per minute, rounded up to the next second. A 1,000-word text shows a reading time of 4 min 13 sec and a speaking time of 6 min 40 sec. Character counts treat an emoji or an accented letter as one character, the way a reader would.',
                ],
            ],
            [
                'heading' => 'Characters versus words',
                'paragraphs' => [
                    'Some limits are set in characters, not words: social media posts, text messages, search result titles and many online form fields. A rough guide for English is five to six characters per word including the space, so a 160-character limit fits roughly 26 to 32 words. Check whether the limit counts spaces; the Word Counter shows characters both with and without them.',
                ],
            ],
            [
                'heading' => 'Common mistakes',
                'list' => [
                    'Assuming "a page" means the same thing to everyone; always check font, size and spacing.',
                    'Counting the title, headings, footnotes or reference list when the rules exclude them, or leaving them out when the rules include them.',
                    'Trusting a page count from a different program; pages shift between Word, Google Docs and PDF.',
                    'Timing a speech by reading silently; reading aloud is much slower.',
                    'Leaving the final word count until the last minute, when cutting is hardest.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'How many words is a 5-page essay?', 'a' => 'About 1,250 to 1,500 words double-spaced, or 2,500 to 3,000 words single-spaced, with a 12-point font and 1-inch margins.'],
            ['q' => 'Does a title or reference list count towards the word count?', 'a' => 'Usually not, but rules differ between schools and journals. Check the instructions, and if they are unclear, ask before you submit.'],
            ['q' => 'How many pages is 1,000 words?', 'a' => 'About 2 pages single-spaced or 4 pages double-spaced.'],
            ['q' => 'How many words is a 5-minute speech?', 'a' => 'About 750 words at a comfortable speaking pace of 150 words per minute. Read your draft aloud with a timer to check.'],
            ['q' => 'How many words is a 650-word essay in pages?', 'a' => 'About 2.5 pages double-spaced or just over 1 page single-spaced. The Word Counter shows it takes about 2 min 44 sec to read silently.'],
            ['q' => 'Why does my word count differ between programs?', 'a' => 'Programs treat hyphenated words, numbers, dashes and symbols differently. The differences are usually small, but check in the program your teacher or publisher uses if the limit is strict.'],
        ],
        'sources' => [
            [
                'title' => 'Brysbaert (2019), "How many words do we read per minute?", Journal of Memory and Language',
                'url' => 'https://doi.org/10.1016/j.jml.2019.104047',
            ],
            [
                'title' => 'Common App, First-year essay prompts',
                'url' => 'https://www.commonapp.org/apply/essay-prompts',
            ],
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
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'How automatic background removal works',
                'paragraphs' => [
                    'Background removers use a type of AI model trained to find the main subject in a picture, a task researchers call salient object detection. The model looks at the whole image and produces a mask: a grey-scale map where white means "keep" and black means "remove". The mask is then used to make the background transparent.',
                    'Older tools sent your photo to a server to run the model. The [Background Remover](/remove-background) on this site runs the model inside your web browser instead, so the picture never leaves your device. The first run downloads the model once; after that it works quickly.',
                    'Grey values in the mask matter too. Pixels the model is unsure about, such as the edge of a strand of hair, become partly transparent instead of being cut sharply, which is why a good cut-out looks soft at the edges rather than jagged.',
                ],
            ],
            [
                'heading' => 'Step by step',
                'list' => [
                    'Open the [Background Remover](/remove-background) and choose Fast or High quality at the top. Fast works on every device; High quality needs a browser with WebGPU, such as Chrome or Edge.',
                    'Drop in a JPG, PNG, WebP or AVIF image of up to 50 MB, or click to choose one.',
                    'Wait while the AI model loads and the background is removed. A progress bar shows the model download the first time.',
                    'Compare the original and the result side by side. The checkerboard pattern behind the result means transparent.',
                    'Under Background, keep Transparent, or choose White or Colour to place the subject on a solid background.',
                    'Click Download PNG. The file is saved with "-no-bg" added to the original name.',
                ],
            ],
            [
                'heading' => 'Fast or High quality?',
                'paragraphs' => [
                    'The two modes use different AI models. Fast uses U-2-Netp, the small version of the U-2-Net model from the research paper listed below. It is about 4.4 MB, runs on any device and looks at the image at 320 x 320 pixels. High quality uses a larger model called BiRefNet lite, a one-time download of about 109 MB, which looks at the image at 1,024 x 1,024 pixels and gives sharper hair and edges.',
                    'That working size explains the difference. Whatever the size of your photo, the model draws its mask at 320 or 1,024 pixels, and the mask is then scaled up smoothly to fit your image. On a large photo in Fast mode, fine details such as loose hair or the gap between fingers can be blurred or lost. High quality keeps far more of that detail.',
                    'High quality runs on your graphics chip through WebGPU, which not every browser or device supports. If your browser lacks it, the button is disabled and says so. If it starts but fails, you will see a message suggesting Fast mode instead. The model is saved in your browser after the first download, so next time it starts much sooner.',
                ],
                'table' => [
                    'headers' => ['', 'Fast', 'High quality'],
                    'rows' => [
                        ['Model', 'U-2-Netp', 'BiRefNet lite'],
                        ['Download', 'About 4.4 MB', 'About 109 MB, once'],
                        ['Mask resolution', '320 x 320', '1,024 x 1,024'],
                        ['Runs on', 'Every device', 'Browsers with WebGPU (Chrome or Edge)'],
                        ['Best for', 'Simple shapes, quick jobs, phones', 'Hair, fur, detailed edges'],
                    ],
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
                'heading' => 'Check the edges before you use it',
                'paragraphs' => [
                    'The result depends heavily on the photo. Fine hair, fur, glass and objects the same colour as the background are the hardest cases, so look along those edges at full size.',
                    'Check the result against both a light and a dark background, since a pale halo can be invisible on white and obvious on black. The tool makes this easy: switch Background to Colour and pick a dark colour to inspect the edges, then switch back to Transparent before you download if that is what you need.',
                ],
            ],
            [
                'heading' => 'Worked example: a product photo for an online shop',
                'paragraphs' => [
                    'Say you have a phone photo of a mug on a kitchen worktop and want a clean image on white for a listing. Photograph the mug in daylight near a window, with the worktop clear behind it. Drop the photo into the Background Remover in Fast mode; a simple solid shape like a mug usually cuts out cleanly.',
                    'Choose White under Background and download the PNG. The download keeps your photo\'s full size, up to 4,096 pixels on the longest side, so a 4,000 x 3,000 photo stays 4,000 x 3,000. Then use the [Image Resizer](/image-resizer) to fit the dimensions the marketplace asks for, and the [Image Compressor](/image-compressor) if the file is too large to upload.',
                    'For a portrait with loose hair, the steps are the same, but try High quality if your browser supports it, and check the hairline against a dark colour before you download.',
                ],
            ],
            [
                'heading' => 'Which format should I save it in?',
                'paragraphs' => [
                    'The Background Remover downloads a PNG, which keeps full transparency and works everywhere, for example in documents, presentations and marketplaces. Do not convert a transparent cut-out to JPG: JPG cannot be transparent, so the background turns solid again.',
                    'For a website, WebP also keeps transparency and is usually much smaller. If the PNG is large, run it through the [Image Compressor](/image-compressor) and choose WebP output to shrink it while keeping the transparent background.',
                ],
            ],
            [
                'heading' => 'What background removal cannot do well',
                'paragraphs' => [
                    'Fine, semi-transparent details are the hardest part: wispy hair, glass, smoke and lace. The AI may leave a faint halo or cut a little too much. For a product listing that matters, check the edges at full size. Very busy scenes with several people or objects can also confuse the model about which one is the subject; cropping the photo around your subject first usually fixes that.',
                    'There is no brush to paint parts back in or erase leftovers by hand, so if the model keeps something you did not want, a better source photo or a tighter crop is the fix. The cut-out downloads as a PNG with a transparent background. To change other JPG images to PNG without removing anything, use [JPG to PNG](/jpg-to-png).',
                ],
            ],
            [
                'heading' => 'Troubleshooting',
                'list' => [
                    'The first image takes a long time: the model is downloading. Later images are quicker, because the model is kept in your browser\'s cache.',
                    'It downloads the model every time: private or incognito windows may not keep the cache, so the model is fetched again in each session.',
                    '"High quality mode could not run on this device": your browser or graphics chip could not run the larger model. Use Fast mode.',
                    'The file is refused: only JPG, PNG, WebP and AVIF images up to 50 MB are accepted. Convert or shrink the image first.',
                    'The wrong object was kept: crop the photo so the subject fills most of the frame, then try again.',
                    'Edges look soft on a big photo: switch to High quality, which draws its mask at a much higher resolution.',
                ],
            ],
            [
                'heading' => 'Privacy: what is downloaded and what is not',
                'paragraphs' => [
                    'Your image is never uploaded. The AI runs in your browser, so the only things fetched from the internet are the model files and the code that runs them. The Fast model comes from our own site, the High quality model from Hugging Face, and the runtime that executes the models from a public code library network. None of these receive your photo.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Is it free to remove a background here?', 'a' => 'Yes. There is no sign up, no watermark and no limit on the number of images.'],
            ['q' => 'Are my photos uploaded?', 'a' => 'No. The AI model runs in your browser, so the image stays on your device.'],
            ['q' => 'Why does the first image take longer?', 'a' => 'The AI model is downloaded the first time you use the tool. After that it is ready, and each image only takes a few seconds.'],
            ['q' => 'Can I put the subject on a white or coloured background?', 'a' => 'Yes. After the background is removed, choose White or Colour under Background, pick a colour if you like, and download the PNG.'],
            ['q' => 'Does it reduce the size of my image?', 'a' => 'Not for normal photos. The cut-out keeps the original dimensions; only images larger than 4,096 pixels on the longest side are scaled down to that size.'],
            ['q' => 'Why is High quality greyed out?', 'a' => 'It needs WebGPU, which is available in browsers such as Chrome and Edge on supported devices. On other browsers, use Fast mode.'],
        ],
        'sources' => [
            [
                'title' => 'Qin et al. (2020), "U2-Net: Going Deeper with Nested U-Structure for Salient Object Detection", arXiv:2005.09007',
                'url' => 'https://arxiv.org/abs/2005.09007',
            ],
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
        'updated' => '2026-11-10',
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
                    'The second is a random password from a generator, which is ideal when a password manager remembers it for you. The [Password Generator](/password-generator) on this site creates passwords with your browser\'s cryptographic random number generator, and nothing is sent or stored.',
                ],
            ],
            [
                'heading' => 'How to generate one, step by step',
                'list' => [
                    'Open the [Password Generator](/password-generator). A 16-character password using all four character types is ready as soon as the page loads.',
                    'Set the length with the slider or type a number into the box next to it. Any length from 4 to 128 characters works; choose at least 15 for an important account.',
                    'Tick the character types you want: Uppercase (A-Z), Lowercase (a-z), Numbers (0-9) and Symbols. Tick "Exclude similar (l, 1, O, 0)" if you will ever need to read the password aloud or type it from paper.',
                    'Watch the strength bar and the bits of entropy update. Click New or Generate password for a different one.',
                    'Click Copy and paste it straight into the website and your password manager. Do not keep it in a plain text file or an email to yourself.',
                ],
            ],
            [
                'heading' => 'How the generator works',
                'paragraphs' => [
                    'Each character is picked with crypto.getRandomValues, the browser\'s cryptographically secure random number source, rather than the predictable Math.random. The generator uses a method called rejection sampling so that every character in the pool is equally likely, then guarantees at least one character from each type you ticked and shuffles the result, so the guaranteed characters are not always at the start.',
                    'Everything happens on your device. The password is not sent to our server, logged or saved, and a new one is made every time you change a setting.',
                ],
            ],
            [
                'heading' => 'How much strength is enough?',
                'paragraphs' => [
                    'Password strength is measured in bits of entropy. Each extra bit doubles the number of guesses needed. For a randomly generated password, the figure is the length multiplied by log2 of the number of possible characters. Our [Password Generator](/password-generator) shows the figure as you change the settings: at its default of 16 characters using all four character types, it showed 104 bits when we tested it.',
                    'The four character sets together give 89 possible characters (26 capitals, 26 lower-case letters, 10 digits and 27 symbols), and each one adds about 6.5 bits. Lower-case letters alone give 26 characters, about 4.7 bits each. The generator labels results from Very weak (under 40 bits) through Weak, Good and Strong to Excellent (100 bits or more).',
                    'That is far beyond what guessing can reach, as long as the site stores passwords properly. For a password you must type by hand, such as your computer login, a long passphrase of several random words is easier and can be just as strong.',
                ],
                'table' => [
                    'headers' => ['Settings', 'Bits of entropy', 'Label in the generator'],
                    'rows' => [
                        ['8 characters, all four types', '52', 'Weak'],
                        ['12 characters, all four types', '78', 'Good'],
                        ['16 characters, numbers only', '53', 'Weak'],
                        ['16 characters, lower-case only', '75', 'Good'],
                        ['20 characters, lower-case only', '94', 'Strong'],
                        ['16 characters, all four types', '104', 'Excellent'],
                    ],
                ],
            ],
            [
                'heading' => 'Why a long lower-case password can beat a short complex one',
                'paragraphs' => [
                    'The table shows the point of the length-first advice. Twenty random lower-case letters (94 bits) are stronger than twelve characters mixing capitals, numbers and symbols (78 bits), and much easier to type on a phone. If a website refuses symbols, untick Symbols and add a few characters instead: 16 characters of letters and numbers still give about 95 bits.',
                    'The same maths explains passphrases. If each word is picked at random from a list of 7,776 words, the size of the well-known Diceware list, every word adds about 12.9 bits. Five random words give about 65 bits and six give about 78 bits. The words must be chosen at random, for example with dice or a generator; words you pick yourself are far more predictable.',
                ],
            ],
            [
                'heading' => 'Entropy only applies to random passwords',
                'paragraphs' => [
                    'A password like "Sunshine2025!" has 12 characters from all four sets, but it is not worth 78 bits, because it was not chosen at random. It is a dictionary word, a year and a symbol, which is exactly the pattern guessing tools try early. The entropy figure in the generator is accurate because the generator picks every character at random. Do not use it to judge a password you made up.',
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
                'heading' => 'What attackers actually do',
                'paragraphs' => [
                    'Most accounts are not lost to clever maths. Attackers try passwords from earlier data breaches on other sites, which is why reuse is so dangerous, and they trick people into typing passwords into fake pages. A strong password protects against neither if you reuse it or hand it over.',
                    'That is why the most useful steps are a unique password for each account, a password manager to remember them, and two-step sign-in on your email and bank. Your email matters most, because it can reset everything else.',
                ],
            ],
            [
                'heading' => 'Common mistakes',
                'list' => [
                    'Making one strong password and using it everywhere.',
                    'Building passwords from names, birthdays, pets or teams, which are easy to find online.',
                    'Swapping letters for look-alike symbols, such as @ for a or 0 for o; guessing tools already try these.',
                    'Adding a number to the end when forced to change a password.',
                    'Writing passwords in a note on your phone or an unprotected spreadsheet instead of a password manager.',
                    'Sending a password in the same email as the file or account it protects.',
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
            [
                'heading' => 'Protecting files as well as accounts',
                'paragraphs' => [
                    'The same rules apply to a password on a document. [Protect PDF](/protect-pdf) locks a PDF with a password so only the people you share it with can open it. Send the password by a different route than the file, such as a phone call or a separate message, or anyone who gets the email gets both.',
                    'A generated password works well here too, because the recipient can paste it rather than type it. If you need a random PIN or a number for something else, the [Random Number Generator](/random-number-generator) picks numbers in a range you set.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'How long should a password be?', 'a' => 'At least 15 characters if it is the only thing protecting the account. Longer is better, and a passphrase of four or more random words reaches that easily.'],
            ['q' => 'Do I still need symbols and numbers?', 'a' => 'Not according to current NIST guidance, although some websites still require them. Length and uniqueness matter much more.'],
            ['q' => 'Is a password generator safe to use online?', 'a' => 'This one creates passwords in your browser with a cryptographic random number generator; nothing is sent to a server or saved.'],
            ['q' => 'What does "Exclude similar" do?', 'a' => 'It leaves out characters that are easy to confuse, such as l, 1, I, O and 0. The password becomes slightly weaker per character, so add a character or two if you use it.'],
            ['q' => 'What is the longest password the generator makes?', 'a' => '128 characters. Some websites cap passwords at a shorter length, so if one is rejected, check the site\'s limit and generate a shorter one.'],
            ['q' => 'What does bits of entropy mean?', 'a' => 'It measures how many guesses a random password could need: each extra bit doubles the number. 104 bits means 2 to the power of 104 possible passwords with those settings.'],
        ],
        'sources' => [
            [
                'title' => 'NIST Special Publication 800-63B-4, Digital Identity Guidelines: Authentication and Authenticator Management',
                'url' => 'https://pages.nist.gov/800-63-4/sp800-63b.html',
            ],
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
        'updated' => '2026-11-10',
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
                    'Open [PDF to Word](/pdf-to-word) and drop in your PDF, or click to choose one. One file at a time, up to 200 MB. The file is processed in your browser and not uploaded.',
                    'Check the file name, size and page count that appear, so you know you picked the right document.',
                    'Click Convert to Word and wait while the text, paragraphs and headings are detected.',
                    'Click Download Word document to save the .docx file, then open it in Microsoft Word, Google Docs or LibreOffice.',
                    'Check headings, lists and tables, and fix any line breaks that landed in the wrong place.',
                ],
            ],
            [
                'heading' => 'How our converter rebuilds the document',
                'paragraphs' => [
                    'It helps to know what the converter is actually doing, because it explains most of the clean-up you may need. First it reads every piece of text on each page with PDF.js. Pieces at the same height are joined into a line, reading from left to right. Lines are then grouped into paragraphs: a gap noticeably bigger than the normal line spacing starts a new paragraph.',
                    'Headings are guessed from size. The converter finds the most common text size on the page and treats it as body text. A line at least 15% bigger becomes a level 3 heading, at least 35% bigger a level 2 heading, and at least 60% bigger a level 1 heading. These are real Word heading styles, so the navigation pane and an automatic table of contents work straight away.',
                    'Each PDF page ends with a page break in the Word file, so page 3 of the PDF starts on a new page in Word. Inside a paragraph, each original line is kept as a line break rather than being joined into flowing text, so you can compare it line by line with the original.',
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
                        ['Bold, italics, colours and fonts', 'Not kept; text uses the default Word style'],
                        ['Multi-column layouts', 'Lines at the same height are joined across columns'],
                        ['Complex tables', 'Come through as lines of text, not a Word table'],
                        ['Images, charts and logos', 'Not included'],
                        ['Headers, footers and page numbers', 'Come through as ordinary text on each page'],
                        ['Scanned pages (photos of text)', 'No text to extract'],
                    ],
                ],
            ],
            [
                'heading' => 'Tidying the Word file afterwards',
                'paragraphs' => [
                    'Because each line of the PDF becomes a separate line inside its paragraph, text you edit will not reflow neatly until you remove those breaks. In Microsoft Word, open Find and Replace, type ^l (a caret and a lower-case L) in the Find box, which stands for a manual line break, and a single space in the Replace box. Run it on a selected paragraph or the whole document, and the lines join into normal flowing paragraphs.',
                    'Then remove repeated headers, footers and page numbers, which appear once per page, and delete page breaks you no longer need. If a heading was missed or a large line was wrongly made a heading, apply the right style from the Styles gallery. Finally, check words that were hyphenated across a line break in the PDF; they may now read as "docu- ment" in the middle of a line.',
                ],
            ],
            [
                'heading' => 'A worked example',
                'paragraphs' => [
                    'Take a three-page job offer letter: a company name in large type at the top, a heading for each section, body text in one column, and a signature line. The large company name and section headings are bigger than the body text, so they become Word headings. The body paragraphs come through as paragraphs with their original line breaks, and the letter is split over three pages as in the PDF.',
                    'What needs attention: the logo at the top is missing, because images are not included, and the footer with the company address appears at the bottom of every page as plain text. Joining the line breaks and deleting the repeated footer takes a few minutes, and the letter is then fully editable.',
                    'A two-column newsletter is a different story. Lines from the left and right columns that sit at the same height are joined into one line, so the text alternates between the two columns. For a document like that, copying each column separately from the PDF, or retyping a short section, may be quicker than fixing the conversion.',
                ],
            ],
            [
                'heading' => 'What about scanned PDFs?',
                'paragraphs' => [
                    'A scanned PDF is just a picture of a page. There is no actual text inside it, only pixels, so a normal converter has nothing to extract. To edit a scanned document you need OCR (optical character recognition), which reads the letters in the image. A quick test: if you cannot select a word in the PDF with your mouse, it is a scan.',
                    'Our converter does not include OCR. If it finds no text at all, it tells you that no text was found and that scanned pages without selectable text cannot be converted, rather than giving you an empty document.',
                ],
            ],
            [
                'heading' => 'Troubleshooting',
                'list' => [
                    '"Password-protected": the PDF is encrypted. Open it with the password and save a copy without one, or use [Unlock PDF](/unlock-pdf) if you know the password, then convert again.',
                    '"Could not be read": the file may be damaged or not really a PDF. Try opening it in a PDF viewer and saving or printing it to a new PDF.',
                    '"No text was found": the pages are scans or images. You need OCR before converting.',
                    'Strange characters or missing letters: some PDFs use embedded fonts without a proper map from shapes to letters, so the text cannot be read back correctly. Copying text from the PDF viewer will usually show the same problem.',
                    'Words run together or split oddly: the PDF placed letters individually. Fix them in Word with spell check, which highlights most of them.',
                    'Large file is slow: the work happens on your device, so a long PDF on an older phone takes longer. A laptop or desktop is faster.',
                ],
            ],
            [
                'heading' => 'Keeping your document private',
                'paragraphs' => [
                    'PDFs often contain contracts, CVs, bank statements and other personal information. Many online converters upload the file to their servers. This converter reads the PDF and builds the Word file entirely in your browser, using the open-source PDF.js library from Mozilla, so the document stays on your device.',
                    'When you have finished editing, [Word to PDF](/word-to-pdf) turns the document back into a PDF that looks the same on every device.',
                ],
            ],
            [
                'heading' => 'Check the result before you rely on it',
                'paragraphs' => [
                    'A conversion rebuilds the document from what the PDF contains, so it can look right and still have small errors. Read through anything important. Look closely at the things that are easiest to get wrong: tables, multi-column text, headers and footers, and special characters.',
                    'Search for the last sentence of the original, and compare the number of pages. If a section is missing, it was probably an image in the PDF rather than text.',
                ],
            ],
            [
                'heading' => 'When not to convert at all',
                'paragraphs' => [
                    'If you only need to change a date or fix a typo, you may not need Word. [Edit PDF](/edit-pdf) changes the existing text directly in the PDF, in its own font, which keeps the layout exactly as it is. Converting back and forth is where formatting usually goes wrong.',
                    'To pull figures out of a table, [PDF to Excel](/pdf-to-excel) is often a better fit, because it keeps rows and columns as cells. When you finish in Word, [Word to PDF](/word-to-pdf) turns it back into a file that looks the same on every device.',
                    'A PDF made by scanning paper is really a picture of text. Tools without text recognition cannot read it, so you get little or nothing back. The quick test: try to select a sentence in your PDF viewer. If you cannot, it is a scan.',
                    'For a simple text document that you do want to rewrite, though, [PDF to Word](/pdf-to-word) saves retyping every paragraph.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Will the Word file look exactly like the PDF?', 'a' => 'No. The text, paragraphs and headings are rebuilt, but fonts, bold and italics, images, columns and tables are not kept. Simple documents come closest.'],
            ['q' => 'Can I convert a scanned PDF to Word?', 'a' => 'Not directly: a scan contains images of text, not text. It needs OCR first.'],
            ['q' => 'Is there a page limit?', 'a' => 'There is no fixed page limit, but the file can be up to 200 MB. Very large PDFs simply take longer, because the work happens on your own device.'],
            ['q' => 'Why does every line end with a break in Word?', 'a' => 'The converter keeps each line of the PDF as a line break inside its paragraph. In Word, replace ^l with a space to join them into flowing text.'],
            ['q' => 'Can I convert a password-protected PDF?', 'a' => 'Not while it is locked. Remove the password first, for example by opening it with the password and saving a copy, then convert the copy.'],
            ['q' => 'Is my PDF uploaded?', 'a' => 'No. The PDF is read and the Word file is built in your browser, so the document never leaves your device.'],
        ],
        'sources' => [
            [
                'title' => 'PDF.js, the PDF renderer by Mozilla',
                'url' => 'https://mozilla.github.io/pdf.js/',
            ],
            [
                'title' => 'Ecma International, ECMA-376 Office Open XML file formats (.docx)',
                'url' => 'https://ecma-international.org/publications-and-standards/standards/ecma-376/',
            ],
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
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'What a QR code is',
                'paragraphs' => [
                    'QR stands for "Quick Response". The format was invented in 1994 by Denso Wave, a Japanese company, to track car parts, and it was later made an international standard. A QR code stores text, such as a web address, in a square grid of black and white modules that any phone camera can read.',
                    'Everything a QR code does comes down to that stored text. A link is just text that starts with https://, and a Wi-Fi code is text in a special format that phones recognise. The phone reads the text and decides what to offer: open a page, join a network, start an email or dial a number.',
                ],
            ],
            [
                'heading' => 'Step by step',
                'list' => [
                    'Open the [QR Code Generator](/qr-code-generator) and pick a tab for what the code should contain: URL, Text, Wi-Fi, Email, Phone or SMS.',
                    'Type or paste the content. The preview updates as you type.',
                    'Open "Customise colours, size and quality" if you want to change the colours, the size, the error correction level or the margin. Keep strong contrast: dark code on a light background.',
                    'Read any warning under the preview, such as colours that are too similar or a margin that is too small, and fix it.',
                    'Click Download PNG for screens and documents, or Download SVG for printing at any size.',
                    'Scan it with at least two different phones before you print anything.',
                ],
            ],
            [
                'heading' => 'What each type of code contains',
                'paragraphs' => ['Each tab builds a different piece of text for the code. Knowing what goes inside helps when a code does not do what you expected.'],
                'table' => [
                    'headers' => ['Tab', 'What you enter', 'What the phone does'],
                    'rows' => [
                        ['URL', 'A web address; https:// is added if you leave it out', 'Offers to open the page'],
                        ['Text', 'Any text', 'Shows the text'],
                        ['Wi-Fi', 'Network name (SSID), security type, password, and whether the network is hidden', 'Offers to join the network'],
                        ['Email', 'Email address, optional subject and message', 'Opens a new email, filled in'],
                        ['Phone', 'Phone number with country code', 'Offers to call the number'],
                        ['SMS', 'Phone number and optional message', 'Opens a text message, filled in'],
                    ],
                ],
            ],
            [
                'heading' => 'Making a Wi-Fi QR code',
                'paragraphs' => [
                    'A Wi-Fi code saves guests from typing a long password. In the Wi-Fi tab, enter the network name exactly as it appears on your router, including capitals and spaces, choose the security type (WPA / WPA2 / WPA3, WEP, or No password), and type the password. Tick Hidden network only if your network does not broadcast its name.',
                    'The generator handles special characters for you: a semicolon, comma, colon, quote mark or backslash in the name or password is escaped so phones read it correctly. If a phone fails to join, the usual cause is a typo in the network name or password, or the wrong security type.',
                    'Remember that the password is stored in the code as plain text. Anyone who can photograph the code can join your network, so for a café or an office lobby, point the code at a guest network rather than your main one.',
                ],
            ],
            [
                'heading' => 'Error correction: why some damage is fine',
                'paragraphs' => [
                    'QR codes contain extra data so they still scan when part of the code is dirty, torn or covered. There are four levels: L restores about 7 percent of the code, M about 15 percent, Q about 25 percent and H about 30 percent. Level M is the most common choice, and it is the default in our generator, where the levels are labelled Low, Medium, Quartile and High.',
                    'A higher level makes the code denser but tougher, which is useful for codes that will be printed on packaging or placed outdoors. The trade-off is capacity: the same text needs more modules at level H than at level L. If the generator says there is too much data for one QR code, shorten the text or choose a lower level.',
                ],
            ],
            [
                'heading' => 'Size, contrast and placement',
                'list' => [
                    'Print it large enough: about 2 x 2 cm is a practical minimum for a short link held close to the camera; bigger for posters seen from a distance.',
                    'Keep a quiet zone, a plain margin around the code, so the camera can find its edges. The generator\'s default margin is 4 modules, which is the width the QR standard calls for.',
                    'Use dark modules on a light background. Inverted or low-contrast codes fail on many phones.',
                    'Keep the content short. A short link produces a simpler code that scans faster.',
                    'Avoid curved or shiny surfaces where possible; glare and bending distort the grid.',
                ],
            ],
            [
                'heading' => 'How big should a printed QR code be?',
                'paragraphs' => [
                    'A common rule of thumb is that a code can be scanned from about ten times its own width. By that rule, a 2 cm code on a business card works at arm\'s length, while a code on a poster that people will read from 2 metres away should be around 20 cm across. Treat this as a starting point and test at the real distance, because lighting, camera quality and how much data the code holds all make a difference.',
                    'Pixel size and print size are linked by the printer\'s resolution. Our PNG download is 512 x 512 pixels by default, and the size slider goes from 128 to 1,024 pixels in steps of 32. At 300 dots per inch, a 512-pixel image prints at about 1.7 inches, or 4.3 cm, before it starts to blur. For anything larger, or when you are not sure, use the SVG download: it is a vector file, so it stays sharp at any size.',
                ],
            ],
            [
                'heading' => 'Colours that still scan',
                'paragraphs' => [
                    'You can change the QR colour and the background, but the camera still needs to tell them apart. The generator measures the contrast between the two colours and shows a warning when they are too similar for many phones to read. It also warns when the code is lighter than its background, because light-on-dark codes do not scan on some phones.',
                    'A safe approach is a very dark brand colour for the code, such as navy or deep green, on white or a very pale background. Test colour codes on paper, since printed colours often come out darker or duller than on screen.',
                ],
            ],
            [
                'heading' => 'Static codes never expire',
                'paragraphs' => [
                    'The codes made here are static: the link or text is stored inside the code itself, so the code works forever and does not depend on any service staying online. The trade-off is that you cannot change the destination after printing. If you might need to, point the code at a page on your own website that you can update.',
                    'The code is drawn in your browser by an open-source QR library, so the text you type, including a Wi-Fi password, is not sent to our server.',
                ],
            ],
            [
                'heading' => 'What to put in the code',
                'paragraphs' => [
                    'Shorter data makes a simpler pattern that is easier to scan from further away. A short web address beats a long one with tracking parameters. Our test code for a web address came out as a 512 x 512 PNG of 8.6 KB; for print, use the SVG download, which stays sharp at any size.',
                    'If the address might change, point the code at a page you control and can redirect, because a static code cannot be edited after printing. Resize the PNG for a slide or web page with the [Image Resizer](/image-resizer) rather than stretching it in a design tool, which can blur the edges. To put one or more codes on a printable page, [JPG to PDF](/jpg-to-pdf) can turn the image into a PDF.',
                ],
            ],
            [
                'heading' => 'Test it properly before printing',
                'paragraphs' => [
                    'A code that scans on your laptop screen can still fail on a poster. Print one at the real size and try it with two or three different phones, in normal light and from the distance people will actually stand.',
                    'Common causes of failure are too little contrast, a dark code on a dark background, a code printed too small, and a missing quiet zone: the empty margin around the code that scanners need. Keep that margin clear. Light codes on dark backgrounds also fail on some older scanner apps.',
                ],
            ],
            [
                'heading' => 'Troubleshooting a code that will not scan',
                'list' => [
                    'The phone sees nothing: make the code bigger, add more light, or move the camera further back so the whole code and its margin fit in the frame.',
                    'It scans on one phone but not another: raise the contrast, return to black on white, and check the margin is at least 4 modules.',
                    'It opens the wrong page: check the address for typos and make sure it works when typed into a browser.',
                    'The Wi-Fi code does not connect: re-type the network name and password exactly, and check the security type.',
                    'The generator reports too much data: shorten the text or link, or lower the error correction level.',
                    'It printed blurry: go back to the [QR Code Generator](/qr-code-generator) and download the SVG instead of the PNG, or generate the PNG at a larger size.',
                ],
            ],
            [
                'heading' => 'Be careful what you scan',
                'paragraphs' => [
                    'QR codes hide their destination, which scammers exploit by sticking fake codes over real ones on parking meters and restaurant tables. Check the address your phone shows before you open it, and never enter a password or card number on a page you reached that way unless you are sure of it.',
                    'If you run a shop or restaurant, check your printed codes from time to time to make sure nobody has covered them with a sticker.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Do these QR codes expire?', 'a' => 'No. The content is stored inside the code, so it keeps working as long as the link it points to works.'],
            ['q' => 'Can I add a logo to a QR code?', 'a' => 'The generator does not add logos. A small logo placed over the centre in a design tool can work with a high error correction level, but always test it on several phones before printing.'],
            ['q' => 'PNG or SVG?', 'a' => 'PNG for websites and documents, SVG for printing because it stays sharp at any size.'],
            ['q' => 'Can I make a contact card (vCard) QR code?', 'a' => 'There is no contact-card tab. You can use the Email, Phone or SMS tabs to let people reach you in one tap, or the Text tab for any other text.'],
            ['q' => 'Can I track how many people scan my code?', 'a' => 'Not with a static code, because the phone goes straight to your link without passing through any tracking service. If you need numbers, use a link on your own site whose visits you can measure.'],
            ['q' => 'What error correction level should I choose?', 'a' => 'Medium (15%) suits most codes. Choose Quartile or High for codes that may get scratched, dirty or partly covered, and Low only when you need to fit a lot of data.'],
        ],
        'sources' => [
            [
                'title' => 'DENSO WAVE, History of QR Code',
                'url' => 'https://www.qrcode.com/en/history/',
            ],
            [
                'title' => 'DENSO WAVE, QR Code error correction feature',
                'url' => 'https://www.qrcode.com/en/about/error_correction.html',
            ],
        ],
    ],

    'how-to-calculate-percentages' => [
        'title' => 'How to Calculate Percentages: Formulas and Examples',
        'description' => 'The three percentage formulas you actually need, with worked examples for discounts, tips, grades and percentage change, plus common mistakes to avoid.',
        'h1' => 'How to calculate percentages',
        'intro' => 'Percentages show up in shopping discounts, restaurant tips, exam scores, pay rises, tax and price increases. Almost every percentage question is one of three simple calculations, plus two close relatives: working backwards to the original number, and adding or taking off a percentage. Learn those and you can handle nearly anything, with or without a calculator. This guide gives each formula, worked examples with the arithmetic shown, and the mistakes that catch people out.',
        'tool' => 'percentage-calculator',
        'related' => ['tip-calculator', 'loan-calculator', 'mortgage-calculator'],
        'published' => '2026-10-10',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'What "percent" means',
                'paragraphs' => [
                    'Percent means "per hundred". 25 percent is 25 out of every 100, which is the same as the fraction 25/100 or the decimal 0.25. To turn a percentage into a decimal, divide it by 100; to turn a decimal into a percentage, multiply by 100.',
                    'Fractions work the same way. To turn 3/8 into a percentage, divide 3 by 8 to get 0.375, then multiply by 100: 37.5%. Keeping this conversion in mind makes every formula below easier, because most percentage sums are really multiplication by a decimal.',
                ],
                'table' => [
                    'headers' => ['Percentage', 'Decimal', 'Fraction', 'Quick way to find it'],
                    'rows' => [
                        ['1%', '0.01', '1/100', 'Divide by 100'],
                        ['10%', '0.1', '1/10', 'Divide by 10'],
                        ['12.5%', '0.125', '1/8', 'Divide by 8'],
                        ['25%', '0.25', '1/4', 'Divide by 4'],
                        ['50%', '0.5', '1/2', 'Divide by 2'],
                        ['75%', '0.75', '3/4', 'Divide by 4, then multiply by 3'],
                    ],
                ],
            ],
            [
                'heading' => '1. What is X% of a number?',
                'paragraphs' => [
                    'Multiply the number by the percentage and divide by 100. 20% of 80 is 80 x 20 / 100 = 16. A quick mental trick: 10% is the number divided by 10, so 20% is twice that, and 5% is half of it.',
                    'Another handy trick is that X% of Y is the same as Y% of X. 8% of 50 looks awkward, but 50% of 8 is obviously 4, and both answers are the same.',
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
                    'The order matters: the part goes on top and the whole underneath. If you spend 900 of a 2,400 monthly income on rent, that is 900 / 2,400 x 100 = 37.5%. Flip the numbers and you get 266.67%, which is clearly not a share of anything.',
                ],
            ],
            [
                'heading' => '3. Percentage increase or decrease',
                'paragraphs' => [
                    'Subtract the old value from the new value, divide by the old value and multiply by 100. A price that goes from 50 to 60 has risen by (60 - 50) / 50 x 100 = 20%. A price that falls from 60 to 45 has dropped by (45 - 60) / 60 x 100 = -25%, a 25% decrease.',
                    'A school example: a test score goes from 62 to 74. The change is 12, and 12 / 62 x 100 = 19.35% to two decimal places. Notice that it is not 12%: the 12 marks are measured against where you started.',
                    'Percentage change from zero has no answer, because you cannot divide by zero. If a new product sold nothing last month and 40 units this month, describe the change in units instead.',
                ],
            ],
            [
                'heading' => '4. Working backwards: X is Y% of what?',
                'paragraphs' => [
                    'Sometimes you know the part and the percentage but not the original number. Divide the part by the percentage as a decimal. If 25 is 20% of a number, the number is 25 / 0.2 = 125.',
                    'This is the formula people need most often without realising it. You paid 60 for a jacket after a 25% discount; what was the original price? You paid 75% of it, so the original was 60 / 0.75 = 80. A common wrong answer is to add 25% to 60, which gives 75 and is too low, because the 25% was taken from the bigger, original price.',
                    'Prices that include sales tax or VAT work the same way. A price of 54 including 20% VAT is 120% of the price before tax, so the pre-tax price is 54 / 1.2 = 45 and the tax is 9. Taking 20% off 54 gives 43.20, which is wrong for the same reason.',
                ],
            ],
            [
                'heading' => '5. Adding or taking off a percentage',
                'paragraphs' => [
                    'To increase a number by a percentage, multiply it by 1 plus the percentage as a decimal. To decrease it, multiply by 1 minus the decimal. Increasing 50 by 20% gives 50 x 1.2 = 60; decreasing 50 by 20% gives 50 x 0.8 = 40.',
                    'This one-step method is faster than working out the percentage and then adding or subtracting it, and it is the key to every multi-step problem: a 3% pay rise on 2,800 is 2,800 x 1.03 = 2,884.',
                ],
            ],
            [
                'heading' => 'Worked examples from everyday life',
                'paragraphs' => [
                    'A jacket costs $80 and is 25% off. The discount is 80 x 0.25 = $20, so you pay $60. A quicker way is to multiply by what is left: 80 x 0.75 = 60.',
                    'A restaurant bill is $64 and you leave 18%: 64 x 0.18 = $11.52, for a total of $75.52. The [Tip Calculator](/tip-calculator) does this and splits it between people.',
                    'Your pay rises from $3,200 to $3,400 a month. The change is 200, and 200 / 3,200 x 100 = 6.25%. Always divide by the old value, not the new one.',
                    'You answered 8 out of 10 questions correctly on one quiz (80%) and 36 out of 40 on another (90%). Your overall score is not the average of 80 and 90. Add up the marks instead: 44 out of 50, which is 88%, because the second quiz had four times as many questions.',
                ],
            ],
            [
                'heading' => 'Common mistakes',
                'list' => [
                    'A rise and a fall of the same percentage do not cancel out: 100 up 10% is 110, and 110 down 10% is 99.',
                    'Always divide by the original value when working out a change, not the new one.',
                    'Two discounts multiply, they do not add: 20% off then another 10% off is 28% off in total, not 30%.',
                    'Percentage points are not percent: an interest rate moving from 3% to 4% is a rise of 1 percentage point, but 33% in relative terms.',
                    'To remove a percentage that was added, divide; do not subtract the same percentage again.',
                    'Averaging percentages from groups of different sizes gives the wrong total; add the underlying numbers first.',
                ],
            ],
            [
                'heading' => 'Why percentages do not add up the way you expect',
                'paragraphs' => [
                    'A 50% rise followed by a 50% fall does not bring you back to where you began. Start at 100: up 50% is 150, and down 50% is 75. The second percentage is taken from a bigger number, so the fall is larger than the rise.',
                    'It is the same with stacked discounts. 20% off and then another 10% off is not 30% off. Multiply instead: 0.8 x 0.9 = 0.72, which is 28% off.',
                    'Growth over several years compounds the same way. Something that grows 10% a year for three years grows by 1.1 x 1.1 x 1.1 = 1.331, a total rise of 33.1%, not 30%. Savings and debts follow this rule, which is what the [Compound Interest Calculator](/compound-interest-calculator) works out year by year.',
                ],
            ],
            [
                'heading' => 'Percent versus percentage points',
                'paragraphs' => [
                    'If a loan rate goes from 4% to 5%, it rose by one percentage point, but by 25% in relative terms, because 1 is a quarter of 4. News stories and adverts often use whichever sounds bigger, so check which one you are reading.',
                    'This matters when you compare offers. A rate quoted in the [Loan Calculator](/loan-calculator) is a percentage of the balance, and a small change in points can mean a large change in what you pay over the years.',
                    'A percentage of a percentage is a third trap. If 40% of a class chose science, and 25% of those chose physics, then 0.4 x 0.25 = 0.1, so 10% of the whole class chose physics.',
                ],
            ],
            [
                'heading' => 'Let the calculator do it',
                'paragraphs' => [
                    'The [Percentage Calculator](/percentage-calculator) on this site has a separate box for each of the five questions in this guide: what is X% of Y, X is what percent of Y, percentage increase or decrease, X is Y% of what number, and increase or decrease a number by a percentage. Each result shows the formula it used, so you can check the working, and the last box also shows the difference between the old and new number.',
                    'You can type numbers with a comma or a point as the decimal separator, such as 1,234.5 or 1.234,5, and a trailing % sign is ignored. Results are shown to up to six decimal places. If a calculation would mean dividing by zero, such as a percentage change from a starting value of 0, the calculator says so instead of showing a meaningless number.',
                    'For splitting a bill, the [Tip Calculator](/tip-calculator) does the percentage and the division in one go.',
                ],
            ],
            [
                'heading' => 'A quick checklist before you trust an answer',
                'list' => [
                    'Ask what the percentage is "of": the original price, the new price or the total.',
                    'Estimate first. 19% of 300 should be a little under 60; if you get 570, a decimal point has moved.',
                    'For a change, check you divided by the starting value.',
                    'For several steps, multiply the factors rather than adding the percentages.',
                    'Run the numbers through the [Percentage Calculator](/percentage-calculator) and compare its formula with yours.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'How do I work out 15% of a number in my head?', 'a' => 'Find 10% by dividing by 10, then add half of that again. For 60: 10% is 6, half of 6 is 3, so 15% is 9.'],
            ['q' => 'How do I calculate a discount price?', 'a' => 'Multiply the price by (100 - discount) / 100. A 25% discount on 80 is 80 x 0.75 = 60.'],
            ['q' => 'What is the difference between percent and percentage points?', 'a' => 'Percentage points measure the gap between two percentages (3% to 4% is 1 point). Percent change measures it relative to the start (a 33% increase).'],
            ['q' => 'How do I find the original price before a discount?', 'a' => 'Divide the price you paid by what was left after the discount. After 25% off you pay 75%, so a sale price of 60 means an original price of 60 / 0.75 = 80.'],
            ['q' => 'How do I remove VAT or sales tax from a price?', 'a' => 'Divide by 1 plus the tax rate. A price of 54 including 20% VAT is 54 / 1.2 = 45 before tax, so the tax is 9.'],
            ['q' => 'Can a percentage be more than 100?', 'a' => 'Yes, when the part is bigger than the whole or a value more than doubles. A price going from 20 to 50 has risen by 150%.'],
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
                    'No. Merging copies the pages exactly as they are; it does not re-compress images or re-render text, so there is no loss of quality. The combined file is roughly the sum of the originals\' sizes, give or take a small amount of overhead from the file structure. If the result is too large to email, run it through the [Compress PDF](/compress-pdf) tool afterwards rather than before, so you only need to compress once.',
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
                    'If a file has pages in the wrong order, or pages you do not need, fix it first with [Organize PDF](/organize-pdf). Photos or scans saved as images can become PDF pages with [JPG to PDF](/jpg-to-pdf) and then be merged like any other file.',
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
                    'The [Mortgage Calculator](/mortgage-calculator) on this site runs the exact formula above, shows a full year-by-year amortization schedule, and lets you add an extra monthly payment to see how many months sooner the loan is paid off. For a loan that is not tied to a home purchase - a car, personal or student loan - the [Loan Calculator](/loan-calculator) uses the same math without a down payment field.',
                    'Both calculators run entirely in your browser, so the numbers you enter - loan amount, rate, term - are never sent to a server. That makes them a quick, private way to sanity-check a lender\'s pre-approval letter or compare two offers side by side before you commit to either one.',
                    'To see how the same money would grow if you saved or invested it instead, try the [Compound Interest Calculator](/compound-interest-calculator).',
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
                    'The [Image Resizer](/image-resizer) on this site resizes to an exact pixel width and height, or by percentage, and converts between JPG, PNG and WebP - all in your browser, so the original photo is never uploaded anywhere.',
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
                    'If a platform still rejects the file for its size, shrink it with the [Image Compressor](/image-compressor). For a profile picture or product photo with a busy background, the [Background Remover](/remove-background) cuts the subject out first.',
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
                    'The [Watermark PDF](/watermark-pdf) tool on this site runs entirely in your browser: the file is opened, watermarked and saved on your own device, and is never uploaded anywhere. That matters for anything confidential, since a draft contract or HR letter is exactly the kind of file you are watermarking in the first place.',
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
                    'A watermark discourages copying but does not stop anyone opening the file; to control who can open it, add a password with [Protect PDF](/protect-pdf). To watermark several documents in one go, combine them first with [Merge PDF](/merge-pdf).',
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
                    'Open the [Edit PDF](/edit-pdf) tool and choose your file.',
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
                    'If the document needs a signature after your edits, add it with [Sign PDF](/sign-pdf). To hide sensitive text for good rather than change it, use [Redact PDF](/redact-pdf), which removes the text instead of only covering it.',
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
                    'That is the opposite of how the [Edit PDF](/edit-pdf) tool\'s in-place text editing works. When you click a line of real text and retype it, the old glyphs are deleted from the content stream and new ones are drawn in their place, so there is nothing left behind. Whiteout is simpler and works on anything - text, a logo, a signature, a scanned stamp - because it does not need to understand what it is covering, it only needs to know where to draw a box.',
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
                    'Proper redaction is a different operation: it has to delete the hidden content from the file, not just draw over it, which is what the [Redact PDF](/redact-pdf) tool is for. Use whiteout for anything cosmetic - cleaning up a scan, removing an old date stamp, hiding a logo on a sample document you are sharing internally. Use redaction, not whiteout, the moment the hidden content is a name, account number, address, signature or anything else that would matter if someone else recovered it.',
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
                    'To mark a document as a draft or confidential instead of hiding parts of it, stamp text across every page with [Watermark PDF](/watermark-pdf).',
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

    'how-to-redact-a-pdf-properly' => [
        'title' => 'How to Redact a PDF Properly (Free & Permanent)',
        'description' => 'Learn why a black box is not real redaction, and how to permanently remove sensitive text or images from a PDF for free, right in your browser.',
        'h1' => 'How to redact a PDF properly',
        'intro' => 'Redacting a PDF means permanently removing something sensitive - a name, an account number, a photo - not just hiding it under a black rectangle. A huge number of real-world privacy leaks have come from exactly that mistake: someone drew a box over text in a PDF viewer, shared the file, and the original text was still sitting underneath, ready to be copied out or extracted with a script. Here is what actually makes redaction permanent, and how to do it correctly without uploading the file anywhere.',
        'tool' => 'redact-pdf',
        'related' => ['edit-pdf', 'sign-pdf', 'merge-pdf'],
        'published' => '2026-10-29',
        'updated' => '2026-10-29',
        'sections' => [
            [
                'heading' => 'Why covering text with a box usually fails',
                'paragraphs' => [
                    'A PDF page is not a flat picture - it is a set of instructions: draw this text at this position, in this font, then draw this shape, then draw more text on top. When you add a black rectangle "over" a line of text in a typical PDF viewer or editor, you are only adding one more instruction to that list; the original text instruction is still there, underneath, in the exact same file. Open the file in a different viewer, select all the text, zoom in at a different scale, or run a script that reads text positions, and the "redacted" words can reappear - because they were never removed, only drawn over.',
                    'This is not a theoretical risk. It is the single most common way redaction fails in practice, because the black box looks completely convincing to the human eye while doing nothing to the underlying content. The only way to be sure something is actually gone is to remove the instructions that drew it in the first place, not add a new instruction on top of them.',
                ],
            ],
            [
                'heading' => 'What real redaction has to do',
                'paragraphs' => [
                    'Proper redaction has to delete the original content from the page, not cover it. One reliable way to guarantee that is to flatten the page: render it to a plain image and replace the page\'s content with that image. Once a page is an image, there is no text to select, no vector shape to extract and no font data to read - what you see pixel-for-pixel is all that remains, and the box you drew is now part of the picture rather than a separate layer sitting on top of recoverable text.',
                    'The trade-off is that a flattened page loses its selectable, searchable text entirely, even in the parts you did not mark. That is an acceptable cost for a page that contains something sensitive, and it is why a proper redaction tool only flattens the pages you actually mark, leaving every other page exactly as it was - full quality, real text, nothing lost.',
                ],
            ],
            [
                'heading' => 'Redacting a PDF, step by step',
                'paragraphs' => [
                    'This runs entirely in your browser - the file is opened, redacted and saved on your own device and never sent to a server.',
                ],
                'list' => [
                    'Open the [Redact PDF](/redact-pdf) tool and choose your file.',
                    'Draw a box over anything on the current page you need to permanently remove - a line of text, a signature, a photo.',
                    'Add as many boxes as you need on that page, then move to the next page and repeat for anything else that needs removing.',
                    'Move, resize, or remove a box before you finish, if you drew it slightly off.',
                    'Click Redact PDF - every page with at least one box is flattened into an image; every other page is left untouched.',
                    'Download the result and verify it (see the checklist below) before you share or delete the original.',
                ],
            ],
            [
                'heading' => 'Checking your work before you share the file',
                'paragraphs' => [
                    'A redacted file deserves a second look before it goes anywhere, because the whole point is that a mistake here cannot be quietly fixed later - once you have shared the file, whatever was supposed to be removed may already be out.',
                ],
                'list' => [
                    'Open the downloaded file and try to select text over a redacted area in your PDF reader - on a properly flattened page, nothing should be selectable anywhere on that page, including outside your box.',
                    'Zoom in on the edges of every box to confirm the covered area is fully inside it, with a small margin, not trimmed right to the pixel.',
                    'Check the file\'s document properties (title, author, subject, keywords) separately - redacting page content does not touch metadata, and a name or company in the "Author" field can leak the same information you just removed from the page.',
                    'Keep the original file somewhere private until you are certain the redacted copy is correct; do not overwrite your only copy before checking.',
                ],
            ],
            [
                'heading' => 'Redaction vs. other ways to hide content',
                'paragraphs' => [
                    'Not every cover-up needs full redaction, and it helps to know when a lighter tool is actually appropriate.',
                    'Before you share the redacted file, you can also lock it with a password using [Protect PDF](/protect-pdf). If you only need to correct wording rather than remove it, [Edit PDF](/edit-pdf) is the right tool.',
                ],
                'table' => [
                    'headers' => ['What you are hiding', 'Right tool', 'Why'],
                    'rows' => [
                        ['A social security, account or passport number', 'Redact PDF', 'Must be deleted from the file, not just covered'],
                        ['A signature or a photo of a person', 'Redact PDF', 'Same risk as above - the image data stays recoverable if only covered'],
                        ['An old stamp or a mark on a scan you are keeping internally', 'Whiteout (inside Edit PDF)', 'Cosmetic only - nothing sensitive underneath'],
                        ['A watermark or stamp you want added, not removed', 'Watermark PDF or Edit PDF', 'A different job entirely - adding, not hiding'],
                    ],
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Is drawing a black box over text in a PDF the same as redacting it?', 'a' => 'No. A box drawn in most editors only sits on top of the original content, which is usually still present underneath and can be copied, selected or extracted. Real redaction has to remove that content, typically by flattening the page into an image.'],
            ['q' => 'Does redacting a page affect the rest of the document?', 'a' => 'No. Only the pages you mark are flattened into images; every page without a redaction box keeps its original text, images and quality exactly as they were.'],
            ['q' => 'Does redaction remove hidden metadata, like the author name?', 'a' => 'No. Redacting page content and clearing document metadata are two separate things. Check the file\'s properties (title, author, subject) separately if that information also needs to go.'],
        ],
        'sources' => [
            ['title' => 'pdf-lib, create and modify PDF documents in JavaScript', 'url' => 'https://pdf-lib.js.org/'],
            ['title' => 'Mozilla, PDF.js - a PDF renderer and text extraction library', 'url' => 'https://mozilla.github.io/pdf.js/'],
        ],
    ],

    'how-to-split-a-pdf-into-separate-files' => [
        'title' => 'How to Split a PDF Into Separate Files (Free)',
        'description' => 'Split a PDF into separate files or pull out specific pages for free, right in your browser. Step-by-step instructions, page-range syntax, and common mistakes.',
        'h1' => 'How to split a PDF into separate files',
        'intro' => 'A single PDF often holds more than you actually need: a 40-page contract when you only have to send page 12, or a scanned bundle that should really be five separate files. Splitting a PDF - pulling pages out, or dividing one document into several - is one of the most common things people need to do to a PDF and one of the easiest to get wrong by hand. Here is how to do it correctly, with no software to install and nothing uploaded anywhere.',
        'tool' => 'split-pdf',
        'related' => ['merge-pdf', 'rotate-pdf', 'compress-pdf'],
        'published' => '2026-10-31',
        'updated' => '2026-10-31',
        'sections' => [
            [
                'heading' => 'Splitting vs. extracting: two different jobs',
                'paragraphs' => [
                    'People use "split a PDF" to mean two different things, and picking the wrong one wastes time. Extracting pulls specific pages out of a document into one new, smaller PDF - useful when you only need pages 4 to 9 of a long report and can throw the rest away. Splitting by ranges divides a document into several separate files at the points you choose - useful when one PDF is really three invoices stapled together and each one needs to stand alone. A third variant, splitting every page, turns an N-page PDF into N single-page files, which comes up more than you would expect: scanning software often produces one combined PDF for a stack of separate forms, and each form needs to be its own file before it can be filed or emailed individually.',
                ],
            ],
            [
                'heading' => 'Splitting a PDF, step by step',
                'paragraphs' => [
                    'This runs entirely in your browser using the [Split PDF](/split-pdf) tool - the file is opened, split and saved on your own device and never sent to a server.',
                ],
                'list' => [
                    'Open Split PDF and choose the file you want to split.',
                    'Pick a mode: extract pages into one PDF, split by ranges into separate files, or split every page into its own file.',
                    'For extract or split-by-range mode, type the page ranges you need (see the syntax below).',
                    'Click Split PDF.',
                    'Download the result - a single range downloads as one PDF, multiple ranges or "split every page" download together as a ZIP file.',
                ],
            ],
            [
                'heading' => 'How to write page ranges',
                'paragraphs' => [
                    'Page ranges use a simple, consistent syntax that most PDF tools share, so it is worth learning once.',
                ],
                'table' => [
                    'headers' => ['You type', 'What it means'],
                    'rows' => [
                        ['5', 'Page 5 only'],
                        ['1-3', 'Pages 1, 2 and 3'],
                        ['1-3, 7', 'Pages 1, 2, 3 and 7, as one file'],
                        ['1-3, 7, 10-12', 'Pages 1-3, 7, and 10-12, as one file (in extract mode) or three separate files (in split-by-range mode)'],
                    ],
                ],
            ],
            [
                'heading' => 'What goes wrong, and how to avoid it',
                'paragraphs' => [
                    'Most split-PDF mistakes come from page numbers that do not mean what they look like.',
                ],
                'list' => [
                    'The page number in the tool is always the physical position in the file, counting the first page as 1 - it ignores any page numbers printed on the page itself. A document with a cover page and a "page 1" printed on the second sheet means you want page 2, not page 1, for the start of the content.',
                    'Double-booklet or front-and-back scans sometimes list pages out of order in the file (for example 1, 3, 5, 2, 4, 6) even though they display correctly - check a preview before trusting the range, not just the total page count.',
                    'Ranges with a hyphen are always ordered low-to-high; "9-4" will not give you pages 9 down to 4 in reverse, so reorder pages first if you need them in a different sequence.',
                    'Splitting does not shrink a file in proportion to the pages removed if the PDF shares embedded resources (like one large background image) across every page - each extracted page still carries a copy of anything it uses. Run the result through [Compress PDF](/compress-pdf) afterward if size matters.',
                ],
            ],
            [
                'heading' => 'Does splitting affect quality?',
                'paragraphs' => [
                    'No. Splitting copies the page content exactly as it exists in the original - the same text, fonts and images at the same resolution - so nothing is re-rendered, re-compressed or redrawn. This is different from converting a PDF to images and back, which can introduce blur or a loss of searchable text. If a split file needs to be smaller for email, compress it as a separate step rather than expecting the split itself to reduce size.',
                ],
            ],
            [
                'heading' => 'After splitting: putting files back together',
                'paragraphs' => [
                    'It is common to split a document, work on individual pages, and then need to recombine some of them - or to realize a page belongs in a different grouping than you first split it into. [Merge PDF](/merge-pdf) joins any number of PDFs back into one file in the order you choose, and [Rotate PDF](/rotate-pdf) fixes any pages that came out sideways from a scanned original before you send the final files.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'How do I pull just one page out of a PDF?', 'a' => 'Choose "Extract pages" in Split PDF, type the single page number (for example 4), and click Split PDF. You get a new PDF containing only that page.'],
            ['q' => 'What is the difference between extracting pages and splitting by ranges?', 'a' => 'Extracting collects the pages you list into one new PDF. Splitting by ranges produces a separate PDF for each range you type, so "1-3, 7, 10-12" becomes three distinct files instead of one.'],
            ['q' => 'Will splitting a PDF reduce its file size?', 'a' => 'Each resulting file will usually be smaller than the original simply because it has fewer pages, but splitting does not compress anything. If a split file is still too large, run it through a PDF compressor afterward.'],
        ],
        'sources' => [
            ['title' => 'pdf-lib, create and modify PDF documents in JavaScript', 'url' => 'https://pdf-lib.js.org/'],
            ['title' => 'Library of Congress, Sustainability of Digital Formats: PDF', 'url' => 'https://www.loc.gov/preservation/digital/formats/fdd/fdd000030.shtml'],
            ['title' => 'Adobe, How to split a PDF into multiple files', 'url' => 'https://www.adobe.com/acrobat/how-to/split-pdf-pages.html'],
        ],
    ],

    'how-to-sign-a-pdf-online' => [
        'title' => 'How to Sign a PDF Online for Free',
        'description' => 'Sign a PDF online for free by drawing, typing or uploading your signature, and learn the real difference between an electronic and a digital signature.',
        'h1' => 'How to sign a PDF online',
        'intro' => 'Printing a PDF, signing it by hand and scanning it back in is slower than just signing it on screen - and for most everyday agreements, an on-screen signature is just as valid. The confusing part is that "electronic signature" and "digital signature" are not the same thing, and knowing which one a document actually needs matters more than which tool you click through. Here is how to sign a PDF online for free, and how to tell whether that is enough for the document in front of you.',
        'tool' => 'sign-pdf',
        'related' => ['edit-pdf', 'redact-pdf', 'merge-pdf'],
        'published' => '2026-11-01',
        'updated' => '2026-11-01',
        'sections' => [
            [
                'heading' => 'Electronic signature vs digital signature: the difference that matters',
                'paragraphs' => [
                    'An electronic signature is simply a mark - a drawn squiggle, a typed name in a script font, or a scanned image of your handwritten signature - placed onto a document to show you agreed to it. It proves intent but carries no built-in cryptographic proof of who signed or whether the file changed afterward.',
                    'A digital signature is a different, cryptographic mechanism: it uses a certificate tied to a verified identity to create a tamper-evident seal on the exact bytes of the file, so a PDF reader can show whether the document was altered after signing. Most everyday paperwork - approving a quote, countersigning a letter, initialing a form - only needs an electronic signature. Contracts tied to specific legal or regulatory requirements, or anything that must prove the file was never altered after signing, may need a certificate-based digital signature instead, which is a separate service from simply placing a signature image on a page.',
                ],
            ],
            [
                'heading' => 'Signing a PDF online, step by step',
                'paragraphs' => [
                    'This creates an electronic signature - a signature image placed on the page - entirely in your browser, with the file never uploaded anywhere.',
                ],
                'list' => [
                    'Open the [Sign PDF](/sign-pdf) tool and choose the PDF you need to sign.',
                    'Pick how you want to create your signature: draw it with a mouse or finger, type your name in a signature-style font, or upload a photo of your signature.',
                    'Click "Add signature to this page", then drag it into place and resize it so it fits naturally where a handwritten signature would go.',
                    'Switch pages if the document needs your signature in more than one place, and add it again on each page.',
                    'Tick "Add today\'s date" if the document should show when it was signed.',
                    'Click Sign PDF and download the signed file.',
                ],
            ],
            [
                'heading' => 'Drawn, typed or uploaded - which looks best',
                'table' => [
                    'headers' => ['Method', 'Best for', 'Common mistake'],
                    'rows' => [
                        ['Draw with mouse/trackpad', 'A quick signature on a laptop', 'Drawing too small, then it looks shaky when enlarged - draw bigger than needed'],
                        ['Draw with a finger on phone/tablet', 'The most natural-looking result for most people', 'Rushing the stroke; a slightly slower draw reads more like real handwriting'],
                        ['Type your name', 'Speed, or when you don\'t want to draw at all', 'Looks visibly "generated" - fine for internal approvals, less convincing on formal documents'],
                        ['Upload a photo of your signature', 'Reusing the same signature everywhere', 'A shadowed or off-white background leaves a grey box; crop tightly and use good lighting'],
                    ],
                ],
            ],
            [
                'heading' => 'Three things to get right before you send it',
                'paragraphs' => [
                    'Check the signature is actually on the page, not floating over the wrong spot. Zoom in after placing it - a signature that overlaps a line of printed text or sits outside the signature box looks careless and can make a reviewer send the document back.',
                    'If you uploaded a signature image, use one with a transparent or clean white background. A photo taken on a patterned desk or with a visible paper edge leaves a faint box around your name once it is placed on the page.',
                    'Match the number of signature placements to what the document actually asks for. Some contracts need initials on every page plus a full signature at the end - skimming past an initial line is one of the most common reasons a signed document gets rejected and has to be resent.',
                    'If a typo turns up while you are checking it over, fix it directly in the file with [Edit PDF](/edit-pdf) rather than redoing the signature - correcting the text afterward does not disturb the signature you already placed.',
                ],
            ],
            [
                'heading' => 'When an electronic signature is not enough',
                'paragraphs' => [
                    'In the United States, the federal ESIGN Act gives electronic signatures the same legal standing as a handwritten one for most contracts, as long as both sides consented to sign electronically. In the EU, the eIDAS Regulation recognizes electronic signatures too, but it also defines stronger categories - advanced and qualified electronic signatures - that carry more legal weight and are sometimes required for specific transactions, such as certain property, inheritance or company-formation documents.',
                    'If a lawyer, bank, government agency or counterparty has told you the document needs a "digital signature," "qualified electronic signature" or notarization, check with them before relying on a simple signature image - those usually require a dedicated certificate-based signing service, not a signature drawn onto a PDF.',
                ],
            ],
            [
                'heading' => 'Checklist before you send a signed PDF',
                'list' => [
                    'Open the saved file and confirm the signature appears on every page it needs to, at full size with no clipping.',
                    'Check the date stamp, if you added one, shows the correct date.',
                    'Confirm you signed (and initialed, if required) every place the document asks for, not just the final page.',
                    'For anything legally sensitive, confirm an electronic signature is actually sufficient for this specific document before you send it.',
                    'Keep a copy of the signed file for your own records before sending it on.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Is a signature added this way legally binding?', 'a' => 'It is an electronic signature, which the US ESIGN Act and the EU eIDAS Regulation both give legal recognition for most everyday agreements. It is not a certificate-based digital signature, so check what a specific contract, bank or authority requires if the stakes are high.'],
            ['q' => 'Which looks more genuine: drawing, typing or uploading my signature?', 'a' => 'Drawing with a finger on a phone or tablet usually looks closest to a real handwritten signature. Typing your name in a script font is faster but looks visibly generated, which is fine for internal approvals but less convincing on formal documents.'],
            ['q' => 'Is my PDF uploaded to a server to sign it?', 'a' => 'No. Drawing, placing and saving the signature all happen in your browser with JavaScript, and the file is never sent anywhere.'],
        ],
        'sources' => [
            ['title' => 'Cornell Law School, 15 U.S. Code §7001 - the ESIGN Act', 'url' => 'https://www.law.cornell.edu/uscode/text/15/7001'],
            ['title' => 'European Commission, the eIDAS Regulation', 'url' => 'https://digital-strategy.ec.europa.eu/en/policies/eidas-regulation'],
            ['title' => 'pdf-lib, create and modify PDF documents in JavaScript', 'url' => 'https://pdf-lib.js.org/'],
        ],
    ],

    'how-to-check-if-an-online-tool-uploads-your-file' => [
        'title' => 'How to Check if an Online Tool Uploads Your File',
        'description' => 'Check whether a "browser-based" PDF or image tool really keeps your file on your device, using the Network tab, an offline test and the privacy policy.',
        'h1' => 'How to check if an online tool uploads your file',
        'intro' => 'Many free PDF and image tools say your file "never leaves your device". Some of them mean it, some of them upload the file to a server and delete it later, and the page often looks exactly the same either way. You do not have to take the claim on trust. Every desktop browser has a built-in tool that lists what a page sends over the network, and with a few minutes of practice you can see for yourself whether your file went anywhere. No technical background is needed; here is how to do it.',
        'tool' => 'merge-pdf',
        'related' => ['image-compressor', 'redact-pdf', 'edit-pdf'],
        'published' => '2026-10-30',
        'updated' => '2026-10-30',
        'sections' => [
            [
                'heading' => 'Why it matters which kind of tool you use',
                'paragraphs' => [
                    'The files people run through quick online tools are often the most sensitive ones they own: a scan of a passport or driving licence for an application, a signed contract, a payslip or bank statement for a rental, a medical letter. Once a file is uploaded, you are relying on the operator to store it securely, delete it when they say they will, and not keep copies in backups or logs. You usually have no way to check any of that.',
                    'A tool that processes the file inside your browser avoids the question entirely. The page downloads its code once, and the work happens on your own computer using JavaScript libraries such as PDF.js and pdf-lib for PDFs or the Canvas API for images. Nothing about the file has to travel anywhere. The checks below tell you which of the two kinds of tool you are actually using.',
                ],
            ],
            [
                'heading' => 'The Network tab check in Chrome and Edge',
                'paragraphs' => [
                    'Chrome and Microsoft Edge share the same developer tools, so the steps are identical. Do this on a desktop or laptop; mobile browsers do not include these tools. Use a harmless test file the first time, not the real document.',
                ],
                'list' => [
                    'Open the tool\'s page, then press F12 (or Ctrl+Shift+I on Windows and Linux, Cmd+Option+I on a Mac) to open DevTools. You can also right-click the page and choose Inspect.',
                    'Click the Network tab at the top of the DevTools panel. If you do not see it, click the >> arrow to show more tabs.',
                    'Tick "Preserve log" so the list is not wiped if the page reloads, then click the Clear button (the circle with a line through it) to empty the list of everything the page loaded so far.',
                    'Now use the tool normally: choose your file, run the conversion or compression, and download the result. Keep DevTools open the whole time; it only records what happens while it is open.',
                    'Look at the new rows that appeared. Right-click any column heading and switch on "Method" if it is not already shown. An upload almost always appears as a POST or PUT request.',
                    'Click a POST or PUT row and open its Headers tab. Under Request Headers, "Content-Length" is the size of what was sent, in bytes. If it is close to your file\'s size (a 2 MB file is about 2,000,000 bytes), the file was uploaded. The Payload tab may also show the file name.',
                    'To cut out noise, click the "Fetch/XHR" filter button. This hides images, fonts and scripts and leaves only the requests the page made from code, which is where an upload would be.',
                ],
            ],
            [
                'heading' => 'The same check in Firefox',
                'paragraphs' => [
                    'Firefox calls its version the Network Monitor. It works the same way and shows the request method by default, which makes uploads slightly easier to spot.',
                ],
                'list' => [
                    'Press Ctrl+Shift+E (Cmd+Option+E on a Mac) to open the Network Monitor directly, or press F12 and click the Network tab.',
                    'Turn on "Persist Logs" in the Network Monitor\'s settings menu (the gear icon) if the page reloads while you work, and click the bin icon to clear the list.',
                    'Use the tool with your test file, from choosing the file through to downloading the result.',
                    'Check the Method column for POST or PUT, and the Transferred column for sizes. Click the XHR filter to show only requests made from code.',
                    'Click a suspicious request and look at its Headers panel for Content-Length, and at its Request panel for the content that was sent.',
                ],
            ],
            [
                'heading' => 'What normal, harmless requests look like',
                'paragraphs' => [
                    'An empty Network tab is not what you should expect, even from a tool that never uploads anything. Most free sites load analytics and ads, and these keep sending small requests while you use the page. On their own they are not a sign that your file went anywhere.',
                    'Typical harmless traffic includes requests to analytics services (Google Analytics requests often have "collect" in the name), ad networks, fonts and the page\'s own scripts and images. These are usually a few hundred bytes to a few tens of kilobytes each, and many are GET requests. Analytics requests can be POST requests too, but their size stays small and does not grow with your file.',
                    'The pattern to look for is size. One POST or PUT whose size roughly matches your file, or a run of medium-sized requests that add up to it (some sites upload in chunks), means the file was sent. Try a larger test file: if the requests grow with it, that settles it. Rows starting with "blob:" or "data:" are local to your browser and are not uploads.',
                ],
            ],
            [
                'heading' => 'The offline test',
                'paragraphs' => [
                    'If the Network tab feels like too much, there is a simpler check that needs no developer tools at all. A tool that runs in your browser does not need the internet once its page has loaded.',
                ],
                'list' => [
                    'Open the tool\'s page and wait until it has fully loaded.',
                    'Disconnect: turn on airplane mode, switch off Wi-Fi, or unplug the network cable. In Chrome or Edge DevTools you can instead pick "Offline" from the throttling menu on the Network tab, which only affects that tab.',
                    'Choose a test file and run the tool. If it finishes and lets you download the result, the processing happened on your device.',
                    'If it shows an error, spins forever, or says "uploading", it needed a server.',
                    'Close the tab before you reconnect, so that nothing held back while offline can be sent when the connection comes back.',
                ],
            ],
            [
                'heading' => 'Limits of the offline test',
                'paragraphs' => [
                    'The offline test is good at proving a tool can work locally, but a failure does not always mean an upload. Some pages load parts of their code only when you first use them, so a genuinely local tool can fail offline simply because a script was not downloaded yet. Others break because an ad or analytics script errors out. If you get a failure, use the tool once online with a harmless file so everything is downloaded, then try again offline without reloading the page.',
                    'It also cannot help with tools that need the network by their nature. A tool that looks up information about a website, a domain or your IP address has to ask a server; that is the job, not a privacy problem. What matters is that tools handling your own files do not need one.',
                ],
            ],
            [
                'heading' => 'Reading the privacy policy and spotting red flags',
                'paragraphs' => [
                    'Read the site\'s privacy policy or FAQ and search it for the words "upload", "server", "delete" and "retain". A tool that processes files locally can say so plainly. A policy that describes how long files are stored, where the servers are, or that files are "encrypted in transit" is describing uploads, however the home page is worded.',
                    'Some signs on the page itself point to a server doing the work:',
                ],
                'list' => [
                    'A progress bar or message that says "Uploading" before the processing starts. Local tools have nothing to upload; they may show "Processing" instead.',
                    'A file-size or page-count limit for free users, such as a fixed number of megabytes. Limits like this usually exist to control server costs; a local tool is limited mainly by your own device\'s memory.',
                    'A promise that "files are deleted after 1 hour" (or 24 hours). That is reassurance about what happens to an uploaded copy, which means there is an uploaded copy.',
                    'A limit on how many files you can process per hour or per day, or a queue before your file is processed.',
                    'A result delivered by email, or as a download link that keeps working from another device.',
                ],
            ],
            [
                'heading' => 'Which check to use',
                'paragraphs' => [
                    'Each check answers a slightly different question, and none is perfect on its own. The Network tab plus one other check gives you a clear answer.',
                ],
                'table' => [
                    'headers' => ['Check', 'What it shows', 'Limits'],
                    'rows' => [
                        ['Network tab (Chrome, Edge, Firefox)', 'Every request the page sends while you use the tool, with its method and size', 'Desktop only; DevTools must be open before you add the file; takes a little practice to read'],
                        ['Offline / airplane-mode test', 'Whether the tool can finish its work with no connection at all', 'Can fail for harmless reasons (lazily loaded code, ad scripts); does not apply to lookup tools'],
                        ['Privacy policy', 'What the operator says it does with files, and for how long', 'A statement, not proof; it can be vague or out of date'],
                        ['Red flags on the page', 'Hints such as "uploading", size limits, deletion timers', 'Indirect; a site can avoid all of them and still upload'],
                    ],
                ],
            ],
            [
                'heading' => 'How ILoveMyTools handles your files',
                'paragraphs' => [
                    'You can run every check above on this site, and we would rather you did than take our word for it. The PDF and image tools, such as [Merge PDF](/merge-pdf), [Redact PDF](/redact-pdf), [Edit PDF](/edit-pdf) and the [Image Compressor](/image-compressor), do their work in your browser with PDF.js, pdf-lib and the Canvas API. Your file is read from your device and the result is saved back to it; you will not see a request carrying it in the Network tab.',
                    'You will still see small requests while you use the site, because the pages load Google Analytics and ads. A few tools do use our server because they cannot work otherwise: the [Bulk Domain Authority Checker](/domain-authority-checker), the [Broken Link Checker](/broken-link-checker), the [Domain Age Checker](/domain-age-checker) and [What Is My IP](/what-is-my-ip) all have to look things up on the internet. They send the domains or URLs you type in (or, for What Is My IP, simply ask the server which address your request came from), not files. The three domain and link checkers say on the page that they use the server.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Can I check whether a tool uploads my file on my phone?', 'a' => 'Not with the Network tab, because mobile browsers do not include developer tools. The offline test works on a phone: load the page, turn on airplane mode, then run the tool. For a full check, use a desktop browser.'],
            ['q' => 'I see lots of requests in the Network tab. Does that mean my file was uploaded?', 'a' => 'Not necessarily. Analytics, ads, fonts and scripts all create requests. Look for a POST or PUT request whose size is close to your file\'s size, or several requests that add up to it. Small requests that do not grow with your file are not your file.'],
            ['q' => 'If a tool works offline, is it guaranteed to be private?', 'a' => 'It proves the processing can happen on your device, which is the main thing. A page could in theory keep data and send it later, so close the tab before reconnecting, and use the Network tab check if you need to be certain.'],
            ['q' => 'Is a tool that uploads files always unsafe?', 'a' => 'No. Many reputable services upload files and delete them as promised. The difference is that you have to trust the operator. For passports, contracts or payslips, a tool that never receives the file removes that question.'],
            ['q' => 'Do I need to understand code to use the Network tab?', 'a' => 'No. You only need three things from it: the Method column (POST or PUT), the size of each request, and whether a request appears at the moment you use the tool. Everything else can be ignored.'],
        ],
        'sources' => [
            ['title' => 'Chrome for Developers, Inspect network activity (DevTools Network panel)', 'url' => 'https://developer.chrome.com/docs/devtools/network'],
            ['title' => 'Firefox Source Docs, Network Monitor', 'url' => 'https://firefox-source-docs.mozilla.org/devtools-user/network_monitor/index.html'],
            ['title' => 'MDN Web Docs, POST request method', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Methods/POST'],
        ],
    ],

    'ilovemytools-vs-ilovepdf-vs-smallpdf' => [
        'title' => 'ILoveMyTools vs iLovePDF vs Smallpdf: Who Uploads Your PDF?',
        'description' => 'An honest comparison of three free PDF sites: where your file goes, how long it is kept, free-plan limits, and when the bigger services win.',
        'h1' => 'ILoveMyTools vs iLovePDF vs Smallpdf',
        'intro' => 'The main difference between these three sites is where your file is processed. iLovePDF and Smallpdf upload your PDF to their servers and delete it later; ILoveMyTools does the work inside your browser, so the file stays on your device. That does not make one of them best for everything. We built ILoveMyTools, so read this with that in mind: every claim about the other two comes from their own pages, linked below, as they read on 2 November 2026.',
        'tool' => 'protect-pdf',
        'related' => ['merge-pdf', 'compress-pdf', 'edit-pdf'],
        'published' => '2026-11-02',
        'updated' => '2026-11-04',
        'sections' => [
            [
                'heading' => 'The short comparison',
                'paragraphs' => [
                    'The table covers what matters most for an everyday job. Prices and limits change often, so check the linked pages before you rely on a figure.',
                ],
                'table' => [
                    'headers' => ['', 'ILoveMyTools', 'iLovePDF', 'Smallpdf'],
                    'rows' => [
                        ['Where a PDF is processed', 'In your browser', 'On their servers', 'On their servers'],
                        ['How long the file is kept', 'Never received', 'Up to 2 hours', 'Deleted after 1 hour'],
                        ['Free plan', 'Everything free, no daily limit', 'Limited document processing', 'Limited use, varies by tool'],
                        ['Paid plan', 'None', 'Premium from $4 a month, billed yearly', 'Pro plan available'],
                        ['Ads', 'Yes', 'Free plan has ads; Premium is ad-free', 'Check their current plans'],
                        ['Desktop and mobile apps', 'No, website only', 'Yes, with Premium', 'Check their current plans'],
                    ],
                ],
            ],
            [
                'heading' => 'Does uploading matter?',
                'paragraphs' => [
                    'Uploading is not automatically unsafe. iLovePDF says uploads are encrypted and that files stay on its servers for a maximum of 2 hours. Smallpdf says its files are protected with TLS encryption, that it complies with GDPR and is ISO/IEC 27001 certified, and that files are deleted automatically after one hour. For a lunch menu or a public brochure, that is plenty.',
                    'It matters more for a passport scan, a contract, a payslip or medical records, or if your employer does not allow documents on outside services. A file that is never sent cannot be stored or leaked by the site. You do not have to take our word for that: our guide on [how to check if a tool uploads your file](/guides/how-to-check-if-an-online-tool-uploads-your-file) shows how to test any site in a few minutes, including this one.',
                ],
            ],
            [
                'heading' => 'When iLovePDF or Smallpdf is the better choice',
                'paragraphs' => [
                    'The bigger services have real advantages, and it would be misleading to skip them. They are the better pick in these cases:',
                ],
                'list' => [
                    'You need desktop or mobile apps, not just a website.',
                    'You work in a team and want shared accounts, invoicing or company contracts.',
                    'You work with very large files on a slow phone or an old computer. A server does the heavy work for you, while our tools use your own device\'s memory.',
                    'You want a site with no ads. Paid plans remove them; ILoveMyTools shows ads on every page and has no paid plan.',
                ],
            ],
            [
                'heading' => 'When ILoveMyTools is the better choice',
                'paragraphs' => [
                    'Our tools suit a different need: you want the job done now, on a private file, with no account. You can [merge up to 50 PDFs](/merge-pdf), [compress a PDF](/compress-pdf), [change the text already in a PDF](/edit-pdf), or [redact it properly](/redact-pdf) with no sign-up, no watermark and no daily limit, and the file stays on your device.',
                    'There are limits to be honest about. Because everything runs on your device, a very large file can be slow or fail on a phone with little memory. The site also has a few lookup tools, such as the Bulk Domain Authority Checker, that have to use our server, and they say so on the page. Those tools handle web addresses, not your files.',
                ],
            ],
            [
                'heading' => 'How to test any of these yourself',
                'paragraphs' => [
                    'You do not have to trust any of the three sites, including us. Open your browser\'s developer tools, go to the Network tab, and run a job with a small test file. A browser-based tool shows no request carrying your file. A server-based one shows an upload roughly the size of the file. Our [guide to checking for uploads](/guides/how-to-check-if-an-online-tool-uploads-your-file) walks through it step by step.',
                    'We ran that check on our own file tools on 4 November 2026 and recorded the results on the tool pages: 0 bytes uploaded while merging, compressing and splitting. The numbers for a 3-page photo PDF were 716 KB down to 122 KB on the Recommended setting.',
                ],
            ],
            [
                'heading' => 'Which should you choose?',
                'paragraphs' => [
                    'For a private file and a one-off job, with no account, use a browser-based tool. For a very large file on a weak phone, a server may simply be faster. If you process documents every day in a team, a paid plan\'s apps and admin features may well be worth the cost. There is no single best answer, and anyone who says otherwise, us included, is selling something.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does iLovePDF upload my files?', 'a' => 'Yes. iLovePDF processes files on its servers. Its FAQ says uploads are encrypted and files are kept for a maximum of 2 hours so you can download the result.'],
            ['q' => 'Does Smallpdf upload my files?', 'a' => 'Yes. Smallpdf asks you to upload the file and says it deletes files automatically after one hour, with TLS encryption in transit.'],
            ['q' => 'Does ILoveMyTools upload my files?', 'a' => 'No, not for its file tools. PDFs, images and text are processed in your browser with PDF.js, pdf-lib and Canvas. You can confirm it in your browser\'s Network tab. A few lookup tools use our server for the web addresses you enter.'],
            ['q' => 'Which one is best?', 'a' => 'It depends on the job. For a private file and no account, a browser-based tool is a good fit. For apps, team features or very large files on a weak device, a paid server-based service may suit you better.'],
        ],
        'sources' => [
            ['title' => 'iLovePDF, Frequently asked questions', 'url' => 'https://www.ilovepdf.com/help/faq'],
            ['title' => 'iLovePDF, Pricing plans', 'url' => 'https://www.ilovepdf.com/pricing'],
            ['title' => 'Smallpdf, Compress PDF (security notes on the page)', 'url' => 'https://smallpdf.com/compress-pdf'],
            ['title' => 'Compare Tools, Best free online PDF tools in 2026', 'url' => 'https://comparetools.io/best-free-online-pdf-tools/'],
        ],
    ],

    'how-much-sleep-do-you-need-sleep-cycles' => [
        'title' => 'How Much Sleep You Need: A Guide to Sleep Cycles',
        'description' => 'How much sleep adults, teens and kids actually need, why 90-minute sleep cycles matter more than a round number of hours, and how to time an alarm.',
        'h1' => 'How much sleep you need: a guide to sleep cycles',
        'intro' => '"Get 8 hours" is the sleep advice everyone has heard, but it misses the part that actually decides whether you wake up groggy or refreshed: where in a sleep cycle your alarm happens to land. Two people can both sleep exactly 8 hours and have completely different mornings, because one woke at the end of a cycle and the other was pulled out of deep sleep halfway through one. Here is what the research actually recommends by age, how sleep cycles work, and how to use that to pick a better bedtime or alarm.',
        'tool' => 'sleep-calculator',
        'related' => ['stopwatch', 'countdown-timer', 'age-calculator'],
        'published' => '2026-11-03',
        'updated' => '2026-11-03',
        'sections' => [
            [
                'heading' => 'How much sleep you actually need, by age',
                'paragraphs' => [
                    'Sleep need is not one number for everyone - it changes a lot with age, and the ranges below come from the two main US sleep health bodies, the American Academy of Sleep Medicine and the Sleep Foundation, who largely agree with each other. Adults need less sleep than teenagers, who in turn need less than school-age children, because a developing brain and body need more time in the deeper and REM stages of sleep that drive growth and memory consolidation.',
                    'These are ranges, not a single target. Sleeping slightly outside the range occasionally is normal; feeling consistently exhausted inside the "recommended" range is a signal to look at sleep quality, not just quantity - a cycle interrupted by a poorly timed alarm, noise, light, or a condition like sleep apnea can make 8 hours feel like 5.',
                ],
                'table' => [
                    'headers' => ['Age group', 'Recommended sleep', 'Typical in sleep cycles (90 min each)'],
                    'rows' => [
                        ['School-age children (6-12)', '9-12 hours', '6-8 cycles'],
                        ['Teenagers (13-18)', '8-10 hours', '5.5-6.5 cycles'],
                        ['Adults (18+)', '7-9 hours', '4.5-6 cycles'],
                    ],
                ],
            ],
            [
                'heading' => 'What a sleep cycle actually is',
                'paragraphs' => [
                    'Overnight, sleep does not stay at one depth - it moves through a repeating cycle of light sleep, deep sleep and REM (the dreaming stage), and one full cycle takes roughly 90 minutes, usually ranging from about 80 to 120 minutes depending on the person and the time of night. Most adults go through four to six of these cycles in a night.',
                    'The mix changes as the night goes on: the first couple of cycles contain the most deep sleep, which is the stage most linked to physical recovery, while the later cycles, closer to morning, contain more REM, which is more linked to memory and dreaming. That is one reason a short night costs you disproportionately more REM sleep than deep sleep - you lose the cycles at the end first.',
                    'Near the very end of each cycle, sleep becomes light again for a short stretch before the next cycle begins (or before you wake up for the day). Waking during that light stretch usually feels easy; waking in the middle of a deep-sleep stage is what produces that disoriented, heavy-headed feeling called sleep inertia.',
                ],
            ],
            [
                'heading' => 'Working out a better bedtime or alarm, step by step',
                'list' => [
                    'Pick a fixed point: either the time you need to wake up, or the time you plan to go to bed.',
                    'Count backward or forward in 90-minute steps from that point, in whole cycles - 4 cycles is 6 hours, 5 cycles is 7.5 hours, 6 cycles is 9 hours.',
                    'Add the time it typically takes you to fall asleep (commonly 10-20 minutes) on top of that, since the cycles only start once you are actually asleep.',
                    'Favour 5 or 6 full cycles for most adults, since that lands inside the 7-9 hour range public health guidance recommends.',
                    'If you are short on time, prefer waking a full cycle earlier (so after 4 cycles instead of partway into a 5th) rather than letting an alarm cut a cycle in the middle - less total sleep but an easier wake-up.',
                    'The [Sleep Calculator](/sleep-calculator) does this arithmetic for you: enter a wake-up time, a bedtime, or use "Sleep now", and it lists the matching times by cycle count, plus a chart of the night ahead.',
                ],
            ],
            [
                'heading' => 'Three habits that undo good timing',
                'paragraphs' => [
                    'An irregular schedule. Sleep cycles are fairly consistent in length once you are actually asleep, but a bedtime that moves by two or three hours night to night makes it much harder to predict - and often harder to reach - deep, restorative sleep at all. A regular sleep and wake time, even on weekends, does more for daytime alertness than chasing an exact cycle count on any single night.',
                    'Treating "cycle count" as more precise than it is. 90 minutes is an average, not a fixed number - actual cycle length varies from person to person and can shift across a single night (earlier cycles sometimes run a little longer than later ones). Use the cycle math to pick a sensible range of good options, not a single exact minute to aim for.',
                    'Screens and light right before bed. Bright light, especially from a phone or laptop held close to the face, suppresses the release of melatonin, the hormone that signals it is time to sleep, which can both delay falling asleep and shift when your cycles start relative to your alarm.',
                ],
            ],
            [
                'heading' => 'Checklist for a better night',
                'list' => [
                    'Pick a wake-up time and count back in whole 90-minute cycles rather than just subtracting "8 hours".',
                    'Add your own typical time-to-fall-asleep on top, instead of assuming you are asleep the instant you lie down.',
                    'Keep the same bed and wake time daily, weekends included, so your body\'s own rhythm lines up with the schedule you want.',
                    'If you consistently feel exhausted after a full night that fits the recommended range, treat that as a sign to check sleep quality (noise, light, screens, stress) or speak to a doctor, rather than just sleeping more.',
                    'Use a consistent way to time your night - the [Stopwatch](/stopwatch) or [Countdown Timer](/countdown-timer) for naps, or the Sleep Calculator\'s own hours-slept counter for a full night.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Is it better to sleep in full 90-minute cycles than to just get 8 hours?', 'a' => 'Timing an alarm for the end of a cycle tends to make waking up feel easier, but total sleep time still matters most for health - don\'t cut hours short just to land on a round number of cycles. Use the cycle math to fine-tune timing within a healthy range, not to justify sleeping less.'],
            ['q' => 'Does everyone have exactly 90-minute sleep cycles?', 'a' => 'No. 90 minutes is a commonly cited average; real cycle length varies from person to person and can range from about 80 to 120 minutes, and it can shift slightly across a single night.'],
            ['q' => 'Why do I wake up tired after what felt like a full night of sleep?', 'a' => 'It often means your alarm or a disturbance happened during a deep-sleep stage rather than at the lighter transition between cycles. Shifting your bedtime or wake time by 15-30 minutes at a time can help you land on an easier point in the cycle.'],
        ],
        'sources' => [
            ['title' => 'Sleep Foundation, How much sleep do you need?', 'url' => 'https://www.sleepfoundation.org/how-sleep-works/how-much-sleep-do-we-really-need'],
            ['title' => 'National Sleep Foundation, How many hours of sleep do you really need?', 'url' => 'https://www.thensf.org/how-many-hours-of-sleep-do-you-really-need/'],
            ['title' => 'CDC, About Sleep', 'url' => 'https://www.cdc.gov/sleep/about/index.html'],
        ],
    ],

    'how-compound-interest-works' => [
        'title' => 'How Compound Interest Works, With a Worked Example',
        'description' => 'See how compound interest grows money, with a worked 20-year example, the formula, the Rule of 72, and how much monthly contributions really change the result.',
        'h1' => 'How compound interest works',
        'intro' => 'Compound interest means you earn interest on your interest as well as on the money you put in. Early on the difference looks small, and over decades it does most of the work. This guide walks through one real calculation, shows the formula behind it, and explains the assumption that matters most: no real investment pays the same rate every year.',
        'tool' => 'compound-interest-calculator',
        'related' => ['percentage-calculator', 'loan-calculator', 'mortgage-calculator'],
        'published' => '2026-11-04',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'A worked example',
                'paragraphs' => [
                    'We ran this through the [Compound Interest Calculator](/compound-interest-calculator): $10,000 to start, 6% a year compounded monthly, for 20 years, adding $200 every month. The final balance was $125,510.22.',
                    'You put in $58,000 of your own money: the $10,000 starting amount plus $48,000 in contributions. The other $67,510.22 is interest, so more than half of the final balance is money you never paid in.',
                ],
                'table' => [
                    'headers' => ['Item', 'Amount'],
                    'rows' => [
                        ['Starting amount', '$10,000.00'],
                        ['Monthly contributions over 20 years', '$48,000.00'],
                        ['Interest earned', '$67,510.22'],
                        ['Final balance', '$125,510.22'],
                    ],
                ],
            ],
            [
                'heading' => 'How the balance builds, year by year',
                'paragraphs' => [
                    'The same example, followed through the years, shows why compounding is described as slow and then fast. In the first year interest adds only a few hundred dollars. By the last years the balance earns several thousand dollars of interest a year, without any extra effort from you.',
                    'Between year 15 and year 20 the balance grows by $42,805.54, of which $12,000 is your contributions. The remaining $30,805.54 is interest earned in just those five years, nearly half of all the interest earned over the full 20.',
                ],
                'table' => [
                    'headers' => ['After year', 'Balance', 'Paid in so far', 'Interest so far'],
                    'rows' => [
                        ['1', '$13,083.89', '$12,400.00', '$683.89'],
                        ['5', '$27,442.51', '$22,000.00', '$5,442.51'],
                        ['10', '$50,969.84', '$34,000.00', '$16,969.84'],
                        ['15', '$82,704.68', '$46,000.00', '$36,704.68'],
                        ['20', '$125,510.22', '$58,000.00', '$67,510.22'],
                    ],
                ],
            ],
            [
                'heading' => 'The formula',
                'paragraphs' => [
                    'For a single deposit with no further contributions, the balance is A = P x (1 + r / n) ^ (n x t). P is the starting amount, r is the yearly rate as a decimal, n is how many times a year interest is added, and t is the number of years.',
                    'Using our example with no monthly contributions: $10,000 x (1 + 0.06 / 12) ^ 240 is about $33,102. Compare that with the $125,510.22 above and you can see that steady contributions did more for the total than the starting amount did.',
                    'Regular deposits add a second part: C x ((1 + r / n) ^ (n x t) - 1) / (r / n), where C is the amount paid in each period. With $200 a month, that part comes to about $92,408, and $33,102 plus $92,408 gives the $125,510 total. The calculator assumes each deposit is made at the end of its period.',
                ],
            ],
            [
                'heading' => 'Simple interest versus compound interest',
                'paragraphs' => [
                    'With simple interest, $10,000 at 6% earns $600 every year, forever, because interest is only ever paid on the original $10,000. After 20 years you have $22,000.',
                    'With interest compounded monthly, the same $10,000 grows to about $33,102 over 20 years. The extra $11,102 is interest earned on earlier interest. The gap is small in the first few years and widens every year after that.',
                ],
            ],
            [
                'heading' => 'The Rule of 72',
                'paragraphs' => [
                    'To estimate how long money takes to double, divide 72 by the yearly rate. At 6% that gives about 12 years. It is an approximation for mental arithmetic and works best for rates between about 4% and 12%. To work out the rates themselves, the [Percentage Calculator](/percentage-calculator) shows each step.',
                ],
                'table' => [
                    'headers' => ['Yearly rate', 'Rule of 72', 'Exact (compounded yearly)'],
                    'rows' => [
                        ['2%', '36 years', '35.0 years'],
                        ['6%', '12 years', '11.9 years'],
                        ['9%', '8 years', '8.0 years'],
                        ['18%', '4 years', '4.2 years'],
                    ],
                ],
            ],
            [
                'heading' => 'What actually changes the result',
                'paragraphs' => [
                    'Time and the rate matter far more than how often interest is added. Moving from yearly to monthly compounding helps a little; starting ten years earlier helps a lot, because the last years of growth are the largest.',
                    'The same maths works against you on debt. A [loan](/loan-calculator) or a credit card balance grows on the same principle, which is why paying off high-interest debt usually beats saving at a lower rate.',
                ],
                'list' => [
                    'Start early: extra years add more than a slightly higher rate.',
                    'Contribute regularly: small monthly amounts add up, as the example shows.',
                    'Watch fees: a yearly fee comes straight off your rate, and it compounds too.',
                ],
            ],
            [
                'heading' => 'Comparing the levers with real numbers',
                'paragraphs' => [
                    'All of these use the calculator\'s method, with $200 a month and monthly compounding unless stated. They show how much each choice moves the final figure.',
                ],
                'table' => [
                    'headers' => ['Change', 'Result', 'Compared with the example'],
                    'rows' => [
                        ['$10,000 lump sum only, compounded yearly', '$32,071.35', '$1,030.69 less than monthly compounding ($33,102.04)'],
                        ['$10,000 lump sum only, compounded daily', '$33,197.90', 'Only $95.86 more than monthly'],
                        ['$200 a month only, 20 years', '$92,408.18', '$48,000 paid in'],
                        ['$200 a month only, 30 years', '$200,903.01', '$72,000 paid in, more than double the 20-year result'],
                        ['Example at 5% instead of 6% (a 1% yearly fee)', '$109,333.14', '$16,177.08 less'],
                        ['Example at 7% instead of 6%', '$144,572.72', '$19,062.50 more'],
                    ],
                ],
            ],
            [
                'heading' => 'How to use the calculator',
                'paragraphs' => [
                    'The [Compound Interest Calculator](/compound-interest-calculator) updates as you type, so it is quick to try several scenarios side by side.',
                ],
                'list' => [
                    'Enter your Starting amount and pick a Currency symbol ($, £, €, C$ or A$). The symbol only changes the display.',
                    'Enter the Interest rate (annual %) and the Number of years, from 1 to 50.',
                    'Add a Monthly contribution if you plan to pay in regularly, or leave it at 0.',
                    'Choose the Compound frequency: Annually, Semi-annually, Quarterly, Monthly or Daily.',
                    'Read the Final balance, Total contributed and Total interest earned. Total contributed counts your monthly deposits only; the starting amount is separate.',
                    'Open Show the year-by-year balance to see every year, as in the table above. There, the contributed column includes the starting amount.',
                ],
            ],
            [
                'heading' => 'Common mistakes',
                'list' => [
                    'Typing a monthly rate into a yearly field. A savings account advertising 0.5% a month is 6% a year, not 0.5%.',
                    'Comparing a rate quoted with compounding to one quoted without. 6% compounded monthly works out to about 6.17% over a year, which is why savings accounts often quote an annual equivalent.',
                    'Forgetting inflation. At 2.5% inflation a year, $125,510.22 in 20 years buys roughly what $76,595 buys today.',
                    'Assuming the rate holds for decades. Use a few different rates to see a range rather than one number.',
                ],
            ],
            [
                'heading' => 'The limit of any calculator',
                'paragraphs' => [
                    'A calculator assumes one fixed rate for the whole period. Savings rates change, and investment returns vary from year to year, including years that lose money. Treat the result as a projection for comparing options, not a forecast. It also ignores tax and inflation unless you allow for them yourself. This guide is general information, not financial advice.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'What is the difference between simple and compound interest?', 'a' => 'Simple interest is paid only on the original amount. Compound interest is also paid on the interest already earned, so the balance grows faster over time.'],
            ['q' => 'How much does $10,000 grow to in 20 years at 6%?', 'a' => 'With monthly compounding and no further deposits, about $33,102. With $200 added every month, our calculator gave $125,510.22.'],
            ['q' => 'Does compounding more often make a big difference?', 'a' => 'Only a small one. On $10,000 at 6% for 20 years, daily compounding gives $33,197.90 against $33,102.04 for monthly. The rate and the number of years matter far more.'],
            ['q' => 'How does compound interest work on a credit card?', 'a' => 'The same way, against you. A 20% yearly rate charged monthly works out to about 21.9% over a year, so an unpaid $5,000 balance would grow to about $6,097 in 12 months with no new spending and no payments.'],
            ['q' => 'Is the calculator\'s result guaranteed?', 'a' => 'No. It assumes one fixed rate for the whole period. Real returns vary, so use it to compare options rather than to predict an exact balance.'],
        ],
        'sources' => [
            [
                'title' => 'U.S. Securities and Exchange Commission, Compound interest calculator',
                'url' => 'https://www.investor.gov/financial-tools-calculators/calculators/compound-interest-calculator',
            ],
        ],
    ],

    'how-to-fix-invalid-json' => [
        'title' => 'How to Fix Invalid JSON: 6 Common Errors and What They Mean',
        'description' => 'What JSON error messages really mean: six common mistakes, the exact message each one produces, and how to fix them, from trailing commas to single quotes.',
        'h1' => 'How to fix invalid JSON',
        'intro' => 'JSON is strict. One stray comma or the wrong kind of quote and the whole document is rejected, often with a message that points somewhere confusing. We fed six of the most common mistakes into our JSON Formatter and recorded exactly what came back, so you can match your error to its cause. The position in the message is where the parser gave up, which is often just after the real mistake.',
        'tool' => 'json-formatter',
        'related' => ['base64-encoder-decoder', 'case-converter', 'domain-age-checker'],
        'published' => '2026-11-04',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'The six errors we tested',
                'paragraphs' => [
                    'Each message below is what the [JSON Formatter](/json-formatter) reported in Chrome. The technical part comes from the browser, so its wording can differ slightly in other browsers; the tool adds the plain-English hint in some cases.',
                ],
                'table' => [
                    'headers' => ['Mistake', 'Example', 'Message', 'Fix'],
                    'rows' => [
                        [
                            'Trailing comma in an object',
                            '{"a": 1,}',
                            'Expected double-quoted property name... Remove the trailing comma before this bracket.',
                            'Delete the last comma',
                        ],
                        ['Trailing comma in an array', '[1, 2, 3,]', 'Unexpected token \']\'', 'Delete the last comma'],
                        ['Single quotes', '{\'name\': \'Ann\'}', 'Expected property name or \'}\'... must use double quotes', 'Use " for keys and strings'],
                        ['Unquoted key', '{name: "Ann"}', 'Expected property name or \'}\'... must be wrapped in double quotes', 'Write "name"'],
                        ['Missing comma', '{"a": 1 "b": 2}', 'Expected \',\' or \'}\' after property value', 'Add a comma between items'],
                        ['Comment', '{"a": 1 // note}', 'Expected \',\' or \'}\'... Comments are not allowed in JSON.', 'Remove the comment'],
                    ],
                ],
            ],
            [
                'heading' => 'How to check your JSON, step by step',
                'list' => [
                    'Paste the JSON into the box labelled JSON input in the [JSON Formatter](/json-formatter). The Sample button loads a small valid example if you want to see how it works first.',
                    'Click Validate to check it without changing anything, or Format / Beautify to check it and lay it out with indentation.',
                    'If it is invalid, read the message under the buttons: it gives the browser\'s description, the line and column, and for common mistakes a hint such as "Remove the trailing comma before this bracket."',
                    'Fix the problem in the input and click again. Repeat until the message says Valid JSON.',
                    'Copy or download the result. Use as input moves the formatted result back into the input box if you want to keep editing it.',
                ],
            ],
            [
                'heading' => 'Reading the position',
                'paragraphs' => [
                    'A message like "position 8 (line 1, column 9)" tells you where the parser stopped, counted from the start. With a missing comma, as in {"a": 1 "b": 2}, position 8 is the start of "b", because that is where a comma should have appeared. So look just before the position as well as at it.',
                    'One mismatched bracket can do the same thing. In {"tags": ["a", "b"} the parser complains at the closing brace, position 18, because it expected the array to end first. Formatting a long document first makes this kind of mistake much easier to see.',
                    'Positions are counted from 0, so position 8 is the ninth character, which is why the formatter reports it as column 9. Chrome and Edge give a position or a line and column; Firefox gives a line and column. The formatter turns either into the same line and column, so you can jump to the spot in your editor.',
                ],
            ],
            [
                'heading' => 'Six more mistakes that break JSON',
                'paragraphs' => [
                    'The table above covers the most common errors, but these come up often too, especially with data copied from documents, spreadsheets or code.',
                ],
                'list' => [
                    'Curly quotes. Word processors and chat apps often turn "straight" quotes into “curly” ones. JSON only accepts the straight double quote, so retype the quotes or paste through a plain-text editor.',
                    'Unescaped backslashes. A Windows path such as "C:\\Users\\ann" is invalid, because \\U is not a valid escape. Write each backslash twice: "C:\\\\Users\\\\ann".',
                    'Line breaks inside a string. A string cannot contain a real line break; use \\n for a new line and \\t for a tab.',
                    'JavaScript values. undefined, NaN and Infinity are not JSON. Use null, or a number, or a string.',
                    'Number formats. Leading zeros such as 007, hexadecimal such as 0xFF, a leading + sign and a trailing decimal point such as 5. are all invalid. Write 7, 255, 5 and 5.0.',
                    'Truncated data. If a file or API response was cut off, the brackets never close and the parser reports that the input ended too early. Get the full response again rather than adding brackets by hand.',
                ],
            ],
            [
                'heading' => 'A quick way to debug a large file',
                'list' => [
                    'Paste the JSON into the formatter and note the line and column in the message.',
                    'Check that spot and the character just before it.',
                    'Fix one error and format again: the next error often only appears after the first is gone.',
                    'If the JSON came from code, fix it there too, or the same error will return.',
                ],
                'paragraphs' => [
                    'The usual culprits are hand-edited config files, JavaScript objects pasted as if they were JSON, and copying from a document that turned straight quotes into curly ones.',
                    'If the error position makes no sense, the real problem may be much earlier. An unclosed string, for example, swallows everything up to the next quote mark, so the parser may only complain many lines later. Look upwards from the reported line for a string that is missing its closing quote.',
                ],
            ],
            [
                'heading' => 'Worked example: fixing a broken config file',
                'paragraphs' => [
                    'Suppose you paste this into the formatter: {name: \'my-app\', "port": 8080, "debug": true, // local only }. It contains three problems: an unquoted key, single quotes and a comment, plus a trailing comma hidden before the comment.',
                    'The first message points at name and says keys must be wrapped in double quotes. Change it to "name" and validate again. The next message, in Chrome, reports an unexpected \' token, the single quote; change \'my-app\' to "my-app". The third message says comments are not allowed; delete // local only. The last error is the trailing comma after true. Remove it and the message changes to Valid JSON.',
                    'This is why it pays to fix one error at a time. The parser stops at the first problem it meets, so it can only ever show one.',
                ],
            ],
            [
                'heading' => 'What formatting changes, and what it does not',
                'paragraphs' => [
                    'Format / Beautify reads your JSON and writes it out again with 2 spaces, 4 spaces or tabs, whichever you choose in the Indent menu. Minify removes all the spacing to make the file as small as possible. Sort keys A-Z puts the keys of every object in alphabetical order, which makes two versions of a file easier to compare.',
                    'Because the formatter rebuilds the data, a few details can change. Numbers are rewritten in their simplest form, so 1.0 becomes 1 and 1e3 becomes 1000. Escapes such as \\u00e9 are written out as the character itself, é. If an object has the same key twice, only the last value is kept. And very large whole numbers lose precision: JavaScript numbers are exact only up to 9,007,199,254,740,991, so a long ID like 12345678901234567890 comes back as 12345678901234567000. Keep large IDs as strings if they must stay exact.',
                    'Validate never changes anything, so use it when you only need a yes or no.',
                ],
            ],
            [
                'heading' => 'JSON is not JavaScript',
                'paragraphs' => [
                    'Most of these errors come from the same confusion. JavaScript objects allow single quotes, unquoted keys, trailing commas and comments. JSON allows none of them. The rules are short and fixed by the standard, so a strict error is the parser doing its job.',
                    'If a value holds binary data or an encoded string, a tool like the [Base64 Encoder](/base64-encoder-decoder) can help you see what is inside. Your JSON stays in your browser in the formatter: our network log showed 0 bytes sent during these tests, so it is safe for config files, though you should still be careful where you paste live secrets.',
                ],
            ],
            [
                'heading' => 'Preventing invalid JSON in the first place',
                'list' => [
                    'Generate JSON with your language\'s built-in encoder, such as JSON.stringify in JavaScript or json.dumps in Python, instead of joining strings by hand.',
                    'Use an editor that highlights JSON syntax, so a missing quote stands out as you type.',
                    'Do not write JSON in a word processor; it changes quotes and dashes.',
                    'If you need comments in a config file, check whether the program accepts a format that allows them, such as JSON5 or YAML, rather than adding them to strict JSON.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Why does JSON not allow trailing commas?', 'a' => 'The JSON standard simply does not include them. A comma must be followed by another value.'],
            ['q' => 'Can JSON have comments?', 'a' => 'No. Standard JSON has no comment syntax. Some tools accept variants such as JSON5, but a strict parser will reject them.'],
            ['q' => 'Why is the error position after my mistake?', 'a' => 'The parser reports where it could no longer continue, which is often the character right after the real problem.'],
            ['q' => 'Is a single number or string valid JSON?', 'a' => 'Yes. Under the current standard, any JSON value can stand on its own, so 42, "hello", true and null are all valid documents.'],
            ['q' => 'Why did my long ID number change after formatting?', 'a' => 'JavaScript numbers are only exact up to 9,007,199,254,740,991. Larger whole numbers are rounded when the JSON is read. Store such IDs as strings.'],
            ['q' => 'Does the formatter fix errors automatically?', 'a' => 'No. It shows where the error is and, for common mistakes, what to change, but you make the fix yourself so nothing is changed without you seeing it.'],
        ],
        'sources' => [
            [
                'title' => 'RFC 8259, The JavaScript Object Notation (JSON) Data Interchange Format',
                'url' => 'https://www.rfc-editor.org/rfc/rfc8259',
            ],
            [
                'title' => 'MDN Web Docs, SyntaxError: JSON.parse: bad parsing',
                'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Errors/JSON_bad_parse',
            ],
        ],
    ],

    'what-is-a-good-domain-authority-score' => [
        'title' => 'What Is a Good Domain Authority Score? DA vs DR vs OPR',
        'description' => 'What a good authority score looks like, how Moz DA, Ahrefs DR and OpenPageRank differ, and what a low score on a new website does and does not mean.',
        'h1' => 'What is a good domain authority score?',
        'intro' => 'There is no single authority score. Moz, Ahrefs, Semrush and OpenPageRank each run their own formula on their own data, so the same site gets different numbers, and none of them comes from Google. A "good" score is one that is strong compared with the sites you actually compete with. Here is how the metrics differ, and what we found when we checked a giant site alongside our own new one.',
        'tool' => 'domain-authority-checker',
        'related' => ['domain-age-checker', 'broken-link-checker', 'readability-checker'],
        'published' => '2026-11-04',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'The metrics compared',
                'paragraphs' => [
                    'All of these estimate how strong a site is from links pointing to it. They are not interchangeable: a DR of 40 and a DA of 40 are different measurements.',
                    'Each company crawls the web with its own crawler, or uses a public crawl, and counts the links it finds. Because no crawl sees the whole web, and each formula weighs links differently, the same domain can look strong on one metric and average on another. That is normal, and it is the main reason to stick to one metric when you compare sites.',
                ],
                'table' => [
                    'headers' => ['Metric', 'Made by', 'Scale'],
                    'rows' => [
                        ['OpenPageRank', 'OpenPageRank (Common Crawl data)', '0-10'],
                        ['Domain Authority (DA)', 'Moz', '0-100'],
                        ['Domain Rating (DR)', 'Ahrefs', '0-100'],
                        ['Authority Score', 'Semrush', '0-100'],
                    ],
                ],
            ],
            [
                'heading' => 'What we saw when we checked',
                'paragraphs' => [
                    'We ran two sites through the [Bulk Domain Authority Checker](/domain-authority-checker) on 4 November 2026. wikipedia.org scored 9.63 out of 10, ranked #36 globally, with 627,034 referring domains. Our own site, ilovemytools.store, launched in 2026, came back as "Not found".',
                    'That second result is the useful one. It does not mean a site is penalised or broken. It means the site does not have enough links in the web crawl behind the score yet. Almost every new site starts here.',
                ],
            ],
            [
                'heading' => 'So what counts as good?',
                'paragraphs' => [
                    'The scales are logarithmic, so each step up is much harder than the last. Moving from 2 to 3 on OpenPageRank takes far fewer links than moving from 8 to 9. As a rough guide, new sites sit near 0, small established sites often score 2 to 4, well-known brands 5 to 7, and only the largest sites go higher.',
                    'The better question is how you compare with the sites ranking for the searches you want. Paste your competitors in alongside your own domain and sort the table. If they are all at 3, you are in reach at 2.5. If they are all at 7, you need a different target for now.',
                ],
                'table' => [
                    'headers' => ['OpenPageRank score', 'Typical kind of site (rough guide)'],
                    'rows' => [
                        ['0 or not found', 'New sites, or sites with very few links'],
                        ['2 to 4', 'Small established sites and local businesses'],
                        ['5 to 7', 'Well-known brands and popular publications'],
                        ['8 and above', 'Only the largest sites on the web'],
                    ],
                ],
            ],
            [
                'heading' => 'How to check scores in bulk, step by step',
                'list' => [
                    'Open the [Bulk Domain Authority Checker](/domain-authority-checker) and paste your domains into the box, one per line. Up to 100 domains are checked at a time.',
                    'Full addresses are fine: https://www.example.com/page is reduced to the domain. Anything that is not a domain is skipped and listed in a warning, so you can see what was left out.',
                    'Click Check authority. The table shows each domain\'s OpenPageRank score out of 10, its global rank and the number of referring domains.',
                    'Use Sort by to order the table by Highest score, Domain A-Z or Your order. The summary above it shows how many domains were checked, how many have a score, and the average score of those that do.',
                    'Click Details on a row for that domain\'s registration record, public DNS and HTTPS certificate. With a single domain, the details open automatically.',
                    'Click Download CSV to keep the results in a spreadsheet and compare them again in a few months.',
                ],
            ],
            [
                'heading' => 'What happens to the domains you enter',
                'paragraphs' => [
                    'Unlike most tools on this site, this one has to ask an outside service, so it does not run only in your browser. The list of domains you paste is sent to our server, which looks up the scores with the OpenPageRank service and caches the answers. The Details panel is also fetched by our server, from registry RDAP records, public DNS and the site\'s HTTPS certificate. Only the domain names are sent, nothing else.',
                    'Because the scores come from a free service, there is a daily limit on lookups, and checking many lists in a short time may ask you to wait a minute. The date of the data is shown under the table.',
                ],
            ],
            [
                'heading' => 'Worked example: sizing up your competition',
                'paragraphs' => [
                    'Say you run a small bakery website and want to rank for a search like "birthday cakes" in your town. Search for it, note the five sites on the first page, and paste them into the checker with your own domain, six lines in total.',
                    'Suppose the results come back as 4.1, 3.6, 3.2, 2.9 and 2.4, with your own site at 1.8. Sort by Highest score. The average in the summary covers all six domains, 3 here; the five competitors alone average 3.24. The two weakest rivals are within about one point of you, so these searches are realistic targets if your page is genuinely more useful. The strongest one at 4.1 will take longer to catch.',
                    'Now suppose instead that a national chain and two big recipe sites fill the first page, all scoring 6 or more. That does not mean you can never rank, but it is a sign to aim first at more specific searches, such as a particular cake style plus your town, where the competition is smaller sites.',
                ],
            ],
            [
                'heading' => 'Reading the other columns',
                'paragraphs' => [
                    'Referring domains is the number of different websites linking to a domain, which matters more than the raw number of links, because a thousand links from one site count for far less than a link each from a hundred sites. The global rank places the domain among all the domains OpenPageRank knows about; a lower number is stronger.',
                    'A dash in those columns, or "Not found" in the score column, means the data source has nothing for that domain yet. Double-check the spelling first, then treat it as a sign that the site is new or has very few links.',
                ],
            ],
            [
                'heading' => 'What these scores are not',
                'paragraphs' => [
                    'They are not Google rankings or a Google metric. Moz says plainly that Domain Authority is not a ranking factor. A page with a low score can outrank a stronger site if it answers the search better, especially for specific long-tail searches.',
                    'They also do not measure quality directly. Scores can be pushed up with low-quality or paid links, which is exactly what Google\'s spam policies target, so treat a sudden high score on an unknown site with some suspicion.',
                ],
            ],
            [
                'heading' => 'How to improve a low score',
                'paragraphs' => [
                    'Because these scores count links from other sites, the only lasting way to raise them is to earn more links from real, relevant websites. That usually comes from publishing something people want to reference: original data, a genuinely useful tool or guide, or local news and partnerships for a local business.',
                    'Buying links or joining link schemes can lift a third-party score for a while, but it breaks Google\'s spam policies and can harm the rankings you actually care about. Expect real progress to take months, and measure it against your competitors rather than against a target number.',
                ],
            ],
            [
                'heading' => 'Common mistakes',
                'list' => [
                    'Comparing a Moz DA with an Ahrefs DR or an OpenPageRank score as if they were the same scale.',
                    'Panicking about a low or missing score on a new site, which is normal.',
                    'Choosing link partners by score alone without reading the site.',
                    'Treating a score change from one month to the next as a ranking change; scores and rankings move independently.',
                    'Chasing a number instead of the searches and visitors it is meant to stand for.',
                ],
            ],
            [
                'heading' => 'How to use a score sensibly',
                'list' => [
                    'Compare within one metric. Never compare DA from one site with DR from another.',
                    'Use it to size up link partners and guest-post sites, then read the site itself.',
                    'Check a domain\'s history too: the [Domain Age Checker](/domain-age-checker) shows when it was registered.',
                    'Fix your own [broken links](/broken-link-checker) before chasing new ones.',
                    'Track the trend over months. Scores update slowly; OpenPageRank updates monthly.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Is a domain authority of 30 good?', 'a' => 'It depends on the metric and your competitors. On a 0-100 scale, 30 is reasonable for a small site in a low-competition niche and weak in a crowded one.'],
            ['q' => 'Why does my new site show no score?', 'a' => 'Scores come from crawls of links across the web. A new site with few links often has no score yet, and that is normal.'],
            ['q' => 'Does Google use domain authority?', 'a' => 'No. DA is a Moz metric, and these scores are made by third parties to estimate strength. Google has its own systems.'],
            ['q' => 'How many domains can I check at once?', 'a' => 'Up to 100 per check. Paste them one per line; full URLs are reduced to the domain automatically.'],
            ['q' => 'Why is the score out of 10 and not 100?', 'a' => 'The checker shows OpenPageRank, which uses a 0-10 scale. Do not multiply it by 10 to compare with Moz or Ahrefs; they are different formulas on different data.'],
            ['q' => 'Are the domains I check stored or shared?', 'a' => 'The domain names are sent to our server to look up the scores and details, and the answers are cached. No other information is sent.'],
        ],
        'sources' => [
            [
                'title' => 'OpenPageRank: how the score is calculated',
                'url' => 'https://openpagerank.keywordseverywhere.com/methodology',
            ],
            [
                'title' => 'Moz, What is Domain Authority?',
                'url' => 'https://moz.com/learn/seo/domain-authority',
            ],
            [
                'title' => 'Google Search Central, Spam policies: link spam',
                'url' => 'https://developers.google.com/search/docs/essentials/spam-policies',
            ],
        ],
    ],

    'are-online-coin-flips-fair' => [
        'title' => 'Are Online Coin Flips Fair? We Flipped 1,000 Coins to Check',
        'description' => 'We flipped 1,000 virtual coins on our own tool and got 510 heads and 490 tails. What that shows about fairness, streaks, and how to judge any random tool.',
        'h1' => 'Are online coin flips fair?',
        'intro' => 'A fair online coin should land on heads about half the time, with no pattern you can predict. We flipped 1,000 coins on our Coin Flip tool and got 510 heads and 490 tails. That is a good result, but it is also easy to misread, because a fair coin is not supposed to be perfectly even. Here is what the number shows, what it does not show, and how randomness works in a browser.',
        'tool' => 'coin-flip',
        'related' => ['dice-roller', 'spin-the-wheel', 'random-number-generator'],
        'published' => '2026-11-04',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'What we did',
                'paragraphs' => [
                    'On the live [Coin Flip](/coin-flip) page we set 100 coins per flip and flipped 10 times, for 1,000 coins in total. The tool counted 510 heads and 490 tails, or 51% and 49%.',
                ],
                'table' => [
                    'headers' => ['Result', 'Count', 'Share'],
                    'rows' => [
                        ['Heads', '510', '51%'],
                        ['Tails', '490', '49%'],
                        ['Total', '1,000', '100%'],
                    ],
                ],
            ],
            [
                'heading' => 'Is 510 out of 1,000 fair?',
                'paragraphs' => [
                    'Yes. With 1,000 fair flips, the typical distance from 500 is about 16 flips (the standard deviation, the square root of 1,000 x 0.5 x 0.5, which is 15.8). Our result is 10 away, well inside normal variation. An exact 500 would not be any more impressive.',
                    'One run cannot prove a coin is fair; it can only fail to show a problem. A much larger gap, say 600 heads in 1,000, would be a real warning sign, since that is more than six standard deviations from the middle.',
                ],
            ],
            [
                'heading' => 'What normal variation looks like',
                'paragraphs' => [
                    'The binomial distribution tells you exactly how uneven a fair coin is allowed to look. These figures are calculated, not measured, and they apply to any fair coin, real or virtual.',
                ],
                'table' => [
                    'headers' => ['Flips', 'Chance of an exact 50/50 split', 'At least 95% of fair runs land between'],
                    'rows' => [
                        ['10', '24.6% (exactly 5 heads)', '2 and 8 heads'],
                        ['100', '8.0% (exactly 50 heads)', '40 and 60 heads'],
                        ['1,000', '2.5% (exactly 500 heads)', '469 and 531 heads'],
                    ],
                ],
                'list' => [
                    'With 10 flips, a lopsided result is common: 8 or more of one side, either way, happens about 11% of the time.',
                    'With 1,000 flips, only about half of all fair runs land between 490 and 510 heads. Our 510 sits right at the edge of that middle band, which is entirely ordinary.',
                    'The percentage gets closer to 50% as you flip more, but the raw gap from an even split tends to grow. That is the law of large numbers working as it should, not a sign of bias.',
                ],
            ],
            [
                'heading' => 'Streaks are normal',
                'paragraphs' => [
                    'People expect random results to alternate, so a run of five heads looks suspicious. It is not. Each flip is independent: after five heads the next is still 50/50. Believing tails is now "due" is the gambler\'s fallacy.',
                    'In fact, long runs are close to guaranteed. In 100 fair flips, the chance of seeing a run of at least 5 of the same side somewhere is about 97%, at least 6 about 81%, and at least 7 about 54%. In 1,000 flips, a run of 10 or more turns up about 62% of the time. A list of results with no runs longer than three would be more suspicious than one with a streak of seven.',
                ],
            ],
            [
                'heading' => 'How to run your own test',
                'list' => [
                    'Open the [Coin Flip](/coin-flip) tool and choose 100 under Coins per flip.',
                    'Press Flip 100 coins ten times. You can also press F, the space bar or Enter.',
                    'Read the Heads, Tails and Total flips counters and the percentage bar underneath.',
                    'Compare the result with the table above: anything between about 469 and 531 heads in 1,000 is what a fair coin produces 95% of the time.',
                    'Click Reset stats to start a fresh test.',
                ],
                'paragraphs' => [
                    'The counters keep the most recent 1,000 coins, so for a test of exactly 1,000, reset first. The streak counter shows the current run of heads or tails, and the row of small coins shows the last 24 results, which is a good way to see for yourself how often runs of three or four appear.',
                ],
            ],
            [
                'heading' => 'One coin or many: same odds',
                'paragraphs' => [
                    'With one coin selected, the tool shows a full toss animation and lands on the result; with 2 to 100 coins it shows a grid of small coins and a heads and tails count. The display is the only difference. Every coin in a batch is decided separately by the same generator, so flipping 100 coins once is statistically the same as flipping one coin 100 times, just faster. That makes the batch mode the practical choice for testing, and the single coin the friendlier choice for settling who goes first. If your device is set to reduce motion, the result appears without the animation.',
                ],
            ],
            [
                'heading' => 'Where the randomness comes from',
                'paragraphs' => [
                    'Our random tools use your browser\'s crypto.getRandomValues, a cryptographically secure generator, rather than the simpler Math.random. The flip happens on your device, so the site does not choose the outcome.',
                    'The code also guards against a subtle problem called modulo bias by discarding random values that would favour some outcomes over others. For a coin it never has to: the generator produces one of 2^32 equally likely numbers, which divides exactly into two halves, so heads and tails each get exactly half. The guard matters for things like a 6-sided die, where 2^32 does not divide evenly by 6.',
                    'The same source drives the [Dice Roller](/dice-roller), [Spin the Wheel](/spin-the-wheel) and the [Random Number Generator](/random-number-generator), so all of them have the same basis for fairness.',
                ],
            ],
            [
                'heading' => 'How to judge any random tool',
                'list' => [
                    'Run a large sample and compare it with what chance predicts, not with a perfect split.',
                    'Look for a statement of how results are generated. Secure browser randomness is a good sign.',
                    'Check whether the result is decided on your device or on a server you cannot see. A server-side result is not necessarily unfair, but you are trusting the operator.',
                    'For anything with money or legal weight, use a process people can witness or audit. A website is fine for deciding who goes first, not for a prize draw with legal rules.',
                ],
                'paragraphs' => [
                    'Virtual coins also skip a detail of real ones: studies of human coin tossing have found a slight tendency to land on the side that started up. A software flip has no starting side.',
                ],
            ],
            [
                'heading' => 'Common misunderstandings',
                'list' => [
                    '"It gave heads three times, so it must be broken." Three in a row happens one time in eight for any three flips.',
                    '"I flipped 10 and got 7 heads, so it is biased." Seven or more heads in 10 flips happens about 17% of the time.',
                    '"Best of three is fairer than one flip." Each player still has exactly a 50% chance; it only takes longer.',
                    '"The animation decides the result." The result is chosen first by the random generator, and the spinning coin is then drawn to land on it.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Is a virtual coin flip truly random?', 'a' => 'It is random enough for everyday decisions. Ours uses the browser\'s cryptographically secure generator, which is designed to be unpredictable.'],
            ['q' => 'What are the odds of 5 heads in a row?', 'a' => 'One in 32, or about 3%, for any given five flips: 0.5 multiplied by itself five times. Somewhere within 100 flips, a run of 5 of the same side is very likely, at about 97%.'],
            ['q' => 'Does the previous flip affect the next one?', 'a' => 'No. Each flip is independent and stays 50/50.'],
            ['q' => 'How many coins can I flip at once?', 'a' => 'Up to 100 per flip. You can choose 1, 2, 5, 10, 25 or 100 coins, and the tool counts heads and tails for you.'],
            ['q' => 'Is it fair for settling a decision between two people?', 'a' => 'Yes, for everyday choices. Agree who takes heads before anyone flips, flip once, and accept the result; re-flipping until someone likes the answer is what makes it unfair.'],
            ['q' => 'How many flips do I need to test fairness?', 'a' => 'Several hundred at least. With 10 flips almost any split is normal; with 1,000 a fair coin lands between 469 and 531 heads about 95% of the time.'],
        ],
        'sources' => [
            [
                'title' => 'MDN Web Docs, Crypto: getRandomValues()',
                'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues',
            ],
        ],
    ],

    'how-to-find-broken-links' => [
        'title' => 'How to Find Broken Links on Your Website (Free Check)',
        'description' => 'How to find and fix broken links page by page: what 404, redirect and blocked results mean, which pages to check first, and a real scan of one of our own pages.',
        'h1' => 'How to find broken links on your website',
        'intro' => 'A broken link sends a visitor to an error page and wastes the trust that got them to click. Sites collect them quietly as other pages move or disappear. You can find them on any page in about a minute. This guide covers how to check, what the results mean, and what to do with each kind, using a real scan of one of our own pages as the example.',
        'tool' => 'broken-link-checker',
        'related' => ['domain-authority-checker', 'domain-age-checker', 'readability-checker'],
        'published' => '2026-11-04',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'How to run the check',
                'paragraphs' => [
                    'When we ran it on our own About page, it checked 82 links: 82 OK, 0 broken, 0 redirects and 0 blocked. This tool has to use our server to fetch the links, because a browser page is not allowed to test other sites directly. It sends the address you enter and stores nothing: our server fetches the page and each link only to read its status, and does not save the address or the results.',
                ],
                'list' => [
                    'Open the [Broken Link Checker](/broken-link-checker) and enter the address of one page in Page address (URL).',
                    'Click Check links. It tests every link and image on that page, up to 300, and shows progress as it goes. Click Stop if you want to end early.',
                    'Read the Problems tab first. The Redirects, OK and All tabs show the rest.',
                    'Download the CSV if you want a list to work through. It includes each URL, its status code, the result, the final address after any redirects, the link text, whether it is a link or an image, and whether it is internal or external.',
                    'Repeat for your other important pages.',
                ],
            ],
            [
                'heading' => 'What the results mean',
                'paragraphs' => [
                    'Each link ends up in one of the groups in the table below. Under every result you can also see whether it is a link or an image, its link text, whether it points to your own site (Internal) or elsewhere (External), and, for redirects, where it ends up.',
                    'Blocked is not the same as broken. Plenty of large sites turn away automated requests while working perfectly for people, so check those by hand. A link that redirects and then lands on a missing page counts as broken, because what matters is where the visitor ends up.',
                ],
                'table' => [
                    'headers' => ['Result', 'Meaning', 'What to do'],
                    'rows' => [
                        ['OK', 'The link works', 'Nothing'],
                        [
                            'Broken',
                            'A missing page (such as 404 or 410), a server error (500 and up) or a domain that no longer exists',
                            'Update the link or remove it',
                        ],
                        ['Redirect', 'It still works, through another address', 'Point it at the final address when convenient'],
                        ['Blocked', 'The site refused an automated check, with 401, 403 or 429', 'Open it in a browser before changing anything'],
                        ['No answer', 'No response in time, or too many redirects', 'Try the link yourself; the site may be slow or down for now'],
                    ],
                ],
            ],
            [
                'heading' => 'A worked example: triaging one page',
                'paragraphs' => [
                    'Suppose a blog post has 40 links and the checker reports 34 OK, 3 redirects, 2 broken and 1 blocked. Here is a sensible order to handle them, most urgent first.',
                ],
                'list' => [
                    'The 2 broken links. Open each one. If the page moved, search the site for its new address and update your link. If it is gone for good, find another source or reword the sentence.',
                    'The 1 blocked link. Open it in your browser. If it loads normally, the site simply refused our automated check and there is nothing to fix.',
                    'The 3 redirects. Look at where each one ends up. If http:// now goes to https://, or an old address goes to the same article at a new address, update the link to the final address when you next edit the post. If a redirect lands on a site\'s home page instead of the article you linked, treat it as broken: the content you cited is probably gone.',
                    'Run the check again to confirm the Problems tab is empty.',
                ],
            ],
            [
                'heading' => 'Which pages to check first',
                'paragraphs' => [
                    'The tool checks one page at a time, so start where a broken link costs the most: your home page, main menu and footer (which appear everywhere), your most visited articles, and any page that earns money or leads.',
                    'Old articles collect the most dead links, because they often point to sources that have since moved. Check them once or twice a year. A link in your menu or footer appears on every page, so fixing it once on the template fixes it everywhere.',
                ],
            ],
            [
                'heading' => 'How to fix what you find',
                'paragraphs' => [
                    'Broken outgoing links are mainly a problem for visitors. Google has said broken links are a normal part of the web, so do not panic over a few. Treat this as upkeep. To see how strong the sites linking to you are, try the [Bulk Domain Authority Checker](/domain-authority-checker).',
                ],
                'list' => [
                    'If the page moved, update the link to its new address.',
                    'If it is gone, find a replacement source or remove the link and adjust the sentence.',
                    'If the broken page is on your own site, add a redirect to the closest live page so existing links keep working.',
                    'Never delete a page that other sites link to without a redirect: that throws those links away.',
                    'For a broken image, upload the image again or point to a working copy, and keep its alt text.',
                ],
            ],
            [
                'heading' => 'What the checker does not see',
                'paragraphs' => [
                    'Knowing the limits helps you read a clean result correctly. The checker reads the page\'s HTML as the server sends it, the same way a search engine first sees it.',
                ],
                'list' => [
                    'Links added by JavaScript after the page loads are not in that HTML, so they are not checked.',
                    'Only ordinary links and images are tested. Email (mailto:), phone (tel:) and javascript: links are skipped, as are links to a #section on the same page.',
                    'The part of an address after # is ignored, so a link to a missing section of a working page shows as OK.',
                    'A page that says "not found" but returns a normal success code (a so-called soft 404) shows as OK, because the server reported success.',
                    'The same address linked twice on a page is checked once.',
                    'Only public websites can be checked. Addresses on your own computer or a private office network are refused.',
                    'On a page with more than 300 links, the first 300 are checked and a note tells you the rest were skipped.',
                ],
            ],
            [
                'heading' => 'If the page itself cannot be checked',
                'paragraphs' => [
                    'Sometimes the tool cannot read the page you entered, so it has no links to test. The message tells you why. If you run many checks in a short time you may be asked to wait a minute; the limits keep our server from hammering other sites.',
                ],
                'table' => [
                    'headers' => ['Message', 'Likely cause', 'What to do'],
                    'rows' => [
                        ['That website could not be found', 'A typo in the address, or the domain has expired', 'Check the spelling'],
                        [
                            'The page answered with error 404 (or another code)',
                            'The page you entered is itself missing or broken',
                            'Open it in a browser and check the address',
                        ],
                        ['The website did not respond', 'The site is down, slow or blocking automated checks', 'Try again later'],
                        ['That address is not a web page (HTML)', 'You entered a PDF, image or other file', 'Enter the page that links to it instead'],
                        ['This address can\'t be checked', 'A local, private or unusual address or port', 'Use the public address of the page'],
                    ],
                ],
            ],
            [
                'heading' => 'A simple routine',
                'paragraphs' => [
                    'Most sites only need a light, regular check rather than a big clean-up. Once a quarter, run the [Broken Link Checker](/broken-link-checker) on your home page and your five most visited pages, fix anything on the Problems tab, and keep the CSV files so you can see what changed since last time. Before publishing a long article with many sources, check it once too: sources you found months ago may already have moved. If the article is long and dense, the [Readability Checker](/readability-checker) is a useful second pass while you are editing.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does a broken link hurt SEO?', 'a' => 'A few rarely matter on their own. The clearer costs are a poor visitor experience and, for broken pages on your own site, losing the value of links pointing to them.'],
            ['q' => 'Can this check my whole website at once?', 'a' => 'No. It checks one page at a time, up to 300 links. Enter your other pages one by one.'],
            ['q' => 'Why is a working link marked Blocked?', 'a' => 'Some sites refuse automated requests or require a login. Open the link in a normal browser to confirm.'],
            ['q' => 'Are redirects a problem?', 'a' => 'Not usually. The link still works. Updating it to the final address saves a step for visitors and avoids surprises if the redirect is ever removed.'],
            ['q' => 'Does it check images too?', 'a' => 'Yes. Images on the page are checked alongside links and marked Image in the results.'],
            ['q' => 'Why does a link work for me but show No answer?', 'a' => 'The site may have been slow to respond, or it may ignore automated requests. Try the check again later, or open the link yourself.'],
        ],
        'sources' => [
            [
                'title' => 'MDN Web Docs, HTTP response status codes',
                'url' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Status',
            ],
        ],
    ],

    'how-to-check-how-old-a-domain-is' => [
        'title' => 'How to Check How Old a Domain Is (and Why It Matters)',
        'description' => 'Find out when any domain was registered, when it expires and who the registrar is. What domain age can and cannot tell you when judging a website or a purchase.',
        'h1' => 'How to check how old a domain is',
        'intro' => 'A domain\'s registration date is public record, and it is one quick way to judge a website you do not know. An online shop that claims twenty years in business on a domain registered last month deserves a closer look. Here is how to check, what the record shows, and the part people often get wrong: domain age does not make a site rank better.',
        'tool' => 'domain-age-checker',
        'related' => ['domain-authority-checker', 'broken-link-checker', 'what-is-my-ip'],
        'published' => '2026-11-04',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'How to check',
                'list' => [
                    'Open the [Domain Age Checker](/domain-age-checker).',
                    'Type or paste a domain, or up to 20 domains, one per line. Full addresses such as https://www.example.com/page are fine; they are reduced to the domain, and a leading www. is dropped.',
                    'Click Check domain age.',
                    'Read the table: created date, age, expiry, last update, registrar, status and nameservers for each domain.',
                    'Click Download CSV if you want to keep the results or compare them in a spreadsheet.',
                ],
                'paragraphs' => [
                    'We looked up wikipedia.org on 4 November 2026: it was created on January 13, 2001, which made it 25 years, 9 months and 22 days old that day. The age is shown in the short form 25y 9m 22d.',
                    'The tool looks the domain up in public registration records through our server, using RDAP, the structured successor to WHOIS. It sends only the domain name and does not keep a record of who searched for what. Registration records are cached on the server for up to a day, because they rarely change.',
                ],
            ],
            [
                'heading' => 'What the record shows',
                'table' => [
                    'headers' => ['Field', 'What it tells you'],
                    'rows' => [
                        ['Created', 'When this registration began'],
                        ['Age', 'Time since that date, in years, months and days'],
                        ['Expires', 'When it must be renewed'],
                        ['Last updated', 'When the record last changed, such as a renewal or a change of nameservers'],
                        ['Registrar', 'The company it was registered through'],
                        ['Status', 'Codes from the registry, such as client transfer prohibited'],
                        ['Nameservers', 'Where its DNS is hosted, which often hints at the hosting or DNS provider'],
                    ],
                ],
                'paragraphs' => [
                    'The owner\'s personal details are usually hidden for privacy, so this normally will not tell you who runs a site. Some registries also publish fewer fields than others; a dash in a column means the registry did not provide that value.',
                ],
            ],
            [
                'heading' => 'Reading the age: a worked example',
                'paragraphs' => [
                    'The age is counted in calendar months, not in blocks of 30 days. For wikipedia.org, January 13, 2001 to October 13, 2026 is 25 years and 9 months, and October 13 to November 4 adds 22 days: 18 days to the end of October plus 4 in November.',
                    'Now a hypothetical case. A shop\'s About page says it has been trading since 2005, but the domain shows Created August 20, 2026 and, on November 10, 2026, an age of 0y 2m 21d. That does not prove anything by itself: the business may have moved to a new domain. It is a reason to look for older evidence, such as reviews from before August 2026 or a company registration number you can look up.',
                ],
            ],
            [
                'heading' => 'Making sense of the status codes',
                'paragraphs' => [
                    'The Status column shows the registry\'s own codes, unchanged. Most healthy domains show active plus one or more "prohibited" codes, which are locks rather than problems.',
                ],
                'table' => [
                    'headers' => ['Status', 'What it usually means'],
                    'rows' => [
                        ['active', 'Registered and working normally'],
                        [
                            'client transfer prohibited',
                            'A lock set by the registrar so the domain cannot be moved to another registrar without the owner unlocking it; a normal security setting',
                        ],
                        ['client delete prohibited / client update prohibited', 'Further locks against accidental or unauthorised changes'],
                        ['redemption period', 'The domain expired and was not renewed; the previous owner can still restore it, usually for a fee'],
                        ['pending delete', 'The domain is about to be released and may soon be registrable by anyone'],
                    ],
                ],
                'list' => [
                    '"Server" versions of the same codes are set by the registry rather than the registrar, often for high-value domains.',
                    'A domain in redemption period or pending delete on a site you rely on is worth telling its owner about, if you can reach them.',
                ],
            ],
            [
                'heading' => 'When it is useful',
                'list' => [
                    'Checking a shop or a message before you pay: a very new domain is a reason to look harder, though not proof of anything.',
                    'Buying a domain: the history shows how long it has been registered.',
                    'Checking your own renewals: paste all your domains at once, download the CSV and note each expiry date so a domain never lapses by accident.',
                    'Researching competitors or link partners, alongside their [authority score](/domain-authority-checker).',
                    'Spotting look-alike domains: a domain that copies a well-known brand with one letter changed and was created recently is a classic phishing sign.',
                ],
            ],
            [
                'heading' => 'What it cannot tell you',
                'paragraphs' => [
                    'Age is not a measure of trust on its own. A new domain can belong to an honest new business, and an old one can be bought by anyone. The created date also resets if a domain lapses and is registered again, so it may not reach back to its earliest use. A domain that changed hands without lapsing keeps its original date, so an old date does not mean the same people have run it all along.',
                    'Domain age is also not a ranking boost. Google\'s John Mueller has said publicly that it does not help. Older sites often rank well because they have had longer to earn links and build content, not because of the date itself. Do not pay extra for an "aged" domain on that promise alone.',
                ],
            ],
            [
                'heading' => 'Troubleshooting',
                'table' => [
                    'headers' => ['Message or result', 'Likely cause', 'What to do'],
                    'rows' => [
                        [
                            'No RDAP record was found',
                            'The domain is not registered, was registered minutes ago, or you entered a subdomain',
                            'Check the spelling, and enter the registered domain (example.com rather than shop.example.com). A brand-new registration can take up to a day to show here',
                        ],
                        [
                            'This domain\'s extension does not have an RDAP service yet',
                            'Some country-code extensions do not offer RDAP',
                            'Use that registry\'s own WHOIS lookup page',
                        ],
                        [
                            'Skipped (not a domain)',
                            'The line was not a valid domain name',
                            'Remove spaces and stray characters, and include the extension, such as .com',
                        ],
                        ['Could not be checked right now', 'The registry did not answer in time', 'Try again in a minute'],
                        [
                            'Expiry date looks out of date',
                            'The domain was renewed after the record was cached',
                            'Check again the next day, or ask the registrar',
                        ],
                    ],
                ],
                'paragraphs' => [
                    'If you enter more than 20 domains, the tool asks you to shorten the list rather than checking only some of them. Duplicates are checked once.',
                ],
            ],
            [
                'heading' => 'A quick checklist for judging an unfamiliar site',
                'list' => [
                    'Check the domain age with the [Domain Age Checker](/domain-age-checker) and compare it with what the site claims about its history.',
                    'Look at the registrar and nameservers. They are not proof of anything, but a sudden change can explain why a long-running site suddenly looks different.',
                    'Search for independent reviews and complaints that predate the domain\'s creation date.',
                    'Check the site\'s links: a page full of [broken links](/broken-link-checker) suggests nobody maintains it.',
                    'Pay with a method that offers buyer protection when you are unsure.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does domain age affect SEO?', 'a' => 'Not directly. Google has said age itself does not help. Older sites simply have had more time to earn links and publish.'],
            ['q' => 'Can I see who owns a domain?', 'a' => 'Usually not. Most registrations hide personal details for privacy, though the registrar is shown.'],
            ['q' => 'Is a new domain a scam?', 'a' => 'Not necessarily. It is one signal to weigh along with reviews, contact details and payment protection.'],
            ['q' => 'How many domains can I check at once?', 'a' => 'Up to 20, one per line. Full URLs are reduced to the domain automatically, and you can download the results as a CSV.'],
            ['q' => 'Why does a subdomain show no record?', 'a' => 'Registration records exist for the registered domain, such as example.com, not for subdomains like blog.example.com. Enter the main domain instead.'],
            ['q' => 'Is RDAP the same as WHOIS?', 'a' => 'It holds the same registration data, served in a structured format. RDAP is the protocol that is replacing WHOIS.'],
        ],
        'sources' => [
            [
                'title' => 'ICANN, Registration Data Access Protocol (RDAP)',
                'url' => 'https://www.icann.org/rdap',
            ],
        ],
    ],

    'what-your-ip-address-reveals' => [
        'title' => 'What Your IP Address Reveals (and What It Does Not)',
        'description' => 'What a website can learn from your IP address and browser, what it cannot, how accurate IP location is, and what a VPN does and does not change.',
        'h1' => 'What your IP address reveals, and what it does not',
        'intro' => 'Every website you visit sees your public IP address, because that is how it knows where to send the page. It reveals less than most people fear, and also a bit more than some assume. An IP address points to your network and a rough location, not your name or your home. Here is what it shows, what else your browser shares, and what actually protects your privacy.',
        'tool' => 'what-is-my-ip',
        'related' => ['password-generator', 'domain-age-checker', 'qr-code-generator'],
        'published' => '2026-11-04',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'What an IP address shows',
                'paragraphs' => [
                    'Your public IP is assigned by your internet provider. From it, a website can usually work out your provider and an approximate location, often the city or region, and sometimes only the country. It often points to a provider\'s equipment rather than to your building, so "your location" on a lookup site can be a neighbouring city.',
                    'It does not reveal your name, street address, email or browsing history. Only your provider can link an IP to a customer, and normally only under legal process.',
                ],
            ],
            [
                'heading' => 'What your browser shares too',
                'paragraphs' => [
                    'The IP is only part of it. Open [What Is My IP](/what-is-my-ip) and you will see what any page can read from your browser without asking.',
                    'None of the details in the table below needs a permission prompt. Each one on its own is shared by millions of people, but together they narrow things down, which is why advertisers combine them into a so-called fingerprint. The tool also shows your full user agent string, so you can see exactly what your browser announces to every site.',
                ],
                'table' => [
                    'headers' => ['Detail', 'Where it comes from'],
                    'rows' => [
                        ['Public IP and IPv4 or IPv6', 'Your connection, seen by the server'],
                        ['Browser and operating system', 'The user agent your browser sends'],
                        ['Device type (desktop, mobile or tablet)', 'Worked out from the user agent'],
                        ['Screen resolution', 'Readable by the page'],
                        ['Language and time zone', 'Your browser settings'],
                        ['Whether cookies are enabled', 'Your browser settings'],
                    ],
                ],
            ],
            [
                'heading' => 'How our tool works',
                'paragraphs' => [
                    'To show your public IP, the page has to ask our server which address your request came from, since a page cannot see it alone. The IP is sent back to you and we do not store it in that lookup. Each request uses a unique address and tells caches not to keep the answer, so a cached copy can never show you someone else\'s IP. Click Refresh to look it up again, for example after switching network, and Copy IP to copy it.',
                    'The other details are read by the page in your own browser. Our tool does not look up a location for your IP; it shows the address and your browser details only. The site also uses analytics and advertising, as our privacy policy explains.',
                ],
            ],
            [
                'heading' => 'IPv4 and IPv6',
                'paragraphs' => [
                    'An IPv4 address is four numbers from 0 to 255 separated by dots, such as 203.0.113.9. There are only about 4.3 billion of them (2 to the power of 32), far fewer than the devices online, which is why providers share them. An IPv6 address is longer, written in groups of letters and digits separated by colons, such as 2001:db8::1, and the pool is so large that every device can have its own.',
                    'Many connections support both. When they do, your browser usually prefers IPv6, so seeing an IPv6 address on [What Is My IP](/what-is-my-ip) is normal. The badge next to your address tells you which one the site saw.',
                ],
            ],
            [
                'heading' => 'Public and private addresses',
                'paragraphs' => [
                    'Your router gives each device at home a private address, usually starting 192.168., 10. or 172.16. to 172.31. These addresses are reused in millions of homes and are not visible to websites. The router then sends everyone\'s traffic out through one public address, which is the one websites see.',
                    'That explains two things people often ask about. Every device on your home Wi-Fi shows the same public IP, and the address in your computer\'s network settings is different from the one our tool shows. Both are expected.',
                ],
            ],
            [
                'heading' => 'Dynamic, shared and VPN addresses',
                'list' => [
                    'Most home addresses are dynamic, so yours may change from time to time.',
                    'Phone networks and many providers share one public IP among lots of customers.',
                    'A VPN hides your IP from the sites you visit by showing the VPN\'s address instead, and hides your traffic from your provider. The VPN company can then see that traffic, so choose carefully.',
                ],
                'paragraphs' => ['A VPN does not make you anonymous. Logins, cookies and browser details can still identify you, as can a site you are signed in to.'],
            ],
            [
                'heading' => 'Test what your VPN actually changes',
                'list' => [
                    'With the VPN off, open [What Is My IP](/what-is-my-ip) and note the IP address, language and time zone.',
                    'Turn the VPN on and connect to a server in another country.',
                    'Click Refresh. The IP should change to the VPN\'s address.',
                    'Now look at the rest of the table. Your language and time zone have not changed, because they come from your device, not your connection.',
                    'If the IP did not change, the VPN is not routing your browser\'s traffic. Reconnect it, or check whether it is set to cover only some apps.',
                ],
                'paragraphs' => [
                    'The time zone point matters if you use a VPN to appear to be elsewhere. A site that sees a VPN address in one country and a browser time zone from another can tell that something does not match.',
                ],
            ],
            [
                'heading' => 'When knowing your IP is useful',
                'list' => [
                    'Setting up remote access or a game server, where someone asks for your public address.',
                    'Checking whether a VPN or proxy is on before you browse.',
                    'Giving your IP to support staff when a website or service has blocked it by mistake.',
                    'Adding your address to an allow list for a work system or a hosting control panel. Remember a dynamic address can change, so the allow list may need updating.',
                ],
            ],
            [
                'heading' => 'What actually protects you',
                'paragraphs' => [
                    'Your IP address is rarely the weak point. Most accounts are lost through reused or stolen passwords and phishing. Using a unique password for each account, from a [Password Generator](/password-generator) and a password manager, plus two-step sign-in, does more for most people than hiding an IP. Be careful about scanning unknown QR codes or clicking links in unexpected messages as well. If a message links to a website you do not recognise, checking how long its domain has existed with the [Domain Age Checker](/domain-age-checker) is a quick sanity test.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Can someone find my home address from my IP?', 'a' => 'Not from the IP alone. It usually shows an approximate area and your provider. Linking it to a customer normally needs the provider and a legal process.'],
            ['q' => 'Why does my IP show the wrong city?', 'a' => 'Location databases are estimates, and many point to your provider\'s equipment rather than your building.'],
            ['q' => 'Does my IP change?', 'a' => 'Often, yes. Most home connections have dynamic addresses, and using mobile data or a VPN gives you a different one.'],
            ['q' => 'Why do all my devices at home show the same IP?', 'a' => 'Your router shares one public address between every device on your network. Each device has its own private address inside the network, which websites do not see.'],
            ['q' => 'Why is my IP address IPv6?', 'a' => 'Your provider supports IPv6 and your browser used it. That is normal and works the same way for browsing.'],
            ['q' => 'What if the tool says it could not look up my IP?', 'a' => 'The request to our server did not get through, usually because the connection dropped or a privacy extension or firewall blocked it. Check your connection, allow the page if an extension blocked it, and click Refresh.'],
            ['q' => 'Does the What Is My IP tool show my location?', 'a' => 'No. It shows your public IP, whether it is IPv4 or IPv6, and the browser details any page can read. It does not look up a location.'],
        ],
        'sources' => [
            [
                'title' => 'MDN Web Docs, User-Agent header',
                'url' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/User-Agent',
            ],
        ],
    ],

    'how-to-reorder-and-delete-pdf-pages' => [
        'title' => 'How to Reorder and Delete Pages in a PDF (Free, No Upload)',
        'description' => 'Put PDF pages in the right order and remove the ones you do not need, in your browser. Steps, when to use each tool, and what stays the same in the file.',
        'h1' => 'How to reorder and delete pages in a PDF',
        'intro' => 'A scan comes out backwards, a report has a blank page in the middle, or an attachment needs only three pages out of twenty. You do not need a paid editor for any of these. Reordering and deleting pages are separate jobs with separate tools here, and both leave the content of the remaining pages untouched. Here is how to do each, and in what order if you need both.',
        'tool' => 'organize-pdf',
        'related' => ['delete-pdf-pages', 'pdf-to-png', 'split-pdf'],
        'published' => '2026-11-04',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'How to reorder pages',
                'list' => [
                    'Open [Organize PDF](/organize-pdf) and choose your file (one PDF, up to 200 MB). Each page appears as a numbered thumbnail.',
                    'Drag a page to its new position, or use the left and right arrow buttons under it to move it one place at a time.',
                    'Watch the numbers under the thumbnails: they show each page\'s new position, so you can check the order before saving.',
                    'Click Save new order and download the file. The button stays greyed out until you have actually moved something.',
                    'Open the result and check the order before you send it.',
                ],
                'paragraphs' => [
                    'The arrow buttons also work from the keyboard, which helps with long documents where dragging is awkward. We opened a 3-page test file this way, and it stayed on the device: 0 bytes were uploaded. The new file is saved with "-organized" added to its name, so it never overwrites the original.',
                ],
            ],
            [
                'heading' => 'How to delete pages',
                'list' => [
                    'Open [Delete PDF Pages](/delete-pdf-pages) and choose your file.',
                    'On the Select by thumbnail tab, click each page you want to remove. Marked pages are labelled Delete; click again to keep one.',
                    'Or switch to Page ranges and type them, such as 2, 4-6. You can also write 8- for "page 8 to the end" or -3 for "pages 1 to 3".',
                    'Click Delete pages. The tool tells you how many pages are left and the new file size.',
                    'Download the new file.',
                ],
                'paragraphs' => [
                    'Your original file is not changed. You always get a new copy (with "-pages-deleted" in its name), so a wrong selection costs nothing. Typing mistakes are caught before anything is built: a range like 6-4 is reported as backwards, a page number beyond the end of the file is reported as out of range, and you cannot delete every page, because a PDF needs at least one.',
                ],
            ],
            [
                'heading' => 'Which tool do you need?',
                'table' => [
                    'headers' => ['You want to', 'Use'],
                    'rows' => [
                        ['Change the page order', 'Organize PDF'],
                        ['Remove a few pages and keep the rest', 'Delete PDF Pages'],
                        ['Keep only a few pages from a long file', 'Split PDF'],
                        ['Turn a page the right way up', 'Rotate PDF'],
                        ['Turn a page into an image', 'PDF to PNG or PDF to JPG'],
                        ['Combine several files', 'Merge PDF'],
                    ],
                ],
                'paragraphs' => [
                    'If you only need 3 pages out of 200, [Split PDF](/split-pdf) is quicker than deleting 197. If you need a single page as a picture, such as for a slide, use [PDF to PNG](/pdf-to-png). A page that is sideways or upside down is a rotation problem, not an order problem: [Rotate PDF](/rotate-pdf) fixes that.',
                ],
            ],
            [
                'heading' => 'Worked example: tidying a 10-page report',
                'paragraphs' => [
                    'Say a 10-page report has a blank page at position 4, and the appendix (page 10) should come straight after the contents page (page 2). Here is the order of work that avoids mistakes.',
                ],
                'list' => [
                    'Delete first. In Delete PDF Pages, type 4 and click Delete pages. You now have 9 pages.',
                    'Notice the renumbering. Every page after the deleted one has moved up a place, so the old page 10, the appendix, is now page 9.',
                    'Reorder second. Open the new 9-page file in Organize PDF and drag the thumbnail in position 9 to position 3, right after the contents page.',
                    'Check the result. The order is now cover, contents, appendix, then the old pages 3, 5, 6, 7, 8 and 9.',
                ],
            ],
            [
                'heading' => 'Worked example: fixing a double-sided scan',
                'paragraphs' => [
                    'Scanners without a duplex feeder often produce a common mess. You scan the fronts of a 6-page document, turn the stack over and scan the backs, and because the stack is upside down the backs come in reverse. The file order is then 1, 3, 5, 6, 4, 2.',
                    'In Organize PDF, you want positions 1 to 6 to read 1, 2, 3, 4, 5, 6. Drag page 2 (currently last) to position 2, then page 4 to position 4. Pages 5 and 6 fall into place on their own. The thumbnails make it easy to recognise each page by its content even when the page numbers are hard to read. If some backs also came out upside down, run the file through [Rotate PDF](/rotate-pdf) as a separate step.',
                ],
            ],
            [
                'heading' => 'Doing both, and a warning',
                'paragraphs' => [
                    'If you need to do both jobs, delete first and reorder second, so you are not moving pages you are about to remove. Check the page numbers printed on the pages too: they are part of the page content, so moving a page does not renumber them.',
                    'Deleting a page removes it from the new file, but it does not remove sensitive text from the pages you keep. To hide something on a page you are keeping, use [Redact PDF](/redact-pdf), which removes the text instead of covering it.',
                ],
            ],
            [
                'heading' => 'What stays the same and what can change',
                'paragraphs' => [
                    'Both tools copy each page you keep into a new PDF exactly as it is: the text stays selectable, images keep their resolution, and nothing is re-compressed. Only the list of pages and their order changes.',
                    'Because the result is a newly built file, some document-wide extras that sit outside the pages may not come across, such as a bookmarks panel. A bookmark would point to the wrong place after a reorder anyway. If your document relies on bookmarks or fillable form fields, check the result in your PDF reader before deleting the original.',
                ],
            ],
            [
                'heading' => 'Troubleshooting',
                'table' => [
                    'headers' => ['What you see', 'What it means', 'What to do'],
                    'rows' => [
                        [
                            'The file is reported as password-protected',
                            'The PDF has a password, so its pages cannot be read',
                            'Remove it with the Unlock PDF tool (you need to know the password), then try again',
                        ],
                        [
                            '"Could not be read. It may be damaged"',
                            'The file is broken or not really a PDF',
                            'Open it in a PDF reader and save or print a fresh copy to PDF',
                        ],
                        ['Save new order is greyed out', 'Nothing has moved yet', 'Move at least one page'],
                        [
                            'A range is reported as out of range',
                            'You typed a page number higher than the file has',
                            'Check the page count shown next to the file name',
                        ],
                        [
                            'Thumbnails are slow to appear',
                            'Large or image-heavy pages take time to draw',
                            'Wait for them; the page numbers are already correct',
                        ],
                    ],
                ],
            ],
            [
                'heading' => 'Before you send the file',
                'list' => [
                    'Open the downloaded copy, not the original, and page through it once.',
                    'Check that the first page is the one you expect, since that is what a recipient sees first.',
                    'If the file is going by email, [Compress PDF](/compress-pdf) can shrink a large scan afterwards.',
                    'Keep the original until you are sure the new copy is right.',
                ],
                'paragraphs' => [
                    'For a job that needs several changes, it is fine to chain the tools: delete pages, reorder them in [Organize PDF](/organize-pdf), then rotate or compress. Each step works on the file from the step before and keeps every remaining page intact.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does reordering change the quality of the pages?', 'a' => 'No. Pages are copied as they are; only their position changes.'],
            ['q' => 'Can I undo a change?', 'a' => 'Your original file is untouched, so open it again and start over. The tools always create a new copy.'],
            ['q' => 'Are my files uploaded?', 'a' => 'No. Both tools work in your browser. In our test the network log showed 0 bytes uploaded.'],
            ['q' => 'Can I delete pages and reorder them in one step?', 'a' => 'Not in one tool. Delete the pages first, then open the new file in Organize PDF and reorder it. Remember that pages after a deleted one move up a place.'],
            ['q' => 'How do I type a range up to the last page?', 'a' => 'Leave the end blank or write end. For a 20-page file, 15- and 15-end both mean pages 15 to 20.'],
            ['q' => 'Can I reorder a password-protected PDF?', 'a' => 'Not directly. Remove the password first with Unlock PDF, which needs the password, then reorder the unlocked copy.'],
        ],
        'sources' => [
            [
                'title' => 'pdf-lib, create and modify PDF documents in JavaScript',
                'url' => 'https://pdf-lib.js.org/',
            ],
        ],
    ],

    'how-to-remove-a-pdf-password' => [
        'title' => 'How to Remove a PDF Password You Already Know',
        'description' => 'Remove the open password from a PDF when you know it, in your browser with no upload, and what to do if you have lost the password.',
        'h1' => 'How to remove a PDF password you already know',
        'intro' => 'Bank statements and payslips often arrive locked with a password, and typing it every time gets old. If you know the password, removing it takes a few seconds and gives you an ordinary PDF. If you do not know it, this is not the guide for you: our tool will not crack or guess one. Here is how it works, when you should keep the password, and what to do if yours is lost.',
        'tool' => 'unlock-pdf',
        'related' => ['protect-pdf', 'password-generator', 'compress-pdf'],
        'published' => '2026-11-04',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'How to remove it',
                'list' => [
                    'Open [Unlock PDF](/unlock-pdf) and choose the locked file (one PDF, up to 200 MB). The tool first checks that the file really is password-protected.',
                    'Type the password once in the PDF password box. Click Show if you want to see what you typed.',
                    'Click Unlock PDF. When it succeeds you see how many pages the new file has and its size, with no password.',
                    'Click Download unlocked PDF. The copy is saved with "-unlocked" added to its name.',
                    'Keep or delete the locked original as you prefer. It is not changed.',
                ],
                'paragraphs' => [
                    'The work happens in your browser using a WebAssembly build of the open-source QPDF library, so neither the file nor the password leaves your device. The first time you unlock a file, your browser downloads the QPDF program itself (about 1.3 MB) from a public code server; that is code coming to you, not your PDF going anywhere. If the password is wrong you see an "Incorrect password" message and can try again. If you give it a PDF with no password, it tells you there is nothing to unlock: we got "plain.pdf does not have a password" when we tested that.',
                ],
            ],
            [
                'heading' => 'Two kinds of PDF password',
                'paragraphs' => [
                    'PDFs can carry two different passwords, and it helps to know which one you are dealing with. The table below shows how to tell them apart.',
                    'Bank statements, payslips and tax documents sent by email usually use an open password, which is exactly what this tool removes once you supply it. A file can also have both. Whichever you have, the rule is the same: the tool needs a correct password from you, and it removes the protection only after that password has been accepted.',
                ],
                'table' => [
                    'headers' => ['Type', 'What you notice', 'What it does'],
                    'rows' => [
                        [
                            'Open password (also called a user password)',
                            'The file asks for a password before it shows anything',
                            'Encrypts the content, so nobody can read it without the password',
                        ],
                        [
                            'Permissions password (also called an owner password)',
                            'The file opens normally, but printing, copying or editing is blocked',
                            'Sets restrictions that PDF readers are expected to respect',
                        ],
                    ],
                ],
            ],
            [
                'heading' => 'What it will not do',
                'paragraphs' => [
                    'It does not crack, guess or bypass a password you do not have. Protection that any website could remove would not protect anything, so be wary of sites promising to do that with your confidential files: you would be uploading them to a stranger to do it.',
                    'Only remove passwords from files you are entitled to use. Being sent a document does not always give you the right to remove its protection.',
                ],
            ],
            [
                'heading' => 'When the password will not work',
                'paragraphs' => [
                    'Most "Incorrect password" messages come from small typing problems rather than a wrong password. Work through these before asking for a new one.',
                ],
                'list' => [
                    'Passwords are case-sensitive. Check Caps Lock, and check whether letters in the format should be capitals.',
                    'Click Show and read what you actually typed. It is easy to miss a doubled letter or a missing digit.',
                    'If you pasted the password from an email, a space may have come with it at the start or end. Type it by hand instead.',
                    'Check the keyboard layout. On a different language layout, some symbols and even letters such as y and z can swap places.',
                    'Dates are a common trap. A format of DDMMYYYY written as MMDDYYYY, or with slashes, will be rejected.',
                    'Make sure you are using the password for this file. Some senders use a different password for each statement.',
                ],
            ],
            [
                'heading' => 'A worked example: a statement password format',
                'paragraphs' => [
                    'Many senders explain the format rather than sending the password itself. Here is a made-up example of the kind of rule you might see: "the first four letters of your surname in capitals, followed by the day and month of your birth". For someone called Ana Smithson born on 5 December, that gives SMIT0512.',
                    'Each part is a place to go wrong: smit0512 fails because of the lower-case letters, SMITH0512 fails because it has five letters, and SMIT1205 fails because the day and month are swapped. Read the instructions slowly, write the password down once, and type it from your note.',
                ],
            ],
            [
                'heading' => 'If you have lost the password',
                'list' => [
                    'Ask whoever sent the file. Banks and employers can usually resend it or tell you the format.',
                    'Check the original email: statements often explain the format, such as a date of birth plus part of an account number.',
                    'Look in your password manager, if you set the password yourself.',
                    'Download the document again from your online banking or employee portal; the copy there may not be password-protected at all.',
                ],
            ],
            [
                'heading' => 'Should you remove it at all?',
                'paragraphs' => [
                    'A password protects the file wherever it goes. Remove it for a copy you are keeping safely on your own device, or when you need to [compress](/compress-pdf) or merge the file. Think twice before removing it from anything you will email, because email is not a safe place for an unprotected payslip or ID.',
                    'To lock a file again, use [Protect PDF](/protect-pdf) with a strong password from the [Password Generator](/password-generator). Send the password by a different route than the file, such as a text message for a file sent by email.',
                ],
            ],
            [
                'heading' => 'Why other PDF tools ask you to unlock first',
                'paragraphs' => [
                    'Our other PDF tools cannot read the pages of a password-protected file, so they show a message asking you to remove the password first. A common workflow is to run the file through [Unlock PDF](/unlock-pdf), do the job you actually need, then lock it again if it is going to leave your device.',
                ],
                'list' => [
                    'Combining several statements into one file: unlock each, then use [Merge PDF](/merge-pdf).',
                    'Making a large scan small enough to email: unlock, compress, then protect again.',
                    'Removing pages you do not need, such as marketing inserts: unlock, then delete the pages.',
                ],
            ],
            [
                'heading' => 'Keeping unlocked copies safe',
                'paragraphs' => ['Once the password is gone, the file is only as safe as the place you keep it. A few habits make a big difference.'],
                'list' => [
                    'Store unlocked statements in one folder on a device protected by its own sign-in, rather than scattered across Downloads.',
                    'Be careful with folders that sync to the cloud or are shared with family or colleagues: anyone with access can now open the file.',
                    'Delete unlocked copies you no longer need, and empty the recycle bin or trash afterwards.',
                    'If you must send an unlocked file, protect it again first instead of attaching the open copy.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Can this tool recover a forgotten password?', 'a' => 'No. It only removes a password you type in yourself.'],
            ['q' => 'Does removing the password change the PDF?', 'a' => 'No. Only the protection is removed. Pages, text and images stay as they were.'],
            ['q' => 'Is it safe to type my password here?', 'a' => 'The password is used in your browser and is not sent to any server. In our testing, the tool made no upload.'],
            ['q' => 'Why does it say my PDF does not have a password?', 'a' => 'The file is not encrypted, so there is nothing to remove. If it still asks for a password in another app, that app may be opening a different copy.'],
            ['q' => 'Why do I keep getting Incorrect password?', 'a' => 'Check capital letters, stray spaces from copying, keyboard layout and the order of any date. Click Show to see exactly what you typed.'],
            ['q' => 'Can I add a password back later?', 'a' => 'Yes. Protect PDF adds a new open password to any unprotected PDF, also in your browser.'],
        ],
        'sources' => [
            [
                'title' => 'QPDF documentation',
                'url' => 'https://qpdf.readthedocs.io/',
            ],
        ],
    ],

    'how-to-convert-excel-to-pdf' => [
        'title' => 'How to Convert Excel to PDF Without Losing Your Data',
        'description' => 'Turn a spreadsheet into a PDF in your browser: what comes through, what does not, and how to prepare a sheet first so wide columns are not cut off.',
        'h1' => 'How to convert Excel to PDF',
        'intro' => 'A PDF is the safe way to send a spreadsheet to someone who only needs to read it: it looks the same everywhere, and nobody can change a formula by accident. Our converter works in your browser and turns each sheet into a clean table. It deliberately keeps the data rather than the design, so it is worth knowing what comes through, how the pages are laid out, and how to prepare a sheet so nothing important is cut off before you rely on it.',
        'tool' => 'excel-to-pdf',
        'related' => ['html-to-pdf', 'pdf-to-excel', 'word-to-pdf'],
        'published' => '2026-11-04',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'How to convert',
                'list' => [
                    'Open [Excel to PDF](/excel-to-pdf) and choose one .xlsx, .xls or .csv file, up to 50 MB.',
                    'Pick a Page size (A4 or Letter) and an Orientation (Portrait or Landscape). The page size starts on the one usual where you are, guessed from your browser\'s language and time zone, so check it if you are sending the file abroad.',
                    'Click Convert to PDF. Each sheet becomes a table across one or more pages, with the header row repeated on each page.',
                    'Click Download PDF and read through the result before sending it.',
                    'If something looks wrong, change the settings or fix the sheet and convert again. Changing a setting clears the old result, so you always download the version that matches what you see.',
                ],
                'paragraphs' => [
                    'The file is read and the PDF is built on your device. Nothing is uploaded, which matters when a spreadsheet holds salaries, customer lists or bank details.',
                ],
            ],
            [
                'heading' => 'What comes through and what does not',
                'table' => [
                    'headers' => ['Kept', 'Not kept'],
                    'rows' => [
                        ['Cell values, including the results of formulas', 'The formulas themselves'],
                        ['Every sheet with data, each starting on a new page', 'Charts'],
                        ['The first row, in bold and repeated on every page', 'Cell colours'],
                        ['Table layout with light borders', 'Merged cells'],
                        ['The sheet name as a heading on each page', 'Fonts, column widths and print settings from Excel'],
                    ],
                ],
                'paragraphs' => [
                    'Values come through as text formatted the way the sheet formats them, so a date or a currency amount usually looks as it does on screen. Empty sheets are skipped. If every sheet is empty you get the message "This spreadsheet has no data to convert", and a damaged or renamed file that is not really a spreadsheet is refused with a clear error instead of producing a broken PDF.',
                    'Text too wide for its column is shortened with "…". That is the main thing to check, because a cut-off value in a report can look like a complete one.',
                ],
            ],
            [
                'heading' => 'How the pages are laid out',
                'paragraphs' => [
                    'Every page has 15 mm margins, the sheet name at the top (with "(continued)" on the second and later pages of the same sheet), and rows of a fixed height in 9-point text. Each column is first made wide enough for its longest value. If all the columns together are wider than the page, they are all narrowed by the same proportion until they fit. The text does not get smaller, so narrower columns mean more values are shortened with "…".',
                    'That gives a simple rule: the converter never spreads one sheet\'s columns across two pages. All the columns sit side by side on each page, and long sheets simply continue downwards onto more pages.',
                ],
            ],
            [
                'heading' => 'A worked example: 500 rows in each setting',
                'paragraphs' => [
                    'Take a sheet with one header row and 500 data rows. The number of rows that fit depends on the page size and orientation, and the header is repeated at the top of every page, so the page counts work out as shown in the table below the tips.',
                ],
                'table' => [
                    'headers' => ['Setting', 'Usable width', 'Data rows per page', 'Pages for 500 rows'],
                    'rows' => [
                        ['A4 portrait', 'About 180 mm', '45', '12'],
                        ['A4 landscape', 'About 267 mm', '29', '18'],
                        ['Letter portrait', 'About 186 mm', '41', '13'],
                        ['Letter landscape', 'About 249 mm', '30', '17'],
                    ],
                ],
                'list' => [
                    'Narrow sheet with a few columns: choose portrait. You get the fewest pages and nothing is squeezed.',
                    'Wide sheet with many columns: choose landscape. It costs more pages, but each column gets roughly half as much width again, so far fewer values are cut off.',
                    'Suppose your columns would need about 1,000 points of width at full size. In A4 portrait (about 510 points usable) each column is squeezed to roughly 51% of its natural width; in A4 landscape (about 757 points) it keeps roughly 76%.',
                ],
            ],
            [
                'heading' => 'Prepare your sheet first',
                'list' => [
                    'Make the real column headers the first row. The tool treats row 1 as the header, so a report title typed above the headers would be printed in bold and repeated on every page instead.',
                    'Delete working sheets and scratch columns you do not want to share. Hiding them in Excel is not enough: delete them, or copy only the sheet you need into a new file.',
                    'Shorten long text or split it across columns, so nothing is cut off. A notes column full of sentences is the usual cause of "…".',
                    'Unmerge cells and give each column a clear header.',
                    'Rename sheets to something meaningful, since the sheet name becomes the heading on every page. "Sheet1" tells the reader nothing; "Q3 sales by region" does.',
                    'Save or convert the charts separately if the reader needs them.',
                ],
                'paragraphs' => [
                    'If the exact look matters, such as a designed invoice with colours and a logo, Excel\'s own Save as PDF will keep it better. Our tool is for getting the data into a readable PDF quickly, without installing anything and without uploading a file that may hold salaries or customer details.',
                ],
            ],
            [
                'heading' => 'Common problems and how to fix them',
                'table' => [
                    'headers' => ['Problem', 'Likely cause', 'Fix'],
                    'rows' => [
                        [
                            'Values end in "…"',
                            'Too many or too long columns for the page width',
                            'Switch to Landscape, remove columns the reader does not need, or shorten the text',
                        ],
                        [
                            'A title appears in bold at the top of every page',
                            'The title is in row 1, above the real headers',
                            'Delete the title row so the headers are row 1',
                        ],
                        [
                            'A sheet you did not expect appears',
                            'Every sheet with data is converted',
                            'Delete that sheet, or copy the one you want into a new file',
                        ],
                        [
                            'The paper size is wrong for the recipient',
                            'A4 or Letter was guessed from your browser',
                            'Choose the other Page size and convert again',
                        ],
                        [
                            '"This file could not be read"',
                            'The file is damaged, password-protected or not really a spreadsheet',
                            'Open it in Excel, save a fresh copy as .xlsx and try that',
                        ],
                    ],
                ],
                'paragraphs' => [
                    'A CSV file has no sheets of its own, so it becomes a single table. If a CSV comes out with everything in one column, its separator was probably not recognised; open it in your spreadsheet program, check it splits into columns correctly, and save it as .xlsx before converting.',
                ],
            ],
            [
                'heading' => 'Before you send it',
                'paragraphs' => [
                    'Scroll through every page of the PDF and look for three things: values ending in "…", the page count (a 2-page summary that became 40 pages means a large sheet was included by mistake), and anything you did not intend to share. A PDF is easy to forward, so treat it as public once it leaves your hands.',
                    'If the PDF is large because a sheet is very long, [Compress PDF](/compress-pdf) can help before emailing, though a table of text is usually small already. To add the table to a longer report, convert it here and then combine the files with [Merge PDF](/merge-pdf).',
                ],
            ],
            [
                'heading' => 'Related conversions',
                'paragraphs' => [
                    'Going the other way, [PDF to Excel](/pdf-to-excel) pulls tables back out of a PDF. For a document rather than a table, use [Word to PDF](/word-to-pdf). For a web page or plain text, [HTML to PDF](/html-to-pdf) handles headings, paragraphs, lists and images; its own tables and custom styling are not kept, so use [Excel to PDF](/excel-to-pdf) when your content is really a table.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Are formulas kept in the PDF?', 'a' => 'No. A PDF shows the values, not the formulas. Keep your original spreadsheet to edit them.'],
            ['q' => 'Why are some cells cut off?', 'a' => 'Text too wide for its column is shortened with "…". Switch to landscape, remove unneeded columns, or shorten the text, then convert again.'],
            ['q' => 'Can I convert a CSV file?', 'a' => 'Yes. The tool accepts .xlsx, .xls and .csv files up to 50 MB.'],
            ['q' => 'Will a wide sheet be split across two pages side by side?', 'a' => 'No. All columns are fitted onto the page width by narrowing them, and long sheets continue onto more pages downwards.'],
            ['q' => 'Can I convert only one sheet from a workbook?', 'a' => 'The tool converts every sheet that has data. To convert just one, delete the others or copy that sheet into a new file first.'],
            ['q' => 'Is my spreadsheet uploaded?', 'a' => 'No. The file is read and the PDF is created in your browser, so the data stays on your device.'],
        ],
        'sources' => [
            [
                'title' => 'SheetJS documentation',
                'url' => 'https://docs.sheetjs.com/',
            ],
        ],
    ],

    'should-you-convert-jpg-to-png' => [
        'title' => 'Should You Convert JPG to PNG? Our Test Says Usually Not',
        'description' => 'We converted a photo from JPG to PNG: 88 KB became 571 KB with no gain in quality. When conversion makes sense, and why PNG cannot restore lost detail.',
        'h1' => 'Should you convert JPG to PNG?',
        'intro' => 'Converting a JPG to PNG does not make it better. PNG keeps every pixel it is given, but the detail JPG threw away when the photo was saved is already gone. In our test a photo grew from 88 KB to 571 KB, more than six times larger, and looked the same. There are good reasons to convert, but "higher quality" is not one of them. Here is when it helps and when to leave the file alone.',
        'tool' => 'jpg-to-png',
        'related' => ['avif-to-png', 'pdf-to-png', 'image-compressor'],
        'published' => '2026-11-04',
        'updated' => '2026-11-10',
        'sections' => [
            [
                'heading' => 'What we measured',
                'paragraphs' => [
                    'We ran a photo-like 800 x 533 JPG, generated for the test, through [JPG to PNG](/jpg-to-png) on 4 November 2026. It went from 88 KB to 571 KB, about 6.5 times the size. The exact ratio will vary with your image, but photos always grow a lot, because PNG cannot use the tricks that make JPG small.',
                ],
                'table' => [
                    'headers' => ['Format', 'Size', 'Change'],
                    'rows' => [
                        ['JPG (original)', '88 KB', '-'],
                        ['PNG (converted)', '571 KB', 'About 6.5x larger'],
                    ],
                ],
            ],
            [
                'heading' => 'Where the extra size comes from',
                'paragraphs' => [
                    'An 800 x 533 image has 426,400 pixels. Stored raw, at 3 bytes per pixel for red, green and blue, that is about 1.28 MB of data. The JPG squeezed that into 88 KB, roughly 7% of the raw size, by throwing away fine detail the eye barely notices. PNG is not allowed to throw anything away, so the best it managed was 571 KB, still around 45% of the raw size.',
                    'PNG compresses well when neighbouring pixels repeat: flat colours, sharp edges, text and screenshots. A photo has noise and subtle gradients almost everywhere, and a JPG adds its own small compression artifacts on top, so there is very little repetition for PNG to exploit.',
                ],
            ],
            [
                'heading' => 'Why PNG cannot restore quality',
                'paragraphs' => [
                    'JPG is lossy: it discards detail to save space, and that happens when the JPG is saved. PNG is lossless: it stores exactly what it receives. So converting faithfully preserves the JPG\'s existing blur and artifacts, in a bigger file. The only way to get better quality is to go back to the original photo.',
                    'Think of it like photocopying a photocopy onto better paper: the paper is nicer, but the copy is no sharper than what you started with.',
                ],
            ],
            [
                'heading' => 'When converting does make sense',
                'list' => [
                    'You will edit the image and save it several times. Each time a JPG is opened and saved again it is compressed again and can lose a little more; PNG stops further loss from building up.',
                    'A form or app insists on PNG.',
                    'The image is a graphic, a logo or a screenshot that you will keep editing.',
                    'You want to add transparency in an editor, since JPG has none. Converting alone does not make the background transparent; use the [Background Remover](/remove-background) for that.',
                ],
            ],
            [
                'heading' => 'When to leave it alone',
                'list' => [
                    'It is a photo for a website: JPG, WebP or AVIF will be far smaller.',
                    'You are emailing it: the larger file only gets in the way.',
                    'You want it to look sharper: conversion will not do that.',
                    'An upload has a size limit: a file six times bigger may no longer fit.',
                ],
                'paragraphs' => [
                    'If the real problem is file size, the [Image Compressor](/image-compressor) is what you want. Our [AVIF, WebP and JPG file-size test](/guides/avif-vs-webp-vs-jpg-file-size-test) shows how the modern formats compare, and [JPG vs PNG vs WebP vs AVIF](/guides/jpg-vs-png-vs-webp-vs-avif) explains which format suits which job.',
                ],
            ],
            [
                'heading' => 'A quick decision guide',
                'table' => [
                    'headers' => ['Your situation', 'Best choice', 'Why'],
                    'rows' => [
                        ['Holiday photo for a blog or shop page', 'Keep JPG, or compress it', 'Smallest file with no visible difference'],
                        ['Screenshot you will annotate and re-save', 'Convert to PNG', 'No new loss each time you save'],
                        ['Logo you received as a JPG', 'Ask for the original PNG or SVG', 'Converting keeps the JPG\'s fuzzy edges'],
                        ['Upload form that only accepts PNG', 'Convert to PNG', 'The form requires it; check its size limit'],
                        ['Photo that looks blurry', 'Find the original or a larger copy', 'No conversion can add missing detail'],
                    ],
                ],
            ],
            [
                'heading' => 'How to convert, if you need to',
                'list' => [
                    'Open [JPG to PNG](/jpg-to-png) and drop in your images, or click to choose them. You can add up to 30 at a time, up to 50 MB each.',
                    'Conversion starts straight away. There is no quality slider, because PNG is lossless and has no quality setting to choose.',
                    'Download each PNG on its own, or click Download all (ZIP) to get every converted image in one file.',
                    'Use Clear all to start again with a new batch, or remove a single image from the list if you added it by mistake.',
                ],
                'paragraphs' => [
                    'The page also accepts PNG, WebP, AVIF, GIF and BMP files, so you can turn a mixed folder into PNGs in one go. Each image keeps its width and height; only an extremely large image, more than 10,000 pixels on a side, is scaled down to fit that limit.',
                ],
            ],
            [
                'heading' => 'What changes besides the format',
                'paragraphs' => [
                    'The image is redrawn by your browser and saved fresh, so the new PNG contains only the picture. Hidden information stored inside many JPGs, such as the camera model, the date taken and sometimes GPS coordinates, is not copied across. That is useful if you are about to share a photo publicly, but keep the original if you rely on that information for sorting your photo library.',
                    'Colours should look the same on screen. If you are preparing images for professional print, check the result with whoever is printing it, since print workflows can depend on embedded colour information that a browser does not carry over.',
                ],
            ],
            [
                'heading' => 'Common mistakes',
                'list' => [
                    'Converting to fix a blurry photo. The blur is in the pixels, and PNG keeps the pixels exactly.',
                    'Converting a photo for a website "for quality". Visitors download a much bigger file and see no difference.',
                    'Expecting a transparent background. The white or coloured background in the JPG stays exactly where it is.',
                    'Converting back and forth. Going JPG to PNG and then to JPG again compresses the image a second time; keep one master copy instead.',
                    'Deleting the originals. Keep the JPGs until you have checked the PNGs, especially if you care about the photo details mentioned above.',
                ],
            ],
            [
                'heading' => 'Other routes to PNG',
                'paragraphs' => [
                    'Starting from another format? [AVIF to PNG](/avif-to-png) works the same way. To get a PDF page as a crisp image, [PDF to PNG](/pdf-to-png) suits pages with sharp text and diagrams, because PNG keeps edges clean where JPG tends to smudge them. Going the other way, [PNG to JPG](/png-to-jpg) turns large screenshots or exports into much smaller photos when transparency is not needed. In each case the file stays on your device: our network log showed 0 bytes uploaded during the conversion.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does converting JPG to PNG improve quality?', 'a' => 'No. It keeps the image exactly as it is now, in a larger file. Detail lost when the JPG was saved does not come back.'],
            ['q' => 'Why did my PNG get so much bigger?', 'a' => 'PNG is lossless, and photos contain too much fine variation for it to compress well. In our test the file grew about 6.5 times.'],
            ['q' => 'Does a converted PNG have a transparent background?', 'a' => 'No. JPG has no transparency, so the background stays. Use a background remover for that.'],
            ['q' => 'Can I convert several JPGs at once?', 'a' => 'Yes. Add up to 30 images, up to 50 MB each, and download them one by one or together as a ZIP file.'],
            ['q' => 'Are my photos uploaded?', 'a' => 'No. The conversion runs in your browser, and our network log showed 0 bytes uploaded.'],
            ['q' => 'Does the PNG keep the photo\'s location and camera data?', 'a' => 'No. The image is redrawn and saved fresh, so details such as camera model and GPS position stored in the JPG are not copied into the PNG.'],
        ],
        'sources' => [
            [
                'title' => 'MDN Web Docs, Image file type and format guide',
                'url' => 'https://developer.mozilla.org/en-US/docs/Web/Media/Guides/Formats/Image_types',
            ],
        ],
    ],

    'how-to-convert-avif-to-jpg' => [
        'title' => 'How to Convert AVIF to JPG (and When You Should)',
        'description' => 'Convert AVIF images to JPG for free in your browser, keep enough quality, and learn when JPG is the better choice over AVIF for sharing, editing or printing.',
        'h1' => 'How to convert AVIF to JPG',
        'intro' => 'You save a photo from a website or your phone, and instead of opening normally it shows up as a broken icon or an "unsupported file" error. More often than not, the file is AVIF, a newer image format that saves space but that a lot of older apps, editors and upload forms still cannot read. Converting it to JPG fixes that in seconds. Here is how to do it, what you gain and lose in the process, and when to leave the file as AVIF instead.',
        'tool' => 'avif-to-jpg',
        'related' => ['avif-to-png', 'avif-to-webp', 'image-compressor'],
        'published' => '2026-11-05',
        'updated' => '2026-11-05',
        'sections' => [
            [
                'heading' => 'Why AVIF files cause problems in the first place',
                'paragraphs' => [
                    'AVIF stores images using the same compression ideas as the AV1 video codec, which lets it pack a photo into a noticeably smaller file than JPG at a similar visual quality. Current versions of Chrome, Firefox, Safari and Edge all display AVIF directly, and many phones and websites now save or serve images in this format by default, which is why you keep running into it.',
                    'The catch is everything built before AVIF existed. Many photo editors, some office software, certain printers, and upload forms for things like passport photos or online marketplaces only recognize older formats. They do not throw a helpful error; the file just silently fails to open or upload, which is confusing the first few times it happens.',
                ],
            ],
            [
                'heading' => 'Converting AVIF to JPG, step by step',
                'list' => [
                    'Open the [AVIF to JPG converter](/avif-to-jpg).',
                    'Drop in your AVIF file, or click the box to choose it from your device; you can add up to 30 at once if you have a batch to get through.',
                    'Leave the quality slider at 85% for a good balance of sharpness and file size, or raise it toward 100% if the image will be printed or zoomed into.',
                    'Click Download next to a single image, or use "Download all (ZIP)" when you converted more than one.',
                    'Open the downloaded JPG to confirm it looks right before you delete the original AVIF.',
                ],
            ],
            [
                'heading' => 'Converting a batch without uploading anywhere',
                'paragraphs' => [
                    'If you have a folder full of AVIF photos from a camera roll export or a website scrape, converting them one at a time in a desktop app is tedious. The browser-based converter linked above handles up to 30 files in a single batch: drop the whole folder\'s selection in at once, let it process each image, and download everything together as one ZIP instead of 30 separate clicks.',
                    'Because the conversion runs entirely in your browser\'s own code rather than on a server, none of the images are sent anywhere over the network to be processed. That matters most for anything personal, such as scanned documents saved as AVIF, photos of ID cards, or pictures you have not shared publicly; nothing leaves your device at any point in the process.',
                ],
            ],
            [
                'heading' => 'What changes and what does not',
                'paragraphs' => [
                    'A conversion like this is not completely free: JPG and AVIF compress images differently, so a few things shift along the way.',
                ],
                'table' => [
                    'headers' => ['Property', 'What happens when you convert'],
                    'rows' => [
                        ['File size', 'Usually grows, because AVIF is more efficient than JPG at the same visual quality'],
                        ['Transparency', 'Lost. JPG has no transparency channel, so any transparent area is filled in, normally with white'],
                        ['Image quality', 'Set by the quality slider; 85% or higher keeps photos looking sharp to the eye'],
                        ['Compatibility', 'Improves a lot, since JPG opens in essentially every app, editor, printer and upload form'],
                        ['Animation', 'AVIF can hold a short animated sequence; converting to JPG keeps only a single still frame'],
                    ],
                ],
            ],
            [
                'heading' => 'When converting is the right call',
                'list' => [
                    'An upload form, print shop or older editor rejects the AVIF file outright.',
                    'You are sending the image to someone whose phone, email client or software you do not control and cannot guarantee supports AVIF.',
                    'The image needs to go into a document, slideshow or template that expects JPG.',
                    'You want the smallest possible JPG for an old workflow that has no AVIF option, even though AVIF itself would have been smaller.',
                ],
            ],
            [
                'heading' => 'When to leave it as AVIF',
                'paragraphs' => [
                    'If the image is only going on a modern website, or staying on a device and in apps you know support AVIF, converting just makes the file bigger for no benefit. Keep it as AVIF for web use, and only convert the specific copy you need to hand off somewhere that cannot read it.',
                    'If the AVIF has a transparent background you need to keep, convert to PNG instead, since JPG discards transparency entirely; the [AVIF to PNG converter](/avif-to-png) handles that without flattening it to white.',
                ],
            ],
            [
                'heading' => 'Common mistakes',
                'list' => [
                    'Assuming a "file won\'t open" error means the photo is corrupted, when it is usually just an unsupported format, AVIF, that the app has never seen before.',
                    'Converting at a very low quality setting to save space, then noticing visible blotching around sharp edges or text in the image; raise the quality slider instead of guessing.',
                    'Converting an AVIF with a transparent logo or graphic to JPG and being surprised the transparent area turned solid white - that is expected; use PNG for anything that needs to stay transparent.',
                    'Re-converting the same image back and forth between formats repeatedly, which loses a little quality each time a lossy format like JPG is re-saved; keep the original AVIF and convert fresh from it each time instead.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Why can\'t I open an AVIF file?', 'a' => 'AVIF is a newer image format. Current web browsers display it, but many older apps, photo editors, printers and upload forms do not support it yet, so the file fails to open until you convert it to a more common format like JPG.'],
            ['q' => 'Will converting AVIF to JPG make the file bigger?', 'a' => 'Usually, yes. AVIF compresses images more efficiently than JPG, so the same picture typically takes up more space once it becomes a JPG, even at a similar visual quality.'],
            ['q' => 'What happens to a transparent background when I convert to JPG?', 'a' => 'It is lost. JPG does not support transparency, so any transparent area is filled in, normally with white. If you need to keep transparency, convert the AVIF to PNG instead.'],
        ],
        'sources' => [
            ['title' => 'Alliance for Open Media, AV1 Image File Format (AVIF) specification', 'url' => 'https://aomediacodec.github.io/av1-avif/'],
            ['title' => 'Can I use, AVIF image format browser support', 'url' => 'https://caniuse.com/avif'],
        ],
    ],

    'how-to-calculate-a-loan-payment' => [
        'title' => 'How to Calculate a Loan Payment by Hand',
        'description' => 'Calculate a personal, auto or student loan payment by hand with the amortization formula, see a worked example, and learn what a loan calculator adds on top.',
        'h1' => 'How to calculate a loan payment',
        'intro' => 'Every fixed-rate loan - a personal loan, a car loan, a student loan - reduces to the same math: the amount borrowed, the interest rate and the term fix the monthly payment, down to the cent. Lenders are not doing anything mysterious when they quote you a number; they are running a standard amortization formula that you can run yourself. Here is the formula, a worked example, and the details - extra payments, APR versus the interest rate, prepayment penalties - that a quick online quote usually glosses over.',
        'tool' => 'loan-calculator',
        'related' => ['mortgage-calculator', 'percentage-calculator', 'compound-interest-calculator'],
        'published' => '2026-11-07',
        'updated' => '2026-11-07',
        'sections' => [
            [
                'heading' => 'The formula lenders actually use',
                'paragraphs' => [
                    'For a fixed-rate, fixed-term loan, the monthly payment is M = P x r / (1 - (1 + r)^-n), where P is the amount borrowed, r is the monthly interest rate (the annual rate divided by 12), and n is the total number of monthly payments (the term in years multiplied by 12). This single formula covers a personal loan, an auto loan, a student loan or any other loan that charges a fixed rate over a fixed term - only the mortgage case (see the [mortgage calculator](/mortgage-calculator) for that math) adds a down payment and, often, property tax and insurance on top of principal and interest.',
                    'The formula looks intimidating mainly because of the (1 + r)^-n term, which is just compounding running in reverse: it spreads the interest the lender is owed evenly across every payment so that the very last payment, like the first, is the same size.',
                ],
            ],
            [
                'heading' => 'A worked example, step by step',
                'paragraphs' => [
                    'Take a $20,000 loan at 7% annual interest over 5 years (60 months).',
                ],
                'list' => [
                    'Convert the annual rate to a monthly rate: 7% / 12 = 0.5833% = 0.005833 as a decimal.',
                    'Count the payments: 5 years x 12 = 60.',
                    'Plug into the formula: M = 20000 x 0.005833 / (1 - (1.005833)^-60.',
                    '(1.005833)^-60 works out to about 0.7190, so the denominator is 1 - 0.7190 = 0.2810.',
                    'M = 20000 x 0.005833 / 0.2810 = 116.66 / 0.2810 ≈ $396.02 a month.',
                    'Total repaid over the term: $396.02 x 60 ≈ $23,761. Total interest: about $3,761, all on top of the $20,000 borrowed.',
                ],
            ],
            [
                'heading' => 'How the term changes the payment and the total cost',
                'paragraphs' => [
                    'The same $20,000 at 7% costs very different amounts depending only on the term you choose - a shorter term raises the monthly payment but cuts the total interest sharply, because the balance has less time to keep accruing interest.',
                ],
                'table' => [
                    'headers' => ['Loan term', 'Monthly payment', 'Total interest paid'],
                    'rows' => [
                        ['2 years', '$895.45', '$1,490.84'],
                        ['3 years', '$617.54', '$2,231.51'],
                        ['5 years', '$396.02', '$3,761.44'],
                        ['7 years', '$301.85', '$5,355.70'],
                    ],
                ],
            ],
            [
                'heading' => 'What this math does not include',
                'paragraphs' => [
                    'The formula gives you principal and interest only. It leaves out everything a lender might bolt on separately: an origination fee taken off the loan before you receive it, credit insurance, a documentation fee, or - for an auto loan - taxes and dealer add-ons rolled into the amount financed. That gap is exactly why a lender\'s quoted APR (annual percentage rate) is usually a little higher than the plain interest rate you plugged into the formula: APR is built to fold fees into a single comparable yearly cost, so it is the number to compare between lenders, while the interest rate alone is what you use to recompute the payment by hand.',
                    'The math also assumes every payment lands on time and in full. Miss a payment or pay late and most lenders add fees or extra accrued interest that this formula does not model at all.',
                ],
            ],
            [
                'heading' => 'Why extra payments save more than they look like they should',
                'paragraphs' => [
                    'Every payment you make splits between interest already accrued on the current balance and principal, which permanently lowers that balance. An extra dollar paid toward principal stops earning the lender interest for every remaining month of the loan, so extra payments made early - when the balance and the interest share of each payment are largest - save far more than the same extra amount paid near the end. A loan calculator with an extra-payment field shows this directly, by comparing the full schedule with and without it, rather than asking you to re-run the formula month by month.',
                    'Check the loan agreement before sending extra money: some fixed-rate loans, mortgages especially, charge a prepayment penalty for paying off the balance faster than scheduled.',
                ],
            ],
            [
                'heading' => 'Common mistakes doing this by hand',
                'list' => [
                    'Using the annual rate directly instead of dividing by 12 first - this is the single most common error and produces a payment far too high.',
                    'Mixing up the term in years with the term in months inside n, which throws the whole result off by a factor of 12.',
                    'Comparing two loan offers by interest rate alone instead of APR, which hides a lower-rate loan that actually costs more once its fees are counted.',
                    'Forgetting that a longer term lowers the monthly payment but raises the total interest paid - the cheaper-looking monthly number is not the cheaper loan.',
                ],
            ],
            [
                'heading' => 'Checklist before you sign',
                'list' => [
                    'Confirm the rate you are comparing is the APR, not just the headline interest rate, when shopping between lenders.',
                    'Recompute the payment yourself (or with a [loan calculator](/loan-calculator)) using the actual rate and term in the offer, not a rounded version.',
                    'Ask whether a prepayment penalty applies before planning to pay the loan off early.',
                    'Check what the payment does and does not include - some lenders quote principal and interest only, others roll in fees or insurance.',
                    'Run the numbers at more than one term so you can see the full monthly-payment-versus-total-interest trade-off before choosing.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does this formula work for a mortgage too?', 'a' => 'The same amortization formula drives a mortgage payment, but a mortgage usually adds a down payment that reduces the amount financed, plus property tax and insurance that are not part of this principal-and-interest formula. Use the Mortgage Calculator for a home loan and the Loan Calculator for a personal, auto or student loan.'],
            ['q' => 'Why is my lender\'s quoted payment different from what I calculated?', 'a' => 'Lenders often fold in fees, insurance or their own rounding, and your actual approved rate depends on your credit profile. Recomputing with the exact rate and term from your offer, principal and interest only, should match closely; a larger gap usually means fees are being added to the payment.'],
            ['q' => 'Is it always worth making extra payments?', 'a' => 'Usually it lowers total interest, since extra money goes straight to the principal and stops accruing interest for the rest of the loan. Check your loan agreement first, though - some fixed-rate loans charge a prepayment penalty that can offset part of the saving.'],
        ],
        'sources' => [
            ['title' => 'Consumer Financial Protection Bureau, What is amortization?', 'url' => 'https://www.consumerfinance.gov/ask-cfpb/what-is-amortization-and-how-could-it-affect-my-auto-loan-en-755/'],
            ['title' => 'Consumer Financial Protection Bureau, What is the difference between a loan\'s interest rate and its APR?', 'url' => 'https://www.consumerfinance.gov/ask-cfpb/what-is-the-difference-between-a-interest-rate-and-the-annual-percentage-rate-apr-in-a-car-loan-en-733/'],
            ['title' => 'Consumer Financial Protection Bureau, What is a prepayment penalty?', 'url' => 'https://www.consumerfinance.gov/ask-cfpb/what-is-a-prepayment-penalty-en-1957/'],
        ],
    ],

    'how-to-add-text-to-a-pdf' => [
        'title' => 'How to Add Text to a PDF Online for Free',
        'description' => 'Add text to a PDF online for free: click anywhere on the page and type, pick the right font size and colour, and fix the mistakes that trip people up most.',
        'h1' => 'How to add text to a PDF',
        'intro' => 'Sometimes a PDF just needs one more line - a note in the margin, a missing answer on a form, a date stamped on a scanned page - and the file has no editable field anywhere near it. Printing the page, writing on it and scanning it back in works, but it is slow and the result looks worse than the original. Typing straight onto the PDF in your browser is faster, free and keeps the file looking clean. Here is how to do it well and avoid the few things that catch people out.',
        'tool' => 'add-text-to-pdf',
        'related' => ['edit-pdf', 'watermark-pdf', 'sign-pdf'],
        'published' => '2026-11-09',
        'updated' => '2026-11-09',
        'sections' => [
            [
                'heading' => 'When adding text is the right tool',
                'paragraphs' => [
                    'A PDF only has two kinds of blank space you might want to fill: a spot where the file already has an interactive field built in, and a spot that is simply empty page - a margin, a blank line drawn on a scan, a gap left for a signature or date. Interactive fields belong to a different workflow (filling in an existing form); everywhere else, adding a free-floating piece of text on top of the page is the simplest fix, and it works on any PDF, including a scanned one, because it does not depend on the file having any structure at all underneath.',
                    'The one thing it will not do is blend into text that is already printed in the document - matching an existing paragraph\'s exact font takes editing that text in place, not adding new text next to it. If you need to change wording that is already in the PDF, rather than add something new, use [Edit PDF](/edit-pdf)\'s text mode instead; it reads the PDF\'s own font and replaces words in it directly.',
                ],
            ],
            [
                'heading' => 'Step by step: adding text to a PDF',
                'list' => [
                    'Open the [Add Text to PDF](/add-text-to-pdf) tool and choose your file. It opens straight into the editor with the text tool already selected.',
                    'Type the text you want to add, then pick its font size and colour from the toolbar before placing it - the size is locked in once it is on the page, so get it close to right here rather than resizing afterwards.',
                    'Click "Add text to page." The text appears in the middle of the page, ready to drag.',
                    'Drag it to the exact spot you need - a margin, a blank line, next to an existing paragraph - and repeat for each extra line or note.',
                    'Switch pages with the page controls if you need to add text in more than one place in a longer document.',
                    'Click Save PDF and download the finished file.',
                ],
            ],
            [
                'heading' => 'Getting the size and colour right the first time',
                'paragraphs' => [
                    'Because the font size locks in as soon as the text is placed, a little planning upfront saves a redo. Use this as a rough starting point and adjust from there once you see it next to the page\'s own print.',
                ],
                'table' => [
                    'headers' => ['What you are adding', 'Typical size', 'Colour tip'],
                    'rows' => [
                        ['A note in a blank margin', '10-12pt', 'Match the page\'s body text colour to look intentional, or use a bright colour to flag it as a comment'],
                        ['An answer on a form line', 'Same size as the printed labels next to it', 'Black or dark blue, to match typical ink'],
                        ['A date or reference stamp', '9-11pt', 'Grey or black, placed in a corner so it does not crowd other content'],
                        ['A short heading or title added to a blank page', '16-24pt', 'Match the document\'s existing heading colour if it has one'],
                    ],
                ],
            ],
            [
                'heading' => 'Common mistakes',
                'list' => [
                    'Placing the text, then trying to resize it afterwards: the size is fixed once it is on the page, so pick the size first, or remove the text and add it again at the new size.',
                    'Adding each sentence as one long block when it needs to span several lines at specific points: add each line as its own separate piece of text so every line can be dragged into its own position.',
                    'Choosing a light colour on a light page: it looks fine zoomed in on screen but can be nearly invisible once printed or viewed at normal size - check at 100% zoom before saving.',
                    'Forgetting which page the text landed on in a long document: use the page controls to confirm you are on the right page before clicking "Add text to page", since it is easy to add a note to the wrong page in a form with many sections.',
                ],
            ],
            [
                'heading' => 'Is it safe to add text this way?',
                'paragraphs' => [
                    'The whole process runs on your own device: the PDF is opened, edited and saved using JavaScript in your browser, and it is never uploaded to a server. That matters for anything with personal information on it - a filled-in form, a signed letter, a document with your address or ID number - since there is nothing for anyone else to intercept or store.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Can I add text anywhere on the page, even a blank area with nothing printed?', 'a' => 'Yes. Type the text, click "Add text to page" and it appears ready to drag anywhere, including empty margins or blank lines on a form.'],
            ['q' => 'Can I change the font size or colour after I have placed the text?', 'a' => 'The size and colour are set when you place it, so choose them from the toolbar first. If you need a different size afterwards, remove that piece of text and add it again - dragging it to reposition still works at any time.'],
            ['q' => 'Is this different from editing text that is already in the PDF?', 'a' => 'Yes. Adding text places a brand-new, separate piece of text on top of the page. To change wording that already exists in the document, use Edit text mode instead, which keeps the original font and replaces the words in place.'],
        ],
        'sources' => [
            ['title' => 'Library of Congress, Sustainability of Digital Formats: PDF', 'url' => 'https://www.loc.gov/preservation/digital/formats/fdd/fdd000030.shtml'],
            ['title' => 'Mozilla, PDF.js - a PDF renderer and text extraction library', 'url' => 'https://mozilla.github.io/pdf.js/'],
            ['title' => 'pdf-lib, create and modify PDF documents in JavaScript', 'url' => 'https://pdf-lib.js.org/'],
        ],
    ],

    'how-to-convert-jpg-to-pdf' => [
        'title' => 'How to Convert JPG to PDF for Free (One or Many)',
        'description' => 'Convert one or several JPG photos into a PDF for free, right in your browser: pick the right page size, keep the order correct, and avoid an oversized file.',
        'h1' => 'How to convert JPG to PDF',
        'intro' => 'Most places that ask you to "upload a PDF" - a visa application, a job portal, a bank, a school - will not take a plain JPG, even though a photo of a document is exactly what most people have on their phone. Turning one or more JPGs into a proper PDF solves that in under a minute, but a few choices along the way - page size, order, orientation - change how usable the result looks once someone else opens it. Here is how to get it right.',
        'tool' => 'jpg-to-pdf',
        'related' => ['pdf-to-jpg', 'merge-pdf', 'image-compressor'],
        'published' => '2026-11-11',
        'updated' => '2026-11-11',
        'sections' => [
            [
                'heading' => 'Why convert a JPG to PDF at all',
                'paragraphs' => [
                    'A JPG is a single image; a PDF is a document format built to hold one or many pages in a fixed order, which is what most official uploads actually expect. Converting also solves the "I have five photos of one form" problem - instead of attaching five separate image files that someone has to open one at a time and hope are in the right order, you get one file with the pages exactly as you arranged them.',
                ],
                'list' => [
                    'Submitting a scanned ID, passport page or signed form to a bank, visa office or landlord.',
                    'Turning several photographed receipts into one PDF for an expense claim.',
                    'Combining photographed pages of a contract, worksheet or assignment into a single document to email or upload.',
                    'Sending a product photo or certificate somewhere that only accepts PDF attachments.',
                ],
            ],
            [
                'heading' => 'Step by step: JPG to PDF',
                'list' => [
                    'Open the [JPG to PDF](/jpg-to-pdf) tool and add your image or images - drop them in or click to browse. PNG and WebP work too, and you can mix formats in the same batch.',
                    'If you added more than one, check the numbered order and use the up/down arrows to fix it - this is the order the pages will be in, so do it before converting rather than after.',
                    'Choose a page size: A4, Letter, or Fit image (the page matches each photo\'s own shape and size exactly, with no white border).',
                    'Pick Automatic orientation so a landscape photo gets a landscape page, or set it manually.',
                    'Set a margin if you want white space around each image, or None to let the photo reach the edges.',
                    'Click Convert to PDF and download the result.',
                ],
            ],
            [
                'heading' => 'A4/Letter or Fit image - which to pick',
                'paragraphs' => [
                    'This is the one setting that most changes how the final PDF looks, and it depends on what the PDF is for.',
                ],
                'table' => [
                    'headers' => ['You are converting', 'Best page size', 'Why'],
                    'rows' => [
                        ['A scanned form, ID or document photo', 'A4 or Letter', 'Looks and prints like an ordinary document page; every page in the PDF is the same size'],
                        ['A product photo, certificate or image you just need as a PDF file', 'Fit image', 'No white border is added; the page is exactly the photo\'s own shape'],
                        ['Several photos of different shapes (portrait and landscape mixed)', 'Fit image with Automatic orientation', 'Each page matches its own photo instead of forcing every photo onto one fixed shape'],
                        ['Anything that will be printed', 'A4 or Letter', 'Matches standard printer paper, so nothing gets cropped or scaled oddly at print time'],
                    ],
                ],
            ],
            [
                'heading' => 'Keeping the page order right',
                'paragraphs' => [
                    'Each image becomes one page, in the order shown in the list before you convert - there is no way to reorder pages after the PDF is downloaded from this tool, so check the numbered list first. For a multi-page form or contract photographed one page at a time, this is the step people skip and then have to redo: take the photos in order to begin with, and double-check the order again in the tool before clicking Convert, since photo filenames and gallery order do not always match the order you actually took them in.',
                    'If you later need to fix the page order of a PDF you already downloaded, or you have several PDFs to join together, that is a separate step done afterwards: use [Organize PDF](/organize-pdf) to reorder an existing PDF\'s pages, or [Merge PDF](/merge-pdf) to combine finished PDFs into one.',
                ],
            ],
            [
                'heading' => 'Why the file comes out larger than expected',
                'paragraphs' => [
                    'A JPG to PDF conversion does not re-compress your photos - each image is placed into the PDF at its original quality, so the resulting PDF is roughly as large as all the source images added together. A dozen full-resolution phone photos can easily add up to a file too big for an email attachment or a web form\'s upload limit. If that happens, shrink the photos first with an image compressor before converting, or compress the finished PDF afterwards; either keeps the pages looking the same while cutting the file size.',
                ],
            ],
            [
                'heading' => 'Checklist before you submit the PDF',
                'list' => [
                    'Open the downloaded PDF and check every page is present and in the right order, not just the first one.',
                    'Confirm text on scanned pages is actually readable at normal zoom, not blurry from a low-quality photo.',
                    'Check the file size against any upload limit the destination states, and compress first if it is too big.',
                    'If the form says "PDF only", confirm the file actually saved with a .pdf extension and opens as a document, not an image viewer.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Can I combine several JPGs into one PDF, or only convert one at a time?', 'a' => 'Both. Add a single photo for a one-page PDF, or add several and arrange them with the up/down arrows for a multi-page PDF with one image per page.'],
            ['q' => 'Will converting reduce my photo quality?', 'a' => 'No. JPG and PNG images are placed into the PDF at their original quality; WebP images are converted to PNG first, which stays lossless.'],
            ['q' => 'Are my photos uploaded to a server to make the PDF?', 'a' => 'No. The conversion happens in your browser using JavaScript, and the images never leave your device.'],
        ],
        'sources' => [
            ['title' => 'pdf-lib, create and modify PDF documents in JavaScript', 'url' => 'https://pdf-lib.js.org/'],
            ['title' => 'JPEG committee, Overview of JPEG', 'url' => 'https://jpeg.org/jpeg/'],
            ['title' => 'Library of Congress, Sustainability of Digital Formats: JPEG File Interchange Format', 'url' => 'https://www.loc.gov/preservation/digital/formats/fdd/fdd000018.shtml'],
        ],
    ],

    'how-to-check-if-text-was-written-by-ai' => [
        'title' => 'How to Check if Text Was Written by AI',
        'description' => 'How AI content detectors actually work, why none of them are fully reliable, and a practical way to use a detector score without treating it as proof.',
        'h1' => 'How to check if text was written by AI',
        'intro' => 'A teacher reading an essay, an editor reviewing a submission, or anyone scrolling a suspiciously polished review online eventually asks the same question: did a person write this, or did an AI? A number of free tools, including the one on this site, will give you a score. What that score actually measures, and how far you can trust it, matters more than the number itself.',
        'tool' => 'ai-content-detector',
        'related' => ['readability-checker', 'word-counter', 'case-converter'],
        'published' => '2026-11-13',
        'updated' => '2026-11-13',
        'sections' => [
            [
                'heading' => 'What a detector is actually measuring',
                'paragraphs' => [
                    'Most free AI detectors, including this site\'s own, do not run a language model that recognises "AI writing" the way a person might. Instead they measure a handful of statistical writing habits that tend to differ between typical AI output and typical human writing, then combine the results into a score.',
                ],
                'list' => [
                    'Sentence length uniformity - AI text often keeps sentences a similar length; human writing tends to mix short, punchy sentences with longer ones.',
                    'Stock phrases - certain words and transitions ("delve", "moreover", "it is important to note") show up disproportionately often in AI output, likely because they are common in the model\'s training data and easy for it to reach for.',
                    'Contractions - AI text skews slightly more formal, using "do not" where a person is more likely to type "don\'t".',
                    'Vocabulary variety - how many different words appear across the text, since repeating the same handful of terms is a mild AI tell.',
                ],
            ],
            [
                'heading' => 'Checking a text, step by step',
                'list' => [
                    'Get at least 80-100 words of the text (a [Word Counter](/word-counter) can confirm the count) - very short snippets do not give the underlying signals enough to measure.',
                    'Paste it into an AI detector such as the [AI Content Detector](/ai-content-detector) on this site and run the check.',
                    'Read the overall score, but don\'t stop there - open the breakdown of individual signals.',
                    'Look specifically at which signal is highest. A high score driven entirely by "uses no contractions" is weaker evidence than one driven by several signals together.',
                    'If the tool lists the specific phrases it flagged, check whether they are genuinely unusual or just normal, slightly formal writing - "furthermore" alone proves very little.',
                ],
            ],
            [
                'heading' => 'Why no detector is fully reliable',
                'paragraphs' => [
                    'Two things make AI detection an inherently imperfect science, not a solved problem. First, the signals above are correlations, not fingerprints: plenty of people naturally write in even sentences with little slang, and a researcher studying detector bias found that detectors disproportionately flagged text by non-native English speakers as AI-generated, likely because non-native writing can share some of the same statistical patterns - fewer idioms, more formal phrasing - that the detectors associate with AI.',
                    'Second, a widely cited theoretical analysis argues that as AI-generated text gets closer in quality to human writing, no detector can reliably tell them apart without an unacceptably high rate of mistakes either way - and that even a text run through a basic paraphrasing step can shift its statistical fingerprint enough to slip past a detector that caught the original version. Treat every score, from this tool or any other, as a prompt to look closer, not a verdict.',
                ],
            ],
            [
                'heading' => 'Common AI "tells" and how much to trust each one alone',
                'table' => [
                    'headers' => ['Signal', 'What it suggests', 'How much to trust it alone'],
                    'rows' => [
                        ['Very even sentence lengths throughout', 'Possible AI pattern', 'Weak - many careful human writers do this too'],
                        ['Repeated stock phrases ("delve into", "plays a crucial role")', 'Common in AI output', 'Moderate - a few instances are normal; frequent repetition is more telling'],
                        ['No contractions anywhere in casual writing', 'Possible AI or very formal human writing', 'Weak on its own'],
                        ['Vague, generic claims with no specific names, dates or numbers', 'Possible AI or a rushed human draft', 'Moderate - lack of specificity is a real writing-quality signal either way'],
                        ['Several signals pointing the same way at once', 'Stronger overall pattern', 'The strongest evidence a single tool can give - still not proof'],
                    ],
                ],
            ],
            [
                'heading' => 'Using a score responsibly',
                'paragraphs' => [
                    'This matters most where the stakes are real - grading a student, accepting a freelance submission, or deciding whether a review is genuine.',
                ],
                'list' => [
                    'Never rely on a single score as proof someone used AI; treat it as a reason to look at the evidence that actually exists, such as a document\'s edit history or earlier drafts.',
                    'Where possible, ask the person to explain or expand on a specific claim in their own words - something generic AI output often struggles with convincingly.',
                    'Re-check with more text where you can; a longer sample gives every signal more to work with and reduces noise from a short, unlucky paragraph.',
                    'Remember that heavily edited AI text, or AI text produced with a casual-writing prompt, can score low even though AI was genuinely involved.',
                ],
            ],
            [
                'heading' => 'When a detector is genuinely useful',
                'paragraphs' => [
                    'None of this means a detector is worthless - it means it is best used as a writing aid rather than a verdict machine. Running your own draft through one before you publish or submit it is a quick way to spot stock phrases and overly uniform sentences that read as mechanical regardless of who or what produced them, and worth fixing either way. The same signals that make AI text easy to flag - repetition, flatness, generic phrasing - are the same things that make any piece of writing less engaging to read, so tightening them up improves the text on its own merits, not just its score.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Can an AI detector prove a text was written by AI?', 'a' => 'No. Detectors measure statistical writing patterns that correlate with AI output, not a certain fingerprint. A high score is a signal worth investigating, not proof, and research has shown detectors can misjudge both AI and human text.'],
            ['q' => 'Can human writing score as AI-generated?', 'a' => 'Yes. Very formal, evenly paced writing can score high even when a person wrote every word, and research has found this happens more often to non-native English writers specifically.'],
            ['q' => 'Can someone edit AI text to avoid detection?', 'a' => 'Yes. Varying sentence length, adding contractions, or lightly paraphrasing AI output can lower a detector\'s score without changing that AI was involved in producing it, which is exactly why a score should never be treated as final proof.'],
        ],
        'sources' => [
            ['title' => 'Liang et al. (2023), "GPT detectors are biased against non-native English writers", arXiv:2304.02819', 'url' => 'https://arxiv.org/abs/2304.02819'],
            ['title' => 'Sadasivan et al. (2023), "Can AI-Generated Text be Reliably Detected?", arXiv:2303.11156', 'url' => 'https://arxiv.org/abs/2303.11156'],
        ],
    ],

];
