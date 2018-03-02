function profileThings() {
	if ( jQuery( 'body' ).hasClass( 'section-ucp-register' ) ) {
		var requiredFields = {
			'pf_c_race_type' : {
				'fieldType' : 'select',
				'default'   : 'Unknown',
				'hidden'    : 'Full Blooded'
			},
			'pf_c_race_opts' : {
				'fieldType' : 'checkbox',
				'default'   : 'None',
				'hidden'    : 'Human'
			},
			'pf_c_class_type' : {
				'fieldType' : 'select',
				'default'   : 'Unknown',
				'hidden'    : 'Single'
			},
			'pf_c_class_opts' : {
				'fieldType' : 'checkbox',
				'default'   : 'None',
				'hidden'    : 'Fighter'
			}
		}

		var religionAllowed = {
			'Archaicism' : [ 'Dainyil', 'Ixaziel', 'Ny\'tha', 'Pheriss', 'Ristgir' ],
			'Idolism'	 : [ 'Cecilia', 'Bhelest' ]
		}

		// // Writer = 10, Character = 9
		// var selectedAccount = '10';
		// updateRequiredFields();
		//
		// // If account selection has changed, update fields
		// jQuery( '#pf_account_type' ).on( 'change', function() {
		// 	selectedAccount = jQuery( this ).find( 'option:selected' ).text().trim();
		// 	updateRequiredFields();
		// });

		// Update religion checkboxes based on type selection
		var religionMenu = jQuery( '#pf_c_religion_type' );
		updateReligion( religionMenu );
		religionMenu.on( 'change', function() {
			updateReligion( religionMenu );
		});
	}

	function updateRequiredFields() {
		// For each field in the requiredFields object, update the value depending on account
		jQuery.each( requiredFields, function( key, value ) {
			var field = jQuery( 'label[for="' + key + '"]' ).closest( 'dl' );
			var fieldValue = ( selectedAccount == '10' ) ? value.hidden : value.default;

			// Update select menus
			if ( value.fieldType == 'select' ) {
				updateSelectMenu( field, fieldValue );
			}

			// Update checkboxes
			if ( value.fieldType == 'checkbox' ) {
				updateCheckboxes( field, fieldValue );
			}
		});

		// Hide any custom profile field starting with pf_c_
		jQuery( '[id^=pf_c_]' ).each( function() {
			if (selectedAccount == '9') {
				jQuery( this ).closest( 'dl' ).removeClass( 'hide-fields' );
			} else {
				jQuery( this ).closest( 'dl' ).addClass( 'hide-fields' );
			}
		});
	}

	function updateReligion( field ) {
		// Get current selected option
		var selected = field.find( 'option:selected' ).text().trim();

		// Find the specific religion options
		jQuery( 'label[for^=pf_c_religion_opts_]' ).each( function() {
			// Initially disable all checkboxes
			jQuery( this ).find( 'input[type="checkbox"]' ).prop({ 'disabled' : true, 'checked' : false });

			// If religion is not in the selected array, don't enable the option
			if ( religionAllowed[selected] ) {
				var optionText = jQuery( this ).text().trim();

				if ( religionAllowed[selected].indexOf( optionText ) > -1 ) {
					jQuery( this ).find( 'input[type="checkbox"]' ).prop( 'disabled', false );
				}
			}
		});
	}

	function updateSelectMenu( field, text ) {
		// Remove currently selected item
		field.find( 'option:selected' ).removeAttr( 'selected' );

		// Add new selected item
		field.find( 'option' ).each( function() {
			if ( jQuery( this ).text().trim() == text ) {
				var optValue = jQuery( this ).val();
				field.find( 'select' ).val( optValue );
			}
		});
	}

	function updateCheckboxes( field, text ) {
		// Remove currently selected item
		field.find( 'input[type="checkbox"]' ).prop( 'checked', false );

		// Add new selected item
		if ( text != 'None' ) {
			field.find( 'input[type="checkbox"]' ).each( function() {
				if ( jQuery( this ).closest( 'label' ).text().trim() == text ) {
					jQuery( this ).prop( 'checked', true );
				}
			});
		}
	}
}
