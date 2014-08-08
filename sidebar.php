<?php
/**
 * The Sidebar containing the main widget area
 *
 * @package        WordPress
 * @subpackage 	   FreeSpiritESU
 * @author         Richard Perry <http://www.perry-online.me.uk/>
 * @copyright      Copyright (c) 2014 FreeSpirit ESU
 * @license        http://www.gnu.org/licenses/gpl-3.0.html
 * @since          3.0.0
 * @version        3.0.0
 * @modifiedby     Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified   06 August 2014
 */
?>

			<div id="secondary">
            	<?php
            		$description = get_bloginfo( 'description', 'display' );
            		if ( ! empty ( $description ) ) :
            	?>
            	<h2 class="site-description"><?php echo esc_html( $description ); ?></h2>
            	<?php endif; ?>
            
            	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
            	<div id="primary-sidebar" class="primary-sidebar widget-area" role="complementary">
            		<?php dynamic_sidebar( 'sidebar-1' ); ?>
            	</div><!-- #primary-sidebar -->
            	<?php endif; ?>
            </div><!-- #secondary -->