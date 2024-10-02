<?php
/**
 * Demos
 * Code is mostly from the Ocean Extra plugin.
 *
 * @package Attesa_extra
 * @category Core
 * @author AttesaWP
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
if ( ! class_exists( 'AttesaWP_Demos' ) ) {

	class AttesaWP_Demos {

		/**
		 * Start things up
		 */
		public function __construct() {

			// Return if not in admin
			if ( ! is_admin() || is_customize_preview() ) {
				return;
			}

			// Import demos page
			if ( version_compare( PHP_VERSION, '5.4', '>=' ) ) {
				require_once( AE_PATH .'/panel/classes/importers/class-helpers.php' );
				require_once( AE_PATH .'/panel/classes/class-install-demos.php' );
			}

			// Start things
			add_action( 'admin_init', array( $this, 'init' ) );

			// Demos scripts
			add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );

			// Allows xml uploads
			add_filter( 'upload_mimes', array( $this, 'allow_xml_uploads' ) );

			// Demos popup
			add_action( 'admin_footer', array( $this, 'popup' ) );
			
			// Filter for PRO demos available if Attesa PRO is not installed
			if ( !class_exists( 'Attesa_pro' ) ) {
				add_filter('awp_demos_data', array($this, 'get_demos_data_not_pro') );
			}

		}

		/**
		 * Register the AJAX methods
		 *
		 * @since 1.0.0
		 */
		public function init() {

			// Demos popup ajax
			add_action( 'wp_ajax_awp_ajax_get_demo_data', array( $this, 'ajax_demo_data' ) );
			add_action( 'wp_ajax_awp_ajax_required_plugins_activate', array( $this, 'ajax_required_plugins_activate' ) );

			// Get data to import
			add_action( 'wp_ajax_awp_ajax_get_import_data', array( $this, 'ajax_get_import_data' ) );

			// Import XML file
			add_action( 'wp_ajax_awp_ajax_import_xml', array( $this, 'ajax_import_xml' ) );

			// Import customizer settings
			add_action( 'wp_ajax_awp_ajax_import_theme_settings', array( $this, 'ajax_import_theme_settings' ) );

			// Import widgets
			add_action( 'wp_ajax_awp_ajax_import_widgets', array( $this, 'ajax_import_widgets' ) );

			// After import
			add_action( 'wp_ajax_awp_after_import', array( $this, 'ajax_after_import' ) );

		}

		/**
		 * Load scripts
		 *
		 * @since 1.4.5
		 */
		public static function scripts( $hook_suffix ) {

			if ( 'attesa-theme_page_install_demos' == $hook_suffix ) {

				// CSS
				wp_enqueue_style( 'awp-demos-style', plugins_url( '/assets/css/demos.min.css', __FILE__ ), array(), ATTESA_EXTRA_PLUGIN_VERSION );

				// JS
				wp_enqueue_script( 'awp-demos-js', plugins_url( '/assets/js/demos.min.js', __FILE__ ), array( 'jquery', 'wp-util', 'updates' ), ATTESA_EXTRA_PLUGIN_VERSION, true );

				wp_localize_script( 'awp-demos-js', 'awpDemos', array(
					'ajaxurl' 					=> admin_url( 'admin-ajax.php' ),
					'demo_data_nonce' 			=> wp_create_nonce( 'get-demo-data' ),
					'awp_import_data_nonce' 	=> wp_create_nonce( 'awp_import_data_nonce' ),
					'demo_plugins_activate_nonce' => wp_create_nonce( 'demo_plugins_activate_nonce' ),
					'content_importing_error' 	=> esc_html__( 'There was a problem during the importing process resulting in the following error from your server:', 'attesa-extra' ),
					'button_activating' 		=> esc_html__( 'Activating', 'attesa-extra' ) . '&hellip;',
					'button_active' 			=> esc_html__( 'Active', 'attesa-extra' ),
				) );

			}

		}

		/**
		 * Allows xml uploads so we can import from github
		 *
		 * @since 1.0.0
		 */
		public function allow_xml_uploads( $mimes ) {
			$mimes = array_merge( $mimes, array(
				'xml' 	=> 'application/xml'
			) );
			return $mimes;
		}

		/**
		 * Get demos data to add them in the Demo Import
		 *
		 * @since 1.4.5
		 */
		public static function get_demos_data() {

			// Demos url
			$url = 'https://attesawp.com/demo/';

			$data = array(
			
				'business' => array(
					'categories'        => array( 'Business' ),
					'is_what'			=> 'free',
					'xml_file'     		=> $url . 'business/sample-data-business.xml',
					'theme_settings' 	=> $url . 'business/business-export.dat',
					'widgets_file'  	=> $url . 'business/business-widgets.wie',
					'home_title'  		=> 'Home Page',
					'blog_title'  		=> 'Blog',
					'posts_to_show'  	=> '5',
					'elementor_width'  	=> '1140',
					'required_plugins'  => array(
						'free' => array(
							array(
								'slug'  	=> 'attesa-extra',
								'init'  	=> 'attesa-extra/attesa-extra.php',
								'name'  	=> 'Attesa Extra',
							),
							array(
								'slug'  	=> 'elementor',
								'init'  	=> 'elementor/elementor.php',
								'name'  	=> 'Elementor',
							),
							array(
								'slug'  	=> 'contact-form-7',
								'init'  	=> 'contact-form-7/wp-contact-form-7.php',
								'name'  	=> 'Contact Form 7',
							),
						),
					),
				),
				
				'blogging' => array(
					'categories'        => array( 'Blog' ),
					'is_what'			=> 'free',
					'xml_file'     		=> $url . 'blogging/sample-data-blogging.xml',
					'theme_settings' 	=> $url . 'blogging/blogging-export.dat',
					'widgets_file'  	=> $url . 'blogging/blogging-widgets.wie',
					'home_title'  		=> '',
					'blog_title'  		=> 'Blog',
					'posts_to_show'  	=> '5',
					'required_plugins'  => array(
						'free' => array(
							array(
								'slug'  	=> 'attesa-extra',
								'init'  	=> 'attesa-extra/attesa-extra.php',
								'name'  	=> 'Attesa Extra',
							),
							array(
								'slug'  	=> 'contact-form-7',
								'init'  	=> 'contact-form-7/wp-contact-form-7.php',
								'name'  	=> 'Contact Form 7',
							),
						),
					),
				),
				
				'minimal' => array(
					'categories'        => array( 'Personal', 'Blog' ),
					'is_what'			=> 'free',
					'xml_file'     		=> $url . 'minimal/sample-data-minimal.xml',
					'theme_settings' 	=> $url . 'minimal/minimal-export.dat',
					'widgets_file'  	=> $url . 'minimal/minimal-widgets.wie',
					'home_title'  		=> 'Home Page',
					'blog_title'  		=> 'Blog',
					'posts_to_show'  	=> '6',
					'elementor_width'  	=> '980',
					'required_plugins'  => array(
						'free' => array(
							array(
								'slug'  	=> 'attesa-extra',
								'init'  	=> 'attesa-extra/attesa-extra.php',
								'name'  	=> 'Attesa Extra',
							),
							array(
								'slug'  	=> 'elementor',
								'init'  	=> 'elementor/elementor.php',
								'name'  	=> 'Elementor',
							),
							array(
								'slug'  	=> 'contact-form-7',
								'init'  	=> 'contact-form-7/wp-contact-form-7.php',
								'name'  	=> 'Contact Form 7',
							),
						),
					),
				),

				'creative' => array(
					'categories'        => array( 'One Page', 'Blog' ),
					'is_what'			=> 'free',
					'xml_file'     		=> $url . 'creative/sample-data-creative.xml',
					'theme_settings' 	=> $url . 'creative/creative-export.dat',
					'widgets_file'  	=> $url . 'creative/creative-widgets.wie',
					'home_title'  		=> 'Home Page',
					'blog_title'  		=> 'Blog',
					'posts_to_show'  	=> '5',
					'elementor_width'  	=> '1140',
					'required_plugins'  => array(
						'free' => array(
							array(
								'slug'  	=> 'attesa-extra',
								'init'  	=> 'attesa-extra/attesa-extra.php',
								'name'  	=> 'Attesa Extra',
							),
							array(
								'slug'  	=> 'elementor',
								'init'  	=> 'elementor/elementor.php',
								'name'  	=> 'Elementor',
							),
							array(
								'slug'  	=> 'contact-form-7',
								'init'  	=> 'contact-form-7/wp-contact-form-7.php',
								'name'  	=> 'Contact Form 7',
							),
						),
					),
				),
				
				'fashion' => array(
					'categories'        => array( 'eCommerce', 'Blog', 'One Page' ),
					'is_what'			=> 'free',
					'xml_file'     		=> $url . 'fashion/sample-data-fashion.xml',
					'theme_settings' 	=> $url . 'fashion/fashion-export.dat',
					'widgets_file'  	=> $url . 'fashion/fashion-widgets.wie',
					'home_title'  		=> 'Home Page',
					'blog_title'  		=> 'Blog',
					'posts_to_show'  	=> '5',
					'elementor_width'  	=> '1140',
					'is_shop'  			=> true,
					'woo_image_size'  	=> '600',
					'woo_thumb_size' 	=> '300',
					'woo_crop_width'  	=> '3',
					'woo_crop_height' 	=> '3',
					'required_plugins'  => array(
						'free' => array(
							array(
								'slug'  	=> 'attesa-extra',
								'init'  	=> 'attesa-extra/attesa-extra.php',
								'name'  	=> 'Attesa Extra',
							),
							array(
								'slug'  	=> 'elementor',
								'init'  	=> 'elementor/elementor.php',
								'name'  	=> 'Elementor',
							),
							array(
								'slug'  	=> 'woocommerce',
								'init'  	=> 'woocommerce/woocommerce.php',
								'name'  	=> 'WooCommerce',
							),
							array(
								'slug'  	=> 'contact-form-7',
								'init'  	=> 'contact-form-7/wp-contact-form-7.php',
								'name'  	=> 'Contact Form 7',
							),
						),
					),
				),
				
				'friendly' => array(
					'categories'        => array( 'Personal', 'One Page' ),
					'is_what'			=> 'free',
					'xml_file'     		=> $url . 'friendly/sample-data-friendly.xml',
					'theme_settings' 	=> $url . 'friendly/friendly-export.dat',
					'widgets_file'  	=> $url . 'friendly/friendly-widgets.wie',
					'home_title'  		=> 'Home Page',
					'blog_title'  		=> '',
					'posts_to_show'  	=> '5',
					'elementor_width'  	=> '1140',
					'required_plugins'  => array(
						'free' => array(
							array(
								'slug'  	=> 'attesa-extra',
								'init'  	=> 'attesa-extra/attesa-extra.php',
								'name'  	=> 'Attesa Extra',
							),
							array(
								'slug'  	=> 'elementor',
								'init'  	=> 'elementor/elementor.php',
								'name'  	=> 'Elementor',
							),
							array(
								'slug'  	=> 'contact-form-7',
								'init'  	=> 'contact-form-7/wp-contact-form-7.php',
								'name'  	=> 'Contact Form 7',
							),
						),
					),
				),

			);

			// Return
			return apply_filters( 'awp_demos_data', $data );

		}
		
		/**
		 * Get demos name of the PRO version demos (without data) if Attesa PRO is not installed
		 *
		 * @since 1.0.0
		 */
		public static function get_demos_data_not_pro($data) {
			// Demos url
			$url = 'https://attesawp.com/demo/';
			
			$data['happiness'] = array(
				'categories'        => array( 'eCommerce', 'Blog', 'One Page', 'Personal' ),
				'is_what'			=> 'pro',
			);
			
			$data['folio'] = array(
				'categories'        => array( 'Portfolio', 'One Page', 'Business' ),
				'is_what'			=> 'pro',
			);
			
			$data['restaurant'] = array(
				'categories'        => array( 'One Page', 'Business' ),
				'is_what'			=> 'pro',
			);
			
			$data['travel'] = array(
				'categories'        => array( 'One Page', 'Blog', 'Personal' ),
				'is_what'			=> 'pro',
			);
			
			$data['reverse'] = array(
				'categories'        => array( 'One Page', 'Blog', 'Business' ),
				'is_what'			=> 'pro',
			);
			
			$data['bubba'] = array(
				'categories'        => array( 'Blog', 'Business' ),
				'is_what'			=> 'pro',
			);
			
			$data['clouds'] = array(
				'categories'        => array( 'Personal', 'Business', 'One Page' ),
				'is_what'			=> 'pro',
			);
			
			return $data;
		}
		
		/**
		 * Get the parameter is_what to check if is free or pro version theme
		 *
		 * @since 1.0.0
		 */
		public static function get_demo_theme_type( $item ) {
			if ( isset( $item['is_what'] ) ) {
				return $item['is_what'];
			}
			return false;
		}

		/**
		 * Get the category list of all categories used in the predefined demo imports array.
		 *
		 * @since 1.4.5
		 */
		public static function get_demo_all_categories( $demo_imports ) {
			$categories = array();

			foreach ( $demo_imports as $item ) {
				if ( ! empty( $item['categories'] ) && is_array( $item['categories'] ) ) {
					foreach ( $item['categories'] as $category ) {
						$categories[ sanitize_key( $category ) ] = $category;
					}
				}
			}

			if ( empty( $categories ) ) {
				return false;
			}

			return $categories;
		}

		/**
		 * Return the concatenated string of demo import item categories.
		 * These should be separated by comma and sanitized properly.
		 *
		 * @since 1.4.5
		 */
		public static function get_demo_item_categories( $item ) {
			$sanitized_categories = array();

			if ( isset( $item['categories'] ) ) {
				foreach ( $item['categories'] as $category ) {
					$sanitized_categories[] = sanitize_key( $category );
				}
			}

			if ( ! empty( $sanitized_categories ) ) {
				return implode( ',', $sanitized_categories );
			}

			return false;
		}

	    /**
	     * Demos popup
	     *
		 * @since 1.4.5
	     */
	    public static function popup() {
	    	global $pagenow;

	        // Display on the demos pages
	        if ( ( 'admin.php' == $pagenow && isset( $_GET['page']) && 'install_demos' == $_GET['page'] ) || ( 'admin.php' == $pagenow && isset( $_GET['page']) && 'install_demos' == $_GET['page'] ) ) { ?>
		        
		        <div id="awp-demo-popup-wrap">
					<div class="awp-demo-popup-container">
						<div class="awp-demo-popup-content-wrap">
							<div class="awp-demo-popup-content-inner">
								<a href="#" class="awp-demo-popup-close">×</a>
								<div id="awp-demo-popup-content"></div>
							</div>
						</div>
					</div>
					<div class="awp-demo-popup-overlay"></div>
				</div>

	    	<?php
	    	}
	    }

		/**
		 * Demos popup ajax.
		 *
		 * @since 1.4.5
		 */
		public static function ajax_demo_data() {

			if ( !current_user_can('manage_options')||! wp_verify_nonce( sanitize_key($_GET['demo_data_nonce']), 'get-demo-data' ) ) {
				die( 'This action was stopped for security purposes.' );
			}

			// Database reset url
			if ( is_plugin_active( 'wp-reset/wp-reset.php' ) ) {
				$plugin_link 	= admin_url( 'tools.php?page=wp-reset' );
			} else {
				$plugin_link 	= admin_url( 'plugin-install.php?s=WP+Database+Reset&tab=search' );
			}

			// Get all demos
			$demos = self::get_demos_data();

			// Get selected demo
			$demo = $_GET['demo_name'];

			// Get required plugins
			$plugins = $demos[$demo][ 'required_plugins' ];
			
			// Get free or pro demo content
			$iswhat = $demos[$demo][ 'is_what' ];

			// Get free plugins
			$free = $plugins[ 'free' ]; ?>

			<?php if($iswhat == 'pro' && !class_exists( 'Attesa_pro' ) ): ?>
				<div id="awp-demo-plugins">
					
					<h2 class="title"><?php
					/* translators: name of the demo */
					echo sprintf( esc_html__( 'Import the %1$s demo', 'attesa-extra' ), esc_attr( $demo ) );
					?></h2>
					
					<div class="awp-popup-text">
					
						<p><?php esc_html_e( 'This demo cannot be imported because it contains features available with "Attesa PRO" addon.', 'attesa-extra' ); ?></p>
						<p><?php esc_html_e( 'Get "Attesa PRO" plugin and install it on your WordPress website to import this demo and many others.', 'attesa-extra' ); ?></p>
						
						<div class="awp-required-plugins-wrap">
						
							<h3><?php esc_html_e( 'Get Attesa PRO Addon', 'attesa-extra' ); ?></h3>
							
							<div class="awp-required-plugins oe-plugin-installer">
							
								<div class="awp-plugin awp-clr awp-plugin-attesa-pro" data-slug="attesa-pro">
								
									<h2><?php esc_html_e( 'Attesa PRO', 'attesa-extra' ); ?></h2>
									
									<a class="button" href="https://attesawp.com/pricing/" target="_blank"><?php esc_html_e( 'Get This Addon', 'attesa-extra' ); ?></a>
									
								</div>
								
							</div>
							
						</div>
						
					</div>
					
				</div>
			<?php else: ?>
				<div id="awp-demo-plugins">

					<h2 class="title"><?php
					/* translators: name of the demo */
					echo sprintf( esc_html__( 'Import the %1$s demo', 'attesa-extra' ), esc_attr( $demo ) );
					?></h2>

					<div class="awp-popup-text">

						<p><?php echo
							sprintf(
								/* translators: 1: start link, 2: end link */
								esc_html__( 'Importing demo data allow you to quickly edit everything instead of creating content from scratch. It is recommended uploading sample data on a fresh WordPress install to prevent conflicts with your current content. You can use this plugin to reset your site if needed: %1$sWordpress Database Reset%2$s.', 'attesa-extra' ),
								'<a href="'. esc_attr($plugin_link) .'" target="_blank">',
								'</a>'
							); ?></p>

						<div class="awp-required-plugins-wrap">
							<h3><?php esc_html_e( 'Required Plugins', 'attesa-extra' ); ?></h3>
							<p><?php esc_html_e( 'For your site to look exactly like this demo, the plugins below need to be activated.', 'attesa-extra' ); ?></p>
							<div class="awp-required-plugins oe-plugin-installer">
								<?php
								self::required_plugins( $free, 'free' ); ?>
							</div>
						</div>

					</div>

					<a class="awp-button awp-plugins-next" href="#"><?php esc_html_e( 'Go to the next step', 'attesa-extra' ); ?></a>

				</div>

				<form method="post" id="awp-demo-import-form">

					<input id="awp_import_demo" type="hidden" name="awp_import_demo" value="<?php echo esc_attr( $demo ); ?>" />

					<div class="awp-demo-import-form-types">

						<h2 class="title"><?php esc_html_e( 'Select what you want to import:', 'attesa-extra' ); ?></h2>
						
						<ul class="awp-popup-text">
							<li>
								<label for="awp_import_xml">
									<input id="awp_import_xml" type="checkbox" name="awp_import_xml" checked="checked" />
									<strong><?php esc_html_e( 'Import XML Data', 'attesa-extra' ); ?></strong> (<?php esc_html_e( 'pages, posts, images, menus, etc...', 'attesa-extra' ); ?>)
								</label>
							</li>

							<li>
								<label for="awp_theme_settings">
									<input id="awp_theme_settings" type="checkbox" name="awp_theme_settings" checked="checked" />
									<strong><?php esc_html_e( 'Import Customizer Settings', 'attesa-extra' ); ?></strong>
								</label>
							</li>

							<li>
								<label for="awp_import_widgets">
									<input id="awp_import_widgets" type="checkbox" name="awp_import_widgets" checked="checked" />
									<strong><?php esc_html_e( 'Import Widgets', 'attesa-extra' ); ?></strong>
								</label>
							</li>
							
						</ul>

					</div>
					
					<?php wp_nonce_field( 'awp_import_demo_data_nonce', 'awp_import_demo_data_nonce' ); ?>
					<input type="submit" name="submit" class="awp-button awp-import" value="<?php esc_html_e( 'Install this demo', 'attesa-extra' ); ?>"  />

				</form>

				<div class="awp-loader">
					<h2 class="title"><?php esc_html_e( 'The import process could take some time, please be patient', 'attesa-extra' ); ?></h2>
					<div class="awp-import-status awp-popup-text"></div>
				</div>

				<div class="awp-last">
					<svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52"><circle class="checkmark-circle" cx="26" cy="26" r="25" fill="none"></circle><path class="checkmark-check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8"></path></svg>
					<h3><?php esc_html_e( 'Demo Imported!', 'attesa-extra' ); ?></h3>
					<a href="<?php echo esc_url( get_home_url() ); ?>"" target="_blank"><?php esc_html_e( 'See the result', 'attesa-extra' ); ?></a>
				</div>
			<?php endif; ?>

			<?php
			die();
		}

		/**
		 * Required plugins.
		 *
		 * @since 1.4.5
		 */
		public static function required_plugins( $plugins, $return ) {

			foreach ( $plugins as $key => $plugin ) {

				$api = array(
					'slug' 	=> isset( $plugin['slug'] ) ? $plugin['slug'] : '',
					'init' 	=> isset( $plugin['init'] ) ? $plugin['init'] : '',
					'name' 	=> isset( $plugin['name'] ) ? $plugin['name'] : '',
				);

				if ( ! is_wp_error( $api ) ) { // confirm error free

					// Installed but Inactive.
					if ( file_exists( WP_PLUGIN_DIR . '/' . $plugin['init'] ) && is_plugin_inactive( $plugin['init'] ) ) {

						$button_classes = 'button activate-now button-primary';
						$button_text 	= esc_html__( 'Activate', 'attesa-extra' );

					// Not Installed.
					} elseif ( ! file_exists( WP_PLUGIN_DIR . '/' . $plugin['init'] ) ) {

						$button_classes = 'button install-now';
						$button_text 	= esc_html__( 'Install Now', 'attesa-extra' );

					// Active.
					} else {
						$button_classes = 'button disabled';
						$button_text 	= esc_html__( 'Activated', 'attesa-extra' );
					} ?>

					<div class="awp-plugin awp-clr awp-plugin-<?php echo esc_attr($api['slug']); ?>" data-slug="<?php echo esc_attr($api['slug']); ?>" data-init="<?php echo esc_attr($api['init']); ?>">
						<h2><?php echo esc_html($api['name']); ?></h2>
						<button class="<?php echo esc_attr($button_classes); ?>" data-init="<?php echo esc_attr($api['init']); ?>" data-slug="<?php echo esc_attr($api['slug']); ?>" data-name="<?php echo esc_attr($api['name']); ?>"><?php echo esc_html($button_text); ?></button>
					</div>

				<?php
				}
			}

		}

		/**
		 * Required plugins activate
		 *
		 * @since 1.4.5
		 */
		public function ajax_required_plugins_activate() {

			if ( ! isset( $_POST['_wpnonce'] ) || ! wp_verify_nonce( $_POST['_wpnonce'], 'demo_plugins_activate_nonce' ) ) {
				die( 'Permission check failed' );
			}

			if ( ! current_user_can( 'install_plugins' ) || ! isset( $_POST['init'] ) || ! $_POST['init'] ) {
				wp_send_json_error(
					array(
						'success' => false,
						'message' => __( 'No plugin specified', 'attesa-extra' ),
					)
				);
			}

			$plugin_init = ( isset( $_POST['init'] ) ) ? esc_attr( $_POST['init'] ) : '';
			$activate 	 = activate_plugin( $plugin_init, '', false, true );

			if ( is_wp_error( $activate ) ) {
				wp_send_json_error(
					array(
						'success' => false,
						'message' => $activate->get_error_message(),
					)
				);
			}

			wp_send_json_success(
				array(
					'success' => true,
					'message' => __( 'Plugin Successfully Activated', 'attesa-extra' ),
				)
			);

		}

		/**
		 * Returns an array containing all the importable content
		 *
		 * @since 1.4.5
		 */
		public function ajax_get_import_data() {
			if (!current_user_can('manage_options')) {
				die( 'This action was stopped for security purposes.' );
			}
			check_ajax_referer( 'awp_import_data_nonce', 'security' );

			echo json_encode( 
				array(
					array(
						'input_name' 	=> 'awp_import_xml',
						'action' 		=> 'awp_ajax_import_xml',
						'method' 		=> 'ajax_import_xml',
						'loader' 		=> esc_html__( 'Importing XML Data', 'attesa-extra' )
					),

					array(
						'input_name' 	=> 'awp_theme_settings',
						'action' 		=> 'awp_ajax_import_theme_settings',
						'method' 		=> 'ajax_import_theme_settings',
						'loader' 		=> esc_html__( 'Importing Customizer Settings', 'attesa-extra' )
					),

					array(
						'input_name' 	=> 'awp_import_widgets',
						'action' 		=> 'awp_ajax_import_widgets',
						'method' 		=> 'ajax_import_widgets',
						'loader' 		=> esc_html__( 'Importing Widgets', 'attesa-extra' )
					),

				)
			);

			die();
		}

		/**
		 * Import XML file
		 *
		 * @since 1.4.5
		 */
		public function ajax_import_xml() {
			if ( !current_user_can('manage_options') || !wp_verify_nonce( sanitize_key($_POST['awp_import_demo_data_nonce']), 'awp_import_demo_data_nonce' ) ) {
				die( 'This action was stopped for security purposes.' );
			}

			// Get the selected demo
			$demo_type 			= $_POST['awp_import_demo'];

			// Get demos data
			$demo 				= AttesaWP_Demos::get_demos_data()[ $demo_type ];

			// Content file
			$xml_file 			= isset( $demo['xml_file'] ) ? $demo['xml_file'] : '';

			// Delete the default post and page
			$sample_page 		= get_page_by_path( 'sample-page', OBJECT, 'page' );
			$hello_world_post 	= get_page_by_path( 'hello-world', OBJECT, 'post' );

			if ( ! is_null( $sample_page ) ) {
				wp_delete_post( $sample_page->ID, true );
			}

			if ( ! is_null( $hello_world_post ) ) {
				wp_delete_post( $hello_world_post->ID, true );
			}

			// Import Posts, Pages, Images, Menus.
			$result = $this->process_xml( $xml_file );

			if ( is_wp_error( $result ) ) {
				echo json_encode( $result->errors );
			} else {
				echo 'successful import';
			}

			die();
		}

		/**
		 * Import customizer settings
		 *
		 * @since 1.4.5
		 */
		public function ajax_import_theme_settings() {
			if ( !current_user_can('manage_options') || !wp_verify_nonce( sanitize_key($_POST['awp_import_demo_data_nonce']), 'awp_import_demo_data_nonce' ) ) {
				die( 'This action was stopped for security purposes.' );
			}

			// Include settings importer
			include AE_PATH . '/panel/classes/importers/class-settings-importer.php';

			// Get the selected demo
			$demo_type 			= $_POST['awp_import_demo'];

			// Get demos data
			$demo 				= AttesaWP_Demos::get_demos_data()[ $demo_type ];

			// Settings file
			$theme_settings 	= isset( $demo['theme_settings'] ) ? $demo['theme_settings'] : '';

			// Import settings.
			$settings_importer = new AWP_Settings_Importer();
			$result = $settings_importer->process_import_file( $theme_settings );
			
			if ( is_wp_error( $result ) ) {
				echo json_encode( $result->errors );
			} else {
				echo 'successful import';
			}

			die();
		}

		/**
		 * Import widgets
		 *
		 * @since 1.4.5
		 */
		public function ajax_import_widgets() {
			if ( !current_user_can('manage_options') ||! wp_verify_nonce( sanitize_key($_POST['awp_import_demo_data_nonce']), 'awp_import_demo_data_nonce' ) ) {
				die( 'This action was stopped for security purposes.' );
			}

			// Include widget importer
			include AE_PATH . 'panel/classes/importers/class-widget-importer.php';

			// Get the selected demo
			$demo_type 			= $_POST['awp_import_demo'];

			// Get demos data
			$demo 				= AttesaWP_Demos::get_demos_data()[ $demo_type ];

			// Widgets file
			$widgets_file 		= isset( $demo['widgets_file'] ) ? $demo['widgets_file'] : '';

			// Import settings.
			$widgets_importer = new AWP_Widget_Importer();
			$result = $widgets_importer->process_import_file( $widgets_file );
			
			if ( is_wp_error( $result ) ) {
				echo json_encode( $result->errors );
			} else {
				echo 'successful import';
			}

			die();
		}

		/**
		 * After import
		 *
		 * @since 1.4.5
		 */
		public function ajax_after_import() {
			if ( !current_user_can('manage_options') || ! wp_verify_nonce( sanitize_key($_POST['awp_import_demo_data_nonce']), 'awp_import_demo_data_nonce' ) ) {
				die( 'This action was stopped for security purposes.' );
			}

			// If XML file is imported
			if ( $_POST['awp_import_is_xml'] === 'true' ) {

				// Get the selected demo
				$demo_type 			= $_POST['awp_import_demo'];

				// Get demos data
				$demo 				= AttesaWP_Demos::get_demos_data()[ $demo_type ];

				// Elementor width setting
				$elementor_width 	= isset( $demo['elementor_width'] ) ? $demo['elementor_width'] : '';

				// Reading settings
				$homepage_title 	= isset( $demo['home_title'] ) ? $demo['home_title'] : 'Home';
				$blog_title 		= isset( $demo['blog_title'] ) ? $demo['blog_title'] : '';

				// Posts to show on the blog page
				$posts_to_show 		= isset( $demo['posts_to_show'] ) ? $demo['posts_to_show'] : '';

				// If shop demo
				$shop_demo 			= isset( $demo['is_shop'] ) ? $demo['is_shop'] : false;

				// Product image size
				$image_size 		= isset( $demo['woo_image_size'] ) ? $demo['woo_image_size'] : '';
				$thumbnail_size 	= isset( $demo['woo_thumb_size'] ) ? $demo['woo_thumb_size'] : '';
				$crop_width 		= isset( $demo['woo_crop_width'] ) ? $demo['woo_crop_width'] : '';
				$crop_height 		= isset( $demo['woo_crop_height'] ) ? $demo['woo_crop_height'] : '';

				// Assign WooCommerce pages if WooCommerce Exists
				if ( class_exists( 'WooCommerce' ) && true == $shop_demo ) {

					$woopages = array(
						'woocommerce_shop_page_id' 				=> 'Shop',
						'woocommerce_cart_page_id' 				=> 'Cart',
						'woocommerce_checkout_page_id' 			=> 'Checkout',
						'woocommerce_pay_page_id' 				=> 'Checkout &#8594; Pay',
						'woocommerce_thanks_page_id' 			=> 'Order Received',
						'woocommerce_myaccount_page_id' 		=> 'My Account',
						'woocommerce_edit_address_page_id' 		=> 'Edit My Address',
						'woocommerce_view_order_page_id' 		=> 'View Order',
						'woocommerce_change_password_page_id' 	=> 'Change Password',
						'woocommerce_logout_page_id' 			=> 'Logout',
						'woocommerce_lost_password_page_id' 	=> 'Lost Password'
					);

					foreach ( $woopages as $woo_page_name => $woo_page_title ) {

						$woopage = get_page_by_title( $woo_page_title );
						if ( isset( $woopage ) && $woopage->ID ) {
							update_option( $woo_page_name, $woopage->ID );
						}

					}

					// We no longer need to install pages
					delete_option( '_wc_needs_pages' );
					delete_transient( '_wc_activation_redirect' );

					// Get products image size
					update_option( 'woocommerce_single_image_width', $image_size );
					update_option( 'woocommerce_thumbnail_image_width', $thumbnail_size );
					update_option( 'woocommerce_thumbnail_cropping', 'custom' );
					update_option( 'woocommerce_thumbnail_cropping_custom_width', $crop_width );
					update_option( 'woocommerce_thumbnail_cropping_custom_height', $crop_height );

				}

				// Set imported menus to registered theme locations
				$locations 	= get_theme_mod( 'nav_menu_locations' );
				$menus 		= wp_get_nav_menus();

				if ( $menus ) {
					
					foreach ( $menus as $menu ) {

						if ( $menu->name == 'Main Menu' ) {
							$locations['main'] = $menu->term_id;
						} else if ( $menu->name == 'Top Menu' ) {
							$locations['top'] = $menu->term_id;
						} else if ( $menu->name == 'Footer Menu' ) {
							$locations['footer'] = $menu->term_id;
						}
					}

				}

				// Set menus to locations
				set_theme_mod( 'nav_menu_locations', $locations );

				// Disable Elementor default settings
				update_option( 'elementor_disable_color_schemes', 'yes' );
				update_option( 'elementor_disable_typography_schemes', 'yes' );
			    if ( ! empty( $elementor_width ) ) {
					update_option( 'elementor_container_width', $elementor_width );
				}

				// Assign front page and posts page (blog page).
			    $home_page = get_page_by_title( $homepage_title );
			    $blog_page = get_page_by_title( $blog_title );

			    update_option( 'show_on_front', 'page' );

			    if ( is_object( $home_page ) ) {
					update_option( 'page_on_front', $home_page->ID );
				}

				if ( is_object( $blog_page ) ) {
					update_option( 'page_for_posts', $blog_page->ID );
				}

				// Posts to show on the blog page
			    if ( ! empty( $posts_to_show ) ) {
					update_option( 'posts_per_page', $posts_to_show );
				}
				
			}

			die();
		}

		/**
		 * Import XML data
		 *
		 * @since 1.0.0
		 */
		public function process_xml( $file ) {
			
			$response = AWP_Demos_Helpers::get_remote( $file );

			// No sample data found
			if ( $response === false ) {
				return new WP_Error( 'xml_import_error', __( 'Can not retrieve sample data xml file. AttesaWP.com may be down at the moment please try again later. If you still have issues contact the theme developer for assistance.', 'attesa-extra' ) );
			}

			// Write sample data content to temp xml file
			$temp_xml = AE_PATH .'panel/classes/importers/temp.xml';
			file_put_contents( $temp_xml, $response );

			// Set temp xml to attachment url for use
			$attachment_url = $temp_xml;

			// If file exists lets import it
			if ( file_exists( $attachment_url ) ) {
				$this->import_xml( $attachment_url );
			} else {
				// Import file can't be imported - we should die here since this is core for most people.
				return new WP_Error( 'xml_import_error', __( 'The xml import file could not be accessed. Please try again or contact the theme developer.', 'attesa-extra' ) );
			}

		}
		
		/**
		 * Import XML file
		 *
		 * @since 1.0.0
		 */
		private function import_xml( $file ) {

			// Make sure importers constant is defined
			if ( ! defined( 'WP_LOAD_IMPORTERS' ) ) {
				define( 'WP_LOAD_IMPORTERS', true );
			}

			// Import file location
			$import_file = ABSPATH . 'wp-admin/includes/import.php';

			// Include import file
			if ( ! file_exists( $import_file ) ) {
				return;
			}

			// Include import file
			require_once( $import_file );

			// Define error var
			$importer_error = false;

			if ( ! class_exists( 'WP_Importer' ) ) {
				$class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';

				if ( file_exists( $class_wp_importer ) ) {
					require_once $class_wp_importer;
				} else {
					$importer_error = __( 'Can not retrieve class-wp-importer.php', 'attesa-extra' );
				}
			}

			if ( ! class_exists( 'WP_Import' ) ) {
				$class_wp_import = AE_PATH . 'panel/classes/importers/class-wordpress-importer.php';

				if ( file_exists( $class_wp_import ) ) {
					require_once $class_wp_import;
				} else {
					$importer_error = __( 'Can not retrieve wordpress-importer.php', 'attesa-extra' );
				}
			}

			// Display error
			if ( $importer_error ) {
				return new WP_Error( 'xml_import_error', $importer_error );
			} else {

				// No error, lets import things...
				if ( ! is_file( $file ) ) {
					$importer_error = __( 'Sample data file appears corrupt or can not be accessed.', 'attesa-extra' );
					return new WP_Error( 'xml_import_error', $importer_error );
				} else {
					$importer = new WP_Import();
					$importer->fetch_attachments = true;
					$importer->import( $file );

					// Clear sample data content from temp xml file
					$temp_xml = AE_PATH .'panel/classes/importers/temp.xml';
					file_put_contents( $temp_xml, '' );
				}
			}
		}

	}

}
new AttesaWP_Demos();