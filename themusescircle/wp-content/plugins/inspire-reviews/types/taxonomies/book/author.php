<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Creates an author
	function insprvw_create_book_author() {
		$labels = array(
			'name'              => __( 'Authors', 'inspire-reviews' ),
			'singular_name'     => __( 'Author', 'inspire-reviews' ),
			'search_items'      => __( 'Search Authors', 'inspire-reviews' ),
			'all_items'         => __( 'All Authors', 'inspire-reviews' ),
			'parent_item'       => __( 'Parent Author', 'inspire-reviews' ),
			'parent_item_colon' => __( 'Parent Author:', 'inspire-reviews' ),
			'edit_item'         => __( 'Edit Author', 'inspire-reviews' ), 
			'update_item'       => __( 'Update Author', 'inspire-reviews' ),
			'add_new_item'      => __( 'Add New Author', 'inspire-reviews' ),
			'new_item_name'     => __( 'New Author', 'inspire-reviews' ),
			'menu_name'         => __( 'Authors', 'inspire-reviews' ),
			'not_found'         => __( 'No authors found.', 'inspire-reviews' )
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

		register_taxonomy( 'insprvw-book-author', 'insprvw-book-review', $args );
	}
	add_action( 'init', 'insprvw_create_book_author', 0 );