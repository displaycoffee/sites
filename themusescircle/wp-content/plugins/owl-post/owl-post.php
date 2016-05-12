<?php
	/**
	* Plugin Name: Owl Post
	* Plugin URI: http://neverend.org/adria
	* Description: A custom post type to create sliders using Owl Carousel.
	* Author: Adria Murphy
	* Author URI: http://neverend.org/adria
	* Version: 4.0
	* Text Domain: owl-post
	**/
	
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Load plugin text domain
	function opc_load_textdomain() {
		load_plugin_textdomain( 'owl-post', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	}

	// Loads necessary javascript and CSS
	function opc_enqueue_assets() {
	    global $typenow;
	    if ( $typenow == 'opc-slider' ) {
	    	// Enqueue and localize media library
	        wp_enqueue_media();
	        wp_localize_script( 'opc_asset', 'image_select',
	            array(
	                'title'  => __( 'Choose or Upload an Image', 'owl-post' ),
	                'button' => __( 'Use this image', 'owl-post' ),
	            )
	        );

	        // Enqueue color picker
	        wp_enqueue_style( 'wp-color-picker' );
	        wp_enqueue_script( 'wp-color-picker' );

	        // Enqueue date picker
			wp_enqueue_style( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ), time(), true );	
	 	 
	        // Enqueue the required javascript
	        wp_enqueue_script( 'opc_asset', plugin_dir_url( __FILE__ ) . 'assets/js/functions.js' );

	        // Enqueue the required CSS
	        wp_enqueue_style( 'opc_asset', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
	    }
	}
	add_action( 'admin_enqueue_scripts', 'opc_enqueue_assets' );

	// Load Owl Carousel Assets
	function opc_enqueue_owl() {
        $option = get_option( 'opc-options' );

        // Enqueue the required javascript
        if( !isset( $option['opc-remove-js'] ) ) {
        	wp_enqueue_script( 'opc_asset', plugin_dir_url( __FILE__ ) . 'assets/js/owl.carousel.min.js', array( 'jquery' ) );
        }

        // Enqueue the required CSS
        if( !isset( $option['opc-remove-css'] ) ) {
        	wp_enqueue_style( 'opc_asset', plugin_dir_url( __FILE__ ) . 'assets/css/owl-post.css' );
        }		
	}
	add_action( 'wp_enqueue_scripts', 'opc_enqueue_owl' );

	// Include multi-use files
	require_once( 'includes/choices.php' );
	require_once( 'includes/fields.php' );
	require_once( 'includes/validation.php' );

	// Options
	require_once( 'options/options-array.php' );
	require_once( 'options/options-page.php' );

	// Post types
	require_once( 'types/posts/slider.php' );
	require_once( 'types/posts/post-meta-array.php' );
	require_once( 'types/posts/post-meta-boxes.php' );

	// Taxonomies
	require_once( 'types/taxonomies/category.php' );	
	require_once( 'types/taxonomies/term-meta-array.php' );	
	require_once( 'types/taxonomies/term-meta-boxes.php' );	

	// Display
	require_once( 'display/display-slider.php' );	