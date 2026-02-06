<?php
/**
 * Plugin Name: Attesa Extra
 * Plugin URI: https://attesawp.com/
 * Description: Add extra features to Attesa WordPress Theme.
 * Version: 1.4.7
 * Author: AttesaWP
 * Author URI: https://attesawp.com/about/
 * Domain Path: /languages
 * Text Domain: attesa-extra
 * License: GPL2
 */
 
/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function Attesa_extra() {
	return Attesa_extra::instance();
}

Attesa_extra();

final class Attesa_extra {
	private static $_instance = null;
	private $plugin_path;
	public function __construct() {
		$this->plugin_path = plugin_dir_path( __FILE__ );
		define( 'ATTESA_EXTRA_PLUGIN_VERSION', '1.4.7' );
		define( 'AE_PATH', $this->plugin_path );
		if ($this->attesaextra_check_load()) {
			add_action( 'after_setup_theme', array($this, 'attesaextra_add_image_size' ));
			require_once dirname( __FILE__ ) .'/metabox/functions.php';
			require_once dirname( __FILE__ ) .'/metabox/hooks.php';
			add_action( 'init', array( $this, 'setup' ) );
			require_once dirname( __FILE__ ) .'/panel/attesa-custom-templates.php';
			add_filter( 'plugin_row_meta', array($this, 'attesaextra_add_meta_links'), 10 , 2 );
			add_action( 'widgets_init', array( $this, 'custom_widgets' ), 10 );
			add_action( 'init', array($this, 'attesaextra_actions') );
		}
		// Allow shortcodes in text widgets
		add_filter( 'widget_text', 'do_shortcode' );
		add_action( 'plugins_loaded', array($this, 'attesaextra_load_plugin') );
	}
	/* Check if Attesa or parent theme is active */
	public function attesaextra_check_load() {
		$theme = wp_get_theme();
		if ('Attesa' == $theme->name || 'attesa' == $theme->template ) {
			return true;
		}
		return false;
	}
	/* Setup */
	public function setup() {
		require_once dirname( __FILE__ ) .'/metabox/butterbean/butterbean.php';
		require_once dirname( __FILE__ ) .'/metabox/metabox.php';
		require_once dirname( __FILE__ ) .'/metabox/shortcodes.php';
		require_once dirname( __FILE__ ) .'/customizer/customizer.php';
		require_once dirname( __FILE__ ) .'/customizer/functions.php';
		require_once dirname( __FILE__ ) .'/panel/attesa-admin-page.php';
		require_once dirname( __FILE__ ) .'/panel/demos.php';
		if ( !class_exists( 'Attesa_pro' ) ) {
			require_once dirname( __FILE__ ) .'/panel/attesa-pro-features.php';
		}
		/* Check if Elementor plugin is installed */
		if ( in_array( 'elementor/elementor.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			require_once dirname( __FILE__ ) .'/elementor/widgets.php';
			require_once dirname( __FILE__ ) .'/elementor/compatibility/wpml_compatibility.php';
		}
		add_action( 'init', array( $this, 'register_custom_js' ) );
		add_action( 'wp_head', array( $this, 'custom_js_head' ), 9999 );
		add_action( 'wp_footer', array( $this, 'custom_js_footer' ), 9999 );
		add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), array($this, 'attesaextra_add_install_demos_link') );
	}
	/* Register custom widgets */
	public static function custom_widgets() {
		if (function_exists('attesa_options')) {
			require_once dirname( __FILE__ ) .'/widgets/recent-post.php';
			require_once dirname( __FILE__ ) .'/widgets/latest-comments.php';
			require_once dirname( __FILE__ ) .'/widgets/random-post.php';
			require_once dirname( __FILE__ ) .'/widgets/social-buttons.php';
		}
	}
	/* Register custom code for header and footer */
	public function register_custom_js() {
		require_once dirname( __FILE__ ) .'/panel/custom-code.php';
	}
	/* Add extra link to the meta plugin */
	public function attesaextra_add_meta_links( $links, $file ) {
		if ( strpos( $file, 'attesa-extra.php' ) !== false && !class_exists( 'Attesa_pro' ) ) {
			$new_links = array(
				'<a style="font-weight:bold;" href="https://attesawp.com/attesa-pro/" target="_blank" rel="external" ><span class="dashicons dashicons-star-filled"></span> ' . esc_html__( 'Get Attesa PRO Addon', 'attesa-extra' ) . '</a>', 
			);
			$links = array_merge( $links, $new_links );
		}
		return $links;
	}
	/* Add Install Demos link */
	public function attesaextra_add_install_demos_link($links) { 
		$demos_link = array(
			'<a href="' . admin_url('admin.php?page=install_demos') . '">' . esc_html__( 'Install Demos','attesa-extra') . '</a>',
		);
		return array_merge( $links, $demos_link );
	}
	/* Add or Remove action from Attesa Theme */
	public function attesaextra_actions() {
		remove_action('attesa_footer_widgets', 'attesa_get_footer_widgets');
		add_action('attesa_footer_widgets', 'attesaextra_get_footer');
		remove_action('attesa_header', 'attesa_get_header');
		add_action('attesa_header', 'attesaextra_get_header');
		remove_action('attesa_entry_header', 'attesa_get_entry_header');
		add_action('attesa_entry_header', 'attesaextra_get_entry_header');
	}
	/* Load text domain and check for admin notices */
	public function attesaextra_load_plugin() {
		load_plugin_textdomain( 'attesa-extra', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
		if (!$this->attesaextra_check_load()) {
			add_action( 'admin_notices', array($this, 'attesaextra_fail_load' ));
		}
	}
	/* Admin notices if Attesa theme is not installed or active */
	public function attesaextra_fail_load() {
		$screen = get_current_screen();
		if ( isset( $screen->parent_file ) && 'plugins.php' === $screen->parent_file && 'update' === $screen->id ) {
			return;
		}
		if ( ! current_user_can( 'install_themes' ) ) {
			return;
		}
		$activation_url = admin_url( 'theme-install.php?search=attesa');
		$message = '<p>' . esc_html__( 'Attesa Extra plugin is not working because you need to activate Attesa theme.', 'attesa-extra' ) . '</p>';
		$message .= '<p>' . sprintf( '<a href="%s" class="button-primary">%s</a>', esc_url($activation_url), esc_html__( 'Activate Attesa theme', 'attesa-extra' ) ) . '</p>';
		echo '<div class="notice notice-warning attesa-extra"><p>' . $message . '</p></div>'; //$message is escaped
	}
	/* Add custom js in header */
	public static function custom_js_head( $output = NULL ) {
		$output = apply_filters( 'attesa_header_code', $output );
		if ( ! empty( $output ) ) { ?>
			<script type="text/javascript">
				<?php echo $output; ?>
			</script>
			<?php
		}
	}
	/* Add custom js in footer */
	public static function custom_js_footer( $output = NULL ) {
		$output = apply_filters( 'attesa_footer_code', $output );
		if ( ! empty( $output ) ) { ?>
			<script type="text/javascript">
				<?php echo $output; ?>
			</script>
			<?php
		}
	}
	/* Load this file after setup theme */
	public function attesaextra_add_image_size() {
		add_image_size( 'attesa-box-small', 70, 70, true);
	}
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'attesa-extra' ), '1.0.0' );
	}
	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'attesa-extra' ), '1.0.0' );
	}
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	}
}