function addFiltering() {
	var filters = document.querySelectorAll( '.card-filters .card-filter-menu .card-filter' );
	var filtersActive = 'card-filter-active';
	var toggleShow = 'toggle-show';
	var toggleHide = 'toggle-hide';

	if ( filters && filters.length && cardBlocks ) {
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
					removeFilters( parameter );
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
			cardBlocks.filter( function( block ) {
				if ( block.filters.indexOf( parameter ) !== -1 ) {
					block.applied += 1;
				}

				var blockSelector = document.querySelector( block.id );
				if ( blockSelector.classList.contains( toggleShow ) ) {
					// do nothing if class contains toggle-show already
					// the block should still stay visible
				} else {
					if ( block.filters.indexOf( parameter ) !== -1 ) {
						if ( blockSelector.classList.contains( toggleHide ) ) {
							blockSelector.classList.remove( toggleHide );
						}
						blockSelector.classList.add( toggleShow );
					} else {
						blockSelector.classList.add( toggleHide );
					}
				}
			});
		}

		// Add classes to card blocks when filters are present
		function removeFilters( parameter ) {
			cardBlocks.filter( function( block ) {
				if ( block.filters.indexOf( parameter ) !== -1 ) {
					block.applied -= 1;
				}

				var blockSelector = document.querySelector( block.id );
				if ( blockSelector.classList.contains( toggleHide ) ) {
					// do nothing if class contains toggle-hide already
					// the block should stay hidden
				} else {
					if ( block.filters.indexOf( parameter ) !== -1 && block.applied < 1 ) {
						if ( blockSelector.classList.contains( toggleShow ) ) {
							blockSelector.classList.remove( toggleShow );
						}
						blockSelector.classList.add( toggleHide );
					}
				}
			});
		}
	}
}
