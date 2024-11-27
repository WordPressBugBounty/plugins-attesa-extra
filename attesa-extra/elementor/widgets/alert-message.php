<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography;
use Elementor\Icons_Manager;
use Elementor\Controls_Stack;

class Attesa_Extra_Alert_Message extends Widget_Base {
	public function get_name() {
		return 'attesa-extra-alert-message';
	}
	public function get_title() {
		return __( 'Alert Message', 'attesa-extra' );
	}
	public function get_icon() {
		return 'awp-icon eicon-alert';
	}
	public function get_categories() {
		return [ 'attesa-elements' ];
	}
	public function get_style_depends() {
		return [ 'awp-alert-message' ];
	}
	public function get_script_depends() {
		return [ 'awp-alert' ];
	}
	
	protected function register_controls() {
		$this->start_controls_section(
			'section_alert_query',
			[
				'label' => __( 'Alert Message', 'attesa-extra' ),
			]
		);
		
		$this->add_control(
			'alert_icon',
			[
				'label' => __( 'Icon', 'attesa-extra' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-bolt',
					'library' => 'solid',
				],
			]
		);
		
		$this->add_control(
			'alert_title',
			[
				'label' 		=> __( 'Title', 'attesa-extra' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'This is Alert Message', 'attesa-extra' ),
				'label_block' 	=> true,
			]
		);
		
		$this->add_control(
			'alert_content',
			[
				'label' 		=> __( 'Content', 'attesa-extra' ),
				'type' 			=> Controls_Manager::TEXTAREA,
				'default' 		=> __( 'Proin ut ligula vel nunc egestas porttitor. Morbi lectus risus, iaculis vel.', 'attesa-extra' ),
				'separator' 	=> 'after',
			]
		);
		
		$this->add_control(
			'alert_show_dismiss',
			[
				'label' 		=> __( 'Dismiss Button', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SWITCHER,
				'label_on' => __( 'Show', 'attesa-extra' ),
				'label_off' => __( 'Hide', 'attesa-extra' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);

		$this->add_control(
			'view',
			[
				'label' 		=> __( 'View', 'attesa-extra' ),
				'type' 			=> Controls_Manager::HIDDEN,
				'default' 		=> 'traditional',
			]
		);
		
		$this->end_controls_section();
		//End post titles styles
		
		//Post titles styles
		$this->start_controls_section(
			'section_alert_style',
			[
				'label' => __( 'Alert style', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'alert_background_color',
			[
				'label' 	=> __( 'Background Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#dff0d8',
				'selectors' => [
					'{{WRAPPER}} .awp-alert .attesa-extra-alert-wrap' => 'background-color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'alert_text_color',
			[
				'label' 	=> __( 'Text Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#3cb37d',
				'selectors' => [
					'{{WRAPPER}} .awp-alert .attesa-extra-alert-wrap' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'alert_padding',
			[
				'label' => __( 'Padding', 'attesa-extra' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
				'desktop_default' => [	
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
					'unit' => 'em',
					'isLinked' => true,
				],
				'tablet_default' => [	
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
					'unit' => 'em',
					'isLinked' => true,
				],
				'mobile_default' => [	
					'top' => 1,
					'right' => 1,
					'bottom' => 1,
					'left' => 1,
					'unit' => 'em',
					'isLinked' => true,
				],	
				'separator' 	=> 'before',
				'selectors' => [
					'{{WRAPPER}} .awp-alert .attesa-extra-alert-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'alert_border_radius',
			[
				'label' => __( 'Border Radius', 'attesa-extra' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
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
				'separator' 	=> 'before',
				'selectors' => [
					'{{WRAPPER}} .awp-alert .attesa-extra-alert-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'alert_border_style',
			[
				'label' => __( 'Border Style', 'attesa-extra' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'solid',
				'options' => [
					'none' => __( 'None', 'attesa-extra' ),
					'solid' => __( 'Solid', 'attesa-extra' ),
					'double' => __( 'Double', 'attesa-extra' ),
					'dotted' => __( 'Dotted', 'attesa-extra' ),
					'dashed' => __( 'Dashed', 'attesa-extra' ),
				],
				'selectors' => [
					'{{WRAPPER}} .awp-alert .attesa-extra-alert-wrap' => 'border-style: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'alert_border_width',
			[
				'label' => __( 'Border Width', 'attesa-extra' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 2,
				],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 10,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awp-alert .attesa-extra-alert-wrap' => 'border-width: {{SIZE}}{{UNIT}};',
				],
				'condition' => [
					'alert_border_style!' => 'none',
				],
			]
		);
		
		$this->add_control(
			'alert_border_color',
			[
				'label' 	=> __( 'Border Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'default'	=> '#3cb37d',
				'selectors' => [
					'{{WRAPPER}} .awp-alert .attesa-extra-alert-wrap' => 'border-color: {{VALUE}};',
				],
				'condition' => [
					'alert_border_style!' => 'none',
				],
			]
		);
		
		$this->end_controls_section();
		//End post titles styles
		
		//Post titles styles
		$this->start_controls_section(
			'section_alert_style_title',
			[
				'label' => __( 'Title Typography', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'section_alert_style_title_typo',
				'selector' 	=> '{{WRAPPER}} .awp-alert .attesa-extra-alert-wrap .attesa-alert-title',
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		
		$this->end_controls_section();
		//End post titles styles
		
		//Post titles styles
		$this->start_controls_section(
			'section_alert_style_content',
			[
				'label' => __( 'Content Typography', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'section_alert_style_title_content',
				'selector' 	=> '{{WRAPPER}} .awp-alert .attesa-extra-alert-wrap .attesa-alert-content',
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		
		$this->end_controls_section();
		//End post titles styles
		
		//Post titles styles
		$this->start_controls_section(
			'section_alert_style_icon',
			[
				'label' => __( 'Icon Style', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_responsive_control(
			'section_alert_style_icon_size',
			[
				'label' => __( 'Icon size', 'attesa-extra' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'size' => 50,
					'unit' => 'px',
				],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awp-alert .attesa-extra-alert-wrap .attesa-alert-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		//End post titles styles
	}
	
	protected function render() {
		$settings = $this->get_settings();
		$icon = $settings['alert_icon'];
		$title = $settings['alert_title'];
		$content = $settings['alert_content'];
		$show_dismiss = $settings['alert_show_dismiss'];
		if($icon) {
			$iconExist = 'withIcon';
		} else {
			$iconExist = 'noIcon';
		}
		?>
		<div class="awp-alert" role="alert">
			<div class="attesa-extra-alert-wrap awp-alert-message">
				<div class="attesa-extra-alert-container <?php echo esc_attr($iconExist); ?>">
					<?php if($icon): ?>
						<div class="attesa-alert-icon"><?php Icons_Manager::render_icon( $icon, [ 'aria-hidden' => 'true' ] ); ?></div>
					<?php endif; ?>
					<?php if($title): ?>
						<div class="attesa-alert-title"><?php echo esc_html($title); ?></div>
					<?php endif; ?>
					<?php if($content): ?>
						<div class="attesa-alert-content"><?php echo wp_kses_post($content); ?></div>
					<?php endif; ?>
					<?php if($show_dismiss == 'yes'): ?>
						<div class="attesa-alert-dismiss awp-alert-close-button"><i class="fa fa-times"></i></div>
					<?php endif; ?>
				</div>
			</div>
		</div>
		<?php
	}
	
	protected function content_template() {
	}
}