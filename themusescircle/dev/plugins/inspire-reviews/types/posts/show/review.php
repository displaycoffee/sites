<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Create custom content type
	function insprvw_create_show_review() {
		$labels = array(
			'name'               => __( 'Show Reviews', 'inspire-reviews' ),
			'singular_name'      => __( 'Show Review', 'inspire-reviews' ),
			'add_new'            => __( 'Add New', 'inspire-reviews' ),
			'add_new_item'       => __( 'Add New Review', 'inspire-reviews' ),
			'edit_item'          => __( 'Edit Review', 'inspire-reviews' ),
			'new_item'           => __( 'New Review', 'inspire-reviews' ),
			'all_items'          => __( 'All Reviews', 'inspire-reviews' ),
			'view_item'          => __( 'View Review', 'inspire-reviews' ),			
			'search_items'       => __( 'Search Reviews', 'inspire-reviews' ),
			'not_found'          => __( 'No reviews found.', 'inspire-reviews' ),
			'not_found_in_trash' => __( 'No reviews found in trash.', 'inspire-reviews' ),
			'parent_item_colon'  => __( 'Parent Review:', 'inspire-reviews' ),
			'menu_name'          => __( 'Show Reviews', 'inspire-reviews' ),
			'update_item'        => __( 'Update Reviews', 'inspire-reviews' )
		);

		$args = array(
			'label'               => __( 'Show Review', 'inspire-reviews' ),
			'labels'              => $labels,
			'description'         => __( 'Add reviews.', 'inspire-reviews' ),	
			'public'              => true,
			'menu_position'       => 6,
			'menu_icon'           => 'dashicons-desktop',
			'supports'            => array( 'title', 'page-attributes', 'editor', 'thumbnail', 'excerpt', 'comments' ),
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,			
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'hierarchical'        => false,
			'can_export'          => true,
			'capability_type'     => 'post',
		);
		
		register_post_type( 'insprvw-show-review', $args );
	}

	add_action( 'init', 'insprvw_create_show_review', 0 );