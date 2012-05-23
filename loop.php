<?php
/* SVN FILE: $Id$ */
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
 *  @version        $Rev$
 * 	@modifiedby    	$LastChangedBy$
 * 	@lastmodified  	$Date$
 *
 *  @todo           ToDo List
 *                  - 
 */
?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
            <h1 class="entry-title"><a href="<?php the_permalink(); ?>" 
			    title="<?php printf( 'Permalink to %s', 
                    the_title_attribute( 'echo=0' ) ); ?>" rel="bookmark">
			    <?php the_title(); ?></a></h1>

			<?php if ( 'post' == get_post_type() ) : ?>
			<div class="entry-meta">
				<?php fsesu_entry_meta(); ?>
			</div><!-- .entry-meta -->
			<?php endif; ?>

			<?php if ( comments_open() && ! post_password_required() ) : ?>
			<div class="comments-link">
				<?php comments_popup_link( 
				    '<span class="leave-reply">Reply</span>', 
				    _x( '1', 'comments number' ), 
				    _x( '%', 'comments number' ) ); ?>
			</div>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_excerpt(); ?>
		</div><!-- .entry-content -->
	</article><!-- #post-<?php the_ID(); ?> -->
