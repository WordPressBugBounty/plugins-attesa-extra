<?php
if ( ! class_exists( 'AttesaExtra_Shortcodes' ) ) {
	class AttesaExtra_Shortcodes {
		public function __construct() {
			add_shortcode( 'attesa_date', array( $this, 'date_shortcode' ) );
			add_shortcode( 'attesa_copyright', array( $this, 'copyright_symbol_shortcode' ) );
			add_shortcode( 'attesa_registered_trademark', array( $this, 'registered_trademark_symbol_shortcode' ) );
			add_shortcode( 'attesa_qrcode', array( $this, 'registered_qrcode_shortcode' ) );
		}
		/**
		 * Register the [attesa_date] shortcode
		 *
		 * @since 1.1.8
		 */
		public function date_shortcode( $atts, $content = null ) {
			extract( shortcode_atts( array(
				'year' => '',
			), $atts ) );
			$date = '';
			if ( '' != $year ) {
				$date .= $year . ' - ';
			}
			$date .= date( 'Y' );
			return esc_html( $date );
		}
		
		/**
		 * Register the [attesa_copyright] shortcode
		 *
		 * @since 1.1.8
		 */
		public function copyright_symbol_shortcode( $atts, $content = null ) {
			return '©';
		}
		
		/**
		 * Register the [attesa_registered_trademark] shortcode
		 *
		 * @since 1.1.8
		 */
		public function registered_trademark_symbol_shortcode( $atts, $content = null ) {
			return '®';
		}
		
		/**
		 * Register the [attesa_qrcode] shortcode
		 *
		 * @since 1.1.8
		 */
		public function registered_qrcode_shortcode( $atts, $content = null ) {
			$atts = shortcode_atts(
				array(
					'url'       => '',
					'size'       => 200,
					'color'      => '#000000',
					'background' => '#ffffff',
					'format'	=> 'png',
					'position'	=> 'center',
				),
				$atts,
				'attesa_qrcode'
			);
			if ( ! $atts['url'] ) {
				return '<p>' . esc_html__('Please enter a valid URL to generate the QR code', 'attesa-extra') . '</p>';
			}
			$url = add_query_arg(
				array(
					'data'    => rawurlencode( $atts['url'] ),
					'size'    => sprintf( '%1$sx%1$s', intval( $atts['size'] ) ),
					'format'  => $atts['format'],
					'color'   => ltrim( $atts['color'], '#' ),
					'bgcolor' => ltrim( $atts['background'], '#' ),
				),
				'https://api.qrserver.com/v1/create-qr-code/'
			);
			return '<div class="attesa-extra-qrcode ' . esc_attr($atts['position']) . '"><img src="' . esc_url( $url ) . '" /></div>';
		}
	}
}
new AttesaExtra_Shortcodes();