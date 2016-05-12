<?php
	/**
	* Template for displaying all single posts
	*/

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Include header	
	get_header(); 
?>
<article itemscope itemtype="http://schema.org/Blog">
	<?php the_title( '<header class="main-title"><h1 itemprop="name">', '</h1></header>' ); ?>	
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<meta itemprop="url" content="<?php echo esc_url( get_the_permalink() ) ?>">
		<div class="post-single">
			<div id="post-<?php esc_attr( the_ID() ); ?>" <?php post_class(); ?>>
				<?php get_template_part( 'partials/entry', 'meta' ); ?>
				<?php get_template_part( 'partials/entry', 'thumbnail' ); ?>
				<div class="entry-content" itemprop="text"><?php the_content(); ?></div>
				<?php get_template_part( 'partials/entry', 'footer' ); ?>
			</div>
		</div>
		<nav class="navigation-links">
			<ul>
				<li class="prev"><?php previous_post_link( '%link', __( 'Previous: %title', 'themusescircle' ) ); ?></li>
				<li class="next"><?php next_post_link( '%link', __( 'Next: %title', 'themusescircle' ) ); ?></li>					
			</ul>
		</nav>
		<?php comments_template(); ?>
	<?php endwhile; endif; ?>
</article>
<?php get_sidebar(); ?>
<?php get_footer(); ?>