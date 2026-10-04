import { useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { excelToPdfBlob } from '../lib/excelToPdf.js';
import { baseName, downloadBlob, safeFilename } from '../lib/util.js';
import { t } from '../lib/i18n.js';
import { defaultPaper } from '../lib/region.js';

const ACCEPT = '.xlsx,.xls,.csv,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-excel,text/csv';

function isSpreadsheet(file) {
    return /\.(xlsx|xls|csv)$/i.test(file.name);
}

export default function ExcelToPdf() {
    const [file, setFile] = useState(null);
    const [pageSize, setPageSize] = useState(() => defaultPaper());
    const [orientation, setOrientation] = useState('portrait');
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
            const bytes = new Uint8Array(await file.arrayBuffer());
            const blob = await excelToPdfBlob(bytes, { pageSize, orientation });
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
                    accept={ACCEPT}
                    isAccepted={isSpreadsheet}
                    onReject={() => setError(t('Please choose an Excel (.xlsx, .xls) or CSV file.'))}
                    onFiles={openFile}
                    title={t('Drop a spreadsheet here or click to choose')}
                    hint={t('One .xlsx, .xls or .csv file · max 50 MB')}
                />
                <Notice type="error">{error}</Notice>
                <Notice type="info">
                    {t('Each sheet becomes a table spread across one or more pages, with the header row repeated. Cell colours, formulas, charts and merged cells are not preserved, and text too wide for its column is shortened with "…".')}
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

            <div className="grid-2">
                <div className="field">
                    <label className="field__label" htmlFor="e2p-size">{t('Page size')}</label>
                    <select
                        id="e2p-size"
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
                <div className="field">
                    <label className="field__label" htmlFor="e2p-orientation">{t('Orientation')}</label>
                    <select
                        id="e2p-orientation"
                        className="select"
                        value={orientation}
                        onChange={(e) => {
                            setOrientation(e.target.value);
                            setResult(null);
                        }}
                    >
                        <option value="portrait">{t('Portrait')}</option>
                        <option value="landscape">{t('Landscape')}</option>
                    </select>
                </div>
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
