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
use Elementor\Group_Control_Box_Shadow;
use Elementor\Controls_Stack;

class Attesa_Extra_Advanced_Heading extends Widget_Base {
	public function get_name() {
		return 'attesa-extra-advanced-heading';
	}
	public function get_title() {
		return __( 'Advanced Heading', 'attesa-extra' );
	}
	public function get_icon() {
		return 'awp-icon eicon-animated-headline';
	}
	public function get_categories() {
		return [ 'attesa-elements' ];
	}
	public function get_style_depends() {
		return [ 'awp-advanced-heading' ];
	}
	
	protected function register_controls() {
		$this->start_controls_section(
			'section_advanced_heading',
			[
				'label' => __( 'Advanced Heading', 'attesa-extra' ),
			]
		);
		
		$this->add_control(
			'advanced_heading_first',
			[
				'label' 		=> __( 'First part title', 'attesa-extra' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Attesa', 'attesa-extra' ),
				'label_block' 	=> true,
			]
		);
		
		$this->add_control(
			'advanced_heading_second',
			[
				'label' 		=> __( 'Second part title', 'attesa-extra' ),
				'type' 			=> Controls_Manager::TEXT,
				'default' 		=> __( 'Theme', 'attesa-extra' ),
				'label_block' 	=> true,
			]
		);
		
		$this->add_control(
			'advanced_heading_htmltag',
			[
				'label' => __( 'HTML Tag', 'attesa-extra' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h2',
				'options' => [
					'h1' => __( 'H1', 'attesa-extra' ),
					'h2' => __( 'H2', 'attesa-extra' ),
					'h3' => __( 'H3', 'attesa-extra' ),
					'h4' => __( 'H4', 'attesa-extra' ),
					'h5' => __( 'H5', 'attesa-extra' ),
					'h6' => __( 'H6', 'attesa-extra' ),
					'div' => __( 'div', 'attesa-extra' ),
					'span' => __( 'span', 'attesa-extra' ),
					'p' => __( 'p', 'attesa-extra' ),
				],
			]
		);
		
		$this->add_control(
			'advanced_heading_show_icon',
			[
				'label' => __( 'Show icon', 'attesa-extra' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'advanced_heading_icon',
			[
				'label' => __( 'Icon', 'attesa-extra' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'fas fa-check-circle',
					'library' => 'regular',
				],
				'condition' => [
					'advanced_heading_show_icon' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'advanced_heading_subtitle',
			[
				'label' => __( 'Subtitle', 'attesa-extra' ),
				'type' => Controls_Manager::WYSIWYG,
				'label_block' => true,
			]
		);
		
		$this->end_controls_section();
		
		//Styles
		$this->start_controls_section(
			'advanced_heading_box_style',
			[
				'label' => __( 'Box style', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'advanced_heading_box_background',
			[
				'label' 		=> __( 'Box background', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#3C3C3C',
				'selectors' 	=> [
					'{{WRAPPER}} .attesa-extra-advanced-heading-wrap' => 'background: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'advanced_heading_box_padding',
			[
				'label' 		=> __( 'Box padding', 'attesa-extra' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em' ],
				'desktop_default' => [	
					'top' => 15,
					'right' => 15,
					'bottom' => 15,
					'left' => 15,
					'unit' => 'px',
					'isLinked' => true,
				],
				'tablet_default' => [	
					'top' => 15,
					'right' => 15,
					'bottom' => 15,
					'left' => 15,
					'unit' => 'px',
					'isLinked' => true,
				],
				'mobile_default' => [	
					'top' => 15,
					'right' => 15,
					'bottom' => 15,
					'left' => 15,
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .attesa-extra-advanced-heading-wrap' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'advanced_heading_box_border_radius',
			[
				'label' => __( 'Border Radius', 'attesa-extra' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],	
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-advanced-heading-wrap' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Box_Shadow::get_type(),
			[
				'name' => 'advanced_heading_box_shadow',
				'selector' => '{{WRAPPER}} .attesa-extra-advanced-heading-wrap',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'advanced_heading_title_style',
			[
				'label' => __( 'Title style', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_responsive_control(
			'advanced_heading_title_align',
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
						'justify' => [
							'title' => __( 'Justify', 'attesa-extra' ),
							'icon' => 'fa fa-align-justify',
						],
					],
					'default' => 'center',
					'toggle' => true,
					'selectors' => [
						'{{WRAPPER}} .awp-advanced-heading-title' => 'text-align: {{VALUE}};',
					],
				]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' 		=> __( 'First part title typography', 'attesa-extra' ),
				'name' 		=> 'advanced_heading_title_typography_first',
				'selector' 	=> '{{WRAPPER}} .awp-advanced-heading-title .awp-advanced-heading-first-title' ,
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		
		$this->add_control(
			'advanced_heading_title_color_first',
			[
				'label' 		=> __( 'First part title color', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#f06292',
				'selectors' 	=> [
					'{{WRAPPER}} .awp-advanced-heading-title .awp-advanced-heading-first-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' 		=> __( 'Second part title typography', 'attesa-extra' ),
				'name' 		=> 'advanced_heading_title_typography_second',
				'selector' 	=> '{{WRAPPER}} .awp-advanced-heading-title .awp-advanced-heading-second-title' ,
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		
		$this->add_control(
			'advanced_heading_title_color_second',
			[
				'label' 		=> __( 'Second part title color', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#ffffff',
				'selectors' 	=> [
					'{{WRAPPER}} .awp-advanced-heading-title .awp-advanced-heading-second-title' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'advanced_heading_title_gap',
			[
				'label' => __( 'Gap', 'attesa-extra' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 0,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 50,
						'step' => 1,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .awp-advanced-heading-title' => 'padding: {{SIZE}}{{UNIT}} 0;',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'advanced_heading_icon_style',
			[
				'label' => __( 'Icon style', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
				'condition' => [
					'advanced_heading_show_icon' => 'yes',
				],
			]
		);
		
		$this->add_responsive_control(
			'advanced_heading_icon_align',
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
					'default' => 'center',
					'toggle' => true,
					'selectors' => [
						'{{WRAPPER}} .awp-advanced-heading-icon' => 'justify-content: {{VALUE}};',
					],
				]
		);
		
		$this->add_control(
			'advanced_heading_icon_size',
			[
				'label' 		=> __( 'Icon size', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SLIDER,
				'default' 		=> [
					'size' => 25,
				],
				'range' 		=> [
					'px' => [
						'max' => 100,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-advanced-heading-icon span' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'advanced_heading_icon_padding',
			[
				'label' 		=> __( 'Icon padding', 'attesa-extra' ),
				'type' 			=> Controls_Manager::DIMENSIONS,
				'size_units' 	=> [ 'px', 'em' ],
				'desktop_default' => [	
					'top' => 20,
					'right' => 20,
					'bottom' => 20,
					'left' => 20,
					'unit' => 'px',
					'isLinked' => true,
				],
				'tablet_default' => [	
					'top' => 20,
					'right' => 20,
					'bottom' => 20,
					'left' => 20,
					'unit' => 'px',
					'isLinked' => true,
				],
				'mobile_default' => [	
					'top' => 20,
					'right' => 20,
					'bottom' => 20,
					'left' => 20,
					'unit' => 'px',
					'isLinked' => true,
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-advanced-heading-icon span' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'advanced_heading_icon_position',
			[
				'label'			=> __( 'Icon position', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'middle',
				'options' 		=> [
					'top'  => __( 'Top', 'attesa-extra' ),
					'middle'  => __( 'Middle', 'attesa-extra' ),
					'bottom'  => __( 'Bottom', 'attesa-extra' ),
				],
			]
		);
		
		$this->add_control(
			'advanced_heading_icon_color',
			[
				'label' 		=> __( 'Icon color', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#686868',
				'selectors' 	=> [
					'{{WRAPPER}} .awp-advanced-heading-icon span' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'advanced_heading_icon_background',
			[
				'label' 		=> __( 'Icon background', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#ffffff',
				'selectors' 	=> [
					'{{WRAPPER}} .awp-advanced-heading-icon span' => 'background: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'advanced_heading_icon_gap',
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
					'{{WRAPPER}} .awp-advanced-heading-icon' => 'padding: {{SIZE}}{{UNIT}} 0;',
				],
			]
		);
		
		$this->add_responsive_control(
			'advanced_heading_icon_border_radius',
			[
				'label' => __( 'Border Radius', 'attesa-extra' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .awp-advanced-heading-icon span' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'advanced_heading_subtitle_style',
			[
				'label' => __( 'Subtitle style', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_responsive_control(
			'advanced_heading_subtitle_align',
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
						'justify' => [
							'title' => __( 'Justify', 'attesa-extra' ),
							'icon' => 'fa fa-align-justify',
						],
					],
					'default' => 'center',
					'toggle' => true,
					'selectors' => [
						'{{WRAPPER}} .awp-advanced-heading-subtitle' => 'text-align: {{VALUE}};',
					],
				]
		);
		
		$this->add_responsive_control(
			'advanced_heading_subtitle_gap',
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
					'{{WRAPPER}} .awp-advanced-heading-subtitle' => 'padding: {{SIZE}}{{UNIT}} 0;',
				],
			]
		);
		
		$this->add_control(
			'advanced_heading_subtitle_color',
			[
				'label' 		=> __( 'Subtitle color', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#D8D8D8',
				'selectors' 	=> [
					'{{WRAPPER}} .awp-advanced-heading-subtitle' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'advanced_heading_subtitle_typography',
				'selector' 	=> '{{WRAPPER}} .awp-advanced-heading-subtitle' ,
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		$firstTitle = $settings['advanced_heading_first'];
		$secondTitle = $settings['advanced_heading_second'];
		$subTitle = $settings['advanced_heading_subtitle'];
		$htmlTag = $settings['advanced_heading_htmltag'];
		?>
			<div id="awp-advanced-heading" class="attesa-extra-advanced-heading-wrap">
			
				<?php if($settings['advanced_heading_show_icon'] == 'yes' && $settings['advanced_heading_icon_position'] == 'top'): ?>
					<div class="awp-advanced-heading-icon">
						<span><?php Icons_Manager::render_icon( $settings['advanced_heading_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
					</div>
				<?php endif; ?>
				
				<<?php echo attesa_extra_allowed_tags_title($htmlTag); ?> class="awp-advanced-heading-title">
					<span class="awp-advanced-heading-first-title"><?php echo $firstTitle; ?></span>
					<span class="awp-advanced-heading-second-title"><?php echo $secondTitle; ?></span>
				</<?php echo attesa_extra_allowed_tags_title($htmlTag); ?>>
				
				<?php if($settings['advanced_heading_show_icon'] == 'yes' && $settings['advanced_heading_icon_position'] == 'middle'): ?>
					<div class="awp-advanced-heading-icon">
						<span><?php Icons_Manager::render_icon( $settings['advanced_heading_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
					</div>
				<?php endif; ?>
				
				<?php if($subTitle): ?>
					<div class="awp-advanced-heading-subtitle"><?php echo $subTitle; ?></div>
				<?php endif; ?>
				
				<?php if($settings['advanced_heading_show_icon'] == 'yes' && $settings['advanced_heading_icon_position'] == 'bottom'): ?>
					<div class="awp-advanced-heading-icon">
						<span><?php Icons_Manager::render_icon( $settings['advanced_heading_icon'], [ 'aria-hidden' => 'true' ] ); ?></span>
					</div>
				<?php endif; ?>
				
			</div>
		<?php
	}
	
	protected function content_template() {
	}
}