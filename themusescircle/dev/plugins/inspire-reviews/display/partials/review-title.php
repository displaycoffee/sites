<?php
	/**
	* Template for displaying review page titles
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }	
?>
<header id="header" class="main-header">
	<div class="wrapper">
		<h1>
			<?php 				
				if ( is_archive() ) {
					// Check if on acrhive
					if ( is_author() ) {
						// Check if the archive is an author archive
						_e( 'Author: ', 'inspire-reviews' );
						echo get_the_author();
					} else {
						echo get_the_archive_title();
					}
				} else {
					// For everything else
					echo get_the_title();
				}
			?>		
		</h1>
	</div>
</header>