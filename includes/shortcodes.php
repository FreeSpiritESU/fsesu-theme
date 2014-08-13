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