<?php

function post_type_press() {
	register_post_type( 'press',
                array(	
			'labels' => array(
				'name' => 'Press Cuttings', 
				'singular_name' => 'Press Cutting', 
				'add_new_item' => 'Add New Cutting', 
				'edit_item' => 'Edit Cutting'), 
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
			'rewrite' => array('slug' => 'unit-info/press_cuttings') ) );
	register_taxonomy_for_object_type('post_tag', 'press');
}
add_action('init', 'post_type_press');

?>