import { useEffect, useRef, useState } from 'react';
import CopyButton from '../components/CopyButton.jsx';
import { Notice } from '../components/ui.jsx';
import { formatJson, parseJson, SAMPLE_JSON } from '../lib/json.js';
import { downloadText, formatBytes } from '../lib/util.js';
import { t } from '../lib/i18n.js';

export default function JsonFormatter() {
    const [input, setInput] = useState('');
    const [output, setOutput] = useState('');
    const [indent, setIndent] = useState('2');
    const [sortKeys, setSortKeys] = useState(false);
    const [status, setStatus] = useState({ type: '', text: '' });
    const lastRun = useRef(null); // 'format' | 'minify' | null

    function run(minify) {
        lastRun.current = minify ? 'minify' : 'format';
        const res = formatJson(input, { indent: indent === 'tab' ? 'tab' : Number(indent), sortKeys, minify });
        if (res.ok) {
            setOutput(res.output);
            setStatus({ type: 'success', text: `${t('Valid JSON ✓')} ${minify ? t('Minified') : t('Formatted')} · ${formatBytes(new Blob([res.output]).size)}` });
        } else {
            setOutput('');
            setStatus({ type: 'error', text: res.error });
        }
    }

    // Re-apply the last action when the indent or sort option changes.
    useEffect(() => {
        if (lastRun.current && output) run(lastRun.current === 'minify');
        // eslint-disable-next-line react-hooks/exhaustive-deps
    }, [indent, sortKeys]);

    function validate() {
        const res = parseJson(input);
        setStatus(res.ok ? { type: 'success', text: t('Valid JSON ✓') } : { type: 'error', text: res.error });
    }

    return (
        <div className="stack">
            <div className="field">
                <div className="row row--between">
                    <label className="field__label" htmlFor="json-in">{t('JSON input')}</label>
                    <div className="row">
                        <button type="button" className="btn btn--sm" onClick={() => { setInput(SAMPLE_JSON); setStatus({ type: '', text: '' }); }}>{t('Sample')}</button>
                        <button type="button" className="btn btn--sm btn--danger" onClick={() => { setInput(''); setOutput(''); setStatus({ type: '', text: '' }); lastRun.current = null; }} disabled={!input && !output}>{t('Clear')}</button>
                    </div>
                </div>
                <textarea
                    id="json-in"
                    className="textarea textarea--code"
                    value={input}
                    onChange={(e) => setInput(e.target.value)}
                    placeholder={t('{"paste": "your JSON here"}')}
                    spellCheck={false}
                    autoCapitalize="off"
                    autoCorrect="off"
                    aria-invalid={status.type === 'error'}
                    rows={10}
                />
            </div>

            <div className="row">
                <label className="field__label" htmlFor="json-indent" style={{ margin: 0 }}>{t('Indent')}</label>
                <select id="json-indent" className="select" style={{ width: 'auto' }} value={indent} onChange={(e) => setIndent(e.target.value)}>
                    <option value="2">{t('2 spaces')}</option>
                    <option value="4">{t('4 spaces')}</option>
                    <option value="tab">{t('Tabs')}</option>
                </select>
                <label className="check">
                    <input type="checkbox" checked={sortKeys} onChange={(e) => setSortKeys(e.target.checked)} /> {t('Sort keys A-Z')}
                </label>
            </div>

            <div className="row">
                <button type="button" className="btn btn--primary" onClick={() => run(false)} disabled={!input.trim()}>{t('Format / Beautify')}</button>
                <button type="button" className="btn" onClick={() => run(true)} disabled={!input.trim()}>{t('Minify')}</button>
                <button type="button" className="btn" onClick={validate} disabled={!input.trim()}>{t('Validate')}</button>
            </div>

            <Notice type={status.type || 'info'}>{status.text}</Notice>

            {output && (
                <div className="field">
                    <div className="row row--between">
                        <label className="field__label" htmlFor="json-out">{t('Result')}</label>
                        <div className="row">
                            <CopyButton text={output} className="btn btn--sm btn--primary" />
                            <button type="button" className="btn btn--sm" onClick={() => downloadText(output, 'formatted.json', 'application/json')}>{t('Download')}</button>
                            <button type="button" className="btn btn--sm" onClick={() => { setInput(output); setOutput(''); lastRun.current = null; }}>{t('Use as input')}</button>
                        </div>
                    </div>
                    <textarea id="json-out" className="textarea textarea--code" value={output} readOnly rows={12} spellCheck={false} />
                </div>
            )}
        </div>
    );
}
