<?php
	/**
	* Template for displaying the front page
	*
	* Settings > Reading > Static page > Front page
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Include header	
	get_header(); 
?>
<div id="front-page-sections">
	<?php get_template_part( 'partials/front', 'about' ); ?>
	<?php get_template_part( 'partials/front', 'recent-reviews' ); ?>
	<?php get_template_part( 'partials/front', 'review-buttons' ); ?>
	<?php get_template_part( 'partials/front', 'from-blog' ); ?>
</div>
<?php get_footer(); ?>