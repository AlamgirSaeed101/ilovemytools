import { describe, expect, it } from 'vitest';
import { HISTORY_LIMIT, historyReducer, initHistory } from './editorHistory.js';

const run = (state, ...actions) => actions.reduce(historyReducer, state);
const set = (next, merge) => ({ type: 'set', next, merge });

describe('historyReducer', () => {
    it('records each set as an undo step and undoes/redoes it', () => {
        let s = run(initHistory([]), set([1]), set([1, 2]));
        expect(s.present).toEqual([1, 2]);
        s = run(s, { type: 'undo' });
        expect(s.present).toEqual([1]);
        s = run(s, { type: 'undo' });
        expect(s.present).toEqual([]);
        s = run(s, { type: 'undo' });
        expect(s.present).toEqual([]);
        s = run(s, { type: 'redo' }, { type: 'redo' });
        expect(s.present).toEqual([1, 2]);
        expect(s.future).toHaveLength(0);
    });

    it('accepts an updater function', () => {
        const s = run(initHistory([1]), set((list) => [...list, 2]));
        expect(s.present).toEqual([1, 2]);
        expect(s.past).toEqual([[1]]);
    });

    it('a new change clears the redo stack', () => {
        const s = run(initHistory([]), set([1]), { type: 'undo' }, set([9]));
        expect(s.present).toEqual([9]);
        expect(s.future).toHaveLength(0);
    });

    it('ignores a set that returns the same value', () => {
        const start = initHistory([1]);
        expect(run(start, set((list) => list))).toBe(start);
    });

    it('one gesture (a whole drag) becomes one undo step', () => {
        let s = run(initHistory(['a']), { type: 'beginGesture' }, set(['b']), set(['c']), set(['d']), { type: 'endGesture' });
        expect(s.present).toEqual(['d']);
        expect(s.past).toEqual([['a']]);
        s = run(s, { type: 'undo' });
        expect(s.present).toEqual(['a']);
    });

    it('a gesture that changes nothing (a plain click) adds no step', () => {
        const s = run(initHistory(['a']), { type: 'beginGesture' }, { type: 'endGesture' });
        expect(s.past).toHaveLength(0);
        expect(s.gesture).toBeNull();
    });

    it('undo during a gesture closes it first, then undoes the whole gesture', () => {
        const s = run(initHistory(['a']), { type: 'beginGesture' }, set(['b']), { type: 'undo' });
        expect(s.present).toEqual(['a']);
        expect(s.future).toEqual([['b']]);
        expect(s.gesture).toBeNull();
    });

    it('nested beginGesture keeps the first snapshot', () => {
        const s = run(initHistory(['a']), { type: 'beginGesture' }, set(['b']), { type: 'beginGesture' }, set(['c']), { type: 'endGesture' });
        expect(s.past).toEqual([['a']]);
    });

    it('a merge key folds repeated changes (typing) into one step', () => {
        let s = run(initHistory(['']), set(['H'], 'text:1'), set(['He'], 'text:1'), set(['Hey'], 'text:1'));
        expect(s.past).toEqual([['']]);
        s = run(s, set(['Hey', 'x'], 'color:1'));
        expect(s.past).toHaveLength(2);
        s = run(s, { type: 'undo' }, { type: 'undo' });
        expect(s.present).toEqual(['']);
    });

    it('the same merge key after an unrelated change starts a new step', () => {
        const s = run(initHistory([0]), set([1], 'k'), set([2]), set([3], 'k'));
        expect(s.past).toHaveLength(3);
    });

    it('the merge key resets after undo', () => {
        const s = run(initHistory([0]), set([1], 'k'), set([2], 'k'), { type: 'undo' }, set([5], 'k'));
        expect(s.past).toEqual([[0]]);
        expect(s.present).toEqual([5]);
    });

    it('merge: true replaces the present without touching undo or redo', () => {
        let s = run(initHistory([0]), set([1]), set([2]), { type: 'undo' });
        s = run(s, set([1, 'flag'], true));
        expect(s.present).toEqual([1, 'flag']);
        expect(s.past).toEqual([[0]]);
        expect(s.future).toEqual([[2]]);
    });

    it('reset starts a fresh history', () => {
        const s = run(initHistory([0]), set([1]), { type: 'reset', next: [7] });
        expect(s).toEqual(initHistory([7]));
    });

    it('keeps at most HISTORY_LIMIT undo steps', () => {
        let s = initHistory(0);
        for (let i = 1; i <= HISTORY_LIMIT + 20; i++) s = historyReducer(s, set(i));
        expect(s.past).toHaveLength(HISTORY_LIMIT);
        expect(s.past[0]).toBe(20);
    });
});
