import { useMemo, useState } from 'react';
import { Notice } from '../components/ui.jsx';
import { formatNumber, getLocale, t } from '../lib/i18n.js';
import { analyzeAiText, MIN_WORDS } from '../lib/aiDetect.js';

const VERDICTS = {
    'likely-ai': { label: 'Likely AI-generated', tone: 'var(--danger)' },
    mixed: { label: 'Mixed or unclear', tone: '#d97706' },
    'likely-human': { label: 'Likely human-written', tone: 'var(--success)' },
};

const SIGNALS = [
    ['uniformity', 'Uniform sentence lengths', 'People mix short and long sentences; AI text is often very even.'],
    ['phrases', 'AI-typical phrases', 'Words such as "delve", "moreover" or "in today\'s fast-paced world".'],
    ['formality', 'Few contractions', 'AI rarely writes "don\'t" or "it\'s" unless asked to.'],
    ['repetition', 'Repetitive vocabulary', 'A smaller range of different words than usual.'],
];

export default function AiDetector() {
    const [text, setText] = useState('');
    const [checked, setChecked] = useState('');
    const r = useMemo(() => (checked ? analyzeAiText(checked) : null), [checked]);
    const verdict = r && !r.tooShort ? VERDICTS[r.verdict] : null;

    return (
        <div className="stack">
            <div className="field">
                <label className="field__label" htmlFor="ai-text">{t('Text to check')}</label>
                <textarea
                    id="ai-text"
                    className="textarea"
                    value={text}
                    onChange={(e) => setText(e.target.value)}
                    placeholder={t('Paste at least {min} words of English text…', { min: MIN_WORDS })}
                    rows={10}
                    spellCheck
                />
            </div>

            <div className="row">
                <button type="button" className="btn btn--primary" onClick={() => setChecked(text)} disabled={!text.trim()}>
                    {t('Check text')}
                </button>
                <button
                    type="button"
                    className="btn btn--danger"
                    onClick={() => {
                        setText('');
                        setChecked('');
                    }}
                    disabled={!text}
                >
                    {t('Clear')}
                </button>
            </div>

            {getLocale() !== 'en' && <Notice type="info">{t('The checker analyses English text only.')}</Notice>}

            {r?.tooShort && (
                <Notice type="warn">{t('Please paste at least {min} words (you have {count}) for a meaningful result.', { min: MIN_WORDS, count: r.words })}</Notice>
            )}

            {verdict && (
                <>
                    <div className="result" aria-live="polite" data-testid="ai-result">
                        <div className="flex flex-wrap items-center gap-4">
                            <span
                                className="grid size-20 shrink-0 place-items-center rounded-full text-[1.4rem] font-extrabold text-white"
                                style={{ background: verdict.tone }}
                                data-testid="ai-score"
                            >
                                {r.score}%
                            </span>
                            <div className="min-w-0">
                                <p className="m-0 text-[0.8rem] font-bold tracking-wider text-muted uppercase">{t('AI-likeness score')}</p>
                                <p className="m-0 text-[1.25rem] font-extrabold" data-testid="ai-verdict">{t(verdict.label)}</p>
                                <p className="m-0 text-muted">{t('{words} words · {sentences} sentences analysed', { words: formatNumber(r.words), sentences: formatNumber(r.sentences) })}</p>
                            </div>
                        </div>
                    </div>

                    <div className="grid gap-3 sm:grid-cols-2">
                        {SIGNALS.map(([key, label, help]) => (
                            <div key={key} className="rounded-xl border border-line bg-surface p-3">
                                <div className="mb-1.5 flex items-center justify-between gap-2 font-bold">
                                    <span>{t(label)}</span>
                                    <span>{r.signals[key]}%</span>
                                </div>
                                <div className="h-2 overflow-hidden rounded-full bg-surface-2" aria-hidden="true">
                                    <div className="h-full rounded-full" style={{ width: `${r.signals[key]}%`, background: verdict.tone }} />
                                </div>
                                <p className="mt-1.5 mb-0 text-[0.85rem] text-muted">{t(help)}</p>
                            </div>
                        ))}
                    </div>

                    {r.phrases.length > 0 && (
                        <div className="field">
                            <span className="field__label">{t('AI-typical phrases found')}</span>
                            <ul className="keyword-list">
                                {r.phrases.slice(0, 15).map((p) => (
                                    <li key={p.phrase}>
                                        {p.phrase} <strong>{p.count}</strong>
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}

                    <Notice type="warn">
                        {t('No AI detector is fully reliable, including this one. Use the score as a hint, never as proof, and never to accuse someone of cheating.')}
                    </Notice>
                </>
            )}
        </div>
    );
}
