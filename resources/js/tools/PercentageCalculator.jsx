import { useState } from 'react';
import { applyPercent, parseNumber, percentChange, percentOf, wholeFromPart, whatPercent } from '../lib/percent.js';
import { t } from '../lib/i18n.js';

function Num({ id, value, onChange, label, suffix }) {
    const invalid = value.trim() !== '' && parseNumber(value) === null;
    return (
        <>
            <label className="sr-only" htmlFor={id}>{label}</label>
            <input
                id={id}
                className="input"
                type="text"
                inputMode="decimal"
                autoComplete="off"
                value={value}
                aria-invalid={invalid}
                onChange={(e) => onChange(e.target.value)}
            />
            {suffix && <span>{suffix}</span>}
        </>
    );
}

function Result({ result }) {
    if (!result) return null;
    if (result.error) return <p className="notice notice--error" role="alert" style={{ marginTop: '.75rem' }}>{result.error}</p>;
    return (
        <div className="result" aria-live="polite">
            <div className="result__value">{result.text}</div>
            <div className="result__formula">{result.formula}</div>
            {result.difference !== undefined && <div className="result__formula">{t('Difference: {value}', { value: result.difference })}</div>}
        </div>
    );
}

function useCalc(initialA, initialB) {
    const [a, setA] = useState(initialA);
    const [b, setB] = useState(initialB);
    return { a, b, setA, setB, na: parseNumber(a), nb: parseNumber(b) };
}

export default function PercentageCalculator() {
    const c1 = useCalc('15', '200');
    const c2 = useCalc('30', '120');
    const c3 = useCalc('80', '100');
    const c4 = useCalc('25', '20');
    const c5 = useCalc('50', '20');
    const [mode5, setMode5] = useState('increase');

    return (
        <div className="stack">
            <section className="calc-card" aria-labelledby="pc1">
                <h3 className="calc-card__title" id="pc1">{t('What is X% of Y?')}</h3>
                <div className="calc-line">
                    <span>{t('What is')}</span>
                    <Num id="pc1-a" label={t('Percentage')} value={c1.a} onChange={c1.setA} suffix="%" />
                    <span>{t('of')}</span>
                    <Num id="pc1-b" label={t('Number')} value={c1.b} onChange={c1.setB} />
                    <span>?</span>
                </div>
                <Result result={percentOf(c1.na, c1.nb)} />
            </section>

            <section className="calc-card" aria-labelledby="pc2">
                <h3 className="calc-card__title" id="pc2">{t('X is what percent of Y?')}</h3>
                <div className="calc-line">
                    <Num id="pc2-a" label={t('Part')} value={c2.a} onChange={c2.setA} />
                    <span>{t('is what % of')}</span>
                    <Num id="pc2-b" label={t('Whole')} value={c2.b} onChange={c2.setB} />
                    <span>?</span>
                </div>
                <Result result={whatPercent(c2.na, c2.nb)} />
            </section>

            <section className="calc-card" aria-labelledby="pc3">
                <h3 className="calc-card__title" id="pc3">{t('Percentage increase / decrease')}</h3>
                <div className="calc-line">
                    <span>{t('From')}</span>
                    <Num id="pc3-a" label={t('Starting value')} value={c3.a} onChange={c3.setA} />
                    <span>{t('to')}</span>
                    <Num id="pc3-b" label={t('Final value')} value={c3.b} onChange={c3.setB} />
                </div>
                <Result result={percentChange(c3.na, c3.nb)} />
            </section>

            <section className="calc-card" aria-labelledby="pc4">
                <h3 className="calc-card__title" id="pc4">{t('X is Y% of what number?')}</h3>
                <div className="calc-line">
                    <Num id="pc4-a" label={t('Part')} value={c4.a} onChange={c4.setA} />
                    <span>{t('is')}</span>
                    <Num id="pc4-b" label={t('Percentage')} value={c4.b} onChange={c4.setB} suffix="%" />
                    <span>{t('of what?')}</span>
                </div>
                <Result result={wholeFromPart(c4.na, c4.nb)} />
            </section>

            <section className="calc-card" aria-labelledby="pc5">
                <h3 className="calc-card__title" id="pc5">{t('Increase or decrease a number by a percentage')}</h3>
                <div className="calc-line">
                    <label className="sr-only" htmlFor="pc5-mode">{t('Increase or decrease')}</label>
                    <select id="pc5-mode" className="select" style={{ width: 'auto' }} value={mode5} onChange={(e) => setMode5(e.target.value)}>
                        <option value="increase">{t('Increase')}</option>
                        <option value="decrease">{t('Decrease')}</option>
                    </select>
                    <Num id="pc5-a" label={t('Number')} value={c5.a} onChange={c5.setA} />
                    <span>{t('by')}</span>
                    <Num id="pc5-b" label={t('Percentage')} value={c5.b} onChange={c5.setB} suffix="%" />
                </div>
                <Result result={applyPercent(c5.na, c5.nb, mode5)} />
            </section>
        </div>
    );
}
