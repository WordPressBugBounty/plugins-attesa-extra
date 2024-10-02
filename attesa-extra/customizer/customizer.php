<?php
/* Additional settings for the customizer */
function attesaextra_manage_customizer() { 
	if (function_exists('attesa_options') ) {
		global $wp_customize;
		/* Create the "Custom JS Code" section */
		$wp_customize->add_section( 'section_attesa_theme_options_custom_code', array(
			 'title'    => esc_html__( 'Custom JS Code', 'attesa-extra' ),
			 'priority' => 12,
			 'panel'  => 'attesa_themeoptions',
		) );
		/* Heading custom js code */
		if( class_exists( 'Attesa_Customize_Heading' ) ) {
			$wp_customize->add_setting('attesa_theme_options[_heading_custom_code]', array(
				'sanitize_callback' => 'sanitize_text_field',
				'type'       => 'option',
			));
			$wp_customize->add_control(
				new Attesa_Customize_Heading(
				$wp_customize,
				'attesa_theme_options[_heading_custom_code]',
				array(
					'settings'		=> 'attesa_theme_options[_heading_custom_code]',
					'section'		=> 'section_attesa_theme_options_custom_code',
					'label'			=> __( 'Custom JS code', 'attesa-extra' ),
					'description'	=> __( 'Use this section to insert custom JavaScript code in your website.', 'attesa-extra' ),
					'priority' => 1,
				))
			);
		}
		/* Use header code */
		$wp_customize->add_setting('attesa_theme_options[_custom_code_header_use]', array(
			'default'    => '',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'attesa_sanitize_checkbox'
		) );
		$wp_customize->add_control('attesa_theme_options[_custom_code_header_use]', array(
			'label'      => __( 'Add javascript in header', 'attesa-extra' ),
			'section'    => 'section_attesa_theme_options_custom_code',
			'settings'   => 'attesa_theme_options[_custom_code_header_use]',
			'type'       => 'checkbox',
			'priority' => 1,
		) );
		/* Header Code */
		$wp_customize->add_setting('attesa_theme_options[_custom_code_header]', array(
			'default'    => '',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage',
			'sanitize_callback' => 'wp_unslash',
		) );
		$wp_customize->add_control('attesa_theme_options[_custom_code_header]', array(
			'label'      => __( 'Header Code', 'attesa-extra' ),
			'description' => __( 'These scripts will be printed in the <code>&lt;head&gt;</code> section. No need to add &lt;script&gt; tag.', 'attesa-extra' ),
			'section'    => 'section_attesa_theme_options_custom_code',
			'settings'   => 'attesa_theme_options[_custom_code_header]',
			'type'       => 'textarea',
			'active_callback' => 'attesaextra_is_headercode_active',
			'priority' => 2,
		) );
		/* Use footer code */
		$wp_customize->add_setting('attesa_theme_options[_custom_code_footer_use]', array(
			'default'    => '',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'attesa_sanitize_checkbox'
		) );
		$wp_customize->add_control('attesa_theme_options[_custom_code_footer_use]', array(
			'label'      => __( 'Add javascript in footer', 'attesa-extra' ),
			'section'    => 'section_attesa_theme_options_custom_code',
			'settings'   => 'attesa_theme_options[_custom_code_footer_use]',
			'type'       => 'checkbox',
			'priority' => 3,
		) );
		/* Footer Code */
		$wp_customize->add_setting('attesa_theme_options[_custom_code_footer]', array(
			'default'    => '',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
			'transport' => 'postMessage',
			'sanitize_callback' => 'wp_unslash',
		) );
		$wp_customize->add_control('attesa_theme_options[_custom_code_footer]', array(
			'label'      => __( 'Footer Code', 'attesa-extra' ),
			'description' => __( 'These scripts will be printed above the <code>&lt;/body&gt;</code> tag. No need to add &lt;script&gt; tag.', 'attesa-extra' ),
			'section'    => 'section_attesa_theme_options_custom_code',
			'settings'   => 'attesa_theme_options[_custom_code_footer]',
			'type'       => 'textarea',
			'active_callback' => 'attesaextra_is_footercode_active',
			'priority' => 4,
		) );
		/* Custom Footer with Attesa Templates */
		$wp_customize->add_setting('attesa_theme_options[_footer_choose]', array(
			'default'    => 'default',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'attesa_sanitize_select'
		) );
		$wp_customize->add_control('attesa_theme_options[_footer_choose]', array(
			'label'      => __( 'Choose the footer', 'attesa-extra' ),
			'section'    => 'section_attesa_theme_options_footer',
			'settings'   => 'attesa_theme_options[_footer_choose]',
			'type'       => 'select',
			'priority' => 1,
			'choices' => array(
				'default' => __( 'Default with widgets', 'attesa-extra'),
				'custom' => __( 'Custom via Attesa Templates', 'attesa-extra'),
			),
		) );
		/* Get all Attesa Templates */
		$wp_customize->add_setting('attesa_theme_options[_footer_get_attesa_template]', array(
			'default'    => '0',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'attesa_sanitize_select'
		) );
		$wp_customize->add_control('attesa_theme_options[_footer_get_attesa_template]', array(
			'label'      => __( 'Choose the template for the footer', 'attesa-extra' ),
			'section'    => 'section_attesa_theme_options_footer',
			'settings'   => 'attesa_theme_options[_footer_get_attesa_template]',
			'type'       => 'select',
			'active_callback' => 'attesaextra_is_customfooter_active',
			'priority' => 1,
			'choices' => attesaextra_get_attesa_templates(),
		) );
		/* Add new attesa templates for header format */
		$wp_customize->get_control( 'attesa_theme_options[_header_format]' )->choices = array(
			'compat' => __( 'Compat', 'attesa-extra'),
			'featuredtitle' => __( 'Featured Title', 'attesa-extra'),
			'menupopup' => __( 'Menu Popup', 'attesa-extra'),
			'custom' => __( 'Custom via Attesa Templates', 'attesa-extra'),
		);
		/* Get all Attesa Templates */
		$wp_customize->add_setting('attesa_theme_options[_header_get_attesa_template]', array(
			'default'    => '0',
			'type'       => 'option',
			'capability' => 'edit_theme_options',
			'sanitize_callback' => 'attesa_sanitize_select'
		) );
		$wp_customize->add_control('attesa_theme_options[_header_get_attesa_template]', array(
			'label'      => __( 'Choose the template for the header', 'attesa-extra' ),
			'section'    => 'section_attesa_theme_options_header',
			'settings'   => 'attesa_theme_options[_header_get_attesa_template]',
			'type'       => 'select',
			'active_callback' => 'attesaextra_is_customheader_active',
			'priority' => 1,
			'choices' => attesaextra_get_attesa_templates(),
		) );
	}
}
add_action( 'customize_register', 'attesaextra_manage_customizer', 11 );

function attesaextra_is_headercode_active() {
	$useHeaderCode = attesa_options('_custom_code_header_use', '');
	if ($useHeaderCode == 1) {
		return true;
	}
	return false;
}

function attesaextra_is_footercode_active() {
	$useFooterCode = attesa_options('_custom_code_footer_use', '');
	if ($useFooterCode == 1) {
		return true;
	}
	return false;
}

function attesaextra_is_customfooter_active() {
	$customFooter = attesa_options('_footer_choose', 'default');
	if ($customFooter == 'custom') {
		return true;
	}
	return false;
}

add_filter('attesa_is_customfooter_active_filter', 'attesaextra_is_customfooter_active_filter');
function attesaextra_is_customfooter_active_filter() {
	$customFooter = attesa_options('_footer_choose', 'default');
	if ($customFooter == 'custom') {
		return false;
	}
	return true;
}

function attesaextra_is_customheader_active() {
	$customHeader = attesa_options('_header_format', 'compat');
	if ($customHeader == 'custom') {
		return true;
	}
	return false;
}

add_filter('attesa_is_customheader_active_filter', 'attesaextra_is_customheader_active_filter');
function attesaextra_is_customheader_active_filter() {
	$customHeader = attesa_options('_header_format', 'compat');
	if ($customHeader == 'custom') {
		return false;
	}
	return true;
}