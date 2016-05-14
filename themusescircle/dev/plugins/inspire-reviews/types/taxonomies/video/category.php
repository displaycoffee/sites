<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Creates a category
	function insprvw_create_video_category() {
		$labels = array(
			'name'              => __( 'Categories', 'inspire-reviews' ),
			'singular_name'     => __( 'Category', 'inspire-reviews' ),
			'search_items'      => __( 'Search Categories', 'inspire-reviews' ),
			'all_items'         => __( 'All Categories', 'inspire-reviews' ),
			'parent_item'       => __( 'Parent Category', 'inspire-reviews' ),
			'parent_item_colon' => __( 'Parent Category:', 'inspire-reviews' ),
			'edit_item'         => __( 'Edit Category', 'inspire-reviews' ), 
			'update_item'       => __( 'Update Category', 'inspire-reviews' ),
			'add_new_item'      => __( 'Add New Category', 'inspire-reviews' ),
			'new_item_name'     => __( 'New Category', 'inspire-reviews' ),
			'menu_name'         => __( 'Categories', 'inspire-reviews' ),
			'not_found'         => __( 'No categories found.', 'inspire-reviews' )
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => true,
			'rewrite'           => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false
		);

		register_taxonomy( 'insprvw-video-category', array( 'insprvw-show-review', 'insprvw-video-review' ), $args );
	}
	add_action( 'init', 'insprvw_create_video_category', 3 );