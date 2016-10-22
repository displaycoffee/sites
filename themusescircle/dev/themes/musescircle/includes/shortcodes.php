<?php 
	/**
	* For theme shortcodes
	*/

	// Easy clearfix for floated images and content
	function musescircle_clearfix() {
		return '<div class="clearfix"></div>';
	}
	add_shortcode( 'clearfix', 'musescircle_clearfix' );	