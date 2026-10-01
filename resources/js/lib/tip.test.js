import { describe, expect, it } from 'vitest';
import { calcTip, parseAmount, parsePeople, TIP_PRESETS } from './tip.js';

describe('tip calculator parsing', () => {
    it('parses plain and locale-formatted amounts', () => {
        expect(parseAmount('85')).toBe(85);
        expect(parseAmount('1,250.5')).toBe(1250.5);
        expect(parseAmount('')).toBe(null);
        expect(parseAmount('abc')).toBe(null);
    });

    it('parses a whole number of people, rejecting anything else', () => {
        expect(parsePeople('4')).toBe(4);
        expect(parsePeople('1')).toBe(1);
        expect(Number.isNaN(parsePeople('0'))).toBe(true);
        expect(Number.isNaN(parsePeople('2.5'))).toBe(true);
        expect(Number.isNaN(parsePeople(''))).toBe(true);
        expect(Number.isNaN(parsePeople('abc'))).toBe(true);
    });

    it('exposes the preset tip percentages in order', () => {
        expect(TIP_PRESETS).toEqual([15, 18, 20, 25]);
    });
});

describe('calcTip', () => {
    it('splits a bill with tip between several people', () => {
        const r = calcTip({ bill: 85, tipPercent: 20, people: 4, roundUp: false });
        expect(r.tipAmount).toBeCloseTo(17, 6);
        expect(r.totalAmount).toBeCloseTo(102, 6);
        expect(r.tipPerPerson).toBeCloseTo(4.25, 6);
        expect(r.totalPerPerson).toBeCloseTo(25.5, 6);
        expect(r.roundedUp).toBe(false);
        expect(r.tipAmountText).toBe('17.00');
        expect(r.totalPerPersonText).toBe('25.50');
    });

    it('defaults to one person when splitting by 1', () => {
        const r = calcTip({ bill: 50, tipPercent: 15, people: 1, roundUp: false });
        expect(r.totalAmount).toBeCloseTo(57.5, 6);
        expect(r.totalPerPerson).toBeCloseTo(57.5, 6);
    });

    it('allows a 0% tip', () => {
        const r = calcTip({ bill: 40, tipPercent: 0, people: 2, roundUp: false });
        expect(r.tipAmount).toBe(0);
        expect(r.totalPerPerson).toBe(20);
    });

    it('rounds the per-person total up to the next whole unit when asked', () => {
        const r = calcTip({ bill: 85, tipPercent: 20, people: 4, roundUp: true });
        expect(r.totalPerPerson).toBe(26);
        expect(r.roundedUp).toBe(true);
        expect(r.totalAmount).toBeCloseTo(104, 6);
        expect(r.tipAmount).toBeCloseTo(19, 6);
    });

    it('does not round up when the total per person is already a whole unit', () => {
        const r = calcTip({ bill: 100, tipPercent: 0, people: 2, roundUp: true });
        expect(r.roundedUp).toBe(false);
        expect(r.totalPerPerson).toBe(50);
    });

    it('rejects a negative bill or tip percentage', () => {
        expect(calcTip({ bill: -5, tipPercent: 15, people: 1, roundUp: false }).error).toMatch(/bill amount/);
        expect(calcTip({ bill: 50, tipPercent: -1, people: 1, roundUp: false }).error).toMatch(/tip percentage/);
    });

    it('rejects an invalid number of people', () => {
        expect(calcTip({ bill: 50, tipPercent: 15, people: 0, roundUp: false }).error).toMatch(/at least 1 person/);
        expect(calcTip({ bill: 50, tipPercent: 15, people: NaN, roundUp: false }).error).toMatch(/at least 1 person/);
    });

    it('returns null until both the bill and tip percentage are entered', () => {
        expect(calcTip({ bill: null, tipPercent: 15, people: 1, roundUp: false })).toBe(null);
        expect(calcTip({ bill: 50, tipPercent: null, people: 1, roundUp: false })).toBe(null);
    });

    it('handles a bill of 0', () => {
        const r = calcTip({ bill: 0, tipPercent: 20, people: 1, roundUp: false });
        expect(r.tipAmount).toBe(0);
        expect(r.totalAmount).toBe(0);
    });
});
