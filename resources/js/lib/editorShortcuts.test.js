import { describe, expect, it, vi } from 'vitest';
import { dispatchShortcut, isTypingTarget, matchShortcut } from './editorShortcuts.js';

const key = (k, mods = {}) => ({ key: k, ctrlKey: false, metaKey: false, shiftKey: false, altKey: false, ...mods });

describe('matchShortcut', () => {
    it('undo and redo with Ctrl or Cmd', () => {
        expect(matchShortcut(key('z', { ctrlKey: true }))).toEqual({ action: 'undo' });
        expect(matchShortcut(key('z', { metaKey: true }))).toEqual({ action: 'undo' });
        expect(matchShortcut(key('Z', { ctrlKey: true, shiftKey: true }))).toEqual({ action: 'redo' });
        expect(matchShortcut(key('y', { ctrlKey: true }))).toEqual({ action: 'redo' });
    });

    it('copy, paste and duplicate', () => {
        expect(matchShortcut(key('c', { ctrlKey: true }))).toEqual({ action: 'copy' });
        expect(matchShortcut(key('v', { metaKey: true }))).toEqual({ action: 'paste' });
        expect(matchShortcut(key('d', { ctrlKey: true }))).toEqual({ action: 'duplicate' });
        expect(matchShortcut(key('c', { ctrlKey: true, shiftKey: true }))).toBeNull();
    });

    it('delete, backspace and escape', () => {
        expect(matchShortcut(key('Delete'))).toEqual({ action: 'delete' });
        expect(matchShortcut(key('Backspace'))).toEqual({ action: 'delete' });
        expect(matchShortcut(key('Escape'))).toEqual({ action: 'escape' });
    });

    it('arrow keys nudge by 1px, or 10px with Shift', () => {
        expect(matchShortcut(key('ArrowLeft'))).toEqual({ action: 'nudge', dx: -1, dy: 0 });
        expect(matchShortcut(key('ArrowDown'))).toEqual({ action: 'nudge', dx: 0, dy: 1 });
        expect(matchShortcut(key('ArrowUp', { shiftKey: true }))).toEqual({ action: 'nudge', dx: 0, dy: -10 });
        expect(matchShortcut(key('ArrowRight', { shiftKey: true }))).toEqual({ action: 'nudge', dx: 10, dy: 0 });
    });

    it('zoom with + and -, but leaves Ctrl +/- to the browser', () => {
        expect(matchShortcut(key('+'))).toEqual({ action: 'zoomIn' });
        expect(matchShortcut(key('='))).toEqual({ action: 'zoomIn' });
        expect(matchShortcut(key('-'))).toEqual({ action: 'zoomOut' });
        expect(matchShortcut(key('+', { ctrlKey: true }))).toBeNull();
        expect(matchShortcut(key('-', { metaKey: true }))).toBeNull();
    });

    it('page up and page down', () => {
        expect(matchShortcut(key('PageUp'))).toEqual({ action: 'prevPage' });
        expect(matchShortcut(key('PageDown'))).toEqual({ action: 'nextPage' });
    });

    it('ignores Alt combinations, plain letters and empty events', () => {
        expect(matchShortcut(key('z', { ctrlKey: true, altKey: true }))).toBeNull();
        expect(matchShortcut(key('a'))).toBeNull();
        expect(matchShortcut(key('a', { ctrlKey: true }))).toBeNull();
        expect(matchShortcut(null)).toBeNull();
        expect(matchShortcut({})).toBeNull();
    });
});

describe('isTypingTarget', () => {
    it('is true for inputs, textareas, selects and editable content', () => {
        expect(isTypingTarget({ tagName: 'INPUT' })).toBe(true);
        expect(isTypingTarget({ tagName: 'textarea' })).toBe(true);
        expect(isTypingTarget({ tagName: 'SELECT' })).toBe(true);
        expect(isTypingTarget({ tagName: 'DIV', isContentEditable: true })).toBe(true);
    });

    it('is false for buttons, the page and missing targets', () => {
        expect(isTypingTarget({ tagName: 'BUTTON' })).toBe(false);
        expect(isTypingTarget({ tagName: 'BODY' })).toBe(false);
        expect(isTypingTarget(null)).toBe(false);
    });
});

describe('dispatchShortcut', () => {
    const event = (k, mods = {}, target = { tagName: 'BODY' }) => ({ ...key(k, mods), target, defaultPrevented: false, preventDefault: vi.fn() });

    it('calls the handler and prevents the browser default', () => {
        const undo = vi.fn();
        const e = event('z', { ctrlKey: true });
        expect(dispatchShortcut(e, { undo })).toBe(true);
        expect(undo).toHaveBeenCalledWith({ action: 'undo' }, e);
        expect(e.preventDefault).toHaveBeenCalled();
    });

    it('does nothing while typing in a field', () => {
        const remove = vi.fn();
        const e = event('Backspace', {}, { tagName: 'INPUT' });
        expect(dispatchShortcut(e, { delete: remove })).toBe(false);
        expect(remove).not.toHaveBeenCalled();
        expect(e.preventDefault).not.toHaveBeenCalled();
    });

    it('keeps the browser default when the handler returns false', () => {
        const e = event('c', { ctrlKey: true });
        expect(dispatchShortcut(e, { copy: () => false })).toBe(false);
        expect(e.preventDefault).not.toHaveBeenCalled();
    });

    it('ignores shortcuts with no handler', () => {
        const e = event('PageDown');
        expect(dispatchShortcut(e, {})).toBe(false);
        expect(e.preventDefault).not.toHaveBeenCalled();
    });
});
