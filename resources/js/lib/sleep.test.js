import { describe, expect, it } from 'vitest';
import { bedtimesFor, formatClock, formatSleep, parseTime, sleepDuration, toInputTime, wakeTimesFor } from './sleep.js';

describe('sleep calculator', () => {
    it('parses and formats clock times', () => {
        expect(parseTime('07:30')).toBe(450);
        expect(parseTime('7:05')).toBe(425);
        expect(parseTime('24:00')).toBeNull();
        expect(parseTime('ab')).toBeNull();
        expect(toInputTime(-15)).toBe('23:45');
        expect(formatClock(0)).toBe('12:00 AM');
        expect(formatClock(720)).toBe('12:00 PM');
        expect(formatClock(1350)).toBe('10:30 PM');
        expect(formatClock(1350, false)).toBe('22:30');
        expect(formatSleep(450)).toBe('7 h 30 min');
        expect(formatSleep(540)).toBe('9 h');
        expect(formatSleep(45)).toBe('45 min');
    });

    it('works back from a wake-up time, across midnight', () => {
        const times = bedtimesFor(parseTime('07:00')).map((b) => [b.cycles, formatClock(b.time)]);
        expect(times).toEqual([
            [6, '9:45 PM'],
            [5, '11:15 PM'],
            [4, '12:45 AM'],
            [3, '2:15 AM'],
        ]);
    });

    it('works forward from a bedtime', () => {
        const times = wakeTimesFor(parseTime('22:30'), { fallAsleep: 15 }).map((w) => formatClock(w.time));
        expect(times).toEqual(['3:15 AM', '4:45 AM', '6:15 AM', '7:45 AM']);
        expect(wakeTimesFor(0, { fallAsleep: 0 })[0].time).toBe(270);
    });

    it('measures sleep between two times', () => {
        const d = sleepDuration(parseTime('23:00'), parseTime('07:00'));
        expect(d).toMatchObject({ inBed: 480, asleep: 480, cycles: 5, intoCycle: 30 });
        expect(d.rating.level).toBe('good');
        expect(sleepDuration(parseTime('01:00'), parseTime('06:00')).rating.level).toBe('low');
        expect(sleepDuration(parseTime('23:00'), parseTime('05:30'), { fallAsleep: 15 }).asleep).toBe(375);
        expect(sleepDuration(600, 600)).toBeNull();
    });
});
