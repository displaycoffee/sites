function updateProfileFields() {
	// TO DO
	// Character fields for required select menus don't stay selected properly if
	// something is submitted wrong
	// show / hide fields

	if ( jQuery( 'body' ).hasClass( 'section-ucp-register' ) ) {
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

		// Initially change text of account type options
		// Writer = 10, Character = 9
		updateAccountTypeOptions( accountType, '10', 'Writer', '9', 'Character' );

		// --- START --- RACE DROPDOWN LOGIC

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

		// --- END --- RACE DROPDOWN LOGIC

		// --- START --- RELIGION CHECKBOX LOGIC

		// Allowed religion combinations
		var allowedReligion = {
			'Archaicism' : [ 'Dainyil', 'Ixaziel', 'Ny\'tha', 'Pheriss', 'Ristgir' ],
			'Idolism'	 : [ 'Cecilia', 'Bhelest' ]
		}

		// Check for changes on religion type
		religionType.on( 'change', function() {
			var selected = findSelected( religionType );

			// Reset options on any change
			disableCheckBox( religionOpts );

			// Check if selected is not equal to default option
			if ( selected != defaultText && allowedReligion[ selected ] ) {

				// Check religion combinations that are available
				religionOpts.each( function() {
					var optionText = jQuery( this ).closest( 'label' ).text().trim();
					if ( allowedReligion[ selected ].indexOf( optionText ) > -1 ) {
						jQuery( this ).prop( 'disabled', false );
					} else {
						jQuery( this ).prop( 'disabled', true );
					}
				});
			}
		});

		// --- END --- RELIGION CHECKBOX LOGIC

		// --- START --- CLASS DROPDOWN LOGIC

		// Check for changes on class type
		classType.on( 'change', function() {
			var selected = findSelected( classType );

			// Reset options on any change
			resetSelectOptions( classOpts1, defaultText );
			resetSelectOptions( classOpts2, defaultText );
			disableSelect( classOpts1 );
			disableSelect( classOpts2 );

			// Check if selected is not equal to default option
			if ( selected != defaultText ) {
				// Enable option menu 1
				enableSelect( classOpts1 );
				enableSelectOptions( classOpts1 );
			}
		});

		// Check for changes on class options 1
		classOpts1.on( 'change', function() {
			var selected = findSelected( classOpts1 );

			// Reset options on any change
			resetSelectOptions( classOpts2, defaultText );
			disableSelect( classOpts2 );

			// Check if selected is not equal to default option and if the race type is Dual
			if ( selected != defaultText && findSelected( classType ) == 'Dual' ) {
				enableSelect( classOpts2 );

				classOpts2.find( 'option' ).each( function() {
					var optionText = jQuery( this ).text().trim();
					if ( selected == optionText || optionText == defaultText ) {
						jQuery( this ).prop( 'disabled', true );
					} else {
						jQuery( this ).prop( 'disabled', false );
					}
				});
			}
		});

		// --- END --- CLASS DROPDOWN LOGIC

		// --- START --- SUBMIT LOGIC

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

		// This is a test
		jQuery( '#register' ).on( 'submit', function( e ) {
			// Writer = 10, Character = 9
			var selectedAccount = findSelected( accountType );

			// Check if the writer account is selected
			if ( selectedAccount == 'Writer' || selectedAccount == '10' ) {

				// Loop through all character fields and set as needed
				characterFields.each( function() {
					var current = jQuery( this );
					if ( current.is( 'select' ) ) {
						disableSelect( current );
						resetSelectOptions( current, defaultText );
					} else  {
						if ( current.is( 'input[type="checkbox"]' ) ) {
							disableCheckBox( current );
						}
						current.val( '' );
					}
				});

				// Change account type options again
				// Writer = 10, Character = 9
				updateAccountTypeOptions( accountType, 'Writer', '10', 'Character', '9' );

				// For each item in requiredFields object, update the value
				jQuery.each( requiredFields, function( key, value ) {
					var selector = jQuery( '#' + key );
					if ( selector.is( 'select' ) ) {
						enableSelect( selector );
						enableSelectOptions( selector );
						resetSelectOptions( selector, value.hidden );
					}
				});
			}

			// Remove this later
			//return false;
		});

		// --- END --- SUBMIT LOGIC

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

		// Update account type option text
		function updateAccountTypeOptions( selector, condition1, replace1, condition2, replace2 ) {
			selector.find( 'option' ).each( function() {
				var optionText = jQuery( this ).text().trim();

				if ( optionText == condition1 ) {
					jQuery( this ).text( function () {
						return jQuery( this ).text().replace( optionText, replace1 );
					});​​​​​
				} else if ( optionText == condition2 ) {
					jQuery( this ).text( function () {
						return jQuery( this ).text().replace( optionText, replace2 );
					});​​​​​
				}
			});
		}
	}
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
