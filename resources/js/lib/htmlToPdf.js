import { t } from './i18n.js';
import { MM_TO_PT, PDF_PAGE_SIZES } from './pdf.js';
import { embedDocumentFonts, pickFont } from './pdfFonts.js';

// A small, pure layout engine that turns a restricted subset of HTML (headings, paragraphs,
// line breaks, lists, bold/italic, images) into paginated pages of draw instructions for
// pdf-lib. Shared by the Word to PDF and HTML to PDF tools. No tables, columns, custom fonts
// or precise positioning - complex layouts are not preserved, only the text and reading order.

const HEADING_SIZES = { 1: 22, 2: 18, 3: 15, 4: 13, 5: 12, 6: 11 };
const BODY_SIZE = 11;
const LINE_HEIGHT_RATIO = 1.32;
const BLOCK_GAP = 8;
const LIST_INDENT = 16;

const ENTITIES = { amp: '&', lt: '<', gt: '>', quot: '"', apos: "'", nbsp: ' ' };

export function decodeEntities(str) {
    return String(str).replace(/&(#x?[0-9a-fA-F]+|[a-zA-Z]+);/g, (full, code) => {
        if (code[0] === '#') {
            const isHex = code[1] === 'x' || code[1] === 'X';
            const point = isHex ? parseInt(code.slice(2), 16) : parseInt(code.slice(1), 10);
            return Number.isFinite(point) && point > 0 ? String.fromCodePoint(point) : full;
        }
        return code in ENTITIES ? ENTITIES[code] : full;
    });
}

const HEADING_RE = /^h([1-6])$/;

/**
 * Parse a restricted HTML subset into blocks: headings, paragraphs, list items and images.
 * Unknown tags (span, a, table, style attributes...) are ignored but their text still flows
 * through, so pasted HTML never loses content even when a tag isn't specifically supported.
 */
export function parseHtmlToBlocks(html) {
    const withoutComments = String(html || '').replace(/<!--[\s\S]*?-->/g, '');
    const withoutNonContent = withoutComments.replace(/<(script|style|head)[^>]*>[\s\S]*?<\/\1>/gi, '');
    const bodyMatch = /<body[^>]*>([\s\S]*)<\/body>/i.exec(withoutNonContent);
    const source = bodyMatch ? bodyMatch[1] : withoutNonContent;

    const blocks = [];
    let current = null;
    let boldDepth = 0;
    let italicDepth = 0;
    const listStack = []; // { ordered, count }

    function openBlock(type, extra = {}) {
        closeBlock();
        current = { type, runs: [], ...extra };
    }
    function closeBlock() {
        if (current && (current.runs.length > 0)) blocks.push(current);
        current = null;
    }
    function pushText(raw) {
        const text = decodeEntities(raw).replace(/[ \t\r\n]+/g, ' ');
        if (!text) return;
        if (!current) openBlock('paragraph');
        current.runs.push({ text, bold: boldDepth > 0, italic: italicDepth > 0 });
    }

    const tagRe = /<(\/?)([a-zA-Z][a-zA-Z0-9]*)((?:\s+[^<>]*)?)\/?>|([^<]+)/g;
    let match;
    // eslint-disable-next-line no-cond-assign
    while ((match = tagRe.exec(source))) {
        const [, closing, tagRaw, attrs, text] = match;
        if (text !== undefined) {
            pushText(text);
            continue;
        }
        const tag = tagRaw.toLowerCase();
        const isClose = closing === '/';
        const headingLevel = HEADING_RE.exec(tag);

        if (headingLevel) {
            if (!isClose) openBlock('heading', { level: Number(headingLevel[1]) });
            else closeBlock();
        } else if (tag === 'p' || tag === 'div') {
            if (!isClose) openBlock('paragraph');
            else closeBlock();
        } else if (tag === 'ul' || tag === 'ol') {
            if (!isClose) listStack.push({ ordered: tag === 'ol', count: 0 });
            else listStack.pop();
        } else if (tag === 'li') {
            if (!isClose) {
                const list = listStack[listStack.length - 1] || { ordered: false, count: 0 };
                if (list.ordered) list.count += 1;
                openBlock('listItem', { ordered: list.ordered, number: list.count, depth: listStack.length || 1 });
            } else {
                closeBlock();
            }
        } else if (tag === 'br') {
            if (!current) openBlock('paragraph');
            current.runs.push({ break: true });
        } else if (tag === 'img') {
            if (isClose) continue;
            const srcMatch = /\bsrc\s*=\s*"([^"]*)"|\bsrc\s*=\s*'([^']*)'/i.exec(attrs || '');
            const src = srcMatch ? srcMatch[1] || srcMatch[2] : '';
            if (src) {
                closeBlock();
                blocks.push({ type: 'image', src });
            }
        } else if (tag === 'b' || tag === 'strong') {
            boldDepth += isClose ? -1 : 1;
        } else if (tag === 'i' || tag === 'em') {
            italicDepth += isClose ? -1 : 1;
        }
        // Any other tag (a, span, table, font...) is ignored; its text content still flows through.
    }
    closeBlock();
    return blocks;
}

/** Split a block's runs into style-tagged words, with explicit line breaks and space markers. */
export function tokenizeRuns(runs) {
    const words = [];
    for (const run of runs) {
        if (run.break) {
            words.push({ break: true });
            continue;
        }
        const parts = run.text.split(' ');
        parts.forEach((part, i) => {
            if (part === '') {
                if (words.length > 0) words[words.length - 1].space = true;
                return;
            }
            words.push({ text: part, bold: run.bold, italic: run.italic, space: i < parts.length - 1 });
        });
    }
    return words;
}

/** Break a word wider than `maxWidth` into drawable chunks (long URLs, etc). */
function splitLongWord(word, maxWidth, measure, size) {
    if (measure(word.text, word, size) <= maxWidth || word.text.length <= 1) return [word];
    const chunks = [];
    let start = 0;
    while (start < word.text.length) {
        let end = start + 1;
        while (end < word.text.length && measure(word.text.slice(start, end + 1), word, size) <= maxWidth) end += 1;
        chunks.push(word.text.slice(start, end));
        start = end;
    }
    return chunks.map((text, i) => ({ text, bold: word.bold, italic: word.italic, space: i === chunks.length - 1 ? word.space : false }));
}

/**
 * Greedy word-wrap. `measure(text, {bold, italic}, size)` returns a width in points, so the
 * same function works with pdf-lib's real font metrics or a simple mock in tests.
 */
export function wrapWords(words, maxWidth, measure, size) {
    const spaceWidth = measure(' ', {}, size) || 0;
    const lines = [];
    let line = [];
    let width = 0;
    function flush() {
        lines.push(line);
        line = [];
        width = 0;
    }
    for (const word of words) {
        if (word.break) {
            flush();
            continue;
        }
        for (const piece of splitLongWord(word, maxWidth, measure, size)) {
            const pieceWidth = measure(piece.text, piece, size);
            const sep = line.length > 0 ? spaceWidth : 0;
            if (line.length > 0 && width + sep + pieceWidth > maxWidth) flush();
            width += (line.length > 0 ? spaceWidth : 0) + pieceWidth;
            line.push(piece);
        }
    }
    if (line.length > 0 || lines.length === 0) flush();
    return lines;
}

/**
 * Lay out parsed blocks onto pages of draw instructions.
 * `measure(text, {bold, italic}, size)` -> width in points (pdf-lib font metrics in production).
 * `imageSize(src)` -> {width, height} in points, or null to skip an image that couldn't be read.
 */
export function layoutBlocksToPages(blocks, { pageWidth, pageHeight, marginPt, measure, imageSize }) {
    const maxWidth = pageWidth - marginPt * 2;
    const fullHeight = pageHeight - marginPt * 2;
    const pages = [[]];
    let y = pageHeight - marginPt;

    function page() {
        return pages[pages.length - 1];
    }
    function newPage() {
        pages.push([]);
        y = pageHeight - marginPt;
    }
    function ensureRoom(height) {
        if (y - height < marginPt && y < pageHeight - marginPt) newPage();
    }

    for (const block of blocks) {
        if (block.type === 'image') {
            const natural = imageSize(block.src);
            if (!natural || !natural.width || !natural.height) continue;
            let w = natural.width;
            let h = natural.height;
            if (w > maxWidth) {
                h *= maxWidth / w;
                w = maxWidth;
            }
            if (h > fullHeight) {
                w *= fullHeight / h;
                h = fullHeight;
            }
            ensureRoom(h);
            page().push({ type: 'image', src: block.src, x: marginPt + (maxWidth - w) / 2, y: y - h, width: w, height: h });
            y -= h + BLOCK_GAP;
            continue;
        }

        const size = block.type === 'heading' ? HEADING_SIZES[block.level] || BODY_SIZE : BODY_SIZE;
        const bold = block.type === 'heading';
        const lineHeight = size * LINE_HEIGHT_RATIO;
        const prefix = block.type === 'listItem' ? (block.ordered ? `${block.number}.` : '•') + ' ' : '';
        const indent = block.type === 'listItem' ? LIST_INDENT * (block.depth || 1) : 0;
        const prefixWidth = prefix ? measure(prefix, { bold }, size) : 0;
        const words = tokenizeRuns(block.runs);
        const lines = wrapWords(words, Math.max(10, maxWidth - indent - prefixWidth), measure, size);

        lines.forEach((lineWords, i) => {
            ensureRoom(lineHeight);
            page().push({
                type: 'text',
                x: marginPt + indent + (i === 0 ? 0 : prefixWidth),
                y: y - lineHeight * 0.82,
                words: lineWords,
                prefix: i === 0 ? prefix : '',
                size,
                headingBold: bold,
            });
            y -= lineHeight;
        });
        y -= BLOCK_GAP;
    }
    return pages;
}

/** Default page geometry (A4/Letter, 20mm margins), matching the rest of the PDF tools. */
export function pageGeometry(pageSize = 'a4') {
    const base = PDF_PAGE_SIZES[pageSize] || PDF_PAGE_SIZES.a4;
    return { pageWidth: base.width, pageHeight: base.height, marginPt: 20 * MM_TO_PT };
}

/** Embed every unique image `src` (data URLs only - no fetching other sites) into `pdfDoc`. */
export async function embedBlockImages(pdfDoc, blocks) {
    const images = new Map();
    for (const block of blocks) {
        if (block.type !== 'image' || images.has(block.src)) continue;
        images.set(block.src, await embedOneImage(pdfDoc, block.src));
    }
    return images;
}

async function embedOneImage(pdfDoc, src) {
    const mimeMatch = /^data:(image\/[a-zA-Z+.-]+);base64,/i.exec(src || '');
    if (!mimeMatch) return null;
    try {
        const bytes = await (await fetch(src)).arrayBuffer();
        if (mimeMatch[1] === 'image/png') return await pdfDoc.embedPng(bytes);
        if (mimeMatch[1] === 'image/jpeg' || mimeMatch[1] === 'image/jpg') return await pdfDoc.embedJpg(bytes);
        return null; // other formats (webp, gif, svg) are skipped - documented as a known limit
    } catch {
        return null;
    }
}

function drawOpsOnPage(page, ops, fonts, embeddedImages) {
    for (const op of ops) {
        if (op.type === 'image') {
            const img = embeddedImages.get(op.src);
            if (img) page.drawImage(img, { x: op.x, y: op.y, width: op.width, height: op.height });
            continue;
        }
        let x = op.x;
        if (op.prefix) {
            page.drawText(op.prefix, { x, y: op.y, size: op.size, font: pickFont(fonts, { bold: op.headingBold }) });
        }
        for (const word of op.words) {
            const font = pickFont(fonts, { bold: word.bold || op.headingBold, italic: word.italic });
            page.drawText(word.text, { x, y: op.y, size: op.size, font });
            x += font.widthOfTextAtSize(word.text, op.size);
            if (word.space) x += font.widthOfTextAtSize(' ', op.size);
        }
    }
}

/** Draw laid-out pages onto a fresh pdf-lib document using the embedded DejaVu fonts. */
export function renderPagesToPdf(doc, pages, { pageWidth, pageHeight }, fonts, embeddedImages) {
    for (const ops of pages) {
        const page = doc.addPage([pageWidth, pageHeight]);
        drawOpsOnPage(page, ops, fonts, embeddedImages);
    }
    return doc;
}

/** Full pipeline: HTML string -> a finished PDF Blob. Throws a friendly error if there is no content. */
export async function htmlToPdfBlob(html, { pageSize = 'a4' } = {}) {
    const blocks = parseHtmlToBlocks(html);
    if (blocks.length === 0) throw new Error(t('There is nothing to convert. Add some text or HTML first.'));

    const { PDFDocument } = await import('pdf-lib');
    const doc = await PDFDocument.create();
    const fonts = await embedDocumentFonts(doc);
    const embeddedImages = await embedBlockImages(doc, blocks);
    const sizes = new Map();
    for (const [src, img] of embeddedImages) if (img) sizes.set(src, { width: img.width, height: img.height });

    const geometry = pageGeometry(pageSize);
    const measure = (text, style, size) => pickFont(fonts, style).widthOfTextAtSize(text || ' ', size);
    const pages = layoutBlocksToPages(blocks, { ...geometry, measure, imageSize: (src) => sizes.get(src) || null });

    renderPagesToPdf(doc, pages, geometry, fonts, embeddedImages);
    const bytes = await doc.save();
    return new Blob([bytes], { type: 'application/pdf' });
}
