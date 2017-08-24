jQuery(function($){
	// Logo Icon (sitetitle)
	var logo = wp.customize('logo').get();
	if ( logo ) $('#customize-control-header_icon' ).hide();
	wp.customize( 'logo', function( value ) {
		value.bind( function( to ) {
			if ( to )
				$('#customize-control-header_icon' ).hide();
			else
				$('#customize-control-header_icon' ).show();
		} );
	} );

	// Site Size 
	var site_size = wp.customize('site_size').get();
	if ( site_size != 'custom' ) $('#customize-control-site_size_percent' ).hide();
	wp.customize( 'site_size', function( value ) {
		value.bind( function( to ) {
			if ( to == 'custom' )
				$('#customize-control-site_size_percent' ).show();
			else
				$('#customize-control-site_size_percent' ).hide();
		} );
	} );	
	
	/////////////////
	// document ready
	$(document).ready(function($){	
		/* FA Icon Picker */
		$( function() {
			$( '.icp' ).iconpicker().on( 'iconpickerUpdated', function() {
				$( this ).trigger( 'change' );
			} );
		} );
		
		// jQuery UI Range Slider
		$('.range-slider').slider({
			range: false,
			slide: function( event, ui ) {
				$(this).siblings('input.slide-val').val( ui.value );
				$(this).siblings('input.slide-val').change();
				$(this).children().text( ui.value + '%' );
			},
			create: function (event, ui) {
				$(this).slider( "option", "max", $(this).data('max') );
				$(this).slider( "option", "min", $(this).data('min') );
				$(this).slider( "option", "value", $(this).data('value') );
				$(this).children().text( $(this).data('value') + '%' );
			}
		});
		
	});		
	////////////////
});