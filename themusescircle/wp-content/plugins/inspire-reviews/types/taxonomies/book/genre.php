<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Creates a genre
	function insprvw_create_book_genre() {
		$labels = array(
			'name'              => __( 'Genres', 'inspire-reviews' ),
			'singular_name'     => __( 'Genre', 'inspire-reviews' ),
			'search_items'      => __( 'Search Genres', 'inspire-reviews' ),
			'all_items'         => __( 'All Genres', 'inspire-reviews' ),
			'parent_item'       => __( 'Parent Genre', 'inspire-reviews' ),
			'parent_item_colon' => __( 'Parent Genre:', 'inspire-reviews' ),
			'edit_item'         => __( 'Edit Genre', 'inspire-reviews' ), 
			'update_item'       => __( 'Update Genre', 'inspire-reviews' ),
			'add_new_item'      => __( 'Add New Genre', 'inspire-reviews' ),
			'new_item_name'     => __( 'New Genre', 'inspire-reviews' ),
			'menu_name'         => __( 'Genres', 'inspire-reviews' ),
			'not_found'         => __( 'No genres found.', 'inspire-reviews' )
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

		register_taxonomy( 'insprvw-book-genre', 'insprvw-book-review', $args );
	}
	add_action( 'init', 'insprvw_create_book_genre', 2 );