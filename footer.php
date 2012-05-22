<?php
/* SVN FILE: $Id$ */
/**
 *  The template for displaying the footer.
 *
 *  Contains the closing of the id=main div and all content after
 *
 * 	@package        FreeSpiritESU
 *  @subpackage     Footer
 *  @copright       FreeSpirit ESU <http://www.freespiritesu.org.uk/> 2011 
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

	<footer id="colophon" role="contentinfo">
      <nav id='footer_menu' role='navigation'>
          <small>
              <?php wp_nav_menu( array( 'theme_location' => 'footer-menu' ) ); ?>
          </small>
      </nav>
      <div>
          <small>&copy; 2008 - <?php echo date('Y'); ?> FreeSpirit Explorer Scout Unit. All Rights Reserved. &nbsp;
            | &nbsp; Hosted by <a href="http://www.webtreeauthoring.com/" target="_blank">Webtree Authoring</a></small>
      </div>
      </div>
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>