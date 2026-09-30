import { useEffect, useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { compressImage, EXTENSIONS, IMAGE_TYPES, imageTypeOf, MAX_FILE_BYTES } from '../lib/image.js';
import { baseName, downloadBlob, formatBytes, safeFilename, uniqueNamer } from '../lib/util.js';
import { formatNumber, t, tn } from '../lib/i18n.js';

const MAX_FILES = 30;
let nextId = 1;

export default function ImageCompressor() {
    const itemsRef = useRef([]);
    const [items, setItemsState] = useState([]);
    const [busy, setBusy] = useState(false);
    const [zipping, setZipping] = useState(false);
    const [message, setMessage] = useState({ type: '', text: '' });
    const [settings, setSettings] = useState({ mode: 'quality', quality: 75, targetKB: 100, format: 'same', maxWidth: '' });
    const [settingsDirty, setSettingsDirty] = useState(false);
    const settingsRef = useRef(settings);
    const busyRef = useRef(false);

    const setItems = (updater) => {
        itemsRef.current = typeof updater === 'function' ? updater(itemsRef.current) : updater;
        setItemsState(itemsRef.current);
    };
    const update = (id, patch) => setItems((list) => list.map((it) => (it.id === id ? { ...it, ...patch } : it)));

    // Free memory for all preview/download URLs when leaving the page.
    useEffect(() => () => itemsRef.current.forEach(revokeItem), []);

    function changeSetting(key, value) {
        const next = { ...settingsRef.current, [key]: value };
        settingsRef.current = next;
        setSettings(next);
        if (itemsRef.current.some((it) => it.status === 'done' || it.status === 'error')) setSettingsDirty(true);
    }

    function currentOptions() {
        const s = settingsRef.current;
        const maxWidth = Math.floor(Number(s.maxWidth));
        return {
            quality: Math.min(1, Math.max(0.05, s.quality / 100)),
            format: s.format,
            maxWidth: Number.isFinite(maxWidth) && maxWidth > 0 ? maxWidth : 0,
            targetBytes: s.mode === 'target' ? Math.max(5, Number(s.targetKB) || 0) * 1024 : 0,
        };
    }

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
                    const options = currentOptions();
                    const result = await compressImage(next.file, options);
                    let { blob } = result;
                    let keptOriginal = false;
                    // Never hand back a bigger file than the original in normal mode.
                    if (!options.targetBytes && blob.size >= next.file.size && result.type === imageTypeOf(next.file) && !options.maxWidth) {
                        blob = next.file;
                        keptOriginal = true;
                    }
                    if (!itemsRef.current.some((it) => it.id === next.id)) continue; // removed while working
                    update(next.id, {
                        status: 'done',
                        result: { ...result, blob, url: URL.createObjectURL(blob), keptOriginal },
                    });
                } catch (e) {
                    update(next.id, { status: 'error', error: e.message || t('Could not compress this image.') });
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
        if (files.length - tooBig.length > ok.length) notes.push(t('You can compress up to {max} images at a time.', { max: MAX_FILES }));
        setMessage(notes.length ? { type: 'warn', text: notes.join(' ') } : { type: '', text: '' });

        if (ok.length === 0) return;
        setItems((list) => [
            ...list,
            ...ok.map((file) => ({ id: nextId++, file, thumb: URL.createObjectURL(file), status: 'pending', result: null, error: '' })),
        ]);
        runQueue();
    }

    function recompressAll() {
        setSettingsDirty(false);
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
        if (item) revokeItem(item);
        setItems((list) => list.filter((it) => it.id !== id));
    }

    function clearAll() {
        itemsRef.current.forEach(revokeItem);
        setItems([]);
        setMessage({ type: '', text: '' });
        setSettingsDirty(false);
    }

    function outputName(item) {
        const ext = EXTENSIONS[item.result.type] || 'jpg';
        return safeFilename(`${baseName(item.file.name)}-compressed.${ext}`);
    }

    async function downloadZip() {
        const done = itemsRef.current.filter((it) => it.status === 'done');
        if (!done.length) return;
        setZipping(true);
        try {
            const { default: JSZip } = await import('jszip');
            const zip = new JSZip();
            const unique = uniqueNamer();
            done.forEach((it) => zip.file(unique(outputName(it)), it.result.blob));
            const blob = await zip.generateAsync({ type: 'blob' });
            downloadBlob(blob, 'compressed-images.zip');
        } catch (e) {
            setMessage({ type: 'error', text: t('Could not create the ZIP file: {message}', { message: e.message }) });
        } finally {
            setZipping(false);
        }
    }

    const done = items.filter((it) => it.status === 'done');
    const totalBefore = done.reduce((sum, it) => sum + it.file.size, 0);
    const totalAfter = done.reduce((sum, it) => sum + it.result.blob.size, 0);
    const saved = totalBefore > 0 ? Math.max(0, Math.round((1 - totalAfter / totalBefore) * 100)) : 0;

    return (
        <div className="stack">
            <Dropzone
                multiple
                accept="image/jpeg,image/png,image/webp,.jpg,.jpeg,.png,.webp"
                isAccepted={(f) => IMAGE_TYPES.includes(imageTypeOf(f))}
                onReject={(bad) => setMessage({ type: 'error', text: t('{files}: only JPG, PNG and WebP images are supported.', { files: bad.map((f) => f.name).join(', ') }) })}
                onFiles={addFiles}
                title={t('Drop images here or click to choose')}
                hint={t('JPG, PNG or WebP · up to {max} images · max 50 MB each', { max: MAX_FILES })}
                compact={items.length > 0}
            />

            <div className="stack" style={{ gap: '.75rem' }}>
                <Tabs
                    tabs={[{ id: 'quality', label: t('Quality') }, { id: 'target', label: t('Target size (e.g. 100 KB)') }]}
                    value={settings.mode}
                    onChange={(v) => changeSetting('mode', v)}
                    label={t('Compression mode')}
                />
                <div className="grid-2">
                    {settings.mode === 'quality' ? (
                        <div className="field">
                            <label className="field__label" htmlFor="ic-quality">{t('Quality: {value}%', { value: settings.quality })}</label>
                            <input id="ic-quality" className="range" type="range" min={10} max={100} step={5} value={settings.quality} onChange={(e) => changeSetting('quality', Number(e.target.value))} />
                            <span className="field__hint">{t('Lower = smaller file. 70-80% looks the same as the original to most people.')}</span>
                        </div>
                    ) : (
                        <div className="field">
                            <label className="field__label" htmlFor="ic-target">{t('Maximum file size (KB)')}</label>
                            <input id="ic-target" className="input" type="number" min={5} step={10} inputMode="numeric" value={settings.targetKB} onChange={(e) => changeSetting('targetKB', e.target.value)} />
                            <span className="field__hint">{t('Each image is made as good as possible while staying under this size.')}</span>
                        </div>
                    )}
                    <div className="field">
                        <label className="field__label" htmlFor="ic-format">{t('Output format')}</label>
                        <select id="ic-format" className="select" value={settings.format} onChange={(e) => changeSetting('format', e.target.value)}>
                            <option value="same">{t('Same as original')}</option>
                            <option value="image/jpeg">JPG</option>
                            <option value="image/webp">{t('WebP (smallest)')}</option>
                            <option value="image/png">{t('PNG (lossless)')}</option>
                        </select>
                    </div>
                    <div className="field">
                        <label className="field__label" htmlFor="ic-width">{t('Max width (px, optional)')}</label>
                        <input id="ic-width" className="input" type="number" min={16} inputMode="numeric" placeholder={t('e.g. 1920')} value={settings.maxWidth} onChange={(e) => changeSetting('maxWidth', e.target.value)} />
                    </div>
                </div>
                {settings.format === 'image/png' && <Notice type="info">{t('PNG is lossless, so the quality setting has no effect. Choose WebP or JPG for much smaller files.')}</Notice>}
            </div>

            <Notice type={message.type || 'info'}>{message.text}</Notice>

            {items.length > 0 && (
                <>
                    {settingsDirty && (
                        <div className="notice notice--info row row--between">
                            <span>{t('Settings changed.')}</span>
                            <button type="button" className="btn btn--primary btn--sm" onClick={recompressAll} disabled={busy}>{t('Re-compress all')}</button>
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
                                        {it.status === 'working' && ` · ${t('compressing…')}`}
                                        {it.status === 'done' && (
                                            <>
                                                {' → '}<strong>{formatBytes(it.result.blob.size)}</strong>
                                                {' · '}{it.result.width}×{it.result.height}{' '}
                                                {it.result.keptOriginal ? (
                                                    <span className="badge badge--muted">{t('Already optimised')}</span>
                                                ) : (
                                                    <span className={`badge ${it.result.blob.size < it.file.size ? 'badge--success' : 'badge--muted'}`}>
                                                        {it.result.blob.size < it.file.size ? `−${Math.round((1 - it.result.blob.size / it.file.size) * 100)}%` : `+${Math.round((it.result.blob.size / it.file.size - 1) * 100)}%`}
                                                    </span>
                                                )}
                                            </>
                                        )}
                                    </div>
                                    {it.status === 'done' && it.result.note && <div className="file-item__meta">{it.result.note}</div>}
                                    {it.status === 'error' && <div className="file-item__meta" style={{ color: 'var(--danger)' }}>{it.error}</div>}
                                </div>
                                <div className="file-item__actions">
                                    {it.status === 'done' && (
                                        <button type="button" className="btn btn--primary btn--sm" onClick={() => downloadBlob(it.result.blob, outputName(it))}>
                                            {t('Download')}
                                        </button>
                                    )}
                                    <button type="button" className="btn btn--sm btn--ghost" onClick={() => remove(it.id)} aria-label={t('Remove {name}', { name: it.file.name })}>✕</button>
                                </div>
                            </li>
                        ))}
                    </ul>

                    <div className="row row--between">
                        <p className="field__hint" style={{ margin: 0 }} aria-live="polite">
                            {busy ? t('Compressing…') : done.length > 0 && `${tn('{count} image', '{count} images', done.length)}: ${formatBytes(totalBefore)} → ${formatBytes(totalAfter)} (${t('{percent}% smaller', { percent: formatNumber(saved) })})`}
                        </p>
                        <div className="row">
                            {done.length > 1 && (
                                <button type="button" className="btn btn--primary" onClick={downloadZip} disabled={busy || zipping}>
                                    {zipping ? t('Creating ZIP…') : t('Download all (ZIP)')}
                                </button>
                            )}
                            <button type="button" className="btn btn--danger" onClick={clearAll} disabled={busy}>{t('Clear all')}</button>
                        </div>
                    </div>
                </>
            )}
        </div>
    );
}

function revokeItem(item) {
    if (item.thumb) URL.revokeObjectURL(item.thumb);
    if (item.result?.url) URL.revokeObjectURL(item.result.url);
}
