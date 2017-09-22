<?php

function post_type_support() { 
	register_post_type( 'support',
                array(	
			'labels' => array(
				'name' => 'Unit Supporters', 
				'singular_name' => 'Unit Supporter', 
				'add_new_item' => 'Add New Supporter', 
				'edit_item' => 'Edit Supporter'), 
			'public' => true, 
			'show_ui' => true,
		 	'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 7,
			'query_var' => false,
			'supports' => array(
				'title', 
				'editor', 
				'author', 
				'thumbnails'),
			'_builtin' => false,
			'rewrite' => array('slug' => 'supporters') ) );
	register_taxonomy_for_object_type('post_tag', 'support');
}
add_action('init', 'post_type_support');

?>