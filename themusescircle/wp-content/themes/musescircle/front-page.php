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
<header id="header" class="front-page-header">
	<div class="wrapper">
		<div class="header-content">
			<h1 class="site-name"><?php echo get_bloginfo( 'name' ); ?></h1>
			<p class="site-description"><?php echo get_bloginfo( 'description' ); ?></p>
		</div>
	</div>
</header>	
<div id="front-page-sections" class="full-width">
	<?php get_template_part( 'front/front', 'about' ); ?>
	<?php get_template_part( 'front/front', 'countdown' ); ?>
	<?php get_template_part( 'front/front', 'recent-reviews' ); ?>
	<?php get_template_part( 'front/front', 'review-buttons' ); ?>
	<?php get_template_part( 'front/front', 'from-blog' ); ?>
</div>
<?php get_footer(); ?>