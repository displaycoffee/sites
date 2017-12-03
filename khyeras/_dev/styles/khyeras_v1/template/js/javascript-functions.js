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
	var body = document.getElementsByTagName( 'body' );
	if ( body[0].getAttribute( 'data-class' ) ) {
		var bodyClass = body[0].getAttribute( 'data-class' ).replace( /[^a-zA-Z ]/g,'' ).trim().replace( / /g,'-' ).replace( /-+/g,'-' );
	}

	if ( bodyClass ) {
		body[0].className += ( checkForClasses( body[0] ) + bodyClass );
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
	var fieldset = document.querySelectorAll( 'fieldset dl dd' );

	console.log(fieldset)

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
