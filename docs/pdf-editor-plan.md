# PDF editor and watermark plan (owner request, 21 Oct 2026)

Goal: an editor as capable as sejda.com's, plus an Add Watermark tool. Everything runs in the
browser (pdf.js + pdf-lib, already in the project); files are never uploaded; free, no limits, no
sign-up, all 10 languages. Each finished step ships with tests, translations (rule 4) and a
re-run of `node scripts/measure-panels.mjs`.

Status: in progress. Tick items as they ship.

## Owner decision (22 Oct 2026): one editor

Every feature lives inside the ONE "Edit PDF" tool (resources/js/tools/EditPdf.jsx), as tabs/modes of the
same editor. Separate pages (/watermark-pdf and the step 7 landing pages) only open Edit PDF with the
matching mode preselected; they never get their own editor. Top priority: extract the PDF's existing
text and change it in place, in the same font.

## Build order

1. [x] Add Watermark to PDF (new tool, own page)
1a. [x] Watermark follow-up (missing from the first release): 'Behind the content' option (background watermark, customer request: draw it before the page's existing content stream so text stays on top and fully readable) next to 'On top', plus the optional 'Flatten' setting that merges the watermark into the page content. Both in all 10 languages, with tests.
2. [x] Edit existing text in the same font (moved up, owner priority; shipped 22 Oct: original text removed from the content stream, not just covered): extract every text run with pdf.js, click to edit in place, keep font family/size/bold/italic/colour, cover the old run with its own background colour; plus find and replace
2b. [x] Watermark inside Edit PDF as a Watermark tab; /watermark-pdf opens Edit PDF in that mode (same settings and output as today)
2c. [ ] Editor phase 1 remainder: zoom, page thumbnails, rotate elements, redo (whiteout, shapes, underline/strikethrough and links shipped 22 Oct)
  - [x] Redo: a Redo button next to Undo restores the most recently undone element; any new edit (add, move, resize, retype, find & replace, explicit remove) clears the redo history, matching standard editor behaviour.
4. [ ] Session: auto-save and unsaved-changes warnings
5. [ ] Fill PDF forms (new page) and create form fields
6. [ ] Page tools and signature inside the editor
7. [ ] Landing pages for each mode: add text to PDF, whiteout PDF, edit PDF text, PDF annotator, fill PDF form, Sejda alternative

## Features

### Editing what's already in the PDF
- Edit existing text: click any text and change it
- Same font family as the original, read from the PDF's embedded font
- Font size matches the original by default and can be adjusted
- Bold, italic, colour and position match the original by default
- Find and replace text across the document
- Whiteout: cover existing content

Font limit (tell users): PDFs usually embed only the letters they use. Letters already in the
document use the exact embedded font; a letter the PDF never contained falls back to the closest
full font (Arial/Helvetica, Times, Courier or their free equivalents) with a notice.

### Adding content
- Text: font, size, colour, bold, italic, alignment, multi-line
- Images
- Links to a website or another page
- Shapes: rectangle, ellipse, line, arrow (border and fill colour)
- Freehand drawing
- Signature

### Marking up
- Highlight, strikethrough, underline

### Forms
- Fill existing form fields
- Create fields: text box, checkbox, dropdown, signature

### Watermark (own tool and an editor option)
- Text watermark: font, size, colour, bold
- Image or logo watermark (transparent PNG supported)
- Behind the content (background) or on top
- Opacity and rotation (diagonal by default)
- Position: centre, corners or tiled across the page
- Pages: all, a range, odd or even, skip the first
- Live preview of the first page
- Optional flatten so the watermark is merged into the page and hard to remove

### Pages
- Thumbnails sidebar, zoom
- Insert a blank page; delete, rotate and reorder pages

### Session
- Work stays active until the user downloads, cancels or uploads a new file
- Auto-saved in the browser (IndexedDB): a refresh, closed tab or crash reopens it where it was
- With unsaved changes, warn before leaving or closing the page, uploading a different file or pressing Cancel
- Download or cancel clears the saved session
- Nothing leaves the device

### Ease of use
- Move, resize, rotate and delete any element
- Undo and redo
- Keyboard shortcuts
- Works by touch on phones

## Promotion (owner request, 21 Oct 2026)

Only features ticked [x] above are ever promoted; nothing is announced before it is live.

- LinkedIn routine: announces each `feat(pdf-editor):` release on the personal profile and the company page, then posts about a live PDF feature every Monday and Thursday.
- Guide routine: writes a guide for each live feature first (add a watermark, edit PDF text, fill PDF forms, white out a PDF, free Sejda alternative).
- Backlink prospector: once anything is live, at least half of each day's outreach targets "best free PDF editor", "Sejda/Smallpdf/iLovePDF alternatives" and "watermark a PDF" pages.
- SEO routine: the new pages join its list as soon as they get Google impressions.
- Build order step 7: a landing page per mode (add text, whiteout, edit text, annotate, fill forms, Sejda alternative) in all 10 languages.
- Owner: Product Hunt and AlternativeTo listings (Claude fills the forms in Chrome on request; the owner submits) should lead with the PDF editor, now that editing existing text is live. (The AI Employees GTM Engineer was removed on 23 Oct.)
