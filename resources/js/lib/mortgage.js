import { t } from './i18n.js';
import { parseLocaleInteger, parseLocaleNumber } from './numbers.js';

export const TERM_PRESETS = [10, 15, 20, 25, 30];

/** A money amount typed in the page's own number style (home price, down payment, extra payment). */
export function parseMoney(input) {
    return parseLocaleNumber(String(input ?? '').trim());
}

/** An interest rate or down-payment percentage typed in the page's own number style. */
export function parsePercent(input) {
    return parseLocaleNumber(String(input ?? '').trim());
}

/** Loan term in whole years. Returns NaN when it is not a whole number of 1 or more. */
export function parseTermYears(input) {
    const n = parseLocaleInteger(String(input ?? '').trim());
    return Number.isInteger(n) && n >= 1 ? n : NaN;
}

/** Fixed monthly principal & interest payment for a loan. Null when the inputs can't produce one. */
export function monthlyPayment(loanAmount, annualRatePercent, termYears) {
    if (!(loanAmount > 0) || !(termYears > 0) || !(annualRatePercent >= 0)) return null;
    const n = Math.round(termYears * 12);
    const r = annualRatePercent / 100 / 12;
    return r === 0 ? loanAmount / n : (loanAmount * r) / (1 - Math.pow(1 + r, -n));
}

/**
 * Full year-by-year amortisation schedule for a fixed-rate loan, optionally paying
 * `extraMonthly` extra principal every month (which pays the loan off sooner and for less
 * total interest, but never changes the required monthly payment itself). Null for an
 * invalid loan.
 */
export function amortizationSchedule(loanAmount, annualRatePercent, termYears, extraMonthly = 0) {
    const payment = monthlyPayment(loanAmount, annualRatePercent, termYears);
    if (payment === null) return null;

    const r = annualRatePercent / 100 / 12;
    const n = Math.round(termYears * 12);
    const totalPayment = payment + Math.max(0, extraMonthly || 0);

    let balance = loanAmount;
    let totalInterest = 0;
    let yearPrincipal = 0;
    let yearInterest = 0;
    const yearly = [];
    let month = 0;

    while (balance > 0.005 && month < n) {
        month++;
        const interest = balance * r;
        let principal = totalPayment - interest;
        if (month >= n || principal > balance) principal = balance;
        if (principal < 0) principal = 0;
        balance = Math.max(0, balance - principal);
        totalInterest += interest;
        yearPrincipal += principal;
        yearInterest += interest;
        if (month % 12 === 0 || balance <= 0.005) {
            yearly.push({ year: Math.ceil(month / 12), principal: yearPrincipal, interest: yearInterest, balance });
            yearPrincipal = 0;
            yearInterest = 0;
        }
    }

    return { payment, months: month, totalInterest, totalPaid: loanAmount + totalInterest, yearly };
}

/**
 * Validates the inputs and returns the full breakdown for the Mortgage Calculator tool, or
 * `{ error }` with a friendly, translated message.
 */
export function calcMortgage({ homePrice, downPayment, downPaymentIsPercent, annualRatePercent, termYears, extraMonthly = 0 }) {
    if (homePrice === null || downPayment === null || annualRatePercent === null) return null;
    if (!(homePrice > 0)) return { error: t('Enter a home price greater than 0.') };
    if (downPayment < 0) return { error: t('Enter a down payment of 0 or more.') };
    if (annualRatePercent < 0 || annualRatePercent > 100) return { error: t('Enter an interest rate between 0% and 100%.') };
    if (!Number.isInteger(termYears) || termYears < 1 || termYears > 50) return { error: t('Enter a loan term between 1 and 50 years.') };
    if (!(extraMonthly >= 0)) return { error: t('Enter an extra payment of 0 or more.') };

    const downPaymentAmount = downPaymentIsPercent ? (homePrice * downPayment) / 100 : downPayment;
    const downPaymentPercent = (downPaymentAmount / homePrice) * 100;
    const loanAmount = homePrice - downPaymentAmount;

    if (loanAmount <= 0) return { error: t('Your down payment covers the full home price, so no loan is needed.') };

    const schedule = amortizationSchedule(loanAmount, annualRatePercent, termYears, extraMonthly);
    const baseline = extraMonthly > 0 ? amortizationSchedule(loanAmount, annualRatePercent, termYears, 0) : schedule;

    return {
        loanAmount,
        downPaymentAmount,
        downPaymentPercent,
        monthlyPayment: schedule.payment,
        totalMonthlyPayment: schedule.payment + extraMonthly,
        months: schedule.months,
        totalInterest: schedule.totalInterest,
        totalPaid: schedule.totalPaid,
        totalCost: homePrice + schedule.totalInterest,
        yearly: schedule.yearly,
        baselineMonths: baseline.months,
        baselineInterest: baseline.totalInterest,
        monthsSaved: extraMonthly > 0 ? baseline.months - schedule.months : 0,
        interestSaved: extraMonthly > 0 ? baseline.totalInterest - schedule.totalInterest : 0,
    };
}
