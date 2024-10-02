<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
class AttesaSocial extends WP_Widget {
	public function __construct() {
		parent::__construct(
			'AttesaSocial',
			esc_html__( 'Attesa Social Buttons', 'attesa-extra' ),
			array( 
				'classname' => 'AttesaSocial',
				'description' => esc_html__( 'Displays the Social Network added in Theme Options', 'attesa-extra' ),
				'customize_selective_refresh' => true,
			)
		);
	}
	private static function attesa_socialbutton_defaults() {
		$defaults = array(
			'title' => esc_html__('We are on', 'attesa-extra'),
		);
		return $defaults;
	}
	public function form($instance) {              
		$instance = wp_parse_args( (array) $instance, self::attesa_socialbutton_defaults() );
		$title = ! empty( $instance['title'] ) ? $instance['title'] : '';
		?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:', 'attesa-extra'); ?></label>
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
			</p>
			<p>
				<?php esc_html_e('Add your social network in Appearance -> Customize -> Attesa Theme Options -> Social Buttons', 'attesa-extra'); ?>
			</p>
		<?php 
	}
	public function widget($args, $instance) {
		extract( $args );
		$instance = wp_parse_args( (array) $instance, self::attesa_socialbutton_defaults() );
		$title = apply_filters( 'widget_title', $instance[ 'title' ], $args, $instance );
		?>
		<?php
		echo $before_widget;
		if ( $title ) {echo $before_title . $title . $after_title; } ?>
			<div class="socialWidget"><?php echo attesa_show_social_network('widget'); ?></div>
		<?php echo $after_widget; ?>
	<?php
    }
	public function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		return $instance;
	}
}
register_widget( 'AttesaSocial' );