import { describe, expect, it } from 'vitest';
import { calculateAge, dayNumber, weekday } from './date.js';
import { imageTypeOf } from './image.js';
import { searchTools } from './search.js';
import { keywordDensity } from './text.js';

describe('date: years before 100 (regression)', () => {
    it('does not treat year 50 as 1950', () => {
        expect(dayNumber({ y: 50, m: 1, d: 1 })).toBeLessThan(dayNumber({ y: 1950, m: 1, d: 1 }));
        expect(dayNumber({ y: 1950, m: 1, d: 1 }) - dayNumber({ y: 50, m: 1, d: 1 })).toBe(1900 * 365 + 460); // 460 leap days between year 50 and 1950
    });

    it('gives correct weekdays for early and modern dates', () => {
        expect(weekday({ y: 2000, m: 1, d: 1 })).toBe('Saturday');
        expect(weekday({ y: 1, m: 1, d: 1 })).toBe('Monday'); // proleptic Gregorian
    });

    it('still calculates normal ages', () => {
        const r = calculateAge({ y: 1990, m: 5, d: 15 }, { y: 2026, m: 9, d: 29 });
        expect([r.years, r.months, r.days]).toEqual([36, 4, 14]);
    });
});

describe('keywordDensity: straight apostrophes (regression)', () => {
    it("ignores stop words typed as don't / it's", () => {
        const words = keywordDensity("don't don't don't it's it's garden garden").map((k) => k.word);
        expect(words).toEqual(['garden']);
    });
});

describe('imageTypeOf', () => {
    it('uses the browser type when present', () => {
        expect(imageTypeOf({ type: 'image/png', name: 'a.jpg' })).toBe('image/png');
    });

    it('falls back to the file extension', () => {
        expect(imageTypeOf({ type: '', name: 'Photo.WEBP' })).toBe('image/webp');
        expect(imageTypeOf({ type: '', name: 'scan.jpeg' })).toBe('image/jpeg');
        expect(imageTypeOf({ type: '', name: 'notes.txt' })).toBe('');
    });
});

describe('searchTools', () => {
    const tools = [
        { slug: 'merge-pdf', name: 'Merge PDF', category: 'pdf', tagline: 'Combine PDFs', keywords: ['combine pdf'] },
        { slug: 'split-pdf', name: 'Split PDF', category: 'pdf', tagline: 'Extract pages', keywords: [] },
        { slug: 'image-compressor', name: 'Image Compressor', category: 'img', tagline: 'Shrink photos', keywords: ['compress jpg'] },
    ];
    const categories = [{ slug: 'pdf', name: 'PDF Tools' }, { slug: 'img', name: 'Image Tools' }];

    it('returns everything for an empty query', () => {
        expect(searchTools(tools, '  ')).toHaveLength(3);
    });

    it('requires every word to match and ranks name matches first', () => {
        expect(searchTools(tools, 'pdf', categories).map((t) => t.slug)).toEqual(['merge-pdf', 'split-pdf']);
        expect(searchTools(tools, 'split pdf', categories).map((t) => t.slug)).toEqual(['split-pdf']);
        expect(searchTools(tools, 'compress', categories).map((t) => t.slug)).toEqual(['image-compressor']);
    });

    it('matches keywords and category names, case and accent insensitive', () => {
        expect(searchTools(tools, 'JPG', categories).map((t) => t.slug)).toEqual(['image-compressor']);
        expect(searchTools(tools, 'imagé tools', categories).map((t) => t.slug)).toEqual(['image-compressor']);
    });

    it('treats regex characters literally', () => {
        expect(searchTools(tools, '(pdf', categories)).toEqual([]);
    });
});
