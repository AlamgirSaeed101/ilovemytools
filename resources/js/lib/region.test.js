import { describe, expect, it } from 'vitest';
import { defaultPaper, tipPresets, visitorRegion } from './region.js';

describe('visitor region', () => {
    it('reads the country from language tags, then the time zone', () => {
        expect(visitorRegion(['en-US', 'en'], 'Europe/London')).toBe('US');
        expect(visitorRegion(['de', 'de-DE'], '')).toBe('DE');
        expect(visitorRegion(['zh-Hant-TW'], '')).toBe('TW');
        expect(visitorRegion(['en'], 'America/Chicago')).toBe('US');
        expect(visitorRegion(['fr'], 'America/Toronto')).toBe('CA');
        expect(visitorRegion(['en'], 'Asia/Karachi')).toBeNull();
    });

    it('chooses Letter paper only where it is the norm', () => {
        expect(defaultPaper('US')).toBe('letter');
        expect(defaultPaper('CA')).toBe('letter');
        expect(defaultPaper('GB')).toBe('a4');
        expect(defaultPaper(null)).toBe('a4');
    });

    it('suggests local tip percentages', () => {
        expect(tipPresets('US')).toEqual([15, 18, 20, 25]);
        expect(tipPresets('GB')).toEqual([10, 12.5, 15, 20]);
        expect(tipPresets('DE')).toEqual([5, 10, 15, 20]);
        expect(tipPresets(null)).toEqual([10, 15, 18, 20]);
    });
});
