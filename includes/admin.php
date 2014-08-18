<?php
/**
 * Functions to customise the admin area of the site
 *  
 * @package         FreeSpiritESU
 * @subpackage      Functions
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    15 August 2014
 */
 
function fsesu_login_stylesheet() {
    wp_enqueue_style( 'fsesu-login', get_stylesheet_directory_uri() . '/assets/css/login.css' );
   // wp_enqueue_script( 'custom-login', get_template_directory_uri() . '/style-login.js' );
}
add_action( 'login_enqueue_scripts', 'fsesu_login_stylesheet' );




function fsesu_login_logo_url() {
    return home_url();
}
add_filter( 'login_headerurl', 'fsesu_login_logo_url' );




function fsesu_login_logo_url_title() {
    return get_bloginfo( 'name', 'display' );
}
add_filter( 'login_headertitle', 'fsesu_login_logo_url_title' );




function fsesu_admin_stylesheet() {
    wp_enqueue_style('fsesu-admin', get_stylesheet_directory_uri() . '/assets/css/admin.css' );
}
add_action( 'admin_enqueue_scripts', 'fsesu_admin_stylesheet');




/* function left_admin_footer_text_output($text) {
    $text = $text . '   How much wood would a woodchuck chuck?';
    return $text;
}
add_filter('admin_footer_text', 'left_admin_footer_text_output'); //left side




function right_admin_footer_text_output( $text ) {
    $text = 'That\'s purely hypothetical.   ' . $text;
    return $text;
}
add_filter('update_footer', 'right_admin_footer_text_output', 11); //right side */