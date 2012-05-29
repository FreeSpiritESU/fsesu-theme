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
<html <?php language_attributes(); ?>>
<head>
    <meta http-equiv="Content-Type" 
        content="<?php bloginfo('html_type'); ?>; 
        charset="<?php bloginfo( 'charset' ); ?>" />
    <title><?php wp_title(''); ?></title>
    <meta name="description" content="<?php bloginfo('description'); ?>">
    
    <link rel="stylesheet" type="text/css" media="screen" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
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
			  <h2 id='site-description'><?php bloginfo( 'description' ); ?></h2>
			</div><!-- #branding -->
		</hgroup><!-- #masthead -->
        
        <?php get_search_form(); ?>

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
		</nav><!-- #access -->
	</header><!-- #header -->


	<div id="main">