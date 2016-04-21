<?php
/**
 * The template part for displaying navigation.
 *
 * @package ThemeGrill
 * @subpackage Ample
 * @since Ample 0.1
 */
?>

<?php
if( is_archive() || is_home() || is_search() ) {
   /**
    * Checking WP-PageNavi plugin exist
    */
   if ( function_exists('wp_pagenavi' ) ) :
      wp_pagenavi();

   else:
      global $wp_query;
      if ( $wp_query->max_num_pages > 1 ) :
      ?>
      <ul class="default-wp-page clearfix">
         <li class="previous"><?php next_posts_link( __( '&laquo; Previous', 'ample' ) ); ?></li>
         <li class="next"><?php previous_posts_link( __( 'Next &raquo;', 'ample' ) ); ?></li>
      </ul>
      <?php
      endif;
   endif;
}

if ( is_single() ) {
   if( is_attachment() ) {
   ?>
      <ul class="default-wp-page clearfix">
         <li class="previous"><?php previous_image_link( false, __( '&larr; Previous', 'ample' ) ); ?></li>
         <li class="next"><?php next_image_link( false, __( 'Next &rarr;', 'ample' ) ); ?></li>
      </ul>
   <?php
   }
   else {
   ?>
      <ul class="default-wp-page clearfix">
         <li class="previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'ample' ) . '</span> %title' ); ?></li>
         <li class="next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'ample' ) . '</span>' ); ?></li>
      </ul>
   <?php
   }
}
?>