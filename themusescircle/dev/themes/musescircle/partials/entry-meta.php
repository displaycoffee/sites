<?php
	/**
	* Template for displaying entry meta
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<div class="entry-meta">
	<?php 
		// Dont display publisher schema on attachment pages
		if ( !is_attachment() ) {
			// Create publisher block
			$publisher_schema = '<div itemprop="publisher" itemscope itemtype="https://schema.org/Organization">';
			$publisher_schema .= '<meta itemprop="name" content="' . esc_attr( get_bloginfo( 'name' ) ) . '">';
			$publisher_schema .= '<div itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">';
			$publisher_schema .= '<meta itemprop="url" content="' . esc_url( get_template_directory_uri() . '/assets/images/publisher-logo.png' ) . '">';
			$publisher_schema .= '<meta itemprop="width" content="600">';
			$publisher_schema .= '<meta itemprop="height" content="60">';
			$publisher_schema .= '</div></div>';

			// Display publisher block
			echo $publisher_schema;
		}
	?>
	<?php 
		// Add author schema when not on attachment page
		$author_schema = !is_attachment() ? ' itemprop="author"' : '';
		echo '<p class="author"' . $author_schema . '><strong>' .  __( 'By', 'musescircle' ) . ':</strong> ' .  get_the_author_posts_link() . '</p>';
	?>
	<span class="bullet">&bull;</span>
	<?php 
		// Add date published schema when not on attachment page
		$date_schema = !is_attachment() ? ' itemprop="datePublished"' : '';
		echo '<p class="date"' . $date_schema . '><strong>' .  __( 'Date', 'musescircle' ) . ':</strong> ' .  get_the_time( get_option( 'date_format' ) ) . '</p>';

		// Dont display modified date schema on attachment pages
		if ( !is_attachment() ) {
			echo '<meta itemprop="dateModified" content="' .  esc_attr( get_the_modified_date( get_option( 'date_format' ) ) ) . '"/>';
		}
	?>
	<?php if ( !is_single() ) : ?>
		<span class="bullet">&bull;</span>
		<p class="categories" itemprop="keywords">
			<?php _e( '<strong>Categories:</strong> ', 'musescircle' ); ?><?php the_category( ', ' ); ?>
		</p>
	<?php endif; ?>
</div>