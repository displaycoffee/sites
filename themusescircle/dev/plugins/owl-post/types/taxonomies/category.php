<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Creates a category
	function opc_create_category() {
		$labels = array(
			'name'              => __( 'Categories', 'owl-post' ),
			'singular_name'     => __( 'Category', 'owl-post' ),
			'search_items'      => __( 'Search Categories', 'owl-post' ),
			'all_items'         => __( 'All Categories', 'owl-post' ),
			'parent_item'       => __( 'Parent Category', 'owl-post' ),
			'parent_item_colon' => __( 'Parent Category:', 'owl-post' ),
			'edit_item'         => __( 'Edit Category', 'owl-post' ), 
			'update_item'       => __( 'Update Category', 'owl-post' ),
			'add_new_item'      => __( 'Add New Category', 'owl-post' ),
			'new_item_name'     => __( 'New Category', 'owl-post' ),
			'menu_name'         => __( 'Categories', 'owl-post' ),
			'not_found'         => __( 'No categories found.', 'owl-post' )
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => true,
			'public'            => false,
			'rewrite'           => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false,
			'show_tagcloud'		=> false
		);

		register_taxonomy( 'opc-category', 'opc-slider', $args );
	}
	add_action( 'init', 'opc_create_category', 0 );