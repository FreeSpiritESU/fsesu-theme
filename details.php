<?php
/*
 * Template Name: Event Details
 * 
 * This template is not designed to be used on any page other than the default
 * event details page. The page should not be access directly as it is used to
 * display the event details in a popup box.
 *
 * @package 	   WordPress\Themes\FreeSpiritESU
 * @subpackage 	   Templates
 * @author         Richard Perry <http://www.perry-online.me.uk/>
 * @copyright      Copyright (c) 2014 FreeSpirit ESU
 * @license        http://www.gnu.org/licenses/gpl-2.0.html
 * @since          3.0.0
 * @version        3.0.0
 * @modifiedby     Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified   03 September 2014
 */
    global $fsesu;
    
    if ( isset ( $_GET['id'] ) ) :
    
        $post = get_post( $_GET['id'] );
        if ( $post ) : 
            setup_postdata($post); 
            
            $start_date = get_post_meta( $post->ID, 'start_date', true );
            $end_date = get_post_meta( $post->ID, 'end_date', true );
            $cost = get_post_meta( $post->ID, 'cost', true );
            $link = get_post_meta( $post->ID, 'link', true );
            $locations = get_the_terms( $post->ID, 'location' );
            
            if ( date( 'd F Y', $start_date ) == date( 'd F Y', $end_date ) ) {
                $date = date( 'd M', $start_date );
            } elseif ( date( 'm', $start_date ) == date( 'm', $end_date ) ) {
                $date = date( 'd', $start_date ) . ' - ' . date( 'd M', $end_date );
            } elseif ( date( 'y', $start_date ) == date( 'y', $end_date ) ) {
                $date = date( 'd M', $start_date ) . ' - ' . date( 'd M', $end_date );
            } else {
                $date = date( 'd M Y', $start_date ) . ' - ' . date( 'd M Y', $end_date );
            }
            
            if ( $locations && ! is_wp_error( $locations ) ) { 
            	$location_list = array();
            	foreach ( $locations as $location ) {
            		$location_list[] = $location->name;
            	}
            	$location = join( ", ", $location_list );
            }
    ?>
        	<table class='programme-details'>
        		<caption class='event-title'><?php the_title() ?></caption>
        		<tr>
        		    <th>Date : </th><td><?php echo $date; ?></td>
        		</tr>
        		<tr class='even'>
        			<th>Details : </th><td><?php the_content(); ?></td>
        		</tr>
        		<tr>
        			<th>Price : </th><td><?php echo $cost; ?></td>
        		</tr>
        		<tr class='even'>
        			<th>Location : </th><td><?php echo $location; ?></td>
        		</tr>
        		<tr>
        			<th>Link : </th><td><?php echo $link; ?></td>
        		</tr>
        	</table>
<?php
        endif;
    else :
        echo 'This page is not designed to be accessed directly!';
    endif;
