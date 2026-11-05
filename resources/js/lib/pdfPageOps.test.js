import { PDFDocument } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import {
    applyPageOps,
    defaultPageOps,
    deletePageOp,
    insertBlankPageOp,
    isPageOpsChanged,
    movePageOp,
    remapElementsForPageOps,
    rotatePageOp,
} from './pdfPageOps.js';

describe('defaultPageOps / isPageOpsChanged', () => {
    it('builds one entry per page, unrotated, in order', () => {
        expect(defaultPageOps(3)).toEqual([
            { type: 'page', index: 0, rotate: 0 },
            { type: 'page', index: 1, rotate: 0 },
            { type: 'page', index: 2, rotate: 0 },
        ]);
    });

    it('is unchanged for the default order, and for null (not touched yet)', () => {
        expect(isPageOpsChanged(null, 3)).toBe(false);
        expect(isPageOpsChanged(defaultPageOps(3), 3)).toBe(false);
    });

    it('detects a reorder, a rotation, a deletion and an inserted blank page', () => {
        expect(isPageOpsChanged(movePageOp(defaultPageOps(3), 0, 2), 3)).toBe(true);
        expect(isPageOpsChanged(rotatePageOp(defaultPageOps(3), 0, 90), 3)).toBe(true);
        expect(isPageOpsChanged(deletePageOp(defaultPageOps(3), 1), 3)).toBe(true);
        expect(isPageOpsChanged(insertBlankPageOp(defaultPageOps(3), 0), 3)).toBe(true);
    });

    it('still flags a change when a delete and an insert leave the length unchanged', () => {
        const ops = insertBlankPageOp(deletePageOp(defaultPageOps(3), 1), 0);
        expect(ops).toHaveLength(3);
        expect(isPageOpsChanged(ops, 3)).toBe(true);
    });
});

describe('movePageOp', () => {
    it('moves a page to a later position', () => {
        const moved = movePageOp(defaultPageOps(3), 0, 2);
        expect(moved.map((op) => op.index)).toEqual([1, 2, 0]);
    });

    it('moves a page to an earlier position', () => {
        const moved = movePageOp(defaultPageOps(3), 2, 0);
        expect(moved.map((op) => op.index)).toEqual([2, 0, 1]);
    });

    it('ignores an out-of-range target or a no-op move', () => {
        const ops = defaultPageOps(3);
        expect(movePageOp(ops, 0, -1)).toBe(ops);
        expect(movePageOp(ops, 0, 3)).toBe(ops);
        expect(movePageOp(ops, 1, 1)).toBe(ops);
    });
});

describe('deletePageOp', () => {
    it('removes the page at a position', () => {
        const next = deletePageOp(defaultPageOps(3), 1);
        expect(next.map((op) => op.index)).toEqual([0, 2]);
    });

    it('never removes the last remaining page', () => {
        const ops = [{ type: 'page', index: 0, rotate: 0 }];
        expect(deletePageOp(ops, 0)).toBe(ops);
    });
});

describe('insertBlankPageOp', () => {
    it('inserts a blank page right after the given position', () => {
        const next = insertBlankPageOp(defaultPageOps(2), 0);
        expect(next).toEqual([
            { type: 'page', index: 0, rotate: 0 },
            { type: 'blank' },
            { type: 'page', index: 1, rotate: 0 },
        ]);
    });
});

describe('rotatePageOp', () => {
    it('accumulates rotation on the targeted page only, wrapping at 360', () => {
        let ops = rotatePageOp(defaultPageOps(2), 0, 90);
        ops = rotatePageOp(ops, 0, 90);
        expect(ops[0].rotate).toBe(180);
        expect(ops[1].rotate).toBe(0);
    });

    it('does nothing to a blank page', () => {
        const ops = insertBlankPageOp(defaultPageOps(1), 0);
        expect(rotatePageOp(ops, 1, 90)).toEqual(ops);
    });
});

describe('remapElementsForPageOps', () => {
    it('re-pages elements to their new position and drops elements on a deleted page', () => {
        const ops = deletePageOp(defaultPageOps(3), 0); // original pages 1, 2 survive at positions 0, 1
        const elements = [
            { id: 1, page: 0, type: 'text' },
            { id: 2, page: 1, type: 'text' },
            { id: 3, page: 2, type: 'text' },
        ];
        expect(remapElementsForPageOps(elements, ops)).toEqual([
            { id: 2, page: 0, type: 'text' },
            { id: 3, page: 1, type: 'text' },
        ]);
    });
});

async function docWithPageSizes(sizes) {
    const doc = await PDFDocument.create();
    for (const [width, height] of sizes) doc.addPage([width, height]);
    return doc;
}

describe('applyPageOps', () => {
    it('reorders pages without touching the original document', async () => {
        const doc = await docWithPageSizes([[300, 300], [400, 400], [500, 500]]);
        const ops = movePageOp(defaultPageOps(3), 0, 2);
        const work = await applyPageOps(doc, ops);
        expect(work.getPages().map((p) => p.getWidth())).toEqual([400, 500, 300]);
        expect(doc.getPages().map((p) => p.getWidth())).toEqual([300, 400, 500]);
    });

    it('drops a deleted page', async () => {
        const doc = await docWithPageSizes([[300, 300], [400, 400], [500, 500]]);
        const ops = deletePageOp(defaultPageOps(3), 1);
        const work = await applyPageOps(doc, ops);
        expect(work.getPageCount()).toBe(2);
        expect(work.getPages().map((p) => p.getWidth())).toEqual([300, 500]);
    });

    it('inserts a blank page matching the first page size', async () => {
        const doc = await docWithPageSizes([[300, 600], [400, 400]]);
        const ops = insertBlankPageOp(defaultPageOps(2), 0);
        const work = await applyPageOps(doc, ops);
        expect(work.getPageCount()).toBe(3);
        expect(work.getPages()[1].getSize()).toEqual({ width: 300, height: 600 });
    });

    it('rotates a page absolutely, adding to any rotation it already had', async () => {
        const doc = await docWithPageSizes([[300, 300]]);
        doc.getPage(0).setRotation({ type: 'degrees', angle: 90 });
        const ops = rotatePageOp(defaultPageOps(1), 0, 90);
        const work = await applyPageOps(doc, ops);
        expect(work.getPage(0).getRotation().angle).toBe(180);
    });
});
