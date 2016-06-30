<?php
    /**
    * Customizer date class
    *
    * By paulund: https://github.com/paulund/wordpress-theme-customizer-custom-controls
    */  

    // Exit if accessed directly
    if ( !defined( 'ABSPATH' ) ) { exit; }

    // Check if customize class exists
    if ( !class_exists( 'WP_Customize_Control' ) ) {
        return null;
    }

    // Create data picker class
    class THEMUSESCIRCLE_Date_Picker extends WP_Customize_Control {
        // Enqueue date picker style
        public function enqueue() {
            wp_enqueue_style( 'jquery-ui-datepicker' );
        }

        // Render the content on the theme customizer page
        public function render_content() {
        ?> 
            <label>
                <span class="customize-control-title customize-date-picker-control"><?php echo esc_html( $this->label ); ?></span>
                <input type="date" id="<?php echo esc_attr( $this->id ); ?>" name="<?php echo esc_attr( $this->id ); ?>" value="<?php echo esc_html( $this->value() ); ?>" class="datepicker" data-customize-setting-link="<?php echo esc_attr( $this->id ); ?>" />
            </label>
        <?php
        }
    }