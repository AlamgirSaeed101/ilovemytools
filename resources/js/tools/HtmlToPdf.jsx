import { useState } from 'react';
import { Notice } from '../components/ui.jsx';
import { htmlToPdfBlob } from '../lib/htmlToPdf.js';
import { downloadBlob } from '../lib/util.js';
import { t } from '../lib/i18n.js';
import { defaultPaper } from '../lib/region.js';

export default function HtmlToPdf() {
    const [html, setHtml] = useState('');
    const [pageSize, setPageSize] = useState(() => defaultPaper());
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);

    async function convert() {
        if (!html.trim() || working) return;
        setWorking(true);
        setError('');
        try {
            const blob = await htmlToPdfBlob(html, { pageSize });
            setResult({ blob });
        } catch (e) {
            setError(e.message);
        } finally {
            setWorking(false);
        }
    }

    return (
        <div className="stack">
            <div className="field">
                <label className="field__label" htmlFor="h2p-input">{t('HTML or plain text')}</label>
                <textarea
                    id="h2p-input"
                    className="textarea textarea--code"
                    rows={14}
                    spellCheck={false}
                    value={html}
                    onChange={(e) => {
                        setHtml(e.target.value);
                        setResult(null);
                    }}
                    placeholder={t('Paste HTML (<h1>, <p>, <ul>, <b>, <img>...) or just plain text here.')}
                />
            </div>

            <div className="field" style={{ maxWidth: '12rem' }}>
                <label className="field__label" htmlFor="h2p-size">{t('Page size')}</label>
                <select
                    id="h2p-size"
                    className="select"
                    value={pageSize}
                    onChange={(e) => {
                        setPageSize(e.target.value);
                        setResult(null);
                    }}
                >
                    <option value="a4">A4</option>
                    <option value="letter">{t('Letter')}</option>
                </select>
            </div>

            <Notice type="info">
                {t('Headings, paragraphs, line breaks, lists, bold/italic text and images (as data: URLs) are supported. Tables, columns, custom fonts and other styling are not preserved. Nothing is uploaded or fetched - the PDF is built entirely in your browser.')}
            </Notice>
            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done! Your PDF is ready.')}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, 'document.pdf')}>{t('Download PDF')}</button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={convert} disabled={!html.trim() || working}>
                    {working ? t('Converting…') : t('Convert to PDF')}
                </button>
            )}
        </div>
    );
}
