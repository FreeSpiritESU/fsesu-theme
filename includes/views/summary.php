<?php
/**
 * The default template for displaying content summaries on archive pages etc.
 *
 * Loops through the content in the database & presents it for display on the
 * users computer.
 *
 * @package         FreeSpiritESU
 * @subpackage      Templates
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    30 July 2014
 */

get_template_part( 'includes/parts/post', 'header' ); ?> 
                    
                    <section class='entry-summary'>
                        <?php the_excerpt(); ?>  
                    </section><!-- .entry-summary -->

<?php get_template_part( 'includes/parts/post', 'readmore' );