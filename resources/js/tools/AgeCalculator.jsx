import { useMemo, useState } from 'react';
import { Notice, Stat } from '../components/ui.jsx';
import { calculateAge, parseDateInput, todayParts, toInputValue } from '../lib/date.js';
import { formatNumber, numberLocale, t, tn } from '../lib/i18n.js';

// Dates and weekday names in the page's language.
const utc = (d) => {
    const date = new Date(Date.UTC(2000, d.m - 1, d.d));
    date.setUTCFullYear(d.y);
    return date;
};
const pretty = (d) => new Intl.DateTimeFormat(numberLocale(), { day: 'numeric', month: 'long', year: 'numeric', timeZone: 'UTC' }).format(utc(d));
const weekdayName = (d) => new Intl.DateTimeFormat(numberLocale(), { weekday: 'long', timeZone: 'UTC' }).format(utc(d));
const years = (n) => tn('{count} year', '{count} years', n);
const months = (n) => tn('{count} month', '{count} months', n);
const days = (n) => tn('{count} day', '{count} days', n);

export default function AgeCalculator() {
    const today = toInputValue(todayParts());
    const [dob, setDob] = useState('');
    const [at, setAt] = useState(today);

    const birthDate = parseDateInput(dob);
    const { result, error } = useMemo(() => {
        if (!dob) return { result: null, error: '' };
        const birth = parseDateInput(dob);
        const target = parseDateInput(at || today);
        if (!birth) return { result: null, error: t('Please enter a valid date of birth.') };
        if (!target) return { result: null, error: t('Please enter a valid "age at" date.') };
        if (birth.y < 1000) return { result: null, error: t('Please enter a 4-digit year.') };
        try {
            return { result: calculateAge(birth, target), error: '' };
        } catch (e) {
            return { result: null, error: e.message };
        }
    }, [dob, at, today]);

    return (
        <div className="stack">
            <div className="grid-2">
                <div className="field">
                    <label className="field__label" htmlFor="age-dob">{t('Date of birth')}</label>
                    <input id="age-dob" className="input" type="date" value={dob} max={at || today} onChange={(e) => setDob(e.target.value)} />
                </div>
                <div className="field">
                    <label className="field__label" htmlFor="age-at">{t('Age at the date of')}</label>
                    <input id="age-at" className="input" type="date" value={at} onChange={(e) => setAt(e.target.value)} />
                </div>
            </div>

            <Notice type="error">{error}</Notice>

            {!result && !error && <Notice type="info">{t('Enter a date of birth to see the exact age.')}</Notice>}

            {result && (
                <div className="stack" aria-live="polite">
                    <div className="result">
                        <div className="result__value">
                            {t('{years}, {months}, {days}', { years: years(result.years), months: months(result.months), days: days(result.days) })}
                        </div>
                        <div className="field__hint">{t('Born on a {weekday}', { weekday: weekdayName(birthDate) })}</div>
                    </div>

                    <div className="stats">
                        <Stat value={formatNumber(result.totalMonths)} label={t('Total months')} />
                        <Stat value={formatNumber(result.totalWeeks)} label={result.remainingWeekDays ? t('Weeks (+{days})', { days: days(result.remainingWeekDays) }) : t('Weeks')} />
                        <Stat value={formatNumber(result.totalDays)} label={t('Total days')} />
                        <Stat value={formatNumber(result.totalHours)} label={t('Total hours (approx.)')} />
                    </div>

                    <p className="notice notice--success">
                        {result.daysToBirthday === 0
                            ? `🎉 ${t('Happy birthday! Turning {age} today.', { age: formatNumber(result.turningAge) })}`
                            : t('Next birthday: {weekday}, {date} - in {days} (turning {age}).', {
                                  weekday: weekdayName(result.nextBirthday),
                                  date: pretty(result.nextBirthday),
                                  days: days(result.daysToBirthday),
                                  age: formatNumber(result.turningAge),
                              })}
                    </p>
                </div>
            )}
        </div>
    );
}
