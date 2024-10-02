<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
function Attesa_Custom_Templates() {
	return Attesa_Custom_Templates::instance();
}

Attesa_Custom_Templates();
final class Attesa_Custom_Templates {
	private static $_instance = null;
	
	public function __construct() {
		add_action( 'init', array( $this, 'attesaextra_register_taxonomies' ) );
		add_action( 'admin_menu', array( $this, 'attesaextra_templates_menu' ), 11 );
		add_action('add_meta_boxes', array( $this, 'register_meta_box' ) );
		add_filter('manage_attesa_templates_posts_columns', array($this, 'register_templates_column' ) );
		add_action('manage_attesa_templates_posts_custom_column', array($this, 'write_in_templates_column' ), 10, 2 );
		add_shortcode( 'attesa-template', array($this, 'attesa_templates_shortcode' ) );
	}
	
	public function attesaextra_register_taxonomies() {
		$this->register_attesa_templates();
	}
	
	protected function register_attesa_templates() {
		$labels = array(
			'name'               => _x( 'Attesa Templates', 'post type general name', 'attesa-extra' ),
			'singular_name'      => _x( 'Template', 'post type singular name', 'attesa-extra' ),
			'menu_name'          => _x( 'Templates', 'admin menu', 'attesa-extra' ),
			'name_admin_bar'     => _x( 'Templates', 'add new on admin bar', 'attesa-extra' ),
			'add_new'            => _x( 'Add New', 'template', 'attesa-extra' ),
			'add_new_item'       => __('Add New Template', 'attesa-extra'),
			'new_item'           => __('New Template', 'attesa-extra'),
			'edit_item'          => __('Edit Template', 'attesa-extra'),
			'all_items'          => __('All Templates', 'attesa-extra'),
			'view_item'          => __('View Template', 'attesa-extra'),
			'search_items'       => __('Search Templates', 'attesa-extra'),
			'not_found'          => __('No Template found', 'attesa-extra'),
			'not_found_in_trash' => __('No Template found in trash', 'attesa-extra'),
		);
		$args = array(
			'labels' 				=> $labels,
			'public' 					=> true,
			'hierarchical'          	=> false,
			'show_ui'               	=> true,
			'show_in_menu' 				=> false,
			'show_in_nav_menus'     	=> false,
			'can_export'            	=> true,
			'exclude_from_search'   	=> true,
			'capability_type' 			=> 'post',
			'rewrite' 					=> false,
			'show_in_rest' 				=> true,
			'supports' 					=> array( 'title', 'editor', 'thumbnail', 'author', 'elementor' ),
		);
	   register_post_type('attesa_templates', $args);
	}
	
	public function attesaextra_templates_menu() {
		add_submenu_page(
		'attesa-welcome',
		esc_html__( 'Attesa Templates', 'attesa-extra' ),
		esc_html__( 'Custom Templates', 'attesa-extra' ),
		'manage_options',
		'edit.php?post_type=attesa_templates'); 
	}
	
	public function register_meta_box($post) {
		add_meta_box(
			'attesa-extra-templates-shortcode',
			esc_html__( 'Template Shortcode', 'attesa-extra' ),
			array( $this, 'metabox_options' ),
			'attesa_templates',
			'side',
			'high',
			null
		);
	}
	
	public function metabox_options($post) {
		?>
		<div class="attesa-extra-templates-shortocode">
			<input type="text" id="templates-shortcode" class="widefat" readonly="readonly" value="[attesa-template id=&quot;<?php echo intval($post->ID); ?>&quot;]" />
		</div>
		<?php
	}
	
	public function register_templates_column($columns) {
		unset($columns['date']);
		return array_merge($columns, 
            array(
				'show_attesa_templates' => __('Template Shortcode', 'attesa-extra')
			)
		);
	}
	
	public function write_in_templates_column($column_name, $post_id) {
		if ( $column_name == 'show_attesa_templates') {
			echo '<input type="text" id="templates-shortcode" class="widefat" readonly="readonly" value="[attesa-template id=&quot;'.intval($post_id).'&quot;]" />';
		}
	}
	
	public function attesa_templates_shortcode($atts, $content = null) {
		$atts = shortcode_atts( array(
			'id' => '',
		), $atts, 'attesa-template' );

		ob_start();
		
		if ( $atts[ 'id' ] ) {
			$elementor  = get_post_meta( $atts[ 'id' ], '_elementor_edit_mode', true );
			if ( class_exists( 'Elementor\Plugin' ) && $elementor ) {

				echo Elementor\Plugin::instance()->frontend->get_builder_content_for_display( $atts[ 'id' ] );

			} else if ( class_exists( 'FLBuilder' ) && ! empty( $atts[ 'id' ] ) ) {

				echo do_shortcode( '[fl_builder_insert_layout id="' . $atts[ 'id' ] . '"]' );

			} else {
				
				$content = $atts[ 'id' ];

				if ( ! empty( $content ) ) {

					$template = get_post( $content );

					if ( $template && ! is_wp_error( $template ) ) {
						$content = $template->post_content;
					}

				}

				echo do_shortcode( $content );

			}
		}
		return ob_get_clean();
	}
	
	
	public static function instance() {
		if ( is_null( self::$_instance ) )
			self::$_instance = new self();
		return self::$_instance;
	}
	
	public function __clone() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'attesa-extra' ), '1.0.0' );
	}

	public function __wakeup() {
		_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'attesa-extra' ), '1.0.0' );
	}
} // End Class