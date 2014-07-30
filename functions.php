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
 * @lastmodified     July 2014
 *
 * @todo            ToDo List
 *                  - Add necessary display functions for the theme
 */
 
 if ( ! isset( $content_width ) ) $content_width = 550;
 
/**
 *  Include other function files
 */
 
require_once locate_template( '/includes/admin.php' );           // Admin & login 
require_once locate_template( '/includes/shortcodes.php' );      // Shortcodes

/**
 * Instantiate the theme object
 */
require_once locate_template( '/includes/classes/class-fsesu-theme.php' );
$fsesu = new FSESU_Theme();
 

// Define the standard site categories

$categories = array(
    array (
        'term' => 'Camp Diaries',
        'args' => 
            array(
                'description' => "Everytime we participate in a major camp, 
                    or jamboree, as a group, we will be keeping everyone 
                    informed of how we are getting on through our camp diary. 
                    These diaries will be posted here, and pictures will 
                    generally be found on our Gallery.",
                'slug' => 'campdiaries'
            )
    ),
    array (
        'term' => 'News',
        'args' => 
            array(
                'description' => "News about what is happening in our Unit",
                'slug' => 'news'
            )
    ),
    array (
        'term' => "What's New",
        'args' => 
            array(
                'description' => "Quick updates about new things on the 
                    website, as well as quick notices for the Unit",
                'slug' => 'whatsnew',
                'parent' => get_cat_ID('News')
            )
    )
);
$fsesu->categories( $categories );



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

