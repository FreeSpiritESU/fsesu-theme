                        <?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
                    	<nav class='navigation comment-navigation' role='navigation'>
                    		<h4 class='assistive-text'>Comment navigation</h4>
                    		<div class='nav-previous alignleft'><?php previous_comments_link( '<i class="fa fa-chevron-left"></i> Older Comments' ); ?></div>
                    		<div class='nav-next alignright'><?php next_comments_link( 'Newer Comments <i class="fa fa-chevron-right"></i>' ); ?></div>
                    	</nav><!-- .comment-navigation -->
                    	<?php endif; // Check for comment navigation.