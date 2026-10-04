import { describe, expect, it } from 'vitest';
import { amortizationSchedule, calcMortgage, monthlyPayment, parseMoney, parsePercent, parseTermYears, TERM_PRESETS } from './mortgage.js';

describe('mortgage input parsing', () => {
    it('parses plain and locale-formatted money amounts', () => {
        expect(parseMoney('350000')).toBe(350000);
        expect(parseMoney('1,250.5')).toBe(1250.5);
        expect(parseMoney('')).toBe(null);
        expect(parseMoney('abc')).toBe(null);
    });

    it('parses a percentage the same way as money', () => {
        expect(parsePercent('6.5')).toBe(6.5);
        expect(parsePercent('abc')).toBe(null);
    });

    it('parses a whole number of years, rejecting anything else', () => {
        expect(parseTermYears('30')).toBe(30);
        expect(Number.isNaN(parseTermYears('0'))).toBe(true);
        expect(Number.isNaN(parseTermYears('15.5'))).toBe(true);
        expect(Number.isNaN(parseTermYears('abc'))).toBe(true);
    });

    it('exposes the preset loan terms in order', () => {
        expect(TERM_PRESETS).toEqual([10, 15, 20, 25, 30]);
    });
});

describe('monthlyPayment', () => {
    it('matches the standard fixed-rate amortization formula', () => {
        // $300,000 at 6.5% for 30 years is a textbook figure (~$1,896.20).
        expect(monthlyPayment(300000, 6.5, 30)).toBeCloseTo(1896.2, 1);
    });

    it('divides evenly at 0% interest', () => {
        expect(monthlyPayment(120000, 0, 10)).toBeCloseTo(1000, 6);
    });

    it('returns null for an invalid loan', () => {
        expect(monthlyPayment(0, 6.5, 30)).toBe(null);
        expect(monthlyPayment(-100, 6.5, 30)).toBe(null);
        expect(monthlyPayment(300000, 6.5, 0)).toBe(null);
        expect(monthlyPayment(300000, -1, 30)).toBe(null);
    });
});

describe('amortizationSchedule', () => {
    it('fully pays off the loan in exactly the term with no extra payments', () => {
        const s = amortizationSchedule(300000, 6.5, 30, 0);
        expect(s.months).toBe(360);
        const sumPrincipal = s.yearly.reduce((sum, y) => sum + y.principal, 0);
        const sumInterest = s.yearly.reduce((sum, y) => sum + y.interest, 0);
        expect(sumPrincipal).toBeCloseTo(300000, 2);
        expect(sumInterest).toBeCloseTo(s.totalInterest, 6);
        expect(s.yearly.at(-1).balance).toBeCloseTo(0, 6);
        expect(s.yearly.length).toBe(30);
    });

    it('pays off sooner and for less interest with an extra monthly payment', () => {
        const base = amortizationSchedule(300000, 6.5, 30, 0);
        const extra = amortizationSchedule(300000, 6.5, 30, 500);
        expect(extra.months).toBeLessThan(base.months);
        expect(extra.totalInterest).toBeLessThan(base.totalInterest);
        // The required monthly payment itself never changes because of an extra payment.
        expect(extra.payment).toBeCloseTo(base.payment, 6);
    });

    it('handles 0% interest with no residual balance', () => {
        const s = amortizationSchedule(12000, 0, 1, 0);
        expect(s.months).toBe(12);
        expect(s.totalInterest).toBe(0);
        expect(s.yearly.at(-1).balance).toBeCloseTo(0, 6);
    });
});

describe('calcMortgage', () => {
    it('computes the full breakdown for a typical loan', () => {
        const r = calcMortgage({ homePrice: 350000, downPayment: 20, downPaymentIsPercent: true, annualRatePercent: 6.5, termYears: 30, extraMonthly: 0 });
        expect(r.loanAmount).toBeCloseTo(280000, 6);
        expect(r.downPaymentAmount).toBeCloseTo(70000, 6);
        expect(r.downPaymentPercent).toBeCloseTo(20, 6);
        expect(r.monthlyPayment).toBeCloseTo(1769.79, 1);
        expect(r.months).toBe(360);
        expect(r.totalCost).toBeCloseTo(350000 + r.totalInterest, 6);
        expect(r.monthsSaved).toBe(0);
        expect(r.interestSaved).toBe(0);
    });

    it('accepts a down payment given as a fixed amount instead of a percentage', () => {
        const r = calcMortgage({ homePrice: 350000, downPayment: 70000, downPaymentIsPercent: false, annualRatePercent: 6.5, termYears: 30, extraMonthly: 0 });
        expect(r.loanAmount).toBeCloseTo(280000, 6);
        expect(r.downPaymentPercent).toBeCloseTo(20, 6);
    });

    it('reports the time and interest saved by an extra monthly payment', () => {
        const r = calcMortgage({ homePrice: 350000, downPayment: 20, downPaymentIsPercent: true, annualRatePercent: 6.5, termYears: 30, extraMonthly: 300 });
        expect(r.monthsSaved).toBeGreaterThan(0);
        expect(r.interestSaved).toBeGreaterThan(0);
        expect(r.months).toBe(360 - r.monthsSaved);
    });

    it('rejects a home price of 0 or less', () => {
        expect(calcMortgage({ homePrice: 0, downPayment: 20, downPaymentIsPercent: true, annualRatePercent: 6.5, termYears: 30 }).error).toMatch(/home price/);
        expect(calcMortgage({ homePrice: -1, downPayment: 20, downPaymentIsPercent: true, annualRatePercent: 6.5, termYears: 30 }).error).toMatch(/home price/);
    });

    it('rejects a negative down payment', () => {
        expect(calcMortgage({ homePrice: 300000, downPayment: -5, downPaymentIsPercent: true, annualRatePercent: 6.5, termYears: 30 }).error).toMatch(/down payment/);
    });

    it('rejects a down payment that covers the whole home price', () => {
        expect(calcMortgage({ homePrice: 300000, downPayment: 100, downPaymentIsPercent: true, annualRatePercent: 6.5, termYears: 30 }).error).toMatch(/no loan is needed/);
        expect(calcMortgage({ homePrice: 300000, downPayment: 300000, downPaymentIsPercent: false, annualRatePercent: 6.5, termYears: 30 }).error).toMatch(/no loan is needed/);
    });

    it('rejects an out-of-range interest rate', () => {
        expect(calcMortgage({ homePrice: 300000, downPayment: 20, downPaymentIsPercent: true, annualRatePercent: -1, termYears: 30 }).error).toMatch(/interest rate/);
        expect(calcMortgage({ homePrice: 300000, downPayment: 20, downPaymentIsPercent: true, annualRatePercent: 101, termYears: 30 }).error).toMatch(/interest rate/);
    });

    it('rejects an out-of-range loan term', () => {
        expect(calcMortgage({ homePrice: 300000, downPayment: 20, downPaymentIsPercent: true, annualRatePercent: 6.5, termYears: 0 }).error).toMatch(/loan term/);
        expect(calcMortgage({ homePrice: 300000, downPayment: 20, downPaymentIsPercent: true, annualRatePercent: 6.5, termYears: 51 }).error).toMatch(/loan term/);
    });

    it('rejects a negative extra payment', () => {
        expect(calcMortgage({ homePrice: 300000, downPayment: 20, downPaymentIsPercent: true, annualRatePercent: 6.5, termYears: 30, extraMonthly: -1 }).error).toMatch(/extra payment/);
    });

    it('returns null until the required fields are entered', () => {
        expect(calcMortgage({ homePrice: null, downPayment: 20, downPaymentIsPercent: true, annualRatePercent: 6.5, termYears: 30 })).toBe(null);
        expect(calcMortgage({ homePrice: 300000, downPayment: null, downPaymentIsPercent: true, annualRatePercent: 6.5, termYears: 30 })).toBe(null);
        expect(calcMortgage({ homePrice: 300000, downPayment: 20, downPaymentIsPercent: true, annualRatePercent: null, termYears: 30 })).toBe(null);
    });

    it('allows a 0% interest rate', () => {
        const r = calcMortgage({ homePrice: 120000, downPayment: 0, downPaymentIsPercent: true, annualRatePercent: 0, termYears: 10, extraMonthly: 0 });
        expect(r.monthlyPayment).toBeCloseTo(1000, 6);
        expect(r.totalInterest).toBe(0);
    });
});
