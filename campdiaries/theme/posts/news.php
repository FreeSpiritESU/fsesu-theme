<?php

function post_type_news() { 
	register_post_type( 'news',
                array(	
			'labels' => array(
				'name' => 'News', 
				'singular_name' => 'News', 
				'add_new_item' => 'Add New News Item', 
				'edit_item' => 'Edit News Item'), 
			'public' => true, 
			'show_ui' => true,
		 	'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 4,
			'query_var' => false,
			'supports' => array(
				'title', 
				'editor', 
				'author', 
				'thumbnails'),
			'_builtin' => false,
			'rewrite' => array('slug' => 'news') ) );
	register_taxonomy_for_object_type('post_tag', 'news');
}
add_action('init', 'post_type_news');

?>