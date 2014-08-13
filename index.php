<?php
/**
 * The main template file
 *
 * This is the most generic template file in a WordPress theme and one
 * of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query,
 * e.g., it puts together the home page when no home.php file exists.
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
			<?php
				if ( have_posts() ) :
					// Start the Loop.
					while ( have_posts() ) : the_post();
	
						/*
						 * Include the post format-specific template for the content. If you want to
						 * use this in a child theme, then include a file called called content-___.php
						 * (where ___ is the post format) and that will be used instead.
						 */
						get_template_part( 'partials/content', get_post_format() );
	
					endwhile;
					
					// Previous/next post navigation.
					fsesu_paging_navigation();
	
				else :
					// If no content, include the "No posts found" template.
					get_template_part( 'partials/content', 'none' );
	
				endif;
			?>
			</section><!-- #main-content -->

<?php
get_sidebar();
get_footer();