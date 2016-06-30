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
<?php 
	// Check if the author name is there. Not sure why it wouldn't be...
	if ( $author_name ) {
		echo '<header class="main-title"><div class="wrapper"><h1>' . __( 'Author: ', 'themusescirle' ) . $author_name . '</h1></div></header>';
	}
?>
<section class="content">
	<div class="wrapper">
		<article>
			<div id="author" class="author-info">
				<?php
					// Check if the author has a website
					if ( $author_website ) {
						// Create author block
						$author_meta = '<div class="author-meta">';
						$author_meta .= '<p class="website"><a href="' . esc_url( $author_website ) . '">' . __( 'Website', 'themusescirle' ) . '</a></p>';
						$author_meta .= '</div>';

						// Display author block
						echo $author_meta;
					}				
		 
					// Check if the author has an avatar
					if ( $author_avatar ) { 
						echo '<div class="author-thumbnail"><div class="image-wrap">' . $author_avatar . '</div></div>';
					} 

					// Check if the aithor has a description
					if ( '' != $author_desc ) {
						echo '<div class="author-biography"><p>' .  $author_desc . '</p></div>';
					}
				?>
			</div>
			<h2><?php printf( __( 'Posts by %s', 'themusescirle' ), $author_name ) ?></h2>
			<?php get_template_part( 'loop', 'index' ); ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>