<?php
/**
 * The template for displaying Category pages
 *
 * @link http://codex.wordpress.org/Template_Hierarchy
 *
 * @package         FreeSpiritESU
 * @subpackage      Templates
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
                <?php do_action( 'content_navigation', 'post-nav', 'page' ); ?>  
                <header id='archive-header'>
                    <h2 class='archive-title'>
                        <?php the_category( ' <i class="fa fa-chevron-right"></i> ', 'multiple' ); ?>
                    </h2>
                    
                    <?php
                        // Show an optional term description.
                        $term_description = term_description();
                        if ( ! empty( $term_description ) ) :
                            printf( '<div class="archive-description">%s</div>', $term_description );
                        endif;
                    ?>
                </header><!-- .archive-header -->
                
                <?php get_template_part( 'includes/partials/loop', 'summary' ); ?> 
            </section><!-- #primary-content -->
            
<?php 
get_sidebar(); 
get_footer(); 
