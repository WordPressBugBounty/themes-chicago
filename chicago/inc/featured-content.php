<?php
/**
 * The template for displaying the Featured Content
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

if ( !function_exists( 'chicago_featured_content_display' ) ) :
/**
* Add Featured content.
*
* @uses action hook chicago_before_content.
*
* @since Chicago 0.1
*/
function chicago_featured_content_display() {
	//chicago_flush_transients();
	global $post, $wp_query;

	// get data value from options
	$chicago_classes 	 = get_theme_mod( 'featured_content_layout', chicago_get_default_theme_options( 'featured_content_layout' ) );


	$enablecontent 	= get_theme_mod( 'featured_content_option', chicago_get_default_theme_options( 'featured_content_option' ) );
	$contentselect 	= get_theme_mod( 'featured_content_type', chicago_get_default_theme_options( 'featured_content_type' ) );

	// Front page displays in Reading Settings
	$page_on_front 	= get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');


	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();
	if ( 'entire-site' == $enablecontent || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enablecontent ) ) {
		if ( ( !$chicago_featured_content = get_transient( 'chicago_featured_content' ) ) ) {
			$featured_content_position = get_theme_mod( 'featured_content_position', chicago_get_default_theme_options( 'featured_content_position' ) );
			$layouts 	 = get_theme_mod( 'featured_content_layout', chicago_get_default_theme_options( 'featured_content_layout' ) );
			$headline 	 = get_theme_mod( 'featured_content_headline', chicago_get_default_theme_options( 'featured_content_headline' ) );
			$subheadline = get_theme_mod( 'featured_content_subheadline', chicago_get_default_theme_options( 'featured_content_subheadline' ) );

			echo '<!-- refreshing cache -->';

			if ( !empty( $layouts ) ) {
				$classes = $layouts ;
			}

			if ( 'demo-featured-content' == $contentselect ) {
				$classes 	.= ' demo-featured-content' ;
				$headline 		= __( 'Featured Content', 'chicago' );
				$subheadline 	= __( 'Here you can showcase the x number of Featured Content. You can edit this Headline, Subheadline and Feaured Content from "Appearance -> Customize -> Featured Content Options".', 'chicago' );
			}
			elseif ( 'featured-page-content' == $contentselect ) {
				$classes .= ' featured-page-content' ;
			}

			if ( '1' == $featured_content_position ) {
				$classes .= ' featured-content-bottom' ;
			}

			$chicago_featured_content ='
				<section id="featured-content" class="' . $classes . '">
					<div class="wrapper">';
						if ( !empty( $headline ) || !empty( $subheadline ) ) {
							$chicago_featured_content .='<div class="featured-heading-wrap">';
								if ( !empty( $headline ) ) {
									$chicago_featured_content .='<h1 id="featured-heading" class="entry-title">' . wp_kses_post( $headline ) . '</h1>';
								}
								if ( !empty( $subheadline ) ) {
									$chicago_featured_content .='<p>' . wp_kses_post( $subheadline ) . '</p>';
								}
							$chicago_featured_content .='</div><!-- .featured-heading-wrap -->';
						}

						$chicago_featured_content .='
						<div class="featured-content-wrap clear">';
							// Select content
							if ( 'demo-featured-content' == $contentselect && function_exists( 'chicago_demo_content' ) ) {
								$chicago_featured_content .= chicago_demo_content();
							}
							elseif ( 'featured-page-content' == $contentselect && function_exists( 'chicago_page_content' ) ) {
								$chicago_featured_content .= chicago_page_content();
							}

			$chicago_featured_content .='
						</div><!-- .featured-content-wrap -->
					</div><!-- .wrapper -->
				</section><!-- #featured-content -->';
			set_transient( 'chicago_featured_content', $chicago_featured_content, 86940 );

		}
		echo $chicago_featured_content;
	}
}
endif;


if ( ! function_exists( 'chicago_featured_content_display_position' ) ) :
/**
 * Homepage Featured Content Position
 *
 * @action chicago_content, chicago_after_secondary
 *
 * @since Chicago 0.1
 */
function chicago_featured_content_display_position() {
	// Getting data from Theme Options
	$featured_content_position = get_theme_mod( 'featured_content_position', chicago_get_default_theme_options( 'featured_content_position' ) );

	if ( '1' != $featured_content_position ) {
		add_action( 'chicago_after_header', 'chicago_featured_content_display', 20 );
	} else {
		add_action( 'chicago_after_content', 'chicago_featured_content_display', 20 );
	}

}
endif; // chicago_featured_content_display_position
add_action( 'wp', 'chicago_featured_content_display_position' );


if ( ! function_exists( 'chicago_demo_content' ) ) :
/**
 * This function to display featured posts content
 *
 * @get the data value from customizer options
 *
 * @since Chicago 0.1
 *
 */
function chicago_demo_content() {
	$chicago_demo_content = '
		<article id="featured-post-1" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Central Park" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured1-350x197.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a title="Central Park" href="#">Central Park</a>
					</h1>
				</header>
				<div class="entry-content">
					<p>Central Park is is the most visited urban park in the United States as well as one of the most filmed locations in the world. It was opened in 1857 and is expanded in 843 acres of city-owned land.</p>
				</div>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-2" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Home Office" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured2-350x197.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a title="Home Office" href="#">Home Office</a>
					</h1>
				</header>
				<div class="entry-content">
					<p>It might be work, but it doesn\'t have to feel like it. All you need is a comfortable desk, nice laptop, home office furniture that keeps things organized, and the right lighting for the job.</p>
				</div>
			</div><!-- .entry-container -->
		</article>

		<article id="featured-post-3" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Vespa Scooter" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured3-350x197.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a title="Vespa Scooter" href="#">Vespa Scooter</a>
					</h1>
				</header>
				<div class="entry-content">
					<p>The Vespa Scooter has evolved from a single model motor scooter manufactured in the year 1946 by Piaggio & Co. S.p.A. of Pontedera, Italy-to a full line of scooters, today owned by Piaggio.</p>
				</div>
			</div><!-- .entry-container -->
		</article>';

	if ( 'layout-four' == get_theme_mod( 'featured_content_layout', chicago_get_default_theme_options( 'featured_content_layout' ) ) ) {
		$chicago_demo_content .= '
		<article id="featured-post-4" class="post hentry post-demo">
			<figure class="featured-content-image">
				<img alt="Antique Clock" class="wp-post-image" src="'.trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/featured4-350x197.jpg" />
			</figure>
			<div class="entry-container">
				<header class="entry-header">
					<h1 class="entry-title">
						<a title="Antique Clock" href="#">Antique Clock</a>
					</h1>
				</header>
				<div class="entry-content">
					<p>Antique clocks increase in value with the rarity of the design, their condition, and appeal in the market place. Many different materials were used in antique clocks.</p>
				</div>
			</div><!-- .entry-container -->
		</article>';
	}

	return $chicago_demo_content;
}
endif; // chicago_demo_content


if ( ! function_exists( 'chicago_page_content' ) ) :
/**
 * This function to display featured page content
 *
 * @since Chicago 0.1
 */
function chicago_page_content( ) {
	global $post;

	$quantity 	= get_theme_mod( 'featured_content_number', chicago_get_default_theme_options( 'featured_content_number' ) );

	$chicago_page_content 	= '';

   	$number_of_page 			= 0; 		// for number of pages

	$page_list					= array();	// list of valid pages ids

	//Get valid pages
	for( $i = 1; $i <= $quantity; $i++ ){
		if ( get_theme_mod( 'featured_content_page_' . $i ) && get_theme_mod( 'featured_content_page_' . $i ) > 0 ) {
			$number_of_page++;

			$page_list	=	array_merge( $page_list, array( get_theme_mod( 'featured_content_page_' . $i ) ) );
		}

	}
	if ( !empty( $page_list ) && $number_of_page > 0 ) {
		$loop = new WP_Query( array(
                    'posts_per_page' 		=> $number_of_page,
                    'post__in'       		=> $page_list,
                    'orderby'        		=> 'post__in',
                    'post_type'				=> 'page',
                ));

		$show_content    = get_theme_mod( 'featured_content_show', chicago_get_default_theme_options( 'featured_content_show' ) );

		$i=0;

		while ( $loop->have_posts()) : $loop->the_post(); $i++;
			$title_attribute = the_title_attribute( array( 'before' => __( 'Permalink to: ', 'chicago' ), 'echo' => false ) );

			$excerpt = get_the_excerpt();

			$chicago_page_content .= '
				<article id="featured-post-' . $i . '" class="post hentry featured-page-content">';
				if ( has_post_thumbnail() ) {
					$chicago_page_content .= '
					<figure class="featured-homepage-image">
						<a href="' . esc_url( get_permalink() ) . '" title="'.the_title( '', '', false ).'">
						'. get_the_post_thumbnail( $post->ID, 'chicago-single', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class' => 'pngfix' ) ) .'
						</a>
					</figure>';
				}
				else {
					$chicago_first_image = chicago_get_first_image( $post->ID, 'chicago-single', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class' => 'pngfix' ) );

					if ( '' != $chicago_first_image ) {
						$chicago_page_content .= '
						<figure class="featured-homepage-image">
							<a href="' . esc_url( get_permalink() ) . '" title="'.the_title( '', '', false ).'">
								'. $chicago_first_image .'
							</a>
						</figure>';
					}
				}

				$chicago_page_content .= '
					<div class="entry-container">
						<header class="entry-header">
							<h1 class="entry-title">
								<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . the_title( '','', false ) . '</a>
							</h1>
						</header>';
						if ( 'excerpt' == $show_content ) {
							$chicago_page_content .= '<div class="entry-excerpt"><p>' . $excerpt . '</p></div><!-- .entry-excerpt -->';
						}
						elseif ( 'full-content' == $show_content ) {
							$content = apply_filters( 'the_content', get_the_content() );
							$content = str_replace( ']]>', ']]&gt;', $content );
							$chicago_page_content .= '<div class="entry-content">' . wp_kses_post( $content ) . '</div><!-- .entry-content -->';
						}
					$chicago_page_content .= '
					</div><!-- .entry-container -->
				</article><!-- .featured-post-'. $i .' -->';
		endwhile;

		wp_reset_postdata();
	}

	return $chicago_page_content;
}
endif; // chicago_page_content
