import { numberLocale, t } from './i18n.js';
// Sleep Calculator maths. Times are minutes since midnight (0-1439); results wrap
// around midnight. A full sleep cycle lasts about 90 minutes, and waking at the
// end of a cycle (not in deep sleep) is what makes you feel rested.

export const CYCLE_MINUTES = 90;
export const DAY = 1440;
export const DEFAULT_FALL_ASLEEP = 15;

const wrap = (m) => ((Math.round(m) % DAY) + DAY) % DAY;

/** "07:30" -> 450. Returns null for anything that is not a valid 24-hour time. */
export function parseTime(value) {
    const m = /^(\d{1,2}):(\d{2})$/.exec(String(value || '').trim());
    if (!m) return null;
    const h = Number(m[1]);
    const min = Number(m[2]);
    if (h > 23 || min > 59) return null;
    return h * 60 + min;
}

/** 450 -> "07:30" (the value format of <input type="time">). */
export function toInputTime(minutes) {
    const m = wrap(minutes);
    return `${String(Math.floor(m / 60)).padStart(2, '0')}:${String(m % 60).padStart(2, '0')}`;
}

/** 1350 -> "10:30 PM" (12-hour) or "22:30" (24-hour). */
export function formatClock(minutes, hour12 = true) {
    const m = wrap(minutes);
    const h = Math.floor(m / 60);
    const mm = String(m % 60).padStart(2, '0');
    if (!hour12) return `${String(h).padStart(2, '0')}:${mm}`;
    // 12-hour times in the page's language ("9:45 PM", "9:45 م", "下午9:45").
    try {
        return new Intl.DateTimeFormat(numberLocale(), { hour: 'numeric', minute: '2-digit', hourCycle: 'h12', timeZone: 'UTC' })
            .format(Date.UTC(2000, 0, 1, h, m % 60))
            .replace(/[\u202f\u00a0]/g, ' ');
    } catch {
        return `${h % 12 || 12}:${mm} ${h < 12 ? 'AM' : 'PM'}`;
    }
}

/** 450 -> "7 h 30 min" */
export function formatSleep(minutes) {
    const h = Math.floor(minutes / 60);
    const m = Math.round(minutes % 60);
    if (h === 0) return t('{m} min', { m });
    return m ? t('{h} h {m} min', { h, m }) : t('{h} h', { h });
}

/** Times to go to bed to wake up at `wake`, best first (6, 5, 4, 3 cycles). */
export function bedtimesFor(wake, { fallAsleep = DEFAULT_FALL_ASLEEP, cycles = [6, 5, 4, 3] } = {}) {
    return cycles.map((n) => ({
        cycles: n,
        sleep: n * CYCLE_MINUTES,
        time: wrap(wake - fallAsleep - n * CYCLE_MINUTES),
    }));
}

/** Times to wake up after going to bed at `bed` (3 to 6 cycles, earliest first). */
export function wakeTimesFor(bed, { fallAsleep = DEFAULT_FALL_ASLEEP, cycles = [3, 4, 5, 6] } = {}) {
    return cycles.map((n) => ({
        cycles: n,
        sleep: n * CYCLE_MINUTES,
        time: wrap(bed + fallAsleep + n * CYCLE_MINUTES),
    }));
}

/**
 * How long you slept between two clock times (crossing midnight is fine).
 * Returns null when both times are the same.
 */
export function sleepDuration(bed, wake, { fallAsleep = 0 } = {}) {
    const inBed = wrap(wake - bed);
    if (inBed === 0) return null;
    const asleep = Math.max(0, inBed - fallAsleep);
    return {
        inBed,
        asleep,
        cycles: Math.floor(asleep / CYCLE_MINUTES),
        intoCycle: asleep % CYCLE_MINUTES,
        rating: rateSleep(asleep),
    };
}

/** Adult guidance (7-9 hours, from sleep health organisations). */
export function rateSleep(minutes) {
    if (minutes < 6 * 60) return { level: 'low', label: t('Too little sleep'), advice: t('Adults need 7-9 hours. Under 6 hours regularly affects mood, focus and health.') };
    if (minutes < 7 * 60) return { level: 'short', label: t('A bit short'), advice: t('Close, but most adults feel best with at least 7 hours.') };
    if (minutes <= 9 * 60) return { level: 'good', label: t('Healthy amount'), advice: t('Right in the recommended 7-9 hours for adults.') };
    return { level: 'long', label: t('More than usual'), advice: t('Over 9 hours is fine now and then, for example when recovering from illness or lost sleep.') };
}
