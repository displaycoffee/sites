// Common variables
var body = document.querySelector( 'body' );

// If className has classes, add a space before adding new classes
function checkForClasses( selector ) {
	if ( selector.className ) {
		return ' ';
	} else {
		return '';
	}
}

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
function addFieldsetClasses( selector ) {
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
