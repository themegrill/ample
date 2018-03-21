<?php
/**
 * Functions for configuring demo importer.
 *
 * @author   ThemeGrill
 * @category Admin
 * @package  Importer/Functions
 * @version  1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Setup demo importer packages.
 *
 * @param  array $packages
 *
 * @return array
 */
function ample_demo_importer_packages( $packages ) {
	$new_packages = array(
		'ample-free' => array(
			'name'    => esc_html__( 'Ample', 'ample' ),
			'preview' => 'https://demo.themegrill.com/ample/',
		),
		'ample-pro'  => array(
			'name'     => __( 'Ample Pro', 'ample' ),
			'preview'  => 'https://demo.themegrill.com/ample-pro/',
			'pro_link' => 'https://themegrill.com/themes/ample/',
		),
		'ample-pro-one-page'  => array(
			'name'     => __( 'Ample Pro One Page', 'ample' ),
			'preview'  => 'https://demo.themegrill.com/ample-pro-one-page/',
			'pro_link' => 'https://themegrill.com/themes/ample/',
		),
	);

	return array_merge( $new_packages, $packages );
}

add_filter( 'themegrill_demo_importer_packages', 'ample_demo_importer_packages' );
