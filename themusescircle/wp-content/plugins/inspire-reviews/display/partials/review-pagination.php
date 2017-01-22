<?php
	/**
	* Template for displaying review pagination
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<?php 
	// Check if pages are greater than 1
	if ( $wp_query->max_num_pages > 1 ) {

		// Pagination arguments
		$args = array(
			'end_size'	=> 1,
			'mid_size'	=> 3,
			'prev_text' => '<span class="icon icon-chevron-left"></span>',
			'next_text' => '<span class="icon icon-chevron-right"></span>',
			'type'		=> 'list'			
		);

		// Display pagination
		echo '<nav class="pagination">' . paginate_links( $args ) . '</nav>';
	}
?>