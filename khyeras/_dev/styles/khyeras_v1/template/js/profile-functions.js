function updateProfileFields() {
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

	// Disable these fields by default
	var disabledFields = [ raceOpts, classType, classOpts, religionOpts ];

	for ( var i = 0; i < disabledFields.length; i++ ) {
		if ( disabledFields[i].is( 'select' ) ) {
			toggleSelect( disabledFields[i], false );
		}
		if ( disabledFields[i].is( 'input[type="checkbox"]' ) ) {
			toggleCheckBox( disabledFields[i], false );
		}
	}

	// Keep a count of selected checkboxes
	var raceCount = 0;
	var classCount = 0;
	var religionCount = 0;

	// --- START --- RACE LOGIC

	// Check for changes on race type dropdwon
	raceType.on( 'change', function() {
		var selRaceType = findSelected( raceType );

		// Reset options on change
		toggleCheckBox( raceOpts, false );
		toggleSelect( classType, false );
		toggleCheckBox( classOpts, false );

		// Enable options depending on type selection
		enableRaceOptions( selRaceType );
	});

	// Check for changes on race checkboxes
	raceOpts.on( 'change', function() {
		var selRaceType = findSelected( raceType );
		var selRaceOpt;

		// Update count of checkboxes
		var checkedBox = raceParent.find( 'input[type="checkbox"]:checked' );
		raceCount = checkedBox.length;

		// Check if there is one or more checked boxes
		if ( raceCount ) {
			// Get text following checkbox
			var selRaceOpt = getCheckText( checkedBox );

			// Build excluded race list from selected race and non-half arrays
			var raceArray = mergeArray( characterRules[selRaceOpt]['exRace'], nonHalf );

			// Loop through all the race checkboxes
			raceOpts.each( function() {
				var current = jQuery( this );

				if ( selRaceType == fb ) {
					// If full blooded race type, MAX: one option
					// With one box checked, disable remaining
					if ( !current.is(':checked') ) {
						toggleCheckBox( current, false );
					}
				} else if ( selRaceType == hb ) {
					// If half-breed race type, MAX: two options
					if ( raceCount == 1 ) {
						// With one box checked, exclude remaining in array list
						if ( raceArray && raceArray.indexOf( getCheckText( current ) ) <= -1 )	{
							toggleCheckBox( current, true );
						} else {
							toggleCheckBox( current, false );
						}
					} else if ( raceCount == 2 ) {
						// With two boxes checked, disable remaining
						if ( !current.is(':checked') ) {
							toggleCheckBox( current, false );
						}
					}
				}

				// Enable class type dropdown depending on race type and race checkbox count
				if ( ( selRaceType == fb && raceCount == 1 ) || ( selRaceType == hb && raceCount == 2 ) ) {
					toggleSelect( classType, true );
				} else {
					toggleSelect( classType, false );
					toggleCheckBox( classOpts, false );
				}
			});
		} else {
			// If no boxes are checked, disable class type dropdown and checkboxes
			toggleSelect( classType, false );
			toggleCheckBox( classOpts, false );

			// Enable options depending on type selection
			enableRaceOptions( selRaceType );
		}
	});

	// --- END --- RACE LOGIC

	// --- START --- CLASS LOGIC

	// Check for changes on class type dropdwon
	classType.on( 'change', function() {
		var selRaceType = findSelected( raceType );
		var selClassType = findSelected( classType );

		// Reset options on change
		toggleCheckBox( classOpts, false );

		// Enable options depending on type selections
		enableClassOptions( selRaceType, selClassType );
	});

	// Check for changes on class checkboxes
	classOpts.on( 'change', function() {
		var selRaceType = findSelected( raceType );
		var selClassType = findSelected( classType );

		// Update count of checkboxes
		var checkedBox = classParent.find( 'input[type="checkbox"]:checked' );
		classCount = checkedBox.length;

		// Check if there is one or more checked boxes
		if ( classCount ) {
			// Loop through all the class checkboxes
			classOpts.each( function() {
				var current = jQuery( this );

				if ( selClassType == single ) {
					// If single class type, MAX: one option
					// With one box checked, disable remaining
					if ( !current.is(':checked') ) {
						toggleCheckBox( current, false );
					}
				} else if ( selClassType == dual ) {
					// If dual class type, MAX: two options
					if ( classCount == 1 ) {
						// With one box checked, enable options depending on type selectio
						enableClassOptions( selRaceType, selClassType );
					} else if ( classCount == 2 ) {
						// With two boxes checked, disable remaining
						if ( !current.is(':checked') ) {
							toggleCheckBox( current, false );
						}
					}
				}
			});
		} else {
			// Enable options depending on type selection
			enableClassOptions( selRaceType, selClassType );
		}
	});

	// --- END --- CLASS LOGIC

	// --- START --- RELIGION LOGIC

	// Check for changes on religion type dropdwon
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

	// --- END --- RELIGION LOGIC

	// Build default race options depending on selection
	function enableRaceOptions( rtype ) {
		if ( rtype == fb ) {
			// If full blooded race type, enable all options
			toggleCheckBox( raceOpts, true );
		} else if ( rtype == hb ) {
			// If half-breed race type, enable those that can be half-breeds
			jQuery.each( raceOpts, function() {
				var current = jQuery( this );
				var optText = getCheckText( current );

				if ( nonHalf.indexOf( optText ) <= -1 ) {
					toggleCheckBox( current, true );
				}
			});
		}
	}

	// Build default class options depending on race selection
	function enableClassOptions( rtype, ctype ) {
		// Build excluded class list from selected races
		var classArray = [];
		raceOpts.each( function() {
			var current = jQuery( this );
			var optText = getCheckText( current );

			if ( current.is(':checked') ) {
				var classList = characterRules[optText]['exClass'];

				// Define allowed classes based on race type and checked boxes
				if ( classList ) {
					if ( rtype == fb ) {
						classArray = classList;
					} else if ( rtype == hb ) {
						// Some half-breed classes can use magic
						if ( optText == 'Dwarf' ) {
							classArray = dragonClasses;
						} else {
							classArray = mergeArray( classArray, classList );
						}
					}
				}
			}
		});

		// Enable options depending on type selection
		if ( ctype != defaultText ) {
			jQuery.each( classOpts, function() {
				var current = jQuery( this );
				var optText = getCheckText( current );

				if ( classArray.indexOf( optText ) <= -1 ) {
					toggleCheckBox( current, true );
				}
			});
		}
	}

	// Build default religion options depending on selection
	function enableReligionOptions( rtype ) {
		// Enable options depending on type selection
		if ( rtype != defaultText && religionRules[rtype] ) {

			// Check religion combinations that are available
			jQuery.each( religionOpts, function() {
				var current = jQuery( this );
				var optText = getCheckText( current );

				if ( religionRules[rtype].indexOf( optText ) > -1 ) {
					toggleCheckBox( current, false );
				} else {
					toggleCheckBox( current, true );
				}
			});
		}
	}

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
