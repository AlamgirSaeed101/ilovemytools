import { describe, expect, it } from 'vitest';
import { dateOnly, domainAge, normalizeDomain, rdapDateParts } from './domainAge.js';

describe('normalizeDomain', () => {
    it('reduces a URL to its bare domain', () => {
        expect(normalizeDomain(' https://www.Example.com/page?x=1 ')).toBe('example.com');
        expect(normalizeDomain('example.co.uk')).toBe('example.co.uk');
        expect(normalizeDomain('example.com:8080')).toBe('example.com');
        expect(normalizeDomain('example.com.')).toBe('example.com');
    });

    it('rejects input that is not a domain', () => {
        expect(normalizeDomain('not a domain')).toBeNull();
        expect(normalizeDomain('localhost')).toBeNull();
        expect(normalizeDomain('')).toBeNull();
    });
});

describe('dateOnly / rdapDateParts', () => {
    it('extracts the date part of an RDAP timestamp', () => {
        expect(dateOnly('1995-08-14T04:00:00Z')).toBe('1995-08-14');
        expect(dateOnly(null)).toBeNull();
        expect(rdapDateParts('1995-08-14T04:00:00Z')).toEqual({ y: 1995, m: 8, d: 14 });
        expect(rdapDateParts(null)).toBeNull();
        expect(rdapDateParts('not a date')).toBeNull();
    });
});

describe('domainAge', () => {
    it('computes exact years, months and days', () => {
        expect(domainAge('2010-01-15T00:00:00Z', new Date('2026-10-03T12:00:00Z'))).toEqual({
            years: 16,
            months: 8,
            days: 18,
        });
    });

    it('returns null for a missing, unparseable or future date', () => {
        expect(domainAge(null, new Date('2026-10-03T00:00:00Z'))).toBeNull();
        expect(domainAge('not a date', new Date('2026-10-03T00:00:00Z'))).toBeNull();
        expect(domainAge('2030-01-01T00:00:00Z', new Date('2026-10-03T00:00:00Z'))).toBeNull();
    });
});
