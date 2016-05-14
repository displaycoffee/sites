<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Create text styles
	function opc_create_content_style( $color, $shadow, $postID, $selector ) {
		if ( $color || $shadow ) {
			$style = '#slide-' . $postID . ' ' . $selector . '{';
			$style .= $color ? 'color:' . esc_attr( $color ) . ';' : '';
			$style .= ( $shadow == 1 ) ? 'text-shadow:2px 2px 2px #000;' : '';
			$style .= '}';
			return $style;
		}
	}

	// Create position
	function opc_create_value( $value ) {
		if ( $value == '0' ) {
			return '0';
		} elseif ( is_numeric( $value) ) {
			return esc_attr( $value . 'px' );
		} elseif( strtolower( $value ) == 'auto' ) {
			return 'auto';
		} else {
			return null;
		}
	}	

	// Loop through post type and create a shortcode for slider display
	function opc_display_slider( $atts ) {		
		// Shortcode attributes
	    $atts = shortcode_atts( array(
	        'category' => ''
	    ), $atts );		

	    // Check if a category is set. If not, don't run the loop
	    if( $atts['category'] ) {
	    	// Query args
			$args = array(
				'post_type' => 'opc-slider',
				'tax_query' => array(
					array(
						'taxonomy' => 'opc-category',
						'field'    => 'slug',
						'terms'    => esc_attr( $atts['category'] )
					),
				),
			);
			$query = new WP_Query( $args );		

			// If the query has posts
			if ( $query->have_posts() ) {
				// Start slider element				
				$slider = '<div id="opc-' . esc_attr( $atts['category'] ) . '" class="owl-carousel">';

				// While loop to query posts - for content and button
				while ( $query->have_posts() ) {
					// Query the post
					$query->the_post();
					$postID = get_the_ID();

					// Include variables
					include( 'slider-variables.php' );

					// Create image area
					$slide_image = '';
					if ( $image_url ) {
						$slide_image .= '<div class="image">';
						$slide_image .= '<img src="' . esc_url( $image_url ) . '"';
						$slide_image .= ( $image_alt || $image_alt == '0' ) ? ' alt="' . esc_attr( $image_alt ) . '" title="' . esc_attr( $image_alt ) . '"' : '';
						$slide_image .= ' />';
						$slide_image .= '</div>';
					}

					// Create content area
					$slide_text = '';
					if ( ( $header_content || $header_content == '0') || ( $subheader_content || $subheader_content == '0') || ( $normaltext_content || $normaltext_content == '0' ) ) {						
						$slide_text .= '<div class="content">';
						$slide_text .= ( $header_content || $header_content == '0' ) ? '<h2>' . esc_html( $header_content ) . '</h2>' : '';
						$slide_text .= ( $subheader_content || $subheader_content == '0' ) ? '<h3>' . esc_html( $subheader_content ) . '</h3>' : '';
						$slide_text .= ( $normaltext_content || $normaltext_content == '0' ) ? '<p>' . esc_html( $normaltext_content ) . '</p>' : '';
						$slide_text .= '</div>';
					}

					// Create button area
					$slide_button = '';
					if ( $btn_url && ( $btn_content || $btn_content == '0' ) ) {
						$slide_button .= '<div class="button">';
						$slide_button .= '<a href="' . esc_url( $btn_url ) . '"';
						$slide_button .= $btn_new_window ? ' target="_blank"' : '';
						$slide_button .= ' alt="' . esc_html( substr( $btn_content, 0, 50 ) ) . '">';
						$slide_button .= esc_html( substr( $btn_content, 0, 50 ) );
						$slide_button .= '</a>';
						$slide_button .= '</div>';
					}

					// Check if slide is empty
					if ( $slide_image != '' || $slide_text != '' || $slide_button != '' ) {
						// Create slides for slider
						$slider .= '<div class="slide" id="slide-' . $postID . '">';
						$slider .= $slide_image;
						$slider .= $slide_text;
						$slider .= $slide_button;
						$slider .= '</div>';
					}
				}

				// End slider section					
				$slider .= '</div>';

				// Check if slider has content
				if ( $slider != '<div id="opc-' . esc_attr( $atts['category'] ) . '" class="owl-carousel"></div>' ) {
					// Get category meta
					$term_args = get_term_by( 'slug', $atts['category'], 'opc-category' );
					$term_id = $term_args->term_id;

					// Category meta variables
					$max_height = get_term_meta( $term_id, 'opc-max-height', true );
					$disable_ap = get_term_meta( $term_id, 'opc-disable-autoplay', true );
					$slide_speed = get_term_meta( $term_id, 'opc-slide-speed', true );
					$disable_navigation = get_term_meta( $term_id, 'opc-disable-navigation', true );
					$disable_pagination = get_term_meta( $term_id, 'opc-disable-pagination', true );
					$pagination_speed = get_term_meta( $term_id, 'opc-pagination-speed', true );

					// Begin slider styles
					$style = '<style>';

					// Max image height from terms
					if ( $max_height == '0' || $max_height ) {
						$style .= '#opc-' . esc_attr( $atts['category'] ) . '.owl-carousel .slide .image img{max-height:';
						$style .= opc_create_value( $max_height );
						$style .= '}';
					}

					// While loop to query posts - for style block
					while ( $query->have_posts() ) {					
						// Query the post
						$query->the_post();
						$postID = get_the_ID();

						// Include variables
						include( 'slider-variables.php' );

						// Create image styles
						$image_style = '';
						if ( strtolower( $image_alignment ) != 'center' || $image_bg_color ) {
							$image_style .= '#slide-' . $postID . ' .image{';
							$image_style .= ( strtolower( $image_alignment ) != 'center') ? 'text-align:' . strtolower( esc_html( $image_alignment ) ) . ';' : '';
							$image_style .= $image_bg_color ? 'background-color:' . esc_html( $image_bg_color ) . ';' : ''; 
							$image_style .= '}';
						}

						// Create content styles
						$content_style = '';
						if ( ( $header_content == '0' || $header_content ) || ( $subheader_content == '0' || $subheader_content ) || ( $normaltext_content == '0' || $normaltext_content ) ) {
							$content_style .= '#slide-' . $postID . ' .content{';
							$content_style .= ( $content_top || $content_top == '0' ) ? 'top:' . opc_create_value( $content_top ) . ';' : '';		
							$content_style .= ( $content_right || $content_right == '0' ) ? 'right:' . opc_create_value( $content_right ) . ';' : '';	
							$content_style .= ( $content_bottom || $content_bottom == '0' ) ? 'bottom:' . opc_create_value( $content_bottom ) . ';' : '';	
							$content_style .= ( $content_left || $content_left == '0' ) ? 'left:' . opc_create_value( $content_left ) . ';' : '';
							$content_style .= ( $content_top == '' && $content_right == '' && $content_bottom == '' && $content_left == '' ) ? 'bottom:20px;left:20px;' : '';
							$content_style .= '}';	
							$content_style .= ( $header_content || $header_content == '0' ) ? opc_create_content_style( $header_color, $header_shadow, $postID, 'h2' ) : '';
							$content_style .= ( $subheader_content || $subheader_content == '0' ) ? opc_create_content_style( $subheader_color, $subheader_shadow, $postID, 'h3' ) : '';
							$content_style .= ( $normaltext_content || $normaltext_content == '0' ) ? opc_create_content_style( $normal_color, $normal_shadow, $postID, 'p' ) : '';
						}

						// Create button styles
						$btn_style = '';
						if ( $btn_url && ( $btn_content || $btn_content == '0' ) ) {
							$btn_style .= '#slide-' . $postID . ' .button{';
							$btn_style .= ( $btn_top || $btn_top == '0' ) ? 'top:' . opc_create_value( $btn_top ) . ';' : '';	
							$btn_style .= ( $btn_right || $btn_right == '0' ) ? 'right:' . opc_create_value( $btn_right ) . ';' : '';
							$btn_style .= ( $btn_bottom || $btn_bottom == '0' ) ? 'bottom:' . opc_create_value( $btn_bottom ) . ';' : '';	
							$btn_style .= ( $btn_left || $btn_left == '0' ) ? 'left:' . opc_create_value( $btn_left ) . ';' : '';		
							$btn_style .= ( $btn_top == '' && $btn_right == '' && $btn_bottom == '' && $btn_left == '' ) ? 'bottom:20px;right:20px;' : '';
							$btn_style .= '}';
							if ( $btn_text_color || $btn_bg_color ) {
								$btn_style .= '#slide-' . $postID . ' .button a{';
								$btn_style .= $btn_text_color ? 'color:' . esc_attr( $btn_text_color ) . ';' : '';
								$btn_style .= $btn_bg_color ? 'background-color:' . esc_attr( $btn_bg_color ) . ';' : '';
								$btn_style .= '}';
							}
						}

						// Display slider styles
						$style .= $image_style;
						$style .= $content_style;
						$style .= $btn_style;
					}

					// End slider styles
					$style .= '</style>';

					// Being slider js
					$script = '<script>';
					$script .= 'jQuery(document).ready(function(){jQuery("#opc-' . esc_js( $atts['category'] ) . '").owlCarousel({';
					$script .= 'singleItem:true,';

					// JS init options
					$script_options = $disable_ap ? '' : 'autoPlay:true,';
					$script_options .= ( $slide_speed == '0' || $slide_speed ) ? 'slideSpeed:' . esc_js( $slide_speed ) . ',' : '';
					$script_options .= $disable_navigation ? '' : 'navigation:true,';
					$script_options .= $disable_pagination ? 'pagination:false,' : '';
					$script_options .= ( $pagination_speed == '0' || $pagination_speed ) ? 'paginationSpeed:' . esc_js( $pagination_speed ) . ',' : '';		

					// End slider js
					$script .= rtrim( $script_options, ',' );
					$script .= '})});';					
					$script .= '</script>';

					// Check if style tags are empty
					$final_slider = $slider . $style . $script;					
					return $final_slider;
				}
			}
			wp_reset_postdata();
		}
	}
	add_shortcode( 'opc-slider', 'opc_display_slider' );