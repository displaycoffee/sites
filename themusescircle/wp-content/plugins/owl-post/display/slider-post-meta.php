<?php 
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
	// Image
	$image_url = get_post_meta( $postID, '_opc-image-url', true );
	$image_id = ( attachment_url_to_postid( $image_url ) != 0 ) ? attachment_url_to_postid( $image_url ) : '';
	$image_alt = $image_id ? get_post_meta( $image_id, '_wp_attachment_image_alt', true ) : '';
	$image_alignment = get_post_meta( $postID, '_opc-image-alignment', true );
	$image_bg_color = get_post_meta( $postID, '_opc-image-bg-color', true );

	// Content
	$content_top = get_post_meta( $postID, '_opc-content-pos-top', true );
	$content_right = get_post_meta( $postID, '_opc-content-pos-right', true );
	$content_bottom = get_post_meta( $postID, '_opc-content-pos-bottom', true );
	$content_left = get_post_meta( $postID, '_opc-content-pos-left', true );

	// Header
	$header_content = get_post_meta( $postID, '_opc-header-content', true );
	$header_color = get_post_meta( $postID, '_opc-header-color', true );
	$header_shadow = get_post_meta( $postID, '_opc-header-shadow', true );

	// Subheader
	$subheader_content = get_post_meta( $postID, '_opc-subheader-content', true );
	$subheader_color = get_post_meta( $postID, '_opc-subheader-color', true );
	$subheader_shadow = get_post_meta( $postID, '_opc-subheader-shadow', true );

	// Normal text
	$normaltext_content = get_post_meta( $postID, '_opc-normal-text-content', true );			
	$normal_color = get_post_meta( $postID, '_opc-normal-text-color', true );
	$normal_shadow = get_post_meta( $postID, '_opc-normal-text-shadow', true );

	// Button
	$btn_content = get_post_meta( $postID, '_opc-btn-content', true );
	$btn_url = get_post_meta( $postID, '_opc-btn-url', true );
	$btn_new_window = get_post_meta( $postID, '_opc-btn-new-window', true );	
	$btn_text_color = get_post_meta( $postID, '_opc-btn-text-color', true );
	$btn_bg_color = get_post_meta( $postID, '_opc-btn-bg-color', true );	
	$btn_top = get_post_meta( $postID, '_opc-btn-pos-top', true );
	$btn_right = get_post_meta( $postID, '_opc-btn-pos-right', true );
	$btn_bottom = get_post_meta( $postID, '_opc-btn-pos-bottom', true );
	$btn_left = get_post_meta( $postID, '_opc-btn-pos-left', true );