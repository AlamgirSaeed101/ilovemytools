import { t } from './i18n.js';
// Secure password generation using the Web Crypto API (crypto.getRandomValues).

export const CHARSETS = {
    upper: 'ABCDEFGHIJKLMNOPQRSTUVWXYZ',
    lower: 'abcdefghijklmnopqrstuvwxyz',
    numbers: '0123456789',
    symbols: '!@#$%^&*()-_=+[]{};:,.<>?/~',
};

const SIMILAR = /[il1LoO0I|]/g;

export const MIN_LENGTH = 4;
export const MAX_LENGTH = 128;

function getCrypto() {
    const c = globalThis.crypto;
    if (!c || typeof c.getRandomValues !== 'function') {
        throw new Error(t('Secure random numbers are not available in this browser.'));
    }
    return c;
}

/** Unbiased random integer in [0, max) using rejection sampling. */
export function randomInt(max) {
    if (max <= 0 || max > 2 ** 32) throw new RangeError('max must be between 1 and 2^32');
    const limit = Math.floor(2 ** 32 / max) * max;
    const buf = new Uint32Array(1);
    const c = getCrypto();
    let value;
    do {
        c.getRandomValues(buf);
        value = buf[0];
    } while (value >= limit);
    return value % max;
}

export function buildPools({ upper, lower, numbers, symbols, excludeSimilar }) {
    const selected = { upper, lower, numbers, symbols };
    return Object.entries(selected)
        .filter(([, on]) => on)
        .map(([key]) => (excludeSimilar ? CHARSETS[key].replace(SIMILAR, '') : CHARSETS[key]))
        .filter((pool) => pool.length > 0);
}

export function generatePassword(options) {
    const length = Math.min(MAX_LENGTH, Math.max(MIN_LENGTH, Math.floor(Number(options.length) || 16)));
    const pools = buildPools(options);
    if (pools.length === 0) throw new Error(t('Select at least one character type.'));

    const all = pools.join('');
    // Guarantee at least one character from every selected type...
    const chars = pools.map((pool) => pool[randomInt(pool.length)]);
    // ...then fill the rest from the combined pool.
    while (chars.length < length) chars.push(all[randomInt(all.length)]);

    // Fisher-Yates shuffle so the guaranteed characters are not always first.
    for (let i = chars.length - 1; i > 0; i--) {
        const j = randomInt(i + 1);
        [chars[i], chars[j]] = [chars[j], chars[i]];
    }
    return chars.join('');
}

export function entropyBits(options) {
    const poolSize = buildPools(options).join('').length;
    const length = Math.min(MAX_LENGTH, Math.max(MIN_LENGTH, Math.floor(Number(options.length) || 0)));
    if (poolSize === 0) return 0;
    return Math.round(length * Math.log2(poolSize));
}

export function strength(bits) {
    if (bits >= 100) return { label: t('Excellent'), color: '#047857', percent: 100 };
    if (bits >= 80) return { label: t('Strong'), color: '#16a34a', percent: 80 };
    if (bits >= 60) return { label: t('Good'), color: '#ca8a04', percent: 60 };
    if (bits >= 40) return { label: t('Weak'), color: '#ea580c', percent: 35 };
    return { label: t('Very weak'), color: '#dc2626', percent: 15 };
}
