import { t } from './i18n.js';
// JSON formatting / validation with helpful error positions.

export function lineColumnAt(text, index) {
    let line = 1;
    let column = 1;
    for (let i = 0; i < index && i < text.length; i++) {
        if (text[i] === '\n') {
            line++;
            column = 1;
        } else {
            column++;
        }
    }
    return { line, column };
}

function errorPosition(message, text) {
    // V8 (Chrome, Edge, Node): "... at position 42 (line 3 column 5)" or "at position 42"
    const lineCol = /line (\d+) column (\d+)/i.exec(message);
    if (lineCol) return { line: Number(lineCol[1]), column: Number(lineCol[2]) };
    const pos = /position (\d+)/i.exec(message);
    if (pos) return lineColumnAt(text, Number(pos[1]));
    // Firefox: "JSON.parse: ... at line 3 column 5 of the JSON data"
    const ff = /at line (\d+) column (\d+)/i.exec(message);
    if (ff) return { line: Number(ff[1]), column: Number(ff[2]) };
    if (/unexpected end/i.test(message)) return lineColumnAt(text, text.length);
    return null;
}

function friendlyHint(text, pos) {
    if (!pos) return '';
    const lines = text.split('\n');
    const lineText = lines[pos.line - 1] ?? '';
    const before = lineText.slice(0, Math.max(0, pos.column - 1));
    const at = lineText.slice(Math.max(0, pos.column - 1)).trimStart();
    const prevNonSpace = (lines.slice(0, pos.line - 1).join('\n') + '\n' + before).trimEnd().slice(-1);

    if ((at.startsWith('}') || at.startsWith(']')) && prevNonSpace === ',') return t('Remove the trailing comma before this bracket.');
    if (at.startsWith("'") || before.trimEnd().endsWith("'")) return t('JSON strings and keys must use double quotes ("), not single quotes.');
    if (/^[A-Za-z_$]/.test(at) && !/^(true|false|null)\b/.test(at)) return t('Keys and text values must be wrapped in double quotes.');
    if (at.startsWith('/')) return t('Comments are not allowed in JSON.');
    return '';
}

export function parseJson(text) {
    if (text.trim() === '') return { ok: false, error: t('Please paste some JSON first.'), position: null };
    try {
        return { ok: true, value: JSON.parse(text) };
    } catch (e) {
        const message = String(e && e.message ? e.message : e);
        const position = errorPosition(message, text);
        const hint = friendlyHint(text, position);
        const cleaned = message.replace(/^JSON\.parse: /, '').replace(/\s*\(line \d+ column \d+\)/i, '');
        return {
            ok: false,
            // The browser's own parser message ("Unexpected token...") is shown as-is.
            error: `${t('Invalid JSON: {message}', { message: cleaned })}${position ? ` ${t('(line {line}, column {column})', position)}` : ''}${hint ? `. ${hint}` : ''}`,
            position,
        };
    }
}

export function sortKeysDeep(value) {
    if (Array.isArray(value)) return value.map(sortKeysDeep);
    if (value && typeof value === 'object') {
        return Object.keys(value)
            .sort((a, b) => a.localeCompare(b))
            .reduce((acc, key) => {
                acc[key] = sortKeysDeep(value[key]);
                return acc;
            }, {});
    }
    return value;
}

export function formatJson(text, { indent = 2, sortKeys = false, minify = false } = {}) {
    const parsed = parseJson(text);
    if (!parsed.ok) return parsed;
    const value = sortKeys ? sortKeysDeep(parsed.value) : parsed.value;
    const space = minify ? undefined : indent === 'tab' ? '\t' : Number(indent);
    return { ok: true, output: JSON.stringify(value, null, space) };
}

export const SAMPLE_JSON = '{"name":"ilovemytools","tools":["Word Counter","JSON Formatter","QR Code Generator"],"free":true,"version":1.2,"owner":{"country":"UK","since":2026},"tags":null}';
