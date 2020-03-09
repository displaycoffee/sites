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
				dd.className += ( checkForClasses( dd ) + 'has-multiple-fields' );
			}

			// Check if element has an nbsp space
			if ( dd.innerHTML.indexOf( '&nbsp;' ) !== -1 ) {
				dd.className += ( checkForClasses( dd ) + 'has-space' );
			}
		}
	}

	// Add radio button class to parent elements (labels)
	if ( fieldsetRadio && fieldsetRadio.length ) {
		for ( var i = 0; i < fieldsetRadio.length; i++ ) {
			var radio = fieldsetRadio[i];
			radio.parentNode.className += ( checkForClasses( radio.parentNode ) + 'has-radio-button' );
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
			parentRow.className += ( checkForClasses( parentRow ) + 'has-forum-image' );
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

// Add background image for responsive banners
function addImageBackground( selector, respondDimensions ) {
	var imageSelector = document.querySelectorAll( selector );

	if ( imageSelector && imageSelector.length ) {
		for ( var i = 0; i < imageSelector.length; i++ ) {
			var sImage = imageSelector[i];
			var sImageSrc = sImage.getAttribute( 'src' );
			var sImageClass = 'image-fit image-fit-default';
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
				sImageClass = sImageClass.replace( 'image-fit-default', 'image-fit-responsive' );
			}

			// Set background image attribute and class
			sImageParent.style.backgroundImage = 'url(' + sImageSrc + ')';
			sImageParent.className += ( checkForClasses( sImageParent ) + sImageClass );
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
				body.className += ( checkForClasses( body ) + 'no-pagination' );
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
				topic.className += ( checkForClasses( topic ) + 'ignore' );
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
				parentRow.className += ( checkForClasses( parentRow ) + 'member-thanks-list' );
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

// Check if there is a new PM (mostly for icon purposes)
function checkForNewPM() {
	var menuItem = document.querySelectorAll( '.cp-menu ul li a[href*="folder"]' );

	if ( menuItem && menuItem.length ) {
		for ( var i = 0; i < menuItem.length; i++ ) {
			var item = menuItem[i];

			if ( item.innerHTML.indexOf( 'strong' ) !== -1 ) {
				item.className += ( checkForClasses( item ) + 'new-pm' );
			}
		}
	}
}

// Check for empty content elements on the page
function checkForEmpty( selector ) {
	var emptySelector = document.querySelectorAll( selector );

	if ( emptySelector && emptySelector.length ) {
		for ( var i = 0; i < emptySelector.length; i++ ) {
			emptySelector[i].parentNode.style.display = 'none';
		}
	}
}

// Detect if on iPhone device
function detectiPhone() {
	if ( navigator.userAgent.match( /iPhone|iPad|iPod/i ) ) {
		body.className += ( checkForClasses( body ) + 'ios' );
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
				rank.parentNode.className += ( checkForClasses( rank.parentNode ) + 'name' );
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
				list.className += ( checkForClasses( list ) + 'no-content' );
			}
		}
	}
}

// Toggle elements on page
function toggleElements( button, selector, parentClass, prefix ) {
	var buttons = document.querySelectorAll( button );

	// Get local storage item if it's available
	if ( typeof( Storage ) !== 'undefined' && localStorage.getItem( 'khy-collapsed' ) ) {
		var collapsedElements = JSON.parse( localStorage.getItem( 'khy-collapsed' ) );
	} else {
		var collapsedElements = {};
	}

	if ( buttons && buttons.length ) {
		// Set main collapsed key to collapsedElements object if not already present
		var collapsedKey = prefix + parentClass;
		if ( !collapsedElements.hasOwnProperty( collapsedKey ) ) {
			collapsedElements[collapsedKey] = {};
		}

		for ( var i = 0; i < buttons.length; i++ ) {
			var button = buttons[i];
			var buttonKey = prefix + i;

			// If there is a key, set button value to itself, otherwise set to default true
			if ( collapsedElements[collapsedKey].hasOwnProperty( buttonKey ) ) {
				collapsedElements[collapsedKey][buttonKey] = collapsedElements[collapsedKey][buttonKey];
			} else {
				collapsedElements[collapsedKey][buttonKey] = true;
			}

			// Add toggle button to element
			var buttonIcon = document.createElement( 'button' );
			buttonIcon.className = 'content-toggle-button icon icon-lg';
			button.insertBefore( buttonIcon, button.firstChild );

			// Toggle intial state of collapsible elements
			toggleContent( collapsedElements[collapsedKey][buttonKey], buttonIcon );

			// Add collapsible toggle event to buttons
			buttonIcon.onclick = function( e ) {
				var buttonIndex = i;

				// Wrap everything in another function to save index related to current button
				return function( e ) {
					buttonKey = prefix + buttonIndex;

					// Reset button state in collapsedElements
					collapsedElements[collapsedKey][buttonKey] = collapsedElements[collapsedKey][buttonKey] ? false : true;

					// Send updated collapsed elements to storage
					setStorage( collapsedElements );

					// Then toggle things
					toggleContent( collapsedElements[collapsedKey][buttonKey], ( e.target || e.srcElement ) );
				}
			}();
		}

		// Add khy-collapsed to storage after loop has finished
		setStorage( collapsedElements );

		// Function to reset storage
		function setStorage( data ) {
			if ( typeof( Storage ) !== 'undefined' ) {
				return window.localStorage.setItem( 'khy-collapsed', JSON.stringify( data ) );
			} else {
				return null;
			}
		}

		// Functionality to add / remove classes on collapsible elements
		function toggleContent( buttonKey, buttonTarget ) {
			var buttonParent = findParent( buttonTarget, parentClass );
			var buttonChild = buttonParent.querySelector( selector );
			var buttonClasses = {
				'col'   : 'content-collapsed',
				'exp'   : 'content-expanded',
				'minus' : 'fa-minus',
				'plus'  : 'fa-plus'
			};

			if ( buttonKey ) {
				toggleButtonClasses( buttonTarget, buttonClasses.minus, buttonClasses.plus );
				toggleButtonClasses( buttonChild, buttonClasses.col, buttonClasses.exp );
			} else {
				toggleButtonClasses( buttonTarget, buttonClasses.plus, buttonClasses.minus );
				toggleButtonClasses( buttonChild, buttonClasses.exp, buttonClasses.col );
			}
		}

		// Toggle button classes
		function toggleButtonClasses( element, remove, add ) {
			element.classList.remove( remove );
			element.classList.add( add );
		}
	}
}
