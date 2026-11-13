import { PDFDocument, PDFName, PDFString } from 'pdf-lib';
import { beforeAll, describe, expect, it } from 'vitest';
import { addLinkAnnot, applyLinkEdits, normalizeRect, readPageLinks, refId } from './pdfLinks.js';
import { buildEditedPdf } from './pdfEdit.js';

// pdf.js takes a few seconds to load the first time, more when the whole suite runs at once.
beforeAll(() => import('pdfjs-dist/legacy/build/pdf.mjs'), 60000);

async function openWithPdfjs(bytes) {
    const pdfjs = await import('pdfjs-dist/legacy/build/pdf.mjs');
    return pdfjs.getDocument({ data: new Uint8Array(bytes) }).promise;
}

/** A 3-page PDF whose first page has a web link, a link to page 3 and a named-destination link to page 2. */
async function sampleBytes() {
    const doc = await PDFDocument.create();
    doc.addPage([400, 400]);
    doc.addPage([400, 400]);
    doc.addPage([400, 400]);
    const page = doc.getPage(0);
    addLinkAnnot(doc, page, { rect: { x: 10, y: 10, width: 100, height: 20 }, url: 'https://example.com/old' });
    addLinkAnnot(doc, page, { rect: { x: 10, y: 50, width: 100, height: 20 }, pageTarget: 2 });
    // A named destination, as many PDFs made by word processors use.
    const names = doc.context.obj({ Names: [PDFString.of('chapter2'), doc.context.obj([doc.getPage(1).ref, PDFName.of('Fit')])] });
    doc.catalog.set(PDFName.of('Names'), doc.context.obj({ Dests: names }));
    const named = doc.context.obj({ Type: 'Annot', Subtype: 'Link', Rect: [10, 90, 110, 110], Dest: PDFString.of('chapter2') });
    page.node.addAnnot(doc.context.register(named));
    return doc.save();
}

describe('pdfLinks helpers', () => {
    it('normalizes a rect given in any corner order', () => {
        expect(normalizeRect([110, 30, 10, 10])).toEqual({ x: 10, y: 10, width: 100, height: 20 });
    });

    it('builds pdf.js style ids', () => {
        expect(refId({ objectNumber: 12, generationNumber: 0 })).toBe('12R');
        expect(refId({ objectNumber: 12, generationNumber: 3 })).toBe('12R3');
    });
});

describe('readPageLinks', () => {
    it('lists web links and links to pages (explicit and named destinations)', async () => {
        const renderDoc = await openWithPdfjs(await sampleBytes());
        const links = await readPageLinks(renderDoc, 1);
        await renderDoc.destroy();
        expect(links).toHaveLength(3);
        expect(links[0]).toMatchObject({ index: 0, kind: 'url', url: 'https://example.com/old', rect: { x: 10, y: 10, width: 100, height: 20 } });
        expect(links[1]).toMatchObject({ index: 1, kind: 'page', pageTarget: 2 });
        expect(links[2]).toMatchObject({ index: 2, kind: 'page', pageTarget: 1 });
        expect(links[0].id).toMatch(/^\d+R/);
    });

    it('is empty for a page without links', async () => {
        const renderDoc = await openWithPdfjs(await sampleBytes());
        expect(await readPageLinks(renderDoc, 2)).toEqual([]);
        await renderDoc.destroy();
    });
});

describe('applyLinkEdits', () => {
    async function editAndRead(makeEdits) {
        const bytes = await sampleBytes();
        const renderDoc = await openWithPdfjs(bytes.slice());
        const links = await readPageLinks(renderDoc, 1);
        await renderDoc.destroy();
        const doc = await PDFDocument.load(bytes);
        const applied = applyLinkEdits(doc, makeEdits(links));
        const out = await openWithPdfjs(await doc.save());
        const after = await readPageLinks(out, 1);
        await out.destroy();
        return { applied, after };
    }
    const editOf = (link, changes) => ({ page: 0, annotId: link.id, annotIndex: link.index, linkRect: link.rect, ...changes });

    it("changes an existing link's address", async () => {
        const { applied, after } = await editAndRead((links) => [editOf(links[0], { url: 'https://ilovemytools.store/' })]);
        expect(applied).toBe(1);
        expect(after[0]).toMatchObject({ kind: 'url', url: 'https://ilovemytools.store/' });
    });

    it('turns a web link into a link to a page of the document', async () => {
        const { after } = await editAndRead((links) => [editOf(links[0], { pageTarget: 1 })]);
        expect(after[0]).toMatchObject({ kind: 'page', pageTarget: 1, url: null });
    });

    it('turns a page link into a web link', async () => {
        const { after } = await editAndRead((links) => [editOf(links[1], { url: 'https://example.org/' })]);
        expect(after[1]).toMatchObject({ kind: 'url', url: 'https://example.org/' });
    });

    it('removes links, several at once, keeping the others', async () => {
        const { applied, after } = await editAndRead((links) => [editOf(links[0], { remove: true }), editOf(links[2], { remove: true })]);
        expect(applied).toBe(2);
        expect(after).toHaveLength(1);
        expect(after[0]).toMatchObject({ kind: 'page', pageTarget: 2 });
    });

    it('finds the link by its index and box when the object id does not match', async () => {
        const { applied, after } = await editAndRead((links) => [editOf(links[1], { annotId: '9999R', url: 'https://example.net/' })]);
        expect(applied).toBe(1);
        expect(after[1]).toMatchObject({ kind: 'url', url: 'https://example.net/' });
    });

    it('skips an edit whose link is gone, and pages without links', async () => {
        const { applied } = await editAndRead(() => [
            { page: 0, annotId: '9999R', annotIndex: 7, linkRect: { x: 0, y: 0, width: 1, height: 1 }, remove: true },
            { page: 1, annotIndex: 0, remove: true },
            { page: 99, annotIndex: 0, remove: true },
        ]);
        expect(applied).toBe(0);
    });
});

describe('links through buildEditedPdf', () => {
    it('adds a link to a page and applies linkedit elements', async () => {
        const bytes = await sampleBytes();
        const renderDoc = await openWithPdfjs(bytes.slice());
        const [first] = await readPageLinks(renderDoc, 1);
        await renderDoc.destroy();
        const doc = await PDFDocument.load(bytes);
        const blob = await buildEditedPdf(doc, [
            { type: 'linkedit', page: 0, annotId: first.id, annotIndex: first.index, linkRect: first.rect, remove: true, rectPdf: first.rect },
            { type: 'link', page: 0, pageTarget: 1, url: null, rectPdf: { x: 200, y: 200, width: 50, height: 20 } },
        ]);
        const out = await openWithPdfjs(await blob.arrayBuffer());
        const links = await readPageLinks(out, 1);
        await out.destroy();
        expect(links.map((l) => l.kind)).toEqual(['page', 'page', 'page']);
        expect(links[2]).toMatchObject({ pageTarget: 1, rect: { x: 200, y: 200, width: 50, height: 20 } });
    });
});
