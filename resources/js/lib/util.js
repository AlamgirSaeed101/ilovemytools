import { formatNumber } from './i18n.js';
// Small shared helpers used by several tools.

export function formatBytes(bytes) {
    if (!Number.isFinite(bytes) || bytes < 0) return '—';
    if (bytes < 1024) return `${formatNumber(bytes)} B`;
    const units = ['KB', 'MB', 'GB'];
    let value = bytes / 1024;
    let unit = 0;
    while (value >= 1024 && unit < units.length - 1) {
        value /= 1024;
        unit++;
    }
    const digits = value >= 100 ? 0 : value >= 10 ? 1 : 2;
    return `${formatNumber(Number(value.toFixed(digits)), { minimumFractionDigits: digits, maximumFractionDigits: digits })} ${units[unit]}`;
}

export function downloadBlob(blob, filename) {
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = filename;
    a.rel = 'noopener';
    a.style.display = 'none';
    document.body.appendChild(a);
    a.click();
    a.remove();
    // Give the browser time to start the download before freeing memory.
    setTimeout(() => URL.revokeObjectURL(url), 30000);
}

export function downloadText(text, filename, type = 'text/plain') {
    downloadBlob(new Blob([text], { type: `${type};charset=utf-8` }), filename);
}

export async function copyToClipboard(text) {
    try {
        if (navigator.clipboard && window.isSecureContext) {
            await navigator.clipboard.writeText(text);
            return true;
        }
    } catch {
        // fall through to the legacy method
    }
    const ta = document.createElement('textarea');
    ta.value = text;
    ta.setAttribute('readonly', '');
    ta.style.position = 'fixed';
    ta.style.opacity = '0';
    document.body.appendChild(ta);
    ta.select();
    let ok = false;
    try {
        ok = document.execCommand('copy');
    } catch {
        ok = false;
    }
    ta.remove();
    return ok;
}

/** "My Photo.final.PNG" -> "My Photo.final" */
export function baseName(filename) {
    const i = filename.lastIndexOf('.');
    return i > 0 ? filename.slice(0, i) : filename;
}

/** Make a filename safe for all operating systems. */
export function safeFilename(name) {
    return name.replace(/[\\/:*?"<>|\u0000-\u001f]+/g, '_').trim() || 'file';
}

/** Give duplicate names in a ZIP a (2), (3) suffix instead of overwriting. */
export function uniqueNamer() {
    const used = new Map();
    return (name) => {
        const count = used.get(name) || 0;
        used.set(name, count + 1);
        if (count === 0) return name;
        const i = name.lastIndexOf('.');
        return i > 0 ? `${name.slice(0, i)} (${count + 1})${name.slice(i)}` : `${name} (${count + 1})`;
    };
}
