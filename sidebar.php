<?php
/* SVN FILE: $Id$ */
/**
 *  The sidebar template file.
 *
 *  @package        FreeSpiritESU
 *  @subpackage     Content
 *  @copyright      FreeSpirit ESU <http://www.freespiritesu.org.uk/> 2011 
 *  @author         Richard Perry <http: //www.perry-online.me.uk/>
 *  @since          Release 0.1.1
 *  @version        $Rev$
 *  @modifiedby     $LastChangedBy$
 *  @lastmodified   $Date$
 *
 *  @todo           ToDo List
 *                  -
 */
?>
        <div id="sidebar" class="widget-area" role="complementary">
        <?php if ( ! dynamic_sidebar( 'sidebar' ) ) : ?>

            <aside id="archives" class="widget">
                <h3 class="widget-title">
                    <?php _e( 'Archives', 'fsesu' ); ?>
                </h3>
                <ul>
                    <?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
                </ul>
            </aside>

            <aside id="meta" class="widget">
                <h3 class="widget-title"><?php _e( 'Meta', 'fsesu' ); ?></h3>
                <ul>
                    <?php wp_register(); ?>
                    <li><?php wp_loginout(); ?></li>
                    <?php wp_meta(); ?>
                </ul>
            </aside>

        <?php endif; // end sidebar widget area ?>
        </div><!-- #sidebar .widget-area -->