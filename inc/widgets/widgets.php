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

   register_widget('ample_service_widget');
   register_widget('ample_portfolio_widget');
   register_widget('ample_call_to_action_widget');
   register_widget('ample_featured_posts_widget');
}

// Class: TG: Service Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-service-widget.php';

// Class: TG: Portfolio Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-portfolio-widget.php';

// Class: TG: Call To Action Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-call-to-action-widget.php';

// Class: TG: Featured Posts Widget.
require_once get_template_directory() . '/inc/widgets/class-ample-featured-posts-widget.php';
