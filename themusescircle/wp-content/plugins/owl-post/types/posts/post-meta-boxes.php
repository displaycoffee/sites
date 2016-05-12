<?php
    // Exit if accessed directly
    if ( ! defined( 'ABSPATH' ) ) exit;
         
    // Class for putting together all the meta box goodness
    class OPC_Post_Meta_Box { 
        protected $_postMetaBox;        

        // Add actions for meta boxes
        function __construct( $postMetaBox ) {
            $this->_postMetaBox = $postMetaBox;
            add_action( 'admin_menu', array( &$this, 'add' ) );
            add_action( 'save_post', array( &$this, 'save' ) );
        }

        // Add meta box
        function add() {
            add_meta_box(
                $this->_postMetaBox['id'], 
                $this->_postMetaBox['title'], 
                array( &$this, 'show' ), 
                $this->_postMetaBox['page'], 
                $this->_postMetaBox['context'], 
                $this->_postMetaBox['priority']
            );
        }

        // Show meta box
        function show() {
            global $post;
 
            // Use nonce for verification
            echo '<input type="hidden" name="postMetaBox_nonce" value="', wp_create_nonce( basename( __FILE__ ) ), '" />';

            // Opening div to style meta     
            echo '<div class="opc-post-meta">';
     
            // Loop through each meta box array
            foreach ( $this->_postMetaBox['fields'] as $field ) {
                // Get the post meta
                $meta = get_post_meta( $post->ID, $field['id'], true );

                // Common display value
                $value = isset( $meta ) ? $meta : '';
                
                // Start opening HTML
                $opening = '<div class="row ' . $field['id'] . '-wrap">';
                $opening .= '<div class="block01">';
                $opening .= '<label for="' . $field['id'] . '">';
                $opening .= $field['label'];
                $opening .= '</label>';
                $opening .= '</div>';
                $opening .= '<div class="block02">';
                echo $opening;

                // Loop through basic field types
                opc_display_fields( $field, $value );

                // Display multiple text fields
                if ( $field['type'] == 'multitext' ) {
                    echo '<div class="options">';
                    foreach ( $field['options'] as $option ) {
                        $meta = get_post_meta( $post->ID, $option['id'], true );
                        $value = isset( $meta ) ? $meta : '';
                        opc_display_multitext( $field, $option, $value );
                    }
                    echo '</div>';                    
                }

                // Display multiple checkboxes
                if ( $field['type'] == 'multicheck' ) {
                    echo '<div class="options">';
                    foreach ( $field['options'] as $option ) {
                        $meta = get_post_meta( $post->ID, $option['id'], true );
                        $checked = $meta ? ' checked="checked"' : '';
                        opc_display_multicheck( $field, $option, $checked );
                    }
                    echo '</div>';
                }
              
                // Display description if one is there
                opc_display_description( $field );

                // Start closing HTML
                $closing = '</div>';
                $closing .= '</div>';
                echo $closing;
            }

            // Closing div to style meta     
            echo '</div>';
        }

        // Save data from meta box
        function save( $post_id ) {
            // Verify nonce
            if ( !isset($_POST['postMetaBox_nonce'] ) || !wp_verify_nonce( $_POST['postMetaBox_nonce'], basename( __FILE__ ) ) ) {
                return $post_id;
            }
     
            // Check autosave
            if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return $post_id;
            }
     
            // Check permissions
            if ( 'page' == $_POST['post_type'] ) {
                if ( !current_user_can( 'edit_page', $post_id ) ) {
                    return $post_id;
                }
            } elseif ( !current_user_can( 'edit_post', $post_id ) ) {
                return $post_id;
            }

            // Validate fields before updating
            // If there is no validate in the array, nothing will save
            foreach ( $this->_postMetaBox['fields'] as $field ) {
                if ( in_array( $field['type'], ['multitext','multicheck'] ) ) {
                    foreach ( $field['options'] as $option ) {
                        $old = get_post_meta( $post_id, $option['id'], true );
                        $new = ( isset( $_POST[$option['id']] ) ? $field['validate']( $_POST[$option['id']] ) : '' );
                        if ( $field['validate'] != '' ) {
                            if ( $new && $new != $old || $new === '0' ) {
                                update_post_meta( $post_id, $option['id'], $new );
                            } elseif ( '' == $new && $old || $old === '0' ) {
                                delete_post_meta( $post_id, $option['id'], $old );
                            }
                        }
                    }                    
                } else {    
                    $old = get_post_meta( $post_id, $field['id'], true );
                    $new = ( isset( $_POST[$field['id']] ) ? $field['validate']( $_POST[$field['id']] ) : '' );
                    if ( $field['validate'] != '' ) {
                        if ( $new && $new != $old || $new === '0' ) {
                            update_post_meta( $post_id, $field['id'], $new );
                        } elseif ( '' == $new && $old || $old === '0' ) {
                            delete_post_meta( $post_id, $field['id'], $old );
                        }
                    }
                }
            }
        }
    }

    // Go through each meta box array and build them
    foreach ( $postMetaBoxes as $postMetaBox ) {
        new OPC_Post_Meta_Box( $postMetaBox );
    }