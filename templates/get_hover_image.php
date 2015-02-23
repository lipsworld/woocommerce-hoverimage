<?php
/**
 * common function for creating hover imgae
*/
function wc_ru_get_hover_thumbnails( $css_id, $image, $image_hover ) {
		// apply hover style	
		$output = '<style type="text/css">';
		$output .= '#' . $css_id . ' {background-image:url(' . $image . ');display: block;background-size: contain;background-repeat: no-repeat;} ';
		$output .= '#' . $css_id . ':hover {background-image:url(' . $image_hover . ');}';
		$output .= '#' . $css_id . ' img {visibility: hidden}';
		// preload hover image
		$output .= 'img.preload {display: none !important; visibility: hidden;}';
		$output .=  '</style>';
		$output .=  '<img class="preload" src="'.$image_hover.'"/>';
		return $output;
}
?>