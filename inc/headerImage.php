<?php
// Set the content-type
header("Content-type: image/png");

// Font path
$font = 'arial.ttf';

// Logo filename
$logo = '../images/fslogo.png';

// Header background filename
$hBackground = $_GET['img'];

// Set resized height
$rHeight = 180;
$rWidth  = 960;

// Create the image
$im = imagecreatetruecolor($rWidth, $rHeight);

// Get original height
list($oWidth, $oHeight) = getimagesize( $hBackground );

// Set crop position
if ($oWidth > $oHeight) {
   $oWidth = $oHeight;
}
elseif ($oHeight > $oWidth) {
   $oHeight = $oWidth;
}
$y = ceil((($oWidth / $rWidth) * $rHeight) / 2);

// Create the image
$image = imagecreatefromjpeg($hBackground);
imagecopyresampled($im, $image, 0, 0, 0, $y, $rWidth, $rHeight, $oWidth, $oHeight);
imagepng($im);
