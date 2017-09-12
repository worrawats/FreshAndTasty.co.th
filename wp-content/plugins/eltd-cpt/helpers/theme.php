<?php

if(!function_exists('eltdcpt_theme_installed')) {
    /**
     * Function that checks if theme is installed
     * @return bool whether theme is installed or not
     */
    function eltdcpt_theme_installed() {
        return defined('ELTD_ROOT');
    }
}