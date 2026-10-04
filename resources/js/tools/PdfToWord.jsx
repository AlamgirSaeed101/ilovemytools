import { useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { isPdf, loadPdf } from '../lib/pdf.js';
import { pdfToDocxBlob } from '../lib/pdfToWord.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { t, tn } from '../lib/i18n.js';

export default function PdfToWord() {
    const [file, setFile] = useState(null);
    const [pageCount, setPageCount] = useState(0);
    const [checking, setChecking] = useState(false);
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);

    async function openFile([picked]) {
        setError('');
        setResult(null);
        setFile(null);
        if (!picked) return;
        setChecking(true);
        try {
            const { pageCount: count } = await loadPdf(picked);
            setFile(picked);
            setPageCount(count);
        } catch (e) {
            setError(e.message);
        } finally {
            setChecking(false);
        }
    }

    async function convert() {
        if (!file || working) return;
        setWorking(true);
        setError('');
        try {
            const bytes = new Uint8Array(await file.arrayBuffer());
            const blob = await pdfToDocxBlob(bytes);
            setResult({ blob, name: safeFilename(`${baseName(file.name)}.docx`) });
        } catch (e) {
            setError(e.message);
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
                {checking && <Notice type="info">{t('Reading PDF…')}</Notice>}
                <Notice type="error">{error}</Notice>
                <Notice type="info">
                    {t('Text, paragraphs and basic headings are extracted into an editable Word document. Complex layouts, tables, columns and images are not preserved, and scanned (image-only) pages have no text to extract.')}
                </Notice>
            </div>
        );
    }

    return (
        <div className="stack">
            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {formatBytes(file.size)} · {tn('{count} page', '{count} pages', pageCount)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done! Your Word document is ready.')}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>{t('Download Word document')}</button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={convert} disabled={working}>
                    {working ? t('Converting…') : t('Convert to Word')}
                </button>
            )}
        </div>
    );
}
