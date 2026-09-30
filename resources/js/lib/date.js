import { t } from './i18n.js';
// Date helpers for the Age Calculator.
// Dates are handled as plain {y, m, d} calendar values (no time zones),
// so results never shift by a day because of the visitor's time zone.

export function parseDateInput(value) {
    const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec(value || '');
    if (!match) return null;
    const y = Number(match[1]);
    const m = Number(match[2]);
    const d = Number(match[3]);
    if (m < 1 || m > 12 || d < 1 || d > daysInMonth(y, m)) return null;
    return { y, m, d };
}

export function toInputValue({ y, m, d }) {
    return `${String(y).padStart(4, '0')}-${String(m).padStart(2, '0')}-${String(d).padStart(2, '0')}`;
}

export function todayParts(now = new Date()) {
    return { y: now.getFullYear(), m: now.getMonth() + 1, d: now.getDate() };
}

export function isLeapYear(y) {
    return (y % 4 === 0 && y % 100 !== 0) || y % 400 === 0;
}

export function daysInMonth(y, m) {
    return [31, isLeapYear(y) ? 29 : 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][m - 1];
}

/** A UTC Date for a calendar date. setUTCFullYear keeps years 0-99 literal (Date.UTC maps them to 1900-1999). */
function utcDate({ y, m, d }) {
    if (y >= 100) return new Date(Date.UTC(y, m - 1, d)); // fast path for every normal date
    const date = new Date(Date.UTC(2000, m - 1, d));
    date.setUTCFullYear(y, m - 1, d);
    return date;
}

/** Days since 1970-01-01 for a calendar date (UTC based, so no DST issues). */
export function dayNumber(date) {
    return Math.round(utcDate(date).getTime() / 86400000);
}

export function compare(a, b) {
    return dayNumber(a) - dayNumber(b);
}

const WEEKDAYS = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];

export function weekday(date) {
    return WEEKDAYS[utcDate(date).getUTCDay()];
}

/** Birthday in a given year; 29 Feb falls back to 28 Feb in non-leap years. */
export function birthdayInYear(birth, year) {
    const day = Math.min(birth.d, daysInMonth(year, birth.m));
    return { y: year, m: birth.m, d: day };
}

/** The date `addMonths` months after birth, clamped to the end of short months. */
export function monthAnniversary(birth, addMonths) {
    const total = birth.m - 1 + addMonths;
    const y = birth.y + Math.floor(total / 12);
    const m = (total % 12) + 1;
    return { y, m, d: Math.min(birth.d, daysInMonth(y, m)) };
}

/**
 * Exact age between birth and target: complete years, then complete months,
 * then remaining days (the method used on official forms). A month is
 * "complete" once the same day-of-month is reached (or the month's last day
 * if it is shorter, e.g. 31 Jan -> 28/29 Feb).
 */
export function calculateAge(birth, target) {
    if (compare(target, birth) < 0) {
        throw new Error(t('The date of birth must be on or before the "age at" date.'));
    }

    let totalMonths = (target.y - birth.y) * 12 + (target.m - birth.m);
    if (compare(monthAnniversary(birth, totalMonths), target) > 0) totalMonths -= 1;

    const years = Math.floor(totalMonths / 12);
    const months = totalMonths % 12;
    const days = dayNumber(target) - dayNumber(monthAnniversary(birth, totalMonths));

    const totalDays = dayNumber(target) - dayNumber(birth);

    let next = birthdayInYear(birth, target.y);
    if (compare(next, target) < 0) next = birthdayInYear(birth, target.y + 1);
    const daysToBirthday = dayNumber(next) - dayNumber(target);

    return {
        years,
        months,
        days,
        totalMonths,
        totalWeeks: Math.floor(totalDays / 7),
        remainingWeekDays: totalDays % 7,
        totalDays,
        totalHours: totalDays * 24,
        bornOn: weekday(birth),
        nextBirthday: next,
        nextBirthdayWeekday: weekday(next),
        daysToBirthday,
        turningAge: next.y - birth.y,
    };
}
