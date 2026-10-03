import { useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { isPdf, addRotation, buildRotatedPdf } from '../lib/pdf.js';
import { usePdfPageThumbnails } from '../lib/pdfPages.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { t, tn } from '../lib/i18n.js';

export default function RotatePdf() {
    const [file, setFile] = useState(null);
    const [offsets, setOffsets] = useState([]);
    const [selected, setSelected] = useState(new Set());
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);
    const { status, doc, pageCount, thumbs } = usePdfPageThumbnails(file);

    function openFile([picked]) {
        setError('');
        setResult(null);
        setSelected(new Set());
        setOffsets([]);
        setFile(picked);
    }

    function ensureOffsets() {
        if (offsets.length === pageCount) return offsets;
        const next = Array.from({ length: pageCount }, (_, i) => offsets[i] || 0);
        setOffsets(next);
        return next;
    }

    function rotate(delta) {
        setResult(null);
        const base = ensureOffsets();
        const targets = selected.size > 0 ? selected : new Set(base.map((_, i) => i));
        setOffsets(base.map((v, i) => (targets.has(i) ? addRotation(v, delta) : v)));
    }

    function toggleSelected(index) {
        setSelected((set) => {
            const next = new Set(set);
            if (next.has(index)) next.delete(index);
            else next.add(index);
            return next;
        });
    }

    function selectAll() {
        setSelected(new Set(Array.from({ length: pageCount }, (_, i) => i)));
    }

    function selectNone() {
        setSelected(new Set());
    }

    async function apply() {
        if (!doc || working) return;
        setWorking(true);
        setError('');
        try {
            const baseRotations = doc.getPages().map((p) => p.getRotation().angle);
            const targets = baseRotations.map((base, i) => addRotation(base, offsets[i] || 0));
            const blob = await buildRotatedPdf(doc, targets);
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-rotated.pdf`) });
        } catch (e) {
            setError(t('Rotating failed: {message}', { message: e.message }));
        } finally {
            setWorking(false);
        }
    }

    if (!file) {
        return (
            <div className="stack">
                <Dropzone
                    accept=".pdf,application/pdf"
                    isAccepted={isPdf}
                    onReject={() => setError(t('Please choose a PDF file.'))}
                    onFiles={openFile}
                    title={t('Drop a PDF here or click to choose')}
                    hint={t('One PDF file · max 200 MB')}
                />
                <Notice type="error">{error}</Notice>
            </div>
        );
    }

    if (status === 'loading' || status === 'idle') {
        return <Notice type="info">{t('Reading PDF…')}</Notice>;
    }

    if (status === 'error') {
        return (
            <div className="stack">
                <Notice type="error">{error}</Notice>
                <button type="button" className="btn" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>
        );
    }

    const anyRotated = offsets.some((v) => v);

    return (
        <div className="stack">
            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {tn('{count} page', '{count} pages', pageCount)} · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <div className="row">
                <button type="button" className="btn btn--sm" onClick={selectAll}>{t('Select all')}</button>
                <button type="button" className="btn btn--sm" onClick={selectNone} disabled={selected.size === 0}>{t('Select none')}</button>
                <span className="field__hint" style={{ margin: 0 }}>
                    {selected.size > 0
                        ? tn('{count} page selected', '{count} pages selected', selected.size)
                        : t('No pages selected - rotation applies to every page')}
                </span>
            </div>

            <div className="row">
                <button type="button" className="btn btn--primary" onClick={() => rotate(-90)} aria-label={t('Rotate left 90 degrees')}>↺ 90°</button>
                <button type="button" className="btn btn--primary" onClick={() => rotate(90)} aria-label={t('Rotate right 90 degrees')}>↻ 90°</button>
                <button type="button" className="btn" onClick={() => rotate(180)} aria-label={t('Rotate 180 degrees')}>180°</button>
            </div>

            <ol className="page-grid" aria-label={t('PDF pages')}>
                {Array.from({ length: pageCount }, (_, i) => {
                    const thumb = thumbs[i];
                    const offset = offsets[i] || 0;
                    return (
                        <li key={i}>
                            <label className={`page-card${selected.has(i) ? ' is-selected' : ''}`}>
                                <input
                                    type="checkbox"
                                    className="page-card__check"
                                    checked={selected.has(i)}
                                    onChange={() => toggleSelected(i)}
                                    aria-label={t('Select page {number}', { number: i + 1 })}
                                />
                                <div className="page-card__frame">
                                    {thumb?.url ? (
                                        <img className="page-card__img" src={thumb.url} alt="" style={{ transform: `rotate(${offset}deg)` }} />
                                    ) : (
                                        <span className="field__hint">{t('Loading…')}</span>
                                    )}
                                </div>
                                <span className="page-card__number">{i + 1}{offset ? ` · ${offset}°` : ''}</span>
                            </label>
                        </li>
                    );
                })}
            </ol>

            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done!')} {formatBytes(result.blob.size)}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>{t('Download PDF')}</button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={apply} disabled={working || !anyRotated}>
                    {working ? t('Rotating…') : t('Rotate PDF')}
                </button>
            )}
        </div>
    );
}
