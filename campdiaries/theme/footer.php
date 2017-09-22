<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content
 * after.  Calls sidebar-footer.php for bottom widgets.
 *
 * @package WordPress
 * @subpackage Twenty_Ten
 * @since Twenty Ten 1.0
 */
?>
	</div><!-- #main -->

	<div id="footer" role="contentinfo">
		<div id="colophon">

<?php
	/* A sidebar in the footer? Yep. You can can customize
	 * your footer with four columns of widgets.
	 */
	get_sidebar( 'footer' );
?>

		<div>
			<a href="/" title="home">Home</a>  |
			<a href="/sitemap/" title="sitemap">Site Map</a>  |
			<a href="/parents/supporters.php" title="Unit Supporters">Unit Supporters</a>  |
			<a href="/contact.php" title="Contact Us">Contact Us</a>
		</div>
		<div>
			<small>&copy; 2008 - <?php echo date('Y'); ?> FreeSpirit Explorer Scout Unit. All Rights Reserved. &nbsp;
				| &nbsp; Hosted by <a href="http://www.webtreeauthoring.com/" target="_blank">Webtree Authoring</a></small>
		</div>

			<div>
        <small>
          <?php do_action( 'twentyten_credits' ); ?>
          <a href="<?php echo esc_url( __('http://wordpress.org/', 'twentyten') ); ?>"
              title="<?php esc_attr_e('Semantic Personal Publishing Platform', 'twentyten'); ?>" rel="generator">
            <?php printf( __('Proudly powered by %s.', 'twentyten'), 'WordPress' ); ?>
          </a>
        </small>
      </div>
		</div><!-- #colophon -->
	</div><!-- #footer -->

</div><!-- #wrapper -->

<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
