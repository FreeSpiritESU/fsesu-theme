<?php
/**
 * functions.php    The default functions file for the FreeSpirit ESU Wordpress Theme
 * 
 * This file is the main part of the FreeSpirit ESU Wordpress Theme functions. It is
 * home to the main functions necessary for the theme to work correctly.
 *  
 * @package         FreeSpiritESU
 * @subpackage      Functions
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    07 August 2014
 */
 
 if ( ! isset( $content_width ) ) $content_width = 550;
 

 /**
 * FreeSpiritESU setup.
 *
 * Revise theme defaults and support registered in Twenty Fourteen.
 *
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_setup() {

	/*
	 * Make FreeSpiritESU available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 */
	load_child_theme_textdomain( 'fsesu', get_stylesheet_directory() . '/languages' );

	
	// Remove the unnecessary menu registered by Twentyfourteen
	unregister_nav_menu( 'secondary' );
	
	// Register a menu for use in the footer
	register_nav_menus( array(
		'footer'    => __( 'Footer menu', 'fsesu' )
	) );
	
	// This will remove support for featured content, custom backgrounds & headers
    remove_theme_support( 'featured-content' );
    remove_theme_support( 'custom-background' );
    
    // Add back slightly revised custom header support
    add_theme_support( 'custom-header', array(
		'default-image'          => get_stylesheet_directory_uri() . '/assets/images/brandimages/main-explorers.png',
	    'random-default'         => false,
		'width'                  => 960,
		'height'                 => 180,
		'flex-height'            => true,
		'flex-width'             => true,
		'default-text-color'     => 'f00',
		'wp-head-callback'       => 'twentyfourteen_header_style',
		'admin-head-callback'    => 'twentyfourteen_admin_header_style',
		'admin-preview-callback' => 'twentyfourteen_admin_header_image'
	) );
}
add_action( 'after_setup_theme', 'fsesu_setup', 99 );



/**
 * Use the custom header as a background to the page header element
 * 
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_header() {
    if ( get_header_image() ) :
?> 
    <style type="text/css">
        #masthead {
            background: url('<?php header_image(); ?>') center top;
        }
    </style>
<?php
	endif;
}
add_action( 'wp_head', 'fsesu_header', 99 );



/**
 * Load Font Awesome & custom javascripts
 * 
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_enqueue() {
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' );
	wp_enqueue_script( 'fsesu-functions', get_stylesheet_directory_uri() . '/assets/js/functions.js' );
}
add_action( 'wp_enqueue_scripts', 'fsesu_enqueue', 99 );




/**
 * Remove one of the unnecessary Twenty Fourteen widget areas.
 *
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_remove_widgets() {
	unregister_sidebar( 'sidebar-2' );
}
add_action( 'widgets_init', 'fsesu_remove_widgets', 99 );





/* Disable Admin Bar for everyone
if (!function_exists('df_disable_admin_bar')) {

    function df_disable_admin_bar() {
        
        // for the admin page
        //remove_action('admin_footer', 'wp_admin_bar_render', 1000);
        // for the front-end
        remove_action('wp_footer', 'wp_admin_bar_render', 1000);
        
        // css override for the admin page
        //function remove_admin_bar_style_backend() { 
        //    echo '<style>body.admin-bar #wpcontent, body.admin-bar #adminmenu { padding-top: 0px !important; }</style>';
        //}     
        //add_filter('admin_head','remove_admin_bar_style_backend');
        
        // css override for the frontend
        function remove_admin_bar_style_frontend() {
            echo '<style type="text/css" media="screen">
            html { margin-top: 0px !important; }
            * html body { margin-top: 0px !important; }
            </style>';
        }
        add_filter('wp_head','remove_admin_bar_style_frontend', 99);
    }
}
add_action('init','df_disable_admin_bar'); */