<?php
/**
 * The template for displaying a "No posts found" message
 *
 * @package			WordPress
 * @subpackage 	    FreeSpiritESU
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    13 August 2014
 */
?>
				
				<article id='page-none' itemscope itemtype='http://schema.org/BlogPosting'>
					
					<header class='page-header' itemprop='headline'>
						<h1 class='page-title'><?php _e( 'Nothing Found', 'twentyfourteen' ); ?></h1>
					</header>
					
					<section class='page-content'>
						<?php if ( is_home() && current_user_can( 'publish_posts' ) ) : ?>
						
						<p><?php printf( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'twentyfourteen' ), admin_url( 'post-new.php' ) ); ?></p>
					
						<?php elseif ( is_search() ) : ?>
						
						<p><?php _e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'twentyfourteen' ); ?></p>
						<?php get_search_form(); ?>
						
						<?php else : ?>
						
						<p><?php _e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'twentyfourteen' ); ?></p>
						<?php get_search_form(); ?>
						
						<?php endif; ?>
					</section><!-- .page-content -->
				</article><!-- #page-none -->
				