<?php
/**
 * The template for displaying the Breadcrumb
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

/**
 * Add breadcrumb.
 *
 * @action chicago_after_header
 *
 * @since Chicago 0.1
 */
if ( !function_exists( 'chicago_add_breadcrumb' ) ) :

	function chicago_add_breadcrumb() {
		$breadcrumb_option		= get_theme_mod( 'breadcrumb_option', chicago_get_default_theme_options( 'breadcrumb_option' ) );
		$breadcrumb_onhomepage	= get_theme_mod( 'breadcrumb_onhomepage', chicago_get_default_theme_options( 'breadcrumb_onhomepage' ) );
		$breadcrumb_seperator	= get_theme_mod( 'breadcrumb_seperator', chicago_get_default_theme_options( 'breadcrumb_seperator' ) );

		if ( $breadcrumb_option ){
			$showOnHome = ( $breadcrumb_onhomepage ) ? '1' : '0';

			$delimiter = '<span class="sep">'. $breadcrumb_seperator .'</span><!-- .sep -->'; // delimiter between crumbs

			echo chicago_custom_breadcrumbs( $showOnHome, $delimiter );
		}
		else
			return false;
	}

endif;
add_action( 'chicago_after_header', 'chicago_add_breadcrumb', 10 );


/**
 * Breadcrumb Lists
 * Allows visitors to quickly navigate back to a previous section or the root page.
 *
 * Adopted from Dimox
 *
 * @since Chicago 0.1
 */
if ( !function_exists( 'chicago_custom_breadcrumbs' ) ) :

	function chicago_custom_breadcrumbs( $showOnHome, $delimiter ) {

		/* === OPTIONS === */
		$text['home']     = __( 'Home', 'chicago' ); // text for the 'Home' link
		$text['category'] = __( '%1$s Archive for %2$s', 'chicago' ); // text for a category page
		$text['search']   = __( '%1$sSearch results for: %2$s', 'chicago' ); // text for a search results page
		$text['tag']      = __( '%1$sPosts tagged %2$s', 'chicago' ); // text for a tag page
		$text['author']   = __( '%1$sView all posts by %2$s', 'chicago' ); // text for an author page
		$text['404']      = __( 'Error 404', 'chicago' ); // text for the 404 page

		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$before      = '<span class="breadcrumb-current">'; // tag before the current crumb
		$after       = '</span>'; // tag after the current crumb
		/* === END OF OPTIONS === */

		global $post, $paged, $page;
		$homeLink   = home_url( '/' );
		$linkBefore = '<span class="breadcrumb" typeof="v:Breadcrumb">';
		$linkAfter  = '</span>';
		$linkAttr   = ' rel="v:url" property="v:title"';
		$link       = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s ' . $delimiter . '</a>' . $linkAfter;


		if ( is_front_page() ) {

			if ( $showOnHome ) {
				echo '<div id="breadcrumb-list" class="clear">
					<div class="wrapper clear">';

					echo $linkBefore . '<a href="' . esc_url( $homeLink ) . '">' . $text['home'] . '</a>' . $linkAfter;

					echo '</div><!-- .wrapper -->
				</div><!-- #breadcrumb-list -->';
			}

		}
		else {
			echo '<div id="breadcrumb-list" class="clear">
					<div class="wrapper clear">';

			echo sprintf( $link, esc_url( $homeLink ), $text['home'] );

			if ( is_home() ) {
				if ( $showCurrent == 1 ) {
					echo $before . get_the_title( get_option( 'page_for_posts', true ) ) . $after;
				}

			}
			elseif ( is_category() ) {
				$thisCat = get_category( get_query_var( 'cat' ), false );
				if ( $thisCat->parent != 0 ) {
					$cats = get_category_parents( $thisCat->parent, true, false );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', $delimiter .'</a>' . $linkAfter, $cats );
					echo $cats;
				}
				echo $before . sprintf( $text['category'], '<span class="archive-text">', '&nbsp</span>' . single_cat_title( '', false ) ) . $after;

			}
			elseif ( is_search() ) {
				echo $before . sprintf( $text['search'], '<span class="search-text">', '&nbsp</span>' . get_search_query() ) . $after;

			}
			elseif ( is_day() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) ;
				echo sprintf( $link, get_month_link( get_the_time( 'Y' ), get_the_time( 'm' ) ), get_the_time( 'F' ) );
				echo $before . get_the_time( 'd' ) . $after;

			}
			elseif ( is_month() ) {
				echo sprintf( $link, get_year_link( get_the_time( 'Y' ) ), get_the_time( 'Y' ) ) ;
				echo $before . get_the_time( 'F' ) . $after;

			}
			elseif ( is_year() ) {
				echo $before . get_the_time( 'Y' ) . $after;

			}
			elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object( get_post_type() );
					$slug      = $post_type->rewrite;
					printf( $link, esc_url( $homeLink ) . '/' . $slug['slug'] . '/', $post_type->labels->singular_name );
					if ( $showCurrent == 1 ) {
						echo $before . get_the_title() . $after;
					}
				}
				else {
					$cat  = get_the_category();
					$cat  = $cat[0];
					$cats = get_category_parents( $cat, true, ''	 );
					if ( $showCurrent == 0 ) {
						$cats = preg_replace( "#^(.+)$#", "$1", $cats );
					}
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', $delimiter . '</a>' . $linkAfter, $cats );
					echo $cats;
					if ( $showCurrent == 1 ) {
						echo $before . get_the_title() . $after;
					}
				}
			}
			elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
				$post_type = get_post_type_object( get_post_type() );
				echo isset( $post_type->labels->singular_name ) ? $before . $post_type->labels->singular_name . $after : '';
			}
			elseif ( is_attachment() ) {
				$parent = get_post( $post->post_parent );
				$cat    = get_the_category( $parent->ID );

				if ( isset( $cat[0] ) ) {
					$cat = $cat[0];
				}

				if ( $cat ) {
					$cats = get_category_parents( $cat, true );
					$cats = str_replace( '<a', $linkBefore . '<a' . $linkAttr, $cats );
					$cats = str_replace( '</a>', $delimiter .'</a>' . $linkAfter, $cats );
					echo $cats;
				}

				printf( $link, get_permalink( $parent ), $parent->post_title );
				if ( $showCurrent == 1 ) {
					echo $before . get_the_title() . $after;
				}

			}
			elseif ( is_page() && !$post->post_parent ) {
				if ( $showCurrent == 1 ) {
					echo $before . get_the_title() . $after;
				}

			}
			elseif ( is_page() && $post->post_parent ) {
				$parent_id   = $post->post_parent;
				$breadcrumbs = array();
				while( $parent_id ) {
					$page_child    = get_post( $parent_id );
					$breadcrumbs[] = sprintf( $link, get_permalink( $page_child->ID ), get_the_title( $page_child->ID ) );
					$parent_id     = $page_child->post_parent;
				}
				$breadcrumbs = array_reverse( $breadcrumbs );
				for( $i = 0; $i < count( $breadcrumbs ); $i++ ) {
					echo $breadcrumbs[$i];
				}
				if ( $showCurrent == 1 ) {
					echo $before . get_the_title() . $after;
				}

			}
			elseif ( is_tag() ) {
				echo $before . sprintf( $text['tag'], '<span class="tag-text">', '&nbsp</span>' . single_tag_title( '', false ) ) . $after;

			}
			elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata( $author );
				echo $before . sprintf( $text['author'], '<span class="author-text">', '&nbsp</span>' . $userdata->display_name ) . $after;

			}
			elseif ( is_404() ) {
				echo $before . $text['404'] . $after;

			}
			if ( get_query_var( 'paged' ) ) {
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ' (';
				}
				echo sprintf( __( 'Page %s', 'chicago' ), max( $paged, $page ) );
				if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) {
					echo ')';
				}
			}

			echo '</div><!-- .wrapper -->
			</div><!-- #breadcrumb-list -->';
		}


	} // end chicago_breadcrumb_lists
endif;
