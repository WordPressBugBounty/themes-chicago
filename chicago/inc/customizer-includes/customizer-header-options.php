<?php
/**
 * The template for adding Additional Header Option in Customizer
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

	// Header Options
	$wp_customize->add_setting( 'enable_featured_header_image', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['enable_featured_header_image'],
		'sanitize_callback' => 'chicago_sanitize_select',
	) );

	$wp_customize->add_control( 'enable_featured_header_image', array(
			'choices'  	=> chicago_enable_featured_header_image_options(),
			'label'		=> __( 'Enable Featured Header Image on ', 'chicago' ),
			'section'   => 'header_image',
	        'settings'  => 'enable_featured_header_image',
	        'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'featured_image_size', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_image_size'],
		'sanitize_callback' => 'chicago_sanitize_select',
	) );

	$wp_customize->add_control( 'featured_image_size', array(
			'choices'  	=> chicago_featured_image_size_options(),
			'label'		=> __( 'Page/Post Featured Image Size', 'chicago' ),
			'section'   => 'header_image',
			'settings'  => 'featured_image_size',
			'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'featured_header_image_alt', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_header_image_alt'],
		'sanitize_callback' => 'sanitize_text_field',
	) );

	$wp_customize->add_control( 'featured_header_image_alt', array(
			'label'		=> __( 'Featured Header Image Alt/Title Tag ', 'chicago' ),
			'section'   => 'header_image',
	        'settings'  => 'featured_header_image_alt',
	        'type'	  	=> 'text',
	) );

	$wp_customize->add_setting( 'featured_header_image_url', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_header_image_url'],
		'sanitize_callback' => 'esc_url_raw',
	) );

	$wp_customize->add_control( 'featured_header_image_url', array(
			'label'		=> __( 'Featured Header Image Link URL', 'chicago' ),
			'section'   => 'header_image',
	        'settings'  => 'featured_header_image_url',
	        'type'	  	=> 'text',
	) );

	$wp_customize->add_setting( 'featured_header_image_base', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_header_image_base'],
		'sanitize_callback' => 'chicago_sanitize_checkbox',
	) );

	$wp_customize->add_control( 'featured_header_image_base', array(
		'label'    	=> __( 'Check to Open Link in New Window/Tab', 'chicago' ),
		'section'  	=> 'header_image',
		'settings' 	=> 'featured_header_image_base',
		'type'     	=> 'checkbox',
	) );	
	// Header Options End