import { useDeferredValue, useMemo, useState } from 'react';
import { Notice, Stat } from '../components/ui.jsx';
import { formatNumber, getLocale, t } from '../lib/i18n.js';
import { analyzeReadability } from '../lib/readability.js';

/** Colour for the Flesch Reading Ease gauge: green easy, amber medium, red hard. */
const easeTone = (score) => (score >= 60 ? 'var(--success)' : score >= 30 ? '#d97706' : 'var(--danger)');

export default function ReadabilityChecker() {
    const [text, setText] = useState('');
    const deferred = useDeferredValue(text);
    const r = useMemo(() => analyzeReadability(deferred), [deferred]);

    const grades = r && [
        [t('Flesch-Kincaid Grade'), r.fleschKincaid],
        [t('Gunning Fog Index'), r.gunningFog],
        [t('SMOG Index'), r.smog],
        [t('Coleman-Liau Index'), r.colemanLiau],
        [t('Automated Readability Index'), r.ari],
    ];

    return (
        <div className="stack">
            <div className="field">
                <label className="field__label" htmlFor="rd-text">{t('Your text')}</label>
                <textarea
                    id="rd-text"
                    className="textarea"
                    value={text}
                    onChange={(e) => setText(e.target.value)}
                    placeholder={t('Paste an article, essay or AI-written draft to check how easy it is to read…')}
                    rows={10}
                    spellCheck
                />
            </div>

            {getLocale() !== 'en' && <Notice type="info">{t('These formulas were designed for English text; scores for other languages are only a rough guide.')}</Notice>}

            {!r ? (
                <p className="field__hint">{t('Scores appear as soon as you type or paste a sentence.')}</p>
            ) : (
                <>
                    <div className="result" aria-live="polite" data-testid="readability-result">
                        <div className="flex flex-wrap items-center gap-4">
                            <span
                                className="grid size-20 shrink-0 place-items-center rounded-full text-[1.5rem] font-extrabold text-white"
                                style={{ background: easeTone(r.fleschEase) }}
                                data-testid="flesch-ease"
                            >
                                {formatNumber(r.fleschEase)}
                            </span>
                            <div className="min-w-0">
                                <p className="m-0 text-[0.8rem] font-bold tracking-wider text-muted uppercase">{t('Flesch Reading Ease')}</p>
                                <p className="m-0 text-[1.25rem] font-extrabold" data-testid="readability-level">{t(r.level)}</p>
                                <p className="m-0 text-muted">
                                    {t('Average grade level: {grade} · about {minutes} min to read', { grade: formatNumber(r.averageGrade), minutes: formatNumber(r.readingMinutes) })}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div className="stats">
                        <Stat value={formatNumber(r.words)} label={t('Words')} />
                        <Stat value={formatNumber(r.sentences)} label={t('Sentences')} />
                        <Stat value={formatNumber(r.wordsPerSentence)} label={t('Words per sentence')} />
                        <Stat value={formatNumber(r.syllablesPerWord)} label={t('Syllables per word')} />
                        <Stat value={formatNumber(r.complexWords)} label={t('Complex words (3+ syllables)')} />
                    </div>

                    <div className="table-wrap">
                        <table className="compare-table">
                            <caption className="sr-only">{t('Readability scores')}</caption>
                            <thead>
                                <tr>
                                    <th scope="col">{t('Formula')}</th>
                                    <th scope="col">{t('US school grade')}</th>
                                </tr>
                            </thead>
                            <tbody>
                                {grades.map(([name, value]) => (
                                    <tr key={name}>
                                        <th scope="row">{name}</th>
                                        <td>{formatNumber(value)}</td>
                                    </tr>
                                ))}
                            </tbody>
                        </table>
                    </div>

                    {r.longSentences.length > 0 && (
                        <div className="field">
                            <span className="field__label">{t('Long sentences to shorten ({count})', { count: r.longSentences.length })}</span>
                            <ul className="m-0 list-none space-y-2 p-0">
                                {r.longSentences.slice(0, 5).map((s) => (
                                    <li key={s.text} className="rounded-xl border border-line bg-surface-2 px-3 py-2 text-[0.92rem]">
                                        <strong className="text-danger">{t('{count} words', { count: s.words })}</strong> · {s.text}
                                    </li>
                                ))}
                            </ul>
                        </div>
                    )}

                    <div className="row">
                        <button type="button" className="btn btn--danger" onClick={() => setText('')}>
                            {t('Clear')}
                        </button>
                    </div>
                </>
            )}
        </div>
    );
}
