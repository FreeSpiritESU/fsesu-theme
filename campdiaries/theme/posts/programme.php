<?php

function post_type_event() {
	register_post_type( 'event',
                array(	
			'labels' => array(
				'name' => 'Programme', 
				'singular_name' => 'Programme', 
				'add_new_item' => 'Add New Programme Entry', 
				'edit_item' => 'Edit Programme Entry'), 
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
			'rewrite' => array('slug' => 'unit-info/programme') ) );
	register_taxonomy_for_object_type('post_tag', 'event');
}
add_action('init', 'post_type_event');

?>