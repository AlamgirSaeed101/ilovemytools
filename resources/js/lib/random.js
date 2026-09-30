import { formatNumber, t } from './i18n.js';
// Fair randomness for the dice, coin, wheel and number tools.
// Uses crypto.getRandomValues (via randomInt) with rejection sampling, so
// every outcome is equally likely - never Math.random().
import { randomInt } from './password.js';

export const DICE_SIDES = [4, 6, 8, 10, 12, 20, 100];
export const MAX_DICE = 10;

function assertInt(value, min, max, message) {
    if (!Number.isInteger(value) || value < min || value > max) throw new RangeError(message);
}

/** Roll `count` dice with `sides` sides. */
export function rollDice(count, sides, rng = randomInt) {
    assertInt(count, 1, MAX_DICE, t('Roll between 1 and {max} dice.', { max: MAX_DICE }));
    assertInt(sides, 2, 1000, t('A die needs between 2 and 1000 sides.'));
    const values = Array.from({ length: count }, () => rng(sides) + 1);
    return { values, total: values.reduce((a, b) => a + b, 0), sides };
}

/** Flip `count` coins: an array of 'heads' | 'tails'. */
export function flipCoins(count = 1, rng = randomInt) {
    assertInt(count, 1, 100, t('Flip between 1 and 100 coins.'));
    return Array.from({ length: count }, () => (rng(2) === 0 ? 'heads' : 'tails'));
}

/** Totals and the current streak for a list of flips (oldest first). */
export function coinStats(flips) {
    const heads = flips.filter((f) => f === 'heads').length;
    let streak = 0;
    for (let i = flips.length - 1; i >= 0 && flips[i] === flips[flips.length - 1]; i--) streak++;
    return { heads, tails: flips.length - heads, total: flips.length, streak: streak ? { side: flips[flips.length - 1], length: streak } : null };
}

export const MAX_NUMBERS = 1000;

/**
 * Random integers between min and max (inclusive).
 * options: { min, max, count, unique, sort }
 */
export function randomNumbers({ min, max, count = 1, unique = false, sort = false }, rng = randomInt) {
    if (!Number.isSafeInteger(min) || !Number.isSafeInteger(max)) throw new RangeError(t('Enter whole numbers for the minimum and maximum.'));
    if (min > max) throw new RangeError(t('The minimum must be less than or equal to the maximum.'));
    assertInt(count, 1, MAX_NUMBERS, t('Generate between 1 and {max} numbers at a time.', { max: formatNumber(MAX_NUMBERS) }));
    const range = max - min + 1;
    if (range > 2 ** 32) throw new RangeError(t('The range is too large. Keep max - min under {limit}.', { limit: formatNumber(2 ** 32) }));
    if (unique && count > range) {
        throw new RangeError(t('There are only {range} different numbers between {min} and {max}, so you cannot pick {count} without duplicates.', { range: formatNumber(range), min, max, count }));
    }

    let values;
    if (!unique) {
        values = Array.from({ length: count }, () => min + rng(range));
    } else if (range <= 20000) {
        // Partial Fisher-Yates shuffle of the whole range: exact and fast.
        const pool = Array.from({ length: range }, (_, i) => min + i);
        for (let i = 0; i < count; i++) {
            const j = i + rng(range - i);
            [pool[i], pool[j]] = [pool[j], pool[i]];
        }
        values = pool.slice(0, count);
    } else {
        const seen = new Set();
        values = [];
        while (values.length < count) {
            const n = min + rng(range);
            if (!seen.has(n)) {
                seen.add(n);
                values.push(n);
            }
        }
    }
    return sort ? values.sort((a, b) => a - b) : values;
}

export const MAX_WHEEL_OPTIONS = 100;

/** One wheel entry per line; blank lines ignored. */
export function parseOptions(text) {
    return String(text || '')
        .split(/\r?\n/)
        .map((line) => line.trim())
        .filter(Boolean)
        .slice(0, MAX_WHEEL_OPTIONS);
}

/**
 * Wheel geometry: slice i covers [i * seg, (i + 1) * seg) degrees clockwise
 * from the pointer at 12 o'clock when the wheel is at rotation 0. Rotating the
 * wheel clockwise by R puts the wheel angle (360 - R) under the pointer.
 */
export function segmentAt(rotation, count) {
    const seg = 360 / count;
    const angle = (((360 - (rotation % 360)) % 360) + 360) % 360;
    return Math.min(count - 1, Math.floor(angle / seg));
}

/**
 * The rotation that lands slice `index` under the pointer after `turns` full
 * spins. `offset` (-0.5..0.5) moves the stop point inside the slice so spins
 * don't always stop dead-centre; it stays clear of the slice edges.
 */
export function wheelRotation(current, index, count, { turns = 6, offset = 0 } = {}) {
    const seg = 360 / count;
    const inside = Math.max(-0.35, Math.min(0.35, offset)) * seg;
    const target = (((360 - (index * seg + seg / 2 + inside)) % 360) + 360) % 360;
    const now = ((current % 360) + 360) % 360;
    let delta = target - now;
    if (delta <= 0) delta += 360;
    return current + turns * 360 + delta;
}

/** Random offset for wheelRotation, from secure randomness. */
export function randomOffset(rng = randomInt) {
    return rng(1001) / 1000 - 0.5;
}
