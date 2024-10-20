<?php
/**
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */
?>

<?php 
	/** 
	 * chicago_before_post_container hook
	 *
	 * @hooked chicago_single_content_image - 10
	 */
	do_action( 'chicago_before_post_container' ); ?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<div class="entry-meta">
			<?php chicago_posted_on(); ?>
		</div><!-- .entry-meta -->
        
		<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
	</header><!-- .entry-header -->

	<div class="entry-content">
		<?php the_content(); ?>
		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . __( 'Pages:', 'chicago' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->

	<footer class="entry-footer">
		<?php chicago_entry_footer(); ?>
	</footer><!-- .entry-footer -->
</article><!-- #post-## -->