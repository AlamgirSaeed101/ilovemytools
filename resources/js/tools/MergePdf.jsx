import { useRef, useState } from 'react';
import Dropzone from '../components/Dropzone.jsx';
import { Notice } from '../components/ui.jsx';
import { buildPdf, isPdf, loadPdf } from '../lib/pdf.js';
import { downloadBlob, formatBytes } from '../lib/util.js';
import { formatNumber, t, tn } from '../lib/i18n.js';

const MAX_FILES = 50;
let nextId = 1;

export default function MergePdf() {
    const [items, setItems] = useState([]); // { id, file, status: loading|ready|error, doc, pageCount, error }
    const [message, setMessage] = useState({ type: '', text: '' });
    const [merging, setMerging] = useState(false);
    const [result, setResult] = useState(null);
    const itemsRef = useRef(items);
    itemsRef.current = items;

    const update = (id, patch) => setItems((list) => list.map((it) => (it.id === id ? { ...it, ...patch } : it)));

    function addFiles(files) {
        setResult(null);
        const room = MAX_FILES - itemsRef.current.length;
        const accepted = files.slice(0, Math.max(0, room));
        setMessage(files.length > accepted.length ? { type: 'warn', text: t('You can merge up to {max} files at a time.', { max: MAX_FILES }) } : { type: '', text: '' });

        const newItems = accepted.map((file) => ({ id: nextId++, file, status: 'loading', doc: null, pageCount: 0, error: '' }));
        setItems((list) => [...list, ...newItems]);

        newItems.forEach(async (item) => {
            try {
                const { doc, pageCount } = await loadPdf(item.file);
                update(item.id, { status: 'ready', doc, pageCount });
            } catch (e) {
                update(item.id, { status: 'error', error: e.message });
            }
        });
    }

    function move(index, delta) {
        setResult(null);
        setItems((list) => {
            const next = [...list];
            const target = index + delta;
            if (target < 0 || target >= next.length) return list;
            [next[index], next[target]] = [next[target], next[index]];
            return next;
        });
    }

    function remove(id) {
        setResult(null);
        setItems((list) => list.filter((it) => it.id !== id));
    }

    const ready = items.filter((it) => it.status === 'ready');
    const loading = items.some((it) => it.status === 'loading');
    const hasErrors = items.some((it) => it.status === 'error');
    const totalPages = ready.reduce((sum, it) => sum + it.pageCount, 0);
    const canMerge = ready.length >= 2 && !loading && !hasErrors && !merging;

    async function merge() {
        if (!canMerge) return;
        setMerging(true);
        setMessage({ type: '', text: '' });
        try {
            const blob = await buildPdf(ready.map((it) => ({ doc: it.doc })));
            setResult({ blob, pages: totalPages });
        } catch (e) {
            setMessage({ type: 'error', text: t('Merging failed: {message}', { message: e.message }) });
        } finally {
            setMerging(false);
        }
    }

    return (
        <div className="stack">
            <Dropzone
                multiple
                accept=".pdf,application/pdf"
                isAccepted={isPdf}
                onReject={(bad) => setMessage({ type: 'error', text: tn('{files} is not a PDF.', '{files} are not PDFs.', bad.length, { files: bad.map((f) => f.name).join(', ') }) })}
                onFiles={addFiles}
                title={items.length ? t('Add more PDF files') : t('Drop PDF files here or click to choose')}
                hint={t('Select 2 or more PDFs · up to {max} files', { max: MAX_FILES })}
                compact={items.length > 0}
            />

            <Notice type={message.type || 'info'}>{message.text}</Notice>

            {items.length > 0 && (
                <>
                    <ol className="file-list" aria-label={t('Files to merge, in order')}>
                        {items.map((it, index) => (
                            <li key={it.id} className="file-item">
                                <span className="badge badge--muted" aria-hidden="true">{index + 1}</span>
                                <div className="file-item__main">
                                    <div className="file-item__name">{it.file.name}</div>
                                    <div className="file-item__meta">
                                        {formatBytes(it.file.size)}
                                        {it.status === 'loading' && ` · ${t('reading…')}`}
                                        {it.status === 'ready' && ` · ${tn('{count} page', '{count} pages', it.pageCount)}`}
                                    </div>
                                    {it.status === 'error' && <div className="file-item__meta" style={{ color: 'var(--danger)' }}>{it.error}</div>}
                                </div>
                                <div className="file-item__actions">
                                    <button type="button" className="btn btn--sm" onClick={() => move(index, -1)} disabled={index === 0} aria-label={t('Move {name} up', { name: it.file.name })}>↑</button>
                                    <button type="button" className="btn btn--sm" onClick={() => move(index, 1)} disabled={index === items.length - 1} aria-label={t('Move {name} down', { name: it.file.name })}>↓</button>
                                    <button type="button" className="btn btn--sm btn--ghost" onClick={() => remove(it.id)} aria-label={t('Remove {name}', { name: it.file.name })}>✕</button>
                                </div>
                            </li>
                        ))}
                    </ol>

                    {hasErrors && <Notice type="error">{t('Remove the files marked in red to continue.')}</Notice>}
                    {!hasErrors && ready.length === 1 && !loading && <Notice type="info">{t('Add at least one more PDF to merge.')}</Notice>}

                    {result ? (
                        <div className="notice notice--success row row--between">
                            <span>{t('Done! Your merged PDF has {pages} ({size}).', { pages: tn('{count} page', '{count} pages', result.pages), size: formatBytes(result.blob.size) })}</span>
                            <button type="button" className="btn btn--primary" onClick={() => downloadBlob(result.blob, 'merged.pdf')}>{t('Download merged PDF')}</button>
                        </div>
                    ) : (
                        <div className="row row--between">
                            <p className="field__hint" style={{ margin: 0 }}>{tn('{count} file', '{count} files', ready.length)} · {tn('{count} page in total', '{count} pages in total', totalPages)}</p>
                            <div className="row">
                                <button type="button" className="btn btn--danger" onClick={() => { setItems([]); setResult(null); setMessage({ type: '', text: '' }); }} disabled={merging}>{t('Clear')}</button>
                                <button type="button" className="btn btn--primary btn--lg" onClick={merge} disabled={!canMerge}>
                                    {merging ? t('Merging…') : t('Merge PDF')}
                                </button>
                            </div>
                        </div>
                    )}
                </>
            )}
        </div>
    );
}
