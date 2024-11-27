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

class Attesa_Extra_Posts_Carousel extends Widget_Base {

	public function get_name() {
		return 'attesa-extra-posts';
	}

	public function get_title() {
		return __( 'Blog Posts Grid', 'attesa-extra' );
	}

	public function get_icon() {
		return 'awp-icon eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'attesa-elements' ];
	}
	
	public function get_style_depends() {
		return [ 'awp-posts-carousel' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_query_blog',
			[
				'label' => __( 'Query', 'attesa-extra' ),
			]
		);


		$this->add_control(
			'number',
			[
				'label' => __( 'Number of posts', 'attesa-extra' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 4,
			]
		);
		
		$this->add_control(
			'ignore_sticky_posts',
			[
				'label' => __( 'Ignore sticky posts', 'attesa-extra' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'attesa-extra' ),
				'label_off' => __( 'Off', 'attesa-extra' ),
				'return_value' => 'true',
				'default' => 'false',
			]
		);
    
		$this->add_control(
			'per_row',
			[
				'label' => __( 'Columns', 'attesa-extra' ),
				'type' => Controls_Manager::SELECT,
				'default' => '3',
				'options' => [
					'1' => __( '1', 'attesa-extra' ),
					'2' => __( '2', 'attesa-extra' ),
					'3' => __( '3', 'attesa-extra' ),
					'4' => __( '4', 'attesa-extra' ),
					'5' => __( '5', 'attesa-extra' ),
				],
			]
		);
		
		$this->add_control(
			'order_by',
			[
				'label' => __( 'Order by', 'attesa-extra' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'date',
				'options' => [
					'date' 	=> __( 'Date', 'attesa-extra' ),
					'rand' 	=> __( 'Random', 'attesa-extra' ),
					'comment_count' 	=> __( 'Number of comments', 'attesa-extra' ),
				],
			]
		);

		$this->add_control(
			'category',
			[
				'label' 	=> __( 'Categories', 'attesa-extra' ),
				'type' 		=> Controls_Manager::SELECT,
                'options' 	=> $this->get_cats(),				
				'default' 	=> 'all',
			]
		);
		
		$this->add_control(
			'show_images',
			[
				'label' => __( 'Show featured images (if exists)', 'attesa-extra' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'attesa-extra' ),
				'label_off' => __( 'Off', 'attesa-extra' ),
				'return_value' => 'yes',
				'default' => 'yes',
			]
		);
		
		$this->add_control(
			'show_meta',
			[
				'label' => __( 'Show Meta', 'attesa-extra' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'attesa-extra' ),
				'label_off' => __( 'Off', 'attesa-extra' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'author',
			[
				'label' 		=> __( 'Author Meta', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'true',
				'options' 		=> [
					'true' 		=> __( 'Show', 'attesa-extra' ),
					'false' 	=> __( 'Hide', 'attesa-extra' ),
				],
				'condition' => [
					'show_meta' => 'yes',
				],
			]
		);

		$this->add_control(
			'date',
			[
				'label' 		=> __( 'Date Meta', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'true',
				'options' 		=> [
					'true' 		=> __( 'Show', 'attesa-extra' ),
					'false' 	=> __( 'Hide', 'attesa-extra' ),
				],
				'condition' => [
					'show_meta' => 'yes',
				],
			]
		);

		$this->add_control(
			'comments',
			[
				'label' 		=> __( 'Comments Meta', 'attesa-extra' ),
				'type' 			=> Controls_Manager::SELECT,
				'default' 		=> 'true',
				'options' 		=> [
					'true' 		=> __( 'Show', 'attesa-extra' ),
					'false' 	=> __( 'Hide', 'attesa-extra' ),
				],
				'condition' => [
					'show_meta' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'show_categories',
			[
				'label' => __( 'Show Categories', 'attesa-extra' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'attesa-extra' ),
				'label_off' => __( 'Off', 'attesa-extra' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
		
		$this->add_control(
			'show_limit',
			[
				'label' => __( 'Show Excerpt', 'attesa-extra' ),
				'type' => Controls_Manager::SWITCHER,
				'label_on' => __( 'On', 'attesa-extra' ),
				'label_off' => __( 'Off', 'attesa-extra' ),
				'return_value' => 'yes',
				'default' => 'no',
			]
		);
    
		$this->add_control(
			'limit',
			[
				'label' => __( 'Excerpt length', 'attesa-extra' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 20,
				],
				'range' => [
					'ms' => [
						'min' => 0,
						'max' => 100,
						'step' => 1,
					],
				],
				'condition' => [
					'show_limit' => 'yes',
				],
			]
		);
		
		$this->add_control(
			'image_size',
			[
				'label' => __( 'Image Size', 'attesa-extra' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'attesa-small',
				'options' => [
					'medium_large' 	=> __( 'Medium Large (768 x infinite height)', 'attesa-extra' ),
					'large' 	=> __( 'Large (1024 x 1024px)', 'attesa-extra' ),
					'attesa-small' 	=> __( 'Medium Small (500 x 270px)', 'attesa-extra' ),
					'thumbnail' => __( 'Thumbnail (150 x 150px)', 'attesa-extra' ),
					'full' => __( 'Original image size', 'attesa-extra' ),
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


		//Post titles styles
		$this->start_controls_section(
			'section_post_title_style',
			[
				'label' => __( 'Post title', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'name_color',
			[
				'label' 	=> __( 'Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .latest-news-wrapper article .attesa-extra-elementor-blog-title a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'post_title_typography',
				'selector' 	=> '{{WRAPPER}} .latest-news-wrapper article .attesa-extra-elementor-blog-title',
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);
		
		$this->add_control(
			'html_tag',
			[
				'label' => __( 'HTML Tag', 'attesa-extra' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'h4',
				'options' => [
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

		$this->end_controls_section();
		//End post titles styles

		//Content styles
		$this->start_controls_section(
			'section_content_style',
			[
				'label' => __( 'Post content', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'content_color',
			[
				'label' 	=> __( 'Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .latest-news-wrapper article .post-excerpt,{{WRAPPER}} .latest-news-wrapper article .elementor-cat-links' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'content_typography',
				'selector' 	=> '{{WRAPPER}} .latest-news-wrapper article .post-excerpt',
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
		//End content styles
		
		//Categories styles
		$this->start_controls_section(
			'section_categories_style',
			[
				'label' => __( 'Categories content', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'categories_color',
			[
				'label' 	=> __( 'Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .latest-news-wrapper article .elementor-cat-links a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'categories_typography',
				'selector' 	=> '{{WRAPPER}} .latest-news-wrapper article .elementor-cat-links',
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
		//End categories styles
		
		//Meta styles
		$this->start_controls_section(
			'section_meta_style',
			[
				'label' => __( 'Meta content', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_control(
			'meta_color',
			[
				'label' 	=> __( 'Color', 'attesa-extra' ),
				'type' 		=> Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .awp-blog-grid-meta a, .awp-blog-grid-meta' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' 		=> 'meta_typography',
				'selector' 	=> '.awp-blog-grid-meta',
				'global'	=> [
					'default' => Global_Typography::TYPOGRAPHY_TEXT,
				],
			]
		);

		$this->end_controls_section();
		//End meta styles
    	
		//Post spacing
		$this->start_controls_section(
			'section_post_spacing',
			[
				'label' => __( 'Post spacing', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'post_spacing',
			[
				'label' => __( 'Spacing', 'attesa-extra' ),
				'type' => Controls_Manager::DIMENSIONS,
				'size_units' => [ 'px', '%', 'em' ],
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
					'right' => 10,
					'bottom' => 15,
					'left' => 10,
					'unit' => 'px',
					'isLinked' => false,
				],
				'mobile_default' => [	
					'top' => 10,
					'right' => 0,
					'bottom' => 10,
					'left' => 0,
					'unit' => 'px',
					'isLinked' => false,
				],	
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-blog-posts-elementor article' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		//End post spacing
		
		//Post spacing
		$this->start_controls_section(
			'section_image_border_radius',
			[
				'label' => __( 'Images Border Radius', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		$this->add_responsive_control(
			'border_radius',
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
				'selectors' => [
					'{{WRAPPER}} .attesa-extra-blog-posts-elementor article .entry-thumb img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->end_controls_section();
		//End post spacing
		
		//Alignment
		$this->start_controls_section(
			'section_alignment',
			[
				'label' => __( 'Text Alignment', 'attesa-extra' ),
				'tab' 	=> Controls_Manager::TAB_STYLE,
			]
		);
		
		$this->add_control(
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
						'{{WRAPPER}} .attesa-extra-blog-posts-elementor article' => 'text-align: {{VALUE}};',
					],
				]
		);
		
		$this->end_controls_section();
		//End alignment


	}	
	
	protected function get_cats() {
		$all = array(
			'all' => 'All Categories'
		);
		$args = array( 'hide_empty' => false );
		$terms = get_terms('category',$args);
		foreach ( $terms as $term => $key ) {
			$all[$key->term_id] = $key->name;
		}
		return $all;
	}

	protected function render() {
		$settings = $this->get_settings();
		$show_images = $settings['show_images'];
		$show_categories = $settings['show_categories'];
		$show_meta = $settings['show_meta'];
		$show_limit = $settings['show_limit'];
		$limit = $settings['limit']['size'];
		$per_row = $settings['per_row'];
		$image_size = $settings['image_size'];
		$tag = $settings['html_tag'];
		if ($settings['category'] == 'all') {
			$r = new \WP_Query( array(
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'orderby'			=> $settings['order_by'],
				'posts_per_page'	  => $settings['number'],
				'ignore_sticky_posts' => $settings['ignore_sticky_posts']	
			) );
		} else {
			$r = new \WP_Query( array(
				'no_found_rows'       => true,
				'post_status'         => 'publish',
				'cat'		  		  => $settings['category'],
				'orderby' 			=> $settings['order_by'],
				'posts_per_page'	  => $settings['number'],
				'ignore_sticky_posts' => $settings['ignore_sticky_posts']
			) );
		}

		if ( $r->have_posts() ) :
		?>

		<div class="attesa-extra-blog-posts-elementor number-columns-<?php echo absint( $per_row ); ?>">
			<div class="latest-news-wrapper">
				<?php while ( $r->have_posts() ) : $r->the_post(); ?>
					<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
						<?php if ( '' != get_the_post_thumbnail() && $show_images == 'yes' ) : ?>
						<div class="entry-thumb"><a href="<?php echo esc_url(get_permalink()); ?>">
							<?php echo get_the_post_thumbnail(get_the_ID() ,esc_attr($image_size)); ?>
						</a></div>	
						<?php endif; ?>
						<?php if ($show_meta == 'yes'): ?>
						<div class="awp-blog-grid-meta">

							<?php if ( 'true' == $settings['author'] ) { ?>
								<span class="meta-author"><i class="fa fas fa-user spaceLeftRight"></i><?php echo the_author_posts_link(); ?></span>
							<?php } ?>

							<?php if ( 'true' == $settings['date'] ) { ?>
								<span class="meta-date"><i class="fa fas fa-clock spaceLeftRight"></i><?php echo get_the_date(); ?></span>
							<?php } ?>

							<?php if ( 'true' == $settings['comments'] && comments_open() && ! post_password_required() ) { ?>
								<span class="meta-comments"><i class="fa fas fa-comments spaceLeftRight"></i><?php comments_popup_link( esc_html__( '0 Comments', 'attesa-extra' ), esc_html__( '1 Comment',  'attesa-extra' ), esc_html__( '% Comments', 'attesa-extra' ), 'comments-link' ); ?></span>
							<?php } ?>

						</div>
						<?php endif; ?>
						<?php if ($show_categories == 'yes'):
							$categories_list = get_the_category_list( ' &bull; ' );
							if ( $categories_list ) {
								echo '<span class="elementor-cat-links">' . $categories_list . '</span>';
							}
						endif; ?>
						<?php the_title( sprintf( '<'.attesa_extra_allowed_tags_title($tag).' class="entry-title attesa-extra-elementor-blog-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></'.attesa_extra_allowed_tags_title($tag).'>' ); ?>
						<?php if($show_limit == 'yes'): ?>
							<div class="post-excerpt">
								<?php echo wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), $limit ); ?>
							</div>
						<?php endif; ?>
					</article>
				<?php endwhile; ?>
			</div>
		</div>

		<?php 
		wp_reset_postdata();
		endif;
	}

	protected function content_template() {
	}
}