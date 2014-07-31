                <?php get_template_part( 'includes/partials/post', 'header' ); ?> 
                    
                    <section class='entry-summary'>
                        <?php the_excerpt(); ?>  
                    </section><!-- .entry-summary -->
                    
                <?php get_template_part( 'includes/partials/post', 'readmore' );