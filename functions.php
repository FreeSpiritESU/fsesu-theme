<?php
/**
 * functions.php    The default functions file for the FreeSpirit ESU Wordpress Theme
 * 
 * This file is the main part of the FreeSpirit ESU Wordpress Theme functions. It is
 * home to the main functions necessary for the theme to work correctly.
 *  
 * @package         FreeSpiritESU
 * @subpackage      Functions
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    07 August 2014
 */
 
 if ( ! isset( $content_width ) ) $content_width = 550;
 

 /**
 * FreeSpiritESU setup.
 *
 * Revise theme defaults and support registered in Twenty Fourteen.
 *
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_setup() {

	/*
	 * Make FreeSpiritESU available for translation.
	 *
	 * Translations can be added to the /languages/ directory.
	 */
	load_child_theme_textdomain( 'fsesu', get_stylesheet_directory() . '/languages' );

	
	// Remove the unnecessary menu registered by Twentyfourteen
	unregister_nav_menu( 'secondary' );
	
	// Register a menu for use in the footer
	register_nav_menus( array(
		'footer'    => __( 'Footer menu', 'fsesu' )
	) );
	
	// This will remove support for featured content, custom backgrounds & headers
    remove_theme_support( 'featured-content' );
    remove_theme_support( 'custom-background' );
    
    // Add back slightly revised custom header support
    add_theme_support( 'custom-header', array(
		'default-image'          => get_stylesheet_directory_uri() . '/assets/images/brandimages/main-explorers.png',
	    'random-default'         => false,
		'width'                  => 960,
		'height'                 => 180,
		'flex-height'            => true,
		'flex-width'             => true,
		'default-text-color'     => 'f00',
		'wp-head-callback'       => 'twentyfourteen_header_style',
		'admin-head-callback'    => 'twentyfourteen_admin_header_style',
		'admin-preview-callback' => 'twentyfourteen_admin_header_image'
	) );
	
	// Change post format support within the theme
	add_theme_support( 'post-formats', array( 'gallery', 'image', 'status', 'vide' ) );
}
add_action( 'after_setup_theme', 'fsesu_setup', 99 );



/**
 * Use the custom header as a background to the page header element
 * 
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_header() {
    if ( get_header_image() ) :
?> 
    <style type="text/css">
        #masthead {
            background: url('<?php header_image(); ?>') center top;
        }
    </style>
<?php
	endif;
}
add_action( 'wp_head', 'fsesu_header', 99 );




/**
 * Load Font Awesome & custom javascripts
 * 
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_enqueue() {
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css' );
	wp_enqueue_script( 'fsesu-functions', get_stylesheet_directory_uri() . '/assets/js/functions.js' );
}
add_action( 'wp_enqueue_scripts', 'fsesu_enqueue', 99 );




/**
 * Remove one of the unnecessary Twenty Fourteen widget areas.
 *
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_remove_widgets() {
	unregister_sidebar( 'sidebar-2' );
}
add_action( 'widgets_init', 'fsesu_remove_widgets', 99 );




/**
 * Adjust the content for the status post format to include the date & link to post
 * 
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_status_infinity( $content ) {

	if ( has_post_format( 'status' ) && !is_singular() ) {
		
		$date = '<span class="entry-meta"><span class="entry-date">';
		$date .= sprintf( '<a href="%1$s" rel="bookmark" title="%2$s"><time class="entry-date" datetime="%3$s" itemprop="datePublished">%4$s</time></a>',
			esc_url( get_permalink() ),
			get_the_title(),
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date() )
		);
		$date .= '</span></span> ';
		
		$infinity = sprintf( ' <a href="%1$s" title="%2$s" class="infinity" rel="bookmark" itemprop="url">&infin;</a>',
			esc_url( get_permalink() ),
				get_the_title()
		);
		$content = $date . $content . $infinity;
	}

	return $content;
}
add_filter( 'the_content', 'fsesu_status_infinity', 9 ); // run before wpautop




function fsesu_excerpt_length( $length ) {
	return 120;
}
add_filter( 'excerpt_length', 'fsesu_excerpt_length', 99 );





function fsesu_excerpt_more( $more ) {
	return ' &hellip; <div class="read-more"><a href="'. get_permalink( get_the_ID() ) . '">' . __('Read More', 'fsesu') . '  <i class="fa fa-chevron-right"></i></a></div>';
}
add_filter( 'excerpt_more', 'fsesu_excerpt_more' );





/**
 * Display an optional post thumbnail.
 *
 * Wraps the post thumbnail in a div, and if on an archive page it also wraps it
 * in an anchor. Also checks what size thumbnail to get depending on whether the
 * post is being viewed from a mobile device or not
 *
 * @since FreeSpiritESU 3.0.0
 */
function fsesu_post_thumbnail() {
	if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
		return;
	}
	
	$before = '<div class="post-thumbnail">';
	$after = '';
	
	if ( ! is_singular() ) :
        $before .= '<a class="post-thumbnail" href="' . get_the_permalink() . '">';
        $after = '</a>';
    endif;
    
    if ( wp_is_mobile() ) :
	    $thumb = get_the_post_thumbnail( get_the_ID(), ' medium' );
	else :
	    $thumb = get_the_post_thumbnail( get_the_ID(), 'large' );
	endif;
	
	$after .= '</div>';
    echo $before . $thumb . $after;
}




/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since FreeSpiritESU 3.0.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 */
function fsesu_paging_navigation() {
	global $wp_query;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	// Set up paginated links.
	$links = paginate_links( array(
		'show_all'  => true,
		'prev_text' => __( ' Previous', 'fsesu' ),
		'next_text' => __( 'Next ', 'fsesu' ),
	) );

	if ( $links ) :

	?>
	<nav class='navigation paging-navigation' role='navigation'>
		<h1 class='screen-reader-text'><?php _e( 'Posts navigation', 'fsesu' ); ?></h1>
		<div class='pagination loop-pagination'>
			<?php echo $links; ?>
		</div><!-- .pagination -->
	</nav><!-- .navigation -->
	<?php
	endif;
}




/**
 * Simple function to return a link to the hosting company
 * 
 * @since FreeSpiritESU 3.0.0
 * 
 * @param   string  $name   Name of the hosting company
 * @param   string  $link   Link to the hosting company
 * @return  string          The collated hosting credit string
 */
function fsesu_hosting( $name, $link ) {
    return "Hosted by <a href='$link' title='$name' target='_blank'>$name</a>";
}




/**
 * Simple function to display the copyright details & hosting string
 * 
 * @since FreeSpiritESU 3.0.0
 * 
 * @param   string  $first_year First year of copyright of the site
 * @param   string  $owner      Name of the site owner/copyright holder
 * @return  string              The collated copyright & hosting string
 */
function fsesu_credits( $first_year, $owner ) {
    $copyright = '&copy; ' . $first_year;
    $current_year = date('Y');
    if($first_year != $current_year) {
        $copyright .= ' - ' . $current_year;
    }
    $copyright .= ' ' . $owner;
    
    echo "$copyright  &nbsp; | &nbsp; " . 
        fsesu_hosting( 'Webtree Authoring Ltd', 'http://www.webtreeauthoring.com/' );
}
add_action( 'fsesu_credits','fsesu_credits', 10, 2 );


/* Disable Admin Bar for everyone
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
add_action('init','df_disable_admin_bar'); */