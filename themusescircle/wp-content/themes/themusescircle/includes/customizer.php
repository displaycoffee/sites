<?php 
	/**
	* Load and create theme customizer options
	*/	
	
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Adds individual sections, settings, and controls
	function themusescircle_customizer_section( $wp_customize ) {
		// Home Page
		$wp_customize->add_panel( 
			'themusescircle_front_content', 
			array(
				'title'       => __( 'Front Page Content', 'themusescircle' ),
				'description' => __( 'Here you can manage the content sections seen on the front page.', 'themusescircle' ),
				'priority'    => 160
			) 
		);

		// About 
	    $wp_customize->add_section(
	        'themusescircle_front_about',
	        array(
	            'title'		  => __( 'About', 'themusescircle' ),
	            'description' => __( 'Quick information about the site.', 'themusescircle' ),
	            'panel' 	  => 'themusescircle_front_content',
	        )
	    );

	    // About - Show section
		$wp_customize->add_setting(
		    'themusescircle_hide_about',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_hide_about',
		    array(
		        'label'	  => __( 'Hide "About" section', 'themusescircle' ),
		        'section' => 'themusescircle_front_about',
		        'type'	  => 'checkbox'
		    )
		);

		// About - Left column
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
		        'label'	      => __( 'Left column text', 'ambase' ),
		        'description' => __( 'In addition to the checkbox above, leaving this column blank will hide the "About" section.', 'ambase' ),
		        'section'     => 'themusescircle_front_about',
		        'type'	      => 'textarea'
		    )
		);		
		
		// About - Right column
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
		        'label'	      => __( 'Right column text', 'ambase' ),
		        'description' => __( 'If blank, right column will not show and left column will be full width.', 'ambase' ),
		        'section'     => 'themusescircle_front_about',		        
		        'type'	      => 'textarea'
		    )
		);				

	    // About - "Read More" text
		$wp_customize->add_setting(
		    'themusescircle_about_more_text',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_about_more_text',
		    array(
		        'label'	      => __( '"Read More" text', 'ambase' ),
		        'description' => __( 'Default text is "Read More".', 'ambase' ),
		        'section'     => 'themusescircle_front_about',
		        'type'	      => 'text'
		    )
		);

	    // About - "Read More" link
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
		        'label'	  	  => __( '"Read More" link', 'themusescircle' ),
		        'description' => __( 'If blank, link will not show.', 'ambase' ),
		        'section'     => 'themusescircle_front_about',
		        'type'	      => 'url'
		    )
		);	

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