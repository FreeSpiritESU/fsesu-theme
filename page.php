<?php
/* SVN FILE: $Id$ */
/**
 *  The default template for displaying page content
 *
 *  Loops through the content in the database & presents it for display on the
 *  users computer
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
 *                  - 
 */

get_header();
 ?>

        <div id="content" role="main">

            <?php if ( have_posts() ) : ?>

                <?php if(function_exists('fsesu_content_nav')) { fsesu_content_nav('top-nav'); } ?>

                <?php /* Start the Loop */ ?>
                <?php while ( have_posts() ) : the_post(); ?>
                    
        	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
        		<header class="entry-header">
                    <h2 class="entry-title">
                        <a href="<?php the_permalink(); ?>" 
                            title="<?php printf( 'Permalink to %s', 
                                the_title_attribute( 'echo=0' ) ); ?>" 
                            rel="bookmark"><?php the_title(); ?></a>
                    </h2>
        		</header><!-- .entry-header -->
        
        		<div class="entry-content">
        			<?php the_content(); ?>
        		</div><!-- .entry-content -->
        	</article><!-- #post-<?php the_ID(); ?> -->

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