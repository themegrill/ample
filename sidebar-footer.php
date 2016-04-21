<?php
/**
 * The Sidebar containing the footer widget areas.
 *
 * @package ThemeGrill
 * @subpackage Ample
 * @since Ample 0.1
 */
?>

<?php
/**
 * The footer widget area is triggered if any of the areas
 * have widgets. So let's check that first.
 *
 * If none of the sidebars have widgets, then let's bail early.
 */
if( !is_active_sidebar( 'ample_footer_sidebar1' ) &&
   !is_active_sidebar( 'ample_footer_sidebar2' ) &&
   !is_active_sidebar( 'ample_footer_sidebar3' ) &&
   !is_active_sidebar( 'ample_footer_sidebar4' ) ) {
   return;
}
?>
<div class="footer-widgets-wrapper">
   <div class="footer-widgets-area clearfix">
      <div class="footer-box tg-one-fourth tg-column-odd">
         <?php
         // Calling the footer sidebar if it exists.
         if ( !dynamic_sidebar( 'ample_footer_sidebar1' ) ):
         endif;
         ?>
      </div>
      <div class="footer-box tg-one-fourth tg-column-even">
         <?php
         // Calling the footer sidebar if it exists.
         if ( !dynamic_sidebar( 'ample_footer_sidebar2' ) ):
         endif;
         ?>
      </div>
      <div class="footer-box tg-one-fourth tg-after-two-blocks-clearfix tg-column-odd">
         <?php
         // Calling the footer sidebar if it exists.
         if ( !dynamic_sidebar( 'ample_footer_sidebar3' ) ):
         endif;
         ?>
      </div>
      <div class="footer-box tg-one-fourth tg-one-fourth-last tg-column-even">
         <?php
         // Calling the footer sidebar if it exists.
         if ( !dynamic_sidebar( 'ample_footer_sidebar4' ) ):
         endif;
         ?>
      </div>
   </div>
</div>