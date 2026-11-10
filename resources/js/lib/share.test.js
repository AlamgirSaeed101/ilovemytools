import { afterEach, describe, expect, it, vi } from 'vitest';
import { bookmarkKeys, shareLink } from './share.js';

afterEach(() => {
    vi.unstubAllGlobals();
});

describe('shareLink', () => {
    it('uses the Web Share API when the browser has it', async () => {
        const share = vi.fn().mockResolvedValue(undefined);
        vi.stubGlobal('navigator', { share, clipboard: { writeText: vi.fn() } });
        await expect(shareLink({ title: 'Merge PDF', url: 'https://example.com/merge-pdf' })).resolves.toBe('shared');
        expect(share).toHaveBeenCalledWith({ title: 'Merge PDF', url: 'https://example.com/merge-pdf' });
    });

    it('does not copy when the visitor closes the share sheet', async () => {
        const writeText = vi.fn();
        const abort = Object.assign(new Error('closed'), { name: 'AbortError' });
        vi.stubGlobal('navigator', { share: vi.fn().mockRejectedValue(abort), clipboard: { writeText } });
        await expect(shareLink({ title: 'a', url: 'https://example.com/a' })).resolves.toBe('cancelled');
        expect(writeText).not.toHaveBeenCalled();
    });

    it('copies the link when there is no share sheet', async () => {
        const writeText = vi.fn().mockResolvedValue(undefined);
        vi.stubGlobal('navigator', { clipboard: { writeText } });
        await expect(shareLink({ title: 'a', url: 'https://example.com/a' })).resolves.toBe('copied');
        expect(writeText).toHaveBeenCalledWith('https://example.com/a');
    });
});

describe('bookmarkKeys', () => {
    it('names the right shortcut for the platform', () => {
        vi.stubGlobal('navigator', { platform: 'MacIntel' });
        expect(bookmarkKeys()).toBe('⌘D');
        vi.stubGlobal('navigator', { platform: 'Win32' });
        expect(bookmarkKeys()).toBe('Ctrl+D');
    });
});
