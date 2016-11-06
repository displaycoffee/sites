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
	// Create "Countdown" block
	$countdown_section = '<section id="countdown-promotion"><div class="wrapper">';
	$countdown_section .= do_shortcode( '[countdown][/countdown]' );	
	$countdown_section .= '</div></section>';

	// Display "Countdown" section (only if not marked as hidden)
	if ( !$countdown_hide ) {
	 	echo $countdown_section;
	}
?>