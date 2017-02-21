<?php
	/**
	* Functions specific to musescircle theme
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Set up theme options
	function musescircle_setup() {
		// Load theme text domain
		load_theme_textdomain( 'musescircle', get_template_directory() . '/languages' );

		// Add them support options
		add_theme_support( 'title-tag' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'post-thumbnails' );
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );	

		// Add support for posts/pages
		add_post_type_support( 'page', 'excerpt' );

		// Register navigation menus
		register_nav_menus( array(
			'main-menu'   => __( 'Main Menu', 'musescircle' ),
			'footer-menu' => __( 'Footer Menu', 'musescircle' ),
			'social-menu' => __( 'Social Media Menu', 'musescircle' )
		) );
	}
	add_action( 'after_setup_theme', 'musescircle_setup' );	

	// Add theme related scripts
	function musescircle_load_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'functions', get_template_directory_uri () . '/assets/js/functions.js', 'jquery', '', true );

		// Get blog url to use in JavaScript
		wp_localize_script( 'functions', 'wpurl', array( 'siteurl' => get_option( 'siteurl' ) ) );
	}
	add_action( 'wp_enqueue_scripts', 'musescircle_load_scripts' );

	// Enable shortcodes in text widgets
	add_filter( 'widget_text', 'do_shortcode' );
	
	// Add user contact methods
	function musescircle_user_contact_methods( $user_contact ) {		
		$user_contact['facebook']  = __( 'Facebook', 'musescircle' );
		$user_contact['gplus']     = __( 'Google+', 'musescircle' );
		$user_contact['linkedin']  = __( 'LinkedIn', 'musescircle' );
		$user_contact['twitter']   = __( 'Twitter', 'musescircle' );
		$user_contact['instagram'] = __( 'Instagram', 'musescircle' );
		$user_contact['youtube']   = __( 'YouTube', 'musescircle' );
		$user_contact['pinterest'] = __( 'Pinterest', 'musescircle' );
		$user_contact['tumblr']    = __( 'Tumblr', 'musescircle' );
		$user_contact['goodreads'] = __( 'Goodreads', 'musescircle' );
		return $user_contact;
	}
	add_filter( 'user_contactmethods', 'musescircle_user_contact_methods' );

    // Parse date into an array to check values
    function musescircle_parse_date( $date ) {
		$date_array = date_parse( $date );

		// Check if the date contains a parseable month, year, and day, and there's no errors
		if ( $date_array['year'] && $date_array['month'] && $date_array['day'] && $date_array['error_count'] <= 0 ) {
			return true;
		} else {
			return false;
		}
	}

	// Include extra function files
	require_once( 'includes/functions-display.php' );
	require_once( 'includes/functions-json-ld.php' );

	// Include shortcode file
	require_once( 'includes/shortcodes.php' );	

	// Include customizer files
	require_once( 'customizer/customizer-enqueue.php' );	
	require_once( 'customizer/customizer-choices.php' );
	require_once( 'customizer/customizer-date-picker.php' );
	require_once( 'customizer/customizer-validation.php' );
	require_once( 'customizer/customizer.php' );