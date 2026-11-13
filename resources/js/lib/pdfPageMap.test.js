import { PDFDocument, PDFName, StandardFonts, degrees } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import {
    applyPageMap,
    deletePage,
    duplicatePage,
    entrySize,
    followPage,
    initialPageMap,
    insertBlank,
    insertPages,
    isPageMapChanged,
    movePage,
    remapElements,
    rotatePage,
} from './pdfPageOps.js';
import { isSideways, pointerToPage, stageTransform, viewSize } from './pdfPageView.js';

const sources = (map) => map.map((e) => (e.blank ? 'blank' : e.from != null ? `${e.from}${e.source}` : e.source));

describe('page map operations', () => {
    it('starts as the original pages in order, unchanged', () => {
        expect(initialPageMap(3)).toEqual([
            { id: 0, source: 0, rotation: 0 },
            { id: 1, source: 1, rotation: 0 },
            { id: 2, source: 2, rotation: 0 },
        ]);
        expect(isPageMapChanged(initialPageMap(3), 3)).toBe(false);
        expect(isPageMapChanged(null, 3)).toBe(false);
    });

    it('moves, deletes, rotates, duplicates and inserts pages without mutating the map', () => {
        const map = initialPageMap(3);
        const frozen = JSON.stringify(map);
        expect(sources(movePage(map, 0, 2))).toEqual([1, 2, 0]);
        expect(sources(movePage(map, 2, 0))).toEqual([2, 0, 1]);
        expect(movePage(map, 0, 5)).toBe(map);
        expect(sources(deletePage(map, 1))).toEqual([0, 2]);
        expect(deletePage(initialPageMap(1), 0)).toHaveLength(1); // always keeps a page
        expect(rotatePage(map, 1, 90)[1].rotation).toBe(90);
        expect(rotatePage(map, 1, -90)[1].rotation).toBe(270);
        expect(rotatePage(rotatePage(map, 1, 90), 1, -90)[1].rotation).toBe(0);
        expect(sources(duplicatePage(map, 0))).toEqual([0, 0, 1, 2]);
        expect(sources(insertBlank(map, 1, [100, 200]))).toEqual([0, 'blank', 1, 2]);
        expect(insertBlank(map, 3, [100, 200])[3]).toMatchObject({ blank: true, size: [100, 200] });
        expect(sources(insertPages(map, 1, 'x1', 2))).toEqual([0, 'x10', 'x11', 1, 2]);
        expect(JSON.stringify(map)).toBe(frozen);
    });

    it('gives every new page a unique id', () => {
        let map = initialPageMap(2);
        map = duplicatePage(map, 0);
        map = insertBlank(map, 0);
        map = insertPages(map, 0, 'x1', 2);
        const ids = map.map((e) => e.id);
        expect(new Set(ids).size).toBe(ids.length);
    });

    it('detects every kind of change', () => {
        const map = initialPageMap(3);
        expect(isPageMapChanged(movePage(map, 0, 1), 3)).toBe(true);
        expect(isPageMapChanged(rotatePage(map, 0, 90), 3)).toBe(true);
        expect(isPageMapChanged(deletePage(map, 0), 3)).toBe(true);
        expect(isPageMapChanged(insertBlank(map, 0), 3)).toBe(true);
        expect(isPageMapChanged(duplicatePage(map, 0), 3)).toBe(true);
        expect(isPageMapChanged(insertPages(map, 0, 'x1', 1), 3)).toBe(true);
    });

    it('follows the page on screen to its new position, or its neighbour when it is deleted', () => {
        const map = initialPageMap(3);
        expect(followPage(map, movePage(map, 0, 2), 0)).toBe(2);
        expect(followPage(map, insertBlank(map, 0), 1)).toBe(2);
        expect(followPage(map, deletePage(map, 2), 2)).toBe(1);
        expect(followPage(map, deletePage(map, 0), 0)).toBe(0);
    });
});

describe('remapElements', () => {
    const elements = [
        { id: 1, page: 0, type: 'text' },
        { id: 2, page: 1, type: 'shape' },
        { id: 3, page: 2, type: 'image' },
    ];

    it('keeps elements on their page when pages are reordered', () => {
        const map = initialPageMap(3);
        const moved = movePage(map, 0, 2); // pages 1, 2, 0
        expect(remapElements(elements, map, moved)).toEqual([
            { id: 1, page: 2, type: 'text' },
            { id: 2, page: 0, type: 'shape' },
            { id: 3, page: 1, type: 'image' },
        ]);
    });

    it('drops the elements of a deleted page and shifts the later ones', () => {
        const map = initialPageMap(3);
        expect(remapElements(elements, map, deletePage(map, 1))).toEqual([
            { id: 1, page: 0, type: 'text' },
            { id: 3, page: 1, type: 'image' },
        ]);
    });

    it('shifts elements past an inserted page, and leaves untouched elements as the same objects', () => {
        const map = initialPageMap(3);
        const result = remapElements(elements, map, insertBlank(map, 1));
        expect(result.map((el) => el.page)).toEqual([0, 2, 3]);
        expect(result[0]).toBe(elements[0]);
        expect(remapElements(elements, map, insertPages(map, 0, 'x1', 2)).map((el) => el.page)).toEqual([2, 3, 4]);
    });

    it('is unchanged by rotation', () => {
        const map = initialPageMap(3);
        expect(remapElements(elements, map, rotatePage(map, 1, 90))).toEqual(elements);
    });

    it('copies a duplicated page’s elements with fresh ids when asked to', () => {
        const map = initialPageMap(3);
        const dup = duplicatePage(map, 1); // 0, 1, 1', 2
        let id = 100;
        const result = remapElements(elements, map, dup, { nextId: () => id++ });
        expect(result).toEqual([
            { id: 1, page: 0, type: 'text' },
            { id: 2, page: 1, type: 'shape' },
            { id: 3, page: 3, type: 'image' },
            { id: 100, page: 2, type: 'shape' },
        ]);
        // Without an id source, the copy starts empty.
        expect(remapElements(elements, map, dup)).toHaveLength(3);
        // A later change does not copy them again.
        const later = movePage(dup, 3, 0);
        expect(remapElements(result, dup, later, { nextId: () => id++ })).toHaveLength(4);
    });

    it('keeps a link to a page pointing at that page when pages move, are deleted or duplicated', () => {
        const map = initialPageMap(3);
        const link = { id: 5, page: 0, type: 'link', pageTarget: 2 };
        // Page 3 moves to the front: the link (still on page 1, now 2nd) goes to position 0.
        expect(remapElements([link], map, movePage(map, 2, 0))).toEqual([{ ...link, page: 1, pageTarget: 0 }]);
        // Its target is deleted: it points at the nearest page that is left.
        expect(remapElements([link], map, deletePage(map, 2))[0].pageTarget).toBe(1);
        // A link without a page target is left alone.
        const web = { id: 6, page: 0, type: 'link', url: 'https://example.com', pageTarget: null };
        expect(remapElements([web], map, movePage(map, 2, 0))).toEqual([{ ...web, page: 1 }]);
        // The copy on a duplicated page points at the same page.
        let id = 50;
        const out = remapElements([link], map, duplicatePage(map, 0), { nextId: () => id++ });
        expect(out.map((el) => [el.page, el.pageTarget])).toEqual([[0, 3], [1, 3]]);
    });

    it('gives new form fields copied to a duplicated page names of their own', () => {
        const map = initialPageMap(2);
        const fields = [
            { id: 1, page: 0, type: 'formfield', kind: 'text', name: 'Text field 1' },
            { id: 2, page: 0, type: 'formfield', kind: 'radio', name: 'Group', exportValue: 'A' },
            { id: 3, page: 0, type: 'formfield', kind: 'radio', name: 'Group', exportValue: 'B' },
            { id: 4, page: 1, type: 'formfield', kind: 'text', name: 'Text field 1 copy' },
            { id: 5, page: 0, type: 'formfield', kind: 'checkmark' },
        ];
        let id = 100;
        const copies = remapElements(fields, map, duplicatePage(map, 0), { nextId: () => id++ }).filter((el) => el.id >= 100);
        expect(copies.map((el) => el.name)).toEqual(['Text field 1 copy 2', 'Group copy', 'Group copy', undefined]);
        expect(copies.every((el) => el.page === 1)).toBe(true);
    });

    it('drops elements whose page is out of range', () => {
        expect(remapElements([{ id: 9, page: 7 }], initialPageMap(2), initialPageMap(2))).toEqual([]);
    });
});

async function numberedPdf(sizes, label = 'P') {
    const doc = await PDFDocument.create();
    const font = await doc.embedFont(StandardFonts.Helvetica);
    sizes.forEach(([w, h], i) => doc.addPage([w, h]).drawText(`${label}${i + 1}`, { x: 10, y: 10, size: 12, font }));
    return doc;
}

describe('entrySize', () => {
    it('reads the size of a page, an inserted page and a blank page', async () => {
        const main = await numberedPdf([[300, 400]]);
        const other = await numberedPdf([[500, 600]]);
        expect(entrySize({ source: 0 }, { main })).toEqual({ width: 300, height: 400 });
        expect(entrySize({ source: 0, from: 'x1' }, { main, x1: other })).toEqual({ width: 500, height: 600 });
        expect(entrySize({ blank: true, size: [10, 20] }, { main })).toEqual({ width: 10, height: 20 });
    });
});

describe('applyPageMap', () => {
    it('returns the same document when nothing changed', async () => {
        const doc = await numberedPdf([[300, 300], [400, 400]]);
        expect(await applyPageMap(doc, initialPageMap(2))).toBe(doc);
        expect(await applyPageMap(doc, null)).toBe(doc);
    });

    it('builds the pages in map order, with rotation, blanks, duplicates and an inserted PDF', async () => {
        const doc = await numberedPdf([[300, 300], [400, 400], [500, 500]]);
        doc.getPage(2).setRotation(degrees(90));
        const other = await numberedPdf([[111, 222], [333, 444]], 'Q');
        let map = initialPageMap(3);
        map = movePage(map, 0, 2); // 2, 3, 1
        map = deletePage(map, 0); // 3, 1
        map = rotatePage(map, 0, 90); // page 3: 90 + 90
        map = rotatePage(map, 1, -90); // page 1: 270
        map = insertBlank(map, 1, [200, 100]); // 3, blank, 1
        map = duplicatePage(map, 2); // 3, blank, 1, 1
        map = insertPages(map, 4, 'x1', 2); // 3, blank, 1, 1, Q1, Q2

        const out = await applyPageMap(doc, map, { extraDocs: { x1: other } });
        expect(out).not.toBe(doc);
        expect(out.getPageCount()).toBe(6);
        expect(out.getPages().map((p) => p.getWidth())).toEqual([500, 200, 300, 300, 111, 333]);
        expect(out.getPages().map((p) => p.getRotation().angle)).toEqual([180, 0, 270, 270, 0, 0]);
        // The original document is left as it was.
        expect(doc.getPageCount()).toBe(3);
        expect(doc.getPage(0).getRotation().angle).toBe(0);

        // It saves and reloads as a valid PDF with the same pages and /Rotate values.
        const reloaded = await PDFDocument.load(await out.save());
        expect(reloaded.getPageCount()).toBe(6);
        expect(reloaded.getPages().map((p) => p.getRotation().angle)).toEqual([180, 0, 270, 270, 0, 0]);
    });

    it('gives a duplicated page its own content stream', async () => {
        const doc = await numberedPdf([[300, 300]]);
        const out = await applyPageMap(doc, duplicatePage(initialPageMap(1), 0));
        const [a, b] = out.getPages();
        const contents = (page) => String(page.node.get(PDFName.of('Contents')));
        expect(contents(a)).not.toBe(contents(b));
    });

    it('keeps the form fields of pages that stay and drops those of a deleted page', async () => {
        const doc = await PDFDocument.create();
        const form = doc.getForm();
        for (const name of ['first', 'second', 'third']) {
            const page = doc.addPage([300, 300]);
            form.createTextField(name).addToPage(page, { x: 20, y: 20, width: 120, height: 24 });
        }
        form.getTextField('second').setText('kept');
        const out = await applyPageMap(doc, deletePage(movePage(initialPageMap(3), 2, 0), 1));
        const reloaded = await PDFDocument.load(await out.save());
        const names = reloaded.getForm().getFields().map((f) => f.getName()).sort();
        expect(names).toEqual(['second', 'third']);
        expect(reloaded.getForm().getTextField('second').getText()).toBe('kept');
        // Flattening needs every widget to be on a page.
        reloaded.getForm().flatten();
        expect(reloaded.getPageCount()).toBe(2);
    });

    it('makes the form fields of a duplicated page real fields of their own', async () => {
        const doc = await PDFDocument.create();
        const form = doc.getForm();
        const page = doc.addPage([300, 300]);
        form.createTextField('name').addToPage(page, { x: 20, y: 20, width: 120, height: 24 });
        form.getTextField('name').setText('Ada');
        const group = form.createRadioGroup('choice');
        group.addOptionToPage('yes', page, { x: 20, y: 60, width: 14, height: 14 });
        group.addOptionToPage('no', page, { x: 50, y: 60, width: 14, height: 14 });
        const out = await applyPageMap(doc, duplicatePage(initialPageMap(1), 0));
        const reloaded = await PDFDocument.load(await out.save());
        const fields = reloaded.getForm();
        expect(fields.getFields().map((f) => f.getName()).sort()).toEqual(['choice', 'choice copy', 'name', 'name copy']);
        expect(fields.getTextField('name copy').getText()).toBe('Ada');
        expect(fields.getRadioGroup('choice copy').getOptions().sort()).toEqual(['no', 'yes']);
        // The copy is filled on its own, and flattening reaches it.
        fields.getTextField('name copy').setText('Grace');
        expect(fields.getTextField('name').getText()).toBe('Ada');
        fields.flatten();
        expect(fields.getFields()).toHaveLength(0);
        // Every widget, the copies' too, was flattened away (pdf-lib leaves the emptied /Annots entries behind).
        const widgets = reloaded.getPages().flatMap((p) => (p.node.Annots()?.asArray() ?? []).map((ref) => reloaded.context.lookup(ref)).filter(Boolean));
        expect(widgets).toEqual([]);
    });

    it('leaves nothing of a deleted page inside the saved file', async () => {
        const doc = await PDFDocument.create();
        const font = await doc.embedFont(StandardFonts.Helvetica);
        const keep = doc.addPage([300, 300]);
        keep.drawText('KEEPME', { x: 10, y: 10, size: 12, font });
        const secret = doc.addPage([300, 300]);
        const { PDFString } = await import('pdf-lib');
        // A marker only the deleted page holds (its /Contents stream is compressed, so check a plain object too).
        secret.node.set(PDFName.of('SecretMarker'), PDFString.of('TOPSECRET'));
        secret.drawText('TOPSECRET', { x: 10, y: 10, size: 12, font });
        // A link on the kept page pointing at the deleted page must not keep it alive.
        const dest = doc.context.obj([secret.ref, PDFName.of('Fit')]);
        keep.node.addAnnot(doc.context.register(doc.context.obj({ Type: 'Annot', Subtype: 'Link', Rect: [0, 0, 10, 10], Dest: dest })));
        const before = await doc.save({ useObjectStreams: false });
        expect(Buffer.from(before).toString('latin1')).toContain('TOPSECRET');

        const out = await applyPageMap(doc, deletePage(initialPageMap(2), 1));
        const bytes = await out.save({ useObjectStreams: false });
        expect(Buffer.from(bytes).toString('latin1')).not.toContain('TOPSECRET');
        expect(bytes.length).toBeLessThan(before.length);
        const reloaded = await PDFDocument.load(bytes);
        expect(reloaded.getPageCount()).toBe(1);
    });

    it('fails clearly when an inserted PDF is missing', async () => {
        const doc = await numberedPdf([[300, 300]]);
        await expect(applyPageMap(doc, insertPages(initialPageMap(1), 0, 'gone', 1))).rejects.toThrow(/no longer available/);
    });
});

describe('page view helpers', () => {
    it('swaps width and height for a sideways page', () => {
        expect(isSideways(90)).toBe(true);
        expect(isSideways(-90)).toBe(true);
        expect(isSideways(180)).toBe(false);
        expect(viewSize(100, 200, 90, 2)).toEqual({ width: 400, height: 200 });
        expect(viewSize(100, 200, 180, 1)).toEqual({ width: 100, height: 200 });
    });

    it('only transforms when zoomed or rotated', () => {
        expect(stageTransform(100, 200, 0, 1)).toBeUndefined();
        expect(stageTransform(100, 200, 0, 1.5)).toBe('scale(1.5)');
        expect(stageTransform(100, 200, 90, 1)).toBe('translate(100px, 50px) rotate(90deg) scale(1) translate(-50px, -100px)');
    });

    const natural = { width: 100, height: 200 };

    it('maps a pointer like before when the page is not rotated', () => {
        const rect = { left: 10, top: 20, width: 50, height: 100 }; // zoom 0.5
        expect(pointerToPage(10, 20, rect, natural)).toEqual({ x: 0, y: 0 });
        expect(pointerToPage(60, 120, rect, natural)).toEqual({ x: 100, y: 200 });
        expect(pointerToPage(35, 70, rect, natural)).toEqual({ x: 50, y: 100 });
    });

    it('maps the corners of a rotated page back to the page’s own corners', () => {
        // Rotated 90° clockwise: the page's top-left corner is now the box's top-right corner.
        const rect = { left: 0, top: 0, width: 200, height: 100 };
        const near = (p, x, y) => {
            expect(p.x).toBeCloseTo(x);
            expect(p.y).toBeCloseTo(y);
        };
        near(pointerToPage(200, 0, rect, natural, 90), 0, 0);
        near(pointerToPage(0, 0, rect, natural, 90), 0, 200);
        near(pointerToPage(0, 100, rect, natural, 270), 0, 0);
        near(pointerToPage(100, 200, { left: 0, top: 0, width: 100, height: 200 }, natural, 180), 0, 0);
        // And at 2x zoom.
        near(pointerToPage(400, 0, { left: 0, top: 0, width: 400, height: 200 }, natural, 90), 0, 0);
    });
});
