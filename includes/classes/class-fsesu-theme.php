<?php
/**
 * FreeSpirit Master theme class
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
 * @lastmodified   19 December 2013
 *
 * @todo           ToDo List
 *                  -  
 * 
 */

class FSESU_Theme {
	
	/**
	 * Construct
	 * 
	 * 
	 * 
	 * @param     void
	 * @return    void
	 * 
	 * @access    public
	 * @since     3.0.0
	 */
	public function __construct() {
	
		add_action( 'init', array( $this, 'constants' ) );
        add_action( 'init', array( $this, 'theme_support' ) );
        add_action( 'init', array( $this, 'styles' ) );
        
        add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
                
	} 
	
	
	/**
     * constants
     *
     * Defines the constant paths for use within the theme and child theme.  
	 * Constants prefixed with 'FSESU_' are for use only within the core framework and don't 
	 * reference other areas of the parent or child theme.
     *
     * @param       void
     * @return      void
	 * 
	 * @uses        FSESU_VERSION
	 * @uses        THEME_URI
	 * @uses        THEME_DIR
	 * @uses        FSESU_ASSETS
	 * @uses        FSESU_LIB
     *
     * @access      public
     * @since       3.0.0
     */
	function constants() {
	    
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
	 * Theme Support
	 * 
	 * Defines the various items that the theme supports
	 * 
	 * @param       void
	 * @return      void
     *
     * @access      public
     * @since       3.0.0
	 */ 
	function theme_support() {
	    
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
	 * Styles
	 * 
	 * Defines the various items that the theme supports
	 * 
	 * @param       void
	 * @return      void
	 * 
	 * @uses        FSESU_VERSION
	 * @uses        FSESU_STYLES
	 * @uses        CHILD_THEME_DIR
     *
     * @access      public
     * @since       3.0.0
	 */ 
	function styles() {
	    
	    if ( ! is_admin() ) {

            wp_register_style( 'fsesu-reset', FSESU_STYLES . '/reset.css', null, FSESU_VERSION );
            wp_register_style( 'fsesu-h5bp', FSESU_STYLES . '/h5bp.css', array( 'fsesu-h5bp' ), FSESU_VERSION );
            wp_register_style( 'fsesu-main', FSESU_STYLES . '/main.css', array( 'fsesu-reset' ), FSESU_VERSION );
            wp_register_style( 'fsesu-wordpress', FSESU_STYLES . '/wordpress.css', array( 'fsesu-main' ), FSESU_VERSION );
            wp_enqueue_style( 'fsesu-wordpress' );
                
            /**
             * Load child theme stylesheets after fsesu to override fsesu defaults
             * (with thanks to Alison Barrett (http://alisothegeek.com/) for the code snippet from
             * her Bolts theme
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
     *  Change the [...] to a Read More link
     */
    function excerpt_more( $more ) {
        global $post;
        return '<a href="'. get_permalink($post->ID) . '">Read more...</a>';
    }
	
	
}
