<?php
/**
 * The template for adding Featured Content Settings in Customizer
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */
	// Featured Content Options
	$wp_customize->add_panel( 'chicago_featured_content_options', array(
	    'capability'     => 'edit_theme_options',
		'description'    => __( 'Options for Featured Content', 'chicago' ),
	    'priority'       => 400,
	    'title'    		 => __( 'Featured Content', 'chicago' ),
	) );


	$wp_customize->add_section( 'chicago_featured_content_options', array(
		'panel'			=> 'chicago_featured_content_options',
		'priority'		=> 1,
		'title'			=> __( 'Featured Content Options', 'chicago' ),
	) );

	$wp_customize->add_setting( 'featured_content_option', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_option'],
		'sanitize_callback' => 'chicago_sanitize_select',
	) );

	$wp_customize->add_control( 'featured_content_option', array(
		'choices'  	=> chicago_featured_slider_options(),
		'label'    	=> __( 'Enable Featured Content on', 'chicago' ),
		'priority'	=> '1',
		'section'  	=> 'chicago_featured_content_options',
		'settings' 	=> 'featured_content_option',
		'type'	  	=> 'select',
	) );

	$wp_customize->add_setting( 'featured_content_layout', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_layout'],
		'sanitize_callback' => 'chicago_sanitize_select',
	) );

	$wp_customize->add_control( 'featured_content_layout', array(
		'active_callback'	=> 'chicago_is_featured_content_active',
		'choices'  			=> chicago_featured_content_layout_options(),
		'label'    			=> __( 'Select Featured Content Layout', 'chicago' ),
		'priority'			=> '2',
		'section'  			=> 'chicago_featured_content_options',
		'settings' 			=> 'featured_content_layout',
		'type'	  			=> 'select',
	) );

	$wp_customize->add_setting( 'featured_content_position', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_position'],
		'sanitize_callback' => 'chicago_sanitize_checkbox'
	) );

	$wp_customize->add_control( 'featured_content_position', array(
		'active_callback'	=> 'chicago_is_featured_content_active',
		'label'				=> __( 'Check to Move above Footer', 'chicago' ),
		'priority'			=> '3',
		'section'  			=> 'chicago_featured_content_options',
		'settings'			=> 'featured_content_position',
		'type'				=> 'checkbox',
	) );

	$wp_customize->add_setting( 'featured_content_type', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_type'],
		'sanitize_callback'	=> 'chicago_sanitize_select',
	) );

	$wp_customize->add_control( 'featured_content_type', array(
		'active_callback'	=> 'chicago_is_featured_content_active',
		'choices'  			=> chicago_featured_content_types(),
		'label'    			=> __( 'Select Content Type', 'chicago' ),
		'priority'			=> '3',
		'section'  			=> 'chicago_featured_content_options',
		'settings' 			=> 'featured_content_type',
		'type'	  			=> 'select',
	) );

	$wp_customize->add_setting( 'featured_content_headline', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_headline'],
		'sanitize_callback'	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( 'featured_content_headline' , array(
		'active_callback'	=> 'chicago_is_featured_content_active',
		'description'		=> __( 'Leave field empty if you want to remove Headline', 'chicago' ),
		'label'    			=> __( 'Headline for Featured Content', 'chicago' ),
		'priority'			=> '4',
		'section'  			=> 'chicago_featured_content_options',
		'settings' 			=> 'featured_content_headline',
		'type'	   			=> 'text',
		)
	);

	$wp_customize->add_setting( 'featured_content_subheadline', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_subheadline'],
		'sanitize_callback'	=> 'wp_kses_post',
	) );

	$wp_customize->add_control( 'featured_content_subheadline' , array(
		'active_callback'	=> 'chicago_is_featured_content_active',
		'description'		=> __( 'Leave field empty if you want to remove Sub-headline', 'chicago' ),
		'label'    			=> __( 'Sub-headline for Featured Content', 'chicago' ),
		'priority'			=> '5',
		'section'  			=> 'chicago_featured_content_options',
		'settings' 			=> 'featured_content_subheadline',
		'type'	   			=> 'text',
		) 
	);

	$wp_customize->add_setting( 'featured_content_number', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_number'],
		'sanitize_callback'	=> 'chicago_sanitize_number_range',
	) );

	$wp_customize->add_control( 'featured_content_number' , array(
		'active_callback'	=> 'chicago_is_demo_featured_content_inactive',
		'description'		=> __( 'Save and refresh the page if No. of Featured Content is changed (Max no of Featured Content is 20)', 'chicago' ),
		'input_attrs' 		=> array(
					            'style' => 'width: 45px;',
					            'min'   => 0,
					            'max'   => 20,
					            'step'  => 1,
        						),
		'label'    			=> __( 'No of Featured Content', 'chicago' ),
		'priority'			=> '6',
		'section'  			=> 'chicago_featured_content_options',
		'settings' 			=> 'featured_content_number',
		'type'	   			=> 'number',
		) 
	);

	$wp_customize->add_setting( 'featured_content_show', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_content_show'],
		'sanitize_callback'	=> 'chicago_sanitize_select',
	) ); 

	$wp_customize->add_control( 'featured_content_show', array(
		'active_callback'	=> 'chicago_is_demo_featured_content_inactive',
		'choices'  			=> chicago_featured_content_show(),
		'label'    			=> __( 'Display Content', 'chicago' ),
		'priority'			=> '6.1',
		'section'  			=> 'chicago_featured_content_options',
		'settings' 			=> 'featured_content_show',
		'type'	  			=> 'select',
	) );
	

	//Get featured slides humber from theme options
	$featured_content_number	= get_theme_mod( 'featured_content_number', chicago_get_default_theme_options( 'featured_content_number' ) );

	//loop for featured page sliders
	for ( $i=1; $i <= $featured_content_number ; $i++ ) {
		$wp_customize->add_setting( 'featured_content_page_'. $i, array(
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'chicago_sanitize_page',
		) );

		$wp_customize->add_control( 'featured_content_page_'. $i, array(
			'active_callback'	=> 'chicago_is_demo_featured_content_inactive',
			'label'    			=> __( 'Featured Page', 'chicago' ) . ' ' . $i,
			'priority'			=> '5' . $i,
			'section'  			=> 'chicago_featured_content_options',
			'settings' 			=> 'featured_content_page_'. $i,
			'type'	   			=> 'dropdown-pages',
		) );
	}	
// Featured Content Setting End