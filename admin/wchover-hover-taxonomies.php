<?php
/*
* Admin function
*
*
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * Category thumbnail fields.
 *
 * @access public
 * @return void
 *
 * based on woocommerce-admin-taxonomies.php
 */
function wchover_add_category_fields() {
	global $woocommerce;
	?>
	<div class="form-field">
		<label><?php _e( 'Image de survol', 'woocommerce-hoverimage' ); ?></label>
		<div id="product_cat_hover_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo woocommerce_placeholder_img_src(); ?>" width="60px" height="60px" /></div>
		<div style="line-height:60px;">
			<input type="hidden" id="product_cat_hover_thumbnail_id" name="product_cat_hover_thumbnail_id" />
			<button type="submit" class="upload_hover_image_button button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
			<button type="submit" class="remove_hover_image_button button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
		</div>
		<script type="text/javascript">
			
			// Uploading files
			var file_hover_frame;

			jQuery(document).on( 'click', '.upload_hover_image_button', function( event ){

				event.preventDefault();

				// If the media frame already exists, reopen it.
				if ( file_hover_frame ) {
					file_hover_frame.open();
					return;
				}

				// Create the media frame.
				file_hover_frame = wp.media.frames.downloadable_file = wp.media({
					title: '<?php _e( 'Choose an image', 'woocommerce' ); ?>',
					button: {
						text: '<?php _e( 'Use image', 'woocommerce' ); ?>',
					},
					multiple: false
				});

				// When an image is selected, run a callback.
				file_hover_frame.on( 'select', function() {
					attachment = file_hover_frame.state().get('selection').first().toJSON();

					jQuery('#product_cat_hover_thumbnail_id').val( attachment.id );
					jQuery('#product_cat_hover_thumbnail img').attr('src', attachment.url );
					jQuery('.remove_hover_image_button').show();
				});

				// Finally, open the modal.
				file_hover_frame.open();
			});

			jQuery(document).on( 'click', '.remove_hover_image_button', function( event ){
				jQuery('#product_cat_hover_thumbnail img').attr('src', '<?php echo woocommerce_placeholder_img_src(); ?>');
				jQuery('#product_cat_hover_thumbnail_id').val('');
				jQuery('.remove_hover_image_button').hide();
				return false;
			});

		</script>
		<div class="clear"></div>
	</div>
	<?php
}

add_action( 'product_cat_add_form_fields', 'wchover_add_category_fields',11 );


/**
 * Edit category thumbnail field.
 *
 * @access public
 * @param mixed $term Term (category) being edited
 * @param mixed $taxonomy Taxonomy of the term being edited
 * @return void
 *
 * based on woocommerce-admin-taxonomies.php
 */
function wchover_edit_category_fields( $term, $taxonomy ) {
	global $woocommerce;

	$hover_image 			= '';
	$hover_thumbnail_id 	= absint( get_woocommerce_term_meta( $term->term_id, '_woocommerce_hover_image', true ) );

	if ($hover_thumbnail_id) :
		$hover_image = wp_get_attachment_url( $hover_thumbnail_id );
	else :
		$hover_image = woocommerce_placeholder_img_src();
	endif;

	?>
	<tr class="form-field"  id="form-product_cat_hover_thumbnail">
		<th scope="row" valign="top"><label><?php _e( 'Image de survol', 'woocommerce-hoverimage' ); ?></label></th>
		<td>
			<div id="product_cat_hover_thumbnail" style="float:left;margin-right:10px;"><img src="<?php echo $hover_image; ?>" width="60px" height="60px" /></div>
			<div style="line-height:60px;">
				<input type="hidden" id="product_cat_hover_thumbnail_id" name="product_cat_hover_thumbnail_id" value="<?php echo $hover_thumbnail_id; ?>" />
				<button type="submit" class="upload_hover_image_button button"><?php _e( 'Upload/Add image', 'woocommerce' ); ?></button>
				<button type="submit" class="remove_hover_image_button button"><?php _e( 'Remove image', 'woocommerce' ); ?></button>
			</div>
			<script type="text/javascript">
				
				
				// show / hide image for description depending on all button click because, i don't
				// want to modify original woocomerce file, and hidden input won't fire .change event !
				if (jQuery('#product_cat_thumbnail_id').val() == 0) {
					jQuery('#form-product_cat_hover_thumbnail').hide()
				} else {
					jQuery('#form-product_cat_hover_thumbnail').show()
				}
				
				if (jQuery('#product_cat_hover_thumbnail_id').val() == 0) {
					jQuery('.remove_hover_image_button').hide()
				} else {
					jQuery('.remove_hover_image_button').show()
				}
				
				jQuery('.remove_image_button').click(function(){
					jQuery('.remove_image_button').hide();
					jQuery('#form-product_cat_hover_thumbnail').hide('slow');
				});
				
				jQuery('.upload_image_button').click(function(){
					jQuery('.remove_image_button').show();
					jQuery('#form-product_cat_hover_thumbnail').show('slow');
				});
				
				// Uploading files
				var file_hover_frame;
				
				jQuery(document).on( 'click', '.upload_hover_image_button', function( event ){

					event.preventDefault();

					// If the media frame already exists, reopen it.
					if ( file_hover_frame ) {
						file_hover_frame.open();
						return;
					}

					// Create the media frame.
					file_hover_frame = wp.media.frames.downloadable_file = wp.media({
						title: '<?php _e( 'Choose an image', 'woocommerce' ); ?>',
						button: {
							text: '<?php _e( 'Use image', 'woocommerce' ); ?>',
						},
						multiple: false
					});

					// When an image is selected, run a callback.
					file_hover_frame.on( 'select', function() {
						attachment = file_hover_frame.state().get('selection').first().toJSON();

						jQuery('#product_cat_hover_thumbnail_id').val( attachment.id );
						jQuery('#product_cat_hover_thumbnail img').attr('src', attachment.url );
						jQuery('.remove_hover_image_button').show();
					});

					// Finally, open the modal.
					file_hover_frame.open();
				});

				jQuery(document).on( 'click', '.remove_hover_image_button', function( event ){
					jQuery('#product_cat_hover_thumbnail img').attr('src', '<?php echo woocommerce_placeholder_img_src(); ?>');
					jQuery('#product_cat_hover_thumbnail_id').val('');
					jQuery('.remove_hover_image_button').hide();
					return false;
				});

			</script>
			<div class="clear"></div>
		</td>
	</tr>
	<?php
}

add_action( 'product_cat_edit_form_fields', 'wchover_edit_category_fields', 11,2 );


/**
 * woocommerce_category_fields_save function.
 *
 * @access public
 * @param mixed $term_id Term ID being saved
 * @param mixed $tt_id
 * @param mixed $taxonomy Taxonomy of the term being saved
 * @return void
 */
function wchover_category_fields_save( $term_id, $tt_id, $taxonomy ) {
	if ( isset( $_POST['product_cat_hover_thumbnail_id'] ) )
		update_woocommerce_term_meta( $term_id, '_woocommerce_hover_image', absint( $_POST['product_cat_hover_thumbnail_id'] ) );
		
}

add_action( 'created_term', 'wchover_category_fields_save', 11,3);
add_action( 'edit_term', 'wchover_category_fields_save', 11,3);

	
