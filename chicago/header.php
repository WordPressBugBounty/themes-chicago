<?php
/**
 * The header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="content">
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

	/** 
	 * chicago_doctype hook
	 *
	 * @hooked chicago_doctype -  10
	 * 
	 */
	do_action( 'chicago_doctype' );
	?>

<head>
<?php	
	/** 
	 * chicago_before_wp_head hook
	 *
	 * @hooked chicago_head -  10
	 * 
	 */
	do_action( 'chicago_before_wp_head' );

	wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<?php do_action( 'wp_body_open' );  ?>

	<?php 
	/** 
	 * chicago_before_header hook
	 *
	 * @hooked chicago_page_start -  10
	 * @hooked chicago_promotion_headline -  20
	 * 
	 */
	do_action( 'chicago_before_header' );
	

	/** 
	 * chicago_header hook
	 *
	 * @hooked chicago_header_start -  10
	 * @hooked chicago_site_banner_start -  20
	 * @hooked chicago_site_branding_start -  30
	 * @hooked chicago_jetpack_logo -  40
	 * @hooked chicago_logo -  50
	 * @hooked chicago_site_title_description -  60
	 * @hooked chicago_site_branding_end -  70
	 * @hooked chicago_header_right -  80
	 * @hooked chicago_site_banner_end -  90
	 * @hooked chicago_social_menu -  100
	 * @hooked chicago_primary_menu -  110
	 * @hooked chicago_header_end -  200
	 * 
	 */
	do_action( 'chicago_header' );
	

	/** 
	 * chicago_after_header hook
	 *
	 * @hooked chicago_add_breadcrumb - 10
	 * @hooked chicago_featured_content_displaychicago_featured_content_display - 20
	 * @hooked chicago_featured_slider -  30
	 * @hooked chicago_featured_image_display - 40
	 * 
	 */
	do_action( 'chicago_after_header' );

	/** 
	 * chicago_content hook
	 *
	 * @hooked chicago_add_breadcrumb - 10
	 * @hooked chicago_featured_content_displaychicago_featured_content_display - 20
	 * @hooked chicago_featured_slider -  30
	 * @hooked chicago_featured_image_display - 40
	 * 
	 */
	do_action( 'chicago_content' );