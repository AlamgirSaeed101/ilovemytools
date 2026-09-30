import { useState } from 'react';
import CopyButton from '../components/CopyButton.jsx';
import { t, tn } from '../lib/i18n.js';
import { CASES, convertCase, textStats } from '../lib/text.js';
import { downloadText } from '../lib/util.js';

// Everyday case names are translated; programming styles (camelCase...) are the same in every language.
const TRANSLATED = new Set(['upper', 'lower', 'title', 'sentence']);

export default function CaseConverter() {
    const [text, setText] = useState('');
    const [active, setActive] = useState(null);
    const stats = textStats(text);

    function apply(mode) {
        setText((current) => convertCase(current, mode));
        setActive(mode);
    }

    return (
        <div className="stack">
            <div className="field">
                <label className="field__label" htmlFor="cc-text">{t('Your text')}</label>
                <textarea
                    id="cc-text"
                    className="textarea"
                    value={text}
                    onChange={(e) => {
                        setText(e.target.value);
                        setActive(null);
                    }}
                    placeholder={t('Type or paste the text you want to convert…')}
                    rows={9}
                />
            </div>

            <div className="row" role="group" aria-label={t('Convert to')}>
                {CASES.map((c) => (
                    <button
                        key={c.id}
                        type="button"
                        className={`btn${active === c.id ? ' is-active' : ''}`}
                        onClick={() => apply(c.id)}
                        disabled={!text}
                    >
                        {TRANSLATED.has(c.id) ? t(c.label) : c.label}
                    </button>
                ))}
            </div>

            <div className="row row--between">
                <p className="field__hint" style={{ margin: 0 }}>
                    {tn('{count} word', '{count} words', stats.words)} · {tn('{count} character', '{count} characters', stats.characters)}
                </p>
                <div className="row">
                    <CopyButton text={text} className="btn btn--primary" />
                    <button type="button" className="btn" onClick={() => downloadText(text, 'converted-text.txt')} disabled={!text}>
                        {t('Download .txt')}
                    </button>
                    <button type="button" className="btn btn--danger" onClick={() => setText('')} disabled={!text}>
                        {t('Clear')}
                    </button>
                </div>
            </div>
        </div>
    );
}
