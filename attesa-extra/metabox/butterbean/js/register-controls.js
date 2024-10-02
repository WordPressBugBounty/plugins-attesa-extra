( function() {
	butterbean.views.register_control( 'rgba-color', {

		ready : function() {

			var options = this.model.attributes.options;

			jQuery( this.$el ).find( '.butterbean-color-picker-alpha' ).wpColorPicker( options );
		}
	} );
}() );