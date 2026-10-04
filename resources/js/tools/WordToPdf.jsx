import { useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { htmlToPdfBlob } from '../lib/htmlToPdf.js';
import { docxToHtml, isDocx } from '../lib/wordToPdf.js';
import { baseName, downloadBlob, safeFilename } from '../lib/util.js';
import { t } from '../lib/i18n.js';
import { defaultPaper } from '../lib/region.js';

export default function WordToPdf() {
    const [file, setFile] = useState(null);
    const [pageSize, setPageSize] = useState(() => defaultPaper());
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);

    function openFile([picked]) {
        setError('');
        setResult(null);
        setFile(picked || null);
    }

    async function convert() {
        if (!file || working) return;
        setWorking(true);
        setError('');
        try {
            const html = await docxToHtml(file);
            const blob = await htmlToPdfBlob(html, { pageSize });
            setResult({ blob, name: safeFilename(`${baseName(file.name)}.pdf`) });
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
                    accept=".docx,application/vnd.openxmlformats-officedocument.wordprocessingml.document"
                    isAccepted={isDocx}
                    onReject={() => setError(t('Please choose a Word .docx file. Older .doc files are not supported.'))}
                    onFiles={openFile}
                    title={t('Drop a Word (.docx) file here or click to choose')}
                    hint={t('One .docx file · max 50 MB')}
                />
                <Notice type="error">{error}</Notice>
                <Notice type="info">
                    {t('Headings, paragraphs, lists, bold/italic text and images are kept. Tables, columns, text boxes, tracked changes and exact fonts or positioning are not preserved.')}
                </Notice>
            </div>
        );
    }

    return (
        <div className="stack">
            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}><strong>{file.name}</strong></p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another file')}</button>
            </div>

            <div className="field" style={{ maxWidth: '12rem' }}>
                <label className="field__label" htmlFor="w2p-size">{t('Page size')}</label>
                <select
                    id="w2p-size"
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

            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done! Your PDF is ready.')}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>{t('Download PDF')}</button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={convert} disabled={working}>
                    {working ? t('Converting…') : t('Convert to PDF')}
                </button>
            )}
        </div>
    );
}
