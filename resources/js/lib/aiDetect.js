// AI writing signals for English text. This is a statistical guide, not proof:
// no detector can tell for certain whether a text was written by AI.
import { sentencesOf, wordsOf } from './readability.js';

/** Phrases that AI chat models use far more often than people do. */
export const AI_PHRASES = [
    'delve', 'delves', 'delving', 'tapestry', 'testament to', 'in today\'s fast-paced', 'in today’s fast-paced',
    'it is important to note', 'it\'s important to note', 'it’s important to note', 'it is worth noting',
    'in the realm of', 'navigate the complexities', 'navigating the complexities', 'plays a crucial role',
    'plays a pivotal role', 'a pivotal role', 'unlock the potential', 'unleash', 'embark on', 'elevate your',
    'seamlessly', 'seamless', 'robust', 'leverage', 'leveraging', 'harness the power', 'ever-evolving',
    'ever-changing landscape', 'in conclusion', 'furthermore', 'moreover', 'additionally', 'overall,',
    'comprehensive guide', 'whether you\'re', 'whether you’re', 'look no further', 'game-changer', 'game changer',
    'cutting-edge', 'dive into', 'dive deep', 'a myriad of', 'myriad', 'foster', 'fostering', 'holistic',
    'paramount', 'meticulous', 'meticulously', 'intricate', 'nuanced', 'resonate', 'underscores', 'showcasing',
    'crucial', 'vital', 'landscape', 'realm', 'journey', 'streamline', 'empower', 'bustling', 'vibrant',
];

const CONTRACTION_RE = /\b\w+['’](?:t|s|re|ve|ll|d|m)\b/gi;

function mean(xs) {
    return xs.reduce((a, b) => a + b, 0) / xs.length;
}

function stdev(xs) {
    const m = mean(xs);
    return Math.sqrt(mean(xs.map((x) => (x - m) ** 2)));
}

/** Moving-average type-token ratio over 50-word windows (stable across text lengths). */
export function lexicalDiversity(words, window = 50) {
    const w = words.map((x) => x.toLowerCase());
    if (w.length <= window) return new Set(w).size / Math.max(1, w.length);
    let total = 0;
    let n = 0;
    for (let i = 0; i + window <= w.length; i += 10) {
        total += new Set(w.slice(i, i + window)).size / window;
        n++;
    }
    return total / n;
}

const clamp01 = (x) => Math.max(0, Math.min(1, x));

export const MIN_WORDS = 80;

/**
 * Score 0-100 (higher = more AI-like) from four signals:
 * uniform sentence lengths, AI-typical phrases, few contractions, and repetitive vocabulary.
 */
export function analyzeAiText(text) {
    const words = wordsOf(text);
    const sentences = sentencesOf(text);
    if (words.length < MIN_WORDS || sentences.length < 3) return { tooShort: true, words: words.length };

    const lower = ` ${String(text).toLowerCase().replace(/\s+/g, ' ')} `;
    const lengths = sentences.map((s) => wordsOf(s).length);
    const burstiness = stdev(lengths) / mean(lengths); // people vary sentence length more

    const found = new Map();
    for (const p of AI_PHRASES) {
        const re = new RegExp(`(?<![a-z])${p.replace(/[.*+?^${}()|[\]\\]/g, '\\$&')}(?![a-z])`, 'g');
        const count = (lower.match(re) || []).length;
        if (count) found.set(p.replace(/’/g, "'"), (found.get(p.replace(/’/g, "'")) || 0) + count);
    }
    const phraseHits = [...found.values()].reduce((a, b) => a + b, 0);
    const phrasesPer100 = (phraseHits / words.length) * 100;
    const contractionsPer100 = ((String(text).match(CONTRACTION_RE) || []).length / words.length) * 100;
    const diversity = lexicalDiversity(words);

    const signals = {
        uniformity: clamp01((0.6 - burstiness) / 0.35), // CV 0.25 or less -> 1, 0.6 or more -> 0
        phrases: clamp01(phrasesPer100 / 1.5), // 1.5 AI phrases per 100 words -> 1
        formality: clamp01((1.2 - contractionsPer100) / 1.2), // no contractions -> 1
        repetition: clamp01((0.78 - diversity) / 0.13), // MATTR 0.65 or less -> 1
    };
    const score = Math.round(100 * (0.35 * signals.uniformity + 0.35 * signals.phrases + 0.15 * signals.formality + 0.15 * signals.repetition));

    const flagged = sentences
        .map((s) => ({ text: s, phrases: [...found.keys()].filter((p) => s.toLowerCase().replace(/’/g, "'").includes(p.replace(/,$/, ''))) }))
        .filter((s) => s.phrases.length > 0)
        .slice(0, 8);

    return {
        tooShort: false,
        words: words.length,
        sentences: sentences.length,
        score,
        verdict: score >= 65 ? 'likely-ai' : score >= 40 ? 'mixed' : 'likely-human',
        signals: Object.fromEntries(Object.entries(signals).map(([k, v]) => [k, Math.round(v * 100)])),
        burstiness: Math.round(burstiness * 100) / 100,
        phrases: [...found.entries()].sort((a, b) => b[1] - a[1]).map(([phrase, count]) => ({ phrase, count })),
        flagged,
    };
}
