<?php
/**
 * Portfolio widget
 */

class ample_portfolio_widget extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'widget_portfolio_block',
			'description'                 => __( 'Display portfolio by using specific category', 'ample' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' => 250 );
		parent::__construct( false, $name = __( 'TG: Portfolio', 'ample' ), $widget_ops );
	}

	function form( $instance ) {
		$tg_defaults['background_color'] = '#80abc8';
		$tg_defaults['background_image'] = '';
		$tg_defaults['attachment']       = 'scroll';
		$tg_defaults['title']            = '';
		$tg_defaults['text']             = '';
		$tg_defaults['number']           = 4;
		$tg_defaults['category']         = '';
		$tg_defaults['button_text']      = '';
		$tg_defaults['button_url']       = '';

		$instance = wp_parse_args( (array) $instance, $tg_defaults );

		$background_color = esc_attr( $instance['background_color'] );
		$background_image = esc_url_raw( $instance['background_image'] );
		$attachment       = $instance['attachment'];
		$title            = esc_attr( $instance['title'] );
		$text             = esc_textarea( $instance['text'] );
		$number           = $instance['number'];
		$category         = $instance['category'];
		$button_text      = esc_attr( $instance['button_text'] );
		$button_url       = esc_url( $instance['button_url'] );
		?>
		<p>
			<strong><?php _e( 'DESIGN SETTINGS :', 'ample' ); ?></strong><br />
			<label for="<?php echo $this->get_field_id( 'background_color' ); ?>"><?php _e( 'Background Color:', 'ample' ); ?></label><br />
			<input class="my-color-picker" type="text" id="<?php echo $this->get_field_id( 'background_color' ); ?>" name="<?php echo $this->get_field_name( 'background_color' ); ?>" value="<?php echo $background_color; ?>" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'background_image' ); ?>"> <?php esc_html_e( 'Background Image:', 'ample' ); ?> </label>
			<br />
		<div class="media-uploader" id="<?php echo $this->get_field_id( 'background_image' ); ?>">
			<div class="custom_media_preview">
				<?php if ( $background_image != '' ) : ?>
					<img class="custom_media_preview_default" src="<?php echo esc_url( $instance['background_image'] ); ?>" style="max-width:100%;" />
				<?php endif; ?>
			</div>
			<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'background_image' ); ?>" name="<?php echo $this->get_field_name( 'background_image' ); ?>" value="<?php echo esc_url( $instance['background_image'] ); ?>" style="margin-top:5px;" />
			<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'background_image' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'ample' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'ample' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'ample' ); ?></button>
		</div>
		</p>

		<p>
			<?php _e( 'Background attachment:', 'ample' ); ?> <br />
			<input type="radio" <?php checked( $attachment, 'scroll' ) ?> id="<?php echo $this->get_field_id( 'attachment' ); ?>" name="<?php echo $this->get_field_name( 'attachment' ); ?>" value="scroll" /><?php _e( 'Scroll', 'ample' ); ?>
			<input type="radio" <?php checked( $attachment, 'fixed' ) ?> id="<?php echo $this->get_field_id( 'attachment' ); ?>" name="<?php echo $this->get_field_name( 'attachment' ); ?>" value="fixed" style="margin-left:20px;" /><?php _e( 'Fixed', 'ample' ); ?>
		</p>

		<strong><?php _e( 'OTHER SETTINGS :', 'ample' ); ?></strong><br />

		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo $title; ?>" />
		</p>

		<?php _e( 'Description', 'ample' ); ?>
		<textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id( 'text' ); ?>" name="<?php echo $this->get_field_name( 'text' ); ?>"><?php echo $text; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>"><?php _e( 'Number of posts to display:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo $number; ?>" size="3" />
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select category', 'ample' ); ?>
				:</label>
			<?php wp_dropdown_categories( array(
				'show_option_none' => ' ',
				'name'             => $this->get_field_name( 'category' ),
				'selected'         => $category,
			) ); ?>
		</p>

		<p>
			<label for="<?php echo $this->get_field_id( 'button_text' ); ?>"><?php _e( 'Button Text:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_text' ); ?>" name="<?php echo $this->get_field_name( 'button_text' ); ?>" type="text" value="<?php echo $button_text; ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'button_url' ); ?>"><?php _e( 'Button Redirect Link:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id( 'button_url' ); ?>" name="<?php echo $this->get_field_name( 'button_url' ); ?>" type="text" value="<?php echo $button_url; ?>" />
		</p>
		<p><?php _e( 'Note: Link to redirect. If empty than it will redirect to selected category.', 'ample' ); ?></p>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance                     = $old_instance;
		$instance['background_color'] = $new_instance['background_color'];
		$instance['background_image'] = esc_url_raw( $new_instance['background_image'] );
		$instance['attachment']       = $new_instance['attachment'];
		$instance['title']            = strip_tags( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) );
		} // wp_filter_post_kses() expects slashed
		$instance['number']      = absint( $new_instance['number'] );
		$instance['category']    = $new_instance['category'];
		$instance['button_text'] = strip_tags( $new_instance['button_text'] );
		$instance['button_url']  = esc_url_raw( $new_instance['button_url'] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$background_color = isset( $instance['background_color'] ) ? $instance['background_color'] : '';
		$background_image = isset( $instance['background_image'] ) ? $instance['background_image'] : '';
		$attachment       = isset( $instance['attachment'] ) ? $instance['attachment'] : '';
		$title            = isset( $instance['title'] ) ? $instance['title'] : '';
		$text             = isset( $instance['text'] ) ? $instance['text'] : '';
		$number           = empty( $instance['number'] ) ? 4 : $instance['number'];
		$category         = isset( $instance['category'] ) ? $instance['category'] : '';
		$button_text      = isset( $instance['button_text'] ) ? $instance['button_text'] : '';
		$button_url       = isset( $instance['button_url'] ) ? $instance['button_url'] : '#';

		$get_featured_posts = new WP_Query( array(
			'posts_per_page' => $number,
			'post_type'      => 'post',
			'category__in'   => $category,
		) );

		echo $before_widget;
		$image_style = '';
		if ( ! empty( $background_image ) ) {
			$image_style .= 'background-image:url(' . $background_image . ');background-attachment:' . $attachment . ';background-repeat:no-repeat;background-size:cover;';
		} else {
			$image_style .= 'background-color:' . $background_color . ';';
		} ?>

		<div class="portfolio-container" style="<?php echo $image_style; ?>">
			<?php if ( $category > 0 ) : ?>
				<div class="inner-wrap clearfix">
					<div class="portfolio-header">
						<?php
						if ( ! empty( $title ) ) {
							echo $before_title . esc_html( $title ) . $after_title;
						}
						if ( ! empty( $text ) ) { ?>
							<div class="portfolio-main-description"><p> <?php echo esc_textarea( $text ); ?> </p>
							</div> <?php }
						?>
					</div>
					<div class="portfolio-content clearfix">
						<?php
						$i = 1;
						while ( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
							if ( $i % 4 == 0 ) {
								$class = 'tg-one-fourth tg-one-fourth-last';
							} elseif ( $i % 3 == 0 ) {
								$class = 'tg-one-fourth tg-after-two-blocks-clearfix';
							} else {
								$class = 'tg-one-fourth';
							}

							if ( $i % 2 == 1 ) {
								$class .= ' ' . 'tg-column-odd';
							} else {
								$class .= ' ' . 'tg-column-even';
							}
							?>
							<div class="single-portfolio <?php echo $class; ?>">
								<div class="single-portfolio-thumbnail">
									<?php
									if ( has_post_thumbnail() ) {
										$thumb_id            = get_post_thumbnail_id( get_the_ID() );
										$img_altr            = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
										$img_alt             = ! empty( $img_altr ) ? $img_altr : $title;
										$post_thumbnail_attr = array(
											'alt'   => esc_attr( $img_alt ),
											'title' => esc_attr( $title ),
										);

										the_post_thumbnail( 'ample-portfolio-image', $post_thumbnail_attr );
										?>

										<div class="view-detail">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><i class="fa fa-link"></i></a>
										</div>

										<div class="moving-box">
											<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
										</div>
									<?php } else { ?>
										<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
									<?php } ?>
								</div>
							</div>
							<?php $i ++;
						endwhile;
						if ( ! empty( $button_text ) ) {
							if ( ! empty( $button_url ) ) {
								$button_link = $button_url;
							} else {
								$button_link = get_category_link( $category );
							} ?>
							<div class="clearfix"></div>
							<div class="portfolio-view-more inner-wrap">
								<a class="portfolio-button" href="<?php echo $button_link; ?>" title="<?php echo esc_attr( $button_text ); ?>"><span><?php echo esc_html( $button_text ); ?></span></a>
							</div>
						<?php } ?>
					</div>
				</div>
			<?php endif; ?>
		</div>
		<?php
		// Reset Post Data
		wp_reset_query();
		?>
		<?php echo $after_widget;
	}
}
