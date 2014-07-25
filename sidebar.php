<?php
/**
 *  The sidebar template file.
 *
 * @package         FreeSpiritESU
 * @subpackage      Templates
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    09 January 2014
 */
?>

            <aside id='sidebar' class='widget-area' role='complementary'>
                <?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>
                
                <aside id='archives' class='widget'>
                    <h3 class='widget-title'>
                        <?php _e( 'Archives', 'fsesu' ); ?>
                    </h3>
                    <ul>
                        <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
                    </ul>
                </aside>
                
                <aside id='meta' class='widget'>
                    <h3 class='widget-title'><?php _e( 'Meta', 'fsesu' ); ?></h3>
                    <ul>
                        <?php wp_register(); ?>
                        <li><?php wp_loginout(); ?></li>
                        <?php wp_meta(); ?>
                    </ul>
                </aside>
                
                <?php endif; // end sidebar widget area ?>
            </aside><!-- #sidebar .widget-area -->
            