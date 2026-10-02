// Background removal in the browser with ONNX Runtime Web. Images never leave the device;
// only the AI model is downloaded (and cached for next time).
//   fast: U-2-Netp (Apache-2.0, 4.4 MB, self-hosted), 320x320, works everywhere (WASM).
//   hq:   BiRefNet lite (MIT, 109 MB from Hugging Face), 1024x1024, needs WebGPU.

export const MODELS = {
    fast: { url: '/models/u2netp.onnx', size: 320, bytes: 4_574_861, sigmoid: false, provider: 'wasm' },
    hq: {
        url: 'https://huggingface.co/onnx-community/BiRefNet_lite-ONNX/resolve/main/onnx/model_fp16.onnx',
        size: 1024,
        bytes: 114_538_221,
        sigmoid: true,
        provider: 'webgpu',
    },
};

const MEAN = [0.485, 0.456, 0.406];
const STD = [0.229, 0.224, 0.225];
const CACHE = 'ilovetools-models-v1';

/** RGBA pixels (size x size) -> normalised CHW float tensor data. U-2-Net scales by the brightest value. */
export function toTensorData(rgba, size, { scaleByMax = false } = {}) {
    const n = size * size;
    let max = 255;
    if (scaleByMax) {
        max = 1;
        for (let i = 0; i < n * 4; i++) if (i % 4 !== 3 && rgba[i] > max) max = rgba[i];
    }
    const out = new Float32Array(3 * n);
    for (let i = 0; i < n; i++) {
        for (let c = 0; c < 3; c++) out[c * n + i] = (rgba[i * 4 + c] / max - MEAN[c]) / STD[c];
    }
    return out;
}

/** Model output -> 0-255 mask. BiRefNet gives logits (sigmoid); U-2-Net gives a map we stretch to 0-1. */
export function toMask(values, { sigmoid }) {
    const mask = new Uint8ClampedArray(values.length);
    if (sigmoid) {
        for (let i = 0; i < values.length; i++) mask[i] = 255 / (1 + Math.exp(-values[i]));
        return mask;
    }
    let min = Infinity;
    let max = -Infinity;
    for (const v of values) {
        if (v < min) min = v;
        if (v > max) max = v;
    }
    const range = max - min || 1;
    for (let i = 0; i < values.length; i++) mask[i] = ((values[i] - min) / range) * 255;
    return mask;
}

export function hasWebGpu() {
    return typeof navigator !== 'undefined' && 'gpu' in navigator;
}

/** Download a model with progress, using the Cache API so it is only downloaded once. */
async function fetchModel(model, onProgress) {
    let cache = null;
    try {
        cache = await caches.open(CACHE);
        const hit = await cache.match(model.url);
        if (hit) return new Uint8Array(await hit.arrayBuffer());
    } catch {
        cache = null; // private mode or no Cache API: just download
    }
    const res = await fetch(model.url);
    if (!res.ok || !res.body) throw new Error(`Model download failed (${res.status})`);
    const total = Number(res.headers.get('content-length')) || model.bytes;
    const reader = res.body.getReader();
    const chunks = [];
    let loaded = 0;
    for (;;) {
        const { done, value } = await reader.read();
        if (done) break;
        chunks.push(value);
        loaded += value.length;
        onProgress?.(Math.min(1, loaded / total));
    }
    const bytes = new Uint8Array(loaded);
    let offset = 0;
    for (const c of chunks) {
        bytes.set(c, offset);
        offset += c.length;
    }
    try {
        await cache?.put(model.url, new Response(bytes, { headers: { 'Content-Type': 'application/octet-stream' } }));
    } catch {
        // Quota exceeded: fine, it is downloaded again next time.
    }
    return bytes;
}

let ortPromise = null;
const sessions = {};

async function loadOrt() {
    ortPromise ??= import('onnxruntime-web/webgpu').then((ort) => {
        // The runtime's large .wasm files come from the jsDelivr CDN instead of our server.
        ort.env.wasm.wasmPaths = `https://cdn.jsdelivr.net/npm/onnxruntime-web@${ort.env.versions.web}/dist/`;
        ort.env.wasm.numThreads = 1; // threads need cross-origin isolation, which the site doesn't use
        return ort;
    });
    return ortPromise;
}

export async function loadModel(key, onProgress) {
    sessions[key] ??= (async () => {
        const model = MODELS[key];
        const [ort, bytes] = await Promise.all([loadOrt(), fetchModel(model, onProgress)]);
        return ort.InferenceSession.create(bytes, { executionProviders: [model.provider], graphOptimizationLevel: 'all' });
    })().catch((e) => {
        delete sessions[key];
        throw e;
    });
    return sessions[key];
}

/** Draw an image (bitmap/canvas) into a size x size canvas and return its pixels. */
function pixelsAt(source, size) {
    const c = new OffscreenCanvas(size, size);
    const ctx = c.getContext('2d', { willReadFrequently: true });
    ctx.drawImage(source, 0, 0, size, size);
    return ctx.getImageData(0, 0, size, size).data;
}

/**
 * Remove the background of an image file. Returns a canvas with a transparent background.
 * Very large images are scaled to at most `maxSide` pixels on their longest side.
 */
export async function removeBackground(file, key, { onProgress, maxSide = 4096 } = {}) {
    const model = MODELS[key];
    const [session, ort, bitmap] = await Promise.all([loadModel(key, onProgress), loadOrt(), createImageBitmap(file)]);

    const scale = Math.min(1, maxSide / Math.max(bitmap.width, bitmap.height));
    const width = Math.round(bitmap.width * scale);
    const height = Math.round(bitmap.height * scale);

    const input = toTensorData(pixelsAt(bitmap, model.size), model.size, { scaleByMax: !model.sigmoid });
    const feeds = { [session.inputNames[0]]: new ort.Tensor('float32', input, [1, 3, model.size, model.size]) };
    const results = await session.run(feeds);
    const output = results[session.outputNames[0]];
    const mask = toMask(await output.getData(), model);
    output.dispose?.();

    // Mask -> grayscale canvas -> scaled to the image size with smoothing.
    const m = new OffscreenCanvas(model.size, model.size);
    const mctx = m.getContext('2d');
    const mData = mctx.createImageData(model.size, model.size);
    for (let i = 0; i < mask.length; i++) {
        mData.data[i * 4 + 3] = mask[i];
    }
    mctx.putImageData(mData, 0, 0);

    const out = new OffscreenCanvas(width, height);
    const ctx = out.getContext('2d');
    ctx.imageSmoothingQuality = 'high';
    ctx.drawImage(m, 0, 0, width, height);
    ctx.globalCompositeOperation = 'source-in';
    ctx.drawImage(bitmap, 0, 0, width, height);
    ctx.globalCompositeOperation = 'source-over';
    bitmap.close();
    return out;
}

/** Final image: transparent PNG, or the cut-out on a solid colour (PNG or JPG). */
export async function exportResult(cutout, { background = null, type = 'image/png', quality = 0.92 } = {}) {
    const c = new OffscreenCanvas(cutout.width, cutout.height);
    const ctx = c.getContext('2d');
    if (background) {
        ctx.fillStyle = background;
        ctx.fillRect(0, 0, c.width, c.height);
    }
    ctx.drawImage(cutout, 0, 0);
    return c.convertToBlob({ type, quality });
}
