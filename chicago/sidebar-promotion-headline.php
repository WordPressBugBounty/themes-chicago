<?php
/**
 * The Secondary Sidebar containing the secondary widget area
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 1.1
 */
?>

<?php 
/** 
 * chicago_before_promotion_headline_content hook
 */
do_action( 'chicago_before_promotion_headline_content' );

echo '
	<div id="promotion-message">
		<div class="wrapper clear">';

	    	//Promotion Headline Left
			$chicago_promotion_headline 	= get_theme_mod( 'promotion_headline', chicago_get_default_theme_options( 'promotion_headline' ) );
			$chicago_promotion_subheadline 	= get_theme_mod( 'promotion_subheadline', chicago_get_default_theme_options( 'promotion_subheadline' ) );
			
			echo '<div class="section left">';

				if ( "" != $chicago_promotion_headline ) {
					echo '<h2>' . $chicago_promotion_headline . '</h2>';
				}

				if ( "" != $chicago_promotion_subheadline ) {
					echo '<p>' . $chicago_promotion_subheadline . '</p>';
				}			
			
			echo '</div><!-- .section.left -->';  			

	    	//Promotion Headline Right
			$chicago_promotion_headline_button 	= get_theme_mod( 'promotion_headline_button', chicago_get_default_theme_options( 'promotion_headline_button' ) );
			$chicago_promotion_headline_target 	= get_theme_mod( 'promotion_headline_target', chicago_get_default_theme_options( 'promotion_headline_target' ) );
			$chicago_promotion_headline_url 	= get_theme_mod( 'promotion_headline_url', chicago_get_default_theme_options( 'promotion_headline_url' ) );
			
			if ( "" != $chicago_promotion_headline_url ) {
				if ( "1" == $chicago_promotion_headline_target ) {
					$chicago_headlinetarget = '_blank';
				}
				else {
					$chicago_headlinetarget = '_self';
				}
				
				echo '
				<div class="section right">
					<a class="promotion-button" href="' . esc_url( $chicago_promotion_headline_url ) . '" target="' . esc_attr( $chicago_headlinetarget ) . '">' . esc_attr( $chicago_promotion_headline_button ) . '
					</a>
				</div><!-- .section.right -->';
			}		
			
		echo '
		</div><!-- .wrapper -->
	</div><!-- #promotion-message -->';


/** 
 * chicago_after_promotion_headline_content hook
 *
 */
do_action( 'chicago_after_promotion_headline_content' );