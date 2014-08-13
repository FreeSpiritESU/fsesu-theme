<?php
/**
 * The template for displaying Archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each specific one. For example, Twenty Fourteen
 * already has tag.php for Tag archives, category.php for Category archives,
 * and author.php for Author archives.
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
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

			<?php if ( have_posts() ) : ?>
	
				<header class='page-header'>
					<h1 class='page-title'>
						<?php
							if ( is_day() ) :
								printf( __( 'Daily Archives: %s', 'fsesu' ), get_the_date() );
								
							elseif ( is_month() ) :
								printf( __( 'Monthly Archives: %s', 'fsesu' ), get_the_date( _x( 'F Y', 'monthly archives date format', 'fsesu' ) ) );
								
							elseif ( is_year() ) :
								printf( __( 'Yearly Archives: %s', 'fsesu' ), get_the_date( _x( 'Y', 'yearly archives date format', 'fsesu' ) ) );
								
							else :
								_e( 'Archives', 'fsesu' );
	
							endif;
						?>
					</h1>
				</header><!-- .page-header -->
				
				<?php
					// Start the Loop.
					while ( have_posts() ) : the_post();
					
						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'partials/content', get_post_format() );
						
					endwhile;
					
					// Previous/next page navigation.
					fsesu_paging_navigation();
					
				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'partials/content', 'none' );
					
				endif;
			?>
			</section><!-- #primary -->

<?php
get_sidebar();
get_footer();
