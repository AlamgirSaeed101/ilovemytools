import { afterEach, describe, expect, it, vi } from 'vitest';
import { fileType, toolFromPath, track } from './analytics.js';

describe('analytics', () => {
    afterEach(() => {
        delete globalThis.window;
    });

    it('reads the tool from the path', () => {
        expect(toolFromPath('/merge-pdf')).toBe('merge-pdf');
        expect(toolFromPath('/es/merge-pdf')).toBe('merge-pdf');
        expect(toolFromPath('/')).toBe('home');
        expect(toolFromPath('/de')).toBe('home');
        expect(toolFromPath('/category/pdf-tools')).toBe('category/pdf-tools');
    });

    it('gets the file type without the name', () => {
        expect(fileType('My holiday photo-no-bg.PNG')).toBe('png');
        expect(fileType('noext')).toBe('other');
    });

    it('sends events only when gtag exists', () => {
        expect(() => track('tool_use')).not.toThrow(); // no window/gtag
        const gtag = vi.fn();
        globalThis.window = { gtag };
        globalThis.location = { pathname: '/fr/word-counter' };
        track('tool_download', { file_type: 'pdf' });
        expect(gtag).toHaveBeenCalledWith('event', 'tool_download', { tool: 'word-counter', file_type: 'pdf' });
        delete globalThis.location;
    });
});
