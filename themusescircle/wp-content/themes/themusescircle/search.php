<?php
	/**
	* Template for displaying search page
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 
?>
<article>
	<?php 
		// Start search header html
		$search_header = '<header class="main-title"><h1>';

		// Check if a search query is present
		if ( get_search_query() ) {
			$search_header .= sprintf( __( 'Search results for "%s"', 'themusescircle' ), get_search_query() );
		} else {
			$search_header .= __( 'Search results', 'themusescircle' );
		}

		// End search header html
		$search_header .= '</h1></header>';	

		// Display search header
		echo $search_header;	
	?>
	<?php get_template_part( 'loop' ); ?>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>