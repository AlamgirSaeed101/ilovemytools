import { useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { buildPdf, isPdf } from '../lib/pdf.js';
import { usePdfPageThumbnails } from '../lib/pdfPages.js';
import { indexesExcluding, parseRanges, rangesToIndexes } from '../lib/pdfRanges.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { t, tn } from '../lib/i18n.js';

const MODES = [
    { id: 'select', label: 'Select by thumbnail' },
    { id: 'ranges', label: 'Page ranges' },
];

export default function DeletePdfPages() {
    const [file, setFile] = useState(null);
    const [mode, setMode] = useState('select');
    const [marked, setMarked] = useState(new Set()); // 1-based page numbers to delete
    const [rangeText, setRangeText] = useState('');
    const [rangeError, setRangeError] = useState('');
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null);
    const { status, doc, pageCount, thumbs } = usePdfPageThumbnails(file);

    function openFile([picked]) {
        setError('');
        setResult(null);
        setMarked(new Set());
        setRangeText('');
        setRangeError('');
        setFile(picked);
    }

    function toggleMarked(pageNumber) {
        setResult(null);
        setMarked((set) => {
            const next = new Set(set);
            if (next.has(pageNumber)) next.delete(pageNumber);
            else next.add(pageNumber);
            return next;
        });
    }

    function onRangeChange(value) {
        setResult(null);
        setRangeText(value);
        if (value.trim() === '') {
            setMarked(new Set());
            setRangeError('');
            return;
        }
        try {
            const ranges = parseRanges(value, pageCount);
            setMarked(new Set(rangesToIndexes(ranges).map((i) => i + 1)));
            setRangeError('');
        } catch (e) {
            setRangeError(e.message);
        }
    }

    const keepIndexes = indexesExcluding(pageCount, Array.from(marked, (n) => n - 1));
    const deleteAll = marked.size > 0 && keepIndexes.length === 0;
    const canDelete = marked.size > 0 && !deleteAll && !rangeError && !working;

    async function apply() {
        if (!doc || !canDelete) return;
        setWorking(true);
        setError('');
        try {
            const blob = await buildPdf([{ doc, indexes: keepIndexes }]);
            setResult({ blob, name: safeFilename(`${baseName(file.name)}-pages-deleted.pdf`), kept: keepIndexes.length });
        } catch (e) {
            setError(t('Deleting pages failed: {message}', { message: e.message }));
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

    return (
        <div className="stack">
            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{file.name}</strong> · {tn('{count} page', '{count} pages', pageCount)} · {formatBytes(file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => openFile([])}>{t('Choose another PDF')}</button>
            </div>

            <Tabs tabs={MODES.map((x) => ({ ...x, label: t(x.label) }))} value={mode} onChange={setMode} label={t('How to pick pages')} />

            {mode === 'ranges' && (
                <div className="field">
                    <label className="field__label" htmlFor="dp-ranges">{t('Pages to delete')}</label>
                    <input
                        id="dp-ranges"
                        className="input"
                        value={rangeText}
                        aria-invalid={Boolean(rangeError)}
                        aria-describedby="dp-help"
                        onChange={(e) => onRangeChange(e.target.value)}
                        placeholder={t('e.g. 2, 4-6')}
                    />
                    <span className="field__hint" id="dp-help">
                        {t('Pages 1 to {count}. Separate with commas. Example: 2, 4-6', { count: pageCount })}
                    </span>
                    {rangeError && <Notice type="error">{rangeError}</Notice>}
                </div>
            )}

            <p className="field__hint" style={{ margin: 0 }}>
                {marked.size > 0
                    ? tn('{count} page marked for deletion', '{count} pages marked for deletion', marked.size)
                    : t('Click a page to mark it for deletion.')}
            </p>

            <ol className="page-grid" aria-label={t('PDF pages')}>
                {Array.from({ length: pageCount }, (_, i) => {
                    const pageNumber = i + 1;
                    const thumb = thumbs[i];
                    const isMarked = marked.has(pageNumber);
                    return (
                        <li key={i}>
                            <label className={`page-card${isMarked ? ' is-marked' : ''}`}>
                                <input
                                    type="checkbox"
                                    className="page-card__check"
                                    checked={isMarked}
                                    onChange={() => toggleMarked(pageNumber)}
                                    aria-label={isMarked ? t('Keep page {number}', { number: pageNumber }) : t('Delete page {number}', { number: pageNumber })}
                                />
                                <div className="page-card__frame">
                                    {thumb?.url ? <img className="page-card__img" src={thumb.url} alt="" /> : <span className="field__hint">{t('Loading…')}</span>}
                                </div>
                                <span className="page-card__number">{pageNumber}{isMarked ? ` · ${t('Delete')}` : ''}</span>
                            </label>
                        </li>
                    );
                })}
            </ol>

            {deleteAll && <Notice type="error">{t("You can't delete every page. At least one page must remain.")}</Notice>}
            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done! {pages} left ({size}).', { pages: tn('{count} page', '{count} pages', result.kept), size: formatBytes(result.blob.size) })}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>{t('Download PDF')}</button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={apply} disabled={!canDelete}>
                    {working ? t('Deleting…') : t('Delete pages')}
                </button>
            )}
        </div>
    );
}
