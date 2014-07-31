<?php
/**
 * The template for displaying Comments
 *
 * The area of the page that contains comments and the comment form.
 *
 * @package         FreeSpiritESU
 * @subpackage      Templates
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    31 July 2014
 */

/*
 * If the current post is protected by a password and the visitor has not yet
 * entered the password we will return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

                    <div id='comments' class='comments-area'>
                	<?php if ( have_comments() ) : ?> 
                    
                    	<h4 class='comments-title'>
                    	<?php printf( _n( 'One Comment', '%1$s Comments', get_comments_number() ), number_format_i18n( get_comments_number() ) ); ?>
                    	</h4>
                    
                    	<?php get_template_part( 'includes/partials/comments', 'nav' ); ?>
                    
                    	<ul class='comment-list'>
                    		<?php wp_list_comments( array( 'format' => 'html5' ) ); ?>  
                    	</ul><!-- .comment-list -->
                    	
                	<?php endif; // have_comments() 
                	    get_template_part( 'includes/partials/comments', 'nav' ); 
                	    
                	    if ( comments_open() ) : 
                	        comment_form();
            	        else : ?>  
                    	
                	    <p class='no-comments'>Comments are closed.</p>
                	<?php endif; // comment_open() ?>
                    
                    </div><!-- #comments -->
