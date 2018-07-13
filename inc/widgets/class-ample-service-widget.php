<?php
/**
 * Featured recent work widget to show pages.
 */

class ample_service_widget extends WP_Widget {
	function __construct() {
		$widget_ops = array(
			'classname' => 'widget_service_block',
			'description' => __( 'Show your some pages as services.', 'ample' ),
			'customize_selective_refresh' => true,
		);
		$control_ops = array( 'width' => 200, 'height' =>250 );
		parent::__construct( false, $name = __( 'TG: Service Widget', 'ample' ), $widget_ops, $control_ops);
	}

	function form( $instance ) {
		for ( $i=1; $i<=6; $i++ ) {
			$var = 'page_id'.$i;
			$defaults[$var] = '';
		}
		$defaults['title'] = '';
		$defaults['text'] = '';
		$defaults['image'] = '';

		$instance = wp_parse_args( (array) $instance, $defaults );

		$title = esc_attr( $instance[ 'title' ] );
		$text = esc_textarea( $instance['text'] );
		$image = esc_url_raw( $instance['image'] );
		?>
		<p>
			<label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'ample' ); ?></label>
			<input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
		</p>
		<?php _e( 'Description','ample' ); ?>
		<textarea class="widefat" rows="10" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

		<p>
			<label for="<?php echo $this->get_field_id( 'image' ); ?>"> <?php esc_html_e( 'Image:', 'ample' ); ?> </label> <br />
		<div class="media-uploader" id="<?php echo $this->get_field_id( 'image' ); ?>">
			<div class="custom_media_preview">
				<?php if ( $image != '' ) : ?>
					<img class="custom_media_preview_default" src="<?php echo esc_url( $instance[ 'image' ] ); ?>" style="max-width:100%;" />
				<?php endif; ?>
			</div>
			<input type="text" class="widefat custom_media_input" id="<?php echo $this->get_field_id( 'image' ); ?>" name="<?php echo $this->get_field_name( 'image' ); ?>" value="<?php echo esc_url( $instance[ 'image' ] ); ?>" style="margin-top:5px;" />
			<button class="custom_media_upload button button-secondary button-large" id="<?php echo $this->get_field_id( 'image' ); ?>" data-choose="<?php esc_attr_e( 'Choose an image', 'ample' ); ?>" data-update="<?php esc_attr_e( 'Use image', 'ample' ); ?>" style="width:100%;margin-top:6px;margin-right:30px;"><?php esc_html_e( 'Select an Image', 'ample' ); ?></button>
		</div>
		</p>

		<p>
			<?php
			$url = 'http://fontawesome.io/icons/';
			$link = sprintf( __( '<a href="%s" target="_blank">Refer here</a> For Icon Class', 'ample' ), esc_url( $url ) );
			echo $link;
			?>
		</p>

		<p><?php _e('Select the page to display Title and Excerpt.', 'ample') ?></p>
		<?php
		for( $i=1; $i<=6; $i++) {
			if( $i%2 != 0 ){ ?>
				<p>
					<label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php _e( 'Page', 'ample' ); ?>:</label>
					<?php wp_dropdown_pages( array( 'show_option_none' =>' ','name' => $this->get_field_name( key($defaults) ), 'selected' => $instance[ key($defaults) ] ) ); ?>
				</p>
			<?php }
			elseif( $i%2 == 0 ) { ?>
				<p>
					<label for="<?php echo $this->get_field_id( key($defaults) ); ?>"><?php _e( 'Icon Class:', 'ample' ); ?></label>
					<input id="<?php echo $this->get_field_id( key($defaults) ); ?>" name="<?php echo $this->get_field_name( key($defaults) ); ?>" placeholder="fa-refresh" type="text" value="<?php echo $instance[ key($defaults) ]; ?>" />
				</p>
			<?php }
			next( $defaults );// forwards the key of $defaults array
		}
	}

	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
		for( $i=1; $i<=6; $i++ ) {
			$var = 'page_id'.$i;
			if( $i%2 != 0 )
				$instance[ $var] = absint( $new_instance[ $var ] );
			elseif( $i%2 == 0 )
				$instance[ $var ] = strip_tags( $new_instance[ $var ] );
		}
		if ( current_user_can('unfiltered_html') )
			$instance['text'] =  $new_instance['text'];
		else
			$instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
		$instance[ 'image' ] = esc_url_raw( $new_instance[ 'image' ] );

		return $instance;
	}

	function widget( $args, $instance ) {
		extract( $args );
		extract( $instance );

		global $post;
		$title = apply_filters( 'widget_title', isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '');
		$text = apply_filters( 'widget_text', empty( $instance['text'] ) ? '' : $instance['text'], $instance );
		$image = isset( $instance[ 'image' ] ) ? $instance[ 'image' ] : '';

		$page_array = array();
		$icon = array();
		for( $i=1; $i<=6; $i++ ) {
			$var = 'page_id'.$i;
			if( $i%2 != 0 ){
				$page_id = isset( $instance[ $var ] ) ? $instance[ $var ] : '';
				if( !empty( $page_id ) )
					array_push( $page_array, $page_id );// Push the page id in the array
			}
			elseif( $i%2 == 0 && !( empty( $page_id ) ) ) {
				$strn =  $instance[ $var ];
				array_push( $icon, $strn );
			}
		}
		$get_featured_pages = new WP_Query( array(
			'posts_per_page'        => -1,
			'post_type'             =>  array( 'page' ),
			'post__in'              => $page_array,
			'orderby'               => 'post__in'
		) );
		echo $before_widget;

		if ( !empty( $title ) ) { ?>
			<div class="services-header">
				<?php echo $before_title . esc_html( $title ) . $after_title; ?>
				<div class="services-main-description">
					<p>
						<?php echo esc_textarea( $text ); ?>
					</p>
					<?php if( !empty( $image ) ) { ?>
						<img title="<?php echo esc_attr($title); ?>" alt="<?php echo esc_attr($title); ?>" src="<?php echo $image; ?>">
					<?php } ?>
				</div>
			</div>
		<?php }
		if ( !empty( $page_array ) ) : ?>
			<div class="services-content clearfix">
				<?php
				$count=0;
				while( $get_featured_pages->have_posts() ):$get_featured_pages->the_post();

					if ( $count ==  2 ) { $service_wrap_class = 'single-service tg-one-third tg-one-third-last'; }
					else { $service_wrap_class = 'single-service tg-one-third'; }
					?>
					<div class="<?php echo $service_wrap_class; ?>">
						<?php
						if( !empty( $icon[$count] ) ) {
							?>
							<span class="icons">
                     <i class="fa fa-aw <?php echo esc_html( $icon[$count] )?> fa-3x"></i>
                  </span>
						<?php }
						?>
						<h5><a title="<?php the_title_attribute(); ?>" href="<?php the_permalink(); ?>"> <?php echo esc_html(get_the_title() ); ?></a></h5>
						<?php the_excerpt(); ?>
					</div>
					<?php
					$count++;
				endwhile; ?>
			</div>
		<?php endif;
		// Reset Post Data
		wp_reset_query();
		?>
		<?php echo $after_widget;
	}
}
