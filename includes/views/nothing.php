<?php
/**
 * Content to display when no posts are returned
 *
 * This is a template part that is displayed when there is no posts to display,
 * this could be due to the site having no posts, or an empty search result set
 *
 * @package         FreeSpiritESU
 * @subpackage      Templates
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    09 January 2014
 */
?>

            <article id='post-0' class='post no-results not-found hentry'>
				<header class='entry-header'>
					<h2 class='entry-title'>Nothing Found</h2>
				</header><!-- .entry-header -->

				<section class='entry-content'>
					<p>
					    Apologies, but there doesn't seem to be anything 
					    here. Are you sure you clicked on the right link? Or 
					    did you mistype the page address?
				    </p>
					<?php get_search_form(); ?>
				</section><!-- .entry-content -->
			</article><!-- #post-0 -->