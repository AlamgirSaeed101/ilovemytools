// Snapshot undo/redo history for the PDF editor. Every change replaces the whole `present`
// value (the list of elements); undo/redo step back and forth between whole snapshots, so any
// kind of change (add, move, resize, rotate, recolour, retype, delete, reorder) is undoable
// without each feature having to describe how to reverse itself.
//
// Gestures: between beginGesture() and endGesture() every set() only replaces `present`; the
// whole drag becomes one undo step when it ends (and no step at all if nothing changed).
//
// set(next, { merge }):
//   merge omitted  -> a new undo step
//   merge: 'key'   -> folds into the previous step when that step was made with the same key
//                     (typing a word, dragging a colour picker or holding an arrow key is one step)
//   merge: true    -> silent: replaces `present` without touching undo or redo at all
//                     (derived data, such as a flag computed from what the user did)
import { useMemo, useReducer } from 'react';

export const HISTORY_LIMIT = 100;

export function initHistory(present) {
    return { past: [], present, future: [], gesture: null, lastKey: null };
}

function resolve(next, present) {
    return typeof next === 'function' ? next(present) : next;
}

function pushPast(past, snapshot) {
    const next = [...past, snapshot];
    return next.length > HISTORY_LIMIT ? next.slice(next.length - HISTORY_LIMIT) : next;
}

/** Ends an open gesture: the snapshot from before it becomes one undo step if anything changed. */
function closeGesture(state) {
    if (!state.gesture) return state;
    if (state.gesture.base === state.present) return { ...state, gesture: null };
    return { ...state, past: pushPast(state.past, state.gesture.base), future: [], gesture: null, lastKey: null };
}

export function historyReducer(state, action) {
    switch (action.type) {
        case 'set': {
            const next = resolve(action.next, state.present);
            if (Object.is(next, state.present)) return state;
            if (action.merge === true || state.gesture) return { ...state, present: next };
            if (typeof action.merge === 'string' && action.merge === state.lastKey && state.past.length > 0) {
                return { ...state, present: next, future: [] };
            }
            return {
                ...state,
                past: pushPast(state.past, state.present),
                present: next,
                future: [],
                lastKey: typeof action.merge === 'string' ? action.merge : null,
            };
        }
        case 'beginGesture':
            if (state.gesture) return state;
            return { ...state, gesture: { base: state.present } };
        case 'endGesture':
            return closeGesture(state);
        case 'undo': {
            const closed = closeGesture(state);
            if (closed.past.length === 0) return closed;
            return {
                past: closed.past.slice(0, -1),
                present: closed.past[closed.past.length - 1],
                future: [closed.present, ...closed.future],
                gesture: null,
                lastKey: null,
            };
        }
        case 'redo': {
            const closed = closeGesture(state);
            if (closed.future.length === 0) return closed;
            return {
                past: pushPast(closed.past, closed.present),
                present: closed.future[0],
                future: closed.future.slice(1),
                gesture: null,
                lastKey: null,
            };
        }
        case 'reset':
            return initHistory(resolve(action.next, state.present));
        default:
            return state;
    }
}

/**
 * React hook around historyReducer.
 * Returns { present, set, undo, redo, reset, canUndo, canRedo, beginGesture, endGesture }.
 * The functions keep the same identity for the life of the component.
 */
export function useHistory(initial) {
    const [state, dispatch] = useReducer(historyReducer, initial, initHistory);
    const api = useMemo(
        () => ({
            set: (next, { merge } = {}) => dispatch({ type: 'set', next, merge }),
            undo: () => dispatch({ type: 'undo' }),
            redo: () => dispatch({ type: 'redo' }),
            reset: (next) => dispatch({ type: 'reset', next }),
            beginGesture: () => dispatch({ type: 'beginGesture' }),
            endGesture: () => dispatch({ type: 'endGesture' }),
        }),
        []
    );
    return { ...api, present: state.present, canUndo: state.past.length > 0 || (state.gesture !== null && state.gesture.base !== state.present), canRedo: state.future.length > 0 };
}
