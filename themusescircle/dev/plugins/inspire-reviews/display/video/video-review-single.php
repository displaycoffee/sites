<?php
	/**
	* Template for displaying single video review
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header();
?>
<?php include INSPRVW_DIR . 'display/partials/review-title.php'; ?>
<section class="content">
	<div class="wrapper">
		<article>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>			
				<div class="entry-single">
					<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-review insprvw-<?php echo insprvw_video_type( false ); ?>-review" itemscope itemtype="http://schema.org/Review">
						<meta itemprop="name" content="<?php echo esc_attr( get_the_title() ); ?>"/>
						<meta itemprop="url" content="<?php echo esc_url( get_the_permalink() ); ?>"/>
						<?php include INSPRVW_DIR . 'display/partials/review-meta.php'; ?>
						<div class="entry-item-reviewed <?php echo ( has_post_thumbnail() ? 'has-thumbnail' : 'no-thumbnail' ); ?>" itemprop="itemReviewed" itemscope itemtype="<?php echo insprvw_video_type( true ); ?>">							
							<?php include INSPRVW_DIR . 'display/partials/review-thumbnail.php'; ?>							
							<div class="entry-details">
								<?php include INSPRVW_DIR . 'display/video/' . insprvw_video_type( false ) . '-information.php'; ?>
							</div>						
						</div>
						<div class="entry-content">
							<meta itemprop="description" content="<?php echo esc_attr( substr( strip_tags( get_the_content() ), 0, 197 ) . '...' ); ?>"/>
							<?php the_content(); ?>
						</div>
						<?php include INSPRVW_DIR . 'display/partials/review-footer.php'; ?>	
						<?php edit_post_link( __( 'Edit', 'inspire-reviews' ), '<p class="edit">', '</p>' ); ?>								
					</div>
				</div>				
				<?php comments_template(); ?>
				<?php include INSPRVW_DIR . 'display/partials/review-navigation.php'; ?>
			<?php endwhile; wp_reset_postdata(); endif; ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>		