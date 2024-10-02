<div class="attesa-mb-field checkbox">
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
			<input type="checkbox" value="true" {{{ data.attr }}} <# if ( data.value ) { #> checked="checked" <# } #> />
		</label>
	</div>
</div>