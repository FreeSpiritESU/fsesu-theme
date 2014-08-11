<?php
/**
 * The template for displaying posts in the Aside post format
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
					<section class="entry-content">
					<?php
						the_content();
					?> 
					</section><!-- .entry-content -->
				</article><!-- #post-## -->
