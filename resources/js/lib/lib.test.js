import { describe, expect, it } from 'vitest';
import { convertCase, keywordDensity, textStats, formatDuration } from './text.js';
import { entropyBits, generatePassword, CHARSETS } from './password.js';
import { calculateAge, parseDateInput } from './date.js';
import { applyPercent, parseNumber, percentChange, percentOf, wholeFromPart, whatPercent, formatNumber } from './percent.js';
import { formatJson, parseJson } from './json.js';
import { decodeText, encodeText, normalizeBase64 } from './base64.js';
import { parseRanges, rangesToIndexes, indexesExcluding } from './pdfRanges.js';
import { computeImagePageLayout, MM_TO_PT, PDF_PAGE_SIZES, addRotation, buildRotatedPdf } from './pdf.js';
import { dpiToScale } from './pdfRender.js';
import { fileExtension, mimeType, pageFilename } from './pdfToImage.js';
import { isRecompressibleImage, isRecompressibleImageInfo, listRecompressibleImages, scaledDimensions } from './pdfCompress.js';
import { PDFDocument, PDFRawStream } from 'pdf-lib';
import { buildQrPayload, contrastRatio, escapeWifi } from './qr.js';
import { formatBytes, uniqueNamer, baseName, safeFilename } from './util.js';
import { decodeEntities, parseHtmlToBlocks, tokenizeRuns, wrapWords, layoutBlocksToPages } from './htmlToPdf.js';
import { groupItemsIntoLines, detectBodySize, headingLevelFor, buildDocumentBlocks } from './pdfToWord.js';
import { groupItemsIntoRows, detectColumnBoundaries, rowsToTable } from './pdfToExcel.js';
import { cellText, computeColumnWidths, truncateToWidth, paginateRows, layoutSheetToPages } from './excelToPdf.js';

describe('word counter', () => {
    it('counts an empty string as zero', () => {
        expect(textStats('')).toMatchObject({ words: 0, characters: 0, sentences: 0, paragraphs: 0, lines: 0 });
        expect(textStats('   \n  ')).toMatchObject({ words: 0, sentences: 0, paragraphs: 0 });
    });

    it('counts words, sentences and paragraphs', () => {
        const text = 'Hello world. This is a test!\n\nSecond paragraph here?';
        const s = textStats(text);
        expect(s.words).toBe(9);
        expect(s.sentences).toBe(3);
        expect(s.paragraphs).toBe(2);
        expect(s.characters).toBe(text.length);
        expect(s.charactersNoSpaces).toBe(text.replace(/\s/g, '').length);
    });

    it('ignores standalone punctuation and counts contractions and hyphens as one word', () => {
        expect(textStats("It's a well-known fact - really , truly").words).toBe(6);
    });

    it('does not split decimals into sentences', () => {
        expect(textStats('Version 1.5 is out. Great').sentences).toBe(2);
    });

    it('counts emoji as one character and non-English words', () => {
        expect(textStats('👍🏽').characters).toBe(1);
        expect(textStats('café naïve über').words).toBe(3);
    });

    it('calculates reading time and formats durations', () => {
        expect(textStats(Array(238).fill('word').join(' ')).readingSeconds).toBe(60);
        expect(formatDuration(0)).toBe('0 sec');
        expect(formatDuration(59)).toBe('59 sec');
        expect(formatDuration(125)).toBe('2 min 5 sec');
        expect(formatDuration(3660)).toBe('1 hr 1 min');
    });

    it('computes keyword density without stop words', () => {
        const k = keywordDensity('The SEO tool. SEO tools help seo work, the end.');
        expect(k[0]).toMatchObject({ word: 'seo', count: 3 });
        expect(k.find((x) => x.word === 'the')).toBeUndefined();
    });
});

describe('case converter', () => {
    const t = 'the quick brown fox of the woods';
    it('upper / lower', () => {
        expect(convertCase('Hello World', 'upper')).toBe('HELLO WORLD');
        expect(convertCase('Hello World', 'lower')).toBe('hello world');
    });
    it('title case keeps small words lowercase', () => {
        expect(convertCase(t, 'title')).toBe('The Quick Brown Fox of the Woods');
        expect(convertCase('a tale of two cities', 'title')).toBe('A Tale of Two Cities');
        expect(convertCase('what is it for', 'title')).toBe('What Is It For');
        expect(convertCase('a well-known story', 'title')).toBe('A Well-Known Story');
    });
    it('sentence case', () => {
        expect(convertCase('HELLO THERE. how ARE you? i am fine!', 'sentence')).toBe('Hello there. How are you? I am fine!');
    });
    it('programming cases', () => {
        expect(convertCase('Hello world foo', 'camel')).toBe('helloWorldFoo');
        expect(convertCase('hello world foo', 'pascal')).toBe('HelloWorldFoo');
        expect(convertCase('helloWorld XMLHttpRequest', 'snake')).toBe('hello_world_xml_http_request');
        expect(convertCase('Hello World', 'kebab')).toBe('hello-world');
        expect(convertCase('max retry count', 'constant')).toBe('MAX_RETRY_COUNT');
    });
    it('keeps lines separate for programming cases', () => {
        expect(convertCase('first name\nlast name', 'snake')).toBe('first_name\nlast_name');
    });
    it('alternating and inverse', () => {
        expect(convertCase('hello', 'alternating')).toBe('hElLo');
        expect(convertCase('Hello World', 'inverse')).toBe('hELLO wORLD');
    });
    it('handles accents', () => {
        expect(convertCase('élan über', 'upper')).toBe('ÉLAN ÜBER');
    });
});

describe('password generator', () => {
    it('respects length and charsets', () => {
        for (let i = 0; i < 50; i++) {
            const pw = generatePassword({ length: 20, upper: true, lower: false, numbers: true, symbols: false });
            expect(pw).toHaveLength(20);
            expect(pw).toMatch(/^[A-Z0-9]+$/);
            expect(pw).toMatch(/[A-Z]/);
            expect(pw).toMatch(/[0-9]/);
        }
    });
    it('includes every selected type even at minimum length', () => {
        for (let i = 0; i < 100; i++) {
            const pw = generatePassword({ length: 4, upper: true, lower: true, numbers: true, symbols: true });
            expect(pw).toHaveLength(4);
            expect(pw).toMatch(/[A-Z]/);
            expect(pw).toMatch(/[a-z]/);
            expect(pw).toMatch(/[0-9]/);
            expect([...pw].some((c) => CHARSETS.symbols.includes(c))).toBe(true);
        }
    });
    it('excludes similar characters', () => {
        for (let i = 0; i < 50; i++) {
            expect(generatePassword({ length: 64, upper: true, lower: true, numbers: true, symbols: false, excludeSimilar: true })).not.toMatch(/[il1LoO0I]/);
        }
    });
    it('clamps length and errors when nothing is selected', () => {
        expect(generatePassword({ length: 999, lower: true })).toHaveLength(128);
        expect(generatePassword({ length: 1, lower: true })).toHaveLength(4);
        expect(() => generatePassword({ length: 10 })).toThrow(/at least one/);
    });
    it('computes entropy', () => {
        expect(entropyBits({ length: 16, upper: true, lower: true, numbers: true, symbols: true })).toBeGreaterThan(100);
        expect(entropyBits({ length: 16 })).toBe(0);
    });
});

describe('age calculator', () => {
    const d = parseDateInput;
    it('parses and validates dates', () => {
        expect(d('2024-02-29')).toEqual({ y: 2024, m: 2, d: 29 });
        expect(d('2023-02-29')).toBeNull();
        expect(d('2023-13-01')).toBeNull();
        expect(d('')).toBeNull();
    });
    it('calculates exact age', () => {
        expect(calculateAge(d('1990-05-15'), d('2026-09-29'))).toMatchObject({ years: 36, months: 4, days: 14 });
        expect(calculateAge(d('2000-01-31'), d('2000-03-01'))).toMatchObject({ years: 0, months: 1, days: 1 });
        expect(calculateAge(d('2020-09-29'), d('2026-09-29'))).toMatchObject({ years: 6, months: 0, days: 0, daysToBirthday: 0, turningAge: 6 });
    });
    it('borrows days across year boundary', () => {
        expect(calculateAge(d('2025-12-20'), d('2026-01-05'))).toMatchObject({ years: 0, months: 0, days: 16, totalDays: 16 });
    });
    it('handles leap day birthdays', () => {
        const r = calculateAge(d('2004-02-29'), d('2026-03-01'));
        expect(r).toMatchObject({ years: 22, months: 0, days: 1 });
        expect(r.nextBirthday).toEqual({ y: 2027, m: 2, d: 28 });
        expect(calculateAge(d('2004-02-29'), d('2027-02-27')).daysToBirthday).toBe(1);
        expect(calculateAge(d('2004-02-29'), d('2028-02-01')).nextBirthday).toEqual({ y: 2028, m: 2, d: 29 });
    });
    it('computes totals, weekday and rejects future birth dates', () => {
        const r = calculateAge(d('2000-01-01'), d('2000-01-15'));
        expect(r.totalDays).toBe(14);
        expect(r.totalWeeks).toBe(2);
        expect(r.bornOn).toBe('Saturday');
        expect(() => calculateAge(d('2030-01-01'), d('2026-01-01'))).toThrow();
    });
});

describe('percentage calculator', () => {
    it('parses numbers leniently', () => {
        expect(parseNumber('1,250.5')).toBe(1250.5);
        expect(parseNumber('15%')).toBe(15);
        expect(parseNumber('-3')).toBe(-3);
        expect(parseNumber('.5')).toBe(0.5);
        expect(parseNumber('abc')).toBeNull();
        expect(parseNumber('')).toBeNull();
        expect(parseNumber('1e3')).toBe(1000);
    });
    it('formats without floating point noise', () => {
        expect(formatNumber(0.1 + 0.2)).toBe('0.3');
        expect(formatNumber(1234567.891)).toBe('1,234,567.891');
        expect(formatNumber(-0)).toBe('0');
    });
    it('calculates', () => {
        expect(percentOf(15, 200).text).toBe('30');
        expect(whatPercent(30, 120).text).toBe('25%');
        expect(percentChange(80, 100).text).toBe('25% increase');
        expect(percentChange(100, 80).text).toBe('20% decrease');
        expect(percentChange(-50, -25).value).toBe(50);
        expect(percentChange(5, 5).text).toContain('no change');
        expect(wholeFromPart(25, 20).text).toBe('125');
        expect(applyPercent(50, 20, 'increase').text).toBe('60');
        expect(applyPercent(50, 20, 'decrease').text).toBe('40');
    });
    it('reports division by zero and missing input', () => {
        expect(whatPercent(5, 0).error).toBeTruthy();
        expect(percentChange(0, 10).error).toBeTruthy();
        expect(wholeFromPart(5, 0).error).toBeTruthy();
        expect(percentOf(null, 5)).toBeNull();
    });
});

describe('json formatter', () => {
    it('formats and minifies', () => {
        expect(formatJson('{"a":1,"b":[1,2]}', { indent: 2 }).output).toBe('{\n  "a": 1,\n  "b": [\n    1,\n    2\n  ]\n}');
        expect(formatJson('{ "a" : 1 }', { minify: true }).output).toBe('{"a":1}');
        expect(formatJson('{"a":1}', { indent: 'tab' }).output).toBe('{\n\t"a": 1\n}');
    });
    it('sorts keys deeply', () => {
        expect(formatJson('{"b":1,"a":{"d":1,"c":2}}', { sortKeys: true, minify: true }).output).toBe('{"a":{"c":2,"d":1},"b":1}');
    });
    it('reports errors with line and column', () => {
        const r = parseJson('{\n  "a": 1,\n}');
        expect(r.ok).toBe(false);
        expect(r.error).toMatch(/line 3/);
        expect(r.error).toMatch(/trailing comma/i);
        expect(parseJson("{'a': 1}").error).toMatch(/double quotes/);
        expect(parseJson('   ').ok).toBe(false);
    });
});

describe('base64', () => {
    it('round-trips UTF-8 text', () => {
        const text = 'Hello, 世界! 👋 café';
        expect(decodeText(encodeText(text)).text).toBe(text);
        expect(encodeText('Hello')).toBe('SGVsbG8=');
    });
    it('supports URL-safe output and input', () => {
        const input = '??>>';
        const safe = encodeText(input, { urlSafe: true });
        expect(safe).not.toMatch(/[+/=]/);
        expect(decodeText(safe).text).toBe(input);
    });
    it('accepts whitespace, missing padding and data URLs', () => {
        expect(decodeText('SGVs bG8').text).toBe('Hello');
        expect(decodeText('data:text/plain;base64,SGVsbG8=').text).toBe('Hello');
    });
    it('rejects invalid input', () => {
        expect(() => normalizeBase64('not base64!')).toThrow();
        expect(() => normalizeBase64('SGVsb')).toThrow(/length/);
        expect(() => normalizeBase64('')).toThrow();
    });
    it('flags binary output', () => {
        expect(decodeText('/w==').binary).toBe(true);
    });
});

describe('pdf page ranges', () => {
    it('parses ranges', () => {
        expect(parseRanges('1-3, 5, 8-', 10)).toEqual([[1, 3], [5, 5], [8, 10]]);
        expect(parseRanges('-2; 4-end', 6)).toEqual([[1, 2], [4, 6]]);
        expect(parseRanges(' 2 ', 3)).toEqual([[2, 2]]);
    });
    it('rejects bad ranges with helpful messages', () => {
        expect(() => parseRanges('', 5)).toThrow();
        expect(() => parseRanges('0', 5)).toThrow(/start at 1/);
        expect(() => parseRanges('7', 5)).toThrow(/only has 5 pages/);
        expect(() => parseRanges('5-2', 5)).toThrow(/backwards/);
        expect(() => parseRanges('abc', 5)).toThrow(/not a valid/);
    });
    it('flattens and de-duplicates indexes', () => {
        expect(rangesToIndexes([[1, 3], [2, 4], [1, 1]])).toEqual([0, 1, 2, 3]);
    });
    it('keeps the indexes not excluded, in order', () => {
        expect(indexesExcluding(5, [1, 3])).toEqual([0, 2, 4]);
        expect(indexesExcluding(3, new Set([0, 1, 2]))).toEqual([]);
        expect(indexesExcluding(4, [])).toEqual([0, 1, 2, 3]);
    });
});

describe('pdf rotation', () => {
    it('normalises rotation deltas to 0-270', () => {
        expect(addRotation(0, 90)).toBe(90);
        expect(addRotation(270, 90)).toBe(0);
        expect(addRotation(0, -90)).toBe(270);
        expect(addRotation(90, 180)).toBe(270);
        expect(addRotation(350, 20)).toBe(10);
    });

    it('sets absolute page rotation and keeps page content', async () => {
        const doc = await PDFDocument.create();
        doc.addPage([100, 200]);
        doc.addPage([100, 200]);
        const blob = await buildRotatedPdf(doc, [90, 180]);
        const out = await PDFDocument.load(await blob.arrayBuffer());
        expect(out.getPageCount()).toBe(2);
        expect(out.getPage(0).getRotation().angle).toBe(90);
        expect(out.getPage(1).getRotation().angle).toBe(180);
    });

    it('leaves a page untouched when no target rotation is given for it', async () => {
        const doc = await PDFDocument.create();
        doc.addPage([100, 200]);
        const blob = await buildRotatedPdf(doc, []);
        const out = await PDFDocument.load(await blob.arrayBuffer());
        expect(out.getPage(0).getRotation().angle).toBe(0);
    });
});

describe('pdf render scale', () => {
    it('converts DPI to a pdfjs viewport scale (72 dpi = scale 1)', () => {
        expect(dpiToScale(72)).toBe(1);
        expect(dpiToScale(150)).toBeCloseTo(150 / 72);
        expect(dpiToScale(300)).toBeCloseTo(300 / 72);
    });
});

describe('pdf to image naming', () => {
    it('picks the right mime type and extension per format', () => {
        expect(mimeType('jpeg')).toBe('image/jpeg');
        expect(mimeType('png')).toBe('image/png');
        expect(fileExtension('jpeg')).toBe('jpg');
        expect(fileExtension('png')).toBe('png');
    });

    it('names a single page without a "-page-N" suffix', () => {
        expect(pageFilename('report', 1, 1, 'jpeg')).toBe('report.jpg');
        expect(pageFilename('report', 1, 1, 'png')).toBe('report.png');
    });

    it('numbers each page when there is more than one', () => {
        expect(pageFilename('report', 1, 3, 'jpeg')).toBe('report-page-1.jpg');
        expect(pageFilename('report', 3, 3, 'png')).toBe('report-page-3.png');
    });
});

describe('pdf compression', () => {
    // A hand-built minimal JPEG header: just enough for pdf-lib's JpegEmbedder to read
    // SOI, a SOF0 marker, 8-bit depth, 2x2 size and 3 (RGB) channels - not a decodable image,
    // but enough to produce a real DCTDecode image stream to inspect.
    const MINIMAL_JPEG = new Uint8Array([0xff, 0xd8, 0xff, 0xc0, 0x00, 0x0b, 0x08, 0x00, 0x02, 0x00, 0x02, 0x03, 0, 0, 0, 0]);
    // A real, valid 1x1 transparent PNG.
    const MINIMAL_PNG = Uint8Array.from(atob('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNk+A8AAQUBAScY42YAAAAASUVORK5CYII='), (c) => c.charCodeAt(0));

    it('judges recompressibility from an image stream\'s own attributes', () => {
        expect(isRecompressibleImageInfo({ subtype: 'Image', filter: 'DCTDecode', colorSpace: 'DeviceRGB', hasSMask: false })).toBe(true);
        expect(isRecompressibleImageInfo({ subtype: 'Image', filter: 'DCTDecode', colorSpace: 'DeviceGray', hasSMask: false })).toBe(true);
        expect(isRecompressibleImageInfo({ subtype: 'Image', filter: 'DCTDecode', colorSpace: 'DeviceCMYK', hasSMask: false })).toBe(false);
        expect(isRecompressibleImageInfo({ subtype: 'Image', filter: 'FlateDecode', colorSpace: 'DeviceRGB', hasSMask: false })).toBe(false);
        expect(isRecompressibleImageInfo({ subtype: 'Image', filter: 'DCTDecode', colorSpace: 'DeviceRGB', hasSMask: true })).toBe(false);
        expect(isRecompressibleImageInfo({ subtype: 'Form', filter: 'DCTDecode', colorSpace: 'DeviceRGB', hasSMask: false })).toBe(false);
    });

    it('finds embedded JPEGs in a real PDF but skips PNGs', async () => {
        const doc = await PDFDocument.create();
        const page = doc.addPage([100, 100]);
        const jpg = await doc.embedJpg(MINIMAL_JPEG);
        const png = await doc.embedPng(MINIMAL_PNG);
        page.drawImage(jpg, { x: 0, y: 0, width: 10, height: 10 });
        page.drawImage(png, { x: 20, y: 0, width: 10, height: 10 });

        const reloaded = await PDFDocument.load(await doc.save());
        const images = listRecompressibleImages(reloaded.context);
        expect(images).toHaveLength(1);
        expect(images[0].obj).toBeInstanceOf(PDFRawStream);
        expect(isRecompressibleImage(images[0].obj)).toBe(true);
    });

    it('keeps aspect ratio when capping the longer side, and leaves small images alone', () => {
        expect(scaledDimensions(2000, 1000, 1600)).toEqual({ width: 1600, height: 800 });
        expect(scaledDimensions(1000, 2000, 1600)).toEqual({ width: 800, height: 1600 });
        expect(scaledDimensions(800, 600, 1600)).toEqual({ width: 800, height: 600 });
    });
});

describe('jpg to pdf page layout', () => {
    it('fits a portrait image on an A4 page, centred, with the default margin', () => {
        const margin = 10 * MM_TO_PT;
        const layout = computeImagePageLayout({ pageSize: 'a4', orientation: 'auto', marginMm: 10, imageWidth: 800, imageHeight: 1200 });
        expect(layout.pageWidth).toBeCloseTo(PDF_PAGE_SIZES.a4.width);
        expect(layout.pageHeight).toBeCloseTo(PDF_PAGE_SIZES.a4.height);
        const scale = Math.min((layout.pageWidth - margin * 2) / 800, (layout.pageHeight - margin * 2) / 1200);
        expect(layout.drawWidth).toBeCloseTo(800 * scale);
        expect(layout.drawHeight).toBeCloseTo(1200 * scale);
        expect(layout.x).toBeCloseTo((layout.pageWidth - layout.drawWidth) / 2);
        expect(layout.y).toBeCloseTo((layout.pageHeight - layout.drawHeight) / 2);
    });

    it('rotates the page to landscape for a wide image in auto orientation', () => {
        const layout = computeImagePageLayout({ pageSize: 'a4', orientation: 'auto', marginMm: 10, imageWidth: 1200, imageHeight: 800 });
        expect(layout.pageWidth).toBeCloseTo(PDF_PAGE_SIZES.a4.height);
        expect(layout.pageHeight).toBeCloseTo(PDF_PAGE_SIZES.a4.width);
    });

    it('keeps the requested orientation even when it does not match the image', () => {
        const portrait = computeImagePageLayout({ pageSize: 'a4', orientation: 'portrait', marginMm: 10, imageWidth: 1200, imageHeight: 800 });
        expect(portrait.pageWidth).toBeCloseTo(PDF_PAGE_SIZES.a4.width);
        expect(portrait.pageHeight).toBeCloseTo(PDF_PAGE_SIZES.a4.height);

        const landscape = computeImagePageLayout({ pageSize: 'letter', orientation: 'landscape', marginMm: 10, imageWidth: 800, imageHeight: 1200 });
        expect(landscape.pageWidth).toBeCloseTo(PDF_PAGE_SIZES.letter.height);
        expect(landscape.pageHeight).toBeCloseTo(PDF_PAGE_SIZES.letter.width);
    });

    it('sizes the page to the image itself in "fit" mode, with no scaling', () => {
        const layout = computeImagePageLayout({ pageSize: 'fit', marginMm: 5, imageWidth: 640, imageHeight: 480 });
        const margin = 5 * MM_TO_PT;
        expect(layout.pageWidth).toBeCloseTo(640 + margin * 2);
        expect(layout.pageHeight).toBeCloseTo(480 + margin * 2);
        expect(layout.drawWidth).toBeCloseTo(640);
        expect(layout.drawHeight).toBeCloseTo(480);
        expect(layout.x).toBeCloseTo(margin);
        expect(layout.y).toBeCloseTo(margin);
    });

    it('supports no margin at all', () => {
        const layout = computeImagePageLayout({ pageSize: 'fit', marginMm: 0, imageWidth: 100, imageHeight: 200 });
        expect(layout.pageWidth).toBeCloseTo(100);
        expect(layout.pageHeight).toBeCloseTo(200);
        expect(layout.x).toBe(0);
        expect(layout.y).toBe(0);
    });
});

describe('qr payloads', () => {
    it('builds url, wifi, email, phone and sms payloads', () => {
        expect(buildQrPayload('url', { url: 'example.com' }).payload).toBe('https://example.com');
        expect(buildQrPayload('url', { url: 'http://x.io' }).payload).toBe('http://x.io');
        expect(buildQrPayload('wifi', { ssid: 'My;Net', password: 'p:ss', encryption: 'WPA' }).payload).toBe('WIFI:T:WPA;S:My\\;Net;P:p\\:ss;;');
        expect(buildQrPayload('wifi', { ssid: 'Open', encryption: 'nopass', hidden: true }).payload).toBe('WIFI:T:nopass;S:Open;H:true;;');
        expect(buildQrPayload('email', { email: 'a@b.co', subject: 'Hi there' }).payload).toBe('mailto:a@b.co?subject=Hi%20there');
        expect(buildQrPayload('phone', { phone: '+44 (0) 7700-900' }).payload).toBe('tel:+4407700900');
        expect(buildQrPayload('sms', { phone: '+1 555 1234', message: 'Hi' }).payload).toBe('SMSTO:+15551234:Hi');
    });
    it('validates input', () => {
        expect(buildQrPayload('url', { url: ' ' }).error).toBeTruthy();
        expect(buildQrPayload('wifi', { ssid: 'x', encryption: 'WPA', password: '' }).error).toBeTruthy();
        expect(buildQrPayload('email', { email: 'nope' }).error).toBeTruthy();
        expect(escapeWifi('a\\b"c')).toBe('a\\\\b\\"c');
    });
    it('computes contrast', () => {
        expect(contrastRatio('#000000', '#ffffff')).toBeCloseTo(21, 0);
        expect(contrastRatio('#777777', '#888888')).toBeLessThan(3);
    });
});

describe('utils', () => {
    it('formats bytes', () => {
        expect(formatBytes(500)).toBe('500 B');
        expect(formatBytes(1536)).toBe('1.50 KB');
        expect(formatBytes(150 * 1024)).toBe('150 KB');
        expect(formatBytes(5 * 1024 * 1024)).toBe('5.00 MB');
    });
    it('makes unique, safe filenames', () => {
        const next = uniqueNamer();
        expect([next('a.jpg'), next('a.jpg'), next('a.jpg')]).toEqual(['a.jpg', 'a (2).jpg', 'a (3).jpg']);
        expect(baseName('my.photo.PNG')).toBe('my.photo');
        expect(safeFilename('a/b:c*.pdf')).toBe('a_b_c_.pdf');
    });
});

describe('age calculator edge cases (brute force)', () => {
    it('never returns negative or out-of-range parts across 3 years of dates', () => {
        // ~42,000 date pairs. Checked with plain comparisons and asserted once at
        // the end: 340k individual expect() calls made this test hit the 5s timeout.
        const start = Date.UTC(2023, 0, 1);
        const failures = [];
        let checked = 0;
        for (let i = 0; i < 1100; i += 3) {
            for (let j = i; j < i + 800; j += 7) {
                const a = new Date(start + i * 86400000);
                const b = new Date(start + j * 86400000);
                const birth = { y: a.getUTCFullYear(), m: a.getUTCMonth() + 1, d: a.getUTCDate() };
                const target = { y: b.getUTCFullYear(), m: b.getUTCMonth() + 1, d: b.getUTCDate() };
                const r = calculateAge(birth, target);
                const ok =
                    r.days >= 0 && r.days < 31 &&
                    r.months >= 0 && r.months < 12 &&
                    r.years >= 0 &&
                    r.daysToBirthday >= 0 && r.daysToBirthday <= 366 &&
                    r.totalDays === j - i;
                if (!ok && failures.length < 5) failures.push({ birth, target, result: r });
                checked++;
            }
        }
        expect(checked).toBeGreaterThan(40000);
        expect(failures).toEqual([]);
    });
});

describe('html to pdf', () => {
    it('decodes named and numeric HTML entities', () => {
        expect(decodeEntities('&amp;&lt;&gt;&quot;&#39;&nbsp;')).toBe('&<>"\' ');
        expect(decodeEntities('&#65;&#x42;')).toBe('AB');
    });

    it('parses headings and paragraphs, keeping bold/italic runs', () => {
        const blocks = parseHtmlToBlocks('<h1>Title</h1><p>Hello <b>world</b></p>');
        expect(blocks).toEqual([
            { type: 'heading', level: 1, runs: [{ text: 'Title', bold: false, italic: false }] },
            { type: 'paragraph', runs: [{ text: 'Hello ', bold: false, italic: false }, { text: 'world', bold: true, italic: false }] },
        ]);
    });

    it('numbers ordered lists and leaves unordered lists unnumbered', () => {
        const ordered = parseHtmlToBlocks('<ol><li>A</li><li>B</li></ol>');
        expect(ordered.map((b) => b.number)).toEqual([1, 2]);
        const unordered = parseHtmlToBlocks('<ul><li>One</li><li>Two</li></ul>');
        expect(unordered.every((b) => b.ordered === false)).toBe(true);
    });

    it('turns <br> into an explicit break and <img src> into its own block', () => {
        const blocks = parseHtmlToBlocks('<p>Line1<br>Line2</p><img src="data:image/png;base64,abc">');
        expect(blocks[0].runs).toEqual([
            { text: 'Line1', bold: false, italic: false },
            { break: true },
            { text: 'Line2', bold: false, italic: false },
        ]);
        expect(blocks[1]).toEqual({ type: 'image', src: 'data:image/png;base64,abc' });
    });

    it('treats plain text with no tags as one paragraph', () => {
        expect(parseHtmlToBlocks('Hello world')).toEqual([{ type: 'paragraph', runs: [{ text: 'Hello world', bold: false, italic: false }] }]);
    });

    it('tokenizes runs into words with space markers', () => {
        const words = tokenizeRuns([{ text: 'Hello world', bold: false, italic: false }]);
        expect(words).toEqual([
            { text: 'Hello', bold: false, italic: false, space: true },
            { text: 'world', bold: false, italic: false, space: false },
        ]);
    });

    it('wraps words greedily to fit the available width', () => {
        const words = tokenizeRuns([{ text: 'aa bb cc dd', bold: false, italic: false }]);
        const lines = wrapWords(words, 10, (text) => text.length, 12);
        expect(lines.map((l) => l.map((w) => w.text))).toEqual([['aa', 'bb', 'cc'], ['dd']]);
    });

    it('hard-breaks a single word wider than the whole line', () => {
        const words = tokenizeRuns([{ text: 'abcdefghij', bold: false, italic: false }]);
        const lines = wrapWords(words, 5, (text) => text.length, 12);
        expect(lines.flat().map((w) => w.text).join('')).toBe('abcdefghij');
        expect(lines.every((l) => l.reduce((w, word) => w + word.text.length, 0) <= 5)).toBe(true);
    });

    it('paginates long content and scales oversized images to fit the page', () => {
        const blocks = Array.from({ length: 6 }, (_, i) => ({ type: 'paragraph', runs: [{ text: `Paragraph ${i}`, bold: false, italic: false }] }));
        const measure = (text) => (text || ' ').length * 2;
        const pages = layoutBlocksToPages(blocks, { pageWidth: 200, pageHeight: 100, marginPt: 10, measure, imageSize: () => null });
        expect(pages.length).toBeGreaterThan(1);
        expect(pages.flat().length).toBe(6);

        const withImage = layoutBlocksToPages([{ type: 'image', src: 'big.png' }], {
            pageWidth: 200, pageHeight: 300, marginPt: 10, measure, imageSize: () => ({ width: 400, height: 200 }),
        });
        expect(withImage[0][0]).toMatchObject({ width: 180, height: 90 });

        const unknownImage = layoutBlocksToPages([{ type: 'image', src: 'missing.png' }], {
            pageWidth: 200, pageHeight: 300, marginPt: 10, measure, imageSize: () => null,
        });
        expect(unknownImage.flat()).toEqual([]);
    });
});

describe('pdf to word text reconstruction', () => {
    it('joins same-line text items with a space when there is a visible gap', () => {
        const items = [
            { str: 'Hello', x: 0, y: 700, height: 12 },
            { str: 'World', x: 50, y: 700, height: 12 },
            { str: 'Second line', x: 0, y: 680, height: 12 },
        ];
        const lines = groupItemsIntoLines(items);
        expect(lines.map((l) => l.text)).toEqual(['Hello World', 'Second line']);
    });

    it('picks the most common line height as the body text size', () => {
        expect(detectBodySize([{ height: 10 }, { height: 10 }, { height: 20 }])).toBe(10);
        expect(detectBodySize([])).toBe(12);
    });

    it('guesses a heading level from how much bigger a line is than the body text', () => {
        expect(headingLevelFor(20, 10)).toBe(1);
        expect(headingLevelFor(13.6, 10)).toBe(2);
        expect(headingLevelFor(12, 10)).toBe(3);
        expect(headingLevelFor(10, 10)).toBeNull();
    });

    it('groups lines into headings and multi-line paragraphs, splitting on big gaps', () => {
        const lines = [
            { y: 700, height: 20, text: 'Big Title' },
            { y: 670, height: 10, text: 'First paragraph line one' },
            { y: 658, height: 10, text: 'continuing same paragraph' },
            { y: 600, height: 10, text: 'New paragraph after big gap' },
        ];
        expect(buildDocumentBlocks(lines)).toEqual([
            { type: 'heading', level: 1, text: 'Big Title' },
            { type: 'paragraph', lines: ['First paragraph line one', 'continuing same paragraph'] },
            { type: 'paragraph', lines: ['New paragraph after big gap'] },
        ]);
    });
});

describe('pdf to excel table reconstruction', () => {
    it('clusters text items that share a Y position into rows, sorted top to bottom', () => {
        const items = [
            { str: 'A1', x: 0, y: 700 },
            { str: 'B1', x: 100, y: 700 },
            { str: 'A2', x: 0, y: 680 },
        ];
        const rows = groupItemsIntoRows(items);
        expect(rows.map((r) => r.items.map((i) => i.str))).toEqual([['A1', 'B1'], ['A2']]);
    });

    it('clusters nearby X start-positions into shared column boundaries', () => {
        const rows = groupItemsIntoRows([
            { str: 'A1', x: 0, y: 700 },
            { str: 'B1', x: 100, y: 700 },
            { str: 'A2', x: 2, y: 680 },
        ]);
        expect(detectColumnBoundaries(rows)).toEqual([0, 100]);
    });

    it('places each row into its detected column, leaving missing cells blank', () => {
        const rows = groupItemsIntoRows([
            { str: 'A1', x: 0, y: 700 },
            { str: 'B1', x: 100, y: 700 },
            { str: 'A2', x: 0, y: 680 },
        ]);
        expect(rowsToTable(rows, detectColumnBoundaries(rows))).toEqual([
            ['A1', 'B1'],
            ['A2', ''],
        ]);
    });
});

describe('excel to pdf table layout', () => {
    it('reads cell values as text, never null/undefined', () => {
        expect(cellText(null)).toBe('');
        expect(cellText(undefined)).toBe('');
        expect(cellText(5)).toBe('5');
        expect(cellText('x')).toBe('x');
    });

    it('keeps natural column widths when they already fit the page', () => {
        const widths = computeColumnWidths([['Name', 'Age'], ['Alexander', '30']], 200, (text) => text.length);
        expect(widths).toEqual([36, 36]);
    });

    it('scales columns down proportionally when the table is wider than the page', () => {
        const measure = (text) => text.length * 5;
        const widths = computeColumnWidths([['Name', 'VeryLongColumnHeader'], ['Bob', 'Short']], 100, measure);
        expect(widths.reduce((a, b) => a + b, 0)).toBeLessThanOrEqual(100.01);
        expect(widths[1]).toBeGreaterThan(widths[0]);
    });

    it('truncates text with an ellipsis only when it does not already fit', () => {
        expect(truncateToWidth('Hi', 10, (text) => text.length)).toBe('Hi');
        expect(truncateToWidth('Hello World', 5, (text) => text.length)).toBe('Hell…');
    });

    it('paginates rows into fixed-size chunks', () => {
        expect(paginateRows([], 5)).toEqual([[]]);
        expect(paginateRows([1, 2, 3, 4, 5, 6, 7], 3)).toEqual([[1, 2, 3], [4, 5, 6], [7]]);
    });

    it('lays out a sheet into a header plus row chunks that fit the page height', () => {
        const rows = [['H1', 'H2'], ['r1c1', 'r1c2'], ['r2c1', 'r2c2'], ['r3c1', 'r3c2']];
        const pages = layoutSheetToPages(rows, { maxWidth: 1000, maxBodyHeight: 48, measure: (text) => text.length, rowHeight: 16 });
        expect(pages).toHaveLength(2);
        expect(pages[0].header).toEqual(['H1', 'H2']);
        expect(pages[0].rows).toEqual([['r1c1', 'r1c2'], ['r2c1', 'r2c2']]);
        expect(pages[1].rows).toEqual([['r3c1', 'r3c2']]);
    });

    it('returns no pages for an empty sheet', () => {
        expect(layoutSheetToPages([], { maxWidth: 100, maxBodyHeight: 100, measure: (text) => text.length })).toEqual([]);
    });
});
