<?php
/**
 * Custom shortcodes for the FreeSpiritESU theme
 *  
 * @package         FreeSpiritESU
 * @subpackage      Functions
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    14 August 2014
 */


function fsesu_shortcode_random_image() {
    global $post;
    
    $args = array( 
        'post_type'     => 'attachment',
        'numberposts'   => 1,
        'post_status'   => 'any',
        'orderby'       => 'rand'
    );
    $attachments = get_posts( $args );
    $query = new WP_Query( $args );
    
    while ( $query->have_posts() ):
        $query->the_post();
        
        $image_id = get_the_ID();
        $image_attributes = wp_get_attachment_image_src( $image_id, 'medium' );
        $image_meta = wp_prepare_attachment_for_js( $image_id );
        if( $image_attributes ) :
            $output = sprintf('<figure class="random-image"><img src="%1$s" alt="%2$s"><figcaption class="wp-caption-text">%3$s</figcaption></figure>',
                $image_attributes[0],
                ( $image_meta['alt'] ) ? $image_meta['alt'] : get_the_title(),
                ( $image_meta['caption'] ) ? $image_meta['caption'] : get_the_title()
            );
        endif;
    endwhile;
    wp_reset_postdata();
    return $output;
    
    
    if ( wp_is_mobile() ) :
        return do_shortcode('[gallery include="' . $ids . '" link="file" size="medium"]'); 
    else :
        return do_shortcode('[gallery include="' . $ids . '" link="file" size="large"]'); 
    endif;
    
    
}

add_shortcode( 'random_image', 'fsesu_shortcode_random_image' );




// Add Shortcode
function fsesu_shortcode_recent_posts( $atts , $content = null ) {

    // Attributes
    extract( shortcode_atts(
        array(
            'posts'     => '5',
            'category'  => '',
            'short'     => false
        ), $atts )
    );

    // Code
    
    $cat = get_category_by_slug( $category ); 
    $title =  ( $cat ) ? $cat->name : 'Recent Posts';
    $category = ( $cat ) ? $cat->term_id : '';
    $output = '<h3>' . $title . '</h3>';
    $output .= ( $short ) ? '<ul class="recent-posts short">' : '<ul class="recent-posts">';
    $args = array(
        'posts_per_page'    => $posts,
        'category__in'      => $category
    );
    $the_query = new WP_Query( $args );
    while ( $the_query->have_posts() ):
        $the_query->the_post();
        $date = sprintf( '<a href="%1$s" rel="bookmark" title="%2$s"><time class="entry-date" datetime="%3$s" itemprop="datePublished">%4$s</time></a>',
                            esc_url( get_permalink() ),
                            get_the_title(),
                            esc_attr( get_the_date( 'c' ) ),
                            esc_html( get_the_date() )
                        );
        $output .= '<li>';
        if ( $short == true ) :
            $output .= '<span class="entry-meta"><span class="entry-date">' . $date . '</span></span>';
            $output .= sprintf( '%1$s <a href="%2$s" title="%3$s" class="infinity" rel="bookmark" itemprop="url">&infin;</a>',
                            get_the_content(),
                            esc_url( get_permalink() ),
                            get_the_title()
                        );
        else :
            $output .= '<h4>' . get_the_title() . '</h4>';
            ob_start();
                echo '<div class="entry-meta">';
                twentyfourteen_posted_on();
                edit_post_link( __( 'Edit', 'fsesu' ), '<span class="edit-link">', '</span>' );
                echo '</div>';
            $output .= ob_get_clean();
            $output .= sprintf ( '%1$s &hellip; <div class="read-more"><a href="%2$s" title="%3$s">%4$s  <i class="fa fa-chevron-right"></i></a></div>',
                            get_the_excerpt(),
                            esc_url(get_permalink( get_the_ID() )),
                            get_the_title(),
                            __('Read More', 'fsesu')
                        );
        endif;
        $output .= '</li>';
    endwhile;
    wp_reset_postdata();
    $output .= '</ul>'; 
    return $output;

}
add_shortcode( 'recent-posts', 'fsesu_shortcode_recent_posts' );