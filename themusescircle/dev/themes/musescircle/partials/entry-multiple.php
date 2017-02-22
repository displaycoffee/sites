<?php
	/**
	* Template for displaying multiple posts on an archive
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry post">
	<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
	<div class="entry-wrapper">
		<?php 
			// Since the string is long, create variables for title before/after
			$title_before = '<header class="entry-header"><h3><a href="' . esc_url( get_the_permalink() ) . '">';
			$title_after = '</a></h3></header>';

			// Display the title
			the_title( $title_before, $title_after );
		?>
		<?php get_template_part( 'partials/entry', 'meta' ); ?>														
		<div class="entry-content"><?php echo musescircle_excerpt( true ); ?></div>
	</div>
</div>