function addFiltering() {
	var filters = document.querySelectorAll( '.card-filters .card-filter-menu .card-filter' );
	var blocks = document.querySelectorAll( '.card-block' );
	var filtersActive = 'card-filter-active';
	var toggleShow = 'toggle-show';
	var toggleHide = 'toggle-hide';

	if ( filters && filters.length && blocks && blocks.length ) {
		// Get list of all cards on page that can be filtered
		var cardBlocks = [];
		for ( var h = 0; h < blocks.length; h++ ) {
			var block = blocks[h];
			cardBlocks.push({
				'id'      : '#' + block.getAttribute( 'id' ),
				'filters' : block.getAttribute( 'data-filters' ),
				'applied' : 0
			});
		}

		// Check if there are already filter parameters applied to the url
		if ( window.location.search ) {
			var filterParameters = window.location.search.replace( '?', '' ).split( '&' );

			// If there are filters applied to the url, add active class
			for ( var i = 0; i < filterParameters.length; i++ ) {
				var parameterSplit = filterParameters[i].split( '=' );
				var parameterSelector = document.querySelector( '#card-filter-' + parameterSplit[0] + '-' + parameterSplit[1] );
				if ( parameterSelector ) {
					parameterSelector.classList.add( filtersActive );
					applyFilters( parameterSplit[0] + '=' + parameterSplit[1] );
				}
			}
		} else {
			var filterParameters = [];
		}

		// Loop through filter links
		for ( var j = 0; j < filters.length; j++ ) {
			var currentFilter = filters[j];

			// Filter click event
			currentFilter.onclick = function( e ) {
				var selector = e.target || e.srcElement;
				var field = selector.getAttribute( 'data-field' );
				var filter = selector.getAttribute( 'data-filter' );

				// Combine field and filter details into parameter
				var parameter = field + '=' + filter;

				// If the parameter is already there, remove it and active class
				if ( filterParameters.indexOf( parameter ) !== -1 ) {
					filterParameters.splice( filterParameters.indexOf( parameter ), 1 );
					selector.classList.remove( filtersActive );
				} else {
					// Otherwise add parameter and add active class
					filterParameters.push( parameter );
					selector.classList.add( filtersActive );
					applyFilters( parameter );
				}

				// Push history state to window
				window.history.pushState( {} , '', '?' + filterParameters.join( '&' ) );
			};
		}

		// Add classes to card blocks when filters are present
		function applyFilters( parameter ) {
			cardBlocks = cardBlocks.filter( function( block ) {
				if ( block.filters.indexOf( parameter ) !== -1 ) {
					block.applied += 1;
				}
				return block;
			});

			// var blocks = document.querySelectorAll( '.card-block' );
			//
			// if ( blocks && blocks.length ) {
			// 	for ( var k = 0; k < blocks.length; k++ ) {
			// 		var block = blocks[k];
			// 		var filterAttribute = block.getAttribute( 'data-filters' );
			// 		var filterCount = ( block.getAttribute( 'data-applied-filters' ) * 1);
			//
			// 		if ( block.classList.contains( toggleShow ) ) {
			// 			// do nothing if class contains toggle-show already
			// 			// the block should still stay visible
			// 		} else {
			// 			if ( filterAttribute.indexOf( parameter ) !== -1 ) {
			// 				if ( block.classList.contains( toggleHide ) ) {
			// 					block.classList.remove( toggleHide );
			// 				}
			// 				block.classList.add( toggleShow );
			// 				block.setAttribute( 'data-applied-filters', ( filterCount + 1 ) );
			// 			} else {
			// 				block.classList.add( toggleHide );
			// 			}
			// 		}
			// 	}
			// }
		}
	}
}
