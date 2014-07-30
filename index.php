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
 * @lastmodified    30 July 2014
 *
 * @todo            ToDo List
 *                  - Add i18n/l10n elements
 *                  - Add content templates for other post formats
 */


get_header(); ?>
 
            <section id='primary-content'>
                <?php get_template_part( 'includes/parts/loop' ); ?> 
            </section><!-- #primary-content -->
            
<?php 
get_sidebar(); 
get_footer(); 
