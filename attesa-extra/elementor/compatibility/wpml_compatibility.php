<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class awpWPML {

	/**
	 * @since 1.1.7
	 * @var Object
	 */
	public static $instance = null;

	/**
	 * Returns the class instance
	 * 
	 * @since 1.1.7
	 *
	 * @return Object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Constructor for the class
	 *
	 * @since 1.1.7
	 *
	 * @return void
	 */
	public function __construct() {
		if ( defined( 'WPML_ST_VERSION' ) ) {
			if ( class_exists( 'WPML_Elementor_Module_With_Items' ) ) {
				$this->load_wpml_modules();
			}
			add_filter( 'wpml_elementor_widgets_to_translate', array( $this, 'add_elementor_translatable_nodes' ) );

		}
	}
	
	/**
     * load_wpml_modules
     *
     * Integrations class for complex widgets.
     *
     * @since 1.1.7
	 * @access public
	 */
	public function load_wpml_modules() {
		require_once AE_PATH . '/elementor/compatibility/widgets/heading-typewriter.php';
	}

	/**
	 * Adds additional translatable nodes to WPML
	 *
	 * @since 1.1.7
	 *
	 * @param  array   $widgets WPML nodes to translate
	 * @return array   $widgets Updated nodes
	 */
	public function add_elementor_translatable_nodes( $widgets ) {

		$widgets[ 'attesa-extra-alert-message' ] = array(
			'conditions' => array( 'widgetType' => 'attesa-extra-alert-message' ),
			'fields'     => array(
				array(
					'field'       => 'alert_title',
					'type'        => __( 'Alert Title', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
				array(
					'field'       => 'alert_content',
					'type'        => __( 'Alert Content', 'attesa-extra' ),
					'editor_type' => 'AREA'
				),
			),
		);
		
		$widgets[ 'attesa-heading-typewriter' ] = array(
			'conditions' => array( 'widgetType' => 'attesa-heading-typewriter' ),
			'fields'     => array(
				array(
					'field'       => 'before_text',
					'type'        => __( 'Heading typewriter before text', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
				array(
					'field'       => 'after_text',
					'type'        => __( 'Heading typewriter after text', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
			),
			'integration-class' => array( 'Attesa_WPML_Heading_Typewriter', )
		);
		
		$widgets[ 'attesa-extra-navigation-menu' ] = array(
			'conditions' => array( 'widgetType' => 'attesa-extra-navigation-menu' ),
			'fields'     => array(
				array(
					'field'       => 'mobile_menu',
					'type'        => __( 'Menu Mobile Text', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
				array(
					'field'       => 'close_mobile_menu',
					'type'        => __( 'Close Menu Mobile Text', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
			),
		);
		
		$widgets[ 'attesa-extra-double-button' ] = array(
			'conditions' => array( 'widgetType' => 'attesa-extra-double-button' ),
			'fields'     => array(
				array(
					'field'       => 'section_double_first_button_text',
					'type'        => __( 'Double button first text', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
				'section_double_first_button_link' => array(
					'field'       => 'url',
					'type'        => __( 'Double button first link', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
				array(
					'field'       => 'section_double_second_button_text',
					'type'        => __( 'Double button second text', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
				'section_double_second_button_link' => array(
					'field'       => 'url',
					'type'        => __( 'Double button second link', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
			),
		);
		
		$widgets[ 'attesa-extra-advanced-heading' ] = array(
			'conditions' => array( 'widgetType' => 'attesa-extra-advanced-heading' ),
			'fields'     => array(
				array(
					'field'       => 'advanced_heading_first',
					'type'        => __( 'Advanced heading first title', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
				array(
					'field'       => 'advanced_heading_second',
					'type'        => __( 'Advanced heading second title', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
				array(
					'field'       => 'advanced_heading_subtitle',
					'type'        => __( 'Advanced heading subtitle', 'attesa-extra' ),
					'editor_type' => 'VISUAL'
				),
			),
		);
		
		$widgets[ 'attesa-extra-flip-box' ] = array(
			'conditions' => array( 'widgetType' => 'attesa-extra-flip-box' ),
			'fields'     => array(
				array(
					'field'       => 'section_flip_box_front_title',
					'type'        => __( 'Flip box front side title', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
				array(
					'field'       => 'section_flip_box_front_content',
					'type'        => __( 'Flip box front side content', 'attesa-extra' ),
					'editor_type' => 'VISUAL'
				),
				array(
					'field'       => 'section_flip_box_back_title',
					'type'        => __( 'Flip box back side title', 'attesa-extra' ),
					'editor_type' => 'LINE'
				),
				array(
					'field'       => 'section_flip_box_back_content',
					'type'        => __( 'Flip box back side content', 'attesa-extra' ),
					'editor_type' => 'VISUAL'
				),
			),
		);

		return $widgets;
	}
}
awpWPML::instance();