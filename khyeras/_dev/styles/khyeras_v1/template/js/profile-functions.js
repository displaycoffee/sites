function updateProfileFields() {
	// Reusable selectors for fields
	var accountType     = jQuery( '#pf_account_type' );
	var characterFields = jQuery( '[id^=pf_c_]' );
	var raceType 		= jQuery( '#pf_c_race_type' );
	var raceOpts1 		= jQuery( '#pf_c_race_a_opts' );
	var raceOpts2 		= jQuery( '#pf_c_race_b_opts' );
	var classType 		= jQuery( '#pf_c_class_type' );
	var classOpts1 		= jQuery( '#pf_c_class_a_opts' );
	var classOpts2 		= jQuery( '#pf_c_class_b_opts' );
	var religionType 	= jQuery( '#pf_c_religion_type' );
	var religionOpts 	= jQuery( 'input[name="pf_c_religion_opts[]"]' );

	// Default dropdown text for comparisons
	var defaultText = '-- Please Select --';

	// Disable these fields by default
	var disabledFields = [ raceOpts1, raceOpts2, religionOpts, classOpts1, classOpts2 ];

	for ( var i = 0; i < disabledFields.length; i++ ) {
		if ( disabledFields[i].is( 'select' ) ) {
			disableSelect( disabledFields[i] );
		}
		if ( disabledFields[i].is( 'input[type="checkbox"]' ) ) {
			disableCheckBox( disabledFields[i] );
		}
	}

	// --- START --- Race Dropdown Logic

	// Allowed race combinations
	var allowedRaces = {
		'Dwarf' 	   : [ 'Human', 'Kerasoka', 'Shapeshifter' ],
		'Elemental'    : [ 'Fae', 'Human', 'Kerasoka', 'Lumeacia', 'Shapeshifter' ],
		'Fae' 		   : [ 'Elemental', 'Human', 'Kerasoka', 'Shapeshifter' ],
		'Human' 	   : [ 'Dwarf', 'Elemental', 'Fae', 'Kerasoka', 'Shapeshifter', 'Ue\'drahc' ],
		'Kerasoka'     : [ 'Dwarf', 'Elemental', 'Fae', 'Human', 'Lumeacia', 'Shapeshifter' ],
		'Lumeacia' 	   : [ 'Elemental', 'Kerasoka' ],
		'Shapeshifter' : [ 'Dwarf', 'Elemental', 'Fae', 'Human', 'Kerasoka' ],
		'Ue\'drahc'    : [ 'Human' ]
	}

	// Check for changes on race type
	raceType.on( 'change', function() {
		var selected = findSelected( raceType );

		// Reset options on any change
		resetSelectOptions( raceOpts1, defaultText );
		resetSelectOptions( raceOpts2, defaultText );
		disableSelect( raceOpts1 );
		disableSelect( raceOpts2 );

		// Check if selected is not equal to default option
		if ( selected != defaultText ) {
			// Enable option menu 1
			enableSelect( raceOpts1 );

			// Enable certain options depending on selection
			if ( selected == 'Full Blooded' ) {
				enableSelectOptions( raceOpts1 );
			} else if ( selected == 'Half-Breed' ) {
				raceOpts1.find( 'option' ).each( function() {
					var optionText = jQuery( this ).text().trim();
					if ( allowedRaces[ optionText ] ) {
						jQuery( this ).prop( 'disabled', false );
					}
				});
			}
		}
	});

	// Check for changes on race options 1
	raceOpts1.on( 'change', function() {
		var selected = findSelected( raceOpts1 );

		// Reset options on any change
		resetSelectOptions( raceOpts2, defaultText );
		disableSelect( raceOpts2 );

		// Check if selected is not equal to default option and if the race type is Half-Breed
		if ( selected != defaultText && findSelected( raceType ) == 'Half-Breed' ) {
			enableSelect( raceOpts2 );

			// Get list of races that are allowed to be half-breed
			var raceList = allowedRaces[ selected ];
			if ( raceList && raceList.length ) {
				raceOpts2.find( 'option' ).each( function() {
					var optionText = jQuery( this ).text().trim();
					if ( raceList.indexOf( optionText ) > -1 ) {
						jQuery( this ).prop( 'disabled', false );
					} else {
						jQuery( this ).prop( 'disabled', true );
					}
				});
			}
		}
	});

	// --- END --- Race Dropdown Logic

	// --- START --- Class Dropdown Logic

	// --- END --- Class Dropdown Logic

	// --- START --- Religion Checkbox Logic

	// --- END --- Religion Checkbox Logic	

	// Disable select menu and options
	function disableSelect( selector ) {
		if ( !selector.prop( 'disabled' ) ) {
			selector.prop( 'disabled', true );
		}

		selector.find( 'option' ).each( function() {
			if ( !jQuery( this ).prop( 'disabled' ) ) {
				jQuery( this ).prop( 'disabled', true );
			}
		});
	}

	// Reset select menu options
	function resetSelectOptions( selector, text ) {
		// Remove currently selected item
		selector.find( 'option:selected' ).removeAttr( 'selected' );

		// Add new selected item
		var options = selector.find( 'option' );
		for ( var i = 0; i < options.length; i++ ) {
			if ( jQuery( options[i] ).text().trim() == text ) {
				selector.val( jQuery( options[i] ).val() );
				break;
			}
		}
	}

	// Enable select menu
	function enableSelect( selector ) {
		if ( selector.prop( 'disabled' ) ) {
			selector.prop( 'disabled', false );
		}
	}

	// Enable all select options
	function enableSelectOptions( selector ) {
		selector.find( 'option' ).each( function() {
			if ( jQuery( this ).prop( 'disabled' ) ) {
				jQuery( this ).prop( 'disabled', false );
			}
		});
	}

	// Disable checkbox options
	function disableCheckBox( selector ) {
		selector.prop({ 'disabled' : true, 'checked' : false });
	}

	// Get the currently selected option
	function findSelected( selector ) {
		return selector.find( 'option:selected' ).text().trim();
	}
}

function profileThings() {
	if ( jQuery( 'body' ).hasClass( 'section-ucp-register' ) ) {
		// Character field selector
		var characterFields = jQuery( '[id^=pf_c_]' );

		// Default dropdown text for comparisons
		var defaultText = '-- Please Select --';

		// Required field values to change
		var requiredFields = {
			'pf_c_race_type' : {
				'fieldType' : 'select',
				'hidden'    : 'Full Blooded'
			},
			'pf_c_race_a_opts' : {
				'fieldType' : 'select',
				'hidden'    : 'Human'
			},
			'pf_c_class_type' : {
				'fieldType' : 'select',
				'hidden'    : 'Single'
			},
			'pf_c_class_a_opts' : {
				'fieldType' : 'select',
				'hidden'    : 'Fighter'
			}
		}

		// When selecting character account, disable these fields by default
		var characterDisabled = [ 'pf_c_race_a_opts', 'pf_c_race_b_opts', 'pf_c_religion_opts[]', 'pf_c_class_a_opts', 'pf_c_class_b_opts' ];

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
		var selectedDropdown = jQuery( '#pf_account_type' );
		var selectedAccount = findSelected( selectedDropdown );
		setRequiredDisabled();
		updateRequiredDropdowns( '#pf_c_race_type', '#pf_c_race_a_opts', '#pf_c_race_b_opts', 'Half-Breed', raceAllowed );
		updateRequiredDropdowns( '#pf_c_class_type', '#pf_c_class_a_opts', '#pf_c_class_b_opts', 'Dual' );

		// If account selection has changed, selected account variable
		selectedDropdown.on( 'change', function() {
			selectedAccount = findSelected( jQuery( this ) );
		});

		// This is a test
		jQuery( '#register' ).on( 'submit', function( e ) {
			// I probably don't need this...
			selectedAccount = findSelected( selectedDropdown );

			if ( selectedAccount == '10' ) {
				characterFields.each( function() {
			    	jQuery( this ).prop( 'disabled', false );
				});
				updateWriterFields();
			}

			// Remove this later
			// return false;
		});

		// Update religion checkboxes based on type selection
		// var religionMenu = jQuery( '#pf_c_religion_type' );
		// updateReligion( religionMenu );
		// religionMenu.on( 'change', function() {
		// 	updateReligion( religionMenu );
		// });
	}

	function updateWriterFields() {
		// Loop through all character fields and set as needed
		characterFields.each( function() {
			var current = jQuery( this );

			if ( current.is( 'select' ) ) {
				current.find( 'option:selected' ).removeAttr( 'selected' );
				updateSelectMenu( current, defaultText );
			} else  {
				if ( current.is( 'input[type="checkbox"]' ) ) {
					current.prop( 'checked', false );
				}
				current.val( '' );
			}
		});

		// For each item in requiredFields object, update the value depending on account
		jQuery.each( requiredFields, function( key, value ) {
			var field = jQuery( 'label[for="' + key + '"]' ).closest( 'dl' );
			updateSelectMenu( field, value.hidden );
		});
	}

	function setRequiredDisabled() {
		// Loop through all the custom profile fields and disable required fields
		characterFields.each( function() {
			var current = jQuery( this );

			if ( characterDisabled.indexOf( current.attr( 'name' ) ) > -1 ) {
				jQuery( this ).prop( 'disabled', true );
			}
		});
	}

	function updateRequiredDropdowns( main, opts1, opts2, multiText, allowed ) {
		// Select menus
		var dropdownType = jQuery( main );
		var dropdownOpts1 = jQuery( opts1 );
		var dropdownOpts2 = jQuery( opts2 );

		// Watch for changes on type
		dropdownType.on( 'change', function() {
			// Always reset select menus when type changes
			dropdownOpts1.find( 'option' ).each( function() {
				jQuery( this ).prop( 'disabled', false );
			});
			updateSelectMenu( dropdownOpts1, defaultText );
			updateSelectMenu( dropdownOpts2, defaultText );
			dropdownOpts1.add( dropdownOpts2 ).prop( 'disabled', true );

			// If the selected type does not equal default text, enable first dropdown
			if ( findSelected( jQuery( this ) ) != defaultText ) {

				// Update half breed options as needed
				if ( findSelected( jQuery( this ) ) == multiText ) {
					dropdownOpts1.find( 'option' ).each( function() {
						if ( !allowed[jQuery( this ).text().trim()] ) {
							jQuery( this ).prop( 'disabled', true );
						}
					});
				}

				dropdownOpts1.prop( 'disabled', false );
			}
		});

		// Watch for changes on primary dropdown (opts1)
		dropdownOpts1.on( 'change', function() {
			// If type allows for a second selection and the primary selection and defaultText are not the same...
			// Then show the second drop dropdown and reset if no longer true
			if ( findSelected( dropdownType ) == multiText && findSelected( jQuery( this ) ) != defaultText ) {
				dropdownOpts2.prop( 'disabled', false );
			} else {
				updateSelectMenu( dropdownOpts2, defaultText );
				dropdownOpts2.prop( 'disabled', true );
			}
		});
	}

	function updateReligion( field ) {
		// Get current selected option
		var selected = findSelected( field );

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

	function findSelected( selector ) {
		return selector.find( 'option:selected' ).text().trim();
	}
}

var religionAllowed = {
	'Archaicism' : [ 'Dainyil', 'Ixaziel', 'Ny\'tha', 'Pheriss', 'Ristgir' ],
	'Idolism'	 : [ 'Cecilia', 'Bhelest' ]
}



// // Hide any custom profile field starting with pf_c_
// characterFields.each( function() {
// 	if (selectedAccount == '9') {
// 		//jQuery( this ).prop( 'disabled', false );
// 		//jQuery( this ).closest( 'dl' ).removeClass( 'hide-fields' );
// 	} else {
// 		//jQuery( this ).prop( 'disabled', true );
// 		//jQuery( this ).closest( 'dl' ).addClass( 'hide-fields' );
// 	}
// });
