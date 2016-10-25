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
<div id="front-page-sections">
	<?php get_template_part( 'partials/front', 'about' ); ?>
	<section>
		<div class="wrapper">
			<div class="countdown" data-end-date="2016-10-31" data-content="This is a message 1" data-url="www.google.com" data-target="New"></div>			
			<div class="countdown" data-end-date="2017-12-22" data-content="This is a message 2" data-url="http://www.imdb.com"></div>
		</div>
	</section>
	<?php get_template_part( 'partials/front', 'recent-reviews' ); ?>
	<?php get_template_part( 'partials/front', 'review-buttons' ); ?>
	<?php get_template_part( 'partials/front', 'from-blog' ); ?>
</div>
<?php get_footer(); ?>