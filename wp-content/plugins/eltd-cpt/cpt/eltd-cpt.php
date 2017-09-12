<?php
if(!defined('ABSPATH')) exit;

/**
 * Class EltdCPT
 *
 * @package Elated Core
 *
 * This class is used to register custom post types and taxonomies. It is a singletone class and main method
 * is registerCPT
 * It registers:
 * - portfolio
 * - portfolio category
 * - testimonials
 * - testimonials category
 * - carousels
 * - carousels category
 * - sliders
 * - sliders category
 */
class EltdCPT {
    private static $instance;

    /**
     * Private constructor so this class can't instantiated multiple times
     */
    private function __construct() {}

    /**
     * Method that returns instance of current class
     * @return EltdCPT
     */
    public static function getInstance() {
        if(self::$instance == null) {
            return new self();
        }

        return self::$instance;
    }

    /**
     * Method that registers all CPTs
     *
     * @see EltdCPT::registerPortfolio
     * @see EltdCPT::registerTestimonials
     * @see EltdCPT::registerCarousels
     * @see EltdCPT::registerEltdSlider
     */
    public function registerCPT() {
        $this->registerPortfolio();
        $this->registerTestimonials();
        $this->registerCarousels();
        $this->registerEltdSlider();
    }

    /**
     * Method that registers portfolio CPT and portfolio category taxonomy
     */
    public function registerPortfolio() {
        global $eltd_options, $eltdFramework;

        $slug = 'portfolio_page';
        $menuPosition = 5;
        $menuIcon = 'dashicons-admin-post';
        if(eltdcpt_theme_installed()) {
            if(isset($eltd_options['portfolio_single_slug'])) {
                if($eltd_options['portfolio_single_slug'] != ""){
                    $slug = $eltd_options['portfolio_single_slug'];
                }
            }

            $menuPosition   = $eltdFramework->getSkin()->getMenuItemPosition('portfolio');
            $menuIcon       = $eltdFramework->getSkin()->getMenuIcon('portfolio');
        }

        register_post_type( 'portfolio_page',
            array(
                'labels' => array(
                    'name' => __( 'Portfolio','eltd_cpt' ),
                    'singular_name' => __( 'Portfolio Item','eltd_cpt' ),
                    'add_item' => __('New Portfolio Item','eltd_cpt'),
                    'add_new_item' => __('Add New Portfolio Item','eltd_cpt'),
                    'edit_item' => __('Edit Portfolio Item','eltd_cpt')
                ),
                'public' => true,
                'has_archive' => true,
                'rewrite' => array('slug' => $slug),
                'menu_position' => $menuPosition,
                'menu_icon'	=> $menuIcon,
                'show_ui' => true,
                'supports' => array('author', 'title', 'editor', 'thumbnail', 'excerpt', 'page-attributes', 'comments')
            )
        );

        $labels = array(
            'name' => __( 'Portfolio Categories', 'eltd_cpt' ),
            'singular_name' => __( 'Portfolio Category', 'eltd_cpt' ),
            'search_items' =>  __( 'Search Portfolio Categories','eltd_cpt' ),
            'all_items' => __( 'All Portfolio Categories','eltd_cpt' ),
            'parent_item' => __( 'Parent Portfolio Category','eltd_cpt' ),
            'parent_item_colon' => __( 'Parent Portfolio Category:','eltd_cpt' ),
            'edit_item' => __( 'Edit Portfolio Category','eltd_cpt' ),
            'update_item' => __( 'Update Portfolio Category','eltd_cpt' ),
            'add_new_item' => __( 'Add New Portfolio Category','eltd_cpt' ),
            'new_item_name' => __( 'New Portfolio Category Name','eltd_cpt' ),
            'menu_name' => __( 'Portfolio Categories','eltd_cpt' ),
        );

        register_taxonomy('portfolio_category', array('portfolio_page'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'portfolio-category' ),
        ));

        $labels = array(
            'name' => __( 'Portfolio Tags', 'eltd_cpt' ),
            'singular_name' => __( 'Portfolio Tag', 'eltd_cpt' ),
            'search_items' =>  __( 'Search Portfolio Tags','eltd_cpt' ),
            'all_items' => __( 'All Portfolio Tags','eltd_cpt' ),
            'parent_item' => __( 'Parent Portfolio Tag','eltd_cpt' ),
            'parent_item_colon' => __( 'Parent Portfolio Tags:','eltd_cpt' ),
            'edit_item' => __( 'Edit Portfolio Tag','eltd_cpt' ),
            'update_item' => __( 'Update Portfolio Tag','eltd_cpt' ),
            'add_new_item' => __( 'Add New Portfolio Tag','eltd_cpt' ),
            'new_item_name' => __( 'New Portfolio Tag Name','eltd_cpt' ),
            'menu_name' => __( 'Portfolio Tags','eltd_cpt' ),
        );

        register_taxonomy('portfolio_tag',array('portfolio_page'), array(
            'hierarchical' => false,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array( 'slug' => 'portfolio-tag' ),
        ));
    }

    /**
     * Method that registers testimonials CPT and testimonials category taxonomy
     */
    public function registerTestimonials() {
        global $eltdFramework;

        $menuPosition = 5;
        $menuIcon = 'dashicons-admin-post';
        if(eltdcpt_theme_installed()) {
            $menuPosition   = $eltdFramework->getSkin()->getMenuItemPosition('testimonial');
            $menuIcon       = $eltdFramework->getSkin()->getMenuIcon('testimonial');
        }

        register_post_type('testimonials',
            array(
                'labels' 		=> array(
                    'name' 				=> __('Testimonials','eltd_cpt' ),
                    'singular_name' 	=> __('Testimonial','eltd_cpt' ),
                    'add_item'			=> __('New Testimonial','eltd_cpt'),
                    'add_new_item' 		=> __('Add New Testimonial','eltd_cpt'),
                    'edit_item' 		=> __('Edit Testimonial','eltd_cpt')
                ),
                'public'		=>	false,
                'show_in_menu'	=>	true,
                'rewrite' 		=> 	array('slug' => 'testimonials'),
                'menu_position' => 	$menuPosition,
                'menu_icon'		=>  $menuIcon,
                'show_ui'		=>	true,
                'has_archive'	=>	false,
                'hierarchical'	=>	false,
                'supports'		=>	array('title', 'thumbnail')
            )
        );

        $labels = array(
            'name' => __( 'Testimonials Categories', 'eltd_cpt' ),
            'singular_name' => __( 'Testimonial Category', 'eltd_cpt' ),
            'search_items' =>  __( 'Search Testimonials Categories','eltd_cpt' ),
            'all_items' => __( 'All Testimonials Categories','eltd_cpt' ),
            'parent_item' => __( 'Parent Testimonial Category','eltd_cpt' ),
            'parent_item_colon' => __( 'Parent Testimonial Category:','eltd_cpt' ),
            'edit_item' => __( 'Edit Testimonials Category','eltd_cpt' ),
            'update_item' => __( 'Update Testimonials Category','eltd_cpt' ),
            'add_new_item' => __( 'Add New Testimonials Category','eltd_cpt' ),
            'new_item_name' => __( 'New Testimonials Category Name','eltd_cpt' ),
            'menu_name' => __( 'Testimonials Categories','eltd_cpt' ),
        );

        register_taxonomy('testimonials_category',array('testimonials'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'show_admin_column' => true,
            'rewrite' => array( 'slug' => 'testimonials-category' ),
        ));
    }

    /**
     * Method that registers carousel item CPT and carousel taxonomy
     */
    public function registerCarousels() {
        global $eltdFramework;

        $menuIcon = 'dashicons-admin-post';
        $menuPosition = 5;
        if(eltdcpt_theme_installed()) {
            $menuIcon       = $eltdFramework->getSkin()->getMenuIcon('carousel');
            $menuPosition   = $eltdFramework->getSkin()->getMenuItemPosition('carousel');
        }

        register_post_type('carousels',
            array(
                'labels'    => array(
                    'name'        => __('Elated Carousel','eltd_cpt' ),
                    'menu_name' => __('Elated Carousel','eltd_cpt' ),
                    'all_items' => __('Carousel Items','eltd_cpt' ),
                    'add_new' =>  __('Add New Carousel Item','eltd_cpt'),
                    'singular_name'   => __('Carousel Item','eltd_cpt' ),
                    'add_item'      => __('New Carousel Item','eltd_cpt'),
                    'add_new_item'    => __('Add New Carousel Item','eltd_cpt'),
                    'edit_item'     => __('Edit Carousel Item','eltd_cpt')
                ),
                'public'    =>  false,
                'show_in_menu'  =>  true,
                'rewrite'     =>  array('slug' => 'carousels'),
                'menu_position' =>  $menuPosition,
                'menu_icon'	=> $menuIcon,
                'show_ui'   =>  true,
                'has_archive' =>  false,
                'hierarchical'  =>  false,
                'supports'    =>  array('title','page-attributes'),
            )
        );

        $labels = array(
            'name' => __( 'Carousels', 'eltd_cpt' ),
            'singular_name' => __( 'Carousel', 'eltd_cpt' ),
            'search_items' =>  __( 'Search Carousels','eltd_cpt' ),
            'all_items' => __( 'All Carousels','eltd_cpt' ),
            'parent_item' => __( 'Parent Carousel','eltd_cpt' ),
            'parent_item_colon' => __( 'Parent Carousel:','eltd_cpt' ),
            'edit_item' => __( 'Edit Carousel','eltd_cpt' ),
            'update_item' => __( 'Update Carousel','eltd_cpt' ),
            'add_new_item' => __( 'Add New Carousel','eltd_cpt' ),
            'new_item_name' => __( 'New Carousel Name','eltd_cpt' ),
            'menu_name' => __( 'Carousels','eltd_cpt' ),
        );

        register_taxonomy('carousels_category',array('carousels'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'show_admin_column' => true,
            'rewrite' => array( 'slug' => 'carousels-category' ),
        ));
    }

    /**
     * Method that registers slide CPT and slider taxonomy
     */
    public function registerEltdSlider() {
        global $eltdFramework;

        $menuIcon = 'dashicons-admin-post';
        $menuPosition = 5;
        if(eltdcpt_theme_installed()) {
            $menuIcon       = $eltdFramework->getSkin()->getMenuIcon('slider');
            $menuPosition   = $eltdFramework->getSkin()->getMenuItemPosition('slider');
        }
;        register_post_type('slides',
            array(
                'labels' 		=> array(
                    'name' 				=> __('Elated Slider','eltd_cpt' ),
                    'menu_name'	=> __('Elated Slider','eltd_cpt' ),
                    'all_items'	=> __('Slides','eltd_cpt' ),
                    'add_new' =>  __('Add New Slide','eltd_cpt'),
                    'singular_name' 	=> __('Slide','eltd_cpt' ),
                    'add_item'			=> __('New Slide','eltd_cpt'),
                    'add_new_item' 		=> __('Add New Slide','eltd_cpt'),
                    'edit_item' 		=> __('Edit Slide','eltd_cpt')
                ),
                'public'		=>	false,
                'show_in_menu'	=>	true,
                'rewrite' 		=> 	array('slug' => 'slides'),
                'menu_position' => 	$menuPosition,
                'menu_icon'		=>  $menuIcon,
                'show_ui'		=>	true,
                'has_archive'	=>	false,
                'hierarchical'	=>	false,
                'supports'		=>	array('title', 'thumbnail', 'page-attributes'),
            )
        );

        $labels = array(
            'name' => __( 'Sliders', 'eltd_cpt' ),
            'singular_name' => __( 'Slider', 'eltd_cpt' ),
            'search_items' =>  __( 'Search Sliders','eltd_cpt' ),
            'all_items' => __( 'All Sliders','eltd_cpt' ),
            'parent_item' => __( 'Parent Slider','eltd_cpt' ),
            'parent_item_colon' => __( 'Parent Slider:','eltd_cpt' ),
            'edit_item' => __( 'Edit Slider','eltd_cpt' ),
            'update_item' => __( 'Update Slider','eltd_cpt' ),
            'add_new_item' => __( 'Add New Slider','eltd_cpt' ),
            'new_item_name' => __( 'New Slider Name','eltd_cpt' ),
            'menu_name' => __( 'Sliders','eltd_cpt' ),
        );

        register_taxonomy('slides_category',array('slides'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'show_admin_column' => true,
            'rewrite' => array( 'slug' => 'slides-category' ),
        ));
    }
}

//Hook EltdCPT::registerCPT method to init action
add_action('init', array(EltdCPT::getInstance(), 'registerCPT'), 0);