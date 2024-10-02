<?php
/**
 * Adds custom metabox
 *
 * @package Attesa_Extra
 * @category Core
 * @author Attesa
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// The Metabox class
if ( ! class_exists( 'Attesa_Post_Metabox' ) ) {
	final class Attesa_Post_Metabox {
		private $default_control;
		private $custom_control;
	
		public function enqueue_scripts( $hook ) {
			if ( $hook != 'edit.php' && $hook != 'post.php' && $hook != 'post-new.php' ) {
				return;
			}
			
			// Get global post
			global $post;

			// Return if post is not object
			if ( ! is_object( $post ) ) {
				return;
			}
			
			wp_enqueue_script( 'attesa-extra-register-controls-script', plugins_url('/butterbean/js/register-controls.js',__FILE__), array('butterbean'), ATTESA_EXTRA_PLUGIN_VERSION, true);
			wp_enqueue_style( 'attesa-extra-metabox-style', plugins_url('css/attesa-extra-admin-css.css',__FILE__), array(), ATTESA_EXTRA_PLUGIN_VERSION);
			wp_enqueue_script( 'attesa-extra-metabox-script', plugins_url('js/attesa-extra-admin-js.js',__FILE__), array('jquery'), ATTESA_EXTRA_PLUGIN_VERSION, true);
			wp_enqueue_script( 'wp-color-picker-alpha', plugins_url( '/butterbean/js/wp-color-picker-alpha.js', __FILE__ ), array( 'wp-color-picker' ), ATTESA_EXTRA_PLUGIN_VERSION, true );
		}
		
		private function setup_actions() {
			// Default butterbean controls
			$this->default_control = array(
				'checkbox',
				'select',
				'color',
				'text',
				'number',
				'textarea',
				'image',
				'checkboxes',
			);
			// Custom butterbean controls
			$this->custom_control = array(
				'onoff' 		=> 'Attesa_ButterBean_Control_Onoff',
				'rgba-color' 	=> 'Attesa_ButterBean_Control_RGBA_Color',
			);
			$capabilities = apply_filters( 'attesa_filter_metabox_capabilities', 'manage_options' );
			if ( current_user_can( $capabilities ) ) {
				add_action( 'butterbean_register', array( $this, 'register_managers' ), 10, 2 );
				add_action( 'butterbean_register', array( $this, 'register_sections' ), 10, 2 );
				add_action( 'butterbean_register', array( $this, 'register_controls_and_settings' ), 10, 2 );
				add_action( 'butterbean_register', array( $this, 'register_controls_and_settings_for_post' ), 10, 2 );
				add_action( 'butterbean_register', array( $this, 'register_controls_and_settings_for_page' ), 10, 2 );
				add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
			}
			add_filter( 'butterbean_pre_control_template', array( $this, 'default_control_templates' ), 10, 2 );
			add_action( 'butterbean_register', array( $this, 'register_control_types' ), 10, 2 );
			add_filter( 'butterbean_control_template', array( $this, 'custom_control_templates' ), 10, 2 );
		}
		
		public function default_control_templates( $located, $slug ) {
			$controls = $this->default_control;
			foreach ( $controls as $control ) {
				if ( $slug === $control ) {
					return( AE_PATH . '/metabox/controls/'. $control .'/template.php' );
				}
			}
			return $located;
		}
		
		public function register_control_types( $butterbean ) {
			$controls = $this->custom_control;
			foreach ( $controls as $control => $class ) {
				require_once( AE_PATH . '/metabox/controls/'. $control .'/class-control-'. $control .'.php' );
				$butterbean->register_control_type( $control, $class );
			}
		}
		
		public function custom_control_templates( $located, $slug ) {
			$controls = $this->custom_control;
			foreach ( $controls as $control => $class ) {
				if ( $slug === $control ) {
					return( AE_PATH . '/metabox/controls/'. $control .'/template.php' );
				}
			}
			return $located;
		}
		
		public function register_managers( $butterbean, $post_type ) {
			$screens = get_post_types( array('public' => true) );
			$butterbean->register_manager(
				'attesa_mb_settings',
				array(
					'label'     => __( 'Attesa Extra Theme Options', 'attesa-extra' ),
					'post_type' => $screens,
					'context'   => 'normal',
					'priority'  => 'high'
				)
			);
		}
		
		public function register_sections( $butterbean, $post_type ) {
			$manager = $butterbean->get_manager( 'attesa_mb_settings' );
			$manager->register_section(
				'attesa_mb_general',
				array(
					'label' => __( 'General Settings', 'attesa-extra' ),
					'icon'  => 'dashicons-admin-generic'
				)
			);
			$manager->register_section(
				'attesa_mb_widgets',
				array(
					'label' => __( 'Widgets Settings', 'attesa-extra' ),
					'icon'  => 'dashicons-welcome-widgets-menus'
				)
			);
			if ( 'post' == $post_type ) {
				$manager->register_section(
					'attesa_mb_post',
					array(
						'label' => __( 'Post Settings', 'attesa-extra' ),
						'icon'  => 'dashicons-admin-page'
					)
				);
			}
			if ( 'page' == $post_type ) {
				$manager->register_section(
					'attesa_mb_page',
					array(
						'label' => __( 'Page Settings', 'attesa-extra' ),
						'icon'  => 'dashicons-admin-page'
					)
				);
			}
			$manager->register_section(
				'attesa_mb_header',
				array(
					'label' => __( 'Header Settings', 'attesa-extra' ),
					'icon'  => 'dashicons-menu'
				)
			);
			$manager->register_section(
				'attesa_mb_colors',
				array(
					'label' => __( 'Colors Settings', 'attesa-extra' ),
					'icon'  => 'dashicons-admin-customizer'
				)
			);
			$manager->register_section(
				'attesa_mb_shortcodes',
				array(
					'label' => __( 'Shortcodes', 'attesa-extra' ),
					'icon'  => 'dashicons-admin-settings'
				)
			);
		}
		
		public function register_controls_and_settings_for_post( $butterbean, $post_type ) {
			// Return if it is not Post post type
			if ( 'post' != $post_type ) {
				return;
			}
			
			$manager = $butterbean->get_manager( 'attesa_mb_settings' );
			/* Use custom settings for this post */
			$manager->register_control(
				'_post_use_custom_settings',
				array(
					'section' 		=> 'attesa_mb_post',
					'type'    		=> 'onoff',
					'label'   		=> __( 'Use custom settings for this post', 'attesa-extra' ),
					'priority' => 1,
				)
			);
			$manager->register_setting(
				'_post_use_custom_settings',
				array(
					'sanitize_callback' => 'sanitize_key',
					'default' 			=> ''
				)
			);
			/* Featured image style (if set) */
			$manager->register_control(
				'_post_featured_image_style',
				array(
					'section' 		=> 'attesa_mb_post',
					'type'    		=> 'select',
					'label'   		=> __( 'Featured image style (if set)', 'attesa-extra' ),
					'choices' 		=> array(
						'content' 	=> __( 'Featured image inside the content', 'attesa-extra' ),
						'header' => __( 'Big Featured image in the header', 'attesa-extra' ),
					),
					'priority' => 2,
				)
			);
			$manager->register_setting(
				'_post_featured_image_style',
				array(
					'sanitize_callback' => 'sanitize_key',
				)
			);
			/* Overlay featured image to the main menu */
			$manager->register_control(
				'_post_overlay_featured_image',
				array(
					'section' 		=> 'attesa_mb_post',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Overlay featured image to the main menu', 'attesa-extra' ),
					'priority' => 3,
				)
			);
			$manager->register_setting(
				'_post_overlay_featured_image',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Featured image fixed inside the box */
			$manager->register_control(
				'_post_fixed_featured_image',
				array(
					'section' 		=> 'attesa_mb_post',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Featured image fixed inside the box', 'attesa-extra' ),
					'priority' => 4,
				)
			);
			$manager->register_setting(
				'_post_fixed_featured_image',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Featured image height (in pixel) */
			$manager->register_control(
				'_post_height_featured_image',
				array(
					'section' 		=> 'attesa_mb_post',
					'type'    		=> 'number',
					'label'   		=> __( 'Featured image height (in pixel)', 'attesa-extra' ),
					'priority' => 5,
				)
			);
			$manager->register_setting(
				'_post_height_featured_image',
				array(
					'sanitize_callback' => 'absint',
					'default' => attesa_options('_featimage_style_posts_height', '500')
				)
			);
			/* Box opacity background color */
			$manager->register_control(
				'_post_opacity_featured_image',
				array(
					'section' 		=> 'attesa_mb_post',
					'type'    		=> 'color',
					'label'   		=> __( 'Box opacity background color', 'attesa-extra' ),
					'priority' => 6,
				)
			);
			$manager->register_setting(
				'_post_opacity_featured_image',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#f5f5f5'
				)
			);
			/* Text color for the overlay header */
			$manager->register_control(
				'_post_overlay_contenttoheader_color',
				array(
					'section' 		=> 'attesa_mb_post',
					'type'    		=> 'color',
					'label'   		=> __( 'Text color for the overlay header', 'attesa-extra' ),
					'priority' => 7,
				)
			);
			$manager->register_setting(
				'_post_overlay_contenttoheader_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#404040'
				)
			);
			/* Title position */
			$manager->register_control(
				'_post_featured_title_style',
				array(
					'section' 		=> 'attesa_mb_post',
					'type'    		=> 'select',
					'label'   		=> __( 'Title position', 'attesa-extra' ),
					'choices' 		=> array(
						'insidecontent' 	=> __( 'Inside the content', 'attesa-extra' ),
						'insideheader' => __( 'Inside the header', 'attesa-extra' ),
					),
					'priority' => 8,
				)
			);
			$manager->register_setting(
				'_post_featured_title_style',
				array(
					'sanitize_callback' => 'sanitize_key',
				)
			);
			
		}
		
		public function register_controls_and_settings_for_page( $butterbean, $post_type ) {
			// Return if it is not Post post type
			if ( 'page' == $post_type && isset($_GET['post']) ) {
				if (get_option('page_for_posts') != $_GET['post'] && get_option( 'woocommerce_shop_page_id' ) != $_GET['post']) {
					$manager = $butterbean->get_manager( 'attesa_mb_settings' );
					/* Use custom settings for this page */
					$manager->register_control(
						'_page_use_custom_settings',
						array(
							'section' 		=> 'attesa_mb_page',
							'type'    		=> 'onoff',
							'label'   		=> __( 'Use custom settings for this page', 'attesa-extra' ),
							'priority' => 1,
						)
					);
					$manager->register_setting(
						'_page_use_custom_settings',
						array(
							'sanitize_callback' => 'sanitize_key',
							'default' 			=> ''
						)
					);
					/* Featured image style (if set) */
					$manager->register_control(
						'_page_featured_image_style',
						array(
							'section' 		=> 'attesa_mb_page',
							'type'    		=> 'select',
							'label'   		=> __( 'Featured image style (if set)', 'attesa-extra' ),
							'choices' 		=> array(
								'content' 	=> __( 'Featured image inside the content', 'attesa-extra' ),
								'header' => __( 'Big Featured image in the header', 'attesa-extra' ),
							),
							'priority' => 2,
						)
					);
					$manager->register_setting(
						'_page_featured_image_style',
						array(
							'sanitize_callback' => 'sanitize_key',
						)
					);
					/* Overlay featured image to the main menu */
					$manager->register_control(
						'_page_overlay_featured_image',
						array(
							'section' 		=> 'attesa_mb_page',
							'type'    		=> 'checkbox',
							'label'   		=> __( 'Overlay featured image to the main menu', 'attesa-extra' ),
							'priority' => 3,
						)
					);
					$manager->register_setting(
						'_page_overlay_featured_image',
						array(
							'sanitize_callback' => 'butterbean_validate_boolean',
							'default' 			=> ''
						)
					);
					/* Featured image fixed inside the box */
					$manager->register_control(
						'_page_fixed_featured_image',
						array(
							'section' 		=> 'attesa_mb_page',
							'type'    		=> 'checkbox',
							'label'   		=> __( 'Featured image fixed inside the box', 'attesa-extra' ),
							'priority' => 4,
						)
					);
					$manager->register_setting(
						'_page_fixed_featured_image',
						array(
							'sanitize_callback' => 'butterbean_validate_boolean',
							'default' 			=> ''
						)
					);
					/* Featured image height (in pixel) */
					$manager->register_control(
						'_page_height_featured_image',
						array(
							'section' 		=> 'attesa_mb_page',
							'type'    		=> 'number',
							'label'   		=> __( 'Featured image height (in pixel)', 'attesa-extra' ),
							'priority' => 5,
						)
					);
					$manager->register_setting(
						'_page_height_featured_image',
						array(
							'sanitize_callback' => 'absint',
							'default' => attesa_options('_featimage_style_posts_height', '500')
						)
					);
					/* Box opacity background color */
					$manager->register_control(
						'_page_opacity_featured_image',
						array(
							'section' 		=> 'attesa_mb_page',
							'type'    		=> 'color',
							'label'   		=> __( 'Box opacity background color', 'attesa-extra' ),
							'priority' => 6,
						)
					);
					$manager->register_setting(
						'_page_opacity_featured_image',
						array(
							'sanitize_callback' => 'sanitize_hex_color',
							'default' 			=> '#f5f5f5'
						)
					);
					/* Text color for the overlay header */
					$manager->register_control(
						'_page_overlay_contenttoheader_color',
						array(
							'section' 		=> 'attesa_mb_page',
							'type'    		=> 'color',
							'label'   		=> __( 'Text color for the overlay header', 'attesa-extra' ),
							'priority' => 7,
						)
					);
					$manager->register_setting(
						'_page_overlay_contenttoheader_color',
						array(
							'sanitize_callback' => 'sanitize_hex_color',
							'default' 			=> '#404040'
						)
					);
					/* Title position */
					$manager->register_control(
						'_page_featured_title_style',
						array(
							'section' 		=> 'attesa_mb_page',
							'type'    		=> 'select',
							'label'   		=> __( 'Title position', 'attesa-extra' ),
							'choices' 		=> array(
								'insidecontent' 	=> __( 'Inside the content', 'attesa-extra' ),
								'insideheader' => __( 'Inside the header', 'attesa-extra' ),
							),
							'priority' => 8,
						)
					);
					$manager->register_setting(
						'_page_featured_title_style',
						array(
							'sanitize_callback' => 'sanitize_key',
						)
					);
				}
			}	
		}
		
		public function register_controls_and_settings( $butterbean, $post_type ) {
			$manager = $butterbean->get_manager( 'attesa_mb_settings' );
			/* Use custom general settings */
			$manager->register_control(
				'_general_use_custom_settings',
				array(
					'section' 		=> 'attesa_mb_general',
					'type'    		=> 'onoff',
					'label'   		=> __( 'Use custom general settings', 'attesa-extra' ),
					'priority' => 1,
				)
			);
			$manager->register_setting(
				'_general_use_custom_settings',
				array(
					'sanitize_callback' => 'sanitize_key',
					'default' 			=> ''
				)
			);
			/* Set this page 100% full width (useful if page is made entirely with page builders) */
			$manager->register_control(
				'_general_use_full_width_builders',
				array(
					'section' 		=> 'attesa_mb_general',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Set this page 100% full width', 'attesa-extra' ),
					'description'   => __( 'Useful if page is made entirely with page builders', 'attesa-extra' ),
					'priority' => 2,
				)
			);
			$manager->register_setting(
				'_general_use_full_width_builders',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Overlay content on the header */
			$manager->register_control(
				'_general_overlay_contenttoheader',
				array(
					'section' 		=> 'attesa_mb_general',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Overlay content on the header', 'attesa-extra' ),
					'priority' => 3,
				)
			);
			$manager->register_setting(
				'_general_overlay_contenttoheader',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Text color for the overlay header */
			$manager->register_control(
				'_general_overlay_contenttoheader_color',
				array(
					'section' 		=> 'attesa_mb_general',
					'type'    		=> 'color',
					'label'   		=> __( 'Text color for the overlay header', 'attesa-extra' ),
					'priority' => 4,
				)
			);
			$manager->register_setting(
				'_general_overlay_contenttoheader_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#ffffff'
				)
			);
			/* Add a background color to header when is overlay */
			$manager->register_control(
		        '_general_overlay_contentbackground',
		        array(
		            'section' 		=> 'attesa_mb_general',
		            'type'    		=> 'rgba-color',
		            'label'   		=> __( 'Background color for the overlay header', 'attesa-extra' ),
					'priority' => 4,
		        )
		    );
			
			$manager->register_setting(
		        '_general_overlay_contentbackground',
		        array(
		            'sanitize_callback' => 'attesaextra_sanitize_hex_or_rgba',
		        )
		    );
			/* Website Structure */
			$manager->register_control(
				'_website_structure',
				array(
					'section' 		=> 'attesa_mb_general',
					'type'    		=> 'select',
					'label'   		=> __( 'Website Structure', 'attesa-extra' ),
					'choices' 		=> array(
						'wide' 	=> __( 'Wide', 'attesa-extra' ),
						'boxed' => __( 'Boxed', 'attesa-extra' ),
					),
					'priority' => 5,
				)
			);
			$manager->register_setting(
				'_website_structure',
				array(
					'sanitize_callback' => 'sanitize_key',
					'default' => attesa_options('_website_structure', 'wide')
				)
			);
			/* Max width for boxed website (in pixel) */
			$manager->register_control(
				'_max_width_structure',
				array(
					'section' 		=> 'attesa_mb_general',
					'type'    		=> 'number',
					'label'   		=> __( 'Max width for boxed website (in pixel)', 'attesa-extra' ),
					'priority' => 6,
				)
			);
			$manager->register_setting(
				'_max_width_structure',
				array(
					'sanitize_callback' => 'absint',
					'default' => attesa_options('_max_width_structure', '1500')
				)
			);
			/* Border radius for elements (in pixel) */
			$manager->register_control(
				'_elements_border_radius',
				array(
					'section' 		=> 'attesa_mb_general',
					'type'    		=> 'number',
					'label'   		=> __( 'Border radius for elements (in pixel)', 'attesa-extra' ),
					'priority' => 7,
				)
			);
			$manager->register_setting(
				'_elements_border_radius',
				array(
					'sanitize_callback' => 'absint',
					'default' => attesa_options('_elements_border_radius', '5')
				)
			);
			/* Max width for site content (in pixel) */
			$manager->register_control(
				'_max_width_site_content',
				array(
					'section' 		=> 'attesa_mb_general',
					'type'    		=> 'number',
					'label'   		=> __( 'Max width for site content (in pixel)', 'attesa-extra' ),
					'priority' => 8,
				)
			);
			$manager->register_setting(
				'_max_width_site_content',
				array(
					'sanitize_callback' => 'absint',
					'default' => attesa_options('_max_width', '1240')
				)
			);
			/* Width for content side with sidebar (in percentage) */
			$manager->register_control(
				'_max_width_with_sidebar',
				array(
					'section' 		=> 'attesa_mb_general',
					'type'    		=> 'number',
					'label'   		=> __( 'Width for content side with sidebar (in percentage)', 'attesa-extra' ),
					'priority' => 9,
				)
			);
			$manager->register_setting(
				'_max_width_with_sidebar',
				array(
					'sanitize_callback' => 'absint',
					'default' => attesa_options('_width_content', '67')
				)
			);
			/* Width for content side without sidebar (in percentage) */
			$manager->register_control(
				'_max_width_without_sidebar',
				array(
					'section' 		=> 'attesa_mb_general',
					'type'    		=> 'number',
					'label'   		=> __( 'Width for content side without sidebar (in percentage)', 'attesa-extra' ),
					'priority' => 10,
				)
			);
			$manager->register_setting(
				'_max_width_without_sidebar',
				array(
					'sanitize_callback' => 'absint',
					'default' => attesa_options('_width_content_nosidebar', '67')
				)
			);
			
			if ( function_exists('yoast_breadcrumb') ) {
				$breadcrumbs_enabled = WPSEO_Options::get('breadcrumbs-enable');
				if ($breadcrumbs_enabled) {
					/* Show breadcrumbs */
					$manager->register_control(
						'_show_yoast_breadcrumb',
						array(
							'section' 		=> 'attesa_mb_general',
							'type'    		=> 'select',
							'label'   		=> __( 'Show breadcrumbs', 'attesa-extra' ),
							'choices' 		=> array(
								'show' => __( 'Show breadcrumbs', 'attesa-extra' ),
								'hide' => __( 'Hide breadcrumbs', 'attesa-extra' ),
							),
							'priority' => 20,
						)
					);
					$manager->register_setting(
						'_show_yoast_breadcrumb',
						array(
							'sanitize_callback' => 'sanitize_key',
						)
					);
				}
			}
			
			
			/* Classic sidebar display */
			$manager->register_control(
				'_classic_sidebar_position',
				array(
					'section' 		=> 'attesa_mb_widgets',
					'type'    		=> 'select',
					'label'   		=> __( 'Classic sidebar display', 'attesa-extra' ),
					'choices' 		=> array(
						'default' 	=> __( 'Default from theme options', 'attesa-extra' ),
						'none' => __( 'Hide classic sidebar', 'attesa-extra' ),
						'show' => __( 'Show classic sidebar', 'attesa-extra' ),
					),
					'priority' => 1,
				)
			);
			$manager->register_setting(
				'_classic_sidebar_position',
				array(
					'sanitize_callback' => 'sanitize_key',
				)
			);
			/* Choose classic sidebar position */
			$manager->register_control(
				'_choose_classic_sidebar_position',
				array(
					'section' 		=> 'attesa_mb_widgets',
					'type'    		=> 'select',
					'label'   		=> __( 'Choose classic sidebar position', 'attesa-extra' ),
					'choices' 		=> array(
						'default' 	=> __( 'Default from theme options', 'attesa-extra' ),
						'left' => __( 'Classic sidebar left', 'attesa-extra' ),
						'right' => __( 'Classic sidebar right', 'attesa-extra' ),
					),
					'priority' => 2,
				)
			);
			$manager->register_setting(
				'_choose_classic_sidebar_position',
				array(
					'sanitize_callback' => 'sanitize_key',
				)
			);
			/* Push sidebar display */
			$manager->register_control(
				'_push_sidebar_position',
				array(
					'section' 		=> 'attesa_mb_widgets',
					'type'    		=> 'select',
					'label'   		=> __( 'Push sidebar display', 'attesa-extra' ),
					'choices' 		=> array(
						'default' 	=> __( 'Default from theme options', 'attesa-extra' ),
						'none' => __( 'Hide push sidebar', 'attesa-extra' ),
						'show' => __( 'Show push sidebar', 'attesa-extra' ),
					),
					'priority' => 4,
				)
			);
			$manager->register_setting(
				'_push_sidebar_position',
				array(
					'sanitize_callback' => 'sanitize_key',
				)
			);
			/* Choose push sidebar position */
			$manager->register_control(
				'_choose_push_sidebar_position',
				array(
					'section' 		=> 'attesa_mb_widgets',
					'type'    		=> 'select',
					'label'   		=> __( 'Choose push sidebar position', 'attesa-extra' ),
					'choices' 		=> array(
						'default' 	=> __( 'Default from theme options', 'attesa-extra' ),
						'left' => __( 'Push sidebar left', 'attesa-extra' ),
						'right' => __( 'Push sidebar right', 'attesa-extra' ),
					),
					'priority' => 5,
				)
			);
			$manager->register_setting(
				'_choose_push_sidebar_position',
				array(
					'sanitize_callback' => 'sanitize_key',
				)
			);
			/* Footer widgets display */
			$manager->register_control(
				'_footer_widgets_position',
				array(
					'section' 		=> 'attesa_mb_widgets',
					'type'    		=> 'select',
					'label'   		=> __( 'Footer widgets display', 'attesa-extra' ),
					'choices' 		=> array(
						'default' 	=> __( 'Default from theme options', 'attesa-extra' ),
						'none' => __( 'Hide footer widgets', 'attesa-extra' ),
						'show' => __( 'Show footer widgets', 'attesa-extra' ),
					),
					'priority' => 7,
				)
			);
			$manager->register_setting(
				'_footer_widgets_position',
				array(
					'sanitize_callback' => 'sanitize_key',
				)
			);
			/* Use custom general settings */
			$manager->register_control(
				'_header_use_custom_settings',
				array(
					'section' 		=> 'attesa_mb_header',
					'type'    		=> 'onoff',
					'label'   		=> __( 'Use header custom settings', 'attesa-extra' ),
					'priority' => 1,
				)
			);
			$manager->register_setting(
				'_header_use_custom_settings',
				array(
					'sanitize_callback' => 'sanitize_key',
					'default' 			=> ''
				)
			);
			/* Header style */
			$manager->register_control(
				'_header_style',
				array(
					'section' 		=> 'attesa_mb_header',
					'type'    		=> 'select',
					'label'   		=> __( 'Header style', 'attesa-extra' ),
					'choices' 		=> array(
						'default' 	=> __( 'Default from theme options', 'attesa-extra' ),
						'boxed' 	=> __( 'Boxed', 'attesa-extra' ),
						'fullwidth' => __( 'Full Width', 'attesa-extra' ),
					),
					'priority' => 2,
				)
			);
			$manager->register_setting(
				'_header_style',
				array(
					'sanitize_callback' => 'sanitize_key',
				)
			);
			/* Sticky header when scroll down */
			$manager->register_control(
				'_sticky_header_scroll',
				array(
					'section' 		=> 'attesa_mb_header',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Sticky header when scroll down', 'attesa-extra' ),
					'priority' => 2,
				)
			);
			$manager->register_setting(
				'_sticky_header_scroll',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Sticky header also on tablet/smartphone */
			$manager->register_control(
				'_sticky_header_scroll_mobile',
				array(
					'section' 		=> 'attesa_mb_header',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Sticky header also on tablet/smartphone', 'attesa-extra' ),
					'priority' => 3,
				)
			);
			$manager->register_setting(
				'_sticky_header_scroll_mobile',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Show top navigation bar */
			$manager->register_control(
				'_use_top_nav',
				array(
					'section' 		=> 'attesa_mb_header',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Show top navigation bar', 'attesa-extra' ),
					'priority' => 4,
				)
			);
			$manager->register_setting(
				'_use_top_nav',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Show top bar also on tablet/smartphone */
			$manager->register_control(
				'_use_top_nav_mobile',
				array(
					'section' 		=> 'attesa_mb_header',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Show top bar also on tablet/smartphone', 'attesa-extra' ),
					'priority' => 5,
				)
			);
			$manager->register_setting(
				'_use_top_nav_mobile',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Top bar style */
			$manager->register_control(
				'_topbar_style',
				array(
					'section' 		=> 'attesa_mb_header',
					'type'    		=> 'select',
					'label'   		=> __( 'Top bar style', 'attesa-extra' ),
					'choices' 		=> array(
						'default' 	=> __( 'Default from theme options', 'attesa-extra' ),
						'boxed' 	=> __( 'Boxed', 'attesa-extra' ),
						'fullwidth' => __( 'Full Width', 'attesa-extra' ),
					),
					'priority' => 6,
				)
			);
			$manager->register_setting(
				'_topbar_style',
				array(
					'sanitize_callback' => 'sanitize_key',
				)
			);
			/* Top bar scroll */
			$manager->register_control(
				'_scroll_top_nav',
				array(
					'section' 		=> 'attesa_mb_header',
					'type'    		=> 'select',
					'label'   		=> __( 'Top bar scroll', 'attesa-extra' ),
					'choices' 		=> array(
						'default' 	=> __( 'Default from theme options', 'attesa-extra' ),
						'hide' => __( 'Hide when scroll down', 'attesa-extra' ),
						'show' => __( 'Show when scroll down', 'attesa-extra' ),
					),
					'priority' => 7,
				)
			);
			$manager->register_setting(
				'_scroll_top_nav',
				array(
					'sanitize_callback' => 'sanitize_key',
				)
			);
			/* Upload custom logo for this page */
			$manager->register_control(
				'_upload_custom_logo',
				array(
					'section' 		=> 'attesa_mb_header',
					'type'    		=> 'image',
					'label'   		=> __( 'Use a custom logo for this post/page', 'attesa-extra' ),
					'description'   => __( 'Recommended size 220x60px', 'attesa-extra' ),
					'priority' => 8,
				)
			);
			$manager->register_setting(
				'_upload_custom_logo',
				array(
					'sanitize_callback' => 'absint',
				)
			);
			/* Upload custom logo on scroll for this page */
			$manager->register_control(
				'_upload_custom_logo_on_scroll',
				array(
					'section' 		=> 'attesa_mb_header',
					'type'    		=> 'image',
					'label'   		=> __( 'Use a custom logo on scroll for this post/page', 'attesa-extra' ),
					'description'   => __( 'Recommended size 220x60px', 'attesa-extra' ),
					'priority' => 9,
				)
			);
			$manager->register_setting(
				'_upload_custom_logo_on_scroll',
				array(
					'sanitize_callback' => 'absint',
				)
			);
			/* Use custom colors for this page */
			$manager->register_control(
				'_color_use_custom_settings',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'onoff',
					'label'   		=> __( 'Use custom colors for this page', 'attesa-extra' ),
					'priority' => 1,
				)
			);
			$manager->register_setting(
				'_color_use_custom_settings',
				array(
					'sanitize_callback' => 'sanitize_key',
					'default' 			=> ''
				)
			);
			/* Edit general colors */
			$manager->register_control(
				'_color_use_general_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Edit general colors', 'attesa-extra' ),
					'priority' => 2,
				)
			);
			$manager->register_setting(
				'_color_use_general_color',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Outer background color */
			$manager->register_control(
				'_outer_background_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Outer background color', 'attesa-extra' ),
					'priority' => 3,
				)
			);
			$manager->register_setting(
				'_outer_background_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#cccccc'
				)
			);
			/* General background color */
			$manager->register_control(
				'_general_background_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'General background color', 'attesa-extra' ),
					'priority' => 4,
				)
			);
			$manager->register_setting(
				'_general_background_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#ffffff'
				)
			);
			/* Alternative background color */
			$manager->register_control(
				'_alternative_background_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Alternative background color', 'attesa-extra' ),
					'priority' => 5,
				)
			);
			$manager->register_setting(
				'_alternative_background_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#fbfbfb'
				)
			);
			/* General text color */
			$manager->register_control(
				'_general_text_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'General text color', 'attesa-extra' ),
					'priority' => 6,
				)
			);
			$manager->register_setting(
				'_general_text_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#404040'
				)
			);
			/* Content text color */
			$manager->register_control(
				'_content_text_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Content text color', 'attesa-extra' ),
					'priority' => 7,
				)
			);
			$manager->register_setting(
				'_content_text_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#828282'
				)
			);
			/* General link color */
			$manager->register_control(
				'_general_link_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'General link color', 'attesa-extra' ),
					'priority' => 8,
				)
			);
			$manager->register_setting(
				'_general_link_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#f06292'
				)
			);
			/* General border color */
			$manager->register_control(
				'_general_border_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'General border color', 'attesa-extra' ),
					'priority' => 9,
				)
			);
			$manager->register_setting(
				'_general_border_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#ececec'
				)
			);
			/* Edit top bar colors */
			$manager->register_control(
				'_color_use_topnav_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Edit top bar colors', 'attesa-extra' ),
					'priority' => 10,
				)
			);
			$manager->register_setting(
				'_color_use_topnav_color',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Top bar background color */
			$manager->register_control(
				'_topbar_background_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Top bar background color', 'attesa-extra' ),
					'priority' => 11,
				)
			);
			$manager->register_setting(
				'_topbar_background_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#fbfbfb'
				)
			);
			/* Top bar text color */
			$manager->register_control(
				'_topbar_text_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Top bar text color', 'attesa-extra' ),
					'priority' => 12,
				)
			);
			$manager->register_setting(
				'_topbar_text_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#828282'
				)
			);
			/* Top bar border color */
			$manager->register_control(
				'_topbar_border_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Top bar border color', 'attesa-extra' ),
					'priority' => 13,
				)
			);
			$manager->register_setting(
				'_topbar_border_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#ececec'
				)
			);
			/* Edit header colors */
			$manager->register_control(
				'_color_use_header_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Edit header colors', 'attesa-extra' ),
					'priority' => 13,
				)
			);
			$manager->register_setting(
				'_color_use_header_color',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Header background color */
			$manager->register_control(
				'_header_background_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Header background color', 'attesa-extra' ),
					'priority' => 13,
				)
			);
			$manager->register_setting(
				'_header_background_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#ffffff'
				)
			);
			/* Header link color */
			$manager->register_control(
				'_header_link_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Header link color', 'attesa-extra' ),
					'priority' => 13,
				)
			);
			$manager->register_setting(
				'_header_link_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#f06292'
				)
			);
			/* Header text color */
			$manager->register_control(
				'_header_text_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Header text color', 'attesa-extra' ),
					'priority' => 13,
				)
			);
			$manager->register_setting(
				'_header_text_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#404040'
				)
			);
			/* Edit classic sidebar colors */
			$manager->register_control(
				'_color_use_classic_sidebar_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Edit classic sidebar colors', 'attesa-extra' ),
					'priority' => 14,
				)
			);
			$manager->register_setting(
				'_color_use_classic_sidebar_color',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Classic sidebar background color */
			$manager->register_control(
				'_classicsidebar_background_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Classic sidebar background color', 'attesa-extra' ),
					'priority' => 15,
				)
			);
			$manager->register_setting(
				'_classicsidebar_background_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#fbfbfb'
				)
			);
			/* Classic sidebar text color */
			$manager->register_control(
				'_classicsidebar_text_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Classic sidebar text color', 'attesa-extra' ),
					'priority' => 16,
				)
			);
			$manager->register_setting(
				'_classicsidebar_text_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#404040'
				)
			);
			/* Classic sidebar link color */
			$manager->register_control(
				'_classicsidebar_link_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Classic sidebar link color', 'attesa-extra' ),
					'priority' => 17,
				)
			);
			$manager->register_setting(
				'_classicsidebar_link_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#f06292'
				)
			);
			/* Classic sidebar border color */
			$manager->register_control(
				'_classicsidebar_border_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Classic sidebar border color', 'attesa-extra' ),
					'priority' => 18,
				)
			);
			$manager->register_setting(
				'_classicsidebar_border_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#ececec'
				)
			);
			/* Edit push sidebar colors */
			$manager->register_control(
				'_color_use_push_sidebar_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Edit push sidebar colors', 'attesa-extra' ),
					'priority' => 19,
				)
			);
			$manager->register_setting(
				'_color_use_push_sidebar_color',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Push sidebar background color */
			$manager->register_control(
				'_pushsidebar_background_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Push sidebar background color', 'attesa-extra' ),
					'priority' => 20,
				)
			);
			$manager->register_setting(
				'_pushsidebar_background_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#fbfbfb'
				)
			);
			/* Push sidebar text color */
			$manager->register_control(
				'_pushsidebar_text_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Push sidebar text color', 'attesa-extra' ),
					'priority' => 21,
				)
			);
			$manager->register_setting(
				'_pushsidebar_text_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#909090'
				)
			);
			/* Push sidebar link color */
			$manager->register_control(
				'_pushsidebar_link_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Push sidebar link color', 'attesa-extra' ),
					'priority' => 22,
				)
			);
			$manager->register_setting(
				'_pushsidebar_link_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#f06292'
				)
			);
			/* Push sidebar border color */
			$manager->register_control(
				'_pushsidebar_border_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Push sidebar border color', 'attesa-extra' ),
					'priority' => 23,
				)
			);
			$manager->register_setting(
				'_pushsidebar_border_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#ececec'
				)
			);
			/* Edit footer colors */
			$manager->register_control(
				'_color_use_footer_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'checkbox',
					'label'   		=> __( 'Edit footer colors', 'attesa-extra' ),
					'priority' => 24,
				)
			);
			$manager->register_setting(
				'_color_use_footer_color',
				array(
					'sanitize_callback' => 'butterbean_validate_boolean',
					'default' 			=> ''
				)
			);
			/* Footer background color */
			$manager->register_control(
				'_footer_background_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Footer background color', 'attesa-extra' ),
					'priority' => 25,
				)
			);
			$manager->register_setting(
				'_footer_background_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#3f3f3f'
				)
			);
			/* Footer text color */
			$manager->register_control(
				'_footer_text_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Footer text color', 'attesa-extra' ),
					'priority' => 26,
				)
			);
			$manager->register_setting(
				'_footer_text_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#f0f0f0'
				)
			);
			/* Footer link color */
			$manager->register_control(
				'_footer_link_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Footer link color', 'attesa-extra' ),
					'priority' => 27,
				)
			);
			$manager->register_setting(
				'_footer_link_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#aeaeae'
				)
			);
			/* Footer border color */
			$manager->register_control(
				'_footer_border_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Footer border color', 'attesa-extra' ),
					'priority' => 28,
				)
			);
			$manager->register_setting(
				'_footer_border_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#bcbcbc'
				)
			);
			/* Sub Footer background color */
			$manager->register_control(
				'_subfooter_background_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Sub Footer background color', 'attesa-extra' ),
					'priority' => 29,
				)
			);
			$manager->register_setting(
				'_subfooter_background_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#181818'
				)
			);
			/* Sub Footer text color */
			$manager->register_control(
				'_subfooter_text_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Sub Footer text color', 'attesa-extra' ),
					'priority' => 30,
				)
			);
			$manager->register_setting(
				'_subfooter_text_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#ffffff'
				)
			);
			/* Sub Footer link color */
			$manager->register_control(
				'_subfooter_link_color',
				array(
					'section' 		=> 'attesa_mb_colors',
					'type'    		=> 'color',
					'label'   		=> __( 'Sub Footer link color', 'attesa-extra' ),
					'priority' => 31,
				)
			);
			$manager->register_setting(
				'_subfooter_link_color',
				array(
					'sanitize_callback' => 'sanitize_hex_color',
					'default' 			=> '#9a9a9a'
				)
			);
			/* Shortcode before site content */
			$manager->register_control(
				'_shortcode_before_site_content',
				array(
					'section' 		=> 'attesa_mb_shortcodes',
					'type'    		=> 'text',
					'label'   		=> __( 'Shortcode before site content', 'attesa-extra' ),
					'priority' => 1,
				)
			);
			$manager->register_setting(
				'_shortcode_before_site_content',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			/* Shortcode after site content */
			$manager->register_control(
				'_shortcode_after_site_content',
				array(
					'section' 		=> 'attesa_mb_shortcodes',
					'type'    		=> 'text',
					'label'   		=> __( 'Shortcode after site content', 'attesa-extra' ),
					'priority' => 2,
				)
			);
			$manager->register_setting(
				'_shortcode_after_site_content',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			/* Shortcode before page content */
			$manager->register_control(
				'_shortcode_before_page_content',
				array(
					'section' 		=> 'attesa_mb_shortcodes',
					'type'    		=> 'text',
					'label'   		=> __( 'Shortcode before page content', 'attesa-extra' ),
					'priority' => 2,
				)
			);
			$manager->register_setting(
				'_shortcode_before_page_content',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			/* Shortcode after page content */
			$manager->register_control(
				'_shortcode_after_page_content',
				array(
					'section' 		=> 'attesa_mb_shortcodes',
					'type'    		=> 'text',
					'label'   		=> __( 'Shortcode after page content', 'attesa-extra' ),
					'priority' => 2,
				)
			);
			$manager->register_setting(
				'_shortcode_after_page_content',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			/* Shortcode before classic sidebar */
			$manager->register_control(
				'_shortcode_before_classic_side',
				array(
					'section' 		=> 'attesa_mb_shortcodes',
					'type'    		=> 'text',
					'label'   		=> __( 'Shortcode before classic sidebar', 'attesa-extra' ),
					'priority' => 3,
				)
			);
			$manager->register_setting(
				'_shortcode_before_classic_side',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			/* Shortcode after classic sidebar */
			$manager->register_control(
				'_shortcode_after_classic_side',
				array(
					'section' 		=> 'attesa_mb_shortcodes',
					'type'    		=> 'text',
					'label'   		=> __( 'Shortcode after classic sidebar', 'attesa-extra' ),
					'priority' => 4,
				)
			);
			$manager->register_setting(
				'_shortcode_after_classic_side',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			/* Shortcode before push sidebar */
			$manager->register_control(
				'_shortcode_before_push_side',
				array(
					'section' 		=> 'attesa_mb_shortcodes',
					'type'    		=> 'text',
					'label'   		=> __( 'Shortcode before push sidebar', 'attesa-extra' ),
					'priority' => 5,
				)
			);
			$manager->register_setting(
				'_shortcode_before_push_side',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			/* Shortcode after push sidebar */
			$manager->register_control(
				'_shortcode_after_push_side',
				array(
					'section' 		=> 'attesa_mb_shortcodes',
					'type'    		=> 'text',
					'label'   		=> __( 'Shortcode after push sidebar', 'attesa-extra' ),
					'priority' => 6,
				)
			);
			$manager->register_setting(
				'_shortcode_after_push_side',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			/* Shortcode before footer widgets */
			$manager->register_control(
				'_shortcode_before_footer_wid',
				array(
					'section' 		=> 'attesa_mb_shortcodes',
					'type'    		=> 'text',
					'label'   		=> __( 'Shortcode before footer widgets', 'attesa-extra' ),
					'priority' => 7,
				)
			);
			$manager->register_setting(
				'_shortcode_before_footer_wid',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
			/* Shortcode after footer widgets */
			$manager->register_control(
				'_shortcode_after_footer_wid',
				array(
					'section' 		=> 'attesa_mb_shortcodes',
					'type'    		=> 'text',
					'label'   		=> __( 'Shortcode after footer widgets', 'attesa-extra' ),
					'priority' => 8,
				)
			);
			$manager->register_setting(
				'_shortcode_after_footer_wid',
				array(
					'sanitize_callback' => 'sanitize_text_field',
				)
			);
		}
		
		public static function get_instance() {
			static $instance = null;
			if ( is_null( $instance ) ) {
				$instance = new self;
				$instance->setup_actions();
			}
			return $instance;
		}
		private function __construct() {}
	}
	Attesa_Post_Metabox::get_instance();
}