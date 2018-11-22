<?php
/**
 * Featured Posts widget
 */

class ample_featured_posts_widget extends WP_Widget {

	function __construct() {
		$widget_ops  = array(
			'classname'                   => 'widget_featured_posts_block',
			'description'                 => __( 'Display latest posts or posts of specific category', 'ample' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' => 250 );
		parent::__construct( false, $name = __( 'TG: Featured Posts', 'ample' ), $widget_ops );
	}

	function form( $instance ) {
		$tg_defaults['title']    = '';
		$tg_defaults['text']     = '';
		$tg_defaults['number']   = 4;
		$tg_defaults['type']     = 'latest';
		$tg_defaults['category'] = '';

		$instance = wp_parse_args( (array) $instance, $tg_defaults );

		$title    = esc_attr( $instance['title'] );
		$text     = esc_textarea( $instance['text'] );
		$number   = $instance['number'];
		$type     = $instance['type'];
		$category = $instance['category'];
		?>

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
			<input type="radio" <?php checked( $type, 'latest' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest" /><?php _e( 'Show latest Posts', 'ample' ); ?>
			<br />
			<input type="radio" <?php checked( $type, 'category' ) ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category" /><?php _e( 'Show posts from a category', 'ample' ); ?>
			<br />
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
		<?php
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		$instance['title'] = strip_tags( $new_instance['title'] );
		if ( current_user_can( 'unfiltered_html' ) ) {
			$instance['text'] = $new_instance['text'];
		} else {
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes( $new_instance['text'] ) ) );
		} // wp_filter_post_kses() expects slashed
		$instance['number']   = absint( $new_instance['number'] );
		$instance['type']     = $new_instance['type'];
		$instance['category'] = $new_instance['category'];

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title    = isset( $instance['title'] ) ? $instance['title'] : '';
		$text     = isset( $instance['text'] ) ? $instance['text'] : '';
		$number   = empty( $instance['number'] ) ? 4 : $instance['number'];
		$type     = isset( $instance['type'] ) ? $instance['type'] : 'latest';
		$category = isset( $instance['category'] ) ? $instance['category'] : '';

		if ( $type == 'latest' ) {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page'      => $number,
				'post_type'           => 'post',
				'ignore_sticky_posts' => true,
			) );
		} else {
			$get_featured_posts = new WP_Query( array(
				'posts_per_page' => $number,
				'post_type'      => 'post',
				'category__in'   => $category,
			) );
		}

		echo $before_widget; ?>

		<div class="featured-posts-header">
			<?php if ( ! empty( $title ) ) { ?>
				<?php echo $before_title . esc_html( $title ) . $after_title; ?>
			<?php } ?>
			<?php if ( ! empty( $text ) ) { ?>
				<div class="featured-posts-main-description">
					<p><?php echo esc_textarea( $text ); ?></p>
				</div>
			<?php } ?>
		</div>

		<div class="featured-posts-content clearfix">
			<?php
			$i = 1;
			while ( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
				?>
				<?php
				if ( $i % 2 == 0 ) {
					$class = 'tg-one-half tg-one-half-last';
				} else {
					$class = 'tg-one-half';
				}
				if ( $i % 2 == 1 && $i > 1 ) {
					$class .= ' tg-featured-posts-clearfix';
				}
				?>
				<div class="single-post <?php echo $class; ?>">
					<?php if ( has_post_thumbnail() ) { ?>
						<div class="single-post-image-wrap">
							<?php
							$image           = '';
							$title_attribute = the_title_attribute( 'echo=0' );
							$thumb_id        = get_post_thumbnail_id( get_the_ID() );
							$img_altr        = get_post_meta( $thumb_id, '_wp_attachment_image_alt', true );
							$img_alt         = ! empty( $img_altr ) ? $img_altr : $title_attribute;
							$image           .= '<figure>';
							$image           .= '<a href="' . get_permalink() . '" title="' . $title_attribute . '">';
							$image           .= get_the_post_thumbnail( $post->ID, 'ample-featured-blog-small', array(
									'title' => $title_attribute,
									'alt'   => $img_alt,
								) ) . '</a>';
							$image           .= '</figure>';

							echo $image;
							?>

						</div>
					<?php } ?>
					<div class="single-post-content">
						<h3 class="entry-title">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a>
						</h3>
						<div class="entry-summary">
							<?php the_excerpt(); ?>
						</div>
						<div class="read-btn">
							<a href="<?php the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php _e( 'Read more', 'ample' ); ?></a>
						</div>
					</div>
				</div>
				<?php $i ++;
			endwhile; ?>
		</div>

		<?php
		// Reset Post Data
		wp_reset_query();
		echo $after_widget;
	}
}
