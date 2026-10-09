import { t } from './i18n.js';
import { amortizationSchedule, monthlyPayment, parseTermYears } from './mortgage.js';
import { parseLocaleNumber } from './numbers.js';

export const TERM_PRESETS = [2, 3, 5, 7, 10];

export { amortizationSchedule, monthlyPayment, parseTermYears };

/** A money amount typed in the page's own number style (loan amount, extra payment). */
export function parseMoney(input) {
    return parseLocaleNumber(String(input ?? '').trim());
}

/** An interest rate typed in the page's own number style. */
export function parsePercent(input) {
    return parseLocaleNumber(String(input ?? '').trim());
}

/**
 * Validates the inputs and returns the full breakdown for the Loan Calculator tool, or
 * `{ error }` with a friendly, translated message.
 */
export function calcLoan({ loanAmount, annualRatePercent, termYears, extraMonthly = 0 }) {
    if (loanAmount === null || annualRatePercent === null) return null;
    if (!(loanAmount > 0)) return { error: t('Enter a loan amount greater than 0.') };
    if (annualRatePercent < 0 || annualRatePercent > 100) return { error: t('Enter an interest rate between 0% and 100%.') };
    if (!Number.isInteger(termYears) || termYears < 1 || termYears > 50) return { error: t('Enter a loan term between 1 and 50 years.') };
    if (!(extraMonthly >= 0)) return { error: t('Enter an extra payment of 0 or more.') };

    const schedule = amortizationSchedule(loanAmount, annualRatePercent, termYears, extraMonthly);
    const baseline = extraMonthly > 0 ? amortizationSchedule(loanAmount, annualRatePercent, termYears, 0) : schedule;

    return {
        loanAmount,
        monthlyPayment: schedule.payment,
        totalMonthlyPayment: schedule.payment + extraMonthly,
        months: schedule.months,
        totalInterest: schedule.totalInterest,
        totalPaid: schedule.totalPaid,
        yearly: schedule.yearly,
        baselineMonths: baseline.months,
        baselineInterest: baseline.totalInterest,
        monthsSaved: extraMonthly > 0 ? baseline.months - schedule.months : 0,
        interestSaved: extraMonthly > 0 ? baseline.totalInterest - schedule.totalInterest : 0,
    };
}
