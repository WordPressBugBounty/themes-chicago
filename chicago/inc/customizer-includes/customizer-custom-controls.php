<?php
/**
 * The template for adding Customizer Custom Controls
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

//Custom control for dropdown category multiple select
class Chicago_Customize_Dropdown_Categories_Control extends WP_Customize_Control {
	public $type = 'dropdown-categories';

	public $name;

	public function render_content() {
		$dropdown = wp_dropdown_categories(
			array(
				'name'             => $this->name,
				'echo'             => 0,
				'hide_empty'       => false,
				'show_option_none' => false,
				'hide_if_empty'    => false,
				'show_option_all'  => __( 'All Categories', 'chicago' )
			)
		);

		$dropdown = str_replace('<select', '<select multiple = "multiple" style = "height:95px;" ' . $this->get_link(), $dropdown );

		printf( '<label class="customize-control-select"><span class="customize-control-title">%s</span> %s</label>',esc_html( $this->label ), $dropdown ); // WPCS: XSS OK.
		echo '<p class="description">'. __( 'Hold down the Ctrl (windows) / Command (Mac) button to select multiple options.', 'chicago' ) . '</p>';
	}
}

//Custom control for any note, use label as output description
class Chicago_Note_Control extends WP_Customize_Control {
	public $type = 'description';

	public function render_content() {
		echo '<h2 class="description">' . $this->label . '</h2>'; // WPCS: XSS OK.
	}
}

//Important Links
class ChicagoImportantLinks extends WP_Customize_Control {
    public $type = 'important-links';

    public function render_content() {
    	//Add Theme instruction, Support Forum, Changelog, Donate link, Review, Facebook, Twitter, Google+, Pinterest links
        $important_links = array(
						'theme_instructions' => array(
							'link'	=> esc_url( 'https://catchthemes.com/theme-instructions/chicago/' ),
							'text' 	=> __( 'Theme Instructions', 'chicago' ),
							),
						'support' => array(
							'link'	=> esc_url( 'https://catchthemes.com/support/' ),
							'text' 	=> __( 'Support', 'chicago' ),
							),
						'changelog' => array(
							'link'	=> esc_url( 'https://catchthemes.com/changelogs/chicago-theme/' ),
							'text' 	=> __( 'Changelog', 'chicago' ),
							),
						'review' => array(
							'link'	=> esc_url( 'https://wordpress.org/support/view/theme-reviews/chicago' ),
							'text' 	=> __( 'Review', 'chicago' ),
							),
						'facebook' => array(
							'link'	=> esc_url( 'https://www.facebook.com/catchthemes/' ),
							'text' 	=> __( 'Facebook', 'chicago' ),
							),
						'twitter' => array(
							'link'	=> esc_url( 'https://twitter.com/catchthemes/' ),
							'text' 	=> __( 'Twitter', 'chicago' ),
							),
						'gplus' => array(
							'link'	=> esc_url( 'https://plus.google.com/+Catchthemes/' ),
							'text' 	=> __( 'Google+', 'chicago' ),
							),
						'pinterest' => array(
							'link'	=> esc_url( 'http://www.pinterest.com/catchthemes/' ),
							'text' 	=> __( 'Pinterest', 'chicago' ),
							),
						);
		foreach ( $important_links as $important_link) {
			echo '<p><a target="_blank" href="' . $important_link['link'] .'" >' . $important_link['text'] .' </a></p>'; // WPCS: XSS OK.
		}
    }
}
