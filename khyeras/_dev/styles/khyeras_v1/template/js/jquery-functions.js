// Check for spaces inside elements
function checkForSpace( selector ) {
	var emptySelector = jQuery( selector );

	if ( emptySelector && emptySelector.length ) {
		emptySelector.each( function() {
			var current = jQuery( this );

			if ( current.html() == '&nbsp;' || current.html() == '<label>&nbsp;</label>' ) {
				current.addClass( 'empty-space' );
			} else {
				current.removeClass( 'empty-space' );
			}
		});
	}
}

// Add wrapper around area if height is bigger than a certain number
function addScrollableArea( selector, selectorHeight, selectorHide ) {
	if ( selector && selector.length || selectorHide && selectorHide.length ) {
		if ( selector[0].scrollHeight > selectorHeight ) {
			selector.addClass( 'scrollable' );
			selector.wrapInner( '<div class="scrollable-wrapper"></div>' );
		} else {
			selectorHide.hide();
		}
	}
}

// Add icon for image attachment expansion
function addAttachmentIcon() {
	var attachImage = jQuery( '.attach-image' );

	if ( attachImage && attachImage.length ) {
		attachImage.each( function() {
			jQuery( this ).prepend( '<span class="image-open" onclick="viewableArea(this);"><i class="icon icon-xl fa-search-plus fa-fw" aria-hidden="true"></i></span>' );
		});
	}
}

// Add additional click events to image attachment expansion
function updateaAttachmentDisplay( selector ) {
	var attachment = jQuery( selector );

	if ( attachment && attachment.length ) {
		attachment.on( 'click', function( e ) {
			var parentImageContainer = jQuery( this ).closest( '.file' ).parent();

			if ( parentImageContainer.hasClass( 'image-expanded' ) ) {
				parentImageContainer.removeClass( 'image-expanded' );
			} else {
				parentImageContainer.addClass( 'image-expanded' );
			}
		});
	}
}

// Function display-actions div because the markup is a mess
// This prevents editting a number of templates
function formatDisplayActions() {
	var displayActions = jQuery( '.display-actions' );

	if ( displayActions && displayActions.length ) {
		displayActions.each( function() {
			var current = jQuery( this );

			// Remove spaces
			current.html( current.html().replace( /&nbsp;/g, '' ).replace( /::/g, '&bull;' ) );

			// Find mark / unmark buttons
			var markButtons = current.find( ' div a' );

			if ( markButtons.text().toLowerCase().indexOf( 'mark' ) !== -1 ) {
				markButtons.parent( 'div' ).addClass( 'mark-actions' );
			}

			// Find select menus with a button and wrap a div around
			var selectMenu = current.children( 'select' );

			selectMenu.each( function() {
				jQuery( this ).next( '.button1, .button2' ).addBack().wrapAll( '<div class="select-actions"></div>' );
			});

			// Add a new inner wrapper
			// Keep at the bottom to do this last
			current.wrapInner( '<div class="display-actions-wrapper"></div>' );
		});
	}
}

// If postingbox in ucp is empty, hide it
function hidePMPostBox() {
	var pmPostBox = jQuery( '#pmheader-postingbox' );

	if ( pmPostBox && pmPostBox.length ) {
		if ( pmPostBox.find( 'fieldset.fields1' ).children().length == 0 ) {
			pmPostBox.hide();
		}
	}
}

// Add a wrapper to the control panel for better design control
function addCPWrapper() {
	var cpMenu = jQuery( '.cp-menu' );
	var cpMain = jQuery( '.cp-main' );

	if ( cpMenu && cpMenu.length || cpMain && cpMain.length ) {
		cpMenu.parent().addClass('cp-wrapper');
		cpMain.parent().addClass('cp-wrapper');
	}
}

// Toggle display of character versus writer on memberlist_view
function toggleMemberDisplay() {
	var profileTabs = jQuery( '.profile-tabs' );

	if ( profileTabs && profileTabs.length ) {
		// Get all tabs on profile
		var tabs = profileTabs.find( 'ul li a[data-tabname]' );

		// Add click event for tabs
		tabs.on( 'click', function() {
			var current = jQuery( this );

			// Find any active tab, remove activetab class, then add it to clicked element
			tabs.parent().removeClass( khy.attr.activeTab );
			current.parent().addClass( khy.attr.activeTab );

			// Get tab name
			var activeTab = current.attr( 'data-tabname' );

			// For each tab, show or hide depending on tab name match
			jQuery( '.tab-panel' ).each( function() {
				var current = jQuery( this );

				if ( current.hasClass( activeTab ) ) {
					current.addClass( khy.attr.showPanel ).removeClass( khy.attr.hidePanel );
				} else {
					current.addClass( khy.attr.hidePanel ).removeClass( khy.attr.showPanel );
				}
			});
		});
	}
}

// Toggle display of map elements
function toggleMapDisplay() {
	var mapTabs = jQuery( '.map-tabs' );
	var mapPerimeters = false;
	var mapLayouts = false;

	if ( mapTabs && mapTabs.length ) {
		// Get all tabs on map
		var tabs = mapTabs.find( 'ul li a[data-tabname]' );

		// Add click event for tabs
		tabs.on( 'click', function() {
			var current = jQuery( this );

			// Get tab name
			var activeTab = current.attr( 'data-tabname' );

			// Add and remove activetab class for changing tab color / size
			if ( current.parent().hasClass( khy.attr.activeTab ) ) {
				current.parent().removeClass( khy.attr.activeTab );
			} else {

				if ( activeTab == khy.attr.perimeters ) {
					jQuery( '.map-tabs .tab a[data-tabname="' + khy.attr.layouts + '"]' ).parent().removeClass( khy.attr.activeTab );
				} else if ( activeTab == khy.attr.layouts ) {
					jQuery( '.map-tabs .tab a[data-tabname="' + khy.attr.perimeters + '"]' ).parent().removeClass( khy.attr.activeTab );
				}

				current.parent().addClass( khy.attr.activeTab );
			}

			// Get map selector
			var mapPanel = jQuery( '.map .' + activeTab );

			// Show and hide map elements with class toggle
			if ( mapPanel.hasClass( khy.attr.hidePanel ) ) {
				if ( activeTab == khy.attr.perimeters ) {
					jQuery( '.map .' + khy.attr.layouts ).removeClass( khy.attr.showPanel ).addClass( khy.attr.hidePanel );
				} else if ( activeTab == khy.attr.layouts ) {
					jQuery( '.map .' + khy.attr.perimeters ).removeClass( khy.attr.showPanel ).addClass( khy.attr.hidePanel );
				}

				mapPanel.addClass( khy.attr.showPanel ).removeClass( khy.attr.hidePanel );
			} else {
				mapPanel.addClass( khy.attr.hidePanel ).removeClass( khy.attr.showPanel );
			}
		});
	}
}

// Add sticky class to navigation when scroll
function addOnScroll( selector, anchor, class ) {
	var windowSelector = jQuery( window );

	if ( windowSelector && windowSelector.length ) {
		// Variables for scroll logic
		var anchor = jQuery( anchor ).offset().top;
		var scrollCheck = false;

		windowSelector.scroll( function() {
			if (scrollCheck == false) {
				if ( windowSelector.scrollTop() > anchor ) {
					jQuery( selector ).addClass( class );
					scrollCheck = true;
				}
			} else {
				if ( windowSelector.scrollTop() <= anchor ) {
					jQuery( selector ).removeClass( class );
					scrollCheck = false;
				}
			}
		});
	}
}

// Scroll to top functionality
// Modified from https://paulund.co.uk/how-to-create-an-animated-scroll-to-top-with-jquery
function scrollOnPage( selector, distance, position ) {
	var scrollSelector = jQuery( selector );

	if ( scrollSelector && scrollSelector.length ) {
		// Check to see if the window is top if not then display button
		addOnScroll( '.scroll-to-links', '.site-description', 'scroll-to-visible' );

		// Click event to scroll to top
		scrollSelector.on( 'click', function() {
			jQuery( 'html, body' ).animate({
				scrollTop : position
			}, 1000 );
			return false;
		});
	}
}

// Build discord list display
function initializeDiscordList() {
	var discordList = jQuery( '.discord-channel-status .discord-channel-list' );
	var noUsersHtml = '<li>There\'s no one online right now. :( Check back later.</li>';

	var discordWidget = jQuery.ajax({
		type: 'GET',
		url: '//discordapp.com/api/guilds/482924002411806732/widget.json',
		dataType: 'json'
	});

	discordWidget.done( function( data ) {
		// List of members, admins, and moderators
		var members = data['members'] || false;
		var admins = [ 'memoria' ];
		var moderators = [ 'algaliarept' ];

		if ( members && members.length > 0 ) {
			// Assign rank and group to members using filter
			members = members.filter( function( value ) {
				// Default rank and group
				value['rank'] = 3;
				value['group'] = 'user';

				// Check other users
				var username = value['username'].toLowerCase();
				if ( moderators.indexOf( username ) > -1 ) {
					value['rank'] = 2;
					value['group'] = 'moderator';
				} else if ( admins.indexOf( username ) > -1 ) {
					value['rank'] = 1;
					value['group'] = 'admin';
				}
				return value;
			});

			// Sort member data by rank
			members.sort( function( a, b ) {
				return a.rank - b.rank;
			});

			// Variables for looping through members
			var totalMembers = members.length;
			var membersLimit = 12;
			var membersLength = ( totalMembers > membersLimit ) ? membersLimit : totalMembers;

			for ( var i = 0; i < membersLength; i++ ) {
				// Current member data
				var current = members[i];

				// Set image url
				var imageUrl = '//khyeras.org/styles/khyeras_v1/theme/images/no_avatar.gif'
				if ( current['avatar_url'] ) {
					imageUrl = current['avatar_url'].replace(/^http(s?):/i, '');
				}

				// Create member HTML
				var memberAlt = 'Discord Avatar - ' + current['username'];
				var memberImage = '<span class="discord-avatar image-wrap"><img src="' + imageUrl + '" class="user-avatar" alt="' + memberAlt + '" title="' + memberAlt + '" /></span>';
				var memberName = '<span class="discord-username">' + current['username'] + '</span>'
				var memberHTML = '<li class="discord-' + current['group'] + ' discord-status-' + current['status'] + '">' + memberImage + memberName + '</li>';

				// Append HTML to discord list
				discordList.append( memberHTML );
			}

			// If there are more than the user limit, add invite link
			if ( totalMembers > membersLimit ) {
				discordList.append( '<li class="discord-more-users"><a href="//discord.gg/MXtzbmw" target="_blank">...more users online</a></li>' );
			}
		} else {
			discordList.append( noUsersHtml );
		}
	});

	discordWidget.fail( function() {
		discordList.append( noUsersHtml );
	});
}

// Create dropdown toggle for main nav menu
// This works differently from phpbb dropdown for desktop / mobile purposes
function initializeDropdownMenu( menuTrigger, menuLinks ) {
	var visible = 'dropdown-visible';
	var notVisible = 'dropdown-not-visible';

	var menuTrigger = jQuery( menuTrigger );
	var menuLinksSelector = jQuery( menuLinks );

	menuTrigger.off().on( 'click', function() {
		var parentContainer = jQuery( this ).closest( menuLinks );

		// Toggle casses on li containers
		if ( parentContainer.hasClass( visible ) ) {
			menuLinksSelector.removeClass( notVisible );
			parentContainer.removeClass( visible );
		} else {
			menuLinksSelector.removeClass( visible ).addClass( notVisible );
			parentContainer.removeClass( notVisible ).addClass( visible );
		}
	});

	// If anything outside the menu trigger is clicked on, hide menus
	if ( menuTrigger && menuTrigger.length ) {
		jQuery( document ).off().on( 'click', function( event ) {
			if ( !jQuery( event.target ).closest( menuLinks ).length ) {
				menuLinksSelector.removeClass( visible ).removeClass( notVisible );
			}
		});
	}
}

// Initialize Mobile Menu
function initializeMobileMenu( options ) {
	// Variables from mobile object
	var menu = jQuery( options.menu );
	var menuContainer = jQuery( options.menuContainer );
	var mobileButton = jQuery( options.mobileButton );
	var mobileMenu = jQuery( options.mobileMenu );
	var mobileContent = jQuery( options.mobileContent );
	var mobileOverlay = jQuery( options.mobileOverlay );
	var width = options.width;

	// Set a mobile false state (for window resize mainly)
	var mobileOnce = false;

	// Create open / close function
	function toggleMobileMenu() {
		if ( mobileMenu.hasClass( 'show' ) ) {
			mobileMenu.removeClass( 'show' );
			jQuery( 'body, html' ).removeClass( 'mobile-open' );
		} else {
			mobileMenu.addClass( 'show' );
			jQuery( 'body, html' ).addClass( 'mobile-open' );
		}
	}

	// Add/remove classes when mobile menu button or overlay is clicked on
	mobileButton.off().on( 'click', function() {
		toggleMobileMenu();
	});
	mobileOverlay.off().on( 'click', function() {
		toggleMobileMenu();
	});

	// Resize actions for mobile menu
	function mobileResizeAction() {
		// Check if we are on mobile
		var onMobile = isMobile( width / khy.variables.fontSize );

		// Check all sorts of window and document widths to make sure resizing is consistent across browsers
		if ( onMobile ) {
			// Check if mobile ones is false, meaning we haven't activated the mobile menu yet
			if ( !mobileOnce ) {
				// Close menu when button is clicked on
				jQuery( '.mobile-menu-header .fa-close' ).off().on( 'click', function() {
					toggleMobileMenu();
				});

				// Move menu to menu container
				menu.detach().appendTo( mobileContent );

				// After everything has been done, set mobile to true so it's not run again on resize
				mobileOnce = true;
			}
		} else {
			// Check if mobile is true, meaning we're resizing and want to clean up on resize
			if ( mobileOnce ) {
				// Remove close button, replace menu, remove slide menu toggle, and remove any extra slide-open class
				menu.detach().appendTo( menuContainer );
				jQuery( 'body, html' ).removeClass( 'mobile-open' );
				mobileMenu.removeClass( 'show' );

				// Then set mobile to false again so we can start over
				mobileOnce = false;
			}
		}
	}

	// Call mobile menu once if browser is brought up or refreshed
	mobileResizeAction();

	// Then run mobile menu on resizing using debounce
	var resizeMenuForMobile = debounce( function() {
		mobileResizeAction();
	}, 100 );
	window.addEventListener( 'resize', resizeMenuForMobile );
}
