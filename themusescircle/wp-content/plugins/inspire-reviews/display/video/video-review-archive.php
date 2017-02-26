<?php
	/**
	* Template for displaying video review archive
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 	

	// Get post type to generate dyanmic categories
	$post_type = get_post_type();

	// Check what type of post we're viewing and sreate json-ld string for blog schema
	if ( $post_type == 'insprvw-movie-review' ) {
		$post_type = 'movie';
	} else if ( $post_type == 'insprvw-tv-review' ) {
		$post_type = 'tv';
	} 

	// Create empty json-ld string to store data
	$json_block = '';	
?>
<?php include INSPRVW_DIR . 'display/partials/review-title.php'; ?>
<section class="content">
	<div class="wrapper">
		<article>	
			<?php the_archive_description( '<div class="category-description">', '</div>' ); ?>	
			<?php if ( have_posts() ) : ?>	
				<div class="entry-multiple">
					<?php while ( have_posts() ) : the_post(); ?>				
						<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-review insprvw-<?php echo $post_type; ?>-review">
							<?php 
								// If there's not a thumbnail, don't add thumbnail class
								$item_reviewed_class = has_post_thumbnail() ? 'class="entry-item-reviewed"' : '';
							?>
							<div <?php echo $item_reviewed_class; ?>>
								<?php include INSPRVW_DIR . 'display/partials/review-thumbnail.php'; ?>
							</div>
							<div class="entry-wrapper">
								<?php 
									// Since the string is long, create variables for title before/after
									$title_before = '<header class="entry-header"><h3><a href="' . esc_url( get_the_permalink() ) . '">';
									$title_after = '</a></h3></header>';

									// Display the title
									the_title( $title_before, $title_after );
								?>
								<?php include INSPRVW_DIR . 'display/partials/review-meta.php'; ?>
								<div class="entry-content"><?php echo insprvw_excerpt( true ); ?></div>
							</div>						
						</div>
						<?php 
							// Check what type of post we're viewing and sreate json-ld string for blog schema
							if ( $post_type == 'movie' ) {
								$json_block .= insprvw_movie_json( $post ) . ',';
							} else if ( $post_type == 'tv' ) {
								$json_block .= insprvw_tv_json( $post ) . ',';
							} 
						?>							
					<?php endwhile; ?>
					<script type="application/ld+json">
						{"@context": "http://schema.org","@graph": [<?php echo rtrim( $json_block, ',' ); ?>]}	
					</script>					
				</div>
				<?php include INSPRVW_DIR . 'display/partials/review-pagination.php'; ?>
				<?php wp_reset_postdata(); ?>
			<?php else : ?>
				<?php include INSPRVW_DIR . 'display/partials/review-no-posts.php'; ?>
			<?php endif; ?>	
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>				