<div class="attesa-mb-field rgba-color alpha-true">
	<div class="attesa-extra-block-first">
		<# if ( data.label ) { #>
			<span class="butterbean-label">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="butterbean-description">{{{ data.description }}}</span>
		<# } #>
	</div>
	<div class="attesa-extra-block-second">
		<label>
			<input class="widefat butterbean-color-picker-alpha" {{{ data.attr }}} value="<# if ( data.value ) { #>{{ data.value }}<# } #>" data-alpha="true" />
		</label>
	</div>
</div>
