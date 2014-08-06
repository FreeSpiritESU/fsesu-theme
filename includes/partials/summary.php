                <?php get_template_part( 'includes/partials/post', 'header' ); ?> 
                    
                    <section class='entry-summary'>
                    <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'post-thumbnail', array( 'class' => 'alignleft' ) );
                        }
                        the_excerpt(); 
                    ?>  
                    </section><!-- .entry-summary -->
                    
                <?php get_template_part( 'includes/partials/post', 'readmore' );