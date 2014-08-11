<?php
/**
 * The template for displaying the footer
 *
 * Contains footer content and the closing of the #main and #page div elements.
 *
 * @package 		WordPress
 * @subpackage 	    FreeSpiritESU
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    11 August 2014
 */
?>

		</div><!-- #content -->
	
		<footer id='colophon' class='site-footer' role='contentinfo' itemscope itemtype='http://schema.org/WPFooter'>
			<div class='footer-content'>
	            <?php 
	            if ( has_nav_menu( 'footer' ) ) :
	                wp_nav_menu( 
	                    array( 
	                        'container' => 'nav',
	                        'container_class' => 'footer-menu',
	                        'items_wrap' => '<ul id="%1$s" class="%2$s"><li><a href="' . get_home_url() . '" title="Home">Home</a></li>%3$s</ul>', 
	                        'before' => ' &nbsp; | &nbsp; ',
	                        'theme_location' => 'footer'
	                    ) 
	                ); 
	            endif;
	            
	            get_sidebar( 'footer' ); 
	            ?>
		
				<div class='site-info'>
					<?php do_action( 'fsesu_credits', 2008, "FreeSpirit ESU" ); ?>
				</div><!-- .site-info -->
			</div><!-- .footer-content -->
		</footer><!-- #colophon -->
	</div><!-- #page -->

	<?php wp_footer(); ?>
</body>
</html>