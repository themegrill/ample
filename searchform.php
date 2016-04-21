<?php
/**
 * The template for displaying search forms.
 *
 * @package ThemeGrill
 * @subpackage Ample
 * @since Ample 0.1
 */
?>

<form action="<?php echo esc_url( home_url( '/' ) ); ?>" class="search-form searchform clearfix" method="get">
   <div class="search-wrap">
      <input type="text" placeholder="<?php esc_attr_e( 'Search', 'ample' ); ?>" class="s field" name="s">
      <button class="search-icon" type="submit"></button>
   </div>
</form><!-- .searchform -->