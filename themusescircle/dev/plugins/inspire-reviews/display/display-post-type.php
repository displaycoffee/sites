<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Loop through post type and custom meta
	function insprvwf_display_post() {
		$args = array(
			'post_type' => 'insprvwf-post-type'
		);

		$query = new WP_Query( $args );

		if ( $query->have_posts() ) {
			echo '<h3>' . __( 'Display Post Type', 'custom-stuff' ) . '</h3>';
			echo '<ul>';
			while ( $query->have_posts() ) {
				$query->the_post();
				$postID = get_the_ID();
				echo '<li>' . get_the_title() . '</li>';
				echo '<li>' . get_the_content() . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-text', true ) ) . '</li>';
				echo '<li>' . esc_url( get_post_meta( $postID, '_insprvwf-url', true ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-multitext01', true ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-multitext02', true ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-multitext03', true ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-multitext04', true ) ) . '</li>';
				echo '<li>' . wpautop( esc_html( get_post_meta( $postID, '_insprvwf-textarea', true ) ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-select', true ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-radio', true ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-checkbox', true ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-multicheck01', true ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-multicheck02', true ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-multicheck03', true ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-multicheck04', true ) ) . '</li>';
				echo '<li>' . esc_html( get_post_meta( $postID, '_insprvwf-color', true ) ) . '</li>';
				echo '<li>' . esc_url( get_post_meta( $postID, '_insprvwf-image', true ) ) . '</li>';
			}
			echo '</ul>';
			echo '<hr />';
		}
		
		wp_reset_postdata();
	}
	add_shortcode( 'display-posts', 'insprvwf_display_post' );