                <?php get_template_part( 'includes/partials/post', 'header' ); ?> 
                    
                    <section class='entry-summary'>
                    <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'large', array( 'class' => 'aligncenter' ) );
                        }
                        do_action( 'random_images' );
                        do_action( 'gallery_images' );
                    ?>  
                    </section><!-- .entry-summary -->
                    
                <?php get_template_part( 'includes/partials/post', 'readmore' );