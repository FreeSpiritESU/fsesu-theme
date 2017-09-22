<?php

function post_type_international() { 
	register_post_type( 'international',
                array(	
			'labels' => array(
				'name' => 'International Opportunities', 
				'singular_name' => 'International Opportunity', 
				'add_new_item' => 'Add New International Opportunity', 
				'edit_item' => 'Edit International Opportunity'), 
			'public' => true, 
			'show_ui' => true,
		 	'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 6,
			'query_var' => false,
			'supports' => array(
				'title', 
				'editor', 
				'author', 
				'thumbnails'),
			'_builtin' => false,
			'rewrite' => array('slug' => 'unit-info/intopps') ) );
	register_taxonomy_for_object_type('post_tag', 'international');
}
add_action('init', 'post_type_international');

?>