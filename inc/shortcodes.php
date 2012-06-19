<?php
/* SVN FILE: $Id$ */
/**
 * inc/shortcodes.php   Registers shortcodes for use by the FreeSpirit ESU Wordpress Theme
 *  
 * This file is the included in the main theme functions file and registers shortcodes
 * specific to the FreeSpirit ESU Website to make page generation simpler
 *  
 * PHP Version 5
 *  
 * @package        FreeSpiritESU
 * @subpackage     Functions
 * @copyright      FreeSpirit ESU <http://www.freespiritesu.org.uk/> 2011 
 * @author         Richard Perry <http: //www.perry-online.me.uk/>
 * @since          Release 0.1.1
 * @version        $Rev$
 * @modifiedby     $LastChangedBy$
 * @lastmodified   $Date$
 *
 * @todo           ToDo List
 */


function googlemap_function($atts, $content = null) {
    extract(shortcode_atts(array(
        "width" => '640',
        "height" => '480',
        "src" => ''
    ), $atts));
    return '<iframe width="'.$width.'" height="'.$height.'" src="'.$src.'&output=embed" ></iframe>';
}



function recent_posts_function($atts, $content = null) {
    extract(shortcode_atts(array(
        'posts' => 1,
        'category' => ''
    ), $atts));

    $return_string = '<h3>'.$content.'</h3>';
    $return_string .= '<ul>';
    query_posts(array(
        'orderby' => 'date', 
        'order' => 'DESC' , 
        'showposts' => $posts, 
        'category' => $category
    ));
    if (have_posts()) :
        while (have_posts()) : the_post();
            $return_string .= '<li><a href="'.get_permalink().'">'.get_the_title().'</a></li>';
        endwhile;
    endif;
    $return_string .= '</ul>';

    wp_reset_query();
    return $return_string;
}


function register_shortcodes(){
    add_shortcode("googlemap", "googlemap_function");
    add_shortcode('recent-posts', 'recent_posts_function');
}
add_action( 'init', 'register_shortcodes');