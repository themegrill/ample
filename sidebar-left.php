<?php
/**
 * The Sidebar containing the main widget areas.
 *
 * @package ThemeGrill
 * @subpackage Ample
 * @since Ample 0.1
 */
?>

<div id="tertiary" class="sidebar">
   <?php do_action( 'ample_before_sidebar' );

   if ( ! dynamic_sidebar( 'ample_left_sidebar' ) ) :

      the_widget( 'WP_Widget_Text',
         array(
            'title'  => __( 'Example Widget', 'ample' ),
            'text'   => sprintf( __( 'This is an example widget to show how the Left sidebar looks by default. You can add custom widgets from the %swidgets screen%s in the admin. If custom widgets are added then this will be replaced by those widgets', 'ample' ), current_user_can( 'edit_theme_options' ) ? '<a href="' . admin_url( 'widgets.php' ) . '">' : '', current_user_can( 'edit_theme_options' ) ? '</a>' : '' ),
            'filter' => true,
         ),
         array(
            'before_widget' => '<section class="widget widget_text">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>'
         )
      );
   endif;

   do_action( 'ample_after_sidebar' ); ?>
</div>
