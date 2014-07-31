            <?php get_template_part( 'includes/partials/post', 'header' ); ?> 
                
                <section class='entry-media'>
                    <?php 
                        if ( function_exists('the_post_format_video') ) {
                             the_post_format_video(); 
                        } else {
                            global $wp_embed;
                            add_filter( 'the_content', array($wp_embed, 'autoembed'), 8 );
                            the_content();
                        } 
                    ?>
                </section><!-- .entry-media -->
                
	        </article><!-- #post-<?php the_ID(); ?> -->
