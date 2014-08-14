<?php 


function fsesu_shortcode_random_image() {
    global $post;
    
    $ids = '';
    $counter = 0;
    $args = array( 
        'post_type'     => 'attachment',
        'numberposts'   => 1,
        'post_status'   => 'any',
        'orderby'       => 'rand'
    );
    $attachments = get_posts( $args );
    
    if ( $attachments ) {
        foreach ( $attachments as $attachment ) {
            setup_postdata( $attachment );
            if ( $counter != 0 ) {
                $ids .= ',' . $attachment->ID;
            }
            else {
                $ids .= $attachment->ID;
            }
            $counter++;
        }
        wp_reset_postdata();
    }
    
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