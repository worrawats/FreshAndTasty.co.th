<?php
/**
 * @package Elated CPT
 * @version 1.0.3
 */
/*
Plugin Name: Elated CPT
Description: Plugin that adds all custom post types that are needed by Elated theme
Author: Elated Themes
Version: 1.0.3
*/

require_once 'bootstrap.php';

/**
 * Function that sets plugin text domain to eltd_cpt
 *
 * @see load_plugin_textdomain()
 */
function eltdcpt_text_domain() {
    load_plugin_textdomain('eltd_cpt', false, ELTD_CORE_REL_PATH.'/languages');
}

add_action('plugins_loaded', 'eltdcpt_text_domain');

/**
 * Function that adds class to body element so we can easily see which version of plugin is installed
 * @param $classes array of existing body classes
 * @return array array of body classes with our body class added
 */
function eltdcpt_body_class($classes) {
    $classes[] = 'eltd-core-'.ELTD_CORE_VERSION;

    return $classes;
}

add_action('body_class', 'eltdcpt_body_class');

/**
 * Function that calls CPT registration method when plugin is activated.
 * Rewrite rules needs to flushed so our custom slug for CPT can work properly
 * without saving permalinks in Settings page
 *
 * @see EltdCPT::registerCPT()
 */
function eltdcpt_activation() {
    EltdCPT::getInstance()->registerCPT();
    flush_rewrite_rules();
}

register_activation_hook(__FILE__, 'eltdcpt_activation');
