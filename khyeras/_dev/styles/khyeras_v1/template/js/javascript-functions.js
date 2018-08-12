// Add class to body tag
function addBodyClass() {
	if ( body.getAttribute( 'data-class' ) ) {
		var bodyClass = body.getAttribute( 'data-class' ).replace( /[^a-zA-Z ]/g,'' ).trim().replace( / /g,'-' ).replace( /-+/g,'-' );
	}

	if ( bodyClass ) {
		body.className += ( checkForClasses( body ) + bodyClass );
	}
}

// If forum has image, add responsive image and a class to parent
function addForumImageClass() {
	var forumImage = document.querySelectorAll( '.list-inner .forum-image' );

	if ( forumImage && forumImage.length ) {
		for ( var i = 0; i < forumImage.length; i++ ) {
			var fImage = forumImage[i];

			// Add class to parent row
			var parentRow = fImage.parentNode.parentNode.parentNode;
			parentRow.className += ( checkForClasses( parentRow ) + 'has-forum-image' );
		}
	}
}

// Add classes to fieldset dl dd depending on conditions
function addFieldsetClasses() {
	var fieldsetDd = document.querySelectorAll( 'fieldset:not(.polls) dl:not(.pmlist) dd' );

	if ( fieldsetDd && fieldsetDd.length ) {
		for ( var i = 0; i < fieldsetDd.length; i++ ) {
			var dd = fieldsetDd[i];

			// Check if there are multiple children in the dd
			if (dd.children.length > 1) {
				dd.className += ( checkForClasses( dd ) + 'has-multiple-fields' );
			}

			// Check if element has an nbsp space
			if ( dd.innerHTML.indexOf( '&nbsp;' ) !== -1 ) {
				dd.className += ( checkForClasses( dd ) + 'has-space' );
			}
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

// On user profile, check for thanks list content
function addThanksClass() {
	var extraDetailsTitle = document.querySelectorAll( '#viewprofile .extra-details h3' );

	if ( extraDetailsTitle && extraDetailsTitle.length ) {
		for ( var i = 0; i < extraDetailsTitle.length; i++ ) {
			var title = extraDetailsTitle[i];

			if ( title.innerHTML.indexOf( 'Thanks list' ) !== -1 ) {
				// Add class to parent row
				var parentRow = title.parentNode.parentNode;
				parentRow.className += ( checkForClasses( parentRow ) + 'member-thanks-list' );
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

	var listing = document.querySelectorAll( '.action-bar + .panel .inner' );

	if ( listing && listing.length ) {
		for ( var i = 0; i < listing.length; i++ ) {
			var list = listing[i];

			if ( noContentText.indexOf( list.innerText ) !== -1 ) {
				list.className += ( checkForClasses( list ) + 'no-content' );
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

// Remove any HTML characters that get add when saving drafts from post area
function removeHTMLFromDraft() {
	// General postform selector
	var postForm = ' #postform #message';

	// Clean HTML when loading from UCP > Manage Drafts
	var draftArea = document.querySelectorAll( '.section-ucp-manage-drafts' + postForm );

	if ( draftArea && draftArea.length ) {
		var draftValue = cleanHTML( draftArea[0].value );
		draftArea[0].value = draftValue;
	}

	// Clean HTML when loading from Posting > Load Draft
	var posting = document.querySelectorAll( '.section-posting' );

	if ( posting && posting.length && window.location.href.indexOf( '&d=' ) !== -1 ) {
		var postArea = document.querySelectorAll( '.section-posting' + postForm );
		var postValue = cleanHTML( postArea[0].value );
		postArea[0].value = postValue;
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

// Check image dimensions and add classes to constrain images in a square space
function checkImageDimensions( selector ) {
	var imageSelector = document.querySelectorAll( selector );

	if ( imageSelector && imageSelector.length ) {
		for ( var i = 0; i < imageSelector.length; i++ ) {
			var sImage = imageSelector[i];

			if ( sImage.naturalWidth > sImage.naturalHeight ) {
				sImage.className += ( checkForClasses( sImage ) + 'image-wide' );
			} else if ( sImage.naturalHeight > sImage.naturalWidth ) {
				sImage.className += ( checkForClasses( sImage ) + 'image-tall' );
			}
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
			var sImageDimensions = sImageSrc.match( /(\d+x\d+)/g );
			var sImageExt = sImageSrc.match( /.(jpg|jpeg|gif|png)/g );

			// Create responsive background image src
			var responsiveImage = sImageSrc;
			if ( sImageDimensions ) {
				responsiveImage = sImageSrc.replace( sImageDimensions, respondDimensions );
			} else if ( sImageExt ) {
				responsiveImage = sImageSrc.replace( sImageExt, '-' + respondDimensions + sImageExt );
			}

			// Set background image attribute
			sImage.parentNode.setAttribute( 'style', 'background-image: url(' + responsiveImage + ');' );
		}
	}
}
