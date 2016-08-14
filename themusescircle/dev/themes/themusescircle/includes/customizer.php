<?php 
	/**
	* Load and create theme customizer options
	*/	
	
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Adds individual sections, settings, and controls
	function themusescircle_customizer_section( $wp_customize ) {
		$wp_customize->add_panel( 
			'testtest', 
			array(
				'title'       => __( 'testing', 'themusescircle' ),
				'description' => __( 'Description.', 'themusescircle' ),
				'priority'    => 160
			) 
		);

		// Social Media
	    $wp_customize->add_section(
	        'testtest_section',
	        array(
	            'title'		  => __( 'About Site', 'themusescircle' ),
	            'description' => __( 'Information related to site on static front page.', 'themusescircle' ),
	            'panel' 	  => 'testtest',
	        )
	    );

	    // Static Front Page - Hide Header Search
		$wp_customize->add_setting(
		    'testtest_field',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'testtest_field',
		    array(
		        'label'	  => __( 'Hide search bar in header', 'themusescircle' ),
		        'section' => 'testtest_section',
		        'type'	  => 'checkbox'
		    )
		);

		// $wp_customize->add_section( $section_id , array(
		// 'title' => $menu->name,
		// 'panel' => 'menus',
		// ) );





	    // Static Front Page - Hide Header Search
		$wp_customize->add_setting(
		    'themusescircle_hide_search',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_hide_search',
		    array(
		        'label'	  => __( 'Hide search bar in header', 'themusescircle' ),
		        'section' => 'static_front_page',
		        'type'	  => 'checkbox'
		    )
		);

		// Social Media
	    $wp_customize->add_section(
	        'themusescircle_about',
	        array(
	            'title'		  => __( 'About Site', 'themusescircle' ),
	            'description' => __( 'Information related to site on static front page.', 'themusescircle' )
	        )
	    );

		// About - Left Column
		$wp_customize->add_setting(
		    'themusescircle_about_left',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_textarea',
		        'sanitize_js_callback' => 'themusescircle_sanitize_textarea'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_about_left',
		    array(
		        'label'	  => __( 'Left Column Text', 'ambase' ),
		        'section' => 'themusescircle_about',
		        'type'	  => 'textarea'
		    )
		);	

		// About - Right Column
		$wp_customize->add_setting(
		    'themusescircle_about_right',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_textarea',
		        'sanitize_js_callback' => 'themusescircle_sanitize_textarea'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_about_right',
		    array(
		        'label'	      => __( 'Right Column Text', 'ambase' ),
		        'section'     => 'themusescircle_about',
		        'description' => __( 'If blank, right column will not show and left column will be full width.', 'ambase' ),
		        'type'	      => 'textarea'
		    )
		);	

	    // About - Read More Text
		$wp_customize->add_setting(
		    'themusescircle_about_more',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_about_more',
		    array(
		        'label'	      => __( 'Read More Text', 'ambase' ),
		        'description' => __( 'If blank, url will not show.', 'ambase' ),
		        'section'     => 'themusescircle_about',
		        'type'	      => 'text'
		    )
		);

	    // About - Read More Link
		$wp_customize->add_setting(
		    'themusescircle_about_more_url',
		    array(
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_about_more_url',
		    array(
		        'label'	  => __( 'Read More Link', 'themusescircle' ),
		        'section' => 'themusescircle_about',
		        'type'	  => 'url'
		    )
		);		

		// Social Media
	    $wp_customize->add_section(
	        'themusescircle_social',
	        array(
	            'title'		  => __( 'Social Media', 'themusescircle' ),
	            'description' => __( 'Add links for website social media.', 'themusescircle' )
	        )
	    );

	    // Social Media - Facebook
		$wp_customize->add_setting(
		    'themusescircle_facebook',
		    array(
		    	'default'			   => __( 'http://www.facebook.com', 'themusescircle' ),
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_facebook',
		    array(
		        'label'	  => __( 'Facebook', 'themusescircle' ),
		        'section' => 'themusescircle_social',
		        'type'	  => 'url'
		    )
		);		

	    // Social Media - Google+
		$wp_customize->add_setting(
		    'themusescircle_gplus',
		    array(
		    	'default'			   => __( 'http://www.google.com', 'themusescircle' ),
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_gplus',
		    array(
		        'label'	  => __( 'Google+', 'themusescircle' ),
		        'section' => 'themusescircle_social',
		        'type'	  => 'url'
		    )
		);	

	    // Social Media - LinkedIn
		$wp_customize->add_setting(
		    'themusescircle_youtube',
		    array(
		    	'default'			   => __( 'http://www.youtube.com', 'themusescircle' ),
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_youtube',
		    array(
		        'label'	  => __( 'YouTube', 'themusescircle' ),
		        'section' => 'themusescircle_social',
		        'type'	  => 'url'
		    )
		);	

	    // Social Media - Twitter
		$wp_customize->add_setting(
		    'themusescircle_twitter',
		    array(
		    	'default'			   => __( 'http://www.twitter.com', 'themusescircle' ),
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_twitter',
		    array(
		        'label'	  => __( 'Twitter', 'themusescircle' ),
		        'section' => 'themusescircle_social',
		        'type'	  => 'url'
		    )
		);	

	    // Social Media - Goodreads
		$wp_customize->add_setting(
		    'themusescircle_goodreads',
		    array(
		    	'default'			   => __( 'http://www.goodreads.com', 'themusescircle' ),
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_goodreads',
		    array(
		        'label'	  => __( 'Goodreads', 'themusescircle' ),
		        'section' => 'themusescircle_social',
		        'type'	  => 'url'
		    )
		);	

	    // Social Media - Library Thing
		$wp_customize->add_setting(
		    'themusescircle_librarything',
		    array(
		    	'default'			   => __( 'http://www.librarything.com', 'themusescircle' ),
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_librarything',
		    array(
		        'label'	  => __( 'Library Thing', 'themusescircle' ),
		        'section' => 'themusescircle_social',
		        'type'	  => 'url'
		    )
		);											
	}
	add_action( 'customize_register', 'themusescircle_customizer_section' );