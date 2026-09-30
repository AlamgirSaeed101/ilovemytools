import { describe, expect, it } from 'vitest';
import { coinStats, flipCoins, parseOptions, randomNumbers, rollDice, segmentAt, wheelRotation } from './random.js';
import { formatCountdown, formatStopwatch, fromMs, lapExtremes, toMs } from './time.js';

// Deterministic "random" source for exact assertions: returns the queued values.
const queue = (...values) => {
    let i = 0;
    return (max) => values[i++ % values.length] % max;
};

describe('rollDice', () => {
    it('rolls values from 1 to sides and totals them', () => {
        expect(rollDice(3, 6, queue(0, 5, 2))).toEqual({ values: [1, 6, 3], total: 10, sides: 6 });
    });

    it('stays in range and covers every face with real randomness', () => {
        const seen = new Set();
        for (let i = 0; i < 300; i++) {
            for (const v of rollDice(10, 20).values) {
                expect(v).toBeGreaterThanOrEqual(1);
                expect(v).toBeLessThanOrEqual(20);
                seen.add(v);
            }
        }
        expect(seen.size).toBe(20);
    });

    it('is roughly uniform (chi-square on 60,000 d6 rolls)', () => {
        const counts = Array(6).fill(0);
        for (let i = 0; i < 6000; i++) rollDice(10, 6).values.forEach((v) => counts[v - 1]++);
        const expected = 60000 / 6;
        const chi = counts.reduce((sum, c) => sum + (c - expected) ** 2 / expected, 0);
        expect(chi).toBeLessThan(20.5); // p ≈ 0.001 for 5 degrees of freedom
    });

    it('rejects bad input', () => {
        expect(() => rollDice(0, 6)).toThrow('between 1 and 10');
        expect(() => rollDice(11, 6)).toThrow();
        expect(() => rollDice(2, 1)).toThrow();
        expect(() => rollDice(1.5, 6)).toThrow();
    });
});

describe('coins', () => {
    it('flips heads and tails', () => {
        expect(flipCoins(4, queue(0, 1, 1, 0))).toEqual(['heads', 'tails', 'tails', 'heads']);
    });

    it('counts totals and the current streak', () => {
        expect(coinStats([])).toEqual({ heads: 0, tails: 0, total: 0, streak: null });
        expect(coinStats(['heads', 'tails', 'tails', 'tails'])).toEqual({ heads: 1, tails: 3, total: 4, streak: { side: 'tails', length: 3 } });
    });
});

describe('randomNumbers', () => {
    it('generates numbers inside an inclusive range, including negatives', () => {
        const values = randomNumbers({ min: -3, max: 3, count: 500 });
        expect(Math.min(...values)).toBe(-3);
        expect(Math.max(...values)).toBe(3);
    });

    it('can pick every number exactly once without duplicates', () => {
        const values = randomNumbers({ min: 1, max: 49, count: 49, unique: true, sort: true });
        expect(values).toEqual(Array.from({ length: 49 }, (_, i) => i + 1));
    });

    it('stays unique over a huge range', () => {
        const values = randomNumbers({ min: 1, max: 1e9, count: 1000, unique: true });
        expect(new Set(values).size).toBe(1000);
    });

    it('explains impossible requests', () => {
        expect(() => randomNumbers({ min: 1, max: 5, count: 6, unique: true })).toThrow('only 5 different numbers');
        expect(() => randomNumbers({ min: 10, max: 1 })).toThrow('less than or equal');
        expect(() => randomNumbers({ min: 1.5, max: 3 })).toThrow('whole numbers');
        expect(() => randomNumbers({ min: 0, max: 2 ** 33 })).toThrow('too large');
    });
});

describe('wheel', () => {
    it('parses one option per line, ignoring blanks', () => {
        expect(parseOptions('  Pizza \n\nSushi\r\n Tacos\n')).toEqual(['Pizza', 'Sushi', 'Tacos']);
    });

    it('lands exactly on the chosen slice, from any starting angle', () => {
        for (const count of [2, 3, 7, 12, 100]) {
            for (let index = 0; index < count; index += Math.ceil(count / 5)) {
                for (const start of [0, 45, 359.5, 1234.5]) {
                    for (const offset of [-0.5, 0, 0.49]) {
                        const r = wheelRotation(start, index, count, { offset });
                        expect(segmentAt(r, count)).toBe(index);
                        expect(r - start).toBeGreaterThan(6 * 360); // always spins forward, several turns
                    }
                }
            }
        }
    });

    it('reads the slice under the pointer', () => {
        expect(segmentAt(0, 4)).toBe(0);
        expect(segmentAt(360 - 100, 4)).toBe(1); // wheel angle 100° is under the pointer
    });
});

describe('time formatting', () => {
    it('formats stopwatch times, rounding down', () => {
        expect(formatStopwatch(0)).toBe('00:00.00');
        expect(formatStopwatch(83456.9)).toBe('01:23.45');
        expect(formatStopwatch(3723456)).toBe('1:02:03.45');
    });

    it('formats countdowns, rounding up to the next whole second', () => {
        expect(formatCountdown(0)).toBe('00:00');
        expect(formatCountdown(1)).toBe('00:01');
        expect(formatCountdown(59001)).toBe('01:00');
        expect(formatCountdown(3600000)).toBe('1:00:00');
    });

    it('converts timer inputs', () => {
        expect(toMs({ h: '1', m: '2', s: '3' })).toBe(3723000);
        expect(toMs({ h: '', m: 'x', s: '-5' })).toBe(0);
        expect(fromMs(3723000)).toEqual({ h: 1, m: 2, s: 3 });
    });

    it('finds the fastest and slowest laps', () => {
        expect(lapExtremes([5000])).toEqual({ fastest: -1, slowest: -1 });
        expect(lapExtremes([5000, 3000, 7000, 4000])).toEqual({ fastest: 1, slowest: 2 });
    });
});
