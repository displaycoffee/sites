// Add classes to fieldset dl dd depending on conditions
function addFieldsetClasses() {
	var ddSelector = 'fieldset:not(.polls) dl:not(.pmlist) dd';
	var fieldsetDd = document.querySelectorAll( ddSelector );
	var fieldsetRadio = document.querySelectorAll( ddSelector + ' input[type="radio"]' );

	if ( fieldsetDd && fieldsetDd.length ) {
		for ( var i = 0; i < fieldsetDd.length; i++ ) {
			var dd = fieldsetDd[i];

			// Check if there are multiple children in the dd
			if ( dd.children.length > 1 ) {
				dd.classList.add( 'has-multiple-fields' );
			}

			// Check if element has an nbsp space
			if ( dd.innerHTML.indexOf( '&nbsp;' ) !== -1 ) {
				dd.classList.add( 'has-space' );
			}
		}
	}

	// Add radio button class to parent elements (labels)
	if ( fieldsetRadio && fieldsetRadio.length ) {
		for ( var i = 0; i < fieldsetRadio.length; i++ ) {
			var radio = fieldsetRadio[i];

			radio.parentNode.classList.add( 'has-radio-button' );
		}
	}
}

// If forum has image, add responsive image and a class to parent
function addForumImageClass() {
	var forumImage = document.querySelectorAll( '.list-inner .forum-image' );

	if ( forumImage && forumImage.length ) {
		for ( var i = 0; i < forumImage.length; i++ ) {
			var fImage = forumImage[i];

			// Add class to parent row
			var parentRow = findParent( fImage, 'row-item' );
			parentRow.classList.add( 'has-forum-image' );
		}
	}
}

// Add background image for responsive banners
function addImageBackground( selector, respondDimensions ) {
	var imageSelector = document.querySelectorAll( selector );

	if ( imageSelector && imageSelector.length ) {
		for ( var i = 0; i < imageSelector.length; i++ ) {
			var sImage = imageSelector[i];
			var sImageSrc = sImage.getAttribute( 'src' );
			var sImageClass = 'image-fit-default';
			var sImageParent = sImage.parentNode;

			// Check if there are dimensions to change with background image
			if (respondDimensions) {
				var sImageDimensions = sImageSrc.match( /(\d+x\d+)/g );
				var sImageExt = sImageSrc.match( /.(jpg|jpeg|gif|png)/g );

				// Add image dimensions and check extension for background image
				if ( sImageDimensions ) {
					sImageSrc = sImageSrc.replace( sImageDimensions, respondDimensions );
				} else if ( sImageExt ) {
					sImageSrc = sImageSrc.replace( sImageExt, '-' + respondDimensions + sImageExt );
				}

				// Update image class
				sImageClass = 'image-fit-responsive';
			}

			// Set background image attribute and class
			sImageParent.style.backgroundImage = 'url(' + sImageSrc + ')';
			sImageParent.classList.add( 'image-fit' );
			sImageParent.classList.add( sImageClass );
		}
	}
}

// Add an image wrapper around notification images
function addImageWrapper( selector ) {
	var imageSelector = document.querySelectorAll( selector );

	if ( imageSelector && imageSelector.length ) {
		for ( var i = 0; i < imageSelector.length; i++ ) {
			var sImage = imageSelector[i];

			// Create the new image wrapper div
			var imageWrapper = document.createElement( 'div' );
			imageWrapper.setAttribute( 'class', 'image-wrap' );

			// Insert wrapper before the image
			sImage.parentNode.insertBefore( imageWrapper, sImage );

			// Append image to the image wrapper
			imageWrapper.appendChild( sImage );
		}
	}
}

// Add no-pagination class to body to hide pagination
function addNoPaginationClass() {
	var pagination = document.querySelector( '.action-bar .pagination' );

	if ( pagination ) {
		var paginationText = pagination.innerText.toLowerCase();
		var paginationPhrase = 'page 1 of 1';

		if ( paginationText.indexOf( paginationPhrase ) !== -1 ) {
			var regex = new RegExp( paginationPhrase, 'gi' );
			var totalNumber = paginationText.replace( regex, '' ).match( /\d+/g );

			if ( totalNumber && totalNumber <= 0 ) {
				khy.selectors.body.classList.add( 'no-pagination' );
			}
		}
	}
}

// Add Quick Links to pages
function addQuickLinks() {
	var links = document.querySelectorAll( '[data-quick-name]' );

	if ( links && links.length ) {
		var panel = document.querySelector( '.page-body > .wrapper > .panel' );
		var tabs = document.querySelector( '.page-body > .wrapper .tabs' );

		// Create the quick links element
		var quickLinks = document.createElement( 'p' );
		quickLinks.setAttribute( 'class', 'quick-links' );
		var quickLinksHeading = document.createElement( 'strong' );
		quickLinksHeading.textContent = 'Quick Links:';
		quickLinks.appendChild( quickLinksHeading );

		// If there are tabs, inset before tabs instead of before panel
		if ( tabs ) {
			tabs.parentNode.insertBefore( quickLinks, tabs );
		} else {
			panel.parentNode.insertBefore( quickLinks, panel );
		}

		for ( var i = 0; i < links.length; i++ ) {
			var link = links[i];

			// Create individual linkElement element
			var linkElement = document.createElement( 'a' );
			linkElement.setAttribute( 'href', '#' + link.getAttribute( 'id' ) );
			linkElement.textContent = link.getAttribute( 'data-quick-name' );
			quickLinks.appendChild( linkElement );

			// Append separator but not if last
			if ( i != ( links.length - 1 ) ) {
				var linkSeparator = document.createElement( 'span' );
				linkSeparator.setAttribute( 'class', 'quick-links-separator' );
				linkSeparator.textContent = '|';
				quickLinks.appendChild( linkSeparator );
			}
		}
	}
}

// Add class to topics on search results that are ignored
function addSearchIgnoredClass() {
	var postBody = document.querySelectorAll( '.search.post .postbody' );

	if ( postBody && postBody.length ) {
		for ( var i = 0; i < postBody.length; i++ ) {
			var topic = postBody[i];

			if ( topic.innerHTML.indexOf( 'ignore list' ) !== -1 ) {
				topic.classList.add( 'ignore' );
			}
		}
	}
}

// On user profile, check for thanks list content
function addThanksClass() {
	var extraDetailsTitle = document.querySelectorAll( '#viewprofile .extra-details h3' );

	if ( extraDetailsTitle && extraDetailsTitle.length ) {
		for ( var i = 0; i < extraDetailsTitle.length; i++ ) {
			var title = extraDetailsTitle[i];

			if ( title.innerHTML.indexOf( 'Thanks list' ) !== -1 ) {
				// Add class to parent row
				var parentRow = findParent( title, 'panel' );
				parentRow.classList.add( 'member-thanks-list' );
			}
		}
	}
}

// Generate banner code
function bannerCodeGenerator( bannerImages, bannerCode ) {
	var codeBlock = document.querySelector( bannerCode );

	if ( codeBlock ) {
		// Re-usable variables
		var codeHTML = codeBlock.innerHTML;
		var currentImage = codeHTML.match(/src=\"(.*?)\"/)[1];
		var currentAlt = codeHTML.match(/alt=\"(.*?)\"/)[1];

		// Loop through all banner images and attach onclick event
		var bannerArray = document.querySelectorAll( bannerImages );
		for ( var i = 0; i < bannerArray.length; i++ ) {
			bannerArray[i].onclick = function( e ) {
				changeBannerCode( e, currentImage, currentAlt );
			};
		}

		// Function to change banner code
		function changeBannerCode( e, image, alt ) {
			// Element that has been clicked
			var selector = e.target || e.srcElement;

			// Create new image src attribute
			var newSrc =  '//' + window.location.hostname + '/' + selector.getAttribute( 'src' ).replace( './', '' );

			// Replace current image src and alt with new element alt and src
			codeBlock.innerHTML = codeHTML.replace( image, newSrc ).replace( alt, selector.getAttribute( 'alt' ) );
		}
	}
}

// Check for empty content elements on the page
function checkForEmpty( selector, parent ) {
	var emptySelector = document.querySelectorAll( selector );

	if ( emptySelector && emptySelector.length ) {
		for ( var i = 0; i < emptySelector.length; i++ ) {
			var empty = emptySelector[i];
			var emptyHTML = empty.innerHTML.replace(/\s+|\n|\r/g, '').length;
			if ( emptyHTML <= 0 ) {
				if ( parent ) {
					empty.parentNode.style.display = 'none';
				} else {
					empty.style.display = 'none';
				}
			}
		}
	}
}

// Check if there is a new PM (mostly for icon purposes)
function checkForNewPM() {
	var menuItem = document.querySelectorAll( '.cp-menu ul li a[href*="folder"]' );

	if ( menuItem && menuItem.length ) {
		for ( var i = 0; i < menuItem.length; i++ ) {
			var item = menuItem[i];

			if ( item.innerHTML.indexOf( 'strong' ) !== -1 ) {
				item.classList.add( 'new-pm' );
			}
		}
	}
}

// Detect if on iPhone device
function detectiPhone() {
	if ( navigator.userAgent.match( /iPhone|iPad|iPod/i ) ) {
		khy.selectors.body.classList.add( 'ios' );
	}
}

// Format rank and username display on member lists
function moveRankText() {
	var rankImgs = document.querySelectorAll( 'table.table1 .rank-img' );

	if ( rankImgs && rankImgs.length ) {
		for ( var i = 0; i < rankImgs.length; i++ ) {
			var rank = rankImgs[i];

			rank.parentNode.appendChild(rank);

			// Also add "name" class to td elements
			if (rank.parentNode.nodeName == 'TD' || rank.parentNode.nodeName == 'td') {
				rank.parentNode.classList.add( 'name' );
			}
		}
	}
}

// Add a class to elements where there are no topics / forums
function noContentListing() {
	var noContentText = [
		'This board has no forums.',
		'You do not have the required permissions to view or read topics within this forum.',
		'There are no topics or posts in this forum.',
		'This category has no forums.',
		'No suitable matches were found.'
	];

	var listing = document.querySelectorAll( '.action-bar + .panel' );

	if ( listing && listing.length ) {
		for ( var i = 0; i < listing.length; i++ ) {
			var list = listing[i];

			if ( noContentText.indexOf( list.innerText.trim() ) !== -1 ) {
				list.classList.add( 'no-content' );
			}
		}
	}
}

// Toggle elements on page
function toggleElements( button, content, parentClass, save ) {
	var toggleButtons = document.querySelectorAll( button );
	var toggleCookie = 'khy-toggles';

	// Get local storage item if it's available
	if ( typeof( Storage ) !== 'undefined' && localStorage.getItem( toggleCookie ) && save ) {
		var toggleObject = JSON.parse( localStorage.getItem( toggleCookie ) );
	} else {
		var toggleObject = {};
	}

	if ( toggleButtons && toggleButtons.length ) {
		// Set main toggleKey to toggleObject if not already present
		var toggleKey = toggleButtons[0].getAttribute( khy.attr.toggleType );
		if ( !toggleObject.hasOwnProperty( toggleKey ) ) {
			toggleObject[toggleKey] = {};
		}

		for ( var i = 0; i < toggleButtons.length; i++ ) {
			var button = toggleButtons[i];

			// If button id is equal to 9999, we need to set a random id using index
			var buttonId = button.getAttribute( khy.attr.toggleId );
			if ( buttonId == '9999' ) {
				buttonId = ( i + 1 ) * 2;
				button.setAttribute( khy.attr.toggleId, buttonId );
			}

			var buttonKey = getButtonKey( button.getAttribute( khy.attr.toggleName ), buttonId );

			// If there is a key, set button value to itself, otherwise set to default true
			if ( toggleObject[toggleKey].hasOwnProperty( buttonKey ) ) {
				toggleObject[toggleKey][buttonKey] = toggleObject[toggleKey][buttonKey];
			} else {
				var buttonDataState = ( button.getAttribute( khy.attr.toggleState ) ) == 'true' ? true : false;
				toggleObject[toggleKey][buttonKey] = buttonDataState;
			}

			// Add class to parent
			button.parentNode.classList.add( 'has-toggle-button' );

			// Toggle intial state of collapsible elements
			toggleContent( toggleObject[toggleKey][buttonKey], button, button.getAttribute( khy.attr.toggleMobile ) );

			// Add collapsible toggle event to buttons
			button.onclick = function() {
				return function( e ) {
					// Reset button key text
					buttonKey = getButtonKey( this.getAttribute( khy.attr.toggleName ), this.getAttribute( khy.attr.toggleId ) );

					// Reset button state in toggleObject
					toggleObject[toggleKey][buttonKey] = toggleObject[toggleKey][buttonKey] ? false : true;

					// Send updated toggleObject to storage
					setStorage( toggleObject );

					// Then toggle things
					toggleContent( toggleObject[toggleKey][buttonKey], this, this.getAttribute( khy.attr.toggleMobile ) );
				}
			}();
		}

		// Add toggleCookie to storage after loop has finished
		setStorage( toggleObject );

		// Generate button keys for object keys
		function getButtonKey( string, id ) {
			string = string + ' - ' + id;
			return string.toLowerCase().replace( /\'/, '' ).replace( /[^a-z0-9]+/g, '-' ).replace( /-+/, '-' );
		}

		// Functionality to add / remove classes on collapsible elements
		function toggleContent( buttonKey, buttonTarget, mobile ) {
			var buttonMobile = ( mobile == 'true' ) ? '-mobile' : '';
			var buttonChild = findParent( buttonTarget, parentClass ).querySelector( content );
			var buttonClasses = {
				'con-col' : 'toggle-content-collapsed' + buttonMobile,
				'con-exp' : 'toggle-content-expanded' + buttonMobile,
				'btn-col' : 'toggle-button-collapsed',
				'btn-exp' : 'toggle-button-expanded'
			};

			if ( buttonKey ) {
				toggleClasses( buttonTarget, buttonClasses['btn-col'], buttonClasses['btn-exp'] );
				toggleClasses( buttonChild, buttonClasses['con-col'], buttonClasses['con-exp'] );
			} else {
				toggleClasses( buttonTarget, buttonClasses['btn-exp'], buttonClasses['btn-col'] );
				toggleClasses( buttonChild, buttonClasses['con-exp'], buttonClasses['con-col'] );
			}
		}

		// Toggle button classes
		function toggleClasses( selector, remove, add ) {
			selector.classList.remove( remove ); selector.classList.add( add );
		}

		// Function to reset storage
		function setStorage( data ) {
			return ( typeof( Storage ) !== 'undefined' && save ) ? window.localStorage.setItem( toggleCookie, JSON.stringify( data ) ) : null;
		}
	}
}
