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
 * @lastmodified    06 August 2014
 *
 * @todo            ToDo List
 *                  - Add necessary display functions for the theme
 */
 
 if ( ! isset( $content_width ) ) $content_width = 550;
 
 
 /**
 * Twenty Fourteen setup.
 *
 * Set up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support post thumbnails.
 *
 * @since Twenty Fourteen 1.0
 */
function fsesu_setup() {

	/*
	 * Make Twenty Fourteen available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 * If you're building a theme based on Twenty Fourteen, use a find and
	 * replace to change 'twentyfourteen' to the name of your theme in all
	 * template files.
	 */
	load_child_theme_textdomain( 'fsesu', get_stylesheet_directory() . '/languages' );

	
	// Remove the unnecessary menu registered by Twentyfourteen
	unregister_nav_menu( 'secondary' );
	
	// Register a menu for use in the footer
	register_nav_menus( array(
		'footer'    => __( 'Footer menu', 'fsesu' )
	) );
	
	// This will remove support for featured content
    remove_theme_support( 'featured-content' );
}
add_action( 'after_setup_theme', 'fsesu_setup', 99 );


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


// Disable Admin Bar for everyone
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
add_action('init','df_disable_admin_bar');

