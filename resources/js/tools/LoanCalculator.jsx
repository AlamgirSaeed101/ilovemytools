import { useId, useMemo, useState } from 'react';
import { Notice, Stat } from '../components/ui.jsx';
import { defaultCurrency } from '../lib/region.js';
import { calcLoan, parseMoney, parsePercent, parseTermYears, TERM_PRESETS } from '../lib/loan.js';
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

export default function LoanCalculator() {
    const [amount, setAmount] = useState('20000');
    const [rate, setRate] = useState('7');
    const [term, setTerm] = useState('5');
    const [extra, setExtra] = useState('0');
    const [currency, setCurrency] = useState(() => defaultCurrency());
    const [showTable, setShowTable] = useState(false);

    const amountId = useId();
    const rateId = useId();
    const termId = useId();
    const extraId = useId();
    const currencyId = useId();

    const amountValue = parseMoney(amount);
    const rateValue = parsePercent(rate);
    const termValue = parseTermYears(term);
    const extraValue = parseMoney(extra || '0');

    const termInvalid = term.trim() !== '' && Number.isNaN(termValue);
    const extraInvalid = extra.trim() !== '' && extraValue === null;

    const result = useMemo(() => {
        if (termInvalid || extraInvalid || Number.isNaN(termValue) || extraValue === null) return null;
        return calcLoan({
            loanAmount: amountValue,
            annualRatePercent: rateValue,
            termYears: termValue,
            extraMonthly: extraValue,
        });
    }, [amountValue, rateValue, termValue, extraValue, termInvalid, extraInvalid]);

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
                    <label className="field__label" htmlFor={amountId}>{t('Loan amount')}</label>
                    <input
                        id={amountId}
                        className="input"
                        type="text"
                        inputMode="decimal"
                        autoComplete="off"
                        value={amount}
                        aria-invalid={amount.trim() !== '' && amountValue === null}
                        onChange={(e) => setAmount(e.target.value)}
                    />
                </div>
                <div className="field">
                    <label className="field__label" htmlFor={currencyId}>{t('Currency')}</label>
                    <select id={currencyId} className="select" value={currency} onChange={(e) => setCurrency(e.target.value)}>
                        {CURRENCIES.map((c) => <option key={c} value={c}>{c}</option>)}
                    </select>
                </div>
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
                    {TERM_PRESETS.map((preset) => (
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
            {!result && !error && <Notice type="info">{t('Enter a loan amount, interest rate and loan term to see the monthly payment.')}</Notice>}

            {result && !result.error && (
                <div className="stack" aria-live="polite">
                    <div className="stats">
                        <Stat value={money(result.monthlyPayment)} label={t('Monthly payment')} />
                        <Stat value={money(result.totalInterest)} label={t('Total interest')} />
                        <Stat value={money(result.totalPaid)} label={t('Total repayment (loan + interest)')} />
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

                    <Notice type="info">{t('This shows the loan repayment with interest only. It does not include lender fees, origination charges or insurance, which vary by lender.')}</Notice>

                    <details open={showTable} onToggle={(e) => setShowTable(e.target.open)}>
                        <summary style={{ cursor: 'pointer', fontWeight: 600 }}>{t('Show the year-by-year amortization schedule')}</summary>
                        <div className="table-wrap">
                            <table className="compare-table" data-testid="loan-table">
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
