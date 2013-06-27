<?php
/* SVN FILE: $Id$ */
/**
 *  inc/util.php   The utility functions file for the FreeSpirit ESU Wordpress Theme
 *  
 *  This file is the called by the main theme functions file and includes all theme
 *  functions that are not run, or hooked into actions but can be used within the
 *  theme itself
 *  
 *  PHP Version 5
 *  
 *  @package        FreeSpiritESU
 *  @subpackage     Functions
 *  @copyright      FreeSpirit ESU <http://www.freespiritesu.org.uk/> 2011 
 *  @author         Richard Perry <http: //www.perry-online.me.uk/>
 *  @since          Release 0.1.1
 *  @version        $Rev$
 *  @modifiedby     $LastChangedBy$
 *  @lastmodified   $Date$
 *
 *  @todo           ToDo List
 */

/**
 *  FUNCTIONS FOR USE WITHIN THE THEME
 */

/**
 *  Generate next/previous navigation for use anywhere within the theme
 *  
 *  @param  nav_id      an ID tag for the navigation element
 */
function fsesu_content_nav( $nav_id ) {
    global $wp_query;

    if ( $wp_query->max_num_pages > 1 ) : ?>
        <nav id="<?php echo $nav_id; ?>">
            <h3 class="assistive-text">Post navigation</h3>
            <div class="nav-previous alignleft"><?php next_posts_link( '&larr; Previous post' ); ?></div>
            <div class="nav-next alignright"><?php previous_posts_link( 'Neext post &rarr;' ); ?></div>
        </nav>
    <?php endif;
}


/**
 *  
 */
function fsesu_entry_meta() {
    printf( 'Posted on <a href="%1$s" title="%2$s" rel="bookmark"><time class="entry-date" datetime="%3$s" pubdate>%4$s</time></a><span class="by-author">  by  <span class="author vcard"><a class="url fn n" href="%5$s" title="%6$s" rel="author">%7$s</a></span></span>',
        esc_url( get_permalink() ),
        esc_attr( get_the_time() ),
        esc_attr( get_the_date( 'c' ) ),
        esc_html( get_the_date() ),
        esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ),
        esc_attr( sprintf( 'View all posts by %s',  get_the_author() ) ),
        get_the_author()
    );
}


/**
 * Generate the breadcrumb for the page header
 */
function fsesu_breadcrumb() {
    if (!is_home()) {
        echo '<a href="';
        echo get_option('home');
        echo '">';
        bloginfo('name');
        echo "</a> &gt;&gt; ";
        if (is_category() || is_single()) {
            the_category('title_li=');
            if (is_single()) {
                echo " &gt;&gt; ";
                the_title();
            }
        } elseif (is_page()) {
            echo the_title();
        }
    }
}


/**
 * Create a new category
 */
function fsesu_new_category( $category_array ) {
    if (file_exists (ABSPATH.'/wp-admin/includes/taxonomy.php')) {
        require_once (ABSPATH.'/wp-admin/includes/taxonomy.php'); 
        if ( ! get_cat_ID( $category_array['cat_name'] ) ) {
            wp_insert_category( $category_array ); 
        }
    }
}



