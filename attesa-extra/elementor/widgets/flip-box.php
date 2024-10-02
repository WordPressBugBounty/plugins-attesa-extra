<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Background;
use Elementor\Core\Schemes\Typography;
use Elementor\Icons_Manager;
use Elementor\Controls_Stack;

class Attesa_Extra_Flip_Box extends Widget_Base {
	
	public function get_name() {
		return 'attesa-extra-flip-box';
	}

	public function get_title() {
		return __( 'Flip Box', 'attesa-extra' );
	}

	public function get_icon() {
		return 'awp-icon eicon-flip-box';
	}

	public function get_categories() {
		return [ 'attesa-elements' ];
	}
	
	public function get_style_depends() {
		return [ 'awp-flip-box' ];
	}
	
	protected function register_controls() {
		
		$this->start_controls_section(
			'section_flip_box_general',
			[
				'label' => __( 'Flip Box', 'attesa-extra' ),
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_width',
			[
				'label' 		=> __( 'Width', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'default' => [
					'unit' => '%',
					'size' => 100,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
					'%' => [
						'min' => 0,
						'max' => 100,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container' => 'width: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_height',
			[
				'label' 		=> __( 'Height', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 400,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 1000,
						'step' => 5,
					],
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container' => 'height: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_content_position',
			[
				'label' 		=> __( 'Content Position', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'center',
				'options' 		=> [
					'flex-start' 		=> __( 'Top', 'attesa-extra' ),
					'center' 			=> __( 'Center', 'attesa-extra' ),
					'flex-end' 		=> __( 'Bottom', 'attesa-extra' ),
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-filp-box-front' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}} .awp-flip-box-container .awp-filp-box-back' => 'justify-content: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_content_flip',
			[
				'label' => __( 'Flip', 'attesa-extra' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'horizontal',
				'options' => [
					'horizontal' 	=> __( 'Horizontal', 'attesa-extra' ),
					'vertical' 	=> __( 'Vertical', 'attesa-extra' ),
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_flip_box_front',
			[
				'label' => __( 'Front side', 'attesa-extra' ),
			]
		);
		
		$this->add_control(
			'section_flip_box_front_use_icon',
			[
				'label' => __( 'Use icon', 'attesa-extra' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'section_flip_box_front_custom_icon',
			[
				'label' => __( 'Icon', 'attesa-extra' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-grin-squint-tears',
					'library' => 'regular',
				],
				'condition' => [
					'section_flip_box_front_use_icon' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_front_title',
			[
				'label' => __( 'Title', 'attesa-extra' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Title', 'attesa-extra' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_front_content',
			[
				'label' => __( 'Content', 'attesa-extra' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus non leo pretium, tempus tellus et, pellentesque ligula. Suspendisse potenti.', 'attesa-extra' ),
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_flip_box_back',
			[
				'label' => __( 'Back side', 'attesa-extra' ),
			]
		);
		
		$this->add_control(
			'section_flip_box_back_use_icon',
			[
				'label' => __( 'Use icon', 'attesa-extra' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'section_flip_box_back_custom_icon',
			[
				'label' => __( 'Icon', 'attesa-extra' ),
				'type' => Controls_Manager::ICONS,
				'default' => [
					'value' => 'far fa-grimace',
					'library' => 'regular',
				],
				'condition' => [
					'section_flip_box_back_use_icon' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_back_title',
			[
				'label' => __( 'Title', 'attesa-extra' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Title', 'attesa-extra' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_back_content',
			[
				'label' => __( 'Content', 'attesa-extra' ),
				'type' => Controls_Manager::WYSIWYG,
				'default' => __( 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus non leo pretium, tempus tellus et, pellentesque ligula. Suspendisse potenti.', 'attesa-extra' ),
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_flip_box_general_style',
			[
				'label' => __( 'Flip Box', 'attesa-extra' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_general_padding',
			[
				'label' 		=> __( 'Padding', 'attesa-extra' ),
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
					'{{WRAPPER}} .awp-flip-box-container .awp-filp-box-front' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .awp-flip-box-container .awp-filp-box-back' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_general_border_radius',
			[
				'label' => __( 'Border Radius', 'attesa-extra' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .awp-flip-box-container .awp-filp-box-front' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .awp-flip-box-container .awp-filp-box-back' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_flip_box_front_style',
			[
				'label' => __( 'Front side', 'attesa-extra' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);
		
		$this->add_control(
			'section_flip_box_front_style_iconcolor',
			[
				'label' 		=> __( 'Icon Color', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#000000',
				'condition' => [
					'section_flip_box_front_use_icon' => 'yes',
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-front-icon' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_front_style_iconsize',
			[
				'label' 		=> __( 'Icon size', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'separator' 	=> 'after',
				'condition' => [
					'section_flip_box_front_use_icon' => 'yes',
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-front-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_front_style_titlemargin',
			[
				'label' 		=> __( 'Title margin', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_front_title',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-front-title' => 'padding: {{SIZE}}{{UNIT}} 0;',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' 		=> __( 'Title Typography', 'attesa-extra' ),
				'name' 			=> 'section_flip_box_front_style_titletypo',
				'selector' 		=> '{{WRAPPER}} .awp-flip-box-container .awp-flip-box-front-title',
				'scheme' 		=> Typography::TYPOGRAPHY_1,
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_front_title',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_front_style_titlecolor',
			[
				'label' 		=> __( 'Title Color', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#E18C25',
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-front-title' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_front_title',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_front_style_titletag',
			[
				'label' => __( 'Title Tag', 'attesa-extra' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1' => __( 'H1', 'attesa-extra' ),
					'h2' => __( 'H2', 'attesa-extra' ),
					'h3' => __( 'H3', 'attesa-extra' ),
					'h4' => __( 'H4', 'attesa-extra' ),
					'h5' => __( 'H5', 'attesa-extra' ),
					'h6' => __( 'H6', 'attesa-extra' ),
					'div' => __( 'div', 'attesa-extra' ),
					'span' => __( 'span', 'attesa-extra' ),
				],
				'separator' 	=> 'after',
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_front_title',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' 		=> __( 'Content Typography', 'attesa-extra' ),
				'name' 			=> 'section_flip_box_front_style_contenttypo',
				'selector' 		=> '{{WRAPPER}} .awp-flip-box-container .awp-flip-box-front-content',
				'scheme' 		=> Typography::TYPOGRAPHY_1,
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_front_content',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_front_style_contentmargin',
			[
				'label' 		=> __( 'Content margin', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_front_content',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-front-content' => 'padding: {{SIZE}}{{UNIT}} 0;',
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_front_style_contentcolor',
			[
				'label' 		=> __( 'Content Color', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#959595',
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-front-content' => 'color: {{VALUE}};',
				],
				'separator' 	=> 'after',
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_front_content',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_front_style_align',
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
						'{{WRAPPER}} .awp-flip-box-container .awp-filp-box-front' => 'text-align: {{VALUE}};',
					],
				]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'section_flip_box_front_style_background',
				'label' => __( 'Background', 'attesa-extra' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awp-flip-box-container .awp-filp-box-front',
			]
		);
		
		$this->end_controls_section();
		
		$this->start_controls_section(
			'section_flip_box_back_style',
			[
				'label' => __( 'Back side', 'attesa-extra' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'show_label' => false,
			]
		);
		
		$this->add_control(
			'section_flip_box_back_style_iconcolor',
			[
				'label' 		=> __( 'Icon Color', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#000000',
				'condition' => [
					'section_flip_box_back_use_icon' => 'yes',
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-back-icon' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_back_style_iconsize',
			[
				'label' 		=> __( 'Icon size', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 60,
				],
				'separator' 	=> 'after',
				'condition' => [
					'section_flip_box_back_use_icon' => 'yes',
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-back-icon' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_back_style_titlemargin',
			[
				'label' 		=> __( 'Title margin', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 20,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_back_title',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-back-title' => 'padding: {{SIZE}}{{UNIT}} 0;',
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' 		=> __( 'Title Typography', 'attesa-extra' ),
				'name' 			=> 'section_flip_box_back_style_titletypo',
				'selector' 		=> '{{WRAPPER}} .awp-flip-box-container .awp-flip-box-back-title',
				'scheme' 		=> Typography::TYPOGRAPHY_1,
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_back_title',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_back_style_titlecolor',
			[
				'label' 		=> __( 'Title Color', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#E18C25',
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-back-title' => 'color: {{VALUE}};',
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_back_title',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_back_style_titletag',
			[
				'label' => __( 'Title Tag', 'attesa-extra' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h3',
				'options' => [
					'h1' => __( 'H1', 'attesa-extra' ),
					'h2' => __( 'H2', 'attesa-extra' ),
					'h3' => __( 'H3', 'attesa-extra' ),
					'h4' => __( 'H4', 'attesa-extra' ),
					'h5' => __( 'H5', 'attesa-extra' ),
					'h6' => __( 'H6', 'attesa-extra' ),
					'div' => __( 'div', 'attesa-extra' ),
					'span' => __( 'span', 'attesa-extra' ),
				],
				'separator' 	=> 'after',
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_back_title',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'label' 		=> __( 'Content Typography', 'attesa-extra' ),
				'name' 			=> 'section_flip_box_back_style_contenttypo',
				'selector' 		=> '{{WRAPPER}} .awp-flip-box-container .awp-flip-box-back-content',
				'scheme' 		=> Typography::TYPOGRAPHY_1,
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_back_content',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_back_style_contentmargin',
			[
				'label' 		=> __( 'Content margin', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SLIDER,
				'size_units' => [ 'px' ],
				'default' => [
					'unit' => 'px',
					'size' => 10,
				],
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_back_content',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-back-content' => 'padding: {{SIZE}}{{UNIT}} 0;',
				],
			]
		);
		
		$this->add_control(
			'section_flip_box_back_style_contentcolor',
			[
				'label' 		=> __( 'Content Color', 'attesa-extra' ),
				'type' 			=> Controls_Manager::COLOR,
				'default'		=> '#959595',
				'selectors' 	=> [
					'{{WRAPPER}} .awp-flip-box-container .awp-flip-box-back-content' => 'color: {{VALUE}};',
				],
				'separator' 	=> 'after',
				'conditions' => [
					'terms' => [
						[
							'name' => 'section_flip_box_back_content',
							'operator' => '!=',
							'value' => '',
						]
					]
				],
			]
		);
		
		$this->add_responsive_control(
			'section_flip_box_back_style_align',
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
						'{{WRAPPER}} .awp-flip-box-container .awp-filp-box-back' => 'text-align: {{VALUE}};',
					],
				]
		);
		
		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'section_flip_box_back_style_background',
				'label' => __( 'Background', 'attesa-extra' ),
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .awp-flip-box-container .awp-filp-box-back',
			]
		);
		
		$this->end_controls_section();
		
	}
	
	protected function render() {
		$settings = $this->get_settings_for_display();
		$titleFront = $settings['section_flip_box_front_title'];
		$contentFront = $settings['section_flip_box_front_content'];
		$titleBack = $settings['section_flip_box_back_title'];
		$contentBack = $settings['section_flip_box_back_content'];
		$flipStyle = $settings['section_flip_box_content_flip'];
		?>
		<div class="awp-flip-box-container flip_<?php echo esc_attr($flipStyle); ?>">
			<div class="awp-flip-box-inner">
				<div class="awp-filp-box-front">
					<div class="awp-flip-box-internal">
						<?php if ($settings['section_flip_box_front_use_icon'] == 'yes' ): ?>
							<div class="awp-flip-box-front-icon"><?php Icons_Manager::render_icon( $settings['section_flip_box_front_custom_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
						<?php endif; ?>
						<?php if($titleFront): ?>
							<<?php echo attesa_extra_allowed_tags_title($settings['section_flip_box_front_style_titletag']); ?> class="awp-flip-box-front-title"><?php echo $titleFront; ?></<?php echo attesa_extra_allowed_tags_title($settings['section_flip_box_front_style_titletag']); ?>>
						<?php endif; ?>
						<?php if($contentFront): ?>
							<div class="awp-flip-box-front-content"><?php echo $contentFront; ?></div>
						<?php endif; ?>
					</div>
				</div>
				<div class="awp-filp-box-back">
					<div class="awp-flip-box-internal">
						<?php if ($settings['section_flip_box_back_use_icon'] == 'yes' ): ?>
							<div class="awp-flip-box-back-icon"><?php Icons_Manager::render_icon( $settings['section_flip_box_back_custom_icon'], [ 'aria-hidden' => 'true' ] ); ?></div>
						<?php endif; ?>
						<?php if($titleBack): ?>
							<<?php echo attesa_extra_allowed_tags_title($settings['section_flip_box_back_style_titletag']); ?> class="awp-flip-box-back-title"><?php echo $titleBack; ?></<?php echo attesa_extra_allowed_tags_title($settings['section_flip_box_back_style_titletag']); ?>>
						<?php endif; ?>
						<?php if($contentBack): ?>
							<div class="awp-flip-box-back-content"><?php echo $contentBack; ?></div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
		<?php
	}
	
	protected function content_template() {
	}
}