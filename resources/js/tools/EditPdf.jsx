import { useEffect, useMemo, useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import PdfPageCanvas from '../components/PdfPageCanvas.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { getLocale, t, tn } from '../lib/i18n.js';
import { isPdf } from '../lib/pdf.js';
import { usePageThumbnails, usePdfDoc } from '../lib/pdfPages.js';
import { canvasRectToPdfRect, clampRect, computeDisplayScale, pdfRectToCanvasRect, rectFromPoints } from '../lib/pdfOverlay.js';
import { loadRenderDoc, renderPageToCanvas } from '../lib/pdfRender.js';
import { colorsFromCanvas, coverRect, extractPageRuns, missingGlyphs } from '../lib/pdfTextRuns.js';
import { angleFromCenter, arrowHeadLines, normalizeLinkUrl, pointsToPdf, strokeBoundingBox, undoLast } from '../lib/pdfEditShapes.js';
import { imageWatermarkSize, watermarkPageIndexes } from '../lib/pdfWatermarkLayout.js';
import { buildSignedPdf, formatSignatureDate, signatureBoxSize } from '../lib/pdfSign.js';
import { clearSession, fileFromSession, hasUnsavedChanges, loadSession, saveSession } from '../lib/pdfSession.js';
import {
    applyPageOps,
    defaultPageOps,
    deletePageOp,
    insertBlankPageOp,
    isPageOpsChanged,
    movePageOp,
    remapElementsForPageOps,
    rotatePageOp,
} from '../lib/pdfPageOps.js';
import { blockCanvasRect, groupRunsIntoBlocks, textEditElement, textElementToPdf } from '../lib/pdfTextBlocks.js';
import TextBlockEditor from '../components/pdf-editor/TextBlockEditor.jsx';
import TextPropsBar from '../components/pdf-editor/TextPropsBar.jsx';

// pdf-lib (~165 KB) only loads when a PDF is previewed or saved, not with the page.
const loadWatermark = () => import('../lib/pdfWatermark.js');
const loadEdit = () => import('../lib/pdfEdit.js');
const loadForm = () => import('../lib/pdfForm.js');
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';

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
// Elements with a fixed x/y/width/height box that a rotate handle can spin around its own centre.
const canRotate = (el) => el.type === 'text' || el.type === 'image' || el.type === 'highlight' || (el.type === 'shape' && !isLine(el));

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
    const [textProps, setTextProps] = useState({ family: 'sans', size: 18, color: '#1d4ed8', bold: false, italic: false, align: 'left', lineHeight: 1.2 });
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
    const [signMode, setSignMode] = useState('draw');
    const [signature, setSignature] = useState(null);
    const [signAddDate, setSignAddDate] = useState(false);
    const [signPlacements, setSignPlacements] = useState([]);
    const [signSelectedId, setSignSelectedId] = useState(null);
    const [formFields, setFormFields] = useState([]);
    const [formValues, setFormValues] = useState({});
    const [formReady, setFormReady] = useState(false);
    const [formSubMode, setFormSubMode] = useState('fill');
    const [pageOps, setPageOps] = useState(null);
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);
    const [savedSession, setSavedSession] = useState(null);
    const stageRef = useRef(null);
    const nextId = useRef(1);
    const fileBytesRef = useRef(null);
    const autosaveTimerRef = useRef(null);
    const wmPreviewCanvasRef = useRef(null);
    const wmPreviewRenderDocRef = useRef(null);
    const { status, doc, renderDoc, pageCount } = usePdfDoc(file, { keepFonts: true });
    const thumbs = usePageThumbnails(renderDoc, pageCount);

    // Starts the page-management list at the document's own order once it is known, unless a
    // resumed session already restored one.
    useEffect(() => {
        if (pageCount > 0) setPageOps((prev) => prev ?? defaultPageOps(pageCount));
    }, [pageCount]);

    // A previous visit left unfinished work: offer to resume it before the dropzone is shown.
    useEffect(() => {
        loadSession()
            .then((session) => setSavedSession(session))
            .catch(() => setSavedSession(null));
    }, []);

    // Caches the open file's bytes once, so auto-save doesn't re-read a possibly large file on every edit.
    useEffect(() => {
        fileBytesRef.current = null;
        if (!file) return;
        let cancelled = false;
        file.arrayBuffer().then((buf) => {
            if (!cancelled) fileBytesRef.current = buf;
        });
        return () => {
            cancelled = true;
        };
    }, [file]);

    // Auto-saves to IndexedDB as the user works, and clears the save once there is nothing left to lose.
    useEffect(() => {
        if (!file) return;
        if (!hasUnsavedChanges(elements) && !isPageOpsChanged(pageOps, pageCount)) {
            clearSession().catch(() => {});
            return;
        }
        autosaveTimerRef.current = setTimeout(() => {
            if (!fileBytesRef.current) return;
            saveSession({ fileName: file.name, fileType: file.type, fileBytes: fileBytesRef.current, elements, currentPage, mode, pageOps }).catch(() => {});
        }, 800);
        return () => clearTimeout(autosaveTimerRef.current);
    }, [file, elements, currentPage, mode, pageOps, pageCount]);

    // Warns before the tab closes or navigates away while there is unsaved work.
    useEffect(() => {
        if (!hasUnsavedChanges(elements) && !isPageOpsChanged(pageOps, pageCount)) return;
        function onBeforeUnload(e) {
            e.preventDefault();
            e.returnValue = '';
        }
        window.addEventListener('beforeunload', onBeforeUnload);
        return () => window.removeEventListener('beforeunload', onBeforeUnload);
    }, [elements, pageOps, pageCount]);

    function resumeSession() {
        if (!savedSession) return;
        const restored = fileFromSession(savedSession);
        nextId.current = 1 + Math.max(0, ...savedSession.elements.map((el) => el.id));
        setElements(savedSession.elements);
        setCurrentPage(savedSession.currentPage || 0);
        setMode(savedSession.mode || 'edittext');
        setPageOps(savedSession.pageOps ?? null);
        setSavedSession(null);
        setFile(restored);
    }

    function discardSavedSession() {
        clearSession().catch(() => {});
        setSavedSession(null);
    }

    /** Confirms before anything that would discard unsaved work (a new upload, or picking another PDF). */
    function confirmDiscard() {
        return (!hasUnsavedChanges(elements) && !isPageOpsChanged(pageOps, pageCount)) || window.confirm(t('Discard your unsaved changes to this PDF?'));
    }

    function downloadResult() {
        if (!result) return;
        downloadBlob(result.blob, result.name);
        clearTimeout(autosaveTimerRef.current);
        clearSession().catch(() => {});
    }

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
    // Lines of one paragraph (same font, size, edge, spacing) are edited together as one block.
    const pageBlocks = useMemo(() => groupRunsIntoBlocks(pageRuns), [pageRuns]);

    const editing = elements.find((el) => el.id === editingId) ?? null;

    // Letters the selected edit needs that the PDF's own font doesn't contain (then a similar font is used).
    useEffect(() => {
        if (editing?.type !== 'textedit') {
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

    // The PDF's own fillable fields (text, checkbox, dropdown, radio), read once per file.
    useEffect(() => {
        if (mode !== 'form' || !doc) return;
        let cancelled = false;
        setFormReady(false);
        loadForm()
            .then(({ readFormFields }) => {
                if (cancelled) return;
                const detected = readFormFields(doc);
                setFormFields(detected);
                setFormValues((prev) => {
                    const next = { ...prev };
                    for (const f of detected) {
                        if (f.type === 'radio') {
                            if (!(f.name in next) && f.value) next[f.name] = f.value;
                        } else if (!(f.name in next)) next[f.name] = f.value;
                    }
                    return next;
                });
            })
            .catch(() => !cancelled && setFormFields([]))
            .finally(() => !cancelled && setFormReady(true));
        return () => {
            cancelled = true;
        };
    }, [mode, doc]);

    function setFormValue(name, value) {
        setFormValues((prev) => ({ ...prev, [name]: value }));
        setResult(null);
    }

    async function applyForm() {
        if (!doc || working || formFields.length === 0) return;
        setWorking(true);
        setError('');
        try {
            const { buildFilledFormPdf } = await loadForm();
            const blob = await buildFilledFormPdf(doc, formValues);
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-filled.pdf`) });
        } catch (e) {
            setError(t('Filling the form failed: {message}', { message: e.message }));
        } finally {
            setWorking(false);
        }
    }

    /** The first "Text field N" / "Checkbox N" / "Dropdown N" / "Signature N" name not already used by an existing or a new field. */
    function nextFieldName(kind) {
        const prefix = kind === 'checkbox' ? 'Checkbox' : kind === 'dropdown' ? 'Dropdown' : kind === 'signature' ? 'Signature' : 'Text field';
        const used = new Set([...formFields.map((f) => f.name), ...elements.filter((el) => el.type === 'formfield').map((el) => el.name)]);
        let n = 1;
        while (used.has(`${prefix} ${n}`)) n += 1;
        return `${prefix} ${n}`;
    }

    function addFormField(kind) {
        if (!canvasSize.width) return;
        const width = kind === 'checkbox' ? 24 : 160;
        const height = kind === 'checkbox' ? 24 : kind === 'dropdown' ? 54 : kind === 'signature' ? 50 : 32;
        const rect = clampRect({ x: (canvasSize.width - width) / 2, y: (canvasSize.height - height) / 2, width, height }, canvasSize.width, canvasSize.height, 10);
        pushElement({ type: 'formfield', fieldType: kind, name: nextFieldName(kind), ...(kind === 'dropdown' ? { optionsText: '' } : {}), ...rect });
    }

    async function applyNewFormFields() {
        if (!doc || working) return;
        const toCreate = elements.filter((el) => el.type === 'formfield');
        if (toCreate.length === 0) return;
        setWorking(true);
        setError('');
        try {
            const { validateNewFieldNames, buildPdfWithNewFields, parseDropdownOptions } = await loadForm();
            const named = toCreate.map((el) => ({
                ...el,
                name: el.name.trim(),
                ...(el.fieldType === 'dropdown' ? { options: parseDropdownOptions(el.optionsText) } : {}),
            }));
            const check = validateNewFieldNames(named, formFields.map((f) => f.name));
            if (!check.ok) {
                setError(
                    check.reason === 'duplicate'
                        ? t('Two fields can’t share the name "{name}". Give each field its own name.', { name: check.name })
                        : check.reason === 'options'
                          ? t('Give the dropdown "{name}" at least two options, separated by commas.', { name: check.name })
                          : t('Give every new field a name before saving.')
                );
                return;
            }
            const fields = named.map((el) => {
                const size = doc.getPage(el.page).getSize();
                const scaleForPage = computeDisplayScale(size.width, size.height);
                return {
                    fieldType: el.fieldType,
                    name: el.name,
                    page: el.page,
                    rectPdf: canvasRectToPdfRect(el, scaleForPage, size.height),
                    ...(el.fieldType === 'dropdown' ? { options: el.options } : {}),
                };
            });
            const blob = await buildPdfWithNewFields(doc, fields);
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-form.pdf`) });
        } catch (e) {
            setError(t('Adding the field failed: {message}', { message: e.message }));
        } finally {
            setWorking(false);
        }
    }

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

    function onSignatureReady(canvas) {
        canvasToPng(canvas)
            .then((sig) => setSignature(sig))
            .catch((e) => setError(e.message));
    }

    function addSignatureToPage() {
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
        setSignPlacements((list) => [
            ...list,
            { id, page: currentPage, ...rect, dataUrl: signature.dataUrl, pngBytes: signature.bytes, dateText: signAddDate ? formatSignatureDate(getLocale()) : null },
        ]);
        setSignSelectedId(id);
    }

    function removeSignPlacement(id) {
        setSignPlacements((list) => list.filter((p) => p.id !== id));
        if (signSelectedId === id) setSignSelectedId(null);
        setResult(null);
    }

    function startSignDrag(e, id, dragMode) {
        e.preventDefault();
        e.stopPropagation();
        setSignSelectedId(id);
        const stage = stageRef.current;
        const natural = canvasSize;
        const placement = signPlacements.find((p) => p.id === id);
        if (!stage || !placement) return;
        const startPoint = pointerPoint(e, stage, natural);
        const startRect = { x: placement.x, y: placement.y, width: placement.width, height: placement.height };
        const ratio = startRect.height / startRect.width;

        function handleMove(ev) {
            const p = pointerPoint(ev, stage, natural);
            const dx = p.x - startPoint.x;
            const dy = p.y - startPoint.y;
            setSignPlacements((list) =>
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

    async function applySignature() {
        if (!doc || working || signPlacements.length === 0) return;
        setWorking(true);
        setError('');
        try {
            const toBuild = signPlacements.map((p) => {
                const size = doc.getPage(p.page).getSize();
                const scaleForPage = computeDisplayScale(size.width, size.height);
                return {
                    page: p.page,
                    pngBytes: p.pngBytes,
                    dateText: p.dateText,
                    rectPdf: canvasRectToPdfRect({ x: p.x, y: p.y, width: p.width, height: p.height }, scaleForPage, size.height),
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

    /** A text-edit element for a paragraph `block`, with the colours sampled from `canvas` (rendered at `atScale`). */
    function textEditFor(block, page, canvas, atScale, text) {
        const { width, height: pageHeight } = doc.getPage(page).getSize();
        const first = block.runs?.[0] ?? block;
        const colors = colorsFromCanvas(canvas, pdfRectToCanvasRect(coverRect(first, first.ascent, first.descent), atScale, pageHeight));
        return { ...textEditElement(block, { scale: computeDisplayScale(width, pageHeight), pageHeight, colors }), page, text };
    }

    function startTextEdit(block) {
        dropEmptyText();
        const existing = elements.find((el) => el.type === 'textedit' && el.page === currentPage && (el.runs ?? [el.run]).some((r) => r.id === block.id));
        if (existing) {
            setEditingId(existing.id);
            return;
        }
        const canvas = stageRef.current?.querySelector('canvas');
        if (!canvas) return;
        const id = nextId.current;
        pushElement(textEditFor(block, currentPage, canvas, scale, block.text));
        setEditingId(id);
    }

    /** Added text left empty is dropped when editing moves on, so no blank boxes pile up. */
    function dropEmptyText() {
        if (editing?.type === 'text' && !editing.text.trim()) removeElement(editing.id);
    }

    function finishEditing() {
        dropEmptyText();
        setEditingId(null);
    }

    /** Text tool: a click on the page starts a new, empty text box there to type into. */
    function placeTextAt(point) {
        if (editing) {
            finishEditing();
            return;
        }
        const id = nextId.current;
        const lineHeightPx = textProps.size * scale * textProps.lineHeight;
        pushElement({ type: 'text', text: '', ...textProps, maxWidth: null, rotation: 0, x: point.x, y: Math.max(0, point.y - lineHeightPx / 2), width: 16, height: lineHeightPx });
        setEditingId(id);
    }

    function changeTextProps(changes) {
        if (editing) updateElement(editing.id, changes);
        if (!editing || editing.type === 'text') setTextProps((current) => ({ ...current, ...changes }));
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
                const editOf = (block) => elements.find((el) => el.type === 'textedit' && el.page === n - 1 && el.run.id === block.id);
                const runs = groupRunsIntoBlocks(await extractPageRuns(renderDoc, n)).filter((run) => (editOf(run)?.text ?? run.str).includes(findText));
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
        if (savedSession) discardSavedSession();
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
        setFormFields([]);
        setFormValues({});
        setFormReady(false);
        setPageOps(null);
        setFormSubMode('fill');
        setSignature(null);
        setSignPlacements([]);
        setSignSelectedId(null);
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
        const pxSize = textProps.size * scale;
        const width = measureText(textValue, pxSize) + 10;
        const height = pxSize * textProps.lineHeight;
        const rect = clampRect({ x: (canvasSize.width - width) / 2, y: (canvasSize.height - height) / 2, width, height }, canvasSize.width, canvasSize.height, 10);
        pushElement({ type: 'text', text: textValue, ...textProps, maxWidth: null, rotation: 0, ...rect });
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
        pushElement({ type: 'image', dataUrl: pendingImage.dataUrl, bytes: pendingImage.bytes, format: 'png', rotation: 0, ...rect });
    }

    function addHighlight() {
        if (!canvasSize.width) return;
        const width = Math.min(220, canvasSize.width * 0.5);
        const height = 28;
        const rect = clampRect({ x: (canvasSize.width - width) / 2, y: (canvasSize.height - height) / 2, width, height }, canvasSize.width, canvasSize.height, 10);
        pushElement({ type: 'highlight', color: highlightColor, rotation: 0, ...rect });
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
            else pushElement({ type: 'shape', shape: shapeKind, color: shapeColor, thickness: shapeThickness, fill: shapeFill, rotation: 0, ...rect });
        }
        window.addEventListener('pointermove', handleMove);
        window.addEventListener('pointerup', handleUp);
    }

    function startDraw(e) {
        if (mode === 'edittext') finishEditing();
        if (!canvasSize.width) return;
        if (mode === 'text') {
            e.preventDefault();
            placeTextAt(pointerPoint(e, stageRef.current, canvasSize));
            return;
        }
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
        if (!stage || !el) return;
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
                    if (item.type === 'text' || item.type === 'textedit') {
                        const width = Math.max(20, startRect.width + dx);
                        return { ...item, width, maxWidth: width };
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

    function startRotate(e, id) {
        e.preventDefault();
        e.stopPropagation();
        const stage = stageRef.current;
        const natural = canvasSize;
        const el = elements.find((x) => x.id === id);
        if (!stage || !el) return;
        const center = { x: el.x + el.width / 2, y: el.y + el.height / 2 };

        const handleMove = (ev) => {
            const rotation = angleFromCenter(center, pointerPoint(ev, stage, natural));
            setElements((list) => list.map((item) => (item.id === id ? { ...item, rotation } : item)));
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

    /** Converts `srcElements` (canvas-pixel coordinates, keyed by original page index) to the PDF-space shape `buildEditedPdf` expects, using `srcDoc`'s own page sizes. */
    function toBuildElements(srcDoc, srcElements) {
        return srcElements.map((el) => {
            const size = srcDoc.getPage(el.page).getSize();
            const scaleForPage = computeDisplayScale(size.width, size.height);
            if (el.type === 'text' || el.type === 'textedit') return textElementToPdf(el, scaleForPage, size.height);
            if (isLine(el)) {
                return { ...el, thickness: el.thickness / scaleForPage, points: pointsToPdf(el.points, scaleForPage, size.height) };
            }
            return { ...el, thickness: el.thickness / scaleForPage, rectPdf: canvasRectToPdfRect(el, scaleForPage, size.height) };
        });
    }

    async function apply() {
        if (!doc || working || elements.length === 0) return;
        setWorking(true);
        setError('');
        try {
            const toBuild = toBuildElements(doc, elements);
            const { buildEditedPdf } = await loadEdit();
            const blob = await buildEditedPdf(doc, toBuild);
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-edited.pdf`) });
        } catch (e) {
            setError(t('Editing failed: {message}', { message: e.message }));
        } finally {
            setWorking(false);
        }
    }

    function movePage(from, to) {
        setPageOps((ops) => movePageOp(ops, from, to));
        setResult(null);
    }

    function deletePage(position) {
        setPageOps((ops) => deletePageOp(ops, position));
        setResult(null);
    }

    function insertBlankPage(position) {
        setPageOps((ops) => insertBlankPageOp(ops, position));
        setResult(null);
    }

    function rotatePage(position, delta) {
        setPageOps((ops) => rotatePageOp(ops, position, delta));
        setResult(null);
    }

    async function applyPages() {
        if (!doc || working || !isPageOpsChanged(pageOps, pageCount)) return;
        setWorking(true);
        setError('');
        try {
            const toBuild = remapElementsForPageOps(toBuildElements(doc, elements), pageOps);
            const work = await applyPageOps(doc, pageOps);
            const { buildEditedPdf } = await loadEdit();
            const blob = await buildEditedPdf(work, toBuild);
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-pages.pdf`) });
        } catch (e) {
            setError(t('Updating the pages failed: {message}', { message: e.message }));
        } finally {
            setWorking(false);
        }
    }

    if (!file) {
        return (
            <div className="stack">
                {savedSession && (
                    <div className="notice notice--info row row--between">
                        <span>{t('Resume editing {name}?', { name: savedSession.fileName })}</span>
                        <span className="row">
                            <button type="button" className="btn btn--sm btn--primary" onClick={resumeSession}>{t('Resume')}</button>
                            <button type="button" className="btn btn--sm" onClick={discardSavedSession}>{t('Discard')}</button>
                        </span>
                    </div>
                )}
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
                <button type="button" className="btn" onClick={() => confirmDiscard() && openFile([])}>{t('Choose another PDF')}</button>
            </div>
        );
    }

    const currentPageSize = doc.getPage(currentPage).getSize();
    const scale = computeDisplayScale(currentPageSize.width, currentPageSize.height);
    const currentElements = elements.filter((el) => el.page === currentPage);
    const zoomFactor = zoomPct / 100;

    return (
        <div className="stack">
            {mode === 'sign' ? (
                <Notice type="info">{t('This creates an electronic signature (a drawn, typed or uploaded image placed on the PDF), not a certificate-based digital signature.')}</Notice>
            ) : mode !== 'edittext' && mode !== 'text' && mode !== 'watermark' && mode !== 'form' && mode !== 'pages' && (
                <Notice type="info">{t('This adds new content on top of the page. To change text that is already in the PDF, use the Edit text tab.')}</Notice>
            )}

            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => confirmDiscard() && openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <div className="field">
                <Tabs
                    label={t('What to add')}
                    value={mode}
                    onChange={setMode}
                    tabs={[
                        { id: 'edittext', label: t('Edit text') },
                        { id: 'form', label: t('Fill form') },
                        { id: 'text', label: t('Add text') },
                        { id: 'image', label: t('Image') },
                        { id: 'highlight', label: t('Highlight') },
                        { id: 'underline', label: t('Underline') },
                        { id: 'strike', label: t('Strikethrough') },
                        { id: 'whiteout', label: t('Whiteout') },
                        { id: 'shape', label: t('Shapes') },
                        { id: 'link', label: t('Link') },
                        { id: 'draw', label: t('Draw') },
                        { id: 'pages', label: t('Pages') },
                        { id: 'watermark', label: t('Watermark') },
                        { id: 'sign', label: t('Signature') },
                    ]}
                />

                {mode === 'pages' ? (
                <div className="stack" style={{ marginTop: '0.7rem' }}>
                    <p className="field__hint" style={{ margin: 0 }}>
                        {t('Insert a blank page, delete, rotate or reorder pages. This only changes the file once you click Save PDF below.')}
                    </p>
                    <ol className="page-grid" aria-label={t('PDF pages, in order')}>
                        {(pageOps ?? []).map((op, position) => {
                            const thumb = op.type === 'page' ? thumbs[op.index] : null;
                            return (
                                <li key={op.type === 'page' ? `page-${op.index}` : `blank-${position}`}>
                                    <div className="page-card" style={{ cursor: 'default' }} role="group" aria-label={op.type === 'blank' ? t('Blank page') : t('Page {number}', { number: op.index + 1 })}>
                                        <div className="page-card__frame">
                                            {op.type === 'blank' ? (
                                                <span className="page-card__blank" aria-hidden="true" />
                                            ) : thumb?.url ? (
                                                <img className="page-card__img" src={thumb.url} alt="" style={op.rotate ? { transform: `rotate(${op.rotate}deg)` } : undefined} />
                                            ) : (
                                                <span className="field__hint">{t('Loading…')}</span>
                                            )}
                                        </div>
                                        <span className="page-card__number">{position + 1}</span>
                                        <div className="row">
                                            <button type="button" className="btn btn--sm" onClick={() => movePage(position, position - 1)} disabled={position === 0} aria-label={t('Move page {number} earlier', { number: position + 1 })}>
                                                ←
                                            </button>
                                            <button type="button" className="btn btn--sm" onClick={() => movePage(position, position + 1)} disabled={position === pageOps.length - 1} aria-label={t('Move page {number} later', { number: position + 1 })}>
                                                →
                                            </button>
                                            {op.type === 'page' && (
                                                <button type="button" className="btn btn--sm" onClick={() => rotatePage(position, 90)} aria-label={t('Rotate page {number}', { number: position + 1 })}>
                                                    ⟳
                                                </button>
                                            )}
                                            <button
                                                type="button"
                                                className="btn btn--sm btn--danger"
                                                onClick={() => deletePage(position)}
                                                disabled={pageOps.length <= 1}
                                                aria-label={t('Delete page {number}', { number: position + 1 })}
                                            >
                                                {t('Delete')}
                                            </button>
                                        </div>
                                        <button type="button" className="btn btn--sm btn--ghost" onClick={() => insertBlankPage(position)}>
                                            {t('Insert blank page after')}
                                        </button>
                                    </div>
                                </li>
                            );
                        })}
                    </ol>
                </div>
                ) : mode === 'watermark' ? (
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
                {mode === 'sign' && (
                    <div className="stack" style={{ marginTop: '0.7rem' }}>
                        <div className="field">
                            <span className="field__label">{t('1. Create your signature')}</span>
                            <Tabs
                                label={t('Signature type')}
                                value={signMode}
                                onChange={setSignMode}
                                tabs={[
                                    { id: 'draw', label: t('Draw') },
                                    { id: 'type', label: t('Type') },
                                    { id: 'upload', label: t('Upload') },
                                ]}
                            />
                            <div style={{ marginTop: '0.7rem' }}>
                                {signMode === 'draw' && <SignaturePad onUse={onSignatureReady} />}
                                {signMode === 'type' && <TypedSignature onUse={onSignatureReady} />}
                                {signMode === 'upload' && <UploadSignature onUse={onSignatureReady} onError={() => setError(t('Please choose a PNG, JPG or WebP image.'))} />}
                            </div>
                            {signature && (
                                <p className="field__hint">
                                    {t('Signature ready.')} <img src={signature.dataUrl} alt={t('Signature preview')} style={{ height: '28px', verticalAlign: 'middle' }} />
                                </p>
                            )}
                        </div>
                        <span className="field__label">{t('2. Place it on the page')}</span>
                        <div className="pdf-editor__toolbar">
                            <label className="row" style={{ gap: '0.4rem' }}>
                                <input type="checkbox" checked={signAddDate} onChange={(e) => setSignAddDate(e.target.checked)} />
                                {t("Add today's date under the signature")}
                            </label>
                            <button type="button" className="btn btn--primary btn--sm" disabled={!signature} onClick={addSignatureToPage}>
                                {t('Add signature to this page')}
                            </button>
                        </div>
                    </div>
                )}
                {mode !== 'sign' && (
                <div className="pdf-editor__toolbar" style={{ marginTop: '0.7rem' }}>
                    {mode === 'text' && (
                        <>
                            <span className="field__hint" style={{ margin: 0 }}>{t('Click anywhere on the page and type, or click existing text to change it.')}</span>
                            <input className="input" style={{ maxWidth: '240px' }} value={textValue} onChange={(e) => setTextValue(e.target.value)} placeholder={t('Text to add')} aria-label={t('Text to add')} />
                            <button type="button" className="btn btn--primary btn--sm" disabled={!textValue.trim()} onClick={addText}>{t('Add text to page')}</button>
                        </>
                    )}
                    {(mode === 'text' || (mode === 'edittext' && editing)) && (
                        <TextPropsBar
                            value={editing ?? textProps}
                            onChange={changeTextProps}
                            originalFontAvailable={Boolean(editing?.type === 'textedit' && editing.run.fontData)}
                            originalStyle={editing?.type === 'textedit' ? editing.run : null}
                        />
                    )}
                    {(mode === 'text' || mode === 'edittext') && editing && (
                        <>
                            {editing.type === 'textedit' && (
                                <>
                                    <button type="button" className="btn btn--sm" onClick={() => { updateElement(editing.id, { text: '' }); setEditingId(null); }}>{t('Delete text')}</button>
                                    <button type="button" className="btn btn--sm" onClick={() => { removeElement(editing.id); setEditingId(null); }}>{t('Restore original')}</button>
                                </>
                            )}
                            <button type="button" className="btn btn--primary btn--sm" onClick={finishEditing}>{t('Done')}</button>
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
                    {mode === 'form' && (
                        <>
                            <Tabs
                                label={t('Fill form')}
                                value={formSubMode}
                                onChange={setFormSubMode}
                                tabs={[
                                    { id: 'fill', label: t('Fill in fields') },
                                    { id: 'add', label: t('Add fields') },
                                ]}
                            />
                            {formSubMode === 'add' ? (
                                <>
                                    <button type="button" className="btn btn--sm" onClick={() => addFormField('text')}>{t('Add a text field')}</button>
                                    <button type="button" className="btn btn--sm" onClick={() => addFormField('checkbox')}>{t('Add a checkbox')}</button>
                                    <button type="button" className="btn btn--sm" onClick={() => addFormField('dropdown')}>{t('Add a dropdown field')}</button>
                                    <button type="button" className="btn btn--sm" onClick={() => addFormField('signature')}>{t('Add a signature field')}</button>
                                    <span className="field__hint" style={{ margin: 0 }}>{t('Drag a field to move it, drag its corner to resize it, and edit its name in the box.')}</span>
                                </>
                            ) : (
                                <span className="field__hint" style={{ margin: 0 }}>
                                    {!formReady
                                        ? t('Reading form fields…')
                                        : formFields.length === 0
                                          ? t('No fillable fields were found in this PDF.')
                                          : t('Fill in the fields below, then click Save PDF.')}
                                </span>
                            )}
                        </>
                    )}
                    {mode === 'edittext' && !editing && (
                        <span className="field__hint" style={{ margin: 0 }}>
                            {runsReady && pageRuns.length === 0 ? t('No editable text was found on this page (it may be a scanned image).') : t('Click any text on the page to change it.')}
                        </span>
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
                )}

                {(mode === 'edittext' || mode === 'text') && editing?.type === 'textedit' && (editing.family ?? 'original') === 'original' && editing.run.fontData && missing.length > 0 && (
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

                {pageCount > 1 && (
                    <ul className="pdf-editor__thumbs" aria-label={t('Pages')}>
                        {thumbs.map((thumb, i) => (
                            <li key={i}>
                                <button
                                    type="button"
                                    className={`pdf-editor__thumb${i === currentPage ? ' is-selected' : ''}`}
                                    onClick={() => setCurrentPage(i)}
                                    aria-current={i === currentPage ? 'true' : undefined}
                                    aria-label={t('Go to page {number}', { number: i + 1 })}
                                >
                                    {thumb?.url ? <img src={thumb.url} alt="" /> : <span className="field__hint">{t('Loading…')}</span>}
                                    <span className="pdf-editor__thumb-number">{i + 1}</span>
                                </button>
                            </li>
                        ))}
                    </ul>
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
                    {(mode === 'edittext' || mode === 'text') &&
                        pageBlocks
                            .filter((block) => !currentElements.some((el) => el.type === 'textedit' && (el.runs ?? [el.run]).some((r) => block.runs.some((b) => b.id === r.id))))
                            .map((block) => {
                                const r = blockCanvasRect(block, scale, currentPageSize.height);
                                return (
                                    <button
                                        key={block.id}
                                        type="button"
                                        className="pdf-editor__textrun pdf-editor__textrun--block"
                                        style={{ left: r.x, top: r.y, width: r.width, height: r.height }}
                                        onPointerDown={(e) => e.stopPropagation()}
                                        onClick={() => startTextEdit(block)}
                                        aria-label={t('Edit text: {text}', { text: block.text })}
                                    />
                                );
                            })}
                    {mode === 'form' &&
                        formFields
                            .filter((f) => f.page === currentPage)
                            .map((f) => {
                                const r = pdfRectToCanvasRect(f.rectPdf, scale, currentPageSize.height);
                                const style = { left: r.x, top: r.y, width: r.width, height: r.height };
                                if (f.type === 'text') {
                                    const Tag = f.multiline ? 'textarea' : 'input';
                                    return (
                                        <Tag
                                            key={f.id}
                                            className="pdf-editor__forminput"
                                            style={style}
                                            type={f.multiline ? undefined : 'text'}
                                            value={formValues[f.name] ?? ''}
                                            maxLength={f.maxLength}
                                            disabled={f.readOnly}
                                            onPointerDown={(e) => e.stopPropagation()}
                                            onChange={(e) => setFormValue(f.name, e.target.value)}
                                            aria-label={t('Fill in {name}', { name: f.name })}
                                        />
                                    );
                                }
                                if (f.type === 'checkbox') {
                                    return (
                                        <input
                                            key={f.id}
                                            type="checkbox"
                                            className="pdf-editor__formcheck"
                                            style={style}
                                            checked={!!formValues[f.name]}
                                            disabled={f.readOnly}
                                            onPointerDown={(e) => e.stopPropagation()}
                                            onChange={(e) => setFormValue(f.name, e.target.checked)}
                                            aria-label={t('Checkbox: {name}', { name: f.name })}
                                        />
                                    );
                                }
                                if (f.type === 'dropdown') {
                                    return (
                                        <select
                                            key={f.id}
                                            className="pdf-editor__forminput"
                                            style={style}
                                            value={formValues[f.name] ?? ''}
                                            disabled={f.readOnly}
                                            onPointerDown={(e) => e.stopPropagation()}
                                            onChange={(e) => setFormValue(f.name, e.target.value)}
                                            aria-label={t('Select {name}', { name: f.name })}
                                        >
                                            <option value="">{t('Choose a value')}</option>
                                            {f.options.map((o) => (
                                                <option key={o} value={o}>
                                                    {o}
                                                </option>
                                            ))}
                                        </select>
                                    );
                                }
                                return (
                                    <input
                                        key={f.id}
                                        type="radio"
                                        name={`pdf-form-${f.name}`}
                                        className="pdf-editor__formcheck"
                                        style={style}
                                        checked={formValues[f.name] === f.onValue}
                                        disabled={f.readOnly}
                                        onPointerDown={(e) => e.stopPropagation()}
                                        onChange={() => setFormValue(f.name, f.onValue)}
                                        aria-label={t('{name}: {value}', { name: f.name, value: f.onValue })}
                                    />
                                );
                            })}
                    {mode === 'sign' &&
                        signPlacements
                            .filter((p) => p.page === currentPage)
                            .map((p) => (
                                <div
                                    key={p.id}
                                    className={`pdf-editor__overlay${signSelectedId === p.id ? ' is-selected' : ''}`}
                                    style={{ left: p.x, top: p.y, width: p.width, height: p.height }}
                                    onPointerDown={(e) => startSignDrag(e, p.id, 'move')}
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
                                        onClick={() => removeSignPlacement(p.id)}
                                    >
                                        ×
                                    </button>
                                    <span className="pdf-editor__handle" onPointerDown={(e) => startSignDrag(e, p.id, 'resize')} aria-hidden="true" />
                                </div>
                            ))}
                    {currentElements.map((el) => {
                        if (el.type === 'textedit' || el.type === 'text') {
                            return (
                                <TextBlockEditor
                                    key={el.id}
                                    el={el}
                                    selected={el.id === editingId && (mode === 'edittext' || mode === 'text')}
                                    scale={scale}
                                    labels={el.type === 'text' ? { drag: OVERLAY_LABELS.text.drag(), remove: OVERLAY_LABELS.text.remove() } : undefined}
                                    onChange={(changes) => updateElement(el.id, changes)}
                                    onLayout={(box) => setElements((list) => list.map((item) => (item.id === el.id ? { ...item, ...box } : item)))}
                                    onSelect={() => {
                                        if (mode !== 'edittext' && mode !== 'text') setMode(el.type === 'text' ? 'text' : 'edittext');
                                        if (editingId !== el.id) dropEmptyText();
                                        setEditingId(el.id);
                                    }}
                                    onDone={finishEditing}
                                    onMoveStart={(e) => startDrag(e, el.id, 'move')}
                                    onResizeStart={(e) => startDrag(e, el.id, 'resize')}
                                    onRotateStart={el.type === 'text' ? (e) => startRotate(e, el.id) : undefined}
                                    onRemove={el.type === 'text' ? () => { removeElement(el.id); if (editingId === el.id) setEditingId(null); } : undefined}
                                />
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
                        if (el.type === 'formfield') {
                            const checkbox = el.fieldType === 'checkbox';
                            const dropdown = el.fieldType === 'dropdown';
                            const signature = el.fieldType === 'signature';
                            const dragLabel = checkbox ? t('Checkbox field - drag to move') : dropdown ? t('Dropdown field - drag to move') : signature ? t('Signature field - drag to move') : t('Text field - drag to move');
                            const nameLabel = checkbox ? t('Checkbox field name') : dropdown ? t('Dropdown field name') : signature ? t('Signature field name') : t('Text field name');
                            const removeLabel = checkbox ? t('Remove this checkbox field') : dropdown ? t('Remove this dropdown field') : signature ? t('Remove this signature field') : t('Remove this text field');
                            return (
                                <div
                                    key={el.id}
                                    className={`pdf-editor__overlay pdf-editor__overlay--field${dropdown ? ' pdf-editor__overlay--dropdown' : ''}`}
                                    style={{ left: el.x, top: el.y, width: el.width, height: el.height }}
                                    onPointerDown={(e) => startDrag(e, el.id, 'move')}
                                    role="button"
                                    tabIndex={0}
                                    aria-label={dragLabel}
                                >
                                    <input
                                        className="pdf-editor__fieldname"
                                        value={el.name}
                                        onPointerDown={(e) => e.stopPropagation()}
                                        onChange={(e) => updateElement(el.id, { name: e.target.value })}
                                        aria-label={nameLabel}
                                    />
                                    {dropdown && (
                                        <input
                                            className="pdf-editor__fieldoptions"
                                            value={el.optionsText ?? ''}
                                            placeholder={t('Option 1, Option 2')}
                                            onPointerDown={(e) => e.stopPropagation()}
                                            onChange={(e) => updateElement(el.id, { optionsText: e.target.value })}
                                            aria-label={t('Dropdown options, separated by commas')}
                                        />
                                    )}
                                    <button
                                        type="button"
                                        className="pdf-editor__remove"
                                        aria-label={removeLabel}
                                        onPointerDown={(e) => e.stopPropagation()}
                                        onClick={() => removeElement(el.id)}
                                    >
                                        ×
                                    </button>
                                    <span className="pdf-editor__handle" onPointerDown={(e) => startDrag(e, el.id, 'resize')} aria-hidden="true" />
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
                                    ...(canRotate(el) && el.rotation ? { transform: `rotate(${el.rotation}deg)`, transformOrigin: 'center' } : null),
                                }}
                                onPointerDown={(e) => startDrag(e, el.id, 'move')}
                                role="button"
                                tabIndex={0}
                                aria-label={labels.drag()}
                                title={el.type === 'link' ? el.url : undefined}
                            >
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
                                {canRotate(el) && <span className="pdf-editor__rotate-handle" onPointerDown={(e) => startRotate(e, el.id)} aria-hidden="true" />}
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
                    <button type="button" className="btn btn--primary" onClick={downloadResult}>{t('Download PDF')}</button>
                </div>
            ) : mode === 'pages' ? (
                <button type="button" className="btn btn--primary btn--lg" onClick={applyPages} disabled={working || !isPageOpsChanged(pageOps, pageCount)}>
                    {working ? t('Saving…') : t('Save PDF')}
                </button>
            ) : mode === 'watermark' ? (
                <button type="button" className="btn btn--primary btn--lg" onClick={applyWatermark} disabled={working || !(wmKind === 'text' ? wmText.trim() : wmPendingImage)}>
                    {working ? wmProgress || t('Adding watermark…') : t('Add watermark')}
                </button>
            ) : mode === 'sign' ? (
                <button type="button" className="btn btn--primary btn--lg" onClick={applySignature} disabled={working || signPlacements.length === 0}>
                    {working ? t('Signing…') : t('Sign PDF')}
                </button>
            ) : mode === 'form' && formSubMode === 'add' ? (
                <button type="button" className="btn btn--primary btn--lg" onClick={applyNewFormFields} disabled={working || elements.filter((el) => el.type === 'formfield').length === 0}>
                    {working ? t('Saving…') : t('Save PDF with new fields')}
                </button>
            ) : mode === 'form' ? (
                <button type="button" className="btn btn--primary btn--lg" onClick={applyForm} disabled={working || formFields.length === 0}>
                    {working ? t('Saving…') : t('Save filled PDF')}
                </button>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={apply} disabled={working || elements.length === 0}>
                    {working ? t('Saving…') : t('Save PDF')}
                </button>
            )}
        </div>
    );
}
