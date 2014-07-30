<?php
/* SVN FILE: $Id$ */
/**
 *  inc/admin.php   The admin & login functions file for the FreeSpirit ESU Wordpress Theme
 *  
 *  This file is the called by the main theme functions file and includes all theme
 *  functions relating to the admin and login sections of the site.
 *  
 *  PHP Version 5
 *  
 *  @package        FreeSpiritESU
 *  @subpackage     Functions
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    10 January 2014
 *
 *  @todo           ToDo List
 */

/**
 *  ADMIN & LOGIN FUNCTIONS
 */

 
/**
 *  Add the FreeSpirit ESU Logo to the Login Page
 */
function fsesu_login_logo() {
    $style = '<style type="text/css"> h1 a { background: transparent url(' . 
        get_bloginfo('url') . 
        '/favicon.ico) no-repeat 30px center !important; } </style>';
    $style .= '<link rel="stylesheet" type="text/css" href="' .
        get_bloginfo('stylesheet_directory') . 
        '/css/admin.css">';
    echo $style;
}
add_action( 'login_head', 'fsesu_login_logo' );

/**
 *  Change the Login header title
 */
function fsesu_login_headertitle() {
    return get_option('blogname');
}
add_filter( 'login_headertitle', 'fsesu_login_headertitle' );

/**
 *  Change the Login header link
 */
function fsesu_login_headerurl() {
    return home_url();
}
add_filter( 'login_headerurl', 'fsesu_login_headerurl' );

/**
 *  Change the Login/Logout text
 */
function fsesu_loginout_text($text) {
    $login_text_before = 'Log in';
    $login_text_after = 'Member sign-in';
    $logout_text_before = 'Log out';
    $logout_text_after = 'Member sign-out';
    $text = str_replace($login_text_before, $login_text_after ,$text);
    $text = str_replace($logout_text_before, $logout_text_after ,$text);
    return $text;
}
add_filter('loginout','fsesu_loginout_text');