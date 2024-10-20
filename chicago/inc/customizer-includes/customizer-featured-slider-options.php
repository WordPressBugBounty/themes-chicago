<?php
/**
 * The template for adding Featured Slider Options in Customizer
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */
	// Featured Slider
	$wp_customize->add_panel( 'chicago_featured_slider', array(
	    'capability'     => 'edit_theme_options',
	    'description'    => __( 'Featured Slider', 'chicago' ),
	    'priority'       => 500,
		'title'    		 => __( 'Featured Slider', 'chicago' ),
	) );

	$wp_customize->add_section( 'chicago_featured_slider', array(
		'panel'			=> 'chicago_featured_slider',
		'priority'		=> 1,
		'title'			=> __( 'Featured Slider Options', 'chicago' ),
	) );

	$wp_customize->add_setting( 'featured_slider_option', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_option'],
		'sanitize_callback' => 'chicago_sanitize_select',
	) );

	$wp_customize->add_control( 'featured_slider_option', array(
		'choices'   => chicago_featured_slider_options(),
		'label'    	=> __( 'Enable Slider on', 'chicago' ),
		'priority'	=> '1.1',
		'section'  	=> 'chicago_featured_slider',
		'settings' 	=> 'featured_slider_option',
		'type'    	=> 'select',
	) );

	$wp_customize->add_setting( 'featured_slide_transition_effect', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_transition_effect'],
		'sanitize_callback'	=> 'chicago_sanitize_select',
	) );

	$wp_customize->add_control( 'featured_slide_transition_effect' , array(
		'active_callback'	=> 'chicago_is_slider_active',
		'choices'  			=> chicago_featured_slide_transition_effects(),
		'label'				=> __( 'Transition Effect', 'chicago' ),
		'priority'			=> '2',
		'section'  			=> 'chicago_featured_slider',
		'settings' 			=> 'featured_slide_transition_effect',
		'type'	  			=> 'select',
		)
	);

	$wp_customize->add_setting( 'featured_slide_transition_delay', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_transition_delay'],
		'sanitize_callback'	=> 'absint',
	) );

	$wp_customize->add_control( 'featured_slide_transition_delay' , array(
		'active_callback'	=> 'chicago_is_slider_active',
		'description'		=> __( 'seconds(s)', 'chicago' ),
		'input_attrs' 		=> array(
        							'style' => 'width: 40px;'
    							),
    	'label'    			=> __( 'Transition Delay', 'chicago' ),
		'priority'			=> '2.1.1',
		'section'  			=> 'chicago_featured_slider',
		'settings' 			=> 'featured_slide_transition_delay',
		)
	);

	$wp_customize->add_setting( 'featured_slide_transition_length', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_transition_length'],
		'sanitize_callback'	=> 'absint',
	) );

	$wp_customize->add_control( 'featured_slide_transition_length' , array(
		'active_callback'	=> 'chicago_is_slider_active',
		'description'		=> __( 'seconds(s)', 'chicago' ),
		'input_attrs' 		=> array(
					        	'style' => 'width: 40px;'
					    		),
    	'label'    			=> __( 'Transition Length', 'chicago' ),
		'priority'			=> '2.1.2',
		'section'  			=> 'chicago_featured_slider',
		'settings' 			=> 'featured_slide_transition_length',
		)
	);

	$wp_customize->add_setting( 'featured_slider_image_loader', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_image_loader'],
		'sanitize_callback' => 'chicago_sanitize_select',
	) );

	$wp_customize->add_control( 'featured_slider_image_loader', array(
		'active_callback'	=> 'chicago_is_slider_active',
		'choices'   		=> chicago_featured_slider_image_loader(),
		'label'    			=> __( 'Image Loader', 'chicago' ),
		'priority'			=> '2.1.3',
		'section'  			=> 'chicago_featured_slider',
		'settings' 			=> 'featured_slider_image_loader',
		'type'    			=> 'select',
	) );

	$wp_customize->add_setting( 'featured_slider_type', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slider_type'],
		'sanitize_callback'	=> 'chicago_sanitize_select',
	) );

	$wp_customize->add_control( 'featured_slider_type', array(
		'active_callback'	=> 'chicago_is_slider_active',
		'choices'  			=> chicago_featured_slider_types(),
		'label'    			=> __( 'Select Slider Type', 'chicago' ),
		'priority'			=> '2.1.3',
		'section'  			=> 'chicago_featured_slider',
		'settings' 			=> 'featured_slider_type',
		'type'	  			=> 'select',
	) );

	$wp_customize->add_setting( 'featured_slide_number', array(
		'capability'		=> 'edit_theme_options',
		'default'			=> $defaults['featured_slide_number'],
		'sanitize_callback'	=> 'chicago_sanitize_number_range',
	) );

	$wp_customize->add_control( 'featured_slide_number' , array(
		'active_callback'	=> 'chicago_is_demo_slider_inactive',
		'description'		=> __( 'Save and refresh the page if No. of Slides is changed (Max no of slides is 20)', 'chicago' ),
		'input_attrs' 		=> array(
					            'style' => 'width: 45px;',
					            'min'   => 0,
					            'max'   => 20,
					            'step'  => 1,
					        	),
		'label'    			=> __( 'No of Slides', 'chicago' ),
		'priority'			=> '2.1.4',
		'section'  			=> 'chicago_featured_slider',
		'settings' 			=> 'featured_slide_number',
		'type'	   			=> 'number',
		)
	);

	//Get featured slides humber from theme options
	$featured_slide_number	= get_theme_mod( 'featured_slide_number', chicago_get_default_theme_options( 'featured_slide_number' ) );

	//loop for featured page sliders
	for ( $i=1; $i <= $featured_slide_number ; $i++ ) {
		$wp_customize->add_setting( 'featured_slider_page_'. $i, array(
			'capability'		=> 'edit_theme_options',
			'sanitize_callback'	=> 'chicago_sanitize_page',
		) );

		$wp_customize->add_control( 'featured_slider_page_'. $i, array(
			'active_callback'	=> 'chicago_is_demo_slider_inactive',
			'label'    			=> __( 'Featured Page', 'chicago' ) . ' # ' . $i ,
			'priority'			=> '4' . $i,
			'section'  			=> 'chicago_featured_slider',
			'settings' 			=> 'featured_slider_page_'. $i,
			'type'	   			=> 'dropdown-pages',
		) );
	}
// Featured Slider End