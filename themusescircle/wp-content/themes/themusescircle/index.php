<?php
	/**
	* Template for displaying the main page
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Include header	
	get_header(); 
?>
<article>
	<?php get_template_part( 'loop', 'index' ); ?>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>