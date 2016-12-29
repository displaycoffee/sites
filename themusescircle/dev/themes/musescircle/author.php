<?php
	/**
	* Template part for displaying an author archive
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header
	get_header(); 

	// Grab all the variables we need for this page
	$author_id = get_the_author_meta( 'ID' );
	$author_image = get_avatar( $author_id, 200, '', esc_attr( get_the_author() ) );
	$author_description = get_the_author_meta( 'user_description' );	

	// Grab author social media variables
	$author_website = get_the_author_meta( 'user_url' );	
	$author_facebook = get_the_author_meta( 'facebook' );
	$author_gplus = get_the_author_meta( 'gplus' );
	$author_linkedin = get_the_author_meta( 'linkedin' );
	$author_twitter = get_the_author_meta( 'twitter' );
	$author_instagram = get_the_author_meta( 'instagram' );
	$author_youtube = get_the_author_meta( 'youtube' );
	$author_pinterest = get_the_author_meta( 'pinterest' );
	$author_tumblr = get_the_author_meta( 'tumblr' );
	$author_goodreads = get_the_author_meta( 'goodreads' );
?>
<?php get_template_part( 'page', 'title' ); ?>
<section class="content">
	<div class="wrapper">
		<article>
			<div class="entry-author">
				<?php
					// Don't display on author archive
					if ( !is_author() ) { 	
						echo '<h3>' . __( 'About', 'musescircle' ) . ' ' . get_the_author() . '</h3>';
					}
				?>
				<?php 
					// Create author image block
					$author_image_html = '<div class="entry-author-thumbnail">';
					$author_image_html .= '<div class="image-wrap image-wrap-border">' . $author_image . '</div>';
					$author_image_html .= '</div>';	

					// Display author image block
					echo $author_image_html;
				?>
				<?php 
					// Create author social links
					$author_social_links = $author_website ? '<li>' . musescircle_create_link( 'website', $author_website, 'Website' ) . '</li>' : '';
					$author_social_links .= $author_facebook ? '<li>' . musescircle_create_link( 'facebook', $author_facebook, 'Facebook' ) . '</li>' : '';
					$author_social_links .= $author_gplus ? '<li>' . musescircle_create_link( 'gplus', $author_gplus, 'Google+' ) . '</li>' : '';
					$author_social_links .= $author_linkedin ? '<li>' . musescircle_create_link( 'linkedin', $author_linkedin, 'LinkedIn' ) . '</li>' : '';
					$author_social_links .= $author_twitter ? '<li>' . musescircle_create_link( 'twitter', $author_twitter, 'Twitter' ) . '</li>' : '';			
					$author_social_links .= $author_instagram ? '<li>' . musescircle_create_link( 'instagram', $author_instagram, 'Instagram' ) . '</li>' : '';
					$author_social_links .= $author_youtube ? '<li>' . musescircle_create_link( 'youtube', $author_youtube, 'YouTube' ) . '</li>' : '';
					$author_social_links .= $author_pinterest ? '<li>' . musescircle_create_link( 'pinterest', $author_pinterest, 'Pinterest' ) . '</li>' : '';
					$author_social_links .= $author_goodreads ? '<li>' . musescircle_create_link( 'goodreads', $author_goodreads, 'Goodreads' ) . '</li>' : '';
					$author_social_links .= $author_tumblr ? '<li>' . musescircle_create_link( 'tumblr', $author_tumblr, 'Tumblr' ) . '</li>' : '';

					// Create author social block
					$author_social_html = '<div class="entry-author-social menu-social-container">';
					$author_social_html .= '<strong>' . __( 'Connect:', 'musescircle' ) . '</strong>';
					$author_social_html .= '<ul class="menu">';
					$author_social_html .= str_replace( ',', '', $author_social_links );
					$author_social_html .= '</ul></div>';

					// Create author description block
					$author_description_html = '<div class="entry-author-description">';
					$author_description_html .= wpautop( esc_textarea ( $author_description ) );
					$author_description_html .= '</div>';

					// Check if there is a description or any social media links
					if ( $author_description || strlen( $author_social_links ) > 0 ) {
						// Create author details block
						$author_details_html = '<div class="entry-author-details">';
						$author_details_html .= $author_description ? $author_description_html : '';
						$author_details_html .= ( strlen( $author_social_links ) > 0 ) ? $author_social_html : '';
						$author_details_html .= '</div>';				

						// Display author details block
						echo $author_details_html;
					}
				?>
			</div>
			<h2><?php printf( __( 'Posts by %s', 'musescircle' ), get_the_author() ) ?></h2>
			<?php get_template_part( 'loop', 'index' ); ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>