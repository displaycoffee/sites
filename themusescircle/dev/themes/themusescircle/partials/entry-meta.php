<?php
	/**
	* Template for displaying entry meta
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<div class="entry-meta">
	<?php 
		// Dont load author schema on attachment pages
		if ( !is_attachment() ) {
			$att_schema = ' itemprop="author"';
		} else {
			$att_schema = '';
		}

		// Check if author is available
		if ( !is_author() ) {
			echo '<p class="author"' . $att_schema . '>' .  get_the_author_posts_link() . '</p>';
		}
	?>
	<?php 
		// Dont load date schema on attachment pages
		if ( !is_attachment() ) {
			$date_schema = ' itemprop="datePublished"';
		} else {
			$date_schema = '';
		}

		// Display the date
		echo '<p class="date"' . $date_schema . '>' .  get_the_time( get_option( 'date_format' ) ) . '</p>';
	?>
</div>