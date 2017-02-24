<?php
	/**
	* Plugin Name: Inspire Reviews
	* Plugin URI: http://neverend.org/adria
	* Description: Used for reviewing various types of media such as books, movies, and tv.
	* Author: Adria Murphy
	* Author URI: http://neverend.org/adria
	* Version: 8.5
	* Text Domain: inspire-reviews
	**/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Define paths
	define( 'INSPRVW_DIR', plugin_dir_path( __FILE__ ) );

	// Load plugin text domain
	function insprvw_load_textdomain() {
		load_plugin_textdomain( 'inspire-reviews', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	}

	// Loads necessary javascript and CSS
	function insprvw_enqueue_assets() {
	    global $typenow;
	    if ( $typenow == 'insprvw-book-review' || $typenow == 'insprvw-movie-review' || $typenow == 'insprvw-tv-review' ) {
	    	// Enqueue and localize media library
	        wp_enqueue_media();
	        wp_localize_script( 'insprvw_asset', 'image_select',
	            array(
	                'title'  => __( 'Choose or Upload an Image', 'inspire-reviews' ),
	                'button' => __( 'Use this image', 'inspire-reviews' ),
	            )
	        );

	        // Enqueue color picker
	        wp_enqueue_style( 'wp-color-picker' );
	        wp_enqueue_script( 'wp-color-picker' );

	        // Enqueue date picker
			wp_enqueue_style( 'jquery-ui-datepicker' );
			wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ), time(), true );	
	 	 
	        // Enqueue the required javascript
	        wp_enqueue_script( 'insprvw_asset', plugin_dir_url( __FILE__ ) . 'assets/js/functions.js' );

	        // Enqueue the required CSS
	        wp_enqueue_style( 'insprvw_asset', plugin_dir_url( __FILE__ ) . 'assets/css/style.css' );
	    }
	}
	add_action( 'admin_enqueue_scripts', 'insprvw_enqueue_assets' );

	// Include multi-use files
	require_once( INSPRVW_DIR . 'types/fields.php' );
	require_once( INSPRVW_DIR . 'types/validation.php' );

	// Book Post Types
	require_once( INSPRVW_DIR . 'types/posts/book/book-review.php' );

	// Movie Post Types
	require_once( INSPRVW_DIR . 'types/posts/video/movie-review.php' );

	// TV Post Types
	require_once( INSPRVW_DIR . 'types/posts/video/tv-review.php' );

	// Post Types
	require_once( INSPRVW_DIR . 'types/posts/post-meta-array.php' );
	require_once( INSPRVW_DIR . 'types/posts/post-meta-boxes.php' );

	// Book Taxonomies
	require_once( INSPRVW_DIR . 'types/taxonomies/book/author.php' );
	require_once( INSPRVW_DIR . 'types/taxonomies/book/category.php' );
	require_once( INSPRVW_DIR . 'types/taxonomies/book/genre.php' );
	require_once( INSPRVW_DIR . 'types/taxonomies/book/publisher.php' );
	require_once( INSPRVW_DIR . 'types/taxonomies/book/tag.php' );

	// Video Taxonomies - For movies and tv
	require_once( INSPRVW_DIR . 'types/taxonomies/video/actor.php' );
	require_once( INSPRVW_DIR . 'types/taxonomies/video/category.php' );
	require_once( INSPRVW_DIR . 'types/taxonomies/video/genre.php' );
	require_once( INSPRVW_DIR . 'types/taxonomies/video/tag.php' );
	require_once( INSPRVW_DIR . 'types/taxonomies/video/theme.php' );

	// Taxonomies
	require_once( INSPRVW_DIR . 'types/taxonomies/term-meta-array.php' );
	require_once( INSPRVW_DIR . 'types/taxonomies/term-meta-boxes.php' );	

	// Functions for display
	require_once( INSPRVW_DIR . 'display/includes/functions.php' );	
	require_once( INSPRVW_DIR . 'display/includes/functions-display.php' );	
	require_once( INSPRVW_DIR . 'display/includes/functions-meta.php' );	
	require_once( INSPRVW_DIR . 'display/includes/functions-json-ld.php' );	

	// Shortcodes
	require_once( INSPRVW_DIR . 'display/includes/shortcode-author-block.php' );
	require_once( INSPRVW_DIR . 'display/includes/shortcode-formatting.php' );	
	require_once( INSPRVW_DIR . 'display/includes/shortcode-recent-reviews.php' );	
