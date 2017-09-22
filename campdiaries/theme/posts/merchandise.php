<?php

function post_type_products() { 
	register_post_type( 'products',
                array(	
			'labels' => array(
				'name' => 'Merchandise', 
				'singular_name' => 'Product', 
				'add_new_item' => 'Add New Product', 
				'edit_item' => 'Edit Product',
				'not_found' => 'No products found!'), 
			'public' => true, 
			'show_ui' => true,
		 	'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 6,
			'query_var' => false,
			'supports' => array(
				'title', 
				'excerpt',
				'thumbnail'),
			'_builtin' => false,
			'rewrite' => array('slug' => 'members/merchandise') ) );
}
function admin_init(){
	add_meta_box('prodInfo-meta', 'Options', 'meta_options', 'products', 'normal', 'high');
}

function meta_options(){
	global $post;
	$custom = get_post_custom($post->ID);
	$price = $custom['price'][0];
?>
	<label>Price:</label><input name='price' value='<?php echo $price; ?>' />
<?php
}

function save_price(){
	global $post;
	update_post_meta($post->ID, 'price', $_POST['price']);
}

function prod_edit_columns($columns){
	$columns = array(
		'cb' => '<input type=\'checkbox\' />',
		'icon' => '',
		'title' => 'Product',
		'description' => 'Description',
		'price' => 'Price',
	);

	return $columns;
}

function prod_custom_columns($column){
	global $post;
	switch ($column)
	{
		case 'icon':
			the_post_thumbnail(array(60,60));
			break;
		case 'description':
			the_excerpt();
			break;
		case 'price':
			$custom = get_post_custom();
			echo $custom['price'][0];
			break;
	}
}
add_action('init', 'post_type_products');
add_action('admin_init', 'admin_init');
add_action('save_post', 'save_price');
add_filter('manage_edit-products_columns', 'prod_edit_columns');
add_action('manage_posts_custom_column',  'prod_custom_columns');

?>