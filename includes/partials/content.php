                <?php get_template_part( 'includes/partials/post', 'header' ); ?> 
                    
                    <section class='entry-content'>
                    <?php 
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'medium', array( 'class' => 'alignleft' ) );
                        }
                        the_content(); 
                    ?>
                    </section><!-- .entry-content -->
                    
                </article><!-- #post-<?php the_ID(); ?> -->