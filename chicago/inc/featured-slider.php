<?php
/**
 * The template for displaying the Slider
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

if ( !function_exists( 'chicago_featured_slider' ) ) :
/**
 * Add slider.
 *
 * @uses action hook chicago_before_content.
 *
 * @since Chicago 0.1
 */
function chicago_featured_slider() {
	global $wp_query;
	//chicago_flush_transients();

	// get data value from options
	$enableslider	= get_theme_mod( 'featured_slider_option', chicago_get_default_theme_options( 'featured_slider_option' ) );

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Front page displays in Reading Settings
	$page_for_posts = get_option('page_for_posts');

	if ( 'entire-site' == $enableslider || ( ( is_front_page() || ( is_home() && $page_for_posts != $page_id ) ) && 'homepage' == $enableslider ) ) {
		if ( ( !$chicago_featured_slider = get_transient( 'chicago_featured_slider' ) ) ) {
			echo '<!-- refreshing cache -->';
			$featured_slide_transition_effect	= get_theme_mod( 'featured_slide_transition_effect', chicago_get_default_theme_options( 'featured_slide_transition_effect' ) );
			$featured_slide_transition_length	= get_theme_mod( 'featured_slide_transition_length', chicago_get_default_theme_options( 'featured_slide_transition_length' ) );
			$featured_slide_transition_delay	= get_theme_mod( 'featured_slide_transition_delay', chicago_get_default_theme_options( 'featured_slide_transition_delay' ) );
			$sliderselect						= get_theme_mod( 'featured_slider_type', chicago_get_default_theme_options( 'featured_slider_type' ) );
			$imageloader						= get_theme_mod( 'featured_slider_image_loader', chicago_get_default_theme_options( 'featured_slider_image_loader' ) );

			$chicago_featured_slider = '
				<section id="feature-slider">
					<div class="wrapper">
						<div class="cycle-slideshow"
						    data-cycle-log="false"
						    data-cycle-pause-on-hover="true"
						    data-cycle-swipe="true"
						    data-cycle-auto-height=container
						    data-cycle-fx="'. esc_attr( $featured_slide_transition_effect ) .'"
							data-cycle-speed="'. esc_attr( $featured_slide_transition_length ) * 1000 .'"
							data-cycle-timeout="'. esc_attr( $featured_slide_transition_delay ) * 1000 .'"
							data-cycle-loader="'. esc_attr( $imageloader ) .'"
							data-cycle-slides="> article"
							>

						    <!-- prev/next links -->
						    <div class="cycle-prev"></div>
						    <div class="cycle-next"></div>

						    <!-- empty element for pager links -->
	    					<div class="cycle-pager"></div>';

							// Select Slider
							if ( 'demo-featured-slider' == $sliderselect && function_exists( 'chicago_demo_slider' ) ) {
								$chicago_featured_slider .=  chicago_demo_slider();
							}
							elseif ( 'featured-page-slider' == $sliderselect && function_exists( 'chicago_page_slider' ) ) {
								$chicago_featured_slider .=  chicago_page_slider();
							}

			$chicago_featured_slider .= '
						</div><!-- .cycle-slideshow -->
					</div><!-- .wrapper -->
				</section><!-- #feature-slider -->';

			set_transient( 'chicago_featured_slider', $chicago_featured_slider, 86940 );
		}
		echo $chicago_featured_slider;
	}
}
endif;
add_action( 'chicago_after_header', 'chicago_featured_slider', 30 );


if ( ! function_exists( 'chicago_demo_slider' ) ) :
/**
 * This function to display featured posts slider
 *
 * @get the data value from customizer options
 *
 * @since Chicago 0.1
 *
 */
function chicago_demo_slider() {
	$excerpt_more_text	= get_theme_mod( 'excerpt_more_text', chicago_get_default_theme_options( 'excerpt_more_text' ) );
	$chicago_demo_slider ='
						<article class="post demo-image-1 hentry slides displayblock">
							<a title="Slider Image 1" href="'. esc_url( home_url( '/' ) ) .'">
								<figure class="slider-image">
									<img src="'.esc_url( get_template_directory_uri() ).'/images/gallery/slider1-1680x720.jpg" class="wp-post-image" alt="Slider Image 1" title="Slider Image 1">
								</figure>
								<div class="entry-container">
									<div class="vcenter">
										<header class="entry-header">
											<h1 class="entry-title">
												<span>Slider Image 1</span>
											</h1>
										</header>
										<div class="entry-content">
											<p>Slider Image 1 Content
											<span class="more-link">' . esc_html( $excerpt_more_text ) . '</span></p>
										</div><!-- .entry-content -->
									</div>
								</div>
							</a>
						</article><!-- .slides -->

						<article class="post demo-image-2 hentry slides displaynone">
							<a title="Slider Image 2" href="'. esc_url( home_url( '/' ) ) .'">
								<figure class="Slider Image 2">
									<img src="'. trailingslashit( esc_url ( get_template_directory_uri() ) ) . 'images/gallery/slider2-1680x720.jpg" class="wp-post-image" alt="Slider Image 2" title="Slider Image 2">
								</figure>
								<div class="entry-container">
									<div class="vcenter">
										<header class="entry-header">
											<h1 class="entry-title">
												<span>Slider Image 2</span>
											</h1>
										</header>
										<div class="entry-content">
											<p>Slider Image 2 Content
											<span class="more-link">' . esc_html( $excerpt_more_text ) . '</span></p>
										</div><!-- .entry-content -->
									</div>
								</div>
							</a>
						</article><!-- .slides --> ';
	return $chicago_demo_slider;
}
endif; // chicago_demo_slider


if ( ! function_exists( 'chicago_page_slider' ) ) :
/**
 * This function to display featured page slider
 *
 * @since Chicago 0.1
 */
function chicago_page_slider() {
	$quantity	= get_theme_mod( 'featured_slide_number', chicago_get_default_theme_options( 'featured_slide_number' ) );

	$excerpt_more_text	= get_theme_mod( 'excerpt_more_text', chicago_get_default_theme_options( 'excerpt_more_text' ) );

    global $post;

    $chicago_page_slider = '';
    $number_of_page 	= 0; 		// for number of pages
	$page_list			= array();	// list of valid page ids

	//Get number of valid pages
	for( $i = 1; $i <= $quantity; $i++ ){
		if ( get_theme_mod( 'featured_slider_page_' . $i ) && get_theme_mod( 'featured_slider_page_' . $i ) > 0 ){
			$number_of_page++;

			$page_list	=	array_merge( $page_list, array( get_theme_mod( 'featured_slider_page_' . $i ) ) );
		}

	}

	if ( !empty( $page_list ) && $number_of_page > 0 ) {
		$loop = new WP_Query( array(
			'posts_per_page'	=> $quantity,
			'post_type'			=> 'page',
			'post__in'			=> $page_list,
			'orderby' 			=> 'post__in'
		));
		$i=0;

		while ( $loop->have_posts()) : $loop->the_post(); $i++;
			$title_attribute = the_title_attribute( 'echo=0' );

			if ( $i == 1 ) { $classes = 'page post-'.$post->ID.' hentry slides displayblock'; } else { $classes = 'page post-'.$post->ID.' hentry slides displaynone'; }

			$chicago_page_slider .= '
			<article class="'.$classes.'">';
				$chicago_page_slider .= '
				<a title="'. $title_attribute . '" href="' . esc_url( get_permalink() ) . '">';
					if ( has_post_thumbnail() ) {
						$chicago_page_slider .= '
							<figure class="slider-image">
								'. get_the_post_thumbnail( $post->ID, 'chicago-slider', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class'	=> 'wp-post-image' ) ).'
							</figure>';
					}
					else {
						//Default value if there is no first image
						$chicago_image = '<img class="pngfix wp-post-image" src="'.esc_url( get_template_directory_uri() ).'/images/gallery/no-featured-image-1680x720.jpg" >';

						//Get the first image in page, returns false if there is no image
						$chicago_first_image = chicago_get_first_image( $post->ID, 'chicago-slider', array( 'title' => $title_attribute, 'alt' => $title_attribute, 'class' => 'attached-post-image' ) );

						//Set value of image as first image if there is an image present in the page
						if ( '' != $chicago_first_image ) {
							$chicago_image =	$chicago_first_image;
						}

						$chicago_page_slider .= '
							<figure class="slider-image">
								'. $chicago_image .'
							</figure>';
					}

					$chicago_page_slider .= '
					<div class="entry-container">
						<div class="vcenter">
							<header class="entry-header">
								<h1 class="entry-title">'
									. the_title( '<span>','</span>', false ) . '
								</h1>
							</header>
							<div class="entry-content"><p><span class="more-link">' . esc_html( $excerpt_more_text ) . '</span></p></div>
						</div><!-- .vcenter -->
					</div><!-- .entry-container -->
				</a><!-- .slides -->
			</article><!-- .slides -->';
		endwhile;

		wp_reset_postdata();
  	}
	return $chicago_page_slider;
}
endif; // chicago_page_slider
