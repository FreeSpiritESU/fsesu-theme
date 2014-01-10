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
 * @lastmodified    10 January 2014
 *
 *  @todo           ToDo List
 *                  - 
 */

get_header();
 ?>
 
        <section id='content' role='main'>
            <section id='entries'>
    			<?php 
    			    if ( have_posts() ) { 
    			        $fsesu->content_navigation('top-nav'); 
    
        				/* Start the Loop */ 
    				    while ( have_posts() ) { 
    				        the_post(); 
			    ?>
                    
            	<article id='post-<?php the_ID(); ?>' <?php post_class(); ?>>
            		<header class='entry-header'>
                        <h2 class='entry-title'>
                            <a href="<?php the_permalink(); ?>" 
                                title="<?php printf( 'Permalink to %s', 
                                    the_title_attribute( 'echo=0' ) ); ?>" 
                                rel="bookmark"><?php the_title(); ?></a>
                        </h2>
            		</header><!-- .entry-header -->
            
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