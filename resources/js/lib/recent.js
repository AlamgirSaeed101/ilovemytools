// "Recently used" tools, remembered per browser. Storage can be unavailable
// (private mode, blocked site data), so every access is guarded.

const KEY = 'recent-tools';
const MAX = 6;

export function getRecent() {
    try {
        const list = JSON.parse(localStorage.getItem(KEY) || '[]');
        return Array.isArray(list) ? list.filter((s) => typeof s === 'string') : [];
    } catch {
        return [];
    }
}

export function addRecent(slug) {
    try {
        const next = [slug, ...getRecent().filter((s) => s !== slug)].slice(0, MAX);
        localStorage.setItem(KEY, JSON.stringify(next));
    } catch {
        // storage unavailable: nothing to remember
    }
}
