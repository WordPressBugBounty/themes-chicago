/**
 * custom-scripts.js
 *
 * Custom scripts for Chicago
 */

jQuery(document).ready(function() {
	var jQueryheader_search = jQuery( '#search-toggle' );
	jQueryheader_search.on( 'click', function() {
		var jQuerythis_el_search = jQuery(this),
			jQueryform_search = jQuerythis_el_search.siblings( '#search-container' );
			
		if ( jQueryform_search.hasClass( 'displaynone' ) ) {
			jQueryform_search.removeClass( 'displaynone' ).addClass( 'displayblock' ).animate( { opacity : 1 }, 300 );
		} else {
			jQueryform_search.removeClass( 'displayblock' ).addClass( 'displaynone' ).animate( { opacity : 0 }, 300 );		
		}
	});
});
