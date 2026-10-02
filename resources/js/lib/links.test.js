import { describe, expect, it } from 'vitest';
import { chunk, classifyLink, toCsv } from './links.js';

describe('link results', () => {
    it('classifies statuses', () => {
        expect(classifyLink({ status: 200 })).toBe('ok');
        expect(classifyLink({ status: 200, redirects: 2 })).toBe('redirect');
        expect(classifyLink({ status: 404 })).toBe('broken');
        expect(classifyLink({ status: 500 })).toBe('broken');
        expect(classifyLink({ status: 403 })).toBe('blocked');
        expect(classifyLink({ status: 429 })).toBe('blocked');
        expect(classifyLink({ status: null, error: 'dns' })).toBe('broken');
        expect(classifyLink({ status: null, error: 'unreachable' })).toBe('error');
    });

    it('chunks lists', () => {
        expect(chunk([1, 2, 3, 4, 5], 2)).toEqual([[1, 2], [3, 4], [5]]);
    });

    it('writes CSV with quoting', () => {
        expect(toCsv([['a', 'b,c'], ['say "hi"', 1]])).toBe('a,"b,c"\n"say ""hi""",1');
    });
});
