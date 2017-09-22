<?php
$filename = $_GET['img'];

// Content type
header('Content-type: image/png');

// Set the maximum cropped size
$crop = (isset($_GET['c'])) ? $_GET['c'] : 250;

// Get the size of the thumbnail
$resizeWidth  = ($_GET['w'] > $crop) ? $crop : $_GET['w'];
$resizeHeight = ($_GET['h'] > $crop) ? $crop : $_GET['h'];

// Get new dimensions
list($imgWidth, $imgHeight) = getimagesize( $filename );


if ($imgWidth > $imgHeight) {
   $x = (($imgWidth / $crop) * ($crop - $resizeWidth)) / 2;
   $y = (($imgHeight / $crop) * ($crop - $resizeHeight)) / 2;
   $imgWidth = $imgHeight;
}
elseif ($imgHeight > $imgWidth) {
   $y = (($imgHeight / $crop) * ($crop - $resizeHeight)) / 2;
   $x = (($imgWidth / $crop) * ($crop - $resizeWidth)) / 2;
   $imgHeight = $imgWidth;
}
$font = 'arial.ttf';
$text = 'FreeSpirit';
// Resample
$image_p = imagecreatetruecolor($resizeWidth, $resizeHeight);
$image = imagecreatefromjpeg($filename);
$image2 = imagecopyresampled($image_p, $image, 0, 0, $x, $y, $crop, $crop, $imgWidth, $imgHeight);
$image_p = imagettftext($image2, 12, 0, 0, 13, $black, $font, $text);

// Output
imagepng($image_p);

?>
