<?php
/**
 * The sidebar containing the main widget area.
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

/**
 * chicago_before_secondary hook
 */
do_action( 'chicago_before_secondary' );?>

<?php
	global $post, $wp_query;

	$themeoption_layout = get_theme_mod( 'theme_layout', chicago_get_default_theme_options( 'theme_layout' ) );

	// Front page displays in Reading Settings
	$page_on_front = get_option('page_on_front') ;
	$page_for_posts = get_option('page_for_posts');

	// Get Page ID outside Loop
	$page_id = $wp_query->get_queried_object_id();

	// Blog Page or Front Page setting in Reading Settings
	if ( $page_id == $page_for_posts || $page_id == $page_on_front ) {
        $layout 		= get_post_meta( $page_id,'chicago-layout-option', true );
    }
	elseif ( is_singular() ) {
		if ( is_attachment() ) {
			$parent 		= $post->post_parent;
			$layout 		= get_post_meta( $parent, 'chicago-layout-option', true );

		} else {
			$layout 		= get_post_meta( $post->ID, 'chicago-layout-option', true );
		}
	}
	else {
		$layout = 'default';
	}

	//check empty and load default
	if ( empty( $layout ) ) {
		$layout = 'default';
	}

	if ( 'no-sidebar' == $layout ) {
		return;
	}

	if ( 'default' == $layout && 'no-sidebar' == $themeoption_layout ) {
		return;
	}

	do_action( 'chicago_before_primary_sidebar' );
	?>
		<aside id="secondary" class="sidebar sidebar-primary widget-area" role="complementary">
			<?php
			if ( is_active_sidebar( 'sidebar-1' ) ) {
	        	dynamic_sidebar( 'sidebar-1' );
	   		}
			else {
			//Helper Text
			if ( current_user_can( 'edit_theme_options' ) ) { ?>
				<section id="widget-default-text" class="widget widget_text">
					<div class="widget-wrap">
	                	<h4 class="widget-title"><?php _e( 'Primary Sidebar Widget Area', 'chicago' ); ?></h4>

	           			<div class="textwidget">
	                   		<p><?php _e( 'This is the Primary Sidebar Widget Area if you are using a two or three column site layout option.', 'chicago' ); ?></p>
	                   		<p><?php printf( __( 'By default it will load Search and Archives widgets as shown below. You can add widget to this area by visiting your <a href="%s">Widgets Panel</a> which will replace default widgets.', 'chicago' ), esc_url( admin_url( 'widgets.php' ) ) ); ?></p>
	                 	</div>
	           		</div><!-- .widget-wrap -->
	       		</section><!-- #widget-default-text -->
			<?php
			} ?>
			<section class="widget widget_search" id="default-search">
				<div class="widget-wrap">
					<?php get_search_form(); ?>
				</div><!-- .widget-wrap -->
			</section><!-- #default-search -->
			<section class="widget widget_archive" id="default-archives">
				<div class="widget-wrap">
					<h4 class="widget-title"><?php _e( 'Archives', 'chicago' ); ?></h4>
					<ul>
						<?php wp_get_archives( array( 'type' => 'monthly' ) ); ?>
					</ul>
				</div><!-- .widget-wrap -->
			</section><!-- #default-archives -->
			<?php
		} ?>
		</aside><!-- .sidebar sidebar-primary widget-area -->
	<?php
	/**
	 * chicago_after_primary_sidebar hook
	 */
	do_action( 'chicago_after_primary_sidebar' ); ?>

<?php
/**
 * chicago_after_secondary hook
 *
 */
do_action( 'chicago_after_secondary' );
