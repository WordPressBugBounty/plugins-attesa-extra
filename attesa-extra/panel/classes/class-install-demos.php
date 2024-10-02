<?php
/**
 * Install demos page
 *
 * @package Attesa_Extra
 * @category Core
 * @author AttesaWP
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Start Class
class AttesaExtra_Install_Demos {

	/**
	 * Start things up
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_page' ), 999 );
	}

	/**
	 * Add sub menu page for the custom CSS input
	 *
	 * @since 1.0.0
	 */
	public function add_page() {
		add_submenu_page(
			'attesa-welcome',
			esc_html__( 'Install Demos', 'attesa-extra' ),
			esc_html__( 'Install Demos', 'attesa-extra' ),
			'manage_options',
			'install_demos',
			array( $this, 'create_admin_page' )
		);
	}

	/**
	 * Settings page output
	 *
	 * @since 1.0.0
	 */
	public function create_admin_page() {

		?>

		<div class="awp-demo-wrap wrap">

			<h2><?php esc_html_e( 'Attesa - Install Demos', 'attesa-extra' ); ?></h2>

			<div class="theme-browser rendered">

				<?php
				// Vars
				$demos = AttesaWP_Demos::get_demos_data();
				$categories = AttesaWP_Demos::get_demo_all_categories( $demos ); ?>

				<?php if ( ! empty( $categories ) ) : ?>
					<div class="awp-header-bar">
						<nav class="awp-navigation">
							<ul>
								<li class="active"><a href="#all" class="awp-navigation-link"><?php esc_html_e( 'All', 'attesa-extra' ); ?></a></li>
								<?php foreach ( $categories as $key => $name ) : ?>
									<li><a href="#<?php echo esc_attr( $key ); ?>" class="awp-navigation-link"><?php echo esc_html( $name ); ?></a></li>
								<?php endforeach; ?>
							</ul>
						</nav>
						<div clas="awp-search">
							<input type="text" class="awp-search-input" name="awp-search" value="" placeholder="<?php esc_attr_e( 'Search demos...', 'attesa-extra' ); ?>">
						</div>
					</div>
				<?php endif; ?>

				<div class="themes wp-clearfix">

					<?php
					// Loop through all demos
					foreach ( $demos as $demo => $key ) {

						// Vars
						$item_categories = AttesaWP_Demos::get_demo_item_categories( $key );
						$is_what = AttesaWP_Demos::get_demo_theme_type( $key ) ?>

						<div class="theme-wrap awp_is_<?php echo esc_attr($is_what); ?>" data-categories="<?php echo esc_attr( $item_categories ); ?>" data-name="<?php echo esc_attr( strtolower( $demo ) ); ?>">

							<div class="theme awp-open-popup" data-demo-id="<?php echo esc_attr( $demo ); ?>">

								<div class="theme-screenshot">									
									<img src="<?php echo esc_url(plugins_url('assets/img/demos/',dirname(__FILE__))) . esc_attr($demo); ?>.jpg" />

									<div class="demo-import-loader preview-all preview-all-<?php echo esc_attr( $demo ); ?>"></div>

									<div class="demo-import-loader preview-icon preview-<?php echo esc_attr( $demo ); ?>"><i class="custom-loader"></i></div>
								</div>

								<div class="theme-id-container">
		
									<h2 class="theme-name" id="<?php echo esc_attr( $demo ); ?>"><span><?php echo esc_html(ucwords( $demo )); ?></span></h2>

									<div class="theme-actions">
										<a class="button button-primary" href="https://demos.attesawp.com/<?php echo esc_attr( $demo ); ?>/" target="_blank"><?php echo esc_html( 'Live Preview', 'attesa-extra' ); ?></a>
									</div>

								</div>

							</div>

						</div>

					<?php } ?>

				</div>

			</div>

		</div>

	<?php }
}
new AttesaExtra_Install_Demos();