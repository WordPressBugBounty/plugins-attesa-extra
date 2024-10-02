<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

final class Attesa_Extra_Elementor_Extensions {
	private static $_instance;
	
	/**
	 * Plugin instance
	 * 
	 * @since 1.0.0
	 * @return Plugin
	 */
	public static function instance() {

		if ( is_null( self::$_instance ) ) {
			self::$_instance = new self();
		}
		return self::$_instance;

	}
	
	public function __clone() {
		// Cloning instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'attesa-extra' ), '1.0.0' );
	}
	
	public function __wakeup() {
		// Unserializing instances of the class is forbidden
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'attesa-extra' ), '1.0.0' );
	}
	
	/**
	 * Widget constructor.
	 *
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct() {
		add_action( 'elementor/widgets/register', array( $this, 'register_elementor_widgets' ) );
		add_action( 'elementor/elements/categories_registered', array( $this, 'register_elementor_widget_categories' ) );
		add_action( 'elementor/frontend/after_register_scripts', array( $this, 'widget_scripts' ) );
		add_action( 'elementor/frontend/after_register_styles', array( $this, 'widget_styles' ) );
		add_action( 'elementor/preview/enqueue_scripts', array( $this, 'widget_scripts_preview' ) );
		add_action( 'elementor/preview/enqueue_styles', array( $this, 'widget_style_preview' ) );
		add_action( 'elementor/editor/after_enqueue_styles', array( $this, 'editor_style' ) );
		if ( !class_exists( 'Attesa_pro' ) ) {
			add_action( 'elementor/frontend/after_enqueue_scripts', array( $this, 'enqueue_editor_scripts_promotional' ) );
			add_filter( 'elementor/editor/localize_settings', array( $this, 'promote_pro_addons' ) );
		}
	}
	
	/**
	 * Registers widgets in Elementor
	 *
	 *
	 * @since 1.0.0
	 * @access public
	 */
	public function register_elementor_widgets($widgets_manager) {
		require_once AE_PATH . '/elementor/widgets/navigation-menu.php';
		$widgets_manager->register( new \Attesa_Extra_Navigation_Menu() );
		
		require_once AE_PATH . '/elementor/widgets/site-logo.php';
		$widgets_manager->register( new \Attesa_Extra_Site_Logo() );
		
		require_once AE_PATH . '/elementor/widgets/site-social-buttons.php';
		$widgets_manager->register( new \Attesa_Extra_Site_Social_Buttons() );
		
		require_once AE_PATH . '/elementor/widgets/posts-carousel.php';
		$widgets_manager->register( new \Attesa_Extra_Posts_Carousel() );
		
		require_once AE_PATH . '/elementor/widgets/divider.php';
		$widgets_manager->register( new \Attesa_Extra_Divider() );
		
		require_once AE_PATH . '/elementor/widgets/heading-typewriter.php';
		$widgets_manager->register( new \Attesa_Extra_Heading_Typewriter() );
		
		require_once AE_PATH . '/elementor/widgets/alert-message.php';
		$widgets_manager->register( new \Attesa_Extra_Alert_Message() );
		
		require_once AE_PATH . '/elementor/widgets/double-button.php';
		$widgets_manager->register( new \Attesa_Extra_Double_Button() );
		
		require_once AE_PATH . '/elementor/widgets/advanced-heading.php';
		$widgets_manager->register( new \Attesa_Extra_Advanced_Heading() );
		
		require_once AE_PATH . '/elementor/widgets/flip-box.php';
		$widgets_manager->register( new \Attesa_Extra_Flip_Box() );
	}
	
	public function register_elementor_widget_categories($elements_manager) {
		$elements_manager->add_category(
			'attesa-elements',
				array(
	                'title' => __( 'Attesa Theme Addons', 'attesa-extra' ),
	                'icon'  => 'fa fa-plug',
	            ),
		1 );
	}
	
	public function widget_scripts() {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_script('typed', plugins_url('elementor/js/typed'.$min.'.js',dirname(__FILE__)), array('jquery'),'2.0.9',true);
		wp_register_script('awp-alert', plugins_url('elementor/js/alert'.$min.'.js',dirname(__FILE__)), array('jquery'),ATTESA_EXTRA_PLUGIN_VERSION,true);
		wp_register_script('awp-heading-typewriter', plugins_url('elementor/js/heading-typewriter'.$min.'.js',dirname(__FILE__)), array('jquery'),ATTESA_EXTRA_PLUGIN_VERSION,true);
	}
	
	public function widget_scripts_preview() {
		wp_enqueue_script( 'typed' );
		wp_enqueue_script( 'awp-alert' );
		wp_enqueue_script( 'awp-heading-typewriter' );
	}
	
	public function widget_styles() {
		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
		wp_register_style( 'awp-double-button', plugins_url( '/elementor/css/double-button'.$min.'.css', dirname(__FILE__)), array(), ATTESA_EXTRA_PLUGIN_VERSION);
		wp_register_style( 'awp-advanced-heading', plugins_url( '/elementor/css/advanced-heading'.$min.'.css', dirname(__FILE__)), array(), ATTESA_EXTRA_PLUGIN_VERSION);
		wp_register_style( 'awp-posts-carousel', plugins_url( '/elementor/css/posts-carousel'.$min.'.css', dirname(__FILE__)), array(), ATTESA_EXTRA_PLUGIN_VERSION);
		wp_register_style( 'awp-divider', plugins_url( '/elementor/css/divider'.$min.'.css', dirname(__FILE__)), array(), ATTESA_EXTRA_PLUGIN_VERSION);
		wp_register_style( 'awp-heading-typewriter', plugins_url( '/elementor/css/heading-typewriter'.$min.'.css', dirname(__FILE__)), array(), ATTESA_EXTRA_PLUGIN_VERSION);
		wp_register_style( 'awp-alert-message', plugins_url( '/elementor/css/alert-message'.$min.'.css', dirname(__FILE__)), array(), ATTESA_EXTRA_PLUGIN_VERSION);
		wp_register_style( 'awp-site-social-buttons', plugins_url( '/elementor/css/site-social-buttons'.$min.'.css', dirname(__FILE__)), array(), ATTESA_EXTRA_PLUGIN_VERSION);
		wp_register_style( 'awp-flip-box', plugins_url( '/elementor/css/flip-box'.$min.'.css', dirname(__FILE__)), array(), ATTESA_EXTRA_PLUGIN_VERSION);
	}
	
	public function widget_style_preview() {
		wp_enqueue_style( 'awp-elementor-editor', plugins_url( 'elementor/css/fix-preview.min.css',dirname(__FILE__)), array(), ATTESA_EXTRA_PLUGIN_VERSION );
		wp_enqueue_style( 'awp-double-button' );
		wp_enqueue_style( 'awp-advanced-heading' );
		wp_enqueue_style( 'awp-posts-carousel' );
		wp_enqueue_style( 'awp-divider' );
		wp_enqueue_style( 'awp-heading-typewriter' );
		wp_enqueue_style( 'awp-alert-messsage' );
		wp_enqueue_style( 'awp-site-social-buttons' );
		wp_enqueue_style( 'awp-flip-box' );
	}
	
	public function editor_style() {
		wp_enqueue_style( 'awp-elementor-editor', plugins_url( 'elementor/css/editor.min.css',dirname(__FILE__)), array(), ATTESA_EXTRA_PLUGIN_VERSION );
	}
	
	public function enqueue_editor_scripts_promotional() {
		if ( \Elementor\Plugin::$instance->preview->is_preview_mode() ) {
			$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';
			wp_enqueue_script( 'awp-promotion', plugins_url('elementor/js/promotion'.$min.'.js',dirname(__FILE__)), array('jquery'), ATTESA_EXTRA_PLUGIN_VERSION, true );
			$attesa_extra_array_promotion = array(
				'conversionString' => esc_html__( 'Upgrade to Attesa PRO', 'attesa-extra' ),
			);
			wp_localize_script( 'awp-promotion', 'AttesaExtraElementorPromotion', $attesa_extra_array_promotion );
		}
	}
	
	public function promote_pro_addons($config) {
        $promotion_widgets = [];

        if (isset($config['promotionWidgets'])) {
            $promotion_widgets = $config['promotionWidgets'];
        }

        $combine_array = array_merge($promotion_widgets, [
            [
                'name' => 'attesa-pro-scroll-to-next-section',
                'title' => __('Scroll to next section', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-arrow-down',
                'categories' => '["attesa-elements"]',
            ],
            [
                'name' => 'attesa-pro-tilt-effect',
                'title' => __('Tilt Effect', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-clone',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-posts-carousel-pro',
                'title' => __('Posts Carousel', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-post-slider',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-pricing-table',
                'title' => __('Pricing Table', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-price-table',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-image-hotspots',
                'title' => __('Image Hotspots', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-image-hotspot',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-onepage-navigation',
                'title' => __('Onepage Navigation', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-navigation-vertical',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-stylize-every-word',
                'title' => __('Stylize every word', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-text-area',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-price-list',
                'title' => __('Price List', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-price-list',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-filterable-gallery',
                'title' => __('Filterable Gallery', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-gallery-masonry',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-page-scroll-progress',
                'title' => __('Page Scroll Progress', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-scroll',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-image-compare',
                'title' => __('Image Compare', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-image-before-after',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-offcanvas',
                'title' => __('Offcanvas', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-column',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-step-by-step',
                'title' => __('Step by step', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-h-align-right',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-ajax-search',
                'title' => __('Ajax Search', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-site-search',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-content-timeline',
                'title' => __('Content Timeline', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-time-line',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-content-behind-background',
                'title' => __('Content behind background', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-navigator',
                'categories' => '["attesa-elements"]',
            ],
			[
                'name' => 'attesa-pro-switch',
                'title' => __('Switch', 'attesa-extra'),
                'icon' => 'awp-pro-addons awp-icon eicon-dual-button',
                'categories' => '["attesa-elements"]',
            ]
        ]);

        $config['promotionWidgets'] = $combine_array;

        return $config;
    }

}
function attesa_extra_elementor_widgets() {
	return Attesa_Extra_Elementor_Extensions::instance();
}

attesa_extra_elementor_widgets();

function attesa_extra_allowed_tags_title($tag) {
	switch ($tag) {
		case 'h1':
			return 'h1';
			break;
		case 'h2':
			return 'h2';
			break;
		case 'h3':
			return 'h3';
			break;
		case 'h4':
			return 'h4';
			break;
		case 'h5':
			return 'h5';
			break;
		case 'h6':
			return 'h6';
			break;
		case 'div':
			return 'div';
			break;
		case 'span':
			return 'span';
			break;
		case 'p':
			return 'p';
			break;
		default:
			return 'h1';
	}
}