function profileThings() {
	if ( jQuery( 'body' ).hasClass( 'section-ucp-register' ) ) {
		var defaultText = '-- Please Select --';

		var requiredFields = {
			'pf_c_race_type' : {
				'fieldType' : 'select',
				'default'   : defaultText,
				'hidden'    : 'Full Blooded'
			},
			'pf_c_race_a_opts' : {
				'fieldType' : 'select',
				'default'   : defaultText,
				'hidden'    : 'Human'
			},
			'pf_c_class_type' : {
				'fieldType' : 'select',
				'default'   : defaultText,
				'hidden'    : 'Single'
			},
			'pf_c_class_a_opts' : {
				'fieldType' : 'select',
				'default'   : defaultText,
				'hidden'    : 'Fighter'
			}
		}

		var religionAllowed = {
			'Archaicism' : [ 'Dainyil', 'Ixaziel', 'Ny\'tha', 'Pheriss', 'Ristgir' ],
			'Idolism'	 : [ 'Cecilia', 'Bhelest' ]
		}

		var raceAllowed = {
			'Dwarf' : [ 'Human', 'Kerasoka', 'Shapeshifter' ],
			'Elemental' : [ 'Fae', 'Human', 'Kerasoka', 'Lumeacia', 'Shapeshifter' ],
			'Fae' : [ 'Elemental', 'Human', 'Kerasoka', 'Shapeshifter' ],
			'Human' : [ 'Dwarf', 'Elemental', 'Fae', 'Kerasoka', 'Shapeshifter', 'Ue\'drahc' ],
			'Kerasoka' : [ 'Dwarf', 'Elemental', 'Fae', 'Human', 'Lumeacia', 'Shapeshifter' ],
			'Lumeacia' : [ 'Elemental', 'Kerasoka' ],
			'Shapeshifter' : [ 'Dwarf', 'Elemental', 'Fae', 'Human', 'Kerasoka' ],
			'Ue\'drahc' : [ 'Human' ]
		}

		// Writer = 10, Character = 9
		var selectedAccount = '10';
		updateRequiredFields();

		// If account selection has changed, update fields
		jQuery( '#pf_account_type' ).on( 'change', function() {
			selectedAccount = jQuery( this ).find( 'option:selected' ).text().trim();
			updateRequiredFields();
		});

		// Re-enable disabled fields so form can submit properly
		jQuery('#register').on('submit', function() {
			jQuery( '[id^=pf_c_]' ).each( function() {
		    	jQuery( this ).prop( 'disabled', false );
			});
		});

		// Update race based on type selection
		// var raceMenu = jQuery( '#pf_c_race_type' );
		// updateRace( raceMenu );
		// raceMenu.on( 'change', function() {
		// 	updateRace( raceMenu );
		// });

		// Update religion checkboxes based on type selection
		// var religionMenu = jQuery( '#pf_c_religion_type' );
		// updateReligion( religionMenu );
		// religionMenu.on( 'change', function() {
		// 	updateReligion( religionMenu );
		// });
	}

	function updateRequiredFields() {
		// For each field in the requiredFields object, update the value depending on account
		jQuery.each( requiredFields, function( key, value ) {
			var field = jQuery( 'label[for="' + key + '"]' ).closest( 'dl' );
			var fieldValue = ( selectedAccount == '9' ) ? value.default : value.hidden;

			// Update select menus
			if ( value.fieldType == 'select' ) {
				updateSelectMenu( field, fieldValue );
			}
		});

		// Hide any custom profile field starting with pf_c_
		jQuery( '[id^=pf_c_]' ).each( function() {
			if (selectedAccount == '9') {
				jQuery( this ).prop( 'disabled', false );
				//jQuery( this ).closest( 'dl' ).removeClass( 'hide-fields' );
			} else {
				jQuery( this ).prop( 'disabled', true );
				//jQuery( this ).closest( 'dl' ).addClass( 'hide-fields' );
			}
		});
	}

	// function updateRace( field ) {
	// 	// Get current selected option
	// 	var selected = field.find( 'option:selected' ).text().trim();
	// 	var raceOpts1 = jQuery( '#pf_c_race_a_opts' );
	// 	var raceOpts2 = jQuery( '#pf_c_race_b_opts' );
	//
	// 	console.log(selected, defaultText);
	//
	// 	if ( selected == defaultText ) {
	// 		console.log('hello')
	// 		raceOpts1.prop( 'disabled', true );
	// 		raceOpts2.prop( 'disabled', true );
	// 	} else if ( selected == 'Full Blooded' ) {
	// 		raceOpts1.prop( 'disabled', false );
	// 		raceOpts2.prop( 'disabled', true );
	// 	}
	//
	// 	raceOpts1.on( 'change', function() {
	// 		if ( field.find( 'option:selected' ).text().trim() != defaultText ) {
	// 			raceOpts2.prop( 'disabled', false );
	// 		}
	// 	});
	// }

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

	// function updateCheckboxes( field, text ) {
	// 	// Remove currently selected item
	// 	field.find( 'input[type="checkbox"]' ).prop( 'checked', false );
	//
	// 	// Add new selected item
	// 	if ( text != 'None' ) {
	// 		field.find( 'input[type="checkbox"]' ).each( function() {
	// 			if ( jQuery( this ).closest( 'label' ).text().trim() == text ) {
	// 				jQuery( this ).prop( 'checked', true );
	// 			}
	// 		});
	// 	}
	// }
}
