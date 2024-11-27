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

class Attesa_Extra_Site_Logo extends Widget_Base {
	public function get_name() {
		return 'attesa-extra-logo';
	}
	public function get_title() {
		return __( 'Site Logo', 'attesa-extra' );
	}
	public function get_icon() {
		return 'awp-icon eicon-site-logo';
	}
	public function get_categories() {
		return [ 'attesa-elements' ];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_site_logo',
			[
				'label' 		=> __( 'Site Logo', 'attesa-extra' ),
			]
		);
		
		$this->add_control(
			'important_note',
			[
				'label' => __( 'Note', 'attesa-extra' ),
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __( 'You can customize your settings (choose the logo, change the site title or tagline) from your WordPress Dashboard in "Appearance-> Customize-> Site Identity".', 'attesa-extra' ),
				'content_classes' => 'elementor-descriptor',
			]
		);
		
		$this->add_responsive_control(
			'site_logo_align',
				[
					'label' => __( 'Alignment', 'attesa-extra' ),
					'type' => Controls_Manager::CHOOSE,
					'options' => [
						'flex-start' => [
							'title' => __( 'Left', 'attesa-extra' ),
							'icon' => 'fa fa-align-left',
						],
						'center' => [
							'title' => __( 'Center', 'attesa-extra' ),
							'icon' => 'fa fa-align-center',
						],
						'flex-end' => [
							'title' => __( 'Right', 'attesa-extra' ),
							'icon' => 'fa fa-align-right',
						],
					],
					'default' => 'flex-start',
					'toggle' => true,
					'selectors' => [
						'{{WRAPPER}} .attesa-custom-logo .attesa-text-logo' => 'align-items: {{VALUE}};',
						'{{WRAPPER}} .attesa-custom-logo .attesa-logo' => 'justify-content: {{VALUE}};',
					],
				]
		);
		
		$this->add_responsive_control(
			'max_height',
			[
				'label' => __( 'Logo Max Height', 'attesa-extra' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 60,
				],
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .attesa-custom-logo .attesa-logo img' => 'max-height: {{SIZE}}{{UNIT}};width: auto;',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'site_title_style',
			[
				'label' => __( 'Site title style (if used)', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'site_title_color',
			[
				'label' 	=> __( 'Site Title Text Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#f06292',
				'selectors' => [
					'{{WRAPPER}} .attesa-custom-logo .site-title a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'title_typography',
				'selector' 	=> '{{WRAPPER}} .attesa-custom-logo .site-title a',
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'site_tagline_style',
			[
				'label' => __( 'Site tagline style (if used)', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'site_tagline_color',
			[
				'label' 	=> __( 'Site Tagline Text Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#000000',
				'selectors' => [
					'{{WRAPPER}} .attesa-custom-logo .site-description' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'tagline_typography',
				'selector' 	=> '{{WRAPPER}} .attesa-custom-logo .site-description',
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings();
		?>
		<div class="attesa-custom-logo">
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
		</div>
		<?php
	}

}