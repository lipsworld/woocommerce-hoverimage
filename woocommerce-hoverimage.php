<?php
/*
Plugin Name: WooCommerce Hover Image
Plugin URI: N/A
Description: WooCommerce custom plugin for Hover image on product and categories
Author: Samuel Boutron
Author URI: samuel.boutron@gmail.com
Version: 1.0.351204

	Copyright: © 2012 Samuel Boutron (email : samuel.boutron@gmail.com)
	License: GNU General Public License v3.0
	License URI: http://www.gnu.org/licenses/gpl-3.0.html
	
*/

// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;

// remove action when initializing plugin
add_action( 'woocommerce_init','init_hover_image' );

function init_hover_image() {
	remove_action( 'woocommerce_before_subcategory_title', 'woocommerce_subcategory_thumbnail' );
	add_action( 'woocommerce_before_subcategory_title', 'wchover_get_subcategory_thumbnail', 10,1 );
	
	remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail' );
	add_action( 'woocommerce_before_shop_loop_item_title', 'wchover_get_product_thumbnail',12,3);
}

// global variable to get plugin dir in other php files
global $wc_hover_plugin_url;
$wc_hover_plugin_url = plugin_dir_url(__FILE__);

// Require php files
require_once dirname( __FILE__ ) . '/admin/wchover-hover-taxonomies.php';
require_once dirname( __FILE__ ) . '/templates/content-product_cat.php';
require_once dirname( __FILE__ ) . '/admin/wchover-hover-product.php';
require_once dirname( __FILE__ ) . '/templates/content-product.php';