<?php
/**
 * The template used for displaying page content in page.php
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */
?>

<?php 
/** 
 * chicago_before_page_container hook
 *
 * @hooked chicago_single_content_image - 10
 */
do_action( 'chicago_before_page_container' ); ?>
	
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
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
        <?php edit_post_link( __( 'Edit', 'chicago' ), '<span class="edit-link">', '</span>' ); ?>
    </footer><!-- .entry-footer -->

</article><!-- #post-## -->