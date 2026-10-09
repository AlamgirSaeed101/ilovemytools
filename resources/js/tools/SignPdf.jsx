import { useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import PdfPageCanvas from '../components/PdfPageCanvas.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { getLocale, t } from '../lib/i18n.js';
import { isPdf } from '../lib/pdf.js';
import { usePdfDoc } from '../lib/pdfPages.js';
import { canvasRectToPdfRect, clampRect, computeDisplayScale } from '../lib/pdfOverlay.js';
import { buildSignedPdf, formatSignatureDate, signatureBoxSize } from '../lib/pdfSign.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';

function canvasToPng(canvas) {
    return new Promise((resolve, reject) => {
        canvas.toBlob(async (blob) => {
            if (!blob) {
                reject(new Error(t('Could not create the signature image.')));
                return;
            }
            const bytes = new Uint8Array(await blob.arrayBuffer());
            resolve({ bytes, dataUrl: canvas.toDataURL('image/png'), width: canvas.width, height: canvas.height });
        }, 'image/png');
    });
}

function pointerPoint(e, el, natural) {
    const rect = el.getBoundingClientRect();
    return {
        x: ((e.clientX - rect.left) * natural.width) / rect.width,
        y: ((e.clientY - rect.top) * natural.height) / rect.height,
    };
}

function SignaturePad({ onUse }) {
    const canvasRef = useRef(null);
    const drawingRef = useRef(false);
    const [hasDrawing, setHasDrawing] = useState(false);

    function point(e) {
        const canvas = canvasRef.current;
        const rect = canvas.getBoundingClientRect();
        return { x: ((e.clientX - rect.left) * canvas.width) / rect.width, y: ((e.clientY - rect.top) * canvas.height) / rect.height };
    }

    function down(e) {
        e.preventDefault();
        drawingRef.current = true;
        const ctx = canvasRef.current.getContext('2d');
        const p = point(e);
        ctx.beginPath();
        ctx.moveTo(p.x, p.y);
    }
    function move(e) {
        if (!drawingRef.current) return;
        e.preventDefault();
        const ctx = canvasRef.current.getContext('2d');
        ctx.lineWidth = 3;
        ctx.lineCap = 'round';
        ctx.lineJoin = 'round';
        ctx.strokeStyle = '#1e293b';
        const p = point(e);
        ctx.lineTo(p.x, p.y);
        ctx.stroke();
        setHasDrawing(true);
    }
    function up() {
        drawingRef.current = false;
    }
    function clear() {
        const canvas = canvasRef.current;
        canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
        setHasDrawing(false);
    }

    return (
        <div className="stack">
            <canvas
                ref={canvasRef}
                width={500}
                height={180}
                className="signature-pad"
                aria-label={t('Draw your signature here')}
                onPointerDown={down}
                onPointerMove={move}
                onPointerUp={up}
                onPointerLeave={up}
            />
            <div className="row">
                <button type="button" className="btn btn--sm" onClick={clear} disabled={!hasDrawing}>{t('Clear')}</button>
                <button type="button" className="btn btn--primary btn--sm" disabled={!hasDrawing} onClick={() => onUse(canvasRef.current)}>
                    {t('Use this signature')}
                </button>
            </div>
        </div>
    );
}

function TypedSignature({ onUse }) {
    const [name, setName] = useState('');

    function use() {
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');
        canvas.width = 500;
        canvas.height = 150;
        ctx.font = "60px 'Brush Script MT', cursive";
        const width = Math.min(480, Math.max(ctx.measureText(name).width + 40, 140));
        canvas.width = width;
        ctx.font = "60px 'Brush Script MT', cursive";
        ctx.fillStyle = '#1e293b';
        ctx.textBaseline = 'middle';
        ctx.fillText(name, 16, canvas.height / 2);
        onUse(canvas);
    }

    return (
        <div className="stack">
            <input
                className="input"
                style={{ fontFamily: "'Brush Script MT', cursive", fontSize: '1.7rem' }}
                value={name}
                onChange={(e) => setName(e.target.value)}
                placeholder={t('Type your name')}
                maxLength={60}
                aria-label={t('Type your name')}
            />
            <button type="button" className="btn btn--primary btn--sm" disabled={!name.trim()} onClick={use}>
                {t('Use this signature')}
            </button>
        </div>
    );
}

function UploadSignature({ onUse, onError }) {
    function handleFiles([file]) {
        const img = new Image();
        const url = URL.createObjectURL(file);
        img.onload = () => {
            const canvas = document.createElement('canvas');
            canvas.width = img.naturalWidth;
            canvas.height = img.naturalHeight;
            canvas.getContext('2d').drawImage(img, 0, 0);
            URL.revokeObjectURL(url);
            onUse(canvas);
        };
        img.onerror = () => {
            URL.revokeObjectURL(url);
            onError();
        };
        img.src = url;
    }

    return (
        <Dropzone
            accept="image/png,image/jpeg,image/webp"
            isAccepted={(f) => /^image\/(png|jpeg|webp)$/.test(f.type)}
            onFiles={handleFiles}
            onReject={onError}
            title={t('Drop a signature image or click to choose')}
            hint={t('A PNG with a transparent background works best')}
            compact
        />
    );
}

export default function SignPdf() {
    const [file, setFile] = useState(null);
    const [currentPage, setCurrentPage] = useState(0);
    const [signature, setSignature] = useState(null);
    const [mode, setMode] = useState('draw');
    const [addDate, setAddDate] = useState(false);
    const [placements, setPlacements] = useState([]);
    const [selectedId, setSelectedId] = useState(null);
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
        setPlacements([]);
        setSelectedId(null);
        setSignature(null);
        setFile(picked);
    }

    function onSignatureReady(canvas) {
        canvasToPng(canvas)
            .then((sig) => setSignature(sig))
            .catch((e) => setError(e.message));
    }

    function onPageReady({ width, height }) {
        setCanvasSize({ width, height });
    }

    function addToPage() {
        if (!signature || !canvasSize.width) return;
        setResult(null);
        const targetWidth = Math.min(canvasSize.width * 0.45, 260);
        const box = signatureBoxSize(signature.width, signature.height, targetWidth);
        const rect = clampRect(
            { x: (canvasSize.width - box.width) / 2, y: (canvasSize.height - box.height) / 2, width: box.width, height: box.height },
            canvasSize.width,
            canvasSize.height
        );
        const id = nextId.current++;
        setPlacements((list) => [
            ...list,
            { id, page: currentPage, ...rect, dataUrl: signature.dataUrl, pngBytes: signature.bytes, dateText: addDate ? formatSignatureDate(getLocale()) : null },
        ]);
        setSelectedId(id);
    }

    function removePlacement(id) {
        setPlacements((list) => list.filter((p) => p.id !== id));
        if (selectedId === id) setSelectedId(null);
        setResult(null);
    }

    function startDrag(e, id, dragMode) {
        e.preventDefault();
        e.stopPropagation();
        setSelectedId(id);
        const stage = stageRef.current;
        const natural = canvasSize;
        const placement = placements.find((p) => p.id === id);
        if (!stage || !placement) return;
        const startPoint = pointerPoint(e, stage, natural);
        const startRect = { x: placement.x, y: placement.y, width: placement.width, height: placement.height };
        const ratio = startRect.height / startRect.width;

        function handleMove(ev) {
            const p = pointerPoint(ev, stage, natural);
            const dx = p.x - startPoint.x;
            const dy = p.y - startPoint.y;
            setPlacements((list) =>
                list.map((item) => {
                    if (item.id !== id) return item;
                    if (dragMode === 'move') {
                        return { ...item, ...clampRect({ ...startRect, x: startRect.x + dx, y: startRect.y + dy }, natural.width, natural.height) };
                    }
                    const width = Math.max(30, startRect.width + dx);
                    return { ...item, ...clampRect({ x: startRect.x, y: startRect.y, width, height: width * ratio }, natural.width, natural.height) };
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
        if (!doc || working || placements.length === 0) return;
        setWorking(true);
        setError('');
        try {
            const toBuild = placements.map((p) => {
                const size = doc.getPage(p.page).getSize();
                const scale = computeDisplayScale(size.width, size.height);
                return {
                    page: p.page,
                    pngBytes: p.pngBytes,
                    dateText: p.dateText,
                    rectPdf: canvasRectToPdfRect({ x: p.x, y: p.y, width: p.width, height: p.height }, scale, size.height),
                };
            });
            const blob = await buildSignedPdf(doc, toBuild);
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-signed.pdf`) });
        } catch (e) {
            setError(t('Signing failed: {message}', { message: e.message }));
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

    const currentPlacements = placements.filter((p) => p.page === currentPage);
    const currentPageSize = doc.getPage(currentPage).getSize();
    const scale = computeDisplayScale(currentPageSize.width, currentPageSize.height);

    return (
        <div className="stack">
            <Notice type="info">{t('This creates an electronic signature (a drawn, typed or uploaded image placed on the PDF), not a certificate-based digital signature.')}</Notice>

            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <div className="field">
                <span className="field__label">{t('1. Create your signature')}</span>
                <Tabs
                    label={t('Signature type')}
                    value={mode}
                    onChange={setMode}
                    tabs={[
                        { id: 'draw', label: t('Draw') },
                        { id: 'type', label: t('Type') },
                        { id: 'upload', label: t('Upload') },
                    ]}
                />
                <div style={{ marginTop: '0.7rem' }}>
                    {mode === 'draw' && <SignaturePad onUse={onSignatureReady} />}
                    {mode === 'type' && <TypedSignature onUse={onSignatureReady} />}
                    {mode === 'upload' && <UploadSignature onUse={onSignatureReady} onError={() => setError(t('Please choose a PNG, JPG or WebP image.'))} />}
                </div>
                {signature && (
                    <p className="field__hint">
                        {t('Signature ready.')} <img src={signature.dataUrl} alt={t('Signature preview')} style={{ height: '28px', verticalAlign: 'middle' }} />
                    </p>
                )}
            </div>

            <div className="field">
                <span className="field__label">{t('2. Place it on the page')}</span>
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
                    <label className="row" style={{ gap: '0.4rem' }}>
                        <input type="checkbox" checked={addDate} onChange={(e) => setAddDate(e.target.checked)} />
                        {t("Add today's date under the signature")}
                    </label>
                    <button type="button" className="btn btn--primary btn--sm" disabled={!signature} onClick={addToPage}>
                        {t('Add signature to this page')}
                    </button>
                </div>

                <div className="pdf-editor__stage" ref={stageRef}>
                    <PdfPageCanvas renderDoc={renderDoc} pageNumber={currentPage + 1} scale={scale} className="pdf-editor__canvas" onReady={onPageReady} />
                    {currentPlacements.map((p) => (
                        <div
                            key={p.id}
                            className={`pdf-editor__overlay${selectedId === p.id ? ' is-selected' : ''}`}
                            style={{ left: p.x, top: p.y, width: p.width, height: p.height }}
                            onPointerDown={(e) => startDrag(e, p.id, 'move')}
                            role="button"
                            tabIndex={0}
                            aria-label={t('Signature on the page - drag to move')}
                        >
                            <img src={p.dataUrl} alt="" draggable={false} />
                            {p.dateText && <span className="pdf-editor__date">{p.dateText}</span>}
                            <button
                                type="button"
                                className="pdf-editor__remove"
                                aria-label={t('Remove signature')}
                                onPointerDown={(e) => e.stopPropagation()}
                                onClick={() => removePlacement(p.id)}
                            >
                                ×
                            </button>
                            <span
                                className="pdf-editor__handle"
                                onPointerDown={(e) => startDrag(e, p.id, 'resize')}
                                aria-hidden="true"
                            />
                        </div>
                    ))}
                </div>
            </div>

            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done!')} {formatBytes(result.blob.size)}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>{t('Download PDF')}</button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={apply} disabled={working || placements.length === 0}>
                    {working ? t('Signing…') : t('Sign PDF')}
                </button>
            )}
        </div>
    );
}
