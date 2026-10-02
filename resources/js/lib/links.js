// Broken Link Checker: turn a server check result into a category the page can show.

/** @returns {'ok'|'redirect'|'broken'|'blocked'|'error'} */
export function classifyLink({ status, redirects = 0, error }) {
    if (error === 'dns') return 'broken';
    if (error) return 'error';
    if (status >= 200 && status < 300) return redirects > 0 ? 'redirect' : 'ok';
    if (status === 401 || status === 403 || status === 429) return 'blocked';
    if (status >= 400) return 'broken';
    return 'error';
}

/** Split a list into chunks of `size`. */
export function chunk(list, size) {
    const out = [];
    for (let i = 0; i < list.length; i += size) out.push(list.slice(i, i + size));
    return out;
}

/** CSV with a header row; values are quoted when needed. */
export function toCsv(rows) {
    const cell = (v) => {
        const s = String(v ?? '');
        return /[",\n]/.test(s) ? `"${s.replace(/"/g, '""')}"` : s;
    };
    return rows.map((r) => r.map(cell).join(',')).join('\n');
}
