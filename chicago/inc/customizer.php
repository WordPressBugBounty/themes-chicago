<?php
/**
 * Chicago Theme Customizer
 *
 * @package Chicago
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function chicago_customize_register( $wp_customize ) {

	//Include custom controls
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/customizer-custom-controls.php';

	$defaults = chicago_get_default_theme_options();

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	$jetpack_logo  = get_option( 'site_logo' );

	//If there logo present from jetpack, the $jetpack_logo['id'] becomes not empty, hence,  the check
    if ( empty( $jetpack_logo['id'] ) ) {
    	//@remove Remove this block when WordPress 4.8 is released
    	if ( ! function_exists( 'has_custom_logo' ) ) {
			// Custom Logo (added to Site Title and Tagline section in Theme Customizer)
			$wp_customize->add_setting( 'logo', array(
				'capability'		=> 'edit_theme_options',
				'default'			=> $defaults['logo'],
				'sanitize_callback'	=> 'esc_url_raw'
			) );

			$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'logo', array(
				'label'		=> __( 'Logo', 'chicago' ),
				'priority'	=> 100,
				'section'   => 'title_tagline',
		        'settings'  => 'logo',
		    ) ) );

		    $wp_customize->add_setting( 'logo_disable', array(
				'capability'		=> 'edit_theme_options',
				'default'			=> $defaults['logo_disable'],
				'sanitize_callback' => 'chicago_sanitize_checkbox',
			) );

			$wp_customize->add_control( 'logo_disable', array(
				'label'    => __( 'Check to disable logo', 'chicago' ),
				'priority' => 101,
				'section'  => 'title_tagline',
				'settings' => 'logo_disable',
				'type'     => 'checkbox',
			) );

		    $wp_customize->add_setting( 'logo_alt_text', array(
				'capability'		=> 'edit_theme_options',
				'default'			=> $defaults['logo_alt_text'],
				'sanitize_callback'	=> 'sanitize_text_field',
			) );

			$wp_customize->add_control( 'logo_alt_text', array(
				'label'    	=> __( 'Logo Alt Text', 'chicago' ),
				'priority'	=> 102,
				'section' 	=> 'title_tagline',
				'settings' 	=> 'logo_alt_text',
				'type'     	=> 'text',
			) );
			// Custom Logo End
		}
	}

	//Header Options
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/customizer-header-options.php';

	// Color Scheme
	$wp_customize->add_setting( 'color_scheme', array(
		'capability' 		=> 'edit_theme_options',
		'default'    		=> $defaults['color_scheme'],
		'sanitize_callback'	=> 'chicago_sanitize_select',
		'transport'         => 'refresh',
	) );

	$wp_customize->add_control( 'color_scheme', array(
		'choices'  => chicago_color_schemes(),
		'label'    => __( 'Color Scheme', 'chicago' ),
		'priority' => 5,
		'section'  => 'colors',
		'settings' => 'color_scheme',
		'type'     => 'radio',
	) );
	//End Color Scheme

	//Theme Options
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/customizer-theme-options.php';

	//Featured Content
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/customizer-featured-content-options.php';

	//Featured Slider
	require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/customizer-featured-slider-options.php';

	// Reset all settings to default
	$wp_customize->add_section( 'chicago_reset_all_settings', array(
		'description'	=> __( 'Caution: Reset all settings to default. Refresh the page after save to view full effects.', 'chicago' ),
		'priority' 		=> 700,
		'title'    		=> __( 'Reset all settings', 'chicago' ),
	) );

	$wp_customize->add_setting( 'reset_all_settings', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['reset_all_settings'],
		'sanitize_callback' => 'chicago_sanitize_checkbox',
		'transport'			=> 'postMessage',
	) );

	$wp_customize->add_control( 'reset_all_settings', array(
		'label'    => __( 'Check to reset all settings to default', 'chicago' ),
		'section'  => 'chicago_reset_all_settings',
		'settings' => 'reset_all_settings',
		'type'     => 'checkbox',
	) );
	// Reset all settings to default end

	$wp_customize->add_section( 'important_links', array(
		'priority' 		=> 999,
		'title'   	 	=> __( 'Important Links', 'chicago' ),
	) );

	/**
	 * Has dummy Sanitizaition function as it contains no value to be sanitized
	 */
	$wp_customize->add_setting( 'important_links', array(
		'sanitize_callback'	=> 'sanitize_text_field',
	) );

	$wp_customize->add_control( new ChicagoImportantLinks( $wp_customize, 'important_links', array(
        'label'   	=> __( 'Important Links', 'chicago' ),
        'section'  	=> 'important_links',
        'settings' 	=> 'important_links',
        'type'     	=> 'important_links',
    ) ) );
    //Important Links End

}
add_action( 'customize_register', 'chicago_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function chicago_customize_preview_js() {
	wp_enqueue_script( 'chicago_customizer', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/customizer.js', array( 'customize-preview' ), '20130508', true );

	//Flush transients
	chicago_flush_transients();
}
add_action( 'customize_preview_init', 'chicago_customize_preview_js' );


/**
 * Custom scripts and styles on customize.php for chicago.
 *
 * @since Chicago 1.1
 */
function chicago_customize_scripts() {
	wp_enqueue_script( 'chicago_customizer_custom', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/customizer-custom-scripts.js', array( 'customize-controls', 'iris', 'underscore', 'wp-util' ), '20150630', true );

	$chicago_misc_links['color_list'] = chicago_color_list();

	//Add Upgrade Button, old WordPress message and color list via localized script
	wp_localize_script( 'chicago_customizer_custom', 'chicago_misc_links', $chicago_misc_links );
}
add_action( 'customize_controls_enqueue_scripts', 'chicago_customize_scripts' );

/**
 * Returns list of color keys of array with default values for each color scheme as index
 *
 * @since Chicago 1.1
 */
function chicago_color_list() {
	// Get default color scheme values
	$default 		= chicago_default_color_options('light');
	// Get default dark color scheme valies
	$default_dark 	= chicago_default_color_options('dark');

	$chicago_color_list['background_color']['pink']	= chicago_get_default_theme_options('background_color');
	$chicago_color_list['background_color']['light']= $default['background_color'];
	$chicago_color_list['background_color']['dark']	= $default_dark['background_color'];

	$chicago_color_list['header_textcolor']['pink']	= chicago_get_default_theme_options('header_textcolor');
	$chicago_color_list['header_textcolor']['light']= $default['header_textcolor'];
	$chicago_color_list['header_textcolor']['dark']	= $default_dark['header_textcolor'];

	return $chicago_color_list;
}

/**
 * Function to reset date with respect to condition
 */
function chicago_reset_data() {
	if ( get_theme_mod( 'reset_all_settings' ) ) {
    	remove_theme_mods();

        // Flush out all transients	on reset
        chicago_flush_transients();
    }
}
add_action( 'customize_save_after', 'chicago_reset_data' );


//Active callbacks for customizer
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/customizer-active-callbacks.php';

//Sanitize functions for customizer
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/customizer-sanitize-functions.php';

// Add Upgrade to Pro Button.
require trailingslashit( get_template_directory() ) . 'inc/customizer-includes/upgrade-button/class-customize.php';
