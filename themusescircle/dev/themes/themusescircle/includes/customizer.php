<?php 
	/**
	* Load and create theme customizer options
	*/	
	
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Adds individual sections, settings, and controls
	function themusescircle_customizer_section( $wp_customize ) {
		// Header
	    $wp_customize->add_section(
	        'themusescircle_header',
	        array(
	            'title'	      => __( 'Header', 'themusescircle' ),
	            'description' => __( 'Manage different aspects of the theme header.', 'themusescircle' ),
	            'priority'    => 150
	        )
	    );

	    // Header - Hide search
		$wp_customize->add_setting(
		    'themusescircle_header_hide_search',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_header_hide_search',
		    array(
		        'label'	  => __( 'Hide search bar', 'themusescircle' ),
		        'section' => 'themusescircle_header',
		        'type'	  => 'checkbox'
		    )
		);

		// Front page content
		$wp_customize->add_panel( 
			'themusescircle_front_content', 
			array(
				'title'       => __( 'Front Page Content', 'themusescircle' ),
				'priority'    => 160
			) 
		);

		// About 
	    $wp_customize->add_section(
	        'themusescircle_about',
	        array(
	            'title'		  => __( 'About', 'themusescircle' ),
	            'description' => __( 'Quick information about the site.', 'themusescircle' ),
	            'panel' 	  => 'themusescircle_front_content'
	        )
	    );

	    // About - Hide section
		$wp_customize->add_setting(
		    'themusescircle_about_hide',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_about_hide',
		    array(
		        'label'	  => __( 'Hide section', 'themusescircle' ),
		        'section' => 'themusescircle_about',
		        'type'	  => 'checkbox'
		    )
		);

	    // About - Section title
		$wp_customize->add_setting(
		    'themusescircle_about_title',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_about_title',
		    array(
		        'label'	      => __( 'Section title', 'themusescircle' ),
		        'section'     => 'themusescircle_about',
		        'type'	      => 'text'
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
		        'label'	      => __( 'Left column text', 'themusescircle' ),
		        'section'     => 'themusescircle_about',
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
		        'label'	      => __( 'Right column text', 'themusescircle' ),
		        'description' => __( 'If blank, left column will be full width.', 'themusescircle' ),
		        'section'     => 'themusescircle_about',		        
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
		        'label'	      => __( '"Read More" text', 'themusescircle' ),
		        'section'     => 'themusescircle_about',
		        'type'	      => 'text'
		    )
		);

	    // About - "Read More" url
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
		        'label'	  	  => __( '"Read More" url', 'themusescircle' ),
		        'section'     => 'themusescircle_about',
		        'type'	      => 'url'
		    )
		);	

		// Latest Reviews 
	    $wp_customize->add_section(
	        'themusescircle_recent_reviews',
	        array(
	            'title'		  => __( 'Recent Reviews', 'themusescircle' ),
	            'description' => __( 'Display recent reviews in a carousel.', 'themusescircle' ),
	            'panel' 	  => 'themusescircle_front_content'
	        )
	    );

	    // Latest Reviews - Hide section
		$wp_customize->add_setting(
		    'themusescircle_recent_reviews_hide',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_recent_reviews_hide',
		    array(
		        'label'	  => __( 'Hide section', 'themusescircle' ),
		        'section' => 'themusescircle_recent_reviews',
		        'type'	  => 'checkbox'
		    )
		);

	    // Latest Reviews - Section title
		$wp_customize->add_setting(
		    'themusescircle_recent_reviews_title',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_recent_reviews_title',
		    array(
		        'label'   => __( 'Section title', 'themusescircle' ),
		        'section' => 'themusescircle_recent_reviews',
		        'type'	  => 'text'
		    )
		);

		// Latest Reviews - Number of reviews
		$wp_customize->add_setting(
		    'themusescircle_recent_reviews_number',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_number',
		        'sanitize_js_callback' => 'themusescircle_sanitize_number'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_recent_reviews_number',
		    array(
		        'label'	  => __( 'Number of reviews', 'themusescircle' ),
		        'section' => 'themusescircle_recent_reviews',
		        'type'    => 'text'
		    )
		);

		// Latest Reviews - Hide book reviews
		$wp_customize->add_setting(
		    'themusescircle_recent_reviews_hide_books',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_recent_reviews_hide_books',
		    array(
		        'label'	  => __( 'Hide book reviews', 'themusescircle' ),
		        'section' => 'themusescircle_recent_reviews',
		        'type'    => 'checkbox'
		    )
		);

		// Latest Reviews - Hide movie reviews
		$wp_customize->add_setting(
		    'themusescircle_recent_reviews_hide_movies',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_recent_reviews_hide_movies',
		    array(
		        'label'	  => __( 'Hide movie reviews', 'themusescircle' ),
		        'section' => 'themusescircle_recent_reviews',
		        'type'    => 'checkbox'
		    )
		);

		// Latest Reviews - Hide tv reviews
		$wp_customize->add_setting(
		    'themusescircle_recent_reviews_hide_tv',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_recent_reviews_hide_tv',
		    array(
		        'label'	  => __( 'Hide tv reviews', 'themusescircle' ),
		        'section' => 'themusescircle_recent_reviews',
		        'type'    => 'checkbox'
		    )
		);				

		// Review Buttons
	    $wp_customize->add_section(
	        'themusescircle_review_buttons',
	        array(
	            'title'		  => __( 'Review Buttons', 'themusescircle' ),
	            'description' => __( 'Display buttons to review archive pages.', 'themusescircle' ),
	            'panel' 	  => 'themusescircle_front_content'
	        )
	    );

	    // Review Buttons - Hide section
		$wp_customize->add_setting(
		    'themusescircle_review_buttons_hide',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_review_buttons_hide',
		    array(
		        'label'	  => __( 'Hide section', 'themusescircle' ),
		        'section' => 'themusescircle_review_buttons',
		        'type'	  => 'checkbox'
		    )
		);

	    // Review Buttons - Section title
		$wp_customize->add_setting(
		    'themusescircle_review_buttons_title',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_review_buttons_title',
		    array(
		        'label'   => __( 'Section title', 'themusescircle' ),
		        'section' => 'themusescircle_review_buttons',
		        'type'	  => 'text'
		    )
		);

		// Review Buttons - Book url
		$wp_customize->add_setting(
		    'themusescircle_review_buttons_book_url',
		    array(
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_review_buttons_book_url',
		    array(
		        'label'	  	  => __( 'Book url', 'themusescircle' ),
		        'section'     => 'themusescircle_review_buttons',
		        'type'	      => 'url'
		    )
		);	

	    // Review Buttons - Hide book review button
		$wp_customize->add_setting(
		    'themusescircle_review_buttons_hide_books',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_review_buttons_hide_books',
		    array(
		        'label'	  => __( 'Hide book review button', 'themusescircle' ),
		        'section' => 'themusescircle_review_buttons',
		        'type'	  => 'checkbox'
		    )
		);

		// Review Buttons - Movie url
		$wp_customize->add_setting(
		    'themusescircle_review_buttons_movie_url',
		    array(
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_review_buttons_movie_url',
		    array(
		        'label'	  	  => __( 'Movie url', 'themusescircle' ),
		        'section'     => 'themusescircle_review_buttons',
		        'type'	      => 'url'
		    )
		);	

	    // Review Buttons - Hide movie review button
		$wp_customize->add_setting(
		    'themusescircle_review_buttons_hide_movies',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_review_buttons_hide_movies',
		    array(
		        'label'	  => __( 'Hide movie review button', 'themusescircle' ),
		        'section' => 'themusescircle_review_buttons',
		        'type'	  => 'checkbox'
		    )
		);

		// Review Buttons - TV url
		$wp_customize->add_setting(
		    'themusescircle_review_buttons_tv_url',
		    array(
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_review_buttons_tv_url',
		    array(
		        'label'	  	  => __( 'TV url', 'themusescircle' ),
		        'section'     => 'themusescircle_review_buttons',
		        'type'	      => 'url'
		    )
		);			

	    // Review Buttons - Hide tv review button
		$wp_customize->add_setting(
		    'themusescircle_review_buttons_hide_tv',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_review_buttons_hide_tv',
		    array(
		        'label'	  => __( 'Hide tv review button', 'themusescircle' ),
		        'section' => 'themusescircle_review_buttons',
		        'type'	  => 'checkbox'
		    )
		);

		// Review Buttons - "Everything" url
		$wp_customize->add_setting(
		    'themusescircle_review_buttons_everything_url',
		    array(
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_review_buttons_everything_url',
		    array(
		        'label'	  	  => __( '"Everything" url', 'themusescircle' ),
		        'section'     => 'themusescircle_review_buttons',
		        'type'	      => 'url'
		    )
		);			

	    // Review Buttons - Hide "Everything" review button
		$wp_customize->add_setting(
		    'themusescircle_review_buttons_hide_everything',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_review_buttons_hide_everything',
		    array(
		        'label'	  => __( 'Hide "Everything" review button', 'themusescircle' ),
		        'section' => 'themusescircle_review_buttons',
		        'type'	  => 'checkbox'
		    )
		);

		// From the Blog
	    $wp_customize->add_section(
	        'themusescircle_from_blog',
	        array(
	            'title'		  => __( 'From the Blog', 'themusescircle' ),
	            'description' => __( 'Display the latest blog posts.', 'themusescircle' ),
	            'panel' 	  => 'themusescircle_front_content'
	        )
	    );

	    // From the Blog - Hide section
		$wp_customize->add_setting(
		    'themusescircle_from_blog_hide',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_from_blog_hide',
		    array(
		        'label'	  => __( 'Hide section', 'themusescircle' ),
		        'section' => 'themusescircle_from_blog',
		        'type'	  => 'checkbox'
		    )
		);

	    // From the Blog - Section title
		$wp_customize->add_setting(
		    'themusescircle_from_blog_title',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_from_blog_title',
		    array(
		        'label'	      => __( 'Section title', 'themusescircle' ),
		        'section'     => 'themusescircle_from_blog',
		        'type'	      => 'text'
		    )
		);	

		// From the Blog - Number of posts
		$wp_customize->add_setting(
		    'themusescircle_from_blog_number',
		    array(
		        'sanitize_callback'	   => 'themusescircle_sanitize_number',
		        'sanitize_js_callback' => 'themusescircle_sanitize_number'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_from_blog_number',
		    array(
		        'label'	      => __( 'Number of posts', 'themusescircle' ),
		        'section'     => 'themusescircle_from_blog',
		        'type'	      => 'text'
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