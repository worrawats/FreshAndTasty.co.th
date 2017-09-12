<?php

//define needed constants
define('ELTD_CORE_VERSION', '1.0.3');
define('ELTD_CORE_ABS_PATH', dirname(__FILE__));
define('ELTD_CORE_REL_PATH', dirname(plugin_basename(__FILE__ )));

//include all necessary files
require_once ELTD_CORE_ABS_PATH.'/helpers/carousel.php';
require_once ELTD_CORE_ABS_PATH.'/helpers/theme.php';
require_once ELTD_CORE_ABS_PATH.'/cpt/eltd-cpt.php';
require_once ELTD_CORE_ABS_PATH.'/cpt/portfolio/eltd.portfolio.php';
require_once ELTD_CORE_ABS_PATH.'/cpt/eltd-slider/shortcodes/eltd.slidersc.php';
require_once ELTD_CORE_ABS_PATH.'/cpt/eltd-slider/eltd-slider-settings.php';
require_once ELTD_CORE_ABS_PATH.'/cpt/testimonials/shortcodes/eltd.testimonialssc.php';
require_once ELTD_CORE_ABS_PATH.'/cpt/carousels/shortcodes/eltd.carouselsc.php';