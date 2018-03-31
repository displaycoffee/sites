function updateProfileFields() {
	if ( jQuery( 'body' ).hasClass( 'section-ucp-register' ) ) {
		// Reusable language variables
		var defaultText = '-- Please Select --';
		var fb 			= 'Full Blooded';
		var hb 			= 'Half-Breed';
		var single		= 'Single';
		var dual		= 'Dual';
		var archaicism	= 'Archaicism';
		var idolism		= 'Idolism';

		// Reusable selectors for fields
		var accountType     = jQuery( '#pf_account_type' );
		var characterFields = jQuery( '[id^=pf_c_]' );
		var raceType 		= jQuery( '#pf_c_race_type' );
		var raceOpts 		= jQuery( 'input[name="pf_c_race_opts[]"]' );
		var raceParent 		= jQuery( '#pf_c_race_opts_1' ).closest( 'dd' );
		var classType 		= jQuery( '#pf_c_class_type' );
		var classOpts 		= jQuery( 'input[name="pf_c_class_opts[]"]' );
		var classParent		= jQuery( '#pf_c_class_opts_1' ).closest( 'dd' );
		var religionType 	= jQuery( '#pf_c_religion_type' );
		var religionOpts 	= jQuery( 'input[name="pf_c_religion_opts[]"]' );
		var religionParent  = jQuery( '#pf_c_religion_opts_1' ).closest( 'dd' );

		// Set variables without values
		var current, checkedBox, optText;
		var raceCount, selRaceType, selRaceOpt;
		var classCount, selClassType, selClassOpt;
		var religionCount, selReligionType, selReligionOpt;

		// --- START --- RACE LOGIC

		// Check for changes on race type dropdown
		raceType.on( 'change', function() {
			selRaceType = findSelected( raceType );

			// Reset options on change
			toggleCheckBox( raceOpts, false );
			disableAllClass();

			// Enable options depending on type selection
			defaultRaceOptions( selRaceType );
		});

		// Check for changes on race checkboxes
		updateRaceOptions();
		raceOpts.on( 'change', function() {
			updateRaceOptions();
		});

		// Update race options depending on various selections
		function updateRaceOptions() {
			selRaceType = findSelected( raceType );

			// Update count of checkboxes
			checkedBox = raceParent.find( 'input[type="checkbox"]:checked' );
			raceCount = checkedBox.length;

			// Check if full breed or half-breed is selected
			if ( selRaceType == fb || selRaceType == hb ) {
				raceOpts.each( function() {
					current = jQuery( this );

					// If half-breed and one box is selected, update remaining
					if ( selRaceType == hb && raceCount == 1 ) {
						 selRaceOpt = getCheckText( checkedBox );

						// Create exclude array and enable / disable boxes
						var raceArray = mergeArray( characterRules[selRaceOpt]['exRace'], nonHalf );
						if ( raceArray && raceArray.indexOf( getCheckText( current ) ) <= -1 )	{
							toggleCheckBox( current, true );
						} else {
							toggleCheckBox( current, false );
						}

						// Also make sure classes are still disabled
						disableAllClass();
					} else if ( ( selRaceType == fb && raceCount == 1 ) || ( selRaceType == hb && raceCount == 2 ) ) {
						// If max count is met, disable remaining checkboxes
						// Half-breed - MAX: 2, Full blooded - MAX: 1
						if ( !current.is(':checked') ) {
							toggleCheckBox( current, false );
						}

						// And allow class type selection
						toggleSelect( classType, true );
					} else {
						// If no above conditions are met, reset to default options and disable classes
						defaultRaceOptions( selRaceType );
						disableAllClass();
					}
				});
			} else {
				// When default is selected, disable all options
				toggleCheckBox( raceOpts, false );
				toggleSelect( classType, false );
			}
		}

		// Build default race options depending on selection
		function defaultRaceOptions( rtype ) {
			if ( rtype == fb ) {
				toggleCheckBox( raceOpts, true );
			} else if ( rtype == hb ) {
				jQuery.each( raceOpts, function() {
					current = jQuery( this );
					optText = getCheckText( current );

					if ( nonHalf.indexOf( optText ) <= -1 ) {
						toggleCheckBox( current, true );
					}
				});
			}
		}

		// --- END --- RACE LOGIC

		// --- START --- CLASS LOGIC

		// Check for changes on class type dropdown
		classType.on( 'change', function() {
			selRaceType = findSelected( raceType );
			selClassType = findSelected( classType );

			// Reset options on change
			toggleCheckBox( classOpts, false );

			// Enable options depending on type selections
			defaultClassOptions( selRaceType, selClassType );
		});

		// Check for changes on class checkboxes
		updateClassOptions();
		classOpts.on( 'change', function() {
			updateClassOptions();
		});

		// Update class options depending on various selections
		function updateClassOptions() {
			selRaceType = findSelected( raceType );
			selClassType = findSelected( classType );

			// Update count of checkboxes
			checkedBox = classParent.find( 'input[type="checkbox"]:checked' );
			classCount = checkedBox.length;

			// Check if single or dual is selected
			if ( selClassType == single || selClassType == dual ) {
				classOpts.each( function() {
					current = jQuery( this );

					// If max count is met, disable remaining checkboxes
					// Dual - MAX: 2, Single - MAX: 1
					if ( ( selClassType == single && classCount == 1 ) || ( selClassType == dual && classCount == 2 ) ) {
						if ( !current.is(':checked') ) {
							toggleCheckBox( current, false );
						}
					} else {
						// If no above conditions are met, reset to default options
						defaultClassOptions( selRaceType, selClassType );
					}
				});
			} else {
				// When default is selected, disable all options
				toggleCheckBox( classOpts, false );
			}
		}

		// Build default class options depending on race and class selection
		function defaultClassOptions( rtype, ctype ) {
			// Build excluded class list from selected races
			var classArray = [];
			raceOpts.each( function() {
				current = jQuery( this );
				optText = getCheckText( current );

				if ( current.is(':checked') ) {
					var classList = characterRules[optText]['exClass'];

					// Define allowed classes based on race type and checked boxes
					if ( classList ) {
						// Half-breed dwarves can be magic users
						if ( rtype == hb && optText == 'Dwarf' ) {
							classArray = dragonClasses;
						} else {
							classArray = mergeArray( classArray, classList );
						}
					}
				}
			});

			// Enable options depending on type selection
			if ( ctype != defaultText ) {
				jQuery.each( classOpts, function() {
					current = jQuery( this );
					optText = getCheckText( current );

					if ( classArray.indexOf( optText ) <= -1 ) {
						toggleCheckBox( current, true );
					}
				});
			}
		}

		// Reset for disabling everything class related
		function disableAllClass() {
			toggleSelect( classType, false );
			toggleCheckBox( classOpts, false );
		}

		// --- END --- CLASS LOGIC

		// --- START --- RELIGION LOGIC

		// Check for changes on religion type dropdown
		religionType.on( 'change', function() {
			var selReligionType = findSelected( religionType );

			// Reset options on change
			toggleCheckBox( religionOpts, false );

			// Enable options depending on type selections
			enableReligionOptions( selReligionType );
		});

		// Check for changes on religion checkboxes
		religionOpts.on( 'change', function() {
			var selReligionType = findSelected( religionType );

			// Update count of checkboxes
			var checkedBox = religionParent.find( 'input[type="checkbox"]:checked' );
			religionCount = checkedBox.length;

			// Check if there is one or more checked boxes
			if ( religionCount ) {
				// Loop through all the religion checkboxes
				religionOpts.each( function() {
					var current = jQuery( this );

					if ( selReligionType == archaicism || selReligionType == idolism ) {
						// If archaicism or idolism type, MAX: four options
						if ( religionCount > 3 ) {
							// With four boxes checked, disable remaining
							if ( !current.is(':checked') ) {
								toggleCheckBox( current, false );
							}
						} else {
							enableReligionOptions( selReligionType );
						}
					}
				});
			} else {
				// Enable options depending on type selection
				enableReligionOptions( selReligionType );
			}
		});

		// Build default religion options depending on selection
		function enableReligionOptions( rtype ) {
			// Enable options depending on type selection
			if ( rtype != defaultText && religionRules[rtype] ) {

				// Check religion combinations that are available
				jQuery.each( religionOpts, function() {
					var current = jQuery( this );
					var optText = getCheckText( current );

					if ( religionRules[rtype].indexOf( optText ) <= -1 ) {
						toggleCheckBox( current, false );
					} else {
						toggleCheckBox( current, true );
					}
				});
			}
		}

		// --- END --- RELIGION LOGIC

		// Disable / enable select menu and options
		function toggleSelect( selector, condition ) {
			if ( condition ) {
				selector.prop( 'disabled', false );
				selector.find( 'option' ).each( function() {
					jQuery( this ).prop( 'disabled', false );
				});
			} else {
				selector.prop( 'disabled', true );
				selector.find( 'option' ).each( function( index ) {
					var current =  jQuery( this );
					current.prop( 'disabled', true );
					if ( current.text().trim() == defaultText ) {
						selector.val( current.val() );
					}
				});
			}
		}

		// Return the currently selected option
		function findSelected( selector ) {
			return selector.find( 'option:selected' ).text().trim();
		}

		// Disable / enable checkbox options
		function toggleCheckBox( selector, condition ) {
			if ( condition ) {
				selector.prop( 'disabled', false );
			} else {
				selector.prop({ 'disabled' : true, 'checked' : false });
			}
		}

		// Return text next to checkbox
		function getCheckText( selector ) {
			return selector[0].nextSibling.nodeValue.trim();
		}
	}
}

// Common array for exclude dragon classes
var dragonClasses = [ 'Physical', 'Magical', 'Healing' ];

// Common array for exclude magic classes
var magicClasses = [ 'Cleric', 'Druid', 'Sorcerer', 'Summoner', 'Wizard' ];

// Common array for excluding all races
var all = [ 'All' ];

// Common array for excluding non-half-breed
var nonHalf = [ 'Dragon', 'Ghost', 'Korcai' ];

// Excluded character rules / combinations
var characterRules = {
	'Dragon' : {
		'exRace'  : all,
		'exClass' : [ 'Alchemist', 'Barbarian', 'Bard', 'Cleric', 'Druid', 'Fighter', 'Monk', 'Paladin', 'Ranger', 'Rogue', 'Sorcerer', 'Summoner', 'Wizard' ]
	},
	'Dwarf' : {
		'exRace'  : [ 'Elemental', 'Fae', 'Lumeacia', 'Ue\'drahc' ],
		'exClass' : mergeArray( magicClasses, dragonClasses )
	},
	'Elemental' : {
		'exRace'  : [ 'Dwarf', 'Ue\'drahc' ],
		'exClass' : dragonClasses
	},
	'Fae' : {
		'exRace'  : [ 'Dwarf', 'Lumeacia', 'Ue\'drahc' ],
		'exClass' : dragonClasses
	},
	'Ghost' : {
		'exRace'  : all,
		'exClass' : dragonClasses
	},
	'Human' : {
		'exRace'  : [ 'Lumeacia' ],
		'exClass' : dragonClasses
	},
	'Kerasoka' : {
		'exRace'  : [ 'Ue\'drahc' ],
		'exClass' : mergeArray( magicClasses, dragonClasses )
	},
	'Korcai' : {
		'exRace'  : all,
		'exClass' : dragonClasses
	},
	'Lumeacia' : {
		'exRace'  : [ 'Dwarf', 'Fae', 'Human', 'Shapeshifter', 'Ue\'drahc' ],
		'exClass' : dragonClasses
	},
	'Shapeshifter' : {
		'exRace'  : [ 'Lumeacia', 'Ue\'drahc' ],
		'exClass' : dragonClasses
	},
	'Ue\'drahc' : {
		'exRace'  : [ 'Dwarf', 'Elemental', 'Fae', 'Kerasoka', 'Lumeacia', 'Shapeshifter' ],
		'exClass' : dragonClasses
	}
}

// Excluded religion rules / combinations
var religionRules = {
	'Archaicism' : [ 'Dainyil', 'Ixaziel', 'Ny\'tha', 'Pheriss', 'Ristgir' ],
	'Idolism'	 : [ 'Cecilia', 'Bhelest' ]
}

// //	Disable these fields by default
// var disabledFields = [ raceOpts, classType, classOpts, religionOpts ];
//
// for ( var i = 0; i < disabledFields.length; i++ ) {
// 	if ( disabledFields[i].is( 'select' ) ) {
// 		toggleSelect( disabledFields[i], false );
// 	}
// 	if ( disabledFields[i].is( 'input[type="checkbox"]' ) ) {
// 		toggleCheckBox( disabledFields[i], false );
// 	}
// }

// function updateProfileFields() {
// 	// TO DO
// 	// Character fields for required select menus don't stay selected properly if
// 	// something is submitted wrong
// 	// show / hide fields
//
// 	if ( jQuery( 'body' ).hasClass( 'section-ucp-register' ) ) {
// 		// This is a test
// 		jQuery( '#register' ).on( 'submit', function( e ) {
// 			// Writer = 10, Character = 9
// 			var selectedAccount = findSelected( accountType );
//
// 			// Check if the writer account is selected
// 			if ( selectedAccount == 'Writer' || selectedAccount == '10' ) {
//
// 				// Loop through all character fields and set as needed
// 				characterFields.each( function() {
// 					var current = jQuery( this );
// 					if ( current.is( 'select' ) ) {
// 						disableSelect( current );
// 						resetSelectOptions( current, defaultText );
// 					} else  {
// 						if ( current.is( 'input[type="checkbox"]' ) ) {
// 							disableCheckBox( current );
// 						}
// 						current.val( '' );
// 					}
// 				});
//
// 				// Change account type options again
// 				// Writer = 10, Character = 9
// 				updateAccountTypeOptions( accountType, 'Writer', '10', 'Character', '9' );
//
// 				// For each item in requiredFields object, update the value
// 				jQuery.each( requiredFields, function( key, value ) {
// 					var selector = jQuery( '#' + key );
// 					if ( selector.is( 'select' ) ) {
// 						enableSelect( selector );
// 						enableSelectOptions( selector );
// 						resetSelectOptions( selector, value.hidden );
// 					}
// 				});
// 			}
//
// 			// Remove this later
// 			//return false;
// 		});
//
// 		// --- END --- SUBMIT LOGIC
//
// 		// Update account type option text
// 		function updateAccountTypeOptions( selector, condition1, replace1, condition2, replace2 ) {
// 			selector.find( 'option' ).each( function() {
// 				var optionText = jQuery( this ).text().trim();
//
// 				if ( optionText == condition1 ) {
// 					jQuery( this ).text( function () {
// 						return jQuery( this ).text().replace( optionText, replace1 );
// 					});​​​​​
// 				} else if ( optionText == condition2 ) {
// 					jQuery( this ).text( function () {
// 						return jQuery( this ).text().replace( optionText, replace2 );
// 					});​​​​​
// 				}
// 			});
// 		}
// 	}
// }


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
