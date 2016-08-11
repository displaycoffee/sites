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
<section id="about-muses">
	<div class="wrapper">
		<div class="column">column 1</div>
		<div class="column">column 2</div>
	</div>
</section>
<section id="home-latest-reviews">
	<div class="wrapper">stuff</div>	
</section>
<section id="home-more-reviews">
	<div class="wrapper">stuff</div>	
</section>
<section id="home-blog-roll">
	<div class="wrapper">stuff</div>	
</section>
<?php get_footer(); ?>