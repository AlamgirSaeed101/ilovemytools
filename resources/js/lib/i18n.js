import { createElement, Fragment } from 'react';

// Interface translations for the React app.
//
// The page's language is fixed for the whole visit (switching language loads
// the page in the new language), so t() is a plain function. Keys are the
// English text itself; a missing translation simply shows the English, so the
// interface can never show a blank or a raw key.
//
//   t('Roll {count} dice', { count: 3 })
//   dictionary value can be a string or plural forms: { one: '...', other: '...' }

let dict = {};
let locale = 'en';
let dir = 'ltr';
let plural = new Intl.PluralRules('en');
let numberTag = 'en';

export function initI18n({ locale: code = 'en', ui = {}, dir: direction = 'ltr' } = {}) {
    locale = code;
    dir = direction;
    dict = ui && typeof ui === 'object' ? ui : {};
    try {
        plural = new Intl.PluralRules(code);
    } catch {
        plural = new Intl.PluralRules('en');
    }
    // Local separators (1.234,5 in German) but Western digits everywhere, which
    // is what people expect for tool results and what they type back in.
    numberTag = `${code}-u-nu-latn`;
    try {
        new Intl.NumberFormat(numberTag).format(1);
    } catch {
        numberTag = 'en';
    }
}

export const getLocale = () => locale;
export const getDir = () => dir;
export const isRtl = () => dir === 'rtl';
export const numberLocale = () => numberTag;

function pick(value, vars) {
    if (value && typeof value === 'object') {
        const count = Number(vars?.count ?? 0);
        let form = 'other';
        try {
            form = plural.select(count);
        } catch {
            // keep "other"
        }
        return value[form] ?? value.other ?? value.one ?? null;
    }
    return typeof value === 'string' && value !== '' ? value : null;
}

/** Translate `key` (the English text), filling {placeholders} from vars. */
export function t(key, vars) {
    const text = pick(dict[key], vars) ?? key;
    return vars ? fill(text, vars) : text;
}

/**
 * English source text with a plural: tn('{count} tool', '{count} tools', n).
 * Translators provide { one, other, few, many... } for the plural key.
 */
export function tn(one, other, count, vars = {}) {
    const all = { count: formatNumber(count), ...vars };
    const entry = dict[other];
    if (entry && typeof entry === 'object') {
        const text = pick(entry, { count });
        if (text) return fill(text, all);
    } else if (typeof entry === 'string' && entry) {
        return fill(entry, all);
    }
    return fill(count === 1 ? one : other, all);
}

function fill(text, vars) {
    let out = text;
    for (const [name, value] of Object.entries(vars)) out = out.split(`{${name}}`).join(String(value));
    return out;
}

const formatters = new Map();

/** Format a number for the current language (Western digits). */
export function formatNumber(n, options = {}) {
    if (!Number.isFinite(n)) return '—';
    const key = JSON.stringify(options);
    if (!formatters.has(key)) formatters.set(key, new Intl.NumberFormat(numberTag, options));
    return formatters.get(key).format(n);
}

/** The decimal separator people type in this language ("." or ","). */
export function decimalSeparator() {
    return formatNumber(1.5).replace(/\d/g, '').charAt(0) || '.';
}

/**
 * Translate text that contains elements (links, bold text):
 *   tr('Email us at {email}.', { email: <a href="...">...</a> })
 * Returns an array of strings and elements, in the order the translation uses.
 */
export function tr(key, parts) {
    const text = pick(dict[key], parts) ?? key;
    return text.split(/(\{[a-zA-Z0-9_]+\})/).map((piece, i) => {
        const name = /^\{([a-zA-Z0-9_]+)\}$/.exec(piece)?.[1];
        if (name && parts && name in parts) {
            return createElement(Fragment, { key: i }, parts[name]);
        }
        return piece === '' ? null : createElement(Fragment, { key: i }, piece);
    });
}
