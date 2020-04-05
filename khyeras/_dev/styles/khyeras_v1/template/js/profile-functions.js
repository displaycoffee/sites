function updateProfileFields() {
	if ( jQuery( 'body' ).hasClass( 'section-ucp-register' ) || jQuery( 'body' ).hasClass( 'section-ucp-edit-profile' ) ) {
		// Determine what page we are on
		if ( jQuery( 'body' ).hasClass( 'section-ucp-register' ) ) {
			var pageType = 'register';
		} else {
			var pageType = 'ucp';
		}

		// Reusable language variables
		var defaultText = '-- Please Select --';
		var fb          = 'Full blooded';
		var hb          = 'Half-breed';
		var single      = 'Single';
		var dual        = 'Dual';
		var archaicism  = 'Archaicism';
		var idolism     = 'Idolism';
		var hide        = 'hide-fields';

		// Reusable selectors for fields
		var accountType     = jQuery( '#pf_account_type' );
		var characterFields = jQuery( '[id^=pf_c_]' );
		var raceType        = jQuery( '#pf_c_race_type' );
		var raceOpts        = jQuery( 'input[name="pf_c_race_opts[]"]' );
		var raceParent      = jQuery( '#pf_c_race_opts_1' ).closest( 'dd' );
		var classType       = jQuery( '#pf_c_class_type' );
		var classOpts       = jQuery( 'input[name="pf_c_class_opts[]"]' );
		var classParent     = jQuery( '#pf_c_class_opts_1' ).closest( 'dd' );
		var religionType    = jQuery( '#pf_c_religion_type' );
		var religionOpts    = jQuery( 'input[name="pf_c_religion_opts[]"]' );
		var religionParent  = jQuery( '#pf_c_religion_opts_1' ).closest( 'dd' );

		// Set variables without values
		var current, checkedBox, optText, selAccount;
		var raceCount, selRaceType, selRaceOpt;
		var classCount, selClassType, selClassOpt;
		var religionCount, selReligionType, selReligionOpt;

		// Is accType defined?
		if ( typeof accType == 'undefined' ) {
			accType = false;
		}

		// List of writer fields that should be hidden if "Writer Name" field is filled out for characters
		var hiddenWriterFields = [ 'pf_contact_discord', 'pf_phpbb_facebook', 'pf_phpbb_twitter', 'pf_phpbb_skype', 'pf_phpbb_youtube', 'pf_phpbb_website', 'pf_gender', 'pf_phpbb_location', 'pf_phpbb_interests', 'pf_phpbb_occupation', 'pf_writing_prefs', 'pf_character_list', 'pf_plotters_trackers' ];

		// --- START --- ACCOUNT LOGIC

		// If selected account is default or writer, disable and reset fields
		selAccount = findSelected( accountType );
		if ( accType == 'Writer' || selAccount == 'Writer' || selAccount == defaultText ) {
			updateCharacterFields();
			toggleFieldClass( true );
		} else {
			toggleFieldClass( false );

			// Hide writer fields when "Writer Name" is filled out
			if ( pageType == 'ucp' ) {
				var writerName = jQuery( '#pf_c_writer_name' ).val();

				if ( writerName && writerName.length ) {
					jQuery( hiddenWriterFields ).each( function( i ) {
						var currentField = jQuery( '#' + hiddenWriterFields[i] );
						if ( currentField && currentField.length ) {
							currentField.parents( 'dl' ).addClass( hide );
						}
					});
				}
			}
		}

		// Check for changes on account type dropdown
		accountType.on( 'change', function() {
			updateCharacterFields();
			toggleFieldClass( true );

			// Enable options depending on account selection
			selAccount = findSelected( accountType );
			if ( selAccount == 'Character' ) {
				toggleFieldClass( false );
				toggleSelect( raceType, true );
				toggleSelect( religionType, true );
				jQuery( 'input[id^=pf_c_][type="text"], input[id^=pf_c_][type="number"], textarea[id^=pf_c_]' ).prop( 'disabled', false );
			}
		});

		// Update character fields depending on selections
		function updateCharacterFields() {
			characterFields.each( function() {
				current = jQuery( this );

				// Different actions for register versus ucp edit profile
				if ( pageType == 'ucp' ) {
					accountType.prop( 'disabled', true );
					current.prop( 'disabled', true );
				} else {
					if ( current.is( 'select' ) ) {
						toggleSelect( current, false );
					} else if ( current.is( 'input[type="checkbox"]' ) ) {
						toggleCheckBox( current, false );
					} else {
						current.val( '' ).prop( 'disabled', true );
					}
				}
			});
		}

		// Add or remove classes to hide fields
		function toggleFieldClass( condition ) {
			var fieldsToHide = jQuery( '.error-msg-chracter, .character-fields' );
			if ( condition ) {
				fieldsToHide.addClass( hide );
			} else {
				fieldsToHide.removeClass( hide );
			}
		}

		// --- END --- ACCOUNT LOGIC

		// --- START --- RACE LOGIC

		// Check for changes on race type dropdown
		raceType.on( 'change', function() {
			selRaceType = findSelected( raceType );

			// Reset options on change
			toggleCheckBox( raceOpts, false );
			disableAllClass();

			// Enable options depending on type selection
			if ( selRaceType == fb ) {
				toggleCheckBox( raceOpts, true );
			} else if ( selRaceType == hb ) {
				jQuery.each( raceOpts, function() {
					current = jQuery( this );
					compareCheckedValues( nonHalf, getCheckText( current ), current );
				});
			}
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
			raceCount = getCheckedCount( '#pf_c_race_opts_1' );

			// Check if Full blooded or Half-breed is selected
			if ( selRaceType == fb || selRaceType == hb ) {
				raceOpts.each( function() {
					current = jQuery( this );

					// If Half-breed and one box is selected, update remaining
					if ( selRaceType == hb && raceCount == 1 ) {
						selRaceOpt = getCheckText( checkedBox );

						// Create exclude array and enable / disable boxes
						var raceArray = mergeArray( characterRules[selRaceOpt]['exRace'], nonHalf );
						if ( raceArray ) {
							compareCheckedValues( raceArray, getCheckText( current ), current );
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
						if ( selRaceType == fb ) {
							toggleCheckBox( current, true );
						} else if ( selRaceType == hb ) {
							compareCheckedValues( nonHalf, getCheckText( current ), current );
						}
						disableAllClass();
					}
				});
			} else {
				// When default is selected, disable all options
				toggleCheckBox( raceOpts, false );
				toggleSelect( classType, false );
			}

			// If on ucp profile and writer account, disable all fields to ensure no changes are made
			if ( accType == 'Writer' && pageType == 'ucp' ) {
				classType.prop( 'disabled', true );
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
			if ( selClassType != defaultText ) {
				var classArray = createClassArray( selRaceType );
				jQuery.each( classOpts, function() {
					current = jQuery( this );
					compareCheckedValues( classArray, getCheckText( current ), current );
				});
			}
		});

		// Check for changes on class checkboxes
		updateClassOptions();
		classOpts.on( 'change', function() {
			updateClassOptions();
		});

		// Build excluded class list from selected races
		var kerasokaSelector = kerasokaSelector || false;
		function createClassArray( rtype ) {
			var classArray = [];
			raceOpts.each( function() {
				current = jQuery( this );
				optText = getCheckText( current );

				// Record is kerasoka seletor for checks later
				if ( optText == 'Kerasoka' ) {
					kerasokaSelector = current;
				}

				if ( current.is(':checked') ) {
					var classList = characterRules[optText]['exClass'];

					// Define allowed classes based on race type and checked boxes
					if ( classList ) {
						// Half-breed dwarves can be magic users (as long as they are not Kerasoka)
						if ( rtype == hb && optText == 'Dwarf' && !kerasokaSelector.is(':checked') ) {
							classArray = dragonClasses;
						} else {
							classArray = mergeArray( classArray, classList );
						}
					}
				}
			});
			return classArray;
		}

		// Update class options depending on various selections
		function updateClassOptions() {
			selRaceType = findSelected( raceType );
			selClassType = findSelected( classType );
			var classArray = createClassArray( selRaceType );

			// Update count of checkboxes
			checkedBox = classParent.find( 'input[type="checkbox"]:checked' );
			classCount = getCheckedCount( '#pf_c_class_opts_1' );

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
						if ( selClassType != defaultText ) {
							compareCheckedValues( classArray, getCheckText( current ), current );
						}
					}
				});
			} else {
				// When default is selected, disable all options
				toggleCheckBox( classOpts, false );
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
			selReligionType = findSelected( religionType );

			// Reset options on change
			toggleCheckBox( religionOpts, false );

			// Enable options depending on type selection
			if ( selReligionType != defaultText && religionRules[selReligionType] ) {
				jQuery.each( religionOpts, function() {
					current = jQuery( this );
					compareCheckedValues( religionRules[selReligionType], getCheckText( current ), current, 'include' );
				});
			} else {
				toggleCheckBox( religionOpts, false );
			}
		});

		// Check for changes on religion checkboxes
		updateReligionOptions();
		religionOpts.on( 'change', function() {
			updateReligionOptions();
		});

		// Update religion options depending on various selections
		function updateReligionOptions() {
			selReligionType = findSelected( religionType );

			// Update count of checkboxes
			checkedBox = religionParent.find( 'input[type="checkbox"]:checked' );
			religionCount = getCheckedCount( '#pf_c_religion_opts_1' );

			// Check if Archaicism or Idolism is selected
			if ( selReligionType == archaicism || selReligionType == idolism ) {
				religionOpts.each( function() {
					current = jQuery( this );

					// If max count is met, disable remaining checkboxes
					// Archaicism or Idolism - MAX: 2
					if ( religionCount > 3 ) {
						if ( !current.is(':checked') ) {
							toggleCheckBox( current, false );
						}
					} else {
						// If no above conditions are met, reset to default options
						if ( selReligionType != defaultText && religionRules[selReligionType] ) {
							compareCheckedValues( religionRules[selReligionType], getCheckText( current ), current, 'include' );
						} else {
							toggleCheckBox( current, false );
						}
					}
				});
			} else {
				// When default is selected, disable all options
				toggleCheckBox( religionOpts, false );
			}
		}

		// --- END --- RELIGION LOGIC

		// --- START --- ON SUBMIT LOGIC

		jQuery( '.page-body' ).on( 'submit', '#register, #ucp.edit-profile-form', function( e ) {
			selAccount = findSelected( accountType );

			// Check if the writer account is selected
			if ( selAccount == 'Writer' ) {
				// Clear out extra field information
				updateCharacterFields();

				// Set required fields for character registration to go through
				setRequiredSelect( raceType, fb );
				setRequiredCheckboxes( raceOpts, 'Human' );
				setRequiredSelect( classType, single );
				setRequiredCheckboxes( classOpts, 'Bard' );

				// If on ucp profile, set account type field on submit
				if ( pageType == 'ucp' ) {
					setRequiredSelect( accountType, 'Writer' );
				}
			}
		});

		// Set required select menus
		function setRequiredSelect( selector, value ) {
			var selOpt;
			selector.find( 'option' ).each( function() {
				current = jQuery( this );
				current.prop( 'disabled', false );
				if ( current.text().trim() == value ) {
					selOpt = current.val();
				}
			});
			selector.prop( 'disabled', false ).val( selOpt );
		}

		// Set required checkboxes
		function setRequiredCheckboxes( selector, value ) {
			selector.each( function() {
				current = jQuery( this );
				optText = getCheckText( current );
				toggleCheckBox( current, false );
				if ( optText == value ) {
					current.prop({ 'disabled' : false, 'checked' : true });
				}
			});
		}

		// --- END --- ON SUBMIT LOGIC

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

		// Update checked checkboxes depending on condition
		function compareCheckedValues( array, value, selector, type ) {
			// By default, "exclude" checked values
			var toggle1 = false;
			var toggle2 = true;

			// Or, if the type is "include", reverse booleans
			if ( type == 'include' ) {
				toggle1 = true;
				toggle2 = false;
			}

			if ( array.indexOf( value ) > -1 ) {
				toggleCheckBox( selector, toggle1 );
			} else {
				toggleCheckBox( selector, toggle2 );
			}
		}

		// Return text next to checkbox
		function getCheckText( selector ) {
			return selector[0].nextSibling.nodeValue.trim();
		}

		// Return count of checkboxes
		function getCheckedCount( selector ) {
			return jQuery( selector ).closest( 'dd' ).find( 'input[type="checkbox"]:checked' ).length;
		}
	}
}

// Common array for exclude dragon classes
var dragonClasses = [ 'Physical', 'Magical', 'Restoration' ];

// Common array for exclude magic classes
var magicClasses = [ 'Cleric', 'Druid', 'Sorcerer', 'Summoner', 'Wizard' ];

// Common array for excluding all races
var all = [ 'All' ];

// Common array for excluding non-Half-breed
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
	'Idolism'	 : [ 'Ahm\'kela', 'Cecilia', 'Bhelest', 'Esyrax', 'Faryv', 'Faunir', 'Iodrah', 'Kaxitaki', 'Kelorha', 'Lahiel', 'Misanyt', 'Nilbein', 'Veditova' ]
}
