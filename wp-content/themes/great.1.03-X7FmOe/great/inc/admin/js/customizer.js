/**
 * Theme Customizer enhancements for a better user experience.
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

jQuery(function($){
	// Site title and description.
	wp.customize( 'blogname', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).text( to );
		} );
	} );
	// Site Size
	wp.customize( 'site_size_percent', function( value ) {
		value.bind( function( to ) {
			$( '.site' ).css( {
					'max-width': to + '%',
			} );
			$( "#customize-control-site_size_percent span.n" ).text( to );
		});
	});
	// Header text color.
	wp.customize( 'header_textcolor', function( value ) {
		value.bind( function( to ) {
			$( '.site-title a' ).css( {
					'clip': 'auto',
					'color': to,
					'position': 'relative'
			} );
		} );
	} );
});