<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
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
				// Start the Loop.
				while ( have_posts() ) : the_post();

					// Include the page content template.
					get_template_part( 'partials/content', 'page' );

					// If comments are open or we have at least one comment, load up the comment template.
					if ( comments_open() || get_comments_number() ) {
						comments_template();
					}
				endwhile;
			?>
			</section>

<?php
get_sidebar();
get_footer();
