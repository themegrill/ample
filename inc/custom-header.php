<?php
/**
 * Implements a custom header for Ample.
 * See http://codex.wordpress.org/Custom_Headers
 *
 * @package ThemeGrill
 * @subpackage Ample
 * @since Ample 0.1
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses ample_header_style()
 */

add_action( 'after_setup_theme', 'ample_custom_header_setup' );

function ample_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'ample_custom_header_args', array(
		'default-image'			=> '',
		'default-text-color'	=> '222222',
		'width'					=> 1500,
		'height'				=> 400,
		'flex-width'			=> false,
		'flex-height'			=> true,
		'video'					=> true,
		'wp-head-callback'		=> 'ample_header_style',
	) ) );
}

if ( ! function_exists( 'ample_header_style' ) ) :

/**
 * Styles the header text displayed on the blog.
 *
 */
function ample_header_style() {
   $header_text_color = get_header_textcolor();

   // If no custom options for text are set, let's bail
   // get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
   if ( HEADER_TEXTCOLOR == $header_text_color ) {
      return;
   }

   // If we get this far, we have custom styles. Let's do this.
   ?>
   <style type="text/css">
   <?php
   // Has the text been hidden?
   if ( 'blank' == $header_text_color ) :
   ?>
      #site-title,
      #site-description {
         position: absolute;
         clip: rect(1px, 1px, 1px, 1px);
      }
   <?php
   // If the user has set a custom color for the text use that
   else :
   ?>
      #site-title a, #site-description {
         color: #<?php echo $header_text_color; ?>;
      }
   <?php endif; ?>
   </style>
   <?php
}
endif; // ample_header_style
