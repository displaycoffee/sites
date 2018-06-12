// Common variables
var body = document.querySelector( 'body' );
var baseFontSize = 16;

// If className has classes, add a space before adding new classes
function checkForClasses( selector ) {
	if ( selector.className ) {
		return ' ';
	} else {
		return '';
	}
}

// Check for mobile
function isMobile( baseFontSize, respond ) {
	var windowWidth = ( window.innerWidth / baseFontSize );
	var docWidth = ( document.documentElement.clientWidth / baseFontSize );
	var bodyWidth = ( document.body.clientWidth / baseFontSize );

	if ( ( windowWidth || docWidth || bodyWidth ) <= respond ) {
		return true;
	} else {
		return false;
	}
}

// Merge arrays and remove duplicates
function mergeArray( array1, array2 ) {
	var a = array1.concat( array2 );
	for ( var i = 0; i < a.length; ++i ) {
		for ( var j = i+1; j < a.length; ++j ) {
			if ( a[i] === a[j] ) {
				a.splice( j--, 1 );
			}
		}
	}
	return a;
}

// Replace HTML characters
function cleanHTML( selector ) {
	return selector.replace( /(<([^>]+)>)/ig, '' );
}
