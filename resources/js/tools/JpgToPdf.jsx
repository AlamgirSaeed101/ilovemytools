import { useEffect, useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { IMAGE_TYPES, imageTypeOf, MAX_FILE_BYTES } from '../lib/image.js';
import { buildImagePdf } from '../lib/pdf.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { t, tn } from '../lib/i18n.js';
import { defaultPaper } from '../lib/region.js';

const MAX_FILES = 30;
let nextId = 1;

export default function JpgToPdf() {
    const [items, setItems] = useState([]); // { id, file, thumb }
    const [message, setMessage] = useState({ type: '', text: '' });
    // Letter paper in the US/Canada, A4 elsewhere (from browser settings).
    const [settings, setSettings] = useState(() => ({ pageSize: defaultPaper(), orientation: 'auto', marginMm: 10 }));
    const [building, setBuilding] = useState(false);
    const [result, setResult] = useState(null);
    const itemsRef = useRef(items);
    itemsRef.current = items;

    useEffect(() => () => itemsRef.current.forEach((it) => URL.revokeObjectURL(it.thumb)), []);

    function addFiles(files) {
        setResult(null);
        const room = MAX_FILES - itemsRef.current.length;
        const tooBig = files.filter((f) => f.size > MAX_FILE_BYTES);
        const ok = files.filter((f) => f.size <= MAX_FILE_BYTES).slice(0, Math.max(0, room));
        const notes = [];
        if (tooBig.length) notes.push(tn('{count} file skipped because it is larger than 50 MB.', '{count} files skipped because they are larger than 50 MB.', tooBig.length));
        if (files.length - tooBig.length > ok.length) notes.push(t('You can convert up to {max} images at a time.', { max: MAX_FILES }));
        setMessage(notes.length ? { type: 'warn', text: notes.join(' ') } : { type: '', text: '' });

        if (ok.length === 0) return;
        setItems((list) => [...list, ...ok.map((file) => ({ id: nextId++, file, thumb: URL.createObjectURL(file) }))]);
    }

    function move(index, delta) {
        setResult(null);
        setItems((list) => {
            const next = [...list];
            const target = index + delta;
            if (target < 0 || target >= next.length) return list;
            [next[index], next[target]] = [next[target], next[index]];
            return next;
        });
    }

    function remove(id) {
        setResult(null);
        setItems((list) => {
            const item = list.find((it) => it.id === id);
            if (item) URL.revokeObjectURL(item.thumb);
            return list.filter((it) => it.id !== id);
        });
    }

    function clearAll() {
        itemsRef.current.forEach((it) => URL.revokeObjectURL(it.thumb));
        setItems([]);
        setResult(null);
        setMessage({ type: '', text: '' });
    }

    function changeSetting(key, value) {
        setResult(null);
        setSettings((s) => ({ ...s, [key]: value }));
    }

    async function convert() {
        if (items.length === 0 || building) return;
        setBuilding(true);
        setMessage({ type: '', text: '' });
        try {
            const blob = await buildImagePdf(items.map((it) => it.file), settings);
            setResult({ blob, count: items.length });
        } catch (e) {
            setMessage({ type: 'error', text: e.message });
        } finally {
            setBuilding(false);
        }
    }

    const outputName = () =>
        items.length === 1 ? safeFilename(`${baseName(items[0].file.name)}.pdf`) : 'images.pdf';

    return (
        <div className="stack">
            <Dropzone
                multiple
                accept="image/jpeg,image/png,image/webp,.jpg,.jpeg,.png,.webp"
                isAccepted={(f) => IMAGE_TYPES.includes(imageTypeOf(f))}
                onReject={(bad) => setMessage({ type: 'error', text: t('{files}: only JPG, PNG and WebP images are supported.', { files: bad.map((f) => f.name).join(', ') }) })}
                onFiles={addFiles}
                title={items.length ? t('Add more images') : t('Drop JPG, PNG or WebP images here or click to choose')}
                hint={t('Select one or more images · up to {max} images · max 50 MB each', { max: MAX_FILES })}
                compact={items.length > 0}
            />

            <div className="grid-2">
                <div className="field">
                    <label className="field__label" htmlFor="j2p-size">{t('Page size')}</label>
                    <select id="j2p-size" className="select" value={settings.pageSize} onChange={(e) => changeSetting('pageSize', e.target.value)}>
                        <option value="a4">A4</option>
                        <option value="letter">{t('Letter')}</option>
                        <option value="fit">{t('Fit image')}</option>
                    </select>
                </div>
                <div className="field">
                    <label className="field__label" htmlFor="j2p-orientation">{t('Orientation')}</label>
                    <select id="j2p-orientation" className="select" value={settings.orientation} onChange={(e) => changeSetting('orientation', e.target.value)} disabled={settings.pageSize === 'fit'}>
                        <option value="auto">{t('Automatic')}</option>
                        <option value="portrait">{t('Portrait')}</option>
                        <option value="landscape">{t('Landscape')}</option>
                    </select>
                </div>
                <div className="field">
                    <label className="field__label" htmlFor="j2p-margin">{t('Margin')}</label>
                    <select id="j2p-margin" className="select" value={settings.marginMm} onChange={(e) => changeSetting('marginMm', Number(e.target.value))}>
                        <option value={0}>{t('None')}</option>
                        <option value={5}>{t('Small')}</option>
                        <option value={10}>{t('Medium')}</option>
                        <option value={20}>{t('Large')}</option>
                    </select>
                </div>
            </div>

            <Notice type={message.type || 'info'}>{message.text}</Notice>

            {items.length > 0 && (
                <>
                    <ol className="file-list" aria-label={t('Images to convert, in order')}>
                        {items.map((it, index) => (
                            <li key={it.id} className="file-item">
                                <img className="file-item__thumb" src={it.thumb} alt="" loading="lazy" />
                                <div className="file-item__main">
                                    <span className="badge badge--muted" aria-hidden="true">{index + 1}</span>{' '}
                                    <span className="file-item__name">{it.file.name}</span>
                                    <div className="file-item__meta">{formatBytes(it.file.size)}</div>
                                </div>
                                <div className="file-item__actions">
                                    <button type="button" className="btn btn--sm" onClick={() => move(index, -1)} disabled={index === 0} aria-label={t('Move {name} up', { name: it.file.name })}>↑</button>
                                    <button type="button" className="btn btn--sm" onClick={() => move(index, 1)} disabled={index === items.length - 1} aria-label={t('Move {name} down', { name: it.file.name })}>↓</button>
                                    <button type="button" className="btn btn--sm btn--ghost" onClick={() => remove(it.id)} aria-label={t('Remove {name}', { name: it.file.name })}>✕</button>
                                </div>
                            </li>
                        ))}
                    </ol>

                    {result ? (
                        <div className="notice notice--success row row--between">
                            <span>{t('Done! Your PDF has {pages}.', { pages: tn('{count} page', '{count} pages', result.count) })}</span>
                            <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, outputName())}>{t('Download PDF')}</button>
                        </div>
                    ) : (
                        <div className="row row--between">
                            <p className="field__hint" style={{ margin: 0 }}>{tn('{count} image', '{count} images', items.length)}</p>
                            <div className="row">
                                <button type="button" className="btn btn--danger" onClick={clearAll} disabled={building}>{t('Clear')}</button>
                                <button type="button" className="btn btn--primary btn--lg" onClick={convert} disabled={building || items.length === 0}>
                                    {building ? t('Converting…') : t('Convert to PDF')}
                                </button>
                            </div>
                        </div>
                    )}
                </>
            )}
        </div>
    );
}
