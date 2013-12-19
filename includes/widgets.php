<?php
/* SVN FILE: $Id$ */
/**
 *  inc/widgets.php   The widget functions file for the FreeSpirit ESU Wordpress Theme
 *  
 *  This file is the called by the main theme functions file and includes all theme
 *  functions relating to the widget areas created by the theme, as well as theme
 *  specific widgets available for use
 *  
 *  PHP Version 5
 *  
 *  @package        FreeSpiritESU
 *  @subpackage     Functions
 *  @copyright      FreeSpirit ESU <http://www.freespiritesu.org.uk/> 2011 
 *  @author         Richard Perry <http: //www.perry-online.me.uk/>
 *  @since          Release 0.1.1
 *  @version        $Rev$
 *  @modifiedby     $LastChangedBy$
 *  @lastmodified   $Date$
 *
 *  @todo           ToDo List
 */

 
/**
 * Register our sidebars and widgetized areas.
 *
 * @since Release 0.1.1
 */
function fsesu_widgets_init() {

    register_sidebar( array(
        'name' => __( 'Main Sidebar', 'fsesu' ),
        'id' => 'sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );

    register_sidebar( array(
        'name' => __( 'Footer Sidebar', 'fsesu' ),
        'id' => 'sidebar-foot',
        'description' => __( 'An optional widget area for the footer', 'fsesu' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => "</aside>",
        'before_title' => '<h3 class="widget-title">',
        'after_title' => '</h3>',
    ) );
}
add_action( 'widgets_init', 'fsesu_widgets_init' );
