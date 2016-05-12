<?php
	/**
	* Template for displaying comments
	*/

	// Exit if accessed directly
	if ( 'comments.php' == basename( $_SERVER['SCRIPT_FILENAME'] ) ) { exit; }	

	// Check if post password is required
	if ( post_password_required() ) {
		return;
	}
?>
<?php 
	if ( have_comments() ) : 
		global $comments_by_type;
		$get_comments = get_comments( 'status=approve&post_id=' . $id ); 
		$comments_by_type = separate_comments( $get_comments );
		if ( !empty( $comments_by_type['comment'] ) ) : 
?>
	<div id="comments">
		<div class="comments-list">
			<h3><?php comments_number( __( 'No comments', 'themusescircle' ), __( 'One comment', 'themusescircle' ), __( '% comments', 'themusescircle') ); ?></h3>
			<ul>
				<?php wp_list_comments( 'callback=themusescircle_custom_comments' ); ?>
			</ul>
		</div>
		<?php 
			// Check if comment pages are greater than 1
			if ( get_comment_pages_count() > 1 ) {

				// Pagination arguments
				$args = array(
					'end_size'	=> 2,
					'mid_size'	=> 3,
					'prev_text' => __( 'Previous', 'themusescircle' ),
					'next_text' => __( 'Next', 'themusescircle' ),
					'type'		=> 'list'			
				);

				// Display comment pagination
				echo '<nav class="pagination">';
				paginate_comments_links( $args );
				echo '</nav>';
			}
		?>
		<?php endif; ?>
	</div>
<?php endif; ?>	
<?php if ( comments_open() ) comment_form(); ?>