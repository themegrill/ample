<?php
/**
 * Ample functions related to defining constants, adding files and WordPress core functionality.
 *
 * @package ThemeGrill
 * @subpackage Ample
 * @since Ample 0.1
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
if ( ! isset( $content_width ) )
   $content_width = 710; /* pixels */

/**
 * $content_width global variable adjustment as per layout option.
 */
function ample_content_width() {
   global $post;
   global $content_width;

   if( $post ) { $layout_meta = get_post_meta( $post->ID, 'ample_page_layout', true ); }
   if( empty( $layout_meta ) || is_archive() || is_search() ) { $layout_meta = 'default_layout'; }
   $ample_default_layout = ample_option( 'ample_default_layout', 'right_sidebar' );

   if( $layout_meta == 'default_layout' ) {
      if ( $ample_default_layout == 'no_sidebar_full_width' ) { $content_width = 1100; /* pixels */ }
      elseif ( $ample_default_layout == 'both_sidebar' ) { $content_width = 500; /* pixels */ }
      else { $content_width = 710; /* pixels */ }
   }
   elseif ( $layout_meta == 'no_sidebar_full_width' ) { $content_width = 1100; /* pixels */ }
   elseif ( $layout_meta == 'both_sidebar' ) { $content_width = 500; /* pixels */ }
   else { $content_width = 710; /* pixels */ }
}
add_action( 'template_redirect', 'ample_content_width' );

add_action( 'after_setup_theme', 'ample_setup' );

if ( ! function_exists( 'ample_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 */
function ample_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 */
	load_theme_textdomain( 'ample', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	//Enable support for Post Thumbnails on posts and pages.
	add_theme_support( 'post-thumbnails' );

   // Cropping the images to different sizes to be used in the theme
	add_image_size( 'ample-featured-blog-large', 710, 300, true );
	add_image_size( 'ample-featured-blog-small', 230, 230, true );
	add_image_size( 'ample-portfolio-image', 330, 330, true );

	// Registering navigation menus.
	register_nav_menus( array(
		'primary' => __( 'Primary Menu', 'ample' ),
		'footer' => __( 'Footer Menu', 'ample' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'ample_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );

	// Adding excerpt option box for pages as well
	add_post_type_support( 'page', 'excerpt' );
}
endif; // ample_setup

/**
 * Register widget area.
 *
 */
require get_template_directory() . '/inc/widgets/widgets.php';

/**
 * Enqueue scripts and styles.
 */
require get_template_directory() . '/inc/functions.php';

/**
 * Functions related to header.
 */
require get_template_directory() . '/inc/header-functions.php';

/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Add meta Box
 */
require get_template_directory() . '/inc/admin/meta-boxes.php';

/**
 * Add Customizer
 */
require_once( get_template_directory() . '/inc/customizer.php' );

/**
 * Detect plugin. For use on Front End only.
 */
include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

/**
 * Adding Admin Menu for theme options
 */
add_action( 'admin_menu', 'ample_theme_options_menu' );

function ample_theme_options_menu() {

   add_theme_page( 'Theme Options', 'Theme Options', 'manage_options', 'ample-theme-options', 'ample_theme_options' );

}
function ample_theme_options() {

   if ( !current_user_can( 'manage_options' ) )  {
      wp_die( __( 'You do not have sufficient permissions to access this page.', 'ample' ) );
   } ?>

   <h1 class="ample-theme-options"><?php _e( 'Theme Options', 'ample' ); ?></h1>
   <?php
   printf( __('<p style="font-size: 16px; max-width: 800px";>As our themes are hosted on WordPress repository, we need to follow the WordPress theme guidelines and as per the new guiedlines we have migrated all our Theme Options to Customizer.</p><p style="font-size: 16px; max-width: 800px";>We too think this is a better move in the long run. All the options are unchanged, it is just that they are moved to customizer. So, please use this <a href="%1$s">link</a> to customize your site. If you have any issues then do let us know via our <a href="%2$s">Contact form</a></p>', 'ample'),
      esc_url(admin_url( 'customize.php' ) ),
      esc_url('http://themegrill.com/contact/')
   );
}