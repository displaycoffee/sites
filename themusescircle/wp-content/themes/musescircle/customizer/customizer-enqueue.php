<?php
	/**
	* Enqueue script for custom customize control.
	*/	

	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }

	// Add customizer scripts and styles
	function musescircle_customizer_enqueue() {
        wp_enqueue_style( 'customizer', '/wp-content/themes/musescircle/assets/css/customizer.css' );
        wp_enqueue_script( 'jquery-ui-datepicker', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ), time(), true ); 
	}
	add_action( 'customize_controls_enqueue_scripts', 'musescircle_customizer_enqueue' );

	// Add custom inline scripts
	function musescircle_customizer_inline() {
	    ?>
	    <script type='text/javascript'>
            jQuery( document ).ready( function( $ ) {
                $( '.date-picker' ).datepicker({
                    dateFormat: 'mm/dd/yy'
                });
            }); 
	    </script>
	    <?php
	}
	add_action( 'customize_controls_print_footer_scripts', 'musescircle_customizer_inline' );
