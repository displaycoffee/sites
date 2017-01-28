<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Creates a tag
	function insprvw_create_video_tag() {
		$labels = array(
			'name'              => __( 'Video Tags', 'inspire-reviews' ),
			'singular_name'     => __( 'Tag', 'inspire-reviews' ),
			'search_items'      => __( 'Search Tags', 'inspire-reviews' ),
			'all_items'         => __( 'All Tags', 'inspire-reviews' ),
			'parent_item'       => __( 'Parent Tag', 'inspire-reviews' ),
			'parent_item_colon' => __( 'Parent Tag:', 'inspire-reviews' ),
			'edit_item'         => __( 'Edit Tag', 'inspire-reviews' ), 
			'update_item'       => __( 'Update Tag', 'inspire-reviews' ),
			'add_new_item'      => __( 'Add New Tag', 'inspire-reviews' ),
			'new_item_name'     => __( 'New Tag', 'inspire-reviews' ),
			'menu_name'         => __( 'Tags', 'inspire-reviews' ),
			'not_found'         => __( 'No tags found.', 'inspire-reviews' )
		);

		$args = array(
			'labels'            => $labels,
			'hierarchical'      => false,
			'public'            => true,
			'rewrite'           => true,
			'show_ui'           => true,
			'show_admin_column' => true,
			'show_in_nav_menus' => false
		);

		register_taxonomy( 'insprvw-video-tag', array( 'insprvw-tv-review', 'insprvw-movie-review' ), $args );
	}
	add_action( 'init', 'insprvw_create_video_tag', 4 );	