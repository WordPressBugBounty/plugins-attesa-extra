<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class AttesaExtraRecent extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'AttesaExtraRecent',
			esc_html__( 'Attesa Recent Posts with thumbnails', 'attesa-extra' ),
			array( 
				'classname' => 'AttesaExtraRecent',
				'description' => esc_html__( 'Displays a list of your latest posts with thumbnails', 'attesa-extra' ),
				'customize_selective_refresh' => true,
			)
		);
	}
	private static function attesa_recentposts_defaults() {
		$defaults = array(
			'title' => esc_html__('Recent posts', 'attesa-extra'),
			'dis_posts' => '3',
			'cat_filter' => '',
		);
		return $defaults;
	}
	public function form($instance) {              
		$instance = wp_parse_args( (array) $instance, self::attesa_recentposts_defaults() );
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$dis_posts = ! empty( $instance['dis_posts'] ) ? $instance['dis_posts'] : '3';
		$cat_filter = ! empty( $instance['cat_filter'] ) ? $instance['cat_filter'] : '';
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'attesa-extra'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('dis_posts')); ?>"><?php esc_html_e('Number of Posts Displayed:', 'attesa-extra'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('dis_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('dis_posts')); ?>" type="number" value="<?php echo intval( $dis_posts ); ?>" />
			</p>
			<p>
			<label for="<?php echo esc_attr($this->get_field_id('cat_filter')); ?>"><?php esc_html_e('Category filter (optional):', 'attesa-extra'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('cat_filter')); ?>" name="<?php echo esc_attr($this->get_field_name('cat_filter')); ?>" type="text" value="<?php echo esc_attr( $cat_filter ); ?>" />
				<span class="description"><?php esc_html_e('If you want to view only posts from some categories, add the category IDs separated by a comma (example: 15,42,12)', 'attesa-extra'); ?></span>
			</p>
		<?php 
	}
	public function widget($args, $instance) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, self::attesa_recentposts_defaults() );
		$title = apply_filters( 'widget_title', $instance[ 'title' ], $args, $instance );
		$dis_posts = $instance['dis_posts'];
		$cat_filter = $instance['cat_filter'];
		?>
		<?php
		echo $before_widget;
		if ( $title ) {echo $before_title . $title . $after_title; } ?>
		<ul>
			<?php
			$args = array( 'posts_per_page' => intval($dis_posts), 'ignore_sticky_posts' => 1, 'cat'=> esc_attr($cat_filter));
			$myposts = new WP_Query( $args );
			while( $myposts->have_posts() ) : $myposts->the_post(); ?>
			<li class="attesaPostWidget">
				<?php if ( '' != get_the_post_thumbnail() ) : ?>
					<div class="theImgWidget">
						<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
							<?php the_post_thumbnail('attesa-box-small', array( 'alt' => get_the_title())); ?>
						</a>
					</div>
				<?php endif; ?>
				<div class="theText"><span class="date"><i class="<?php attesa_fontawesome_icons('clock'); ?> spaceRight"></i><?php
					/* translators: %s: human-readable time difference */
					printf( _x( '%s ago', '%s = human-readable time difference', 'attesa-extra' ), human_time_diff( get_the_time( 'U' ), current_time( 'timestamp' ) ) ); ?></span>
					<a href="<?php the_permalink(); ?>"><?php echo wp_trim_words( get_the_title(), 7 ); ?></a>
				</div>
			</li>
			<?php endwhile; ?>
			<?php wp_reset_query(); ?>
		</ul>
		<?php echo $after_widget; ?>
	<?php
    }
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'dis_posts' ] = strip_tags( $new_instance[ 'dis_posts' ] );
		$instance[ 'cat_filter' ] = strip_tags( $new_instance[ 'cat_filter' ] );
		return $instance;
	}
}
register_widget( 'AttesaExtraRecent' );