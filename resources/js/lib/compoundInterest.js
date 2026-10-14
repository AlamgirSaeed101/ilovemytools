import { t } from './i18n.js';
import { parseLocaleInteger, parseLocaleNumber } from './numbers.js';

/** Compounding frequencies: periods per year. */
export const COMPOUNDING_OPTIONS = [1, 2, 4, 12, 365];

/** A money amount typed in the page's own number style (starting amount, monthly contribution). */
export function parseAmount(input) {
    return parseLocaleNumber(String(input ?? '').trim());
}

/** An interest rate typed in the page's own number style. */
export function parsePercent(input) {
    return parseLocaleNumber(String(input ?? '').trim());
}

/** Number of years. Returns NaN when it is not a whole number of 1 or more. */
export function parseYears(input) {
    const n = parseLocaleInteger(String(input ?? '').trim());
    return Number.isInteger(n) && n >= 1 ? n : NaN;
}

/** Future value of a lump sum plus a level contribution made at the end of every period. */
function futureValue(periodicRate, periods, principal, contributionPerPeriod) {
    if (periods <= 0) return principal;
    if (periodicRate === 0) return principal + contributionPerPeriod * periods;
    const growth = Math.pow(1 + periodicRate, periods);
    return principal * growth + contributionPerPeriod * ((growth - 1) / periodicRate);
}

/**
 * Validates the inputs and returns the full year-by-year breakdown for the Compound Interest
 * Calculator, or `{ error }` with a friendly, translated message.
 *
 * The monthly contribution is spread evenly across whichever compounding frequency is chosen
 * (e.g. 1/3 of it per period when compounding is quarterly), so the total deposited in a year
 * is always `monthlyContribution * 12` no matter how often interest compounds.
 */
export function calcCompoundInterest({ principal, annualRatePercent, years, compoundingPerYear = 12, monthlyContribution = 0 }) {
    if (principal === null || annualRatePercent === null) return null;
    if (!(principal >= 0)) return { error: t('Enter a starting amount of 0 or more.') };
    if (annualRatePercent < 0 || annualRatePercent > 100) return { error: t('Enter an interest rate between 0% and 100%.') };
    if (!Number.isInteger(years) || years < 1 || years > 50) return { error: t('Enter a number of years between 1 and 50.') };
    if (!(monthlyContribution >= 0)) return { error: t('Enter a monthly contribution of 0 or more.') };
    if (!COMPOUNDING_OPTIONS.includes(compoundingPerYear)) return { error: t('Choose how often interest compounds.') };
    if (principal === 0 && monthlyContribution === 0) return { error: t('Enter a starting amount or a monthly contribution greater than 0.') };

    const periodicRate = annualRatePercent / 100 / compoundingPerYear;
    const contributionPerPeriod = (monthlyContribution * 12) / compoundingPerYear;

    const yearly = [];
    for (let year = 1; year <= years; year++) {
        const periods = compoundingPerYear * year;
        const balance = futureValue(periodicRate, periods, principal, contributionPerPeriod);
        const contributed = monthlyContribution * 12 * year;
        yearly.push({ year, balance, contributed, interest: balance - principal - contributed });
    }

    const last = yearly[yearly.length - 1];
    const totalContributed = monthlyContribution * 12 * years;

    return {
        startingAmount: principal,
        finalBalance: last.balance,
        totalContributed,
        totalInterest: last.balance - principal - totalContributed,
        yearly,
    };
}
