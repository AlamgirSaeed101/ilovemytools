import { useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import PdfPageCanvas from '../components/PdfPageCanvas.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { t } from '../lib/i18n.js';
import { isPdf } from '../lib/pdf.js';
import { usePdfDoc } from '../lib/pdfPages.js';
import { canvasRectToPdfRect, clampRect, computeDisplayScale } from '../lib/pdfOverlay.js';
import { buildEditedPdf, pointsToPdf, strokeBoundingBox, undoLast } from '../lib/pdfEdit.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';

const TEXT_SIZES = [12, 14, 18, 24, 32, 48];

function pointerPoint(e, el, natural) {
    const rect = el.getBoundingClientRect();
    return {
        x: ((e.clientX - rect.left) * natural.width) / rect.width,
        y: ((e.clientY - rect.top) * natural.height) / rect.height,
    };
}

function measureText(text, pxSize) {
    const canvas = measureText.canvas ?? (measureText.canvas = document.createElement('canvas'));
    const ctx = canvas.getContext('2d');
    ctx.font = `${pxSize}px sans-serif`;
    return Math.max(10, ctx.measureText(text).width);
}

export default function EditPdf() {
    const [file, setFile] = useState(null);
    const [currentPage, setCurrentPage] = useState(0);
    const [elements, setElements] = useState([]);
    const [mode, setMode] = useState('text');
    const [textValue, setTextValue] = useState('');
    const [textSize, setTextSize] = useState(18);
    const [textColor, setTextColor] = useState('#1d4ed8');
    const [highlightColor, setHighlightColor] = useState('#fde047');
    const [drawColor, setDrawColor] = useState('#dc2626');
    const [drawThickness, setDrawThickness] = useState(3);
    const [pendingImage, setPendingImage] = useState(null);
    const [drawingPoints, setDrawingPoints] = useState(null);
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
        setElements([]);
        setPendingImage(null);
        setFile(picked);
    }

    function onPageReady({ width, height }) {
        setCanvasSize({ width, height });
    }

    function pushElement(el) {
        setElements((list) => [...list, { id: nextId.current++, page: currentPage, ...el }]);
        setResult(null);
    }

    function undo() {
        setElements((list) => undoLast(list));
        setResult(null);
    }

    function removeElement(id) {
        setElements((list) => list.filter((el) => el.id !== id));
        setResult(null);
    }

    function addText() {
        if (!textValue.trim() || !canvasSize.width) return;
        const pxSize = textSize * scale;
        const width = measureText(textValue, pxSize) + 10;
        const height = pxSize * 1.35;
        const rect = clampRect({ x: (canvasSize.width - width) / 2, y: (canvasSize.height - height) / 2, width, height }, canvasSize.width, canvasSize.height, 10);
        pushElement({ type: 'text', text: textValue, size: textSize, color: textColor, ...rect });
    }

    function addImage() {
        if (!pendingImage || !canvasSize.width) return;
        const targetWidth = Math.min(canvasSize.width * 0.4, 220);
        const ratio = pendingImage.height / pendingImage.width || 1;
        const rect = clampRect(
            { x: (canvasSize.width - targetWidth) / 2, y: (canvasSize.height - targetWidth * ratio) / 2, width: targetWidth, height: targetWidth * ratio },
            canvasSize.width,
            canvasSize.height,
            20
        );
        pushElement({ type: 'image', dataUrl: pendingImage.dataUrl, bytes: pendingImage.bytes, format: 'png', ...rect });
    }

    function addHighlight() {
        if (!canvasSize.width) return;
        const width = Math.min(220, canvasSize.width * 0.5);
        const height = 28;
        const rect = clampRect({ x: (canvasSize.width - width) / 2, y: (canvasSize.height - height) / 2, width, height }, canvasSize.width, canvasSize.height, 10);
        pushElement({ type: 'highlight', color: highlightColor, ...rect });
    }

    function handleImageFile([picked]) {
        const img = new Image();
        const url = URL.createObjectURL(picked);
        img.onload = () => {
            const canvas = document.createElement('canvas');
            canvas.width = img.naturalWidth;
            canvas.height = img.naturalHeight;
            canvas.getContext('2d').drawImage(img, 0, 0);
            URL.revokeObjectURL(url);
            canvas.toBlob(async (blob) => {
                if (!blob) {
                    setError(t('Could not read that image.'));
                    return;
                }
                const bytes = new Uint8Array(await blob.arrayBuffer());
                setPendingImage({ dataUrl: canvas.toDataURL('image/png'), bytes, width: canvas.width, height: canvas.height });
            }, 'image/png');
        };
        img.onerror = () => {
            URL.revokeObjectURL(url);
            setError(t('Could not read that image.'));
        };
        img.src = url;
    }

    function startDraw(e) {
        if (mode !== 'draw' || !canvasSize.width) return;
        const stage = stageRef.current;
        const first = pointerPoint(e, stage, canvasSize);
        let points = [first];
        setDrawingPoints(points);

        function handleMove(ev) {
            points = [...points, pointerPoint(ev, stage, canvasSize)];
            setDrawingPoints(points);
        }
        function handleUp() {
            window.removeEventListener('pointermove', handleMove);
            window.removeEventListener('pointerup', handleUp);
            setDrawingPoints(null);
            if (points.length < 2) return;
            pushElement({ type: 'stroke', points, color: drawColor, thickness: drawThickness });
        }
        window.addEventListener('pointermove', handleMove);
        window.addEventListener('pointerup', handleUp);
    }

    function startDrag(e, id, dragMode) {
        e.preventDefault();
        e.stopPropagation();
        const stage = stageRef.current;
        const natural = canvasSize;
        const el = elements.find((x) => x.id === id);
        if (!stage || !el) return;
        const startPoint = pointerPoint(e, stage, natural);

        if (el.type === 'stroke') {
            const startPoints = el.points;
            const handleMove = (ev) => {
                const p = pointerPoint(ev, stage, natural);
                const dx = p.x - startPoint.x;
                const dy = p.y - startPoint.y;
                setElements((list) => list.map((item) => (item.id === id ? { ...item, points: startPoints.map((pt) => ({ x: pt.x + dx, y: pt.y + dy })) } : item)));
                setResult(null);
            };
            const handleUp = () => {
                window.removeEventListener('pointermove', handleMove);
                window.removeEventListener('pointerup', handleUp);
            };
            window.addEventListener('pointermove', handleMove);
            window.addEventListener('pointerup', handleUp);
            return;
        }

        const startRect = { x: el.x, y: el.y, width: el.width, height: el.height };
        const ratio = startRect.height / startRect.width;
        const handleMove = (ev) => {
            const p = pointerPoint(ev, stage, natural);
            const dx = p.x - startPoint.x;
            const dy = p.y - startPoint.y;
            setElements((list) =>
                list.map((item) => {
                    if (item.id !== id) return item;
                    if (dragMode === 'move') {
                        return { ...item, ...clampRect({ ...startRect, x: startRect.x + dx, y: startRect.y + dy }, natural.width, natural.height, 0) };
                    }
                    if (item.type === 'image') {
                        const width = Math.max(20, startRect.width + dx);
                        return { ...item, ...clampRect({ x: startRect.x, y: startRect.y, width, height: width * ratio }, natural.width, natural.height, 20) };
                    }
                    return { ...item, ...clampRect({ x: startRect.x, y: startRect.y, width: startRect.width + dx, height: startRect.height + dy }, natural.width, natural.height, 12) };
                })
            );
            setResult(null);
        };
        const handleUp = () => {
            window.removeEventListener('pointermove', handleMove);
            window.removeEventListener('pointerup', handleUp);
        };
        window.addEventListener('pointermove', handleMove);
        window.addEventListener('pointerup', handleUp);
    }

    async function apply() {
        if (!doc || working || elements.length === 0) return;
        setWorking(true);
        setError('');
        try {
            const toBuild = elements.map((el) => {
                const size = doc.getPage(el.page).getSize();
                const scaleForPage = computeDisplayScale(size.width, size.height);
                if (el.type === 'text') {
                    const rectPdf = canvasRectToPdfRect(el, scaleForPage, size.height);
                    return { type: 'text', page: el.page, text: el.text, size: el.size, color: el.color, x: rectPdf.x, y: rectPdf.y };
                }
                if (el.type === 'stroke') {
                    return { type: 'stroke', page: el.page, color: el.color, thickness: el.thickness / scaleForPage, points: pointsToPdf(el.points, scaleForPage, size.height) };
                }
                return { type: el.type, page: el.page, color: el.color, bytes: el.bytes, format: el.format, rectPdf: canvasRectToPdfRect(el, scaleForPage, size.height) };
            });
            const blob = await buildEditedPdf(doc, toBuild);
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-edited.pdf`) });
        } catch (e) {
            setError(t('Editing failed: {message}', { message: e.message }));
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
    const currentElements = elements.filter((el) => el.page === currentPage);

    return (
        <div className="stack">
            <Notice type="info">{t('This adds new text, images, highlights and drawings on top of the page - it cannot change or remove text that was already in the PDF.')}</Notice>

            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <div className="field">
                <Tabs
                    label={t('What to add')}
                    value={mode}
                    onChange={setMode}
                    tabs={[
                        { id: 'text', label: t('Text') },
                        { id: 'image', label: t('Image') },
                        { id: 'highlight', label: t('Highlight') },
                        { id: 'draw', label: t('Draw') },
                    ]}
                />

                <div className="pdf-editor__toolbar" style={{ marginTop: '0.7rem' }}>
                    {mode === 'text' && (
                        <>
                            <input className="input" style={{ maxWidth: '240px' }} value={textValue} onChange={(e) => setTextValue(e.target.value)} placeholder={t('Text to add')} aria-label={t('Text to add')} />
                            <select className="select" style={{ maxWidth: '110px' }} value={textSize} onChange={(e) => setTextSize(Number(e.target.value))} aria-label={t('Font size')}>
                                {TEXT_SIZES.map((s) => <option key={s} value={s}>{s}px</option>)}
                            </select>
                            <input type="color" value={textColor} onChange={(e) => setTextColor(e.target.value)} aria-label={t('Text colour')} />
                            <button type="button" className="btn btn--primary btn--sm" disabled={!textValue.trim()} onClick={addText}>{t('Add text to page')}</button>
                        </>
                    )}
                    {mode === 'image' && (
                        <>
                            <Dropzone
                                accept="image/png,image/jpeg,image/webp"
                                isAccepted={(f) => /^image\/(png|jpeg|webp)$/.test(f.type)}
                                onFiles={handleImageFile}
                                onReject={() => setError(t('Please choose a PNG, JPG or WebP image.'))}
                                title={t('Drop an image or click to choose')}
                                hint={t('PNG, JPG or WebP')}
                                compact
                            />
                            <button type="button" className="btn btn--primary btn--sm" disabled={!pendingImage} onClick={addImage}>{t('Add image to page')}</button>
                        </>
                    )}
                    {mode === 'highlight' && (
                        <>
                            <input type="color" value={highlightColor} onChange={(e) => setHighlightColor(e.target.value)} aria-label={t('Highlight colour')} />
                            <button type="button" className="btn btn--primary btn--sm" onClick={addHighlight}>{t('Add highlight to page')}</button>
                        </>
                    )}
                    {mode === 'draw' && (
                        <>
                            <input type="color" value={drawColor} onChange={(e) => setDrawColor(e.target.value)} aria-label={t('Drawing colour')} />
                            <select className="select" style={{ maxWidth: '110px' }} value={drawThickness} onChange={(e) => setDrawThickness(Number(e.target.value))} aria-label={t('Line thickness')}>
                                {[2, 3, 5, 8].map((v) => <option key={v} value={v}>{v}px</option>)}
                            </select>
                            <span className="field__hint" style={{ margin: 0 }}>{t('Draw directly on the page below')}</span>
                        </>
                    )}
                    <button type="button" className="btn btn--sm" onClick={undo} disabled={elements.length === 0}>{t('Undo')}</button>
                </div>

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
                </div>

                <div className="pdf-editor__stage" ref={stageRef} onPointerDown={startDraw}>
                    <PdfPageCanvas renderDoc={renderDoc} pageNumber={currentPage + 1} scale={scale} className="pdf-editor__canvas" onReady={onPageReady} />
                    {currentElements.map((el) => {
                        if (el.type === 'stroke') {
                            const bbox = strokeBoundingBox(el.points);
                            return (
                                <div
                                    key={el.id}
                                    className="pdf-editor__overlay"
                                    style={{ left: bbox.x, top: bbox.y, width: bbox.width, height: bbox.height, border: 'none' }}
                                    onPointerDown={(e) => startDrag(e, el.id, 'move')}
                                    role="button"
                                    tabIndex={0}
                                    aria-label={t('Drawing - drag to move')}
                                >
                                    <svg width={bbox.width} height={bbox.height} style={{ pointerEvents: 'none', overflow: 'visible' }}>
                                        <polyline
                                            points={el.points.map((p) => `${p.x - bbox.x},${p.y - bbox.y}`).join(' ')}
                                            fill="none"
                                            stroke={el.color}
                                            strokeWidth={el.thickness}
                                            strokeLinecap="round"
                                            strokeLinejoin="round"
                                        />
                                    </svg>
                                    <button type="button" className="pdf-editor__remove" aria-label={t('Remove this drawing')} onPointerDown={(e) => e.stopPropagation()} onClick={() => removeElement(el.id)}>×</button>
                                </div>
                            );
                        }
                        return (
                            <div
                                key={el.id}
                                className={`pdf-editor__overlay${el.type === 'highlight' ? ' pdf-editor__overlay--highlight' : ''}`}
                                style={{
                                    left: el.x,
                                    top: el.y,
                                    width: el.width,
                                    height: el.height,
                                    background: el.type === 'highlight' ? el.color : undefined,
                                    borderStyle: el.type === 'text' ? 'none' : undefined,
                                }}
                                onPointerDown={(e) => startDrag(e, el.id, 'move')}
                                role="button"
                                tabIndex={0}
                                aria-label={el.type === 'text' ? t('Text - drag to move') : el.type === 'image' ? t('Image - drag to move') : t('Highlight - drag to move')}
                            >
                                {el.type === 'text' && (
                                    <span style={{ fontSize: el.size * scale, color: el.color, lineHeight: 1, whiteSpace: 'nowrap', pointerEvents: 'none' }}>{el.text}</span>
                                )}
                                {el.type === 'image' && <img src={el.dataUrl} alt="" draggable={false} />}
                                <button
                                    type="button"
                                    className="pdf-editor__remove"
                                    aria-label={el.type === 'text' ? t('Remove this text') : el.type === 'image' ? t('Remove this image') : t('Remove this highlight')}
                                    onPointerDown={(e) => e.stopPropagation()}
                                    onClick={() => removeElement(el.id)}
                                >
                                    ×
                                </button>
                                {el.type !== 'text' && <span className="pdf-editor__handle" onPointerDown={(e) => startDrag(e, el.id, 'resize')} aria-hidden="true" />}
                            </div>
                        );
                    })}
                    {drawingPoints && drawingPoints.length > 1 && (
                        <svg className="pdf-editor__overlay" style={{ left: 0, top: 0, width: canvasSize.width, height: canvasSize.height, border: 'none', pointerEvents: 'none' }}>
                            <polyline points={drawingPoints.map((p) => `${p.x},${p.y}`).join(' ')} fill="none" stroke={drawColor} strokeWidth={drawThickness} strokeLinecap="round" strokeLinejoin="round" />
                        </svg>
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
                <button type="button" className="btn btn--primary btn--lg" onClick={apply} disabled={working || elements.length === 0}>
                    {working ? t('Saving…') : t('Save PDF')}
                </button>
            )}
        </div>
    );
}
