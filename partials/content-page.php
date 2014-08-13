<?php
/**
 * The template used for displaying page content
 *
 * @package  	   WordPress
 * @subpackage 	   FreeSpiritESU
 * @author         Richard Perry <http://www.perry-online.me.uk/>
 * @copyright      Copyright (c) 2014 FreeSpirit ESU
 * @license        http://www.gnu.org/licenses/gpl-3.0.html
 * @since          3.0.0
 * @version        3.0.0
 * @modifiedby     Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified   13 August 2014
 */
?>

				<article id='page-<?php the_ID(); ?>' <?php post_class(); ?>  itemscope itemtype='http://schema.org/Article'>
					
					<header class='page-header' itemprop='headline'>
						<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
					</header><!-- .page-header -->
					
					<section class='page-content'  itemprop='articleBody'>
						<?php the_content(); ?>
					</section><!-- .page-content -->
					
					<footer class='entry-meta'>
					<?php
						wp_link_pages( array(
							'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'fsesu' ) . '</span>',
							'after'       => '</div>',
							'link_before' => '<span>',
							'link_after'  => '</span>',
						) );
			
						edit_post_link( __( 'Edit', 'fsesu' ), '<span class="edit-link">', '</span>' );
					?>
					</footer><!-- .entry-footer -->
				</article><!-- #page-<?php the_ID(); ?> -->
