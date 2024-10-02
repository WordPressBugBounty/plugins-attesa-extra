<div class="attesa-mb-field textarea">
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
			<textarea type="text" class="widefat" {{{ data.attr }}}>{{{ data.value }}}</textarea>
		</label>
	</div>
</div>