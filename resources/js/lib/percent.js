import { formatNumber as formatLocal, t } from './i18n.js';
import { parseLocaleNumber } from './numbers.js';
// Percentage calculations. Every function returns { value, formula } or
// { error } so the UI can show the working, never NaN or Infinity.

/** Accepts 1,234.5 / 1.234,5 / 1,5 and a trailing % (see lib/numbers.js). */
export function parseNumber(input, decimal) {
    if (typeof input === 'number') return Number.isFinite(input) ? input : null;
    return parseLocaleNumber(String(input ?? '').trim().replace(/%$/, ''), decimal);
}

/** Round away floating point noise (0.1 + 0.2) and show up to 6 decimals. */
export function formatNumber(n, maxDecimals = 6) {
    if (!Number.isFinite(n)) return '—';
    const rounded = Number(n.toFixed(maxDecimals));
    const normalized = Object.is(rounded, -0) ? 0 : rounded;
    return formatLocal(normalized, { maximumFractionDigits: maxDecimals });
}

const fmt = (n) => formatNumber(n);

function needNumbers(...values) {
    return values.every((v) => v !== null);
}

// What is X% of Y?
export function percentOf(x, y) {
    if (!needNumbers(x, y)) return null;
    const value = (x / 100) * y;
    return { value, text: fmt(value), formula: `${fmt(x)}% × ${fmt(y)} = ${fmt(x)} / 100 × ${fmt(y)} = ${fmt(value)}` };
}

// X is what percent of Y?
export function whatPercent(x, y) {
    if (!needNumbers(x, y)) return null;
    if (y === 0) return { error: t('The second number cannot be 0 (division by zero).') };
    const value = (x / y) * 100;
    return { value, text: `${fmt(value)}%`, formula: `${fmt(x)} / ${fmt(y)} × 100 = ${fmt(value)}%` };
}

// Percentage change from A to B
export function percentChange(from, to) {
    if (!needNumbers(from, to)) return null;
    if (from === 0) return { error: t('The starting value cannot be 0 - percentage change from 0 is undefined.') };
    const value = ((to - from) / Math.abs(from)) * 100;
    const pct = fmt(Math.abs(value));
    const label = value === 0 ? t('0% (no change)') : value > 0 ? t('{value}% increase', { value: pct }) : t('{value}% decrease', { value: pct });
    return { value, text: label, formula: `(${fmt(to)} − ${fmt(from)}) / |${fmt(from)}| × 100 = ${fmt(value)}%` };
}

// X is Y% of what?
export function wholeFromPart(part, percent) {
    if (!needNumbers(part, percent)) return null;
    if (percent === 0) return { error: t('The percentage cannot be 0 (division by zero).') };
    const value = part / (percent / 100);
    return { value, text: fmt(value), formula: `${fmt(part)} / (${fmt(percent)} / 100) = ${fmt(value)}` };
}

// Increase or decrease Y by X%
export function applyPercent(value, percent, mode = 'increase') {
    if (!needNumbers(value, percent)) return null;
    const factor = mode === 'increase' ? 1 + percent / 100 : 1 - percent / 100;
    const result = value * factor;
    const sign = mode === 'increase' ? '+' : '−';
    return {
        value: result,
        text: fmt(result),
        formula: `${fmt(value)} × (1 ${sign} ${fmt(percent)} / 100) = ${fmt(result)}`,
        difference: fmt(Math.abs(result - value)),
    };
}
