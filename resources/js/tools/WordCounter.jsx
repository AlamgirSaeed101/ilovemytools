import { useDeferredValue, useMemo, useState } from 'react';
import CopyButton from '../components/CopyButton.jsx';
import { Stat } from '../components/ui.jsx';
import { formatNumber, t } from '../lib/i18n.js';
import { formatDuration, keywordDensity, textStats } from '../lib/text.js';

export default function WordCounter() {
    const [text, setText] = useState('');
    // Keeps typing smooth even with very long documents.
    const deferred = useDeferredValue(text);
    const stats = useMemo(() => textStats(deferred), [deferred]);
    const keywords = useMemo(() => keywordDensity(deferred, 10), [deferred]);

    return (
        <div className="stack">
            <div className="stats" aria-live="polite">
                <Stat value={formatNumber(stats.words)} label={t('Words')} />
                <Stat value={formatNumber(stats.characters)} label={t('Characters')} />
                <Stat value={formatNumber(stats.charactersNoSpaces)} label={t('Characters (no spaces)')} />
                <Stat value={formatNumber(stats.sentences)} label={t('Sentences')} />
                <Stat value={formatNumber(stats.paragraphs)} label={t('Paragraphs')} />
            </div>

            <div className="field">
                <label className="field__label" htmlFor="wc-text">{t('Your text')}</label>
                <textarea
                    id="wc-text"
                    className="textarea"
                    value={text}
                    onChange={(e) => setText(e.target.value)}
                    placeholder={t('Start typing or paste your text here…')}
                    rows={10}
                    spellCheck
                />
            </div>

            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    {t('Reading time:')} <strong>{formatDuration(stats.readingSeconds)}</strong> · {t('Speaking time:')}{' '}
                    <strong>{formatDuration(stats.speakingSeconds)}</strong> · {t('Lines:')} <strong>{formatNumber(stats.lines)}</strong>
                </p>
                <div className="row">
                    <CopyButton text={text} />
                    <button type="button" className="btn btn--danger" onClick={() => setText('')} disabled={!text}>
                        {t('Clear')}
                    </button>
                </div>
            </div>

            {keywords.length > 0 && (
                <div className="field">
                    <span className="field__label">{t('Top keywords')}</span>
                    <ul className="keyword-list">
                        {keywords.map((k) => (
                            <li key={k.word}>
                                {k.word} <strong>{formatNumber(k.count)}</strong> ({formatNumber(k.percent)}%)
                            </li>
                        ))}
                    </ul>
                </div>
            )}
        </div>
    );
}
