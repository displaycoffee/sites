<?php
	/**
	* Template part for displaying an author archive
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header
	get_header(); 

	// Grab all the variables we need for this page
	$author_name = get_the_author();
	$author_website = get_the_author_meta( 'user_url' );
	$author_id = get_the_author_meta( 'ID' );
	$author_avatar = get_avatar( $author_id, 200, '', esc_attr( get_the_author() ) );
	$author_desc = get_the_author_meta( 'user_description' );
?>
<article>
	<?php 
		// Check if the author name is there. Not sure why it wouldn't be...
		if ( $author_name ) {
			$author_header = '<header class="main-title"><h1>' . __( 'Author: ', 'themusescircle' ) . $author_name . '</h1></header>';
			echo $author_header;
		}
	?>
	<div id="author" class="author-info">
		<?php
			// Check if the author has a website
			if ( $author_website ) {
				$author_meta = '<div class="author-meta">';
				$author_meta .= '<p class="website"><a href="' . esc_url( $author_website ) . '">' . __( 'Website', 'themusescircle' ) . '</a></p>';
				$author_meta .= '</div>';
				echo $author_meta;
			}				
 
			// Check if the author has an avatar
			if ( $author_avatar ) { 
				$author_thumbnail = '<div class="author-thumbnail"><div class="image-wrap">' . $author_avatar . '</div></div>'; 
				echo $author_thumbnail;
			} 

			// Check if the aithor has a description
			if ( '' != $author_desc ) {
				$author_biography = '<div class="author-biography"><p>' .  $author_desc . '</p></div>';
				echo $author_biography;
			}
		?>
	</div>
	<h2><?php printf( __( 'Posts by %s', 'themusescircle' ), $author_name ) ?></h2>
	<?php get_template_part( 'loop', 'index' ); ?>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>