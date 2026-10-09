import { describe, expect, it } from 'vitest';
import { formatSignatureDate, signatureBoxSize } from './pdfSign.js';

describe('signatureBoxSize', () => {
    it('keeps the source image aspect ratio at the target width', () => {
        expect(signatureBoxSize(400, 200, 160)).toEqual({ width: 160, height: 80 });
        expect(signatureBoxSize(300, 100, 150)).toEqual({ width: 150, height: 50 });
    });

    it('falls back to a sensible ratio for a zero-size image', () => {
        expect(signatureBoxSize(0, 0, 160)).toEqual({ width: 160, height: 64 });
    });
});

describe('formatSignatureDate', () => {
    it('formats a fixed date for a given locale', () => {
        const date = new Date(Date.UTC(2026, 0, 15, 12));
        expect(formatSignatureDate('en-US', date)).toBe('01/15/2026');
        expect(formatSignatureDate('de-DE', date)).toBe('15.01.2026');
    });

    it('falls back to an ISO date for an invalid locale', () => {
        const date = new Date(Date.UTC(2026, 0, 15, 12));
        expect(formatSignatureDate('not-a-real-locale!!', date)).toBe('2026-01-15');
    });
});
