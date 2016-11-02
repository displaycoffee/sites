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
	function musescircle_countdown( $atts, $content = null ) {
		// Get arguments for shortcode
	    $a = shortcode_atts( array(
	        'date'   => '',
	        'url'    => '',
	        'window' => ''
	    ), $atts );	

	    // First, check if date is set and if so, display countdown timer
	    if ( $a['date'] ) {
		    // Check if window is set to new
		    $new_window = ( strtolower( $a['window'] ) == 'new' ) ? ' target="_blank"' : '';

		    // Create "Countdown" block - START
			$countdown_html = '<div class="countdown">';
			$countdown_html .= '<div class="countdown-timer" data-end-date="' . esc_attr( $a['date'] ) . '"></div>';

		    // Check if there is content and if so, display a message
		    if ( $content ) {
		    	// Check if there is a url
		    	if ( $a['url'] ) {
			    	$countdown_html .= '<div class="countdown-message"><a href="' . esc_url( $a['url'] ) . '"' . $new_window . '>' . esc_html( $content ) . '</a></div>';
			    } else {
			    	$countdown_html .= '<div class="countdown-message">' . esc_html( $content ) . '</div>';
			    }
		    }

		    // Create "Countdown" block - END
			$countdown_html .= '</div>';

			// Display "Countdown" block
			return $countdown_html;
		} else {
			return false;
		}
	}
	add_shortcode( 'countdown', 'musescircle_countdown' );	