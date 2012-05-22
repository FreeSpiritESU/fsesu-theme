<?php
/**
 *  functions.php The default functions file for the FreeSpirit ESU Wordpress Theme
 *  
 *  This file is the main part of the FreeSpirit ESU Wordpress Theme functions. It is
 *  home to the main functions necessary for the theme to work correctly, and also links
 *  to additional files used to create custom post type, taxonomies and meta boxes for
 *  use throughout the theme.
 *  
 *  PHP Version 5
 *  
 *  @package        FreeSpiritESU
 *  @subpackage     Functions
 *  @copright       FreeSpirit ESU <http://www.freespiritesu.org.uk/> 2011 
 *  @author         Richard Perry <http: //www.perry-online.me.uk/>
 *  @since          Release 0.1.0
 *  @version        0.1.0
 *
 *  @todo           ToDo List
 *                  - Create Merchandise Custom Post Type
 *                  - Create Members Custom Post Type
 *                  - Add necessary display functions for the theme
 */
 
/**
 *  Add the FreeSpirit ESU Favicon to the site
 */
 
add_action('wp_head', 'favicon_link');

function favicon_link() {
    echo '<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />' . "\n";
}

/**
 *  Include the various additional function files
 */
//require_once( get_stylesheet_directory() . '/custom_post_types/events.php' );
