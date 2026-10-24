import { useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { isPdf, loadPdf } from '../lib/pdf.js';
import { STRONG_DEFAULT_DPI, STRONG_DPI_OPTIONS } from '../lib/pdfCompressOptions.js';
import { loadRenderDoc } from '../lib/pdfRender.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { t, tn } from '../lib/i18n.js';

const MODES = [
    { id: 'recommended', label: 'Recommended' },
    { id: 'strong', label: 'Strong' },
];

export default function CompressPdf() {
    const [file, setFile] = useState(null);
    const [pageCount, setPageCount] = useState(0);
    const [loading, setLoading] = useState(false);
    const [mode, setMode] = useState('recommended');
    const [dpi, setDpi] = useState(STRONG_DEFAULT_DPI);
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [progress, setProgress] = useState(0);
    const [result, setResult] = useState(null); // { blob, name, before, after, kept }

    async function openFile([picked]) {
        setError('');
        setResult(null);
        setLoading(true);
        try {
            const { pageCount } = await loadPdf(picked);
            setFile(picked);
            setPageCount(pageCount);
        } catch (e) {
            setFile(null);
            setError(e.message);
        } finally {
            setLoading(false);
        }
    }

    async function compress() {
        if (!file || working) return;
        setWorking(true);
        setError('');
        setResult(null);
        setProgress(0);
        const base = safeFilename(baseName(file.name));
        try {
            const bytes = new Uint8Array(await file.arrayBuffer());
            // pdf-lib loads only when a file is compressed, not with the page.
            const { compressPdfRecommended, compressPdfStrong } = await import('../lib/pdfCompress.js');
            let outputBytes;
            if (mode === 'recommended') {
                const { bytes: compressed } = await compressPdfRecommended(bytes);
                outputBytes = compressed;
            } else {
                const renderDoc = await loadRenderDoc(bytes);
                try {
                    outputBytes = await compressPdfStrong(renderDoc, pageCount, { dpi, onProgress: setProgress });
                } finally {
                    renderDoc.destroy();
                }
            }

            const kept = outputBytes.byteLength >= file.size;
            const blob = kept ? file : new Blob([outputBytes], { type: 'application/pdf' });
            setResult({
                blob,
                name: safeFilename(`${base}-compressed.pdf`),
                before: file.size,
                after: blob.size,
                kept,
            });
        } catch (e) {
            setError(t('Compression failed: {message}', { message: e.message }));
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
                    title={loading ? t('Reading PDF…') : t('Drop a PDF here or click to choose')}
                    hint={t('One PDF file · max 200 MB')}
                />
                <Notice type="error">{error}</Notice>
            </div>
        );
    }

    return (
        <div className="stack">
            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {tn('{count} page', '{count} pages', pageCount)} · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => { setFile(null); setResult(null); setError(''); }}>{t('Choose another PDF')}</button>
            </div>

            <Tabs tabs={MODES.map((x) => ({ ...x, label: t(x.label) }))} value={mode} onChange={(m) => { setMode(m); setResult(null); }} label={t('Compression mode')} />

            {mode === 'recommended' ? (
                <Notice type="info">{t('Re-encodes images at a lower quality and resolution. Text stays selectable and sharp.')}</Notice>
            ) : (
                <>
                    <Notice type="warn">{t('Strong mode turns every page into an image. Text can no longer be selected, searched or copied.')}</Notice>
                    <div className="field">
                        <label className="field__label" htmlFor="cp-dpi">{t('Image quality (DPI)')}</label>
                        <select id="cp-dpi" className="select" value={dpi} onChange={(e) => { setDpi(Number(e.target.value)); setResult(null); }}>
                            {STRONG_DPI_OPTIONS.map((d) => (
                                <option key={d} value={d}>{t('{dpi} DPI', { dpi: d })}{d === STRONG_DEFAULT_DPI ? ` (${t('recommended')})` : ''}</option>
                            ))}
                        </select>
                    </div>
                </>
            )}

            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>
                        {result.kept
                            ? t('This PDF could not be made smaller, so the original file is ready to download unchanged ({size}).', { size: formatBytes(result.before) })
                            : t('Done! {before} → {after} ({percent}% smaller).', {
                                before: formatBytes(result.before),
                                after: formatBytes(result.after),
                                percent: Math.round((1 - result.after / result.before) * 100),
                            })}
                    </span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>{t('Download PDF')}</button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={compress} disabled={working}>
                    {working
                        ? (mode === 'strong' ? t('Compressing {done} of {total}…', { done: progress, total: pageCount }) : t('Compressing…'))
                        : t('Compress PDF')}
                </button>
            )}
        </div>
    );
}
