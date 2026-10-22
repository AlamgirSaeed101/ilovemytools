import { useEffect, useRef, useState } from 'react';
import { PDFDocument } from 'pdf-lib';
import Dropzone from '../components/Dropzone.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { t, tn } from '../lib/i18n.js';
import { isPdf } from '../lib/pdf.js';
import { computeDisplayScale } from '../lib/pdfOverlay.js';
import { usePdfDoc } from '../lib/pdfPages.js';
import { loadRenderDoc, renderPageToCanvas } from '../lib/pdfRender.js';
import { buildWatermarkedPdf, imageWatermarkSize, watermarkPageIndexes } from '../lib/pdfWatermark.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';

const TEXT_SIZES = [24, 32, 48, 64, 96];
const POSITIONS = [
    { id: 'center', label: () => t('Centre') },
    { id: 'top-left', label: () => t('Top left') },
    { id: 'top-right', label: () => t('Top right') },
    { id: 'bottom-left', label: () => t('Bottom left') },
    { id: 'bottom-right', label: () => t('Bottom right') },
    { id: 'tile', label: () => t('Tiled across the page') },
];
const SCOPES = [
    { id: 'all', label: () => t('All pages') },
    { id: 'odd', label: () => t('Odd pages') },
    { id: 'even', label: () => t('Even pages') },
    { id: 'skip-first', label: () => t('All pages except the first') },
    { id: 'range', label: () => t('Choose pages') },
];

export default function WatermarkPdf() {
    const [file, setFile] = useState(null);
    const [kind, setKind] = useState('text');
    const [text, setText] = useState('');
    const [textSize, setTextSize] = useState(48);
    const [textColor, setTextColor] = useState('#6b7280');
    const [textBold, setTextBold] = useState(true);
    const [pendingImage, setPendingImage] = useState(null);
    const [imageScalePct, setImageScalePct] = useState(30);
    const [opacityPct, setOpacityPct] = useState(30);
    const [rotation, setRotation] = useState(-45);
    const [position, setPosition] = useState('center');
    const [scope, setScope] = useState('all');
    const [rangeText, setRangeText] = useState('');
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);
    const previewCanvasRef = useRef(null);
    const previewRenderDocRef = useRef(null);
    const { status, doc, renderDoc, pageCount } = usePdfDoc(file);

    function openFile([picked]) {
        setError('');
        setResult(null);
        setFile(picked);
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
                setResult(null);
            }, 'image/png');
        };
        img.onerror = () => {
            URL.revokeObjectURL(url);
            setError(t('Could not read that image.'));
        };
        img.src = url;
    }

    function contentFor(pageWidth) {
        if (kind === 'text') {
            if (!text.trim()) return null;
            return { kind: 'text', text, size: textSize, bold: textBold, color: textColor };
        }
        if (!pendingImage) return null;
        const { width, height } = imageWatermarkSize(pageWidth, pendingImage.width, pendingImage.height, imageScalePct);
        return { kind: 'image', bytes: pendingImage.bytes, width, height };
    }

    // Live preview: builds a real one-page watermarked PDF for page 1 and renders it with pdf.js,
    // so the preview always matches exactly what downloading will produce.
    useEffect(() => {
        if (!doc || !renderDoc) return;
        let cancelled = false;
        const { width: pageWidth, height: pageHeight } = doc.getPage(0).getSize();
        const scale = computeDisplayScale(pageWidth, pageHeight);
        (async () => {
            const content = contentFor(pageWidth);
            let sourceRenderDoc = renderDoc;
            let ownRenderDoc = null;
            if (content) {
                const previewDoc = await PDFDocument.create();
                const [copied] = await previewDoc.copyPages(doc, [0]);
                previewDoc.addPage(copied);
                const blob = await buildWatermarkedPdf(previewDoc, { pageIndexes: [0], position, opacity: opacityPct / 100, rotation, content });
                const bytes = new Uint8Array(await blob.arrayBuffer());
                if (cancelled) return;
                ownRenderDoc = await loadRenderDoc(bytes);
                if (cancelled) {
                    ownRenderDoc.destroy();
                    return;
                }
                sourceRenderDoc = ownRenderDoc;
            }
            const canvas = await renderPageToCanvas(sourceRenderDoc, 1, { scale, background: '#ffffff' });
            previewRenderDocRef.current?.destroy();
            previewRenderDocRef.current = ownRenderDoc;
            if (cancelled || !previewCanvasRef.current) return;
            previewCanvasRef.current.width = canvas.width;
            previewCanvasRef.current.height = canvas.height;
            previewCanvasRef.current.getContext('2d').drawImage(canvas, 0, 0);
        })().catch(() => {
            // The preview is a convenience; a failure here never blocks the real download below.
        });
        return () => {
            cancelled = true;
        };
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [doc, renderDoc, kind, text, textSize, textColor, textBold, pendingImage, imageScalePct, opacityPct, rotation, position]);

    useEffect(() => () => previewRenderDocRef.current?.destroy(), []);

    // A finished download no longer matches the settings once any of them change.
    useEffect(() => {
        setResult(null);
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [kind, text, textSize, textColor, textBold, pendingImage, imageScalePct, opacityPct, rotation, position, scope, rangeText]);

    async function apply() {
        if (!doc || working) return;
        const pageWidth = doc.getPage(0).getSize().width;
        const content = contentFor(pageWidth);
        if (!content) {
            setError(kind === 'text' ? t('Type the watermark text first.') : t('Choose a logo or image first.'));
            return;
        }
        setWorking(true);
        setError('');
        try {
            const pageIndexes = watermarkPageIndexes(pageCount, scope, rangeText);
            const blob = await buildWatermarkedPdf(doc, { pageIndexes, position, opacity: opacityPct / 100, rotation, content });
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-watermarked.pdf`) });
        } catch (e) {
            setError(t('Adding the watermark failed: {message}', { message: e.message }));
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

    const canApply = kind === 'text' ? text.trim().length > 0 : !!pendingImage;

    return (
        <div className="stack">
            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {tn('{count} page', '{count} pages', pageCount)} · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <div className="grid-2">
                <div className="field">
                    <Tabs
                        label={t('Watermark type')}
                        value={kind}
                        onChange={setKind}
                        tabs={[{ id: 'text', label: t('Text') }, { id: 'image', label: t('Logo or image') }]}
                    />

                    {kind === 'text' ? (
                        <div className="stack" style={{ gap: '.6rem', marginTop: '.7rem' }}>
                            <input
                                className="input"
                                value={text}
                                onChange={(e) => setText(e.target.value)}
                                placeholder={t('e.g. CONFIDENTIAL, DRAFT, Your Company')}
                                aria-label={t('Watermark text')}
                            />
                            <div className="row">
                                <select className="select" style={{ maxWidth: '110px' }} value={textSize} onChange={(e) => setTextSize(Number(e.target.value))} aria-label={t('Font size')}>
                                    {TEXT_SIZES.map((s) => <option key={s} value={s}>{s}px</option>)}
                                </select>
                                <input type="color" value={textColor} onChange={(e) => setTextColor(e.target.value)} aria-label={t('Text colour')} />
                                <label className="check">
                                    <input type="checkbox" checked={textBold} onChange={(e) => setTextBold(e.target.checked)} /> {t('Bold')}
                                </label>
                            </div>
                        </div>
                    ) : (
                        <div className="stack" style={{ gap: '.6rem', marginTop: '.7rem' }}>
                            <Dropzone
                                accept="image/png,image/jpeg,image/webp"
                                isAccepted={(f) => /^image\/(png|jpeg|webp)$/.test(f.type)}
                                onFiles={handleImageFile}
                                onReject={() => setError(t('Please choose a PNG, JPG or WebP image.'))}
                                title={pendingImage ? t('Choose a different image') : t('Drop an image or click to choose')}
                                hint={t('PNG, JPG or WebP · a transparent PNG logo works best')}
                                compact
                            />
                            <div className="field">
                                <label className="field__label" htmlFor="wm-image-size">{t('Logo size: {value}% of the page width', { value: imageScalePct })}</label>
                                <input id="wm-image-size" className="range" type="range" min={5} max={80} step={5} value={imageScalePct} onChange={(e) => setImageScalePct(Number(e.target.value))} />
                            </div>
                        </div>
                    )}

                    <div className="field">
                        <label className="field__label" htmlFor="wm-opacity">{t('Opacity: {value}%', { value: opacityPct })}</label>
                        <input id="wm-opacity" className="range" type="range" min={5} max={100} step={5} value={opacityPct} onChange={(e) => setOpacityPct(Number(e.target.value))} />
                    </div>

                    <div className="field">
                        <label className="field__label" htmlFor="wm-rotation">{t('Rotation: {value}°', { value: rotation })}</label>
                        <input id="wm-rotation" className="range" type="range" min={-180} max={180} step={5} value={rotation} onChange={(e) => setRotation(Number(e.target.value))} />
                    </div>

                    <div className="field">
                        <label className="field__label" htmlFor="wm-position">{t('Position')}</label>
                        <select id="wm-position" className="select" value={position} onChange={(e) => setPosition(e.target.value)}>
                            {POSITIONS.map((p) => <option key={p.id} value={p.id}>{p.label()}</option>)}
                        </select>
                    </div>

                    <div className="field">
                        <label className="field__label" htmlFor="wm-scope">{t('Pages')}</label>
                        <select id="wm-scope" className="select" value={scope} onChange={(e) => setScope(e.target.value)}>
                            {SCOPES.map((s) => <option key={s.id} value={s.id}>{s.label()}</option>)}
                        </select>
                        {scope === 'range' && (
                            <input
                                className="input"
                                style={{ marginTop: '.5rem' }}
                                value={rangeText}
                                onChange={(e) => setRangeText(e.target.value)}
                                placeholder={t('e.g. 1-3, 5')}
                                aria-label={t('Page range')}
                            />
                        )}
                    </div>
                </div>

                <div className="field">
                    <span className="field__label">{t('Preview of page 1')}</span>
                    <div className="pdf-editor__stage" style={{ cursor: 'default' }}>
                        <canvas ref={previewCanvasRef} className="pdf-editor__canvas" aria-label={t('Preview of page 1')} />
                    </div>
                </div>
            </div>

            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done!')} {formatBytes(result.blob.size)}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>{t('Download PDF')}</button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={apply} disabled={working || !canApply}>
                    {working ? t('Adding watermark…') : t('Add watermark')}
                </button>
            )}
        </div>
    );
}
