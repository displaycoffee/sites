<?php
	/**
	* Template for displaying single book review
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 

	// Create empty json-ld string to store data
	$json_block = '';	
?>
<?php include INSPRVW_DIR . 'display/partials/review-title.php'; ?>
<section class="content">
	<div class="wrapper">
		<article>
			<?php if ( have_posts() ) : ?>
				<div class="entry-single">
					<?php while ( have_posts() ) : the_post(); ?>	
						<?php 
							// Create json-ld string for blog schema
							$json_block .= insprvw_book_json( $post ) . ',';
						?>						
						<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-review insprvw-book-review">
							<?php include INSPRVW_DIR . 'display/partials/review-meta.php'; ?>
							<?php include INSPRVW_DIR . 'display/partials/review-thumbnail.php'; ?>						
							<div class="entry-details">
								<?php include INSPRVW_DIR . 'display/book/book-information.php'; ?>
							</div>	
							<div class="entry-content"><?php the_content(); ?></div>
							<?php 
								// Get author names without html
								$author_names = strip_tags( get_the_term_list( $post->ID, 'insprvw-book-author', '', ', ' ) );

								// Use author shortcode to display author information
								echo do_shortcode( '[book-author names="' . $author_names . '"]' );
							?>
							<?php include INSPRVW_DIR . 'display/partials/review-footer.php'; ?>						
						</div>										
					<?php endwhile; ?>
					<script type="application/ld+json">
						{"@context": "http://schema.org","@graph": [<?php echo rtrim( $json_block, ',' ); ?>]}	
					</script>
				</div>								
				<?php comments_template(); ?>
				<?php include INSPRVW_DIR . 'display/partials/review-navigation.php'; ?>
				<?php wp_reset_postdata(); ?>	
			<?php endif; ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>		