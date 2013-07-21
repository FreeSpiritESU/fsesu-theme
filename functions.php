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
 *  @modifiedby    	$LastChangedBy$
 *  @lastmodified  	$Date$
 *
 *  @todo           ToDo List
 *                  - Add necessary display functions for the theme
 */
 
 if ( ! isset( $content_width ) ) $content_width = 550;
 
/**
 *  Include other function files
 */
 
require_once locate_template('/inc/util.php');            // Utility functions
require_once locate_template('/inc/admin.php');           // Admin & login 
require_once locate_template('/inc/widgets.php');         // Sidebars and widgets
require_once locate_template('/inc/shortcodes.php');      // Shortcodes

 
 
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
    
    // Add the standard categories that will be used on the FreeSpirit Website
    fsesu_new_category( 
        array(
            'cat_name' => 'Camp Diaries',
            'category_description' => "Everytime we participate in a major camp, or jamboree, as a 
                group, we will be keeping everyone informed of how we are getting on through our camp 
                diary. These diaries will be posted here, and pictures will generally be found on our 
                Gallery.",
            'category_nicename' => 'campdiaries'
        )
    );
    fsesu_new_category( 
        array(
            'cat_name' => 'News',
            'category_description' => "News about what is happening in our Unit",
            'category_nicename' => 'news'
        )
    );
    fsesu_new_category( 
        array(
            'cat_name' => 'What\'s New',
            'category_description' => "Quick updates about new things on the website, as well as 
                quick notices for the Unit",
            'category_nicename' => 'whatsnew',
            'category_parent' => get_cat_ID('news') 
        )
    );
    fsesu_new_category( 
        array(
            'cat_name' => 'Unit Supporters',
            'category_description' => "Over the years the Unit has received support from a lot of 
                people, and we thought it was about time they got a mention on our site.",
            'category_nicename' => 'supporters'
        )
    );
    fsesu_new_category( 
        array(
            'cat_name' => 'International Opportunities',
            'category_description' => "<p>A selection of International Opportunities organised 
                   through Scouting that are available for you. If you are intereseted in any of  
                   them, get in touch with the organisers. We will help you with whatever you 
                   need.</p>
                   <p>For information about many many more international opportunities, please 
                   visit the International Page at Scouts.org.uk 
                   <a href='http://scouts.org.uk/international' title='International'>
                   http://scouts.org.uk/international</a>.</p>",
            'category_nicename' => 'intopps'
        )
    );
    fsesu_new_category( 
        array(
            'cat_name' => 'Merchandise',
            'category_description' => "A selection of Unit branded merchandise is available to 
                buy. Please complete the form below and submit to the FreeSpirit Leadership 
                team with a cheque and we will try to get the goods to you as soon as possible.",
            'category_nicename' => 'merchandise'
        )
    );
    fsesu_new_category( 
        array(
            'cat_name' => 'Press Cuttings/Awards',
            'category_description' => "Since the Unit started up in 2003, we have been collecting
                various press cuttings, awards and certificates, so here they are.",
            'category_nicename' => 'presscuttings'
        )
    );
}
endif; // fsesu_setup
add_action( 'after_setup_theme', 'fsesu_setup' );


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
 * Remove the automatic paragraph wrapper around images
 */
function fsesu_unautop_4_img( $content ) {
    $content = preg_replace(
        '/<p>\\s*?(<a rel=\"attachment.*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s',
        '<figure>$1</figure>',
        $content
    );
    return $content;
}
add_filter( 'the_content', 'fsesu_unautop_4_img', 999 );


// Clean up the <head>
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'wp_generator');

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

