// Google Analytics 4 events for real tool use (page views alone can't show whether a tool helped).
// Sends nothing when GA isn't loaded (no measurement ID, blocked, or in tests), and never sends
// file names, text or URLs the visitor typed: only the tool's slug and the file type.

/** Tool slug from the current path: "/es/merge-pdf" -> "merge-pdf"; "home" for the home page. */
export function toolFromPath(pathname = typeof location !== 'undefined' ? location.pathname : '/') {
    const parts = pathname.split('/').filter(Boolean);
    if (parts.length && /^[a-z]{2}$/.test(parts[0])) parts.shift(); // language prefix
    return parts.length ? parts.join('/') : 'home';
}

export function track(name, params = {}) {
    try {
        if (typeof window === 'undefined' || typeof window.gtag !== 'function') return;
        window.gtag('event', name, { tool: toolFromPath(), ...params });
    } catch {
        // Analytics must never break a tool.
    }
}

/** "photo-no-bg.png" -> "png" */
export function fileType(filename) {
    return /\.([a-z0-9]{1,5})$/i.exec(String(filename || ''))?.[1]?.toLowerCase() || 'other';
}
