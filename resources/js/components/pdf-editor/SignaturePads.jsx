// The three ways to create a signature (draw, type, upload), shared by every place the site signs
// a PDF. Each pad hands a finished canvas (transparent background, trimmed to the ink) to `onUse`.
import { useEffect, useRef, useState } from 'react';
import Dropzone from '../Dropzone.jsx';
import { t } from '../../lib/i18n.js';
import { trimCanvas, whiteToTransparent } from '../../lib/imageUtils.js';

export const INK_COLORS = [
    { id: '#1e293b', label: () => t('Black') },
    { id: '#1d4ed8', label: () => t('Blue') },
    { id: '#b91c1c', label: () => t('Red') },
];

// Handwriting fonts served by the site itself (public/fonts/signature, SIL Open Font License 1.1).
export const SIGNATURE_FONTS = [
    { id: 'dancing', family: 'ILMT Sign Dancing Script', file: '/fonts/signature/dancing-script.woff2', label: 'Dancing Script' },
    { id: 'greatvibes', family: 'ILMT Sign Great Vibes', file: '/fonts/signature/great-vibes.woff2', label: 'Great Vibes' },
    { id: 'sacramento', family: 'ILMT Sign Sacramento', file: '/fonts/signature/sacramento.woff2', label: 'Sacramento' },
    { id: 'caveat', family: 'ILMT Sign Caveat', file: '/fonts/signature/caveat.woff2', label: 'Caveat' },
];

const fontLoads = new Map();

/** Loads a signature font once (for both the on-screen preview and canvas drawing). */
export function loadSignatureFont(font) {
    if (typeof document === 'undefined' || typeof FontFace === 'undefined') return Promise.resolve();
    if (!fontLoads.has(font.id)) {
        const face = new FontFace(font.family, `url(${font.file}) format("woff2")`);
        fontLoads.set(
            font.id,
            face
                .load()
                .then((loaded) => document.fonts.add(loaded))
                .catch(() => {
                    fontLoads.delete(font.id);
                })
        );
    }
    return fontLoads.get(font.id);
}

function InkColorPicker({ value, onChange }) {
    return (
        <div className="row" role="radiogroup" aria-label={t('Ink colour')} style={{ gap: '0.4rem' }}>
            {INK_COLORS.map((c) => (
                <button
                    key={c.id}
                    type="button"
                    role="radio"
                    aria-checked={value === c.id}
                    aria-label={c.label()}
                    title={c.label()}
                    className={`ink-swatch${value === c.id ? ' is-selected' : ''}`}
                    style={{ background: c.id }}
                    onClick={() => onChange(c.id)}
                />
            ))}
            <input type="color" value={value} onChange={(e) => onChange(e.target.value)} aria-label={t('Custom ink colour')} />
        </div>
    );
}

const PAD_WIDTH = 1000;
const PAD_HEIGHT = 360;

/** Freehand pad: points are joined with smooth curves (through each segment's midpoint), so a quick scribble doesn't look jagged. */
export function DrawPad({ onUse }) {
    const canvasRef = useRef(null);
    const pointsRef = useRef(null);
    const [hasDrawing, setHasDrawing] = useState(false);
    const [color, setColor] = useState(INK_COLORS[0].id);

    function point(e) {
        const canvas = canvasRef.current;
        const rect = canvas.getBoundingClientRect();
        return { x: ((e.clientX - rect.left) * canvas.width) / rect.width, y: ((e.clientY - rect.top) * canvas.height) / rect.height, p: e.pressure || 0.5 };
    }

    function down(e) {
        e.preventDefault();
        e.currentTarget.setPointerCapture?.(e.pointerId);
        const p = point(e);
        pointsRef.current = [p];
        const ctx = canvasRef.current.getContext('2d');
        ctx.fillStyle = color;
        ctx.beginPath();
        ctx.arc(p.x, p.y, 2.5, 0, Math.PI * 2);
        ctx.fill();
    }

    function move(e) {
        const points = pointsRef.current;
        if (!points) return;
        e.preventDefault();
        const p = point(e);
        const last = points[points.length - 1];
        if (Math.hypot(p.x - last.x, p.y - last.y) < 1.5) return;
        points.push(p);
        const ctx = canvasRef.current.getContext('2d');
        ctx.strokeStyle = color;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        // Pens report pressure; a mouse reports 0.5, giving the default width.
        ctx.lineWidth = 3.5 + p.p * 3;
        const n = points.length;
        ctx.beginPath();
        if (n < 3) {
            ctx.moveTo(last.x, last.y);
            ctx.lineTo(p.x, p.y);
        } else {
            const a = points[n - 3];
            const b = points[n - 2];
            ctx.moveTo((a.x + b.x) / 2, (a.y + b.y) / 2);
            ctx.quadraticCurveTo(b.x, b.y, (b.x + p.x) / 2, (b.y + p.y) / 2);
        }
        ctx.stroke();
        setHasDrawing(true);
    }

    function up() {
        const points = pointsRef.current;
        pointsRef.current = null;
        // Finishes the last half-segment the midpoint curves stop short of.
        if (points && points.length >= 3) {
            const n = points.length;
            const ctx = canvasRef.current.getContext('2d');
            ctx.beginPath();
            ctx.moveTo((points[n - 2].x + points[n - 1].x) / 2, (points[n - 2].y + points[n - 1].y) / 2);
            ctx.lineTo(points[n - 1].x, points[n - 1].y);
            ctx.stroke();
        }
    }

    function clear() {
        const canvas = canvasRef.current;
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
        setHasDrawing(false);
    }

    return (
        <div className="stack">
            <InkColorPicker value={color} onChange={setColor} />
            <canvas
                ref={canvasRef}
                width={PAD_WIDTH}
                height={PAD_HEIGHT}
                className="signature-pad"
                aria-label={t('Draw your signature here')}
                onPointerDown={down}
                onPointerMove={move}
                onPointerUp={up}
                onPointerCancel={up}
                onPointerLeave={up}
            />
            <p className="field__hint" style={{ margin: 0 }}>{t('Using a keyboard? Choose Type and enter your name instead.')}</p>
            <div className="row">
                <button type="button" className="btn btn--sm" onClick={clear} disabled={!hasDrawing}>{t('Clear')}</button>
                <button type="button" className="btn btn--primary btn--sm" disabled={!hasDrawing} onClick={() => onUse(trimCanvas(canvasRef.current, 8))}>
                    {t('Use this signature')}
                </button>
            </div>
        </div>
    );
}

/** Renders `text` in `font` and `color` onto a transparent canvas trimmed to the letters. */
export async function renderTypedSignature(text, font, color) {
    await loadSignatureFont(font);
    const size = 110;
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    ctx.font = `${size}px "${font.family}", cursive`;
    const width = Math.ceil(ctx.measureText(text).width) + size;
    canvas.width = Math.min(4000, Math.max(width, 200));
    canvas.height = Math.round(size * 2);
    ctx.font = `${size}px "${font.family}", cursive`;
    ctx.fillStyle = color;
    ctx.textBaseline = 'middle';
    ctx.fillText(text, size / 2, canvas.height / 2);
    return trimCanvas(canvas, 10);
}

export function TypePad({ onUse }) {
    const [name, setName] = useState('');
    const [fontId, setFontId] = useState(SIGNATURE_FONTS[0].id);
    const [color, setColor] = useState(INK_COLORS[0].id);
    const [busy, setBusy] = useState(false);
    const font = SIGNATURE_FONTS.find((f) => f.id === fontId) ?? SIGNATURE_FONTS[0];

    useEffect(() => {
        SIGNATURE_FONTS.forEach((f) => loadSignatureFont(f));
    }, []);

    async function use() {
        setBusy(true);
        try {
            onUse(await renderTypedSignature(name.trim(), font, color));
        } finally {
            setBusy(false);
        }
    }

    return (
        <div className="stack">
            <input
                className="input"
                style={{ fontFamily: `"${font.family}", cursive`, fontSize: '1.9rem', color }}
                value={name}
                onChange={(e) => setName(e.target.value)}
                placeholder={t('Type your name')}
                maxLength={60}
                aria-label={t('Type your name')}
            />
            <div className="signature-fonts" role="radiogroup" aria-label={t('Signature style')}>
                {SIGNATURE_FONTS.map((f) => (
                    <label key={f.id} className={`signature-fonts__option${f.id === fontId ? ' is-selected' : ''}`}>
                        <input type="radio" name="signature-font" value={f.id} checked={f.id === fontId} onChange={() => setFontId(f.id)} />
                        <span style={{ fontFamily: `"${f.family}", cursive`, color }} aria-label={f.label}>
                            {name.trim() || f.label}
                        </span>
                    </label>
                ))}
            </div>
            <InkColorPicker value={color} onChange={setColor} />
            <button type="button" className="btn btn--primary btn--sm" disabled={!name.trim() || busy} onClick={use}>
                {t('Use this signature')}
            </button>
        </div>
    );
}

function decodeFile(file) {
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
            reject(new Error('decode'));
        };
        img.src = url;
    });
}

function processUpload(original, removeBackground) {
    const canvas = document.createElement('canvas');
    canvas.width = original.width;
    canvas.height = original.height;
    canvas.getContext('2d').drawImage(original, 0, 0);
    return removeBackground ? trimCanvas(whiteToTransparent(canvas), 6) : canvas;
}

export function UploadPad({ onUse, onError }) {
    const [removeBackground, setRemoveBackground] = useState(true);
    const originalRef = useRef(null);

    function handleFiles([file]) {
        decodeFile(file)
            .then((canvas) => {
                originalRef.current = canvas;
                onUse(processUpload(canvas, removeBackground));
            })
            .catch(() => onError());
    }

    function toggle(checked) {
        setRemoveBackground(checked);
        if (originalRef.current) onUse(processUpload(originalRef.current, checked));
    }

    return (
        <div className="stack">
            <Dropzone
                accept="image/png,image/jpeg,image/webp"
                isAccepted={(f) => /^image\/(png|jpeg|webp)$/.test(f.type)}
                onFiles={handleFiles}
                onReject={onError}
                title={t('Drop a signature image or click to choose')}
                hint={t('A photo or scan of your signature on white paper works')}
                compact
            />
            <label className="check">
                <input type="checkbox" checked={removeBackground} onChange={(e) => toggle(e.target.checked)} /> {t('Remove the white background')}
            </label>
        </div>
    );
}
