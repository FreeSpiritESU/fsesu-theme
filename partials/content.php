<?php
/**
 * The default template for displaying content
 *
 * Used for both single and index/archive/search.
 *
 * @package			WordPress
 * @subpackage 	    FreeSpiritESU
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    11 August 2014
 */
?>
				
				<article id='post-<?php the_ID(); ?>' <?php post_class(); ?>  itemscope itemtype='http://schema.org/BlogPosting'>
					
					<?php fsesu_post_thumbnail(); ?>
					
					<header class='entry-header' itemprop='headline'>
					<?php
						if ( is_single() ) :
							the_title( '<h1 class="entry-title" itemprop="headline">', '</h1>' );
						else :
							the_title( '<h1 class="entry-title" itemprop="headline"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark" itemprop="url">', '</a></h1>' );
						endif;
					?>
						<div class="entry-meta">
						<?php if ( get_post_format() ) : ?>
							<span class="post-format">
								<a class="entry-format" href="<?php echo esc_url( get_post_format_link( get_post_format() ) ); ?>"><?php echo get_post_format_string( get_post_format() ); ?></a>
							</span>
						<?php 
							endif;
							twentyfourteen_posted_on(); 
							echo '<span class="category-links">' . get_the_category_list( __( ', ', 'fsesu' ) ) . '</span>';
							
							if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) :
						?>
							<span class="comments-link"><?php comments_popup_link( __( 'Leave a comment', 'fsesu' ), __( '1 Comment', 'fsesu' ), __( '% Comments', 'fsesu' ) ); ?></span>
						<?php endif; ?>
				
						<?php edit_post_link( __( 'Edit', 'fsesu' ), '<span class="edit-link">', '</span>' ); ?>
						</div><!-- .entry-meta -->
					</header><!-- .entry-header -->
				
					<?php if ( is_search() ) : ?>
					<section class='entry-summary' itemprop='articleBody'>
						<?php the_excerpt(); ?>
					</section><!-- .entry-summary -->
					<?php else : ?>
					<section class='entry-content' itemprop='articleBody'>
						<?php the_content( __( 'Continue reading <span class="meta-nav">&rarr;</span>', 'fsesu' ) ); ?>
					</section><!-- .entry-content -->
					<?php endif; ?>
					
					<footer class='entry-meta'>
					<?php 
						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fsesu' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
						the_tags( '<span class="tag-links">', '', '</span>' ); 
					?>
					</footer>
				</article><!-- #post-## -->
