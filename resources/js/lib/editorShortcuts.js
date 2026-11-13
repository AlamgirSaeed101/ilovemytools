// Keyboard shortcuts for the PDF editor.
// matchShortcut() is pure (a KeyboardEvent-like object in, an action out) so it can be unit tested;
// useEditorShortcuts() listens on the window and calls the matching handler.
import { useEffect, useRef } from 'react';

export const NUDGE = 1;
export const NUDGE_BIG = 10;

const ARROWS = {
    ArrowLeft: [-1, 0],
    ArrowRight: [1, 0],
    ArrowUp: [0, -1],
    ArrowDown: [0, 1],
};

/**
 * Which editor action a key press means, or null.
 * Returns { action } or, for arrows, { action: 'nudge', dx, dy }.
 * Actions: undo, redo, delete, escape, nudge, copy, paste, duplicate, zoomIn, zoomOut, prevPage, nextPage.
 */
export function matchShortcut(e) {
    if (!e || !e.key || e.altKey) return null;
    const mod = Boolean(e.ctrlKey || e.metaKey);
    const key = e.key.length === 1 ? e.key.toLowerCase() : e.key;

    if (mod) {
        if (key === 'z') return { action: e.shiftKey ? 'redo' : 'undo' };
        if (key === 'y' && !e.shiftKey) return { action: 'redo' };
        if (e.shiftKey) return null;
        if (key === 'c') return { action: 'copy' };
        if (key === 'v') return { action: 'paste' };
        if (key === 'd') return { action: 'duplicate' };
        // Ctrl/Cmd with +/- stays the browser's own page zoom.
        return null;
    }

    if (key === 'Delete' || key === 'Backspace') return { action: 'delete' };
    if (key === 'Escape') return { action: 'escape' };
    if (ARROWS[key]) {
        const step = e.shiftKey ? NUDGE_BIG : NUDGE;
        return { action: 'nudge', dx: ARROWS[key][0] * step, dy: ARROWS[key][1] * step };
    }
    if (key === '+' || key === '=') return { action: 'zoomIn' };
    if (key === '-' || key === '_') return { action: 'zoomOut' };
    if (key === 'PageUp') return { action: 'prevPage' };
    if (key === 'PageDown') return { action: 'nextPage' };
    return null;
}

/** True while the user is typing somewhere a key press belongs to the field, not to the editor. */
export function isTypingTarget(target) {
    if (!target || typeof target !== 'object') return false;
    if (target.isContentEditable) return true;
    const tag = String(target.tagName || '').toUpperCase();
    return tag === 'INPUT' || tag === 'TEXTAREA' || tag === 'SELECT';
}

/**
 * Runs a shortcut through `handlers` ({ undo, redo, delete, ... }).
 * A handler returning false means "nothing to do here", so the browser's default action is kept
 * (for example Ctrl+C copies selected page text when no element is selected).
 * Returns true when the event was handled.
 */
export function dispatchShortcut(e, handlers) {
    if (e.defaultPrevented || e.isComposing || isTypingTarget(e.target)) return false;
    const match = matchShortcut(e);
    if (!match) return false;
    const handler = handlers?.[match.action];
    if (typeof handler !== 'function') return false;
    if (handler(match, e) === false) return false;
    e.preventDefault();
    return true;
}

/** Listens for editor shortcuts on the window while `enabled`; `handlers` may change on every render. */
export function useEditorShortcuts(handlers, { enabled = true } = {}) {
    const ref = useRef(handlers);
    ref.current = handlers;
    useEffect(() => {
        if (!enabled) return undefined;
        const onKeyDown = (e) => dispatchShortcut(e, ref.current);
        window.addEventListener('keydown', onKeyDown);
        return () => window.removeEventListener('keydown', onKeyDown);
    }, [enabled]);
}
