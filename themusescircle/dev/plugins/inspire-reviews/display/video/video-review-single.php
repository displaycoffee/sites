<?php
	/**
	* Template for displaying single video review
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
						<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-review insprvw-<?php echo insprvw_video_type( false ); ?>-review">
							<?php include INSPRVW_DIR . 'display/partials/review-meta.php'; ?>
							<div class="entry-item-reviewed">							
								<?php include INSPRVW_DIR . 'display/partials/review-thumbnail.php'; ?>							
								<div class="entry-details">
									<?php include INSPRVW_DIR . 'display/video/' . insprvw_video_type( false ) . '-information.php'; ?>
								</div>						
							</div>
							<div class="entry-content"><?php the_content(); ?></div>
							<?php include INSPRVW_DIR . 'display/partials/review-footer.php'; ?>															
						</div>
						<?php 
							// Create json-ld string for blog schema
							$json_block .= insprvw_movie_json( $post ) . ',';
						?>											
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