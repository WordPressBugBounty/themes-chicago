<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function chicago_body_classes( $classes ) {
	global $post, $wp_query;

	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	// Front page displays in Reading Settings
    $page_on_front 	= get_option('page_on_front') ;
    $page_for_posts = get_option('page_for_posts');

	// Get Page ID outside Loop
    $page_id = $wp_query->get_queried_object_id();

	// Blog Page or Front Page setting in Reading Settings
	if ( $page_id == $page_for_posts || $page_id == $page_on_front ) {
        $layout 			= get_post_meta( $page_id,'chicago-layout-option', true );
        $enableheaderimage 	= get_post_meta( $page_id,'chicago-header-image', true );
    }
	elseif ( is_singular() ) {
 		if ( is_attachment() ) {
			$parent 			= $post->post_parent;
			$layout 			= get_post_meta( $parent,'chicago-layout-option', true );
			$enableheaderimage 	= get_post_meta( $parent,'chicago-header-image', true );
		}
		else {
			$layout 			= get_post_meta( $post->ID,'chicago-layout-option', true );
			$enableheaderimage 	= get_post_meta( $post->ID,'chicago-header-image', true );
		}
	}
	else {
		$layout 			= 'default';
		$enableheaderimage 	= 'default';
	}

	//check empty and load default
	if ( empty( $layout ) ) {
		$layout = 'default';
	}

	//check empty and load default
	if ( empty( $enableheaderimage ) ) {
		$enableheaderimage = 'default';
	}

	if ( 'default' == $layout ) {
		$layout_selector = get_theme_mod( 'theme_layout', chicago_get_default_theme_options( 'theme_layout' ) );
	}
	else {
		$layout_selector = $layout;
	}

	if ( 'default' == $enableheaderimage ) {
		$enableheaderimage = get_theme_mod( 'enable_featured_header_image', chicago_get_default_theme_options( 'enable_featured_header_image' ) );
	}

	// Check no-header-image class
	if ( 'disable' == $enableheaderimage ) {
		$classes[] = 'no-header-image';
	}
	elseif ( 'homepage' == $enableheaderimage ) {
		if ( !( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) ) {
			$classes[] = 'no-header-image';
		}
		elseif ( !get_header_image() ) {
			$classes[] = 'no-header-image';
		}
	}
	elseif ( 'exclude-home' == $enableheaderimage || 'exclude-home-page-post' == $enableheaderimage ) {
		if ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) {
			$classes[] = 'no-header-image';
		}
		if ( is_page() || is_single() ) {
			if ( !has_post_thumbnail() && !get_header_image() ) {
				$classes[] = 'no-header-image';
			}
		}
		else {
			$classes[] = 'no-header-image';
		}
	}
	elseif ( 'entire-site' == $enableheaderimage && !get_header_image() ) {
		$classes[] = 'no-header-image';
	}
	elseif ( 'entire-site-page-post' == $enableheaderimage ) {
		if ( is_page() || is_single() ) {
			if ( !has_post_thumbnail() && !get_header_image() ) {
				$classes[] = 'no-header-image';
			}
		}
		elseif ( !get_header_image() ) {
			$classes[] = 'no-header-image';
		}
	}
	elseif ( 'pages-posts' == $enableheaderimage ) {
		if ( is_page() || is_single() ) {
			if ( !has_post_thumbnail() && !get_header_image() ) {
				$classes[] = 'no-header-image';
			}
		}
		else {
			$classes[] = 'no-header-image';
		}
	}

	switch ( $layout_selector ) {
		case 'left-sidebar':
			$classes[] = 'two-columns content-right';
		break;

		case 'right-sidebar':
			$classes[] = 'two-columns content-left';
		break;

		case 'no-sidebar':
			$classes[] = 'no-sidebar content-width';
		break;
	}

	$current_content_layout = get_theme_mod( 'content_layout', chicago_get_default_theme_options( 'content_layout' ) );

	if ( "" != $current_content_layout ) {
		$classes[] = $current_content_layout;
	}

	if ( is_active_sidebar( 'header-right' ) ) 	{
		$classes[] = "header-right-enabled";
	}

	return $classes;
}
add_filter( 'body_class', 'chicago_body_classes' );

/**
* Left Text
*
* @since Chicago 0.1
*/
function chicago_copyright() {
	return '<span class="site-copyright">' . sprintf( _x( 'Copyright &copy; %1$s %2$s' , '1: Year, 2: Site Title with home URL', 'chicago' ),esc_attr( date_i18n( __( 'Y', 'chicago' ) ) ), '<a href="' . esc_url( home_url( '/' ) ) . '"> ' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '</a>' ) . '</span>';
} //chicago_copyright

/**
 * Seperator
 *
 * @since Chicago 0.1
 */
function chicago_seperator() {
	return '<span class="sep">' . esc_attr( '&nbsp;&bull;&nbsp;' ) . '</span>';
} //chicago_seperator

/**
 * Right Text
 *
 * @since Chicago 0.1
 */
function chicago_profile() {
	return '<span class="theme-name">'. esc_attr( 'Chicago&nbsp;' ) . sprintf( _x( 'by', 'attribution', 'chicago' ) ) . '</span>&nbsp;<span class="theme-author"><a href="' . esc_url( 'https://catchthemes.com/' ) . '" target="_blank">' . esc_attr( 'Catch Themes' ) . '</a></span>';
}

/**
 * Flush out all transients
 *
 * @uses delete_transient
 *
 * @action customize_save, chicago_customize_preview (see chicago_customizer function: chicago_customize_preview)
 *
 * @since  Chicago 1.0
 */
function chicago_flush_transients(){
	delete_transient( 'chicago_featured_image' );

	delete_transient( 'chicago_custom_css' );

	delete_transient( 'chicago_footer_content' );

	delete_transient( 'chicago_featured_content' );

	delete_transient( 'chicago_featured_slider' );

	delete_transient( 'all_the_cool_cats' );

	delete_transient( 'chicago_scrollup' );
}
add_action( 'customize_save', 'chicago_flush_transients' );

if ( ! function_exists( 'chicago_display_logo' ) ) :
	/**
	 * Get the logo and display
	 *
	 * @get logo from options
	 *
	 * @display logo
	 *
	 * @since Chicago 0.1
	 */
	function chicago_display_logo() {
		$logo 		= get_theme_mod( 'logo', chicago_get_default_theme_options( 'logo' ) );

		$logo_alt 	= get_theme_mod( 'logo_alt_text', chicago_get_default_theme_options( 'logo_alt_text' ) );
		if ( '' != $logo_alt ) {
			$logo_alt_text = $logo_alt;
		}
		else {
			$logo_alt_text = get_bloginfo( 'name', 'display' );
		}

		//Checking Logo
		if ( '' != $logo ) {
			echo '
			<a rel="home" class="site-logo-link" href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '">
				<img data-size="chicago-logo" src="' . esc_url( $logo ) . '" alt="' . esc_attr(  $logo_alt_text ). '" class="site-logo attachment-chicago-logo">
			</a><!-- #site-logo -->';
		}
	}
endif; // chicago_display_logo

if ( ! function_exists( 'chicago_custom_css' ) ) :
	/**
	 * Enqueue Custon CSS
	 *
	 * @uses  set_transient, wp_head, wp_enqueue_style
	 *
	 * @action wp_enqueue_scripts
	 *
	 * @since Chicago 0.1
	 */
	function chicago_custom_css() {
		//chicago_flush_transients();

		if ( ( !$chicago_custom_css = get_transient( 'chicago_custom_css' ) ) ) {
			//Custom CSS Option
			//Get data from theme mods values
			$options['custom_css'] 	 = get_theme_mod( 'custom_css', chicago_get_default_theme_options( 'custom_css' ) );

			if ( !empty( $options['custom_css'] ) ) {
				$chicago_custom_css	=  $options[ 'custom_css'] . "\n";
			}

			if ( '' != $chicago_custom_css ){
				echo '<!-- refreshing cache -->' . "\n";

				$chicago_custom_css = '<!-- '.get_bloginfo('name').' inline CSS Styles -->' . "\n" . '<style type="text/css" media="screen">' . "\n" . $chicago_custom_css;

				$chicago_custom_css .= '</style>' . "\n";
			}

			set_transient( 'chicago_custom_css', $chicago_custom_css, 86940 );
		}

		echo $chicago_custom_css;
	}
endif; //chicago_custom_css
add_action( 'wp_head', 'chicago_custom_css', 101  );

if ( ! function_exists( 'chicago_excerpt_length' ) ) :
	/**
	 * Sets the post excerpt length to n words.
	 *
	 * function tied to the excerpt_length filter hook.
	 * @uses filter excerpt_length
	 *
	 * @since Chicago 0.1
	 */
	function chicago_excerpt_length( $length ) {
		// Getting data from Customizer Options
		$length	= get_theme_mod( 'excerpt_length', chicago_get_default_theme_options( 'excerpt_length' ) );
		return $length;
	}
endif; //chicago_excerpt_length
add_filter( 'excerpt_length', 'chicago_excerpt_length', 999 );

if ( ! function_exists( 'chicago_continue_reading' ) ) :
	/**
	 * Returns a "Custom Continue Reading" link for excerpts
	 *
	 * @since Chicago 0.1
	 */
	function chicago_continue_reading() {
		// Getting data from Customizer Options
		$more_tag_text	= get_theme_mod( 'excerpt_more_text', chicago_get_default_theme_options( 'excerpt_more_text' ) );

		return ' <a class="more-link" href="'. esc_url( get_permalink() ) . '">' .  $more_tag_text . '</a>';
	}
endif; //chicago_continue_reading
add_filter( 'excerpt_more', 'chicago_continue_reading' );


if ( ! function_exists( 'chicago_archive_content_image' ) ) :
	/**
	 * Template for Featured Image in Archive Content
	 *
	 * To override this in a child theme
	 * simply chicago your own chicago_archive_content_image(), and that function will be used instead.
	 *
	 * @since Chicago 0.1
	 */
	function chicago_archive_content_image() {
		$featured_image = get_theme_mod( 'content_layout', chicago_get_default_theme_options( 'content_layout' ) );

		if ( has_post_thumbnail() && 'excerpt-image-left' == $featured_image ) {
		?>
			<div class="entry-thumbnail">
				<?php
					the_post_thumbnail();
				?>
	        </div>
	   	<?php
		}
	}
endif; //chicago_archive_content_image
add_action( 'chicago_before_entry_container', 'chicago_archive_content_image', 10 );


if ( ! function_exists( 'chicago_single_content_image' ) ) :
	/**
	 * Template for Featured Image in Single Post
	 *
	 * To override this in a child theme
	 * simply create your own chicago_single_content_image(), and that function will be used instead.
	 *
	 * @since Catch Responsive 1.0
	 */
	function chicago_single_content_image() {
		global $post, $wp_query;

		// Get Page ID outside Loop
		$page_id = $wp_query->get_queried_object_id();
		if ( $post) {
	 		if ( is_attachment() ) {
				$parent = $post->post_parent;
				$individual_featured_image = get_post_meta( $parent,'chicago-featured-image', true );
			} else {
				$individual_featured_image = get_post_meta( $page_id,'chicago-featured-image', true );
			}
		}

		if ( empty( $individual_featured_image ) || ( !is_page() && !is_single() ) ) {
			$individual_featured_image = 'default';
		}

		// Getting data from Theme Options
		$featured_image = get_theme_mod( 'single_post_image_layout', chicago_get_default_theme_options( 'single_post_image_layout' ) );

		if ( ( 'disable' == $individual_featured_image || '' == get_the_post_thumbnail() || ( $individual_featured_image=='default' && 'disable' == $featured_image) ) ) {
			echo '<!-- Page/Post Single Image Disabled or No Image set in Post Thumbnail -->';
			return false;
		}
		else {
			$class = '';

			if ( 'default' == $individual_featured_image ) {
				$class = $featured_image;
			}
			else {
				$class = 'from-metabox ' . $individual_featured_image;
			}

			?>
			<div class="entry-thumbnail <?php echo $class; ?>">
                <?php
				if ( 'featured-image' == $individual_featured_image || ( $individual_featured_image=='default' && 'featured-image' == $featured_image ) ) {
					the_post_thumbnail( 'chicago-single' );
				}
				elseif ( 'slider' == $individual_featured_image || ( $individual_featured_image=='default' && 'slider-image-size' == $featured_image ) ) {
					the_post_thumbnail( 'chicago-slider' );
				}
				else {
					the_post_thumbnail( 'full' );
				} ?>
	        </div><!-- .entry-thumbnail -->
	   	<?php
		}
	}
endif; //chicago_single_content_image
add_action( 'chicago_before_post_container', 'chicago_single_content_image', 10 );
add_action( 'chicago_before_page_container', 'chicago_single_content_image', 10 );

if ( ! function_exists( 'chicago_scrollup' ) ) {
	/**
	 * This function loads Scroll Up Navigation
	 *
	 * @action chicago_after action
	 * @uses set_transient and delete_transient
	 */
	function chicago_scrollup() {
		//chicago_flush_transients();
		if ( !$chicago_scrollup = get_transient( 'chicago_scrollup' ) ) {

			// get the data value from theme options
			echo '<!-- refreshing cache -->';

			$disable_scrollup = get_theme_mod( 'disable_scrollup', chicago_get_default_theme_options( 'disable_scrollup' ) );

			if ( '1' != $disable_scrollup ) {
				$chicago_scrollup =  '<a href="#masthead" id="scrollup" class="font-awesome"><span class="screen-reader-text">' . __( 'Scroll Up', 'chicago' ) . '</span></a>' ;
			}

			set_transient( 'chicago_scrollup', $chicago_scrollup, 86940 );
		}
		echo $chicago_scrollup;
	}
}
add_action( 'chicago_after', 'chicago_scrollup', 10 );

/**
 * Return the first image in a post. Works inside a loop.
 * @param [integer] $post_id [Post or page id]
 * @param [string/array] $size Image size. Either a string keyword (thumbnail, medium, large or full) or a 2-item array representing width and height in pixels, e.g. array(32,32).
 * @param [string/array] $attr Query string or array of attributes.
 * @return [string] image html
 *
 * @since Chicago 1.2
 */

function chicago_get_first_image( $postID, $size, $attr ) {
	ob_start();

	ob_end_clean();

	$image 	= '';

	$output = preg_match_all('/<img.+src=[\'"]([^\'"]+)[\'"].*>/i', get_post_field('post_content', $postID ) , $matches);

	if ( isset( $matches [1] [0] ) ) {
		//Get first image
		$first_img = $matches [1] [0];

		return '<img class="pngfix wp-post-image" src="'. $first_img .'">';
	}

	return false;
}

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
add_action( 'chicago_before_header_navigation', 'chicago_header_right', 10 );


/**
 * Alter the query for the main loop in homepage
 *
 * @action pre_get_posts
 *
 * @since Chicago 0.1
 */
function chicago_alter_home( $query ){
	if ( $query->is_main_query() && $query->is_home() ) {
		$cats = get_theme_mod( 'front_page_category', chicago_get_default_theme_options( 'front_page_category' ) );

	    $post_list	= array();	// list of valid post ids

	    if ( is_array( $cats ) && !in_array( '0', $cats ) ) {
			$query->query_vars['category__in'] =  $cats;
		}
	}
}
add_action( 'pre_get_posts','chicago_alter_home' );


if ( ! function_exists( 'chicago_footer_sidebar_class' ) ) :
	/**
	 * Count the number of footer sidebars to enable dynamic classes for the footer
	 *
	 * @since Chicago 0.1
	 */
	function chicago_footer_sidebar_class() {
		$count = 0;

		if ( is_active_sidebar( 'footer-1' ) )
			$count++;

		if ( is_active_sidebar( 'footer-2' ) )
			$count++;

		if ( is_active_sidebar( 'footer-3' ) )
			$count++;

		if ( is_active_sidebar( 'footer-4' ) )
			$count++;

		$class = '';

		switch ( $count ) {
			case '1':
				$class = 'one';
				break;
			case '2':
				$class = 'two';
				break;
			case '3':
				$class = 'three';
				break;
			case '4':
				$class = 'four';
				break;
		}

		if ( $class )
			echo 'class="' . $class . '"';
	}
endif; // chicago_footer_sidebar_class

if ( ! function_exists( 'chicago_get_logo' ) ) :
	/**
	 * Get the logo
	 *
	 * @get logo from options
	 *
	 * @since Chicago 0.1
	 */
	function chicago_get_logo() {
		$output = '';
		//Checking Logo
		if ( function_exists( 'has_custom_logo' ) ) {
			if ( has_custom_logo() ) {
				$output = '
				<div class="site-logo">'. get_custom_logo() . '</div><!-- #site-logo -->';
			}
		}
		else {
			$logo 		  	= get_theme_mod( 'logo', chicago_get_default_theme_options( 'logo' ) );

			$logo_disable 	= get_theme_mod( 'logo_disable', chicago_get_default_theme_options( 'logo_disable' ) );

			$logo_alt_text 	= get_theme_mod( 'logo_alt_text', chicago_get_default_theme_options( 'logo_alt_text' ) );
			if ( '' != $logo && !$logo_disable ) {

				$output = '
				<div class="site-logo">
					<a href="' . esc_url( home_url( '/' ) ) . '" title="' . esc_attr( get_bloginfo( 'name', 'display' ) ) . '" rel="home">
						<img src="' . esc_url( $logo ) . '"';
						if ( '' != $logo_alt_text ) {
							$output .= ' alt="' . esc_attr(  $logo_alt_text ). '"';
						}
						$output .= '>
					</a>
				</div><!-- .site-logo -->';
			}
		}

		return $output;
	}
endif; // chicago_get_logo
