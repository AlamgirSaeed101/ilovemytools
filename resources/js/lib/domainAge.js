// Pure logic for the Domain Age Checker: turn user input into a bare domain,
// and an RDAP registration date into an exact age (reuses the Age Calculator's
// calendar maths so "16 years, 1 month, 20 days" means the same thing everywhere).
import { calculateAge, todayParts } from './date.js';

/** "https://www.Example.COM/page" -> "example.com"; null when it isn't a domain (mirrors the server-side check). */
export function normalizeDomain(input) {
    let s = String(input ?? '').trim().toLowerCase();
    s = s.replace(/^[a-z][a-z0-9+.-]*:\/\//, '');
    s = s.replace(/[/?#:].*$/, '');
    s = s.replace(/^www\./, '').replace(/\.+$/, '');

    return /^(?=.{3,253}$)([a-z0-9](?:[a-z0-9-]{0,61}[a-z0-9])?\.)+[a-z][a-z0-9-]{1,62}$/.test(s) ? s : null;
}

/** The date part of an RDAP event timestamp ("2003-08-13T04:00:00Z" -> "2003-08-13"); null if missing. */
export function dateOnly(iso) {
    return iso ? String(iso).slice(0, 10) : null;
}

/** An RDAP event timestamp as {y, m, d} in UTC; null if missing or unparseable. */
export function rdapDateParts(iso) {
    const date = dateOnly(iso);
    if (!date) return null;
    const match = /^(\d{4})-(\d{2})-(\d{2})$/.exec(date);
    if (!match) return null;
    return { y: Number(match[1]), m: Number(match[2]), d: Number(match[3]) };
}

/**
 * Exact age (years, months, days) of a domain registered on `created` (an RDAP
 * event timestamp), as of `now`. Null when the date is missing, unparseable or in the future.
 */
export function domainAge(created, now = new Date()) {
    const birth = rdapDateParts(created);
    if (!birth) return null;
    try {
        const { years, months, days } = calculateAge(birth, todayParts(now));
        return { years, months, days };
    } catch {
        return null;
    }
}
