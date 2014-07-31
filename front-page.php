<?php
/**
 * The front page template for displaying the site homepage.
 *
 * Loops through the content in the database & presents it for display on the
 * users computer.
 *
 * @package         FreeSpiritESU
 * @subpackage      Content
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    31 July 2014
 */

get_header(); ?>
 
            <section id='primary-content'>
            <?php 
                if ( have_posts() ) : 
                    
                    /* Start the Loop */ 
                    while ( have_posts() ) : the_post(); 
                        get_template_part( 'includes/partials/content', 'status' );
                    endwhile;
                else :
                    get_template_part( 'includes/view/nothing' );
                endif;
            ?>  
            </section><!-- #primary-content -->
                
<?php
get_sidebar(); 
get_footer();