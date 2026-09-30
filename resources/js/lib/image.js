import { t } from './i18n.js';
// Browser image processing with the Canvas API (no uploads, no libraries).

export const IMAGE_TYPES = ['image/jpeg', 'image/png', 'image/webp'];
export const EXTENSIONS = { 'image/jpeg': 'jpg', 'image/png': 'png', 'image/webp': 'webp' };
export const MAX_SIDE = 10000;
export const MAX_FILE_BYTES = 50 * 1024 * 1024;

const TYPE_BY_EXTENSION = { jpg: 'image/jpeg', jpeg: 'image/jpeg', jfif: 'image/jpeg', png: 'image/png', webp: 'image/webp', gif: 'image/gif', bmp: 'image/bmp' };

/** The file's image MIME type, falling back to its extension when the browser reports none. */
export function imageTypeOf(file) {
    if (file.type) return file.type;
    const ext = /\.([a-z0-9]+)$/i.exec(file.name || '')?.[1]?.toLowerCase();
    return TYPE_BY_EXTENSION[ext] || '';
}

export function loadImage(file) {
    return new Promise((resolve, reject) => {
        const url = URL.createObjectURL(file);
        const img = new Image();
        img.decoding = 'async';
        img.onload = () => {
            if (!img.naturalWidth || !img.naturalHeight) {
                URL.revokeObjectURL(url);
                reject(new Error(t('"{name}" could not be read as an image.', { name: file.name })));
                return;
            }
            resolve({ img, url, width: img.naturalWidth, height: img.naturalHeight });
        };
        img.onerror = () => {
            URL.revokeObjectURL(url);
            reject(new Error(t('"{name}" could not be opened. It may be damaged or in an unsupported format.', { name: file.name })));
        };
        img.src = url;
    });
}

function canvasToBlob(canvas, type, quality) {
    return new Promise((resolve, reject) => {
        canvas.toBlob(
            (blob) => (blob ? resolve(blob) : reject(new Error(t('Your browser could not create this image. Try smaller dimensions.')))),
            type,
            quality,
        );
    });
}

function makeCanvas(width, height) {
    const canvas = document.createElement('canvas');
    canvas.width = width;
    canvas.height = height;
    const ctx = canvas.getContext('2d');
    if (!ctx) throw new Error(t('Your browser does not support image processing (Canvas).'));
    ctx.imageSmoothingEnabled = true;
    ctx.imageSmoothingQuality = 'high';
    return { canvas, ctx };
}

/**
 * Draw an image at a new size. Big reductions are done in halving steps,
 * which gives noticeably sharper results than one big jump.
 */
export function drawScaled(img, width, height, { background } = {}) {
    let source = img;
    let sw = img.naturalWidth || img.width;
    let sh = img.naturalHeight || img.height;

    while (sw / 2 > width && sh / 2 > height) {
        const next = makeCanvas(Math.max(width, Math.round(sw / 2)), Math.max(height, Math.round(sh / 2)));
        next.ctx.drawImage(source, 0, 0, next.canvas.width, next.canvas.height);
        source = next.canvas;
        sw = next.canvas.width;
        sh = next.canvas.height;
    }

    const { canvas, ctx } = makeCanvas(width, height);
    if (background) {
        ctx.fillStyle = background;
        ctx.fillRect(0, 0, width, height);
    }
    ctx.drawImage(source, 0, 0, width, height);
    return canvas;
}

let webpSupport;
/** Safari before v17 silently returns PNG when asked for WebP. */
export async function supportsWebpEncoding() {
    if (webpSupport !== undefined) return webpSupport;
    try {
        const { canvas } = makeCanvas(2, 2);
        const blob = await canvasToBlob(canvas, 'image/webp', 0.8);
        webpSupport = blob.type === 'image/webp';
    } catch {
        webpSupport = false;
    }
    return webpSupport;
}

export async function resolveOutputType(requested, inputType) {
    let type = requested === 'same' ? inputType : requested;
    if (!IMAGE_TYPES.includes(type)) type = 'image/jpeg';
    if (type === 'image/webp' && !(await supportsWebpEncoding())) {
        return { type: 'image/jpeg', note: t('Your browser cannot save WebP, so JPG was used instead.') };
    }
    return { type, note: '' };
}

export async function renderImage(img, width, height, type, quality) {
    // JPG has no transparency - fill with white instead of black.
    const canvas = drawScaled(img, width, height, { background: type === 'image/jpeg' ? '#ffffff' : undefined });
    const blob = await canvasToBlob(canvas, type, type === 'image/png' ? undefined : quality);
    canvas.width = 0; // release memory early on mobile
    canvas.height = 0;
    return blob;
}

export function fitWithin(width, height, maxWidth, maxHeight = Infinity) {
    const scale = Math.min(1, maxWidth / width, maxHeight / height);
    return { width: Math.max(1, Math.round(width * scale)), height: Math.max(1, Math.round(height * scale)) };
}

/**
 * Compress an image.
 * options: { quality 0-1, format 'same'|mime, maxWidth (px or 0), targetBytes (or 0) }
 */
export async function compressImage(file, options) {
    const { img, url, width: w0, height: h0 } = await loadImage(file);
    try {
        const { type, note } = await resolveOutputType(options.format || 'same', imageTypeOf(file));
        let { width, height } = options.maxWidth > 0 ? fitWithin(w0, h0, options.maxWidth) : { width: w0, height: h0 };
        ({ width, height } = fitWithin(width, height, MAX_SIDE, MAX_SIDE));

        if (!options.targetBytes) {
            const blob = await renderImage(img, width, height, type, options.quality);
            return { blob, type, width, height, note };
        }

        // Target size mode: find the highest quality that fits, shrinking dimensions only if needed.
        const target = options.targetBytes;
        let smallest = null;
        for (let round = 0; round < 14; round++) {
            if (type === 'image/png') {
                const blob = await renderImage(img, width, height, type);
                if (!smallest || blob.size < smallest.blob.size) smallest = { blob, width, height };
                if (blob.size <= target) return { blob, type, width, height, note };
            } else {
                let lo = 0.05;
                let hi = 0.95;
                let best = null;
                const floor = await renderImage(img, width, height, type, lo);
                if (!smallest || floor.size < smallest.blob.size) smallest = { blob: floor, width, height };
                if (floor.size <= target) {
                    best = floor;
                    for (let i = 0; i < 7; i++) {
                        const mid = (lo + hi) / 2;
                        const blob = await renderImage(img, width, height, type, mid);
                        if (blob.size <= target) {
                            best = blob;
                            lo = mid;
                        } else {
                            hi = mid;
                        }
                    }
                    return { blob: best, type, width, height, note };
                }
            }
            if (width <= 16 || height <= 16) break;
            width = Math.max(16, Math.round(width * 0.8));
            height = Math.max(16, Math.round(height * 0.8));
        }

        return {
            blob: smallest.blob,
            type,
            width: smallest.width,
            height: smallest.height,
            note: `${note ? `${note} ` : ''}${t('Could not reach the target size; this is the smallest version possible.')}`.trim(),
            missedTarget: true,
        };
    } finally {
        URL.revokeObjectURL(url);
    }
}
