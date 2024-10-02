<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Attesa_Custom_Code' ) ) :

	class Attesa_Custom_Code {

		public function __construct() {

			add_action( 'attesa_header_code', array( $this, 'output_header_js' ), 9999 );
			add_action( 'attesa_footer_code', array( $this, 'output_footer_js' ), 9999 );

		}

		public function output_header_js( $output ) {
			
			// Ignore if Attesa option for header code is uncheck
			if ( !attesa_options('_custom_code_header_use', '')) {
				return;
			}
			// Ignore admin, feed, robots or trackbacks
			if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {
				return;
			}
			$customHeaderCode = attesa_options('_custom_code_header', false);
			if ( empty( $customHeaderCode ) ) {
				return;
			}
			if ( trim( $customHeaderCode ) == '' ) {
				return;
			}
			return wp_unslash( $customHeaderCode );

		}
		
		
		public function output_footer_js( $output ) {

			// Ignore if Attesa option for footer code is uncheck
			if ( !attesa_options('_custom_code_footer_use', '')) {
				return;
			}
			// Ignore admin, feed, robots or trackbacks
			if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {
				return;
			}
			$customFooterCode = attesa_options('_custom_code_footer', false);
			if ( empty( $customFooterCode ) ) {
				return;
			}
			if ( trim( $customFooterCode ) == '' ) {
				return;
			}
			return wp_unslash( $customFooterCode );

		}

	}

endif;

return new Attesa_Custom_Code();