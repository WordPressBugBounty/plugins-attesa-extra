<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class AttesaExtraComments extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'AttesaExtraComments',
			esc_html__( 'Attesa Recent Comments with avatar', 'attesa-extra' ),
			array( 
				'classname' => 'AttesaExtraComments',
				'description' => esc_html__( 'Displays a list of recent comments with avatar', 'attesa-extra' ),
				'customize_selective_refresh' => true,
			)
		);
	}
	private static function attesa_latestcomm_defaults() {
		$defaults = array(
			'title' => esc_html__('Latest Comments', 'attesa-extra'),
			'dis_posts' => '3',
		);
		return $defaults;
	}
	public function form($instance) {              
		$instance = wp_parse_args( (array) $instance, self::attesa_latestcomm_defaults() );
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		$dis_posts = ! empty( $instance['dis_posts'] ) ? $instance['dis_posts'] : '3';
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'attesa-extra'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('dis_posts')); ?>"><?php esc_html_e('Number of Comments to display:', 'attesa-extra'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('dis_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('dis_posts')); ?>" type="number" value="<?php echo intval( $dis_posts ); ?>" />
			</p>
		<?php 
	}
	public function widget($args, $instance) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, self::attesa_latestcomm_defaults() );
		$title = apply_filters( 'widget_title', $instance[ 'title' ], $args, $instance );
		$dis_posts = $instance['dis_posts'];
		?>
		<?php
		echo $before_widget;
		if ( $title ) {echo $before_title . $title . $after_title; } ?>
			<ul>
				<?php
				$args = array( 'number' => intval($dis_posts), 'status' => 'approve', 'type' => 'comment');
				$comments_cresta = get_comments( $args );
				foreach( $comments_cresta as $comment_cresta ) : ?>
				<li class="attesaPostWidget">
				<div class="theImgWidget">
					<?php echo get_avatar( $comment_cresta, 70 ); ?>
				</div>
					<div class="theText">
						<span class="date">
							<i class="<?php attesa_fontawesome_icons('general_prefix'); ?> fa-user spaceRight"></i>
							<?php echo esc_html($comment_cresta->comment_author); ?> <?php esc_html_e('on:', 'attesa-extra'); ?>
						</span>
						<a href="<?php echo esc_url(get_permalink($comment_cresta->comment_post_ID )); ?>#comment-<?php echo esc_attr($comment_cresta->comment_ID); ?>" title="<?php echo wp_trim_words( get_the_title($comment_cresta->comment_post_ID), 7 ); ?>">
							<?php echo wp_trim_words( get_the_title($comment_cresta->comment_post_ID), 7 ); ?>
						</a>
					</div>
				</li>
				<?php endforeach; ?>
			</ul>
		<?php echo $after_widget; ?>
	<?php
    }
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		$instance[ 'dis_posts' ] = strip_tags( $new_instance[ 'dis_posts' ] );
		return $instance;
	}
}
register_widget( 'AttesaExtraComments' );