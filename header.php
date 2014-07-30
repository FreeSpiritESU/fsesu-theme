<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <section id='container'>
 *
 * @package         FreeSpiritESU
 * @subpackage      Templates
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    29 July 2014
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
  <meta charset="<?php bloginfo( 'charset' ); ?>">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <meta name="viewport" content="initial-scale=1">
  <title><?php wp_title( '|', true, 'right' ); ?></title>
  <link rel="profile" href="http://gmpg.org/xfn/11">
  <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
  <?php if ( is_singular() && get_option( 'thread_comments' ) ) wp_enqueue_script( 'comment-reply' ); ?>
    
  <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
  <div id='container' class='hfeed'>
    <header id='header' role='banner'>
      <hgroup id='branding'>
        <img id='site-logo' src='<?php echo FSESU_ASSETS; ?>/images/fslogo.png' alt='FS Logo'>
        <h1 id='site-title'>
          <a href='<?php echo esc_url( home_url( '/' ) ); ?>' 
            title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' 
            rel='home'><?php bloginfo( 'name' ); ?>
          </a>
        </h1>
        <?php if ( function_exists('yoast_breadcrumb') ) {
        	yoast_breadcrumb('<span id="site-breadcrumb">','</span>');
        } ?>
      </hgroup><!-- #branding -->
  
      <nav id='primary-navigation' role='navigation'>
        <h3 class='assistive-text'><?php _e( 'Main menu', 'fsesu' ); ?></h3>
        <?php 
        /** 
         * Allow screen readers / text browsers to skip the navigation menu 
         * and get right to the good stuff.
         */ 
        ?>
        <div class='skip-link'>
          <a class='assistive-text' 
            href="#content" 
            title="<?php esc_attr_e( 'Skip to main content', 'fsesu' ); ?>">
            <?php _e( 'Skip to main content', 'fsesu' ); ?>
          </a>
        </div><!-- .skip-link -->
        <div class='skip-link'>
          <a class='assistive-text' 
            href="#secondary" 
            title="<?php esc_attr_e( 'Skip to secondary content', 'fsesu' ); ?>">
            <?php _e( 'Skip to secondary content', 'fsesu' ); ?>
          </a>
        </div><!-- .skip-link -->
        <div id="page-nav">
          <?php 
            /**
             * Our navigation menu.  If one isn't filled out, wp_nav_menu falls 
             * back to wp_page_menu. The menu assiged to the primary position is 
             * the one used. If none is assigned, the menu with the lowest ID is 
             * used.
             */ 
            wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); 
          ?>
          <nav id='login_links'>
            <ul>
              <li><?php if ( is_user_logged_in() ) { ?> <?php wp_register('', ''); ?></li>
              <li><?php } ?> <?php wp_loginout(); ?></li>
            </ul>
          </nav>
        </div><!-- #main-menu -->
      </nav><!-- #primary-navigation -->
    </header><!-- #header -->
  
  
    <section id='content' role='main'>