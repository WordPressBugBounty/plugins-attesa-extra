<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Controls_Stack;

class Attesa_Extra_Navigation_Menu extends Widget_Base {
	public function get_name() {
		return 'attesa-extra-navigation-menu';
	}
	public function get_title() {
		return __( 'Navigation Menus', 'attesa-extra' );
	}
	public function get_icon() {
		return 'awp-icon eicon-navigation-horizontal';
	}
	public function get_categories() {
		return [ 'attesa-elements' ];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_navigation_menus',
			[
				'label' 		=> __( 'Navigations menus', 'attesa-extra' ),
			]
		);
		
		$this->add_control(
			'select_menu',
			[
				'label' 		=> __( 'Select Menu', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> '0',
				'options' 		=> $this->get_available_menus(),
			]
		);
		
		$this->add_control(
			'mobile_menu',
			[
				'label' 		=> __( 'Menu Mobile Text', 'attesa-extra' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Menu', 'attesa-extra' ),
				'label_block' 	=> true,
			]
		);
		
		$this->add_control(
			'close_mobile_menu',
			[
				'label' 		=> __( 'Close Menu Mobile Text', 'attesa-extra' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Close Menu', 'attesa-extra' ),
				'label_block' 	=> true,
			]
		);
		
		$this->add_responsive_control(
			'menu_align',
				[
					'label' => __( 'Alignment', 'attesa-extra' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'attesa-extra' ),
							'icon' => 'fa fa-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'attesa-extra' ),
							'icon' => 'fa fa-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'attesa-extra' ),
							'icon' => 'fa fa-align-right',
						],
					],
					'default' => 'left',
					'toggle' => true,
					'selectors' => [
						'{{WRAPPER}} .attesa-custom-menu' => 'text-align: {{VALUE}};',
					],
				]
		);
		
		$this->add_responsive_control(
			'items_padding',
			[
				'label' => __( 'Items Padding', 'attesa-extra' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'desktop_default' => [	
					'top' => 1,
					'right' => 0.6,
					'bottom' => 1,
					'left' => 0.6,
					'unit' => 'em',
					'isLinked' => false,
				],
				'tablet_default' => [	
					'top' => 1,
					'right' => 0.6,
					'bottom' => 1,
					'left' => 0.6,
					'unit' => 'em',
					'isLinked' => false,
				],
				'mobile_default' => [	
					'top' => 1,
					'right' => 0.6,
					'bottom' => 1,
					'left' => 0.6,
					'unit' => 'em',
					'isLinked' => false,
				],	
				'selectors' => [
					'{{WRAPPER}} .mainHead .main-navigation > div > ul > li > a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'items_typography',
				'selector' 	=> '{{WRAPPER}} .main-navigation li',
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_nav_menu_style',
			[
				'label' => __( 'Items Style', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'menu_back_color',
			[
				'label' 	=> __( 'Menu Background Color Mobile', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#ffffff',
				'selectors' => [
					'(tablet){{WRAPPER}} .attesa-main-menu-container' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'text_color',
			[
				'label' 	=> __( 'Text Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#000000',
				'selectors' => [
					'{{WRAPPER}} .main-navigation >div >ul >li >a' => 'color: {{VALUE}};',
					'(tablet){{WRAPPER}} .main-navigation ul ul a, {{WRAPPER}} .main-navigation ul li .indicator:before' => 'color: {{VALUE}} !important',
				],
			]
		);
		
		$this->add_control(
			'sub_menu_back_color',
			[
				'label' 	=> __( 'Sub Menu Background Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#000000',
				'selectors' => [
					'{{WRAPPER}} .main-navigation ul ul a' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'sub_menu_text_color',
			[
				'label' 	=> __( 'Sub Menu Text Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .main-navigation ul ul a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'menu_mobile_border_color',
			[
				'label' 	=> __( 'Menu Mobile Border Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#ececec',
				'selectors' => [
					'(tablet){{WRAPPER}} .main-navigation li, {{WRAPPER}} .main-navigation ul li .indicator, {{WRAPPER}} .main-navigation ul li .indicator, {{WRAPPER}} .main-navigation >div >ul >li >ul.sub-menu, {{WRAPPER}} .attesa-main-menu-container' => 'border-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_nav_menu_style_featured',
			[
				'label' => __( 'Featured button Style (if used)', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'feat_button_text_color',
			[
				'label' 	=> __( 'Featured Button Text Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#ffffff',
				'selectors' => [
					'{{WRAPPER}} .main-navigation >div >ul >li.attesaMenuButton >a' => 'color: {{VALUE}};',
					'(tablet){{WRAPPER}} .main-navigation >div ul li.attesaMenuButton a, {{WRAPPER}} .main-navigation >div ul li.attesaMenuButton a:hover, {{WRAPPER}} .main-navigation >div ul li.attesaMenuButton a:focus, {{WRAPPER}} .main-navigation >div ul li.attesaMenuButton a:active, {{WRAPPER}} .main-navigation ul li.attesaMenuButton .indicator:before' => 'color: {{VALUE}} !important',
				],
			]
		);
		
		$this->add_control(
			'feat_button_back_color',
			[
				'label' 	=> __( 'Featured Button Background Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#000000',
				'selectors' => [
					'{{WRAPPER}} .attesaMenuButton' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_nav_menu_close_menu_button',
			[
				'label' => __( 'Close menu mobile button Style', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'close_button_text_color',
			[
				'label' 	=> __( 'Close Menu Button Text Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#000000',
				'selectors' => [
					'{{WRAPPER}} .attesa-main-menu-container.open_pushmenu .attesa-close-pushmenu' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'close_button_back_color',
			[
				'label' 	=> __( 'Close Menu Button Background Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#fbfbfb',
				'selectors' => [
					'{{WRAPPER}} .attesa-main-menu-container.open_pushmenu .attesa-close-pushmenu' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'close_button_align',
				[
					'label' => __( 'Alignment', 'attesa-extra' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'left' => [
							'title' => __( 'Left', 'attesa-extra' ),
							'icon' => 'fa fa-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'attesa-extra' ),
							'icon' => 'fa fa-align-center',
						],
						'right' => [
							'title' => __( 'Right', 'attesa-extra' ),
							'icon' => 'fa fa-align-right',
						],
					],
					'default' => 'left',
					'toggle' => true,
					'selectors' => [
						'{{WRAPPER}} .attesa-main-menu-container.open_pushmenu .attesa-close-pushmenu' => 'text-align: {{VALUE}};',
					],
				]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_hamburger_menu',
			[
				'label' => __( 'Hamburger Menu button Style (if used)', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'hamburger_menu_color',
			[
				'label' 	=> __( 'Hamburger Menu Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#000000',
				'selectors' => [
					'{{WRAPPER}} .hamburger-menu .menu__line' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
	}
	
	private function get_available_menus() {
		$menus = wp_get_nav_menus();

		$options = array (__( '-- Select --', 'attesa-extra' ));

		foreach ( $menus as $menu ) {
			$options[ $menu->slug ] = $menu->name;
		}

		return $options;
	}
	
	protected function render() {
		$settings = $this->get_settings();
		$menu_selected = $settings['select_menu'];
		$menu = $settings['mobile_menu'];
		$close_menu = $settings['close_mobile_menu'];
		$menuLinksStyle = attesa_options('_menu_links_style', 'minimal');
		$mobileMenuIcon = attesa_options('_mobile_menu_icon', 'fas fa fa-bars');
		?>
		<?php if ($menu_selected != '0'):?>
			<div class="attesa-custom-menu">
				<div class="mainHead">
					<div class="subHead attesa-elementor-menu">
						<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false" aria-label="<?php echo esc_attr($menu); ?>"><?php echo esc_html($menu); ?><i class="spaceLeft <?php echo esc_attr($mobileMenuIcon); ?>" aria-hidden="true"></i></button>
						<div class="attesa-main-menu-container open_pushmenu">
							<div class="attesa-close-pushmenu"><i class="fa fa-times-circle-o spaceRight" aria-hidden="true"></i><?php echo esc_html($close_menu); ?></div>
							<nav id="site-navigation" class="main-navigation menustyle_<?php echo esc_attr($menuLinksStyle); ?>" <?php attesa_schema_markup('site-navigation'); ?>>
								<?php
								wp_nav_menu( array(
									'menu' => $menu_selected,
									'theme_location' => 'main',
									'menu_id'        => 'primary-menu',
								) );
								?>
							</nav><!-- #site-navigation -->
						</div>
					</div>
				</div><!-- .mainHead -->
				<?php if ( is_active_sidebar( attesa_get_push_sidebar() ) && attesa_check_bar('push') ) : ?>
					<div class="mainFunc">
						<div class="subFunc attesa-elementor-menu">
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
						</div>
					</div><!-- .mainFunc -->
				<?php endif; ?>
			</div>
		<?php endif;
	}
	
	protected function content_template() {
	}
}