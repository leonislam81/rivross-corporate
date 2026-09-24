( function () {
	'use strict';

	var search = document.querySelector( '#events-search-input' );
	if ( search && window.location.hash === '#events-search' ) {
		search.focus();
	}
}() );
