<?php
/**
 * The default template for displaying page content.
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
                /* Run the loop for full content */
                get_template_part( 'includes/partials/loop', 'content' );
                    
                /* Display the comments template at the bottom of the page */
                comments_template( '', true );
                ?> 
            </section><!-- #primary-content -->
            
<?php 
get_sidebar(); 
get_footer(); 
