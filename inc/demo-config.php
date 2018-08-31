<?php
/**
 * Functions for configuring demo importer.
 *
 * @package Importer/Functions
 * @version 1.0.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Setup demo importer config.
 *
 * @deprecated 1.5.0
 *
 * @param  array $demo_config Demo config.
 * @return array
 */
function ample_demo_importer_packages( $packages ) {
	$new_packages = array(
		'ample-free'         => array(
			'name'    => esc_html__( 'Ample', 'ample' ),
			'preview' => 'https://demo.themegrill.com/ample/',
		),
		'ample-pro'          => array(
			'name'     => __( 'Ample Pro', 'ample' ),
			'preview'  => 'https://demo.themegrill.com/ample-pro/',
			'pro_link' => 'https://themegrill.com/themes/ample/',
		),
		'ample-pro-one-page' => array(
			'name'     => __( 'Ample Pro One Page', 'ample' ),
			'preview'  => 'https://demo.themegrill.com/ample-pro-one-page/',
			'pro_link' => 'https://themegrill.com/themes/ample/',
		),
	);

	return array_merge( $new_packages, $packages );
}

add_filter( 'themegrill_demo_importer_packages', 'ample_demo_importer_packages' );

/**
 * Set categories checkbox to hide from blog page settings in theme customizer.
 *
 * Note: Used rarely, if `ample_option` keys are based on term ID.
 *
 * @param  array  $data
 * @param  array  $demo_data
 * @param  string $demo_id
 *
 * @return array
 */
function ample_set_cat_hide( $data, $demo_data, $demo_id ) {
	// Format the data based on demo ID.
	switch ( $demo_id ) {
		case 'ample-free':
			$wp_categories = array(
				5 => 'Portfolio',
			);
			break;
	}

	// Fetch categories selected and assign it to new category generated on demo import.
	foreach ( $wp_categories as $term_id => $term_name ) {
		if ( ! empty( $data['options']['ample[ample_hide_category]'] ) ) {
			$term = get_term_by( 'name', $term_name, 'category' );
			if ( is_object( $term ) && $term->term_id ) {
				$data['options']['ample[ample_hide_category]'] = $term->term_id;
			}
		}
	}

	return $data;
}

add_filter( 'themegrill_customizer_demo_import_settings', 'ample_set_cat_hide', 20, 3 );
