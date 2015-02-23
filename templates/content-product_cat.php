<?php
/** Hook function to show thumbnail on category frontend page
 *
 * @return void
 */ 
function wchover_get_subcategory_thumbnail($category) {
	global $post, $woocommerce, $wc_hover_plugin_url;
	
	
	// get the thumbnail
	$small_thumbnail_size  = apply_filters( 'single_product_small_thumbnail_size', 'shop_catalog' );
	$image_width    = '150px';//$woocommerce->get_image_size( 'shop_catalog_image_width' );
	$image_height    = '150px';//$woocommerce->get_image_size( 'shop_catalog_image_height' );
	
	$thumbnail_id  = get_woocommerce_term_meta( $category->term_id, 'thumbnail_id', true  );

	if ( $thumbnail_id) {
		$image = wp_get_attachment_image_src( $thumbnail_id, 'full' );
		$image=$image[0];
	} else {
		$image = woocommerce_placeholder_img_src();	

	}
	

	// get the hover image
	$hover_thumbnail_id 	= get_woocommerce_term_meta( $category->term_id, '_woocommerce_hover_image', true );
	if ($hover_thumbnail_id) :
		$image_hover = wp_get_attachment_url( $hover_thumbnail_id );
	else :
		$image_hover = $image;
	endif;
	
	$css_id =  'thumbnails-'. $category->slug;
	//$output = '<img id="' . $css_id . '" src="' . $image . '" alt="' . $category->post_name  . '">';
	$output = '<img id="' . $css_id . '" src="'. $wc_hover_plugin_url .'/img/empty-300x300.png" alt="' . $post->post_name . '" width="'.$image_width.'">';
	//$output .= wc_ru_get_hover_thumbnails($css_id, $image, $image_hover );
	$output .= '<style type="text/css">';
	$output .= '#' . $css_id . ' {background-image:url(' . $image . ');display: block;background-size: contain;background-repeat: no-repeat;} ';
	$output .= '#' . $css_id . ':hover {background-image:url(' . $image_hover . ');}';
	$output .= '#' . $css_id . ' img {visibility: hidden}';
	// preload hover image
	$output .= 'img.preload {display: none !important; visibility: hidden;}';
	$output .=  '</style>';
	$output .=  '<img class="preload" src="'.$image_hover.'"/>';

	echo $output;//echo wc_ru_get_hover_thumbnails( $css_id, $image,$image_hover );
}

?>