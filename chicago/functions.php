<?php
/**
 * Chicago functions and definitions
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

if ( ! function_exists( 'chicago_content_width' ) ) :
	/**
	 * Set the content width in pixels, based on the theme's design and stylesheet.
	 *
	 * Priority 0 to make it available to lower priority callbacks.
	 *
	 * @global int $content_width
	 */
	function chicago_content_width() {
		$GLOBALS['content_width'] = apply_filters( 'chicago_content_width', 690 );
	}
endif;
add_action( 'after_setup_theme', 'chicago_content_width', 0 );

if ( ! function_exists( 'chicago_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function chicago_setup() {

	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Chicago, use a find and replace
	 * to change 'chicago' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'chicago', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	// Add tyles the visual editor to resemble the theme style.
	add_editor_style( array( 'css/editor-style.css' ) );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	//@remove Remove check when WordPress 4.8 is released
	if ( function_exists( 'has_custom_logo' ) ) {
		/**
		* Setup Custom Logo Support for theme
		* Supported from WordPress version 4.5 onwards
		* More Info: https://make.wordpress.org/core/2016/03/10/custom-logo/
		*/
		add_theme_support( 'custom-logo' );
	}

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// Set default size.
	set_post_thumbnail_size( 300, 169, true ); // used in Archive Landecape Ratio 16:9

	// Add default size for single pages.
	add_image_size( 'chicago-single', '690', '388', true ); // used in Archive Landecape Ratio 16:9

	// Add default size for sliders.
	add_image_size( 'chicago-slider', '1680', '720', true ); // used in Featured Slider Ratio 21:9

	// Add default size for Jetpack logo.
	add_image_size( 'chicago-site-logo', '300', '150', false );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' 		=> __( 'Primary Menu', 'chicago' ),
		'social'  		=> __( 'Social Menu', 'chicago' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form', 'comment-form', 'comment-list', 'gallery', 'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside', 'image', 'video', 'quote', 'link',
	) );

	// Set up the WordPress core custom background feature.
	//Get color Scheme
	$color_scheme = get_theme_mod( 'color_scheme', chicago_get_default_theme_options( 'color_scheme' ) );

	if ( 'light' == $color_scheme ) {
		$default_color = chicago_default_color_options('light');
		$default_color = $default_color['background_color'];
	}
	elseif ( 'dark' == $color_scheme ) {
		$default_color = chicago_default_color_options('dark');
		$default_color = $default_color['background_color'];
	}
	else {
		$default_color = chicago_get_default_theme_options( 'background_color' );
	}

	add_theme_support( 'custom-background', apply_filters( 'chicago_custom_background_args', array(
		'default-color' => $default_color
	) ) );

	// Add support for Block Styles.
	add_theme_support( 'wp-block-styles' );

	// Add support for editor styles.
	add_theme_support( 'editor-styles' );

	// Add support for full and wide align images.
	add_theme_support( 'align-wide' );

	// Add support for responsive embeds.
	add_theme_support( 'responsive-embeds' );

	// Add custom editor font sizes.
	add_theme_support(
		'editor-font-sizes',
		array(
			array(
				'name'      => esc_html__( 'Small', 'chicago' ),
				'shortName' => esc_html__( 'S', 'chicago' ),
				'size'      => 13,
				'slug'      => 'small',
			),
			array(
				'name'      => esc_html__( 'Normal', 'chicago' ),
				'shortName' => esc_html__( 'M', 'chicago' ),
				'size'      => 16,
				'slug'      => 'normal',
			),
			array(
				'name'      => esc_html__( 'Large', 'chicago' ),
				'shortName' => esc_html__( 'L', 'chicago' ),
				'size'      => 42,
				'slug'      => 'large',
			),
			array(
				'name'      => esc_html__( 'Huge', 'chicago' ),
				'shortName' => esc_html__( 'XL', 'chicago' ),
				'size'      => 56,
				'slug'      => 'huge',
			),
		)
	);

	// Add support for custom color scheme.
	add_theme_support( 'editor-color-palette', array(
		array(
			'name'  => esc_html__( 'White', 'chicago' ),
			'slug'  => 'white',
			'color' => '#ffffff',
		),
		array(
			'name'  => esc_html__( 'Black', 'chicago' ),
			'slug'  => 'black',
			'color' => '#111111',
		),
		array(
			'name'  => esc_html__( 'Gray', 'chicago' ),
			'slug'  => 'gray',
			'color' => '#f4f4f4',
		),
		array(
			'name'  => esc_html__( 'Yellow', 'chicago' ),
			'slug'  => 'yellow',
			'color' => '#e5ae4a',
		),
		array(
			'name'  => esc_html__( 'Blue', 'chicago' ),
			'slug'  => 'blue',
			'color' => '#1b8be0',
		),
		array(
			'name'  => esc_html__( 'Pink', 'chicago' ),
			'slug'  => 'pink',
			'color' => '#f2157d',
		),
	) );
}
endif; // chicago_setup
add_action( 'after_setup_theme', 'chicago_setup' );

/**
 * Enqueue scripts and styles.
 */
function chicago_scripts() {

	wp_enqueue_style( 'chicago-style', get_stylesheet_uri(), null, date( 'Ymd-Gis', filemtime( get_template_directory() . '/style.css' ) ) );

	// Theme block stylesheet.
	wp_enqueue_style( 'chicago-block-style', get_theme_file_uri( 'css/blocks.css' ), array( 'chicago-style' ), filemtime( get_template_directory() . '/css/blocks.css' ) );

	wp_enqueue_style( 'genericons', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/genericons/genericons.css', false, '3.3' );

	/**
	 * Enqueue the styles for the current color scheme for Chicago.
	 */
	$color_scheme = get_theme_mod( 'color_scheme', chicago_get_default_theme_options( 'color_scheme' ) );

	if ( 'pink' != $color_scheme ) {
		wp_enqueue_style( 'chicago-'. $color_scheme, trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'css/colors/'. $color_scheme .'.css', array(), null );
	}

	wp_enqueue_script( 'chicago-custom-scripts', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/custom-scripts.js', array( 'jquery' ), '1.0.0', true );

	wp_enqueue_script( 'chicago-navigation', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/navigation.js', array(), '1.0.0', true );

	wp_enqueue_script( 'chicago-skip-link-focus-fix', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/skip-link-focus-fix.js', array(), '1.0.0', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}

	/**
	 * Loads up Cycle JS
	 */
	$featured_slider_option = get_theme_mod( 'featured_slider_option', chicago_get_default_theme_options( 'featured_slider_option' ) );

	if ( 'disabled' != $featured_slider_option  ) {
		wp_register_script( 'jquery-cycle2', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/jquery.cycle/jquery.cycle2.min.js', array( 'jquery' ), '2.1.5', true );

		/**
		 * Condition checks for additional slider transition plugins
		 */
		$featured_slide_transition_effect = get_theme_mod( 'featured_slide_transition_effect', chicago_get_default_theme_options( 'featured_slide_transition_effect' ) );

		// Scroll Vertical transition plugin addition
		if ( 'scrollVert' ==  $featured_slide_transition_effect ){
			wp_enqueue_script( 'jquery-cycle2-scrollVert', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/jquery.cycle/jquery.cycle2.scrollVert.min.js', array( 'jquery-cycle2' ), '20140128', true );
		}
		// Flip transition plugin addition
		elseif ( 'flipHorz' ==  $featured_slide_transition_effect || 'flipVert' ==  $featured_slide_transition_effect ){
			wp_enqueue_script( 'jquery-cycle2-flip', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/jquery.cycle/jquery.cycle2.flip.min.js', array( 'jquery-cycle2' ), '20140128', true );
		}
		// tile transition plugin addition
		elseif ( 'tileSlide' ==  $featured_slide_transition_effect || 'tileBlind' ==  $featured_slide_transition_effect ){
			wp_enqueue_script( 'jquery-cycle2-tile', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/jquery.cycle/jquery.cycle2.tile.min.js', array( 'jquery-cycle2' ), '20140128', true );
		}
		else {
			wp_enqueue_script( 'jquery-cycle2' );
		}
	}

	/**
	 * Loads up Scroll Up script
	 */
	$disable_scrollup = get_theme_mod( 'disable_scrollup', chicago_get_default_theme_options( 'disable_scrollup' ) );

	if ( '1' != $disable_scrollup ) {
		wp_enqueue_script( 'chicago-scrollup', trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'js/scrollup.js', array( 'jquery' ), '20141223	', true  );
	}
}
add_action( 'wp_enqueue_scripts', 'chicago_scripts' );

/**
 * Enqueue editor styles for Gutenberg
 */
function chicago_block_editor_styles() {
	// Block styles.
	wp_enqueue_style( 'chicago-block-editor-style', get_theme_file_uri( 'css/editor-blocks.css' ) );
}
add_action( 'enqueue_block_editor_assets', 'chicago_block_editor_styles' );

/**
 * Enqueue scripts and styles for Metaboxes
 * @uses wp_register_script, wp_enqueue_script, and  wp_enqueue_style
 *
 * @action admin_print_scripts-post-new, admin_print_scripts-post, admin_print_scripts-page-new, admin_print_scripts-page
 *
 * @since Chicago 0.1
 */
/**
 * Include Default Options for Chicago
 */
require trailingslashit( get_template_directory() ) . 'inc/default-options.php';

/**
 * Implement the Custom Header feature.
 */
require trailingslashit( get_template_directory() ) . 'inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require trailingslashit( get_template_directory() ) . 'inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require trailingslashit( get_template_directory() ) . 'inc/extras.php';

/**
 * Customizer additions.
 */
require trailingslashit( get_template_directory() ) . 'inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require trailingslashit( get_template_directory() ) . 'inc/jetpack.php';

/**
 * Include metabox options
 */
require trailingslashit( get_template_directory() ) . 'inc/metabox.php';

/**
 * Include Structure for Chicago
 */
require trailingslashit( get_template_directory() ) . 'inc/structure.php';

/**
 * Include featured slider
 */
require trailingslashit( get_template_directory() ) . 'inc/breadcrumb.php';

/**
 * Include featured content
 */
require trailingslashit( get_template_directory() ) . 'inc/featured-content.php';

/**
 * Include featured slider
 */
require trailingslashit( get_template_directory() ) . 'inc/featured-slider.php';

/**
 * Include Widgets and Sidebars
 */
require trailingslashit( get_template_directory() ) . 'inc/widgets.php';

/**
 * Migrate Logo to New WordPress core Custom Logo
 *
 *
 * Runs if version number saved in theme_mod "logo_version" doesn't match current theme version.
 */
function chicago_logo_migrate() {
	$ver = get_theme_mod( 'logo_version', false );

	// Return if update has already been run
	if ( version_compare( $ver, '1.2.4' ) >= 0 ) {
		return;
	}

	// If a logo has been set previously, update to use logo feature introduced in WordPress 4.5
	if ( function_exists( 'the_custom_logo' ) ) {
		/**
		 * Get Logo from Theme Mod
		 */
		$logo = get_theme_mod( 'logo', chicago_get_default_theme_options( 'logo' ) );
		if ( '' != $logo ) {
			// Since previous logo was stored a URL, convert it to an attachment ID
			$logo = attachment_url_to_postid( $logo );

			if ( is_int( $logo ) ) {
				set_theme_mod( 'custom_logo', $logo );
			}
		}

  		// Update to match logo_version so that script is not executed continously
		set_theme_mod( 'logo_version', '1.2.4' );
	}

}
add_action( 'after_setup_theme', 'chicago_logo_migrate' );


/**
 * Migrate Custom CSS to WordPress core Custom CSS
 *
 * Runs if version number saved in theme_mod "custom_css_version" doesn't match current theme version.
 */
function chicago_custom_css_migrate(){
	$ver = get_theme_mod( 'custom_css_version', false );

	// Return if update has already been run
	if ( version_compare( $ver, '4.7' ) >= 0 ) {
		return;
	}

	if ( function_exists( 'wp_update_custom_css_post' ) ) {
	    // Migrate any existing theme CSS to the core option added in WordPress 4.7.

	    /**
		 * Get Theme Options Values
		 */
	    $custom_css = get_theme_mod( 'custom_css' );

	    if ( $custom_css ) {
			$core_css = wp_get_custom_css(); // Preserve any CSS already added to the core option.
			$return   = wp_update_custom_css_post( $core_css . $custom_css );
	        if ( ! is_wp_error( $return ) ) {
	            // Remove the old theme_mod, so that the CSS is stored in only one place moving forward.
	            remove_theme_mod( 'custom_css' );

	            // Update to match custom_css_version so that script is not executed continously
				set_theme_mod( 'custom_css_version', '4.7' );
	        }
	    }
	}
}
add_action( 'after_setup_theme', 'chicago_custom_css_migrate' );
