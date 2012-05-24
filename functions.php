<?php
/* SVN FILE: $Id$ */
/**
 *  functions.php 	The default functions file for the FreeSpirit ESU Wordpress Theme
 *  
 *  This file is the main part of the FreeSpirit ESU Wordpress Theme functions. It is
 *  home to the main functions necessary for the theme to work correctly.
 *  
 *  PHP Version 5
 *  
 *  @package        FreeSpiritESU
 *  @subpackage     Functions
 *  @copyright      FreeSpirit ESU <http://www.freespiritesu.org.uk/> 2011 
 *  @author         Richard Perry <http: //www.perry-online.me.uk/>
 *  @since          Release 0.1.0
 *  @version        $Rev$
 * 	@modifiedby    	$LastChangedBy$
 * 	@lastmodified  	$Date$
 *
 *  @todo           ToDo List
 *                  - Create Merchandise Custom Post Type
 *                  - Create Members Custom Post Type
 *                  - Add necessary display functions for the theme
 */
 
/**
 *  GENERAL SETUP FUNCTIONS
 */
 
if ( ! function_exists( 'fsesu_setup' ) ):
/**
 *  Set up theme defaults and registers support for various WordPress features.
 *
 * 	@uses 	add_editor_style() To style the visual editor.
 * 	@uses 	add_theme_support() To add support for post thumbnails, automatic 
 *			feed links, and Post Formats.
 * 	@uses 	register_nav_menus() To add support for navigation menus.
 * 
 *  @since	Release 0.1.1
 */
function fsesu_setup() {

	// This theme styles the visual editor with editor-style.css to match the 
	// theme style.
	add_editor_style();
	
	// Add default posts and comments RSS feed links to <head>.
	add_theme_support( 'automatic-feed-links' );

	// Register the menus for the theme
	register_nav_menus(
		array(
		  'main-menu' => __( 'Main Menu' ),
		  'footer-menu' => __( 'Footer Menu' )
		)
	);

	// Add support for a variety of post formats
	add_theme_support( 'post-formats', 
		array( 
			'aside', 
			'audio', 
			'chat', 
			'gallery', 
			'image', 
			'link', 
			'quote', 
			'status', 
			'video' 
		) 
	);

	// This theme uses Featured Images (also known as post thumbnails) for per-post/per-page Custom Header images
	add_theme_support( 'post-thumbnails' );

}
endif; // fsesu_setup
add_action( 'after_setup_theme', 'fsesu_setup' );

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


/**
 *  Change the default excerpt length so post summaries are more readable
 * 
 *  @param  integer number of words to include in the excerpt
 */
function fsesu_custom_excerpt( $length ) {
    return 100;
}
add_filter( 'excerpt_length', 'fsesu_custom_excerpt', 9999 );

/**
 *  Change the [...] to a Read More link
 */
function fsesu_excerpt_more($more) {
    global $post;
    return '<a href="'. get_permalink($post->ID) . '">Read more...</a>';
}
add_filter('excerpt_more', 'fsesu_excerpt_more');

/**
 *  Add the FreeSpirit ESU Favicon to the site
 */
function fsesu_favicon() {
    echo '<link rel="shortcut icon" type="image/x-icon" href="/favicon.ico" />' . "\n";
}
add_action('wp_head', 'fsesu_favicon');

/**
 *  Change the Wordpress jQuery reference to use the Google CDN jQuery library
 */
function fsesu_jquery_init() {
	if ( !is_admin() ) { 
		wp_deregister_script( 'jquery' ); // unregistered key jQuery
		wp_register_script( 'jquery', 
	       'http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js', 
	       false, '1.4.2'); // register key jQuery with URL of Google CDN
		wp_enqueue_script( 'jquery' ); // include jQuery
	}
}
add_action( 'after_setup_theme', 'fsesu_jquery_init' );


/**
 *  Include the various additional function files
 */
//require_once( get_stylesheet_directory() . '/custom_post_types/events.php' );




/**
 *  ADMIN & LOGIN FUNCTIONS
 */

 
/**
 *  Add the FreeSpirit ESU Logo to the Login Page
 */
function fsesu_login_logo() {
	$style = '<style type="text/css"> h1 a { background: transparent url(' . get_bloginfo('url') . '/favicon.ico) no-repeat 30px center !important; } </style>';
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
 *  FUNCTIONS FOR USE WITHIN THE THEME
 */

/**
 *  Generate next/previous navigation for use anywhere within the theme
 *  
 *  @param	nav_id 		an ID tag for the navigation element
 */
function fsesu_content_nav( $nav_id ) {
	global $wp_query;

	if ( $wp_query->max_num_pages > 1 ) : ?>
		<nav id="<?php echo $nav_id; ?>">
			<h3 class="assistive-text">Post navigation</h3>
			<div class="nav-previous alignleft"><?php next_posts_link( '&larr; Previous post' ); ?></div>
			<div class="nav-next alignright"><?php previous_posts_link( 'Neext post &rarr;' ); ?></div>
		</nav>
	<?php endif;
}

/**
 *  
 */
function fsesu_entry_meta() {
	printf( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author">  by  <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>',
		esc_url( get_permalink() ),
		esc_attr( get_the_time() ),
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
		esc_attr( sprintf( 'View all posts by %s', 	get_the_author() ) ),
		get_the_author()
	);
}