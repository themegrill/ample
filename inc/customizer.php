<?php
/**
 * Ample Pro Theme Customizer
 *
 * @package    ThemeGrill
 * @subpackage Ample
 * @since      Ample 1.0.7
 */
function ample_customize_register( $wp_customize ) {

	require get_template_directory() . '/inc/customize-controls/class-ample-controls-multicheck-control.php';
	require get_template_directory() . '/inc/customize-controls/class-ample-custom-css-control.php';
	require get_template_directory() . '/inc/customize-controls/class-ample-upsell-section.php';
	require get_template_directory() . '/inc/customize-controls/class-ample-image-radio-control.php';

	// Transport postMessage variable set
	$customizer_selective_refresh = isset( $wp_customize->selective_refresh ) ? 'postMessage' : 'refresh';

	$wp_customize->get_setting( 'blogname' )->transport        = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'blogname', array(
			'selector'        => '#site-title a',
			'render_callback' => 'ample_customize_partial_blogname',
		) );

		$wp_customize->selective_refresh->add_partial( 'blogdescription', array(
			'selector'        => '#site-description',
			'render_callback' => 'ample_customize_partial_blogdescription',
		) );
	}

	// Header Options Area
	$wp_customize->add_panel( 'ample_header', array(
		'title'      => __( 'Header', 'ample' ),
		'capabitity' => 'edit_theme_options',
		'priority'   => 300,
	) );

	// Header logo and text display type option
	$wp_customize->add_section( 'ample_header_logo_text', array(
		'title'    => __( 'Show', 'ample' ),
		'priority' => 20,
		'panel'    => 'ample_header',
	) );

	$wp_customize->add_setting( 'ample[ample_show_header_logo_text]', array(
		'default'           => 'text_only',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_show_header_logo_text]', array(
		'type'    => 'radio',
		'label'   => __( 'Choose the option that you want.', 'ample' ),
		'section' => 'title_tagline',
		'choices' => array(
			'logo_only' => __( 'Header Logo Only', 'ample' ),
			'text_only' => __( 'Header Text Only', 'ample' ),
			'both'      => __( 'Show Both', 'ample' ),
			'none'      => __( 'Disable', 'ample' ),
		),
	) );

	// New Responsive Menu
	$wp_customize->add_section( 'ample_new_menu', array(
		'priority' => 25,
		'title'    => __( 'Responsive Menu Style', 'ample' ),
		'panel'    => 'ample_header',
	) );

	$wp_customize->add_setting( 'ample[ample_new_menu_enable]', array(
		'default'           => '1',
		'type'              => 'option',
		'capability'        => 'edit_theme_options',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_new_menu_enable]', array(
		'type'    => 'checkbox',
		'label'   => __( 'Switch to new responsive menu.', 'ample' ),
		'section' => 'ample_new_menu',
	) );

	// Header Title Bar Background Image upload option
	$wp_customize->add_section( 'ample_header_title_bar', array(
		'title'    => __( 'Header Title Bar Background Image', 'ample' ),
		'priority' => 30,
		'panel'    => 'ample_header',
	) );
	$wp_customize->add_setting( 'ample[ample_header_title_background_image]', array(
		'default'              => '',
		'capability'           => 'edit_theme_options',
		'type'                 => 'option',
		'sanitize_callback'    => 'ample_sanitize_url',
		'sanitize_js_callback' => 'ample_sanitize_js_url',
	) );
	$wp_customize->add_control(
		new WP_Customize_Image_Control( $wp_customize, 'ample[ample_header_title_background_image]', array(
			'label'    => __( 'Upload Background Image for Header Title Bar.', 'ample' ),
			'section'  => 'ample_header_title_bar',
			'settings' => 'ample[ample_header_title_background_image]',
		) )
	);
	// Header Title Bar Background color option
	$wp_customize->add_setting( 'ample[ample_title_bar_background_color]', array(
		'default'              => '#80abc8',
		'capability'           => 'edit_theme_options',
		'type'                 => 'option',
		'sanitize_callback'    => 'ample_sanitize_hex_color',
		'sanitize_js_callback' => 'ample_sanitize_escaping',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'ample[ample_title_bar_background_color]', array(
			'label'    => __( 'Choose Background Color for Header Title Bar', 'ample' ),
			'section'  => 'ample_header_title_bar',
			'settings' => 'ample[ample_title_bar_background_color]',
		) )
	);
	// Header Title Bar Text color option
	$wp_customize->add_setting( 'ample[ample_header_title_color]', array(
		'default'              => '#ffffff',
		'capability'           => 'edit_theme_options',
		'type'                 => 'option',
		'sanitize_callback'    => 'ample_sanitize_hex_color',
		'sanitize_js_callback' => 'ample_sanitize_escaping',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'ample[ample_header_title_color]', array(
			'label'    => __( 'Choose Text Color for Header Title Bar', 'ample' ),
			'section'  => 'ample_header_title_bar',
			'settings' => 'ample[ample_header_title_color]',
		) )
	);

	// Header Image Position
	$wp_customize->add_section( 'ample_header_image_position_setting', array(
		'title'    => __( 'Header Image Position', 'ample' ),
		'priority' => 40,
		'panel'    => 'ample_header',
	) );

	$wp_customize->add_setting( 'ample[ample_header_image_position]', array(
		'default'           => 'above',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_header_image_position]', array(
		'type'    => 'radio',
		'label'   => __( 'Choose top header image display position.', 'ample' ),
		'section' => 'ample_header_image_position_setting',
		'choices' => array(
			'above' => __( 'Position Above (Default): Display the Header image just above the site title and main menu part.', 'ample' ),
			'below' => __( 'Position Below: Display the Header image just below the site title and main menu part.', 'ample' ),
		),
	) );
	// End of the Header Options

	/**************************************************************************************/

	// Design Options Area
	$wp_customize->add_panel( 'ample_design_options', array(
		'title'      => __( 'Design', 'ample' ),
		'capabitity' => 'edit_theme_options',
		'priority'   => 310,
	) );

	// Site Layout
	$wp_customize->add_section( 'ample_site_layout_setting', array(
		'title'    => __( 'Site Layout', 'ample' ),
		'priority' => 10,
		'panel'    => 'ample_design_options',
	) );

	$wp_customize->add_setting( 'ample[ample_site_layout]', array(
		'default'           => 'wide',
		'capability'        => 'edit_theme_options',
		'transport'         => 'postMessage',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control( 'ample[ample_site_layout]', array(
		'type'    => 'radio',
		'label'   => __( 'Choose your site layout. The change is reflected in whole site.', 'ample' ),
		'section' => 'ample_site_layout_setting',
		'choices' => array(
			'wide' => __( 'Wide layout', 'ample' ),
			'box'  => __( 'Boxed layout', 'ample' ),
		),
	) );

	// Default layout
	$wp_customize->add_section( 'ample_default_layout_setting', array(
		'title'    => __( 'Default layout', 'ample' ),
		'priority' => 20,
		'panel'    => 'ample_design_options',
	) );

	$wp_customize->add_setting( 'ample[ample_default_layout]', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control(
		new AMPLE_Image_Radio_Control( $wp_customize, 'ample[ample_default_layout]', array(
			'type'    => 'radio',
			'label'   => __( 'Select default layout. This layout will be reflected in whole site archives, search etc. The layout for a single post and page can be controlled from below options.', 'ample' ),
			'section' => 'ample_default_layout_setting',
			'choices' => array(
				'right_sidebar'               => get_template_directory_uri() . '/inc/admin/images/right-sidebar.png',
				'left_sidebar'                => get_template_directory_uri() . '/inc/admin/images/left-sidebar.png',
				'no_sidebar_full_width'       => get_template_directory_uri() . '/inc/admin/images/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered' => get_template_directory_uri() . '/inc/admin/images/no-sidebar-content-centered-layout.png',
				'both_sidebar'                => get_template_directory_uri() . '/inc/admin/images/both-sidebar.png',
			),
		) )
	);

	// Default layout for pages only
	$wp_customize->add_section( 'ample_pages_default_layout_setting', array(
		'title'    => __( 'Default layout for pages only', 'ample' ),
		'priority' => 30,
		'panel'    => 'ample_design_options',
	) );

	$wp_customize->add_setting( 'ample[ample_pages_default_layout]', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control(
		new AMPLE_Image_Radio_Control( $wp_customize, 'ample[ample_pages_default_layout]', array(
			'type'    => 'radio',
			'label'   => __( 'Select default layout for pages. This layout will be reflected in all pages unless unique layout is set for specific page.', 'ample' ),
			'section' => 'ample_pages_default_layout_setting',
			'choices' => array(
				'right_sidebar'               => get_template_directory_uri() . '/inc/admin/images/right-sidebar.png',
				'left_sidebar'                => get_template_directory_uri() . '/inc/admin/images/left-sidebar.png',
				'no_sidebar_full_width'       => get_template_directory_uri() . '/inc/admin/images/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered' => get_template_directory_uri() . '/inc/admin/images/no-sidebar-content-centered-layout.png',
				'both_sidebar'                => get_template_directory_uri() . '/inc/admin/images/both-sidebar.png',
			),
		) )
	);

	// Default layout for single posts only
	$wp_customize->add_section( 'ample_single_posts_default_layout_setting', array(
		'title'    => __( 'Default layout for single posts only', 'ample' ),
		'priority' => 40,
		'panel'    => 'ample_design_options',
	) );

	$wp_customize->add_setting( 'ample[ample_single_posts_default_layout]', array(
		'default'           => 'right_sidebar',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );
	$wp_customize->add_control(
		new AMPLE_Image_Radio_Control( $wp_customize, 'ample[ample_single_posts_default_layout]', array(
			'type'    => 'radio',
			'label'   => __( 'Select default layout for single posts. This layout will be reflected in all single posts unless unique layout is set for specific post.', 'ample' ),
			'section' => 'ample_single_posts_default_layout_setting',
			'choices' => array(
				'right_sidebar'               => get_template_directory_uri() . '/inc/admin/images/right-sidebar.png',
				'left_sidebar'                => get_template_directory_uri() . '/inc/admin/images/left-sidebar.png',
				'no_sidebar_full_width'       => get_template_directory_uri() . '/inc/admin/images/no-sidebar-full-width-layout.png',
				'no_sidebar_content_centered' => get_template_directory_uri() . '/inc/admin/images/no-sidebar-content-centered-layout.png',
				'both_sidebar'                => get_template_directory_uri() . '/inc/admin/images/both-sidebar.png',
			),
		) )
	);

	// Site primary color option
	$wp_customize->add_section( 'ample_primary_color_setting', array(
		'panel'    => 'ample_design_options',
		'priority' => 50,
		'title'    => __( 'Primary color option', 'ample' ),
	) );

	$wp_customize->add_setting( 'ample[ample_primary_color]', array(
		'default'              => '#80abc8',
		'capability'           => 'edit_theme_options',
		'type'                 => 'option',
		'sanitize_callback'    => 'ample_sanitize_hex_color',
		'sanitize_js_callback' => 'ample_sanitize_escaping',
	) );
	$wp_customize->add_control(
		new WP_Customize_Color_Control( $wp_customize, 'ample[ample_primary_color]', array(
			'label'    => __( 'This will reflect in links, buttons and many others. Choose a color to match your site.', 'ample' ),
			'section'  => 'ample_primary_color_setting',
			'settings' => 'ample[ample_primary_color]',
		) )
	);

	if ( ! function_exists( 'wp_update_custom_css_post' ) ) {

		$wp_customize->add_section( 'ample_custom_css_setting', array(
			'priority' => 60,
			'title'    => __( 'Custom CSS', 'ample' ),
			'panel'    => 'ample_design_options',
		) );

		$wp_customize->add_setting( 'ample[ample_custom_css]', array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'type'                 => 'option',
			'sanitize_callback'    => 'wp_filter_nohtml_kses',
			'sanitize_js_callback' => 'wp_filter_nohtml_kses',
		) );
		$wp_customize->add_control(
			new AMPLE_Custom_CSS_Control( $wp_customize, 'ample[ample_custom_css]', array(
				'label'    => __( 'Write your custom css.', 'ample' ),
				'section'  => 'ample_custom_css_setting',
				'settings' => 'ample[ample_custom_css]',
			) )
		);
	}
	// End of the Design Options

	/**************************************************************************************/

	/* Slider Options Area */
	$wp_customize->add_panel( 'ample_slider_options', array(
		'capabitity' => 'edit_theme_options',
		'priority'   => 320,
		'title'      => __( 'Slider', 'ample' ),
	) );

	// Slider activate option
	$wp_customize->add_section( 'ample_activate_slider_setting', array(
		'title'    => __( 'Activate slider', 'ample' ),
		'priority' => 10,
		'panel'    => 'ample_slider_options',
	) );

	$wp_customize->add_setting( 'ample[ample_activate_slider]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'transport'         => $customizer_selective_refresh,
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_activate_slider]', array(
		'type'    => 'checkbox',
		'label'   => __( 'Check to activate slider.', 'ample' ),
		'section' => 'ample_activate_slider_setting',
	) );

	// Selective refresh for slider
	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial( 'ample[ample_activate_slider]', array(
			'selector'        => '.big-slider-wrapper',
			'render_callback' => '',
		) );
	}

	// Slide options
	for ( $i = 1; $i <= 4; $i ++ ) {
		// Slider Image upload
		$wp_customize->add_section( 'ample_slider_image_setting' . $i, array(
			'title'    => sprintf( __( 'Slider #%1$s', 'ample' ), $i ),
			'priority' => $i + 50,
			'panel'    => 'ample_slider_options',
		) );

		$wp_customize->add_setting( 'ample[ample_slider_image' . $i . ']', array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'type'                 => 'option',
			'sanitize_callback'    => 'ample_sanitize_url',
			'sanitize_js_callback' => 'ample_sanitize_js_url',
		) );
		$wp_customize->add_control(
			new WP_Customize_Image_Control( $wp_customize, 'ample[ample_slider_image' . $i . ']', array(
				'label'    => __( 'Upload image', 'ample' ),
				'section'  => 'ample_slider_image_setting' . $i,
				'settings' => 'ample[ample_slider_image' . $i . ']',
			) )
		);

		// Slider Title
		$wp_customize->add_setting( 'ample[ample_slider_title' . $i . ']', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'sanitize_callback' => 'wp_filter_nohtml_kses',

		) );
		$wp_customize->add_control( 'ample[ample_slider_title' . $i . ']', array(
			'label'    => __( 'Enter title for this slide', 'ample' ),
			'section'  => 'ample_slider_image_setting' . $i,
			'settings' => 'ample[ample_slider_title' . $i . ']',
		) );

		// Button Text
		$wp_customize->add_setting( 'ample[ample_slider_button_text' . $i . ']', array(
			'default'           => '',
			'capability'        => 'edit_theme_options',
			'type'              => 'option',
			'sanitize_callback' => 'wp_filter_nohtml_kses',

		) );
		$wp_customize->add_control( 'ample[ample_slider_button_text' . $i . ']', array(
			'label'    => __( 'Enter button text', 'ample' ),
			'section'  => 'ample_slider_image_setting' . $i,
			'settings' => 'ample[ample_slider_button_text' . $i . ']',
		) );

		// Button Link
		$wp_customize->add_setting( 'ample[ample_slider_link' . $i . ']', array(
			'default'              => '',
			'capability'           => 'edit_theme_options',
			'type'                 => 'option',
			'sanitize_callback'    => 'ample_sanitize_url',
			'sanitize_js_callback' => 'ample_sanitize_js_url',

		) );
		$wp_customize->add_control( 'ample[ample_slider_link' . $i . ']', array(
			'label'    => __( 'Enter link to redirect', 'ample' ),
			'section'  => 'ample_slider_image_setting' . $i,
			'settings' => 'ample[ample_slider_link' . $i . ']',
		) );
	}
	// End of the Slider Options

	/**************************************************************************************/

	/* Additional Options Area */
	$wp_customize->add_panel( 'ample_additional_options', array(
		'capabitity' => 'edit_theme_options',
		'priority'   => 330,
		'title'      => __( 'Additional', 'ample' ),
	) );

	// Pull all the categories into an array
	$options_categories     = array();
	$options_categories_obj = get_categories();
	foreach ( $options_categories_obj as $category ) {
		$options_categories[ $category->cat_ID ] = $category->cat_name;
	}

	// Select category to hide from Post Page
	$wp_customize->add_section( 'ample_hide_category_setting', array(
		'title'    => __( 'Category to hide from Blog', 'ample' ),
		'priority' => 20,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_hide_category]', array(
		'default'           => '',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'wp_filter_nohtml_kses',
	) );
	$wp_customize->add_control(
		new AMPLE_Controls_MultiCheck_Control( $wp_customize, 'ample[ample_hide_category]', array(
			'label'   => __( 'Select a Category or Categories to hide its posts from Blog page.', 'ample' ),
			'section' => 'ample_hide_category_setting',
			'setting' => 'ample[ample_hide_category]',
			'choices' => $options_categories,
		) )
	);

	// Author bio opion.
	$wp_customize->add_section( 'ample_author_bio_section', array(
		'title'    => esc_html__( 'Author Bio Option', 'ample' ),
		'priority' => 60,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_author_bio_setting]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );
	$wp_customize->add_control( 'ample[ample_author_bio_setting]', array(
		'type'    => 'checkbox',
		'label'   => __( 'Check to display author bio', 'ample' ),
		'section' => 'ample_author_bio_section',
		'setting' => 'ample[ample_author_bio_setting]',
	) );

	// Related posts option.
	$wp_customize->add_section( 'ample_related_posts_section', array(
		'title'    => esc_html__( 'Related Posts', 'ample' ),
		'priority' => 60,
		'panel'    => 'ample_additional_options',
	) );

	$wp_customize->add_setting( 'ample[ample_related_posts_setting]', array(
		'default'           => 0,
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'ample[ample_related_posts_setting]', array(
		'type'     => 'checkbox',
		'label'    => esc_html__( 'Check to display related posts', 'ample' ),
		'section'  => 'ample_related_posts_section',
		'settings' => 'ample[ample_related_posts_setting]',
	) );

	$wp_customize->add_setting( 'ample[ample_related_posts]', array(
		'default'           => 'categories',
		'capability'        => 'edit_theme_options',
		'type'              => 'option',
		'sanitize_callback' => 'ample_radio_sanitize',
	) );

	$wp_customize->add_control( 'ample[ample_related_posts]', array(
		'type'     => 'radio',
		'label'    => esc_html__( 'Related Posts Must Be Shown As:', 'ample' ),
		'section'  => 'ample_related_posts_section',
		'settings' => 'ample[ample_related_posts]',
		'choices'  => array(
			'categories' => esc_html__( 'Related Posts By Categories', 'ample' ),
			'tags'       => esc_html__( 'Related Posts By Tags', 'ample' ),
		),
	) );
	// End of the Additional Options

	/**************************************************************************************/

// Register `AMPLE_Upsell_Section` type section.
	$wp_customize->register_section_type( 'AMPLE_Upsell_Section' );

// Add `AMPLE_Upsell_Section` to display pro link.
	$wp_customize->add_section(
		new AMPLE_Upsell_Section( $wp_customize, 'ample_upsell_section',
			array(
				'title'      => esc_html__( 'View PRO version', 'ample' ),
				'url'        => 'https://themegrill.com/themes/ample/?utm_source=ample-customizer&utm_medium=view-pro-link&utm_campaign=view-pro#free-vs-pro',
				'capability' => 'edit_theme_options',
				'priority'   => 1,
			)
		)
	);

	/**************************************************************************************/

	// Checkbox sanitization
	function ample_sanitize_checkbox( $input ) {
		if ( $input == 1 ) {
			return 1;
		} else {
			return '';
		}
	}

	// URL sanitization
	function ample_sanitize_url( $input ) {
		$input = esc_url_raw( $input );

		return $input;
	}

	function ample_sanitize_js_url( $input ) {
		$input = esc_url( $input );

		return $input;
	}

	// Color sanitization
	function ample_sanitize_hex_color( $color ) {
		if ( $unhashed = sanitize_hex_color_no_hash( $color ) ) {
			return '#' . $unhashed;
		}

		return $color;
	}

	function ample_sanitize_escaping( $input ) {
		$input = esc_attr( $input );

		return $input;
	}

	// Radio/Select sanitization
	function ample_radio_sanitize( $input, $setting ) {

		// Ensure input is a slug.
		$input = sanitize_key( $input );

		// Get list of choices from the control associated with the setting.
		$choices = $setting->manager->get_control( $setting->id )->choices;

		// If the input is a valid key, return it; otherwise, return the default.
		return ( array_key_exists( $input, $choices ) ? $input : $setting->default );
	}

	// Sanitization of links
	function ample_links_sanitize() {
		return false;
	}
}

add_action( 'customize_register', 'ample_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 *
 * @since Ample 1.1.8
 */
function ample_customize_preview_js() {
	wp_enqueue_script( 'ample-customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), false, true );
}

add_action( 'customize_preview_init', 'ample_customize_preview_js' );

/**
 * Render the site title for the selective refresh partial.
 *
 * @return void
 */
function ample_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 *
 * @return void
 */
function ample_customize_partial_blogdescription() {
	bloginfo( 'description' );
}


/*****************************************************************************************/

/*
 * Custom Scripts
 */
add_action( 'customize_controls_print_footer_scripts', 'ample_customizer_custom_scripts' );

function ample_customizer_custom_scripts() { ?>
	<style>
		/* Theme Instructions Panel CSS */
		li#accordion-section-ample_upsell_section h3.accordion-section-title {
			background-color: #80ABC8 !important;
			border-left-color: #427190 !important;
		}

		#accordion-section-ample_upsell_section h3 a:after {
			content: '\f345';
			color: #fff;
			position: absolute;
			top: 12px;
			right: 10px;
			z-index: 1;
			font: 400 20px/1 dashicons;
			speak: none;
			display: block;
			-webkit-font-smoothing: antialiased;
			-moz-osx-font-smoothing: grayscale;
			text-decoration: none !important;
		}

		li#accordion-section-ample_upsell_section h3.accordion-section-title a {
			display: block;
			color: #fff !important;
			text-decoration: none;
		}

		li#accordion-section-ample_upsell_section h3.accordion-section-title a:focus {
			box-shadow: none;
		}

		li#accordion-section-ample_upsell_section h3.accordion-section-title:hover {
			background-color: #6496b7 !important;
			color: #fff !important;
		}

		li#accordion-section-ample_upsell_section h3.accordion-section-title:after {
			color: #fff !important;
		}

		/* Upsell button CSS */

		.customize-control-ample-important-links a {
			/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#8fc800+0,8fc800+100;Green+Flat+%232 */
			background: #008EC2;
			color: #fff;
			display: block;
			margin: 15px 0 0;
			padding: 5px 0;
			text-align: center;
			font-weight: 600;
		}

		.customize-control-ample-important-links a {
			padding: 8px 0;
		}

		.customize-control-ample-important-links a:hover {
			color: #ffffff;
			/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#006e2e+0,006e2e+100;Green+Flat+%233 */
			background: #2380BA;
		}
	</style>

	<script>
		( function ( $, api ) {
			api.sectionConstructor['ample-upsell-section'] = api.Section.extend( {

				// No events for this type of section.
				attachEvents : function () {
				},

				// Always make the section active.
				isContextuallyActive : function () {
					return true;
				}
			} );
		} )( jQuery, wp.customize );

	</script>
	<?php
}
