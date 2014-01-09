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
 * @lastmodified    09 January 2014
 */

get_header();
 ?>
 
        <section id='content' role='main'>
            <section id='entries'>
    			<?php 
    			    if ( have_posts() ) { 
    			        
        				/* Start the Loop */ 
    				    while ( have_posts() ) { 
    				        the_post(); 
			    ?>
                    
            	<article id='post-<?php the_ID(); ?>' <?php post_class(); ?>>
            		<section class='entry-content'>
            			<?php the_content(); ?>
            		</section><!-- .entry-content -->
            	</article><!-- #post-<?php the_ID(); ?> -->

                <?php  
                        }
    				} else {
    				    get_template_part( 'includes/view/nothing' );
    			    } 
    			?>
			</section><!-- #entries -->
            <?php get_sidebar(); ?>
		</section><!-- #content -->
		
<?php get_footer(); ?>