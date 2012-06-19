<?php
/* SVN FILE: $Id$ */
/**
 *  The main template file.
 *
 *  This is the most generic template file in a WordPress theme
 *  and one of the two required files for a theme (the other being style.css).
 *  It is used to display a page when nothing more specific matches a query.
 *  E.g., it puts together the home page when no home.php file exists.
 *  Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * 	@package        FreeSpiritESU
 *  @subpackage     Content
 *  @copyright      FreeSpirit ESU <http://www.freespiritesu.org.uk/> 2011
 *  @author         Richard Perry <http: //www.perry-online.me.uk/>
 *  @since          Release 0.1.1
 *  @version        $Rev$
 * 	@modifiedby    	$LastChangedBy$
 * 	@lastmodified  	$Date$
 *
 *  @todo           ToDo List
 *                  - Add i18n/l10n elements
 *                  - Add content templates for other post formats
 */

get_header();
 ?>

		<div id="content" role="main">

			<?php if ( have_posts() ) : ?>

				<?php if(function_exists('fsesu_content_nav')) { fsesu_content_nav('top-nav'); } ?>

				<?php /* Start the Loop */ ?>
				<?php while ( have_posts() ) : the_post(); ?>
                    
                    <?php 
                    /**
                     *  Get the content template relevant to the post format
                     *  of the post to be displayed
                     */
					get_template_part('content', get_post_format()); 
					?>

				<?php endwhile; ?>

			<?php else : ?>

			<article id="post-0" class="post no-results not-found hentry">
				<header class="entry-header">
					<h2 class="entry-title">Nothing Found</h2>
				</header><!-- .entry-header -->

				<div class="entry-content">
					<p>
					    Apologies, but there doesn't seem to be anything 
					    here. Are you sure you clicked on the right link? Or 
					    did you mistype the page address?
				    </p>
					<?php get_search_form(); ?>
				</div><!-- .entry-content -->
			</article><!-- #post-0 -->

			<?php endif; ?>
		</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>