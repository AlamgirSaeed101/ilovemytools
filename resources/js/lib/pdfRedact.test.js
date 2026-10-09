import { describe, expect, it } from 'vitest';
import { pagesWithBoxes } from './pdfRedact.js';

describe('pagesWithBoxes', () => {
    it('returns the sorted, de-duplicated page indexes that have a box', () => {
        expect(pagesWithBoxes([{ page: 2 }, { page: 0 }, { page: 2 }, { page: 1 }])).toEqual([0, 1, 2]);
    });

    it('returns an empty list when there are no boxes', () => {
        expect(pagesWithBoxes([])).toEqual([]);
    });
});
