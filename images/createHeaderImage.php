<?php
$fs_root = '../';
$pics = glob( $fs_root . 'images/pics/*.jpg');
$num = count( glob( $fs_root . 'images/pics/*.jpg')) - 1;
$i = rand(0, $num);
      
$filename = $pics[$i];

$crumb = html_entity_decode(urldecode($_GET['p']));
$crumb = str_replace( 'FreeSpirit ESU >> ', '', $crumb);

// Content type
header('Content-type: image/png');

// Set the size of the header image
$rWidth  = 955;
$rHeight = 180;

// Get dimensions of the image to be used
list($imgWidth, $imgHeight) = getimagesize( $filename );

// Set the crop positions and the image sizes
if ($imgWidth > $imgHeight) {
   $x = (($imgWidth / 955) * (955 - $rWidth)) / 2;
   $y = (($imgHeight / 955) * (955 - $rHeight)) / 2;
   $imgWidth = $imgHeight;
}
elseif ($imgHeight > $imgWidth) {
   $y = (($imgHeight / 955) * (955 - $rHeight)) / 2;
   $x = (($imgWidth / 955) * (955 - $rWidth)) / 2;
   $imgHeight = $imgWidth;
}

// Create the background image
$im = imagecreatetruecolor( $rWidth, $rHeight );
$background = imagecreatefromjpeg( $filename );
imagecopyresampled( $im, $background, 0, 0, $x, $y, 955, 955, $imgWidth, $imgHeight );


// Darken the image
$black = imagecolorallocatealpha( $im, 0, 0, 0, 50 );
imagefilledrectangle($im, 0, 0, 955, 180, $black);

// Setup the font information
$font = 'arialbd.ttf';
$text = 'FreeSpirit ESU';
$fontsize = 28;
$red = imagecolorallocate( $im, 255, 0, 0);

// Find the size of the bounding box so the font can be centred in the header
$bbox = imagettfbbox($fontsize, 0, $font, $text);
$tWidth = $bbox[2] - $bbox[0];
$tHeight = $bbox[1] - $bbox[7];
$x = ceil(( 955 - $tWidth ) / 2 );
$y = ceil((( 180 - $tHeight ) / 2 ) + 15 );

// Add the text to the image
imagettftext( $im, $fontsize, 0, $x, $y, $red, $font, $text );

// Setup the font information
$fontsize = 12;

// Find the size of the bounding box so the font can be centred in the header
$bbox = imagettfbbox($fontsize, 0, $font, $crumb);
$tWidth = $bbox[2] - $bbox[0];
$tHeight = $bbox[1] - $bbox[7];
$x = ceil(( 955 - $tWidth ) / 2 );
$y = ceil((( 180 - $tHeight ) / 2 ) + 50 );

// Add the text to the image
imagettftext( $im, $fontsize, 0, $x, $y, $red, $font, $crumb );

// Output
imagepng($im);

?>
