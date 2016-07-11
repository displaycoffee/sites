<?php
	/**
	* Template for displaying single book review
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 
?>
<?php the_title( '<header class="main-title"><div class="wrapper"><h1>', '</h1></div></header>' ); ?>
<section class="content">
	<div class="wrapper">
		<article>
			<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
				<div class="entry-single">
					<div id="entry-<?php esc_attr( the_ID() ); ?>" class="entry insprvw-review insprvw-book-review" itemscope itemtype="http://schema.org/Review">
						<meta itemprop="name" content="<?php echo esc_attr( get_the_title() ); ?>"/>
						<meta itemprop="url" content="<?php echo esc_url( get_the_permalink() ); ?>"/>
						<?php include '/../partials/review-meta.php'; ?>
						<div class="entry-item-reviewed" itemprop="itemReviewed" itemscope itemtype="http://schema.org/Book">
							<?php include '/../partials/review-thumbnail.php'; ?>						
							<div class="entry-details">
								<?php include 'book-information.php'; ?>
							</div>						
						</div>
						<div class="entry-content">
							<meta itemprop="description" content="<?php echo esc_attr( substr( strip_tags( get_the_content() ), 0, 197 ) . '...' ); ?>"/>
							<?php the_content(); ?>
						</div>
						<?php include '/../partials/review-footer.php'; ?>
					</div>
				</div>
				<?php include '/../partials/review-navigation.php'; ?>
				<?php comments_template(); ?>
			<?php endwhile; endif; ?>
		</article>
		<?php get_sidebar(); ?>
	</div>
</section>			
<?php get_footer(); ?>		