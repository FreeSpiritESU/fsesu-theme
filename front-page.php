<?php
/**
 * The front page template.
 *
 * @package 	   WordPress
 * @subpackage 	   FreeSpiritESU
 * @author         Richard Perry <http://www.perry-online.me.uk/>
 * @copyright      Copyright (c) 2014 FreeSpirit ESU
 * @license        http://www.gnu.org/licenses/gpl-3.0.html
 * @since          3.0.0
 * @version        3.0.0
 * @modifiedby     Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified   13 August 2014
 */

get_header(); ?>

			<section id='main-content' class='site-content'  role='main' itemscope itemtype='http://schema.org/Blog'>
			<?php while ( have_posts() ) : the_post(); ?>
					
				<article id='page-<?php the_ID(); ?>' <?php post_class(); ?>  itemscope itemtype='http://schema.org/Article'>
					
					<section class='page-content'  itemprop='articleBody'>
						<?php the_content(); ?>
					</section><!-- .page-content -->
					
					<footer class='entry-meta'>
					<?php edit_post_link( __( 'Edit', 'fsesu' ), '<span class="edit-link">', '</span>' ); ?>
					</footer><!-- .entry-footer -->
				</article><!-- #page-<?php the_ID(); ?> -->
				
			<?php endwhile; ?>
			</section>

<?php
get_sidebar();
get_footer();
