<?php 
	/**
	* For theme shortcodes
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Easy clearfix for floated images and content
	function musescircle_clearfix() {
		return '<div class="clearfix"></div>';
	}
	add_shortcode( 'clearfix', 'musescircle_clearfix' );	

	// Spoiler shortcode
	function musescircle_spoiler( $atts, $content = null ) {
		// Create spoiler block
		$spoiler_html = '<span class="spoiler">';
		$spoiler_html .= '<a class="spoiler-open">' . __( '[Open Spoiler]', 'musescircle' )  . '</a> ';
		$spoiler_html .= '<a class="spoiler-close">' . __( '[Close Spoiler]', 'musescircle' )  . '</a> ';
		$spoiler_html .= '<span class="spoiler-content">' . esc_html( $content ) . '</span>';
		$spoiler_html .= '</span>';

		// Display spoiler block
		return $spoiler_html;
	}
	add_shortcode( 'spoiler', 'musescircle_spoiler' );	

	// Signature shortcode
	function musescircle_signature( $atts ) {
		// Get arguments for shortcode
	    $a = shortcode_atts( array(
	        'greeting' => 'Best Wishes',
	        'name'     => 'Mia'
	    ), $atts );	

	    // Create image attribute text
	    $attribute_text = esc_html( $a['greeting'] ) . ', ' . esc_html( $a['name'] );

		// Create signature block
		$signature_html = '<div class="signature"><div class="signature-wrapper">';
		$signature_html .= '<div class="signature-fairy">';
		$signature_html .= '<img src="' . esc_url( get_template_directory_uri() . '/assets/images/fairy.png' ) . '" alt="' . esc_html( $attribute_text ) . '" title="' . esc_html( $attribute_text ) . '" />';
		$signature_html .= '</div>';
		$signature_html .= '<p class="signature-greeting">' . esc_html( $a['greeting'] ) . ',</p>';
		$signature_html .= '<p class="signature-name">' . esc_html( $a['name'] ) . '</p>';
		$signature_html .= '</div></div>';

		// Display signature block
		return $signature_html;
	}
	add_shortcode( 'signature', 'musescircle_signature' );	


	// Countdown shortcode
	function musescircle_countdown( $atts ) {
		// Get arguments for shortcode
	    $a = shortcode_atts( array(
	        'date'    => '',
	        'content' => '',
	        'url'     => '',
	        'window'  => ''	        	        
	    ), $atts );	

	    // Get date check boolean
	    $check_date = musescircle_parse_date( $a['date'] ); 

	    // First, check if date is set and if so, display countdown timer
	    if ( $a['date'] && $check_date ) {
	    	// Strip html and convert any remaining special characters for data-content attribute use
		    $new_content = htmlspecialchars( strip_tags( $a['content'] ), ENT_QUOTES);

		    // Date attribute if defined in shortcode
		    if ( $a['date'] ) {
		    	$date_attribute = ' data-end-date="' . esc_attr( $a['date'] ) . '"';
		    } else {
		    	$date_attribute = '';
		    }

		    // Content attribute if defined in shortcode
		    if ( $a['content'] ) {
		    	$content_attribute = ' data-content="' . esc_attr( $new_content ) . '"';
		    } else {
		    	$content_attribute = '';
		    }

			// Content attribute if defined in shortcode
			if ( $a['content'] && strlen( $a['content'] ) > 100 ) {
				$content_attribute = ' data-content="' . esc_attr( substr( $a['content'], 0, 97 ) . '...' ) . '"';
			} else if ( $a['content'] && strlen( $a['content'] ) <= 100 ) {
				$content_attribute = ' data-content="' . esc_attr( $a['content']) . '"';
			} else {
				$content_attribute = '';
			}

		    // URL attribute if defined in shortcode
		    if ( $a['url'] ) {
		    	$url_attribute = ' data-url="' . esc_url( $a['url'] ) . '"';
		    } else {
		    	$url_attribute = '';
		    }

		    // URL attribute if defined in shortcode
		    if ( strtolower( $a['window'] ) == 'new' ) {
		    	$window_attribute = ' data-window="' . esc_attr( $a['window'] ) . '"';
		    } else {
		    	$window_attribute = '';
		    }		    
		    
		    // Create "Countdown" block - START
			$countdown_html = '<div class="countdown"' . $date_attribute . $content_attribute . $url_attribute . $window_attribute . '>';

		    // Create "Countdown" block - END
			$countdown_html .= '</div>';

			// Display "Countdown" block
			return $countdown_html;
		} else {
			return false;
		}
	}
	add_shortcode( 'countdown', 'musescircle_countdown' );	