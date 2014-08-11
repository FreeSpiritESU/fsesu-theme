<?php
/**
 * The template for displaying 404 pages (Not Found)
 *
 * @package 	   WordPress
 * @subpackage 	   FreeSpiritESU
 * @author         Richard Perry <http://www.perry-online.me.uk/>
 * @copyright      Copyright (c) 2014 FreeSpirit ESU
 * @license        http://www.gnu.org/licenses/gpl-3.0.html
 * @since          3.0.0
 * @version        3.0.0
 * @modifiedby     Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified   11 August 2014
 */

get_header(); ?>

			<section id='main-content' class='site-content'  role='main' itemscope itemtype='http://schema.org/Blog'>
	
				<header class="page-header">
					<h1 class="page-title"><?php _e( 'Not Found', 'fsesu' ); ?></h1>
				</header>
	
				<section class="page-content">
					<p><?php _e( 'It looks like nothing was found at this location. Maybe try a search?', 'fsesu' ); ?></p>
	
					<?php get_search_form(); ?>
				</section><!-- .page-content -->
			</section><!-- #main-content.site-content -->

<?php
get_sidebar();
get_footer();
