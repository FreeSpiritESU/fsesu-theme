<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=container section and all content after.
 *
 * @package         FreeSpiritESU
 * @subpackage      Templates
 * @author          Richard Perry <http://www.perry-online.me.uk/>
 * @copyright       Copyright (c) 2014 FreeSpirit ESU
 * @license         http://www.gnu.org/licenses/gpl-3.0.html
 * @since           3.0.0
 * @version         3.0.0
 * @modifiedby      Richard Perry <richard@freespiritesu.org.uk>
 * @lastmodified    25 July 2014
 */
?>

    </section><!-- #container -->

    <footer id='footer' role='contentinfo'>
      <section id='footer_content'>
        <?php 
          if ( has_nav_menu( 'footer-menu' ) )
            wp_nav_menu( 
              array( 
                'container' => 'nav',
                'container_id' => 'footer_menu',
                'items_wrap' => '<small><ul><li><a href="/" title="Home">Home</a></li>%3$s</ul></small>', 
                'before' => ' &nbsp; | &nbsp; ',
                'theme_location' => 'footer-menu'
              ) 
            ); 
        ?>
        <div id='site-info'>
          <small>
            &copy; 2008 - <?php echo date('Y'); ?> FreeSpirit Explorer Scout Unit. 
            All Rights Reserved. &nbsp;
            | &nbsp; Hosted by <a href="http://www.webtreeauthoring.com/" 
              title='Webtree Authoring Ltd' 
              target="_blank">Webtree Authoring</a>
          </small>
        </div><!-- #site-info -->
      </section><!-- #footer_content -->
    </footer><!-- #footer -->
  </div><!-- #wrapper -->

<?php wp_footer(); ?>

</body>
</html>