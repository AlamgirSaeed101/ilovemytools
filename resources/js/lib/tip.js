import { formatNumber as formatLocal, t } from './i18n.js';
import { parseLocaleInteger, parseLocaleNumber } from './numbers.js';

export const TIP_PRESETS = [15, 18, 20, 25];

/** Bill amount or a custom tip percentage, typed in the page's own number style. */
export function parseAmount(input) {
    return parseLocaleNumber(String(input ?? '').trim());
}

/** Number of people to split between. Returns NaN when it is not a whole number of 1 or more. */
export function parsePeople(input) {
    const n = parseLocaleInteger(String(input ?? '').trim());
    return Number.isInteger(n) && n >= 1 ? n : NaN;
}

function money(n) {
    return formatLocal(n, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
}

/**
 * Split a bill, its tip and the round-up (if any) between `people`.
 * Returns { error } or the full breakdown with formatted strings for display.
 */
export function calcTip({ bill, tipPercent, people, roundUp }) {
    if (bill === null || tipPercent === null) return null;
    if (bill < 0) return { error: t('Enter a bill amount of 0 or more.') };
    if (tipPercent < 0) return { error: t('Enter a tip percentage of 0 or more.') };
    if (!Number.isInteger(people) || people < 1) return { error: t('Enter at least 1 person to split between.') };

    let tipAmount = bill * (tipPercent / 100);
    let totalAmount = bill + tipAmount;
    let totalPerPerson = totalAmount / people;
    let roundedUp = false;

    if (roundUp) {
        const ceilPerPerson = Math.ceil(totalPerPerson - 1e-9);
        if (ceilPerPerson > totalPerPerson + 1e-9) {
            roundedUp = true;
            totalPerPerson = ceilPerPerson;
            totalAmount = totalPerPerson * people;
            tipAmount = totalAmount - bill;
        }
    }

    const tipPerPerson = tipAmount / people;

    return {
        tipAmount,
        totalAmount,
        tipPerPerson,
        totalPerPerson,
        roundedUp,
        tipAmountText: money(tipAmount),
        totalAmountText: money(totalAmount),
        tipPerPersonText: money(tipPerPerson),
        totalPerPersonText: money(totalPerPerson),
        tipFormula: `${money(bill)} × ${formatLocal(tipPercent, { maximumFractionDigits: 2 })}% = ${money(tipAmount)}`,
        splitFormula: people > 1 ? `${money(totalAmount)} ÷ ${formatLocal(people)} = ${money(totalPerPerson)}` : '',
    };
}
