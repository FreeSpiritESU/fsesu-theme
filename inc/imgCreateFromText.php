<?php
$text = base64_decode($_GET['txt']);

// Set the content-type
header("Content-type: image/png");

// Create the image
$im = imagecreatetruecolor(210, 18);

// Create some colors
$white = imagecolorallocate($im, 255, 255, 255);
$black = imagecolorallocate($im, 0, 0, 0);
imagefilledrectangle($im, 0, 0, 209, 17, $white);

// Font path
$font = 'arial.ttf';

// Add the text
imagettftext($im, 12, 0, 0, 13, $black, $font, $text);

// Using imagepng() results in clearer text compared with imagejpeg()
imagepng($im);
imagedestroy($im);

?>
