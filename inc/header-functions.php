<?php
/**
 * Contains all the fucntions and components related to header part.
 *
 * @package ThemeGrill
 * @subpackage Ample
 * @since Ample 0.1
 */

if ( ! function_exists( 'ample_featured_image_slider') ):
/**
 * display slider
 */
function ample_featured_image_slider() { ?>
   <div class="big-slider-wrapper">
      <div class="big-slider">
         <?php
         for($i=1; $i<=4; $i++) {
            $ample_slider_image = ample_option('ample_slider_image' . $i , '');
            $ample_slider_title = ample_option('ample_slider_title' . $i , '');
            $ample_slider_button_text = ample_option('ample_slider_button_text' . $i , '');
            $ample_slider_link = ample_option('ample_slider_link' . $i , '');

            if ( $i == 1 ) { $classes = "slides displayblock"; } else { $classes = "slides displaynone"; }

            if( !empty( $ample_slider_image ) ) { ?>
               <div class="<?php echo $classes; ?>">
                  <?php if( !empty( $ample_slider_title ) ) { ?>
                     <div class="slider-entry-container">
                        <h3 class="entry-title">
                           <a href="<?php echo esc_url( $ample_slider_link ); ?>" title="<?php echo esc_attr( $ample_slider_title ); ?>"><?php echo $ample_slider_title; ?></a>
                        </h3>
                        <?php if( !empty( $ample_slider_button_text ) ) : ?>
                        <div class="slider-link-btn">
                           <a class="slider-button" href="<?php echo esc_url( $ample_slider_link ); ?>" title="<?php echo esc_attr( $ample_slider_title ); ?>"> <?php echo ( $ample_slider_button_text ); ?>
                           </a>
                        </div>
                        <?php endif; ?>
                     </div>
                  <?php } ?>
                  <figure>
                     <img alt="<?php echo esc_attr( $ample_slider_title ); ?>" src="<?php echo esc_url( $ample_slider_image ); ?>" >
                  </figure>
               </div>
            <?php }
         } ?>
      </div>
      <div class="slide-next"></div>
      <div class="slide-prev"></div>
   </div><!-- .big-slider-wrapper -->
<?php }
endif;

/****************************************************************************************/
// Filter the get_header_image_tag() for option of displaying the header image in old way
function ample_header_image_markup( $html, $header, $attr ) {
	$output = '';
	$header_image = get_header_image();

	if ( ! empty( $header_image ) ) {
		$output .= '<img src="' . esc_url( $header_image ) . '" class="header-image" width="' . get_custom_header()->width . '" height="' . get_custom_header()->height . '" alt="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">';
	}

	return $output;
}

function ample_header_image_markup_filter() {
	add_filter( 'get_header_image_tag', 'ample_header_image_markup', 10, 3 );
}

add_action( 'ample_header_image_markup_render','ample_header_image_markup_filter' );

/****************************************************************************************/

if ( ! function_exists( 'ample_render_header_image' ) ) :
/**
 * Display the header image.
 */
function ample_render_header_image() {
	if ( function_exists( 'the_custom_header_markup' ) ) {
		do_action( 'ample_header_image_markup_render' );
		the_custom_header_markup();
	} else {
		$header_image = get_header_image();
		if ( ! empty( $header_image ) ) { ?>
			<img src="<?php echo esc_url( $header_image ); ?>" class="header-image" width="<?php echo get_custom_header()->width; ?>" height="<?php echo get_custom_header()->height; ?>" alt="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>">
			<?php
		}
	}
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'ample_header_title' ) ) :
/**
 * Show the title in header
 */
function ample_header_title() {
   if( is_archive() ) {
      if ( is_category() ) :
         $ample_header_title = single_cat_title( '', FALSE );

      elseif ( is_tag() ) :
         $ample_header_title = single_tag_title( '', FALSE );

      elseif ( is_author() ) :
         /* Queue the first post, that way we know
          * what author we're dealing with (if that is the case).
         */
         the_post();
         $ample_header_title =  sprintf( __( 'Author: %s', 'ample' ), '<span class="vcard">' . get_the_author() . '</span>' );
         /* Since we called the_post() above, we need to
          * rewind the loop back to the beginning that way
          * we can run the loop properly, in full.
          */
         rewind_posts();

      elseif ( is_day() ) :
         $ample_header_title = sprintf( __( 'Day: %s', 'ample' ), '<span>' . get_the_date() . '</span>' );

      elseif ( is_month() ) :
         $ample_header_title = sprintf( __( 'Month: %s', 'ample' ), '<span>' . get_the_date( 'F Y' ) . '</span>' );

      elseif ( is_year() ) :
         $ample_header_title = sprintf( __( 'Year: %s', 'ample' ), '<span>' . get_the_date( 'Y' ) . '</span>' );

      elseif ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) :
         $ample_header_title = woocommerce_page_title( false );


      else :
         $ample_header_title = __( 'Archives', 'ample' );

      endif;
   }
   elseif( is_404() ) {
      $ample_header_title = __( 'Page NOT Found', 'ample' );
   }
   elseif( is_search() ) {
      $ample_header_title = sprintf( __( 'Search Results For: %s', 'ample' ), '<span>' . get_search_query() . '</span>' );
   }
   elseif( is_page()  ) {
      $ample_header_title = get_the_title();
   }
   elseif( is_single()  ) {
      $ample_header_title = get_the_title();
   }
   elseif( is_home() ){
      $queried_id = get_option( 'page_for_posts' );
      $ample_header_title = get_the_title( $queried_id );
   }
   else {
      $ample_header_title = '';
   }

   return $ample_header_title;
}
endif;

/****************************************************************************************/

if ( ! function_exists( 'ample_breadcrumb' ) ) :
/**
 * Display breadcrumb on header.
 *
 * If the page is home or front page, slider is displayed.
 * In other pages, breadcrumb will display if breadcrumb NavXT plugin exists.
 */
function ample_breadcrumb() {
   if( function_exists( 'bcn_display' ) ) {
      echo '<div class="breadcrumb" xmlns:v="http://rdf.data-vocabulary.org/#">';
      echo '<span class="breadcrumb-title">'.__( 'You are here:', 'ample' ).'</span>';
      bcn_display();
      echo '</div> <!-- .breadcrumb -->';
   }
}
endif; ?>
