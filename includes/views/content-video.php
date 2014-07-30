<?php
/**
 * The default template for displaying content.
 *
 * Loops through the content in the database & presents it for display on the
 * users computer.
 *
 * @package         FreeSpiritESU
 * @subpackage      Templates
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    25 July 2014
 */
?>

            <article id='post-<?php the_ID(); ?>' <?php post_class(); ?>>
            
                <header class='entry-header'>
                    <h2 class='entry-title'>
                        <a href='<?php the_permalink(); ?>' 
                            title='<?php printf( 'Permalink to %s', 
                                the_title_attribute( 'echo=0' ) ); ?>' 
                            rel='bookmark'><?php the_title(); ?></a>
                    </h2>
                </header><!-- .entry-header -->
                
                <section class='entry-meta'>
                    <?php do_action( 'entry_meta' ); ?>
                </section><!-- .entry-meta -->
                
                <section class='entry-media'>
                    <?php 
                        if ( function_exists('the_post_format_video') ) {
                             the_post_format_video(); 
                        } else {
                            global $wp_embed;
                            add_filter( 'the_excerpt', array($wp_embed, 'autoembed'), 8 );
                            the_excerpt();
                        } 
                    ?>
                </section><!-- .entry-media -->
                
	        </article><!-- #post-<?php the_ID(); ?> -->
