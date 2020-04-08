function addFiltering() {
	var filters = document.querySelectorAll( '.card-filters .card-filter-menu .card-filter' );
	var filtersActive = 'card-filter-active';

	if ( filters && filters.length ) {
		// Check if there are already filter parameters applied to the url
		if ( window.location.search ) {
			var filterParameters = window.location.search.replace( '?', '' ).split( '&' );

			// If there are filters applied to the url, add active class
			for ( var i = 0; i < filterParameters.length; i++ ) {
				var parameterSplit = filterParameters[i].split( '=' );
				var parameterSelector = document.querySelector( '#card-filter-' + parameterSplit[0] + '-' + parameterSplit[1] );
				if ( parameterSelector ) {
					parameterSelector.classList.add( filtersActive );
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
				}

				// Push history state to window
				window.history.pushState( {} , '', '?' + filterParameters.join( '&' ) );
			};
		}
	}
}
