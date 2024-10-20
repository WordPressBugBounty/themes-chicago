<?php
/**
* The template for adding additional theme options in Customizer
*
* @package Catch Themes
* @subpackage Chicago
* @since Chicago 0.1
*/

$wp_customize->add_panel( 'chicago_theme_options', array(
    'description'    => __( 'Basic theme Options', 'chicago' ),
    'capability'     => 'edit_theme_options',
    'priority'       => 200,
    'title'    		 => __( 'Theme Options', 'chicago' ),
) );

// Breadcrumb Option
$wp_customize->add_section( 'chicago_breadcrumb_options', array(
	'description'	=> __( 'Breadcrumbs are a great way of letting your visitors find out where they are on your site with just a glance. You can enable/disable them on homepage and entire site.', 'chicago' ),
	'panel'			=> 'chicago_theme_options',
	'title'    		=> __( 'Breadcrumb Options', 'chicago' ),
	'priority' 		=> 201,
) );

$wp_customize->add_setting( 'breadcrumb_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcrumb_option'],
	'sanitize_callback' => 'chicago_sanitize_checkbox'
) );

$wp_customize->add_control( 'breadcrumb_options', array(
	'label'    => __( 'Check to enable Breadcrumb', 'chicago' ),
	'section'  => 'chicago_breadcrumb_options',
	'settings' => 'breadcrumb_option',
	'type'     => 'checkbox',
) );

$wp_customize->add_setting( 'breadcrumb_onhomepage', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcrumb_onhomepage'],
	'sanitize_callback' => 'chicago_sanitize_checkbox'
) );

$wp_customize->add_control( 'breadcrumb_onhomepage', array(
	'label'    => __( 'Check to enable Breadcrumb on Homepage', 'chicago' ),
	'section'  => 'chicago_breadcrumb_options',
	'settings' => 'breadcrumb_onhomepage',
	'type'     => 'checkbox',
) );

$wp_customize->add_setting( 'breadcrumb_seperator', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['breadcrumb_seperator'],
	'sanitize_callback'	=> 'sanitize_text_field',
) );

$wp_customize->add_control( 'breadcrumb_seperator', array(
	'input_attrs' => array(
    		'style' => 'width: 40px;'
		),
	'label'    	=> __( 'Seperator between Breadcrumbs', 'chicago' ),
	'section' 	=> 'chicago_breadcrumb_options',
	'settings' 	=> 'breadcrumb_seperator',
	'type'     	=> 'text'
	)
);
	// Breadcrumb Option End

/**
 * Do not show Custom CSS option from WordPress 4.7 onwards
 * @remove when WP 5.0 is released
 */
if ( ! function_exists( 'wp_update_custom_css_post' ) ) {
	// Custom CSS Option
	$wp_customize->add_section( 'chicago_custom_css', array(
		'description'	=> __( 'Custom/Inline CSS', 'chicago'),
		'panel'  		=> 'chicago_theme_options',
		'priority' 		=> 203,
		'title'    		=> __( 'Custom CSS Options', 'chicago' ),
	) );

	$wp_customize->add_setting( 'custom_css', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['custom_css'],
		'sanitize_callback' => 'chicago_sanitize_custom_css',
	) );

	$wp_customize->add_control( 'custom_css', array(
			'label'		=> __( 'Enter Custom CSS', 'chicago' ),
	        'priority'	=> 1,
			'section'   => 'chicago_custom_css',
	        'settings'  => 'custom_css',
			'type'		=> 'textarea',
	) ) ;
	// Custom CSS End
}

	// Excerpt Options
$wp_customize->add_section( 'chicago_excerpt_options', array(
	'panel'  	=> 'chicago_theme_options',
	'priority' 	=> 204,
	'title'    	=> __( 'Excerpt Options', 'chicago' ),
) );

$wp_customize->add_setting( 'excerpt_length', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['excerpt_length'],
	'sanitize_callback' => 'absint',
) );

$wp_customize->add_control( 'excerpt_length', array(
	'description' => __('Excerpt length. Default is 40 words', 'chicago'),
	'input_attrs' => array(
        'min'   => 10,
        'max'   => 200,
        'step'  => 5,
        'style' => 'width: 60px;'
        ),
    'label'    => __( 'Excerpt Length (words)', 'chicago' ),
	'section'  => 'chicago_excerpt_options',
	'settings' => 'excerpt_length',
	'type'	   => 'number',
	)
);

$wp_customize->add_setting( 'excerpt_more_text', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['excerpt_more_text'],
	'sanitize_callback'	=> 'sanitize_text_field',
) );

$wp_customize->add_control( 'excerpt_more_text', array(
	'label'    => __( 'Read More Text', 'chicago' ),
	'section'  => 'chicago_excerpt_options',
	'settings' => 'excerpt_more_text',
	'type'	   => 'text',
) );
// Excerpt Options End

//Homepage / Frontpage Options
$wp_customize->add_section( 'chicago_homepage_options', array(
	'description'	=> __( 'Only posts that belong to the categories selected here will be displayed on the front page', 'chicago' ),
	'panel'			=> 'chicago_theme_options',
	'priority' 		=> 209,
	'title'   	 	=> __( 'Homepage / Frontpage Options', 'chicago' ),
) );

$wp_customize->add_setting( 'front_page_category', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['front_page_category'],
	'sanitize_callback'	=> 'chicago_sanitize_category_list',
) );

$wp_customize->add_control( new Chicago_Customize_Dropdown_Categories_Control( $wp_customize, 'front_page_category', array(
    'label'   	=> __( 'Select Categories', 'chicago' ),
    'name'	 	=> 'front_page_category',
	'priority'	=> '6',
    'section'  	=> 'chicago_homepage_options',
    'settings' 	=> 'front_page_category',
    'type'     	=> 'dropdown-categories',
) ) );
//Homepage / Frontpage Settings End


// Layout Options
$wp_customize->add_section( 'chicago_layout', array(
	'capability'=> 'edit_theme_options',
	'panel'		=> 'chicago_theme_options',
	'priority'	=> 211,
	'title'		=> __( 'Layout Options', 'chicago' ),
) );

$wp_customize->add_setting( 'theme_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['theme_layout'],
	'sanitize_callback' => 'chicago_sanitize_select',
) );

$wp_customize->add_control( 'theme_layout', array(
	'choices'	=> chicago_layouts(),
	'label'		=> __( 'Default Layout', 'chicago' ),
	'section'	=> 'chicago_layout',
	'settings'  => 'theme_layout',
	'type'		=> 'select',
) );

$wp_customize->add_setting( 'content_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['content_layout'],
	'sanitize_callback' => 'chicago_sanitize_select',
) );

$wp_customize->add_control( 'content_layout', array(
	'choices'   => chicago_get_archive_content_layout(),
	'label'		=> __( 'Archive Content Layout', 'chicago' ),
	'section'   => 'chicago_layout',
	'settings'  => 'content_layout',
	'type'      => 'select',
) );

$wp_customize->add_setting( 'single_post_image_layout', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['single_post_image_layout'],
	'sanitize_callback' => 'chicago_sanitize_select',
) );

$wp_customize->add_control( 'single_post_image_layout', array(
		'label'		=> __( 'Single Page/Post Image Layout ', 'chicago' ),
		'section'   => 'chicago_layout',
        'settings'  => 'single_post_image_layout',
        'type'	  	=> 'select',
		'choices'  	=> chicago_single_post_image_layout_options(),
) );
	// Layout Options End

// Pagination Options
$pagination_type	= get_theme_mod( 'pagination_type' );

$chicago_navigation_description = sprintf( __( 'Numeric Option requires <a target="_blank" href="%1$s">WP-PageNavi Plugin</a>.<br/>Infinite Scroll Options requires <a target="_blank" href="%2$s">JetPack Plugin</a> with Infinite Scroll module Enabled.', 'chicago' ), esc_url( 'https://wordpress.org/plugins/wp-pagenavi' ), esc_url( 'https://wordpress.org/plugins/jetpack/' ) );

/**
 * Check if navigation type is Jetpack Infinite Scroll and if it is enabled
 */
if ( ( 'infinite-scroll-click' == $pagination_type || 'infinite-scroll-scroll' == $pagination_type ) ) {
	if ( ! (class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) ) {
		$chicago_navigation_description = sprintf( __( 'Infinite Scroll Options requires <a target="_blank" href="%s">JetPack Plugin</a> with Infinite Scroll module Enabled.', 'chicago' ), esc_url( 'https://wordpress.org/plugins/jetpack/' ) );
	}
	else {
		$chicago_navigation_description = '';
	}
}

$wp_customize->add_section( 'chicago_pagination_options', array(
	'description'	=> $chicago_navigation_description,
	'panel'  		=> 'chicago_theme_options',
	'priority'		=> 212,
	'title'    		=> __( 'Pagination Options', 'chicago' ),
) );

$wp_customize->add_setting( 'pagination_type', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['pagination_type'],
	'sanitize_callback' => 'chicago_sanitize_select',
) );

$wp_customize->add_control( 'pagination_type', array(
	'choices'  => chicago_get_pagination_types(),
	'label'    => __( 'Pagination type', 'chicago' ),
	'section'  => 'chicago_pagination_options',
	'settings' => 'pagination_type',
	'type'	   => 'select',
) );
// Pagination Options End

//Promotion Headline Options
$wp_customize->add_section( 'chicago_promotion_headline_options', array(
	'description'	=> __( 'To disable the fields, simply leave them empty.', 'chicago' ),
	'panel'			=> 'chicago_theme_options',
	'priority' 		=> 213,
	'title'   	 	=> __( 'Promotion Headline Options', 'chicago' ),
) );

$wp_customize->add_setting( 'promotion_headline_option', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['promotion_headline_option'],
	'sanitize_callback' => 'chicago_sanitize_select',
) );

$wp_customize->add_control( 'promotion_headline_option', array(
	'choices'  	=> chicago_featured_slider_options(),
	'label'    	=> __( 'Enable Promotion Headline on', 'chicago' ),
	'priority'	=> '0.5',
	'section'  	=> 'chicago_promotion_headline_options',
	'settings' 	=> 'promotion_headline_option',
	'type'	  	=> 'select',
) );

$wp_customize->add_setting( 'promotion_headline', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline'],
	'sanitize_callback'	=> 'wp_kses_post'
) );

$wp_customize->add_control( 'promotion_headline', array(
	'description'	=> __( 'Appropriate Words: 10', 'chicago' ),
	'label'    		=> __( 'Promotion Headline Text', 'chicago' ),
	'priority'		=> '1',
	'section' 		=> 'chicago_promotion_headline_options',
	'settings'		=> 'promotion_headline',
	'type'			=> 'textarea',
) );

$wp_customize->add_setting( 'promotion_subheadline', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_subheadline'],
	'sanitize_callback'	=> 'wp_kses_post'
) );

$wp_customize->add_control( 'promotion_subheadline', array(
	'description'	=> __( 'Appropriate Words: 15', 'chicago' ),
	'label'    		=> __( 'Promotion Subheadline Text', 'chicago' ),
	'priority'		=> '2',
	'section' 		=> 'chicago_promotion_headline_options',
	'settings'		=> 'promotion_subheadline',
	'type'			=> 'textarea',
) );

$wp_customize->add_setting( 'promotion_headline_button', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline_button'],
	'sanitize_callback'	=> 'sanitize_text_field'
) );

$wp_customize->add_control( 'promotion_headline_button', array(
	'description'	=> __( 'Appropriate Words: 3', 'chicago' ),
	'label'    		=> __( 'Promotion Headline Button Text ', 'chicago' ),
	'priority'		=> '3',
	'section' 		=> 'chicago_promotion_headline_options',
	'settings'		=> 'promotion_headline_button',
	'type'			=> 'text',
) );

$wp_customize->add_setting( 'promotion_headline_url', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline_url'],
	'sanitize_callback'	=> 'esc_url_raw'
) );

$wp_customize->add_control( 'promotion_headline_url', array(
	'label'    	=> __( 'Promotion Headline Link', 'chicago' ),
	'priority'	=> '4',
	'section' 	=> 'chicago_promotion_headline_options',
	'settings'	=> 'promotion_headline_url',
	'type'		=> 'text',
) );

$wp_customize->add_setting( 'promotion_headline_target', array(
	'capability'		=> 'edit_theme_options',
	'default' 			=> $defaults['promotion_headline_target'],
	'sanitize_callback' => 'chicago_sanitize_checkbox',
) );

$wp_customize->add_control( 'promotion_headline_target', array(
	'label'    	=> __( 'Check to Open Link in New Window/Tab', 'chicago' ),
	'priority'	=> '5',
	'section'  	=> 'chicago_promotion_headline_options',
	'settings' 	=> 'promotion_headline_target',
	'type'     	=> 'checkbox',
) );
// Promotion Headline Options End

// Scrollup
$wp_customize->add_section( 'chicago_scrollup', array(
	'panel'    => 'chicago_theme_options',
	'priority' => 215,
	'title'    => __( 'Scrollup Options', 'chicago' ),
) );

$wp_customize->add_setting( 'disable_scrollup', array(
	'capability'		=> 'edit_theme_options',
    'default'			=> $defaults['disable_scrollup'],
	'sanitize_callback' => 'chicago_sanitize_checkbox',
) );

$wp_customize->add_control( 'disable_scrollup', array(
	'label'		=> __( 'Check to disable Scroll Up', 'chicago' ),
	'section'   => 'chicago_scrollup',
    'settings'  => 'disable_scrollup',
	'type'		=> 'checkbox',
) );
// Scrollup End

// Search Options
$wp_customize->add_section( 'chicago_search_options', array(
	'description'=> __( 'Change default placeholder text in Search.', 'chicago'),
	'panel'  => 'chicago_theme_options',
	'priority' => 216,
	'title'    => __( 'Search Options', 'chicago' ),
) );

$wp_customize->add_setting( 'search_text', array(
	'capability'		=> 'edit_theme_options',
	'default'			=> $defaults['search_text'],
	'sanitize_callback' => 'sanitize_text_field',
) );

$wp_customize->add_control( 'search_text', array(
	'label'		=> __( 'Default Display Text in Search', 'chicago' ),
	'section'   => 'chicago_search_options',
    'settings'  => 'search_text',
	'type'		=> 'text',
) );
// Search Options End