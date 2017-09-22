<?php
$filename = base64_decode($_GET['img']);

// Content type
header('Content-type: image/png');

// Get the size of the thumbnail
$thumbSize = $_GET['w'];

// Get new dimensions
list($imgWidth, $imgHeight) = getimagesize( $filename );

if ($imgWidth > $imgHeight) {
   $x = ceil(($imgWidth - $imgHeight) / 2 );
   $imgWidth = $imgHeight;
}
elseif ($imgHeight > $imgWidth) {
   $y = ceil(($imgHeight - $imgWidth) / 2);
   $imgHeight = $imgWidth;
}


// Resample
$image_p = imagecreatetruecolor($thumbSize, $thumbSize);
$image = imagecreatefromjpeg($filename);
imagecopyresampled($image_p, $image, 0, 0, $x, $y, $thumbSize, $thumbSize, $imgWidth, $imgHeight);

// Output
imagepng($image_p);

?>
