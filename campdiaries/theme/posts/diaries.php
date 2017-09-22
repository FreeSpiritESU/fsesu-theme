<?php

function post_type_diaries() { 
	register_post_type( 'diaries',
                array(	
			'labels' => array(
				'name' => 'Camp Diaries', 
				'singular_name' => 'Camp Diary', 
				'add_new_item' => 'Add New Diary Entry', 
				'edit_item' => 'Edit Diary Entry'), 
			'public' => true, 
			'show_ui' => true,
		 	'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 5,
			'query_var' => false,
			'supports' => array(
				'title', 
				'editor', 
				'author', 
				'thumbnails'),
			'_builtin' => false,
			'rewrite' => array('slug' => 'campdiaries') ) );
	register_taxonomy_for_object_type('post_tag', 'diaries');
}
add_action('init', 'post_type_diaries');

?>