# Image format benchmark: JPG vs WebP vs AVIF (October 2026)

Source data for the guide https://ilovemytools.store/guides/avif-vs-webp-vs-jpg-file-size-test.

- Script: `scripts/format-benchmark.mjs`
- Results: `format-benchmark-2026-10.csv` (one row per image, sizes in bytes)
- Run on 2026-10-31 (Windows 11, Node 20.20.2)

## Versions

sharp 0.35.5, libvips 8.18.7, mozjpeg 0826579, libwebp 1.6.0, libaom 3.15.1 (AVIF via libheif 1.23.5).

## Test images (synthetic, not real photos)

We did not use downloaded photos. The script draws 24 images from fixed random seeds, so
anyone can rebuild exactly the same set:

| Set | Count | Size | What it is |
| --- | --- | --- | --- |
| photo | 8 | 1600 x 1067, RGB | "Photo-like": fractal value noise for terrain and sky, soft round objects, light falloff, Gaussian "sensor" noise (sigma 2 to 6.2) and a 0.6 px blur. Texture rises from photo-01 to photo-08. Not real camera photos. |
| screenshot | 8 | 1440 x 900, RGB | SVG dashboard UI rendered by librsvg: sidebar, stat cards, line chart, list, table, buttons, real text (Segoe UI / Arial). Two of the eight are dark-mode. |
| graphic | 8 | 800 x 800, RGBA | Flat graphics on a transparent background: badges, app icons, logos with a wordmark, outlined stickers; gradients and translucent shapes. |

## Method

1. Encode each image with sharp, changing only the quality setting:
   - JPEG: `jpeg({ quality: 80, mozjpeg: true })`. Transparent images are first flattened onto white, because JPEG has no alpha channel.
   - WebP: `webp({ quality: 80 })` (lossy, alpha kept).
   - AVIF: `avif({ quality: 50 })` (alpha kept).
   - Everything else is a sharp default (effort, chroma subsampling).
2. Measure SSIM against the lossless source: luma only (BT.601 weights), 8 x 8 windows with a 4 px step, standard constants. Transparent images are composited onto white before measuring, for every format.
3. Matched-SSIM pass: for WebP and AVIF, binary-search the lowest quality (1 to 100) whose SSIM is at least the JPEG q80 SSIM of the same image, and record that file's size.
4. Savings are `1 - format_bytes / jpg_q80_bytes` per image; the script prints median and mean per category.

## Results (from the CSV)

Savings versus JPEG q80. Positive means smaller than JPEG. Median / mean of 8 images per set.

| Set | WebP q80 | AVIF q50 | WebP at JPEG's SSIM | AVIF at JPEG's SSIM |
| --- | --- | --- | --- | --- |
| photo | 53.0% / 53.1% | 69.4% / 66.8% | -18.2% / -16.6% (larger) | 12.0% / 20.1% |
| screenshot | 35.3% / 35.4% | 62.3% / 62.3% | 49.4% / 50.4% | 70.5% / 71.7% |
| graphic | 19.7% / 16.7% | 50.4% / 50.9% | 42.3% / 41.6% | 71.7% / 71.7% |

At fixed settings, the photo-like WebP and AVIF files score a slightly lower SSIM than JPEG q80
(medians 0.9674 and 0.9681 vs 0.9721): they smooth away part of the synthetic grain. To reach
JPEG's SSIM on those images, WebP needed q87 to q90 and grew larger than the JPEG in 7 of 8 cases;
AVIF needed q47 to q71 and stayed smaller in 7 of 8.

## Limitations

- Synthetic images. Real photos (faces, foliage, low light) behave differently; treat the photo row as indicative only.
- One encoder per format (libvips/sharp builds), default speed settings. Other encoders (cwebp, avifenc with other speeds, Squoosh, Photoshop) give other numbers.
- SSIM on luma is a rough proxy for what people see. It ignores colour and rewards keeping noise. A perceptual metric (SSIMULACRA 2, Butteraugli) or a viewing test could rank the formats differently.
- Quality numbers are not comparable across formats: "q80" means different things to mozjpeg, libwebp and libaom.
- Lossless WebP and PNG optimisation were not tested; the PNG column is the lossless source as written by libvips, for reference.

## Rerun

```sh
npm i --no-save sharp
node scripts/format-benchmark.mjs                       # writes docs/benchmarks/format-benchmark-2026-10.csv
node scripts/format-benchmark.mjs out.csv --save-images tmp/bench   # also keeps the PNG/JPG/WebP/AVIF files
```

A full run is 24 images x up to 17 encodes (3 fixed + up to 7 binary-search steps each for WebP and AVIF), so up to 408 encodes; AVIF is the slow part, so expect several minutes.
Results should match byte for byte with the same sharp/libvips build; other versions will drift slightly.
