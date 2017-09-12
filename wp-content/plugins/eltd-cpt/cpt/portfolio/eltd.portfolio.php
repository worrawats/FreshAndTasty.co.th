<?php
include 'shortcodes/eltd.portfoliolistsc.php';
include 'shortcodes/eltd.portfolioslidersc.php';

class EltdPortfolio {
    public function __construct() {
        add_filter('single_template', array($this, 'registerTemplate'));
    }

    public function registerTemplate($single) {
        global $post;

        if($post->post_type == 'portfolio_page') {
            if(!file_exists(get_template_directory().'/single-portfolio_page.php')) {
                return ELTD_CORE_ABS_PATH.'/portfolio/templates/single-portfolio_page.php';
            }
        }

        return $single;
    }
}

new EltdPortfolio();