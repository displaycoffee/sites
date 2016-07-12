<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Creates an actor
	function insprvw_create_video_actor() {
		$labels = array(
			'name'              => __( 'Actors', 'inspire-reviews' ),
			'singular_name'     => __( 'Actor', 'inspire-reviews' ),
			'search_items'      => __( 'Search Actors', 'inspire-reviews' ),
			'all_items'         => __( 'All Actors', 'inspire-reviews' ),
			'parent_item'       => __( 'Parent Actor', 'inspire-reviews' ),
			'parent_item_colon' => __( 'Parent Actor:', 'inspire-reviews' ),
			'edit_item'         => __( 'Edit Actor', 'inspire-reviews' ), 
			'update_item'       => __( 'Update Actor', 'inspire-reviews' ),
			'add_new_item'      => __( 'Add New Actor', 'inspire-reviews' ),
			'new_item_name'     => __( 'New Actor', 'inspire-reviews' ),
			'menu_name'         => __( 'Actors', 'inspire-reviews' ),
			'not_found'         => __( 'No actors found.', 'inspire-reviews' )
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

		register_taxonomy( 'insprvw-video-actor', array( 'insprvw-tv-review', 'insprvw-movie-review' ), $args );
	}
	add_action( 'init', 'insprvw_create_video_actor', 0 );