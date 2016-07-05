<?php
	// Exit if accessed directly
	if ( !defined( 'ABSPATH' ) ) { exit; }
	
    // Class for putting together all the meta box goodness
    class OPC_Term_Meta_Box {	
    	protected $_termMetaBox; 

        // Add actions for meta boxes
        function __construct( $termMetaBox ) {
            $this->_termMetaBox = $termMetaBox;
            add_action( $this->_termMetaBox['category'] . '_add_form_fields', array( &$this, 'add_meta' ), 10, 2 );
            add_action( $this->_termMetaBox['category'] . '_edit_form_fields', array( &$this, 'edit_meta' ), 10, 2 );
            add_action( 'created_' . $this->_termMetaBox['category'], array( &$this, 'save' ), 10, 2 );
            add_action( 'edited_' . $this->_termMetaBox['category'], array( &$this, 'save' ), 10, 2 );
            add_filter( 'manage_edit-' . $this->_termMetaBox['category'] . '_columns', array( &$this, 'add_column' ) );
            add_filter( 'manage_' . $this->_termMetaBox['category'] . '_custom_column', array( &$this, 'add_column_content' ), 10, 3 );
            add_filter( 'manage_edit-' . $this->_termMetaBox['category'] . '_sortable_columns', array( &$this, 'add_column_sort' ) );
        } 

        // Add fields onto the 'Add New' page
		function add_meta() {
            // Use nonce for verification
            echo '<input type="hidden" name="termMetaBox_nonce" value="', wp_create_nonce( basename( __FILE__ ) ), '" />';

            // Loop through each meta box array
            foreach ( $this->_termMetaBox['fields'] as $field ) {
                // Create opening HTML block
                $opening = '<div class="form-field ' . $field['id'] . '-wrap cstmstff-term-meta">';
                $opening .= '<label for="' . $field['id'] . '">';
                $opening .= $field['label'];
                $opening .= '</label>';

                // Display opening HTML block
                echo $opening;

                // Common display value
                $value = '';

				// Loop through basic field types
                opc_display_fields( $field, $value );

                // Display multiple text fields
                if ( $field['type'] == 'multitext' ) {
                	echo '<div class="options">';
                    foreach ( $field['options'] as $option ) {
                        $meta = '';
                        $value = isset( $meta ) ? $meta : '';
                        opc_display_multitext( $field, $option, $value );
                    }
                    echo '</div>';                    
                }

                // Display multiple checkboxes
                if ( $field['type'] == 'multicheck' ) {
                	echo '<div class="options">';
                    foreach ( $field['options'] as $option ) {
                        $meta = '';
                        $checked = $meta ? ' checked="checked"' : '';
                        opc_display_multicheck( $field, $option, $checked );
                    }
                    echo '</div>';
                }

                // Display description if one is there
                opc_display_description( $field );

                // Create closing HTML block
                $closing = '</div>';

                // Display closing HTML block
                echo $closing;
            }
		}	

		// Edit fields on the category page
		function edit_meta( $term ) {
            // Use nonce for verification
            echo '<input type="hidden" name="termMetaBox_nonce" value="', wp_create_nonce( basename( __FILE__ ) ), '" />';

		    // Loop through each meta box array            
		    foreach ( $this->_termMetaBox['fields'] as $field ) {		    
	            // Create opening HTML block
	            $opening = '<tr class="form-field ' . $field['id'] . '-wrap cstmstff-term-meta">';
	            $opening .= '<th scope="row">';
	            $opening .= '<label for="' . $field['id'] . '">';
	            $opening .= $field['label'];
	            $opening .= '</label>';
	            $opening .= '</th>';
	            $opening .= '<td>';

	            // Display opening HTML block
	            echo $opening;
	            
                // Get the term meta
                $meta = get_term_meta( $term->term_id, $field['id'], true );

                // Common display value
                $value = isset( $meta ) ? $meta : '';

				// Loop through basic field types
                opc_display_fields( $field, $value );

                // Display multiple text fields
                if ( $field['type'] == 'multitext' ) {
                	echo '<div class="options">';
                    foreach ( $field['options'] as $option ) {
                        $meta = get_term_meta( $term->term_id, $option['id'], true );
                        $value = isset( $meta ) ? $meta : '';
                        opc_display_multitext( $field, $option, $value );
                    }
                    echo '</div>';                    
                }

                // Display multiple checkboxes
                if ( $field['type'] == 'multicheck' ) {
                	echo '<div class="options">';
                    foreach ( $field['options'] as $option ) {
                        $meta = get_term_meta( $term->term_id, $option['id'], true );
                        $checked = $meta ? ' checked="checked"' : '';
                        opc_display_multicheck( $field, $option, $checked );
                    }
                    echo '</div>';
                }

                // Display description if one is there
                opc_display_description( $field );

	            // Create closing HTML block
	            $closing = '</td>';
	            $closing .= '</tr>';

	            // Display closing HTML block
	            echo $closing;
	        }
		}

		// Updates meta
		function save( $term_id ) {
            // Verify nonce
            if ( !isset( $_POST['termMetaBox_nonce'] ) || !wp_verify_nonce( $_POST['termMetaBox_nonce'], basename( __FILE__ ) ) ) {
                return;
            }

			// Check permissions
            if ( !current_user_can( 'manage_categories' ) ) {
                return;
            }

            // Validate fields before updating
            // If there is no validate in the array, nothing will save
			foreach ( $this->_termMetaBox['fields'] as $field ) {
				if ( in_array( $field['type'], ['multitext','multicheck'] ) ) {
					foreach ( $field['options'] as $option ) {
				    	$old = get_term_meta( $term_id, $option['id'], true );
						$new = ( isset( $_POST[$option['id']] ) ? $field['validate']( $_POST[$option['id']] ) : '' );
						if ( $field['validate'] != '' ) {
							if ( $new && $new != $old || $new === '0' ) {
					        	update_term_meta( $term_id, $option['id'], $new );
					        } elseif ( '' == $new && $old || $old === '0' ) {
				        		delete_term_meta( $term_id, $option['id'], $old );
					        }
				    	}
				    }
			    } else {
			    	$old = get_term_meta( $term_id, $field['id'], true );
					$new = ( isset( $_POST[$field['id']] ) ? $field['validate']( $_POST[$field['id']] ) : '' );
					if ( $field['validate'] != '' ) {
						if ( $new && $new != $old || $new === '0' ) {
				        	update_term_meta( $term_id, $field['id'], $new );
				        } elseif ( '' == $new && $old || $old === '0' ) {
			        		delete_term_meta( $term_id, $field['id'], $old );
				        }
			    	}
			    }
		    }
		}

		// Add columns on 'Add New' page
		function add_column( $columns ) {
			foreach ( $this->_termMetaBox['fields'] as $field ) {
				if ( $field['column'] == 'yes' ) {
					if ( in_array( $field['type'], ['multitext','multicheck'] ) ) {
						foreach ( $field['options'] as $option ) {
							$columns[$option['id']] = $option['label'];
						}
					} else {
						$columns[$field['id']] = $field['label'];
					}
				}
			}
			return $columns;
		}

		// Add content to columns on 'Add New' page
		function add_column_content( $content, $column, $term_id ) {
		    foreach ( $this->_termMetaBox['fields'] as $field ) {
		    	if ( $field['column'] == 'yes' ) {
			    	if ( in_array( $field['type'], ['multitext','multicheck'] ) ) {
			    		foreach ( $field['options'] as $option ) {
							if ( $option['id'] === $column ) {
				                // Get the term meta
				                $meta = get_term_meta( $term_id, $option['id'], true );

				                // Common display value
				                $value = isset( $meta ) ? $meta : '';

				                // Display value in column
						        $content = $field['validate']( $value );
							}
						}
			    	} else {
						if ( $field['id'] === $column ) {
			                // Get the term meta
			                $meta = get_term_meta( $term_id, $field['id'], true );

			                // Common display value
			                $value = isset( $meta ) ? $meta : '';

			                // Display value in column
					        $content = $field['validate']( $value );
						}
					}
				}
			}
			return $content;
		}

		// Make columns sortable
		function add_column_sort( $sortable ) {
			foreach ( $this->_termMetaBox['fields'] as $field ) {
				if ( $field['column'] == 'yes' ) {
					if ( in_array($field['type'], ['multitext','multicheck'] ) ) {
						foreach ( $field['options'] as $option ) {
							$sortable[$option['id']] = $option['id'];
						}
					} else {
						$sortable[$field['id']] = $field['id'];
					}
				}
			}
		    return $sortable;
		}
    }

    // Go through each meta box array and build them
    foreach ( $termMetaBoxes as $termMetaBox ) {
        new OPC_Term_Meta_Box( $termMetaBox );
    }