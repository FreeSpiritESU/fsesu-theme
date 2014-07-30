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
 * @copyright      Copyright (c) 2014 FreeSpirit ESU
 * @license        http://www.gnu.org/licenses/gpl-3.0.html
 * @since          3.0.0
 * @version        3.0.0
 * @modifiedby     Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified   30 July 2014
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
        add_filter( 'excerpt_more', array( $this, 'excerpt_more' ) );
        add_filter( 'the_content', array( $this, 'unautop_for_img' ), 999 );
        add_filter( 'wp_title', array( $this, 'title' ), 10, 3 );
        
        // Add actions for use in the theme
        add_action( 'content_navigation', array( $this, 'content_navigation' ), 10, 2 );
        add_action( 'entry_meta', array( $this, 'entry_meta' ) );
        add_action( 'breadcrumb', array( $this, 'breadcrumb' ) );
        
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
      
      // Check if the browser is IE, and if so, enqueue the html5shiv script
      if ( $is_IE ) {
          wp_register_script( 'modernizer', FSESU_SCRIPTS . '/vendor/modernizer-2.6.2-respond-1.1.0.min.js');
          wp_enqueue_script( 'modernizer' );
      }
      
      wp_register_script( 'slicknav', FSESU_SCRIPTS . '/vendor/jquery.slicknav.min.js', array( 'jquery' ) );
      wp_enqueue_script( 'slicknav' );
      wp_register_script( 'fsesu-menu', FSESU_SCRIPTS . '/menu.js', array( 'jquery' ), false, true );
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
    global $wp_scripts;
      
    if ( ! is_admin() ) {
      
      // get the jquery ui object
      $queryui = $wp_scripts->query('jquery-ui-core');
      
      wp_register_style( 'normalize', 'https://raw.githubusercontent.com/necolas/normalize.css/master/normalize.css', null, false );
      wp_register_style( 'jquery-ui', 'http://ajax.googleapis.com/ajax/libs/jqueryui/'.$queryui->ver.'/themes/smoothness/jquery-ui.css', array( 'normalize' ), $queryui->ver );
      wp_register_style( 'font-awesome', '//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css', array( 'jquery-ui'), '4.0.3');
      wp_register_style( 'fsesu-main', FSESU_STYLES . '/main.css', array( 'font-awesome' ), FSESU_VERSION );
      wp_register_style( 'fsesu-wordpress', FSESU_STYLES . '/wordpress.css', array( 'fsesu-main' ), FSESU_VERSION );
      wp_register_style( 'slicknav', FSESU_STYLES . '/vendor/slicknav.css', array( 'fsesu-wordpress' ), false );
      wp_register_style( 'fsesu-media', FSESU_STYLES . '/media.css', array( 'slicknav' ), FSESU_VERSION );
      wp_register_style( 'fsesu-print', FSESU_STYLES . '/print.css', array( 'fsesu-media' ), FSESU_VERSION, 'print' );
      wp_enqueue_style( 'fsesu-print' );
          
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
        return '...
          <footer class="entry-footer">
            <a class="read-more" href="'. 
            get_permalink($post->ID) . 
            '">Read more <i class="fa fa-chevron-right"></i></a>
          </footer>';
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
   * Improve the wp_title output with a filter.
   * 
   * @param       string  $title  The base output of wp_title
   * @param       string  $sep    The separator defined by wp_title
   * @param       string  $seplocation The position of the separator (left or right)
   * @return      string  $title  The filtered and updated title for display
   * 
   * @since       3.0.0
   */
  function title( $title, $sep, $seplocation ) {
      
      global $page, $paged;
        
        // Don't revise the title in feeds.
        if ( is_feed() )
            return $title;
        
        /*
         * If this is the front page of the site then set a specific title 
         * regardless of the selected separator position
         */
        if ( is_home() || is_front_page() )
            $title = get_bloginfo( 'name' ) . $title . " {$sep} " . get_bloginfo( 'description', 'display' );
        
        // For other pages, add the blog name to the correct position
        if ( 'right' == $seplocation )
            $title .= get_bloginfo( 'name' );
        else
            $title = get_bloginfo( 'name' ) . $title;
            
        // Add a page number if necessary
        if ( $paged >= 2 || $page >= 2 )
            $title .= " {$sep} " . sprintf( __( 'Page %s', 'dbt' ), max( $paged, $page ) );
            
        return $title;
        
  }
  
  
  
  
  /**
   * Generate next/previous navigation for use anywhere within the theme
   * 
   * @param       string   nav_id     an ID tag for the navigation element.
   * @return      void
   * 
   * @since     3.0.0
   */
  function content_navigation( $nav_id, $type = 'post' ) {
    ?>
      <nav class="<?php echo $nav_id; ?>">
        <h3 class="assistive-text"><?php echo ucwords($type); ?> navigation</h3>
        <div class="nav-previous alignleft">
          <?php ( $type == 'post' ) ? previous_post_link() : next_posts_link('<i class="fa fa-chevron-left"></i> Older'); ?>
        </div>
        <div class="nav-next alignright">
          <?php ( $type == 'post' ) ? next_post_link() : previous_posts_link('Newer <i class="fa fa-chevron-right"></i>'); ?>
        </div>
      </nav>
    <?php
  }
    
    
    
    
    /**
     * Generate an entry meta data tag for display within the theme
     * 
     * @return      void
     * @since       3.0.0
     */
    function entry_meta() {
      $category_list = "";
      $categories = get_the_category_list( ', ' );
      
      if ( $categories ) {
        $category_list = "
          <span class='entry-categories'><i class='fa fa-folder-open'></i> 
            $categories
          </span>";
      }
        
      printf( '
          <span class="entry-date"><i class="fa fa-clock-o"></i>
            <a href="%1$s" title="%2$s" rel="bookmark">
              <time datetime="%3$s" pubdate>%4$s</time>
            </a> 
          </span>
          <span class="entry-author"><i class="fa fa-user"></i>   
            <span class="author vcard">
              <a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a>
            </span>
          </span>%8$s',
          esc_url( get_permalink() ),
          esc_attr( get_the_time() ),
          esc_attr( get_the_date( 'r' ) ),
          esc_html( get_the_date( 'd M Y' ) ),
          esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
          esc_attr( sprintf( 'View all posts by %s',  get_the_author() ) ),
          get_the_author(),
          $category_list
      );
      edit_post_link( __( 'Edit', 'fsesu' ), '<span class="edit-link"><i class="fa fa-pencil"></i>', '</span>' );
    }
    
    
    
    
    /**
     * Generate the breadcrumb for the page header.
     * 
     * @return      void
     * @since       3.0.0
     */
    function breadcrumb() {
        if ( !is_home() || !is_front_page() ) {
            echo '<a href="';
            echo get_option('home');
            echo '">';
            echo 'Home';
            echo "</a> &gt;&gt; ";
            if (is_category() || is_single()) {
                the_category('title_li=');
                if (is_single()) {
                    echo " &gt;&gt; ";
                    the_title();
                }
            } elseif (is_page()) {
                echo the_title();
            }
        }
    }
    
  
}
