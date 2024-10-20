<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

/** 
 * chicago_after_content hook
 *
 * @hooked chicago_content_end - 10
 * @hooked chicago_featured_content_display (move featured content below homepage posts) - 20 
 *
 */
do_action( 'chicago_after_content' ); 
               
/** 
 * chicago_footer hook
 *
 * @hooked chicago_footer_content_start - 10
 * @hooked chicago_footer_sidebar - 20
 * @hooked chicago_footer_content_end - 190
 * @hooked chicago_page_end - 200
 *
 */
do_action( 'chicago_footer' );

/** 
 * chicago_after hook
 *
 * @hooked chicago_scrollup - 10
 *
 */
do_action( 'chicago_after' );?>

<?php wp_footer(); ?>

</body>
</html>