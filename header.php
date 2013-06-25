<?php
/* SVN FILE: $Id$ */
/**
 *  The Header for our theme.
 *
 *  Displays all of the <head> section and everything up till <div id="main">
 *
 *  @package        FreeSpiritESU
 *  @subpackage     Header
 *  @copyright      FreeSpirit ESU <http://www.freespiritesu.org.uk/> 2011 
 *  @author         Richard Perry <http: //www.perry-online.me.uk/>
 *  @since          Release 0.1.0
 *  @version        $Rev$
 * 	@modifiedby    	$LastChangedBy$
 * 	@lastmodified  	$Date$
 *
 *  @todo           ToDo List
 *                  - 
 */
?>
<!DOCTYPE html>
<!-- paulirish.com/2008/conditional-stylesheets-vs-css-hacks-answer-neither/ -->
<!-- Consider specifying the language of your content by adding the `lang` attribute to <html> -->
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" <?php language_attributes(); ?>> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" <?php language_attributes(); ?>> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" <?php language_attributes(); ?>> <!--<![endif]-->
<head profile='http://gmpg.org/xfn/11'>
    <meta charset='utf-8'>
    <title><?php bloginfo('name'); ?> | <?php is_home() ? bloginfo('description') : wp_title(''); ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>">
    
    <!-- Mobile viewport optimized: h5bp.com/viewport -->
    <meta name="viewport" content="width=device-width">
    
    <link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="stylesheet" href="<?php bloginfo('stylesheet_url'); ?>" type="text/css" media="screen" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php bloginfo('rss2_url'); ?>" />
    <link rel="alternate" type="text/xml" title="RSS .92" href="<?php bloginfo('rss_url'); ?>" />
    <link rel="alternate" type="application/atom+xml" title="Atom 0.3" href="<?php bloginfo('atom_url'); ?>" />
    
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />
    
    <link rel="icon" href="<?php echo bloginfo('stylesheet_directory'); ?>/images/favicon.ico" />
    <link rel="shortcut icon" href="<?php echo bloginfo('stylesheet_directory'); ?>/images/favicon.ico" />
    
    <link rel="stylesheet" href="print.css" type="text/css" media="print" />

    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/modernizr-2.5.3.min.js"></script>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery-1.7.2.min.js"><\/script>')</script>
    <script src="<?php echo get_stylesheet_directory_uri(); ?>/js/menu.js"></script>
    <?php 
    if ( is_singular() && get_option( 'thread_comments' ) ) 
        wp_enqueue_script( 'comment-reply' ); 
    
    wp_head(); 
    ?>
</head>

<body <?php body_class(); ?>>
<div id='wrapper' class='hfeed'>
	<header id='header' role='banner'>
		<hgroup id='masthead'>
			<div id='branding'>
			  <h1 id='site-title'>
			      <a href='<?php echo esc_url( home_url( '/' ) ); ?>' 
			          title='<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>' 
			          rel='home'><?php bloginfo( 'name' ); ?>
		          </a>
	          </h1>
			  <span id='breadcrumb'><?php fsesu_breadcrumb(); ?></span>
			</div><!-- #branding -->

			<nav id="access" role="navigation">
				<h3 class="assistive-text"><?php _e( 'Main menu', 'fsesu' ); ?></h3>
				<?php 
	            /** 
	             * Allow screen readers / text browsers to skip the navigation menu 
	             * and get right to the good stuff.
	             */ 
	            ?>
				<div class="skip-link">
	                <a class="assistive-text" 
	                    href="#content" 
	                    title="<?php esc_attr_e( 'Skip to main content', 'fsesu' ); ?>">
	                    <?php _e( 'Skip to main content', 'fsesu' ); ?>
	                </a>
	            </div><!-- .skip-link -->
				<div class="skip-link">
	                <a class="assistive-text" 
	                    href="#secondary" 
	                    title="<?php esc_attr_e( 'Skip to secondary content', 'fsesu' ); ?>">
	                    <?php _e( 'Skip to secondary content', 'fsesu' ); ?>
	                </a>
	            </div><!-- .skip-link -->
				<?php 
	                /**
	                 * Our navigation menu.  If one isn't filled out, wp_nav_menu falls 
	                 * back to wp_page_menu. The menu assiged to the primary position is 
	                 * the one used. If none is assigned, the menu with the lowest ID is 
	                 * used.
	                 */ 
	                wp_nav_menu( array( 'theme_location' => 'main-menu' ) ); 
	            ?>
	            <nav id="login_links">
	                
	                    <ul>
	                        <li><?php if ( is_user_logged_in() ) { ?> <?php wp_register('', ''); ?></li>
	                        <li><?php } ?> <?php wp_loginout(); ?></li>
	                    </ul>
                    
                </nav>
			</nav><!-- #access -->
		</hgroup><!-- #masthead -->
	</header><!-- #header -->


	<div id="main">