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

	// Get custom archive post templates
	function insprvw_get_archive_template( $archive ) {
		// Book review archive
		if ( get_post_type() == 'insprvw-book-review' ) {
			$archive = dirname( __FILE__ ) . '/templates/archive-book-review.php';
		}
		return $archive;
	}
	add_filter( 'archive_template', 'insprvw_get_archive_template' ) ;


	// Trim default excerpt length
	function insprvw_excerpt_length( $length ) {
	    return 50;
	}
	add_filter( 'excerpt_length', 'insprvw_excerpt_length' );

	// Change text if excerpt length is reached
	function insprvw_excerpt_more( $more ) {
	    return '...';
	}
	add_filter( 'excerpt_more', 'insprvw_excerpt_more' );

	// Custom read more link for excerpts
	function insprvw_read_more() {
	    return '<div class="read-more"><a href="' . esc_url( get_permalink( get_the_ID() ) ) . '">' . __( 'Read More', 'inspire-reviews' ) . '</a></div>';
	}

	// Check if there is a custom excerpt and if so, make sure it's not too long
	function insprvw_excerpt() {
		if ( has_excerpt() ) {	    
		    return '<p>' . wp_trim_words( get_the_excerpt(), 50 ) . '</p>' . insprvw_read_more();
		} else {
			return '<p>' . get_the_excerpt() . '</p>' . insprvw_read_more();
		}
	}