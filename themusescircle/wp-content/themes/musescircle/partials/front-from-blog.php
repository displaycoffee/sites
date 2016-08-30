<?php
	/**
	* Template for displaying front page "From the Blog" section
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Grab all the variables we need for this page	
	// Note: Number of posts customization is located in loop.php so the main loop can access it
	$from_blog_hide = get_theme_mod( 'musescircle_from_blog_hide' );
	$from_blog_title = get_theme_mod( 'musescircle_from_blog_title' );
?>
<?php if ( !$from_blog_hide ) : ?>
	<section id="from-the-blog">
		<div class="wrapper">
			<h2><?php echo $from_blog_title ? esc_html( $from_blog_title ) : __( 'From the Blog', 'musescircle' ); ?></h2>
			<?php get_template_part( 'loop', 'index' ); ?>
		</div>	
	</section>
<?php endif; ?>