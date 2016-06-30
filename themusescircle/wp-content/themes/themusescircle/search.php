<?php
	/**
	* Template for displaying search page
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 
?>
<?php 
	// Create search header block - START
	$search_header = '<header class="main-title"><div class="wrapper"><h1>';

	// Check if a search query is present
	if ( get_search_query() ) {
		$search_header .= sprintf( __( 'Search results for "%s"', 'themusescirle' ), esc_html( get_search_query() ) );
	} else {
		$search_header .= __( 'Search results', 'themusescirle' );
	}

	// Create search header block - END
	$search_header .= '</h1></div></header>';	

	// Display search header block
	echo $search_header;	
?>
<section class="content">
	<div class="wrapper">
		<article>
			<?php get_template_part( 'loop' ); ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>