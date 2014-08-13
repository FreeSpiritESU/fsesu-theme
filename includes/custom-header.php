<?php
/**
 * Implement Custom Header functionality for Twenty Fourteen
 *
 * @package         FreeSpiritESU
 * @subpackage      Functions
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    13 August 2014
 */

/**
 * Set up the WordPress core custom header settings.
 *
 * @since Twenty Fourteen 1.0
 *
 * @uses twentyfourteen_header_style()
 * @uses twentyfourteen_admin_header_style()
 * @uses twentyfourteen_admin_header_image()
 */
function fsesu_custom_header_setup() {
	/**
	 * Filter Twenty Fourteen custom-header support arguments.
	 *
	 * @since Twenty Fourteen 1.0
	 *
	 * @param array $args {
	 *     An array of custom-header support arguments.
	 *
	 *     @type bool   $header_text            Whether to display custom header text. Default false.
	 *     @type int    $width                  Width in pixels of the custom header image. Default 1260.
	 *     @type int    $height                 Height in pixels of the custom header image. Default 240.
	 *     @type bool   $flex_height            Whether to allow flexible-height header images. Default true.
	 *     @type string $admin_head_callback    Callback function used to style the image displayed in
	 *                                          the Appearance > Header screen.
	 *     @type string $admin_preview_callback Callback function used to create the custom header markup in
	 *                                          the Appearance > Header screen.
	 * }
	 */
	 
	
	
    // Add back slightly revised custom header support
    add_theme_support( 'custom-header', apply_filters( 'fsesu_custom_header_args', array(
		'width'                  => 960,
		'height'                 => 180,
		'flex-width'            => true,
		'flex-height'            => true,
		'random-default'         => true,
		'default-text-color'     => 'f00',
		'admin-head-callback'    => 'fsesu_admin_header_style',
		'admin-preview-callback' => 'fsesu_admin_header_image'
	) ) );
	
	// Register some default headers
	register_default_headers( array(
		'serbia06' => array(
			'description'   => __( 'Serbian National Jamboree 2006', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/serbia06.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/serbia06-thumb.jpg',
		),
		'scotland08' => array(
			'description'   => __( 'Scotland Summer Camp 2008', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/scotland08.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/scotland08-thumb.jpg',
		),
		'wings09' => array(
			'description'   => __( 'Wings 2009', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/wings09.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/wings09-thumb.jpg',
		),
		'youlbury10' => array(
			'description'   => __( 'Youlbury Summer Camp 2010', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/youlbury10.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/youlbury10-thumb.jpg',
		),
		'camjam11' => array(
			'description'   => __( 'CamJam 2011', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/camjam11.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/camjam11-thumb.jpg',
		),
		'lochgoilhead12' => array(
			'description'   => __( 'Lochgoilhead Summer Camp 2012', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/scotland08.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/scotland08-thumb.jpg',
		),
		'kernow13' => array(
			'description'   => __( 'Kernow 2013', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/kernow13.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/kernow13-thumb.jpg',
		),
		'canoeing' => array(
			'description'   => __( 'Canoeing', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/canoeing.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/canoeing-thumb.jpg',
		),
		'freerunning' => array(
			'description'   => __( 'FreeRunning', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/freerunning.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/freerunning-thumb.jpg',
		),
		'gwent_trek' => array(
			'description'   => __( 'Gwent Trek 2013', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/gwent_trek.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/gwent_trek-thumb.jpg',
		),
		'rhys_new_car' => array(
			'description'   => __( 'Rhys\' New Car', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/rhys_new_car.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/rhys_new_car-thumb.jpg',
		),
		'buddhist_visit' => array(
			'description'   => __( 'Visit to Lam Rim Buddhist Centre', 'fsesu' ),
			'url'           => '%2$s/assets/images/head/buddhist_visit.jpg',
			'thumbnail_url' => '%2$s/assets/images/head/buddhist_visit-thumb.jpg',
		)
	) ); 
}
add_action( 'after_setup_theme', 'fsesu_custom_header_setup', 99 );


/**
 * Style the header image displayed on the Appearance > Header screen.
 *
 * @see fsesu_custom_header_setup()
 *
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_admin_header_style() {
?>
	<style type="text/css" id="fsesu-admin-header-css">
	.site-header {
		border: none;
		max-width: 960px;
		height: 180px;
		position: relative;
	}
	.header-main {
		background: rgba( 0, 0, 0, 0.6 );
		height: 180px;
		left: 0;
		position: absolute;
		top: 0;
		width: 100%;
	}
	.header-main .site-logo {
	    height: 180px;
	    left: 15px;
	    position: absolute;
	    top: 0;
	}
	.header-main h1 {
		font-family: Lato, sans-serif;
		font-size: 30px;
		line-height: 48px;
		margin: 0 0 0 30px;
		padding: 50px 155px 0;
	}
	.header-main h1 a {
		color: #f00;
		text-decoration: none;
	}
	</style>
<?php
}

/**
 * Create the custom header image markup displayed on the Appearance > Header screen.
 *
 * @see fsesu_custom_header_setup()
 *
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_admin_header_image() {
?>
	<div class="site-header"<?php if ( get_header_image() ) : ?> style="background: url(<?php header_image(); ?>) center top"<?php endif; ?>>
		<div class="header-main">
			<a onclick="return false;" href='<?php echo esc_url( home_url( '/' ) ); ?>' rel='home'><img class='site-logo' src='<?php echo get_stylesheet_directory_uri(); ?>/assets/images/fslogo.png' title='FSESU Logo' alt='FSESU Logo'></a>
			<h1 class="site-title"><a id="name" onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		</div>
	</div>
<?php
}