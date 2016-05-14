<?php
	/**
	* Plugin Name: Inspire Reviews
	* Plugin URI: http://neverend.org/adria
	* Description: Used for reviewing various types of media such as books, movies, and tv shows.
	* Author: Adria Murphy
	* Author URI: http://neverend.org/adria
	* Version: 4.0
	* Text Domain: inspire-reviews
	**/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Load plugin text domain
	function insprvw_load_textdomain() {
		load_plugin_textdomain( 'inspire-reviews', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' ); 
	}

	// Loads necessary javascript and CSS
	function insprvw_enqueue_assets() {
	    global $typenow;
	    if ( $typenow == 'insprvw-book-review' || $typenow == 'insprvw-movie-review' || $typenow == 'insprvw-show-review' ) {
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
	require_once( 'includes/fields.php' );
	require_once( 'includes/validation.php' );

	// Book Post Types
	require_once( 'types/posts/book/review.php' );

	// Movie Post Types
	require_once( 'types/posts/movie/review.php' );

	// Show Post Types
	require_once( 'types/posts/show/review.php' );

	// Post Types
	require_once( 'types/posts/post-meta-array.php' );
	require_once( 'types/posts/post-meta-boxes.php' );

	// Book Taxonomies
	require_once( 'types/taxonomies/book/author.php' );
	require_once( 'types/taxonomies/book/category.php' );
	require_once( 'types/taxonomies/book/genre.php' );
	require_once( 'types/taxonomies/book/publisher.php' );
	require_once( 'types/taxonomies/book/tag.php' );

	// Video Taxonomies - For movies and tv shows
	require_once( 'types/taxonomies/video/actor.php' );
	require_once( 'types/taxonomies/video/category.php' );
	require_once( 'types/taxonomies/video/genre.php' );
	require_once( 'types/taxonomies/video/tag.php' );
	require_once( 'types/taxonomies/video/theme.php' );

	// Taxonomies
	require_once( 'types/taxonomies/term-meta-array.php' );
	require_once( 'types/taxonomies/term-meta-boxes.php' );	

	// Display
	// require_once( 'display/display-cat-public.php' );	
	// require_once( 'display/display-options.php' );	
	// require_once( 'display/display-post-type.php' );	