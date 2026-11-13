import { describe, expect, it } from 'vitest';
import { imageFromClipboard, inkBounds, jpegSize, loadImageFile, placementRect, pngSize, sniffImageFormat, whiteToTransparentPixels } from './imageUtils.js';

/** A minimal JPEG header: SOI, an APP0 segment, then SOF0 with the given size. */
function fakeJpeg(width, height) {
    return new Uint8Array([
        0xff, 0xd8, 0xff, 0xe0, 0x00, 0x06, 0x4a, 0x46, 0x49, 0x46,
        0xff, 0xc0, 0x00, 0x11, 0x08, height >> 8, height & 0xff, width >> 8, width & 0xff, 0x03, 0, 0, 0, 0, 0, 0, 0, 0, 0,
        0xff, 0xd9,
    ]);
}

function fakePng(width, height) {
    const bytes = new Uint8Array(33);
    bytes.set([0x89, 0x50, 0x4e, 0x47, 0x0d, 0x0a, 0x1a, 0x0a, 0, 0, 0, 13, 0x49, 0x48, 0x44, 0x52]);
    const view = new DataView(bytes.buffer);
    view.setUint32(16, width);
    view.setUint32(20, height);
    return bytes;
}

describe('sniffImageFormat', () => {
    it('recognises JPEG and PNG by their bytes', () => {
        expect(sniffImageFormat(fakeJpeg(10, 10))).toBe('jpg');
        expect(sniffImageFormat(fakePng(10, 10))).toBe('png');
        expect(sniffImageFormat(new Uint8Array([0x52, 0x49, 0x46, 0x46, 0, 0, 0, 0, 0x57, 0x45]))).toBe(null);
        expect(sniffImageFormat(new Uint8Array([1]))).toBe(null);
    });
});

describe('image sizes', () => {
    it('reads a JPEG size from its frame header, skipping other segments', () => {
        expect(jpegSize(fakeJpeg(640, 480))).toEqual({ width: 640, height: 480 });
    });
    it('reads a PNG size from IHDR', () => {
        expect(pngSize(fakePng(300, 120))).toEqual({ width: 300, height: 120 });
    });
    it('returns null for the wrong format', () => {
        expect(jpegSize(fakePng(1, 1))).toBe(null);
        expect(pngSize(fakeJpeg(1, 1))).toBe(null);
    });
});

describe('loadImageFile', () => {
    it('keeps a JPEG as JPEG, byte for byte', async () => {
        const bytes = fakeJpeg(800, 600);
        const image = await loadImageFile(new Blob([bytes], { type: 'image/jpeg' }), { decode: () => { throw new Error('should not decode'); } });
        expect(image.format).toBe('jpg');
        expect(image.width).toBe(800);
        expect(image.height).toBe(600);
        expect(Array.from(image.bytes)).toEqual(Array.from(bytes));
        expect(image.dataUrl.startsWith('data:image/jpeg;base64,')).toBe(true);
    });

    it('keeps a PNG as PNG', async () => {
        const image = await loadImageFile(new Blob([fakePng(20, 10)], { type: 'image/png' }));
        expect(image).toMatchObject({ format: 'png', width: 20, height: 10 });
        expect(image.dataUrl.startsWith('data:image/png;base64,')).toBe(true);
    });

    it('converts any other image to PNG through the decoder', async () => {
        const canvas = {
            width: 4,
            height: 2,
            toBlob: (cb) => cb(new Blob([fakePng(4, 2)], { type: 'image/png' })),
        };
        const image = await loadImageFile(new Blob([new Uint8Array([1, 2, 3, 4, 5, 6, 7, 8, 9])], { type: 'image/webp' }), { decode: async () => canvas });
        expect(image).toMatchObject({ format: 'png', width: 4, height: 2 });
    });
});

describe('whiteToTransparentPixels', () => {
    it('clears white paper, keeps dark ink and fades the edge', () => {
        const data = new Uint8ClampedArray([
            255, 255, 255, 255, // white paper
            240, 238, 242, 255, // off-white scan noise
            20, 30, 90, 255, // blue ink
            210, 210, 210, 255, // light grey edge
        ]);
        whiteToTransparentPixels(data, 225);
        expect(data[3]).toBe(0);
        expect(data[7]).toBe(0);
        expect(data[11]).toBe(255);
        expect(data[15]).toBeGreaterThan(0);
        expect(data[15]).toBeLessThan(255);
    });
});

describe('inkBounds', () => {
    it('finds the box around non-transparent pixels', () => {
        const width = 4;
        const height = 3;
        const data = new Uint8ClampedArray(width * height * 4);
        data[(1 * width + 1) * 4 + 3] = 255;
        data[(2 * width + 2) * 4 + 3] = 255;
        expect(inkBounds(data, width, height)).toEqual({ x: 1, y: 1, width: 2, height: 2 });
    });
    it('is null for an empty canvas', () => {
        expect(inkBounds(new Uint8ClampedArray(16), 2, 2)).toBe(null);
    });
});

describe('placementRect', () => {
    it('centres the image on the pointer, keeping its ratio', () => {
        expect(placementRect({ imageWidth: 200, imageHeight: 100, targetWidth: 100, areaWidth: 600, areaHeight: 800, center: { x: 300, y: 400 } })).toEqual({ x: 250, y: 375, width: 100, height: 50 });
    });
    it('centres on the page without a pointer', () => {
        expect(placementRect({ imageWidth: 100, imageHeight: 100, targetWidth: 100, areaWidth: 300, areaHeight: 300 })).toEqual({ x: 100, y: 100, width: 100, height: 100 });
    });
    it('keeps the image on the page near an edge', () => {
        expect(placementRect({ imageWidth: 100, imageHeight: 50, targetWidth: 100, areaWidth: 300, areaHeight: 300, center: { x: 5, y: 299 } })).toEqual({ x: 0, y: 250, width: 100, height: 50 });
    });
    it('shrinks an image taller than the page', () => {
        const r = placementRect({ imageWidth: 100, imageHeight: 1000, targetWidth: 100, areaWidth: 300, areaHeight: 300 });
        expect(r.height).toBe(300);
        expect(r.width).toBeCloseTo(30);
    });
});

describe('imageFromClipboard', () => {
    it('picks the first image file', () => {
        const png = { type: 'image/png', name: 'a.png' };
        expect(imageFromClipboard({ files: [{ type: 'text/plain' }, png], items: [] })).toBe(png);
    });
    it('falls back to clipboard items', () => {
        const file = { type: 'image/jpeg' };
        expect(imageFromClipboard({ files: [], items: [{ kind: 'file', type: 'image/jpeg', getAsFile: () => file }] })).toBe(file);
    });
    it('is null without an image', () => {
        expect(imageFromClipboard({ files: [], items: [{ kind: 'string', type: 'text/plain' }] })).toBe(null);
        expect(imageFromClipboard(null)).toBe(null);
    });
});
