<?php
/**
 * Attesa Admin Class.
 * @author  AttesaWP
 * @package Attesa
 * @since   1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
if ( ! class_exists( 'Attesa_Admin' ) ) :
/**
 * Attesa_Admin Class.
 */
class Attesa_Admin {
	/**
	 * Constructor.
	 */
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'admin_menu' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_scripts' ) );
		add_action( 'load-plugins.php', array( $this, 'admin_notice' ) );
		add_action( 'wp_loaded', array( $this, 'hide_notices' ) );
	}
	/**
	 * Add admin menu.
	 */
	public function admin_menu() {
		add_menu_page(
			esc_html__( 'Attesa Theme', 'attesa-extra' ),
			'Attesa Theme',
			'manage_options',
			'attesa-welcome',
			array( $this, 'welcome_screen' ),
			'dashicons-hammer'
		);
	}
	/**
	 * Enqueue styles.
	 */
	public function enqueue_admin_scripts($hook) {
		if ( 'toplevel_page_attesa-welcome' != $hook ) {
			return;
		}
		wp_enqueue_style( 'attesa-welcome', plugins_url('assets/css/welcome.css',__FILE__), array(), ATTESA_EXTRA_PLUGIN_VERSION);
	}
	/**
	 * Add admin notice.
	 */
	public function admin_notice() {
		global $pagenow;
		wp_enqueue_style( 'attesa-message', plugins_url('assets/css/message.css',__FILE__), array(), ATTESA_EXTRA_PLUGIN_VERSION);
		// Let's bail on theme activation.
		if ( 'plugins.php' == $pagenow && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
			update_option( 'attesaextra_admin_notice_welcome', 1 );
		// No option? Let run the notice wizard again..
		} elseif( ! get_option( 'attesaextra_admin_notice_welcome' ) ) {
			add_action( 'admin_notices', array( $this, 'welcome_notice' ) );
		}
	}
	/**
	 * Hide a notice if the GET variable is set.
	 */
	public static function hide_notices() {
		if ( isset( $_GET['attesa-extra-hide-notice'] ) && isset( $_GET['_attesaextra_notice_nonce'] ) ) {
			if ( ! wp_verify_nonce( sanitize_key($_GET['_attesaextra_notice_nonce'] ), 'attesaextra_hide_notices_nonce' ) ) {
				wp_die( esc_html__( 'Action failed. Please refresh the page and retry.', 'attesa-extra' ) );
			}
			if ( ! current_user_can( 'manage_options' ) ) {
				wp_die( esc_html__( 'Cheatin&#8217; huh?', 'attesa-extra' ) );
			}
			$hide_notice = sanitize_text_field( wp_unslash($_GET['attesa-extra-hide-notice'] ));
			update_option( 'attesaextra_admin_notice_' . $hide_notice, 1 );
		}
	}
	/**
	 * Show welcome notice.
	 */
	public function welcome_notice() {
		?>
		<div id="message" class="notice attesa-message">
			<a class="attesa-message-close notice-dismiss" href="<?php echo esc_url( wp_nonce_url( remove_query_arg( array( 'activated' ), add_query_arg( 'attesa-extra-hide-notice', 'welcome' ) ), 'attesaextra_hide_notices_nonce', '_attesaextra_notice_nonce' ) ); ?>"><?php esc_html_e( 'Dismiss', 'attesa-extra' ); ?></a>
			<div class="awp-message-inner">
				<div class="awp-icon">
					<img src="<?php echo esc_url(plugins_url( '/assets/img/attesa-icon-70-70.png' , __FILE__ )); ?>"/>
				</div>
				<div class="awp-notice">
					<strong><?php esc_html_e( 'Welcome to Attesa WordPress Theme', 'attesa-extra' ); ?></strong>
					<p class="awp-text">
					<?php
					/* translators: 1: start option panel link, 2: end option panel link */
					printf( esc_html__( 'Thank you for choosing Attesa theme with Attesa Extra plugin! To fully take advantage of the best our theme can offer and read the documentation please make sure you visit our %1$swelcome page%2$s.', 'attesa-extra' ), '<a href="' . esc_url( admin_url( 'admin.php?page=attesa-welcome' ) ) . '">', '</a>' );
					?>
					</p>
				</div>
			</div>
			<p class="submit">
				<a class="button-primary" href="<?php echo esc_url( admin_url( 'admin.php?page=attesa-welcome' ) ); ?>"><?php esc_html_e( 'Get started with Attesa', 'attesa-extra' ); ?></a>
				<a class="button-secondary" href="<?php echo esc_url( admin_url( 'admin.php?page=install_demos' ) ); ?>"><?php esc_html_e( 'Import demo content', 'attesa-extra' ); ?></a>
			</p>
		</div>
		<?php
	}
	/**
	 * Intro text/links shown to all about pages.
	 *
	 * @access private
	 */
	private function intro() {
		$theme = wp_get_theme( get_template() );
		?>
		<div class="attesa-theme-info">
			<h1>
				<?php echo esc_html($theme->get( 'Name' )); ?>
				<?php esc_html_e('WordPress Theme', 'attesa-extra'); ?>
			</h1>
			<div class="welcome-description-wrap">
				<div class="about-text"><?php echo esc_html($theme->display( 'Description' )); ?>
				<p class="attesa-actions">
					<a href="<?php echo esc_url( apply_filters( 'attesa_pro_theme_url', 'https://attesawp.com/' ) ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Theme Info', 'attesa-extra' ); ?></a>

					<a href="<?php echo esc_url( apply_filters( 'attesa_pro_theme_url', 'https://attesawp.com/demos/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'View all Demos', 'attesa-extra' ); ?></a>
					
					<?php if ( !class_exists( 'Attesa_pro' ) ) : ?>
						<a href="<?php echo esc_url( apply_filters( 'attesa_pro_theme_url', 'https://attesawp.com/attesa-pro/' ) ); ?>" class="button button-primary docs" target="_blank"><?php esc_html_e( 'Discover Attesa PRO addon', 'attesa-extra' ); ?></a>
					<?php endif; ?>
					
					<a href="<?php echo esc_url( apply_filters( 'attesa_pro_theme_url', 'https://wordpress.org/support/theme/attesa/reviews/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Rate this theme', 'attesa-extra' ); ?></a>
				
					<a href="<?php echo esc_url( apply_filters( 'attesa_pro_theme_url', 'https://attesawp.com/docs/' ) ); ?>" class="button button-secondary docs" target="_blank"><?php esc_html_e( 'Theme Documentation', 'attesa-extra' ); ?></a>
				</p>
				</div>
				<div class="attesa-screenshot">
					<img src="<?php echo esc_url( get_template_directory_uri() ) . '/screenshot.png'; ?>" />
				</div>
			</div>
		</div>
		<h2 class="nav-tab-wrapper">
			<a class="nav-tab <?php if ( empty( $_GET['tab'] ) && isset( $_GET['page'] ) && $_GET['page'] == 'attesa-welcome' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'attesa-welcome' ), 'admin.php' ) ) ); ?>">
				<?php echo esc_html($theme->display( 'Name' )); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'free_vs_pro' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'attesa-welcome', 'tab' => 'free_vs_pro' ), 'admin.php' ) ) ); ?>">
				<?php esc_html_e( 'Attesa Features', 'attesa' ); ?>
			</a>
			<a class="nav-tab <?php if ( isset( $_GET['tab'] ) && $_GET['tab'] == 'changelog' ) echo 'nav-tab-active'; ?>" href="<?php echo esc_url( admin_url( add_query_arg( array( 'page' => 'attesa-welcome', 'tab' => 'changelog' ), 'admin.php' ) ) ); ?>">
				<?php esc_html_e( 'Changelog', 'attesa' ); ?>
			</a>
		</h2>
		<?php
	}
	/**
	 * Welcome screen page.
	 */
	public function welcome_screen() {
		$current_tab = empty( $_GET['tab'] ) ? 'about' : sanitize_title( wp_unslash($_GET['tab']) );
		// Look for a {$current_tab}_screen method.
		if ( is_callable( array( $this, $current_tab . '_screen' ) ) ) {
			return $this->{ $current_tab . '_screen' }();
		}
		// Fallback to about screen.
		return $this->about_screen();
	}
	/**
	 * Output the about screen.
	 */
	public function about_screen() {
		$theme = wp_get_theme( get_template() );
		?>
		<div class="wrap about-wrap">
			<?php $this->intro(); ?>
			<div class="changelog point-releases">
				<div class="under-the-hood two-col">
					<div class="col">
						<h3><?php esc_html_e( 'Theme Customizer', 'attesa-extra' ); ?></h3>
						<p><?php esc_html_e( 'All Theme Options are available via Customize screen.', 'attesa-extra' ) ?></p>
						<p><a href="<?php echo esc_url(admin_url( 'customize.php' )); ?>" class="button button-secondary"><?php esc_html_e( 'Customize', 'attesa-extra' ); ?></a></p>
					</div>
					<div class="col">
						<h3><?php esc_html_e( 'Got theme support question?', 'attesa-extra' ); ?></h3>
						<p><?php esc_html_e( 'Please put it in our support forum.', 'attesa-extra' ) ?></p>
						<p><a target="_blank" href="<?php echo esc_url( 'https://wordpress.org/support/theme/attesa/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Support', 'attesa-extra' ); ?></a></p>
					</div>
					<?php if ( !class_exists( 'Attesa_pro' ) ) : ?>
						<div class="col">
							<h3><?php esc_html_e( 'Need more features?', 'attesa-extra'); ?></h3>
							<p><?php esc_html_e( 'Get Attesa PRO addon for more exciting features.', 'attesa-extra' ) ?></p>
							<p><a target="_blank" href="<?php echo esc_url( 'https://attesawp.com/attesa-pro/' ); ?>" class="button button-secondary"><?php esc_html_e( 'Info about PRO version', 'attesa-extra' ); ?></a></p>
						</div>
					<?php endif; ?>
					<div class="col">
						<h3>
							<?php
							esc_html_e( 'Translate Attesa Theme', 'attesa-extra' );
							?>
						</h3>
						<p><?php esc_html_e( 'Click below to translate this theme into your own language.', 'attesa-extra' ) ?></p>
						<p>
							<a target="_blank" href="<?php echo esc_url( 'https://translate.wordpress.org/projects/wp-themes/attesa' ); ?>" class="button button-secondary">
								<?php
								esc_html_e( 'Translate', 'attesa-extra' );
								echo ' ' . esc_html($theme->display( 'Name' ));
								?>
							</a>
						</p>
					</div>
				</div>
			</div>
			<div class="return-to-dashboard attesa">
				<?php if ( current_user_can( 'update_core' ) && isset( $_GET['updated'] ) ) : ?>
					<a href="<?php echo esc_url( self_admin_url( 'update-core.php' ) ); ?>">
						<?php is_multisite() ? esc_html_e( 'Return to Updates', 'attesa-extra' ) : esc_html_e( 'Return to Dashboard &rarr; Updates', 'attesa-extra' ); ?>
					</a> |
				<?php endif; ?>
				<a href="<?php echo esc_url( self_admin_url() ); ?>"><?php is_blog_admin() ? esc_html_e( 'Go to Dashboard &rarr; Home', 'attesa-extra' ) : esc_html_e( 'Go to Dashboard', 'attesa-extra' ); ?></a>
			</div>
		</div>
		<?php
	}
	/**
	 * Output the changelog screen.
	 */
	public function changelog_screen() {
		?>
		<div class="wrap about-wrap">
			<?php $this->intro(); ?>
			<?php if ( class_exists( 'Attesa_pro' ) ) :
				$ifpro = 'withpro';
			else:
				$ifpro = 'nopro';
			endif; ?>
			<div class="attesa-changelog-group <?php echo esc_attr($ifpro); ?>">
				<div class="attesa-changelog attesa-theme">
					<p class="about-description"><strong><?php esc_html_e( 'Attesa theme: ', 'attesa-extra' ); ?></strong><?php esc_html_e( 'View changelog below', 'attesa-extra' ); ?></p>
					<?php
						$changelog_file = apply_filters( 'attesa_theme_changelog_file', get_template_directory() . '/readme.txt' );

						// Check if the changelog file exists and is readable.
						if ( $changelog_file && is_readable( $changelog_file ) ) {
							$changelog = file_get_contents( $changelog_file );
							$changelog_list = $this->parse_changelog( $changelog );

							echo wp_kses_post( $changelog_list );
						}
					?>
				</div>
				<div class="attesa-changelog attesa-extra">
					<p class="about-description"><strong><?php esc_html_e( 'Attesa Extra plugin: ', 'attesa-extra' ); ?></strong><?php esc_html_e( 'View changelog below', 'attesa-extra' ); ?></p>
					<?php
						$changelog_file = apply_filters( 'attesa_extra_changelog_file', WP_PLUGIN_DIR . '/attesa-extra/readme.txt' );

						// Check if the changelog file exists and is readable.
						if ( $changelog_file && is_readable( $changelog_file ) ) {
							$changelog = file_get_contents( $changelog_file );
							$changelog_list = $this->parse_changelog( $changelog );

							echo wp_kses_post( $changelog_list );
						}
					?>
				</div>
				<?php if ( $ifpro == 'withpro' ) : ?>
					<div class="attesa-changelog attesa-pro">
						<p class="about-description"><strong><?php esc_html_e( 'Attesa PRO plugin: ', 'attesa-extra' ); ?></strong><?php esc_html_e( 'View changelog below', 'attesa-extra' ); ?></p>
						<?php
							$changelog_file = apply_filters( 'attesa_pro_changelog_file', WP_PLUGIN_DIR . '/attesa-pro/readme.txt' );

							// Check if the changelog file exists and is readable.
							if ( $changelog_file && is_readable( $changelog_file ) ) {
								$changelog = file_get_contents( $changelog_file );
								$changelog_list = $this->parse_changelog( $changelog );

								echo wp_kses_post( $changelog_list );
							}
						?>
					</div>
				<?php endif; ?>
			</div>
		</div>
		<?php
	}
	/**
	 * Parse changelog from readme file.
	 * @param  string $content
	 * @return string
	 */
	private function parse_changelog( $content ) {
		$matches   = null;
		$regexp    = '~==\s*Changelog\s*==(.*)($)~Uis';
		$changelog = '';
		if ( preg_match( $regexp, $content, $matches ) ) {
			$changes = explode( '\r\n', trim( $matches[1] ) );

			$changelog .= '<pre class="changelog">';

			foreach ( $changes as $index => $line ) {
				$changelog .= wp_kses_post( preg_replace( '~(=\s*Version\s*(\d+(?:\.\d+)+)\s*=|$)~Uis', '<span class="title">${1}</span>', $line ) );
			}

			$changelog .= '</pre>';
		}
		return wp_kses_post( $changelog );
	}
	/**
	 * Output the free vs pro screen.
	 */
	public function free_vs_pro_screen() {
		?>
		<div class="wrap about-wrap">
			<?php $this->intro(); ?>
			<?php if ( !class_exists( 'Attesa_pro' ) ) : ?>
				<p class="about-description"><?php esc_html_e( 'Get the PRO addon for more exciting features.', 'attesa-extra' ); ?></p>
			<?php else: ?>
				<p class="about-description"><?php esc_html_e( 'With Attesa PRO plugin, you have all the features available.', 'attesa-extra' ); ?></p>
			<?php endif; ?>
			<table>
				<thead>
					<tr>
						<th class="table-feature-title"><h3><?php esc_html_e('Features', 'attesa-extra'); ?></h3></th>
						<th><h3><?php esc_html_e('Attesa Theme', 'attesa-extra'); ?></h3></th>
						<th><h3><?php esc_html_e('with Attesa Extra addon', 'attesa-extra'); ?></h3></th>
						<th><h3><?php esc_html_e('with Attesa PRO addon', 'attesa-extra'); ?></h3></th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td><h3><?php esc_html_e('Theme Options made with the WP Customizer', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Responsive Design', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Logo Upload', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Unlimited Text and Background Color', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Choose Social Icons', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Elementor Compatibility', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('WooCommerce Compatibility', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('WPML / Polylang Multilingual ready', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('RTL Support', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Sidebar and Footer Widgets', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Loading Page', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span> <?php esc_html_e('2 loaders', 'attesa-extra'); ?></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span> <?php esc_html_e('5 loaders', 'attesa-extra'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Google Fonts switcher', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Manage sidebar position', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Custom Copyright Text', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Exclusive Widgets', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span> <?php esc_html_e('4 widgets', 'attesa-extra'); ?></td>
						<td><span class="dashicons dashicons-yes"></span> <?php esc_html_e('6 additional widgets', 'attesa-extra'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Manage/change settings for every single page', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Custom templates', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Exclusive Elementor Widgets', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span> <?php esc_html_e('+ additional Elementor widgets', 'attesa-extra'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Add custom JS code', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Import demo content', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
						<td><span class="dashicons dashicons-yes"></span> <?php esc_html_e('+ PRO demos available', 'attesa-extra'); ?></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Create Custom Portfolio', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Create Footer Callouts', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Create Custom Sidebars', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Create Custom Sliders', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Icons in the menus', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Badges in the menus', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Floating Contact Buttons', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Masonry Blog Style', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Infinite Scroll for blog', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Customize 404 page', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Custom button in header post/page', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Social sharing buttons for post/page', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Sticky Sidebar', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Related Posts Box', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Information About Author Box', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Login/Logout buttons for WooCommerce in main menu', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('WooCommerce Image Flipper', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td><h3><?php esc_html_e('Copyright text without AttesaWP Credits', 'attesa-extra'); ?></h3></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-no"></span></td>
						<td><span class="dashicons dashicons-yes"></span></td>
					</tr>
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<?php if ( class_exists( 'Attesa_pro' ) ) : ?>
							<td></td>
						<?php else: ?>
							<td class="btn-wrapper">
								<a href="<?php echo esc_url( apply_filters( 'attesa_pro_theme_url', 'https://attesawp.com/pricing/' ) ); ?>" class="button button-secondary" target="_blank"><?php esc_html_e( 'Get Attesa PRO addon', 'attesa-extra' ); ?></a>
							</td>
						<?php endif; ?>
					</tr>
				</tbody>
			</table>
		</div>
		<?php
	}
}
endif;
return new Attesa_Admin();