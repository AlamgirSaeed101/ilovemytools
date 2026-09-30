import { t } from './i18n.js';
// Text utilities: word counting, keyword density and case conversion.
// Pure functions (no DOM) so they can be unit tested.

const WORD_RE = /[\p{L}\p{N}]/u;

// Scripts written without spaces between words (Chinese, Japanese, Thai...).
const NO_SPACE_SCRIPT = /[\p{Script=Han}\p{Script=Hiragana}\p{Script=Katakana}\p{Script=Thai}\p{Script=Lao}\p{Script=Khmer}\p{Script=Myanmar}]/u;

export function splitWords(text) {
    // The browser's dictionary-based word segmentation handles these scripts;
    // everything else keeps the simple, predictable whitespace rule below.
    if (NO_SPACE_SCRIPT.test(text) && typeof Intl !== 'undefined' && typeof Intl.Segmenter === 'function') {
        return Array.from(new Intl.Segmenter(undefined, { granularity: 'word' }).segment(text))
            .filter((s) => s.isWordLike)
            .map((s) => s.segment);
    }
    return text
        .split(/\s+/u)
        .map((token) => token.replace(/^[^\p{L}\p{N}]+|[^\p{L}\p{N}]+$/gu, ''))
        .filter((token) => WORD_RE.test(token));
}

function countGraphemes(text) {
    if (typeof Intl !== 'undefined' && typeof Intl.Segmenter === 'function') {
        let count = 0;
        // eslint-disable-next-line no-unused-vars
        for (const _ of new Intl.Segmenter(undefined, { granularity: 'grapheme' }).segment(text)) count++;
        return count;
    }
    return Array.from(text).length;
}

export function textStats(text) {
    const words = splitWords(text);
    const trimmed = text.trim();

    const sentences = trimmed === ''
        ? 0
        : trimmed.split(/[.!?…]+(?=\s|$)/u).filter((s) => WORD_RE.test(s)).length;

    const paragraphs = trimmed === ''
        ? 0
        : trimmed.split(/\n\s*\n/u).filter((p) => WORD_RE.test(p)).length;

    const lines = text === '' ? 0 : text.split(/\r\n|\r|\n/).length;

    return {
        words: words.length,
        characters: countGraphemes(text),
        charactersNoSpaces: countGraphemes(text.replace(/\s/gu, '')),
        sentences,
        paragraphs,
        lines,
        readingSeconds: Math.ceil((words.length / 238) * 60),
        speakingSeconds: Math.ceil((words.length / 150) * 60),
    };
}

export function formatDuration(totalSeconds) {
    if (totalSeconds <= 0) return t('{s} sec', { s: 0 });
    if (totalSeconds < 60) return t('{s} sec', { s: totalSeconds });
    const minutes = Math.floor(totalSeconds / 60);
    const seconds = totalSeconds % 60;
    if (minutes < 60) return seconds ? t('{m} min {s} sec', { m: minutes, s: seconds }) : t('{m} min', { m: minutes });
    const hours = Math.floor(minutes / 60);
    const mins = minutes % 60;
    return mins ? t('{h} hr {m} min', { h: hours, m: mins }) : t('{h} hr', { h: hours });
}

const STOP_WORDS = new Set(
    ('a about above after again against all am an and any are as at be because been before being below between both but by ' +
        'can did do does doing down during each few for from further had has have having he her here hers herself him himself his how ' +
        'i if in into is it its itself just me more most my myself no nor not now of off on once only or other our ours ourselves out ' +
        'over own same she should so some such than that the their theirs them themselves then there these they this those through to too ' +
        'under until up very was we were what when where which while who whom why will with you your yours yourself yourselves ' +
        'also may might must would could shall can’t don’t it’s i’m')
        .split(' ')
        .flatMap((w) => [w, w.replace(/’/g, "'")]),
);

export function keywordDensity(text, limit = 10) {
    const words = splitWords(text).map((w) => w.toLocaleLowerCase());
    const total = words.length;
    if (total === 0) return [];

    const counts = new Map();
    for (const word of words) {
        if (word.length < 3 || STOP_WORDS.has(word) || /^\d+$/.test(word)) continue;
        counts.set(word, (counts.get(word) || 0) + 1);
    }

    return [...counts.entries()]
        .sort((a, b) => b[1] - a[1] || a[0].localeCompare(b[0]))
        .slice(0, limit)
        .map(([word, count]) => ({ word, count, percent: Math.round((count / total) * 1000) / 10 }));
}

// ---------- Case conversion ----------

const SMALL_WORDS = new Set(['a', 'an', 'the', 'and', 'but', 'or', 'nor', 'for', 'so', 'yet', 'as', 'at', 'by', 'in', 'of', 'off', 'on', 'per', 'to', 'up', 'via', 'vs']);

const capitalize = (word) => {
    const chars = Array.from(word);
    return chars.length ? chars[0].toLocaleUpperCase() + chars.slice(1).join('').toLocaleLowerCase() : word;
};

function titleCase(text) {
    return text
        .split('\n')
        .map((line) => {
            const parts = line.split(/(\s+)/);
            const wordIndexes = parts.map((p, i) => (/\S/.test(p) ? i : -1)).filter((i) => i >= 0);
            const first = wordIndexes[0];
            const last = wordIndexes[wordIndexes.length - 1];
            return parts
                .map((part, i) => {
                    if (!/\S/.test(part)) return part;
                    const lower = part.toLocaleLowerCase();
                    const bare = lower.replace(/[^\p{L}\p{N}']/gu, '');
                    if (i !== first && i !== last && SMALL_WORDS.has(bare)) return lower;
                    // Capitalise each part of hyphenated words: "well-known" -> "Well-Known"
                    return lower.replace(/(^|[-/("'“‘])(\p{L})/gu, (_, sep, ch) => sep + ch.toLocaleUpperCase());
                })
                .join('');
        })
        .join('\n');
}

function sentenceCase(text) {
    const lower = text.toLocaleLowerCase();
    let capitalizeNext = true;
    let out = '';
    for (const ch of lower) {
        if (capitalizeNext && /\p{L}/u.test(ch)) {
            out += ch.toLocaleUpperCase();
            capitalizeNext = false;
        } else {
            out += ch;
        }
        if (/[.!?]/.test(ch) || ch === '\n') capitalizeNext = true;
    }
    // Standalone "i" is always capital in English.
    return out.replace(/(^|[^\p{L}])i(?=[^\p{L}]|$)/gu, '$1I');
}

function toWords(text) {
    return text
        .replace(/([\p{Ll}\p{N}])(\p{Lu})/gu, '$1 $2') // camelCase -> camel Case
        .replace(/(\p{Lu})(\p{Lu}\p{Ll})/gu, '$1 $2') // XMLHttp -> XML Http
        .split(/[^\p{L}\p{N}]+/u)
        .filter(Boolean)
        .map((w) => w.toLocaleLowerCase());
}

function convertLines(text, fn) {
    return text.split('\n').map(fn).join('\n');
}

export const CASES = [
    { id: 'upper', label: 'UPPERCASE' },
    { id: 'lower', label: 'lowercase' },
    { id: 'title', label: 'Title Case' },
    { id: 'sentence', label: 'Sentence case' },
    { id: 'camel', label: 'camelCase' },
    { id: 'pascal', label: 'PascalCase' },
    { id: 'snake', label: 'snake_case' },
    { id: 'kebab', label: 'kebab-case' },
    { id: 'constant', label: 'CONSTANT_CASE' },
    { id: 'alternating', label: 'aLtErNaTiNg' },
    { id: 'inverse', label: 'InVeRsE' },
];

export function convertCase(text, mode) {
    switch (mode) {
        case 'upper':
            return text.toLocaleUpperCase();
        case 'lower':
            return text.toLocaleLowerCase();
        case 'title':
            return titleCase(text);
        case 'sentence':
            return sentenceCase(text);
        case 'camel':
            return convertLines(text, (line) => toWords(line).map((w, i) => (i === 0 ? w : capitalize(w))).join(''));
        case 'pascal':
            return convertLines(text, (line) => toWords(line).map(capitalize).join(''));
        case 'snake':
            return convertLines(text, (line) => toWords(line).join('_'));
        case 'kebab':
            return convertLines(text, (line) => toWords(line).join('-'));
        case 'constant':
            return convertLines(text, (line) => toWords(line).join('_').toLocaleUpperCase());
        case 'alternating': {
            let i = 0;
            return Array.from(text)
                .map((ch) => {
                    if (!/\p{L}/u.test(ch)) return ch;
                    return i++ % 2 === 0 ? ch.toLocaleLowerCase() : ch.toLocaleUpperCase();
                })
                .join('');
        }
        case 'inverse':
            return Array.from(text)
                .map((ch) => (ch === ch.toLocaleUpperCase() ? ch.toLocaleLowerCase() : ch.toLocaleUpperCase()))
                .join('');
        default:
            return text;
    }
}
