import { useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { buildPdf, isPdf } from '../lib/pdf.js';
import { usePdfPageThumbnails } from '../lib/pdfPages.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { t, tn } from '../lib/i18n.js';

export default function OrganizePdf() {
    const [file, setFile] = useState(null);
    const [order, setOrder] = useState([]); // zero-based page indexes, in the new order
    const [dragIndex, setDragIndex] = useState(null);
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);
    const { status, doc, pageCount, thumbs } = usePdfPageThumbnails(file);

    function openFile([picked]) {
        setError('');
        setResult(null);
        setOrder([]);
        setFile(picked);
    }

    const pages = order.length === pageCount ? order : Array.from({ length: pageCount }, (_, i) => i);

    function move(from, to) {
        if (to < 0 || to >= pages.length || from === to) return;
        setResult(null);
        const next = [...pages];
        const [moved] = next.splice(from, 1);
        next.splice(to, 0, moved);
        setOrder(next);
    }

    function onDrop(targetPosition) {
        if (dragIndex !== null) move(dragIndex, targetPosition);
        setDragIndex(null);
    }

    async function apply() {
        if (!doc || working) return;
        setWorking(true);
        setError('');
        try {
            const blob = await buildPdf([{ doc, indexes: pages }]);
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-organized.pdf`) });
        } catch (e) {
            setError(t('Reordering failed: {message}', { message: e.message }));
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

    const changed = pages.some((idx, position) => idx !== position);

    return (
        <div className="stack">
            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {tn('{count} page', '{count} pages', pageCount)} · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <p className="field__hint" style={{ margin: 0 }}>{t('Drag a page to reorder it, or use the move buttons.')}</p>

            <ol className="page-grid" aria-label={t('PDF pages, in order')}>
                {pages.map((pageIndex, position) => {
                    const thumb = thumbs[pageIndex];
                    return (
                        <li
                            key={pageIndex}
                            draggable
                            onDragStart={() => setDragIndex(position)}
                            onDragOver={(e) => e.preventDefault()}
                            onDrop={(e) => {
                                e.preventDefault();
                                onDrop(position);
                            }}
                            onDragEnd={() => setDragIndex(null)}
                        >
                            <div
                                className={`page-card${dragIndex === position ? ' is-dragging' : ''}`}
                                role="group"
                                aria-label={t('Page {number}', { number: pageIndex + 1 })}
                            >
                                <div className="page-card__frame">
                                    {thumb?.url ? <img className="page-card__img" src={thumb.url} alt="" /> : <span className="field__hint">{t('Loading…')}</span>}
                                </div>
                                <span className="page-card__number">{position + 1}</span>
                                <div className="row">
                                    <button
                                        type="button"
                                        className="btn btn--sm"
                                        onClick={() => move(position, position - 1)}
                                        disabled={position === 0}
                                        aria-label={t('Move page {number} earlier', { number: pageIndex + 1 })}
                                    >
                                        ←
                                    </button>
                                    <button
                                        type="button"
                                        className="btn btn--sm"
                                        onClick={() => move(position, position + 1)}
                                        disabled={position === pages.length - 1}
                                        aria-label={t('Move page {number} later', { number: pageIndex + 1 })}
                                    >
                                        →
                                    </button>
                                </div>
                            </div>
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
                <button type="button" className="btn btn--primary btn--lg" onClick={apply} disabled={working || !changed}>
                    {working ? t('Saving…') : t('Save new order')}
                </button>
            )}
        </div>
    );
}
