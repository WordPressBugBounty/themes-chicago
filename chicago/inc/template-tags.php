<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

if ( ! function_exists( 'chicago_the_posts_navigation' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function chicago_the_posts_navigation() {
	global $wp_query, $post;

	// Don't print empty markup in archives if there's only one page.
	if ( $wp_query->max_num_pages < 2 && ( is_home() || is_archive() || is_search() ) ) {
		return;
	}

	$pagination_type    = get_theme_mod( 'pagination_type', chicago_get_default_theme_options( 'pagination_type' ) );

	/**
	 * Check if navigation type is Jetpack Infinite Scroll and if it is enabled, else goto default pagination
	 * if it's active then disable pagination
	 */
	if ( ( 'infinite-scroll-click' == $pagination_type || 'infinite-scroll-scroll' == $pagination_type ) && class_exists( 'Jetpack' ) && Jetpack::is_module_active( 'infinite-scroll' ) ) {
		return false;
	}
	?>

	<nav class="navigation posts-navigation clear" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Posts navigation', 'chicago' ); ?></h2>
		<?php
			/**
			 * Check if navigation type is numeric and if Wp-PageNavi Plugin is enabled
			 */
			if ( 'numeric' == $pagination_type && function_exists( 'wp_pagenavi' ) ) {
				wp_pagenavi();
            }
            else { ?>
				<div class="nav-links">

					<?php if ( get_next_posts_link() ) : ?>
					<div class="nav-previous"><?php next_posts_link( __( 'Older posts', 'chicago' ) ); ?></div>
					<?php endif; ?>

					<?php if ( get_previous_posts_link() ) : ?>
					<div class="nav-next"><?php previous_posts_link( __( 'Newer posts', 'chicago' ) ); ?></div>
					<?php endif; ?>

				</div><!-- .nav-links -->
		<?php } ?>
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'chicago_the_post_navigation' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 *
 * @todo Remove this function when WordPress 4.3 is released.
 */
function chicago_the_post_navigation() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Post navigation', 'chicago' ); ?></h2>
		<div class="nav-links">
			<?php
				previous_post_link( '<div class="nav-previous">%link</div>', '%title' );
				next_post_link( '<div class="nav-next">%link</div>', '%title' );
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}
endif;

if ( ! function_exists( 'chicago_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function chicago_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

	$byline = '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>';

	echo '<span class="posted-on">' . $posted_on . '</span><span class="byline"> ' . $byline . '</span>';

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( __( 'Leave a comment', 'chicago' ), __( '1 Comment', 'chicago' ), __( '% Comments', 'chicago' ) );
		echo '</span>';
	}

}
endif;

if ( ! function_exists( 'chicago_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function chicago_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' == get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( __( ', ', 'chicago' ) );
		if ( $categories_list && chicago_categorized_blog() ) {
			echo '<span class="cat-links">' . $categories_list . '</span>';
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', __( ', ', 'chicago' ) );
		if ( $tags_list ) {
			echo '<span class="tags-links">' . $tags_list . '</span>';
		}
	}

	edit_post_link( __( 'Edit', 'chicago' ), '<span class="edit-link">', '</span>' );
}
endif;


/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function chicago_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'chicago_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'chicago_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so chicago_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so chicago_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in chicago_categorized_blog.
 */
function chicago_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'chicago_categories' );
}
add_action( 'edit_category', 'chicago_category_transient_flusher' );
add_action( 'save_post',     'chicago_category_transient_flusher' );