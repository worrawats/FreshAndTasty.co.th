<?php

/**
 * Exit if accessed directly
 */
if ( !defined( 'ABSPATH' ) ) {
	exit; 
}

/** 
 * Header
 */
add_action( 'wcdn_head', 'wcdn_navigation_style' );
add_action( 'wcdn_head', 'wcdn_template_stylesheet' );
//echo"111111";
/** 
 * Before page
 */
add_action( 'wcdn_before_page', 'wcdn_navigation' );
//echo"222222";
/** 
 * Content
 */

add_action( 'wcdn_loop_content', 'wcdn_content', 10, 2 );
//echo'dfsdf';
add_filter( 'wcdn_order_item_fields', 'wcdn_additional_product_fields', 10, 3);

?>