                <?php get_template_part( 'includes/partials/post', 'header' ); ?> 
                    
                    <section class='entry-content'>
                        <?php the_content(); ?>
                    </section><!-- .entry-content -->
                    
                </article><!-- #post-<?php the_ID(); ?> -->