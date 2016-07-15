<?php
/**
 * Contains all the functions related to sidebar and widget.
 *
 * @package ThemeGrill
 * @subpackage Ample
 * @since Ample 0.1
 */

/**
 * Register widget area.
 *
 */
add_action( 'widgets_init', 'ample_widgets_init' );
/**
 * Function to register the widget areas(sidebar) and widgets.
 */
function ample_widgets_init() {
   register_sidebar( array(
      'name'          => __( 'Right Sidebar', 'ample' ),
      'id'            => 'ample_right_sidebar',
      'description'   => __('Shows widgets at right side.', 'ample' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
   ) );
   register_sidebar( array(
      'name'          => __( 'Left Sidebar', 'ample' ),
      'id'            => 'ample_left_sidebar',
      'description'   => __('Shows widgets at left side.', 'ample' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
   ) );
   register_sidebar( array(
      'name'          => __( 'Business Sidebar', 'ample' ),
      'id'            => 'ample_business_sidebar',
      'description'   => __('Shows widgets on Business Page Template.', 'ample' ),
      'before_widget' => '<div id="%1$s" class="widget %2$s"><div class="inner-wrap clearfix">',
      'after_widget'  => '</div></div>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
   ) );
   register_sidebar( array(
      'name'          => __( 'Error 404 Page Sidebar', 'ample' ),
      'id'            => 'ample_error_404_page_sidebar',
      'description'   => __('Shows widgets on Error 404 page.', 'ample' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
   ) );
   register_sidebar( array(
      'name'          => __( 'Contact Page Sidebar', 'ample' ),
      'id'            => 'ample_contact_page_sidebar',
      'description'   => __('Shows widgets on Right/Left side of Contact page.', 'ample' ),
      'before_widget' => '<aside id="%1$s" class="widget %2$s">',
      'after_widget'  => '</aside>',
      'before_title'  => '<h3 class="widget-title">',
      'after_title'   => '</h3>',
   ) );
   register_sidebar( array(
      'name'          => __( 'Footer Sidebar1', 'ample' ),
      'id'            => 'ample_footer_sidebar1',
      'description'   => __('Shows widgets on footer.', 'ample' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h5 class="widget-title">',
      'after_title'   => '</h5>',
   ) );
   register_sidebar( array(
      'name'          => __( 'Footer Sidebar2', 'ample' ),
      'id'            => 'ample_footer_sidebar2',
      'description'   => __('Shows widgets on footer.', 'ample' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h5 class="widget-title">',
      'after_title'   => '</h5>',
   ) );
   register_sidebar( array(
      'name'          => __( 'Footer Sidebar3', 'ample' ),
      'id'            => 'ample_footer_sidebar3',
      'description'   => __('Shows widgets on footer.', 'ample' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h5 class="widget-title">',
      'after_title'   => '</h5>',
   ) );
   register_sidebar( array(
      'name'          => __( 'Footer Sidebar4', 'ample' ),
      'id'            => 'ample_footer_sidebar4',
      'description'   => __('Shows widgets on footer.', 'ample' ),
      'before_widget' => '<section id="%1$s" class="widget %2$s">',
      'after_widget'  => '</section>',
      'before_title'  => '<h5 class="widget-title">',
      'after_title'   => '</h5>',
   ) );

   register_widget("ample_service_widget");
   register_widget("ample_portfolio_widget");
   register_widget("ample_call_to_action_widget");
   register_widget("ample_featured_posts_widget");
}

/**************************************************************************************/

/**
 * Featured recent work widget to show pages.
 */
class ample_service_widget extends WP_Widget {
   function __construct() {
      $widget_ops = array( 'classname' => 'widget_service_block', 'description' => __( 'Show your some pages as services.', 'ample' ) );
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

/**************************************************************************************/

/**
 * Portfolio widget
 */
class ample_portfolio_widget extends WP_Widget {

   function __construct() {
      $widget_ops = array( 'classname' => 'widget_portfolio_block', 'description' => __( 'Display portfolio by using specific category', 'ample') );
      $control_ops = array( 'width' => 200, 'height' =>250 );
      parent::__construct( false,$name= __( 'TG: Portfolio', 'ample' ), $widget_ops);
   }

   function form( $instance ) {
      $tg_defaults['background_color'] = '#80abc8';
      $tg_defaults['background_image' ] = '';
      $tg_defaults['attachment' ] = 'scroll';
      $tg_defaults['title'] = '';
      $tg_defaults['text'] = '';
      $tg_defaults['number'] = 4;
      $tg_defaults['category'] = '';
      $tg_defaults['button_text'] = '';
      $tg_defaults['button_url' ] = '';

      $instance = wp_parse_args( (array) $instance, $tg_defaults );

      $background_color = esc_attr( $instance[ 'background_color' ] );
      $background_image = esc_url_raw( $instance[ 'background_image' ] );
      $attachment =  $instance[ 'attachment' ];
      $title = esc_attr( $instance[ 'title' ] );
      $text = esc_textarea( $instance[ 'text' ] );
      $number = $instance['number'];
      $category = $instance['category'];
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
         <?php _e( 'Background attachment:', 'ample' ); ?> <br />
         <input type="radio" <?php checked($attachment, 'scroll') ?> id="<?php echo $this->get_field_id( 'attachment' ); ?>" name="<?php echo $this->get_field_name( 'attachment' ); ?>" value="scroll" /><?php _e( 'Scroll', 'ample' );?>
         <input type="radio" <?php checked($attachment,'fixed') ?> id="<?php echo $this->get_field_id( 'attachment' ); ?>" name="<?php echo $this->get_field_name( 'attachment' ); ?>" value="fixed" style="margin-left:20px;"/><?php _e( 'Fixed', 'ample' );?>
      </p>

      <strong><?php _e( 'OTHER SETTINGS :', 'ample' ); ?></strong><br />

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'ample' ); ?></label>
         <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
      </p>

      <?php _e( 'Description','ample' ); ?>
      <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

      <p>
         <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of posts to display:', 'ample' ); ?></label>
         <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select category', 'ample' ); ?>:</label>
         <?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category' ), 'selected' => $category ) ); ?>
      </p>

      <p>
         <label for="<?php echo $this->get_field_id('button_text'); ?>"><?php _e( 'Button Text:', 'ample' ); ?></label>
         <input id="<?php echo $this->get_field_id('button_text'); ?>" name="<?php echo $this->get_field_name('button_text'); ?>" type="text" value="<?php echo $button_text; ?>" />
      </p>
      <p>
         <label for="<?php echo $this->get_field_id('button_url'); ?>"><?php _e( 'Button Redirect Link:', 'ample' ); ?></label>
         <input id="<?php echo $this->get_field_id('button_url'); ?>" name="<?php echo $this->get_field_name('button_url'); ?>" type="text" value="<?php echo $button_url; ?>" />
      </p>
      <p><?php _e( 'Note: Link to redirect. If empty than it will redirect to selected category.', 'ample' ); ?></p>
      <?php
   }

   function update( $new_instance, $old_instance ) {
      $instance = $old_instance;
      $instance['background_color'] = $new_instance['background_color'];
      $instance[ 'background_image' ] = esc_url_raw( $new_instance[ 'background_image' ] );
      $instance[ 'attachment' ] = $new_instance[ 'attachment' ];
      $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
      if ( current_user_can('unfiltered_html') )
         $instance['text'] =  $new_instance['text'];
      else
         $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
      $instance[ 'number' ] = absint( $new_instance[ 'number' ] );
      $instance[ 'category' ] = $new_instance[ 'category' ];
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
      $attachment = isset( $instance[ 'attachment' ] ) ? $instance[ 'attachment' ] : '';
      $title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
      $text = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '';
      $number = empty( $instance[ 'number' ] ) ? 4 : $instance[ 'number' ];
      $category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';
      $button_text = isset( $instance[ 'button_text' ] ) ? $instance[ 'button_text' ] : '';
      $button_url = isset( $instance[ 'button_url' ] ) ? $instance[ 'button_url' ] : '#';

      $get_featured_posts = new WP_Query( array(
         'posts_per_page'        => $number,
         'post_type'             => 'post',
         'category__in'          => $category
      ) );

      echo $before_widget;
      $image_style = '';
      if ( !empty( $background_image ) ) {
         $image_style .= 'background-image:url(' . $background_image . ');background-attachment:' . $attachment . ';background-repeat:no-repeat;background-size:cover;';
      }else {
         $image_style .= 'background-color:' . $background_color . ';';
      }?>

      <div class="portfolio-container" style="<?php echo $image_style; ?>">
         <?php  if( $category > 0 ) : ?>
         <div class="inner-wrap clearfix">
            <div class="portfolio-header">
               <?php
               if( !empty( $title ) ) { echo $before_title . esc_html( $title ) . $after_title; }
               if( !empty( $text ) ) { ?> <div class="portfolio-main-description"><p> <?php echo esc_textarea( $text ); ?> </p></div> <?php }
               ?>
            </div>
            <div class="portfolio-content clearfix">
               <?php
               $i=1;
               while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
                  if ( $i % 4 == 0 ) { $class = 'tg-one-fourth tg-one-fourth-last'; }
                  elseif( $i % 3 == 0 ) { $class= 'tg-one-fourth tg-after-two-blocks-clearfix'; }
                  else { $class = 'tg-one-fourth'; }

                  if ( $i % 2 == 1 ) { $class .= ' '.'tg-column-odd'; }
                  else { $class .= ' '.'tg-column-even'; }
                  ?>
                  <div class="single-portfolio <?php echo $class; ?>">
                     <div class="single-portfolio-thumbnail">
                        <?php
                        if( has_post_thumbnail() ) {
                           the_post_thumbnail('ample-portfolio-image'); ?>
                           <div class="view-detail">
                              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><i class="fa fa-link"></i></a>
                           </div>

                           <div class="moving-box">
                              <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
                           </div>
                        <?php }
                        else { ?>
                           <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a>
                        <?php } ?>
                     </div>
                  </div>
               <?php $i++;
               endwhile;
               if( !empty( $button_text ) ) {
                  if( !empty( $button_url ) )
                     $button_link = $button_url;
                  else
                     $button_link = get_category_link( $category ); ?>
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

/**************************************************************************************/

/**
 * Featured Posts widget
 */
class ample_featured_posts_widget extends WP_Widget {

   function __construct() {
      $widget_ops = array( 'classname' => 'widget_featured_posts_block', 'description' => __( 'Display latest posts or posts of specific category', 'ample') );
      $control_ops = array( 'width' => 200, 'height' =>250 );
      parent::__construct( false,$name= __( 'TG: Featured Posts', 'ample' ),$widget_ops);
   }

   function form( $instance ) {
      $tg_defaults['title'] = '';
      $tg_defaults['text'] = '';
      $tg_defaults['number'] = 4;
      $tg_defaults['type'] = 'latest';
      $tg_defaults['category'] = '';

      $instance = wp_parse_args( (array) $instance, $tg_defaults );

      $title = esc_attr( $instance[ 'title' ] );
      $text = esc_textarea( $instance[ 'text' ] );
      $number = $instance['number'];
      $type = $instance['type'];
      $category = $instance['category'];
      ?>

      <p>
         <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e( 'Title:', 'ample' ); ?></label>
         <input id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
      </p>
      <?php _e( 'Description','ample' ); ?>
      <textarea class="widefat" rows="5" cols="20" id="<?php echo $this->get_field_id('text'); ?>" name="<?php echo $this->get_field_name('text'); ?>"><?php echo $text; ?></textarea>

      <p>
         <label for="<?php echo $this->get_field_id('number'); ?>"><?php _e( 'Number of posts to display:', 'ample' ); ?></label>
         <input id="<?php echo $this->get_field_id('number'); ?>" name="<?php echo $this->get_field_name('number'); ?>" type="text" value="<?php echo $number; ?>" size="3" />
      </p>

      <p>
         <input type="radio" <?php checked($type, 'latest') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="latest"/><?php _e( 'Show latest Posts', 'ample' );?><br />
         <input type="radio" <?php checked($type,'category') ?> id="<?php echo $this->get_field_id( 'type' ); ?>" name="<?php echo $this->get_field_name( 'type' ); ?>" value="category"/><?php _e( 'Show posts from a category', 'ample' );?><br />
      </p>

      <p>
         <label for="<?php echo $this->get_field_id( 'category' ); ?>"><?php _e( 'Select category', 'ample' ); ?>:</label>
         <?php wp_dropdown_categories( array( 'show_option_none' =>' ','name' => $this->get_field_name( 'category' ), 'selected' => $category ) ); ?>
      </p>
      <?php
   }

   function update( $new_instance, $old_instance ) {
      $instance = $old_instance;

      $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
      if ( current_user_can('unfiltered_html') )
         $instance['text'] =  $new_instance['text'];
      else
         $instance['text'] = stripslashes( wp_filter_post_kses( addslashes($new_instance['text']) ) ); // wp_filter_post_kses() expects slashed
      $instance[ 'number' ] = absint( $new_instance[ 'number' ] );
      $instance[ 'type' ] = $new_instance[ 'type' ];
      $instance[ 'category' ] = $new_instance[ 'category' ];

      return $instance;
   }

   function widget( $args, $instance ) {
      extract( $args );
      extract( $instance );

      global $post;
      $title = isset( $instance[ 'title' ] ) ? $instance[ 'title' ] : '';
      $text = isset( $instance[ 'text' ] ) ? $instance[ 'text' ] : '';
      $number = empty( $instance[ 'number' ] ) ? 4 : $instance[ 'number' ];
      $type = isset( $instance[ 'type' ] ) ? $instance[ 'type' ] : 'latest' ;
      $category = isset( $instance[ 'category' ] ) ? $instance[ 'category' ] : '';

      if( $type == 'latest' ) {
         $get_featured_posts = new WP_Query( array(
            'posts_per_page'        => $number,
            'post_type'             => 'post',
            'ignore_sticky_posts'   => true
         ) );
      }
      else {
         $get_featured_posts = new WP_Query( array(
            'posts_per_page'        => $number,
            'post_type'             => 'post',
            'category__in'          => $category
         ) );
      }

      echo $before_widget; ?>

      <div class="featured-posts-header">
         <?php if ( !empty( $title ) ) { ?>
            <?php echo $before_title . esc_html( $title ) . $after_title; ?>
         <?php } ?>
         <?php if ( !empty( $text ) ) { ?>
            <div class="featured-posts-main-description">
               <p><?php echo esc_textarea( $text ); ?></p>
            </div>
         <?php } ?>
      </div>

      <div class="featured-posts-content clearfix">
         <?php
         $i=1;
         while( $get_featured_posts->have_posts() ):$get_featured_posts->the_post();
         ?>
            <?php
            if ( $i % 2 == 0 ) { $class = 'tg-one-half tg-one-half-last'; }
            else { $class = 'tg-one-half'; }
            if( $i % 2 ==  1 && $i > 1) { $class .= ' tg-featured-posts-clearfix'; }
            ?>
            <div class="single-post <?php echo $class; ?>">
               <?php if( has_post_thumbnail() ) { ?>
                  <div class="single-post-image-wrap">
                     <?php
                     $image = '';
                     $title_attribute = the_title_attribute( 'echo=0' );
                     $image .= '<figure>';
                     $image .= '<a href="' . get_permalink() . '" title="'. $title_attribute .'">';
                     $image .= get_the_post_thumbnail( $post->ID, 'ample-featured-blog-small', array( 'title' => $title_attribute , 'alt' => $title_attribute ) ).'</a>';
                     $image .= '</figure>';

                     echo $image;
                     ?>

                  </div>
               <?php } ?>
               <div class="single-post-content">
                  <h3 class="entry-title"><a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php the_title(); ?></a></h3>
                  <div class="entry-summary">
                     <?php the_excerpt(); ?>
                  </div>
                  <div class="read-btn">
                     <a href="<?php the_permalink(); ?>" title="<?php the_title_attribute();?>"><?php _e('Read more', 'ample' ); ?></a>
                  </div>
               </div>
            </div>
         <?php $i++;
         endwhile; ?>
      </div>

      <?php
      // Reset Post Data
      wp_reset_query();
      echo $after_widget;
   }
}

/**************************************************************************************/

/**
 * Featured call to action widget.
 */
class ample_call_to_action_widget extends WP_Widget {
   function __construct() {
      $widget_ops = array( 'classname' => 'widget_call_to_action_block', 'description' => __( 'Use this widget to show the call to action section.', 'ample' ) );
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
