<?php
	/**
	* Template for displaying page titles
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	

	// Check if we are on a page or post and if there is a thumbnail
	if ( has_post_thumbnail() && ( is_page() || is_single() ) ) {
		$thumbnail_class = 'has-thumbnail';
	} else {
		$thumbnail_class = 'no-thumbnail';
	}
?>
<header id="header" class="main-header">
	<div class="wrapper">
		<div class="header-content">
			<h1 class="<?php echo $thumbnail_class; ?>">
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
	</div>
</header>