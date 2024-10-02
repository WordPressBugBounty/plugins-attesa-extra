( function( $ ) {
	var WidgetAwpHeadingTypewriterHandler = function( $scope, $ ) {
		
		var $id = $scope.find( '.attesa-extra-heading-typewriter-wrap' ).data( 'id' ),
			$typespeed = $scope.find( '.attesa-extra-heading-typewriter-wrap' ).data( 'typespeed' ),
			$strings = $scope.find( '.attesa-extra-heading-typewriter-wrap' ).data( 'strings' ),
			$startdelay = $scope.find( '.attesa-extra-heading-typewriter-wrap' ).data( 'startdelay' ),
			$backspeed = $scope.find( '.attesa-extra-heading-typewriter-wrap' ).data( 'backspeed' ),
			$backdelay = $scope.find( '.attesa-extra-heading-typewriter-wrap' ).data( 'backdelay' ),
			$loop = $scope.find( '.attesa-extra-heading-typewriter-wrap' ).data( 'loop' );
		
		var typed = new Typed( '#extra-heading-id-'+ $id +' .attesa-extra-heading-typewriter', {
			strings 	: $strings,
			typeSpeed 	: $typespeed,
			startDelay 	: $startdelay,
			backSpeed 	: $backspeed,
			backDelay 	: $backdelay,
			loop 		: $loop,
			smartBackspace: false,
		} );
		
	};
	
	// Make sure we run this code under Elementor
	$( window ).on( 'elementor/frontend/init', function() {
		elementorFrontend.hooks.addAction( 'frontend/element_ready/attesa-heading-typewriter.default', WidgetAwpHeadingTypewriterHandler );
	} );
} )( jQuery );