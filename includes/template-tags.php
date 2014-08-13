<?php
/**
 * Custom template tags for the FreeSpiritESU theme
 *  
 * @package         FreeSpiritESU
 * @subpackage      Functions
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    13 August 2014
 */
 
 
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