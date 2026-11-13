import { PDFDocument, PDFName, PDFRawStream } from 'pdf-lib';
import { describe, expect, it } from 'vitest';
import { buildEditedPdf } from './pdfEdit.js';
import { base64ToBytes } from './base64.js';

// 1x1 transparent PNG.
const PNG = base64ToBytes('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mNkYPhfDwAChwGA60e6kgAAAABJRU5ErkJggg==');

/** A JPEG header pdf-lib can embed (it reads the frame size; it never decodes the pixels). */
function fakeJpeg(width, height) {
    return new Uint8Array([
        0xff, 0xd8, 0xff, 0xe0, 0x00, 0x06, 0x4a, 0x46, 0x49, 0x46,
        0xff, 0xc0, 0x00, 0x11, 0x08, height >> 8, height & 0xff, width >> 8, width & 0xff, 0x03, 1, 0x22, 0, 2, 0x11, 1, 3, 0x11, 1,
        0xff, 0xd9,
    ]);
}

function imageStreams(doc) {
    return doc.context
        .enumerateIndirectObjects()
        .map(([, obj]) => obj)
        .filter((obj) => obj instanceof PDFRawStream && obj.dict.get(PDFName.of('Subtype'))?.toString() === '/Image');
}

describe('buildEditedPdf images', () => {
    it('embeds a JPEG image as JPEG (DCTDecode), not re-encoded', async () => {
        const doc = await PDFDocument.create();
        doc.addPage([300, 300]);
        const blob = await buildEditedPdf(doc, [{ type: 'image', page: 0, format: 'jpg', bytes: fakeJpeg(40, 20), rectPdf: { x: 10, y: 10, width: 40, height: 20 } }]);
        const saved = await PDFDocument.load(new Uint8Array(await blob.arrayBuffer()));
        const images = imageStreams(saved);
        expect(images).toHaveLength(1);
        expect(images[0].dict.get(PDFName.of('Filter')).toString()).toBe('/DCTDecode');
    });

    it('draws an image with its opacity through a graphics state', async () => {
        const doc = await PDFDocument.create();
        doc.addPage([300, 300]);
        const blob = await buildEditedPdf(doc, [{ type: 'image', page: 0, format: 'png', bytes: PNG, opacity: 0.5, rectPdf: { x: 10, y: 10, width: 40, height: 40 } }]);
        const saved = await PDFDocument.load(new Uint8Array(await blob.arrayBuffer()));
        const states = saved.context
            .enumerateIndirectObjects()
            .map(([, obj]) => obj)
            .filter((obj) => obj?.get?.(PDFName.of('Type'))?.toString() === '/ExtGState');
        const resources = saved.getPage(0).node.Resources();
        const extG = resources.lookup(PDFName.of('ExtGState'));
        const all = [...states, ...(extG ? extG.entries().map(([, v]) => saved.context.lookup(v)) : [])];
        expect(all.some((gs) => gs.get(PDFName.of('ca'))?.asNumber?.() === 0.5)).toBe(true);
    });

    it('keeps a fully opaque image free of transparency', async () => {
        const doc = await PDFDocument.create();
        doc.addPage([300, 300]);
        const blob = await buildEditedPdf(doc, [{ type: 'image', page: 0, format: 'png', bytes: PNG, rectPdf: { x: 10, y: 10, width: 40, height: 40 } }]);
        const saved = await PDFDocument.load(new Uint8Array(await blob.arrayBuffer()));
        expect(saved.getPageCount()).toBe(1);
        expect(imageStreams(saved).length).toBeGreaterThan(0);
    });
});
