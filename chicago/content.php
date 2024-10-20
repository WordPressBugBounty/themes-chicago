<?php
/**
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */
?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php if ( 'post' == get_post_type() ) : ?>
		<div class="entry-meta">
			<?php chicago_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>

		<?php the_title( sprintf( '<h1 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' ); ?>

        <?php
		/**
		 * chicago_before_entry_container hook
		 *
		 * @hooked chicago_archive_content_image - 10
		 */
		do_action( 'chicago_before_entry_container' ); ?>
	</header><!-- .entry-header -->

	<?php
	$chicago_content_layout = get_theme_mod( 'content_layout', chicago_get_default_theme_options( 'content_layout' ) );

	if ( is_search() || 'full-content' != $chicago_content_layout ) : // Only display Excerpts for Search and if 'full-content' is not selected ?>
		<div class="entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- .entry-summary -->
	<?php else : ?>
		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links"><span class="pages">' . __( 'Pages:', 'chicago' ) . '</span>',
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->
	<?php endif; ?>

	<footer class="entry-footer">
		<?php chicago_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->