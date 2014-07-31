<?php
                if ( have_posts() ) : 
                    
                    /* Start the Loop */ 
                    while ( have_posts() ) : the_post(); 
                        /* Get the correct content template for the post_format */
                        get_template_part( 'includes/partials/content', get_post_format() );
                    endwhile;
                else :
                    /* If there is no content then bring up the nothing partial */
                    get_template_part( 'includes/partial/nothing' );
                endif; 