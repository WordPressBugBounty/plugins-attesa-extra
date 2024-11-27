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

class Attesa_Extra_Site_Social_Buttons extends Widget_Base {
	public function get_name() {
		return 'attesa-extra-social-buttons';
	}
	public function get_title() {
		return __( 'Site Social Buttons', 'attesa-extra' );
	}
	public function get_icon() {
		return 'awp-icon eicon-social-icons';
	}
	public function get_categories() {
		return [ 'attesa-elements' ];
	}
	public function get_style_depends() {
		return [ 'awp-site-social-buttons' ];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_social_buttons',
			[
				'label' 		=> __( 'Site Social Buttons', 'attesa-extra' ),
			]
		);
		
		$this->add_control(
			'important_note',
			[
				'label' => __( 'Note', 'attesa-extra' ),
				'type' => Controls_Manager::RAW_HTML,
				'raw' => __( 'You can insert your social media links from your WordPress Dashboard under "Appearance-> Customize-> Attesa Theme Options-> Social Buttons".', 'attesa-extra' ),
				'content_classes' => 'elementor-descriptor',
			]
		);
		
		$this->add_responsive_control(
			'social_buttons_align',
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
						'{{WRAPPER}} .awp-social-buttons .site-social-elementor' => 'text-align: {{VALUE}};',
					],
				]
		);
		
		$this->add_responsive_control(
			'icons_padding',
			[
				'label' => __( 'Icons Padding', 'attesa-extra' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'desktop_default' => [	
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
					'unit' => 'px',
					'isLinked' => true,
				],
				'tablet_default' => [	
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
					'unit' => 'px',
					'isLinked' => true,
				],
				'mobile_default' => [	
					'top' => 10,
					'right' => 10,
					'bottom' => 10,
					'left' => 10,
					'unit' => 'px',
					'isLinked' => true,
				],	
				'selectors' => [
					'{{WRAPPER}} .awp-social-buttons .site-social-elementor a' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'icons_margin',
			[
				'label' => __( 'Icons Padding', 'attesa-extra' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', 'em' ],
				'desktop_default' => [	
					'top' => 5,
					'right' => 5,
					'bottom' => 5,
					'left' => 5,
					'unit' => 'px',
					'isLinked' => true,
				],
				'tablet_default' => [	
					'top' => 5,
					'right' => 5,
					'bottom' => 5,
					'left' => 5,
					'unit' => 'px',
					'isLinked' => true,
				],
				'mobile_default' => [	
					'top' => 5,
					'right' => 5,
					'bottom' => 5,
					'left' => 5,
					'unit' => 'px',
					'isLinked' => true,
				],	
				'selectors' => [
					'{{WRAPPER}} .awp-social-buttons .site-social-elementor a' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'social_buttons_style',
			[
				'label' => __( 'Social Buttons', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_responsive_control(
			'icons_size',
			[
				'label' => __( 'Icons Size', 'attesa-extra' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awp-social-buttons .site-social-elementor a' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'social_buttons_color',
			[
				'label' 	=> __( 'Icon Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#f06292',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awp-social-buttons .site-social-elementor a' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'social_buttons_back_color',
			[
				'label' 	=> __( 'Icon Background Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awp-social-buttons .site-social-elementor a' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'social_buttons_color_hover',
			[
				'label' 	=> __( 'Icon Color Hover', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#000000',
				'separator' => 'before',
				'selectors' => [
					'{{WRAPPER}} .awp-social-buttons .site-social-elementor a:hover, {{WRAPPER}} .awp-social-buttons .site-social-elementor a:focus, {{WRAPPER}} .awp-social-buttons .site-social-elementor a:active' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'social_buttons_back_color_hover',
			[
				'label' 	=> __( 'Icon Background Color Hover', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'separator' => 'after',
				'selectors' => [
					'{{WRAPPER}} .awp-social-buttons .site-social-elementor a:hover, {{WRAPPER}} .awp-social-buttons .site-social-elementor a:focus, {{WRAPPER}} .awp-social-buttons .site-social-elementor a:active' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'icons_border_radius',
			[
				'label' => __( 'Icons Border Radius', 'attesa-extra' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'separator' 	=> 'before',
				'selectors' => [
					'{{WRAPPER}} .awp-social-buttons .site-social-elementor a' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings();
		?>
		<div class="awp-social-buttons">
			<?php echo attesa_show_social_network('elementor'); ?>
		</div>
		<?php
	}
}