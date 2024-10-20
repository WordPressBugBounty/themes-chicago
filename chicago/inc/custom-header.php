<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

/**
 * Set up the WordPress core custom header feature.
 *
 * @uses chicago_header_style()
 * @uses chicago_admin_header_style()
 * @uses chicago_admin_header_image()
 */
function chicago_custom_header_setup() {
	//Get color Scheme
	$color_scheme = get_theme_mod( 'color_scheme', chicago_get_default_theme_options( 'color_scheme' ) );

	if ( 'light' == $color_scheme ) {
		$default_color = chicago_default_color_options('light');
		$default_color = $default_color['header_textcolor'];
	}
	elseif ( 'dark' == $color_scheme ) {
		$default_color = chicago_default_color_options('dark');
		$default_color = $default_color['header_textcolor'];
	}
	else {
		$default_color = chicago_get_default_theme_options( 'header_textcolor' );
	}

	add_theme_support( 'custom-header', apply_filters( 'chicago_custom_header_args', array(
	    'default-image'          => '%s/images/default-image.jpg',
		'default-text-color'     => $default_color,
		'width'                  => 1920,
		'height'                 => 500,
		'flex-height'            => true,
		'wp-head-callback'       => 'chicago_header_style',
		'admin-head-callback'    => 'chicago_admin_header_style',
		'admin-preview-callback' => 'chicago_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'chicago_custom_header_setup' );

if ( ! function_exists( 'chicago_header_style' ) ) :
/**
 * Styles the header image and text displayed on the blog
 *
 * @see chicago_custom_header_setup().
 */
function chicago_header_style() {
	$header_text_color = get_header_textcolor();

	// If no custom options for text are set, let's bail
	// get_header_textcolor() options: get_theme_support( 'custom-header', 'default-text-color' ) is default, hide text (returns 'blank') or any hex value
	if ( get_theme_support( 'custom-header', 'default-text-color' ) === $header_text_color ) {
		return;
	}

	// If we get this far, we have custom styles. Let's do this.
	?>
	<style type="text/css">
	<?php
		// Has the text been hidden?
		if ( 'blank' == $header_text_color ) :
	?>
		.site-title,
		.site-description {
			position: absolute;
			clip: rect(1px, 1px, 1px, 1px);
		}
	<?php
		// If the user has set a custom color for the text use that
		else :
	?>
		.site-title a,
		.site-description {
			color: #<?php echo esc_attr( $header_text_color ); ?>;
		}
	<?php endif; ?>
	</style>
	<?php
}
endif; // chicago_header_style

if ( ! function_exists( 'chicago_admin_header_style' ) ) :
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see chicago_custom_header_setup().
 */
function chicago_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			border: none;
		}
		#headimg h1,
		#desc {
		}
		#headimg h1 {
		}
		#headimg h1 a {
		}
		#desc {
		}
		#headimg img {
		}
	</style>
<?php
}
endif; // chicago_admin_header_style

if ( ! function_exists( 'chicago_admin_header_image' ) ) :
/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see chicago_custom_header_setup().
 */
function chicago_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
?>
	<div id="headimg">
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
		<div class="displaying-header-text" id="desc"<?php echo $style; ?>><?php bloginfo( 'description' ); ?></div>
		<?php if ( get_header_image() ) : ?>
		<img src="<?php header_image(); ?>" alt="">
		<?php endif; ?>
	</div>
<?php
}
endif; // chicago_admin_header_image

if ( ! function_exists( 'chicago_featured_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own chicago_featured_image(), and that function will be used instead.
	 *
	 * @since Chicago 0.1
	 */
	function chicago_featured_image() {
		$header_image 			= get_header_image();

		$options['featured_header_image_url'] = get_theme_mod( 'featured_header_image_url', chicago_get_default_theme_options( 'featured_header_image_url' ) );

		$options['featured_header_image_base'] = get_theme_mod( 'featured_header_image_base', chicago_get_default_theme_options( 'featured_header_image_base' ) );

		$options['featured_header_image_alt'] = get_theme_mod( 'featured_header_image_alt', chicago_get_default_theme_options( 'featured_header_image_alt' ) );

		$options['featured_header_image_url'] = get_theme_mod( 'featured_header_image_url', chicago_get_default_theme_options( 'featured_header_image_url' ) );

		//Support Random Header Image
		if ( is_random_header_image() ) {
			delete_transient( 'chicago_featured_image' );
		}

		if ( !$chicago_featured_image = get_transient( 'chicago_featured_image' ) ) {

			echo '<!-- refreshing cache -->';

			if ( '' != $header_image ) {

				// Header Image Link and Target
				if ( !empty( $options['featured_header_image_url'] ) ) {
					//support for qtranslate custom link
					if ( function_exists( 'qtrans_convertURL' ) ) {
						$link = qtrans_convertURL( $options['featured_header_image_url'] );
					}
					else {
						$link = esc_url( $options['featured_header_image_url'] );
					}
					//Checking Link Target
					if ( !empty( $options['featured_header_image_base'] ) )  {
						$target = '_blank';
					}
					else {
						$target = '_self';
					}
				}
				else {
					$link = '';
					$target = '';
				}

				// Header Image Title/Alt
				if ( !empty( $options['featured_header_image_alt'] ) ) {
					$title = esc_attr( $options['featured_header_image_alt'] );
				}
				else {
					$title = '';
				}

				// Header Image
				$feat_image = '<img class="wp-post-image" alt="' . esc_attr( $title ) . '" src="'.esc_url(  $header_image ).'" />';

				$chicago_featured_image = '<div id="header-featured-image" class="site-header-image">
					<div class="wrapper">';
					// Header Image Link
					if ( !empty( $options['featured_header_image_url'] ) ) :
						$chicago_featured_image .= '<a title="'. esc_attr( $title ).'" href="'. esc_url( $link ) .'" target="' . $target . '">' . $feat_image . '</a>';
					else:
						// if empty featured_header_image on theme options, display default
						$chicago_featured_image .= $feat_image;
					endif;
				$chicago_featured_image .= '</div><!-- .wrapper -->
				</div><!-- #header-featured-image -->';
			}

			set_transient( 'chicago_featured_image', $chicago_featured_image, 86940 );
		}

		echo $chicago_featured_image;

	} // chicago_featured_image
endif;


if ( ! function_exists( 'chicago_featured_page_post_image' ) ) :
	/**
	 * Template for Featured Header Image from Post and Page
	 *
	 * To override this in a child theme
	 * simply create your own chicago_featured_imaage_pagepost(), and that function will be used instead.
	 *
	 * @since Chicago 0.1
	 */
	function chicago_featured_page_post_image() {
		global $post, $wp_query;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		$page_for_posts = get_option('page_for_posts');

		if ( is_home() && $page_for_posts == $page_id ) {
			$header_page_id = $page_id;
		}
		else {
			$header_page_id = $post->ID;
		}

		if ( has_post_thumbnail( $header_page_id ) ) {

			$featured_header_image_url	= get_theme_mod( 'featured_header_image_url', chicago_get_default_theme_options( 'featured_header_image_url' ) );

			$featured_header_image_base	= get_theme_mod( 'featured_header_image_base', chicago_get_default_theme_options( 'featured_header_image_base' ) );

			if ( '' != $featured_header_image_url ) {
				//support for qtranslate custom link
				if ( function_exists( 'qtrans_convertURL' ) ) {
					$link = qtrans_convertURL( $featured_header_image_url );
				}
				else {
					$link = esc_url( $featured_header_image_url );
				}
				//Checking Link Target
				if ( '1' == $featured_header_image_base ) {
					$target = '_blank';
				}
				else {
					$target = '_self';
				}
			}
			else {
				$link = '';
				$target = '';
			}

			$featured_header_image_alt	= get_theme_mod( 'featured_header_image_alt', chicago_get_default_theme_options( 'featured_header_image_alt' ) );

			// Header Image Title/Alt
			if ( '' != $featured_header_image_alt ) {
				$title = esc_attr( $featured_header_image_alt );
			}
			else {
				$title = '';
			}

			$featured_image_size	= get_theme_mod( 'featured_image_size', chicago_get_default_theme_options( 'featured_image_size' ) );


			if ( 'slider' ==  $featured_image_size ) {
				$feat_image = get_the_post_thumbnail( $header_page_id, 'chicago-slider', array('id' => 'main-feat-img'));
			}
			elseif ( 'full' ==  $featured_image_size ) {
				$feat_image = get_the_post_thumbnail( $header_page_id, 'full', array('id' => 'main-feat-img'));
			}
			else {
				$feat_image = get_the_post_thumbnail( $header_page_id, 'chicago-large', array('id' => 'main-feat-img'));
			}

			$chicago_featured_image = '<div id="header-featured-image" class =' . $featured_image_size . '>';
				// Header Image Link
				if ( '' != $featured_header_image_url ) :
					$chicago_featured_image .= '<a title="'. esc_attr( $title ).'" href="'. esc_url( $link ) .'" target="' . $target . '">' . $feat_image . '</a>';
				else:
					// if empty featured_header_image on theme options, display default
					$chicago_featured_image .= $feat_image;
				endif;
			$chicago_featured_image .= '</div><!-- #header-featured-image -->';

			echo $chicago_featured_image;
		}
		else {
			chicago_featured_image();
		}
	} // chicago_featured_page_post_image
endif;


if ( ! function_exists( 'chicago_featured_overall_image' ) ) :
	/**
	 * Template for Featured Header Image from theme options
	 *
	 * To override this in a child theme
	 * simply create your own chicago_featured_pagepost_image(), and that function will be used instead.
	 *
	 * @since Chicago 0.1
	 */
	function chicago_featured_overall_image() {
		global $post, $wp_query;
		$enableheaderimage 		= get_theme_mod( 'enable_featured_header_image', chicago_get_default_theme_options( 'enable_featured_header_image' ) );

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();

		$page_for_posts = get_option('page_for_posts');

		// Check Enable/Disable header image in Page/Post Meta box
		if ( is_page() || is_single() ) {
			//Individual Page/Post Image Setting
			$individual_featured_image = get_post_meta( $post->ID, 'chicago-header-image', true );

			if ( 'disable' == $individual_featured_image || ( 'default' == $individual_featured_image && 'disable' == $enableheaderimage ) ) {
				echo '<!-- Page/Post Disable Header Image -->';
				return;
			}
			elseif ( 'enable' == $individual_featured_image && 'disabled' == $enableheaderimage ) {
				chicago_featured_page_post_image();
			}
		}

		// Check Homepage
		if ( 'homepage' == $enableheaderimage ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				chicago_featured_image();
			}
		}
		// Check Excluding Homepage
		if ( 'exclude-home' == $enableheaderimage ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			else {
				chicago_featured_image();
			}
		}
		elseif ( 'exclude-home-page-post' == $enableheaderimage ) {
			if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
				return false;
			}
			elseif ( is_page() || is_single() ) {
				chicago_featured_page_post_image();
			}
			else {
				chicago_featured_image();
			}
		}
		// Check Entire Site
		elseif ( 'entire-site' == $enableheaderimage ) {
			chicago_featured_image();
		}
		// Check Entire Site (Post/Page)
		elseif ( 'entire-site-page-post' == $enableheaderimage ) {
			if ( is_page() || is_single() || ( is_home() && $page_for_posts == $page_id ) ) {
				chicago_featured_page_post_image();
			}
			else {
				chicago_featured_image();
			}
		}
		// Check Page/Post
		elseif ( 'pages-posts' == $enableheaderimage ) {
			if ( is_page() || is_single() ) {
				chicago_featured_page_post_image();
			}
		}
		else {
			echo '<!-- Disable Header Image -->';
		}
	} // chicago_featured_overall_image
endif;


if ( ! function_exists( 'chicago_featured_image_display' ) ) :
	/**
	 * Display Featured Header Image
	 *
	 * @since Chicago 0.1
	 */
	function chicago_featured_image_display() {
		chicago_featured_overall_image();
	} // chicago_featured_image_display
endif;
add_action( 'chicago_after_header', 'chicago_featured_image_display', 40 );