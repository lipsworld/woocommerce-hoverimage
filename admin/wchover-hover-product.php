<?php


// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

function hoverImage_meta_boxes() {
	add_meta_box( 'hoverImage-wc', __( 'Image de survol', 'pluginname' ), 'wc_rultralight_product_hover_image_box', 'product', 'side','low' );
	add_meta_box( 'hoverImage-wc', __( 'Image de survol', 'pluginname' ), 'wc_rultralight_product_hover_image_box', 'portfolio', 'side','low' );
	add_meta_box( 'hoverImage-wc', __( 'Image de survol', 'pluginname' ), 'wc_rultralight_product_hover_image_box', 'post', 'side','low' );
}
add_action( 'add_meta_boxes', 'hoverImage_meta_boxes' );

function wc_rultralight_product_hover_image_box() {
	global $woocomerce, $post, $content_width, $_wp_additional_image_sizes;	
	
	$product_image_hover_id = get_post_meta( $post->ID, '_product_image_hover', true );
	$thumbnail_html = '<img src="" />';
	
	$content_width = 266;
	if ( !isset( $_wp_additional_image_sizes['post-thumbnail'] ) )
		$thumbnail_html = wp_get_attachment_image( $product_image_hover_id, array( $content_width, $content_width ) );
	else
		$thumbnail_html = wp_get_attachment_image( $product_image_hover_id, 'post-thumbnail' );
	?>
	
	<div id="product_image_hover_container">
		<p class="hide-if-no-js">
			<a id="set-post-hover-image" href=# class="hide-if-no-js"><?php echo $thumbnail_html;?></a>
		</p>
		<a href="#" class="delete_hover" title="<?php echo __( 'Supprimer l\'image de survol', 'rultralight' ); ?> "> <?php echo __( 'Supprimer l\'image de survol', 'rultralight' ); ?></a>	
		<p class="add_product_hover_image hide-if-no-js">
			<a href="#"><?php echo _e( 'Ajouter une image de survol', 'rultralight' ); ?></a>
		</p>
	
		<input type="hidden" id="product_image_hover" name="product_image_hover" value="<?php echo esc_attr( $product_image_hover_id ); ?>" />
	</div>

	<script type="text/javascript">
//debugger;
			// Uploading files
			var product_hover_image_frame;
			var $image_hover_image_ids = jQuery('#product_image_hover');
			var $product_hover_images = jQuery('#product_image_hover_container');
			
			if ( $image_hover_image_ids )  {
				jQuery('.add_product_hover_image').hide();
				jQuery('#product_image_hover_container p a img').show();
			}
			
			if ( $image_hover_image_ids.val() < 1 ) {
				jQuery('.add_product_hover_image').show();
				jQuery('.delete_hover').hide();
				
			};
				
			jQuery('#product_image_hover_container img').css('widht', jQuery('#postimagediv img').css('width'));
			jQuery('#product_image_hover_container img').css('height', jQuery('#postimagediv img').css('height'));
			jQuery('#product_image_hover_container img').css('max-width', jQuery('#postimagediv img').css('max-width'));
			jQuery('#product_image_hover_container img').css('border', jQuery('#postimagediv img').css('border'));
			
			jQuery('#set-post-hover-image').on( 'click', 'a', function( event ) {
				add_hover_image();
			});
			
			jQuery('.add_product_hover_image').on( 'click', 'a', function( event ) {
				add_hover_image();
			});
			
			function add_hover_image() {

				var $el = jQuery(this);
				var attachment_ids = $image_hover_image_ids.val();

				// If the media frame already exists, reopen it.
				if ( product_hover_image_frame ) {
					jQuery('#product_image_hover_container p a img').show();
					product_hover_image_frame.open();
					return;
				}

				// Create the media frame.
				product_hover_image_frame = wp.media.frames.downloadable_file = wp.media({
					// Set the title of the modal.
					title: '<?php _e( 'Ajouter une image de survol au Produit', 'rultralight' ); ?>',
					button: {
						text: '<?php _e( 'Ajouter une image de survol', 'rultralight' ); ?>',
					},
					multiple: true
				});

				// When an image is selected, run a callback.
				product_hover_image_frame.on( 'select', function() {
					
					var selection = product_hover_image_frame.state().get('selection');

					selection.map( function( attachment ) {

						attachment = attachment.toJSON();
						debugger;
						if ( attachment.id ) {
							if (attachment_ids=='') {
								jQuery('#product_image_hover_container p a img').attr('src',attachment.url);
							}
							$image_hover_image_ids.val(attachment.id);							
							attachment_ids = attachment.id;
							jQuery('#product_image_hover_container p a img').attr('src',attachment.url);
							jQuery('#product_image_hover_container p a img').show();
							jQuery('.delete_hover').show();
							jQuery('.add_product_hover_image').hide();
						}

					} );
					
					$image_hover_image_ids.val( attachment_ids );
				});

				// Finally, open the modal.
				product_hover_image_frame.open();
			}

			// Remove images
			jQuery('#product_image_hover_container').on( 'click', 'a.delete_hover', function() {

				jQuery('#product_image_hover_container p a img').hide();
				jQuery('.delete_hover').hide();
				jQuery('.add_product_hover_image').show();
				$image_hover_image_ids.val('');

				return false;
			} );
	</script>
	<?php
}

/*
* Save Hover meta data
*/
function wc_rultralight_save_postdata( $post_id ) {
  
  if ( ! isset( $_POST['product_image_hover'] ) )
    return;
  
  //if saving in a custom table, get post_ID
  $post_ID = $_POST['post_ID'];
  //sanitize user input
  $data = sanitize_text_field( $_POST['product_image_hover'] );
		
  if (!$post_ID) delete_post_meta($post_ID, '_product_image_hover', $data, true);	

  add_post_meta($post_ID, '_product_image_hover', $data, true) or
  update_post_meta($post_ID, '_product_image_hover', $data);

}
add_action( 'save_post', 'wc_rultralight_save_postdata' );