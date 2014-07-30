<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package         FreeSpiritESU
 * @subpackage      Templates
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    28 July 2014
 *
 * @todo            ToDo List
 *                  - Add i18n/l10n elements
 *                  - Add content templates for other post formats
 */

get_header(); ?>
 
      <section id='primary-content'>
        <?php 
          if ( have_posts() ) { 
            do_action( 'content_navigation', 'post-nav', 'page' );
              
            /* Start the Loop */ 
            while ( have_posts() ) { 
              the_post(); 
              /**
               * Get the content template relevant to the post format
               * of the post to be displayed
               */
              get_template_part('includes/views/summary', get_post_format()); ?>
              
        <hr>
        <?php
            }
            do_action( 'content_navigation', 'post-nav', 'page' );
          } else {
            get_template_part( 'includes/view/nothing' );
          } 
        ?>
      </section><!-- #primary-content -->
      <?php get_sidebar(); ?>

<?php get_footer(); ?>