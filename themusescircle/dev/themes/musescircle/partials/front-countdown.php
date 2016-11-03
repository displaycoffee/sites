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
	// Create new date with correct format
	$new_date = $date = DateTime::createFromFormat( 'Y-m-d', $countdown_date )->format( 'm-d-Y' );	

	// Put together countdown attributes
	$countdown_attributes = $countdown_date ? ' date="' . $new_date . '"' : '';
	$countdown_attributes .= $countdown_url ? ' url="' . $countdown_url . '"' : '';
	$countdown_attributes .= $countdown_new_window ? ' window="new"' : '';

	// Create "Countdown" block
	$countdown_section = '<section id="countdown-promotion"><div class="wrapper">';
	$countdown_section .= do_shortcode( '[countdown' . $countdown_attributes . ']' . $countdown_content . '[/countdown]' );	
	$countdown_section .= '</div></section>';

	// Display "Countdown" section (only if not marked as hidden)
	if ( !$countdown_hide && $countdown_date ) {
	 	echo $countdown_section;
	}
?>