<?php
/* Add custom code in the header */
function attesaextra_custom_code_header() {
	if (function_exists('attesa_options') ) {
		// Ignore if Attesa option for header code is uncheck
		if ( !attesa_options('_custom_code_header_use', '')) {
			return;
		}
		// Ignore admin, feed, robots or trackbacks
		if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {
			return;
		}
		$customHeaderCode = attesa_options('_custom_code_header', false);
		if ( empty( $customHeaderCode ) ) {
			return;
		}
		if ( trim( $customHeaderCode ) == '' ) {
			return;
		}
		return wp_unslash( $customHeaderCode );
	}
}
add_action( 'attesa_header_code','attesaextra_custom_code_header' );

/* Add custom code in the footer */
function attesaextra_custom_code_footer() {
	if (function_exists('attesa_options') ) {
		// Ignore if Attesa option for footer code is uncheck
		if ( !attesa_options('_custom_code_footer_use', '')) {
			return;
		}
		// Ignore admin, feed, robots or trackbacks
		if ( is_admin() || is_feed() || is_robots() || is_trackback() ) {
			return;
		}
		$customFooterCode = attesa_options('_custom_code_footer', false);
		if ( empty( $customFooterCode ) ) {
			return;
		}
		if ( trim( $customFooterCode ) == '' ) {
			return;
		}
		return wp_unslash( $customFooterCode );
	}
}
add_action( 'attesa_footer_code','attesaextra_custom_code_footer' );

/* Get all Attesa Templates post */
function attesaextra_get_attesa_templates() {
	$templates = array( __( '-- Select --', 'attesa-extra' ) );
	$get_templates 	= get_posts( array( 'post_type' => 'attesa_templates', 'numberposts' => -1, 'post_status' => 'publish' ) );
	if ( ! empty ( $get_templates ) ) {
		foreach ( $get_templates as $template ) {
			$templates[ $template->ID ] = $template->post_title;
		}
	}
	return $templates;
}

/* Get the footer with optional Attesa Templates */
function attesaextra_get_footer() {
	if(attesa_check_bar('footer')):
		if (attesa_options('_footer_choose', 'default') == 'default' ): ?>
			<?php $footerNumbers = attesa_options('_footer_numbers', 'threecol'); ?>
			<?php if ( is_active_sidebar( 'footer-1' ) || is_active_sidebar( 'footer-2' ) || is_active_sidebar( 'footer-3' ) || is_active_sidebar( 'footer-4' ) ) : ?>
				<div class="footerArea">
					<div class="attesaFooterWidget <?php echo esc_attr($footerNumbers); ?>">
						<?php do_action('attesa_before_footer_widgets'); ?>
						<div class="attesa-footer-container">
							<?php if ($footerNumbers == 'onecol'): ?>
								<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
									<aside id="footer-1" class="widget-area footer">
										<?php dynamic_sidebar( 'footer-1' ); ?>
									</aside><!-- #footer-1 -->
								<?php endif; ?>
							<?php elseif ($footerNumbers == 'twocol'): ?>
								<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
									<aside id="footer-1" class="widget-area footer">
										<?php dynamic_sidebar( 'footer-1' ); ?>
									</aside><!-- #footer-1 -->
								<?php endif; ?>
								<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
									<aside id="footer-2" class="widget-area footer">
										<?php dynamic_sidebar( 'footer-2' ); ?>
									</aside><!-- #footer-2 -->
								<?php endif; ?>
							<?php elseif ($footerNumbers == 'threecol'): ?>
								<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
									<aside id="footer-1" class="widget-area footer">
										<?php dynamic_sidebar( 'footer-1' ); ?>
									</aside><!-- #footer-1 -->
								<?php endif; ?>
								<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
									<aside id="footer-2" class="widget-area footer">
										<?php dynamic_sidebar( 'footer-2' ); ?>
									</aside><!-- #footer-2 -->
								<?php endif; ?>
								<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
									<aside id="footer-3" class="widget-area footer">
										<?php dynamic_sidebar( 'footer-3' ); ?>
									</aside><!-- #footer-3 -->
								<?php endif; ?>
							<?php elseif ($footerNumbers == 'fourcol'): ?>
								<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
									<aside id="footer-1" class="widget-area footer">
										<?php dynamic_sidebar( 'footer-1' ); ?>
									</aside><!-- #footer-1 -->
								<?php endif; ?>
								<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
									<aside id="footer-2" class="widget-area footer">
										<?php dynamic_sidebar( 'footer-2' ); ?>
									</aside><!-- #footer-2 -->
								<?php endif; ?>
								<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
									<aside id="footer-3" class="widget-area footer">
										<?php dynamic_sidebar( 'footer-3' ); ?>
									</aside><!-- #footer-3 -->
								<?php endif; ?>
								<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
									<aside id="footer-4" class="widget-area footer">
										<?php dynamic_sidebar( 'footer-4' ); ?>
									</aside><!-- #footer-3 -->
								<?php endif; ?>
							<?php endif; ?>
						</div>
						<?php do_action('attesa_after_footer_widgets'); ?>
					</div>
				</div>
			<?php endif; ?>
		<?php else: ?>
			<div class="attesa-custom-footer">
				<?php $attesaTemplateID = attesa_options('_footer_get_attesa_template', '0'); ?>
				<?php if($attesaTemplateID != '0') {
					$args = array( 'p' => intval($attesaTemplateID), 'post_type' => 'attesa_templates');
					$query = new WP_Query( $args );
					if ( $query->have_posts() ) :
						while ( $query->have_posts() ) :
							$query->the_post();
							the_content();
						endwhile;
					endif;
					wp_reset_postdata();
				} else {
					printf(
						/* translators: %1$s: create new custom template link */
						wp_kses( __( 'Choose a template to display. If you haven\'t created a custom template yet, <a href="%1$s">get started here</a>.', 'attesa-extra' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'edit.php?post_type=attesa_templates' ) ) 
					);
				} ?>
			</div>
		<?php endif; ?>
	<?php endif;
}

/* Get the header with optional Attesa Templates */
function attesaextra_get_header() {
	$showTopBar = apply_filters( 'attesa_show_top_bar', attesa_options('_show_topbar', '1') );
	$headerScroll = attesa_options('_header_scroll', 'smaller');
	$headerFormat = attesa_options('_header_format', 'compat');
	$showInHeader =  attesa_options('_social_menu', '');
	$headerStyle = apply_filters( 'attesa_header_style', attesa_options('_header_style', 'boxed') );
	$menuPosition = attesa_options('_menu_position', 'right');
	$showWooCartButton = attesa_options('_show_woocart', '');
	$showEddCartButton = attesa_options('_show_eddcart', '');
	$showSearchButton = attesa_options('_show_search', '1');
	$mobileMenuOpen = attesa_options('_menu_mobile_open', 'dropdown');
	$mobileMenuIcon = attesa_options('_mobile_menu_icon', 'fas fa fa-bars');
	$mobileMenuText = attesa_options('_menu_mobile_default_text', __( 'Menu', 'attesa-extra' ));
	?>
	<?php /* if the header format is compat */ if ($headerFormat == 'compat'): ?>
		<?php if ($mobileMenuOpen == 'pushmenu' && $headerFormat != 'menupopup'): ?>
			<div class="opacityMenu"></div>
		<?php endif; ?>
		<div class="nav-middle headerscroll<?php echo esc_attr($headerScroll); ?> format_<?php echo esc_attr($headerFormat); ?>">
			<div class="container <?php echo esc_attr($headerStyle); ?>">
				<div class="mainLogo">
					<div class="subLogo">
						<div class="site-branding menuposition_<?php echo esc_attr($menuPosition); ?>" <?php attesa_schema_markup('site-title'); ?>>
							<?php
							if ( function_exists( 'the_custom_logo' ) ) : ?>
							<div class="attesa-logo">
								<?php the_custom_logo(); ?>
							</div>
							<?php endif; ?>
							<div class="attesa-text-logo">
								<?php
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title" <?php attesa_schema_markup('name'); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" <?php attesa_schema_markup('url'); ?>><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								else :
									?>
									<p class="site-title" <?php attesa_schema_markup('name'); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" <?php attesa_schema_markup('url'); ?>><?php bloginfo( 'name' ); ?></a></p>
									<?php
								endif;
								$removeSiteDescription = attesa_options('_hide_description', '');
								if (empty($removeSiteDescription)) :
									$attesa_description = get_bloginfo( 'description', 'display' );
									if ( $attesa_description || is_customize_preview() ) :
										?>
										<p class="site-description smallText"><?php echo $attesa_description; /* WPCS: xss ok. */ ?></p>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div><!-- .mainLogo -->
				<div class="mainFunc">
					<div class="subFunc">
						<?php
						if ($showWooCartButton && function_exists( 'is_woocommerce') && $showTopBar && !class_exists( 'Attesa_pro' ) ) : ?>
						<div class="cartwoo-button-mobile">
							<a class="woo-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
								<div class="cart-handle">
									<div class="cart-body">
										<i class="<?php echo esc_attr(attesa_options('_woocommercecart_icon', 'fa fa-shopping-cart')); ?>" aria-hidden="true"></i>
										<span class="cart-items"><span class="shopping-count">
											<?php if(WC()->cart->get_cart_contents_count() != 0){ echo intval(WC()->cart->get_cart_contents_count()); } ?>
										</span></span>
									</div>
								</div>
							</a>
						</div>
						<?php endif; ?>
						<?php
						if ($showEddCartButton && function_exists( 'EDD') && $showTopBar ) : ?>
						<div class="cartedd-button-mobile">
							<a class="edd-cart" href="<?php echo esc_url(edd_get_checkout_uri()); ?>">
								<i class="<?php echo esc_attr(attesa_options('_eddcart_icon', 'fa fa-shopping-cart')); ?>" aria-hidden="true"></i>
								<span class="header-cart edd-cart-quantity">
									<?php if (edd_get_cart_quantity() != 0) { echo intval(edd_get_cart_quantity()); } ?>
								</span>
							</a>
						</div>
						<?php endif; ?>
						<?php 
							if ($showInHeader == 1 ) {
								echo '<div class="attesa-social-header-desktop">';
								echo attesa_show_social_network('header');
								echo '</div>';
							}
						?>
						<?php attesa_header_next_to_menu(); ?>
						<?php if ( is_active_sidebar( attesa_get_push_sidebar() ) && attesa_check_bar('push') ) : ?>
							<?php if(attesa_options('_pushsidebar_icon','three_lines_icon') == 'three_lines_icon') : ?>
								<div class="hamburger-menu">
									<div class="menu__line menu_line1"></div>
									<div class="menu__line menu_line2"></div>
									<div class="menu__line menu_line3"></div>
									<div class="menu__line menu_line4"></div>
									<div class="menu__line menu_line5"></div>
								</div>
							<?php elseif(attesa_options('_pushsidebar_icon','three_lines_icon') == 'plus_icon'): ?>
								<div class="hamburger-menu noOw">
									<div class="menu__plus menu_plus1"></div>
									<div class="menu__plus menu_plus2"></div>
								</div>
							<?php else: ?>
								<div class="hamburger-menu noOw">
									<div class="menu__circle"></div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div><!-- .mainFunc -->
				<div class="mainHead">
					<div class="subHead">
						<?php $menuLinksStyle = attesa_options('_menu_links_style', 'minimal'); ?>
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php echo esc_attr($mobileMenuText); ?>"><?php echo esc_html($mobileMenuText); ?><i class="spaceLeft <?php echo esc_attr($mobileMenuIcon); ?>" aria-hidden="true"></i></button>
						<div class="attesa-main-menu-container open_<?php echo esc_attr($mobileMenuOpen); ?>">
							<?php if ($mobileMenuOpen == 'pushmenu'): ?>
								<?php $closeMenuText = attesa_options('_menu_mobile_text_close',__( 'Close menu', 'attesa-extra' )); ?>
								<div class="attesa-close-pushmenu"><i class="<?php attesa_fontawesome_icons('close'); ?> spaceRight" aria-hidden="true"></i><?php echo esc_html($closeMenuText); ?></div>
							<?php endif; ?>
							<nav id="site-navigation" class="main-navigation menustyle_<?php echo esc_attr($menuLinksStyle); ?>" <?php attesa_schema_markup('site-navigation'); ?>>
								<?php
								wp_nav_menu( array(
									'theme_location' => 'main',
									'menu_id'        => 'primary-menu',
								) );
								?>
							</nav><!-- #site-navigation -->
							<?php 
								if ($showInHeader == 1) {
									echo '<div class="attesa-social-header-mobile">';
									echo attesa_show_social_network('header');
									echo '</div>';
								}
								if ($showSearchButton && $showTopBar) {
									echo '<div class="attesa-search-button-mobile">';
									get_search_form();
									echo '</div>';
								}
							?>
						</div>
					</div>
				</div><!-- .mainHead -->
			</div>
		</div>
	<?php /* if the header format is featuredtitle */ elseif ($headerFormat == 'featuredtitle'): ?>
		<?php if ($mobileMenuOpen == 'pushmenu' && $headerFormat != 'menupopup'): ?>
			<div class="opacityMenu"></div>
		<?php endif; ?>
		<div class="nav-middle-top-title">
			<div class="container <?php echo esc_attr($headerStyle); ?>">
				<div class="mainSoc">
					<div class="subSoc">
						<?php 
							if ($showInHeader == 1) {
								echo '<div class="attesa-social-header-desktop">';
								echo attesa_show_social_network('header');
								echo '</div>';
							}
						?>
						<?php attesa_header_next_to_menu(); ?>
					</div>
				</div><!-- .mainSoc -->
				<div class="mainLogo">
					<div class="subLogo">
						<div class="site-branding" <?php attesa_schema_markup('site-title'); ?>>
							<?php
							if ( function_exists( 'the_custom_logo' ) ) : ?>
							<div class="attesa-logo">
								<?php the_custom_logo(); ?>
							</div>
							<?php endif; ?>
							<div class="attesa-text-logo">
								<?php
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title" <?php attesa_schema_markup('name'); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" <?php attesa_schema_markup('url'); ?>><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								else :
									?>
									<p class="site-title" <?php attesa_schema_markup('name'); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" <?php attesa_schema_markup('url'); ?>><?php bloginfo( 'name' ); ?></a></p>
									<?php
								endif;
								$removeSiteDescription = attesa_options('_hide_description', '');
								if (empty($removeSiteDescription)) :
									$attesa_description = get_bloginfo( 'description', 'display' );
									if ( $attesa_description || is_customize_preview() ) :
										?>
										<p class="site-description smallText"><?php echo $attesa_description; /* WPCS: xss ok. */ ?></p>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div><!-- .mainLogo -->
				<div class="mainFunc">
					<div class="subFunc">
						<?php
						if ($showWooCartButton && function_exists( 'is_woocommerce') && $showTopBar && !class_exists( 'Attesa_pro' ) ) : ?>
						<div class="cartwoo-button-mobile">
							<a class="woo-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
								<div class="cart-handle">
									<div class="cart-body">
										<i class="<?php echo esc_attr(attesa_options('_woocommercecart_icon', 'fa fa-shopping-cart')); ?>" aria-hidden="true"></i>
										<span class="cart-items"><span class="shopping-count">
											<?php if(WC()->cart->get_cart_contents_count() != 0){ echo intval(WC()->cart->get_cart_contents_count()); } ?>
										</span></span>
									</div>
								</div>
							</a>
						</div>
						<?php endif; ?>
						<?php
						if ($showEddCartButton && function_exists( 'EDD') && $showTopBar ) : ?>
						<div class="cartedd-button-mobile">
							<a class="edd-cart" href="<?php echo esc_url(edd_get_checkout_uri()); ?>">
								<i class="<?php echo esc_attr(attesa_options('_eddcart_icon', 'fa fa-shopping-cart')); ?>" aria-hidden="true"></i>
								<span class="header-cart edd-cart-quantity">
									<?php if (edd_get_cart_quantity() != 0) { echo intval(edd_get_cart_quantity()); } ?>
								</span>
							</a>
						</div>
						<?php endif; ?>
						<?php if ( is_active_sidebar( attesa_get_push_sidebar() ) && attesa_check_bar('push') ) : ?>
							<?php if(attesa_options('_pushsidebar_icon','three_lines_icon') == 'three_lines_icon') : ?>
								<div class="hamburger-menu">
									<div class="menu__line menu_line1"></div>
									<div class="menu__line menu_line2"></div>
									<div class="menu__line menu_line3"></div>
									<div class="menu__line menu_line4"></div>
									<div class="menu__line menu_line5"></div>
								</div>
							<?php elseif(attesa_options('_pushsidebar_icon','three_lines_icon') == 'plus_icon'): ?>
								<div class="hamburger-menu noOw">
									<div class="menu__plus menu_plus1"></div>
									<div class="menu__plus menu_plus2"></div>
								</div>
							<?php else: ?>
								<div class="hamburger-menu noOw">
									<div class="menu__circle"></div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div><!-- .mainFunc -->
			</div>
		</div>
		<div class="nav-middle headerscroll<?php echo esc_attr($headerScroll); ?> format_<?php echo esc_attr($headerFormat); ?>" <?php attesa_schema_markup('site-navigation'); ?>>
			<div class="container <?php echo esc_attr($headerStyle); ?>">
				<div class="mainHead">
					<div class="subHead">
						<?php $menuLinksStyle = attesa_options('_menu_links_style', 'minimal'); ?>
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php echo esc_attr($mobileMenuText); ?>"><?php echo esc_html($mobileMenuText); ?><i class="spaceLeft <?php echo esc_attr($mobileMenuIcon); ?>" aria-hidden="true"></i></button>
						<div class="attesa-main-menu-container open_<?php echo esc_attr($mobileMenuOpen); ?>">
							<?php if ($mobileMenuOpen == 'pushmenu'): ?>
									<?php $closeMenuText = attesa_options('_menu_mobile_text_close',__( 'Close menu', 'attesa-extra' )); ?>
									<div class="attesa-close-pushmenu"><i class="<?php attesa_fontawesome_icons('close'); ?> spaceRight" aria-hidden="true"></i><?php echo esc_html($closeMenuText); ?></div>
								<?php endif; ?>
							<nav id="site-navigation" class="main-navigation menustyle_<?php echo esc_attr($menuLinksStyle); ?>">
								<?php
								wp_nav_menu( array(
									'theme_location' => 'main',
									'menu_id'        => 'primary-menu',
								) );
								?>
							</nav><!-- #site-navigation -->
							<?php 
								if ($showInHeader == 1) {
									echo '<div class="attesa-social-header-mobile">';
									echo attesa_show_social_network('header');
									echo '</div>';
								}
								if ($showSearchButton && $showTopBar) {
									echo '<div class="attesa-search-button-mobile">';
									get_search_form();
									echo '</div>';
								}
							?>
						</div>
					</div>
				</div><!-- .mainHead -->
			</div>
		</div>
	<?php /* if the header format is menupopup */ elseif ($headerFormat == 'menupopup'): ?>
		<div class="nav-middle headerscroll<?php echo esc_attr($headerScroll); ?> format_<?php echo esc_attr($headerFormat); ?>">
			<div class="container <?php echo esc_attr($headerStyle); ?>">
				<div class="mainLogo">
					<div class="subLogo">
						<div class="site-branding menuposition_<?php echo esc_attr($menuPosition); ?>" <?php attesa_schema_markup('site-title'); ?>>
							<?php
							if ( function_exists( 'the_custom_logo' ) ) : ?>
							<div class="attesa-logo">
								<?php the_custom_logo(); ?>
							</div>
							<?php endif; ?>
							<div class="attesa-text-logo">
								<?php
								if ( is_front_page() && is_home() ) :
									?>
									<h1 class="site-title" <?php attesa_schema_markup('name'); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" <?php attesa_schema_markup('url'); ?>><?php bloginfo( 'name' ); ?></a></h1>
									<?php
								else :
									?>
									<p class="site-title" <?php attesa_schema_markup('name'); ?>><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" <?php attesa_schema_markup('url'); ?>><?php bloginfo( 'name' ); ?></a></p>
									<?php
								endif;
								$removeSiteDescription = attesa_options('_hide_description', '');
								if (empty($removeSiteDescription)) :
									$attesa_description = get_bloginfo( 'description', 'display' );
									if ( $attesa_description || is_customize_preview() ) :
										?>
										<p class="site-description smallText"><?php echo $attesa_description; /* WPCS: xss ok. */ ?></p>
									<?php endif; ?>
								<?php endif; ?>
							</div>
						</div>
					</div>
				</div><!-- .mainLogo -->
				<div class="mainFunc">
					<div class="subFunc">
						<?php
						if ($showWooCartButton && function_exists( 'is_woocommerce') && $showTopBar && !class_exists( 'Attesa_pro' ) ) : ?>
						<div class="cartwoo-button-mobile">
							<a class="woo-cart" href="<?php echo esc_url(wc_get_cart_url()); ?>">
								<div class="cart-handle">
									<div class="cart-body">
										<i class="<?php echo esc_attr(attesa_options('_woocommercecart_icon', 'fa fa-shopping-cart')); ?>" aria-hidden="true"></i>
										<span class="cart-items"><span class="shopping-count">
											<?php if(WC()->cart->get_cart_contents_count() != 0){ echo intval(WC()->cart->get_cart_contents_count()); } ?>
										</span></span>
									</div>
								</div>
							</a>
						</div>
						<?php endif; ?>
						<?php
						if ($showEddCartButton && function_exists( 'EDD') && $showTopBar ) : ?>
						<div class="cartedd-button-mobile">
							<a class="edd-cart" href="<?php echo esc_url(edd_get_checkout_uri()); ?>">
								<i class="<?php echo esc_attr(attesa_options('_eddcart_icon', 'fa fa-shopping-cart')); ?>" aria-hidden="true"></i>
								<span class="header-cart edd-cart-quantity">
									<?php if (edd_get_cart_quantity() != 0) { echo intval(edd_get_cart_quantity()); } ?>
								</span>
							</a>
						</div>
						<?php endif; ?>
						<?php attesa_header_next_to_menu(); ?>
						<?php if ( is_active_sidebar( attesa_get_push_sidebar() ) && attesa_check_bar('push') ) : ?>
							<?php if(attesa_options('_pushsidebar_icon','three_lines_icon') == 'three_lines_icon') : ?>
								<div class="hamburger-menu">
									<div class="menu__line menu_line1"></div>
									<div class="menu__line menu_line2"></div>
									<div class="menu__line menu_line3"></div>
									<div class="menu__line menu_line4"></div>
									<div class="menu__line menu_line5"></div>
								</div>
							<?php elseif(attesa_options('_pushsidebar_icon','three_lines_icon') == 'plus_icon'): ?>
								<div class="hamburger-menu noOw">
									<div class="menu__plus menu_plus1"></div>
									<div class="menu__plus menu_plus2"></div>
								</div>
							<?php else: ?>
								<div class="hamburger-menu noOw">
									<div class="menu__circle"></div>
								</div>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div><!-- .mainFunc -->
				<div class="mainHead">
					<div class="subHead">
						<div class="menu-full-screen-icon">
						  <div class="icon-full-screen">
							<div class="square-full-screen"></div>
							<div class="square-full-screen"></div>
							<div class="square-full-screen"></div>
							<div class="square-full-screen"></div>
							<div class="square-full-screen"></div>
							<div class="square-full-screen"></div>
							<div class="square-full-screen"></div>
							<div class="square-full-screen"></div>
							<div class="square-full-screen"></div>
						  </div>
						</div>
						<?php $menuLinksStyle = attesa_options('_menu_links_style', 'minimal'); ?>
						<div class="attesa-main-menu-full-screen">
							<div class="attesa-main-menu-full-screen-container">
								<div class="attesa-main-menu-full-screen-sub-container">
									<nav id="site-navigation" class="main-navigation-popup menustyle_<?php echo esc_attr($menuLinksStyle); ?>" <?php attesa_schema_markup('site-navigation'); ?>>
										<?php
										wp_nav_menu( array(
											'theme_location' => 'main',
											'menu_id'        => 'primary-menu',
										) );
										?>
									</nav><!-- #site-navigation -->
									<?php 
										if ($showSearchButton && $showTopBar) {
											echo '<div class="attesa-search-button-popup">';
											get_search_form();
											echo '</div>';
										}
										if ($showInHeader == 1) {
											echo '<div class="attesa-social-header-popup">';
											echo attesa_show_social_network('header');
											echo '</div>';
										}
									?>
								</div>
							</div>
						</div>
					</div>
				</div><!-- .mainHead -->
			</div>
		</div>
	<?php /* if the header format is custom */ elseif ($headerFormat == 'custom'): ?>
		<div class="opacityMenu"></div>
		<div class="nav-middle format_elementor">
			<div class="container">
				<?php $attesaTemplateID = attesa_options('_header_get_attesa_template', '0'); ?>
				<?php if($attesaTemplateID != '0') {
					$args = array( 'p' => intval($attesaTemplateID), 'post_type' => 'attesa_templates');
					$query = new WP_Query( $args );
					if ( $query->have_posts() ) :
						while ( $query->have_posts() ) :
							$query->the_post();
							the_content();
						endwhile;
					endif;
					wp_reset_postdata();
				} else {
					printf(
						/* translators: %1$s: create new custom template link */
						wp_kses( __( 'Choose a template to display. If you haven\'t created a custom template yet, <a href="%1$s">get started here</a>.', 'attesa-extra' ), array( 'a' => array( 'href' => array() ) ) ), esc_url( admin_url( 'edit.php?post_type=attesa_templates' ) ) 
					);
				} ?>
			</div>
		</div>
	<?php endif; ?>
	<?php
}
/* Get the entry header filtered for 100% full width for page builders */
function attesaextra_get_entry_header() {
	if (attesaextra_check_use_custom_settings() && attesaextra_check_for_fullwidth_builders()) {
		if ( 'post' === get_post_type() ) {
			?>
			<div class="entry-meta smallText">
				<?php
				attesa_posted_on();
				the_title( '<span class="entry-title hidden" '. attesa_get_schema_markup('name') .'>', '</span>' );
				?>
			</div><!-- .entry-meta -->
			<?php
		} else {
			the_title( '<span class="entry-title hidden" '. attesa_get_schema_markup('name') .'>', '</span>' );
		}
	} else {
		if ( 'post' === get_post_type() ) :
			$attesa_featImageTitle = apply_filters( 'attesa_title_featured_image_style', attesa_options('_featimage_style_posts_title', 'insidecontent') ); 
			$attesa_featImage = apply_filters( 'attesa_post_featured_image_style', attesa_options('_featimage_style_posts', 'content') ); ?>
			<div class="entry-meta smallText">
				<?php
				attesa_posted_on();
				?>
			</div><!-- .entry-meta -->
		<?php else:
			$attesa_featImageTitle = apply_filters( 'attesa_title_featured_image_style_page', attesa_options('_featimage_style_pages_title', 'insidecontent') );
			$attesa_featImage = apply_filters( 'attesa_page_featured_image_style', attesa_options('_featimage_style_pages', 'content') );
		endif;
		if ($attesa_featImageTitle == 'insideheader' && $attesa_featImage == 'header' && '' != get_the_post_thumbnail()) {
			the_title( '<span class="entry-title hidden" '. attesa_get_schema_markup('name') .'>', '</span>' );
		} else {
			the_title( '<h1 class="entry-title" '. attesa_get_schema_markup('name') .'>', '</h1>' );
		}
	}
}

/* Check if WPML String Translation plugin is active */
if ( ! function_exists( 'attesaextra_is_wpml_string_translation_active' ) ) {
	function is_wpml_string_translation_active() {
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		return is_plugin_active( 'wpml-string-translation/plugin.php' );
	}
}