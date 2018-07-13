<?php
/**
 * Featured call to action widget.
 */

class ample_call_to_action_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname' => 'widget_call_to_action_block',
			'description' => __( 'Use this widget to show the call to action section.', 'ample' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = __( 'TG: Call To Action Widget', 'ample' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		$ample_defaults[ 'background_color' ] = '#80abc8';
		$ample_defaults[ 'background_image' ] = '';
		$ample_defaults[ 'bg_attachment' ] = 'scroll';
		$ample_defaults[ 'text_main' ] = '';
		$ample_defaults[ 'button_text' ] = '';
		$ample_defaults[ 'button_url' ] = '';

		$instance = wp_parse_args( (array) $instance, $ample_defaults );

		$background_color = esc_attr( $instance[ 'background_color' ] );
		$background_image = esc_url_raw( $instance[ 'background_image' ] );
		$bg_attachment = $instance[ 'bg_attachment' ];
		$text_main = esc_textarea( $instance[ 'text_main' ] );
		$button_text = esc_attr( $instance[ 'button_text' ] );
		$button_url = esc_url( $instance[ 'button_url' ] );
		?>
		<p>
			<strong><?php _e( 'DESIGN SETTINGS :', 'ample' ); ?></strong><br />
			<label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php _e( 'Background Color:', 'ample' ); ?></label><br />
			<input class="my-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" value="<?php echo  $background_color; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_image' ); ?>"> <?php esc_html_e( 'Background Image:', 'ample' ); ?> </label> <br />
		<div class="media-uploader" id="<?php echo $this->get_field_id( 'background_image' ); ?>">
			<div class="custom_media_preview">
				<?php if ( $background_image != '' ) : ?>
					<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'background_image' ] ); ?>" style="max-width:100%;" />
				<?php endif; ?>
			</div>
			<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'background_image' ); ?>" name="<?php echo $this->get_field_name( 'background_image' ); ?>" value="<?php echo esc_url( $instance[ 'background_image' ] ); ?>" style="margin-top:5px;" />
			<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'background_image' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'ample' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'ample' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'ample' ); ?></button>
		</div>
		</p>

		<p>
			<?php _e( 'Background attachment:', 'ample' ); ?><br />
			<input type="radio" <?php checked($bg_attachment, 'scroll') ?> id="<?php echo $this->get_field_id( 'bg_attachment' ); ?>" name="<?php echo $this->get_field_name( 'bg_attachment' ); ?>" value="scroll" /><?php _e( 'Scroll', 'ample' );?>
			<input type="radio" <?php checked($bg_attachment,'fixed') ?> id="<?php echo $this->get_field_id( 'bg_attachment' ); ?>" name="<?php echo $this->get_field_name( 'bg_attachment' ); ?>" value="fixed" style="margin-left:20px;"/><?php _e( 'Fixed', 'ample' );?>
		</p>

		<strong><?php _e( 'OTHER SETTINGS :', 'ample' ); ?></strong><br />

		<?php _e( 'Call to Action Main Text','ample' ); ?>
		<textarea class="widefat" rows="3" cols="20" id="<?php echo $this->get_field_id('text_main'); ?>" name="<?php echo $this->get_field_name('text_main'); ?>"><?php echo $text_main; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e( 'Button Text:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo $button_text; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id('button_url'); ?>"><?php _e( 'Button Redirect Link:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id('button_url'); ?>" name="<?php echo $this->get_field_name('button_url'); ?>" type="text" value="<?php echo $button_url; ?>" />
		</p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['background_color'] =  $new_instance['background_color'];
		$instance['background_image'] =  esc_url_raw( $new_instance['background_image'] );
		$instance['bg_attachment'] =  $new_instance['bg_attachment'];

		if ( current_user_can('unfiltered_html') )
			$instance['text_main'] =  $new_instance['text_main'];
		else
			$instance['text_main'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text_main']) ) ); // wp_filter_post_kses() expects slashed

		$instance[ 'button_text' ] = strip_tags( $new_instance[ 'button_text' ] );
		$instance[ 'button_url' ] = esc_url_raw( $new_instance[ 'button_url' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$background_color = isset( $instance[ 'background_color' ] ) ? $instance[ 'background_color' ] : '';
		$background_image = isset( $instance[ 'background_image' ] ) ? $instance[ 'background_image' ] : '';
		$bg_attachment = isset( $instance[ 'bg_attachment' ] ) ? $instance[ 'bg_attachment' ] : '';
		$text_main = empty( $instance['text_main'] ) ? '' : $instance['text_main'];
		$button_text = isset( $instance[ 'button_text' ] ) ? $instance[ 'button_text' ] : '';
		$button_url = isset( $instance[ 'button_url' ] ) ? $instance[ 'button_url' ] : '#';

		echo $before_widget;
		$bg_image_style = '';
		if ( !empty( $background_image ) ) {
			$bg_image_style .= 'background-image:url(' . $background_image . ');background-attachment:' . $bg_attachment . ';background-repeat:no-repeat;background-size:cover;';
		}else {
			$bg_image_style .= 'background-color:' . $background_color . ';';
		}?>
		<div class="call-to-action-content-wrapper clearfix" style="<?php echo $bg_image_style; ?>">
			<div class="inner-wrap">
				<?php if( !empty( $text_main ) ) { ?>
					<h3>
						<?php echo esc_html( $text_main );

						if( !empty( $button_text ) ) { ?>
							<a class="call-to-action-button" href="<?php echo $button_url; ?>" title="<?php echo esc_attr( $button_text ); ?>"><?php echo esc_html( $button_text ); ?></a>
						<?php } ?>
					</h3>
				<?php } ?>
			</div>
		</div>

		<?php echo $after_widget;
	}
}
