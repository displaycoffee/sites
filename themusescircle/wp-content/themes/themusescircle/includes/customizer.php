<?php 
	/**
	* Load and create theme customizer options
	*/	
	
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Adds individual sections, settings, and controls
	function themusescircle_customizer_section( $wp_customize ) {
		// Section 01
	    $wp_customize->add_section(
	        'themusescircle_section01',
	        array(
	            'title'		  => __( 'Section 01', 'themusescircle' ),
	            'description' => __( 'These are settings for section 01.', 'themusescircle' )
	        )
	    );

	    // Section 01 - Text
		$wp_customize->add_setting(
		    'themusescircle_text',
		    array(
		    	'default'			   => __( 'Default text field', 'themusescircle' ),
		        'sanitize_callback'	   => 'sanitize_text_field',
		        'sanitize_js_callback' => 'sanitize_text_field'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_text',
		    array(
		        'label'	  => __( 'Text', 'themusescircle' ),
		        'section' => 'themusescircle_section01',
		        'type'	  => 'text'
		    )
		);

	    // Section 01 - URL
		$wp_customize->add_setting(
		    'themusescircle_url',
		    array(
		    	'default'			   => __( 'http://www.wordpress.com', 'themusescircle' ),
		        'sanitize_callback'	   => 'esc_url',
		        'sanitize_js_callback' => 'esc_url'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_url',
		    array(
		        'label'	  => __( 'URL', 'themusescircle' ),
		        'section' => 'themusescircle_section01',
		        'type'	  => 'url'
		    )
		);

	    // Section 01 - Textarea
		$wp_customize->add_setting(
		    'themusescircle_textarea',
		    array(
		    	'default'			   => __( 'Default textarea field', 'themusescircle' ),
		        'sanitize_callback'	   => 'themusescircle_sanitize_textarea',
		        'sanitize_js_callback' => 'themusescircle_sanitize_textarea'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_textarea',
		    array(
		        'label'	  => __( 'Textarea', 'themusescircle' ),
		        'section' => 'themusescircle_section01',
		        'type'	  => 'textarea'
		    )
		);	

	    // Section 01 - Select
		$wp_customize->add_setting(
		    'themusescircle_select',
		    array(
		    	'default'			   => __( 'Option 01', 'themusescircle' ),
		        'sanitize_callback'	   => 'themusescircle_sanitize_select',
		        'sanitize_js_callback' => 'themusescircle_sanitize_select'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_select',
		    array(
		        'label'	  => __( 'Select', 'themusescircle' ),
		        'section' => 'themusescircle_section01',
		        'type'	  => 'select',
		        'choices' => themusescircle_select_choices()
		    )
		);

	    // Section 01 - Radio
		$wp_customize->add_setting(
		    'themusescircle_radio',
		    array(
		    	'default'			   => __( 'Yes', 'themusescircle' ),
		        'sanitize_callback'	   => 'themusescircle_sanitize_radio',
		        'sanitize_js_callback' => 'themusescircle_sanitize_radio'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_radio',
		    array(
		        'label'	  => __( 'Radio', 'themusescircle' ),
		        'section' => 'themusescircle_section01',
		        'type'	  => 'radio',
		        'choices' => themusescircle_radio_choices()
		    )
		);

	    // Section 02 - Checkbox
		$wp_customize->add_setting(
		    'themusescircle_checkbox',
		    array(
		    	'default'			   => __( '1', 'themusescircle' ),
		        'sanitize_callback'	   => 'themusescircle_sanatize_checkbox',
		        'sanitize_js_callback' => 'themusescircle_sanatize_checkbox'
		    )
		);
		$wp_customize->add_control(
		    'themusescircle_checkbox',
		    array(
		        'label'	  => __( 'Checkbox', 'themusescircle' ),
		        'section' => 'themusescircle_section01',
		        'type'	  => 'checkbox'
		    )
		);

        // Section 02
	    $wp_customize->add_section(
	        'themusescircle_section02',
	        array(
	            'title'		  => __( 'Section 02', 'themusescircle' ),
	            'description' => __( 'These are settings for section 02.', 'themusescircle' )
	        )
	    );

		// Section 02 - Date picker
		$wp_customize->add_setting(
		    'themusescircle_date',
		    array(
		    	'default'			   => __( '', 'themusescircle' ),
		        'sanitize_callback'	   => 'themusescircle_sanitize_date',
		        'sanitize_js_callback' => 'themusescircle_sanitize_date'
		    )
		);
		$wp_customize->add_control(
		    new themusescircle_Date_Picker( $wp_customize, 'themusescircle_date', 
			    array(		        
			        'label'	   => __( 'Date Picker', 'themusescircle' ),
			        'section'  => 'themusescircle_section02',
			        'settings' => 'themusescircle_date'
			    )
			)
		);

		// Section 02 - Page list
		$wp_customize->add_setting(
		    'themusescircle_page',		    
		    array(
		    	'default'			   => __( '0', 'themusescircle' ),
		        'sanitize_callback'	   => 'themusescircle_sanitize_number',
		        'sanitize_js_callback' => 'themusescircle_sanitize_number'
		    )
		);		 
		$wp_customize->add_control(
		    'themusescircle_page',
		    array(		        
		        'label'	  => __( 'Choose a page', 'themusescircle' ),
		        'section' => 'themusescircle_section02',
		        'type'	  => 'dropdown-pages'
		    )
		);

		// Section 02 - Color
		$wp_customize->add_setting(
		    'themusescircle_color',		    
		    array(
		    	'default'			   => __( '#000000', 'themusescircle' ),
		        'sanitize_callback'	   => 'sanitize_hex_color',
		        'sanitize_js_callback' => 'sanitize_hex_color'
		    )
		);		 
		$wp_customize->add_control(
		    new WP_Customize_Color_Control(
		        $wp_customize,
			    'themusescircle_color',
			    array(		        
			        'label'	   => __( 'Color', 'themusescircle' ),
			        'section'  => 'themusescircle_section02',
			        'settings' => 'themusescircle_color'
			    )
		    )
		);

		// Section 02 - File upload
		$wp_customize->add_setting(
		    'themusescircle_file'
		);		
		$wp_customize->add_control(
		    new WP_Customize_Upload_Control(
		        $wp_customize,
		        'themusescircle_file',
		        array(
		            'label'	   => __( 'File Upload', 'themusescircle' ),
		            'section'  => 'themusescircle_section02',
		            'settings' => 'themusescircle_file'
		        )
		    )
		);

		// Section 02 - Image upload
		$wp_customize->add_setting(
		    'themusescircle_image'
		);		
		$wp_customize->add_control(
		    new WP_Customize_Image_Control(
		        $wp_customize,
		        'themusescircle_image',
		        array(
		            'label'	   => __( 'Image Upload', 'themusescircle' ),
		            'section'  => 'themusescircle_section02',
		            'settings' => 'themusescircle_image'
		        )
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
	}
	add_action( 'customize_register', 'themusescircle_customizer_section' );