<?php
/* SVN FILE: $Id: content.php 8 2012-06-19 15:21:37Z richard@perrymail.me.uk $ */
/**
 *  The default template for displaying content
 *
 *  Loops through the content in the database & presents it for display on the
 *  users computer
 *
 * 	@package        FreeSpiritESU
 *  @subpackage     Content
 *  @copyright      FreeSpirit ESU <http://www.freespiritesu.org.uk/> 2011 
 *  @author         Richard Perry <http: //www.perry-online.me.uk/>
 *  @since          Release 0.1.1
 *  @version        $Rev: 8 $
 * 	@modifiedby    	$LastChangedBy: richard@perrymail.me.uk $
 * 	@lastmodified  	$Date: 2012-06-19 16:21:37 +0100 (Tue, 19 Jun 2012) $
 *
 *  @todo           ToDo List
 *                  - 
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
            <h2 class="entry-title">
                <a href="<?php the_permalink(); ?>" 
                    title="<?php printf( 'Permalink to %s', 
                        the_title_attribute( 'echo=0' ) ); ?>" 
                    rel="bookmark"><?php the_title(); ?></a>
            </h2>

			<div class="entry-meta">
				<?php 
				/**
                 *  Add the meta data for the post
                 */
				fsesu_entry_meta(); 
				?>
			</div><!-- .entry-meta -->
		</header><!-- .entry-header -->

		<div class="entry-media">
            <?php 
                if ( function_exists('the_post_format_video') ) {
                     the_post_format_video(); 
                } else {
                    global $wp_embed;
                    add_filter( 'the_excerpt', array($wp_embed, 'autoembed'), 8 );
                    the_excerpt();
                } 
                
            ?>
        </div><!-- .entry-media -->
	</article><!-- #post-<?php the_ID(); ?> -->
