import { useEffect, useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { EXTENSIONS, IMAGE_TYPES, imageTypeOf, loadImage, MAX_FILE_BYTES, MAX_SIDE, renderImage, resolveOutputType } from '../lib/image.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { formatNumber, t } from '../lib/i18n.js';

const INPUT_TYPES = [...IMAGE_TYPES, 'image/gif', 'image/bmp'];

export default function ImageResizer() {
    const [source, setSource] = useState(null); // { file, img, url, width, height }
    const [mode, setMode] = useState('pixels');
    const [width, setWidth] = useState('');
    const [height, setHeight] = useState('');
    const [percent, setPercent] = useState(50);
    const [lock, setLock] = useState(true);
    const [format, setFormat] = useState('image/jpeg');
    const [quality, setQuality] = useState(90);
    const [output, setOutput] = useState(null); // { blob, url, width, height, type, note }
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const sourceRef = useRef(null);
    const outputRef = useRef(null);

    useEffect(() => () => {
        if (sourceRef.current) URL.revokeObjectURL(sourceRef.current.url);
        if (outputRef.current) URL.revokeObjectURL(outputRef.current.url);
    }, []);

    function setOutputSafe(next) {
        if (outputRef.current) URL.revokeObjectURL(outputRef.current.url);
        outputRef.current = next;
        setOutput(next);
    }

    async function openFile([file]) {
        setError('');
        setOutputSafe(null);
        if (file.size > MAX_FILE_BYTES) {
            setError(t('This image is larger than 50 MB. Please choose a smaller file.'));
            return;
        }
        try {
            const loaded = await loadImage(file);
            if (sourceRef.current) URL.revokeObjectURL(sourceRef.current.url);
            sourceRef.current = { file, ...loaded };
            setSource(sourceRef.current);
            setWidth(String(loaded.width));
            setHeight(String(loaded.height));
            const type = imageTypeOf(file);
            setFormat(IMAGE_TYPES.includes(type) ? type : 'image/png');
        } catch (e) {
            setError(e.message);
        }
    }

    function onWidth(value, locked = lock) {
        setWidth(value);
        setOutputSafe(null);
        const w = Number(value);
        if (locked && source && w > 0) setHeight(String(Math.max(1, Math.round((w * source.height) / source.width))));
    }

    function onHeight(value) {
        setHeight(value);
        setOutputSafe(null);
        const h = Number(value);
        if (lock && source && h > 0) setWidth(String(Math.max(1, Math.round((h * source.width) / source.height))));
    }

    function targetSize() {
        if (!source) return null;
        if (mode === 'percent') {
            const p = Number(percent);
            if (!(p > 0)) return { error: t('Enter a percentage greater than 0.') };
            return { width: Math.max(1, Math.round((source.width * p) / 100)), height: Math.max(1, Math.round((source.height * p) / 100)) };
        }
        const w = Math.floor(Number(width));
        const h = Math.floor(Number(height));
        if (!(w >= 1) || !(h >= 1)) return { error: t('Enter a width and height of at least 1 pixel.') };
        return { width: w, height: h };
    }

    const target = targetSize();
    const tooLarge = target && !target.error && (target.width > MAX_SIDE || target.height > MAX_SIDE);

    async function resize() {
        if (!source || !target || target.error || tooLarge) return;
        setWorking(true);
        setError('');
        try {
            const { type, note } = await resolveOutputType(format, imageTypeOf(source.file));
            const blob = await renderImage(source.img, target.width, target.height, type, quality / 100);
            setOutputSafe({ blob, url: URL.createObjectURL(blob), width: target.width, height: target.height, type, note });
        } catch (e) {
            setError(e.message || t('Could not resize this image.'));
        } finally {
            setWorking(false);
        }
    }

    function reset() {
        if (sourceRef.current) URL.revokeObjectURL(sourceRef.current.url);
        sourceRef.current = null;
        setSource(null);
        setOutputSafe(null);
        setError('');
    }

    if (!source) {
        return (
            <div className="stack">
                <Dropzone
                    accept="image/*"
                    isAccepted={(f) => INPUT_TYPES.includes(imageTypeOf(f))}
                    onReject={() => setError(t('Please choose a JPG, PNG, WebP, GIF or BMP image.'))}
                    onFiles={openFile}
                    title={t('Drop an image here or click to choose')}
                    hint={t('JPG, PNG, WebP, GIF or BMP · max 50 MB')}
                />
                <Notice type="error">{error}</Notice>
            </div>
        );
    }

    return (
        <div className="stack">
            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{source.file.name}</strong> · {source.width} × {source.height}px · {formatBytes(source.file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={reset}>{t('Choose another image')}</button>
            </div>

            <img className="image-preview" src={output ? output.url : source.url} alt={output ? t('Resized image preview') : t('Original image preview')} />

            <Tabs tabs={[{ id: 'pixels', label: t('By pixels') }, { id: 'percent', label: t('By percentage') }]} value={mode} onChange={(v) => { setMode(v); setOutputSafe(null); }} label={t('Resize mode')} />

            {mode === 'pixels' ? (
                <div className="stack" style={{ gap: '.75rem' }}>
                    <div className="grid-2">
                        <div className="field">
                            <label className="field__label" htmlFor="ir-width">{t('Width (px)')}</label>
                            <input id="ir-width" className="input" type="number" min={1} max={MAX_SIDE} inputMode="numeric" value={width} onChange={(e) => onWidth(e.target.value)} />
                        </div>
                        <div className="field">
                            <label className="field__label" htmlFor="ir-height">{t('Height (px)')}</label>
                            <input id="ir-height" className="input" type="number" min={1} max={MAX_SIDE} inputMode="numeric" value={height} onChange={(e) => onHeight(e.target.value)} />
                        </div>
                    </div>
                    <label className="check">
                        <input type="checkbox" checked={lock} onChange={(e) => { setLock(e.target.checked); if (e.target.checked) onWidth(width, true); }} /> {t('Lock aspect ratio')}
                    </label>
                </div>
            ) : (
                <div className="field">
                    <label className="field__label" htmlFor="ir-percent">{t('Scale: {value}%', { value: percent })}</label>
                    <input id="ir-percent" className="range" type="range" min={5} max={200} step={5} value={percent} onChange={(e) => { setPercent(Number(e.target.value)); setOutputSafe(null); }} />
                </div>
            )}

            <div className="grid-2">
                <div className="field">
                    <label className="field__label" htmlFor="ir-format">{t('Save as')}</label>
                    <select id="ir-format" className="select" value={format} onChange={(e) => { setFormat(e.target.value); setOutputSafe(null); }}>
                        <option value="image/jpeg">JPG</option>
                        <option value="image/png">PNG</option>
                        <option value="image/webp">WebP</option>
                    </select>
                </div>
                {format !== 'image/png' && (
                    <div className="field">
                        <label className="field__label" htmlFor="ir-quality">{t('Quality: {value}%', { value: quality })}</label>
                        <input id="ir-quality" className="range" type="range" min={10} max={100} step={5} value={quality} onChange={(e) => { setQuality(Number(e.target.value)); setOutputSafe(null); }} />
                    </div>
                )}
            </div>

            {format === 'image/jpeg' && ['image/png', 'image/webp', 'image/gif'].includes(imageTypeOf(source.file)) && <Notice type="info">{t('JPG has no transparency, so transparent areas become white.')}</Notice>}
            {target?.error && <Notice type="error">{target.error}</Notice>}
            {tooLarge && <Notice type="error">{t('The maximum size is {max} pixels per side.', { max: formatNumber(MAX_SIDE) })}</Notice>}
            <Notice type="error">{error}</Notice>

            {output ? (
                <div className="notice notice--success row row--between">
                    <span>
                        {t('Resized to')} <strong>{output.width} × {output.height}px</strong> · {formatBytes(output.blob.size)}
                        {output.note && ` · ${output.note}`}
                    </span>
                    <button
                        type="button"
                        className="btn btn--primary"
                        onClick={() => downloadBlob(output.blob, safeFilename(`${baseName(source.file.name)}-${output.width}x${output.height}.${EXTENSIONS[output.type]}`))}
                    >
                        {t('Download image')}
                    </button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={resize} disabled={working || !target || Boolean(target.error) || tooLarge}>
                    {working ? t('Resizing…') : target && !target.error ? t('Resize to {width} × {height}px', target) : t('Resize image')}
                </button>
            )}
        </div>
    );
}
