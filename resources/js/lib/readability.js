// Readability formulas (designed for English text).
// Flesch Reading Ease, Flesch-Kincaid Grade, Gunning Fog, SMOG, Coleman-Liau and ARI.

const WORD_RE = /[A-Za-zÀ-ÖØ-öø-ÿ]+(?:['’][A-Za-zÀ-ÖØ-öø-ÿ]+)*/g;

/** Split text into sentences (ends with . ! ? or a line break; ignores common abbreviations). */
export function sentencesOf(text) {
    const cleaned = String(text || '')
        .replace(/\b(Mr|Mrs|Ms|Dr|Prof|Sr|Jr|St|vs|etc|e\.g|i\.e)\./gi, '$1')
        .replace(/(\d)\.(\d)/g, '$1,$2');
    return cleaned
        .split(/(?<=[.!?…])\s+|\n+/)
        .map((s) => s.trim())
        .filter((s) => (s.match(WORD_RE) || []).length > 0);
}

export function wordsOf(text) {
    return String(text || '').match(WORD_RE) || [];
}

/** Syllables in an English word (heuristic, within ±1 for most words). */
export function syllables(word) {
    let w = word.toLowerCase().replace(/[^a-z]/g, '');
    if (!w) return 0;
    if (w.length <= 3) return 1;
    w = w.replace(/(?:[^laeiouy]es|[^laeiouy]ed|[^laeiouy]e)$/, '').replace(/^y/, '');
    const groups = w.match(/[aeiouy]+/g);
    return Math.max(1, groups ? groups.length : 1);
}

const round1 = (n) => Math.round(n * 10) / 10;

/** Plain-English level for a Flesch Reading Ease score. */
export function easeLevel(score) {
    if (score >= 90) return 'Very easy';
    if (score >= 80) return 'Easy';
    if (score >= 70) return 'Fairly easy';
    if (score >= 60) return 'Plain English';
    if (score >= 50) return 'Fairly difficult';
    if (score >= 30) return 'Difficult';
    return 'Very difficult';
}

/** Every score plus counts; null when there is no text. */
export function analyzeReadability(text, { longSentence = 25 } = {}) {
    const words = wordsOf(text);
    const sentences = sentencesOf(text);
    if (words.length === 0 || sentences.length === 0) return null;

    const W = words.length;
    const S = sentences.length;
    const syl = words.map(syllables);
    const totalSyl = syl.reduce((a, b) => a + b, 0);
    const complex = syl.filter((n) => n >= 3).length;
    const letters = words.reduce((a, w) => a + w.replace(/['’]/g, '').length, 0);

    const wps = W / S;
    const spw = totalSyl / W;
    const fleschEase = 206.835 - 1.015 * wps - 84.6 * spw;
    const fleschKincaid = 0.39 * wps + 11.8 * spw - 15.59;
    const gunningFog = 0.4 * (wps + 100 * (complex / W));
    const smog = 1.043 * Math.sqrt(complex * (30 / S)) + 3.1291;
    const colemanLiau = 0.0588 * ((letters / W) * 100) - 0.296 * ((S / W) * 100) - 15.8;
    const ari = 4.71 * (letters / W) + 0.5 * wps - 21.43;
    const grades = [fleschKincaid, gunningFog, smog, colemanLiau, ari];
    const averageGrade = grades.reduce((a, b) => a + b, 0) / grades.length;

    const long = sentences
        .map((s) => ({ text: s, words: wordsOf(s).length }))
        .filter((s) => s.words > longSentence)
        .sort((a, b) => b.words - a.words);

    return {
        words: W,
        sentences: S,
        syllables: totalSyl,
        complexWords: complex,
        wordsPerSentence: round1(wps),
        syllablesPerWord: round1(spw * 10) / 10,
        fleschEase: round1(Math.max(0, Math.min(121, fleschEase))),
        fleschKincaid: round1(Math.max(0, fleschKincaid)),
        gunningFog: round1(gunningFog),
        smog: round1(smog),
        colemanLiau: round1(Math.max(0, colemanLiau)),
        ari: round1(Math.max(0, ari)),
        averageGrade: round1(Math.max(0, averageGrade)),
        level: easeLevel(fleschEase),
        readingMinutes: Math.max(1, Math.round(W / 238)),
        longSentences: long,
    };
}
