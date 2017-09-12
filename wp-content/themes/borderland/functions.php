<?php
//$eltd_landing = true;

define('ELTD_ROOT', get_template_directory_uri());
define('ELTD_VAR_PREFIX', 'eltd_');
include_once('framework/eltd-framework.php');
include_once('includes/shortcodes/shortcodes.inc');
include_once('includes/import/eltd-import.php');
//include_once('export/eltd-export.php');
include_once('includes/eltd-breadcrumbs.php');
include_once('includes/nav_menu/eltd-menu.php');
include_once('includes/sidebar/eltd-custom-sidebar.php');
include_once('includes/eltd-like.php' );
include_once('includes/header/eltd-header-functions.php');
include_once('includes/title/eltd-title-functions.php');
include_once('includes/eltd-portfolio-functions.php');
include_once('includes/eltd-loading-spinners.php');
/* Include comment functionality */
include_once('includes/comment/comment.php');
/* Include sidebar functionality */
include_once('includes/sidebar/sidebar.php');
/* Include pagination functionality */
include_once('includes/pagination/pagination.php');
/* Include eltd carousel select box for visual composer */
include_once('includes/eltd_carousel/eltd-carousel.php');
/** Include the TGM_Plugin_Activation class. */
require_once dirname( __FILE__ ) . '/includes/plugins/class-tgm-plugin-activation.php';
/* Include visual composer initialization */
include_once('includes/plugins/visual-composer.php');
/* Include activation for layer slider */
include_once('includes/plugins/layer-slider.php');
include_once('includes/plugins/eltd-cpt.php');
include_once('includes/eltd-blog-functions.php');
include_once('includes/eltd-layout-helpers.php');
include_once('includes/eltd-plugin-helper-functions.php');
include_once('widgets/eltd-call-to-action-widget.php');
include_once('widgets/eltd-sticky-sidebar.php');
include_once('widgets/eltd-latest-posts-widget.php');

//does woocommerce function exists?
if(function_exists("is_woocommerce")){
	//include woocommerce configuration
	require_once( 'woocommerce/woocommerce_configuration.php' );
	//include cart dropdown widget
	include_once('widgets/eltd-woocommerce-dropdown-cart.php');
}

add_filter( 'call_to_action_widget', 'do_shortcode');
add_filter('widget_text', 'do_shortcode');

if(!function_exists('eltd_load_theme_text_domain')) {
	/**
	 * Function that sets theme domain. Hooks to after_setup_theme action
	 *
	 * @see load_theme_textdomain()
	 */
	function eltd_load_theme_text_domain() {
		load_theme_textdomain( 'eltd', get_template_directory().'/languages' );
	}

	add_action('after_setup_theme', 'eltd_load_theme_text_domain');
}


if (!function_exists('eltd_styles')) {
	/**
	 * Function that includes theme's core styles
	 */
	function eltd_styles() {
		global $eltd_options;
		global $eltd_toolbar;
        global $eltd_landing;
		global $eltdIconCollections;

		//init variables
		$responsiveness = 'yes';
		$vertical_area 	= "no";
		$vertical_area_hidden = '';

		wp_register_style("eltd_blog", ELTD_ROOT . "/css/blog.min.css");

		//include theme's core styles
		wp_enqueue_style("eltd_default_style", ELTD_ROOT . "/style.css");		
		wp_enqueue_style("eltd_stylesheet", ELTD_ROOT . "/css/stylesheet.css");

		if(eltd_load_blog_assets()) {
			wp_enqueue_style('eltd_blog');
		}
		
		//define files afer which style dynamic needs to be included. It should be included last so it can override other files
		$style_dynamic_deps_array = array();
		if(eltd_load_woo_assets()) {
			$style_dynamic_deps_array = array('eltd_woocommerce', 'eltd_woocommerce_responsive');
		}

        if (file_exists(dirname(__FILE__) ."/css/style_dynamic.css") && eltd_is_css_folder_writable() && !is_multisite()) {
            wp_enqueue_style("eltd_style_dynamic", ELTD_ROOT . "/css/style_dynamic.css", $style_dynamic_deps_array, filemtime(dirname(__FILE__) ."/css/style_dynamic.css")); //it must be included after woocommerce styles so it can override it
        } else {
            wp_enqueue_style("eltd_style_dynamic", ELTD_ROOT . "/css/style_dynamic.php", $style_dynamic_deps_array); //it must be included after woocommerce styles so it can override it
        }

		//include icon collections styles
		if(is_array($eltdIconCollections->iconCollections) && count($eltdIconCollections->iconCollections)) {
			foreach ($eltdIconCollections->iconCollections as $collection_key => $collection_obj) {
				wp_enqueue_style('eltd_'.$collection_key, $collection_obj->styleUrl);
			}
		}

		//does responsive option exists?
		if (isset($eltd_options['responsiveness'])) {
			$responsiveness = $eltd_options['responsiveness'];
		}

		//is responsive option turned on?
		if ($responsiveness != "no") {
			//include proper styles
			wp_enqueue_style("eltd_responsive", ELTD_ROOT . "/css/responsive.min.css");

            if (file_exists(dirname(__FILE__) ."/css/style_dynamic_responsive.css") && eltd_is_css_folder_writable() && !is_multisite()){
                wp_enqueue_style("eltd_style_dynamic_responsive", ELTD_ROOT . "/css/style_dynamic_responsive.css", array(), filemtime(dirname(__FILE__) ."/css/style_dynamic_responsive.css"));
            } else {
                wp_enqueue_style("eltd_style_dynamic_responsive", ELTD_ROOT . "/css/style_dynamic_responsive.php");
            }
		}

		//does left menu option exists?
		if (isset($eltd_options['vertical_area'])){
			$vertical_area = $eltd_options['vertical_area'];
		}
		
		//is hidden menu enabled?
		if (isset($eltd_options['vertical_area_type'])){
			$vertical_area_hidden = $eltd_options['vertical_area_type'];
		}

		//is left menu activated and is responsive turned on?
		if($vertical_area == "yes" && $responsiveness != "no" && $vertical_area_hidden!='hidden'){
			wp_enqueue_style("eltd_vertical_responsive", ELTD_ROOT . "/css/vertical_responsive.min.css");
		}

        //is landing turned on?
        if (isset($eltd_landing)) {
            //include toolbar specific styles
            wp_enqueue_style("eltd_landing_fancybox", get_home_url() . "/demo-files/landing/css/jquery.fancybox.css");
            wp_enqueue_style("eltd_landing", get_home_url() . "/demo-files/landing/css/landing_stylesheet.css");

        }

		//include Visual Composer styles
		if (class_exists('WPBakeryVisualComposerAbstract')) {
			wp_enqueue_style( 'js_composer_front' );
		}

        if (file_exists(dirname(__FILE__) ."/css/custom_css.css") && eltd_is_css_folder_writable() && !is_multisite()){
            wp_enqueue_style("eltd_custom_css", ELTD_ROOT . "/css/custom_css.css", array(), filemtime(dirname(__FILE__) ."/css/custom_css.css"));
        } else {
            wp_enqueue_style("eltd_custom_css", ELTD_ROOT . "/css/custom_css.php");
        }
	}

	add_action('wp_enqueue_scripts', 'eltd_styles');
}


if(!function_exists('eltd_browser_specific_styles')) {
	/**
	 * Function that includes browser specific styles. Works for Chrome on Mac and for webkit browsers
	 */
	function eltd_browser_specific_styles() {
		global $is_chrome;
		global $is_safari;

		//check Chrome version
		preg_match( "#Chrome/(.+?)\.#", $_SERVER['HTTP_USER_AGENT'], $match );
		if(!empty($match)) {
			$chrome_version = $match[1];
		} else{
			$chrome_version = 0;
		}

		//is Mac OS X?
		$mac_os = strpos($_SERVER['HTTP_USER_AGENT'], "Macintosh; Intel Mac OS X");

		//is Chrome on Mac with version greater than 21
		if($is_chrome && ($mac_os !== false) && ($chrome_version > 21)) {
			//include mac specific styles
			wp_enqueue_style("eltd_mac_stylesheet", ELTD_ROOT . "/css/mac_stylesheet.css");
		}

		//is Chrome or Safari?
		if($is_chrome || $is_safari) {
			//include style for webkit browsers only
			wp_enqueue_style("eltd_webkit", ELTD_ROOT . "/css/webkit_stylesheet.css");
		}
	}

	add_action('wp_enqueue_scripts', 'eltd_browser_specific_styles');
}

if(!function_exists('eltd_add_meta_data')) {
    /**
     * Function that includes styles for IE9
     */

    function eltd_add_meta_data(){
        echo '<!--[if IE 9]><link rel="stylesheet" type="text/css" href="' . esc_url(ELTD_ROOT) . '/css/ie9_stylesheet.css" media="screen"><![endif]-->';
    }

    add_action( 'wp_head', 'eltd_add_meta_data' );
}

/* Page ID */

if(!function_exists('eltd_init_page_id')) {
	/**
	 * Function that initializes global variable that holds current page id
	 */
	function eltd_init_page_id() {
		global $wp_query;
		global $eltd_page_id;

		$eltd_page_id = $wp_query->get_queried_object_id();
	}

	add_action('get_header', 'eltd_init_page_id');
}


if(!function_exists('eltd_google_fonts_styles')) {
	/**
	 * Function that includes google fonts defined anywhere in the theme
	 */
	function eltd_google_fonts_styles() {
		global $eltd_options;
        global $eltd_toolbar;

		$font_weight_str = '100,100italic,200,200italic,300,300italic,400,400italic,500,500italic,600,600italic,700,700italic,800,800italic,900,900italic';
		$available_font_options = array(
			'google_fonts',
			'menu_google_fonts',
			'dropdown_google_fonts',
			'dropdown_wide_google_fonts',
			'dropdown_google_fonts_thirdlvl',
			'fixed_google_fonts',
			'sticky_google_fonts',
			'mobile_google_fonts',
			'h1_google_fonts',
			'h2_google_fonts',
			'h3_google_fonts',
			'h4_google_fonts',
			'h5_google_fonts',
			'h6_google_fonts',
            'text_google_fonts',
			'blockquote_font_family',
			'page_title_google_fonts',
            'page_subtitle_google_fonts',
            'page_breadcrumb_google_fonts',
            'contact_form_heading_google_fonts',
            'contact_form_section_title_google_fonts',
            'contact_form_section_subtitle_google_fonts',
            'pricing_tables_active_text_font_family',
            'pricing_tables_title_font_family',
            'pricing_tables_period_font_family',
            'pricing_tables_price_font_family',
            'pricing_tables_currency_font_family',
            'pricing_tables_button_font_family',
            'pricing_tables_content_font_family',
            'service_tables_active_text_font_family',
            'service_tables_title_font_family',
            'service_tables_content_font_family',
            'separators_with_text_text_google_fonts',
            'message_title_google_fonts',
            'counters_font_family',
            'counters_title_font_family',
            'progress_bar_horizontal_font_family',
            'progress_bar_horizontal_percentage_font_family',
           	'progress_bar_vertical_font_family',
           	'progress_bar_vertical_percentage_font_family',
            'list_google_fonts',
            'list_ordered_google_fonts',
            'pagination_font_family',
            'button_title_google_fonts',
            'testimonials_title_font_family',
            'testimonials_text_font_family',
            'testimonials_author_font_family',
            'testimonials_author_job_position_font_family',
            'back_to_top_text_fontfamily',
            'tabs_nav_font_family',
            'tags_font_family',
            'team_font_family',
            'footer_top_text_font_family',
            'footer_top_link_font_family',
            'footer_bottom_text_font_family',
            'footer_bottom_link_font_family',
            'footer_title_font_family',
            'sidebar_title_font_family',
            'sidebar_link_font_family',
            'sidebar_product_title_font_family',
            'side_area_title_google_fonts',
            'sidearea_link_font_family',
            'sidebar_search_text_font_family',
            'vertical_menu_google_fonts',
            'vertical_dropdown_google_fonts',
            'vertical_dropdown_google_fonts_thirdlvl',
            'popup_menu_google_fonts',
            'popup_menu_google_fonts_2nd',
            'popup_menu_3rd_google_fonts',
            'vertical_transparent_menu_google_fonts',
            'vertical_transparent_dropdown_google_fonts',
            'vertical_transparent_dropdown_google_fonts_thirdlvl',
            'popup_menu_3rd_font_family',
            'portfolio_single_big_title_font_family',
            'portfolio_single_small_title_font_family',
            'portfolio_single_meta_title_font_family',
            'top_header_text_font_family',
            'portfolio_filter_title_font_family',
            'portfolio_filter_font_family',
            'portfolio_title_standard_list_font_family',
            'portfolio_title_hover_box_list_font_family',
            'portfolio_category_standard_list_font_family',
            'portfolio_category_hover_box_list_font_family',
            'portfolio_title_list_font_family',
            'portfolio_category_list_font_family',
            'expandable_label_font_family',
            '404_title_font_family',
            '404_text_font_family',
            'woo_products_category_font_family',
            'woo_products_title_font_family',
            'woo_products_price_font_family',
            'woo_products_sale_font_family',
            'woo_products_out_of_stock_font_family',
            'woo_products_sorting_result_font_family',
            'woo_products_list_add_to_cart_font_family',
            'woo_product_single_meta_title_font_family',
            'woo_product_single_meta_info_font_family',
            'woo_product_single_title_font_family',
            'woo_products_single_add_to_cart_font_family',
            'woo_product_single_price_font_family',
            'woo_product_single_related_font_family',
            'woo_product_single_tabs_font_family',
            'woo_products_title_font_family',
            'woo_products_price_font_family',
			'drop_down_cart_button_font_family',
            'content_menu_text_google_fonts',
			'blog_date_in_title_title_google_fonts',
            'blog_date_in_title_info_google_fonts',
            'blog_date_in_title_ql_title_google_fonts',
            'blog_date_in_title_ql_info_google_fonts',
            'blog_date_in_title_ql_author_google_fonts',
            'blog_cat_title_cen_title_google_fonts',
            'blog_cat_title_cen_info_google_fonts',
            'blog_cat_title_cen_category_google_fonts',
            'blog_cat_title_cen_ql_title_fontfamily',
            'blog_cat_title_cen_ql_info_google_fonts',
            'blog_cat_title_cen_ql_author_fontfamily',           
            'blog_title_author_centered_title_google_fonts',
            'blog_title_author_centered_info_google_fonts',
            'blog_title_author_centered_author_google_fonts',
            'blog_title_author_centered_ql_title_google_fonts',
            'blog_title_author_centered_ql_info_google_fonts',
            'blog_title_author_centered_ql_author_google_fonts',
            'blog_masonry_filter_title_font_family',
            'blog_masonry_filter_font_family',
            'blog_masonry_title_google_fonts',
            'blog_masonry_info_google_fonts',
            'blog_masonry_ql_title_google_fonts',
            'blog_masonry_ql_info_google_fonts',
            'blog_masonry_ql_author_google_fonts',
			'blog_standard_type_title_google_fonts',
			'blog_standard_type_info_google_fonts',
			'blog_standard_type_ql_title_google_fonts',
			'blog_standard_type_ql_info_google_fonts',
			'blog_standard_type_ql_author_google_fonts',
			'blog_pih_title_google_fonts',
			'blog_pih_info_google_fonts',
			'blog_pih_ql_title_google_fonts',
			'blog_pih_ql_info_google_fonts',
			'blog_pih_ql_author_google_fonts',
			'blog_mifos_title_google_fonts',
            'blog_mifos_info_google_fonts',
            'blog_mifos_ql_title_google_fonts',
            'blog_mifos_ql_info_google_fonts',
            'blog_mifos_ql_author_google_fonts',
			'blog_mifos_wrm_title_google_fonts',
			'blog_mifos_wrm_info_google_fonts',
            'blog_mifos_wrm_ql_title_google_fonts',
            'blog_mifos_wrm_ql_info_google_fonts',
            'blog_mifos_wrm_ql_author_google_fonts',
			'blog_single_post_author_info_title_font_family',
			'blog_single_post_author_info_text_font_family',
			'blog_list_sections_title_font_family',
			'blog_list_sections_post_info_font_family',
			'blog_list_sections_date_font_family',
            'search_text_google_fonts',
            'side_area_text_google_fonts',
            'cf7_custom_style_1_element_font_family',
            'cf7_custom_style_1_button_font_family',
            'cf7_custom_style_2_element_font_family',
            'cf7_custom_style_2_button_font_family',
            'cf7_custom_style_3_element_font_family',
            'cf7_custom_style_3_button_font_family',
			'vc_grid_button_title_google_fonts',
			'vc_grid_load_more_button_title_google_fonts',
			'vc_grid_portfolio_filter_font_family',
			'navigation_number_font_font_family'
        );

		//define available font options array
		$fonts_array = array();
		foreach($available_font_options as $font_option) {
			//is font set and not set to default and not empty?
			if(isset($eltd_options[$font_option]) && $eltd_options[$font_option] !== '-1' && $eltd_options[$font_option] !== '' && !eltd_is_native_font($eltd_options[$font_option])) {
				$font_option_string = $eltd_options[$font_option].':'.$font_weight_str;
				if(!in_array($font_option_string, $fonts_array)) {
					$fonts_array[] = $font_option_string;
				}
			}
		}

		//add google fonts set in slider
		$args = array( 'post_type' => 'slides', 'posts_per_page' => -1);
		$loop = new WP_Query( $args );

		//for each slide defined
		while ( $loop->have_posts() ) : $loop->the_post();

			//is font family for title option chosen?
			if(get_post_meta(get_the_ID(), "eltd_slide-title-font-family", true) != "") {
				$slide_title_font_string = get_post_meta(get_the_ID(), "eltd_slide-title-font-family", true) . ":".$font_weight_str;
				if(!in_array($slide_title_font_string, $fonts_array)) {
					//include that font
					array_push($fonts_array, $slide_title_font_string);
				}
			}

			//is font family defined for slide's text?
			if(get_post_meta(get_the_ID(), "eltd_slide-text-font-family", true) != "") {
				$slide_text_font_string = get_post_meta(get_the_ID(), "eltd_slide-text-font-family", true) . ":".$font_weight_str;
				if(!in_array($slide_text_font_string, $fonts_array)) {
					//include that font
					array_push($fonts_array, $slide_text_font_string);
				}
			}

			//is font family defined for slide's subtitle?
			if(get_post_meta(get_the_ID(), "eltd_slide-subtitle-font-family", true) != "") {
				$slide_subtitle_font_string = get_post_meta(get_the_ID(), "eltd_slide-subtitle-font-family", true) .":".$font_weight_str;
				if(!in_array($slide_subtitle_font_string, $fonts_array)) {
					//include that font
					array_push($fonts_array, $slide_subtitle_font_string);
				}
			}
		endwhile;

		wp_reset_postdata();

        if($eltd_options['additional_google_fonts'] == 'yes'){

            if($eltd_options['additional_google_font1'] !== '-1'){
                array_push($fonts_array, $eltd_options['additional_google_font1'].":".$font_weight_str);
            }
            if($eltd_options['additional_google_font2'] !== '-1'){
                array_push($fonts_array, $eltd_options['additional_google_font2'].":".$font_weight_str);
            }
            if($eltd_options['additional_google_font3'] !== '-1'){
                array_push($fonts_array, $eltd_options['additional_google_font3'].":".$font_weight_str);
            }
            if($eltd_options['additional_google_font4'] !== '-1'){
                array_push($fonts_array, $eltd_options['additional_google_font4'].":".$font_weight_str);
            }
            if($eltd_options['additional_google_font5'] !== '-1'){
                array_push($fonts_array, $eltd_options['additional_google_font5'].":".$font_weight_str);
            }
        }

		$fonts_array = array_diff($fonts_array, array("-1:".$font_weight_str));
		$google_fonts_string = implode( '%7C', $fonts_array);

		$default_font_string = 'Open+Sans:'.$font_weight_str.'%7CRaleway:'.$font_weight_str.'%7CDancing+Script:'
            .$font_weight_str.'%7CLato:'.$font_weight_str;

		//is google font option checked anywhere in theme?
        if (count($fonts_array) > 0) {
            //include all checked fonts
            print("<link href='//fonts.googleapis.com/css?family=" . $default_font_string . "%7C" . str_replace('
            ', '+', $google_fonts_string) . urlencode('&subset=latin,latin-ext') . "' rel='stylesheet' type='text/css' />\r\n");
        } else {
            //include default google font that theme is using
            print("<link href='//fonts.googleapis.com/css?family=" . $default_font_string . urlencode('&subset=latin,latin-ext') ."' rel='stylesheet' type='text/css' />\r\n");
        }

    }

	add_action('wp_enqueue_scripts', 'eltd_google_fonts_styles');
}


if (!function_exists('eltd_scripts')) {
	/**
	 * Function that includes all necessary scripts
	 */
	function eltd_scripts() {
		global $eltd_options;
		global $eltd_toolbar;
        global $eltd_landing;
		global $wp_scripts;

		//init variables
		$smooth_scroll 	= true;
		$has_ajax 		= false;
		$eltd_animation = "";

		//is smooth scroll option turned on?
		if(isset($eltd_options['smooth_scroll']) && $eltd_options['smooth_scroll'] == "no"){
			$smooth_scroll = false;
		}

		//init theme core scripts
		wp_enqueue_script("jquery");
		wp_enqueue_script("eltd_plugins", ELTD_ROOT."/js/plugins.js",array(),false,true);
		wp_enqueue_script("carouFredSel", ELTD_ROOT."/js/jquery.carouFredSel-6.2.1.js",array(),false,true);
		wp_enqueue_script("one_page_scroll", ELTD_ROOT."/js/jquery.fullPage.min.js",array(),false,true);
		wp_enqueue_script("lemmonSlider", ELTD_ROOT."/js/lemmon-slider.js",array(),false,true);
		wp_enqueue_script("mousewheel", ELTD_ROOT."/js/jquery.mousewheel.min.js",array(),false,true);
		wp_enqueue_script("touchSwipe", ELTD_ROOT."/js/jquery.touchSwipe.min.js",array(),false,true);
		wp_enqueue_script("isotope", ELTD_ROOT."/js/jquery.isotope.min.js",array(),false,true);

	   //include google map api script
		wp_enqueue_script("google_map_api", "https://maps.googleapis.com/maps/api/js", array(), false, true);

        if (file_exists(dirname(__FILE__) ."/js/default_dynamic.js") && eltd_is_js_folder_writable() && !is_multisite()) {
            wp_enqueue_script("eltd_default_dynamic", ELTD_ROOT."/js/default_dynamic.js",array(), filemtime(dirname(__FILE__) ."/js/default_dynamic.js"),true);
        } else {
            wp_enqueue_script("eltd_default_dynamic", ELTD_ROOT."/js/default_dynamic.php", array(), false, true);
        }

        wp_enqueue_script("eltd_default", ELTD_ROOT."/js/default.min.js", array(), false, true);

		if(eltd_load_blog_assets()) {
			wp_enqueue_script('eltd_blog', ELTD_ROOT."/js/blog.min.js", array(), false, true);
		}

        if (file_exists(dirname(__FILE__) ."/js/custom_js.js") && eltd_is_js_folder_writable() && !is_multisite()) {
            wp_enqueue_script("eltd_custom_js", ELTD_ROOT."/js/custom_js.js",array(), filemtime(dirname(__FILE__) ."/js/custom_js.js"),true);
        } else {
            wp_enqueue_script("eltd_custom_js", ELTD_ROOT."/js/custom_js.php", array(), false, true);
        }

        //is smooth scroll enabled enabled and not Mac device?
        $mac_os = strpos($_SERVER['HTTP_USER_AGENT'], "Macintosh; Intel Mac OS X");
        if($smooth_scroll && $mac_os == false){
            wp_enqueue_script("TweenLite", ELTD_ROOT."/js/TweenLite.min.js",array(),false,true);
            wp_enqueue_script("ScrollToPlugin", ELTD_ROOT."/js/ScrollToPlugin.min.js",array(),false,true);
            wp_enqueue_script("smoothPageScroll", ELTD_ROOT."/js/smoothPageScroll.js",array(),false,true);
        }

		//include comment reply script
		$wp_scripts->add_data('comment-reply', 'group', 1 );
		if (is_singular()) {
			wp_enqueue_script( "comment-reply");
		}

		//is ajax set in session?
		if (isset($_SESSION['eltd_borderland_page_transitions'])) {
			$eltd_animation = $_SESSION['eltd_borderland_page_transitions'];
		}
		if (($eltd_options['page_transitions'] != "0") && (empty($eltd_animation) || ($eltd_animation != "no"))) {
			$has_ajax = true;
		} elseif (!empty($eltd_animation) && ($eltd_animation != "no"))
			$has_ajax = true;

		if ($has_ajax) {
			wp_enqueue_script("ajax", ELTD_ROOT."/js/ajax.min.js",array(),false,true);
		}

		//include Visual Composer script
		if (class_exists('WPBakeryVisualComposerAbstract')) {
			wp_enqueue_script( 'wpb_composer_front_js' );
		}

        //is landing enabled?
        if(isset($eltd_landing)) {
            wp_enqueue_script("eltd_landing_fancybox", get_home_url() . "/demo-files/landing/js/jquery.fancybox.js",array(),false,true);
			wp_enqueue_script("eltd_mixitup", get_home_url() . "/demo-files/landing/js/jquery.mixitup.min.js",array(),false,true);
            wp_enqueue_script("eltd_landing", get_home_url() . "/demo-files/landing/js/landing_default.js",array(),false,true);
        }

	}

	add_action('wp_enqueue_scripts', 'eltd_scripts');
}

if(!function_exists('eltd_browser_specific_scripts')) {
	/**
	 * Function that loads browser specific scripts
	 */
	function eltd_browser_specific_scripts() {
		global $is_IE;

		//is ie?
		if ($is_IE) {
			wp_enqueue_script("eltd_html5", ELTD_ROOT."/js/html5.js",array(),false,false);
		}
	}

	add_action('wp_enqueue_scripts', 'eltd_browser_specific_scripts');
}

if(!function_exists('eltd_woocommerce_assets')) {
	/**
	 * Function that includes all necessary scripts for WooCommerce if installed
	 */
	function eltd_woocommerce_assets() {
		global $eltd_options;

		//is woocommerce installed?
		if(eltd_is_woocommerce_installed()) {
			if(eltd_load_woo_assets()) {
				//get woocommerce specific scripts
				wp_enqueue_script("eltd_woocommerce_script", ELTD_ROOT . "/js/woocommerce.min.js", array(), false, true);
				wp_enqueue_script("eltd_select2", ELTD_ROOT . "/js/select2.min.js", array(), false, true);

				//include theme's woocommerce styles
				wp_enqueue_style("eltd_woocommerce", ELTD_ROOT . "/css/woocommerce.min.css");

				//is responsive option turned on?
				if ($eltd_options['responsiveness'] == 'yes') {
					//include theme's woocommerce responsive styles
					wp_enqueue_style("eltd_woocommerce_responsive", ELTD_ROOT . "/css/woocommerce_responsive.min.css");
				}
			}
		}
	}

	add_action('wp_enqueue_scripts', 'eltd_woocommerce_assets');
}

//defined content width variable
if (!isset( $content_width )) $content_width = 1060;

if (!function_exists('eltd_register_menus')) {
	/**
	 * Function that registers menu locations
	 */
	function eltd_register_menus() {
        global $eltd_options;

        if((isset($eltd_options['header_bottom_appearance']) && $eltd_options['header_bottom_appearance'] != "stick_with_left_right_menu") || (isset($eltd_options['vertical_area']) && $eltd_options['vertical_area'] == "yes")){
            //header and left menu location
            register_nav_menus(
                array('top-navigation' => __( 'Top Navigation', 'eltd')
                )
            );
        }

		//popup menu location
		register_nav_menus(
			array('popup-navigation' => __( 'Fullscreen Navigation', 'eltd')
			)
		);

        if((isset($eltd_options['header_bottom_appearance']) && $eltd_options['header_bottom_appearance'] == "stick_with_left_right_menu") && (isset($eltd_options['vertical_area']) && $eltd_options['vertical_area'] == "no")){
            //header left menu location
            register_nav_menus(
                array('left-top-navigation' => __( 'Left Top Navigation', 'eltd')
                )
            );

            //header right menu location
            register_nav_menus(
                array('right-top-navigation' => __( 'Right Top Navigation', 'eltd')
                )
            );
        }
	}

	add_action( 'after_setup_theme', 'eltd_register_menus' );
}

if(!function_exists('eltd_add_theme_support')) {
	/**
	 * Function that adds various features to theme. Also defines image sizes that are used in a theme
	 */
	function eltd_add_theme_support() {
		//add support for feed links
		add_theme_support( 'automatic-feed-links' );

		//add support for post formats
		add_theme_support('post-formats', array('gallery', 'link', 'quote', 'video', 'audio'));

		//add theme support for post thumbnails
		add_theme_support( 'post-thumbnails' );

        //add theme support for title tag
        if(function_exists('_wp_render_title_tag')) {
            add_theme_support('title-tag');
        }

		//define thumbnail sizes
		add_image_size( 'portfolio-square', 550, 550, true );
		add_image_size( 'portfolio-landscape', 800, 600, true );
		add_image_size( 'portfolio-portrait', 600, 800, true );
		add_image_size( 'portfolio_masonry_wide', 1000, 500, true );
		add_image_size( 'portfolio_masonry_tall', 500, 1000, true );
		add_image_size( 'portfolio_masonry_large', 1000, 1000, true );
		add_image_size( 'portfolio_masonry_with_space', 700);
		add_image_size( 'blog_image_format_link_quote', 1100, 500, true);

	}

	add_action('after_setup_theme', 'eltd_add_theme_support');
}

if (!function_exists('eltd_ajax_classes')) {
	/**
	 * Function that adds classes on body for ajax transitions
	 */
	function eltd_ajax_classes($classes) {
		global $eltd_options;

		//init variables
		$eltd_animation="";

		//is ajax set in session
		if (isset($_SESSION['eltd_animation'])) {
			$eltd_animation = $_SESSION['eltd_animation'];
		}

		//is ajax animation turned off in options or in session?
		if(($eltd_options['page_transitions'] === "0") && ($eltd_animation == "no")) {
			$classes[] = '';
		}

		//is up down animation type set?
		elseif($eltd_options['page_transitions'] === "1" && (empty($eltd_animation) || ($eltd_animation != "no"))) {
			$classes[] = 'ajax_updown';
			$classes[] = 'page_not_loaded';
		}

		//is fade animation type set?
		elseif($eltd_options['page_transitions'] === "2" && (empty($eltd_animation) || ($eltd_animation != "no"))) {
			$classes[] = 'ajax_fade';
			$classes[] = 'page_not_loaded';
		}

		//is up down fade animation type set?
		elseif($eltd_options['page_transitions'] === "3" && (empty($eltd_animation) || ($eltd_animation != "no"))) {
			$classes[] = 'ajax_updown_fade';
			$classes[] = 'page_not_loaded';
		}

		//is left / right animation type set?
		elseif($eltd_options['page_transitions'] === "4" && (empty($eltd_animation) || ($eltd_animation != "no"))) {
			$classes[] = 'ajax_leftright';
			$classes[] = 'page_not_loaded';
		}

		//is animation set only in session?
		elseif(!empty($eltd_animation) && $eltd_animation != "no") {
			$classes[] = 'page_not_loaded';
		}

		//animation is turned off both in options and in session
		else {
			$classes[] ="";
		}

		return $classes;
	}

	add_filter('body_class', 'eltd_ajax_classes');
}

if (!function_exists('eltd_boxed_class')) {
	/**
	 * Function that adds classes on body for boxed layout
	 */
	function eltd_boxed_class($classes) {
		global $eltd_options;

		//is boxed layout turned on?
		if(isset($eltd_options['boxed']) && $eltd_options['boxed'] == "yes" && isset($eltd_options['transparent_content']) && $eltd_options['transparent_content'] == 'no') {
			$classes[] = 'boxed';
		} else {
			$classes[] ="";
		}

		return $classes;
	}

	add_filter('body_class', 'eltd_boxed_class');
}

if (!function_exists('eltd_boxed_class')) {
	/**
	 * Function that adds classes on body for boxed layout
	 */
	function eltd_boxed_class($classes) {
		global $eltd_options;

		//is boxed layout turned on?
		if(isset($eltd_options['boxed']) && $eltd_options['boxed'] == "yes" && isset($eltd_options['transparent_content']) && $eltd_options['transparent_content'] == 'no') {
			$classes[] = 'boxed';
		} else {
			$classes[] ="";
		}

		return $classes;
	}

	add_filter('body_class', 'eltd_boxed_class');
}



if(!function_exists('eltd_rgba_color')) {
    /**
     * Function that generates rgba part of css color property
     * @param $color string hex color
     * @param $transparency float transparency value between 0 and 1
     * @return string generated rgba string
     */
    function eltd_rgba_color($color, $transparency) {
        if($color !== '' && $transparency !== '') {
            $rgba_color = '';

            $rgb_color_array = eltd_hex2rgb($color);
            $rgba_color .= 'rgba('.implode(', ', $rgb_color_array).', '.$transparency.')';

            return $rgba_color;
        }
    }
}



if (!function_exists('eltd_theme_version_class')) {
	/**
	 * Function that adds classes on body for version of theme
	 */
	function eltd_theme_version_class($classes) {
        $current_theme = wp_get_theme();

        //is child theme activated?
        if($current_theme->parent()) {
            //add child theme version
            $classes[] = strtolower($current_theme->get('Name')).'-child-ver-'.$current_theme->get('Version');

            //get parent theme
            $current_theme = $current_theme->parent();
        }

        if($current_theme->exists() && $current_theme->get('Version') != "") {
            $classes[] = strtolower($current_theme->get('Name')).'-ver-'.$current_theme->get('Version');
        }

        return $classes;
	}

	add_filter('body_class', 'eltd_theme_version_class');
}

if (!function_exists('eltd_vertical_menu_class')) {
	/**
	 * Function that adds classes on body element for left menu area
	 */
	function eltd_vertical_menu_class($classes) {
		global $eltd_options;
		global $wp_query;

		//is left menu area turned on?
		if(isset($eltd_options['vertical_area']) && $eltd_options['vertical_area'] =='yes') {
			$classes[] = 'vertical_menu_enabled';

            //left menu type class?
            if(isset($eltd_options['vertical_area_type']) && $eltd_options['vertical_area_type'] != '') {
                switch ($eltd_options['vertical_area_type']) {
                    case 'hidden':
                        $classes[] = ' vertical_menu_hidden';

						if(isset($eltd_options['vertical_logo_bottom']) && $eltd_options['vertical_logo_bottom'] !== '') {
							$classes[] = 'vertical_menu_hidden_with_logo';
						}
                        break;
						
					 case 'hidden_with_icons':
                        $classes[] = ' vertical_menu_hidden vertical_menu_hidden_with_icons';

						if(isset($eltd_options['vertical_logo_bottom']) && $eltd_options['vertical_logo_bottom'] !== '') {
							$classes[] = 'vertical_menu_hidden_with_logo';
						}
                        break;
                }
            }

			if(isset($eltd_options['vertical_area_position'])){
				if($eltd_options['vertical_area_position'] == 'right'){
					$classes[] = ' vertical_menu_right';
				}elseif($eltd_options['vertical_area_position'] == 'left'){
					$classes[] = ' vertical_menu_left';
				}				
			}  
			
			if(isset($eltd_options['vertical_area_width']) && $eltd_options['vertical_area_width']=='width_350'){
				 $classes[] = ' vertical_menu_width_350';
			} 
			elseif(isset($eltd_options['vertical_area_width']) && $eltd_options['vertical_area_width']=='width_400'){
				 $classes[] = ' vertical_menu_width_400';
			} 
			else{
				$classes[] = ' vertical_menu_width_290';
			}
		}

		//get current page id
		$id = $wp_query->get_queried_object_id();

		if(eltd_is_woocommerce_page()) {
			$id = get_option('woocommerce_shop_page_id');
		}

		if(isset($eltd_options['vertical_area_transparency']) && $eltd_options['vertical_area_transparency'] =='yes' && get_post_meta($id, "eltd_page_vertical_area_transparency", true) != "no" && isset($eltd_options['vertical_area_dropdown_showing']) && $eltd_options['vertical_area_dropdown_showing'] != "side"){
			$classes[] = ' vertical_menu_transparency vertical_menu_transparency_on';
		}else if(get_post_meta($id, "eltd_page_vertical_area_transparency", true) == "yes" && isset($eltd_options['vertical_area_dropdown_showing']) && $eltd_options['vertical_area_dropdown_showing'] != "side"){
			$classes[] = ' vertical_menu_transparency vertical_menu_transparency_on';
		}
		
		if(isset($eltd_options['vertical_area_background_transparency']) && $eltd_options['vertical_area_background_transparency'] !=='' && $eltd_options['vertical_area_background_transparency'] !=='1' && get_post_meta($id, "eltd_page_vertical_area_background_opacity", true) == "" && isset($eltd_options['vertical_area_dropdown_showing']) && $eltd_options['vertical_area_dropdown_showing'] != "side" && isset($eltd_options['vertical_menu_inside_paspartu']) && $eltd_options['vertical_menu_inside_paspartu'] == 'yes'){
			$classes[] = 'vertical_menu_background_opacity';
		}else if(get_post_meta($id, "eltd_page_vertical_area_background_opacity", true) !== "" && get_post_meta($id, "eltd_page_vertical_area_background_opacity", true) !== "1" && isset($eltd_options['vertical_area_dropdown_showing']) && $eltd_options['vertical_area_dropdown_showing'] != "side"){
			$classes[] = ' vertical_menu_background_opacity';
		}

		if(isset($eltd_options['vertical_area_dropdown_showing']) && $eltd_options['vertical_area_dropdown_showing'] != "to_content"){
			$classes[] = ' vertical_menu_with_scroll';
		}

		
		return $classes;
	}

	add_filter('body_class', 'eltd_vertical_menu_class');
}

if (!function_exists('eltd_smooth_scroll_class')) {
    /**
     * Function that adds classes on body for smooth scroll
     */
    function eltd_smooth_scroll_class($classes) {
        global $eltd_options;

        //is smooth_scroll turned on?
        if(isset($eltd_options['smooth_scroll']) && $eltd_options['smooth_scroll'] == "yes") {
            $classes[] = 'smooth_scroll';
        } else {
            $classes[] ="";
        }

        return $classes;
    }

    add_filter('body_class', 'eltd_smooth_scroll_class');
}

if(!function_exists('eltd_wp_title_text')) {
	/**
	 * Function that sets page's title. Hooks to wp_title filter
	 * @param $title string current page title
	 * @param $sep string title separator
	 * @return string changed title text if SEO plugins aren't installed
	 */
	function eltd_wp_title_text($title, $sep) {
		global $eltd_options;

		//is SEO plugin installed?
		if(eltd_seo_plugin_installed()) {
			//don't do anything, seo plugin will take care of it
		} else {
			//get current post id
            $id = eltd_get_page_id();
			$sep = ' | ';
			$title_prefix = get_bloginfo('name');
			$title_suffix = '';

			//is WooCommerce installed and is current page shop page?
			if(eltd_is_woocommerce_installed() && eltd_is_woocommerce_shop()) {
				//get shop page id
				$id = eltd_get_woo_shop_page_id();
			}

            //is WP 4.1 at least?
            if(function_exists('_wp_render_title_tag')) {
                //set unchanged title variable so we can use it later
                $title_array = explode($sep, $title);
                $unchanged_title = array_shift($title_array);
            }

            //pre 4.1 version of WP
            else {
                //set unchanged title variable so we can use it later
                $unchanged_title = $title;
            }

			//is eltd seo enabled?
			if(isset($eltd_options['disable_eltd_seo']) && $eltd_options['disable_eltd_seo'] !== 'yes') {
				//get current post seo title
				$seo_title = esc_attr(get_post_meta($id, "seo_title", true));

				//is current post seo title set?
				if($seo_title !== '') {
					$title_suffix = $seo_title;
				}
			}

			//title suffix is empty, which means that it wasn't set by eltd seo
			if(empty($title_suffix)) {
				//if current page is front page append site description, else take original title string
				$title_suffix = is_front_page() ? get_bloginfo('description') : $unchanged_title;
			}

			//concatenate title string
			$title  = $title_prefix.$sep.$title_suffix;

			//return generated title string
			return $title;
		}
	}

	add_filter('wp_title', 'eltd_wp_title_text', 10, 2);
}

if(!function_exists('eltd_wp_title')) {
    /**
     * Function that outputs title tag. It checks if _wp_render_title_tag function exists
     * and if it does'nt it generates output. Compatible with versions of WP prior to 4.1
     */
    function eltd_wp_title() {
        if(!function_exists('_wp_render_title_tag')) { ?>
            <title><?php wp_title(''); ?></title>
        <?php }
    }
}

if(!function_exists('eltd_ajax_meta')) {
	/**
	 * Function that echoes meta data for ajax
	 *
	 * @since 4.3
	 * @version 0.2
	 */
	function eltd_ajax_meta() {
		global $eltd_options;
		
		$seo_description = get_post_meta(eltd_get_page_id(), "seo_description", true);
		$seo_keywords = get_post_meta(eltd_get_page_id(), "seo_keywords", true);
		?>

        <div class="seo_title"><?php wp_title('|', true, 'right'); ?></div>

		<?php if($seo_description !== ''){ ?>
			<div class="seo_description"><?php echo esc_html($seo_description); ?></div>
		<?php } else if($eltd_options['meta_description']){?>
			<div class="seo_description"><?php echo esc_html($eltd_options['meta_description']); ?></div>
		<?php } ?>
		<?php if($seo_keywords !== ''){ ?>
			<div class="seo_keywords"><?php echo esc_html($seo_keywords); ?></div>
		<?php }else if($eltd_options['meta_keywords']){?>
			<div class="seo_keywords"><?php echo esc_html($eltd_options['meta_keywords']); ?></div>
		<?php }
	}

	add_action('eltd_ajax_meta', 'eltd_ajax_meta');
}

if(!function_exists('eltd_header_meta')) {
	/**
	 * Function that echoes meta data if our seo is enabled
	 */
	function eltd_header_meta() {
		global $eltd_options;
		
		if(isset($eltd_options['disable_eltd_seo']) && $eltd_options['disable_eltd_seo'] == 'no') {
			$seo_description = get_post_meta(eltd_get_page_id(), "seo_description", true);
			$seo_keywords = get_post_meta(eltd_get_page_id(), "seo_keywords", true);
			?>

			<?php if($seo_description) { ?>
				<meta name="description" content="<?php echo esc_html($seo_description); ?>">
			<?php } else if($eltd_options['meta_description']){ ?>
				<meta name="description" content="<?php echo esc_html($eltd_options['meta_description']) ?>">
			<?php } ?>

			<?php if($seo_keywords) { ?>
				<meta name="keywords" content="<?php echo esc_html($seo_keywords); ?>">
			<?php } else if($eltd_options['meta_keywords']){ ?>
				<meta name="keywords" content="<?php echo esc_html($eltd_options['meta_keywords']) ?>">
			<?php }
		} ?>

        <meta charset="<?php bloginfo( 'charset' ); ?>" />
        <?php
        if (isset($_SERVER['HTTP_USER_AGENT']) && (strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false))
            echo('<meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible">');
        ?>

        <link rel="profile" href="http://gmpg.org/xfn/11" />
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
        <link rel="shortcut icon" type="image/x-icon" href="<?php echo esc_url($eltd_options['favicon_image']); ?>">
        <link rel="apple-touch-icon" href="<?php echo esc_url($eltd_options['favicon_image']); ?>"/>
	<?php }

	add_action('eltd_header_meta', 'eltd_header_meta');
}

if(!function_exists('eltd_user_scalable_meta')) {
    /**
     * Function that outputs user scalable meta if responsiveness is turned on
     * Hooked to eltd_header_meta action
     */
    function eltd_user_scalable_meta() {
        global $eltd_options;

        //is responsiveness option is chosen?
        $responsiveness = "yes";
        if (isset($eltd_options['responsiveness'])) $responsiveness = $eltd_options['responsiveness'];

        if ($responsiveness == "yes") { ?>
            <meta name="viewport" content="width=device-width,initial-scale=1,user-scalable=no">
        <?php }	else { ?>
            <meta name="viewport" content="width=1200,user-scalable=no">
        <?php }
    }

    add_action('eltd_header_meta', 'eltd_user_scalable_meta');
}

if(!function_exists('eltd_get_page_id')) {
	/**
	 * Function that returns current page / post id.
	 * Checks if current page is woocommerce page and returns that id if it is.
	 * Checks if current page is any archive page (category, tag, date, author etc.) and returns -1 because that isn't
	 * page that is created in WP admin.
	 *
	 * @return int
	 *
	 * @version 0.1
	 *
	 * @see eltd_is_woocommerce_installed()
	 * @see eltd_is_woocommerce_shop()
	 */
	function eltd_get_page_id() {
		if(eltd_is_woocommerce_installed() && (eltd_is_woocommerce_shop() || is_singular('product'))){
			return eltd_get_woo_shop_page_id();
		}

		if(is_archive() || is_search() || is_404()) {
			return -1;
		}

		return get_queried_object_id();
	}
}



if (!function_exists('eltd_elements_animation_on_touch_class')) {
	/**
	 * Function that adds classes on body when touch is disabled on touch devices
	 * @param $classes array classes array
	 * @return array array with added classes
	 */
	function eltd_elements_animation_on_touch_class($classes) {
		global $eltd_options;

		//check if current client is on mobile
		$isMobile = (bool)preg_match('#\b(ip(hone|od|ad)|android|opera m(ob|in)i|windows (phone|ce)|blackberry|tablet'.
			'|s(ymbian|eries60|amsung)|p(laybook|alm|rofile/midp|laystation portable)|nokia|fennec|htc[\-_]'.
			'|mobile|up\.browser|[1-4][0-9]{2}x[1-4][0-9]{2})\b#i', $_SERVER['HTTP_USER_AGENT'] );

		//are animations turned off on touch and client is on mobile?
		if(isset($eltd_options['elements_animation_on_touch']) && $eltd_options['elements_animation_on_touch'] == "no" && $isMobile == true) {
			$classes[] = 'no_animation_on_touch';
		} else {
			$classes[] ="";
		}

		return $classes;
	}

	add_filter('body_class', 'eltd_elements_animation_on_touch_class');
}

if(!function_exists('eltd_side_menu_body_class')) {
	/**
	 * Function that adds body classes for different side menu styles
	 * @param $classes array original array of body classes
	 * @return array modified array of classes
	 */
    function eltd_side_menu_body_class($classes) {
            global $eltd_options;

            if(isset($eltd_options['enable_side_area']) && $eltd_options['enable_side_area'] == 'yes') {
                if(isset($eltd_options['side_area_type']) && $eltd_options['side_area_type'] == 'side_menu_slide_from_right') {
                    $classes[] = 'side_menu_slide_from_right';
				}

                else if(isset($eltd_options['side_area_type']) && $eltd_options['side_area_type'] == 'side_menu_slide_with_content') {
                    $classes[] = 'side_menu_slide_with_content';
                    $classes[] = $eltd_options['side_area_slide_with_content_width'];
			   }
        }

        return $classes;
    }

    add_filter('body_class', 'eltd_side_menu_body_class');
}

if(!function_exists('eltd_full_screen_menu_body_class')) {
    /**
     * Function that adds body classes for different full screen menu types
     * @param $classes array original array of body classes
     * @return array modified array of classes
     */
    function eltd_full_screen_menu_body_class($classes) {
        global $eltd_options;

        if(isset($eltd_options['enable_popup_menu']) && $eltd_options['enable_popup_menu'] == 'yes') {
            if(isset($eltd_options['popup_menu_animation_style'])) {
                $classes[] = $eltd_options['popup_menu_animation_style'];
            }
        }

        return $classes;
    }

    add_filter('body_class', 'eltd_full_screen_menu_body_class');
}

if(!function_exists('eltd_paspartu_body_class')) {
    /**
    * Function that adds paspartu class to body.
    * @param $classes array of body classes
    * @return array with paspartu body class added
    */
    function eltd_paspartu_body_class($classes) {
        global $eltd_options;

        if(isset($eltd_options['paspartu']) && $eltd_options['paspartu'] == 'yes') {
			$classes[] = 'paspartu_enabled';
			
			if((isset($eltd_options['paspartu_on_top']) && $eltd_options['paspartu_on_top'] == 'yes' && isset($eltd_options['paspartu_on_top_fixed']) && $eltd_options['paspartu_on_top_fixed'] == 'yes') || 
			(isset($eltd_options['vertical_area']) && $eltd_options['vertical_area'] == 'yes' && isset($eltd_options['vertical_menu_inside_paspartu']) && $eltd_options['vertical_menu_inside_paspartu'] == 'yes')) {
				$classes[] = 'paspartu_on_top_fixed';
			}
			
			if((isset($eltd_options['paspartu_on_bottom_fixed']) && $eltd_options['paspartu_on_bottom_fixed'] == 'yes') || 
			(isset($eltd_options['vertical_area']) && $eltd_options['vertical_area'] == 'yes' && isset($eltd_options['vertical_menu_inside_paspartu']) && $eltd_options['vertical_menu_inside_paspartu'] == 'yes')) {
				$classes[] = 'paspartu_on_bottom_fixed';
			}
			
			if(isset($eltd_options['vertical_area']) && $eltd_options['vertical_area'] =='yes' && isset($eltd_options['vertical_menu_inside_paspartu']) && $eltd_options['vertical_menu_inside_paspartu'] == 'no') {
				$classes[] = 'vertical_menu_outside_paspartu';
			}
			
			if(isset($eltd_options['vertical_area']) && $eltd_options['vertical_area'] =='yes' && isset($eltd_options['vertical_menu_inside_paspartu']) && $eltd_options['vertical_menu_inside_paspartu'] == 'yes') {
				$classes[] = 'vertical_menu_inside_paspartu';
			}
        }

        return $classes;
    }

    add_filter('body_class', 'eltd_paspartu_body_class');
}

if(!function_exists('eltd_transparent_content_body_class')) {
    /**
     * Function that adds transparent content class to body.
     * @param $classes array of body classes
     * @return array with transparent content body class added
     */
    function eltd_transparent_content_body_class($classes) {
        global $eltd_options;

        if(isset($eltd_options['transparent_content']) && $eltd_options['transparent_content'] == 'yes') {
            $classes[] = 'transparent_content';
        }

        return $classes;
    }

    add_filter('body_class', 'eltd_transparent_content_body_class');
}

if(!function_exists('eltd_overlapping_content_body_class')) {
    /**
     * Function that adds transparent content class to body.
     * @param $classes array of body classes
     * @return array with transparent content body class added
     */
    function eltd_overlapping_content_body_class($classes) {
        global $eltd_options;

        if(isset($eltd_options['overlapping_content']) && $eltd_options['overlapping_content'] == 'yes') {
            $classes[] = 'overlapping_content';
        }

        return $classes;
    }

    add_filter('body_class', 'eltd_overlapping_content_body_class');
}

if(!function_exists('eltd_content_initial_width_body_class')) {
    /**
     * Function that adds transparent content class to body.
     * @param $classes array of body classes
     * @return array with transparent content body class added
     */
    function eltd_content_initial_width_body_class($classes) {
        global $eltd_options;

        if(isset($eltd_options['content_predefined_width']) && $eltd_options['content_predefined_width'] !== '') {
            $classes[] = $eltd_options['content_predefined_width'];
        }

        return $classes;
    }

    add_filter('body_class', 'eltd_content_initial_width_body_class');
}

if(!function_exists('eltd_hide_initial_sticky_body_class')) {
    /**
     * Function that adds hidden initial sticky class to body.
     * @param $classes array of body classes
     * @return hidden initial sticky body class
     */
    function eltd_hide_initial_sticky_body_class($classes) {
        global $eltd_options;

        if(isset($eltd_options['header_bottom_appearance']) && ($eltd_options['header_bottom_appearance'] == "stick" || $eltd_options['header_bottom_appearance'] == "stick menu_bottom" || $eltd_options['header_bottom_appearance'] == "stick_with_left_right_menu")){
			if(get_post_meta(eltd_get_page_id(), "eltd_page_hide_initial_sticky", true) !== ''){
				if(get_post_meta(eltd_get_page_id(), "eltd_page_hide_initial_sticky", true) == 'yes'){
					$classes[] = 'hide_inital_sticky';
				}
			}else if(isset($eltd_options['hide_initial_sticky']) && $eltd_options['hide_initial_sticky'] == 'yes') {
				$classes[] = 'hide_inital_sticky';
			}
        }

        return $classes;
    }

    add_filter('body_class', 'eltd_hide_initial_sticky_body_class');
}

if(!function_exists('eltd_set_logo_sizes')) {
	/**
	 * Function that sets logo image dimensions to global eltd options array so it can be used in the theme
	 */
	function eltd_set_logo_sizes() {
		global $eltd_options;

		if (isset($eltd_options['logo_image'])){
			//get logo image size
			$logo_image_sizes = eltd_get_image_dimensions($eltd_options['logo_image']);
			$eltd_options['logo_width'] = 280;
			$eltd_options['logo_height'] = 130;
	
			//is image width and height set?
			if(isset($logo_image_sizes['width']) && isset($logo_image_sizes['height'])) {
				//set those variables in global array
				$eltd_options['logo_width'] = $logo_image_sizes['width'];
				$eltd_options['logo_height'] = $logo_image_sizes['height'];
			}
		}
	}

	add_action('init', 'eltd_set_logo_sizes', 0);
}


if(!function_exists('eltd_is_default_wp_template')) {
	/**
	 * Function that checks if current page archive page, search, 404 or default home blog page
	 * @return bool
	 *
	 * @see is_archive()
	 * @see is_search()
	 * @see is_404()
	 * @see is_front_page()
	 * @see is_home()
	 */
	function eltd_is_default_wp_template() {
		return is_archive() || is_search() || is_404() || (is_front_page() && is_home());
	}
}

if(!function_exists('eltd_get_page_template_name')) {
	/**
	 * Returns current template file name without extension
	 * @return string name of current template file
	 */
	function eltd_get_page_template_name() {
		$file_name = '';

		if(!eltd_is_default_wp_template()) {
			$file_name_without_ext = preg_replace('/\\.[^.\\s]{3,4}$/', '', basename(get_page_template()));

			if($file_name_without_ext !== '') {
				$file_name = $file_name_without_ext;
			}
		}

		return $file_name;
	}
}

if(!function_exists('eltd_is_main_menu_set')) {
    /**
     * Function that checks if any of main menu locations are set.
     * Checks whether top-navigation location is set, or left-top-navigation and right-top-navigation is set
     * @return bool
     *
     * @version 0.1
     */
    function eltd_is_main_menu_set() {
        $has_top_nav = has_nav_menu('top-navigation');
        $has_divided_nav = has_nav_menu('left-top-navigation') && has_nav_menu('right-top-navigation');

        return $has_top_nav || $has_divided_nav;
    }
}

if(!function_exists('eltd_has_shortcode')) {
	/**
	 * Function that checks whether shortcode exists on current page / post
	 * @param string shortcode to find
	 * @param string content to check. If isn't passed current post content will be used
	 * @return bool whether content has shortcode or not
	 */
	function eltd_has_shortcode($shortcode, $content = '')
	{
		$has_shortcode = false;

		if ($shortcode) {
			//if content variable isn't past
			if ($content == '') {
				//take content from current post
				$page_id = eltd_get_page_id();
				if (!empty($page_id)) {
					$current_post = get_post($page_id);

					if (is_object($current_post) && property_exists($current_post, 'post_content')) {
						$content = $current_post->post_content;
					}

				}
			}

			//does content has shortcode added?
			if (stripos($content, '[' . $shortcode) !== false) {
				$has_shortcode = true;
			}
		}

		return $has_shortcode;
	}
}

if(!function_exists('eltd_is_ajax')) {
    /**
     * Function that checks if current request is ajax request
     * @return bool whether it's ajax request or not
     *
     * @version 0.1
     */
    function eltd_is_ajax() {
        return !empty( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ]) && strtolower( $_SERVER[ 'HTTP_X_REQUESTED_WITH' ]) == 'xmlhttprequest';
    }
}

if(!function_exists('eltd_localize_no_ajax_pages')) {
    /**
     * Function that outputs no_ajax_obj javascript variable that is used default_dynamic.php.
     * It is used for no ajax pages functionality
     *
     * Function hooks to wp_enqueue_scripts and uses wp_localize_script
     *
     * @see http://codex.wordpress.org/Function_Reference/wp_localize_script
     *
     * @uses eltd_get_posts_without_ajax()
     * @uses eltd_get_pages_without_ajax()
     * @uses eltd_get_wpml_pages_for_current_page()
     * @uses eltd_get_woocommerce_pages()
     *
     * @version 0.1
     */
    function eltd_localize_no_ajax_pages() {
        global $eltd_options;

        //is ajax enabled?
        if(eltd_is_ajax_enabled()) {
            $no_ajax_pages = array();

            //get posts that have ajax disabled and merge with main array
            $no_ajax_pages = array_merge($no_ajax_pages, eltd_get_objects_without_ajax());

            //is wpml installed?
            if(eltd_is_wpml_installed()) {
                //get translation pages for current page and merge with main array
                $no_ajax_pages = array_merge($no_ajax_pages, eltd_get_wpml_pages_for_current_page());
            }

            //is woocommerce installed?
            if(eltd_is_woocommerce_installed()) {
                //get all woocommerce pages and products and merge with main array
                $no_ajax_pages = array_merge($no_ajax_pages, eltd_get_woocommerce_pages());
            }

            //do we have some internal pages that won't to be without ajax?
            if (isset($eltd_options['internal_no_ajax_links'])) {
                //get array of those pages
                $options_no_ajax_pages_array = explode(',', $eltd_options['internal_no_ajax_links']);

                if(is_array($options_no_ajax_pages_array) && count($options_no_ajax_pages_array)) {
                    $no_ajax_pages = array_merge($no_ajax_pages, $options_no_ajax_pages_array);
                }
            }

            //add logout url to main array
            $no_ajax_pages[] = htmlspecialchars_decode(wp_logout_url());

            //finally localize script so we can use it in default_dynamic
            wp_localize_script( 'eltd_default_dynamic', 'no_ajax_obj', array(
                'no_ajax_pages' => $no_ajax_pages
            ));
        }
    }

    add_action('wp_enqueue_scripts', 'eltd_localize_no_ajax_pages');
}

if(!function_exists('eltd_get_objects_without_ajax')) {
    /**
     * Function that returns urls of objects that have ajax disabled.
     * Works for posts, pages and portfolio pages.
     * @return array array of urls of posts that have ajax disabled
     *
     * @version 0.1
     */
    function eltd_get_objects_without_ajax() {
        $posts_without_ajax = array();

        $posts_args =  array(
            'post_type'  => array('post', 'portfolio_page', 'page'),
            'post_status' => 'publish',
            'meta_key' => 'eltd_show-animation',
            'meta_value' => 'no_animation'
        );

        $posts_query = new WP_Query($posts_args);

        if($posts_query->have_posts()) {
            while($posts_query->have_posts()) {
                $posts_query->the_post();
                $posts_without_ajax[] = get_permalink(get_the_ID());
            }
        }

        wp_reset_postdata();

        return $posts_without_ajax;
    }
}

if(!function_exists('eltd_is_ajax_enabled')) {
    /**
     * Function that checks if ajax is enabled.
     * @return bool
     *
     * @version 0.1
     */
    function eltd_is_ajax_enabled() {
        global $eltd_options;

        $has_ajax = false;

        if(isset($eltd_options['page_transitions']) && $eltd_options['page_transitions'] !== '0') {
            $has_ajax = true;
        }

        return $has_ajax;
    }
}

if(!function_exists('eltd_is_ajax_header_animation_enabled')) {
    /**
     * Function that checks if header animation with ajax is enabled.
     * @return boolean
     *
     * @version 0.1
     */
    function eltd_is_ajax_header_animation_enabled() {
        global $eltd_options;

        $has_header_animation = false;

        if(isset($eltd_options['page_transitions']) && $eltd_options['page_transitions'] !== '0' && isset($eltd_options['ajax_animate_header']) && $eltd_options['ajax_animate_header'] == 'yes') {
            $has_header_animation = true;
        }

        return $has_header_animation;
    }
}

if(!function_exists('eltd_maintenance_mode')) {
    /**
     * Function that redirects user to desired landing page if maintenance mode is turned on in options
     */
    function eltd_maintenance_mode() {
        global $eltd_options;

        $protocol = is_ssl() ? "https://" : "http://";
        if(isset($eltd_options['eltd_maintenance_mode']) && $eltd_options['eltd_maintenance_mode'] == 'yes' && isset($eltd_options['eltd_maintenance_page']) && $eltd_options['eltd_maintenance_page'] != ""
            && !in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))
            && !is_admin()
            && !is_user_logged_in()
            && $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'] != get_permalink($eltd_options['eltd_maintenance_page'])
        ) {

            wp_redirect(get_permalink($eltd_options['eltd_maintenance_page']));
            exit;
        }
    }
}

if(!function_exists('eltd_initial_maintenance')) {
    /**
     * Function that initalize maintenance function
     */
    function eltd_initial_maintenance() {
        global $eltd_options;

	    if(isset($eltd_options['eltd_maintenance_mode']) && $eltd_options['eltd_maintenance_mode'] == 'yes') {
	        add_action('init', 'eltd_maintenance_mode', 2);
	    }
	}

    add_action('init', 'eltd_initial_maintenance', 1);
}

if(!function_exists('eltd_horizontal_slider_icon_classes')) {
	/**
	 * Returns classes for left and right arrow for sliders
	 *
	 * @param $icon_class
	 * @return array
	 */
	function eltd_horizontal_slider_icon_classes($icon_class) {

		switch($icon_class) {
			case 'arrow_carrot-left_alt2':
				$left_icon_class = 'arrow_carrot-left_alt2';
				$right_icon_class = 'arrow_carrot-right_alt2';
				break;
			case 'arrow_carrot-2left_alt2':
				$left_icon_class = 'arrow_carrot-2left_alt2';
				$right_icon_class = 'arrow_carrot-2right_alt2';
				break;
			case 'arrow_triangle-left_alt2':
				$left_icon_class = 'arrow_triangle-left_alt2';
				$right_icon_class = 'arrow_triangle-right_alt2';
				break;
			case 'icon-arrows-drag-left-dashed':
				$left_icon_class = 'icon-arrows-drag-left-dashed';
				$right_icon_class = 'icon-arrows-drag-right-dashed';
				break;
			case 'icon-arrows-drag-left-dashed':
				$left_icon_class = 'icon-arrows-drag-left-dashed';
				$right_icon_class = 'icon-arrows-drag-right-dashed';
				break;
			case 'icon-arrows-left-double-32':
				$left_icon_class = 'icon-arrows-left-double-32';
				$right_icon_class = 'icon-arrows-right-double';
				break;
			case 'icon-arrows-slide-left1':
				$left_icon_class = 'icon-arrows-slide-left1';
				$right_icon_class = 'icon-arrows-slide-right1';
				break;
			case 'icon-arrows-slide-left2':
				$left_icon_class = 'icon-arrows-slide-left2';
				$right_icon_class = 'icon-arrows-slide-right2';
				break;
			case 'icon-arrows-slim-left-dashed':
				$left_icon_class = 'icon-arrows-slim-left-dashed';
				$right_icon_class = 'icon-arrows-slim-right-dashed';
				break;
			case 'ion-arrow-left-a':
				$left_icon_class = 'ion-arrow-left-a';
				$right_icon_class = 'ion-arrow-right-a';
				break;
			case 'ion-arrow-left-b':
				$left_icon_class = 'ion-arrow-left-b';
				$right_icon_class = 'ion-arrow-right-b';
				break;
			case 'ion-arrow-left-c':
				$left_icon_class = 'ion-arrow-left-c';
				$right_icon_class = 'ion-arrow-right-c';
				break;
			case 'ion-ios-arrow-':
				$left_icon_class = $icon_class.'back';
				$right_icon_class = $icon_class.'forward';
				break;
			case 'ion-ios-fastforward':
				$left_icon_class = 'ion-ios-rewind';
				$right_icon_class = 'ion-ios-fastforward';
				break;
			case 'ion-ios-fastforward-outline':
				$left_icon_class = 'ion-ios-rewind-outline';
				$right_icon_class = 'ion-ios-fastforward-outline';
				break;
			case 'ion-ios-skipbackward':
				$left_icon_class = 'ion-ios-skipbackward';
				$right_icon_class = 'ion-ios-skipforward';
				break;
			case 'ion-ios-skipbackward-outline':
				$left_icon_class = 'ion-ios-skipbackward-outline';
				$right_icon_class = 'ion-ios-skipforward-outline';
				break;
			case 'ion-android-arrow-':
				$left_icon_class = $icon_class.'back';
				$right_icon_class = $icon_class.'forward';
				break;
			case 'ion-android-arrow-dropleft-circle':
				$left_icon_class = 'ion-android-arrow-dropleft-circle';
				$right_icon_class = 'ion-android-arrow-dropright-circle';
				break;
			default:
				$left_icon_class = $icon_class.'left';
				$right_icon_class = $icon_class.'right';
		}

		$icon_classes = array(
			'left_icon_class' => $left_icon_class,
			'right_icon_class' => $right_icon_class
		);

    	return $icon_classes;

	}

}

if(!function_exists('eltd_get_side_menu_icon_html')) {
	/**
	 * Function that outputs html for side area icon opener.
	 * Uses $eltdIconCollections global variable
	 * @return string generated html
	 */
	function eltd_get_side_menu_icon_html() {
		global $eltdIconCollections, $eltd_options;

		$icon_html = '';

		if(isset($eltd_options['side_area_button_icon_pack']) && $eltd_options['side_area_button_icon_pack'] !== '') {
			$icon_pack = $eltd_options['side_area_button_icon_pack'];
			if ($icon_pack !== '') {
				$icon_collection_obj = $eltdIconCollections->getIconCollection($icon_pack);
				$icon_field_name = 'side_area_icon_'. $icon_collection_obj->param;

				if(isset($eltd_options[$icon_field_name]) && $eltd_options[$icon_field_name] !== ''){
					$icon_single = $eltd_options[$icon_field_name];

					if (method_exists($icon_collection_obj, 'render')) {
						$icon_html = $icon_collection_obj->render($icon_single);
					}
				}
			}
		}

		return $icon_html;
	}
}

if(!function_exists('eltd_rewrite_rules_on_theme_activation')) {
	/**
	 * Function that flushes rewrite rules on deactivation
	 */
	function eltd_rewrite_rules_on_theme_activation() {
		flush_rewrite_rules();
	}

	add_action( 'after_switch_theme', 'eltd_rewrite_rules_on_theme_activation' );
}

if (!function_exists('eltd_vc_grid_elements_enabled')) {

	/**
	 * Function that checks if Visual Composer Grid Elements are enabled
	 *
	 * @return bool
	 */
	function eltd_vc_grid_elements_enabled() {

		global $eltd_options;
		$vc_grid_enabled = false;

		if (isset($eltd_options['enable_grid_elements']) && $eltd_options['enable_grid_elements'] == 'yes') {

			$vc_grid_enabled = true;

		}

		return $vc_grid_enabled;

	}

}

if(!function_exists('eltd_visual_composer_grid_elements')) {

	/**
	 * Removes Visual Composer Grid Elements post type if VC Grid option disabled
	 * and enables Visual Composer Grid Elements post type
	 * if VC Grid option enabled
	 */
	function eltd_visual_composer_grid_elements() {

		if(!eltd_vc_grid_elements_enabled()){

			remove_action( 'init', 'vc_grid_item_editor_create_post_type' );

		}
	}

	add_action('vc_after_init', 'eltd_visual_composer_grid_elements', 12);
}

if(!function_exists('eltd_grid_elements_ajax_disable')) {
	/**
	 * Function that disables ajax transitions if grid elements are enabled in theme options
	 */
	function eltd_grid_elements_ajax_disable() {
		global $eltd_options;

		if(eltd_vc_grid_elements_enabled()) {
			$eltd_options['page_transitions'] = '0';
		}
	}

	add_action('wp', 'eltd_grid_elements_ajax_disable');
}


if(!function_exists('eltd_get_vc_version')) {
	/**
	 * Return Visual Composer version string
	 *
	 * @return bool|string
	 */
	function eltd_get_vc_version() {
		if(eltd_visual_composer_installed()) {
			return WPB_VC_VERSION;
		}

		return false;
	}
}

if(!function_exists('eltd_get_dynamic_sidebar')){
	/**
	 * Return Custom Widget Area content
	 *
	 * @return string
	 */
	function eltd_get_dynamic_sidebar($index = 1){
		$sidebar_contents = "";
		ob_start();
		dynamic_sidebar($index);
		$sidebar_contents = ob_get_clean();
		return $sidebar_contents;
	}
}


function wooc_extra_register_fields() {

       ?>

 

       <p class="form-row form-row-first">

       <label for="reg_billing_first_name"><?php _e( 'ชื่อจริง', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="billing_first_name" id="reg_billing_first_name" value="<?php if ( ! empty( $_POST['billing_first_name'] ) ) esc_attr_e( $_POST['billing_first_name'] ); ?>" />

       </p>

       <p class="form-row form-row-last">

       <label for="reg_billing_last_name"><?php _e( 'นามสกุล', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="billing_last_name" id="reg_billing_last_name" value="<?php if ( ! empty( $_POST['billing_last_name'] ) ) esc_attr_e( $_POST['billing_last_name'] ); ?>" />

       </p>

 
	  <p class="form-row form-row-last">

       <label for="reg_billing_address1"><?php _e( 'ที่อยู่', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="billing_address1" id="reg_billing_address1" value="<?php if ( ! empty( $_POST['billing_address1'] ) ) esc_attr_e( $_POST['billing_address1'] ); ?>" />

       </p>
       

	   <p class="form-row form-row-last">

       <label for="reg_billing_address2"><?php _e( 'แขวง', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="billing_address2" id="reg_billing_address2" value="<?php if ( ! empty( $_POST['billing_address2'] ) ) esc_attr_e( $_POST['billing_address2'] ); ?>" />

       </p>


	   <p class="form-row form-row-last">

       <label for="reg_billing_city"><?php _e( 'เขต', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="billing_city" id="reg_billing_city" value="<?php if ( ! empty( $_POST['billing_city'] ) ) esc_attr_e( $_POST['billing_city'] ); ?>" />

       </p>

		<p class="form-row form-row-last">
		<label for="reg_billing_city"><?php _e( 'จังหวัด', 'woocommerce' ); ?><span class="required">*</span></label>
		<select class="select2-container input-text" name="billing_state" id="reg_billing_state">
			<option value="TH-37">Amnat Charoen (อำนาจเจริญ)</option>
			<option value="TH-15">Ang Thong (อ่างทอง)</option>
			<option value="TH-14">Ayutthaya (พระนครศรีอยุธยา)</option>
			<option value="TH-10" selected="selected">Bangkok (กรุงเทพมหานคร)</option>
			<option value="TH-38">Bueng Kan (บึงกาฬ)</option>
			<option value="TH-31">Buri Ram (บุรีรัมย์)</option>
			<option value="TH-24">Chachoengsao (ฉะเชิงเทรา)</option>
			<option value="TH-18">Chai Nat (ชัยนาท)</option>
			<option value="TH-36">Chaiyaphum (ชัยภูมิ)</option>
			<option value="TH-22">Chanthaburi (จันทบุรี)</option>
			<option value="TH-50">Chiang Mai (เชียงใหม่)</option>
			<option value="TH-57">Chiang Rai (เชียงราย)</option>
			<option value="TH-20">Chonburi (ชลบุรี)</option>
			<option value="TH-86">Chumphon (ชุมพร)</option>
			<option value="TH-46">Kalasin (กาฬสินธุ์)</option>
			<option value="TH-62">Kamphaeng Phet (กำแพงเพชร)</option>
			<option value="TH-71">Kanchanaburi (กาญจนบุรี)</option>
			<option value="TH-40">Khon Kaen (ขอนแก่น)</option>
			<option value="TH-81">Krabi (กระบี่)</option>
			<option value="TH-52">Lampang (ลำปาง)</option>
			<option value="TH-51">Lamphun (ลำพูน)</option>
			<option value="TH-42">Loei (เลย)</option>
			<option value="TH-16">Lopburi (ลพบุรี)</option>
			<option value="TH-58">Mae Hong Son (แม่ฮ่องสอน)</option>
			<option value="TH-44">Maha Sarakham (มหาสารคาม)</option>
			<option value="TH-49">Mukdahan (มุกดาหาร)</option>
			<option value="TH-26">Nakhon Nayok (นครนายก)</option>
			<option value="TH-73">Nakhon Pathom (นครปฐม)</option>
			<option value="TH-48">Nakhon Phanom (นครพนม)</option>
			<option value="TH-30">Nakhon Ratchasima (นครราชสีมา)</option>
			<option value="TH-60">Nakhon Sawan (นครสวรรค์)</option>
			<option value="TH-80">Nakhon Si Thammarat (นครศรีธรรมราช)</option>
			<option value="TH-55">Nan (น่าน)</option>
			<option value="TH-96">Narathiwat (นราธิวาส)</option>
			<option value="TH-39">Nong Bua Lam Phu (หนองบัวลำภู)</option>
			<option value="TH-43">Nong Khai (หนองคาย)</option>
			<option value="TH-12">Nonthaburi (นนทบุรี)</option>
			<option value="TH-13">Pathum Thani (ปทุมธานี)</option>
			<option value="TH-94">Pattani (ปัตตานี)</option>
			<option value="TH-82">Phang Nga (พังงา)</option>
			<option value="TH-93">Phatthalung (พัทลุง)</option>
			<option value="TH-56">Phayao (พะเยา)</option>
			<option value="TH-67">Phetchabun (เพชรบูรณ์)</option>
			<option value="TH-76">Phetchaburi (เพชรบุรี)</option>
			<option value="TH-66">Phichit (พิจิตร)</option>
			<option value="TH-65">Phitsanulok (พิษณุโลก)</option>
			<option value="TH-54">Phrae (แพร่)</option>
			<option value="TH-83">Phuket (ภูเก็ต)</option>
			<option value="TH-25">Prachin Buri (ปราจีนบุรี)</option>
			<option value="TH-77">Prachuap Khiri Khan (ประจวบคีรีขันธ์)</option>
			<option value="TH-85">Ranong (ระนอง)</option>
			<option value="TH-70">Ratchaburi (ราชบุรี)</option>
			<option value="TH-21">Rayong (ระยอง)</option>
			<option value="TH-45">Roi Et (ร้อยเอ็ด)</option>
			<option value="TH-27">Sa Kaeo (สระแก้ว)</option>
			<option value="TH-47">Sakon Nakhon (สกลนคร)</option>
			<option value="TH-11">Samut Prakan (สมุทรปราการ)</option>
			<option value="TH-74">Samut Sakhon (สมุทรสาคร)</option>
			<option value="TH-75">Samut Songkhram (สมุทรสงคราม)</option>
			<option value="TH-19">Saraburi (สระบุรี)</option>
			<option value="TH-91">Satun (สตูล)</option>
			<option value="TH-17">Sing Buri (สิงห์บุรี)</option>
			<option value="TH-33">Sisaket (ศรีสะเกษ)</option>
			<option value="TH-90">Songkhla (สงขลา)</option>
			<option value="TH-64">Sukhothai (สุโขทัย)</option>
			<option value="TH-72">Suphan Buri (สุพรรณบุรี)</option>
			<option value="TH-84">Surat Thani (สุราษฎร์ธานี)</option>
			<option value="TH-32">Surin (สุรินทร์)</option>
			<option value="TH-63">Tak (ตาก)</option>
			<option value="TH-92">Trang (ตรัง)</option>
			<option value="TH-23">Trat (ตราด)</option>
			<option value="TH-34">Ubon Ratchathani (อุบลราชธานี)</option>
			<option value="TH-41">Udon Thani (อุดรธานี)</option>
			<option value="TH-61">Uthai Thani (อุทัยธานี)</option>
			<option value="TH-53">Uttaradit (อุตรดิตถ์)</option>
			<option value="TH-95">Yala (ยะลา)</option>
			<option value="TH-35">Yasothon (ยโสธร)</option>
		</select>
		</p>

	   <p class="form-row form-row-last">

       <label for="reg_billing_post_code"><?php _e( 'รหัสไปรษณีย์', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="billing_post_code" id="reg_billing_post_code" value="<?php if ( ! empty( $_POST['billing_post_code'] ) ) esc_attr_e( $_POST['billing_post_code'] ); ?>" />

       </p>
 

       <p class="form-row form-row-wide">

       <label for="reg_billing_phone"><?php _e( 'เบอร์โทรศัพท์', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="billing_phone" id="reg_billing_phone" value="<?php if ( ! empty( $_POST['billing_phone'] ) ) esc_attr_e( $_POST['billing_phone'] ); ?>" />

       </p>


	   <p class="form-row form-row-last">

       <label for="reg_billing_line"><?php _e( 'Line ID', 'woocommerce' ); ?></label>

       <input type="text" class="input-text" name="billing_line" id="reg_billing_line" value="<?php if ( ! empty( $_POST['billing_line'] ) ) esc_attr_e( $_POST['billing_line'] ); ?>" />

       </p>


		<p class="form-row form-row-last">

       <label for="reg_billing_place"><?php _e( 'จุดสังเกตสถานที่จัดส่ง', 'woocommerce' ); ?></label>

       <input type="text" class="input-text" name="billing_place" id="reg_billing_place" value="<?php if ( ! empty( $_POST['billing_place'] ) ) esc_attr_e( $_POST['billing_place'] ); ?>" />

       </p>
 
		<p class="form-row form-row-last">

       <label for="reg_billing_agent_id"><?php _e( 'รหัส ID Agent', 'woocommerce' ); ?><span class="required">*</span></label>

       <input type="text" class="input-text" name="billing_agent_id" id="reg_billing_agent_id" value="<?php echo get_current_user_id(); ?>" />

       </p>

	   <p class="form-row form-row-last">

       <label for="reg_billing_role"><?php _e( 'Role', 'woocommerce' ); ?><span class="required">*</span></label>

        <?php
        global $wp_roles;
        $user = new WP_User(get_current_user_id());

        echo '<select name="role" class="input">';
        foreach ( $wp_roles->roles as $key=>$value )
        {
            //var_dump($wp_roles->roles);
            if($user->roles[0]=="administrator")
            {
               if($key=="customer" || $key=="shop_manager")
               {
                echo '<option value="'.$key.'">'.$value['name'].'</option>';
               }
            }
            else if ($user->roles[0]=="shop_manager" && $key=="customer")
            {
                echo '<option value="'.$key.'">'.$value['name'].'</option>';
            }

        }
        echo '</select>';
        ?>

       </p>

       <?php

}


 

add_action( 'woocommerce_register_form_start', 'wooc_extra_register_fields' );

function wooc_validate_extra_register_fields( $username, $email, $validation_errors ) {

       if ( isset( $_POST['billing_first_name'] ) && empty( $_POST['billing_first_name'] ) ) {

              $validation_errors->add( 'billing_first_name_error', __( 'กรุณากรอกชื่อ', 'woocommerce' ) );
       }

       if ( isset( $_POST['billing_last_name'] ) && empty( $_POST['billing_last_name'] ) ) {

              $validation_errors->add( 'billing_last_name_error', __( 'กรุณากรอกนามสกุล', 'woocommerce' ) );
       }

       if ( isset( $_POST['billing_phone'] ) && empty( $_POST['billing_phone'] ) ) {

              $validation_errors->add( 'billing_phone_error', __( 'กรุณากรอกเบอร์โทรศัพท์', 'woocommerce' ) );
       }

	   if ( isset( $_POST['billing_address1'] ) && empty( $_POST['billing_address1'] ) ) {

              $validation_errors->add( 'billing_address1_error', __( 'กรุณากรอกที่อยู่', 'woocommerce' ) );
       }

	   if ( isset( $_POST['billing_address2'] ) && empty( $_POST['billing_address2'] ) ) {

              $validation_errors->add( 'billing_address2_error', __( 'กรุณากรอกแขวง', 'woocommerce' ) );
       }

	   if ( isset( $_POST['billing_city'] ) && empty( $_POST['billing_city'] ) ) {

              $validation_errors->add( 'billing_city_error', __( 'กรุณากรอกเขต', 'woocommerce' ) );
       }

	   if ( isset( $_POST['billing_post_code'] ) && empty( $_POST['billing_post_code'] ) ) {

              $validation_errors->add( 'billing_post_code_error', __( 'กรุณากรอกรหัสไปรษณีย์', 'woocommerce' ) );
       }


}


add_action( 'woocommerce_register_post', 'wooc_validate_extra_register_fields', 10, 3 );

function wooc_save_extra_register_fields( $customer_id ) {

       if ( isset( $_POST['billing_first_name'] ) ) {

              update_user_meta( $customer_id, 'first_name', sanitize_text_field( $_POST['billing_first_name'] ) );

              update_user_meta( $customer_id, 'billing_first_name', sanitize_text_field( $_POST['billing_first_name'] ) );

       }

       if ( isset( $_POST['billing_last_name'] ) ) {

              update_user_meta( $customer_id, 'last_name', sanitize_text_field( $_POST['billing_last_name'] ) );

              update_user_meta( $customer_id, 'billing_last_name', sanitize_text_field( $_POST['billing_last_name'] ) );

       }

       if ( isset( $_POST['billing_phone'] ) ) {

              update_user_meta( $customer_id, 'billing_phone', sanitize_text_field( $_POST['billing_phone'] ) );

       }

	   if ( isset( $_POST['billing_address1'] ) ) {

              update_user_meta( $customer_id, 'billing_address_1', sanitize_text_field( $_POST['billing_address1'] ) );

       }

	    if ( isset( $_POST['billing_address2'] ) ) {

              update_user_meta( $customer_id, 'billing_address_2', sanitize_text_field( $_POST['billing_address2'] ) );

       }

	    if ( isset( $_POST['billing_city'] ) ) {

              update_user_meta( $customer_id, 'billing_city', sanitize_text_field( $_POST['billing_city'] ) );

       }

	    if ( isset( $_POST['billing_state'] ) ) {

              update_user_meta( $customer_id, 'billing_state', sanitize_text_field( $_POST['billing_state'] ) );

       }

	   if ( isset( $_POST['billing_post_code'] ) ) {

              update_user_meta( $customer_id, 'billing_postcode', sanitize_text_field( $_POST['billing_post_code'] ) );

       }

	   if ( isset( $_POST['billing_line'] ) ) {

              update_user_meta( $customer_id, 'billing_line', sanitize_text_field( $_POST['billing_line'] ) );

       }

	   if ( isset( $_POST['billing_place'] ) ) {

              update_user_meta( $customer_id, 'billing_place', sanitize_text_field( $_POST['billing_place'] ) );

       }

	   if ( isset( $_POST['billing_agent_id'] ) ) {

              update_user_meta( $customer_id, 'billing_agent_id', sanitize_text_field( $_POST['billing_agent_id'] ) );

       }

	   if ( isset( $_POST['billing_role'] ) ) {

              update_user_meta( $customer_id, 'billing_role', sanitize_text_field( $_POST['billing_role'] ) );

       }

        $user_id = wp_update_user( array( 'ID' => $customer_id, 'role' => $_POST['role'] ) );

	$user = new WP_User(get_current_user_id()); 
	if($user->roles[0]=="administrator") 
	{	wp_redirect( home_url('wp-admin/edit.php?post_type=shop_order') ); } 
	else if ($user->roles[0]=="shop_manager")
	{ wp_redirect( home_url('wp-admin/edit.php?post_type=shop_order&author='.get_current_user_id()) );
    }
	else
	{ 
		wp_set_current_user($customer_id);
		wp_set_auth_cookie($customer_id);
		wp_redirect( home_url('shop/') );
	}
        exit;
}

 

add_action( 'woocommerce_created_customer', 'wooc_save_extra_register_fields' );

add_filter( 'woocommerce_states', 'thailand_woocommerce_states' );

function thailand_woocommerce_states( $states ) {
	$states['TH'] = array( 'TH-10' => __('กรุงเทพมหานคร', 'woocommerce') );
	return $states;
}

add_filter('woocommerce_default_address_fields','custom_default_label');

function custom_default_label( $fields ) {
	 $fields['first_name']['label'] = 'ชื่อจริง';
	 $fields['last_name']['label'] = 'นามสกุล';
	 $fields['address_1']['label'] = 'ที่อยู่';
	 $fields['address_2']['label'] = 'แขวง';
	 $fields['city'] = array (
		 'label' => __('เขต','woocommerce'),
		 'required'  => true,
	 );
	 $fields['state']['label'] = 'จังหวัด';
	 $fields['postcode']['label'] = 'รหัสไปรษณีย์';
	 unset($fields['company']);
	 unset($fields['country']);
     return $fields;
}

add_filter( 'woocommerce_billing_fields', 'custom_billing_label');
function custom_billing_label( $address_fields ) {
	$address_fields['billing_phone']['label'] = 'เบอร์โทรศัพท์';
	$address_fields['billing_email']['label'] = 'Email';
	return $address_fields;
}

function agent_order_func( $atts ) {

	$my_orders_columns = apply_filters( 'woocommerce_my_account_my_orders_columns', array(
		'order-number'  => __( 'Order', 'woocommerce' ),
		'order-date'    => __( 'Date', 'woocommerce' ),
		'order-status'  => __( 'Status', 'woocommerce' ),
		'order-total'   => __( 'Total', 'woocommerce' ),
		'order-actions' => '&nbsp;',
	) );
	$blogusers = get_users( 'meta_key=billing_agent_id&meta_value='.get_current_user_id() );
	$arrayforsearch = array();
	foreach ( $blogusers as $user ) {
		array_push($arrayforsearch,$user->ID);
	}

	if(! empty($_GET['pag']) && is_numeric($_GET['pag']) ){
		$paged = $_GET['pag'];
	}else{
		$paged = 1;
	}

	$posts_per_page = 50; 
	$all_posts = get_posts($args);

	$all_customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
		'numberposts' => -1,
		'meta_key'    => '_customer_user',
		'meta_value'  => $arrayforsearch,
		'post_type'   => wc_get_order_types( 'view-orders' ),
		'post_status' => array_keys( wc_get_order_statuses() ),
		'paged'        => $paged,
		'orderby' => 'ID',
		'order' => 'DESC',
	) ) );

	$customer_orders = get_posts( apply_filters( 'woocommerce_my_account_my_orders_query', array(
		'numberposts' => $posts_per_page,
		'meta_key'    => '_customer_user',
		'meta_value'  => $arrayforsearch,
		'post_type'   => wc_get_order_types( 'view-orders' ),
		'post_status' => array_keys( wc_get_order_statuses() ),
		'paged'        => $paged,
		'orderby' => 'ID',
		'order' => 'DESC',
	) ) );

	$post_count = count($all_customer_orders);
	$num_pages = ceil($post_count / $posts_per_page);
	if($paged > $num_pages || $paged < 1){
		$paged = $num_pages;
	}

	if ($customer_orders) { ?>

		<h2><?php echo apply_filters( 'woocommerce_my_account_my_orders_title', __( 'Orders', 'woocommerce' ) ); ?></h2>
		<table class="shop_table shop_table_responsive my_account_orders">

			<thead>
				<tr>
						<th class="manage-column column-order_items"><span class="nobr">เลขที่</span></th>
						<th class="manage-column column-order_items"><span class="nobr">วันที่</span></th>
						<th class="manage-column column-order_items"><span class="nobr">ชื่อ - นามสกุล</span></th>
						<th class="manage-column column-order_items"><span class="nobr">สถานะ</span></th>
						<th class="manage-column column-order_items"><span class="nobr">เบอร์โทรศัพท์</span></th>
						<th class="manage-column column-order_items"><span class="nobr">สินค้ารวม</span></th>
						<th class="manage-column column-order_items"><span class="nobr">ราคารวม</span></th>
						<th class="manage-column column-order_items"><span class="nobr"></span></th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ( $customer_orders as $customer_order ) : $order  = wc_get_order( $customer_order ); $item_count = $order->get_item_count(); ?>
					<tr class="order">
						<td><?php echo $order->id; ?></td>
						<td><?php echo $order->post->post_date; ?></td>
						<td><?php echo get_post_meta($order->id,'_billing_first_name',true)." ".get_post_meta($order->id,'_billing_last_name',true); ?></td>
						<td><?php echo $order->post->post_status; ?></td>
						<td><?php echo get_post_meta($order->id,'_billing_phone',true); ?></td>
						<td><?php echo $item_count; ?></td>
						<td><?php echo get_post_meta($order->id,'_order_total',true); ?></td>
						<td></td>
					</tr>
			   <?php endforeach; ?>
			</tbody>
		</table>
		<?php
	if($post_count > $posts_per_page ){

			echo '<div class="pagination">
					<ul>';

			if($paged > 1){
				echo '<li><a class="first" href="?pag=1">&laquo;</a></li>';
			}else{
				echo '<li><span class="first">&laquo;</span></li>';
			}

			for($p = 1; $p <= $num_pages; $p++){
				if ($paged == $p) {
					echo '<li><span class="current">'.$p.'</span></li>';
				}else{
					echo '<li><a href="?pag='.$p.'">'.$p.'</a></li>';
				}
			}

			if($paged < $num_pages){
				echo '<li><a class="last" href="?pag='.$num_pages.'">&raquo;</a></li>';
			}else{
				echo '<li><span class="last">&raquo;</span></li>';
			}

			echo '</ul></div>';
		}
	 }
}

add_filter( 'woocommerce_shop_order_search_fields', function ($search_fields ) {
    $posts = get_posts(array('post_type' => 'shop_order'));

    foreach ($posts as $post) {
        $order_id = $post->ID;
        $order = new WC_Order($order_id);
        $items = $order->get_items();

        foreach($items as $item) {
            $product_id = $item['product_id'];
            $search_sku = get_post_meta($product_id, "_sku", true);
            add_post_meta($order_id, "_product_sku", $search_sku);
            add_post_meta($order_id, "_product_id", $product_id);
        }
    }

    return array_merge($search_fields, array('_product_sku', '_product_id'));
});


add_action('admin_head', 'my_custom_fonts');

function my_custom_fonts() {
    $user = new WP_User(get_current_user_id());
    if($user->roles[0]=="shop_manager")
    {
        echo '<STYLE type="text/css"> div#adminmenumain, div#screen-meta-links, div.update-nag, ul#wp-admin-bar-root-default, div#postcustom, div#mymetabox_revslider_0, div#woocommerce-order-downloads, ul.order_actions li#actions, th#order_actions, td.order_actions, th.column-order_actions, td.check-column, th.check-column, div.bulkactions, button.bulk-decrease-stock, button.bulk-increase-stock, button.add-order-tax, button.refund-items, button.calculate-tax-action, ul.subsubsub  {display:none !important}
        div#wpcontent{margin-left:0 !important}
</style>';
    }
}




?>
 