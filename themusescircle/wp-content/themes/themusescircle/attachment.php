<?php
	/**
	* Template for displaying image attachments
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header
	get_header(); 

	// Grab all the variables we need for this page
	$att_parent_link = get_permalink( $post->post_parent );
	$att_parent_title = get_the_title( $post->post_parent );
	$att_url = wp_get_attachment_url();
	$att_filename = basename( get_attached_file( get_the_ID() ) );
	$att_caption = get_the_excerpt();
?>
<article>
	<?php the_title( '<header class="main-title"><h1>', '</h1></header>' ); ?>
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<div class="post-single">
			<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
				<?php 
					// Check if the parent title is there
					if ( $att_parent_title ) {
						$att_header = '<header class="entry-header"><h2>' . __( 'Published in: ', 'themusescircle' );
						$att_header .= '<a href="' . esc_url( $att_parent_link ) . '">' . $att_parent_title . '</a>';
						$att_header .= '</h2></header>';
						echo $att_header;
					}
				?>			
				<?php get_template_part( 'partials/entry', 'meta' ); ?>
				<div class="entry-content">
					<?php 
						// Check if the attachment is an image or file
						if ( wp_attachment_is_image( $post->ID ) ) { 
							$att_content = '<div class="attachment-image">' . wp_get_attachment_image( get_the_ID(), 'large' ) . '</div>';
						} else {
							$att_content = '<p class="attachment-file"><a href="' . esc_url( $att_url ) . '">' . $att_filename . '</a></p>';
						}

						// Check if the attachment has a caption
						if ( $att_caption ) {
							$att_content .= '<p class="caption">' . $att_caption . '</p>';
						}

						// Display entry content
						echo $att_content; 
					?>
				</div>
			</div>
		</div>
		<nav class="navigation-links">
			<ul>
				<li class="prev"><?php previous_image_link( false, __( 'Previous', 'themusescircle' ) ); ?></li>
				<li class="next"><?php next_image_link( false, __( 'Next', 'themusescircle' ) ); ?></li>					
			</ul>
		</nav>
	<?php endwhile; endif; ?>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>