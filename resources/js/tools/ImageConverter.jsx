import { useEffect, useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { compressImage, CONVERTIBLE_TYPES, convertedName, imageTypeOf, MAX_FILE_BYTES } from '../lib/image.js';
import { downloadBlob, formatBytes, safeFilename, uniqueNamer } from '../lib/util.js';
import { t, tn } from '../lib/i18n.js';

const MAX_FILES = 30;
const LABELS = { 'image/jpeg': 'JPG', 'image/png': 'PNG', 'image/webp': 'WebP' };
let nextId = 1;

/**
 * Batch image format converter used by the "PNG to JPG", "WebP to PNG" and
 * "JPG to PNG" pages. `to` is the output MIME type; everything runs in the browser.
 */
export default function ImageConverter({ to = 'image/png' }) {
    const itemsRef = useRef([]);
    const [items, setItemsState] = useState([]);
    const [busy, setBusy] = useState(false);
    const [zipping, setZipping] = useState(false);
    const [message, setMessage] = useState({ type: '', text: '' });
    const [quality, setQuality] = useState(92);
    const qualityRef = useRef(92);
    const busyRef = useRef(false);
    const lossy = to !== 'image/png';
    const label = LABELS[to] || 'PNG';

    const setItems = (updater) => {
        itemsRef.current = typeof updater === 'function' ? updater(itemsRef.current) : updater;
        setItemsState(itemsRef.current);
    };
    const update = (id, patch) => setItems((list) => list.map((it) => (it.id === id ? { ...it, ...patch } : it)));
    const revoke = (it) => {
        URL.revokeObjectURL(it.thumb);
        if (it.result?.url) URL.revokeObjectURL(it.result.url);
    };

    useEffect(() => () => itemsRef.current.forEach(revoke), []);

    async function runQueue() {
        if (busyRef.current) return;
        busyRef.current = true;
        setBusy(true);
        try {
            for (;;) {
                const next = itemsRef.current.find((it) => it.status === 'pending');
                if (!next) break;
                update(next.id, { status: 'working', error: '' });
                try {
                    const result = await compressImage(next.file, { format: to, quality: qualityRef.current / 100, maxWidth: 0, targetBytes: 0 });
                    if (!itemsRef.current.some((it) => it.id === next.id)) continue; // removed while working
                    update(next.id, { status: 'done', usedQuality: qualityRef.current, result: { ...result, url: URL.createObjectURL(result.blob) } });
                } catch (e) {
                    update(next.id, { status: 'error', error: e.message || t('Could not convert this image.') });
                }
            }
        } finally {
            busyRef.current = false;
            setBusy(false);
        }
    }

    function addFiles(files) {
        const room = MAX_FILES - itemsRef.current.length;
        const tooBig = files.filter((f) => f.size > MAX_FILE_BYTES);
        const ok = files.filter((f) => f.size <= MAX_FILE_BYTES).slice(0, Math.max(0, room));
        const notes = [];
        if (tooBig.length) notes.push(tn('{count} file skipped because it is larger than 50 MB.', '{count} files skipped because they are larger than 50 MB.', tooBig.length));
        if (files.length - tooBig.length > ok.length) notes.push(t('You can convert up to {max} images at a time.', { max: MAX_FILES }));
        setMessage(notes.length ? { type: 'warn', text: notes.join(' ') } : { type: '', text: '' });
        if (!ok.length) return;
        setItems((list) => [...list, ...ok.map((file) => ({ id: nextId++, file, thumb: URL.createObjectURL(file), status: 'pending', result: null, error: '' }))]);
        runQueue();
    }

    function changeQuality(value) {
        qualityRef.current = value;
        setQuality(value);
    }

    function reconvertAll() {
        setItems((list) =>
            list.map((it) => {
                if (it.result?.url) URL.revokeObjectURL(it.result.url);
                return { ...it, status: 'pending', result: null, error: '' };
            }),
        );
        runQueue();
    }

    function remove(id) {
        const item = itemsRef.current.find((it) => it.id === id);
        if (item) revoke(item);
        setItems((list) => list.filter((it) => it.id !== id));
    }

    function clearAll() {
        itemsRef.current.forEach(revoke);
        setItems([]);
        setMessage({ type: '', text: '' });
    }

    const outputName = (it) => convertedName(it.file.name, it.result.type, safeFilename);

    async function downloadZip() {
        const done = itemsRef.current.filter((it) => it.status === 'done');
        if (!done.length) return;
        setZipping(true);
        try {
            const { default: JSZip } = await import('jszip');
            const zip = new JSZip();
            const unique = uniqueNamer();
            done.forEach((it) => zip.file(unique(outputName(it)), it.result.blob));
            downloadBlob(await zip.generateAsync({ type: 'blob' }), `converted-to-${label.toLowerCase()}.zip`);
        } catch (e) {
            setMessage({ type: 'error', text: t('Could not create the ZIP file: {message}', { message: e.message }) });
        } finally {
            setZipping(false);
        }
    }

    const done = items.filter((it) => it.status === 'done');
    const hasTransparentSources = items.some((it) => ['image/png', 'image/webp', 'image/avif', 'image/gif'].includes(imageTypeOf(it.file)));

    return (
        <div className="stack">
            <Dropzone
                multiple
                accept="image/jpeg,image/png,image/webp,image/avif,image/gif,image/bmp,.jpg,.jpeg,.jfif,.png,.webp,.avif,.gif,.bmp"
                isAccepted={(f) => CONVERTIBLE_TYPES.includes(imageTypeOf(f))}
                onReject={(bad) => setMessage({ type: 'error', text: t('{files}: please choose JPG, PNG, WebP, AVIF, GIF or BMP images.', { files: bad.map((f) => f.name).join(', ') }) })}
                onFiles={addFiles}
                title={t('Drop images here or click to choose')}
                hint={t('JPG, PNG, WebP, AVIF, GIF or BMP · up to {max} images · max 50 MB each', { max: MAX_FILES })}
                compact={items.length > 0}
            />

            {lossy && (
                <div className="field">
                    <label className="field__label" htmlFor="cv-quality">{t('Quality: {value}%', { value: quality })}</label>
                    <input id="cv-quality" className="range" type="range" min={50} max={100} step={1} value={quality} onChange={(e) => changeQuality(Number(e.target.value))} />
                    <span className="field__hint">{t('90% or more looks identical to the original. Lower values make smaller files.')}</span>
                </div>
            )}
            {to === 'image/jpeg' && hasTransparentSources && <Notice type="info">{t('JPG has no transparency, so transparent areas become white.')}</Notice>}

            <Notice type={message.type || 'info'}>{message.text}</Notice>

            {items.length > 0 && (
                <>
                    {lossy && done.length > 0 && done.some((it) => it.usedQuality !== quality) && (
                        <div className="notice notice--info row row--between">
                            <span>{t('Settings changed.')}</span>
                            <button type="button" className="btn btn--primary btn--sm" onClick={reconvertAll} disabled={busy}>{t('Convert again')}</button>
                        </div>
                    )}

                    <ul className="file-list">
                        {items.map((it) => (
                            <li key={it.id} className="file-item">
                                <img className="file-item__thumb" src={it.thumb} alt="" loading="lazy" />
                                <div className="file-item__main">
                                    <div className="file-item__name">{it.file.name}</div>
                                    <div className="file-item__meta">
                                        {formatBytes(it.file.size)}
                                        {it.status === 'pending' && ` · ${t('waiting…')}`}
                                        {it.status === 'working' && ` · ${t('converting…')}`}
                                        {it.status === 'done' && (
                                            <>
                                                {' → '}
                                                <strong>{outputName(it)}</strong>
                                                {' · '}
                                                {formatBytes(it.result.blob.size)}
                                            </>
                                        )}
                                    </div>
                                    {it.status === 'done' && it.result.note && <div className="file-item__meta">{it.result.note}</div>}
                                    {it.status === 'error' && (
                                        <div className="file-item__meta" style={{ color: 'var(--danger)' }}>
                                            {it.error}
                                        </div>
                                    )}
                                </div>
                                <div className="file-item__actions">
                                    {it.status === 'done' && (
                                        <button type="button" className="btn btn--primary btn--sm" onClick={() => downloadBlob(it.result.blob, outputName(it))}>
                                            {t('Download')}
                                        </button>
                                    )}
                                    <button type="button" className="btn btn--sm btn--ghost" onClick={() => remove(it.id)} aria-label={t('Remove {name}', { name: it.file.name })}>
                                        ✕
                                    </button>
                                </div>
                            </li>
                        ))}
                    </ul>

                    <div className="row row--between">
                        <p className="field__hint" style={{ margin: 0 }} aria-live="polite">
                            {busy ? t('Converting…') : done.length > 0 && tn('{count} image converted to {format}', '{count} images converted to {format}', done.length, { format: label })}
                        </p>
                        <div className="row">
                            {done.length > 1 && (
                                <button type="button" className="btn btn--primary" onClick={downloadZip} disabled={busy || zipping}>
                                    {zipping ? t('Creating ZIP…') : t('Download all (ZIP)')}
                                </button>
                            )}
                            <button type="button" className="btn btn--ghost" onClick={clearAll} disabled={busy}>
                                {t('Clear all')}
                            </button>
                        </div>
                    </div>
                </>
            )}
        </div>
    );
}
