<?php
/* Get the correct ID of the page */
function attesaextra_get_the_current_ID() {
	$theID = '';
	if ( is_singular() ) {
		$theID = get_the_ID();
	} elseif (function_exists( 'is_woocommerce' ) && is_shop()) {
		$theID = get_option('woocommerce_shop_page_id');
	} elseif (is_home() && !is_front_page()) {
		$theID = get_option('page_for_posts');
	}
	$theID = apply_filters( 'attesa_post_id', $theID );
	$theID = $theID ? $theID : '';
	return $theID;
}

/* Check if use general custom settings */
function attesaextra_check_use_custom_settings() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_general_use_custom_settings', true)) {
		return true;
	}
	return false;
}
/* Check if the page is 100% full width for page builders */
function attesaextra_check_for_fullwidth_builders() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_general_use_full_width_builders', true)) {
		return true;
	}
	return false;
}

/* Check if the page overlay the header */
function attesaextra_check_for_overlaytoheader() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_general_overlay_contenttoheader', true)) {
		return true;
	}
	return false;
}

/* Check if use header custom settings */
function attesaextra_check_use_header_settings() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_header_use_custom_settings', true)) {
		return true;
	}
	return false;
}

/* Check if use post custom settings */
function attesaextra_check_use_post_settings() {
	if (get_post_meta(get_the_ID(), '_post_use_custom_settings', true) && is_singular( 'post' )) {
		return true;
	}
	return false;
}

/* Check if use page custom settings */
function attesaextra_check_use_page_settings() {
	if (get_post_meta(get_the_ID(), '_page_use_custom_settings', true) && is_page()) {
		return true;
	}
	return false;
}
/* Check if use custom colors settings and edit general colors settings */
function attesaextra_edit_general_colors_settings() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_color_use_custom_settings', true) && get_post_meta(attesaextra_get_the_current_ID(), '_color_use_general_color', true)) {
		return true;
	}
	return false;
}
/* Check if use custom colors settings and edit topbar colors settings */
function attesaextra_edit_topbar_colors_settings() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_color_use_custom_settings', true) && get_post_meta(attesaextra_get_the_current_ID(), '_color_use_topnav_color', true)) {
		return true;
	}
	return false;
}
/* Check if use custom colors settings and edit header colors settings */
function attesaextra_edit_header_colors_settings() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_color_use_custom_settings', true) && get_post_meta(attesaextra_get_the_current_ID(), '_color_use_header_color', true)) {
		return true;
	}
	return false;
}
/* Check if use custom colors settings and edit classic sidebar colors settings */
function attesaextra_edit_classicsidebar_colors_settings() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_color_use_custom_settings', true) && get_post_meta(attesaextra_get_the_current_ID(), '_color_use_classic_sidebar_color', true)) {
		return true;
	}
	return false;
}
/* Check if use custom colors settings and edit push sidebar colors settings */
function attesaextra_edit_pushsidebar_colors_settings() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_color_use_custom_settings', true) && get_post_meta(attesaextra_get_the_current_ID(), '_color_use_push_sidebar_color', true)) {
		return true;
	}
	return false;
}
/* Check if use custom colors settings and edit footer colors settings */
function attesaextra_edit_footer_colors_settings() {
	if (get_post_meta(attesaextra_get_the_current_ID(), '_color_use_custom_settings', true) && get_post_meta(attesaextra_get_the_current_ID(), '_color_use_footer_color', true)) {
		return true;
	}
	return false;
}
/* Sanitize color and check if is hex or rgba */
function attesaextra_sanitize_hex_or_rgba($color) {
	if ( empty( $color ) ) {
		return '';
	}
	if (false === strpos($color, 'rgba')) {
		// Is hex color
		$color = sanitize_hex_color( $color );
	} else {
		// Is rgba color
		$color = str_replace( ' ', '', $color );
		sscanf( $color, 'rgba(%d,%d,%d,%f)', $red, $green, $blue, $alpha );
		$color = 'rgba(' . attesaextra_check_the_range( $red, 0, 255 ) . ',' . attesaextra_check_the_range( $green, 0, 255 ) . ',' . attesaextra_check_the_range( $blue, 0, 255 ) . ',' . attesaextra_check_the_range( $alpha, 0, 1 ) . ')';
	}
	return $color;
	
}
/* Helper to sanitize rgba color */
if ( ! function_exists( 'attesaextra_check_the_range' ) ) {
	function attesaextra_check_the_range( $input, $min, $max ){
		if ( $input < $min ) {
			$input = $min;
		}
		if ( $input > $max ) {
			$input = $max;
		}
		return $input;
	}
}