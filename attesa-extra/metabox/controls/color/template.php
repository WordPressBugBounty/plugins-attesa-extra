<div class="attesa-mb-field color">
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
			<input class=" butterbean-color-picker" {{{ data.attr }}} value="<# if ( data.value ) { #>#{{ data.value }}<# } #>" />
		</label>
	</div>
</div>