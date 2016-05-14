<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Creates a publisher
	function insprvw_create_book_publisher() {
		$labels = array(
			'name'              => __( 'Publishers', 'inspire-reviews' ),
			'singular_name'     => __( 'Publisher', 'inspire-reviews' ),
			'search_items'      => __( 'Search Publishers', 'inspire-reviews' ),
			'all_items'         => __( 'All Publishers', 'inspire-reviews' ),
			'parent_item'       => __( 'Parent Publisher', 'inspire-reviews' ),
			'parent_item_colon' => __( 'Parent Publisher:', 'inspire-reviews' ),
			'edit_item'         => __( 'Edit Publisher', 'inspire-reviews' ), 
			'update_item'       => __( 'Update Publisher', 'inspire-reviews' ),
			'add_new_item'      => __( 'Add New Publisher', 'inspire-reviews' ),
			'new_item_name'     => __( 'New Publisher', 'inspire-reviews' ),
			'menu_name'         => __( 'Publishers', 'inspire-reviews' ),
			'not_found'         => __( 'No publishers found.', 'inspire-reviews' )
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

		register_taxonomy( 'insprvw-book-publisher', 'insprvw-book-review', $args );
	}
	add_action( 'init', 'insprvw_create_book_publisher', 1 );