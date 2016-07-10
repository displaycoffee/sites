<?php
	/**
	* Template for displaying book review archive
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
			<?php if ( have_posts() ) : ?>	
				<div class="entry-multiple">
					<?php while ( have_posts() ) : the_post(); ?>
						<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-book-review" itemscope itemtype="http://schema.org/Review">
							<div itemprop="itemReviewed" itemscope itemtype="http://schema.org/Book">
								<?php include 'book-information.php'; ?>	
							</div>
						</div>
					<?php endwhile; ?>
				</div>
				<?php include '/../partials/review-pagination.php'; ?>
			<?php else : ?>
				<div id="no-post" class="not-found">
					<p>
						<?php
							// Display different text for search versus other pages if no posts are found 
							if ( is_search() ) { 
								_e( 'No posts match your search.', 'inspire-reviews' );
							} else {
								_e( 'No posts found.', 'inspire-reviews' );
							}
						?>
					</p>
					<p><?php echo sprintf( __( 'Return to %1$s%2$s%3$s?', 'inspire-reviews' ), '<a href="', esc_url( home_url( '/' ) ), '">home</a>' ); ?></p>
				</div>
			<?php endif; ?>	
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>				