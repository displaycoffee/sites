<?php
	/**
	* Template for displaying front page "Countdown" section
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Grab all the variables we need for this page	
	$countdown_hide = get_theme_mod( 'musescircle_countdown_promotion_hide' );
	$countdown_date = get_theme_mod( 'musescircle_countdown_promotion_date' );
	$countdown_content = get_theme_mod( 'musescircle_countdown_promotion_content' );
	$countdown_url = get_theme_mod( 'musescircle_countdown_promotion_url' );
	$countdown_new_window = get_theme_mod( 'musescircle_countdown_promotion_new_window' );
?>
<?php 
	// Shortcode attributes
	$date_attribute = $countdown_date ? ( ' date="' . esc_attr( $countdown_date ) . '"' ) : '';
	$url_attribute = $countdown_url ? ( ' url="' . esc_url( $countdown_url ) . '"' ) : '';
	$window_attribute = ( $countdown_new_window == 1 ) ? ( ' window="new"' ) : '';

	// Content attribute
	if ( $countdown_content && strlen( $countdown_content ) > 100 ) {
		$content_attribute = ' content="' . esc_attr( substr( $countdown_content, 0, 97 ) . '...' ) . '"';
	} else if ( $countdown_content && strlen( $countdown_content ) <= 100 ) {
		$content_attribute = ' content="' . esc_attr( $countdown_content ) . '"';
	} else {
		$content_attribute = '';
	}

	// Create "Countdown" block
	$countdown_section = '<section id="countdown-promotion"><div class="wrapper">';
	$countdown_section .= do_shortcode( '[countdown' . $date_attribute . $content_attribute . $url_attribute . $window_attribute . ']' );	
	$countdown_section .= '</div></section>';

	// Display "Countdown" section (only if not marked as hidden)
	if ( !$countdown_hide ) {
	 	echo $countdown_section;
	}
?>