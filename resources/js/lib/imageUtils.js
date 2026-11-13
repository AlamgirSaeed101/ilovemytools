// Image helpers for the PDF editor: reading a picked or pasted image without re-encoding it when
// the PDF can embed it as is (JPEG stays JPEG, PNG stays PNG), clearing a scanned signature's
// white paper, and working out where a placed image lands on the page. Everything runs locally.
import { bytesToBase64 } from './base64.js';

/** 'jpg', 'png' or null, from the file's first bytes (not its name or MIME type, which can lie). */
export function sniffImageFormat(bytes) {
    if (!bytes || bytes.length < 8) return null;
    if (bytes[0] === 0xff && bytes[1] === 0xd8 && bytes[2] === 0xff) return 'jpg';
    const png = [0x89, 0x50, 0x4e, 0x47, 0x0d, 0x0a, 0x1a, 0x0a];
    if (png.every((b, i) => bytes[i] === b)) return 'png';
    return null;
}

/** Width/height from a PNG's IHDR chunk, or null. */
export function pngSize(bytes) {
    if (sniffImageFormat(bytes) !== 'png' || bytes.length < 24) return null;
    const view = new DataView(bytes.buffer, bytes.byteOffset, bytes.byteLength);
    const width = view.getUint32(16);
    const height = view.getUint32(20);
    return width && height ? { width, height } : null;
}

/** Width/height from a JPEG's start-of-frame marker, or null when none is found. */
export function jpegSize(bytes) {
    if (sniffImageFormat(bytes) !== 'jpg') return null;
    let i = 2;
    while (i + 9 < bytes.length) {
        if (bytes[i] !== 0xff) {
            i += 1;
            continue;
        }
        const marker = bytes[i + 1];
        // Fill bytes and markers without a length (RST0-7, SOI, TEM).
        if (marker === 0xff || marker === 0x01 || marker === 0xd8 || (marker >= 0xd0 && marker <= 0xd7)) {
            i += marker === 0xff ? 1 : 2;
            continue;
        }
        if (marker === 0xd9 || marker === 0xda) return null; // end of image / scan data before any frame
        const length = (bytes[i + 2] << 8) | bytes[i + 3];
        // SOF0-SOF15, except DHT (C4), JPG (C8) and DAC (CC).
        if (marker >= 0xc0 && marker <= 0xcf && marker !== 0xc4 && marker !== 0xc8 && marker !== 0xcc) {
            const height = (bytes[i + 5] << 8) | bytes[i + 6];
            const width = (bytes[i + 7] << 8) | bytes[i + 8];
            return width && height ? { width, height } : null;
        }
        i += 2 + length;
    }
    return null;
}

export function bytesToDataUrl(bytes, mime) {
    return `data:${mime};base64,${bytesToBase64(bytes)}`;
}

function decodeToCanvas(file) {
    return new Promise((resolve, reject) => {
        const img = new Image();
        const url = URL.createObjectURL(file);
        img.onload = () => {
            const canvas = document.createElement('canvas');
            canvas.width = img.naturalWidth;
            canvas.height = img.naturalHeight;
            canvas.getContext('2d').drawImage(img, 0, 0);
            URL.revokeObjectURL(url);
            resolve(canvas);
        };
        img.onerror = () => {
            URL.revokeObjectURL(url);
            reject(new Error('Could not read that image.'));
        };
        img.src = url;
    });
}

/** PNG bytes, data URL and size of a canvas. */
export function canvasToPngImage(canvas) {
    return new Promise((resolve, reject) => {
        canvas.toBlob(async (blob) => {
            if (!blob) {
                reject(new Error('Could not read that image.'));
                return;
            }
            const bytes = new Uint8Array(await blob.arrayBuffer());
            resolve({ bytes, format: 'png', width: canvas.width, height: canvas.height, dataUrl: bytesToDataUrl(bytes, 'image/png') });
        }, 'image/png');
    });
}

/**
 * Reads an image File/Blob into { bytes, format: 'jpg'|'png', width, height, dataUrl }.
 * JPEG and PNG bytes are kept exactly as they are (a photo stays a small JPEG in the PDF);
 * anything else the browser can show (WebP, GIF...) is converted to PNG. `decode` turns a file
 * into a canvas and is only injected by tests.
 */
export async function loadImageFile(file, { decode = decodeToCanvas } = {}) {
    const bytes = new Uint8Array(await file.arrayBuffer());
    const format = sniffImageFormat(bytes);
    const size = format === 'jpg' ? jpegSize(bytes) : format === 'png' ? pngSize(bytes) : null;
    if (format && size) {
        return { bytes, format, ...size, dataUrl: bytesToDataUrl(bytes, format === 'jpg' ? 'image/jpeg' : 'image/png') };
    }
    return canvasToPngImage(await decode(file));
}

/**
 * Makes near-white pixels of RGBA `data` (in place) transparent, so a photographed or scanned
 * signature loses its paper. A pixel whose darkest channel is at or above `threshold` (0-255) goes
 * fully transparent; slightly darker ones fade, which keeps the ink's edges smooth.
 */
export function whiteToTransparentPixels(data, threshold = 225) {
    const feather = 30;
    for (let i = 0; i < data.length; i += 4) {
        const darkest = Math.min(data[i], data[i + 1], data[i + 2]);
        if (darkest >= threshold) data[i + 3] = 0;
        else if (darkest > threshold - feather) data[i + 3] = Math.round((data[i + 3] * (threshold - darkest)) / feather);
    }
    return data;
}

/** Canvas version of whiteToTransparentPixels: clears the canvas's near-white background in place and returns it. */
export function whiteToTransparent(canvas, threshold = 225) {
    const ctx = canvas.getContext('2d');
    const image = ctx.getImageData(0, 0, canvas.width, canvas.height);
    whiteToTransparentPixels(image.data, threshold);
    ctx.putImageData(image, 0, 0);
    return canvas;
}

/** The smallest box around every pixel of RGBA `data` (width x height) that isn't transparent, or null when it is all transparent. */
export function inkBounds(data, width, height) {
    let minX = width;
    let minY = height;
    let maxX = -1;
    let maxY = -1;
    for (let y = 0; y < height; y++) {
        for (let x = 0; x < width; x++) {
            if (data[(y * width + x) * 4 + 3] > 8) {
                if (x < minX) minX = x;
                if (x > maxX) maxX = x;
                if (y < minY) minY = y;
                if (y > maxY) maxY = y;
            }
        }
    }
    if (maxX < 0) return null;
    return { x: minX, y: minY, width: maxX - minX + 1, height: maxY - minY + 1 };
}

/** A new canvas cropped to the canvas's visible ink plus `padding` pixels, or the canvas itself when it is empty. */
export function trimCanvas(canvas, padding = 6) {
    const data = canvas.getContext('2d').getImageData(0, 0, canvas.width, canvas.height).data;
    const box = inkBounds(data, canvas.width, canvas.height);
    if (!box) return canvas;
    const x = Math.max(0, box.x - padding);
    const y = Math.max(0, box.y - padding);
    const width = Math.min(canvas.width, box.x + box.width + padding) - x;
    const height = Math.min(canvas.height, box.y + box.height + padding) - y;
    const out = document.createElement('canvas');
    out.width = width;
    out.height = height;
    out.getContext('2d').drawImage(canvas, x, y, width, height, 0, 0, width, height);
    return out;
}

/**
 * Where an image of `imageWidth` x `imageHeight` lands when placed `targetWidth` wide on a page
 * area of `areaWidth` x `areaHeight` (all in canvas pixels): centred on `center` (the pointer) or
 * on the area's middle, keeping its aspect ratio, shrunk to fit and kept fully on the page.
 */
export function placementRect({ imageWidth, imageHeight, targetWidth, areaWidth, areaHeight, center = null }) {
    const ratio = imageHeight / imageWidth || 0.4;
    let width = Math.min(targetWidth, areaWidth);
    let height = width * ratio;
    if (height > areaHeight) {
        height = areaHeight;
        width = height / ratio;
    }
    const cx = center ? center.x : areaWidth / 2;
    const cy = center ? center.y : areaHeight / 2;
    const x = Math.min(Math.max(0, cx - width / 2), Math.max(0, areaWidth - width));
    const y = Math.min(Math.max(0, cy - height / 2), Math.max(0, areaHeight - height));
    return { x, y, width, height };
}

/** The image File in a paste event's clipboard data, or null. */
export function imageFromClipboard(clipboardData) {
    if (!clipboardData) return null;
    for (const file of Array.from(clipboardData.files ?? [])) {
        if (file.type.startsWith('image/')) return file;
    }
    for (const item of Array.from(clipboardData.items ?? [])) {
        if (item.kind === 'file' && item.type.startsWith('image/')) return item.getAsFile();
    }
    return null;
}
