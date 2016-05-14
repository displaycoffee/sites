<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Creates a theme
	function insprvw_create_video_theme() {
		$labels = array(
			'name'              => __( 'Themes', 'inspire-reviews' ),
			'singular_name'     => __( 'Theme', 'inspire-reviews' ),
			'search_items'      => __( 'Search Themes', 'inspire-reviews' ),
			'all_items'         => __( 'All Themes', 'inspire-reviews' ),
			'parent_item'       => __( 'Parent Theme', 'inspire-reviews' ),
			'parent_item_colon' => __( 'Parent Theme:', 'inspire-reviews' ),
			'edit_item'         => __( 'Edit Theme', 'inspire-reviews' ), 
			'update_item'       => __( 'Update Theme', 'inspire-reviews' ),
			'add_new_item'      => __( 'Add New Theme', 'inspire-reviews' ),
			'new_item_name'     => __( 'New Theme', 'inspire-reviews' ),
			'menu_name'         => __( 'Themes', 'inspire-reviews' ),
			'not_found'         => __( 'No themes found.', 'inspire-reviews' )
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

		register_taxonomy( 'insprvw-video-theme', array( 'insprvw-show-review', 'insprvw-video-review' ), $args );
	}
	add_action( 'init', 'insprvw_create_video_theme', 2 );