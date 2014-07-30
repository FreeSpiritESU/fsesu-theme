<?php
                if ( have_posts() ) : 
                    
                    do_action( 'content_navigation', 'post-nav', 'page' );
                    
                    /* Start the Loop */ 
                    while ( have_posts() ) : the_post(); 
                        get_template_part( 'includes/views/summary', get_post_format() );
                    endwhile;
                    
                    do_action( 'content_navigation', 'post-nav', 'page' );
                else :
                    get_template_part( 'includes/view/nothing' );
                endif; 