( function( $ ) {
	var WidgetawpAlertMessageHandler = function( $scope, $ ) {
		$scope.find( '.awp-alert-close-button' ).click( function() {

	        $( this ).parents( 'div[class^="awp-alert"]' ).fadeOut( 500 );

	    } );
	};
	
	// Make sure we run this code under Elementor
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/attesa-extra-alert-message.default', WidgetawpAlertMessageHandler );
	} );
} )( jQuery );