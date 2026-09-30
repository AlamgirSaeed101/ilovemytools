// Reading numbers the way people type them in their own language.
//
// English writes 1,234.5 and German 1.234,5, and people often type the "other"
// style anyway. The rules below accept both without guessing wrong:
//   - both "," and "." present: the last one is the decimal point
//   - one kind only: it is a thousands separator when it groups digits in
//     threes (1,234,567) AND the language uses the other symbol for decimals;
//     otherwise it is the decimal point (1,5 -> 1.5 even on an English page)
import { decimalSeparator } from './i18n.js';

const THOUSANDS = { ',': /^[-+]?\d{1,3}(,\d{3})+$/, '.': /^[-+]?\d{1,3}(\.\d{3})+$/ };

/** Normalise user input to a plain JS number string ("1.234,5" -> "1234.5"), or null. */
export function normalizeNumber(input, decimal = decimalSeparator()) {
    let s = String(input ?? '')
        .trim()
        .replace(/[\s  ']/g, '') // spaces and apostrophes as thousands separators
        .replace(/[−–]/g, '-'); // typographic minus signs
    if (s === '') return null;

    const hasComma = s.includes(',');
    const hasDot = s.includes('.');
    if (hasComma && hasDot) {
        const dec = s.lastIndexOf(',') > s.lastIndexOf('.') ? ',' : '.';
        s = s.split(dec === ',' ? '.' : ',').join('').replace(dec, '.');
    } else if (hasComma || hasDot) {
        const sep = hasComma ? ',' : '.';
        const groupsInThrees = THOUSANDS[sep].test(s);
        // "1,234" on an English page is one thousand...; "1,5" is one and a half.
        if (groupsInThrees && sep !== decimal) s = s.split(sep).join('');
        else if ((s.match(new RegExp(`\\${sep}`, 'g')) || []).length === 1) s = s.replace(sep, '.');
        else s = s.split(sep).join(''); // 1.234.567 in a comma-decimal language
    }
    return s;
}

/** Parse a decimal number in either style. Returns null when it is not a number. */
export function parseLocaleNumber(input, decimal) {
    if (typeof input === 'number') return Number.isFinite(input) ? input : null;
    const s = normalizeNumber(input, decimal);
    if (s === null || s === '-' || s === '.' || s === '+') return null;
    if (!/^[-+]?(\d+\.?\d*|\.\d+)(e[-+]?\d+)?$/i.test(s)) return null;
    const n = Number(s);
    return Number.isFinite(n) ? n : null;
}

/** Parse a whole number ("1,000" or "1.000" or "1 000"). Returns NaN when it is not one. */
export function parseLocaleInteger(input, decimal) {
    const n = parseLocaleNumber(input, decimal);
    return n !== null && Number.isSafeInteger(n) ? n : NaN;
}
