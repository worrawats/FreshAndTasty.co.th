<?php

add_action('after_setup_theme', 'eltd_meta_boxes_map_init', 1);
function eltd_meta_boxes_map_init() {
	global $eltd_options;
	global $eltdFramework;
	global $eltd_options_fontstyle;
	global $eltd_options_fontweight;
	global $eltd_options_texttransform;
	global $eltd_options_fontdecoration;
	global $eltd_options_arrows_type;
	require_once("page/map.inc");
	require_once("portfolio/map.inc");
	require_once("slides/map.inc");
	require_once("post/map.inc");
	require_once("testimonials/map.inc");
	require_once("carousels/map.inc");
}