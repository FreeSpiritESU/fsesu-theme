<?php
/* SVN FILE: $Id$ */
/**
 *  The template for displaying the footer.
 *
 *  Contains the closing of the id=main div and all content after
 *
 * 	@package        FreeSpiritESU
 *  @subpackage     Footer
 *  @copyright      FreeSpirit ESU <http://www.freespiritesu.org.uk/> 2011 
 *  @author         Richard Perry <http: //www.perry-online.me.uk/>
 *  @since          Release 0.1.0
 *  @version        $Rev$
 * 	@modifiedby    	$LastChangedBy$
 * 	@lastmodified  	$Date$
 *
 *  @todo           ToDo List
 *                  - 
 */
?>

    </div><!-- #main -->

	<footer id="footer" role="contentinfo">
	    <div id='colophon'>
            <?php wp_nav_menu( array( 'container' => 'nav',
                                      'container_id' => 'footer_menu',
                                      'items_wrap' => '<small><ul><li><a href="/" title="Home">Home</a></li>%3$s</ul></small>', 
                                      'before' => ' &nbsp; | &nbsp; ',
                                      'theme_location' => 'footer-menu') ); ?>
            <div id='site-info'>
                <small>
                    &copy; 2008 - <?php echo date('Y'); ?> FreeSpirit Explorer Scout Unit. 
                    All Rights Reserved. &nbsp;
                    | &nbsp; Hosted by <a href="http://www.webtreeauthoring.com/" 
                        title='Webtree Authoring Ltd' 
                        target="_blank">Webtree Authoring</a>
                </small>
            </div><!-- #site-info -->
        </div><!-- #colophon -->
	</footer><!-- #footer -->
</div><!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>