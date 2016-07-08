<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Loop through post type and create a shortcode for slider display
	function opc_display_slider( $atts ) {		
		// Include common slider functions
		include( 'slider-functions.php' );

		// Shortcode attributes
	    $atts = shortcode_atts( array(
	        'category' => ''
	    ), $atts );		

	    // Check if a category is set. If not, don't run the loop
	    if( $atts['category'] ) {
			// Create empty slide variable to store slides from post loop below
			$slide = '';

	    	// Query args
			$args = array(
				'post_type' => 'opc-slide',
				'tax_query' => array(
					array(
						'taxonomy' => 'opc-category',
						'field'    => 'slug',
						'terms'    => esc_attr( $atts['category'] )
					),
				),
			);
			$opc_query = new WP_Query( $args );	

			// If the query has posts
			if ( $opc_query->have_posts() ) {	
				// Create slider wrapper block - START			
				$slider_wrapper = '<div id="opc-' . esc_attr( $atts['category'] ) . '" class="opc-slider-wrapper owl-carousel">';

				// While loop to query posts - for content and button
				while ( $opc_query->have_posts() ) {
					// Query the post
					$opc_query->the_post();
					$postID = get_the_ID();

					// Include post meta
					include( 'slider-post-meta.php' );

					// Create slide image block
					$slide_image = '';
					if ( $image_url ) {
						$slide_image = '<div class="opc-image">';
						$slide_image .= '<img src="' . esc_url( $image_url ) . '"';
						$slide_image .= ( $image_alt || $image_alt == '0' ) ? ' alt="' . esc_attr( $image_alt ) . '" title="' . esc_attr( $image_alt ) . '"' : '';
						$slide_image .= ' />';
						$slide_image .= '</div>';
					}

					// Create slide content block
					$slide_content = '';
					if ( ( $header_content || $header_content == '0') || ( $subheader_content || $subheader_content == '0') || ( $normaltext_content || $normaltext_content == '0' ) ) {
						$slide_content = '<div class="opc-content">';
						$slide_content .= ( $header_content || $header_content == '0' ) ? '<h3>' . esc_html( $header_content ) . '</h3>' : '';
						$slide_content .= ( $subheader_content || $subheader_content == '0' ) ? '<h4>' . esc_html( $subheader_content ) . '</h4>' : '';
						$slide_content .= ( $normaltext_content || $normaltext_content == '0' ) ? '<p>' . esc_html( $normaltext_content ) . '</p>' : '';
						$slide_content .= '</div>';
					}					

					// Create slide button block
					$slide_button = '';
					if ( $btn_url && ( $btn_content || $btn_content == '0' ) ) {
						$slide_button = '<div class="opc-button">';
						$slide_button .= '<a href="' . esc_url( $btn_url ) . '"';
						$slide_button .= $btn_new_window ? ' target="_blank"' : '';
						$slide_button .= ' alt="' . esc_html( substr( $btn_content, 0, 50 ) ) . '">';
						$slide_button .= esc_html( substr( $btn_content, 0, 50 ) );
						$slide_button .= '</a>';
						$slide_button .= '</div>';
					}

					// Create single slide block					
					if ( $slide_image || $slide_content || $slide_button ) {
						$slide .= '<div id="opc-slide-' . $postID . '" class="opc-slide">';
						$slide .= $slide_image;
						$slide .= $slide_content;
						$slide .= $slide_button;
						$slide .= '</div>';
					}
				}

				// Reset post data
				wp_reset_postdata();

				// Create slider wrapper block - END					
				$slider_wrapper .= $slide;
				$slider_wrapper .= '</div>';

				// Check if there are any slides
				if ( strlen( $slide ) > 0 ) {
					// Get category meta
					$term_args = get_term_by( 'slug', $atts['category'], 'opc-category' );
					$term_id = $term_args->term_id;

					// Include term meta
					include( 'slider-term-meta.php' );

					// Create slider style block - START
					$slider_style = '<style>';			

					// Max width from terms
					if ( $max_width == '0' || $max_width ) {
						$slider_style .= '#opc-' . esc_attr( $atts['category'] ) . '{max-width:';
						$slider_style .= esc_attr( $max_width ) . esc_attr( $max_width_unit );
						$slider_style .= '}';
					}

					// Max image height from terms
					if ( $max_height == '0' || $max_height ) {
						$slider_style .= '#opc-' . esc_attr( $atts['category'] ) . '.owl-carousel .opc-slide .opc-image img{max-height:';
						$slider_style .= opc_create_value( $max_height );
						$slider_style .= '}';
					}	

					// Create empty slide variable to store slide CSS from loop
					$slide_css = '';					

					// While loop to query posts - for style block
					while ( $opc_query->have_posts() ) {					
						// Query the post
						$opc_query->the_post();
						$postID = get_the_ID();

						// Include post meta
						include( 'slider-post-meta.php' );

						// Create image CSS block
						$image_css = '';
						if ( strtolower( $image_alignment ) != 'center' || $image_bg_color ) {
							$image_css .= '#opc-slide-' . $postID . ' .opc-image{';
							$image_css .= ( strtolower( $image_alignment ) != 'center') ? 'text-align:' . strtolower( esc_html( $image_alignment ) ) . ';' : '';
							$image_css .= $image_bg_color ? 'background-color:' . esc_html( $image_bg_color ) . ';' : ''; 
							$image_css .= '}';
						}

						// Create content CSS block
						$content_css = '';
						if ( ( $header_content == '0' || $header_content ) || ( $subheader_content == '0' || $subheader_content ) || ( $normaltext_content == '0' || $normaltext_content ) ) {
							$content_css .= '#opc-slide-' . $postID . ' .opc-content{';
							$content_css .= ( $content_top || $content_top == '0' ) ? 'top:' . opc_create_value( $content_top ) . ';' : '';		
							$content_css .= ( $content_right || $content_right == '0' ) ? 'right:' . opc_create_value( $content_right ) . ';' : '';	
							$content_css .= ( $content_bottom || $content_bottom == '0' ) ? 'bottom:' . opc_create_value( $content_bottom ) . ';' : '';	
							$content_css .= ( $content_left || $content_left == '0' ) ? 'left:' . opc_create_value( $content_left ) . ';' : '';
							$content_css .= ( $content_top == '' && $content_right == '' && $content_bottom == '' && $content_left == '' ) ? 'bottom:20px;left:20px;' : '';
							$content_css .= '}';	
							$content_css .= ( $header_content || $header_content == '0' ) ? opc_create_content_style( $header_color, $header_shadow, $postID, 'h3' ) : '';
							$content_css .= ( $subheader_content || $subheader_content == '0' ) ? opc_create_content_style( $subheader_color, $subheader_shadow, $postID, 'h4' ) : '';
							$content_css .= ( $normaltext_content || $normaltext_content == '0' ) ? opc_create_content_style( $normal_color, $normal_shadow, $postID, 'p' ) : '';
						}

						// Create button CSS block
						$btn_css = '';
						if ( $btn_url && ( $btn_content || $btn_content == '0' ) ) {
							$btn_css .= '#opc-slide-' . $postID . ' .opc-button{';
							$btn_css .= ( $btn_top || $btn_top == '0' ) ? 'top:' . opc_create_value( $btn_top ) . ';' : '';	
							$btn_css .= ( $btn_right || $btn_right == '0' ) ? 'right:' . opc_create_value( $btn_right ) . ';' : '';
							$btn_css .= ( $btn_bottom || $btn_bottom == '0' ) ? 'bottom:' . opc_create_value( $btn_bottom ) . ';' : '';	
							$btn_css .= ( $btn_left || $btn_left == '0' ) ? 'left:' . opc_create_value( $btn_left ) . ';' : '';		
							$btn_css .= ( $btn_top == '' && $btn_right == '' && $btn_bottom == '' && $btn_left == '' ) ? 'bottom:20px;right:20px;' : '';
							$btn_css .= '}';
							if ( $btn_text_color || $btn_bg_color ) {
								$btn_css .= '#opc-slide-' . $postID . ' .opc-button a{';
								$btn_css .= $btn_text_color ? 'color:' . esc_attr( $btn_text_color ) . ';' : '';
								$btn_css .= $btn_bg_color ? 'background-color:' . esc_attr( $btn_bg_color ) . ';' : '';
								$btn_css .= '}';
							}
						}

						// Create single slide CSS block
						$slide_css .= $image_css;
						$slide_css .= $content_css;
						$slide_css .= $btn_css;						
					}

					// Reset post data
					wp_reset_postdata();

					// Create slider style block - END
					$slider_style .= $slide_css;
					$slider_style .= '</style>';

					// Create slider js block - START
					$slider_js = '<script>';
					$slider_js .= 'jQuery(document).ready(function(){jQuery("#opc-' . esc_js( $atts['category'] ) . '").owlCarousel({';
					$slider_js .= 'singleItem:true,';

					// Create slider js options block
					$js_options = $disable_ap ? '' : 'autoPlay:true,';
					$js_options .= ( $slide_speed == '0' || $slide_speed ) ? 'slideSpeed:' . esc_js( $slide_speed ) . ',' : '';
					$js_options .= $disable_navigation ? '' : 'navigation:true,';
					$js_options .= $disable_pagination ? 'pagination:false,' : '';
					$js_options .= ( $pagination_speed == '0' || $pagination_speed ) ? 'paginationSpeed:' . esc_js( $pagination_speed ) . ',' : '';		

					// Create slider js block - END
					$slider_js .= rtrim( $js_options, ',' );
					$slider_js .= '})});';					
					$slider_js .= '</script>';
				}
			}

			// Check if there's any slides in the slider to show
			if ( strlen( $slide ) > 0 ) {
				// Create final slider block
				$final_slider = $slider_wrapper;					
				$final_slider .= $slider_style != '<style></style>' ? $slider_style : '';
				$final_slider .= $slider_js;

				// Display final slider block
				return $final_slider;
			}
		}
	}
	add_shortcode( 'opc-slider', 'opc_display_slider' );