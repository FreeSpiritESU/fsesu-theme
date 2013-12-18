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
 * @lastmodified   18 December 2013
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
	 * @uses      THEME_URI
	 * @uses      THEME_DIR
	 * @uses      
	 * 
	 * @access    public
	 * @since     3.0.0
	 */
	public function __construct() {
		
		if ( ! defined( 'THEME_NAME' ) )
			define( 'THEME_NAME',       'FreeSpirit ESU' );
		
		define( 'THEME_URI',            get_template_directory_uri() );
		define( 'THEME_DIR',            get_template_directory() );
		
		define( 'CHILD_THEME_URI',      get_stylesheet_directory_uri() );
		define( 'CHILD_THEME_DIR',      get_stylesheet_directory() );
		
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
		
		$this->wp_hooks();
	}

	
	
	/**
	 * Add WordPress hooks
	 * 
	 * @param     void
	 * @access    public
	 * @since     3.0.0
	 */
	public function wp_hooks() {
		
		
	}
	
}
