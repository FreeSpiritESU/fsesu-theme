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
 * @lastmodified    28 July 2014
 *
 *  @todo           ToDo List
 *                  - 
 */

get_header(); ?>
 
      <section id='primary-content'>
      <?php 
        if ( have_posts() ) { 
          do_action( 'content_navigation', 'post-nav' ); 

          /* Start the Loop */ 
          while ( have_posts() ) { 
            the_post();  
		        /**
		         * Get the content template relevant to the post format
		         * of the post to be displayed
		         */
		        get_template_part('includes/views/content', get_post_format());
          }
          do_action( 'content_navigation', 'post-nav' );
        } else {
          get_template_part( 'includes/view/nothing' );
        } 
      ?>
      </section><!-- #primary-content -->
      <?php get_sidebar(); ?>
    
<?php get_footer(); ?>