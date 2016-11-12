<?php 
	/**
	* For theme shortcodes
	*/

	// Easy clearfix for floated images and content
	function musescircle_clearfix() {
		return '<div class="clearfix"></div>';
	}
	add_shortcode( 'clearfix', 'musescircle_clearfix' );	

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