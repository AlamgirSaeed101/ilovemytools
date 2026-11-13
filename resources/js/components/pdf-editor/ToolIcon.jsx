// Icons for the PDF editor toolbar, drawn for this project on a 24x24 grid with 2px round strokes
// (the same style as components/Icon.jsx). Inline SVG: no icon font or image request.
const PATHS = {
    select: <path d="M6 3.5v15.5l4.2-4 2.9 6.2 2.6-1.2-2.9-6.1H19z" />,
    text: (
        <>
            <path d="M5 6.5V4.5h14v2" />
            <path d="M12 4.5v15M9 19.5h6" />
        </>
    ),
    edittext: (
        <>
            <path d="M3.5 6V4.5h11V6M9 4.5v13M7 17.5h4" />
            <path d="M19.5 7v13M17.5 7h4M17.5 20h4" />
        </>
    ),
    link: (
        <>
            <path d="M10.5 13.5a4 4 0 0 0 5.7 0l3-3a4 4 0 0 0-5.7-5.7l-1.2 1.2" />
            <path d="M13.5 10.5a4 4 0 0 0-5.7 0l-3 3a4 4 0 0 0 5.7 5.7l1.2-1.2" />
        </>
    ),
    forms: (
        <>
            <rect x="3.5" y="4.5" width="17" height="6" rx="1.5" />
            <rect x="3.5" y="14" width="5.5" height="5.5" rx="1" />
            <path d="m4.8 16.8 1.3 1.3 2.3-2.6M12 16.8h8.5" />
        </>
    ),
    image: (
        <>
            <rect x="3.5" y="4.5" width="17" height="15" rx="2" />
            <circle cx="9" cy="9.5" r="1.6" />
            <path d="m20.5 15.5-4.5-4.5-8 8.5" />
        </>
    ),
    sign: (
        <>
            <path d="M3.5 16.5c2-4 3.5-8 5-8s-1.5 7 .5 7 2.5-3.5 4-3.5 1 2.5 2.5 2.5 2-1.5 3-2" />
            <path d="M3.5 20.5h17" />
        </>
    ),
    whiteout: (
        <>
            <rect x="3.5" y="6.5" width="17" height="11" rx="1.5" />
            <path d="M7 10.5h3M7 13.5h6" />
            <path d="M14.5 6.5v11" strokeDasharray="1.5 2" />
        </>
    ),
    annotate: (
        <>
            <path d="m14.5 4.5 5 5-8.5 8.5H6v-5z" />
            <path d="M3.5 20.5h17" />
        </>
    ),
    highlight: (
        <>
            <path d="m13.5 4 6.5 6.5-7 7-6.5-6.5z" />
            <path d="m6.5 11-2 6h4.5l1-1" />
            <path d="M3.5 20.5h17" />
        </>
    ),
    underline: (
        <>
            <path d="M7 4v6.5a5 5 0 0 0 10 0V4" />
            <path d="M5 20h14" />
        </>
    ),
    strike: (
        <>
            <path d="M16.5 6.5c-.8-1.4-2.5-2.2-4.5-2.2-2.7 0-4.5 1.5-4.5 3.4 0 1.4.9 2.4 2.7 3" />
            <path d="M8 17.3c.8 1.5 2.4 2.4 4.5 2.4 2.7 0 4.5-1.5 4.5-3.5 0-.9-.4-1.7-1.1-2.2" />
            <path d="M4 12h16" />
        </>
    ),
    draw: (
        <>
            <path d="m15.5 4.5 4 4L8.5 19.5H4.5v-4z" />
            <path d="m13 7 4 4" />
        </>
    ),
    note: (
        <>
            <path d="M4.5 4.5h15v10l-5 5h-10z" />
            <path d="M14.5 19.5v-5h5M8 9h8M8 12h5" />
        </>
    ),
    shapes: (
        <>
            <rect x="3.5" y="3.5" width="10" height="10" rx="1" />
            <circle cx="15.5" cy="15.5" r="5" />
        </>
    ),
    rect: <rect x="4" y="6" width="16" height="12" rx="1" />,
    ellipse: <ellipse cx="12" cy="12" rx="8.5" ry="6" />,
    line: <path d="M5 19 19 5" />,
    arrow: (
        <>
            <path d="M5 19 19 5" />
            <path d="M11 5h8v8" />
        </>
    ),
    watermark: (
        <>
            <path d="M12 3.5c3.5 4.2 5.5 7.4 5.5 10a5.5 5.5 0 0 1-11 0c0-2.6 2-5.8 5.5-10z" />
            <path d="M9.5 14.5a2.5 2.5 0 0 0 2.5 2.5" />
        </>
    ),
    undo: (
        <>
            <path d="M8.5 5.5 4.5 9.5l4 4" />
            <path d="M4.5 9.5h10a5 5 0 0 1 0 10h-3" />
        </>
    ),
    redo: (
        <>
            <path d="m15.5 5.5 4 4-4 4" />
            <path d="M19.5 9.5h-10a5 5 0 0 0 0 10h3" />
        </>
    ),
    find: (
        <>
            <circle cx="10.5" cy="10.5" r="6" />
            <path d="m15 15 5.5 5.5" />
        </>
    ),
    zoomIn: (
        <>
            <circle cx="10.5" cy="10.5" r="6" />
            <path d="m15 15 5.5 5.5M8 10.5h5M10.5 8v5" />
        </>
    ),
    zoomOut: (
        <>
            <circle cx="10.5" cy="10.5" r="6" />
            <path d="m15 15 5.5 5.5M8 10.5h5" />
        </>
    ),
    chevron: <path d="m7 10 5 5 5-5" />,
    trash: (
        <>
            <path d="M4.5 7h15M9.5 7V4.5h5V7" />
            <path d="M6.5 7l1 12.5h9l1-12.5M10.5 11v5M13.5 11v5" />
        </>
    ),
    duplicate: (
        <>
            <rect x="8.5" y="8.5" width="11" height="11" rx="1.5" />
            <path d="M15.5 8.5v-3a1 1 0 0 0-1-1h-9a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h3" />
        </>
    ),
    forward: (
        <>
            <rect x="9" y="9" width="11" height="11" rx="1.5" />
            <path d="M15 5.5V5a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v9a1 1 0 0 0 1 1h.5" strokeDasharray="2 2" />
        </>
    ),
    backward: (
        <>
            <rect x="4" y="4" width="11" height="11" rx="1.5" />
            <path d="M18.5 9h.5a1 1 0 0 1 1 1v9a1 1 0 0 1-1 1h-9a1 1 0 0 1-1-1v-.5" strokeDasharray="2 2" />
        </>
    ),
    check: <path d="m5 12.5 4.5 4.5L19 7.5" />,
};

export default function ToolIcon({ name, size = 20, className = 'pdf-tool__icon' }) {
    return (
        <svg
            className={className}
            viewBox="0 0 24 24"
            width={size}
            height={size}
            fill="none"
            stroke="currentColor"
            strokeWidth="2"
            strokeLinecap="round"
            strokeLinejoin="round"
            aria-hidden="true"
            focusable="false"
        >
            {PATHS[name] ?? PATHS.select}
        </svg>
    );
}
