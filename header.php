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
 * @lastmodified    09 January 2014
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	
    <meta name="description" content="<?php bloginfo('description'); ?>">
    
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id='wrapper' class='hfeed'>
	<header id='header-container' role='banner'>
		<hgroup id='header'>
			<div id='branding'>
			  <h1 id='site-title'>
			      <a href='<?php echo esc_url( home_url( '/' ) ); ?>' 
			          title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' 
			          rel='home'><?php bloginfo( 'name' ); ?>
		          </a>
	          </h1>
			  <span id='site-breadcrumb'><?php $fsesu->breadcrumb(); ?></span>
			</div><!-- #branding -->

			<nav id='navigation' role='navigation'>
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
	            <div id='page-nav'>
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
                </div>
			</nav><!-- #access -->
		</hgroup><!-- #header -->
	</header><!-- #header-container -->


	<section id='container'>