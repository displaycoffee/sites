<?php
	/**
	* Template for displaying video review archive
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 	
?>
<?php the_archive_title( '<header class="main-title"><div class="wrapper"><h1>', '</h1></div></header>' ); ?>
<section class="content">
	<div class="wrapper">
		<article>	
			<?php the_archive_description( '<div class="category-description">', '</div>' ); ?>	
			<h2><?php _e( 'Reviews', 'inspire-reviews' ); ?></h2>
			<?php if ( have_posts() ) : ?>	
				<div class="entry-multiple">
					<?php while ( have_posts() ) : the_post(); ?>				
						<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-review insprvw-<?php echo insprvw_video_type( false ); ?>-review" itemscope itemtype="http://schema.org/Review">
							<meta itemprop="url" content="<?php echo esc_url( get_the_permalink() ); ?>"/>
							<?php 
								// Since the string is long, create variables for title before/after
								$title_before = '<header class="entry-header"><h3 itemprop="name"><a href="' . esc_url( get_the_permalink() ) . '">';
								$title_after = '</a></h3></header>';

								// Display the title
								the_title( $title_before, $title_after );
							?>
							<?php include INSPRVW_DIR . 'display/partials/review-meta.php'; ?>
							<div class="entry-item-reviewed" itemprop="itemReviewed" itemscope itemtype="<?php echo insprvw_video_type( true ); ?>">
								<?php include INSPRVW_DIR . 'display/partials/review-thumbnail.php'; ?>
								<?php include INSPRVW_DIR . 'display/video/' . insprvw_video_type( false ) . '-information.php'; ?>
							</div>
							<div class="entry-content">
								<meta itemprop="description" content="<?php echo esc_attr( substr( strip_tags( get_the_content() ), 0, 197 ) . '...' ); ?>"/>
								<?php echo insprvw_excerpt(); ?>
							</div>
							<?php include INSPRVW_DIR . 'display/partials/review-footer.php'; ?>						
						</div>
					<?php endwhile; ?>
				</div>
				<?php include INSPRVW_DIR . 'display/partials/review-pagination.php'; ?>
			<?php else : ?>
				<?php include INSPRVW_DIR . 'display/partials/review-no-posts.php'; ?>
			<?php endif; ?>	
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>				