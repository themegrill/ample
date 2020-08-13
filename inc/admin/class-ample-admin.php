<?php
/**
 * Ample Admin Class.
 *
 * @author  ThemeGrill
 * @package Ample
 * @since   1.1.5
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Ample_Admin' ) ) :

	/**
	 * Ample_Admin Class.
	 */
	class Ample_Admin {

		/**
		 * Constructor.
		 */
		public function __construct() {
			add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		}

		/**
		 * Localize array for import button AJAX request.
		 */
		public function enqueue_scripts() {
			wp_enqueue_style( 'ample-admin-style', get_template_directory_uri() . '/inc/admin/css/admin.css', array(), AMPLE_THEME_VERSION );

			wp_enqueue_script( 'ample-plugin-install-helper', get_template_directory_uri() . '/inc/admin/js/plugin-handle.js', array( 'jquery' ), AMPLE_THEME_VERSION, true );

			$welcome_data = array(
				'uri'      => esc_url( admin_url( '/themes.php?page=demo-importer&browse=all&ample-hide-notice=welcome' ) ),
				'btn_text' => esc_html__( 'Processing...', 'ample' ),
				'nonce'    => wp_create_nonce( 'ample_demo_import_nonce' ),
			);

			wp_localize_script( 'ample-plugin-install-helper', 'ampleRedirectDemoPage', $welcome_data );
		}
	}

endif;

return new Ample_Admin();
