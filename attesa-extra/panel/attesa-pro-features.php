<?php
/**
 * Attesa Pro Features Class.
 * @author  AttesaWP
 * @package Attesa
 * @since   1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Attesa_Pro_Features' ) ) :
/**
 * Attesa_Pro_Features Class.
 */
class Attesa_Pro_Features {
	protected $_menu_parent = '';
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ), 999 );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
	}
	/**
	 * Enqueue styles.
	 */
	public function enqueue_admin_scripts($hook) {
		if ( 'attesa-theme_page_attesa_pro_features' != $hook ) {
			return;
		}
		wp_enqueue_style( 'attesa-pro-features', plugins_url('assets/css/pro-features.css',__FILE__), array(), ATTESA_EXTRA_PLUGIN_VERSION);
	}
	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		add_submenu_page(
			'attesa-welcome',
			esc_html__( 'Attesa PRO addon', 'attesa-attesa' ),
			'<span class="dashicons dashicons-star-filled" style="font-size: 16px; color: greenyellow;"></span> <span style="color: greenyellow; font-weight: 700;">' . esc_html__( 'PRO Features', 'attesa-extra' ) . '</span>',
			'manage_options',
			'attesa_pro_features',
			array( $this, 'pro_features_screen' )
		);
	}
	/**
	 * Output the PRO features screen.
	 */
	public function pro_features_screen() {
		?>
		<div class="wrap about-wrap">
			<h1><?php esc_html_e('Attesa PRO Addon', 'attesa-extra'); ?></h1>
			<h4><?php esc_html_e('Attesa PRO is a plugin that extends free Attesa theme & Attesa Extra plugin and adds more functions and features', 'attesa-extra'); ?></h4>
			<div class="under-the-hood two-col">
				<div class="attesa-get-pro">
					<a href="https://attesawp.com/attesa-pro/" target="_blank"><?php esc_html_e( 'Get Attesa PRO addon', 'attesa-extra' ); ?></a>
				</div>
				<div class="attesa-pro-col">
					<div class="col">
						<h3><?php esc_html_e('PRO Demos available', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('In addition to free demos, you can also import PRO demos.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/pro-demos.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Elementor Widgets', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Many exclusive Elementor Widgets to personalize your pages.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/elementor-widgets.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Icons in the menus', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Insert icons next to the items in each of your menus.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/menu-icons.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Create custom portfolios', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Show your projects to your audience by creating portfolios.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/attesa-portfolios.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Sticky Sidebar', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Make your sidebar permanently visible while scrolling.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/sticky-sidebar.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Masonry posts style', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Arrange the items (posts) in an optimal position based on available vertical space.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/masonry.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Infinite scroll for posts', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Loading the items (posts) via ajax when visitors approach the bottom of the posts page.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/infinite-scroll.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Create custom sidebars', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Create additional sidebars and choose which pages to show them.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/custom-sidebars.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Footer Callout', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Attract your visitors with beautiful call-to-action placed in the footer.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/footer-callout.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Create custom sliders', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Create custom sliders (posts, pages, WooCommerce) and insert them wherever you want.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/custom-sliders.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Floating Contact Buttons', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Insert floating buttons to allow your users to contact you easily via WhatsApp, Facebook Messenger or Telegram.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/contact-buttons.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Related Posts box', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Show related posts (carousel) under each blog post.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/related-posts.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Information about author box', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Show author information under each blog post.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/author-information.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Social Sharing buttons', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('A set of social buttons so that visitors can quickly share pages and posts on social networks.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/share-buttons.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('WooCommerce image flipper', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Adds a secondary product thumbnail on product archives that is displayed when you hover over the main product image.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/woocommerce-image-flip.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Copyright Information', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Remove AttesaWP Credits next to your custom copyright text at the site footer.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/copyright-text.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Custom Header Button', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Add a custom button with links within the header image of specific pages or posts.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/custom-header-button.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('Customize 404 page', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('Customize 404 page (not found) of your website with text and image.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/customize-404-page.png' , __FILE__ )); ?>"/></div>
					</div>
					<div class="col">
						<h3><?php esc_html_e('...Even More', 'attesa-extra'); ?></h3>
						<p><?php esc_html_e('More page loader, more widgets, PowerTip script, and many other features that will be added over time.', 'attesa-extra'); ?></p>
						<div class="attesa-pro-features-image"><img src="<?php echo esc_url(plugins_url( '/assets/img/pro-features/attesa-whats-new.png' , __FILE__ )); ?>"/></div>
					</div>
					<!-- use "col w2" if odd columns -->
				</div>
				<div class="attesa-get-pro">
					<a href="https://attesawp.com/attesa-pro/" target="_blank"><?php esc_html_e( 'Get Attesa PRO addon', 'attesa-extra' ); ?></a>
				</div>
			</div>
		</div>
		<?php
	}
}
endif;
return new Attesa_Pro_Features();