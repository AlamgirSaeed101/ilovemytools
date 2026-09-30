import { useState } from 'react';
import CopyButton from '../components/CopyButton.jsx';
import Dropzone from '../components/Dropzone.jsx';
import { Notice, Tabs } from '../components/ui.jsx';
import { bytesToBase64, decodeText, encodeText, toUrlSafe } from '../lib/base64.js';
import { formatBytes } from '../lib/util.js';
import { t } from '../lib/i18n.js';

const MAX_FILE = 10 * 1024 * 1024;

function TextMode() {
    const [input, setInput] = useState('');
    const [output, setOutput] = useState('');
    const [urlSafe, setUrlSafe] = useState(false);
    const [status, setStatus] = useState({ type: '', text: '' });

    function encode() {
        setOutput(encodeText(input, { urlSafe }));
        setStatus({ type: 'success', text: t('Encoded to Base64 ✓') });
    }

    function decode() {
        try {
            const { text, binary } = decodeText(input);
            setOutput(text);
            setStatus(binary
                ? { type: 'warn', text: t('Decoded, but the result is binary data (not readable text), so some characters may look strange.') }
                : { type: 'success', text: t('Decoded to text ✓') });
        } catch (e) {
            setOutput('');
            setStatus({ type: 'error', text: e.message });
        }
    }

    return (
        <div className="stack">
            <div className="field">
                <label className="field__label" htmlFor="b64-in">{t('Input')}</label>
                <textarea id="b64-in" className="textarea textarea--code" style={{ whiteSpace: 'pre-wrap' }} value={input} onChange={(e) => setInput(e.target.value)} placeholder={t('Type text to encode, or paste Base64 to decode…')} spellCheck={false} rows={7} />
            </div>
            <div className="row">
                <button type="button" className="btn btn--primary" onClick={encode} disabled={!input}>{t('Encode')} ↓</button>
                <button type="button" className="btn btn--primary" onClick={decode} disabled={!input.trim()}>{t('Decode')} ↓</button>
                <label className="check"><input type="checkbox" checked={urlSafe} onChange={(e) => setUrlSafe(e.target.checked)} /> {t('URL-safe')}</label>
                <button type="button" className="btn btn--danger" onClick={() => { setInput(''); setOutput(''); setStatus({ type: '', text: '' }); }} disabled={!input && !output}>{t('Clear')}</button>
            </div>
            <Notice type={status.type || 'info'}>{status.text}</Notice>
            <div className="field">
                <div className="row row--between">
                    <label className="field__label" htmlFor="b64-out">{t('Output')}</label>
                    <div className="row">
                        <CopyButton text={output} className="btn btn--sm btn--primary" />
                        <button type="button" className="btn btn--sm" onClick={() => { setInput(output); setOutput(''); setStatus({ type: '', text: '' }); }} disabled={!output}>{t('Swap')} ↑</button>
                    </div>
                </div>
                <textarea id="b64-out" className="textarea textarea--code" style={{ whiteSpace: 'pre-wrap', wordBreak: 'break-all' }} value={output} readOnly rows={7} spellCheck={false} />
            </div>
        </div>
    );
}

function FileMode() {
    const [file, setFile] = useState(null);
    const [b64, setB64] = useState('');
    const [urlSafe, setUrlSafe] = useState(false);
    const [error, setError] = useState('');
    const [loading, setLoading] = useState(false);

    async function openFile([f]) {
        setError('');
        setB64('');
        if (f.size > MAX_FILE) {
            setFile(null);
            setError(t('Files up to 10 MB are supported. Base64 for bigger files is too large to paste anywhere useful.'));
            return;
        }
        setLoading(true);
        try {
            const bytes = new Uint8Array(await f.arrayBuffer());
            setFile(f);
            setB64(bytesToBase64(bytes));
        } catch {
            setError(t('Could not read this file.'));
        } finally {
            setLoading(false);
        }
    }

    const mime = file?.type || 'application/octet-stream';
    const raw = urlSafe ? toUrlSafe(b64) : b64;
    const dataUrl = b64 ? `data:${mime};base64,${b64}` : '';

    return (
        <div className="stack">
            <Dropzone onFiles={openFile} title={loading ? t('Reading file…') : t('Drop a file here or click to choose')} hint={t('Any file · max 10 MB · images get a ready-to-use data URL')} compact={Boolean(file)} />
            <Notice type="error">{error}</Notice>
            {file && b64 && (
                <>
                    <p className="field__hint" style={{ margin: 0 }}>
                        <strong>{file.name}</strong> · {formatBytes(file.size)} → {t('{size} of Base64', { size: formatBytes(raw.length) })}
                    </p>
                    {mime.startsWith('image/') && <img className="image-preview" style={{ maxHeight: 160 }} src={dataUrl} alt={t('Preview of the encoded image')} />}
                    <div className="field">
                        <div className="row row--between">
                            <label className="field__label" htmlFor="b64-raw">Base64</label>
                            <div className="row">
                                <label className="check"><input type="checkbox" checked={urlSafe} onChange={(e) => setUrlSafe(e.target.checked)} /> {t('URL-safe')}</label>
                                <CopyButton text={raw} className="btn btn--sm btn--primary" />
                            </div>
                        </div>
                        <textarea id="b64-raw" className="textarea textarea--code" style={{ whiteSpace: 'pre-wrap', wordBreak: 'break-all', minHeight: 120 }} value={raw} readOnly rows={5} />
                    </div>
                    <div className="field">
                        <div className="row row--between">
                            <label className="field__label" htmlFor="b64-data">{t('Data URL (for HTML / CSS)')}</label>
                            <CopyButton text={dataUrl} className="btn btn--sm" />
                        </div>
                        <textarea id="b64-data" className="textarea textarea--code" style={{ whiteSpace: 'pre-wrap', wordBreak: 'break-all', minHeight: 100 }} value={dataUrl} readOnly rows={4} />
                    </div>
                </>
            )}
        </div>
    );
}

export default function Base64Tool() {
    const [mode, setMode] = useState('text');
    return (
        <div className="stack">
            <Tabs tabs={[{ id: 'text', label: t('Text') }, { id: 'file', label: t('File / Image') }]} value={mode} onChange={setMode} label={t('Base64 mode')} />
            {mode === 'text' ? <TextMode /> : <FileMode />}
        </div>
    );
}
