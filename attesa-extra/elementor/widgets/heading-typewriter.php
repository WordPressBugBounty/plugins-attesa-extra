<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Controls_Manager;
use Elementor\Scheme_Color;
use Elementor\Widget_Base;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;
use Elementor\Controls_Stack;

class Attesa_Extra_Heading_Typewriter extends Widget_Base {
	
	public function get_name() {
		return 'attesa-heading-typewriter';
	}

	public function get_title() {
		return __( 'Heading Typewriter', 'attesa-extra' );
	}

	public function get_icon() {
		return 'awp-icon eicon-heading';
	}

	public function get_categories() {
		return [ 'attesa-elements' ];
	}
	
	public function get_style_depends() {
		return [ 'awp-heading-typewriter' ];
	}
	
	public function get_script_depends() {
		return [ 'awp-heading-typewriter', 'typed' ];
	}
	
	protected function register_controls() {
		$this->start_controls_section(
			'section_title_heading',
			[
				'label' => __( 'Titles Typewriter', 'attesa-extra' ),
				'tab' => Controls_Manager::TAB_CONTENT,
			]
		);
		
		$this->add_control(
			'before_text',
			[
				'label' => __( 'Text Before', 'attesa-extra' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Text before', 'attesa-extra' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		
		$repeater = new \Elementor\Repeater();
		
		$repeater->add_control(
			'title_text',
			[
				'label' => __( 'Title', 'attesa-extra' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'placeholder' => __( 'Heading Text', 'attesa-extra' ),
				'default' => __( 'Heading Text', 'attesa-extra' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);
		
		$this->add_control(
			'type_list',
			[
				'label' => '',
				'type' => Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),
				'default' => [
					[
						'title_text' => __( 'Heading Text #1', 'attesa-extra' ),
					],
					[
						'title_text' => __( 'Heading Text #2', 'attesa-extra' ),
					],
				],
				'title_field' => '{{{ title_text }}}',
			]
		);
		
		$this->add_control(
			'after_text',
			[
				'label' => __( 'Text After', 'attesa-extra' ),
				'type' => Controls_Manager::TEXT,
				'label_block' => true,
				'default' => __( 'Text after', 'attesa-extra' ),
				'dynamic' => [
					'active' => true,
				],
				'separator' => 'after',
			]
		);
		
		$this->add_control(
			'type_speed',
			[
				'label'     	=> __( 'Type Speed', 'attesa-extra' ),
				'type'      	=> Controls_Manager::NUMBER,
				'default'   	=> 70,
				'min'       	=> 10,
				'max'       	=> 100,
				'step'      	=> 5,
			]
		);
		
		$this->add_control(
			'start_delay',
			[
				'label'     	=> __( 'Start Delay', 'attesa-extra' ),
				'type'      	=> Controls_Manager::NUMBER,
				'default'   	=> 1,
				'min'       	=> 1,
				'max'       	=> 100,
				'step'      	=> 1,
			]
		);
		
		$this->add_control(
			'back_speed',
			[
				'label'     	=> __( 'Back Speed', 'attesa-extra' ),
				'type'      	=> Controls_Manager::NUMBER,
				'default'   	=> 30,
				'min'       	=> 0,
				'max'       	=> 100,
				'step'      	=> 2,
			]
		);
		
		$this->add_control(
			'back_delay',
			[
				'label'     	=> __( 'Back Delay', 'attesa-extra' ) . ' (ms)',
				'type'      	=> Controls_Manager::NUMBER,
				'default'   	=> 1500,
				'min'       	=> 0,
				'max'       	=> 3000,
				'step'      	=> 50,
			]
		);

		$this->add_control(
			'loop',
			[
				'label' => __( 'Loop writing effect', 'attesa-extra' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'off' => __( 'Off', 'attesa-extra' ),
				'on' => __( 'On', 'attesa-extra' ),
				'separator' => 'after',
			]
		);
		
		$this->add_control(
			'html_tag',
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
		
		$this->add_responsive_control(
			'text-align',
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
						'{{WRAPPER}} .attesa-extra-heading-typewriter-wrap .attesa-extra-headline-typewriter' => 'text-align: {{VALUE}};',
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
		
		//General text styles
		$this->start_controls_section(
			'section_typohrapy_style',
			[
				'label' => __( 'Typohrapy text', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'typewriter_typography',
				'selector' 	=> '{{WRAPPER}} .attesa-extra-heading-typewriter-wrap .attesa-extra-headline-typewriter' ,
				'scheme' 	=> Typography::TYPOGRAPHY_3,
			]
		);
		
		$this->end_controls_section();
		
		//Typewriter text styles
		$this->start_controls_section(
			'section_typewriter_style',
			[
				'label' => __( 'Typewriter text', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'typewriter_color',
			[
				'label' 	=> __( 'Text Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-heading-typewriter-wrap .attesa-extra-heading-typewriter, {{WRAPPER}} .attesa-extra-heading-typewriter-wrap .typed-cursor' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		//Before text styles
		$this->start_controls_section(
			'section_typewriter_style_before',
			[
				'label' => __( 'Before text', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'typewriter_color_before',
			[
				'label' 	=> __( 'Text Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-heading-typewriter-wrap .attesa-extra-heading-typewriter-before' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
		
		//After text styles
		$this->start_controls_section(
			'section_typewriter_style_after',
			[
				'label' => __( 'After text', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
			'typewriter_color_after',
			[
				'label' 	=> __( 'Text Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-heading-typewriter-wrap .attesa-extra-heading-typewriter-after' => 'color: {{VALUE}};',
				],
			]
		);
		
		$this->end_controls_section();
	}
	
	protected function render() {
		$id         = $this->get_id();
		$settings = $this->get_settings();
		$before = $settings['before_text'];
		$after = $settings['after_text'];
		$tag = $settings['html_tag'];
		$writeText = '';
		$copy = $settings['type_list'];
		foreach ( $settings['type_list'] as $index => $item ) {
			$singleText[] = $item['title_text'];
		}
		$writeText = implode( '#next#', $singleText);
		$writeText = explode( '#next#', $writeText );
		
		$this->add_render_attribute( 'headline',
			[
				'class' => 'attesa-extra-headline-typewriter',
			]
		);
		?>
		<div data-id="<?php echo esc_attr( $id ); ?>" data-typespeed="<?php echo esc_attr( $settings['type_speed'] ); ?>" data-strings='<?php echo json_encode( $writeText ); ?>' data-startdelay="<?php echo esc_attr( $settings['start_delay'] ); ?>" data-backspeed="<?php echo esc_attr( $settings['back_speed'] ); ?>" data-backdelay="<?php echo esc_attr( $settings['back_delay'] ); ?>" data-loop="<?php echo ( 'yes' == $settings['loop'] ) ? 'true' : 'false'; ?>" class="attesa-extra-heading-typewriter-wrap" id="extra-heading-id-<?php echo esc_attr( $id ); ?>">
			<<?php echo attesa_extra_allowed_tags_title($tag); ?> <?php echo $this->get_render_attribute_string( 'headline' ); ?>>
				<?php if($before): ?>
					<span class="attesa-extra-heading-typewriter-before"><?php echo wp_kses_post($before); ?></span>
				<?php endif; ?>
				<?php if($writeText): ?>
					<span class="attesa-extra-heading-typewriter"></span>
				<?php endif; ?>
				<?php if($after): ?>
					<span class="attesa-extra-heading-typewriter-after"><?php echo wp_kses_post($after); ?></span>
				<?php endif; ?>
			</<?php echo attesa_extra_allowed_tags_title($tag); ?>>
		</div>
		<?php
	}
	
	protected function content_template() {
	}
	
}