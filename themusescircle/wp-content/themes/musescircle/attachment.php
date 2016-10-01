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
<?php get_template_part( 'page', 'title' ); ?>
<section class="content">
	<div class="wrapper">
		<article>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="entry-single">
					<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry attachment">
						<?php 
							// Check if the parent title is there
							if ( $att_parent_title ) {
								// Create attachment header block
								$att_header = '<header class="entry-header"><h3>' . __( 'Published in: ', 'musescircle' );
								$att_header .= '<a href="' . esc_url( $att_parent_link ) . '">' . $att_parent_title . '</a>';
								$att_header .= '</h3></header>';

								// Display attachment header block
								echo $att_header;
							}
						?>
						<?php get_template_part( 'partials/entry', 'meta' ); ?>	
						<div class="entry-content">
							<?php 
								// Check if the attachment is an image or file and create attachment content block
								if ( wp_attachment_is_image( $post->ID ) ) { 
									$att_content = '<div class="attachment-image"><div class="image-wrap">' . wp_get_attachment_image( get_the_ID(), 'large' ) . '</div></div>';
								} else {
									$att_content = '<p class="attachment-file"><a href="' . esc_url( $att_url ) . '">' . $att_filename . '</a></p>';
								}

								// Check if the attachment has a caption and continue attachment content block
								if ( $att_caption ) {
									$att_content .= '<p class="caption">' . $att_caption . '</p>';
								}

								// Display attachment content block
								echo $att_content; 
							?>
						</div>
					</div>
				</div>
				<nav class="navigation-links">
					<ul>
						<li class="prev"><?php previous_image_link( false, '<span class="icon icon-chevron-left"></span>' ); ?></li>
						<li class="next"><?php next_image_link( false, '<span class="icon icon-chevron-right"></span>' ); ?></li>					
					</ul>
				</nav>
			<?php endwhile; endif; ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>