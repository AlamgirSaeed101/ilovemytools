import { useId, useMemo, useState } from 'react';
import { Notice, Stat, Tabs } from '../components/ui.jsx';
import { defaultCurrency, defaultMortgageTermYears } from '../lib/region.js';
import { calcMortgage, parseMoney, parsePercent, parseTermYears, TERM_PRESETS } from '../lib/mortgage.js';
import { formatNumber, t, tn } from '../lib/i18n.js';

const CURRENCIES = ['$', '£', '€', 'C$', 'A$'];
const years = (n) => tn('{count} year', '{count} years', n);
const months = (n) => tn('{count} month', '{count} months', n);

function payoffText(totalMonths) {
    const y = Math.floor(totalMonths / 12);
    const m = totalMonths % 12;
    if (y === 0) return months(m);
    if (m === 0) return years(y);
    return t('{years}, {months}', { years: years(y), months: months(m) });
}

export default function MortgageCalculator() {
    const [homePrice, setHomePrice] = useState('350000');
    const [downMode, setDownMode] = useState('percent');
    const [downAmount, setDownAmount] = useState('70000');
    const [downPercent, setDownPercent] = useState('20');
    const [rate, setRate] = useState('6.5');
    const termPresets = TERM_PRESETS;
    const [term, setTerm] = useState(() => String(defaultMortgageTermYears()));
    const [extra, setExtra] = useState('0');
    const [currency, setCurrency] = useState(() => defaultCurrency());
    const [showTable, setShowTable] = useState(false);

    const priceId = useId();
    const downId = useId();
    const rateId = useId();
    const termId = useId();
    const extraId = useId();
    const currencyId = useId();

    const priceValue = parseMoney(homePrice);
    const downValue = parseMoney(downMode === 'percent' ? downPercent : downAmount);
    const rateValue = parsePercent(rate);
    const termValue = parseTermYears(term);
    const extraValue = parseMoney(extra || '0');

    const termInvalid = term.trim() !== '' && Number.isNaN(termValue);
    const extraInvalid = extra.trim() !== '' && extraValue === null;

    const result = useMemo(() => {
        if (termInvalid || extraInvalid || Number.isNaN(termValue) || extraValue === null) return null;
        return calcMortgage({
            homePrice: priceValue,
            downPayment: downValue,
            downPaymentIsPercent: downMode === 'percent',
            annualRatePercent: rateValue,
            termYears: termValue,
            extraMonthly: extraValue,
        });
    }, [priceValue, downValue, downMode, rateValue, termValue, extraValue, termInvalid, extraInvalid]);

    const error =
        result?.error ||
        (termInvalid ? t('Enter a loan term between 1 and 50 years.') : '') ||
        (extraInvalid ? t('Enter an extra payment of 0 or more.') : '');

    function money(n) {
        return `${currency}${formatNumber(n, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    return (
        <div className="stack">
            <div className="grid-2">
                <div className="field">
                    <label className="field__label" htmlFor={priceId}>{t('Home price')}</label>
                    <input
                        id={priceId}
                        className="input"
                        type="text"
                        inputMode="decimal"
                        autoComplete="off"
                        value={homePrice}
                        aria-invalid={homePrice.trim() !== '' && priceValue === null}
                        onChange={(e) => setHomePrice(e.target.value)}
                    />
                </div>
                <div className="field">
                    <label className="field__label" htmlFor={currencyId}>{t('Currency')}</label>
                    <select id={currencyId} className="select" value={currency} onChange={(e) => setCurrency(e.target.value)}>
                        {CURRENCIES.map((c) => <option key={c} value={c}>{c}</option>)}
                    </select>
                </div>
            </div>

            <div className="field">
                <span className="field__label">{t('Down payment')}</span>
                <Tabs
                    tabs={[{ id: 'percent', label: t('By percentage') }, { id: 'amount', label: t('By amount') }]}
                    value={downMode}
                    onChange={setDownMode}
                    label={t('Down payment')}
                />
                {downMode === 'percent' ? (
                    <div className="row">
                        <label className="sr-only" htmlFor={downId}>{t('Down payment percentage')}</label>
                        <input
                            id={downId}
                            className="input"
                            style={{ maxWidth: '8rem' }}
                            type="text"
                            inputMode="decimal"
                            autoComplete="off"
                            value={downPercent}
                            aria-invalid={downPercent.trim() !== '' && parseMoney(downPercent) === null}
                            onChange={(e) => setDownPercent(e.target.value)}
                        />
                        <span aria-hidden="true">%</span>
                    </div>
                ) : (
                    <>
                        <label className="sr-only" htmlFor={downId}>{t('Down payment amount')}</label>
                        <input
                            id={downId}
                            className="input"
                            type="text"
                            inputMode="decimal"
                            autoComplete="off"
                            value={downAmount}
                            aria-invalid={downAmount.trim() !== '' && parseMoney(downAmount) === null}
                            onChange={(e) => setDownAmount(e.target.value)}
                        />
                    </>
                )}
            </div>

            <div className="grid-2">
                <div className="field">
                    <label className="field__label" htmlFor={rateId}>{t('Interest rate (annual %)')}</label>
                    <input
                        id={rateId}
                        className="input"
                        type="text"
                        inputMode="decimal"
                        autoComplete="off"
                        value={rate}
                        aria-invalid={rate.trim() !== '' && rateValue === null}
                        onChange={(e) => setRate(e.target.value)}
                    />
                </div>
                <div className="field">
                    <label className="field__label" htmlFor={extraId}>{t('Extra monthly payment (optional)')}</label>
                    <input
                        id={extraId}
                        className="input"
                        type="text"
                        inputMode="decimal"
                        autoComplete="off"
                        value={extra}
                        aria-invalid={extraInvalid}
                        onChange={(e) => setExtra(e.target.value)}
                    />
                </div>
            </div>

            <div className="field">
                <span className="field__label" id={`${termId}-label`}>{t('Loan term')}</span>
                <div className="row" role="group" aria-label={t('Loan term')}>
                    {termPresets.map((preset) => (
                        <button
                            key={preset}
                            type="button"
                            className={`btn${termValue === preset ? ' is-active' : ''}`}
                            aria-pressed={termValue === preset}
                            onClick={() => setTerm(String(preset))}
                        >
                            {tn('{count} year', '{count} years', preset)}
                        </button>
                    ))}
                    <label className="sr-only" htmlFor={termId}>{t('Custom loan term (years)')}</label>
                    <input
                        id={termId}
                        className="input"
                        style={{ maxWidth: '6rem' }}
                        type="text"
                        inputMode="numeric"
                        autoComplete="off"
                        value={term}
                        aria-invalid={termInvalid}
                        aria-describedby={`${termId}-label`}
                        onChange={(e) => setTerm(e.target.value)}
                    />
                </div>
            </div>

            <Notice type="error">{error}</Notice>
            {!result && !error && <Notice type="info">{t('Enter a home price, down payment, interest rate and loan term to see the monthly payment.')}</Notice>}

            {result && !result.error && (
                <div className="stack" aria-live="polite">
                    <div className="stats">
                        <Stat value={money(result.monthlyPayment)} label={t('Monthly payment (principal & interest)')} />
                        <Stat value={money(result.loanAmount)} label={t('Loan amount')} />
                        <Stat value={money(result.totalInterest)} label={t('Total interest')} />
                        <Stat value={money(result.totalCost)} label={t('Total cost (price + interest)')} />
                    </div>
                    <p className="field__hint">{t('Paid off in {time}.', { time: payoffText(result.months) })}</p>

                    {extraValue > 0 && result.monthsSaved > 0 && (
                        <p className="notice notice--success">
                            {t('Paying {extra} extra each month pays off the loan {time} sooner and saves {saved} in interest.', {
                                extra: money(extraValue),
                                time: payoffText(result.monthsSaved),
                                saved: money(result.interestSaved),
                            })}
                        </p>
                    )}

                    <Notice type="info">{t('This covers principal and interest only. It does not include property tax, homeowners insurance, mortgage insurance (PMI) or HOA fees, which vary by location and lender.')}</Notice>

                    <details open={showTable} onToggle={(e) => setShowTable(e.target.open)}>
                        <summary style={{ cursor: 'pointer', fontWeight: 600 }}>{t('Show the year-by-year amortization schedule')}</summary>
                        <div className="table-wrap">
                            <table className="compare-table" data-testid="mortgage-table">
                                <caption className="sr-only">{t('Amortization schedule')}</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">{t('Year')}</th>
                                        <th scope="col">{t('Principal paid')}</th>
                                        <th scope="col">{t('Interest paid')}</th>
                                        <th scope="col">{t('Remaining balance')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {result.yearly.map((row) => (
                                        <tr key={row.year}>
                                            <th scope="row">{row.year}</th>
                                            <td className="tabular-nums">{money(row.principal)}</td>
                                            <td className="tabular-nums">{money(row.interest)}</td>
                                            <td className="tabular-nums">{money(row.balance)}</td>
                                        </tr>
                                    ))}
                                </tbody>
                            </table>
                        </div>
                    </details>
                </div>
            )}
        </div>
    );
}
