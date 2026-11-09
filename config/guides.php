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
        'updated' => '2026-11-04',
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
                    'Paste your text into the [Word Counter](/word-counter) on this site. It shows words, characters with and without spaces, sentences, paragraphs, reading time and speaking time as you type, and it never uploads your text. Word processors such as Microsoft Word and Google Docs also have a built-in word count, usually under the Tools or Review menu.',
                    'If you need to cut words, look for filler phrases first: "in order to" becomes "to", "due to the fact that" becomes "because". The [Readability Checker](/readability-checker) can then show you which long sentences are worth splitting.',
                    'If your text arrives in capitals, or a heading needs title case, the [Case Converter](/case-converter) fixes it without retyping.',
                ],
            ],
            [
                'heading' => 'How we count words matters too',
                'paragraphs' => [
                    'Page estimates start from a word count, and word counters disagree on the awkward cases. In our test of the [Word Counter](/word-counter), "A state-of-the-art tool." counted as 3 words, "Don\'t stop, it\'s fine." as 4, and "In 2026 we paid 1,250.50 dollars." as 6. Microsoft Word may differ on a few of these, so if a deadline is strict, check your total in the program your teacher or publisher uses.',
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
        'updated' => '2026-11-04',
        'sections' => [
            [
                'heading' => 'How automatic background removal works',
                'paragraphs' => [
                    'Background removers use a type of AI model trained to find the main subject in a picture, a task researchers call salient object detection. The model looks at the whole image and produces a mask: a grey-scale map where white means "keep" and black means "remove". The mask is then used to make the background transparent.',
                    'Older tools sent your photo to a server to run the model. The [Background Remover](/remove-background) on this site runs the model inside your web browser instead, so the picture never leaves your device. The first run downloads the model once; after that it works quickly.',
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
                    'The cut-out downloads as a PNG with a transparent background. To fit it to the exact size a profile or shop listing asks for, use the [Image Resizer](/image-resizer); to change other JPG images to PNG without removing anything, use [JPG to PNG](/jpg-to-png).',
                ],
            ],
            [
                'heading' => 'Getting a cleaner cut-out',
                'paragraphs' => [
                    'The result depends heavily on the photo. Clear contrast between the subject and the background works best, with even light and sharp focus. Fine hair, fur, glass and objects the same colour as the background are the hardest cases, so look along those edges at full size.',
                    'Check the result against both a light and a dark background, since a pale halo can be invisible on white and obvious on black. Then use the [Image Resizer](/image-resizer) to fit the size a shop or profile asks for.',
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
        'updated' => '2026-11-04',
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
                'heading' => 'Never reuse a password',
                'paragraphs' => [
                    'Reuse is the biggest real-world risk. When one website is breached, attackers try the leaked email and password on email, banking and shopping sites. A unique password for every account stops one breach from spreading. NIST also advises services to check new passwords against lists of passwords known to be compromised.',
                ],
            ],
            [
                'heading' => 'Change passwords when there is a reason, not on a schedule',
                'paragraphs' => [
                    'The same guidance says services should not force people to change passwords periodically. Forced changes lead to small, guessable edits such as "Summer2025" becoming "Autumn2025". Change a password when there is evidence it may be compromised, for example after a breach notice, if you shared it, or if you typed it on a device you do not trust.',
                    'Strong passwords protect files too: [Protect PDF](/protect-pdf) locks a PDF with a password so only the people you share it with can open it.',
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
                'heading' => 'How much strength is enough?',
                'paragraphs' => [
                    'Password strength is measured in bits of entropy. Each extra bit doubles the number of guesses needed. Our [Password Generator](/password-generator) shows the figure as you change the settings: at its default of 16 characters using all four character types, it showed 104 bits when we tested it.',
                    'That is far beyond what guessing can reach, as long as the site stores passwords properly. For a password you must type by hand, such as your computer login, a long passphrase of several random words is easier and can be just as strong.',
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
                'heading' => 'Protecting files as well as accounts',
                'paragraphs' => [
                    'The same rules apply to a password on a document. [Protect PDF](/protect-pdf) locks a file so it cannot be opened without the password. Send the password by a different route than the file, such as a phone call or a separate message, or anyone who gets the email gets both.',
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
        'updated' => '2026-11-04',
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
                    'Open [PDF to Word](/pdf-to-word) and drop in your PDF. The file is processed in your browser and not uploaded.',
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
                    'When you have finished editing, [Word to PDF](/word-to-pdf) turns the document back into a PDF that looks the same on every device.',
                    'For a small fix, such as a typo or a date, you may not need Word at all: [Edit PDF](/edit-pdf) changes the existing text directly in the PDF, in its own font.',
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
                    'If you only need to change a date or fix a typo, you may not need Word. Editing the PDF directly keeps the layout exactly as it is, and converting back and forth is where formatting usually goes wrong.',
                    'To pull figures out of a table, [PDF to Excel](/pdf-to-excel) is often a better fit, because it keeps rows and columns as cells. When you finish in Word, [Word to PDF](/word-to-pdf) turns it back into a file that looks the same on every device.',
                    'A PDF made by scanning paper is really a picture of text. Tools without text recognition cannot read it, so you get little or nothing back. The quick test: try to select a sentence in your PDF viewer. If you cannot, it is a scan.',
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
        'updated' => '2026-11-04',
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
                    'Open the [QR Code Generator](/qr-code-generator) and choose what the code should contain: a link, plain text, Wi-Fi details or contact information.',
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
                    'If you need the QR code at an exact pixel size for a slide or a print layout, resize the downloaded image with the [Image Resizer](/image-resizer).',
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
                'heading' => 'What to put in the code',
                'paragraphs' => [
                    'Shorter data makes a simpler pattern that is easier to scan from further away. A short web address beats a long one with tracking parameters. Our test code for a web address came out as a 512 x 512 PNG of 8.6 KB; for print, use the SVG download, which stays sharp at any size.',
                    'If the address might change, point the code at a page you control and can redirect, because a static code cannot be edited after printing. Resize the PNG for a slide or web page with the [Image Resizer](/image-resizer) rather than stretching it in a design tool, which can blur the edges.',
                ],
            ],
            [
                'heading' => 'Be careful what you scan',
                'paragraphs' => [
                    'QR codes hide their destination, which scammers exploit by sticking fake codes over real ones on parking meters and restaurant tables. Check the address your phone shows before you open it, and never enter a password or card number on a page you reached that way unless you are sure of it.',
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
        'updated' => '2026-11-04',
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
                    'The [Percentage Calculator](/percentage-calculator) on this site has a box for each of these three questions and shows the formula it used, so you can check the working. For splitting a bill, the [Tip Calculator](/tip-calculator) does the percentage and the division in one go.',
                ],
            ],
            [
                'heading' => 'Worked examples from everyday life',
                'paragraphs' => [
                    'A jacket costs $80 and is 25% off. The discount is 80 x 0.25 = $20, so you pay $60. A quicker way is to multiply by what is left: 80 x 0.75 = 60.',
                    'A restaurant bill is $64 and you leave 18%: 64 x 0.18 = $11.52, for a total of $75.52. The [Tip Calculator](/tip-calculator) does this and splits it between people.',
                    'Your pay rises from $3,200 to $3,400 a month. The change is 200, and 200 / 3,200 x 100 = 6.25%. Always divide by the old value, not the new one.',
                ],
            ],
            [
                'heading' => 'Percent versus percentage points',
                'paragraphs' => [
                    'If a loan rate goes from 4% to 5%, it rose by one percentage point, but by 25% in relative terms, because 1 is a quarter of 4. News stories and adverts often use whichever sounds bigger, so check which one you are reading.',
                    'This matters when you compare offers. A rate quoted in the [Loan Calculator](/loan-calculator) is a percentage of the balance, and a small change in points can mean a large change in what you pay over the years.',
                ],
            ],
            [
                'heading' => 'Why percentages do not add up the way you expect',
                'paragraphs' => [
                    'A 50% rise followed by a 50% fall does not bring you back to where you began. Start at 100: up 50% is 150, and down 50% is 75. The second percentage is taken from a bigger number, so the fall is larger than the rise.',
                    'It is the same with stacked discounts. 20% off and then another 10% off is not 30% off. Multiply instead: 0.8 x 0.9 = 0.72, which is 28% off.',
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
        'updated' => '2026-11-04',
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
                'heading' => 'The formula',
                'paragraphs' => [
                    'For a single deposit with no further contributions, the balance is A = P x (1 + r / n) ^ (n x t). P is the starting amount, r is the yearly rate as a decimal, n is how many times a year interest is added, and t is the number of years.',
                    'Using our example with no monthly contributions: $10,000 x (1 + 0.06 / 12) ^ 240 is about $33,102. Compare that with the $125,510.22 above and you can see that steady contributions did more for the total than the starting amount did.',
                ],
            ],
            [
                'heading' => 'The Rule of 72',
                'paragraphs' => [
                    'To estimate how long money takes to double, divide 72 by the yearly rate. At 6% that gives about 12 years. It is an approximation for mental arithmetic and works best for rates between about 4% and 12%. To work out the rates themselves, the [Percentage Calculator](/percentage-calculator) shows each step.',
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
                'heading' => 'The limit of any calculator',
                'paragraphs' => [
                    'A calculator assumes one fixed rate for the whole period. Savings rates change, and investment returns vary from year to year, including years that lose money. Treat the result as a projection for comparing options, not a forecast. It also ignores tax and inflation unless you allow for them yourself. This guide is general information, not financial advice.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'What is the difference between simple and compound interest?', 'a' => 'Simple interest is paid only on the original amount. Compound interest is also paid on the interest already earned, so the balance grows faster over time.'],
            ['q' => 'How much does $10,000 grow to in 20 years at 6%?', 'a' => 'With monthly compounding and no further deposits, about $33,102. With $200 added every month, our calculator gave $125,510.22.'],
            ['q' => 'Does compounding more often make a big difference?', 'a' => 'Only a small one. The rate and the number of years matter far more.'],
        ],
        'sources' => [
            ['title' => 'U.S. Securities and Exchange Commission, Compound interest calculator', 'url' => 'https://www.investor.gov/financial-tools-calculators/calculators/compound-interest-calculator'],
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
        'updated' => '2026-11-04',
        'sections' => [
            [
                'heading' => 'The six errors we tested',
                'paragraphs' => [
                    'Each message below is what the [JSON Formatter](/json-formatter) reported in Chrome. The technical part comes from the browser, so its wording can differ slightly in other browsers; the tool adds the plain-English hint in some cases.',
                ],
                'table' => [
                    'headers' => ['Mistake', 'Example', 'Message', 'Fix'],
                    'rows' => [
                        ['Trailing comma in an object', '{"a": 1,}', 'Expected double-quoted property name... Remove the trailing comma before this bracket.', 'Delete the last comma'],
                        ['Trailing comma in an array', '[1, 2, 3,]', 'Unexpected token \']\'', 'Delete the last comma'],
                        ['Single quotes', '{\'name\': \'Ann\'}', 'Expected property name or \'}\'... must use double quotes', 'Use " for keys and strings'],
                        ['Unquoted key', '{name: "Ann"}', 'Expected property name or \'}\'... must be wrapped in double quotes', 'Write "name"'],
                        ['Missing comma', '{"a": 1 "b": 2}', 'Expected \',\' or \'}\' after property value', 'Add a comma between items'],
                        ['Comment', '{"a": 1 // note}', 'Expected \',\' or \'}\'... Comments are not allowed in JSON.', 'Remove the comment'],
                    ],
                ],
            ],
            [
                'heading' => 'Reading the position',
                'paragraphs' => [
                    'A message like "position 8 (line 1, column 9)" tells you where the parser stopped, counted from the start. With a missing comma, as in {"a": 1 "b": 2}, position 8 is the start of "b", because that is where a comma should have appeared. So look just before the position as well as at it.',
                    'One mismatched bracket can do the same thing. In {"tags": ["a", "b"} the parser complains at the closing brace, position 18, because it expected the array to end first. Formatting a long document first makes this kind of mistake much easier to see.',
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
                ],
            ],
            [
                'heading' => 'JSON is not JavaScript',
                'paragraphs' => [
                    'Most of these errors come from the same confusion. JavaScript objects allow single quotes, unquoted keys, trailing commas and comments. JSON allows none of them. The rules are short and fixed by the standard, so a strict error is the parser doing its job.',
                    'If a value holds binary data or an encoded string, a tool like the [Base64 Encoder](/base64-encoder-decoder) can help you see what is inside. Your JSON stays in your browser in the formatter: our network log showed 0 bytes sent during these tests, so it is safe for config files, though you should still be careful where you paste live secrets.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Why does JSON not allow trailing commas?', 'a' => 'The JSON standard simply does not include them. A comma must be followed by another value.'],
            ['q' => 'Can JSON have comments?', 'a' => 'No. Standard JSON has no comment syntax. Some tools accept variants such as JSON5, but a strict parser will reject them.'],
            ['q' => 'Why is the error position after my mistake?', 'a' => 'The parser reports where it could no longer continue, which is often the character right after the real problem.'],
        ],
        'sources' => [
            ['title' => 'RFC 8259, The JavaScript Object Notation (JSON) Data Interchange Format', 'url' => 'https://www.rfc-editor.org/rfc/rfc8259'],
            ['title' => 'MDN Web Docs, SyntaxError: JSON.parse: bad parsing', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Errors/JSON_bad_parse'],
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
        'updated' => '2026-11-04',
        'sections' => [
            [
                'heading' => 'The metrics compared',
                'paragraphs' => [
                    'All of these estimate how strong a site is from links pointing to it. They are not interchangeable: a DR of 40 and a DA of 40 are different measurements.',
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
            ],
            [
                'heading' => 'What these scores are not',
                'paragraphs' => [
                    'They are not Google rankings or a Google metric. Moz says plainly that Domain Authority is not a ranking factor. A page with a low score can outrank a stronger site if it answers the search better, especially for specific long-tail searches.',
                    'They also do not measure quality directly. Scores can be pushed up with low-quality or paid links, which is exactly what Google\'s spam policies target, so treat a sudden high score on an unknown site with some suspicion.',
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
        ],
        'sources' => [
            ['title' => 'OpenPageRank: how the score is calculated', 'url' => 'https://openpagerank.keywordseverywhere.com/methodology'],
            ['title' => 'Moz, What is Domain Authority?', 'url' => 'https://moz.com/learn/seo/domain-authority'],
            ['title' => 'Google Search Central, Spam policies: link spam', 'url' => 'https://developers.google.com/search/docs/essentials/spam-policies'],
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
        'updated' => '2026-11-04',
        'sections' => [
            [
                'heading' => 'What we did',
                'paragraphs' => [
                    'On the live [Coin Flip](/coin-flip) page we set 100 coins per flip and flipped 10 times, for 1,000 coins in total. The tool counted 510 heads and 490 tails, or 51% and 49%.',
                ],
                'table' => [
                    'headers' => ['Result', 'Count', 'Share'],
                    'rows' => [['Heads', '510', '51%'], ['Tails', '490', '49%'], ['Total', '1,000', '100%']],
                ],
            ],
            [
                'heading' => 'Is 510 out of 1,000 fair?',
                'paragraphs' => [
                    'Yes. With 1,000 fair flips, the typical distance from 500 is about 16 flips (the standard deviation, the square root of 1,000 x 0.5 x 0.5). Our result is 10 away, well inside normal variation. An exact 500 would not be any more impressive.',
                    'One run cannot prove a coin is fair; it can only fail to show a problem. A much larger gap, say 600 heads in 1,000, would be a real warning sign, since that is more than six standard deviations from the middle.',
                ],
            ],
            [
                'heading' => 'Streaks are normal',
                'paragraphs' => [
                    'People expect random results to alternate, so a run of five heads looks suspicious. It is not. In a long series of flips, runs like that are expected. Each flip is independent: after five heads the next is still 50/50. Believing tails is now "due" is the gambler\'s fallacy.',
                ],
            ],
            [
                'heading' => 'Where the randomness comes from',
                'paragraphs' => [
                    'Our random tools use your browser\'s crypto.getRandomValues, a cryptographically secure generator, rather than the simpler Math.random. The code also avoids a subtle bias called modulo bias by discarding values that would skew the result. The flip happens on your device, so the site does not choose the outcome.',
                    'The same source drives the [Dice Roller](/dice-roller) and [Spin the Wheel](/spin-the-wheel), so all of them have the same basis for fairness.',
                ],
            ],
            [
                'heading' => 'How to judge any random tool',
                'list' => [
                    'Run a large sample and compare it with what chance predicts, not with a perfect split.',
                    'Look for a statement of how results are generated. Secure browser randomness is a good sign.',
                    'For anything with money or legal weight, use a process people can witness or audit. A website is fine for deciding who goes first, not for a prize draw with legal rules.',
                ],
                'paragraphs' => [
                    'Virtual coins also skip a detail of real ones: studies of human coin tossing have found a slight tendency to land on the side that started up. A software flip has no starting side.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Is a virtual coin flip truly random?', 'a' => 'It is random enough for everyday decisions. Ours uses the browser\'s cryptographically secure generator, which is designed to be unpredictable.'],
            ['q' => 'What are the odds of 5 heads in a row?', 'a' => 'One in 32, or about 3%, for any given five flips: 0.5 multiplied by itself five times.'],
            ['q' => 'Does the previous flip affect the next one?', 'a' => 'No. Each flip is independent and stays 50/50.'],
        ],
        'sources' => [
            ['title' => 'MDN Web Docs, Crypto: getRandomValues()', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/API/Crypto/getRandomValues'],
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
        'updated' => '2026-11-04',
        'sections' => [
            [
                'heading' => 'How to run the check',
                'list' => [
                    'Open the [Broken Link Checker](/broken-link-checker) and enter the address of one page.',
                    'Click Check links. It tests every link and image on that page, up to 300.',
                    'Read the Problems tab first, then download the CSV if you want a list to work through.',
                    'Repeat for your other important pages.',
                ],
                'paragraphs' => [
                    'When we ran it on our own About page, it checked 82 links: 82 OK, 0 broken, 0 redirects and 0 blocked. This tool has to use our server to fetch the links, because a browser page is not allowed to test other sites directly. It sends the address you enter and stores nothing.',
                ],
            ],
            [
                'heading' => 'What the results mean',
                'table' => [
                    'headers' => ['Result', 'Meaning', 'What to do'],
                    'rows' => [
                        ['OK', 'The link works', 'Nothing'],
                        ['Broken', 'A missing page, server error or dead domain', 'Update the link or remove it'],
                        ['Redirect', 'It still works, through another address', 'Point it at the final address when convenient'],
                        ['Blocked or no answer', 'The site refused an automated check, often with 401, 403 or 429', 'Open it in a browser before changing anything'],
                    ],
                ],
                'paragraphs' => [
                    'Blocked is not the same as broken. Plenty of large sites turn away automated requests while working perfectly for people, so check those by hand.',
                ],
            ],
            [
                'heading' => 'Which pages to check first',
                'paragraphs' => [
                    'The tool checks one page at a time, so start where a broken link costs the most: your home page, main menu and footer (which appear everywhere), your most visited articles, and any page that earns money or leads.',
                    'Old articles collect the most dead links, because they often point to sources that have since moved. Check them once or twice a year.',
                ],
            ],
            [
                'heading' => 'How to fix what you find',
                'list' => [
                    'If the page moved, update the link to its new address.',
                    'If it is gone, find a replacement source or remove the link and adjust the sentence.',
                    'If the broken page is on your own site, add a redirect to the closest live page so existing links keep working.',
                    'Never delete a page that other sites link to without a redirect: that throws those links away.',
                ],
                'paragraphs' => [
                    'Broken outgoing links are mainly a problem for visitors. Google has said broken links are a normal part of the web, so do not panic over a few. Treat this as upkeep. To see how strong the sites linking to you are, try the [Bulk Domain Authority Checker](/domain-authority-checker).',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does a broken link hurt SEO?', 'a' => 'A few rarely matter on their own. The clearer costs are a poor visitor experience and, for broken pages on your own site, losing the value of links pointing to them.'],
            ['q' => 'Can this check my whole website at once?', 'a' => 'No. It checks one page at a time, up to 300 links. Enter your other pages one by one.'],
            ['q' => 'Why is a working link marked Blocked?', 'a' => 'Some sites refuse automated requests or require a login. Open the link in a normal browser to confirm.'],
        ],
        'sources' => [
            ['title' => 'MDN Web Docs, HTTP response status codes', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Status'],
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
        'updated' => '2026-11-04',
        'sections' => [
            [
                'heading' => 'How to check',
                'paragraphs' => [
                    'Enter the domain in the [Domain Age Checker](/domain-age-checker), or up to 20 domains, one per line. Full addresses are fine; they are reduced to the domain. We looked up wikipedia.org on 4 November 2026: it was created on January 13, 2001, which made it 25 years, 9 months and 22 days old that day.',
                    'The tool looks the domain up in public registration records through our server. It sends only the domain name and stores nothing.',
                ],
            ],
            [
                'heading' => 'What the record shows',
                'table' => [
                    'headers' => ['Field', 'What it tells you'],
                    'rows' => [
                        ['Created', 'When this registration began'],
                        ['Age', 'Time since that date'],
                        ['Expires', 'When it must be renewed'],
                        ['Last updated', 'When the record last changed, such as a renewal'],
                        ['Registrar', 'The company it was registered through'],
                        ['Status and nameservers', 'Its current state and where its DNS is hosted'],
                    ],
                ],
                'paragraphs' => [
                    'The owner\'s personal details are usually hidden for privacy, so this normally will not tell you who runs a site.',
                ],
            ],
            [
                'heading' => 'When it is useful',
                'list' => [
                    'Checking a shop or a message before you pay: a very new domain is a reason to look harder, though not proof of anything.',
                    'Buying a domain: the history shows how long it has been registered.',
                    'Checking your own renewals: note the expiry date so a domain never lapses by accident.',
                    'Researching competitors or link partners, alongside their [authority score](/domain-authority-checker).',
                ],
            ],
            [
                'heading' => 'What it cannot tell you',
                'paragraphs' => [
                    'Age is not a measure of trust on its own. A new domain can belong to an honest new business, and an old one can be bought by anyone. The created date also resets if a domain lapses and is registered again, so it may not reach back to its earliest use.',
                    'Domain age is also not a ranking boost. Google\'s John Mueller has said publicly that it does not help. Older sites often rank well because they have had longer to earn links and build content, not because of the date itself. Do not pay extra for an "aged" domain on that promise alone.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does domain age affect SEO?', 'a' => 'Not directly. Google has said age itself does not help. Older sites simply have had more time to earn links and publish.'],
            ['q' => 'Can I see who owns a domain?', 'a' => 'Usually not. Most registrations hide personal details for privacy, though the registrar is shown.'],
            ['q' => 'Is a new domain a scam?', 'a' => 'Not necessarily. It is one signal to weigh along with reviews, contact details and payment protection.'],
        ],
        'sources' => [
            ['title' => 'ICANN, Registration Data Access Protocol (RDAP)', 'url' => 'https://www.icann.org/rdap'],
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
        'updated' => '2026-11-04',
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
                ],
                'table' => [
                    'headers' => ['Detail', 'Where it comes from'],
                    'rows' => [
                        ['Public IP and IPv4 or IPv6', 'Your connection, seen by the server'],
                        ['Browser and operating system', 'The user agent your browser sends'],
                        ['Screen resolution', 'Readable by the page'],
                        ['Language and time zone', 'Your browser settings'],
                        ['Whether cookies are enabled', 'Your browser settings'],
                    ],
                ],
            ],
            [
                'heading' => 'How our tool works',
                'paragraphs' => [
                    'To show your public IP, the page has to ask our server which address your request came from, since a page cannot see it alone. The IP is sent back to you and we do not store it in that lookup. The other details are read by the page in your own browser. The site also uses analytics and advertising, as our privacy policy explains.',
                ],
            ],
            [
                'heading' => 'Dynamic, shared and VPN addresses',
                'list' => [
                    'Most home addresses are dynamic, so yours may change from time to time.',
                    'Phone networks and many providers share one public IP among lots of customers.',
                    'A VPN hides your IP from the sites you visit by showing the VPN\'s address instead, and hides your traffic from your provider. The VPN company can then see that traffic, so choose carefully.',
                ],
                'paragraphs' => [
                    'A VPN does not make you anonymous. Logins, cookies and browser details can still identify you, as can a site you are signed in to.',
                ],
            ],
            [
                'heading' => 'What actually protects you',
                'paragraphs' => [
                    'Your IP address is rarely the weak point. Most accounts are lost through reused or stolen passwords and phishing. Using a unique password for each account, from a [Password Generator](/password-generator) and a password manager, plus two-step sign-in, does more for most people than hiding an IP. Be careful about scanning unknown QR codes or clicking links in unexpected messages as well.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Can someone find my home address from my IP?', 'a' => 'Not from the IP alone. It usually shows an approximate area and your provider. Linking it to a customer normally needs the provider and a legal process.'],
            ['q' => 'Why does my IP show the wrong city?', 'a' => 'Location databases are estimates, and many point to your provider\'s equipment rather than your building.'],
            ['q' => 'Does my IP change?', 'a' => 'Often, yes. Most home connections have dynamic addresses, and using mobile data or a VPN gives you a different one.'],
        ],
        'sources' => [
            ['title' => 'MDN Web Docs, User-Agent header', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/User-Agent'],
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
        'updated' => '2026-11-04',
        'sections' => [
            [
                'heading' => 'How to reorder pages',
                'list' => [
                    'Open [Organize PDF](/organize-pdf) and choose your file. Each page appears as a thumbnail.',
                    'Drag a page to its new position, or use the left and right arrow buttons under it.',
                    'Click Save new order and download the file.',
                    'Open the result and check the order before you send it.',
                ],
                'paragraphs' => [
                    'The arrow buttons also work from the keyboard, which helps with long documents where dragging is awkward. We opened a 3-page test file this way, and it stayed on the device: 0 bytes were uploaded.',
                ],
            ],
            [
                'heading' => 'How to delete pages',
                'list' => [
                    'Open [Delete PDF Pages](/delete-pdf-pages) and choose your file.',
                    'Click the thumbnails of the pages to remove, or switch to Page ranges and type them, such as 2, 4-6.',
                    'Click Delete pages and download the new file.',
                ],
                'paragraphs' => [
                    'Your original file is not changed. You always get a new copy, so a wrong selection costs nothing.',
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
                        ['Turn a page into an image', 'PDF to PNG or PDF to JPG'],
                        ['Combine several files', 'Merge PDF'],
                    ],
                ],
                'paragraphs' => [
                    'If you only need 3 pages out of 200, [Split PDF](/split-pdf) is quicker than deleting 197. If you need a single page as a picture, such as for a slide, use [PDF to PNG](/pdf-to-png).',
                ],
            ],
            [
                'heading' => 'Doing both, and a warning',
                'paragraphs' => [
                    'If you need to do both jobs, delete first and reorder second, so you are not moving pages you are about to remove. Check the page numbers printed on the pages too: they are part of the page content, so moving a page does not renumber them.',
                    'Deleting a page removes it from the new file, but it does not remove sensitive text from the pages you keep. To hide something on a page you are keeping, use [Redact PDF](/redact-pdf), which removes the text instead of covering it.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does reordering change the quality of the pages?', 'a' => 'No. Pages are copied as they are; only their position changes.'],
            ['q' => 'Can I undo a change?', 'a' => 'Your original file is untouched, so open it again and start over. The tools always create a new copy.'],
            ['q' => 'Are my files uploaded?', 'a' => 'No. Both tools work in your browser. In our test the network log showed 0 bytes uploaded.'],
        ],
        'sources' => [
            ['title' => 'pdf-lib, create and modify PDF documents in JavaScript', 'url' => 'https://pdf-lib.js.org/'],
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
        'updated' => '2026-11-04',
        'sections' => [
            [
                'heading' => 'How to remove it',
                'list' => [
                    'Open [Unlock PDF](/unlock-pdf) and choose the locked file.',
                    'Type the password once.',
                    'Download the new copy, which opens without a password.',
                    'Keep or delete the locked original as you prefer. It is not changed.',
                ],
                'paragraphs' => [
                    'The work happens in your browser using a WebAssembly build of the open-source QPDF library, so neither the file nor the password leaves your device. If the password is wrong you see an "Incorrect password" message and can try again. If you give it a PDF with no password, it tells you there is nothing to unlock: we got "plain.pdf does not have a password" when we tested that.',
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
                'heading' => 'If you have lost the password',
                'list' => [
                    'Ask whoever sent the file. Banks and employers can usually resend it or tell you the format.',
                    'Check the original email: statements often explain the format, such as a date of birth plus part of an account number.',
                    'Look in your password manager, if you set the password yourself.',
                ],
            ],
            [
                'heading' => 'Should you remove it at all?',
                'paragraphs' => [
                    'A password protects the file wherever it goes. Remove it for a copy you are keeping safely on your own device, or when you need to [compress](/compress-pdf) or merge the file. Think twice before removing it from anything you will email, because email is not a safe place for an unprotected payslip or ID.',
                    'To lock a file again, use [Protect PDF](/protect-pdf) with a strong password from the [Password Generator](/password-generator). Send the password by a different route than the file.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Can this tool recover a forgotten password?', 'a' => 'No. It only removes a password you type in yourself.'],
            ['q' => 'Does removing the password change the PDF?', 'a' => 'No. Only the protection is removed. Pages, text and images stay as they were.'],
            ['q' => 'Is it safe to type my password here?', 'a' => 'The password is used in your browser and is not sent to any server. In our testing, the tool made no upload.'],
        ],
        'sources' => [
            ['title' => 'QPDF documentation', 'url' => 'https://qpdf.readthedocs.io/'],
        ],
    ],

    'how-to-convert-excel-to-pdf' => [
        'title' => 'How to Convert Excel to PDF Without Losing Your Data',
        'description' => 'Turn a spreadsheet into a PDF in your browser: what comes through, what does not, and how to prepare a sheet first so wide columns are not cut off.',
        'h1' => 'How to convert Excel to PDF',
        'intro' => 'A PDF is the safe way to send a spreadsheet to someone who only needs to read it: it looks the same everywhere, and nobody can change a formula by accident. Our converter works in your browser and turns each sheet into a clean table. It deliberately keeps the data rather than the design, so it is worth knowing what comes through before you rely on it.',
        'tool' => 'excel-to-pdf',
        'related' => ['html-to-pdf', 'pdf-to-excel', 'word-to-pdf'],
        'published' => '2026-11-04',
        'updated' => '2026-11-04',
        'sections' => [
            [
                'heading' => 'How to convert',
                'list' => [
                    'Open [Excel to PDF](/excel-to-pdf) and choose one .xlsx, .xls or .csv file, up to 50 MB.',
                    'Each sheet becomes a table across one or more pages, with the header row repeated on each page.',
                    'Download the PDF and read through it before sending.',
                ],
            ],
            [
                'heading' => 'What comes through and what does not',
                'table' => [
                    'headers' => ['Kept', 'Not kept'],
                    'rows' => [
                        ['Cell values, including the results of formulas', 'The formulas themselves'],
                        ['Every sheet in the file', 'Charts'],
                        ['A repeated header row', 'Cell colours'],
                        ['Table layout', 'Merged cells'],
                    ],
                ],
                'paragraphs' => [
                    'Text too wide for its column is shortened with "…". That is the main thing to check, because a cut-off value in a report can look like a complete one.',
                ],
            ],
            [
                'heading' => 'Prepare your sheet first',
                'list' => [
                    'Delete working sheets and scratch columns you do not want to share.',
                    'Shorten long text or split it across columns, so nothing is cut off.',
                    'Unmerge cells and give each column a clear header.',
                    'Save or convert the charts separately if the reader needs them.',
                ],
                'paragraphs' => [
                    'If the exact look matters, such as a designed invoice with colours and a logo, Excel\'s own Save as PDF will keep it better. Our tool is for getting the data into a readable PDF quickly, without installing anything and without uploading a file that may hold salaries or customer details.',
                ],
            ],
            [
                'heading' => 'Related conversions',
                'paragraphs' => [
                    'Going the other way, [PDF to Excel](/pdf-to-excel) pulls tables back out of a PDF. For a document rather than a table, use [Word to PDF](/word-to-pdf). For a web page or plain text, [HTML to PDF](/html-to-pdf) handles headings, paragraphs, lists and images; its own tables and custom styling are not kept, so use this tool when your content is really a table.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Are formulas kept in the PDF?', 'a' => 'No. A PDF shows the values, not the formulas. Keep your original spreadsheet to edit them.'],
            ['q' => 'Why are some cells cut off?', 'a' => 'Text too wide for its column is shortened with "…". Shorten the text or split it across columns, then convert again.'],
            ['q' => 'Can I convert a CSV file?', 'a' => 'Yes. The tool accepts .xlsx, .xls and .csv files up to 50 MB.'],
        ],
        'sources' => [
            ['title' => 'SheetJS documentation', 'url' => 'https://docs.sheetjs.com/'],
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
        'updated' => '2026-11-04',
        'sections' => [
            [
                'heading' => 'What we measured',
                'paragraphs' => [
                    'We ran a photo-like 800 x 533 JPG, generated for the test, through [JPG to PNG](/jpg-to-png) on 4 November 2026. It went from 88 KB to 571 KB, about 6.5 times the size. The exact ratio will vary with your image, but photos always grow a lot, because PNG cannot use the tricks that make JPG small.',
                ],
                'table' => [
                    'headers' => ['Format', 'Size', 'Change'],
                    'rows' => [['JPG (original)', '88 KB', '-'], ['PNG (converted)', '571 KB', 'About 6.5x larger']],
                ],
            ],
            [
                'heading' => 'Why PNG cannot restore quality',
                'paragraphs' => [
                    'JPG is lossy: it discards detail to save space, and that happens when the JPG is saved. PNG is lossless: it stores exactly what it receives. So converting faithfully preserves the JPG\'s existing blur and artifacts, in a bigger file. The only way to get better quality is to go back to the original photo.',
                ],
            ],
            [
                'heading' => 'When converting does make sense',
                'list' => [
                    'You will edit the image and save it several times. PNG stops further loss from building up.',
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
                ],
                'paragraphs' => [
                    'If the real problem is file size, the [Image Compressor](/image-compressor) is what you want. Our [AVIF, WebP and JPG file-size test](/guides/avif-vs-webp-vs-jpg-file-size-test) shows how the modern formats compare.',
                ],
            ],
            [
                'heading' => 'Other routes to PNG',
                'paragraphs' => [
                    'Starting from another format? [AVIF to PNG](/avif-to-png) works the same way. To get a PDF page as a crisp image, [PDF to PNG](/pdf-to-png) suits pages with sharp text and diagrams, because PNG keeps edges clean where JPG tends to smudge them. In each case the file stays on your device: our network log showed 0 bytes uploaded during the conversion.',
                ],
            ],
        ],
        'faqs' => [
            ['q' => 'Does converting JPG to PNG improve quality?', 'a' => 'No. It keeps the image exactly as it is now, in a larger file. Detail lost when the JPG was saved does not come back.'],
            ['q' => 'Why did my PNG get so much bigger?', 'a' => 'PNG is lossless, and photos contain too much fine variation for it to compress well. In our test the file grew about 6.5 times.'],
            ['q' => 'Does a converted PNG have a transparent background?', 'a' => 'No. JPG has no transparency, so the background stays. Use a background remover for that.'],
        ],
        'sources' => [
            ['title' => 'MDN Web Docs, Image file type and format guide', 'url' => 'https://developer.mozilla.org/en-US/docs/Web/Media/Guides/Formats/Image_types'],
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
                    'The one thing it will not do is blend into text that is already printed in the document - matching an existing paragraph\'s exact font takes editing that text in place, not adding new text next to it. If you need to change wording that is already in the PDF, rather than add something new, use Edit text mode instead; it reads the PDF\'s own font and replaces words in it directly.',
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

];
