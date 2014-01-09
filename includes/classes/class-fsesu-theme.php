<?php
/**
 * FreeSpirit Master theme class.
 * 
 * This file is what powers the entire theme. It sets theme constants;
 * initializes theme options; adds theme support for thumbnails, menus,
 * and post formats; initializes shortcodes; enables the custom background;
 * sets up admin area additions & modifications; handles SEO and meta tags;
 * tweaks the comment form; and a lot of other stuff.
 * 
 * This file is required by functions.php.
 * 
 * @package        FreeSpiritESU
 * @subpackage     Classes
 * @author         Richard Perry <http://www.perry-online.me.uk/>
 * @copyright      Copyright (c) 2013 FreeSpirit ESU
 * @license        http://www.gnu.org/licenses/gpl-3.0.html
 * @since          3.0.0
 * @version        3.0.0
 * @modifiedby     Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified   08 January 2014
 *
 * @todo           ToDo List
 *                  -  
 * 
 */

class FSESU_Theme {
	
	/**
	 * Initialise the class and hook the various functions into WordPress.
	 * 
	 * @return    void
	 * @since     3.0.0
	 */
	public function __construct() {
	    // Actions to be dealt with immediately after theme setup
		add_action( 'after_setup_theme', array( $this, 'constants' ) );
        add_action( 'after_setup_theme', array( $this, 'theme_support' ) );
        add_action( 'after_setup_theme', array( $this, 'menus' ) );
        add_action( 'after_setup_theme', array( $this, 'sidebars' ) );
        
        // Script and stylesheet actions
        add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'styles' ) );
        
        // Content filters
        add_filter( 'excerpt_length', array( $this, 'excerpt_length' ), 9999 );
        add_filter( 'excerpt_more', array( $this, 'fsesu_excerpt_more' ) );
        add_filter( 'the_content', array( $this, 'fsesu_unautop_4_img' ), 999 );
        
        // Various head tag actions
        add_action( 'wp_head', array( $this, 'favicon' ) );
        remove_action('wp_head', 'rsd_link');
        remove_action('wp_head', 'wlwmanifest_link');
        remove_action('wp_head', 'wp_generator');
	}
	
	
	
	
	/**
     * Define theme constants.
     *
     * Defines the constant paths for use within the theme and child theme.  
	 * Constants prefixed with 'FSESU_' are for use only within the core framework 
	 * and don't reference other areas of the parent or child theme.
     * 
     * @return      void
	 * 
	 * @uses        FSESU_VERSION
	 * @uses        THEME_URI
	 * @uses        THEME_DIR
	 * @uses        FSESU_ASSETS
	 * @uses        FSESU_LIB
     * 
     * @since       3.0.0
     */
	public function constants() {
	    
	    define( 'FSESU_VERSION',        '3.0.0' );
        if ( ! defined( 'THEME_VERSION' ) )
                define( 'THEME_VERSION',    FSESU_VERSION );
                
    	if ( ! defined( 'THEME_NAME' ) )
		    define( 'THEME_NAME',       'FreeSpirit ESU' );
		
		define( 'THEME_URI',            get_template_directory_uri() );
		define( 'THEME_DIR',            get_template_directory() );
		
		define( 'CHILD_THEME_URI',      get_stylesheet_directory_uri() );
		define( 'CHILD_THEME_DIR',      get_stylesheet_directory() );
		
		define( 'FSESU_ASSETS',         THEME_URI . '/assets' );
        define( 'FSESU_STYLES',         FSESU_ASSETS . '/css' );
        define( 'FSESU_SCRIPTS',        FSESU_ASSETS . '/js' );
        
		define( 'FSESU_LIB',            THEME_DIR . '/includes' );
		define( 'FSESU_CLASSES',        FSESU_LIB . '/classes' );
        define( 'FSESU_FUNCTIONS',      FSESU_LIB . '/functions' );
        define( 'FSESU_EXTENSIONS_URI', THEME_URI . '/includes/extensions' );
        
        define( 'FSESU_TEXT_DOMAIN',    'fsesu' );
	}
	
	
	
	
	/**
	 * Defines the various items that the theme supports.
	 * 
	 * @return      void
     * @since       3.0.0
	 */ 
	public function theme_support() {
	    
	    add_theme_support( 'post-thumbnails' );
		add_theme_support( 'menus' );
		add_theme_support( 'editor-style' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-formats', array( 
		    'aside', 
		    'gallery', 
		    'link', 
		    'image', 
		    'status', 
		    'video' ) );
	}
	
	
	
	
	/**
	 * Register the navigation menus for use across the site.
	 * 
	 * @return      void
     * @since       3.0.0
	 */ 
	public function menus() {
	
    	// Register the menus for the theme
    	register_nav_menus(
    		array(
    		  'main-menu' => __( 'Main Menu' ),
    		  'footer-menu' => __( 'Footer Menu' )
    		)
    	);
	}
	
	
	
	
	/**
	 * Register the sidebars/widget areas for use across the site.
	 * 
	 * @return      void
     * 
     * @since       3.0.0
	 */ 
	public function sidebars() {
	
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
	
	
	
	
	/**
	 * Register & queue the theme scripts.
	 * 
	 * Registers the javascripts that are needed by the theme and then enqueues 
	 * them as necessary. This includes the HTML5 Shiv script by Alexander Farkas 
	 * (https://github.com/aFarkas) and hosted at Google Code which is enqueued
	 * if the browser is IE.
	 * 
	 * @return      void
	 * 
	 * @uses        is_IE
	 * @uses        FSESU_SCRIPTS
     *
     * @since       3.0.0
	 */ 
	public function scripts() {
	    
	    global $is_IE;
	    
	    // Check if the browser if IE, and if so, enqueue the html5shiv script
	    if ( $is_IE ) {
	        wp_register_script( 'html5shiv', 'http://html5shiv.googlecode.com/svn/trunk/html5.js');
	        wp_enqueue_script( 'html5shiv' );
	    }
	    
	    wp_register_script( 'fsesu-menu', FSESU_SCRIPTS . '/menu.js', array( 'jquery' ) );
	    
	    wp_enqueue_script( 'fsesu-menu' );
	
	}
	
	
	
	
	/**
	 * Register & queue the theme stylesheets.
	 * 
	 * Registers the styles that are required by the theme, including the 
	 * normalize.css file by Nicolas Gallagher (http://nicolasgallagher.com/) 
	 * and the Google WebFonts that this theme uses (Lato). The styles are then
	 * enqueued, a check carried out for a child theme, and if one exists,
	 * including the child theme style last.
	 * 
	 * @return      void
	 * 
	 * @uses        FSESU_VERSION
	 * @uses        FSESU_STYLES
	 * @uses        CHILD_THEME_DIR
     * 
     * @since       3.0.0
	 */ 
	public function styles() {
	    
	    if ( ! is_admin() ) {

            wp_register_style( 'normalize', FSESU_STYLES . '/normalize/normalize.css', null, FSESU_VERSION );
            wp_register_style( 'google-fonts', 'http://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic', array( 'normalize' ), FSESU_VERSION );
            wp_register_style( 'fsesu-main', FSESU_STYLES . '/main.min.css', array( 'google-fonts' ), FSESU_VERSION );
            wp_register_style( 'fsesu-wordpress', FSESU_STYLES . '/wordpress.min.css', array( 'fsesu-main' ), FSESU_VERSION );
            wp_enqueue_style( 'fsesu-wordpress' );
                
            /*
             * Load child theme stylesheets after fsesu to override fsesu 
             * defaults (with thanks to Alison Barrett (http://alisothegeek.com/) 
             * for the code snippet from her Bolts theme
             */
            if ( file_exists( CHILD_THEME_DIR . '/style.css' ) ) {
                /* Compare child style.css to parent style.css, if they're the same, fsesu is active theme (not parent) */
                /* and there's no need to load the stylesheet again */
                if ( md5( CHILD_THEME_DIR . '/style.css' ) !== md5_file( THEME_DIR . '/style.css' ) ) {
                    wp_register_style( 'fsesu-child-theme', CHILD_THEME_URI . '/style.css', array( 'fsesu-wordpress' ), THEME_VERSION );
                    wp_enqueue_style( 'fsesu-child-theme' );
                }
            }
            
        }
	
	}
	
	
	
	
	/**
	 * Add the standard categories that will be used by the site.
	 * 
	 * This function uses the wp_insert_term function to add new categories to 
	 * the standard category taxonomy (n.b. it cannot be used to add new terms to 
	 * custom taxonomies)
	 * 
	 * Usage: 
	 * 
	 *     $categories = array(
     *         array (
     *             'term' => 'Cat 1 Name',
     *             'args' => 
     *                 array(
     *                     'description' => 'Cat 1 Description',
     *                     'slug' => 'cat1_slug',
     *                     'parent' => get_cat_ID('parent')
     *                 )
     *         ),
     *         array (
     *             'term' => 'Cat 2 Name',
     *             'args' => 
     *                 array(
     *                     'description' => 'Cat 2 Description',
     *                     'slug' => 'cat1_slug'
     *                 )
     *         )
     *     );
     *     $fsesu->categories( $categories );
     * 
	 * 
	 * @param       array   $categories array containing category details.
	 * @return      void
	 * 
	 * @since       3.0.0
	 */
	public function categories( $categories ) {
	    /*
         * Breakdown the categories array into individual category arrays
         * then check there is not already a category by that name and 
         * insert the new category if required
         */
        foreach ( $categories as $category ) {
            if ( !get_cat_ID( $category['term'] ) ) {
                wp_insert_term( $category['term'], 'category', $category['args'] ); 
            }
        }
	}
	
	
	
	
	/**
	 * Add the FreeSpirit ESU Favicon to the site.
	 * 
	 * @return      string
	 * 
	 * @uses        CHILD_THEME_URI
	 * @uses        THEME_URI
	 * 
	 * @since       3.0.0
	 */
    public function favicon() {
        /*
         * Check if a child theme favicon exists and if so, use that, else use
         * the parent theme favicon
         */
        if ( file_exists( CHILD_THEME_URI . '/favicon.ico' ) ) {
            echo '<link rel="shortcut icon" type="image/x-icon" href="' . CHILD_THEME_URI . '/favicon.ico" />' . "\n";
        } else {
            echo '<link rel="shortcut icon" type="image/x-icon" href="' . THEME_URI . '/favicon.ico" />' . "\n";
        }
    }
    
    
    
    
    /**
     * Change the default excerpt length so post summaries are more readable.
     * 
     * @param       int     $length number of words to include in the excerpt.
     * @return      int             number of words to include in the excerpt.
     * 
     * @since       3.0.0
     */
    public function excerpt_length( $length ) {
        return 100;
    }
    
    
    
    
    /**
     * Change the [...] to a Read More link.
     * 
     * @param       string  $more   the existing 'read more' text.
     * @return      string          the new 'read more' output.
     * 
     * @since       3.0.0
     */
    public function excerpt_more( $more ) {
        global $post;
        return '<a href="'. get_permalink($post->ID) . '">Read more...</a>';
    }
    
    
    
    
    /**
     * Remove the automatic paragraph wrapper around images.
     * 
     * @param       string  $content    All post content for filtering.
     * @return      string  $content    Filtered post content.
     * 
     * @since       3.0.0
     */
    public function unautop_for_img( $content ) {
        $content = preg_replace(
            '/<p>\\s*?(<a rel=\"attachment.*?><img.*?><\\/a>|<img.*?>)?\\s*<\\/p>/s',
            '<figure>$1</figure>',
            $content
        );
        return $content;
    }
	
}
