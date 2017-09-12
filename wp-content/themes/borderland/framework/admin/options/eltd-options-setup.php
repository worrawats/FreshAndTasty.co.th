<?php

add_action('after_setup_theme', 'eltd_admin_map_init', 0);
function eltd_admin_map_init() {
	global $eltd_options;
	global $eltdFramework;
	global $eltd_options_fontstyle;
	global $eltd_options_fontweight;
	global $eltd_options_texttransform;
	global $eltd_options_fontdecoration;
	global $eltd_options_arrows_type;
	global $eltd_options_double_arrows_type;
	global $eltd_options_arrows_up_type;
	require_once("10.general/map.inc");
	require_once("20.logo/map.inc");
	require_once("30.header/map.inc");
    require_once("40.title/map.inc");
    require_once("50.content/map.inc");
	require_once("60.footer/map.inc");
	require_once("70.fonts/map.inc");
	require_once("80.elements/map.inc");
	require_once("90.blog/map.inc");
	require_once("100.portfolio/map.inc");
	require_once("110.slider/map.inc");
	require_once("120.social/map.inc");
	require_once("130.error404/map.inc");
	if(eltd_visual_composer_installed() && version_compare(eltd_get_vc_version(), '4.4.2') >= 0) {
		require_once("140.visualcomposer/map.inc");
	} else {
		$eltdFramework->eltdOptions->addOption("enable_grid_elements","no");
	}
    if(eltd_contact_form_7_installed()) {
        require_once("150.contactform7/map.inc");
    }
	if(function_exists("is_woocommerce")){
		require_once("160.woocommerce/map.inc");
	}
	require_once("170.reset/map.inc");
}