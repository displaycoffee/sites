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
	        'date'    => '11-12-2016',
	        'content' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Neque odit facere consectetur perspiciatis hic quos quasi, itaque qui quae totam iure blanditiis non, assumenda nemo ex',
	        'url'     => '',
	        'window'  => ''
	    ), $atts );	

	    // First, check if date is set and if so, display countdown timer
	    if ( $a['date'] ) {
	    	// Strip html and convert any remaining special characters for data-content attribute use
		    $new_content = htmlspecialchars( strip_tags( $a['content'] ), ENT_QUOTES);

		    // Create "Countdown" block - START
			$countdown_html = '<div class="countdown" data-end-date="' . esc_attr( $a['date'] ) . '" data-content="' . esc_attr( $new_content ) . '"></div>';

		    // Create "Countdown" block - END
			$countdown_html .= '</div>';

			// Display "Countdown" block
			return $countdown_html;
		} else {
			return false;
		}
	}
	add_shortcode( 'countdown', 'musescircle_countdown' );	