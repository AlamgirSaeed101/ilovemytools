// Time formatting for the Stopwatch and Countdown Timer.

const pad = (n, size = 2) => String(n).padStart(size, '0');

export function splitTime(ms) {
    const total = Math.max(0, Math.floor(ms));
    return {
        h: Math.floor(total / 3600000),
        m: Math.floor((total % 3600000) / 60000),
        s: Math.floor((total % 60000) / 1000),
        cs: Math.floor((total % 1000) / 10),
    };
}

/** Stopwatch display: "01:23.45", or "1:02:03.45" after an hour. Always rounds down. */
export function formatStopwatch(ms) {
    const { h, m, s, cs } = splitTime(ms);
    return h > 0 ? `${h}:${pad(m)}:${pad(s)}.${pad(cs)}` : `${pad(m)}:${pad(s)}.${pad(cs)}`;
}

/** Countdown display: rounds UP to whole seconds, so it shows 00:01 until time is really up. */
export function formatCountdown(ms) {
    const secs = Math.max(0, Math.ceil(ms / 1000));
    const h = Math.floor(secs / 3600);
    const m = Math.floor((secs % 3600) / 60);
    const s = secs % 60;
    return h > 0 ? `${h}:${pad(m)}:${pad(s)}` : `${pad(m)}:${pad(s)}`;
}

export const MAX_TIMER_MS = 99 * 3600000 + 59 * 60000 + 59000;

/** {h, m, s} strings or numbers -> milliseconds (0 when empty/invalid parts). */
export function toMs({ h = 0, m = 0, s = 0 }) {
    const n = (v) => {
        const x = Math.floor(Number(v));
        return Number.isFinite(x) && x > 0 ? x : 0;
    };
    return Math.min(MAX_TIMER_MS, n(h) * 3600000 + n(m) * 60000 + n(s) * 1000);
}

/** Split a millisecond duration into whole {h, m, s} for the timer inputs. */
export function fromMs(ms) {
    const secs = Math.max(0, Math.round(ms / 1000));
    return { h: Math.floor(secs / 3600), m: Math.floor((secs % 3600) / 60), s: secs % 60 };
}

/** Indexes of the fastest and slowest lap (only meaningful with 2+ laps). */
export function lapExtremes(laps) {
    if (laps.length < 2) return { fastest: -1, slowest: -1 };
    let fastest = 0;
    let slowest = 0;
    laps.forEach((lap, i) => {
        if (lap < laps[fastest]) fastest = i;
        if (lap > laps[slowest]) slowest = i;
    });
    return { fastest, slowest };
}
