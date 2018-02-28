// Add class to body tag
function addBodyClass() {
	if ( body.getAttribute( 'data-class' ) ) {
		var bodyClass = body.getAttribute( 'data-class' ).replace( /[^a-zA-Z ]/g,'' ).trim().replace( / /g,'-' ).replace( /-+/g,'-' );
	}

	if ( bodyClass ) {
		body.className += ( checkForClasses( body ) + bodyClass );
	}
}

// If forum has image, add a class to parent
function addForumImageClass() {
	var forumImage = document.querySelectorAll( '.list-inner .forum-image' );

	if ( forumImage.length ) {
		for ( var i = 0; i < forumImage.length; i++ ) {
			var parentRow = forumImage[i].parentNode.parentNode.parentNode;

			parentRow.className += ( checkForClasses( parentRow ) + 'has-forum-image' );
		}
	}
}

// Add classes to fieldset dl dd depending on conditions
function addFieldsetClasses() {
	var fieldset = document.querySelectorAll( 'fieldset:not(.polls) dl:not(.pmlist) dd' );

	if ( fieldset.length ) {
		for ( var i = 0; i < fieldset.length; i++ ) {
			// Check if there are multiple children in the dd
			if (fieldset[i].children.length > 1) {
				fieldset[i].className += ( checkForClasses( fieldset[i] ) + 'has-multiple-fields' );
			}

			// Check if element has an nbsp space
			if ( fieldset[i].innerHTML.indexOf( '&nbsp;' ) !== -1 ) {
				fieldset[i].className += ( checkForClasses( fieldset[i] ) + 'has-space' );
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

	if ( listing.length ) {
		for ( var i = 0; i < listing.length; i++ ) {
			if ( noContentText.indexOf( listing[i].innerText ) !== -1 ) {
				listing[i].className += ( checkForClasses( listing[i] ) + 'no-content' );
			}
		}
	}
}


// Add class to topics on search results that are ignored
function addSearchIgnoredClass() {
	var topic = document.querySelectorAll( '.search.post .postbody' );

	if ( topic.length ) {
		for ( var i = 0; i < topic.length; i++ ) {
			if ( topic[i].innerHTML.indexOf( 'ignore list' ) !== -1 ) {
				topic[i].className += ( checkForClasses( topic[i] ) + 'ignore' );
			}
		}
	}
}

// Add an image wrapper around notification images
function addImageWrapper( selector ) {
	var image = document.querySelectorAll( selector );

	if ( image.length ) {
		for ( var i = 0; i < image.length; i++ ) {
			// Create the new image wrapper div
			var imageWrapper = document.createElement( 'div' );
			imageWrapper.setAttribute( 'class', 'image-wrap' );

			// Insert wrapper before the image
			image[i].parentNode.insertBefore( imageWrapper, image[i] );

			// Append image to the image wrapper
			imageWrapper.appendChild( image[i] );
		}
	}
}

// Check for empty content elements on the page
function checkForEmpty( selector ) {
	var element = document.querySelectorAll( selector );

	if ( element.length ) {
		for ( var i = 0; i < element.length; i++ ) {
			element[i].parentNode.style.display = 'none';
		}
	}
}
