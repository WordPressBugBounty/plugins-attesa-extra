<div class="attesa-mb-field select">
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
			<select class="butterbean-select" {{{ data.attr }}}>

				<# _.each( data.choices, function( label, choice ) { #>

					<option value="{{ choice }}" <# if ( data.value === choice ) { #> selected="selected" <# } #>>{{ label }}</option>

				<# } ) #>

			</select>
		</label>
	</div>
</div>