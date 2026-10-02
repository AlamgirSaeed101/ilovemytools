// The visitor's country, guessed from browser settings (no IP lookup, nothing sent anywhere),
// used for sensible regional defaults such as Letter vs A4 paper and local tipping habits.

/** "en-US" -> "US"; checks every preferred language, then the time zone. Null when unknown. */
export function visitorRegion(languages = typeof navigator !== 'undefined' ? navigator.languages || [navigator.language] : [], timeZone = guessTimeZone()) {
    for (const tag of languages) {
        const m = /^[a-z]{2,3}(?:-[A-Za-z]{4})?-([A-Z]{2})\b/.exec(String(tag || ''));
        if (m) return m[1];
    }
    if (/^America\/(Toronto|Vancouver|Edmonton|Winnipeg|Halifax|Regina|St_Johns)/.test(timeZone)) return 'CA';
    if (/^America\/(New_York|Chicago|Denver|Los_Angeles|Phoenix|Anchorage|Detroit|Indiana|Boise)/.test(timeZone) || timeZone === 'Pacific/Honolulu') return 'US';
    return null;
}

function guessTimeZone() {
    try {
        return Intl.DateTimeFormat().resolvedOptions().timeZone || '';
    } catch {
        return '';
    }
}

/** Countries where US Letter paper is the norm. */
const LETTER = new Set(['US', 'CA', 'MX', 'PH', 'CL', 'CO', 'VE', 'CR', 'GT', 'DO', 'PR', 'PA', 'SV', 'NI', 'HN', 'BZ']);

export function defaultPaper(region = visitorRegion()) {
    return LETTER.has(region) ? 'letter' : 'a4';
}

/** Usual tip percentages: North America tips more than the UK/Australia, and Europe less. */
export function tipPresets(region = visitorRegion()) {
    if (['US', 'CA', 'MX'].includes(region)) return [15, 18, 20, 25];
    if (['GB', 'IE', 'AU', 'NZ'].includes(region)) return [10, 12.5, 15, 20];
    if (region && /^(AT|BE|CH|DE|DK|ES|FI|FR|GR|IT|LU|NL|NO|PL|PT|SE|CZ|HU|RO)$/.test(region)) return [5, 10, 15, 20];
    return [10, 15, 18, 20];
}
