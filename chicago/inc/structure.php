<?php
/**
 * The template for Managing Theme Structure
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

if ( ! function_exists( 'chicago_doctype' ) ) :
	/**
	 * Doctype Declaration
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_doctype() {
		?>
		<!DOCTYPE html>
		<html <?php language_attributes(); ?>>
		<?php
	}
endif;
add_action( 'chicago_doctype', 'chicago_doctype', 10 );


if ( ! function_exists( 'chicago_head' ) ) :
	/**
	 * Header Codes
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_head() {
		?>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="profile" href="http://gmpg.org/xfn/11">
		<?php
		if ( is_singular() && pings_open() ) {
			echo '<link rel="pingback" href="', esc_url( get_bloginfo( 'pingback_url' ) ), '">';
		}
	}
endif;
add_action( 'chicago_before_wp_head', 'chicago_head', 10 );


if ( ! function_exists( 'chicago_page_start' ) ) :
	/**
	 * Start div id #page
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_page_start() {
		?>
		<div id="page" class="hfeed site">
		<a class="skip-link screen-reader-text" href="#content"><?php _e( 'Skip to content', 'chicago' ); ?></a>
		<?php
	}
endif;
add_action( 'chicago_before_header', 'chicago_page_start', 10 );

if ( ! function_exists( 'chicago_promotion_headline' ) ) :
	/**
	 * Template for Promotion Headline
	 *
	 * To override this in a child theme
	 * simply create your own chicago_promotion_headline(), and that function will be used instead.
	 *
	 * @since Chicago 0.1
	 */
	function chicago_promotion_headline() {
		global $post, $wp_query;
	   	$enable_promotion = get_theme_mod( 'promotion_headline_option', chicago_get_default_theme_options( 'promotion_headline_option' ) );

		// Front page displays in Reading Settings
		$page_for_posts = get_option('page_for_posts');

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		 if ( 'entire-site' == $enable_promotion || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' ==  $enable_promotion  ) ) {
			get_sidebar( 'promotion-headline' );
		}
	} // chicago_promotion_featured_content
endif;
add_action( 'chicago_before_header', 'chicago_promotion_headline', 20 );


if ( ! function_exists( 'chicago_header_start' ) ) :
	/**
	 * Start Header id #masthead
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_header_start() {
		echo "\n";
		?>
		<header id="masthead" class="site-header" role="banner">
		<?php
	}
endif;
add_action( 'chicago_header', 'chicago_header_start', 10 );


if ( ! function_exists( 'chicago_site_banner_start' ) ) :
	/**
	 * Start in header class .site-banner and class .wrapper
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_site_banner_start() {
		?>
		<div class="site-banner">
	    	<div class="wrapper">
		<?php
	}
endif;
add_action( 'chicago_header', 'chicago_site_banner_start', 20 );


if ( ! function_exists( 'chicago_site_branding_start' ) ) :
	/**
	 * Start in header class .site-branding
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_site_branding_start() {
		?>
		<div class="site-branding">
		<?php
	}
endif;
add_action( 'chicago_header', 'chicago_site_branding_start', 30 );

if ( ! function_exists( 'chicago_jetpack_logo' ) ) :
	/**
	 * Start in header jetpack logo
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_jetpack_logo() {
		if ( function_exists( 'jetpack_the_site_logo' ) ) {
			jetpack_the_site_logo();
		}
	}
endif;
add_action( 'chicago_header', 'chicago_jetpack_logo', 40 );


if ( ! function_exists( 'chicago_logo' ) ) :
	/**
	 * Get logo output and display
	 *
	 * @get logo output
	 * @since Chicago 0.1
	 *
	 */
	function chicago_logo() {
		echo chicago_get_logo();
	}
endif;
add_action( 'chicago_header', 'chicago_logo', 50 );


if ( ! function_exists( 'chicago_site_title_description' ) ) :
	/**
	 * Get logo output and display
	 *
	 * @get logo output
	 * @since Chicago 0.1
	 *
	 */
	function chicago_site_title_description() {
		if ( is_front_page() && is_home() ) : ?>
			<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
		<?php else : ?>
			<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
		<?php
		endif;

		$description = get_bloginfo( 'description', 'display' );
		if ( $description || is_customize_preview() ) : ?>
			<p class="site-description"><?php echo $description; /* WPCS: xss ok. */ ?></p>
		<?php
		endif;
	}
endif;
add_action( 'chicago_header', 'chicago_site_title_description', 60 );


if ( ! function_exists( 'chicago_site_branding_end' ) ) :
	/**
	 * End in header class .site-branding
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_site_branding_end() {
		?>
		</div><!-- .site-branding -->
		<?php
	}
endif;
add_action( 'chicago_header', 'chicago_site_branding_end', 70 );


if ( ! function_exists( 'chicago_header_right' ) ) :
	/**
	 * Header Right Sidebar
	 *
	 * @since Chicago 0.1
	 */
	function chicago_header_right() {
		//A sidebar in the Header Right
		if ( is_active_sidebar( 'header-right' ) ) {
			get_sidebar( 'header-right' );
		}
	}
endif;
add_action( 'chicago_header', 'chicago_header_right', 80 );


if ( ! function_exists( 'chicago_site_banner_end' ) ) :
	/**
	 * Start in header class .site-banner and class .wrapper
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_site_banner_end() {
		?>
			</div><!-- .wrapper -->
		</div><!-- .site-banner -->
		<?php
	}
endif;
add_action( 'chicago_header', 'chicago_site_banner_end', 90 );


if ( ! function_exists( 'chicago_social_menu' ) ) :
	/**
	 * Start in header social menu
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_social_menu() {
		if ( has_nav_menu( 'social' ) ) { ?>
            <div class="social-menu">
		        <?php wp_nav_menu( array(
				    'theme_location'	=> 'social',
				    'container_class' 	=> 'wrapper',
				    'depth'				=> '1',
				    'link_before'		=> '<span class="screen-reader-text">',
				    'link_after'		=> '</span>' )
				    );
                ?>
            </div><!-- .social-menu -->
        <?php
    	}
	}
endif;
add_action( 'chicago_header', 'chicago_social_menu', 100 );


if ( ! function_exists( 'chicago_primary_menu' ) ) :
	/**
	 * Start in header primary menu
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_primary_menu() {
		?>
    	<nav id="site-navigation" class="main-navigation nav-primary" role="navigation">
    		<div class="wrapper">
	    		<button class="menu-toggle" aria-controls="primary-menu" aria-expanded="false"><?php _e( 'Menu', 'chicago' ); ?></button>
	           	<a class="screen-reader-text skip-link" href="#content"><?php _e( 'Skip to content', 'chicago' ); ?></a>

	           	<?php
                if ( has_nav_menu( 'primary' ) ) {
                    $chicago_primary_menu_args = array(
                        'theme_location'    => 'primary',
                        'menu_class'        => 'menu chicago-nav-menu',
                        'menu_id' 			=> 'primary-menu',
                        'container'         => false
                    );
                    wp_nav_menu( $chicago_primary_menu_args );
                }
                else {
                    wp_page_menu( array( 'menu_class'  => 'menu page-menu-wrap' ) );
                }
                ?>
          	</div><!-- .wrapper -->
        </nav><!-- #site-navigation -->
	    <?php
	}
endif;
add_action( 'chicago_header', 'chicago_primary_menu', 110 );


if ( ! function_exists( 'chicago_header_end' ) ) :
	/**
	 * End in header class .site-banner and class .wrapper
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_header_end() {
		?>
		</header><!-- #masthead -->
		<?php
	}
endif;
add_action( 'chicago_header', 'chicago_header_end', 200 );


if ( ! function_exists( 'chicago_content_start' ) ) :
	/**
	 * Start div id #content and class .wrapper
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_content_start() {
		?>
		<div id="content" class="site-content">
	<?php
	}
endif;
add_action('chicago_content', 'chicago_content_start', 10 );


if ( ! function_exists( 'chicago_content_end' ) ) :
	/**
	 * End div id #content and class .wrapper
	 *
	 * @since Chicago 0.1
	 */
	function chicago_content_end() {
		?>
	    </div><!-- #content -->
		<?php
	}
endif;
add_action( 'chicago_after_content', 'chicago_content_end', 10 );


if ( ! function_exists( 'chicago_footer_content_start' ) ) :
	/**
	 * Start footer id #colophon
	 *
	 * @since Chicago 0.1
	 */
	function chicago_footer_content_start() {
		?>
		<footer id="colophon" class="site-footer" role="contentinfo">
	    <?php
	}
endif;
add_action('chicago_footer', 'chicago_footer_content_start', 10 );


if ( ! function_exists( 'chicago_footer_sidebar' ) ) :
	/**
	 * Footer Sidebar
	 *
	 * @since Chicago 0.1
	 */
	function chicago_footer_sidebar() {
		get_sidebar( 'footer' );
	}
	endif;
add_action( 'chicago_footer', 'chicago_footer_sidebar', 20 );


if ( ! function_exists( 'chicago_footer_info' ) ) :
	/**
	 * Footer Information
	 *
	 * @since Chicago 0.1
	 */
	function chicago_footer_info() { ?>
		<div class="site-info">
			<?php
				if ( ( !$chicago_footer_info = get_transient( 'chicago_footer_info' ) ) ) {
					$chicago_footer_info = wp_kses_post( chicago_copyright() );

					$chicago_footer_info .= chicago_seperator();

					$chicago_footer_info .= wp_kses_post( chicago_profile() );

					set_transient( 'chicago_footer_info', $chicago_footer_info, 86940 );
				}
				echo $chicago_footer_info;
			?>
		</div><!-- .site-info -->

	<?php
	}
endif;
add_action( 'chicago_footer', 'chicago_footer_info', 30 );

if ( ! function_exists( 'chicago_footer_content_end' ) ) :
	/**
	 * End footer id #colophon
	 *
	 * @since Chicago 0.1
	 */
	function chicago_footer_content_end() {
		?>
		</footer><!-- #colophon -->
		<?php
	}
	endif;
add_action( 'chicago_footer', 'chicago_footer_content_end', 190 );

if ( ! function_exists( 'chicago_page_end' ) ) :
	/**
	 * End div id #page
	 *
	 * @since Chicago 0.1
	 *
	 */
	function chicago_page_end() {
		?>
		</div><!-- #page -->
		<?php
	}
endif;
add_action( 'chicago_footer', 'chicago_page_end', 200 );
