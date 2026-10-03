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
import { PDFDocument } from 'pdf-lib';
import { buildQrPayload, contrastRatio, escapeWifi } from './qr.js';
import { formatBytes, uniqueNamer, baseName, safeFilename } from './util.js';

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
