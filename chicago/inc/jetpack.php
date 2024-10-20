<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

function chicago_jetpack_setup() {
	/**
     * Setup Infinite Scroll using JetPack if navigation type is set
     */
    $pagination_type    = get_theme_mod( 'pagination_type', chicago_get_default_theme_options( 'pagination_type' ) );


    if ( 'infinite-scroll-click' == $pagination_type ) {
        add_theme_support( 'infinite-scroll', array(
            'type'      => 'click',
            'container' => 'main',
            'footer'    => 'page'
        ) );
    }
    elseif ( 'infinite-scroll-scroll' == $pagination_type ) {
        //Override infinite scroll disable scroll option
        update_option('infinite_scroll', true);

        add_theme_support( 'infinite-scroll', array(
            'type'      => 'scroll',
            'container' => 'main',
            'footer'    => 'page'
        ) );
    }

    //Check for JetPack logo, if it already has value, support JetPack logo, else don't support it
    $jetpack_logo  = get_option( 'site_logo' );

    if ( !empty( $jetpack_logo['id'] ) ){
        add_theme_support( 'site-logo', array( 'size' => 'chicago-site-logo' ) );
    }

    /**
     * Add theme support for responsive videos.
     */
    add_theme_support( 'jetpack-responsive-videos' );
}
add_action( 'after_setup_theme', 'chicago_jetpack_setup' );