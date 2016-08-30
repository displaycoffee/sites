<?php
	/**
	* Template part for displaying an author archive
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header
	get_header(); 
?>
<?php 
	// Check if the author name is there. Not sure why it wouldn't be...
	if ( $author_name ) {
		echo '<header class="main-title"><div class="wrapper"><h1>' . __( 'Author: ', 'musescircle' ) . $author_name . '</h1></div></header>';
	}
?>
<section class="content">
	<div class="wrapper">
		<article>
			<?php get_template_part( 'partials/entry', 'author' ); ?>
			<h2><?php printf( __( 'Posts by %s', 'musescircle' ), $author_name ) ?></h2>
			<?php get_template_part( 'loop', 'index' ); ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>