// Share a page with the system share sheet (phones, Safari, Edge), or copy its link where the
// Web Share API isn't available. Resolves to 'shared', 'copied' or 'cancelled'.
export async function shareLink({ title, url }) {
    if (typeof navigator !== 'undefined' && typeof navigator.share === 'function') {
        try {
            await navigator.share({ title, url });
            return 'shared';
        } catch (error) {
            // The visitor closed the share sheet: that's a choice, not a reason to copy instead.
            if (error?.name === 'AbortError') return 'cancelled';
        }
    }
    try {
        await navigator.clipboard.writeText(url);
        return 'copied';
    } catch {
        // Old browsers or a blocked clipboard: select-and-copy through a temporary field.
        if (typeof document === 'undefined') return 'cancelled';
        const field = document.createElement('textarea');
        field.value = url;
        field.setAttribute('readonly', '');
        field.style.position = 'fixed';
        field.style.opacity = '0';
        document.body.appendChild(field);
        field.select();
        const ok = document.execCommand?.('copy');
        field.remove();
        return ok ? 'copied' : 'cancelled';
    }
}

/** The keyboard shortcut that bookmarks the current page on this device. */
export function bookmarkKeys() {
    const nav = typeof navigator !== 'undefined' ? navigator : {};
    return /Mac|iPhone|iPad/.test(nav.platform || nav.userAgent || '') ? '⌘D' : 'Ctrl+D';
}
