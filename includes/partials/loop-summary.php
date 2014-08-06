<?php
                if ( have_posts() ) : 
                    /* Start the Loop */ 
                    while ( have_posts() ) : the_post(); 
                        get_template_part( 'includes/partials/summary', get_post_format() );
                    endwhile;
                    
                    do_action( 'content_navigation', 'post-nav', 'page' );
                else :
                    get_template_part( 'includes/partials/nothing' );
                endif; 