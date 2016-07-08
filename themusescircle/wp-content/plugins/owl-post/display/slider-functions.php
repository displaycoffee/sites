<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Create value for max height/width and position
	function opc_create_value( $value ) {
		if ( $value == '0' ) {
			return '0';
		} elseif ( is_numeric( $value) ) {
			return esc_attr( $value . 'px' );
		} elseif( strtolower( $value ) == 'auto' ) {
			return 'auto';
		} else {
			return null;
		}
	}	

	// Create text styles
	function opc_create_content_style( $color, $shadow, $postID, $selector ) {
		if ( $color || $shadow ) {
			// Create content style block
			$content_style = '#opc-slide-' . $postID . ' .opc-content ' . $selector . '{';
			$content_style .= $color ? 'color:' . esc_attr( $color ) . ';' : '';
			$content_style .= ( $shadow == 1 ) ? 'text-shadow:2px 2px 2px #000;' : '';
			$content_style .= '}';

			// Display content style block
			return $content_style;
		}
	}		