<?php 
	/**
	* Load and create theme customizer options
	*/	
	
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Adds individual sections, settings, and controls
	function musescircle_customizer_section( $wp_customize ) {
		// Header
	    $wp_customize->add_section(
	        'musescircle_header',
	        array(
	            'title'	      => __( 'Header', 'musescircle' ),
	            'description' => __( 'Manage different aspects of the theme header.', 'musescircle' ),
	            'priority'    => 150
	        )
	    );

	    // Header - Hide search
		$wp_customize->add_setting(
		    'musescircle_header_hide_search',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_header_hide_search',
		    array(
		        'label'	  => __( 'Hide search bar', 'musescircle' ),
		        'section' => 'musescircle_header',
		        'type'	  => 'checkbox'
		    )
		);

		// Front page content
		$wp_customize->add_panel( 
			'musescircle_front_content', 
			array(
				'title'       => __( 'Front Page Content', 'musescircle' ),
				'priority'    => 160
			) 
		);

		// About 
	    $wp_customize->add_section(
	        'musescircle_about',
	        array(
	            'title'		  => __( 'About', 'musescircle' ),
	            'description' => __( 'Quick information about the site.', 'musescircle' ),
	            'panel' 	  => 'musescircle_front_content'
	        )
	    );

	    // About - Hide section
		$wp_customize->add_setting(
		    'musescircle_about_hide',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_about_hide',
		    array(
		        'label'	  => __( 'Hide section', 'musescircle' ),
		        'section' => 'musescircle_about',
		        'type'	  => 'checkbox'
		    )
		);

	    // About - Section title
		$wp_customize->add_setting(
		    'musescircle_about_title',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_about_title',
		    array(
		        'label'	      => __( 'Section title', 'musescircle' ),
		        'section'     => 'musescircle_about',
		        'type'	      => 'text'
		    )
		);

		// About - Left column
		$wp_customize->add_setting(
		    'musescircle_about_left',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_textarea',
		        'sanitize_js_callback' => 'musescircle_sanitize_textarea'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_about_left',
		    array(
		        'label'	      => __( 'Left column text', 'musescircle' ),
		        'section'     => 'musescircle_about',
		        'type'	      => 'textarea'
		    )
		);		
		
		// About - Right column
		$wp_customize->add_setting(
		    'musescircle_about_right',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_textarea',
		        'sanitize_js_callback' => 'musescircle_sanitize_textarea'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_about_right',
		    array(
		        'label'	      => __( 'Right column text', 'musescircle' ),
		        'description' => __( 'If blank, left column will be full width.', 'musescircle' ),
		        'section'     => 'musescircle_about',		        
		        'type'	      => 'textarea'
		    )
		);				

	    // About - "Read More" text
		$wp_customize->add_setting(
		    'musescircle_about_more_text',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_about_more_text',
		    array(
		        'label'	      => __( '"Read More" text', 'musescircle' ),
		        'section'     => 'musescircle_about',
		        'type'	      => 'text'
		    )
		);

	    // About - "Read More" URL
		$wp_customize->add_setting(
		    'musescircle_about_more_url',
		    array(
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_about_more_url',
		    array(
		        'label'	  	  => __( '"Read More" URL', 'musescircle' ),
		        'section'     => 'musescircle_about',
		        'type'	      => 'url'
		    )
		);	

		// Countdown Promotion 
	    $wp_customize->add_section(
	        'musescircle_countdown_promotion',
	        array(
	            'title'		  => __( 'Countdown Promotion', 'musescircle' ),
	            'description' => __( 'Promote a book, movie, or tv release with a countdown timer.', 'musescircle' ),
	            'panel' 	  => 'musescircle_front_content'
	        )
	    );

	    // Countdown Promotion - Hide section
		$wp_customize->add_setting(
		    'musescircle_countdown_promotion_hide',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_countdown_promotion_hide',
		    array(
		        'label'	  => __( 'Hide section', 'musescircle' ),
		        'section' => 'musescircle_countdown_promotion',
		        'type'	  => 'checkbox'
		    )
		);

		// Countdown Promotion - Date
		$wp_customize->add_setting(
		    'musescircle_countdown_promotion_date',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_date',
		        'sanitize_js_callback' => 'musescircle_sanitize_date'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_countdown_promotion_date',
		    array(
		        'label'	      => __( 'End date', 'musescircle' ),
		        'description' => __( 'If blank, countdown will not show.', 'musescircle' ),
		        'section'     => 'musescircle_countdown_promotion',
		        'type'	      => 'date'
		    )
		);		
		
		// Countdown Promotion - Content
		$wp_customize->add_setting(
		    'musescircle_countdown_promotion_content',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_countdown_promotion_content',
		    array(
		        'label'	      => __( 'Content', 'musescircle' ),
		        'section'     => 'musescircle_countdown_promotion',		        
		        'type'	      => 'text'
		    )
		);				

	    // Countdown Promotion - URL
		$wp_customize->add_setting(
		    'musescircle_countdown_promotion_url',
		    array(
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_countdown_promotion_url',
		    array(
		        'label'	      => __( 'URL', 'musescircle' ),
		        'section'     => 'musescircle_countdown_promotion',
		        'type'	      => 'text'
		    )
		);

	    // Countdown Promotion - New Window
		$wp_customize->add_setting(
		    'musescircle_countdown_promotion_new_window',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_countdown_promotion_new_window',
		    array(
		        'label'	  => __( 'Open URL in new window', 'musescircle' ),
		        'section' => 'musescircle_countdown_promotion',
		        'type'	  => 'checkbox'
		    )
		);			

		// Latest Reviews 
	    $wp_customize->add_section(
	        'musescircle_recent_reviews',
	        array(
	            'title'		  => __( 'Recent Reviews', 'musescircle' ),
	            'description' => __( 'Display recent reviews in a carousel.', 'musescircle' ),
	            'panel' 	  => 'musescircle_front_content'
	        )
	    );

	    // Latest Reviews - Hide section
		$wp_customize->add_setting(
		    'musescircle_recent_reviews_hide',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_recent_reviews_hide',
		    array(
		        'label'	  => __( 'Hide section', 'musescircle' ),
		        'section' => 'musescircle_recent_reviews',
		        'type'	  => 'checkbox'
		    )
		);

	    // Latest Reviews - Section title
		$wp_customize->add_setting(
		    'musescircle_recent_reviews_title',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_recent_reviews_title',
		    array(
		        'label'   => __( 'Section title', 'musescircle' ),
		        'section' => 'musescircle_recent_reviews',
		        'type'	  => 'text'
		    )
		);

		// Latest Reviews - Number of reviews
		$wp_customize->add_setting(
		    'musescircle_recent_reviews_number',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_number',
		        'sanitize_js_callback' => 'musescircle_sanitize_number'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_recent_reviews_number',
		    array(
		        'label'	  => __( 'Number of reviews', 'musescircle' ),
		        'section' => 'musescircle_recent_reviews',
		        'type'    => 'text'
		    )
		);

		// Latest Reviews - Hide book reviews
		$wp_customize->add_setting(
		    'musescircle_recent_reviews_hide_books',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_recent_reviews_hide_books',
		    array(
		        'label'	  => __( 'Hide book reviews', 'musescircle' ),
		        'section' => 'musescircle_recent_reviews',
		        'type'    => 'checkbox'
		    )
		);

		// Latest Reviews - Hide movie reviews
		$wp_customize->add_setting(
		    'musescircle_recent_reviews_hide_movies',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_recent_reviews_hide_movies',
		    array(
		        'label'	  => __( 'Hide movie reviews', 'musescircle' ),
		        'section' => 'musescircle_recent_reviews',
		        'type'    => 'checkbox'
		    )
		);

		// Latest Reviews - Hide tv reviews
		$wp_customize->add_setting(
		    'musescircle_recent_reviews_hide_tv',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_recent_reviews_hide_tv',
		    array(
		        'label'	  => __( 'Hide tv reviews', 'musescircle' ),
		        'section' => 'musescircle_recent_reviews',
		        'type'    => 'checkbox'
		    )
		);				

		// Review Buttons
	    $wp_customize->add_section(
	        'musescircle_review_buttons',
	        array(
	            'title'		  => __( 'Review Buttons', 'musescircle' ),
	            'description' => __( 'Display buttons to review archive pages.', 'musescircle' ),
	            'panel' 	  => 'musescircle_front_content'
	        )
	    );

	    // Review Buttons - Hide section
		$wp_customize->add_setting(
		    'musescircle_review_buttons_hide',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_review_buttons_hide',
		    array(
		        'label'	  => __( 'Hide section', 'musescircle' ),
		        'section' => 'musescircle_review_buttons',
		        'type'	  => 'checkbox'
		    )
		);

	    // Review Buttons - Section title
		$wp_customize->add_setting(
		    'musescircle_review_buttons_title',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_review_buttons_title',
		    array(
		        'label'   => __( 'Section title', 'musescircle' ),
		        'section' => 'musescircle_review_buttons',
		        'type'	  => 'text'
		    )
		);

		// Review Buttons - Book URL
		$wp_customize->add_setting(
		    'musescircle_review_buttons_book_url',
		    array(
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_review_buttons_book_url',
		    array(
		        'label'	  	  => __( 'Book URL', 'musescircle' ),
		        'section'     => 'musescircle_review_buttons',
		        'type'	      => 'url'
		    )
		);	

	    // Review Buttons - Hide book review button
		$wp_customize->add_setting(
		    'musescircle_review_buttons_hide_books',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_review_buttons_hide_books',
		    array(
		        'label'	  => __( 'Hide book review button', 'musescircle' ),
		        'section' => 'musescircle_review_buttons',
		        'type'	  => 'checkbox'
		    )
		);

		// Review Buttons - Movie URL
		$wp_customize->add_setting(
		    'musescircle_review_buttons_movie_url',
		    array(
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_review_buttons_movie_url',
		    array(
		        'label'	  	  => __( 'Movie URL', 'musescircle' ),
		        'section'     => 'musescircle_review_buttons',
		        'type'	      => 'url'
		    )
		);	

	    // Review Buttons - Hide movie review button
		$wp_customize->add_setting(
		    'musescircle_review_buttons_hide_movies',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_review_buttons_hide_movies',
		    array(
		        'label'	  => __( 'Hide movie review button', 'musescircle' ),
		        'section' => 'musescircle_review_buttons',
		        'type'	  => 'checkbox'
		    )
		);

		// Review Buttons - TV URL
		$wp_customize->add_setting(
		    'musescircle_review_buttons_tv_url',
		    array(
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_review_buttons_tv_url',
		    array(
		        'label'	  	  => __( 'TV URL', 'musescircle' ),
		        'section'     => 'musescircle_review_buttons',
		        'type'	      => 'url'
		    )
		);			

	    // Review Buttons - Hide tv review button
		$wp_customize->add_setting(
		    'musescircle_review_buttons_hide_tv',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_review_buttons_hide_tv',
		    array(
		        'label'	  => __( 'Hide tv review button', 'musescircle' ),
		        'section' => 'musescircle_review_buttons',
		        'type'	  => 'checkbox'
		    )
		);

		// Review Buttons - "Everything" URL
		$wp_customize->add_setting(
		    'musescircle_review_buttons_everything_url',
		    array(
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_review_buttons_everything_url',
		    array(
		        'label'	  	  => __( '"Everything" URL', 'musescircle' ),
		        'section'     => 'musescircle_review_buttons',
		        'type'	      => 'url'
		    )
		);			

	    // Review Buttons - Hide "Everything" review button
		$wp_customize->add_setting(
		    'musescircle_review_buttons_hide_everything',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_review_buttons_hide_everything',
		    array(
		        'label'	  => __( 'Hide "Everything" review button', 'musescircle' ),
		        'section' => 'musescircle_review_buttons',
		        'type'	  => 'checkbox'
		    )
		);

		// From the Blog
	    $wp_customize->add_section(
	        'musescircle_from_blog',
	        array(
	            'title'		  => __( 'From the Blog', 'musescircle' ),
	            'description' => __( 'Display the latest blog posts.', 'musescircle' ),
	            'panel' 	  => 'musescircle_front_content'
	        )
	    );

	    // From the Blog - Hide section
		$wp_customize->add_setting(
		    'musescircle_from_blog_hide',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_checkbox',
		        'sanitize_js_callback' => 'musescircle_sanitize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_from_blog_hide',
		    array(
		        'label'	  => __( 'Hide section', 'musescircle' ),
		        'section' => 'musescircle_from_blog',
		        'type'	  => 'checkbox'
		    )
		);

	    // From the Blog - Section title
		$wp_customize->add_setting(
		    'musescircle_from_blog_title',
		    array(
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_from_blog_title',
		    array(
		        'label'	      => __( 'Section title', 'musescircle' ),
		        'section'     => 'musescircle_from_blog',
		        'type'	      => 'text'
		    )
		);	

		// From the Blog - Number of posts
		$wp_customize->add_setting(
		    'musescircle_from_blog_number',
		    array(
		        'sanitize_callback'	   => 'musescircle_sanitize_number',
		        'sanitize_js_callback' => 'musescircle_sanitize_number'
		    )
		);
		$wp_customize->add_control(
		    'musescircle_from_blog_number',
		    array(
		        'label'	      => __( 'Number of posts', 'musescircle' ),
		        'section'     => 'musescircle_from_blog',
		        'type'	      => 'text'
		    )
		);										
	}
	add_action( 'customize_register', 'musescircle_customizer_section' );