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
