<?php
/**
 * The template for displaying meta box in page/post
 *
 * This adds Layout Options, Header Freatured Image Options, Single Page/Post Image Layout
 * This is only for the design purpose and not used to save any content
 *
 * @package Catch Themes
 * @subpackage Chicago
 * @since Chicago 0.1
 */

/**
 * Class to Add, Render and save metabox options
 *
 * @since Chicago 1.8
 */
class ChicagoMetaBox {
	private $meta_box;

	private $fields;

	/**
	* Constructor
	*
	* @since Catch Base 1.8
	*
	* @access public
	*
	*/
	public function __construct( $meta_box_id, $meta_box_title, $post_type ) {

		$this->meta_box = array (
			'id' 		=> $meta_box_id,
			'title' 	=> $meta_box_title,
			'post_type' => $post_type,
		);

		$this->fields = array(
			'chicago-layout-option',
			'chicago-header-image',
			'chicago-featured-image'
		);

		// Add metaboxes
		add_action( 'add_meta_boxes', array( $this, 'add' ) );

		add_action( 'save_post', array( $this, 'save' ) );
   	}

	/**
	* Add Meta Box for multiple post types.
	*
	* @since Chicago 1.
	*
	* @access public
	*/
	public function add( $post_type ) {
		add_meta_box( $this->meta_box['id'], $this->meta_box['title'], array( $this, 'show' ), $post_type, 'side', 'high' );
	}

	/**
	* Renders metabox
	*
	* @since Catch Base 1.8
	*
	* @access public
	*/
	public function show() {
		global $post;

		$layout_options			= chicago_metabox_layouts();
		$featured_image_options	= chicago_metabox_featured_image_options();
		$header_image_options 	= chicago_metabox_header_featured_image_options();

	    // Use nonce for verification
	    wp_nonce_field( basename( __FILE__ ), 'chicago_custom_meta_box_nonce' );

	    // Begin the field table and loop  ?>
	    <p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="chicago-layout-option"><?php esc_html_e( 'Layout Options', 'chicago' ); ?></label></p>
		<select class="widefat" name="chicago-layout-option" id="chicago-layout-option">
			 <?php
				$meta_value = get_post_meta( $post->ID, 'chicago-layout-option', true );
				
				if ( empty( $meta_value ) ){
					$meta_value = 'default';
				}
				
				foreach ( $layout_options as $field =>$label ) {  
				?>
					<option value="<?php echo esc_attr( $label['value'] ); ?>" <?php selected( $meta_value, $label['value'] ); ?>><?php echo esc_html( $label['label'] ); ?></option>
				<?php
				} // end foreach
			?>
		</select>
		
		<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="chicago-header-image"><?php esc_html_e( 'Header Featured Image Options', 'chicago' ); ?></label></p>
		<select class="widefat" name="chicago-header-image" id="chicago-header-image">
			 <?php
				$meta_value = get_post_meta( $post->ID, 'chicago-header-image', true );
				
				if ( empty( $meta_value ) ){
					$meta_value = 'default';
				}
				
				foreach ( $header_image_options as $field =>$label ) {  
				?>
					<option value="<?php echo esc_attr( $label['value'] ); ?>" <?php selected( $meta_value, $label['value'] ); ?>><?php echo esc_html( $label['label'] ); ?></option>
				<?php
				} // end foreach
			?>
		</select>

		<p class="post-attributes-label-wrapper"><label class="post-attributes-label" for="chicago-featured-image"><?php esc_html_e( 'Single Page/Post Image Layout', 'chicago' ); ?></label></p>
		<select class="widefat" name="chicago-featured-image" id="chicago-featured-image">
			 <?php
				$meta_value = get_post_meta( $post->ID, 'chicago-featured-image', true );
				
				if ( empty( $meta_value ) ){
					$meta_value = 'default';
				}
				
				foreach ( $featured_image_options as $field =>$label ) {  
				?>
					<option value="<?php echo esc_attr( $label['value'] ); ?>" <?php selected( $meta_value, $label['value'] ); ?>><?php echo esc_html( $label['label'] ); ?></option>
				<?php
				} // end foreach
			?>
		</select>
	<?php
	}

	/**
	 * Save custom metabox data
	 *
	 * @action save_post
	 *
	 * @since Catch Base 1.8
	 *
	 * @access public
	 */
	public function save( $post_id ) {
		global $post_type;

		$post_type_object = get_post_type_object( $post_type );

	    if ( ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE )                      // Check Autosave
	    || ( ! isset( $_POST['post_ID'] ) || $post_id != $_POST['post_ID'] )        // Check Revision
	    || ( ! in_array( $post_type, $this->meta_box['post_type'] ) )                  // Check if current post type is supported.
	    || ( ! check_admin_referer( basename( __FILE__ ), 'chicago_custom_meta_box_nonce') )    // Check nonce - Security
	    || ( ! current_user_can( $post_type_object->cap->edit_post, $post_id ) ) )  // Check permission
	    {
	      return $post_id;
	    }

	    foreach ( $this->fields as $field ) {
			$old = get_post_meta( $post_id, $field, true);

			$new = $_POST[ $field ];

			delete_post_meta( $post_id, $field );

			if ( '' == $new || array() == $new ) {
				return;
			}
			else {
				if ( ! update_post_meta ($post_id, $field, sanitize_key ( $new ) ) ) {
					add_post_meta($post_id, $field, sanitize_key ( $new ), true );
				}
			}
		} // end foreach
	}
}

$chicago_metabox = new ChicagoMetaBox(
	'chicago-options', 					//metabox id
	esc_html__( 'Chicago Options', 'chicago' ), //metabox title
	array( 'page', 'post' )				//metabox post types
);
