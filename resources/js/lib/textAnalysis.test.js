import { describe, expect, it } from 'vitest';
import { analyzeReadability, easeLevel, sentencesOf, syllables } from './readability.js';
import { analyzeAiText, lexicalDiversity } from './aiDetect.js';

describe('readability', () => {
    it('counts syllables', () => {
        expect(syllables('cat')).toBe(1);
        expect(syllables('water')).toBe(2);
        expect(syllables('beautiful')).toBe(3);
        expect(syllables('readability')).toBeGreaterThanOrEqual(4);
        expect(syllables('make')).toBe(1);
    });

    it('splits sentences and ignores abbreviations and decimals', () => {
        expect(sentencesOf('Dr. Smith paid 3.5 dollars. Then he left! Why?')).toHaveLength(3);
        expect(sentencesOf('')).toEqual([]);
    });

    it('rates simple text as easy and dense text as hard', () => {
        const easy = analyzeReadability('The cat sat on the mat. The dog ran to the park. We had fun in the sun.');
        const hard = analyzeReadability(
            'Notwithstanding considerable institutional heterogeneity, comprehensive organizational transformation necessitates multidimensional evaluation of interdependent administrative responsibilities.',
        );
        expect(easy.fleschEase).toBeGreaterThan(90);
        expect(easy.fleschKincaid).toBeLessThan(3);
        expect(hard.fleschEase).toBeLessThan(10);
        expect(hard.averageGrade).toBeGreaterThan(15);
        expect(easy.sentences).toBe(3);
        expect(easy.words).toBe(18);
    });

    it('lists long sentences and returns null for empty text', () => {
        const long = `${'word '.repeat(30)}end. Short one.`;
        expect(analyzeReadability(long).longSentences).toHaveLength(1);
        expect(analyzeReadability('   ')).toBeNull();
    });

    it('maps scores to levels', () => {
        expect(easeLevel(95)).toBe('Very easy');
        expect(easeLevel(65)).toBe('Plain English');
        expect(easeLevel(10)).toBe('Very difficult');
    });
});

const AI_SAMPLE = `In today's fast-paced digital landscape, it is important to note that effective communication plays a crucial role in organizational success. Furthermore, businesses must leverage robust strategies to navigate the complexities of an ever-evolving market. Moreover, fostering a holistic approach enables teams to unlock the potential of their workforce. Additionally, organizations that embrace innovation can seamlessly streamline their operations. In conclusion, a comprehensive strategy is a testament to the paramount importance of meticulous planning. Overall, companies that delve into these practices will empower their employees and elevate their performance in a vibrant and dynamic realm.`;

const HUMAN_SAMPLE = `I didn't plan to buy a bike. Honestly, I just walked past the shop on Saturday because the bakery next door was out of bread, and there it was: a green one, a bit rusty, forty quid. The guy said it'd been sitting there since spring. I rode it home in the rain. Got soaked. My neighbour laughed at me, which, fair enough. Anyway, it's been three weeks now and I've ridden it to work almost every day. Turns out the hill on Mill Lane is brutal! But I'm getting faster, and I don't miss the bus at all. Not even a little.`;

describe('AI text signals', () => {
    it('needs enough text', () => {
        expect(analyzeAiText('Too short.').tooShort).toBe(true);
    });

    it('scores typical AI prose higher than casual human writing', () => {
        const ai = analyzeAiText(AI_SAMPLE);
        const human = analyzeAiText(HUMAN_SAMPLE);
        expect(ai.score).toBeGreaterThan(human.score + 25);
        expect(ai.verdict).toBe('likely-ai');
        expect(human.verdict).toBe('likely-human');
        expect(ai.phrases.map((p) => p.phrase)).toEqual(expect.arrayContaining(['furthermore', 'moreover', 'leverage']));
        expect(ai.flagged.length).toBeGreaterThan(0);
    });

    it('measures vocabulary variety', () => {
        expect(lexicalDiversity('a a a a'.split(' '))).toBe(0.25);
        expect(lexicalDiversity('one two three four'.split(' '))).toBe(1);
    });
});
