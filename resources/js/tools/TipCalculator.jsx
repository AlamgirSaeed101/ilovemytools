import { useId, useMemo, useState } from 'react';
import { Notice, Stat } from '../components/ui.jsx';
import { tipPresets } from '../lib/region.js';
import { calcTip, parseAmount, parsePeople } from '../lib/tip.js';
import { t } from '../lib/i18n.js';

export default function TipCalculator() {
    const [bill, setBill] = useState('85');
    // Local tipping habits: 15-25% in North America, 10-20% in the UK/Australia, 5-20% in Europe.
    const presets = useMemo(() => tipPresets(), []);
    const [tipPercent, setTipPercent] = useState(() => String(presets.includes(20) && presets[0] >= 15 ? 20 : presets[1]));
    const [people, setPeople] = useState('4');
    const [roundUp, setRoundUp] = useState(false);
    const billId = useId();
    const peopleId = useId();
    const tipId = useId();

    const billValue = parseAmount(bill);
    const tipValue = parseAmount(tipPercent);
    const peopleValue = parsePeople(people);
    const result = calcTip({ bill: billValue, tipPercent: tipValue, people: Number.isNaN(peopleValue) ? null : peopleValue, roundUp });
    const peopleInvalid = people.trim() !== '' && Number.isNaN(peopleValue);
    const error = result?.error || (peopleInvalid ? t('Enter at least 1 person to split between.') : '');

    return (
        <div className="stack">
            <div className="grid-2">
                <div className="field">
                    <label className="field__label" htmlFor={billId}>{t('Bill amount')}</label>
                    <input
                        id={billId}
                        className="input"
                        type="text"
                        inputMode="decimal"
                        autoComplete="off"
                        value={bill}
                        aria-invalid={bill.trim() !== '' && billValue === null}
                        onChange={(e) => setBill(e.target.value)}
                    />
                </div>
                <div className="field">
                    <label className="field__label" htmlFor={peopleId}>{t('Number of people')}</label>
                    <input
                        id={peopleId}
                        className="input"
                        type="text"
                        inputMode="numeric"
                        autoComplete="off"
                        value={people}
                        aria-invalid={peopleInvalid}
                        onChange={(e) => setPeople(e.target.value)}
                    />
                </div>
            </div>

            <div className="field">
                <span className="field__label" id={`${tipId}-label`}>{t('Tip percentage')}</span>
                <div className="row" role="group" aria-label={t('Tip percentage')}>
                    {presets.map((preset) => (
                        <button
                            key={preset}
                            type="button"
                            className={`btn${tipValue === preset ? ' is-active' : ''}`}
                            aria-pressed={tipValue === preset}
                            onClick={() => setTipPercent(String(preset))}
                        >
                            {preset}%
                        </button>
                    ))}
                    <label className="sr-only" htmlFor={tipId}>{t('Custom tip percentage')}</label>
                    <input
                        id={tipId}
                        className="input"
                        style={{ maxWidth: '6rem' }}
                        type="text"
                        inputMode="decimal"
                        autoComplete="off"
                        value={tipPercent}
                        aria-invalid={tipPercent.trim() !== '' && tipValue === null}
                        aria-describedby={`${tipId}-label`}
                        onChange={(e) => setTipPercent(e.target.value)}
                    />
                    <span aria-hidden="true">%</span>
                </div>
            </div>

            <label className="check">
                <input type="checkbox" checked={roundUp} onChange={(e) => setRoundUp(e.target.checked)} />
                {t('Round up the total per person to the next whole dollar')}
            </label>

            <Notice type="error">{error}</Notice>
            {!result && !error && <Notice type="info">{t('Enter a bill amount and tip percentage to split the bill.')}</Notice>}

            {result && !result.error && (
                <div className="stack" aria-live="polite">
                    <div className="stats">
                        <Stat value={result.totalPerPersonText} label={t('Total per person')} />
                        <Stat value={result.tipPerPersonText} label={t('Tip per person')} />
                        <Stat value={result.totalAmountText} label={t('Total bill')} />
                        <Stat value={result.tipAmountText} label={t('Total tip')} />
                    </div>
                    <div className="result__formula">{result.tipFormula}</div>
                    {result.splitFormula && <div className="result__formula">{result.splitFormula}</div>}
                    {result.roundedUp && <p className="field__hint">{t('Rounded up so each person pays a whole dollar amount.')}</p>}
                </div>
            )}
        </div>
    );
}
