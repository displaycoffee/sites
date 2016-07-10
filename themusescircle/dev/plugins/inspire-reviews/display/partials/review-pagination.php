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
			'end_size'	=> 2,
			'mid_size'	=> 3,
			'prev_text' => __( 'Previous', 'inspire-reviews' ),
			'next_text' => __( 'Next', 'inspire-reviews' ),
			'type'		=> 'list'			
		);

		// Display pagination
		echo '<nav class="pagination">' . paginate_links( $args ) . '</nav>';
	}
?>