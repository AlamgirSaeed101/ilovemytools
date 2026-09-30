<?php

/**
 * Regenerate the favicon, app icons and social share image with your brand.
 *
 * Usage (from the project root):
 *   php scripts/generate-brand-images.php "YourBrand" "Free Online Tools"
 *
 * Needs the PHP GD extension (installed on almost every host).
 * Writes: public/favicon.ico, public/apple-touch-icon.png, public/images/icon-192.png,
 *         public/images/logo-512.png, public/images/og-default.png
 */

$brand = $argv[1] ?? 'Toolzy';
$tagline = $argv[2] ?? 'Free Online Tools - Fast, Private, No Sign Up';
$public = dirname(__DIR__).'/public';

if (! extension_loaded('gd')) {
    fwrite(STDERR, "The GD extension is required.\n");
    exit(1);
}

$font = null;
foreach ([
    '/usr/share/fonts/truetype/dejavu/DejaVuSans-Bold.ttf',
    '/usr/share/fonts/truetype/liberation/LiberationSans-Bold.ttf',
    'C:/Windows/Fonts/arialbd.ttf',
    '/Library/Fonts/Arial Bold.ttf',
    '/System/Library/Fonts/Supplemental/Arial Bold.ttf',
] as $candidate) {
    if (is_file($candidate)) {
        $font = $candidate;
        break;
    }
}
if ($font === null) {
    fwrite(STDERR, "No TrueType font found. Edit this script and point \$font at any .ttf file.\n");
    exit(1);
}

function gradient(GdImage $img, int $w, int $h): void
{
    [$r1, $g1, $b1] = [79, 70, 229];   // #4f46e5
    [$r2, $g2, $b2] = [124, 58, 237];  // #7c3aed
    for ($x = 0; $x < $w + $h; $x++) {
        $t = $x / ($w + $h);
        $color = imagecolorallocate($img, (int) ($r1 + ($r2 - $r1) * $t), (int) ($g1 + ($g2 - $g1) * $t), (int) ($b1 + ($b2 - $b1) * $t));
        imageline($img, $x, 0, $x - $h, $h, $color);
    }
}

function centeredText(GdImage $img, string $font, float $size, int $y, string $text, int $color, ?int $width = null): void
{
    $box = imagettfbbox($size, 0, $font, $text);
    $textWidth = $box[2] - $box[0];
    $x = (int) ((($width ?? imagesx($img)) - $textWidth) / 2 - $box[0]);
    imagettftext($img, $size, 0, $x, $y, $color, $font, $text);
}

function roundedIcon(int $size, string $font, string $letter): GdImage
{
    $scale = 4; // supersample for smooth edges
    $big = $size * $scale;
    $img = imagecreatetruecolor($big, $big);
    imagesavealpha($img, true);
    imagealphablending($img, false);
    imagefill($img, 0, 0, imagecolorallocatealpha($img, 0, 0, 0, 127));
    imagealphablending($img, true);

    $grad = imagecreatetruecolor($big, $big);
    gradient($grad, $big, $big);

    $radius = (int) ($big * 0.22);
    $mask = imagecreatetruecolor($big, $big);
    imagefill($mask, 0, 0, imagecolorallocate($mask, 0, 0, 0));
    $white = imagecolorallocate($mask, 255, 255, 255);
    imagefilledrectangle($mask, $radius, 0, $big - $radius, $big, $white);
    imagefilledrectangle($mask, 0, $radius, $big, $big - $radius, $white);
    foreach ([[$radius, $radius], [$big - $radius, $radius], [$radius, $big - $radius], [$big - $radius, $big - $radius]] as [$cx, $cy]) {
        imagefilledellipse($mask, $cx, $cy, $radius * 2, $radius * 2, $white);
    }
    for ($y = 0; $y < $big; $y++) {
        for ($x = 0; $x < $big; $x++) {
            if ((imagecolorat($mask, $x, $y) & 0xFF) > 0) {
                imagesetpixel($img, $x, $y, imagecolorat($grad, $x, $y));
            }
        }
    }

    $white = imagecolorallocate($img, 255, 255, 255);
    $fontSize = $big * 0.42;
    $box = imagettfbbox($fontSize, 0, $font, $letter);
    $x = (int) (($big - ($box[2] - $box[0])) / 2 - $box[0]);
    $y = (int) (($big - ($box[1] - $box[7])) / 2 - $box[7]);
    imagettftext($img, $fontSize, 0, $x, $y, $white, $font, $letter);

    $out = imagecreatetruecolor($size, $size);
    imagesavealpha($out, true);
    imagealphablending($out, false);
    imagefill($out, 0, 0, imagecolorallocatealpha($out, 0, 0, 0, 127));
    imagecopyresampled($out, $img, 0, 0, 0, 0, $size, $size, $big, $big);

    return $out;
}

@mkdir($public.'/images', 0755, true);
$letter = mb_strtoupper(mb_substr($brand, 0, 1));

imagepng(roundedIcon(180, $font, $letter), $public.'/apple-touch-icon.png', 9);
imagepng(roundedIcon(192, $font, $letter), $public.'/images/icon-192.png', 9);
imagepng(roundedIcon(512, $font, $letter), $public.'/images/logo-512.png', 9);

// favicon.ico containing a 32x32 PNG (supported by all modern browsers).
ob_start();
imagepng(roundedIcon(32, $font, $letter));
$png = ob_get_clean();
$ico = pack('vvv', 0, 1, 1).pack('CCCCvvVV', 32, 32, 0, 0, 1, 32, strlen($png), 22).$png;
file_put_contents($public.'/favicon.ico', $ico);

// Social share image 1200x630.
$og = imagecreatetruecolor(1200, 630);
gradient($og, 1200, 630);
$white = imagecolorallocate($og, 255, 255, 255);
$soft = imagecolorallocate($og, 224, 231, 255);
$icon = roundedIcon(120, $font, $letter);
imagealphablending($og, true);
imagecopyresampled($og, $icon, 540, 90, 0, 0, 120, 120, 120, 120);
centeredText($og, $font, 64, 320, $brand, $white);
centeredText($og, $font, 30, 395, $tagline, $soft);
centeredText($og, $font, 22, 500, 'PDF  ·  Images  ·  Text  ·  Calculators  ·  QR Codes  ·  Developer', $soft);
imagepng($og, $public.'/images/og-default.png', 9);

echo "Brand images generated for \"{$brand}\".\n";
