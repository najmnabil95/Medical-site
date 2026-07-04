<?php
require __DIR__ . '/vendor/autoload.php';
$app = require __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$settings = App\Models\Setting::first();
if (!$settings) {
    echo "No settings row found." . PHP_EOL;
    exit;
}

$favicon = $settings->getRawOriginal('favicon') ?: $settings->favicon;
echo "Current Favicon: " . $favicon . PHP_EOL;

if (empty($favicon)) {
    echo "Favicon is empty." . PHP_EOL;
    exit;
}

// Convert relative path to full physical path
$relativePath = str_replace('storage/', '', $favicon);
$physicalPath = public_path('storage/' . $relativePath);

echo "Physical Path: " . $physicalPath . PHP_EOL;

if (!file_exists($physicalPath)) {
    echo "File does not exist." . PHP_EOL;
    exit;
}

// Process using GD
$info = getimagesize($physicalPath);
if (!$info) {
    echo "Not a valid image." . PHP_EOL;
    exit;
}

$mime = $info['mime'];
echo "Mime Type: " . $mime . PHP_EOL;

switch ($mime) {
    case 'image/jpeg':
    case 'image/jpg':
        $src = imagecreatefromjpeg($physicalPath);
        break;
    case 'image/png':
        $src = imagecreatefrompng($physicalPath);
        break;
    case 'image/webp':
        $src = imagecreatefromwebp($physicalPath);
        break;
    case 'image/gif':
        $src = imagecreatefromgif($physicalPath);
        break;
    default:
        echo "Unsupported mime type." . PHP_EOL;
        exit;
}

if (!$src) {
    echo "Failed to load image." . PHP_EOL;
    exit;
}

$srcWidth = imagesx($src);
$srcHeight = imagesy($src);

$targetSize = 128;
$dst = imagecreatetruecolor($targetSize, $targetSize);

// Fill with white background
$white = imagecolorallocate($dst, 255, 255, 255);
imagefill($dst, 0, 0, $white);

// Keep transparent ratio with padding
$padding = 12;
$maxSize = $targetSize - ($padding * 2);

if ($srcWidth > $srcHeight) {
    $dstWidth = $maxSize;
    $dstHeight = round(($srcHeight / $srcWidth) * $maxSize);
} else {
    $dstHeight = $maxSize;
    $dstWidth = round(($srcWidth / $srcHeight) * $maxSize);
}

$dstX = round(($targetSize - $dstWidth) / 2);
$dstY = round(($targetSize - $dstHeight) / 2);

imagecopyresampled($dst, $src, $dstX, $dstY, 0, 0, $dstWidth, $dstHeight, $srcWidth, $srcHeight);

// Draw light gray thin border
$borderColor = imagecolorallocate($dst, 226, 232, 240);
imagerectangle($dst, 0, 0, $targetSize - 1, $targetSize - 1, $borderColor);

// Save back as PNG or same format
imagepng($dst, $physicalPath);

imagedestroy($src);
imagedestroy($dst);

echo "Favicon successfully processed with white background and border!" . PHP_EOL;
