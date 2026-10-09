import { useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import PdfPageCanvas from '../components/PdfPageCanvas.jsx';
import { Notice } from '../components/ui.jsx';
import { t } from '../lib/i18n.js';
import { isPdf } from '../lib/pdf.js';
import { usePdfDoc } from '../lib/pdfPages.js';
import { canvasRectToPdfRect, clampRect, computeDisplayScale, rectFromPoints } from '../lib/pdfOverlay.js';
import { buildRedactedPdf, pagesWithBoxes } from '../lib/pdfRedact.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';

const MIN_BOX = 12;

function pointerPoint(e, el, natural) {
    const rect = el.getBoundingClientRect();
    return {
        x: ((e.clientX - rect.left) * natural.width) / rect.width,
        y: ((e.clientY - rect.top) * natural.height) / rect.height,
    };
}

export default function RedactPdf() {
    const [file, setFile] = useState(null);
    const [currentPage, setCurrentPage] = useState(0);
    const [boxes, setBoxes] = useState([]);
    const [selectedId, setSelectedId] = useState(null);
    const [draft, setDraft] = useState(null);
    const [canvasSize, setCanvasSize] = useState({ width: 0, height: 0 });
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);
    const stageRef = useRef(null);
    const nextId = useRef(1);
    const { status, doc, renderDoc, pageCount } = usePdfDoc(file);

    function openFile([picked]) {
        setError('');
        setResult(null);
        setCurrentPage(0);
        setBoxes([]);
        setSelectedId(null);
        setFile(picked);
    }

    function onPageReady({ width, height }) {
        setCanvasSize({ width, height });
    }

    function removeBox(id) {
        setBoxes((list) => list.filter((b) => b.id !== id));
        if (selectedId === id) setSelectedId(null);
        setResult(null);
    }

    function startNewBox(e) {
        if (!canvasSize.width) return;
        setSelectedId(null);
        const stage = stageRef.current;
        const start = pointerPoint(e, stage, canvasSize);

        function handleMove(ev) {
            const p = pointerPoint(ev, stage, canvasSize);
            setDraft(clampRect(rectFromPoints(start.x, start.y, p.x, p.y), canvasSize.width, canvasSize.height, 0));
        }
        function handleUp(ev) {
            window.removeEventListener('pointermove', handleMove);
            window.removeEventListener('pointerup', handleUp);
            const p = pointerPoint(ev, stage, canvasSize);
            const rect = rectFromPoints(start.x, start.y, p.x, p.y);
            setDraft(null);
            if (rect.width < MIN_BOX || rect.height < MIN_BOX) return;
            const id = nextId.current++;
            setBoxes((list) => [...list, { id, page: currentPage, ...clampRect(rect, canvasSize.width, canvasSize.height) }]);
            setSelectedId(id);
            setResult(null);
        }
        window.addEventListener('pointermove', handleMove);
        window.addEventListener('pointerup', handleUp);
    }

    function startDrag(e, id, dragMode) {
        e.preventDefault();
        e.stopPropagation();
        setSelectedId(id);
        const stage = stageRef.current;
        const natural = canvasSize;
        const box = boxes.find((b) => b.id === id);
        if (!stage || !box) return;
        const startPoint = pointerPoint(e, stage, natural);
        const startRect = { x: box.x, y: box.y, width: box.width, height: box.height };

        function handleMove(ev) {
            const p = pointerPoint(ev, stage, natural);
            const dx = p.x - startPoint.x;
            const dy = p.y - startPoint.y;
            setBoxes((list) =>
                list.map((item) => {
                    if (item.id !== id) return item;
                    if (dragMode === 'move') {
                        return { ...item, ...clampRect({ ...startRect, x: startRect.x + dx, y: startRect.y + dy }, natural.width, natural.height, 0) };
                    }
                    return {
                        ...item,
                        ...clampRect({ x: startRect.x, y: startRect.y, width: startRect.width + dx, height: startRect.height + dy }, natural.width, natural.height, MIN_BOX),
                    };
                })
            );
            setResult(null);
        }
        function handleUp() {
            window.removeEventListener('pointermove', handleMove);
            window.removeEventListener('pointerup', handleUp);
        }
        window.addEventListener('pointermove', handleMove);
        window.addEventListener('pointerup', handleUp);
    }

    async function apply() {
        if (!doc || !renderDoc || working || boxes.length === 0) return;
        setWorking(true);
        setError('');
        try {
            const toBuild = boxes.map((b) => {
                const size = doc.getPage(b.page).getSize();
                const scale = computeDisplayScale(size.width, size.height);
                return { page: b.page, rectPdf: canvasRectToPdfRect(b, scale, size.height) };
            });
            const blob = await buildRedactedPdf(doc, renderDoc, toBuild);
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-redacted.pdf`) });
        } catch (e) {
            setError(t('Redacting failed: {message}', { message: e.message }));
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

    const currentPageSize = doc.getPage(currentPage).getSize();
    const scale = computeDisplayScale(currentPageSize.width, currentPageSize.height);
    const currentBoxes = boxes.filter((b) => b.page === currentPage);
    const affectedPages = pagesWithBoxes(boxes);

    return (
        <div className="stack">
            <Notice type="info">{t('This is true redaction: every page you mark becomes a flattened image, so the covered text is permanently gone and cannot be copied, searched or recovered - not just hidden under a black box.')}</Notice>

            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <div className="field">
                <span className="field__label">{t('Draw a box over anything to redact')}</span>
                <div className="pdf-editor__toolbar">
                    <div className="pdf-editor__nav">
                        <button type="button" className="btn btn--sm" onClick={() => setCurrentPage((p) => Math.max(0, p - 1))} disabled={currentPage === 0}>
                            {t('Previous page')}
                        </button>
                        <span className="pdf-editor__page-label">{t('Page {current} of {total}', { current: currentPage + 1, total: pageCount })}</span>
                        <button type="button" className="btn btn--sm" onClick={() => setCurrentPage((p) => Math.min(pageCount - 1, p + 1))} disabled={currentPage === pageCount - 1}>
                            {t('Next page')}
                        </button>
                    </div>
                    {affectedPages.length > 0 && (
                        <span className="badge badge--muted">{t('{count} page(s) will become images', { count: affectedPages.length })}</span>
                    )}
                </div>

                <div className="pdf-editor__stage" ref={stageRef} onPointerDown={startNewBox}>
                    <PdfPageCanvas renderDoc={renderDoc} pageNumber={currentPage + 1} scale={scale} className="pdf-editor__canvas" onReady={onPageReady} />
                    {currentBoxes.map((b) => (
                        <div
                            key={b.id}
                            className={`pdf-editor__overlay pdf-editor__overlay--box${selectedId === b.id ? ' is-selected' : ''}`}
                            style={{ left: b.x, top: b.y, width: b.width, height: b.height }}
                            onPointerDown={(e) => startDrag(e, b.id, 'move')}
                            role="button"
                            tabIndex={0}
                            aria-label={t('Redaction box - drag to move')}
                        >
                            <button
                                type="button"
                                className="pdf-editor__remove"
                                aria-label={t('Remove this box')}
                                onPointerDown={(e) => e.stopPropagation()}
                                onClick={() => removeBox(b.id)}
                            >
                                ×
                            </button>
                            <span className="pdf-editor__handle" onPointerDown={(e) => startDrag(e, b.id, 'resize')} aria-hidden="true" />
                        </div>
                    ))}
                    {draft && (
                        <div className="pdf-editor__overlay pdf-editor__overlay--box" style={{ left: draft.x, top: draft.y, width: draft.width, height: draft.height }} />
                    )}
                </div>
            </div>

            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done!')} {formatBytes(result.blob.size)}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>{t('Download PDF')}</button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={apply} disabled={working || boxes.length === 0}>
                    {working ? t('Redacting…') : t('Redact PDF')}
                </button>
            )}
        </div>
    );
}
