                <?php get_template_part( 'includes/partials/post', 'header' ); ?> 
                    
                    <section class='entry-content'>
                    <?php 
                        global $page;
                        if ( has_post_thumbnail() && $page == 1 ) {
                            the_post_thumbnail( 'large', array( 'class' => 'aligncenter' ) );
                        }
                        the_content(); 
                    ?>
                    </section><!-- .entry-content -->
                    
                </article><!-- #post-<?php the_ID(); ?> -->