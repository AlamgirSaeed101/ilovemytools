import { useId, useRef, useState } from 'react';

const UploadIcon = () => (
    <svg className="dropzone__icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.8" strokeLinecap="round" strokeLinejoin="round" aria-hidden="true">
        <path d="M12 16V4M7 9l5-5 5 5" />
        <path d="M20 16v3a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2v-3" />
    </svg>
);

/**
 * Accessible file picker with drag & drop.
 * `accept` example: ".pdf,application/pdf"  -  `onFiles` receives an array of File.
 * Files not matching `isAccepted` are reported through `onReject`.
 */
export default function Dropzone({ accept, multiple = false, onFiles, onReject, isAccepted, title, hint, compact = false }) {
    const inputRef = useRef(null);
    const id = useId();
    const [dragging, setDragging] = useState(false);

    function handle(list) {
        const files = Array.from(list || []);
        if (files.length === 0) return;
        const good = isAccepted ? files.filter(isAccepted) : files;
        const bad = isAccepted ? files.filter((f) => !isAccepted(f)) : [];
        if (bad.length && onReject) onReject(bad);
        if (good.length) onFiles(multiple ? good : [good[0]]);
    }

    return (
        <div
            className={`dropzone${dragging ? ' is-dragging' : ''}`}
            style={compact ? { padding: '1.1rem 1rem' } : undefined}
            role="button"
            tabIndex={0}
            aria-describedby={`${id}-hint`}
            onClick={() => inputRef.current?.click()}
            onKeyDown={(e) => {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    inputRef.current?.click();
                }
            }}
            onDragEnter={(e) => {
                e.preventDefault();
                setDragging(true);
            }}
            onDragOver={(e) => {
                e.preventDefault();
                e.dataTransfer.dropEffect = 'copy';
            }}
            onDragLeave={(e) => {
                if (!e.currentTarget.contains(e.relatedTarget)) setDragging(false);
            }}
            onDrop={(e) => {
                e.preventDefault();
                setDragging(false);
                handle(e.dataTransfer.files);
            }}
        >
            {!compact && <UploadIcon />}
            <p className="dropzone__title">{title}</p>
            <p className="dropzone__hint" id={`${id}-hint`}>{hint}</p>
            <input
                ref={inputRef}
                type="file"
                accept={accept}
                multiple={multiple}
                hidden
                data-testid="file-input"
                onChange={(e) => {
                    handle(e.target.files);
                    e.target.value = ''; // allow choosing the same file again
                }}
            />
        </div>
    );
}
