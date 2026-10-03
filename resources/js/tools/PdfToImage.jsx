import { useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { isPdf } from '../lib/pdf.js';
import { usePdfPageThumbnails } from '../lib/pdfPages.js';
import { canvasToBlob, dpiToScale, renderPageToCanvas } from '../lib/pdfRender.js';
import { DPI_OPTIONS, mimeType, pageFilename } from '../lib/pdfToImage.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { t, tn } from '../lib/i18n.js';

/** Shared by /pdf-to-jpg and /pdf-to-png; `format` is 'jpeg' or 'png'. */
export default function PdfToImage({ format }) {
    const [file, setFile] = useState(null);
    const [dpi, setDpi] = useState(150);
    const [error, setError] = useState('');
    const [converting, setConverting] = useState(false);
    const [progress, setProgress] = useState(0);
    const [result, setResult] = useState(null);
    const { status, renderDoc, pageCount, thumbs } = usePdfPageThumbnails(file);

    function openFile([picked]) {
        setError('');
        setResult(null);
        setFile(picked);
    }

    async function convert() {
        if (!renderDoc || converting) return;
        setConverting(true);
        setProgress(0);
        setError('');
        try {
            const base = safeFilename(baseName(file.name));
            const scale = dpiToScale(dpi);
            const background = format === 'jpeg' ? '#ffffff' : null;
            const images = [];
            for (let i = 1; i <= pageCount; i++) {
                const canvas = await renderPageToCanvas(renderDoc, i, { scale, background });
                const blob = await canvasToBlob(canvas, mimeType(format), format === 'jpeg' ? 0.92 : undefined);
                images.push({ name: pageFilename(base, i, pageCount, format), blob });
                setProgress(i);
            }
            if (images.length === 1) {
                setResult({ blob: images[0].blob, name: images[0].name, count: 1 });
            } else {
                const { default: JSZip } = await import('jszip');
                const zip = new JSZip();
                images.forEach((img) => zip.file(img.name, img.blob));
                const blob = await zip.generateAsync({ type: 'blob' });
                setResult({ blob, name: `${base}.zip`, count: images.length });
            }
        } catch (e) {
            setError(t('Conversion failed: {message}', { message: e.message }));
        } finally {
            setConverting(false);
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

    return (
        <div className="stack">
            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {tn('{count} page', '{count} pages', pageCount)} · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <div className="field">
                <label className="field__label" htmlFor="p2i-dpi">{t('Image quality (DPI)')}</label>
                <select id="p2i-dpi" className="select" value={dpi} onChange={(e) => { setDpi(Number(e.target.value)); setResult(null); }}>
                    {DPI_OPTIONS.map((d) => (
                        <option key={d} value={d}>{t('{dpi} DPI', { dpi: d })}{d === 150 ? ` (${t('recommended')})` : ''}</option>
                    ))}
                </select>
            </div>

            <ol className="page-grid" aria-label={t('PDF pages')}>
                {Array.from({ length: pageCount }, (_, i) => (
                    <li key={i}>
                        <div className="page-card">
                            <div className="page-card__frame">
                                {thumbs[i]?.url ? <img className="page-card__img" src={thumbs[i].url} alt="" /> : <span className="field__hint">{t('Loading…')}</span>}
                            </div>
                            <span className="page-card__number">{i + 1}</span>
                        </div>
                    </li>
                ))}
            </ol>

            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done!')} {formatBytes(result.blob.size)}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>
                        {result.name.endsWith('.zip') ? t('Download ZIP') : t('Download image')}
                    </button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={convert} disabled={converting}>
                    {converting ? t('Converting {done} of {total}…', { done: progress, total: pageCount }) : t('Convert')}
                </button>
            )}
        </div>
    );
}
