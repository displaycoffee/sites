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
			<?php 
				// Check if we are on an author category and display information about the author
				if ( is_tax( 'insprvw-book-author' ) ) {
					include 'book-author-information.php';
				} else {
					the_archive_description( '<div class="category-description">', '</div>' );
				}
			?>		
			<h2><?php _e( 'Reviews', 'inspire-reviews' ); ?></h2>
			<?php if ( have_posts() ) : ?>	
				<div class="entry-multiple">
					<?php while ( have_posts() ) : the_post(); ?>
						<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-review insprvw-book-review" itemscope itemtype="http://schema.org/Review">
							<meta itemprop="url" content="<?php echo esc_url( get_the_permalink() ); ?>"/>
							<?php 
								// Since the string is long, create variables for title before/after
								$title_before = '<header class="entry-header"><h3 itemprop="name"><a href="' . esc_url( get_the_permalink() ) . '">';
								$title_after = '</a></h3></header>';

								// Display the title
								the_title( $title_before, $title_after );
							?>
							<?php include '/../partials/review-meta.php'; ?>
							<div class="entry-item-reviewed" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Book">
								<?php include '/../partials/review-thumbnail.php'; ?>
								<?php include 'book-information.php'; ?>	
							</div>
							<div class="entry-content">
								<meta itemprop="description" content="<?php echo esc_attr( substr( strip_tags( get_the_content() ), 0, 197 ) . '...' ); ?>"/>
								<?php insprvw_excerpt(); ?>
							</div>
							<?php include '/../partials/review-footer.php'; ?>
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