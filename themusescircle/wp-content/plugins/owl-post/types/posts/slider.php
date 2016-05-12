<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Creates a slider
	function opc_create_slider() {
		$labels = array(
			'name'               => __( 'Owl Post', 'owl-post' ),
			'singular_name'      => __( 'Slider', 'owl-post' ),
			'add_new'            => __( 'Add New', 'owl-post' ),
			'add_new_item'       => __( 'Add New Slider', 'owl-post' ),
			'edit_item'          => __( 'Edit Slider', 'owl-post' ),
			'new_item'           => __( 'New Slider', 'owl-post' ),
			'all_items'          => __( 'All Sliders', 'owl-post' ),
			'view_item'          => __( 'View Slider', 'owl-post' ),			
			'search_items'       => __( 'Search Sliders', 'owl-post' ),
			'not_found'          => __( 'No sliders found.', 'owl-post' ),
			'not_found_in_trash' => __( 'No sliders found in trash.', 'owl-post' ),
			'parent_item_colon'  => __( 'Parent Slider:', 'owl-post' ),
			'menu_name'          => __( 'Owl Post', 'owl-post' ),
			'update_item'        => __( 'Update Sliders', 'owl-post' ),
		);

		$args = array(
			'label'               => __( 'Slider Entry', 'owl-post' ),
			'labels'              => $labels,
			'description'         => __( 'Add Slider entries.', 'owl-post' ),	
			'public'              => true,
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
		
		register_post_type( 'opc-slider', $args );
	}

	add_action( 'init', 'opc_create_slider', 0 );