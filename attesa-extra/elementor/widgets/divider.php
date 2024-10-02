<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Widget_Base;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Controls_Stack;

class Attesa_Extra_Divider extends Widget_Base {
	public function get_name() {
		return 'attesa-extra-divider';
	}
	public function get_title() {
		return __( 'Icon Divider', 'attesa-extra' );
	}
	public function get_icon() {
		return 'awp-icon eicon-divider-shape';
	}
	public function get_style_depends() {
		return [ 'awp-divider' ];
	}
	public function get_categories() {
		return [ 'attesa-elements' ];
	}
	protected function register_controls() {
		$this->start_controls_section(
			'section_divider_query',
			[
				'label' => __( 'Icon Divider', 'attesa-extra' ),
			]
		);
		
		$this->add_control(
			'style',
			[
				'label' => __( 'Style', 'attesa-extra' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'solid' => __( 'Solid', 'attesa-extra' ),
					'double' => __( 'Double', 'attesa-extra' ),
					'dotted' => __( 'Dotted', 'attesa-extra' ),
					'dashed' => __( 'Dashed', 'attesa-extra' ),
				],
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-divider-wrap .attesa-extra-divider' => 'border-top-style: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'weight',
			[
				'label' => __( 'Weight', 'attesa-extra' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 2,
				],
				'range' => [
					'px' => [
						'min' => 1,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-divider-wrap .attesa-extra-divider' => 'border-top-width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'color',
			[
				'label' 	=> __( 'Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#000000',
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-divider-wrap .attesa-extra-divider' => 'border-top-color: {{VALUE}};',
					'{{WRAPPER}} .attesa-extra-divider-wrap .attesa-divider-middle' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'icon_align',
			[
				'label' => __( 'Alignment', 'attesa-extra' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'position_center',
				'options' => [
					'position_left' => __( 'Left', 'attesa-extra' ),
					'position_center' => __( 'Center', 'attesa-extra' ),
					'position_right' => __( 'Right', 'attesa-extra' ),
				],
			]
		);
		
		$this->add_responsive_control(
			'width',
			[
				'label' => __( 'Width', 'attesa-extra' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'size' => 100,
					'unit' => '%',
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 1,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'condition' => [
					'icon_align' => 'position_center',
				],
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-divider-wrap' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'gap',
			[
				'label' => __( 'Gap', 'attesa-extra' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 15,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-divider-wrap' => 'padding: {{SIZE}}{{UNIT}} 0;',
				],
			]
		);
		
		$this->add_control(
			'icon',
			[
				'label' => __( 'Icon', 'attesa-extra' ),
				'type' => Controls_Manager::ICON,
				'default' => 'fa fa-bolt',
			]
		);
		
		$this->add_control(
			'icon-size',
			[
				'label' => __( 'Icon Size', 'attesa-extra' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'px' => [
						'min' => 5,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-divider-wrap .attesa-divider-middle' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'icon-padding',
			[
				'label' => __( 'Icon Padding', 'attesa-extra' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-divider-wrap .attesa-divider-middle' => 'padding: 0 {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'attesa-extra' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'traditional',
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings();
		$icon = $settings['icon'];
		$align = $settings['icon_align'];
		?>
		<div class="attesa-extra-divider-wrap <?php echo esc_attr($align); ?>">
			<div class="attesa-extra-divider attesa-divider-before"></div>
			<?php if($icon): ?>
				<div class="attesa-divider-middle"><i class="<?php echo esc_attr($icon); ?>"></i></div>
			<?php endif; ?>
			<div class="attesa-extra-divider attesa-divider-after"></div>
		</div>
		<?php
	}
	
	protected function content_template() {
	}
}