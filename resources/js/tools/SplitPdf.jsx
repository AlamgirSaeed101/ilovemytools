import { useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { buildPdf, isPdf, loadPdf } from '../lib/pdf.js';
import { parseRanges, rangeLabel, rangesToIndexes } from '../lib/pdfRanges.js';
import { baseName, downloadBlob, formatBytes, safeFilename } from '../lib/util.js';
import { t, tn } from '../lib/i18n.js';

const MODES = [
    { id: 'extract', label: 'Extract pages' },
    { id: 'ranges', label: 'Split by ranges' },
    { id: 'every', label: 'Split every page' },
];

export default function SplitPdf() {
    const [source, setSource] = useState(null); // { file, doc, pageCount }
    const [loading, setLoading] = useState(false);
    const [mode, setMode] = useState('extract');
    const [rangeText, setRangeText] = useState('');
    const [error, setError] = useState('');
    const [working, setWorking] = useState(false);
    const [result, setResult] = useState(null); // { blob, name, summary }

    async function openFile([file]) {
        setError('');
        setResult(null);
        setLoading(true);
        try {
            const { doc, pageCount } = await loadPdf(file);
            setSource({ file, doc, pageCount });
            setRangeText(pageCount > 1 ? `1-${Math.min(pageCount, 3)}` : '1');
        } catch (e) {
            setSource(null);
            setError(e.message);
        } finally {
            setLoading(false);
        }
    }

    let ranges = null;
    let rangeError = '';
    if (source && mode !== 'every') {
        try {
            ranges = parseRanges(rangeText, source.pageCount);
        } catch (e) {
            rangeError = e.message;
        }
    }

    async function split() {
        if (!source) return;
        setWorking(true);
        setError('');
        setResult(null);
        const base = safeFilename(baseName(source.file.name));
        try {
            if (mode === 'extract') {
                const indexes = rangesToIndexes(ranges);
                const blob = await buildPdf([{ doc: source.doc, indexes }]);
                const label = ranges.map(rangeLabel).join('_');
                setResult({ blob, name: `${base}-${label.length > 40 ? 'extracted' : `pages-${label}`}.pdf`, summary: tn('1 PDF with {count} page', '1 PDF with {count} pages', indexes.length) });
            } else {
                const groups = mode === 'every'
                    ? Array.from({ length: source.pageCount }, (_, i) => [i + 1, i + 1])
                    : ranges;
                const files = [];
                for (const range of groups) {
                    const indexes = rangesToIndexes([range]);
                    files.push({ name: `${base}-${range[0] === range[1] ? `page-${range[0]}` : `pages-${rangeLabel(range)}`}.pdf`, blob: await buildPdf([{ doc: source.doc, indexes }]) });
                }
                if (files.length === 1) {
                    setResult({ ...files[0], summary: t('1 PDF') });
                } else {
                    const { default: JSZip } = await import('jszip');
                    const zip = new JSZip();
                    const seen = new Set();
                    files.forEach((f) => {
                        let name = f.name;
                        for (let n = 2; seen.has(name); n++) name = f.name.replace(/\.pdf$/, ` (${n}).pdf`);
                        seen.add(name);
                        zip.file(name, f.blob);
                    });
                    const blob = await zip.generateAsync({ type: 'blob' });
                    setResult({ blob, name: `${base}-split.zip`, summary: t('{count} PDFs in a ZIP file', { count: files.length }) });
                }
            }
        } catch (e) {
            setError(t('Splitting failed: {message}', { message: e.message }));
        } finally {
            setWorking(false);
        }
    }

    if (!source) {
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

    const disabled = working || (mode !== 'every' && !ranges);

    return (
        <div className="stack">
            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    <strong>{source.file.name}</strong> · {tn('{count} page', '{count} pages', source.pageCount)} · {formatBytes(source.file.size)}
                </p>
                <button type="button" className="btn btn--sm" onClick={() => { setSource(null); setResult(null); setError(''); }}>{t('Choose another PDF')}</button>
            </div>

            <Tabs tabs={MODES.map((x) => ({ ...x, label: t(x.label) }))} value={mode} onChange={(m) => { setMode(m); setResult(null); }} label={t('Split mode')} />

            {mode === 'every' ? (
                <Notice type="info">{source.pageCount > 1 ? t('Every page will be saved as its own PDF ({count} files), bundled in a ZIP.', { count: source.pageCount }) : t('Every page will be saved as its own PDF (1 file).')}</Notice>
            ) : (
                <div className="field">
                    <label className="field__label" htmlFor="sp-ranges">{mode === 'extract' ? t('Pages to extract') : t('Ranges (each becomes a separate PDF)')}</label>
                    <input
                        id="sp-ranges"
                        className="input"
                        value={rangeText}
                        aria-invalid={Boolean(rangeError)}
                        aria-describedby="sp-help"
                        onChange={(e) => { setRangeText(e.target.value); setResult(null); }}
                        placeholder={t('e.g. 1-3, 5, 8-10')}
                    />
                    <span className="field__hint" id="sp-help">
                        {t('Pages 1 to {count}. Separate with commas. Example: 1-3, 5, 8-{count}', { count: source.pageCount })}
                    </span>
                    {rangeError && <Notice type="error">{rangeError}</Notice>}
                </div>
            )}

            <Notice type="error">{error}</Notice>

            {result ? (
                <div className="notice notice--success row row--between">
                    <span>{t('Done!')} {result.summary} · {formatBytes(result.blob.size)}</span>
                    <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, result.name)}>
                        {result.name.endsWith('.zip') ? t('Download ZIP') : t('Download PDF')}
                    </button>
                </div>
            ) : (
                <button type="button" className="btn btn--primary btn--lg" onClick={split} disabled={disabled}>
                    {working ? t('Splitting…') : t('Split PDF')}
                </button>
            )}
        </div>
    );
}
