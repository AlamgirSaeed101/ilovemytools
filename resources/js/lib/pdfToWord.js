import { t } from './i18n.js';
import { loadRenderDoc, pageTextItems } from './pdfRender.js';

// Reconstructing a DOCX from a PDF's text layer. PDF has no real paragraph/heading structure,
// so this groups text items into lines by their Y position, lines into paragraphs by the size
// of the gap between them, and guesses headings from font size relative to the page's most
// common size. Tables, columns, images and exact positioning are not preserved - this is a
// best-effort text extraction, not a layout-accurate conversion (stated on the tool page).

/** Group raw text items (already mapped to {str, x, y, height}) into visual lines. */
export function groupItemsIntoLines(items, yTolerance = 2) {
    const usable = items.filter((it) => it.str && it.str.length > 0);
    const lines = [];
    for (const item of usable) {
        let line = lines.find((l) => Math.abs(l.y - item.y) <= yTolerance);
        if (!line) {
            line = { y: item.y, height: item.height || 10, items: [] };
            lines.push(line);
        }
        line.items.push(item);
        line.height = Math.max(line.height, item.height || 10);
        line.y = (line.y + item.y) / 2;
    }
    lines.sort((a, b) => b.y - a.y);
    for (const line of lines) {
        line.items.sort((a, b) => a.x - b.x);
        line.text = joinLineItems(line.items);
    }
    return lines.filter((l) => l.text);
}

function joinLineItems(items) {
    let text = '';
    let prevEndX = null;
    for (const item of items) {
        const charWidth = (item.height || 10) * 0.5;
        if (prevEndX !== null && item.x - prevEndX > charWidth * 0.3 && !text.endsWith(' ') && !item.str.startsWith(' ')) {
            text += ' ';
        }
        text += item.str;
        prevEndX = item.x + (item.width ?? item.str.length * charWidth);
    }
    return text.trim().replace(/[ \t]+/g, ' ');
}

/** The most common rounded line height on the page - treated as the "body text" size. */
export function detectBodySize(lines) {
    const counts = new Map();
    for (const line of lines) {
        const h = Math.round(line.height);
        counts.set(h, (counts.get(h) || 0) + 1);
    }
    let mode = 0;
    let best = -1;
    for (const [h, c] of counts) {
        if (c > best) {
            best = c;
            mode = h;
        }
    }
    return mode || 12;
}

/** Heading level (1-3) guessed from how much bigger a line is than the body text, or null. */
export function headingLevelFor(height, bodySize) {
    if (!bodySize) return null;
    const ratio = height / bodySize;
    if (ratio >= 1.6) return 1;
    if (ratio >= 1.35) return 2;
    if (ratio >= 1.15) return 3;
    return null;
}

/** Group lines into {type:'heading', level, text} and {type:'paragraph', lines:[...]} blocks. */
export function buildDocumentBlocks(lines) {
    const bodySize = detectBodySize(lines);
    const blocks = [];
    let paragraphLines = [];
    let prevY = null;
    let prevHeight = bodySize;

    function flushParagraph() {
        if (paragraphLines.length > 0) blocks.push({ type: 'paragraph', lines: paragraphLines });
        paragraphLines = [];
    }

    for (const line of lines) {
        const level = headingLevelFor(line.height, bodySize);
        const gap = prevY === null ? 0 : prevY - line.y - prevHeight;
        const startsNewParagraph = prevY === null || gap > prevHeight * 0.6;

        if (level) {
            flushParagraph();
            blocks.push({ type: 'heading', level, text: line.text });
        } else {
            if (startsNewParagraph) flushParagraph();
            paragraphLines.push(line.text);
        }
        prevY = line.y;
        prevHeight = line.height;
    }
    flushParagraph();
    return blocks;
}

/** Build the per-page block list for a whole PDF (one 'pageBreak' block inserted between pages). */
export async function extractPdfBlocks(bytes) {
    const renderDoc = await loadRenderDoc(bytes);
    try {
        const blocks = [];
        for (let i = 1; i <= renderDoc.numPages; i++) {
            const items = await pageTextItems(renderDoc, i);
            const lines = groupItemsIntoLines(items);
            if (i > 1) blocks.push({ type: 'pageBreak' });
            blocks.push(...buildDocumentBlocks(lines));
        }
        return blocks;
    } finally {
        renderDoc.destroy();
    }
}

/** Turn extracted blocks into a .docx Blob with the `docx` package (MIT). */
export async function blocksToDocxBlob(blocks) {
    const { Document, HeadingLevel, Packer, PageBreak, Paragraph, TextRun } = await import('docx');
    const LEVELS = { 1: HeadingLevel.HEADING_1, 2: HeadingLevel.HEADING_2, 3: HeadingLevel.HEADING_3 };
    const children = [];
    for (const block of blocks) {
        if (block.type === 'pageBreak') {
            children.push(new Paragraph({ children: [new PageBreak()] }));
        } else if (block.type === 'heading') {
            children.push(new Paragraph({ text: block.text, heading: LEVELS[block.level] || HeadingLevel.HEADING_3 }));
        } else {
            const runs = block.lines.map((line, i) => new TextRun(i === 0 ? { text: line } : { text: line, break: 1 }));
            children.push(new Paragraph({ children: runs }));
        }
    }
    if (children.length === 0) children.push(new Paragraph({ text: '' }));
    const doc = new Document({ sections: [{ children }] });
    return await Packer.toBlob(doc);
}

/** Full pipeline: a PDF's bytes -> a .docx Blob. */
export async function pdfToDocxBlob(bytes) {
    const blocks = await extractPdfBlocks(bytes);
    const hasText = blocks.some((b) => b.type !== 'pageBreak');
    if (!hasText) throw new Error(t('No text was found in this PDF. Scanned pages without selectable text cannot be converted.'));
    return blocksToDocxBlob(blocks);
}
