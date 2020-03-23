// Khy'eras global configurables
var khy = {
	'attr'      : {
		'activeTab'    : 'activetab',
		'hidePanel'    : 'hide-panel',
		'showPanel'    : 'show-panel',
		'layouts'      : 'map-layouts-panel',
		'perimeters'   : 'map-perimeters-panel',
		'toggleId'     : 'data-toggle-id',
		'toggleMobile' : 'data-toggle-mobile',
		'toggleName'   : 'data-toggle-name',
		'toggleState'  : 'data-toggle-state',
		'toggleType'   : 'data-toggle-type'
	},
	'selectors' : {
		'body' : document.querySelector( 'body' )
	},
	'variables' : {
		'bottom'     : document.body.scrollHeight + window.innerHeight,
		'fontSize'   : 16
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
function isMobile( respond ) {
	var windowWidth = ( window.innerWidth / khy.variables.fontSize );
	var docWidth = ( document.documentElement.clientWidth / khy.variables.fontSize );
	var bodyWidth = ( document.body.clientWidth / khy.variables.fontSize );

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
