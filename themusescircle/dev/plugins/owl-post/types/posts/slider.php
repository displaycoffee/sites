<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Creates a slide
	function opc_create_slide() {
		$labels = array(
			'name'               => __( 'Owl Post', 'owl-post' ),
			'singular_name'      => __( 'Slide', 'owl-post' ),
			'add_new'            => __( 'Add New', 'owl-post' ),
			'add_new_item'       => __( 'Add New Slide', 'owl-post' ),
			'edit_item'          => __( 'Edit Slide', 'owl-post' ),
			'new_item'           => __( 'New Slide', 'owl-post' ),
			'all_items'          => __( 'All Slides', 'owl-post' ),
			'view_item'          => __( 'View Slide', 'owl-post' ),			
			'search_items'       => __( 'Search Slides', 'owl-post' ),
			'not_found'          => __( 'No slides found.', 'owl-post' ),
			'not_found_in_trash' => __( 'No slides found in trash.', 'owl-post' ),
			'parent_item_colon'  => __( 'Parent Slide:', 'owl-post' ),
			'menu_name'          => __( 'Owl Post', 'owl-post' ),
			'update_item'        => __( 'Update Slides', 'owl-post' ),
		);

		$args = array(
			'label'               => __( 'Slide Entry', 'owl-post' ),
			'labels'              => $labels,
			'description'         => __( 'Add Slide entries.', 'owl-post' ),	
			'public'              => true,
			'rewrite'             => false,
			'menu_position'       => 6,
			'menu_icon'           => 'dashicons-slides',
			'supports'            => array( 'title', 'page-attributes' ),
			'has_archive'         => false,
			'exclude_from_search' => true,
			'publicly_queryable'  => false,			
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => false,
			'show_in_admin_bar'   => true,
			'hierarchical'        => false,
			'can_export'          => true,
			'capability_type'     => 'post',
		);
		
		register_post_type( 'opc-slide', $args );
	}
	add_action( 'init', 'opc_create_slide', 0 );