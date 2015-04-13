<?php
/**
* Hook function to show thumbnail on products frontend page
*
* @return void
*/ 

require_once dirname( __FILE__ ) . '/get_hover_image.php';

function wchover_get_product_thumbnail( $size = 'shop_catalog', $placeholder_width = 0, $placeholder_height = 0  ) {
	global $post, $wc_hover_plugin_url;

	if ( ! $placeholder_width )
		$placeholder_width = wc_get_image_size( 'shop_catalog_image_width' );
	if ( ! $placeholder_height )
		$placeholder_height = wc_get_image_size( 'shop_catalog_image_height' );
		
	if ( has_post_thumbnail() ) {
		
		$post_thumbnail_id = get_post_thumbnail_id( $post->ID );
		$image = wp_get_attachment_image_src( $post_thumbnail_id, 'thumbnail', 0 );
		$image = $image[0];
		
		$image = wp_get_attachment_url($post_thumbnail_id);
		
		// get the hover image
		$args = array(
		   'post_type' => 'attachment',
		   'numberposts' => -1,
		   'post_status' => null,
		   'post_parent' => $post->ID
		 );
		// loop around all atteched images to get the hover img
		$attachments = get_posts( $args );
		if ( $attachments ) {
			foreach ( $attachments as $attachment ) {
				$is_hover = get_post_meta($attachment->ID, '_woocommerce_hover_image', true);
				if ( $is_hover ) {
					$image_hover = wp_get_attachment_image_src( $attachment->ID, 'thumbnail', 0 );
					$image_hover = $image_hover[0];
				}
			}
			if ( !$image_hover ) {
				$image_hover = $image;
			}
		}
		
		$image_hover_id = get_post_meta($post->ID, '_product_image_hover',1);
		$image_hover = wp_get_attachment_url($image_hover_id);
		(!$image_hover ? $image_hover=$image : $image_hover);
		//$slug = sanitize_title( get_the_title(), $fallback_title );
		$slug = get_the_id();
		$css_id =  'thumbnails-'. $slug;//$post->slug;
		$output = '<img id="' . $css_id . '" src="' . $image . '" alt="' . $post->post_name  . '">';
		$output = '<img id="' . $css_id . '" src="'. $wc_hover_plugin_url .'/img/empty-150x150.png" alt="' . $post->post_name  . '" width="auto">';
		$output .= wc_ru_get_hover_thumbnails($css_id, $image, $image_hover );

	} else {		$output = wc_placeholder_img();
	}

	echo $output;
} 