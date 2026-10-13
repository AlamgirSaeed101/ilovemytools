import { describe, expect, it } from 'vitest';
import { calcCompoundInterest, COMPOUNDING_OPTIONS, parseAmount, parsePercent, parseYears } from './compoundInterest.js';

describe('compound interest input parsing', () => {
    it('parses plain and locale-formatted amounts', () => {
        expect(parseAmount('10000')).toBe(10000);
        expect(parseAmount('1,250.5')).toBe(1250.5);
        expect(parseAmount('')).toBe(null);
        expect(parseAmount('abc')).toBe(null);
    });

    it('parses a percentage the same way as an amount', () => {
        expect(parsePercent('6')).toBe(6);
        expect(parsePercent('abc')).toBe(null);
    });

    it('parses whole years only', () => {
        expect(parseYears('20')).toBe(20);
        expect(parseYears('2.5')).toBeNaN();
        expect(parseYears('abc')).toBeNaN();
    });

    it('exposes the compounding frequency options', () => {
        expect(COMPOUNDING_OPTIONS).toEqual([1, 2, 4, 12, 365]);
    });
});

describe('calcCompoundInterest', () => {
    it('matches the plain compound interest formula with no contributions', () => {
        const r = calcCompoundInterest({ principal: 1000, annualRatePercent: 5, years: 10, compoundingPerYear: 12, monthlyContribution: 0 });
        expect(r.finalBalance).toBeCloseTo(1647.01, 1);
        expect(r.totalContributed).toBe(0);
        expect(r.totalInterest).toBeCloseTo(647.01, 1);
    });

    it('computes the full breakdown with monthly contributions', () => {
        const r = calcCompoundInterest({ principal: 10000, annualRatePercent: 6, years: 20, compoundingPerYear: 12, monthlyContribution: 200 });
        expect(r.finalBalance).toBeCloseTo(125510.22, 1);
        expect(r.totalContributed).toBe(48000);
        expect(r.totalInterest).toBeCloseTo(67510.22, 1);
        expect(r.yearly).toHaveLength(20);
        expect(r.yearly[0].balance).toBeCloseTo(13083.89, 1);
        expect(r.yearly[4].balance).toBeCloseTo(27442.51, 1);
        expect(r.yearly[19].balance).toBeCloseTo(125510.22, 1);
    });

    it('spreads the same yearly contribution total across any compounding frequency', () => {
        const monthly = calcCompoundInterest({ principal: 5000, annualRatePercent: 4, years: 5, compoundingPerYear: 12, monthlyContribution: 50 });
        const annually = calcCompoundInterest({ principal: 5000, annualRatePercent: 4, years: 5, compoundingPerYear: 1, monthlyContribution: 50 });
        expect(monthly.totalContributed).toBe(annually.totalContributed);
        expect(monthly.finalBalance).not.toBeCloseTo(annually.finalBalance, 0);
    });

    it('allows a 0% interest rate', () => {
        const r = calcCompoundInterest({ principal: 1000, annualRatePercent: 0, years: 2, compoundingPerYear: 12, monthlyContribution: 100 });
        expect(r.finalBalance).toBeCloseTo(1000 + 100 * 24, 6);
        expect(r.totalInterest).toBeCloseTo(0, 6);
    });

    it('rejects a negative starting amount', () => {
        expect(calcCompoundInterest({ principal: -1, annualRatePercent: 5, years: 5 }).error).toMatch(/starting amount/);
    });

    it('rejects an out-of-range interest rate', () => {
        expect(calcCompoundInterest({ principal: 1000, annualRatePercent: -1, years: 5 }).error).toMatch(/interest rate/);
        expect(calcCompoundInterest({ principal: 1000, annualRatePercent: 101, years: 5 }).error).toMatch(/interest rate/);
    });

    it('rejects an out-of-range number of years', () => {
        expect(calcCompoundInterest({ principal: 1000, annualRatePercent: 5, years: 0 }).error).toMatch(/years/);
        expect(calcCompoundInterest({ principal: 1000, annualRatePercent: 5, years: 51 }).error).toMatch(/years/);
    });

    it('rejects a negative monthly contribution', () => {
        expect(calcCompoundInterest({ principal: 1000, annualRatePercent: 5, years: 5, monthlyContribution: -1 }).error).toMatch(/monthly contribution/);
    });

    it('rejects an invalid compounding frequency', () => {
        expect(calcCompoundInterest({ principal: 1000, annualRatePercent: 5, years: 5, compoundingPerYear: 7 }).error).toMatch(/compounds/);
    });

    it('rejects a starting amount and monthly contribution of both 0', () => {
        expect(calcCompoundInterest({ principal: 0, annualRatePercent: 5, years: 5, monthlyContribution: 0 }).error).toMatch(/starting amount or a monthly contribution/);
    });

    it('returns null until the required fields are entered', () => {
        expect(calcCompoundInterest({ principal: null, annualRatePercent: 5, years: 5 })).toBe(null);
        expect(calcCompoundInterest({ principal: 1000, annualRatePercent: null, years: 5 })).toBe(null);
    });
});
