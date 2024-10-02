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
		<ul class="butterbean-checkbox-list">

			<# _.each( data.choices, function( label, choice ) { #>

				<li>
					<label>
						<input type="checkbox" value="{{ choice }}" name="{{ data.field_name }}[]" <# if ( -1 !== _.indexOf( data.value, choice ) ) { #> checked="checked" <# } #> />
						{{ label }}
					</label>
				</li>

			<# } ) #>

		</ul>
	</div>
</div>