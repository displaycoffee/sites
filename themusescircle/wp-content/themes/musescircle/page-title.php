<?php
	/**
	* Template for displaying page titles
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<header id="header" class="main-header">
	<div class="wrapper">
		<h1>
			<?php 				
				if ( is_404() ) {
					// Check if on 404 page
					_e( 'Not Found', 'musescircle' );
				} else if ( is_archive() ) {
					// Check if on acrhive
					if ( is_author() ) {
						// Check if the archive is an author archive
						_e( 'Author: ', 'musescircle' );
						echo get_the_author();
					} else {
						echo get_the_archive_title();
					}
				} else if ( is_search() ) {
					// Check if a search query is present
					if ( get_search_query() ) {
						echo sprintf( __( 'Search results for "%s"', 'musescircle' ), esc_html( get_search_query() ) );
					} else {
						_e( 'Search results', 'musescircle' );
					}
				} else if ( is_home() && !is_front_page() ) {
					// Check if on blog				
					echo single_post_title();
				} else {
					// For everything else
					echo get_the_title();
				}
			?>		
		</h1>
	</div>
</header>