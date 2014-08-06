<?php header('Content-type: image/jpeg');

if ( ! WP_Filesystem($creds) ) {
	request_filesystem_credentials($url, '', true, false, null);
	return;
}
global $wp_filesystem;
$picpage = $wp_filesystem->get_contents( 'http://www.freespiritesu.org.uk/members/fsg/main.php?g2_view=imageblock.External&g2_maxSize=960&g2_show=none' );
//$picpage= @file_get_contents('http://www.freespiritesu.org.uk/members/fsg/main.php?g2_view=imageblock.External&g2_maxSize=960&g2_show=none');

$regexp = "<img\s[^>]*src=(\"??)([^\" >]*?)\\1[^>]*\/>"; 
if(preg_match("/$regexp/siU", $picpage, $matches)) 
{ 
	//print_r ($matches);
	$filename = preg_replace("/\&amp\;/siU", "&", $matches[2]); 
}

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
//$background = imagecreatefromjpeg( $filename );
//imagecopyresampled( $im, $background, 0, 0, $x, $y, 955, 955, $imgWidth, $imgHeight );


// Darken the image
$black = imagecolorallocatealpha( $im, 0, 0, 0, 50 );
imagefilledrectangle($im, 0, 0, 955, 180, $black);

// Output
imagejpeg($im);