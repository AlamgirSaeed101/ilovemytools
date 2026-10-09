import { describe, expect, it } from 'vitest';
import { calcLoan, parseMoney, parsePercent, TERM_PRESETS } from './loan.js';

describe('loan input parsing', () => {
    it('parses plain and locale-formatted money amounts', () => {
        expect(parseMoney('20000')).toBe(20000);
        expect(parseMoney('1,250.5')).toBe(1250.5);
        expect(parseMoney('')).toBe(null);
        expect(parseMoney('abc')).toBe(null);
    });

    it('parses a percentage the same way as money', () => {
        expect(parsePercent('7.5')).toBe(7.5);
        expect(parsePercent('abc')).toBe(null);
    });

    it('exposes the preset loan terms in order', () => {
        expect(TERM_PRESETS).toEqual([2, 3, 5, 7, 10]);
    });
});

describe('calcLoan', () => {
    it('computes the full breakdown for a typical loan', () => {
        const r = calcLoan({ loanAmount: 20000, annualRatePercent: 7, termYears: 5, extraMonthly: 0 });
        expect(r.loanAmount).toBe(20000);
        expect(r.monthlyPayment).toBeCloseTo(396.02, 1);
        expect(r.months).toBe(60);
        expect(r.totalPaid).toBeCloseTo(20000 + r.totalInterest, 6);
        expect(r.monthsSaved).toBe(0);
        expect(r.interestSaved).toBe(0);
    });

    it('reports the time and interest saved by an extra monthly payment', () => {
        const r = calcLoan({ loanAmount: 20000, annualRatePercent: 7, termYears: 5, extraMonthly: 100 });
        expect(r.monthsSaved).toBeGreaterThan(0);
        expect(r.interestSaved).toBeGreaterThan(0);
        expect(r.months).toBe(60 - r.monthsSaved);
    });

    it('rejects a loan amount of 0 or less', () => {
        expect(calcLoan({ loanAmount: 0, annualRatePercent: 7, termYears: 5 }).error).toMatch(/loan amount/);
        expect(calcLoan({ loanAmount: -1, annualRatePercent: 7, termYears: 5 }).error).toMatch(/loan amount/);
    });

    it('rejects an out-of-range interest rate', () => {
        expect(calcLoan({ loanAmount: 20000, annualRatePercent: -1, termYears: 5 }).error).toMatch(/interest rate/);
        expect(calcLoan({ loanAmount: 20000, annualRatePercent: 101, termYears: 5 }).error).toMatch(/interest rate/);
    });

    it('rejects an out-of-range loan term', () => {
        expect(calcLoan({ loanAmount: 20000, annualRatePercent: 7, termYears: 0 }).error).toMatch(/loan term/);
        expect(calcLoan({ loanAmount: 20000, annualRatePercent: 7, termYears: 51 }).error).toMatch(/loan term/);
    });

    it('rejects a negative extra payment', () => {
        expect(calcLoan({ loanAmount: 20000, annualRatePercent: 7, termYears: 5, extraMonthly: -1 }).error).toMatch(/extra payment/);
    });

    it('returns null until the required fields are entered', () => {
        expect(calcLoan({ loanAmount: null, annualRatePercent: 7, termYears: 5 })).toBe(null);
        expect(calcLoan({ loanAmount: 20000, annualRatePercent: null, termYears: 5 })).toBe(null);
    });

    it('allows a 0% interest rate', () => {
        const r = calcLoan({ loanAmount: 12000, annualRatePercent: 0, termYears: 1, extraMonthly: 0 });
        expect(r.monthlyPayment).toBeCloseTo(1000, 6);
        expect(r.totalInterest).toBe(0);
    });
});
