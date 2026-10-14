import { useId, useMemo, useState } from 'react';
import { Notice, Stat } from '../components/ui.jsx';
import { defaultCurrency } from '../lib/region.js';
import { calcCompoundInterest, COMPOUNDING_OPTIONS, parseAmount, parsePercent, parseYears } from '../lib/compoundInterest.js';
import { formatNumber, t } from '../lib/i18n.js';

const CURRENCIES = ['$', '£', '€', 'C$', 'A$'];

function compoundingLabel(n) {
    if (n === 1) return t('Annually');
    if (n === 2) return t('Semi-annually');
    if (n === 4) return t('Quarterly');
    if (n === 12) return t('Monthly');
    return t('Daily');
}

/** A dependency-free line chart: starting amount + contributions in one colour, growth from interest stacked on top. */
function GrowthChart({ yearly, startingAmount, money }) {
    const width = 600;
    const height = 220;
    const padding = { top: 10, right: 10, bottom: 24, left: 10 };
    const maxBalance = Math.max(...yearly.map((row) => row.balance), startingAmount, 1);
    const points = yearly.map((row) => ({
        x: padding.left + (row.year / yearly.length) * (width - padding.left - padding.right),
        yBalance: height - padding.bottom - (row.balance / maxBalance) * (height - padding.top - padding.bottom),
        yContributed: height - padding.bottom - ((startingAmount + row.contributed) / maxBalance) * (height - padding.top - padding.bottom),
    }));
    const start = { x: padding.left, yBalance: height - padding.bottom - (startingAmount / maxBalance) * (height - padding.top - padding.bottom), yContributed: height - padding.bottom - (startingAmount / maxBalance) * (height - padding.top - padding.bottom) };
    const all = [start, ...points];

    const balancePath = all.map((p, i) => `${i === 0 ? 'M' : 'L'}${p.x.toFixed(1)},${p.yBalance.toFixed(1)}`).join(' ');
    const contributedPath = all.map((p, i) => `${i === 0 ? 'M' : 'L'}${p.x.toFixed(1)},${p.yContributed.toFixed(1)}`).join(' ');
    const base = height - padding.bottom;
    const balanceArea = `${balancePath} L${all[all.length - 1].x.toFixed(1)},${base} L${all[0].x.toFixed(1)},${base} Z`;
    const contributedArea = `${contributedPath} L${all[all.length - 1].x.toFixed(1)},${base} L${all[0].x.toFixed(1)},${base} Z`;

    const last = yearly[yearly.length - 1];

    return (
        <svg viewBox={`0 0 ${width} ${height}`} role="img" aria-label={t('Chart of balance growth from {start} to {end} over {years} years.', { start: money(startingAmount), end: money(last.balance), years: String(yearly.length) })} className="chart">
            <path d={balanceArea} fill="var(--chart-interest, #93c5fd)" />
            <path d={contributedArea} fill="var(--chart-principal, #3b82f6)" />
            <path d={balancePath} fill="none" stroke="var(--chart-interest-line, #2563eb)" strokeWidth="2" />
        </svg>
    );
}

export default function CompoundInterestCalculator() {
    const [principal, setPrincipal] = useState('10000');
    const [rate, setRate] = useState('6');
    const [years, setYears] = useState('20');
    const [compounding, setCompounding] = useState('12');
    const [contribution, setContribution] = useState('200');
    const [currency, setCurrency] = useState(() => defaultCurrency());
    const [showTable, setShowTable] = useState(false);

    const principalId = useId();
    const rateId = useId();
    const yearsId = useId();
    const compoundingId = useId();
    const contributionId = useId();
    const currencyId = useId();

    const principalValue = parseAmount(principal);
    const rateValue = parsePercent(rate);
    const yearsValue = parseYears(years);
    const contributionValue = parseAmount(contribution || '0');
    const compoundingValue = Number(compounding);

    const yearsInvalid = years.trim() !== '' && Number.isNaN(yearsValue);
    const contributionInvalid = contribution.trim() !== '' && contributionValue === null;

    const result = useMemo(() => {
        if (yearsInvalid || contributionInvalid || Number.isNaN(yearsValue) || contributionValue === null) return null;
        return calcCompoundInterest({
            principal: principalValue,
            annualRatePercent: rateValue,
            years: yearsValue,
            compoundingPerYear: compoundingValue,
            monthlyContribution: contributionValue,
        });
    }, [principalValue, rateValue, yearsValue, compoundingValue, contributionValue, yearsInvalid, contributionInvalid]);

    const error =
        result?.error ||
        (yearsInvalid ? t('Enter a number of years between 1 and 50.') : '') ||
        (contributionInvalid ? t('Enter a monthly contribution of 0 or more.') : '');

    function money(n) {
        return `${currency}${formatNumber(n, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
    }

    return (
        <div className="stack">
            <div className="grid-2">
                <div className="field">
                    <label className="field__label" htmlFor={principalId}>{t('Starting amount')}</label>
                    <input
                        id={principalId}
                        className="input"
                        type="text"
                        inputMode="decimal"
                        autoComplete="off"
                        value={principal}
                        aria-invalid={principal.trim() !== '' && principalValue === null}
                        onChange={(e) => setPrincipal(e.target.value)}
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
                    <label className="field__label" htmlFor={yearsId}>{t('Number of years')}</label>
                    <input
                        id={yearsId}
                        className="input"
                        type="text"
                        inputMode="numeric"
                        autoComplete="off"
                        value={years}
                        aria-invalid={yearsInvalid}
                        onChange={(e) => setYears(e.target.value)}
                    />
                </div>
            </div>

            <div className="grid-2">
                <div className="field">
                    <label className="field__label" htmlFor={contributionId}>{t('Monthly contribution (optional)')}</label>
                    <input
                        id={contributionId}
                        className="input"
                        type="text"
                        inputMode="decimal"
                        autoComplete="off"
                        value={contribution}
                        aria-invalid={contributionInvalid}
                        onChange={(e) => setContribution(e.target.value)}
                    />
                </div>
                <div className="field">
                    <label className="field__label" htmlFor={compoundingId}>{t('Compound frequency')}</label>
                    <select id={compoundingId} className="select" value={compounding} onChange={(e) => setCompounding(e.target.value)}>
                        {COMPOUNDING_OPTIONS.map((n) => <option key={n} value={n}>{compoundingLabel(n)}</option>)}
                    </select>
                </div>
            </div>

            <Notice type="error">{error}</Notice>
            {!result && !error && <Notice type="info">{t('Enter a starting amount, interest rate and number of years to see how your money grows.')}</Notice>}

            {result && !result.error && (
                <div className="stack" aria-live="polite">
                    <div className="stats">
                        <Stat value={money(result.finalBalance)} label={t('Final balance')} />
                        <Stat value={money(result.totalContributed)} label={t('Total contributed')} />
                        <Stat value={money(result.totalInterest)} label={t('Total interest earned')} />
                    </div>

                    <GrowthChart yearly={result.yearly} startingAmount={result.startingAmount} money={money} />

                    <Notice type="info">{t('This is a projection based on a fixed interest rate. Real investment returns vary year to year and are not guaranteed.')}</Notice>

                    <details open={showTable} onToggle={(e) => setShowTable(e.target.open)}>
                        <summary style={{ cursor: 'pointer', fontWeight: 600 }}>{t('Show the year-by-year balance')}</summary>
                        <div className="table-wrap">
                            <table className="compare-table" data-testid="compound-interest-table">
                                <caption className="sr-only">{t('Year-by-year balance')}</caption>
                                <thead>
                                    <tr>
                                        <th scope="col">{t('Year')}</th>
                                        <th scope="col">{t('Balance')}</th>
                                        <th scope="col">{t('Total contributed')}</th>
                                        <th scope="col">{t('Interest earned')}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {result.yearly.map((row) => (
                                        <tr key={row.year}>
                                            <th scope="row">{row.year}</th>
                                            <td className="tabular-nums">{money(row.balance)}</td>
                                            <td className="tabular-nums">{money(result.startingAmount + row.contributed)}</td>
                                            <td className="tabular-nums">{money(row.interest)}</td>
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
