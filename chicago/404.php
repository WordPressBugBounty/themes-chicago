<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

get_header(); ?>

	<div id="primary" class="content-area">

		<?php
		/** 
		 * chicago_before_main hook
		 */
		do_action( 'chicago_before_main' ); 
		?>
		
		<main id="main" class="site-main" role="main">

			<section class="error-404 not-found">
				<?php if ( is_active_sidebar( 'sidebar-notfound' ) ) :
					
						dynamic_sidebar( 'sidebar-notfound' ); 
					
					else : ?>
					<header class="page-header">
						<h1 class="entry-title"><?php _e( 'Oops! That page can&rsquo;t be found.', 'chicago' ); ?></h1>
					</header><!-- .page-header -->

					<div class="page-content">
						<p><?php _e( 'It looks like nothing was found at this location. Maybe try one of the links below or a search?', 'chicago' ); ?></p>

						<?php get_search_form(); ?>

						<?php the_widget( 'WP_Widget_Recent_Posts' ); ?>

						<?php if ( chicago_categorized_blog() ) : // Only show the widget if site has multiple categories. ?>
						<div class="widget widget_categories">
							<h2 class="widget-title"><?php _e( 'Most Used Categories', 'chicago' ); ?></h2>
							<ul>
							<?php
								wp_list_categories( array(
									'orderby'    => 'count',
									'order'      => 'DESC',
									'show_count' => 1,
									'title_li'   => '',
									'number'     => 10,
								) );
							?>
							</ul>
						</div><!-- .widget -->
						<?php endif; ?>

						<?php
							/* translators: %1$s: smiley */
							$archive_content = '<p>' . sprintf( __( 'Try looking in the monthly archives. %1$s', 'chicago' ), convert_smilies( ':)' ) ) . '</p>';
							the_widget( 'WP_Widget_Archives', 'dropdown=1', "after_title=</h2>$archive_content" );
						?>

						<?php the_widget( 'WP_Widget_Tag_Cloud' ); ?>

					</div><!-- .page-content -->
				<?php endif; ?>
			</section><!-- .error-404 -->

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>