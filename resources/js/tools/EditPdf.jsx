import { useEffect, useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import PdfPageCanvas from '../components/PdfPageCanvas.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { t, tn } from '../lib/i18n.js';
import { isPdf } from '../lib/pdf.js';
import { usePdfDoc } from '../lib/pdfPages.js';
import { canvasRectToPdfRect, clampRect, computeDisplayScale, pdfRectToCanvasRect, rectFromPoints } from '../lib/pdfOverlay.js';
import { loadRenderDoc, renderPageToCanvas } from '../lib/pdfRender.js';
import { colorsFromCanvas, coverRect, extractPageRuns, missingGlyphs } from '../lib/pdfTextRuns.js';
import { arrowHeadLines, normalizeLinkUrl, pointsToPdf, strokeBoundingBox, undoLast } from '../lib/pdfEditShapes.js';
import { imageWatermarkSize, watermarkPageIndexes } from '../lib/pdfWatermarkLayout.js';

// pdf-lib (~165 KB) only loads when a PDF is previewed or saved, not with the page.
const loadWatermark = () => import('../lib/pdfWatermark.js');
const loadEdit = () => import('../lib/pdfEdit.js');
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';

const TEXT_SIZES = [12, 14, 18, 24, 32, 48];
const ZOOM_MIN = 50;
const ZOOM_MAX = 200;
const ZOOM_STEP = 25;
const SHAPES = [
    { id: 'rect', label: () => t('Rectangle') },
    { id: 'ellipse', label: () => t('Ellipse') },
    { id: 'line', label: () => t('Line') },
    { id: 'arrow', label: () => t('Arrow') },
];
const WATERMARK_TEXT_SIZES = [24, 32, 48, 64, 96];
const WATERMARK_POSITIONS = [
    { id: 'center', label: () => t('Centre') },
    { id: 'top-left', label: () => t('Top left') },
    { id: 'top-right', label: () => t('Top right') },
    { id: 'bottom-left', label: () => t('Bottom left') },
    { id: 'bottom-right', label: () => t('Bottom right') },
    { id: 'tile', label: () => t('Tiled across the page') },
];
const WATERMARK_LAYERS = [
    { id: 'over', label: () => t('On top of the content') },
    { id: 'under', label: () => t('Behind the content (background)') },
];
const WATERMARK_SCOPES = [
    { id: 'all', label: () => t('All pages') },
    { id: 'odd', label: () => t('Odd pages') },
    { id: 'even', label: () => t('Even pages') },
    { id: 'skip-first', label: () => t('All pages except the first') },
    { id: 'range', label: () => t('Choose pages') },
];
// Modes where dragging on the page creates the element (instead of an "Add" button).
const DRAG_MODES = ['whiteout', 'shape', 'underline', 'strike', 'link'];
// CSS stand-ins for the fonts pdfTextEdit.fontForEdit() falls back to (DejaVu Sans, Times, Courier).
const FALLBACK_CSS = {
    sans: '"DejaVu Sans", Verdana, Arial, sans-serif',
    serif: '"Times New Roman", Times, serif',
    mono: '"Courier New", Courier, monospace',
};
const OVERLAY_LABELS = {
    text: { drag: () => t('Text - drag to move'), remove: () => t('Remove this text') },
    image: { drag: () => t('Image - drag to move'), remove: () => t('Remove this image') },
    highlight: { drag: () => t('Highlight - drag to move'), remove: () => t('Remove this highlight') },
    whiteout: { drag: () => t('Whiteout - drag to move'), remove: () => t('Remove this whiteout') },
    shape: { drag: () => t('Shape - drag to move'), remove: () => t('Remove this shape') },
    underline: { drag: () => t('Underline - drag to move'), remove: () => t('Remove this underline') },
    strike: { drag: () => t('Strikethrough - drag to move'), remove: () => t('Remove this strikethrough') },
    link: { drag: () => t('Link - drag to move'), remove: () => t('Remove this link') },
};
const isLine = (el) => el.type === 'stroke' || (el.type === 'shape' && (el.shape === 'line' || el.shape === 'arrow'));

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

export default function EditPdf({ initialMode } = {}) {
    const [file, setFile] = useState(null);
    const [currentPage, setCurrentPage] = useState(0);
    const [elements, setElements] = useState([]);
    const [redoStack, setRedoStack] = useState([]);
    const [mode, setMode] = useState(initialMode ?? 'edittext');
    const [pageRuns, setPageRuns] = useState([]);
    const [runsReady, setRunsReady] = useState(false);
    const [editingId, setEditingId] = useState(null);
    const [missing, setMissing] = useState([]);
    const [findText, setFindText] = useState('');
    const [replaceText, setReplaceText] = useState('');
    const [replaceInfo, setReplaceInfo] = useState('');
    const [textValue, setTextValue] = useState('');
    const [textSize, setTextSize] = useState(18);
    const [textColor, setTextColor] = useState('#1d4ed8');
    const [highlightColor, setHighlightColor] = useState('#fde047');
    const [drawColor, setDrawColor] = useState('#dc2626');
    const [drawThickness, setDrawThickness] = useState(3);
    const [shapeKind, setShapeKind] = useState('rect');
    const [shapeColor, setShapeColor] = useState('#dc2626');
    const [shapeThickness, setShapeThickness] = useState(3);
    const [shapeFill, setShapeFill] = useState(false);
    const [markupColor, setMarkupColor] = useState('#dc2626');
    const [linkUrl, setLinkUrl] = useState('');
    const [dragBox, setDragBox] = useState(null);
    const [pendingImage, setPendingImage] = useState(null);
    const [drawingPoints, setDrawingPoints] = useState(null);
    const [canvasSize, setCanvasSize] = useState({ width: 0, height: 0 });
    const [zoomPct, setZoomPct] = useState(100);
    const [wmKind, setWmKind] = useState('text');
    const [wmText, setWmText] = useState('');
    const [wmTextSize, setWmTextSize] = useState(48);
    const [wmTextColor, setWmTextColor] = useState('#6b7280');
    const [wmTextBold, setWmTextBold] = useState(true);
    const [wmPendingImage, setWmPendingImage] = useState(null);
    const [wmImageScalePct, setWmImageScalePct] = useState(30);
    const [wmOpacityPct, setWmOpacityPct] = useState(30);
    const [wmRotation, setWmRotation] = useState(-45);
    const [wmPosition, setWmPosition] = useState('center');
    const [wmLayer, setWmLayer] = useState('over');
    const [wmFlatten, setWmFlatten] = useState(false);
    const [wmScope, setWmScope] = useState('all');
    const [wmRangeText, setWmRangeText] = useState('');
    const [wmProgress, setWmProgress] = useState('');
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);
    const stageRef = useRef(null);
    const nextId = useRef(1);
    const wmPreviewCanvasRef = useRef(null);
    const wmPreviewRenderDocRef = useRef(null);
    const { status, doc, renderDoc, pageCount } = usePdfDoc(file, { keepFonts: true });

    // The editable text runs of the page on screen (pdf.js text + the PDF's own fonts).
    useEffect(() => {
        if (!renderDoc) return;
        let cancelled = false;
        setPageRuns([]);
        setRunsReady(false);
        extractPageRuns(renderDoc, currentPage + 1)
            .then((runs) => !cancelled && setPageRuns(runs))
            .catch(() => !cancelled && setPageRuns([]))
            .finally(() => !cancelled && setRunsReady(true));
        return () => {
            cancelled = true;
        };
    }, [renderDoc, currentPage]);

    const editing = elements.find((el) => el.id === editingId) ?? null;

    // Letters the selected edit needs that the PDF's own font doesn't contain (then a similar font is used).
    useEffect(() => {
        if (!editing) {
            setMissing([]);
            return;
        }
        let cancelled = false;
        missingGlyphs(editing.run.fontData, editing.text).then((letters) => {
            if (cancelled) return;
            setMissing(letters);
            // The saved PDF draws this line in a fallback font when letters are missing; preview it the same way.
            setElements((list) => list.map((el) => (el.id === editing.id ? { ...el, fallback: letters.length > 0 } : el)));
        });
        return () => {
            cancelled = true;
        };
    }, [editing?.id, editing?.text]);

    function wmContentFor(pageWidth) {
        if (wmKind === 'text') {
            if (!wmText.trim()) return null;
            return { kind: 'text', text: wmText, size: wmTextSize, bold: wmTextBold, color: wmTextColor };
        }
        if (!wmPendingImage) return null;
        const { width, height } = imageWatermarkSize(pageWidth, wmPendingImage.width, wmPendingImage.height, wmImageScalePct);
        return { kind: 'image', bytes: wmPendingImage.bytes, width, height };
    }

    function handleWatermarkImageFile([picked]) {
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
                setWmPendingImage({ dataUrl: canvas.toDataURL('image/png'), bytes, width: canvas.width, height: canvas.height });
                setResult(null);
            }, 'image/png');
        };
        img.onerror = () => {
            URL.revokeObjectURL(url);
            setError(t('Could not read that image.'));
        };
        img.src = url;
    }

    // Live preview: builds a real one-page watermarked PDF for page 1 and renders it with pdf.js,
    // so the preview always matches exactly what downloading will produce.
    useEffect(() => {
        if (mode !== 'watermark' || !doc || !renderDoc) return;
        let cancelled = false;
        const { width: pageWidth, height: pageHeight } = doc.getPage(0).getSize();
        const scaleForPreview = computeDisplayScale(pageWidth, pageHeight);
        (async () => {
            const content = wmContentFor(pageWidth);
            let sourceRenderDoc = renderDoc;
            let ownRenderDoc = null;
            if (content) {
                const { PDFDocument } = await import('pdf-lib');
                const previewDoc = await PDFDocument.create();
                const [copied] = await previewDoc.copyPages(doc, [0]);
                previewDoc.addPage(copied);
                const { buildWatermarkedPdf } = await loadWatermark();
                const blob = await buildWatermarkedPdf(previewDoc, { pageIndexes: [0], position: wmPosition, opacity: wmOpacityPct / 100, rotation: wmRotation, layer: wmLayer, content });
                const bytes = new Uint8Array(await blob.arrayBuffer());
                if (cancelled) return;
                ownRenderDoc = await loadRenderDoc(bytes);
                if (cancelled) {
                    ownRenderDoc.destroy();
                    return;
                }
                sourceRenderDoc = ownRenderDoc;
            }
            const canvas = await renderPageToCanvas(sourceRenderDoc, 1, { scale: scaleForPreview, background: '#ffffff' });
            wmPreviewRenderDocRef.current?.destroy();
            wmPreviewRenderDocRef.current = ownRenderDoc;
            if (cancelled || !wmPreviewCanvasRef.current) return;
            wmPreviewCanvasRef.current.width = canvas.width;
            wmPreviewCanvasRef.current.height = canvas.height;
            wmPreviewCanvasRef.current.getContext('2d').drawImage(canvas, 0, 0);
        })().catch(() => {
            // The preview is a convenience; a failure here never blocks the real download below.
        });
        return () => {
            cancelled = true;
        };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [mode, doc, renderDoc, wmKind, wmText, wmTextSize, wmTextColor, wmTextBold, wmPendingImage, wmImageScalePct, wmOpacityPct, wmRotation, wmPosition, wmLayer]);

    useEffect(() => () => wmPreviewRenderDocRef.current?.destroy(), []);

    // A finished watermark download no longer matches the settings once any of them change.
    useEffect(() => {
        setResult(null);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [wmKind, wmText, wmTextSize, wmTextColor, wmTextBold, wmPendingImage, wmImageScalePct, wmOpacityPct, wmRotation, wmPosition, wmLayer, wmFlatten, wmScope, wmRangeText]);

    async function applyWatermark() {
        if (!doc || working) return;
        const pageWidth = doc.getPage(0).getSize().width;
        const content = wmContentFor(pageWidth);
        if (!content) {
            setError(wmKind === 'text' ? t('Type the watermark text first.') : t('Choose a logo or image first.'));
            return;
        }
        setWorking(true);
        setError('');
        try {
            const pageIndexes = watermarkPageIndexes(pageCount, wmScope, wmRangeText);
            const { buildWatermarkedPdf, flattenPdf } = await loadWatermark();
            let blob = await buildWatermarkedPdf(doc, { pageIndexes, position: wmPosition, opacity: wmOpacityPct / 100, rotation: wmRotation, layer: wmLayer, content });
            if (wmFlatten) {
                blob = await flattenPdf(new Uint8Array(await blob.arrayBuffer()), {
                    onProgress: (page, total) => setWmProgress(t('Flattening page {page} of {total}…', { page, total })),
                });
            }
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-watermarked.pdf`) });
        } catch (e) {
            setError(t('Adding the watermark failed: {message}', { message: e.message }));
        } finally {
            setWorking(false);
            setWmProgress('');
        }
    }

    /** A text-edit element for `run`, with the colours sampled from `canvas` (rendered at `atScale`). */
    function textEditFor(run, page, canvas, atScale, text) {
        const { width, height: pageHeight } = doc.getPage(page).getSize();
        const coverPdf = coverRect(run, run.ascent, run.descent);
        const sampled = colorsFromCanvas(canvas, pdfRectToCanvasRect(coverPdf, atScale, pageHeight));
        const rect = pdfRectToCanvasRect(coverPdf, computeDisplayScale(width, pageHeight), pageHeight);
        return { type: 'textedit', page, run, text, size: run.size, color: sampled.color, background: sampled.background, ...rect };
    }

    function startTextEdit(run) {
        const existing = elements.find((el) => el.type === 'textedit' && el.page === currentPage && el.run.id === run.id);
        if (existing) {
            setEditingId(existing.id);
            return;
        }
        const canvas = stageRef.current?.querySelector('canvas');
        if (!canvas) return;
        const id = nextId.current;
        pushElement(textEditFor(run, currentPage, canvas, scale, run.str));
        setEditingId(id);
    }

    function updateElement(id, changes) {
        setElements((list) => list.map((el) => (el.id === id ? { ...el, ...changes } : el)));
        setRedoStack([]);
        setResult(null);
    }

    async function replaceAll() {
        if (!findText || working) return;
        setWorking(true);
        setReplaceInfo('');
        let count = 0;
        const added = [];
        try {
            for (let n = 1; n <= pageCount; n++) {
                // Search the wording as it is now: a line already edited is matched on its new text.
                const editOf = (run) => elements.find((el) => el.type === 'textedit' && el.page === n - 1 && el.run.id === run.id);
                const runs = (await extractPageRuns(renderDoc, n)).filter((run) => (editOf(run)?.text ?? run.str).includes(findText));
                if (runs.length === 0) continue;
                const canvas = await renderPageToCanvas(renderDoc, n, { scale: 1, background: '#ffffff' });
                for (const run of runs) {
                    const current = editOf(run);
                    const before = current?.text ?? run.str;
                    const text = before.split(findText).join(replaceText);
                    count += before.split(findText).length - 1;
                    const fallback = (await missingGlyphs(run.fontData, text)).length > 0;
                    if (current) added.push({ ...current, text, fallback });
                    else added.push({ id: nextId.current++, ...textEditFor(run, n - 1, canvas, 1, text), fallback });
                }
            }
            setElements((list) => [...list.filter((el) => !added.some((a) => a.id === el.id)), ...added]);
            setRedoStack([]);
            setResult(null);
            setReplaceInfo(count ? tn('Replaced {count} time.', 'Replaced {count} times.', count) : t('No matches found.'));
        } catch (e) {
            setError(t('Editing failed: {message}', { message: e.message }));
        } finally {
            setWorking(false);
        }
    }

    function openFile([picked]) {
        setError('');
        setResult(null);
        setCurrentPage(0);
        setElements([]);
        setPendingImage(null);
        setWmPendingImage(null);
        setEditingId(null);
        setReplaceInfo('');
        setRedoStack([]);
        setZoomPct(100);
        setFile(picked);
    }

    function onPageReady({ width, height }) {
        setCanvasSize({ width, height });
    }

    function pushElement(el) {
        setElements((list) => [...list, { id: nextId.current++, page: currentPage, ...el }]);
        setRedoStack([]);
        setResult(null);
    }

    function undo() {
        if (elements.length === 0) return;
        setRedoStack((stack) => [...stack, elements[elements.length - 1]]);
        setElements((list) => undoLast(list));
        setResult(null);
    }

    function redo() {
        if (redoStack.length === 0) return;
        setElements((list) => [...list, redoStack[redoStack.length - 1]]);
        setRedoStack((stack) => stack.slice(0, -1));
        setResult(null);
    }

    function removeElement(id) {
        setElements((list) => list.filter((el) => el.id !== id));
        setRedoStack([]);
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

    function startCreate(e) {
        const stage = stageRef.current;
        const start = pointerPoint(e, stage, canvasSize);
        let end = start;
        setDragBox({ start, end });

        function handleMove(ev) {
            const p = pointerPoint(ev, stage, canvasSize);
            end = { x: Math.min(Math.max(0, p.x), canvasSize.width), y: Math.min(Math.max(0, p.y), canvasSize.height) };
            setDragBox({ start, end });
        }
        function handleUp() {
            window.removeEventListener('pointermove', handleMove);
            window.removeEventListener('pointerup', handleUp);
            setDragBox(null);
            const rect = rectFromPoints(start.x, start.y, end.x, end.y);
            if (Math.hypot(rect.width, rect.height) < 6) return; // a click, not a drag
            if (mode === 'whiteout') pushElement({ type: 'whiteout', ...rect });
            else if (mode === 'underline' || mode === 'strike') pushElement({ type: 'markup', kind: mode, color: markupColor, ...rect, height: Math.max(8, rect.height) });
            else if (mode === 'link') pushElement({ type: 'link', url: normalizeLinkUrl(linkUrl), ...rect });
            else if (shapeKind === 'line' || shapeKind === 'arrow') pushElement({ type: 'shape', shape: shapeKind, color: shapeColor, thickness: shapeThickness, points: [start, end] });
            else pushElement({ type: 'shape', shape: shapeKind, color: shapeColor, thickness: shapeThickness, fill: shapeFill, ...rect });
        }
        window.addEventListener('pointermove', handleMove);
        window.addEventListener('pointerup', handleUp);
    }

    function startDraw(e) {
        if (mode === 'edittext') setEditingId(null);
        if (!canvasSize.width) return;
        if (DRAG_MODES.includes(mode)) {
            if (mode === 'link' && !normalizeLinkUrl(linkUrl)) {
                setError(t('Type a valid link address first, for example https://example.com'));
                return;
            }
            setError('');
            e.preventDefault();
            startCreate(e);
            return;
        }
        if (mode !== 'draw') return;
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
        if (!stage || !el || el.type === 'textedit') return;
        const startPoint = pointerPoint(e, stage, natural);

        if (isLine(el)) {
            const startPoints = el.points;
            const handleMove = (ev) => {
                const p = pointerPoint(ev, stage, natural);
                const dx = p.x - startPoint.x;
                const dy = p.y - startPoint.y;
                setElements((list) => list.map((item) => (item.id === id ? { ...item, points: startPoints.map((pt) => ({ x: pt.x + dx, y: pt.y + dy })) } : item)));
                setRedoStack([]);
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
            setRedoStack([]);
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
                if (el.type === 'textedit') {
                    return { type: 'textedit', page: el.page, run: el.run, text: el.text, size: el.size, color: el.color, background: el.background };
                }
                if (isLine(el)) {
                    return { ...el, thickness: el.thickness / scaleForPage, points: pointsToPdf(el.points, scaleForPage, size.height) };
                }
                return { ...el, thickness: el.thickness / scaleForPage, rectPdf: canvasRectToPdfRect(el, scaleForPage, size.height) };
            });
            const { buildEditedPdf } = await loadEdit();
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
    const zoomFactor = zoomPct / 100;

    return (
        <div className="stack">
            {mode !== 'edittext' && mode !== 'watermark' && (
                <Notice type="info">{t('This adds new content on top of the page. To change text that is already in the PDF, use the Edit text tab.')}</Notice>
            )}

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
                        { id: 'edittext', label: t('Edit text') },
                        { id: 'text', label: t('Add text') },
                        { id: 'image', label: t('Image') },
                        { id: 'highlight', label: t('Highlight') },
                        { id: 'underline', label: t('Underline') },
                        { id: 'strike', label: t('Strikethrough') },
                        { id: 'whiteout', label: t('Whiteout') },
                        { id: 'shape', label: t('Shapes') },
                        { id: 'link', label: t('Link') },
                        { id: 'draw', label: t('Draw') },
                        { id: 'watermark', label: t('Watermark') },
                    ]}
                />

                {mode === 'watermark' ? (
                <div className="grid-2" style={{ marginTop: '0.7rem' }}>
                    <div className="field">
                        <Tabs
                            label={t('Watermark type')}
                            value={wmKind}
                            onChange={setWmKind}
                            tabs={[{ id: 'text', label: t('Text') }, { id: 'image', label: t('Logo or image') }]}
                        />

                        {wmKind === 'text' ? (
                            <div className="stack" style={{ gap: '.6rem', marginTop: '.7rem' }}>
                                <input
                                    className="input"
                                    value={wmText}
                                    onChange={(e) => setWmText(e.target.value)}
                                    placeholder={t('e.g. CONFIDENTIAL, DRAFT, Your Company')}
                                    aria-label={t('Watermark text')}
                                />
                                <div className="row">
                                    <select className="select" style={{ maxWidth: '110px' }} value={wmTextSize} onChange={(e) => setWmTextSize(Number(e.target.value))} aria-label={t('Font size')}>
                                        {WATERMARK_TEXT_SIZES.map((s) => <option key={s} value={s}>{s}px</option>)}
                                    </select>
                                    <input type="color" value={wmTextColor} onChange={(e) => setWmTextColor(e.target.value)} aria-label={t('Text colour')} />
                                    <label className="check">
                                        <input type="checkbox" checked={wmTextBold} onChange={(e) => setWmTextBold(e.target.checked)} /> {t('Bold')}
                                    </label>
                                </div>
                            </div>
                        ) : (
                            <div className="stack" style={{ gap: '.6rem', marginTop: '.7rem' }}>
                                <Dropzone
                                    accept="image/png,image/jpeg,image/webp"
                                    isAccepted={(f) => /^image\/(png|jpeg|webp)$/.test(f.type)}
                                    onFiles={handleWatermarkImageFile}
                                    onReject={() => setError(t('Please choose a PNG, JPG or WebP image.'))}
                                    title={wmPendingImage ? t('Choose a different image') : t('Drop an image or click to choose')}
                                    hint={t('PNG, JPG or WebP · a transparent PNG logo works best')}
                                    compact
                                />
                                <div className="field">
                                    <label className="field__label" htmlFor="wm-image-size">{t('Logo size: {value}% of the page width', { value: wmImageScalePct })}</label>
                                    <input id="wm-image-size" className="range" type="range" min={5} max={80} step={5} value={wmImageScalePct} onChange={(e) => setWmImageScalePct(Number(e.target.value))} />
                                </div>
                            </div>
                        )}

                        <div className="field">
                            <label className="field__label" htmlFor="wm-opacity">{t('Opacity: {value}%', { value: wmOpacityPct })}</label>
                            <input id="wm-opacity" className="range" type="range" min={5} max={100} step={5} value={wmOpacityPct} onChange={(e) => setWmOpacityPct(Number(e.target.value))} />
                        </div>

                        <div className="field">
                            <label className="field__label" htmlFor="wm-rotation">{t('Rotation: {value}°', { value: wmRotation })}</label>
                            <input id="wm-rotation" className="range" type="range" min={-180} max={180} step={5} value={wmRotation} onChange={(e) => setWmRotation(Number(e.target.value))} />
                        </div>

                        <div className="field">
                            <label className="field__label" htmlFor="wm-position">{t('Position')}</label>
                            <select id="wm-position" className="select" value={wmPosition} onChange={(e) => setWmPosition(e.target.value)}>
                                {WATERMARK_POSITIONS.map((p) => <option key={p.id} value={p.id}>{p.label()}</option>)}
                            </select>
                        </div>

                        <div className="field">
                            <label className="field__label" htmlFor="wm-layer">{t('Layer')}</label>
                            <select id="wm-layer" className="select" value={wmLayer} onChange={(e) => setWmLayer(e.target.value)}>
                                {WATERMARK_LAYERS.map((l) => <option key={l.id} value={l.id}>{l.label()}</option>)}
                            </select>
                            {wmLayer === 'under' && (
                                <p className="field__hint">{t('A scanned page or a page with a solid background can hide a watermark placed behind the content.')}</p>
                            )}
                        </div>

                        <div className="field">
                            <label className="field__label" htmlFor="wm-scope">{t('Pages')}</label>
                            <select id="wm-scope" className="select" value={wmScope} onChange={(e) => setWmScope(e.target.value)}>
                                {WATERMARK_SCOPES.map((s) => <option key={s.id} value={s.id}>{s.label()}</option>)}
                            </select>
                            {wmScope === 'range' && (
                                <input
                                    className="input"
                                    style={{ marginTop: '.5rem' }}
                                    value={wmRangeText}
                                    onChange={(e) => setWmRangeText(e.target.value)}
                                    placeholder={t('e.g. 1-3, 5')}
                                    aria-label={t('Page range')}
                                />
                            )}
                        </div>

                        <div className="field">
                            <label className="check">
                                <input type="checkbox" checked={wmFlatten} onChange={(e) => setWmFlatten(e.target.checked)} /> {t('Flatten pages so the watermark can’t be removed')}
                            </label>
                            <p className="field__hint">{t('Each page becomes an image: the watermark can no longer be deleted, but the text is no longer selectable or searchable and the file may be larger.')}</p>
                        </div>
                    </div>

                    <div className="field">
                        <span className="field__label">{t('Preview of page 1')}</span>
                        <div className="pdf-editor__stage" style={{ cursor: 'default' }}>
                            <canvas ref={wmPreviewCanvasRef} className="pdf-editor__canvas" aria-label={t('Preview of page 1')} />
                        </div>
                    </div>
                </div>
                ) : (
                <>
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
                    {mode === 'edittext' && !editing && (
                        <span className="field__hint" style={{ margin: 0 }}>
                            {runsReady && pageRuns.length === 0 ? t('No editable text was found on this page (it may be a scanned image).') : t('Click any text on the page to change it.')}
                        </span>
                    )}
                    {mode === 'edittext' && editing && (
                        <>
                            <input
                                className="input"
                                type="number"
                                style={{ maxWidth: '90px' }}
                                min={4}
                                max={200}
                                step={0.5}
                                value={Math.round(editing.size * 10) / 10}
                                onChange={(e) => updateElement(editing.id, { size: Math.min(200, Math.max(4, Number(e.target.value) || editing.size)) })}
                                aria-label={t('Font size')}
                            />
                            <input type="color" value={editing.color} onChange={(e) => updateElement(editing.id, { color: e.target.value })} aria-label={t('Text colour')} />
                            <button type="button" className="btn btn--sm" onClick={() => { removeElement(editing.id); setEditingId(null); }}>{t('Restore original')}</button>
                            <button type="button" className="btn btn--primary btn--sm" onClick={() => setEditingId(null)}>{t('Done')}</button>
                        </>
                    )}
                    {mode === 'whiteout' && <span className="field__hint" style={{ margin: 0 }}>{t('Drag on the page to cover content with white.')}</span>}
                    {(mode === 'underline' || mode === 'strike') && (
                        <>
                            <input type="color" value={markupColor} onChange={(e) => setMarkupColor(e.target.value)} aria-label={t('Line colour')} />
                            <span className="field__hint" style={{ margin: 0 }}>{mode === 'underline' ? t('Drag across the text to underline it.') : t('Drag across the text to strike it through.')}</span>
                        </>
                    )}
                    {mode === 'shape' && (
                        <>
                            <select className="select" style={{ maxWidth: '140px' }} value={shapeKind} onChange={(e) => setShapeKind(e.target.value)} aria-label={t('Shape')}>
                                {SHAPES.map((sh) => <option key={sh.id} value={sh.id}>{sh.label()}</option>)}
                            </select>
                            <input type="color" value={shapeColor} onChange={(e) => setShapeColor(e.target.value)} aria-label={t('Shape colour')} />
                            <select className="select" style={{ maxWidth: '110px' }} value={shapeThickness} onChange={(e) => setShapeThickness(Number(e.target.value))} aria-label={t('Line thickness')}>
                                {[1, 2, 3, 5, 8].map((v) => <option key={v} value={v}>{v}px</option>)}
                            </select>
                            {(shapeKind === 'rect' || shapeKind === 'ellipse') && (
                                <label className="check"><input type="checkbox" checked={shapeFill} onChange={(e) => setShapeFill(e.target.checked)} /> {t('Filled')}</label>
                            )}
                            <span className="field__hint" style={{ margin: 0 }}>{t('Drag on the page to draw the shape.')}</span>
                        </>
                    )}
                    {mode === 'link' && (
                        <>
                            <input className="input" style={{ maxWidth: '260px' }} value={linkUrl} onChange={(e) => setLinkUrl(e.target.value)} placeholder="https://" aria-label={t('Link address')} inputMode="url" />
                            <span className="field__hint" style={{ margin: 0 }}>{t('Then drag on the page over the area that should open the link.')}</span>
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
                    <button type="button" className="btn btn--sm" onClick={redo} disabled={redoStack.length === 0}>{t('Redo')}</button>
                </div>

                {mode === 'edittext' && editing && missing.length > 0 && (
                    <Notice type="warn">{t('The PDF’s own font doesn’t include {letters}, so this line will use a similar font.', { letters: missing.join(' ') })}</Notice>
                )}
                {mode === 'edittext' && (
                    <div className="pdf-editor__toolbar">
                        <input className="input" style={{ maxWidth: '180px' }} value={findText} onChange={(e) => setFindText(e.target.value)} placeholder={t('Find')} aria-label={t('Find')} />
                        <input className="input" style={{ maxWidth: '180px' }} value={replaceText} onChange={(e) => setReplaceText(e.target.value)} placeholder={t('Replace with')} aria-label={t('Replace with')} />
                        <button type="button" className="btn btn--sm" onClick={replaceAll} disabled={!findText || working}>{t('Replace all')}</button>
                        {replaceInfo && <span className="field__hint" style={{ margin: 0 }} aria-live="polite">{replaceInfo}</span>}
                    </div>
                )}

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
                    <div className="pdf-editor__zoom">
                        <button type="button" className="btn btn--sm" onClick={() => setZoomPct((z) => Math.max(ZOOM_MIN, z - ZOOM_STEP))} disabled={zoomPct <= ZOOM_MIN} aria-label={t('Zoom out')}>
                            −
                        </button>
                        <span className="pdf-editor__zoom-label" aria-live="polite">{t('Zoom: {value}%', { value: zoomPct })}</span>
                        <button type="button" className="btn btn--sm" onClick={() => setZoomPct((z) => Math.min(ZOOM_MAX, z + ZOOM_STEP))} disabled={zoomPct >= ZOOM_MAX} aria-label={t('Zoom in')}>
                            +
                        </button>
                        {zoomPct !== 100 && (
                            <button type="button" className="btn btn--sm btn--ghost" onClick={() => setZoomPct(100)}>{t('Reset zoom')}</button>
                        )}
                    </div>
                </div>

                <div
                    className="pdf-editor__zoomport"
                    style={{ width: canvasSize.width ? canvasSize.width * zoomFactor : undefined, height: canvasSize.height ? canvasSize.height * zoomFactor : undefined }}
                >
                <div
                    className="pdf-editor__stage"
                    ref={stageRef}
                    onPointerDown={startDraw}
                    style={{
                        transformOrigin: 'top left',
                        ...(zoomFactor !== 1 ? { transform: `scale(${zoomFactor})` } : null),
                        ...(mode === 'draw' || DRAG_MODES.includes(mode) ? { touchAction: 'none', cursor: 'crosshair' } : null),
                    }}
                >
                    <PdfPageCanvas renderDoc={renderDoc} pageNumber={currentPage + 1} scale={scale} className="pdf-editor__canvas" onReady={onPageReady} />
                    {mode === 'edittext' &&
                        pageRuns
                            .filter((run) => !currentElements.some((el) => el.type === 'textedit' && el.run.id === run.id))
                            .map((run) => {
                                const r = pdfRectToCanvasRect(coverRect(run, run.ascent, run.descent), scale, currentPageSize.height);
                                return (
                                    <button
                                        key={run.id}
                                        type="button"
                                        className="pdf-editor__textrun"
                                        style={{ left: r.x, top: r.y, width: r.width, height: r.height }}
                                        onPointerDown={(e) => e.stopPropagation()}
                                        onClick={() => startTextEdit(run)}
                                        aria-label={t('Edit text: {text}', { text: run.str })}
                                    />
                                );
                            })}
                    {currentElements.map((el) => {
                        if (el.type === 'textedit') {
                            const selected = el.id === editingId;
                            // The PDF's own font while it has every letter, otherwise the fallback the saved file will use.
                            const own = el.run.fontData && !el.fallback;
                            const fontStyle = {
                                fontFamily: own ? el.run.cssFamily : FALLBACK_CSS[el.run.family] ?? FALLBACK_CSS.sans,
                                fontSize: el.size * scale,
                                color: el.color,
                                fontWeight: own ? undefined : el.run.bold ? 700 : 400,
                                fontStyle: !own && el.run.italic ? 'italic' : undefined,
                            };
                            return (
                                <div
                                    key={el.id}
                                    className={`pdf-editor__textedit${selected ? ' is-selected' : ''}`}
                                    style={{ left: el.x, top: el.y, minWidth: el.width, height: el.height, background: el.background }}
                                    onPointerDown={(e) => {
                                        e.stopPropagation();
                                        setMode('edittext');
                                        setEditingId(el.id);
                                    }}
                                >
                                    {selected ? (
                                        <input
                                            autoFocus
                                            value={el.text}
                                            onChange={(e) => updateElement(el.id, { text: e.target.value })}
                                            onKeyDown={(e) => (e.key === 'Enter' || e.key === 'Escape') && setEditingId(null)}
                                            aria-label={t('Edit this text')}
                                            size={Math.max(1, el.text.length)}
                                            style={{ ...fontStyle, border: 0, padding: 0, margin: 0, background: 'transparent', outline: 'none', width: '100%', minWidth: el.width }}
                                        />
                                    ) : (
                                        <span style={{ ...fontStyle, whiteSpace: 'pre', pointerEvents: 'none' }}>{el.text}</span>
                                    )}
                                </div>
                            );
                        }
                        if (isLine(el)) {
                            const bbox = strokeBoundingBox(el.points);
                            const local = el.points.map((p) => ({ x: p.x - bbox.x, y: p.y - bbox.y }));
                            const head = el.shape === 'arrow' ? arrowHeadLines(local[0], local[1], Math.max(8, el.thickness * 4)) : [];
                            return (
                                <div
                                    key={el.id}
                                    className="pdf-editor__overlay"
                                    style={{ left: bbox.x, top: bbox.y, width: bbox.width, height: bbox.height, border: 'none' }}
                                    onPointerDown={(e) => startDrag(e, el.id, 'move')}
                                    role="button"
                                    tabIndex={0}
                                    aria-label={el.type === 'shape' ? t('Shape - drag to move') : t('Drawing - drag to move')}
                                >
                                    <svg width={bbox.width} height={bbox.height} style={{ pointerEvents: 'none', overflow: 'visible' }}>
                                        <polyline points={local.map((p) => `${p.x},${p.y}`).join(' ')} fill="none" stroke={el.color} strokeWidth={el.thickness} strokeLinecap="round" strokeLinejoin="round" />
                                        {head.map((h, i) => (
                                            <line key={i} x1={h.start.x} y1={h.start.y} x2={h.end.x} y2={h.end.y} stroke={el.color} strokeWidth={el.thickness} strokeLinecap="round" />
                                        ))}
                                    </svg>
                                    <button type="button" className="pdf-editor__remove" aria-label={el.type === 'shape' ? t('Remove this shape') : t('Remove this drawing')} onPointerDown={(e) => e.stopPropagation()} onClick={() => removeElement(el.id)}>×</button>
                                </div>
                            );
                        }
                        const labels = OVERLAY_LABELS[el.type === 'markup' ? el.kind : el.type] ?? OVERLAY_LABELS.highlight;
                        return (
                            <div
                                key={el.id}
                                className={`pdf-editor__overlay${el.type === 'highlight' ? ' pdf-editor__overlay--highlight' : ''}`}
                                style={{
                                    left: el.x,
                                    top: el.y,
                                    width: el.width,
                                    height: el.height,
                                    background: el.type === 'highlight' ? el.color : el.type === 'whiteout' ? '#ffffff' : el.type === 'link' ? 'rgba(37, 99, 235, 0.08)' : undefined,
                                    borderStyle: el.type === 'text' || el.type === 'markup' || el.type === 'shape' ? 'none' : undefined,
                                    borderColor: el.type === 'link' ? '#2563eb' : undefined,
                                }}
                                onPointerDown={(e) => startDrag(e, el.id, 'move')}
                                role="button"
                                tabIndex={0}
                                aria-label={labels.drag()}
                                title={el.type === 'link' ? el.url : undefined}
                            >
                                {el.type === 'text' && (
                                    <span style={{ fontSize: el.size * scale, color: el.color, lineHeight: 1, whiteSpace: 'nowrap', pointerEvents: 'none' }}>{el.text}</span>
                                )}
                                {el.type === 'image' && <img src={el.dataUrl} alt="" draggable={false} />}
                                {el.type === 'shape' && (
                                    <svg width={el.width} height={el.height} style={{ pointerEvents: 'none', overflow: 'visible', position: 'absolute', inset: 0 }}>
                                        {el.shape === 'ellipse' ? (
                                            <ellipse cx={el.width / 2} cy={el.height / 2} rx={el.width / 2} ry={el.height / 2} fill={el.fill ? el.color : 'none'} stroke={el.color} strokeWidth={el.thickness} />
                                        ) : (
                                            <rect x={0} y={0} width={el.width} height={el.height} fill={el.fill ? el.color : 'none'} stroke={el.color} strokeWidth={el.thickness} />
                                        )}
                                    </svg>
                                )}
                                {el.type === 'markup' && (
                                    <span
                                        aria-hidden="true"
                                        style={{
                                            position: 'absolute',
                                            left: 0,
                                            right: 0,
                                            height: Math.max(1.5, el.height * 0.07),
                                            background: el.color,
                                            ...(el.kind === 'strike' ? { top: '50%', transform: 'translateY(-50%)' } : { bottom: el.height * 0.08 }),
                                            pointerEvents: 'none',
                                        }}
                                    />
                                )}
                                {el.type === 'link' && (
                                    <span style={{ fontSize: 11, color: '#1d4ed8', padding: '0 4px', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis', pointerEvents: 'none' }}>{el.url}</span>
                                )}
                                <button
                                    type="button"
                                    className="pdf-editor__remove"
                                    aria-label={labels.remove()}
                                    onPointerDown={(e) => e.stopPropagation()}
                                    onClick={() => removeElement(el.id)}
                                >
                                    ×
                                </button>
                                {el.type !== 'text' && <span className="pdf-editor__handle" onPointerDown={(e) => startDrag(e, el.id, 'resize')} aria-hidden="true" />}
                            </div>
                        );
                    })}
                    {dragBox && (
                        <svg className="pdf-editor__overlay" style={{ left: 0, top: 0, width: canvasSize.width, height: canvasSize.height, border: 'none', pointerEvents: 'none' }}>
                            {mode === 'shape' && (shapeKind === 'line' || shapeKind === 'arrow') ? (
                                <line x1={dragBox.start.x} y1={dragBox.start.y} x2={dragBox.end.x} y2={dragBox.end.y} stroke={shapeColor} strokeWidth={shapeThickness} strokeLinecap="round" />
                            ) : (
                                (() => {
                                    const r = rectFromPoints(dragBox.start.x, dragBox.start.y, dragBox.end.x, dragBox.end.y);
                                    return <rect x={r.x} y={r.y} width={r.width} height={r.height} fill={mode === 'whiteout' ? '#ffffff' : 'none'} stroke="#2563eb" strokeDasharray="4 3" />;
                                })()
                            )}
                        </svg>
                    )}
                    {drawingPoints && drawingPoints.length > 1 && (
                        <svg className="pdf-editor__overlay" style={{ left: 0, top: 0, width: canvasSize.width, height: canvasSize.height, border: 'none', pointerEvents: 'none' }}>
                            <polyline points={drawingPoints.map((p) => `${p.x},${p.y}`).join(' ')} fill="none" stroke={drawColor} strokeWidth={drawThickness} strokeLinecap="round" strokeLinejoin="round" />
                        </svg>
                    )}
                </div>
                </div>
                </>
                )}
            </div>

            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done!')} {formatBytes(result.blob.size)}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>{t('Download PDF')}</button>
                </div>
            ) : mode === 'watermark' ? (
                <button type="button" className="btn btn--primary btn--lg" onClick={applyWatermark} disabled={working || !(wmKind === 'text' ? wmText.trim() : wmPendingImage)}>
                    {working ? wmProgress || t('Adding watermark…') : t('Add watermark')}
                </button>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={apply} disabled={working || elements.length === 0}>
                    {working ? t('Saving…') : t('Save PDF')}
                </button>
            )}
        </div>
    );
}
