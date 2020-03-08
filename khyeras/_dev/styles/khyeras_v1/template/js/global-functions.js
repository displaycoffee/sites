// Common variables
var body = document.querySelector( 'body' );
var baseFontSize = 16;
var bottomDistance =  document.body.scrollHeight + window.innerHeight;

// If className has classes, add a space before adding new classes
function checkForClasses( selector ) {
	if ( selector.className ) {
		return ' ';
	} else {
		return '';
	}
}

// Replace HTML characters
function cleanHTML( selector ) {
	return selector.replace( /(<([^>]+)>)/ig, '' );
}

// Debounce function from underscore.js and https://davidwalsh.name/javascript-debounce-function
function debounce( func, wait, immediate ) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		var later = function() {
			timeout = null;
			if ( !immediate ) {
				func.apply( context, args );
			}
		};
		var callNow = immediate && !timeout;
		clearTimeout( timeout );
		timeout = setTimeout( later, wait );
		if ( callNow ) {
			func.apply( context, args );
		}
	};
};

// Find parent element
function findParent( selector, parentClass ) {
	while ( selector ) {
		if ( selector.classList && selector.classList.contains( parentClass ) ) {
			return selector;
		}
		selector = selector.parentNode;
	} return null;
};

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
