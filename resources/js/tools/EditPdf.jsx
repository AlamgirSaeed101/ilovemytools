import { useEffect, useMemo, useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { getLocale, t, tn } from '../lib/i18n.js';
import { addRotation, isPdf } from '../lib/pdf.js';
import { usePageThumbnails, usePdfDoc } from '../lib/pdfPages.js';
import { canvasRectToPdfRect, clampRect, computeDisplayScale, pdfRectToCanvasRect, rectFromPoints } from '../lib/pdfOverlay.js';
import { loadRenderDoc, renderPageToCanvas } from '../lib/pdfRender.js';
import { colorsFromCanvas, coverRect, extractPageRuns, missingGlyphs } from '../lib/pdfTextRuns.js';
import { angleFromCenter, arrowHeadLines, normalizeLinkUrl, pointsToPdf, shapeStyleOf, strokeBoundingBox } from '../lib/pdfEditShapes.js';
import { imageWatermarkSize, watermarkPageIndexes } from '../lib/pdfWatermarkLayout.js';
import { formatSignatureDate } from '../lib/pdfSign.js';
import { imageFromClipboard, loadImageFile, placementRect } from '../lib/imageUtils.js';
import SignatureMenu from '../components/pdf-editor/SignatureMenu.jsx';
import ImageControls from '../components/pdf-editor/ImageControls.jsx';
import { clearSession, fileFromSession, hasUnsavedChanges, loadSession, saveSession } from '../lib/pdfSession.js';
import { blockCanvasRect, groupRunsIntoBlocks, textEditElement, textElementToPdf } from '../lib/pdfTextBlocks.js';
import TextBlockEditor from '../components/pdf-editor/TextBlockEditor.jsx';
import TextPropsBar from '../components/pdf-editor/TextPropsBar.jsx';
import FormFieldOverlay from '../components/pdf-editor/FormFieldOverlay.jsx';
import FormFieldCreator, { FormCreateTools, formSaveErrorText } from '../components/pdf-editor/FormFieldCreator.jsx';
import { newFormElement } from '../lib/pdfFormElements.js';
import FormFillFields from './FormFillFields.jsx';
import { quadsBounds, quadsForRuns, smoothStroke, strokeToSvgPath } from '../lib/pdfAnnotationGeometry.js';
import ShapeProps, { DEFAULT_SHAPE_PROPS, LineEndHandles, isLineShape, shapeElementStyle, shapeSvgStyle } from '../components/pdf-editor/ShapeProps.jsx';
import StickyNote, { NOTE_COLORS, NOTE_SIZE, rememberedAuthor } from '../components/pdf-editor/StickyNote.jsx';
import LinkOverlay, { LinkTargetFields, linkTargetLabel, pageIndexFrom } from '../components/pdf-editor/LinkOverlay.jsx';
import TextMarkup from '../components/pdf-editor/TextMarkup.jsx';
import MappedPageCanvas from '../components/pdf-editor/MappedPageCanvas.jsx';
import PageScroller from '../components/pdf-editor/PageScroller.jsx';
import PageSidebar from '../components/pdf-editor/PageSidebar.jsx';
import usePageMap from '../components/pdf-editor/usePageMap.js';
import { insertBlank } from '../lib/pdfPageOps.js';
import { isSideways, pointerToPage, stageTransform, viewSize } from '../lib/pdfPageView.js';
import { useHistory } from '../lib/editorHistory.js';
import { useEditorShortcuts } from '../lib/editorShortcuts.js';
import { canReorder, cursorForMode, duplicateElement, elementBox, moveElement, reorderElement } from '../lib/editorSelection.js';
import EditorToolbar, { ZOOM_PRESETS } from '../components/pdf-editor/EditorToolbar.jsx';
import SelectionBar from '../components/pdf-editor/SelectionBar.jsx';

// pdf-lib (~165 KB) only loads when a PDF is previewed or saved, not with the page.
const loadWatermark = () => import('../lib/pdfWatermark.js');
const loadEdit = () => import('../lib/pdfEdit.js');
const loadForms = () => import('../lib/pdfForms.js');
const loadFormCreate = () => import('../lib/pdfFormCreate.js');
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';

const ZOOM_MIN = 50;
const ZOOM_MAX = 200;
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
const DRAG_MODES = ['whiteout', 'shape', 'highlight', 'underline', 'strike', 'link'];
// The tools the toolbar shows (see EditorToolbar's TOOL_ITEMS).
const EDITOR_MODES = ['select', 'edittext', 'text', 'link', 'form', 'image', 'sign', 'whiteout', 'highlight', 'underline', 'strike', 'draw', 'note', 'shape', 'watermark'];
// Added elements that get the selection bar; text, notes, links and form fields have their own editors on the page.
const SELECTABLE = ['image', 'highlight', 'markup', 'stroke', 'shape', 'whiteout', 'link'];
const EMPTY_HISTORY = { elements: [], pageMap: null, formValues: {} };
const resolveNext = (next, current) => (typeof next === 'function' ? next(current) : next);
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

// The stage's data-rotation is the page panel's rotation of the page on screen (see pdfPageView.js).
function pointerPoint(e, el, natural) {
    return pointerToPage(e.clientX, e.clientY, el.getBoundingClientRect(), natural, Number(el.dataset.rotation) || 0);
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
    // Every change to the added elements, the page panel's pages and the form's values goes through
    // one snapshot history, so undo/redo covers all of them in the order they were made.
    const history = useHistory(EMPTY_HISTORY);
    const { elements, formValues } = history.present;
    const setElements = (next, options) =>
        history.set((state) => {
            const list = resolveNext(next, state.elements);
            return list === state.elements ? state : { ...state, elements: list };
        }, options);
    const [selectedId, setSelectedId] = useState(null);
    const [findOpen, setFindOpen] = useState(false);
    const clipboardRef = useRef(null);
    const mainRef = useRef(null);
    const [mode, setMode] = useState(initialMode === 'forms' ? 'form' : (initialMode ?? 'edittext'));
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
    const [shapeProps, setShapeProps] = useState(DEFAULT_SHAPE_PROPS);
    const [drawAsInk, setDrawAsInk] = useState(false);
    const [linkTarget, setLinkTarget] = useState('url');
    const [linkPage, setLinkPage] = useState(1);
    const [pageLinks, setPageLinks] = useState([]);
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
    const [signature, setSignature] = useState(null);
    const [signAddDate, setSignAddDate] = useState(false);
    const [activeImageId, setActiveImageId] = useState(null);
    const [formFields, setFormFields] = useState([]);
    const [formReady, setFormReady] = useState(false);
    const [formSubMode, setFormSubMode] = useState('fill');
    const [formKind, setFormKind] = useState('text');
    const [formFlatten, setFormFlatten] = useState(false);
    // The values the PDF's own fields had when it was opened, to tell which ones the user changed.
    const [formInitial, setFormInitial] = useState({});
    const [pageWidgets, setPageWidgets] = useState([]);
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
    const [continuous, setContinuous] = useState(false);
    // Form values that differ from what the PDF came with (a value restored from a saved session
    // counts until the fields are read). Undoing every change brings this back to false.
    const formDirty = useMemo(
        () => Object.entries(formValues).some(([name, value]) => !(name in formInitial) || JSON.stringify(formInitial[name]) !== JSON.stringify(value)),
        [formValues, formInitial]
    );
    const pages = usePageMap({
        doc,
        renderDoc,
        pageCount,
        thumbs,
        rawMap: history.present.pageMap,
        elements,
        commit: (nextElements, pageMap) => history.set((state) => ({ ...state, elements: nextElements, pageMap })),
        nextId,
        currentPage,
        setCurrentPage,
        onEdit: () => setResult(null),
    });

    // Undo/redo of a page change can leave fewer pages than the one on screen.
    useEffect(() => {
        if (pages.count > 0 && currentPage > pages.count - 1) setCurrentPage(pages.count - 1);
    }, [pages.count, currentPage]);

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
        if (!hasUnsavedChanges(elements, pages.changed || formDirty)) {
            clearSession().catch(() => {});
            return;
        }
        autosaveTimerRef.current = setTimeout(() => {
            if (!fileBytesRef.current) return;
            saveSession({ fileName: file.name, fileType: file.type, fileBytes: fileBytesRef.current, elements, formValues, currentPage, mode, ...pages.sessionFields() }).catch(() => {});
        }, 800);
        return () => clearTimeout(autosaveTimerRef.current);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [file, elements, formValues, formDirty, currentPage, mode, pages.map, pages.changed]);

    // Warns before the tab closes or navigates away while there is unsaved work.
    useEffect(() => {
        if (!hasUnsavedChanges(elements, pages.changed || formDirty)) return;
        function onBeforeUnload(e) {
            e.preventDefault();
            e.returnValue = '';
        }
        window.addEventListener('beforeunload', onBeforeUnload);
        return () => window.removeEventListener('beforeunload', onBeforeUnload);
    }, [elements, pages.changed, formDirty]);

    function resumeSession() {
        if (!savedSession) return;
        const restored = fileFromSession(savedSession);
        nextId.current = 1 + Math.max(0, ...savedSession.elements.map((el) => el.id));
        history.reset({
            ...EMPTY_HISTORY,
            elements: savedSession.elements,
            pageMap: Array.isArray(savedSession.pageMap) ? savedSession.pageMap : null,
            formValues: savedSession.formValues && typeof savedSession.formValues === 'object' ? savedSession.formValues : {},
        });
        setFormInitial({});
        setCurrentPage(savedSession.currentPage || 0);
        // Sessions saved before the toolbar may name a tab that no longer exists (the old Pages tab).
        setMode(EDITOR_MODES.includes(savedSession.mode) ? savedSession.mode : 'edittext');
        pages.restore(savedSession);
        setSavedSession(null);
        setFile(restored);
    }

    function discardSavedSession() {
        clearSession().catch(() => {});
        setSavedSession(null);
    }

    /** Confirms before anything that would discard unsaved work (a new upload, or picking another PDF). */
    function confirmDiscard() {
        return !hasUnsavedChanges(elements, pages.changed || formDirty) || window.confirm(t('Discard your unsaved changes to this PDF?'));
    }

    function downloadResult() {
        if (!result) return;
        downloadBlob(result.blob, result.name);
        clearTimeout(autosaveTimerRef.current);
        clearSession().catch(() => {});
    }

    // The editable text runs of the page on screen (pdf.js text + the PDF's own fonts).
    const runsSource = pages.isOwnPage(currentPage) ? pages.entry(currentPage).source : -1;
    useEffect(() => {
        if (!renderDoc) return;
        let cancelled = false;
        setPageRuns([]);
        setRunsReady(false);
        // Blank pages and pages inserted from another PDF have no text of the open PDF to edit.
        if (runsSource < 0) {
            setRunsReady(true);
            return;
        }
        extractPageRuns(renderDoc, runsSource + 1)
            .then((runs) => !cancelled && setPageRuns(runs))
            .catch(() => !cancelled && setPageRuns([]))
            .finally(() => !cancelled && setRunsReady(true));
        return () => {
            cancelled = true;
        };
    }, [renderDoc, runsSource]);
    // Lines of one paragraph (same font, size, edge, spacing) are edited together as one block.
    const pageBlocks = useMemo(() => groupRunsIntoBlocks(pageRuns), [pageRuns]);

    // The links the page on screen already has, so the Link tool can show, change or remove them.
    useEffect(() => {
        setPageLinks([]);
        // Blank pages and pages inserted from another PDF have no links of the open PDF.
        if (!renderDoc || mode !== 'link' || runsSource < 0) return undefined;
        let cancelled = false;
        import('../lib/pdfLinks.js')
            .then(({ readPageLinks }) => readPageLinks(renderDoc, runsSource + 1))
            .then((links) => !cancelled && setPageLinks(links))
            .catch(() => !cancelled && setPageLinks([]));
        return () => {
            cancelled = true;
        };
    }, [renderDoc, runsSource, mode]);

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
            const fallback = letters.length > 0;
            setElements((list) => (list.some((el) => el.id === editing.id && Boolean(el.fallback) !== fallback) ? list.map((el) => (el.id === editing.id ? { ...el, fallback } : el)) : list), { merge: true });
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
        return { kind: 'image', bytes: wmPendingImage.bytes, format: wmPendingImage.format, width, height };
    }

    function handleWatermarkImageFile([picked]) {
        loadImageFile(picked)
            .then((image) => {
                setWmPendingImage(image);
                setResult(null);
            })
            .catch(() => setError(t('Could not read that image.')));
    }

    // Live preview: builds a real one-page PDF of page 1 as the page panel has it (its rotation, a
    // blank or inserted page) with what was added to it and the watermark, and renders it with
    // pdf.js, so the preview matches what Apply changes will save.
    const pageMapKey = JSON.stringify(pages.map);
    useEffect(() => {
        if (mode !== 'watermark' || !doc) return;
        let cancelled = false;
        const entry = pages.entry(0);
        const size = pages.size(0);
        const source = entry && !entry.blank ? pages.docFor(entry) : null;
        if (entry && !entry.blank && !source) return;
        (async () => {
            const [{ PDFDocument, degrees }, { buildEditedPdf }, { drawWatermark }] = await Promise.all([import('pdf-lib'), loadEdit(), loadWatermark()]);
            const content = wmContentFor(size.width);
            const firstPage = async () => {
                const previewDoc = await PDFDocument.create();
                const page = source ? previewDoc.addPage((await previewDoc.copyPages(source, [entry.source]))[0]) : previewDoc.addPage([size.width, size.height]);
                if (entry?.rotation) page.setRotation(degrees(addRotation(page.getRotation().angle, entry.rotation)));
                return previewDoc;
            };
            const watermark = content
                ? (work) => drawWatermark(work, { pageIndexes: [0], position: wmPosition, opacity: wmOpacityPct / 100, rotation: wmRotation, layer: wmLayer, content })
                : undefined;
            const onPage = elements.filter((el) => el.page === 0 && el.type !== 'formfield');
            let blob;
            try {
                const previewDoc = await firstPage();
                blob = await buildEditedPdf(previewDoc, toBuildElements(previewDoc, onPage), { beforeSave: watermark });
            } catch {
                // An element that can't be drawn on a one-page copy only drops out of the preview.
                const previewDoc = await firstPage();
                blob = await buildEditedPdf(previewDoc, [], { beforeSave: watermark });
            }
            const bytes = new Uint8Array(await blob.arrayBuffer());
            if (cancelled) return;
            const ownRenderDoc = await loadRenderDoc(bytes);
            if (cancelled) {
                ownRenderDoc.destroy();
                return;
            }
            const canvas = await renderPageToCanvas(ownRenderDoc, 1, { scale: computeDisplayScale(size.width, size.height), background: '#ffffff' });
            wmPreviewRenderDocRef.current?.destroy();
            wmPreviewRenderDocRef.current = ownRenderDoc;
            if (cancelled || !wmPreviewCanvasRef.current) return;
            wmPreviewCanvasRef.current.width = canvas.width;
            wmPreviewCanvasRef.current.height = canvas.height;
            wmPreviewCanvasRef.current.getContext('2d').drawImage(canvas, 0, 0);
        })().catch(() => {
            // The preview is a convenience; a failure here never blocks the real download.
        });
        return () => {
            cancelled = true;
        };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [mode, doc, pageMapKey, elements, wmKind, wmText, wmTextSize, wmTextColor, wmTextBold, wmPendingImage, wmImageScalePct, wmOpacityPct, wmRotation, wmPosition, wmLayer]);

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
        loadForms()
            .then(({ listFormFields }) => listFormFields(doc))
            .then((detected) => {
                if (cancelled) return;
                setFormFields(detected.filter((f) => f.type !== 'unsupported'));
                setFormInitial(Object.fromEntries(detected.filter((f) => f.type !== 'unsupported').map((f) => [f.name, f.value])));
                // The PDF's own values are the starting point, not an undo step.
                history.set((state) => {
                    const next = { ...state.formValues };
                    for (const f of detected) if (f.type !== 'unsupported' && !(f.name in next)) next[f.name] = f.value;
                    return { ...state, formValues: next };
                }, { merge: true });
            })
            .catch(() => !cancelled && setFormFields([]))
            .finally(() => !cancelled && setFormReady(true));
        return () => {
            cancelled = true;
        };
    }, [mode, doc]);

    // Where the PDF's own fields sit on the page on screen, to fill them in place.
    useEffect(() => {
        setPageWidgets([]);
        // Blank pages and pages inserted from another PDF have none of the open PDF's fields.
        if (mode !== 'form' || !renderDoc || runsSource < 0) return;
        let cancelled = false;
        loadForms()
            .then(({ readFormWidgets }) => readFormWidgets(renderDoc, runsSource + 1))
            .then((widgets) => !cancelled && setPageWidgets(widgets))
            .catch(() => !cancelled && setPageWidgets([]));
        return () => {
            cancelled = true;
        };
    }, [mode, renderDoc, runsSource]);

    function changeFormValue(name, value) {
        // Typing in one field is one undo step.
        history.set((state) => ({ ...state, formValues: { ...state.formValues, [name]: value } }), { merge: `form:${name}` });
        setResult(null);
    }

    /** Places a new field of the chosen kind: over a dragged `box`, centred on a clicked point, or mid-page. */
    function addFormElement(box) {
        if (!canvasSize.width) return;
        const at = box ?? { x: canvasSize.width / 2, y: canvasSize.height / 2 };
        pushElement({ ...newFormElement(formKind, at, { existingNames: formFields.map((f) => f.name), elements, bounds: canvasSize }), fresh: true });
    }

    /** The form step of a save: changed values into the PDF's own fields, then the new fields, then flatten if asked. */
    function formsBeforeSave(forms, built) {
        const specs = built.filter((el) => el.type === 'formfield').map((el) => forms.toFieldSpec(el, el.rectPdf));
        return (work) => forms.applyFormsToDocument(work, { values: formValues, specs, flatten: formFlatten });
    }

    /**
     * Watermark's Apply: the same save as every other tool (pages in the page panel's order, the
     * added elements, form values and new fields), on a copy of the open PDF, with the watermark
     * drawn last. The open document is never changed, so applying again starts from the original.
     */
    async function applyWatermark() {
        if (!doc || working) return;
        const content = wmContentFor(pages.size(0).width);
        if (!content) {
            setError(wmKind === 'text' ? t('Type the watermark text first.') : t('Choose a logo or image first.'));
            return;
        }
        setWorking(true);
        setError('');
        try {
            const [{ buildEditedPdf }, forms, { drawWatermark, flattenPdf }] = await Promise.all([loadEdit(), loadFormCreate(), loadWatermark()]);
            const work = await pages.build(await forms.workingCopy(doc));
            const toBuild = toBuildElements(work, elements);
            const saveForms = formsBeforeSave(forms, toBuild);
            const pageIndexes = watermarkPageIndexes(work.getPageCount(), wmScope, wmRangeText);
            let blob = await buildEditedPdf(work, toBuild.filter((el) => el.type !== 'formfield'), {
                beforeSave: async (target) => {
                    await saveForms(target);
                    await drawWatermark(target, { pageIndexes, position: wmPosition, opacity: wmOpacityPct / 100, rotation: wmRotation, layer: wmLayer, content });
                },
            });
            if (wmFlatten) {
                blob = await flattenPdf(new Uint8Array(await blob.arrayBuffer()), {
                    onProgress: (page, total) => setWmProgress(t('Flattening page {page} of {total}…', { page, total })),
                });
            }
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-watermarked.pdf`) });
        } catch (e) {
            setError(formSaveErrorText(e) ?? t('Adding the watermark failed: {message}', { message: e.message }));
        } finally {
            setWorking(false);
            setWmProgress('');
        }
    }

    /** Places a picked signature or image on the current page, centred on `at` (a click on the page) or in the middle of it. */
    function placeImage(img, at = null) {
        if (!img || !canvasSize.width) return;
        const signing = mode === 'sign';
        const initials = img.kind === 'initials';
        const targetWidth = signing ? Math.min(canvasSize.width * (initials ? 0.2 : 0.45), initials ? 110 : 260) : Math.min(canvasSize.width * 0.4, 220);
        const rect = placementRect({ imageWidth: img.width, imageHeight: img.height, targetWidth, areaWidth: canvasSize.width, areaHeight: canvasSize.height, center: at });
        setActiveImageId(nextId.current);
        pushElement({
            type: 'image',
            dataUrl: img.dataUrl,
            bytes: img.bytes,
            format: img.format ?? 'png',
            opacity: 1,
            rotation: 0,
            ...rect,
            ...(signing ? { signature: true, dateText: signAddDate ? formatSignatureDate(getLocale()) : null } : {}),
        });
    }

    // Pasting an image (Ctrl+V) anywhere outside a text box adds it to the page on screen.
    useEffect(() => {
        if (!file || !canvasSize.width || mode === 'watermark') return undefined;
        function onPaste(e) {
            const target = e.target;
            if (target instanceof HTMLElement && (target.isContentEditable || /^(INPUT|TEXTAREA|SELECT)$/.test(target.tagName))) return;
            const pasted = imageFromClipboard(e.clipboardData);
            if (!pasted) return;
            e.preventDefault();
            loadImageFile(pasted)
                .then((image) => {
                    if (mode !== 'sign') {
                        setMode('image');
                        setPendingImage(image);
                    }
                    placeImage(image);
                })
                .catch(() => setError(t('Could not read that image.')));
        }
        window.addEventListener('paste', onPaste);
        return () => window.removeEventListener('paste', onPaste);
    });

    /** A text-edit element for a paragraph `block`, with the colours sampled from `canvas` (rendered at `atScale`). */
    function textEditFor(block, page, canvas, atScale, text) {
        const { width, height: pageHeight } = pages.size(page);
        const first = block.runs?.[0] ?? block;
        const colors = colorsFromCanvas(canvas, pdfRectToCanvasRect(coverRect(first, first.ascent, first.descent), atScale, pageHeight));
        return { ...textEditElement(block, { scale: computeDisplayScale(width, pageHeight), pageHeight, colors }), page, text };
    }

    function startTextEdit(block) {
        if (mode === 'select') setMode('edittext');
        setSelectedId(null);
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

    // Repeated changes to the same properties of one element (typing, dragging a colour picker or a
    // line's end) fold into one undo step.
    function updateElement(id, changes, { merge = `${id}:${Object.keys(changes).sort().join(',')}` } = {}) {
        setElements((list) => list.map((el) => (el.id === id ? { ...el, ...changes } : el)), { merge });
        setResult(null);
    }

    async function replaceAll() {
        if (!findText || working) return;
        setWorking(true);
        setReplaceInfo('');
        let count = 0;
        const added = [];
        try {
            for (let page = 0; page < pages.count; page++) {
                if (!pages.isOwnPage(page)) continue;
                const n = pages.entry(page).source + 1;
                // Search the wording as it is now: a line already edited is matched on its new text.
                const editOf = (block) => elements.find((el) => el.type === 'textedit' && el.page === page && el.run.id === block.id);
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
                    else added.push({ id: nextId.current++, ...textEditFor(run, page, canvas, 1, text), fallback });
                }
            }
            setElements((list) => [...list.filter((el) => !added.some((a) => a.id === el.id)), ...added]);
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
        history.reset(EMPTY_HISTORY);
        setSelectedId(null);
        setPendingImage(null);
        setWmPendingImage(null);
        setEditingId(null);
        setReplaceInfo('');
        setZoomPct(100);
        setFormFields([]);
        setFormReady(false);
        setFormSubMode('fill');
        setFormFlatten(false);
        setFormInitial({});
        setPageWidgets([]);
        setSignature(null);
        setActiveImageId(null);
        pages.reset();
        setFile(picked);
    }

    function onPageReady({ width, height }) {
        setCanvasSize({ width, height });
    }

    function pushElement(el) {
        const id = nextId.current++;
        setElements((list) => [...list, { id, page: currentPage, ...el }]);
        setResult(null);
        return id;
    }

    /** Adds an element the user just placed with a tool, selects it and goes back to the Select tool (Draw stays on). */
    function placeElement(el) {
        const id = pushElement(el);
        setSelectedId(id);
        if (mode !== 'draw') setMode('select');
        return id;
    }

    function undo() {
        if (!history.canUndo) return false;
        setEditingId(null);
        history.undo();
        setResult(null);
    }

    function redo() {
        if (!history.canRedo) return false;
        setEditingId(null);
        history.redo();
        setResult(null);
    }

    function removeElement(id) {
        setElements((list) => list.filter((el) => el.id !== id));
        if (id === selectedId) setSelectedId(null);
        if (id === activeImageId) setActiveImageId(null);
        setResult(null);
    }

    function changeTool(next, option) {
        if (option?.shape) setShapeProps((p) => ({ ...p, shape: option.shape }));
        if (next !== 'edittext' && next !== 'text') finishEditing();
        setSelectedId(null);
        if (next !== 'edittext') setFindOpen(false);
        setMode(next);
    }

    function changeZoom(value) {
        if (value === 'fit') {
            const available = mainRef.current?.clientWidth ?? 0;
            const pageWidth = isSideways(pageRotation) ? canvasSize.height : canvasSize.width;
            if (!available || !pageWidth) return;
            setZoomPct(Math.min(ZOOM_MAX, Math.max(ZOOM_MIN, Math.floor((available / pageWidth) * 100))));
            return;
        }
        setZoomPct(Math.min(ZOOM_MAX, Math.max(ZOOM_MIN, value)));
    }

    const selected = elements.find((el) => el.id === selectedId && SELECTABLE.includes(el.type)) ?? null;

    function duplicateSelected() {
        if (!selected) return false;
        const id = nextId.current++;
        setElements((list) => [...list, duplicateElement(selected, id, canvasSize)]);
        setSelectedId(id);
        setResult(null);
    }

    function copySelected() {
        if (!selected) return false;
        clipboardRef.current = selected;
    }

    function pasteClipboard() {
        if (!clipboardRef.current || !canvasSize.width) return false;
        const id = nextId.current++;
        setElements((list) => [...list, { ...duplicateElement(clipboardRef.current, id, canvasSize), page: currentPage }]);
        setSelectedId(id);
        setResult(null);
    }

    function deleteSelected() {
        if (!selected) return false;
        removeElement(selected.id);
    }

    function nudgeSelected({ dx, dy }) {
        if (!selected) return false;
        setElements((list) => list.map((el) => (el.id === selected.id ? moveElement(el, dx, dy, canvasSize) : el)), { merge: `nudge:${selected.id}` });
        setResult(null);
    }

    function reorderSelected(direction) {
        if (!selected) return;
        setElements((list) => reorderElement(list, selected.id, direction));
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
        placeImage(pendingImage);
    }

    /** A highlight box centred on `at` (a click on the page), or in the middle of the page. */
    function addHighlight(at = null) {
        if (!canvasSize.width) return;
        const width = Math.min(220, canvasSize.width * 0.5);
        const height = 28;
        const origin = at ? { x: at.x - width / 2, y: at.y - height / 2 } : { x: (canvasSize.width - width) / 2, y: (canvasSize.height - height) / 2 };
        const rect = clampRect({ ...origin, width, height }, canvasSize.width, canvasSize.height, 10);
        placeElement({ type: 'highlight', color: highlightColor, rotation: 0, ...rect });
    }

    function handleImageFile([picked]) {
        loadImageFile(picked)
            .then((image) => setPendingImage(image))
            .catch(() => setError(t('Could not read that image.')));
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
            if (mode === 'form') return addFormElement(Math.hypot(rect.width, rect.height) < 6 ? end : rect);
            if (Math.hypot(rect.width, rect.height) < 6) {
                // A click, not a drag: the highlighter drops a box there; other tools need a drag.
                if (mode === 'highlight') addHighlight(end);
                return;
            }
            // Highlight / underline / strikethrough dragged across real text snap to its lines and save as annotations.
            const markup = mode === 'highlight' || mode === 'underline' || mode === 'strike';
            const quads = markup ? quadsForRuns(pageRuns, canvasRectToPdfRect(rect, scale, currentPageSize.height)) : [];
            if (quads.length) {
                const quadsBox = quadsBounds(quads);
                const box = pdfRectToCanvasRect(quadsBox, scale, currentPageSize.height);
                if (mode === 'highlight') placeElement({ type: 'highlight', color: highlightColor, quads, quadsBox, ...box });
                else placeElement({ type: 'markup', kind: mode, color: markupColor, quads, quadsBox, ...box });
            } else if (mode === 'highlight') placeElement({ type: 'highlight', color: highlightColor, rotation: 0, ...rect });
            else if (mode === 'whiteout') placeElement({ type: 'whiteout', ...rect });
            else if (markup) placeElement({ type: 'markup', kind: mode, color: markupColor, ...rect, height: Math.max(8, rect.height) });
            else if (mode === 'link' && linkTarget === 'page') placeElement({ type: 'link', url: null, pageTarget: pageIndexFrom(linkPage, pages.count), ...rect });
            else if (mode === 'link') placeElement({ type: 'link', url: normalizeLinkUrl(linkUrl), ...rect });
            else if (isLineShape(shapeProps.shape)) placeElement({ type: 'shape', shape: shapeProps.shape, ...shapeElementStyle(shapeProps), points: [start, end] });
            else placeElement({ type: 'shape', shape: shapeProps.shape, ...shapeElementStyle(shapeProps), rotation: 0, ...rect });
        }
        window.addEventListener('pointermove', handleMove);
        window.addEventListener('pointerup', handleUp);
    }

    function startDraw(e) {
        if (mode === 'edittext' || mode === 'select') finishEditing();
        // Clicking empty page deselects; with a placing tool it also places the element there.
        setSelectedId(null);
        if (!canvasSize.width) return;
        if (mode === 'text') {
            e.preventDefault();
            placeTextAt(pointerPoint(e, stageRef.current, canvasSize));
            return;
        }
        // With a signature or image picked, a click on the page places it at the pointer.
        const placing = mode === 'sign' ? signature : mode === 'image' ? pendingImage : null;
        if (placing) {
            e.preventDefault();
            placeImage(placing, pointerPoint(e, stageRef.current, canvasSize));
            return;
        }
        if (mode === 'note') {
            // Keeps the click from moving focus off the new note's text box.
            e.preventDefault();
            const p = pointerPoint(e, stageRef.current, canvasSize);
            const rect = clampRect({ x: p.x - NOTE_SIZE / 2, y: p.y - NOTE_SIZE / 2, width: NOTE_SIZE, height: NOTE_SIZE }, canvasSize.width, canvasSize.height, NOTE_SIZE);
            placeElement({ type: 'note', color: NOTE_COLORS[0], contents: '', author: rememberedAuthor(), icon: 'Comment', ...rect });
            return;
        }
        if (DRAG_MODES.includes(mode) || (mode === 'form' && formSubMode === 'add')) {
            if (mode === 'link' && linkTarget === 'url' && !normalizeLinkUrl(linkUrl)) {
                setError(t('Type a valid link address first, for example https://example.com'));
                return;
            }
            if (mode === 'link' && linkTarget === 'page' && pageIndexFrom(linkPage, pages.count) == null) {
                setError(t('Choose a page from 1 to {total}.', { total: pages.count }));
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
            placeElement({ type: 'stroke', points: smoothStroke(points), color: drawColor, thickness: drawThickness, ink: drawAsInk });
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
        if (el.type === 'image') setActiveImageId(id);
        if (SELECTABLE.includes(el.type)) setSelectedId(id);
        const startPoint = pointerPoint(e, stage, natural);
        // The whole drag is one undo step.
        history.beginGesture();

        if (isLine(el)) {
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
                history.endGesture();
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
            setResult(null);
        };
        const handleUp = () => {
            window.removeEventListener('pointermove', handleMove);
            window.removeEventListener('pointerup', handleUp);
            history.endGesture();
        };
        window.addEventListener('pointermove', handleMove);
        window.addEventListener('pointerup', handleUp);
    }

    /** Keyboard selection of a placed element: focusing it (Tab) or Enter/Space selects it, so arrows nudge it and Delete removes it. */
    function keyboardSelect(el) {
        return {
            onFocus: (e) => {
                if (e.target !== e.currentTarget) return;
                if (el.type === 'image') setActiveImageId(el.id);
                if (SELECTABLE.includes(el.type)) setSelectedId(el.id);
            },
            onKeyDown: (e) => {
                if (e.target !== e.currentTarget || (e.key !== 'Enter' && e.key !== ' ')) return;
                e.preventDefault();
                if (el.type === 'image') setActiveImageId(el.id);
                if (SELECTABLE.includes(el.type)) setSelectedId(el.id);
            },
        };
    }

    function startRotate(e, id) {
        e.preventDefault();
        e.stopPropagation();
        const stage = stageRef.current;
        const natural = canvasSize;
        const el = elements.find((x) => x.id === id);
        if (!stage || !el) return;
        if (SELECTABLE.includes(el.type)) setSelectedId(id);
        const center = { x: el.x + el.width / 2, y: el.y + el.height / 2 };
        history.beginGesture();

        const handleMove = (ev) => {
            const rotation = angleFromCenter(center, pointerPoint(ev, stage, natural));
            setElements((list) => list.map((item) => (item.id === id ? { ...item, rotation } : item)));
            setResult(null);
        };
        const handleUp = () => {
            window.removeEventListener('pointermove', handleMove);
            window.removeEventListener('pointerup', handleUp);
            history.endGesture();
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

    // Something for Apply changes to save: added elements, page changes, changed form values, or a form to flatten.
    const hasEdits = elements.length > 0 || pages.changed || formDirty || formFlatten;

    async function apply(suffix = 'edited') {
        if (!doc || working || !hasEdits) return;
        setWorking(true);
        setError('');
        try {
            const [{ buildEditedPdf }, forms] = await Promise.all([loadEdit(), loadFormCreate()]);
            // A copy, so saving again later doesn't draw or create anything twice; then the pages in
            // the page panel's order, rotation, blanks and inserted PDFs; then the elements on top.
            const work = await pages.build(await forms.workingCopy(doc));
            const toBuild = toBuildElements(work, elements);
            const blob = await buildEditedPdf(work, toBuild.filter((el) => el.type !== 'formfield'), { beforeSave: formsBeforeSave(forms, toBuild) });
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-${suffix}.pdf`) });
        } catch (e) {
            setError(formSaveErrorText(e) ?? t('Editing failed: {message}', { message: e.message }));
        } finally {
            setWorking(false);
        }
    }

    function escapeKey() {
        if (editingId !== null) finishEditing();
        else if (selectedId !== null) setSelectedId(null);
        else if (mode !== 'select' && mode !== 'edittext') changeTool('select');
        else return false;
    }

    useEditorShortcuts(
        {
            undo,
            redo,
            delete: deleteSelected,
            escape: escapeKey,
            nudge: nudgeSelected,
            copy: copySelected,
            paste: pasteClipboard,
            duplicate: duplicateSelected,
            zoomIn: () => changeZoom(ZOOM_PRESETS.find((z) => z > zoomPct) ?? ZOOM_MAX),
            zoomOut: () => changeZoom([...ZOOM_PRESETS].reverse().find((z) => z < zoomPct) ?? ZOOM_MIN),
            prevPage: () => (currentPage > 0 ? setCurrentPage(currentPage - 1) : false),
            nextPage: () => (currentPage < pages.count - 1 ? setCurrentPage(currentPage + 1) : false),
        },
        { enabled: status === 'ready' }
    );

    // One primary action for every tool: add the watermark, or save every edit (elements, pages,
    // form values and new fields) into one PDF.
    function applyChanges() {
        if (mode === 'watermark') return applyWatermark();
        return apply(mode === 'sign' ? 'signed' : 'edited');
    }
    const applyDisabled = working || (mode === 'watermark' ? !(wmKind === 'text' ? wmText.trim() : wmPendingImage) : !hasEdits);
    const applyLabel = !working ? t('Apply changes') : mode === 'watermark' ? wmProgress || t('Adding watermark…') : t('Saving…');

    // Properties shown in the selected element's bar (an image's opacity and replace stay in ImageControls).
    function propertiesFor(el) {
        if (el.type === 'shape') {
            const look = shapeStyleOf(el);
            const value = { ...DEFAULT_SHAPE_PROPS, shape: el.shape, thickness: el.thickness, strokeColor: look.strokeColor, fill: look.fillColor != null, fillColor: look.fillColor ?? DEFAULT_SHAPE_PROPS.fillColor, opacity: look.opacity, dash: look.dash };
            return (
                <ShapeProps
                    value={value}
                    onChange={(patch) => {
                        // A box can become an ellipse and back, a line an arrow; not a box a line.
                        const shape = patch.shape && isLineShape(patch.shape) === isLineShape(el.shape) ? patch.shape : el.shape;
                        updateElement(el.id, { shape, ...shapeElementStyle({ ...value, ...patch, shape }) });
                    }}
                />
            );
        }
        if (el.type === 'link') {
            return <span className="pdf-selection__label" title={linkTargetLabel(el)}>{linkTargetLabel(el)}</span>;
        }
        if (el.type === 'highlight' || el.type === 'markup' || el.type === 'stroke') {
            const thick = el.type === 'stroke';
            const sizes = thick ? [...new Set([1, 2, 3, 5, 8, el.thickness])].sort((a, b) => a - b) : [];
            return (
                <>
                    <input type="color" value={el.color} onChange={(e) => updateElement(el.id, { color: e.target.value })} aria-label={t('Colour')} title={t('Colour')} />
                    {thick && (
                        <select className="pdf-selection__select" value={el.thickness} onChange={(e) => updateElement(el.id, { thickness: Number(e.target.value) })} aria-label={t('Line thickness')}>
                            {sizes.map((v) => <option key={v} value={v}>{v}px</option>)}
                        </select>
                    )}
                </>
            );
        }
        return null;
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

    const currentPageSize = pages.size(currentPage);
    const pageRotation = pages.rotation(currentPage);
    const scale = computeDisplayScale(currentPageSize.width, currentPageSize.height);
    const currentElements = elements.filter((el) => el.page === currentPage);
    const activeImage = elements.find((el) => el.id === activeImageId && el.type === 'image') ?? null;
    const zoomFactor = zoomPct / 100;

    return (
        <div className="stack">
            {mode === 'sign' && (
                <Notice type="info">{t('This creates an electronic signature (a drawn, typed or uploaded image placed on the PDF), not a certificate-based digital signature.')}</Notice>
            )}

            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => confirmDiscard() && openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <div className="field">
                <div className="pdf-editor__sticky">
                    <EditorToolbar
                        tool={mode}
                        onTool={changeTool}
                        shape={shapeProps.shape}
                        modes={EDITOR_MODES}
                        canUndo={history.canUndo}
                        canRedo={history.canRedo}
                        onUndo={undo}
                        onRedo={redo}
                        findOpen={findOpen && mode === 'edittext'}
                        onFind={() => {
                            if (mode !== 'edittext') {
                                changeTool('edittext');
                                setFindOpen(true);
                            } else setFindOpen((open) => !open);
                        }}
                        zoom={zoomPct}
                        onZoom={mode === 'watermark' ? undefined : changeZoom}
                        zoomMin={ZOOM_MIN}
                        zoomMax={ZOOM_MAX}
                    >
                        <button type="button" className="btn btn--primary btn--sm pdf-toolbar__apply" onClick={applyChanges} disabled={applyDisabled}>
                            {applyLabel}
                        </button>
                    </EditorToolbar>
                </div>
                {result && (
                    <div className="notice notice--success row row--between" style={{ marginTop: '0.6rem' }}>
                        <span>{t('Done!')} {formatBytes(result.blob.size)}</span>
                        <button type="button" className="btn btn--primary" onClick={downloadResult}>{t('Download PDF')}</button>
                    </div>
                )}

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
                {mode === 'sign' && (
                    <>
                        <SignatureMenu picked={signature} onPick={setSignature} onPlace={() => placeImage(signature)} addDate={signAddDate} onAddDateChange={setSignAddDate} onError={setError} />
                        <ImageControls element={activeImage?.signature ? activeImage : null} onChange={(changes) => updateElement(activeImage.id, changes)} onError={setError} />
                    </>
                )}
                {mode !== 'sign' && (
                <div className="pdf-editor__toolbar" style={{ marginTop: '0.7rem' }}>
                    {mode === 'select' && (
                        <span className="field__hint" style={{ margin: 0 }}>
                            {t('Click something you added to select it, or click the PDF’s own text to change it. Pick a tool above to add more.')}
                        </span>
                    )}
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
                            <span className="field__hint" style={{ margin: 0 }}>{pendingImage ? t('Or click on the page to place it there.') : t('You can also paste an image with Ctrl+V.')}</span>
                            <ImageControls element={activeImage && !activeImage.signature ? activeImage : null} onChange={(changes) => updateElement(activeImage.id, changes)} onError={setError} />
                        </>
                    )}
                    {mode === 'highlight' && (
                        <>
                            <input type="color" value={highlightColor} onChange={(e) => setHighlightColor(e.target.value)} aria-label={t('Highlight colour')} />
                            <button type="button" className="btn btn--primary btn--sm" onClick={() => addHighlight()}>{t('Add highlight to page')}</button>
                            <span className="field__hint" style={{ margin: 0 }}>{t('Or drag across text to highlight it.')}</span>
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
                                <FormCreateTools kind={formKind} onKind={setFormKind} onAdd={() => addFormElement()} />
                            ) : (
                                <span className="field__hint" style={{ margin: 0 }}>
                                    {!formReady
                                        ? t('Reading form fields…')
                                        : formFields.length === 0
                                          ? t('No fillable fields were found in this PDF.')
                                          : t('Fill in the fields on the page, then click Apply changes.')}
                                </span>
                            )}
                            <label className="check">
                                <input type="checkbox" checked={formFlatten} onChange={(e) => { setFormFlatten(e.target.checked); setResult(null); }} />
                                {t('Flatten the form so the answers cannot be changed')}
                            </label>
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
                    {mode === 'shape' && <ShapeProps value={shapeProps} onChange={(patch) => setShapeProps((p) => ({ ...p, ...patch }))} />}
                    {mode === 'link' && (
                        <>
                            <LinkTargetFields target={linkTarget} onTarget={setLinkTarget} url={linkUrl} onUrl={setLinkUrl} page={linkPage} onPage={setLinkPage} pageCount={pages.count} idPrefix="new-link" />
                            <span className="field__hint" style={{ margin: 0 }}>
                                {t('Then drag on the page over the area that should open the link.')} {pageLinks.length > 0 && t('Click an existing link to change or remove it.')}
                            </span>
                        </>
                    )}
                    {mode === 'note' && <span className="field__hint" style={{ margin: 0 }}>{t('Click on the page to add a note. Other PDF apps show it as a comment.')}</span>}
                    {mode === 'draw' && (
                        <>
                            <input type="color" value={drawColor} onChange={(e) => setDrawColor(e.target.value)} aria-label={t('Drawing colour')} />
                            <select className="select" style={{ maxWidth: '110px' }} value={drawThickness} onChange={(e) => setDrawThickness(Number(e.target.value))} aria-label={t('Line thickness')}>
                                {[2, 3, 5, 8].map((v) => <option key={v} value={v}>{v}px</option>)}
                            </select>
                            <label className="check">
                                <input type="checkbox" checked={drawAsInk} onChange={(e) => setDrawAsInk(e.target.checked)} /> {t('Save as an annotation (editable in other PDF apps)')}
                            </label>
                            <span className="field__hint" style={{ margin: 0 }}>{t('Draw directly on the page below')}</span>
                        </>
                    )}
                </div>
                )}

                {(mode === 'edittext' || mode === 'text') && editing?.type === 'textedit' && (editing.family ?? 'original') === 'original' && editing.run.fontData && missing.length > 0 && (
                    <Notice type="warn">{t('The PDF’s own font doesn’t include {letters}, so this line will use a similar font.', { letters: missing.join(' ') })}</Notice>
                )}
                {findOpen && mode === 'edittext' && (
                    <div className="pdf-editor__toolbar">
                        <input className="input" style={{ maxWidth: '180px' }} value={findText} onChange={(e) => setFindText(e.target.value)} placeholder={t('Find')} aria-label={t('Find')} />
                        <input className="input" style={{ maxWidth: '180px' }} value={replaceText} onChange={(e) => setReplaceText(e.target.value)} placeholder={t('Replace with')} aria-label={t('Replace with')} />
                        <button type="button" className="btn btn--sm" onClick={replaceAll} disabled={!findText || working}>{t('Replace all')}</button>
                        {replaceInfo && <span className="field__hint" style={{ margin: 0 }} aria-live="polite">{replaceInfo}</span>}
                    </div>
                )}

                <div className="pdf-editor__workspace">
                <PageSidebar
                    pageMap={pages.map}
                    thumbFor={pages.thumbFor}
                    sizeOf={pages.size}
                    current={currentPage}
                    onSelect={setCurrentPage}
                    onChange={pages.change}
                    onInsertPdf={(picked, position) => pages.insertPdf(picked, position).catch((e) => setError(t('Could not add that PDF: {message}', { message: e.message })))}
                    continuous={continuous}
                    onContinuousChange={setContinuous}
                />
                <div className="pdf-editor__main" ref={mainRef}>

                <div className="pdf-editor__toolbar">
                    <div className="pdf-editor__nav">
                        <button type="button" className="btn btn--sm" onClick={() => setCurrentPage((p) => Math.max(0, p - 1))} disabled={currentPage === 0}>
                            {t('Previous page')}
                        </button>
                        <span className="pdf-editor__page-label">{t('Page {current} of {total}', { current: currentPage + 1, total: pages.count })}</span>
                        <button type="button" className="btn btn--sm" onClick={() => setCurrentPage((p) => Math.min(pages.count - 1, p + 1))} disabled={currentPage >= pages.count - 1}>
                            {t('Next page')}
                        </button>
                    </div>
                </div>

                <PageScroller
                    enabled={continuous}
                    count={pages.count}
                    current={currentPage}
                    onCurrentChange={setCurrentPage}
                    getPage={(i) => ({ key: pages.entry(i).id, entry: pages.entry(i), renderDoc: pages.renderDocFor(pages.entry(i)), size: pages.size(i) })}
                    zoom={zoomFactor}
                    onInsertBlank={(position) => pages.change(insertBlank(pages.map, position, [currentPageSize.width, currentPageSize.height]))}
                >
                <div
                    className="pdf-editor__zoomport"
                    style={canvasSize.width ? viewSize(canvasSize.width, canvasSize.height, pageRotation, zoomFactor) : undefined}
                >
                <div
                    className="pdf-editor__stage"
                    ref={stageRef}
                    onPointerDown={startDraw}
                    data-rotation={pageRotation || undefined}
                    style={{
                        transformOrigin: 'top left',
                        transform: stageTransform(canvasSize.width, canvasSize.height, pageRotation, zoomFactor),
                        cursor: mode === 'form' && formSubMode === 'add' ? 'crosshair' : (mode === 'sign' && !signature) || (mode === 'image' && !pendingImage) ? 'default' : cursorForMode(mode),
                        ...(mode === 'draw' || mode === 'note' || DRAG_MODES.includes(mode) || (mode === 'form' && formSubMode === 'add') ? { touchAction: 'none' } : null),
                    }}
                >
                    <MappedPageCanvas entry={pages.entry(currentPage)} renderDoc={pages.renderDocFor(pages.entry(currentPage))} size={currentPageSize} scale={scale} className="pdf-editor__canvas" onReady={onPageReady} />
                    {(mode === 'edittext' || mode === 'text' || mode === 'select') &&
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
                    {mode === 'form' && (
                        <FormFieldOverlay widgets={pageWidgets} fields={formFields} values={formValues} onChange={changeFormValue} scale={scale} pageHeight={currentPageSize.height} interactive={formSubMode !== 'add'} />
                    )}
                    {mode === 'link' &&
                        pageLinks
                            .filter((link) => !currentElements.some((el) => el.type === 'linkedit' && el.annotIndex === link.index))
                            // The PDF names the target by its page in the original file; the editor by its place in the page panel.
                            .map((original) => ({ ...original, pageTarget: original.pageTarget == null ? null : pages.positionOfSource(original.pageTarget) }))
                            .map((link) => (
                                <LinkOverlay
                                    key={`link-${link.index}`}
                                    link={link}
                                    edit={null}
                                    rect={pdfRectToCanvasRect(link.rect, scale, currentPageSize.height)}
                                    pageCount={pages.count}
                                    onChange={(patch) => pushElement({ type: 'linkedit', annotId: link.id, annotIndex: link.index, linkRect: link.rect, link, url: link.url, pageTarget: link.pageTarget, remove: false, ...pdfRectToCanvasRect(link.rect, scale, currentPageSize.height), ...patch })}
                                    onRevert={() => {}}
                                />
                            ))}
                    {currentElements.map((el) => {
                        if (el.type === 'linkedit') {
                            if (mode !== 'link') return null;
                            const rect = pdfRectToCanvasRect(el.linkRect, scale, currentPageSize.height);
                            return <LinkOverlay key={el.id} link={el.link} edit={el} rect={rect} pageCount={pages.count} onChange={(patch) => updateElement(el.id, patch)} onRevert={() => removeElement(el.id)} />;
                        }
                        if (el.type === 'note') {
                            return <StickyNote key={el.id} el={el} onDragStart={(e) => startDrag(e, el.id, 'move')} onChange={(patch) => updateElement(el.id, patch)} onRemove={() => removeElement(el.id)} />;
                        }
                        if (el.quads?.length) {
                            const labels = OVERLAY_LABELS[el.type === 'markup' ? el.kind : 'highlight'];
                            return <TextMarkup key={el.id} el={el} scale={scale} pageHeight={currentPageSize.height} label={labels.drag()} removeLabel={labels.remove()} onDragStart={(e) => startDrag(e, el.id, 'move')} onRemove={() => removeElement(el.id)} keyboard={keyboardSelect(el)} selected={el.id === selectedId} />;
                        }
                        if (el.type === 'textedit' || el.type === 'text') {
                            return (
                                <TextBlockEditor
                                    key={el.id}
                                    el={el}
                                    selected={el.id === editingId && (mode === 'edittext' || mode === 'text')}
                                    scale={scale}
                                    labels={el.type === 'text' ? { drag: OVERLAY_LABELS.text.drag(), remove: OVERLAY_LABELS.text.remove() } : undefined}
                                    onChange={(changes) => updateElement(el.id, changes)}
                                    onLayout={(box) =>
                                        // Measured layout, not a user change: never its own undo step.
                                        setElements((list) => (list.some((item) => item.id === el.id && Object.keys(box).some((k) => item[k] !== box[k])) ? list.map((item) => (item.id === el.id ? { ...item, ...box } : item)) : list), { merge: true })
                                    }
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
                            const look = el.type === 'shape' ? shapeSvgStyle(el) : { stroke: el.color, strokeWidth: el.thickness };
                            return (
                                <div
                                    key={el.id}
                                    className="pdf-editor__overlay"
                                    style={{ left: bbox.x, top: bbox.y, width: bbox.width, height: bbox.height, border: 'none' }}
                                    onPointerDown={(e) => startDrag(e, el.id, 'move')}
                                    {...keyboardSelect(el)}
                                    role="button"
                                    tabIndex={0}
                                    aria-pressed={el.id === selectedId}
                                    aria-label={el.type === 'shape' ? t('Shape - drag to move') : t('Drawing - drag to move')}
                                >
                                    <svg width={bbox.width} height={bbox.height} style={{ pointerEvents: 'none', overflow: 'visible' }}>
                                        <g opacity={look.opacity}>
                                            {el.type === 'stroke' ? (
                                                <path d={strokeToSvgPath(local)} fill="none" stroke={look.stroke} strokeWidth={look.strokeWidth} strokeLinecap="round" strokeLinejoin="round" />
                                            ) : (
                                                <line x1={local[0].x} y1={local[0].y} x2={local[1].x} y2={local[1].y} stroke={look.stroke} strokeWidth={look.strokeWidth} strokeDasharray={look.strokeDasharray} strokeLinecap={look.strokeDasharray ? 'butt' : 'round'} />
                                            )}
                                            {head.map((h, i) => (
                                                <line key={i} x1={h.start.x} y1={h.start.y} x2={h.end.x} y2={h.end.y} stroke={look.stroke} strokeWidth={look.strokeWidth} strokeLinecap="round" />
                                            ))}
                                        </g>
                                    </svg>
                                    {el.type === 'shape' && (
                                        <LineEndHandles points={el.points} origin={bbox} stageRef={stageRef} canvasSize={canvasSize} onChange={(points) => updateElement(el.id, { points })} />
                                    )}
                                    <button type="button" className="pdf-editor__remove" aria-label={el.type === 'shape' ? t('Remove this shape') : t('Remove this drawing')} onPointerDown={(e) => e.stopPropagation()} onClick={() => removeElement(el.id)}>×</button>
                                </div>
                            );
                        }
                        if (el.type === 'formfield') {
                            return <FormFieldCreator key={el.id} el={el} onChange={(changes) => updateElement(el.id, changes)} onRemove={() => removeElement(el.id)} onStartDrag={(e, how) => startDrag(e, el.id, how)} />;
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
                                {...keyboardSelect(el)}
                                role="button"
                                tabIndex={0}
                                aria-pressed={SELECTABLE.includes(el.type) ? el.id === selectedId : undefined}
                                aria-label={labels.drag()}
                                title={el.type === 'link' ? linkTargetLabel(el) : undefined}
                            >
                                {el.type === 'image' && <img src={el.dataUrl} alt="" draggable={false} style={el.opacity != null && el.opacity < 1 ? { opacity: el.opacity } : undefined} />}
                                {el.type === 'image' && el.dateText && <span className="pdf-editor__date">{el.dateText}</span>}
                                {el.type === 'shape' && (
                                    <svg width={el.width} height={el.height} style={{ pointerEvents: 'none', overflow: 'visible', position: 'absolute', inset: 0 }}>
                                        {el.shape === 'ellipse' ? (
                                            <ellipse cx={el.width / 2} cy={el.height / 2} rx={el.width / 2} ry={el.height / 2} {...shapeSvgStyle(el)} />
                                        ) : (
                                            <rect x={0} y={0} width={el.width} height={el.height} {...shapeSvgStyle(el)} />
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
                                    <span style={{ fontSize: 11, color: '#1d4ed8', padding: '0 4px', whiteSpace: 'nowrap', overflow: 'hidden', textOverflow: 'ellipsis', pointerEvents: 'none' }}>{linkTargetLabel(el)}</span>
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
                            {mode === 'shape' && isLineShape(shapeProps.shape) ? (
                                <line x1={dragBox.start.x} y1={dragBox.start.y} x2={dragBox.end.x} y2={dragBox.end.y} {...shapeSvgStyle(shapeElementStyle(shapeProps))} strokeLinecap="round" />
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
                    {selected && selected.page === currentPage && (
                        <SelectionBar
                            box={elementBox(selected)}
                            stageWidth={canvasSize.width}
                            stageHeight={canvasSize.height}
                            zoom={zoomFactor}
                            onDelete={deleteSelected}
                            onDuplicate={duplicateSelected}
                            onForward={() => reorderSelected('forward')}
                            onBackward={() => reorderSelected('backward')}
                            canForward={canReorder(elements, selected.id, 'forward')}
                            canBackward={canReorder(elements, selected.id, 'backward')}
                        >
                            {propertiesFor(selected)}
                        </SelectionBar>
                    )}
                </div>
                </div>
                </PageScroller>
                {mode === 'form' && formSubMode === 'fill' && formFields.length > 0 && (
                    <details className="pdf-editor__formlist">
                        <summary>{t('Show all fields as a list')}</summary>
                        <FormFillFields status="ready" fields={formFields} values={formValues} onChange={changeFormValue} />
                    </details>
                )}
                </div>
                </div>
                </>
                )}
            </div>

            <Notice type="error">{error}</Notice>

        </div>
    );
}
