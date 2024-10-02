<div class="attesa-mb-field onoff">
	<div class="attesa-extra-block-first">
		<# if ( data.label ) { #>
			<span class="butterbean-label">{{ data.label }}</span>
		<# } #>

		<# if ( data.description ) { #>
			<span class="butterbean-description">{{{ data.description }}}</span>
		<# } #>
	</div>
	<div class="attesa-extra-block-second">
		<label class="switch">
			<input type="checkbox" value="true" {{{ data.attr }}} <# if ( data.value ) { #> checked="checked" <# } #> />
			<span class="slider"></span>
		</label>
	</div>
</div>