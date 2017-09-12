<?php

class EltdSliderShortcode {
    public function __construct() {
        add_shortcode('no_slider', array($this, 'render'));
    }

    public function render($atts, $content = null) {
        global $eltdIconCollections;
        global $eltd_options;
        extract(shortcode_atts(array("slider" => "", "height" => "", "responsive_height" => "", "responsive_breakpoints" => "set1", "background_color" => "", "auto_start" => "", "animation_type" => "", "slide_animation" => "6000", "anchor" => "", "show_navigation_arrows" => "yes", "show_navigation_circles" => "yes", "navigation_position" => "default", "content_next_to_arrows" => ""), $atts));
        $html = "";

        if ($slider != "") {
            $args = array(
                'post_type' => 'slides',
                'slides_category' => $slider,
                'orderby' => "menu_order",
                'order' => "ASC",
                'posts_per_page' => -1
            );

            $slider_id = get_term_by('slug', $slider, 'slides_category')->term_id;
            $slider_meta = get_option("taxonomy_term_" . $slider_id);
            $slider_header_effect = $slider_meta['header_effect'];
            if ($slider_header_effect == 'yes') {
                $header_effect_class = 'header_effect';
            } else {
                $header_effect_class = '';
            }

            $slider_css_position_class = '';
            $slider_parallax = 'yes';
            if (isset($slider_meta['slider_parallax_effect'])) {
                $slider_parallax = $slider_meta['slider_parallax_effect'];
            }
            if ($slider_parallax == 'no' || (isset($eltd_options['paspartu']) && $eltd_options['paspartu'] == 'yes' && ((isset($eltd_options['paspartu_on_top']) && $eltd_options['paspartu_on_top'] == 'yes') || (isset($eltd_options['paspartu_on_bottom_slider']) && $eltd_options['paspartu_on_bottom_slider'] == 'yes')))) {
                $data_parallax_effect = 'data-parallax="no"';
                $slider_css_position_class = 'relative_position';
            } else {
                $data_parallax_effect = 'data-parallax="yes"';
            }

            // not enabled for vertical menu and paspartu
            $slider_thumbs = 'no';
            if (isset($slider_meta['slider_thumbs'])) {
                if(isset($eltd_options['vertical_area']) && $eltd_options['vertical_area'] =='no' && isset($eltd_options['paspartu']) && $eltd_options['paspartu'] == 'no') {
                    $slider_thumbs = $slider_meta['slider_thumbs'];
                }
            }
            if ($slider_thumbs == 'yes') {
                $slider_thumbs_class = 'slider_thumbs';
            } else {
                $slider_thumbs_class = '';
            }

            $slider_numbers = 'no';
            if(isset($slider_meta['slider_numbers']) && $slider_meta['slider_numbers'] == 'yes') {
                $slider_numbers_class = 'slider_numbers';
                $slider_numbers = 'yes';
            } else {
                $slider_numbers_class = '';
            }


            if ($height == "" || $height == "0") {
                $full_screen_class = "full_screen";
                $responsive_height_class = "";
                $height_class = "";
                $slide_holder_height = "";
                $slide_height = "";
                $data_height = "";
                $carouselinner_height = 'height: 100%';
            } else {
                $full_screen_class = "";
                $height_class = "has_height";
                if ($responsive_height == "yes") {
                    $responsive_height_class = "responsive_height";
                } else {
                    $responsive_height_class = "";
                }
                $slide_holder_height = "height: " . $height . "px;";
                $slide_height = "height: " . ($height) . "px;";
                $data_height = "data-height='" . $height . "'";
                $carouselinner_height = "height: " . ($height + 50) . "px;"; //because of the bottom gap on smooth scroll
            }

            $anchor_data = '';
            if ($anchor != "") {
                $anchor_data .= 'data-eltd_id = "#' . esc_attr($anchor) . '"';
            }

            $responsiveness_data = '';
            $responsive_coefficients_graphic_data = '';
            $responsive_coefficients_title_data = '';
            $responsive_coefficients_subtitle_data = '';
            $responsive_coefficients_text_data = '';
            $responsive_coefficients_button_data = '';

            if ($height != "" && $responsive_height == "yes") {
                $responsiveness_data = 'data-eltd_responsive_breakpoints = "' . esc_attr($responsive_breakpoints) . '"';
            }

            if (isset($slider_meta['breakpoint1_graphic']) && $slider_meta['breakpoint1_graphic'] != '') {
                $breakpoint1_graphic = esc_attr($slider_meta['breakpoint1_graphic']);
            } else {
                $breakpoint1_graphic = 1;
            }
            if (isset($slider_meta['breakpoint2_graphic']) && $slider_meta['breakpoint2_graphic'] != '') {
                $breakpoint2_graphic = esc_attr($slider_meta['breakpoint2_graphic']);
            } else {
                $breakpoint2_graphic = 1;
            }
            if (isset($slider_meta['breakpoint3_graphic']) && $slider_meta['breakpoint3_graphic'] != '') {
                $breakpoint3_graphic = esc_attr($slider_meta['breakpoint3_graphic']);
            } else {
                $breakpoint3_graphic = 0.8;
            }
            if (isset($slider_meta['breakpoint4_graphic']) && $slider_meta['breakpoint4_graphic'] != '') {
                $breakpoint4_graphic = esc_attr($slider_meta['breakpoint4_graphic']);
            } else {
                $breakpoint4_graphic = 0.7;
            }
            if (isset($slider_meta['breakpoint5_graphic']) && $slider_meta['breakpoint5_graphic'] != '') {
                $breakpoint5_graphic = esc_attr($slider_meta['breakpoint5_graphic']);
            } else {
                $breakpoint5_graphic = 0.6;
            }
            if (isset($slider_meta['breakpoint6_graphic']) && $slider_meta['breakpoint6_graphic'] != '') {
                $breakpoint6_graphic = esc_attr($slider_meta['breakpoint6_graphic']);
            } else {
                $breakpoint6_graphic = 0.5;
            }
            if (isset($slider_meta['breakpoint7_graphic']) && $slider_meta['breakpoint7_graphic'] != '') {
                $breakpoint7_graphic = esc_attr($slider_meta['breakpoint7_graphic']);
            } else {
                $breakpoint7_graphic = 0.4;
            }

            if (isset($slider_meta['breakpoint1_title']) && $slider_meta['breakpoint1_title'] != '') {
                $breakpoint1_title = esc_attr($slider_meta['breakpoint1_title']);
            } else {
                $breakpoint1_title = 1;
            }
            if (isset($slider_meta['breakpoint2_title']) && $slider_meta['breakpoint2_title'] != '') {
                $breakpoint2_title = esc_attr($slider_meta['breakpoint2_title']);
            } else {
                $breakpoint2_title = 1;
            }
            if (isset($slider_meta['breakpoint3_title']) && $slider_meta['breakpoint3_title'] != '') {
                $breakpoint3_title = esc_attr($slider_meta['breakpoint3_title']);
            } else {
                $breakpoint3_title = 0.8;
            }
            if (isset($slider_meta['breakpoint4_title']) && $slider_meta['breakpoint4_title'] != '') {
                $breakpoint4_title = esc_attr($slider_meta['breakpoint4_title']);
            } else {
                $breakpoint4_title = 0.7;
            }
            if (isset($slider_meta['breakpoint5_title']) && $slider_meta['breakpoint5_title'] != '') {
                $breakpoint5_title = esc_attr($slider_meta['breakpoint5_title']);
            } else {
                $breakpoint5_title = 0.6;
            }
            if (isset($slider_meta['breakpoint6_title']) && $slider_meta['breakpoint6_title'] != '') {
                $breakpoint6_title = esc_attr($slider_meta['breakpoint6_title']);
            } else {
                $breakpoint6_title = 0.5;
            }
            if (isset($slider_meta['breakpoint7_title']) && $slider_meta['breakpoint7_title'] != '') {
                $breakpoint7_title = esc_attr($slider_meta['breakpoint7_title']);
            } else {
                $breakpoint7_title = 0.4;
            }

            if (isset($slider_meta['breakpoint1_subtitle']) && $slider_meta['breakpoint1_subtitle'] != '') {
                $breakpoint1_subtitle = esc_attr($slider_meta['breakpoint1_subtitle']);
            } else {
                $breakpoint1_subtitle = 1;
            }
            if (isset($slider_meta['breakpoint2_subtitle']) && $slider_meta['breakpoint2_subtitle'] != '') {
                $breakpoint2_subtitle = esc_attr($slider_meta['breakpoint2_subtitle']);
            } else {
                $breakpoint2_subtitle = 1;
            }
            if (isset($slider_meta['breakpoint3_subtitle']) && $slider_meta['breakpoint3_subtitle'] != '') {
                $breakpoint3_subtitle = esc_attr($slider_meta['breakpoint3_subtitle']);
            } else {
                $breakpoint3_subtitle = 0.8;
            }
            if (isset($slider_meta['breakpoint4_subtitle']) && $slider_meta['breakpoint4_subtitle'] != '') {
                $breakpoint4_subtitle = esc_attr($slider_meta['breakpoint4_subtitle']);
            } else {
                $breakpoint4_subtitle = 0.7;
            }
            if (isset($slider_meta['breakpoint5_subtitle']) && $slider_meta['breakpoint5_subtitle'] != '') {
                $breakpoint5_subtitle = esc_attr($slider_meta['breakpoint5_subtitle']);
            } else {
                $breakpoint5_subtitle = 0.6;
            }
            if (isset($slider_meta['breakpoint6_subtitle']) && $slider_meta['breakpoint6_subtitle'] != '') {
                $breakpoint6_subtitle = esc_attr($slider_meta['breakpoint6_subtitle']);
            } else {
                $breakpoint6_subtitle = 0.5;
            }
            if (isset($slider_meta['breakpoint7_subtitle']) && $slider_meta['breakpoint7_subtitle'] != '') {
                $breakpoint7_subtitle = esc_attr($slider_meta['breakpoint7_subtitle']);
            } else {
                $breakpoint7_subtitle = 0.4;
            }

            if (isset($slider_meta['breakpoint1_text']) && $slider_meta['breakpoint1_text'] != '') {
                $breakpoint1_text = esc_attr($slider_meta['breakpoint1_text']);
            } else {
                $breakpoint1_text = 1;
            }
            if (isset($slider_meta['breakpoint2_text']) && $slider_meta['breakpoint2_text'] != '') {
                $breakpoint2_text = esc_attr($slider_meta['breakpoint2_text']);
            } else {
                $breakpoint2_text = 1;
            }
            if (isset($slider_meta['breakpoint3_text']) && $slider_meta['breakpoint3_text'] != '') {
                $breakpoint3_text = esc_attr($slider_meta['breakpoint3_text']);
            } else {
                $breakpoint3_text = 0.8;
            }
            if (isset($slider_meta['breakpoint4_text']) && $slider_meta['breakpoint4_text'] != '') {
                $breakpoint4_text = esc_attr($slider_meta['breakpoint4_text']);
            } else {
                $breakpoint4_text = 0.7;
            }
            if (isset($slider_meta['breakpoint5_text']) && $slider_meta['breakpoint5_text'] != '') {
                $breakpoint5_text = esc_attr($slider_meta['breakpoint5_text']);
            } else {
                $breakpoint5_text = 0.6;
            }
            if (isset($slider_meta['breakpoint6_text']) && $slider_meta['breakpoint6_text'] != '') {
                $breakpoint6_text = esc_attr($slider_meta['breakpoint6_text']);
            } else {
                $breakpoint6_text = 0.5;
            }
            if (isset($slider_meta['breakpoint7_text']) && $slider_meta['breakpoint7_text'] != '') {
                $breakpoint7_text = esc_attr($slider_meta['breakpoint7_text']);
            } else {
                $breakpoint7_text = 0.4;
            }

            if (isset($slider_meta['breakpoint1_button']) && $slider_meta['breakpoint1_button'] != '') {
                $breakpoint1_button = esc_attr($slider_meta['breakpoint1_button']);
            } else {
                $breakpoint1_button = 1;
            }
            if (isset($slider_meta['breakpoint2_button']) && $slider_meta['breakpoint2_button'] != '') {
                $breakpoint2_button = esc_attr($slider_meta['breakpoint2_button']);
            } else {
                $breakpoint2_button = 1;
            }
            if (isset($slider_meta['breakpoint3_button']) && $slider_meta['breakpoint3_button'] != '') {
                $breakpoint3_button = esc_attr($slider_meta['breakpoint3_button']);
            } else {
                $breakpoint3_button = 0.8;
            }
            if (isset($slider_meta['breakpoint4_button']) && $slider_meta['breakpoint4_button'] != '') {
                $breakpoint4_button = esc_attr($slider_meta['breakpoint4_button']);
            } else {
                $breakpoint4_button = 0.7;
            }
            if (isset($slider_meta['breakpoint5_button']) && $slider_meta['breakpoint5_button'] != '') {
                $breakpoint5_button = esc_attr($slider_meta['breakpoint5_button']);
            } else {
                $breakpoint5_button = 0.6;
            }
            if (isset($slider_meta['breakpoint6_button']) && $slider_meta['breakpoint6_button'] != '') {
                $breakpoint6_button = esc_attr($slider_meta['breakpoint6_button']);
            } else {
                $breakpoint6_button = 0.5;
            }
            if (isset($slider_meta['breakpoint7_button']) && $slider_meta['breakpoint7_button'] != '') {
                $breakpoint7_button = esc_attr($slider_meta['breakpoint7_button']);
            } else {
                $breakpoint7_button = 0.4;
            }

            $responsive_coefficients_graphic_data = 'data-eltd_responsive_graphic_coefficients = "' . esc_attr($breakpoint1_graphic . ',' . $breakpoint2_graphic . ',' . $breakpoint3_graphic . ',' . $breakpoint4_graphic . ',' . $breakpoint5_graphic . ',' . $breakpoint6_graphic . ',' . $breakpoint7_graphic) . '"';
            $responsive_coefficients_title_data = 'data-eltd_responsive_title_coefficients = "' . esc_attr($breakpoint1_title . ',' . $breakpoint2_title . ',' . $breakpoint3_title . ',' . $breakpoint4_title . ',' . $breakpoint5_title . ',' . $breakpoint6_title . ',' . $breakpoint7_title) . '"';
            $responsive_coefficients_subtitle_data = 'data-eltd_responsive_subtitle_coefficients = "' . esc_attr($breakpoint1_subtitle . ',' . $breakpoint2_subtitle . ',' . $breakpoint3_subtitle . ',' . $breakpoint4_subtitle . ',' . $breakpoint5_subtitle . ',' . $breakpoint6_subtitle . ',' . $breakpoint7_subtitle) . '"';
            $responsive_coefficients_text_data = 'data-eltd_responsive_text_coefficients = "' . esc_attr($breakpoint1_text . ',' . $breakpoint2_text . ',' . $breakpoint3_text . ',' . $breakpoint4_text . ',' . $breakpoint5_text . ',' . $breakpoint6_text . ',' . $breakpoint7_text) . '"';
            $responsive_coefficients_button_data = 'data-eltd_responsive_button_coefficients = "' . esc_attr($breakpoint1_button . ',' . $breakpoint2_button . ',' . $breakpoint3_button . ',' . $breakpoint4_button . ',' . $breakpoint5_button . ',' . $breakpoint6_button . ',' . $breakpoint7_button) . '"';


            $slider_transparency_class = "header_not_transparent";
            if (isset($eltd_options['header_background_transparency_initial']) && $eltd_options['header_background_transparency_initial'] != "1" && $eltd_options['header_background_transparency_initial'] != "") {
                $slider_transparency_class = "";
            }

            if ($background_color != "") {
                $background_color = 'background-color:' . $background_color . ';';
            }

            $auto = "true";
            if ($auto_start != "") {
                $auto = $auto_start;
            }

            if ($auto == "true") {
                $auto_start_class = "eltd_auto_start";
            } else {
                $auto_start_class = "";
            }

            if ($slide_animation != "") {
                $slide_animation = 'data-slide_animation="' . $slide_animation . '"';
            } else {
                $slide_animation = 'data-slide_animation=""';
            }

            switch ($animation_type) {
                case 'fade':
                    $animation_type_class = 'fade';
                    break;
                case 'slide-vertical-up':
                    $animation_type_class = 'vertical_up';
                    break;
                case 'slide-vertical-down':
                    $animation_type_class = 'vertical_down';
                    break;
                case 'slide-cover':
                    $animation_type_class = 'slide_cover';
                    break;
                default:
                    $animation_type_class = '';
            }

            switch ($navigation_position) {
                case 'bottom_right':
                    $navigation_position_class = 'navigation_bottom_right';
                    break;
                case 'bottom_left':
                    $navigation_position_class = 'navigation_bottom_left';
                    break;
                default:
                    $navigation_position_class = '';
            }

            $content_next_to_arrows_class = '';
            if ($content_next_to_arrows == 'yes' && $navigation_position_class != '') {
                $content_next_to_arrows_class = 'content_next_to_arrows';
            }

            /**************** Count positioning of navigation arrows and preloader depending on header transparency and layout - START ****************/

            global $wp_query;

            $page_id = $wp_query->get_queried_object_id();
            $header_height_padding = 0;

            //this is out of 'if condition' bellow since calculating is needed for slide item top padding - start //
            $arrow_button_height = 50;
            if (isset($eltd_options['navigation_button_height']) && $eltd_options['navigation_button_height'] != '') {
                $arrow_button_height = esc_attr($eltd_options['navigation_button_height']);
            }

            if (!empty($eltd_options['header_height'])) {
                $header_height = esc_attr($eltd_options['header_height']);
            } else {
                $header_height = 129;
            }
            if ($eltd_options['header_bottom_appearance'] == 'stick menu_bottom') {
                $menu_bottom = '46';
                if (is_active_sidebar('header_fixed_right')) {
                    $menu_bottom = $menu_bottom + 22;
                }
            } else {
                $menu_bottom = 0;
            }

            $header_top = 0;
            if (isset($eltd_options['header_top_area']) && $eltd_options['header_top_area'] == "yes"){
                if(isset($eltd_options['header_top_height']) && $eltd_options['header_top_height'] !== ""){
                    $header_top = $eltd_options['header_top_height'];
                } else {
                    $header_top = 36;
                }
            }

            $header_top_border = 0;
            $header_bottom_border = 0;
            if (isset($eltd_options['enable_header_top_border']) && $eltd_options['enable_header_top_border'] == 'yes' && isset($eltd_options['header_top_border_width']) && $eltd_options['header_top_border_width'] !== '') {
                $header_top_border = esc_attr($eltd_options['header_top_border_width']);
            }
            if (isset($eltd_options['enable_header_bottom_border']) && $eltd_options['enable_header_bottom_border'] == 'yes' && isset($eltd_options['header_bottom_border_width']) && $eltd_options['header_bottom_border_width'] !== '') {
                $header_bottom_border = esc_attr($eltd_options['header_bottom_border_width']);
            }

            $large_menu_item_border = 0;
            if (isset($eltd_options['enable_manu_item_border']) && $eltd_options['enable_manu_item_border'] == 'yes' && isset($eltd_options['menu_item_style']) && $eltd_options['menu_item_style'] == 'large_item') {
                if (isset($eltd_options['menu_item_border_style']) && $eltd_options['menu_item_border_style'] == 'all_borders') {
                    $large_menu_item_border = esc_attr($eltd_options['menu_item_border_width']) * 2;
                }
                if (isset($eltd_options['menu_item_border_style']) && $eltd_options['menu_item_border_style'] == 'top_bottom_borders') {
                    $large_menu_item_border = esc_attr($eltd_options['menu_item_border_width']) * 2;
                }
                if (isset($eltd_options['menu_item_border_style']) && $eltd_options['menu_item_border_style'] == 'bottom_border') {
                    $large_menu_item_border = esc_attr($eltd_options['menu_item_border_width']);
                }
            }

            $header_height = $header_height + $header_top_border + $header_bottom_border + $large_menu_item_border;

            if (isset($eltd_options['header_bottom_appearance'])) {
                switch ($eltd_options['header_bottom_appearance']) {
                    case 'stick':
                        $logo_height = esc_attr($eltd_options['logo_height']) / 2;
                        break;
                    case 'stick menu_bottom':
                        $logo_height = esc_attr($eltd_options['logo_height']) / 2;
                        break;
                    case 'fixed_hiding':
                        $logo_height = esc_attr($eltd_options['logo_height']) / 2;
                        break;
                    default:
                        $logo_height = esc_attr($eltd_options['logo_height']);
                        break;
                }
            }
            //this is out of 'if condition' bellow since calculating is needed for slide item top padding - end //

            $hide_sticky_header = false;
            if (get_post_meta($page_id, "eltd_page_hide_initial_sticky", true) == "yes"){
                $hide_sticky_header = true;
            }else if(isset($eltd_options['hide_initial_sticky']) && $eltd_options['hide_initial_sticky'] == "yes"){
                $hide_sticky_header = true;
            }

            if ((get_post_meta($page_id, "eltd_header_color_transparency_per_page", true) !== "0") && ($eltd_options['header_background_transparency_initial'] !== "0") && ((isset($eltd_options['paspartu']) && $eltd_options['paspartu'] == 'no') || (isset($eltd_options['paspartu_on_top']) && $eltd_options['paspartu_on_top'] == 'no')) && !$hide_sticky_header) {

                $header_height_padding = $header_height + $menu_bottom + $header_top;
                if ((isset($eltd_options['center_logo_image']) && $eltd_options['center_logo_image'] == "yes" && $eltd_options['header_bottom_appearance'] !== 'stick menu_bottom' && $eltd_options['header_bottom_appearance'] !== 'stick_with_left_right_menu') || $eltd_options['header_bottom_appearance'] == "fixed_hiding") {
                    $header_height_padding = $logo_height + 20 + $header_height + $menu_bottom + $header_top; // 20 is top margin of centered logo
                }
            }
            if ($header_height_padding != 0 && get_post_meta($page_id, "eltd_enable_content_top_margin", true) != "yes") {
                $navigation_margin_top = 'style="margin-top:' . esc_attr((($header_height_padding / 2) - $arrow_button_height / 2)) . 'px;"'; // 30 is top and bottom margin of centered logo
                $loader_margin_top = 'style="margin-top:' . esc_attr(($header_height_padding / 2)) . 'px;"';
            } else {
                $navigation_margin_top = '';
                $loader_margin_top = '';
            }

            /**************** Count positioning of navigation arrows and preloader depending on header transparency and layout - END ****************/


            $custom_cursor = "";
            if(isset($eltd_options['qs_enable_navigation_custom_cursor']) && ($eltd_options['qs_enable_navigation_custom_cursor']=="yes")){
                $custom_cursor = "has_custom_cursor";
            }

            if((isset($eltd_options['paspartu']) && $eltd_options['paspartu'] == 'yes' && ((isset($eltd_options['paspartu_on_top']) && $eltd_options['paspartu_on_top'] == 'yes') || (isset($eltd_options['paspartu_on_bottom_slider']) && $eltd_options['paspartu_on_bottom_slider'] == 'yes'))) || $slider_parallax == "no"){
                $data_parallax_transform = '';
            }else{
                $data_parallax_transform = 'data-start="transform: translateY(0px);" data-1440="transform: translateY(-500px);"';
            }

            $ajax_loader = '';
            if($eltd_options['loading_animation'] == "on") {
                if($eltd_options['loading_image'] != "") {
                    $ajax_loader = '<div class="ajax_loader" ' . $loader_margin_top . '><div class="ajax_loader_1"><div class="ajax_loader_2"><img src="' . esc_url($eltd_options['loading_image']) . '" alt="" /></div></div></div>';
                }else{
                    $ajax_loader = '<div class="ajax_loader" ' . $loader_margin_top . '><div class="ajax_loader_1">' . eltd_loading_spinners(true) . '</div></div>';
                }
            }

            $html .= '<div id="eltd-' . esc_attr($slider) . '" ' . $anchor_data . ' ' . $responsiveness_data . ' ' . $responsive_coefficients_graphic_data . ' ' . $responsive_coefficients_title_data . ' ' . $responsive_coefficients_subtitle_data . ' ' . $responsive_coefficients_text_data . ' ' . $responsive_coefficients_button_data . ' class="carousel slide ' . esc_attr($animation_type_class . ' ' . $custom_cursor . ' ' . $full_screen_class . ' ' . $responsive_height_class . ' ' . $height_class . ' ' . $auto_start_class . ' ' . $header_effect_class . ' ' . $slider_numbers_class .  ' ' . $slider_thumbs_class . ' ' . $slider_transparency_class . ' ' . $navigation_position_class . ' ' . $content_next_to_arrows_class) . '" ' . $slide_animation . ' ' . $data_height . ' ' . $data_parallax_effect . ' '.eltd_get_inline_style($slide_holder_height. $background_color).'><div class="eltd_slider_preloader" '.eltd_get_inline_style($background_color).'>'.$ajax_loader.'</div>';
            $html .= '<div class="carousel-inner ' . esc_attr($slider_css_position_class) . '" '.eltd_get_inline_style($carouselinner_height).' '.$data_parallax_transform.'>';
            query_posts($args);


            $found_slides = $wp_query->post_count;

            if (have_posts()) : $postCount = 0;
                while (have_posts()) : the_post();
                    $active_class = '';
                    if ($postCount == 0) {
                        $active_class = 'active';
                    } else {
                        $active_class = 'inactive';
                    }

                    $slide_type = get_post_meta(get_the_ID(), "eltd_slide-background-type", true);

                    $image = esc_url(get_post_meta(get_the_ID(), "eltd_slide-image", true));
                    $image_overlay_pattern = esc_url(get_post_meta(get_the_ID(), "eltd_slide-overlay-image", true));
                    $thumbnail = esc_url(get_post_meta(get_the_ID(), "eltd_slide-thumbnail", true));
                    $thumbnail_attributes = eltd_get_attachment_meta_from_url($thumbnail, array('width','height'));
                    $thumbnail_attributes_width = '';
                    $thumbnail_attributes_height = '';
                    if($thumbnail_attributes == true){
                        $thumbnail_attributes_width = $thumbnail_attributes['width'];
                        $thumbnail_attributes_height = $thumbnail_attributes['height'];
                    }
                    $thumbnail_animation = get_post_meta(get_the_ID(), "eltd_slide-thumbnail-animation", true);
                    $thumbnail_link = "";
                    if (get_post_meta(get_the_ID(), "eltd_slide-thumbnail-link", true) != "") {
                        $thumbnail_link = esc_url(get_post_meta(get_the_ID(), "eltd_slide-thumbnail-link", true));
                    }
                    $svg_link = "";
                    if (get_post_meta(get_the_ID(), "eltd_slide-svg-link", true) != "") {
                        $svg_link = esc_url(get_post_meta(get_the_ID(), "eltd_slide-svg-link", true));
                    }



                    $video_webm = esc_url(get_post_meta(get_the_ID(), "eltd_slide-video-webm", true));
                    $video_mp4 = esc_url(get_post_meta(get_the_ID(), "eltd_slide-video-mp4", true));
                    $video_ogv = esc_url(get_post_meta(get_the_ID(), "eltd_slide-video-ogv", true));
                    $video_image = esc_url(get_post_meta(get_the_ID(), "eltd_slide-video-image", true));
                    $video_overlay = get_post_meta(get_the_ID(), "eltd_slide-video-overlay", true);
                    $video_overlay_image = esc_url(get_post_meta(get_the_ID(), "eltd_slide-video-overlay-image", true));

                    $content_animation = get_post_meta(get_the_ID(), "eltd_slide-content-animation", true);
                    $content_animation_direction = get_post_meta(get_the_ID(), "eltd_slide-content-animation-direction", true);

                    $slide_content_style = "";
                    $padding_responsive_class = '';
                    if (get_post_meta(get_the_ID(), "eltd_slide-content-background-color", true) != "") {
                        $slide_content_style .= "background-color: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-content-background-color", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-content-text-padding", true) != "") {
                        $slide_content_style .= "padding: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-content-text-padding", true)) . ";";
                        $padding_responsive_class .= 'custom_slide_padding';
                    }

                    $slide_title_style = "";
                    if (get_post_meta(get_the_ID(), "eltd_slide-title-color", true) != "") {
                        $slide_title_style .= "color: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-title-color", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-title-font-size", true) != "") {
                        $slide_title_style .= "font-size: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-title-font-size", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-title-line-height", true) != "") {
                        $slide_title_style .= "line-height: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-title-line-height", true)) . "px;";
                    }
                    if ((get_post_meta(get_the_ID(), "eltd_slide-title-font-family", true) !== "-1") && (get_post_meta(get_the_ID(), "eltd_slide-title-font-family", true) !== "")) {
                        $slide_title_style .= "font-family: '" . esc_attr(str_replace('+', ' ', get_post_meta(get_the_ID(), "eltd_slide-title-font-family", true))) . "';";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-title-font-style", true) != "") {
                        $slide_title_style .= "font-style: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-title-font-style", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-title-font-weight", true) != "") {
                        $slide_title_style .= "font-weight: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-title-font-weight", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide-title-letter-spacing', true) !== '') {
                        $slide_title_style .= 'letter-spacing: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide-title-letter-spacing', true)) . 'px;';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide-title-text-transform', true) !== '') {
                        $slide_title_style .= 'text-transform: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide-title-text-transform', true)) . ';';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide-hide-shadow', true) == 'yes') {
                        $slide_title_style .= 'text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide_title_margin_bottom', true) != '') {
                        $slide_title_style .= 'margin-bottom: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_title_margin_bottom', true)) . 'px;';
                    }

                    $slide_title_span_style = "";
                    if (get_post_meta(get_the_ID(), 'eltd_slide-title-background-color', true) !== '') {
                        $slide_title_bg_color = esc_attr(get_post_meta(get_the_ID(), "eltd_slide-title-background-color", true));
                        if (get_post_meta(get_the_ID(), 'eltd_slide-title-bg-color-transparency', true) != '') {
                            $slide_title_bg_transparency = esc_attr(get_post_meta(get_the_ID(), "eltd_slide-title-bg-color-transparency", true));
                        } else {
                            $slide_title_bg_transparency = 1;
                        }
                        $slide_title_span_style .= 'background-color: ' . esc_attr(eltd_rgba_color($slide_title_bg_color, $slide_title_bg_transparency)) . ';';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide_title_padding_top', true) != '') {
                        $slide_title_span_style .= 'padding-top: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_title_padding_top', true)) . 'px;';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide_title_padding_right', true) != '') {
                        $slide_title_span_style .= 'padding-right: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_title_padding_right', true)) . 'px;';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide_title_padding_bottom', true) != '') {
                        $slide_title_span_style .= 'padding-bottom: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_title_padding_bottom', true)) . 'px;';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide_title_padding_left', true) != '') {
                        $slide_title_span_style .= 'padding-left: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_title_padding_left', true)) . 'px;';
                    }

                    $border_style = '';
                    if (get_post_meta(get_the_ID(), 'eltd_slide_title_border', true) != '' && get_post_meta(get_the_ID(), 'eltd_slide_title_border', true) == 'yes') {

                        if (get_post_meta(get_the_ID(), 'eltd_slide_title_border_thickness', true) != '') {
                            $border_style .= 'border-width: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_title_border_thickness', true)) . 'px;';
                        }
                        if (get_post_meta(get_the_ID(), 'eltd_slide_title_border_style', true) != '') {
                            $border_style .= 'border-style: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_title_border_style', true)) . ';';
                        }
                        if (get_post_meta(get_the_ID(), 'eltd_slider_title_border_color', true) != '') {
                            $border_style .= 'border-color: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slider_title_border_color', true)) . ';';
                        }
                        $slide_title_span_style .= $border_style;

                    }



                    //is separator after title option selected for current slide?
                    $slide_separator_position = '';
                    if (get_post_meta(get_the_ID(), "eltd_slide-separator-title", true) == 'yes') {

                        //init variables
                        $slide_separator_styles = '';
                        $slide_top_separator_styles = '';
                        $slide_bottom_separator_styles = '';

                        $slide_separator_position = "both";
                        $slide_separator_type_var = 'without_icon';
                        if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_type", true) !== "") {
                            $slide_separator_type_var = get_post_meta(get_the_ID(), "eltd_slide_title_separator_type", true);
                        }
                        if ($slide_separator_type_var == "without_icon") {

                            if (get_post_meta(get_the_ID(), "eltd_slide-title-separator-position", true) != "") {
                                $slide_separator_position = get_post_meta(get_the_ID(), "eltd_slide-title-separator-position", true);
                            }

                            $slide_separator_color = '';
                            if (get_post_meta(get_the_ID(), 'eltd_slide-separator-color', true) !== '') {
                                $slide_separator_color = esc_attr(get_post_meta(get_the_ID(), "eltd_slide-separator-color", true));
                            }
                            $slide_separator_transparency = '';
                            if (get_post_meta(get_the_ID(), 'eltd_slide-separator-transparency', true) !== '') {
                                $slide_separator_transparency = esc_attr(get_post_meta(get_the_ID(), "eltd_slide-separator-transparency", true));
                            }

                            //is separator color chosen?
                            if ($slide_separator_color !== '') {
                                //is separator transparenct set?
                                if ($slide_separator_transparency !== '') {
                                    //get rgba color value
                                    $slide_separator_rgba_color = eltd_rgba_color($slide_separator_color, $slide_separator_transparency);

                                    //set color style
                                    $slide_separator_styles .= 'background-color: ' . esc_attr($slide_separator_rgba_color) . ';';
                                } else {
                                    //set color without transparency
                                    $slide_separator_styles .= 'background-color: ' . esc_attr($slide_separator_color) . ';';
                                }
                            }

                            //is separator width set?
                            if (get_post_meta(get_the_ID(), 'eltd_slide-separator-width', true) != '') {
                                $slide_separator_styles .= 'width: ' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-separator-width", true)) . '%;';
                            }

                            //is separator width set?
                            if (get_post_meta(get_the_ID(), 'eltd_slide-separator-thickness', true) != '' && get_post_meta(get_the_ID(), 'eltd_slide-title-separator-position', true) !== 'left_right') {
                                $slide_separator_styles .= 'height: ' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-separator-thickness", true)) . 'px;';
                            }

                            //separator align
                            if ($slide_separator_position != 'left_right') {
                                if (get_post_meta(get_the_ID(), "eltd_slide-title-separator-align", true) != "") {
                                    $slide_separator_styles .= 'float:' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-title-separator-align", true)) . ';';
                                }
                            }


                            // separator border
                            $slide_separator_border_color = '';
                            if (get_post_meta(get_the_ID(), 'eltd_slide-separator-border-color', true) !== '') {
                                $slide_separator_border_color = esc_attr(get_post_meta(get_the_ID(), "eltd_slide-separator-border-color", true));
                            }
                            $slide_separator_border_width = '';
                            if (get_post_meta(get_the_ID(), 'eltd_slide-separator-border-width', true) !== '') {
                                $slide_separator_border_width = esc_attr(get_post_meta(get_the_ID(), "eltd_slide-separator-border-width", true));
                            }
                            $slide_separator_border_style = '';
                            if (get_post_meta(get_the_ID(), 'eltd_slide-separator-border-style', true) !== '') {
                                $slide_separator_border_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide-separator-border-style", true));
                            }

                            if ($slide_separator_border_color !== '' && $slide_separator_border_width !== '' && $slide_separator_border_style !== '' ) {
                                $slide_separator_styles .= 'border-top:' .esc_attr($slide_separator_border_width. 'px ' .$slide_separator_border_style. ' ' .$slide_separator_border_color).';';
                            }


                            // top separator
                            if (get_post_meta(get_the_ID(), "eltd_slide-title-separator-position", true) != "bottom") {

                                if (get_post_meta(get_the_ID(), 'eltd_slide-top-separator-margin-top', true) !== '') {
                                    $slide_top_separator_styles .= 'margin-top:' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-top-separator-margin-top", true)) . 'px;';
                                }
                                if (get_post_meta(get_the_ID(), 'eltd_slide-top-separator-margin-bottom', true) !== '') {
                                    $slide_top_separator_styles .= 'margin-bottom:' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-top-separator-margin-bottom", true)) . 'px;';
                                }
                            }

                            // bottom separator
                            if (get_post_meta(get_the_ID(), "eltd_slide-title-separator-position", true) != "top") {

                                if (get_post_meta(get_the_ID(), 'eltd_slide-bottom-separator-margin-top', true) !== '') {
                                    $slide_bottom_separator_styles .= 'margin-top:' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-bottom-separator-margin-top", true)) . 'px;';
                                }
                                if (get_post_meta(get_the_ID(), 'eltd_slide-bottom-separator-margin-bottom', true) !== '') {
                                    $slide_bottom_separator_styles .= 'margin-bottom:' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-bottom-separator-margin-bottom", true)) . 'px;';
                                }
                            }

                            //Left/right separator
                            if (get_post_meta(get_the_ID(), "eltd_slide-title-separator-position", true) == "left_right") {

                                $slide_left_separator_margin = '';
                                $slide_right_separator_margin = '';
                                $slide_dots_style = '';
                                $slide_dots_height = '';

                                $slide_separator_styles .= 'background: none;';

                                if ($slide_separator_transparency !== '') {
                                    $slide_separator_styles .= 'border-bottom-color:' . esc_attr($slide_separator_rgba_color) . ';';
                                } else {
                                    $slide_separator_styles .= 'border-bottom-color:' . esc_attr($slide_separator_color) . ';';
                                }

                                if (get_post_meta(get_the_ID(), 'eltd_slide-separator-thickness', true) !== '') {
                                    $slide_separator_styles .= 'border-bottom-width:' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-separator-thickness", true)) . 'px;';
                                }

                                if (get_post_meta(get_the_ID(), 'eltd_slide_left_right_separator_style', true) !== '') {
                                    $slide_separator_styles .= 'border-bottom-style:' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_left_right_separator_style", true)) . ';';
                                }

                                if (get_post_meta(get_the_ID(), 'eltd_slide_left_separator_margin_right', true) !== '') {
                                    $slide_left_separator_margin .= 'margin-right:' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_left_separator_margin_right", true)) . 'px;';
                                }
                                if (get_post_meta(get_the_ID(), 'eltd_slide_right_separator_margin_left', true) !== '') {
                                    $slide_right_separator_margin .= 'margin-left:' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_right_separator_margin_left", true)) . 'px;';
                                }

                                if (get_post_meta(get_the_ID(), 'eltd_slide_left_right_separator_linedots', true) == 'yes') {

                                    if (get_post_meta(get_the_ID(), 'eltd_slide_left_right_separator_line_dots_size', true) !== '') {
                                        $slide_dots_height = esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_left_right_separator_line_dots_size', true));
                                        $slide_dots_style .= 'height: ' . $slide_dots_height . 'px;';
                                        $slide_dots_style .= 'width: ' . $slide_dots_height . 'px;';
                                        $slide_dots_style .= 'top: ' . -ceil($slide_dots_height / 3) . 'px;';
                                    }
                                    if (get_post_meta(get_the_ID(), 'eltd_slide_left_right_separator_dots_color', true) !== '') {
                                        $slide_dots_style .= 'background-color: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_left_right_separator_dots_color', true)) . ';';
                                    }
                                }

                            }

                        }

                        $slide_separator_with_icon_params_array = array();
                        if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_type", true) == "with_icon") {

                            $slide_separator_position = "top";

                            $slide_separator_with_icon_params_array[] = "type='with_icon'";

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_pack", true) != ''){
                                $slide_separator_icon = get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_pack", true);

                                $slide_separator_with_icon_params_array[] = "icon_pack='".$slide_separator_icon."'";

                                $slide_separator_icon_param = $eltdIconCollections->getIconCollection($slide_separator_icon);

                                $icon_param = $slide_separator_icon_param->param;

                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_".$icon_param, true) !== ''){
                                $slide_separator_with_icon_params_array[] = $icon_param."='".esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_".$icon_param, true))."'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_line_style", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "border_style='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_line_style", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_separator_width", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "width='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_separator_width", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_separator_margin_top", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "up='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_separator_margin_top", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_separator_margin_bottom", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "down='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_separator_margin_bottom", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_separator_thickness", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "thickness='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_separator_thickness", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_separator_color", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "color='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_separator_color", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_type", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "icon_type='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_type", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_postition", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "separator_icon_position='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_postition", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_icon_custom_size', true) != '') {
                                $slide_separator_with_icon_params_array[] = "icon_custom_size='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_custom_size", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_icon_shape_size', true) != '') {
                                $slide_separator_with_icon_params_array[] = "icon_shape_size='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_shape_size", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_icon_margin', true) != '') {
                                $slide_separator_with_icon_params_array[] = "icon_margin='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_margin", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_icon_border_radius', true) != '') {
                                $slide_separator_with_icon_params_array[] = "icon_border_radius='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_border_radius", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_icon_color', true) != '') {
                                $slide_separator_with_icon_params_array[] = "icon_color='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_color", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_icon_border_color', true) != '') {
                                $slide_separator_with_icon_params_array[] = "icon_border_color='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_border_color", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_icon_border_width', true) != '') {
                                $slide_separator_with_icon_params_array[] = "icon_border_width='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_border_width", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_icon_background_color', true) != '') {
                                $slide_separator_with_icon_params_array[] = "icon_background_color='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_background_color", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_icon_hover_color', true) != '') {
                                $slide_separator_with_icon_params_array[] = "hover_icon_color='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_hover_color", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_icon_hover_border_color', true) != '') {
                                $slide_separator_with_icon_params_array[] = "hover_icon_border_color='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_hover_border_color", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_icon_hover_background_color', true) != '') {
                                $slide_separator_with_icon_params_array[] = "hover_icon_background_color='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_icon_hover_background_color", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_icon_position', true) != '') {
                                $slide_separator_position = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_icon_position", true));
                            }

                        }

                        if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_type", true) == "with_custom_icon") {

                            $slide_separator_position = "top";

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_custom_icon_position', true) != '') {
                                $slide_separator_position = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_position", true));
                            }

                            $slide_separator_with_icon_params_array[] = "type='with_custom_icon'";

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_custom_icon", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "custom_icon='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_custom_icon", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_line_style", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "border_style='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_line_style", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_separator_width", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "width='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_separator_width", true))."'";
                            }

                            $slide_separator_with_custom_icon_margin_top = '40';
                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_separator_margin_top", true) !== ''){
                                $slide_separator_with_custom_icon_margin_top = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_separator_margin_top", true));
                            }
                            $slide_separator_with_icon_params_array[] = "up='" . $slide_separator_with_custom_icon_margin_top . "'";

                            $slide_separator_with_custom_icon_margin_bottom = '40';
                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_separator_margin_bottom", true) !== ''){
                                $slide_separator_with_custom_icon_margin_bottom = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_separator_margin_bottom", true));
                            }
                            $slide_separator_with_icon_params_array[] = "down='".$slide_separator_with_custom_icon_margin_bottom."'";

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_separator_thickness", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "thickness='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_separator_thickness", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_separator_color", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "color='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_separator_color", true))."'";
                            }

                            if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_with_custom_icon_icon_margin', true) != '') {
                                $slide_separator_with_icon_params_array[] = "icon_margin='" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_icon_margin", true)) . "'";
                            }

                            if (get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_icon_postition", true) !== ''){
                                $slide_separator_with_icon_params_array[] = "separator_icon_position='". esc_attr(get_post_meta(get_the_ID(), "eltd_slide_title_separator_with_custom_icon_icon_postition", true))."'";
                            }

                        }
                    }

                    $slide_subtitle_style = "";
                    if (get_post_meta(get_the_ID(), "eltd_slide-subtitle-color", true) != "") {
                        $slide_subtitle_style .= "color: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-subtitle-color", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-subtitle-font-size", true) != "") {
                        $slide_subtitle_style .= "font-size: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-subtitle-font-size", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-subtitle-line-height", true) != "") {
                        $slide_subtitle_style .= "line-height: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-subtitle-line-height", true)) . "px;";
                    }
                    if ((get_post_meta(get_the_ID(), "eltd_slide-subtitle-font-family", true) !== "-1") && (get_post_meta(get_the_ID(), "eltd_slide-subtitle-font-family", true) !== "")) {
                        $slide_subtitle_style .= "font-family: '" . esc_attr(str_replace('+', ' ', get_post_meta(get_the_ID(), "eltd_slide-subtitle-font-family", true))) . "';";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-subtitle-font-style", true) != "") {
                        $slide_subtitle_style .= "font-style: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-subtitle-font-style", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-subtitle-font-weight", true) != "") {
                        $slide_subtitle_style .= "font-weight: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-subtitle-font-weight", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide-subtitle-letter-spacing', true) !== '') {
                        $slide_subtitle_style .= 'letter-spacing: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide-subtitle-letter-spacing', true)) . 'px;';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide-subtitle-text-transform', true) !== '') {
                        $slide_subtitle_style .= 'text-transform: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide-subtitle-text-transform', true)) . ';';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide-hide-shadow', true) == 'yes') {
                        $slide_subtitle_style .= 'text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide_subtitle_margin_bottom', true) != '') {
                        $slide_subtitle_style .= 'margin-bottom: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_subtitle_margin_bottom', true)) . 'px;';
                    }

                    $slide_subtitle_span_style = "";
                    if (get_post_meta(get_the_ID(), 'eltd_slide-subtitle-background-color', true) !== '') {
                        $slide_subtitle_bg_color = esc_attr(get_post_meta(get_the_ID(), "eltd_slide-subtitle-background-color", true));
                        if (get_post_meta(get_the_ID(), 'eltd_slide-subtitle-bg-color-transparency', true) != '') {
                            $slide_subtitle_bg_transparency = esc_attr(get_post_meta(get_the_ID(), "eltd_slide-subtitle-bg-color-transparency", true));
                        } else {
                            $slide_subtitle_bg_transparency = 1;
                        }
                        $slide_subtitle_span_style .= 'background-color: ' . esc_attr(eltd_rgba_color($slide_subtitle_bg_color, $slide_subtitle_bg_transparency)) . ';';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide_subtitle_padding_top', true) != '') {
                        $slide_subtitle_span_style .= 'padding-top: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_subtitle_padding_top', true)) . 'px;';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide_subtitle_padding_right', true) != '') {
                        $slide_subtitle_span_style .= 'padding-right: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_subtitle_padding_right', true)) . 'px;';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide_subtitle_padding_bottom', true) != '') {
                        $slide_subtitle_span_style .= 'padding-bottom: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_subtitle_padding_bottom', true)) . 'px;';
                    }
                    if (get_post_meta(get_the_ID(), 'eltd_slide_subtitle_padding_left', true) != '') {
                        $slide_subtitle_span_style .= 'padding-left: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_subtitle_padding_left', true)) . 'px;';
                    }

                    $slide_text_style = "";
                    $slide_text_span_style = "";
                    $slide_text_separator_var = 'no';
                    if (get_post_meta(get_the_ID(), "text_separator_text", true) !=='') {
                        $slide_text_separator_var = get_post_meta(get_the_ID(), "text_separator_text", true);
                    }

                    if ($slide_text_separator_var == "no") {
                        if (get_post_meta(get_the_ID(), "eltd_slide-text-color", true) != "") {
                            $slide_text_style .= "color: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-color", true)) . ";";
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-text-font-size", true) != "") {
                            $slide_text_style .= "font-size: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-font-size", true)) . "px;";
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-text-line-height", true) != "") {
                            $slide_text_style .= "line-height: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-line-height", true)) . "px;";
                        }
                        if ((get_post_meta(get_the_ID(), "eltd_slide-text-font-family", true) !== "-1") && (get_post_meta(get_the_ID(), "eltd_slide-text-font-family", true) !== "")) {
                            $slide_text_style .= "font-family: '" . esc_attr(str_replace('+', ' ', get_post_meta(get_the_ID(), "eltd_slide-text-font-family", true))) . "';";
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-text-font-style", true) != "") {
                            $slide_text_style .= "font-style: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-font-style", true)) . ";";
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-text-font-weight", true) != "") {
                            $slide_text_style .= "font-weight: " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-font-weight", true)) . ";";
                        }
                        if (get_post_meta(get_the_ID(), 'eltd_slide-text-letter-spacing', true) !== '') {
                            $slide_text_style .= 'letter-spacing: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide-text-letter-spacing', true)) . 'px;';
                        }
                        if (get_post_meta(get_the_ID(), 'eltd_slide-text-text-transform', true) !== '') {
                            $slide_text_style .= 'text-transform: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide-text-text-transform', true)) . ';';
                        }
                        if (get_post_meta(get_the_ID(), 'eltd_slide-hide-shadow', true) == 'yes') {
                            $slide_text_style .= 'text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.4);';
                        }
                        if (get_post_meta(get_the_ID(), 'eltd_slide-text-background-color', true) !== '') {
                            $slide_text_bg_color = esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-background-color", true));
                            if (get_post_meta(get_the_ID(), 'eltd_slide-text-bg-color-transparency', true) != '') {
                                $slide_text_bg_transparency = esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-bg-color-transparency", true));
                            } else {
                                $slide_text_bg_transparency = 1;
                            }
                            $slide_text_span_style .= 'background-color: ' . esc_attr(eltd_rgba_color($slide_text_bg_color, $slide_text_bg_transparency)) . ';';
                        }
                        if (get_post_meta(get_the_ID(), 'eltd_slide_text_padding_top', true) != '') {
                            $slide_text_span_style .= 'padding-top: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_text_padding_top', true)) . 'px;';
                        }
                        if (get_post_meta(get_the_ID(), 'eltd_slide_text_padding_right', true) != '') {
                            $slide_text_span_style .= 'padding-right: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_text_padding_right', true)) . 'px;';
                        }
                        if (get_post_meta(get_the_ID(), 'eltd_slide_text_padding_bottom', true) != '') {
                            $slide_text_span_style .= 'padding-bottom: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_text_padding_bottom', true)) . 'px;';
                        }
                        if (get_post_meta(get_the_ID(), 'eltd_slide_text_padding_left', true) != '') {
                            $slide_text_span_style .= 'padding-left: ' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide_text_padding_left', true)) . 'px;';
                        }
                    }


                    $slide_text_with_separator_array = array();
                    if ($slide_text_separator_var == 'yes') {

                        if (get_post_meta(get_the_ID(), 'eltd_slide-text', true) != '') {
                            $slide_text_with_separator_array[] = 'title="' . esc_attr(get_post_meta(get_the_ID(), 'eltd_slide-text', true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-text-color", true) != "") {
                            $slide_text_with_separator_array[] = 'title_color="' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-color", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-text-color", true) != "") {
                            $slide_text_with_separator_array[] = 'title_size="' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-font-size", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-text-color", true) != "") {
                            $slide_text_with_separator_array[] = 'box_height="' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-line-height", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_text_in_box", true) != "") {
                            $slide_text_with_separator_array[] = 'text_in_box="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_text_in_box", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_box_border_style", true) != "") {
                            $slide_text_with_separator_array[] = 'box_border_style="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_box_border_style", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_line_border_style", true) != "") {
                            $slide_text_with_separator_array[] = 'line_border_style="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_line_border_style", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_linedots", true) != "") {
                            $slide_text_with_separator_array[] = 'line_dots="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_linedots", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_line_width", true) != "") {
                            $slide_text_with_separator_array[] = 'line_width="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_line_width", true)) . '"';
                        }

                        $line_thickness = '3';
                        if (get_post_meta(get_the_ID(), "eltd_separator_line_thickness", true) != "") {
                            $line_thickness = esc_attr(get_post_meta(get_the_ID(), "eltd_separator_line_thickness", true));
                        }
                        $slide_text_with_separator_array[] = 'line_thickness="' . $line_thickness . '"';

                        if (get_post_meta(get_the_ID(), "eltd_separator_line_dots_size", true) != "") {
                            $slide_text_with_separator_array[] = 'line_dots_size="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_line_dots_size", true)) . '"';
                        }

                        $line_color = '#fff';
                        if (get_post_meta(get_the_ID(), "eltd_separator_line_color", true) != "") {
                            $line_color = esc_attr(get_post_meta(get_the_ID(), "eltd_separator_line_color", true));
                        }
                        $slide_text_with_separator_array[] = 'line_color="' . $line_color . '"';

                        if (get_post_meta(get_the_ID(), "eltd_separator_dots_color", true) != "") {
                            $slide_text_with_separator_array[] = 'line_dots_color="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_dots_color", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_text_position", true) != "") {
                            $slide_text_with_separator_array[] = 'text_position="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_text_position", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_text_leftright_padding", true) != "") {
                            $slide_text_with_separator_array[] = 'box_padding="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_text_leftright_padding", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_text_top_margin", true) != "") {
                            $slide_text_with_separator_array[] = 'up="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_text_top_margin", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_text_bottom_margin", true) != "") {
                            $slide_text_with_separator_array[] = 'down="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_text_bottom_margin", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_box_margin", true) != "") {
                            $slide_text_with_separator_array[] = 'box_margin="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_box_margin", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-text-background-color", true) != "") {
                            $slide_text_with_separator_array[] = 'box_background_color="' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-background-color", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_box_border_width", true) != "") {
                            $slide_text_with_separator_array[] = 'box_border_width="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_box_border_width", true)) . '"';
                        } else {
                            $slide_text_with_separator_array[] = 'box_border_width="' . $line_thickness . '"';
                        }

                        if (get_post_meta(get_the_ID(), "eltd_separator_box_border_radius", true) != "") {
                            $slide_text_with_separator_array[] = 'box_border_radius="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_box_border_radius", true)) . '"';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_separator_box_border_color", true) != "") {
                            $slide_text_with_separator_array[] = 'box_border_color="' . esc_attr(get_post_meta(get_the_ID(), "eltd_separator_box_border_color", true)) . '"';
                        } else {
                            $slide_text_with_separator_array[] = 'box_border_color="' . $line_color . '"';
                        }

                    }

                    $content_predefined_position = get_post_meta(get_the_ID(), "eltd_slide_predefined_content_position", true);
                    $graphic_alignment = get_post_meta(get_the_ID(), "eltd_slide-graphic-alignment", true);
                    $content_alignment = get_post_meta(get_the_ID(), "eltd_slide-content-alignment", true);

                    $separate_text_graphic = 'no';
                    if($content_predefined_position == ""){
                        $separate_text_graphic = get_post_meta(get_the_ID(), "eltd_slide-separate-text-graphic", true);
                    }

                    $animate_image_class = "";
                    $animate_image_data = "";
                    if (get_post_meta(get_the_ID(), "eltd_enable_image_animation", true) == "yes") {
                        $animate_image_class .= "animate_image ";
                        $animate_image_class .= get_post_meta(get_the_ID(), "eltd_enable_image_animation_type", true);
                        $animate_image_data .= "data-animate_image='".get_post_meta(get_the_ID(), "eltd_enable_image_animation_type", true)."'";
                    }

                    $content_full_width_class = "";
                    if (get_post_meta(get_the_ID(), "eltd_slide-content-full-width", true) == "yes") {
                        $content_full_width_class = "slide_full_width";
                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide-content-vertical-middle-type", true) == 'window_top') {
                        $slide_item_padding_value = 0;
                    } else {
                        $slide_item_padding_value = $header_height + $menu_bottom + $header_top;
                        if ((isset($eltd_options['center_logo_image']) && $eltd_options['center_logo_image'] == "yes" && $eltd_options['header_bottom_appearance'] !== 'stick menu_bottom' && $eltd_options['header_bottom_appearance'] !== 'stick_with_left_right_menu') || $eltd_options['header_bottom_appearance'] == "fixed_hiding") {
                            $slide_item_padding_value = $logo_height + 20 + $header_height + $menu_bottom + $header_top; // 20 is top margin of centered logo
                        }
                    }

                    $content_vertical_middle_position_class = "";
                    $slide_item_padding = "";

                    if (get_post_meta(get_the_ID(), "eltd_slide-content-vertical-middle", true) == "yes" && $content_predefined_position == "") {
                        $content_vertical_middle_position_class = "content_vertical_middle";
                        $slide_item_padding = "padding-top: " . esc_attr($slide_item_padding_value) . "px;";
                        $content_width = "";
                        $content_xaxis = "";
                        $content_yaxis_start = "";
                        $content_yaxis_end = "";
                        $graphic_width = "";
                        $graphic_xaxis = "";
                        $graphic_yaxis_start = "";
                        $graphic_yaxis_end = "";
                    } else {
                        if($content_predefined_position != ""){
                            if(get_post_meta(get_the_ID(), "eltd_slide_predefined_content_position_width", true) != ""){
                                $content_width = "width:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide_predefined_content_position_width", true)) . "px;";
                            }else{
                                $content_width = "width:auto;";
                            }
                        }else{
                            if (get_post_meta(get_the_ID(), "eltd_slide-content-width", true) != "") {
                                $content_width = "width:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-content-width", true)) . "%;";
                            } else {
                                $content_width = "width:80%;";
                            }
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-content-left", true) != "") {
                            $content_xaxis = "left:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-content-left", true)) . "%;";
                        } else {
                            if (get_post_meta(get_the_ID(), "eltd_slide-content-right", true) != "") {
                                $content_xaxis = "right:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-content-right", true)) . "%;";
                            } else {
                                $content_xaxis = "left: 10%;";
                            }
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-content-top", true) != "") {
                            $content_yaxis_start = "top:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-content-top", true)) . "%;";
                            $content_yaxis_end = "top:" . (esc_attr(get_post_meta(get_the_ID(), "eltd_slide-content-top", true)) - 10) . "%;";
                        } else {
                            if (get_post_meta(get_the_ID(), "eltd_slide-content-bottom", true) != "") {
                                $content_yaxis_start = "bottom:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-content-bottom", true)) . "%;";
                                $content_yaxis_end = "bottom:" . (esc_attr(get_post_meta(get_the_ID(), "eltd_slide-content-bottom", true)) + 10) . "%;";
                            } else {
                                $content_yaxis_start = "top: 35%;";
                                $content_yaxis_end = "top: 10%;";
                            }
                        }

                        if (get_post_meta(get_the_ID(), "eltd_slide-graphic-width", true) != "") {
                            $graphic_width = "width:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-graphic-width", true)) . "%;";
                        } else {
                            $graphic_width = "width:50%;";
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-graphic-left", true) != "") {
                            $graphic_xaxis = "left:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-graphic-left", true)) . "%;";
                        } else {
                            if (get_post_meta(get_the_ID(), "eltd_slide-graphic-right", true) != "") {
                                $graphic_xaxis = "right:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-graphic-right", true)) . "%;";
                            } else {
                                $graphic_xaxis = "left: 25%;";
                            }
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-graphic-top", true) != "") {
                            $graphic_yaxis_start = "top:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-graphic-top", true)) . "%;";
                            $graphic_yaxis_end = "top:" . (esc_attr(get_post_meta(get_the_ID(), "eltd_slide-graphic-top", true)) - 10) . "%;";
                        } else {
                            if (get_post_meta(get_the_ID(), "eltd_slide-graphic-bottom", true) != "") {
                                $graphic_yaxis_start = "bottom:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-graphic-bottom", true)) . "%;";
                                $graphic_yaxis_end = "bottom:" . (esc_attr(get_post_meta(get_the_ID(), "eltd_slide-graphic-bottom", true)) + 10) . "%;";
                            } else {
                                $graphic_yaxis_start = "top: 30%;";
                                $graphic_yaxis_end = "top: 10%;";
                            }
                        }
                    }

                    //General Animation Start
                    $slide_data_start = '';
                    $slide_data_end = '';
                    $slide_title_data = '';
                    $slide_subtitle_data = '';
                    $slide_graphics_data = '';
                    $slide_text_data = '';
                    $slide_button_1_data = '';
                    $slide_button_2_data = '';
                    $slide_separator_top_data = '';
                    $slide_separator_bottom_data = '';
                    $slide_svg_data = '';


                    $eltd_slide_general_animation_var = "yes";
                    if (get_post_meta(get_the_ID(), "eltd_slide_general_animation", true) === "no") {
                        $eltd_slide_general_animation_var = "no";
                    }

                    if ($eltd_slide_general_animation_var === "yes") {

                        //Default values for data start and data end animation
                        $eltd_slide_data_start = '0';
                        $eltd_slide_data_end = '300';
                        $eltd_slide_data_start_custom_style = ' opacity: 1;';
                        $eltd_slide_data_end_custom_style = ' opacity: 0;';


                        if (get_post_meta(get_the_ID(), "eltd_slide_data_start", true) != "") {
                            $eltd_slide_data_start = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_start", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_start_custom_style", true) != "") {
                            $eltd_slide_data_start_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_start_custom_style", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_end", true) != "") {
                            $eltd_slide_data_end = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_end", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_end_custom_style", true) != "") {
                            $eltd_slide_data_end_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_end_custom_style", true));
                        }

                        $slide_data_start = ' data-' . $eltd_slide_data_start . '="' . $eltd_slide_data_start_custom_style . ' ' . $content_width . ' ' . $content_xaxis . ' ' . $content_yaxis_start . '"';
                        $slide_data_end = ' data-' . $eltd_slide_data_end . '="' . $eltd_slide_data_end_custom_style . ' ' . $content_xaxis . ' ' . $content_yaxis_end . '"';

                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide_title_animation_scroll", true) == "yes") {

                        //Title options
                        $slide_title_data_start = '0';
                        $slide_title_data_start_custom_style = ' opacity: 1;';
                        $slide_title_data_end = '300';
                        $slide_title_data_end_custom_style = ' opacity:0;';

                        if (get_post_meta(get_the_ID(), "eltd_slide_data_title_start", true) != "") {
                            $slide_title_data_start = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_title_start", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_title_start_custom_style", true) != "") {
                            $slide_title_data_start_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_title_start_custom_style", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_title_end", true) != "") {
                            $slide_title_data_end = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_title_end", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_title_end_custom_style", true) != "") {
                            $slide_title_data_end_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_title_end_custom_style", true));
                        }

                        $slide_title_data = 'data-' . $slide_title_data_start . '="' . $slide_title_data_start_custom_style . '" data-' . $slide_title_data_end . '="' . $slide_title_data_end_custom_style . '"';

                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide_subtitle_animation_scroll", true) == "yes") {

                        //Subtitle options
                        $slide_subtitle_data_start = '0';
                        $slide_subtitle_data_start_custom_style = ' opacity: 1;';
                        $slide_subtitle_data_end = '300';
                        $slide_subtitle_data_end_custom_style = ' opacity:0;';


                        if (get_post_meta(get_the_ID(), "eltd_slide_data_subtitle_start", true) != "") {
                            $slide_subtitle_data_start = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_subtitle_start", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_subtitle_start_custom_style", true) != "") {
                            $slide_subtitle_data_start_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_subtitle_start_custom_style", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_subtitle_end", true) != "") {
                            $slide_subtitle_data_end = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_subtitle_end", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_subtitle_end_custom_style", true) != "") {
                            $slide_subtitle_data_end_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_subtitle_end_custom_style", true));
                        }

                        $slide_subtitle_data = 'data-' . $slide_subtitle_data_start . '="' . $slide_subtitle_data_start_custom_style . '" data-' . $slide_subtitle_data_end . '="' . $slide_subtitle_data_end_custom_style . '"';

                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide_graphic_animation_scroll", true) == "yes") {

                        //Graphics options
                        $slide_graphics_data_start = '0';
                        $slide_graphics_data_start_custom_style = ' opacity: 1;';
                        $slide_graphics_data_end = '300';
                        $slide_graphics_data_end_custom_style = ' opacity: 0;';

                        if (get_post_meta(get_the_ID(), "eltd_slide_data_graphics_start", true) != "") {
                            $slide_graphics_data_start = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_graphics_start", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_graphics_start_custom_style", true) != "") {
                            $slide_graphics_data_start_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_graphics_start_custom_style", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_graphics_end", true) != "") {
                            $slide_graphics_data_end = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_graphics_end", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_graphics_end_custom_style", true) != "") {
                            $slide_graphics_data_end_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_graphics_end_custom_style", true));
                        }

                        $slide_graphics_data = 'data-' . $slide_graphics_data_start . '="' . $slide_graphics_data_start_custom_style . '" data-' . $slide_graphics_data_end . '="' . $slide_graphics_data_end_custom_style . '"';

                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide_text_animation_scroll", true) == "yes") {

                        //Text options
                        $slide_text_data_start = '0';
                        $slide_text_data_start_custom_style = ' opacity: 1;';
                        $slide_text_data_end = '300';
                        $slide_text_data_end_custom_style = ' opacity: 0;';

                        if (get_post_meta(get_the_ID(), "eltd_slide_data_text_start", true) != "") {
                            $slide_text_data_start = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_text_start", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_text_start_custom_style", true) != "") {
                            $slide_text_data_start_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_text_start_custom_style", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_text_end", true) != "") {
                            $slide_text_data_end = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_text_end", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_text_end_custom_style", true) != "") {
                            $slide_text_data_end_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_text_end_custom_style", true));
                        }

                        $slide_text_data = 'data-' . $slide_text_data_start . '="' . $slide_text_data_start_custom_style . '" data-' . $slide_text_data_end . '="' . $slide_text_data_end_custom_style . '"';

                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide_button1_animation_scroll", true) == "yes") {

                        //Button 1 options
                        $slide_button_1_data_start = '0';
                        $slide_button_1_data_start_custom_style = ' opacity: 1;';
                        $slide_button_1_data_end = '300';
                        $slide_button_1_data_end_custom_style = ' opacity: 0;';

                        if (get_post_meta(get_the_ID(), "eltd_slide_data_button_1_start", true) != "") {
                            $slide_button_1_data_start = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_button_1_start", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_button_1_start_custom_style", true) != "") {
                            $slide_button_1_data_start_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_button_1_start_custom_style", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_button_1_end", true) != "") {
                            $slide_button_1_data_end = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_button_1_end", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_button_1_end_custom_style", true) != "") {
                            $slide_button_1_data_end_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_button_1_end_custom_style", true));
                        }

                        $slide_button_1_data = 'data-' . $slide_button_1_data_start . '="' . $slide_button_1_data_start_custom_style . '" data-' . $slide_button_1_data_end . '="' . $slide_button_1_data_end_custom_style . '"';

                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide_button2_animation_scroll", true) == "yes") {

                        //Button 2 options
                        $slide_button_2_data_start = '0';
                        $slide_button_2_data_start_custom_style = ' opacity: 1;';
                        $slide_button_2_data_end = '300';
                        $slide_button_2_data_end_custom_style = ' opacity: 0;';

                        if (get_post_meta(get_the_ID(), "eltd_slide_data_button_2_start", true) != "") {
                            $slide_button_2_data_start = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_button_2_start", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_button_2_start_custom_style", true) != "") {
                            $slide_button_2_data_start_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_button_2_start_custom_style", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_button_2_end", true) != "") {
                            $slide_button_2_data_end = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_button_2_end", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_button_2_end_custom_style", true) != "") {
                            $slide_button_2_data_end_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_button_2_end_custom_style", true));
                        }

                        $slide_button_2_data = 'data-' . $slide_button_2_data_start . '="' . $slide_button_2_data_start_custom_style . '" data-' . $slide_button_2_data_end . '="' . $slide_button_2_data_end_custom_style . '"';

                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide_separator_top_animation_scroll", true) == "yes") {

                        //Separator top options
                        $slide_separator_top_data_start = '0';
                        $slide_separator_top_data_start_custom_style = ' opacity: 1;';
                        $slide_separator_top_data_end = '300';
                        $slide_separator_top_data_end_custom_style = ' opacity: 0;';

                        if (get_post_meta(get_the_ID(), "eltd_slide_data_separator_top_start", true) != "") {
                            $slide_separator_top_data_start = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_separator_top_start", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_separator_top_start_custom_style", true) != "") {
                            $slide_separator_top_data_start_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_separator_top_start_custom_style", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_separator_top_end", true) != "") {
                            $slide_separator_top_data_end = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_separator_top_end", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_separator_top_end_custom_style", true) != "") {
                            $slide_separator_top_data_end_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_separator_top_end_custom_style", true));
                        }

                        $slide_separator_top_data = 'data-' . $slide_separator_top_data_start . '="' . $slide_separator_top_data_start_custom_style . '" data-' . $slide_separator_top_data_end . '="' . $slide_separator_top_data_end_custom_style . '"';

                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide_separator_bottom_animation_scroll", true) == "yes") {

                        //Separator bottom options
                        $slide_separator_bottom_data_start = '0';
                        $slide_separator_bottom_data_start_custom_style = ' opacity: 1;';
                        $slide_separator_bottom_data_end = '300';
                        $slide_separator_bottom_data_end_custom_style = ' opacity: 0;';

                        if (get_post_meta(get_the_ID(), "eltd_slide_data_separator_bottom_start", true) != "") {
                            $slide_separator_bottom_data_start = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_separator_bottom_start", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_separator_bottom_start_custom_style", true) != "") {
                            $slide_separator_bottom_data_start_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_separator_bottom_start_custom_style", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_separator_bottom_end", true) != "") {
                            $slide_separator_bottom_data_end = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_separator_bottom_end", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_separator_bottom_end_custom_style", true) != "") {
                            $slide_separator_bottom_data_end_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_separator_bottom_end_custom_style", true));
                        }

                        $slide_separator_bottom_data = 'data-' . $slide_separator_bottom_data_start . '="' . $slide_separator_bottom_data_start_custom_style . '" data-' . $slide_separator_bottom_data_end . '="' . $slide_separator_bottom_data_end_custom_style . '"';

                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide_svg_animation_scroll", true) == "yes") {

                        //SVG options
                        $slide_svg_data_start = '0';
                        $slide_svg_data_start_custom_style = ' opacity: 1;';
                        $slide_svg_data_end = '300';
                        $slide_svg_data_end_custom_style = ' opacity: 0;';

                        if (get_post_meta(get_the_ID(), "eltd_slide_data_svg_start", true) != "") {
                            $slide_svg_data_start = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_svg_start", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_svg_start_custom_style", true) != "") {
                            $slide_svg_data_start_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_svg_start_custom_style", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_svg_end", true) != "") {
                            $slide_svg_data_end = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_svg_end", true));
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide_data_svg_end_custom_style", true) != "") {
                            $slide_svg_data_end_custom_style = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_data_svg_end_custom_style", true));
                        }

                        $slide_svg_data = 'data-' . $slide_svg_data_start . '="' . $slide_svg_data_start_custom_style . '" data-' . $slide_svg_data_end . '="' . $slide_svg_data_end_custom_style . '"';

                    }



                    //SVG
                    $svg = '';
                    $svg_frame_rate = '';
                    if (get_post_meta(get_the_ID(), "eltd_slide_svg_source", true) != "") {
                        $svg = get_post_meta(get_the_ID(), "eltd_slide_svg_source", true);
                    }
                    $svg_drawing = "no";
                    if (get_post_meta(get_the_ID(), "eltd_slide_svg_drawing", true) == "yes") {
                        $svg_drawing = get_post_meta(get_the_ID(), "eltd_slide_svg_drawing", true);

                        $svg_frame_rate = '100';
                        if (get_post_meta(get_the_ID(), "eltd_slide_svg_frame_rate", true) !== "") {
                            $svg_frame_rate = esc_attr(get_post_meta(get_the_ID(), "eltd_slide_svg_frame_rate", true));
                        }
                    }


                    $header_style = "";
                    if (get_post_meta(get_the_ID(), "eltd_slide-header-style", true) != "") {
                        $header_style = get_post_meta(get_the_ID(), "eltd_slide-header-style", true);
                    }

                    $thumbnail_class = "";
                    if ($thumbnail !== "") {
                        $thumbnail_class = "has_thumbnail";
                    }

                    $title = get_the_title();

                    $html .= '<div class="item ' . $header_style . ' ' . $thumbnail_class . ' ' . $content_vertical_middle_position_class . ' ' . $content_full_width_class . ' '.$animate_image_class.'" style="' . $slide_height . ' ' . $slide_item_padding . '" '.$animate_image_data.'>';
                    if ($slide_type == 'video') {

                        $html .= '<div class="video"><div class="mobile-video-image" '.eltd_get_inline_style('background-image: url(' . esc_url($video_image) . ')').'></div><div class="video-overlay';
                        if ($video_overlay == "yes") {
                            $html .= ' active';
                        }
                        $html .= '"';
                        if ($video_overlay_image != "") {
                            $html .= ' style="background-image:url(' . esc_url($video_overlay_image) . ');"';
                        }
                        $html .= '>';
                        if ($video_overlay_image != "") {
                            $html .= '<img src="' . esc_url($video_overlay_image) . '" alt="" />';
                        } else {
                            $html .= '<img src="' . esc_url(get_template_directory_uri()) . '/css/img/pixel-video.png" alt="" />';
                        }
                        $html .= '</div><div class="video-wrap">

									<video class="video" width="1920" height="800" poster="' . esc_url($video_image) . '" controls="controls" preload="auto" loop autoplay muted>';
                        if (!empty($video_webm)) {
                            $html .= '<source type="video/webm" src="' . esc_url($video_webm) . '">';
                        }
                        if (!empty($video_mp4)) {
                            $html .= '<source type="video/mp4" src="' . esc_url($video_mp4) . '">';
                        }
                        if (!empty($video_ogv)) {
                            $html .= '<source type="video/ogg" src="' . esc_url($video_ogv) . '">';
                        }
                        $html .='<object width="320" height="240" type="application/x-shockwave-flash" data="' . esc_url(get_template_directory_uri()) . '/js/flashmediaelement.swf">
													<param name="movie" value="' . esc_url(get_template_directory_uri()) . '/js/flashmediaelement.swf" />
													<param name="flashvars" value="controls=true&amp;file=' . esc_url($video_mp4) . '" />
													<img src="' . esc_url($video_image) . '" width="1920" height="800" title="No video playback capabilities" alt="Video thumb" />
											</object>
									</video>
							</div></div>';
                    } else {
                        $html .= '<div class="image" '.eltd_get_inline_style('background-image:url(' . esc_url($image) . ')').'>';
                        if ($slider_thumbs == 'no') {
                            $html .= '<img src="' . esc_url($image) . '" alt="' . esc_attr($title) . '">';
                        }

                        if ($image_overlay_pattern !== "") {
                            $html .= '<div class="image_pattern" '.eltd_get_inline_style('background: url(' . esc_url($image_overlay_pattern) . ') repeat 0 0').'></div>';
                        }
                        $html .= '</div>';
                    }

                    $html_thumb = "";
                    if ($thumbnail != "") {
                        $html_thumb .= '<div '.$slide_graphics_data.'>';
                        $html_thumb .= '<div class="thumb ' . esc_attr($thumbnail_animation) . '">';
                        if ($thumbnail_link != "") {
                            $html_thumb .= '<a href="' . esc_url($thumbnail_link) . '" target="_self">';
                        }

                        $html_thumb .= '<img data-width="'.esc_attr($thumbnail_attributes_width).'" data-height="'.esc_attr($thumbnail_attributes_height).'" src="' . esc_url($thumbnail) . '" alt="' . esc_attr($title) . '">';

                        if ($thumbnail_link != "") {
                            $html_thumb .= '</a>';
                        }
                        $html_thumb .= '</div></div>';
                    }

                    //SVG
                    if ( $svg != "" ) {
                        $html_thumb .= '<div '.$slide_svg_data.'>';
                        $html_thumb .= '<div class="eltd_slide-svg-holder" data-svg-drawing="'.$svg_drawing.'" data-svg-frames="'.$svg_frame_rate.'">';

                        if ($svg_link != "") {
                            $html_thumb .= '<a href="' . esc_url($svg_link) . '" target="_self">';
                        }

                        $html_thumb .= $svg;

                        if ($svg_link != "") {
                            $html_thumb .= '</a>';
                        }

                        $html_thumb .= '</div></div>';
                    }

                    $html_text = "";
                    $html_text .= '<div class="text ' . esc_attr($content_animation . ' ' . $content_animation_direction . ' '. $padding_responsive_class) .'" style="' . esc_attr($slide_content_style) . '">';

                    if (get_post_meta(get_the_ID(), "eltd_slide-subtitle", true) != "") {
                        $html_text .= '<div class="el">';
                        $html_text .= '<div '.$slide_subtitle_data.'>';
                        $html_text .= '<h3 class="eltd_slide_subtitle" '.eltd_get_inline_style($slide_subtitle_style).'><span '.eltd_get_inline_style($slide_subtitle_span_style).'>' . wp_kses_post(get_post_meta(get_the_ID(), 'eltd_slide-subtitle', true)) . '</span></h3>';
                        $html_text .= '</div></div>';
                    }

                    if ((get_post_meta(get_the_ID(), "eltd_slide-separator-title", true) == 'yes') && ($slide_separator_position != 'bottom' ) && ($slide_separator_position) != 'left_right') {
                        //append separator html
                        if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_type', true) !== 'with_icon' && get_post_meta(get_the_ID(), 'eltd_slide_title_separator_type', true) !== 'with_custom_icon') {
                            $html_text .= '<div class="el">';
                            $html_text .= '<div '.$slide_separator_top_data.'>';
                            $html_text .= '<div '.eltd_get_inline_style($slide_separator_styles.$slide_top_separator_styles).' class="separator separator_top"></div>';
                            $html_text .= '</div></div>';
                        }
                        else {
                            $html_text .= '<div class="el">';
                            $html_text .= '<div ' . $slide_separator_top_data . ' >';
                            $html_text .= do_shortcode('[no_separator_with_icon ' . implode(' ', $slide_separator_with_icon_params_array) .  ']');
                            $html_text .= '</div></div>';
                        }

                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide-hide-title", true) != true) {
                        $html_text .= '<div class="el"><div '.$slide_title_data.'>';
                        $html_text .= '<h2 class="eltd_slide_title" '.eltd_get_inline_style($slide_title_style).'>';
                        if ($slide_separator_position == 'left_right') {
                            $html_text .= '<span '.eltd_get_inline_style($slide_separator_styles
                                    .$slide_left_separator_margin).' class="separator separator_left"><span class="slide_separator_dots" '.eltd_get_inline_style($slide_dots_style).'></span></span>';
                        }
                        if (get_post_meta(get_the_ID(), "eltd_slide-title-link", true) != '') {
                            $html_text .= '<a '.eltd_get_inline_style($slide_title_style).' '.$slide_title_data.' href="' . esc_url(get_post_meta(get_the_ID(), "eltd_slide-title-link", true)) . '" target="' . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-title-target", true)) . '">';
                        }
                        $html_text .= '<span '.eltd_get_inline_style($slide_title_span_style).'>' . wp_kses_post(get_the_title()) . '</span>';
                        if (get_post_meta(get_the_ID(), "eltd_slide-title-link", true) != '') {
                            $html_text .= '</a>';
                        }
                        if ($slide_separator_position == 'left_right') {
                            $html_text .= '<span '.eltd_get_inline_style($slide_separator_styles.$slide_right_separator_margin).' class="separator separator_right"><span class="slide_separator_dots" '.eltd_get_inline_style($slide_dots_style).'></span></span>';
                        }
                        $html_text .= '</h2></div></div>';
                    }

                    if ((get_post_meta(get_the_ID(), "eltd_slide-separator-title", true) == 'yes') && ($slide_separator_position != 'top') && ($slide_separator_position) != 'left_right') {
                        //append separator html
                        if (get_post_meta(get_the_ID(), 'eltd_slide_title_separator_type', true) !== 'with_icon' && get_post_meta(get_the_ID(), 'eltd_slide_title_separator_type', true) !== 'with_custom_icon') {
                            $html_text .= '<div class="el">';
                            $html_text .= '<div ' . $slide_separator_bottom_data . '>';
                            $html_text .= '<div '.eltd_get_inline_style($slide_separator_styles.$slide_bottom_separator_styles).'  class="separator separator_bottom"></div>';
                            $html_text .= '</div></div>';
                        }
                        else {
                            $html_text .= '<div class="el">';
                            $html_text .= '<div ' . $slide_separator_bottom_data . ' >';
                            $html_text .= do_shortcode('[no_separator_with_icon ' . implode(' ', $slide_separator_with_icon_params_array) .  ']');
                            $html_text .= '</div></div>';
                        }
                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide-text", true) != "") {
                        $html_text .= '<div class="el"><div '.$slide_text_data.'>';
                        if ($slide_text_separator_var == 'yes') {
                            $html_text .= do_shortcode('[vc_text_separator ' . implode(' ', $slide_text_with_separator_array ) . ']');
                        } else {
                            $html_text .= '<h3 class="eltd_slide_text" '.eltd_get_inline_style($slide_text_style).'><span '.eltd_get_inline_style($slide_text_span_style).'>' . wp_kses_post(get_post_meta(get_the_ID(), "eltd_slide-text", true)) . '</span></h3>';
                        }
                        $html_text .= '</div></div>';
                    }

                    //check if first button should be displayed
                    $is_first_button_shown = (get_post_meta(get_the_ID(), "eltd_slide-button-label", true) != "" || get_post_meta(get_the_ID(), "button1_icon_pack", true))
                        && get_post_meta(get_the_ID(), "eltd_slide-button-link", true) != "";

                    //check if second button should be displayed
                    $is_second_button_shown = (get_post_meta(get_the_ID(), "eltd_slide-button-label2", true) != "" || get_post_meta(get_the_ID(), "button2_icon_pack", true))
                        && get_post_meta(get_the_ID(), "eltd_slide-button-link2", true) != "";

                    //does any button should be displayed?
                    $is_any_button_shown = $is_first_button_shown || $is_second_button_shown;

                    if ($is_any_button_shown) {
                        $html_text .= '<div class="el">';
                        $html_text .= '<div class="slide_buttons_holder">';
                    }
                    $slide_button_target = "_self";
                    if (get_post_meta(get_the_ID(), "eltd_slide-button-target", true) != "") {
                        $slide_button_target = get_post_meta(get_the_ID(), "eltd_slide-button-target", true);
                    }

                    $slide_button_target2 = "_self";
                    if (get_post_meta(get_the_ID(), "eltd_slide-button-target2", true) != "") {
                        $slide_button_target2 = get_post_meta(get_the_ID(), "eltd_slide-button-target2", true);
                    }


                    //First Button Style and HTML
                    $button_text_style1 = "";
                    $data_attr1 = "";
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_font_family", true) != "-1") {
                        $button_text_style1 .= "font-family:" . str_replace('+', ' ', get_post_meta(get_the_ID(), "eltd_slide-button_font_family", true)) . ", sans-serif;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_letter_spacing", true) != "") {
                        $button_text_style1 .= "letter-spacing:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_letter_spacing", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_font_style", true) != "") {
                        $button_text_style1 .= "font-style:" . get_post_meta(get_the_ID(), "eltd_slide-button_font_style", true) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_font_weight", true) != "") {
                        $button_text_style1 .= "font-weight:" . get_post_meta(get_the_ID(), "eltd_slide-button_font_weight", true) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_font_size", true) != "") {
                        $button_text_style1 .= "font-size:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_font_size", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_text_color", true) != "") {
                        $button_text_style1 .= "color:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_text_color", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_background_color", true) != "") {
                        $button_text_style1 .= "background-color:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_background_color", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_border_color", true) != "") {
                        $button_text_style1 .= "border-color:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_border_color", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_border_radius", true) != "") {
                        $button_text_style1 .= "border-radius:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_border_radius", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_border_width", true) != "") {
                        $button_text_style1 .= "border-width:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_border_width", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_line_height", true) != "") {
                        $button_text_style1 .= "line-height:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_line_height", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_width", true) != "") {
                        $button_text_style1 .= "width:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_width", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_height", true) != "") {
                        $button_text_style1 .= "height:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_height", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_margin1", true) != "") {
                        $button_text_style1 .= "margin:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_margin1", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_text_align", true) != "") {
                        $button_text_style1 .= "text-align:" . get_post_meta(get_the_ID(), "eltd_slide-button_text_align", true) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_text_transform", true) != "") {
                        $button_text_style1 .= "text-transform:" . get_post_meta(get_the_ID(), "eltd_slide-button_text_transform", true) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_padding", true) != "") {
                        $button_text_style1 .= "padding: 0 " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_padding", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_text_hover_color", true) != "") {
                        $data_attr1 .= "data-hover-color=" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_text_hover_color", true)) . " ";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_border_hover_color", true) != "") {
                        $data_attr1 .= "data-hover-border-color=" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_border_hover_color", true)) . " ";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_background_hover_color", true) != "") {
                        $data_attr1 .= "data-hover-background-color=" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_background_hover_color", true)) . " ";
                    }
                    if ($is_first_button_shown) {
                        $first_button_icon_html = '';
                        $first_button_icon_class = '';

                        if(get_post_meta(get_the_ID(), "eltd_slide-button-label", true) !== '') {
                            $first_button_icon_class .= ' icon_right';
                        }

                        if(get_post_meta(get_the_ID(), 'button1_icon_pack', true) !== 'no_icon') {
                            $first_btn_icon_collection = $eltdIconCollections->getIconCollection(get_post_meta(get_the_ID(), 'button1_icon_pack', true));

                            if(is_object($first_btn_icon_collection) && method_exists($first_btn_icon_collection, 'render')
                                && get_post_meta(get_the_ID(), 'button1_icon_'.$first_btn_icon_collection->param, true) !== '') {
                                $first_button_icon_html = $first_btn_icon_collection->render(
                                    get_post_meta(get_the_ID(), 'button1_icon_'.$first_btn_icon_collection->param, true),
                                    array(
                                        'icon_attributes' => array(
                                            'class' => 'button_icon',
                                            'style' => 'font-size: inherit; width: auto'
                                        )
                                    )
                                );
                            }
                        }

                        $html_text .= '<a class="qbutton '.esc_attr($first_button_icon_class).'" ' . $data_attr1 . ' '.eltd_get_inline_style($button_text_style1).' '.$slide_button_1_data.' href="' . esc_url(get_post_meta(get_the_ID(), "eltd_slide-button-link", true)) . '" target="' . esc_attr($slide_button_target) . '">' . esc_html(get_post_meta(get_the_ID(), "eltd_slide-button-label", true)) .$first_button_icon_html. '</a>';
                    }


                    //SecondButton Style and HTML
                    $button_text_style2 = "";
                    $data_attr2 = "";
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_font_family2", true) != "-1") {
                        $button_text_style2 .= "font-family:" . str_replace('+', ' ', get_post_meta(get_the_ID(), "eltd_slide-button_font_family2", true)) . ", sans-serif;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_letter_spacing2", true) != "") {
                        $button_text_style2 .= "letter-spacing:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_letter_spacing2", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_font_style2", true) != "") {
                        $button_text_style2 .= "font-style:" . get_post_meta(get_the_ID(), "eltd_slide-button_font_style2", true) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_font_weight2", true) != "") {
                        $button_text_style2 .= "font-weight:" . get_post_meta(get_the_ID(), "eltd_slide-button_font_weight2", true) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_font_size2", true) != "") {
                        $button_text_style2 .= "font-size:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_font_size2", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_text_color2", true) != "") {
                        $button_text_style2 .= "color:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_text_color2", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_background_color2", true) != "") {
                        $button_text_style2 .= "background-color:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_background_color2", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_border_color2", true) != "") {
                        $button_text_style2 .= "border-color:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_border_color2", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_border_radius2", true) != "") {
                        $button_text_style2 .= "border-radius:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_border_radius2", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_border_width2", true) != "") {
                        $button_text_style2 .= "border-width:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_border_width2", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_line_height2", true) != "") {
                        $button_text_style2 .= "line-height:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_line_height2", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_width2", true) != "") {
                        $button_text_style2 .= "width:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_width2", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_height2", true) != "") {
                        $button_text_style2 .= "height:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_height2", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_margin2", true) != "") {
                        $button_text_style2 .= "margin:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_margin2", true)) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_text_align2", true) != "") {
                        $button_text_style2 .= "text-align:" . get_post_meta(get_the_ID(), "eltd_slide-button_text_align2", true) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_text_transform2", true) != "") {
                        $button_text_style2 .= "text-transform:" . get_post_meta(get_the_ID(), "eltd_slide-button_text_transform2", true) . ";";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_padding2", true) != "") {
                        $button_text_style2 .= "padding: 0 " . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_padding2", true)) . "px;";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_text_hover_color2", true) != "") {
                        $data_attr2 .= "data-hover-color=" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_text_hover_color2", true)) . " ";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_border_hover_color2", true) != "") {
                        $data_attr2 .= "data-hover-border-color=" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_border_hover_color2", true)) . " ";
                    }
                    if (get_post_meta(get_the_ID(), "eltd_slide-button_background_hover_color2", true) != "") {
                        $data_attr2 .= "data-hover-background-color=" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-button_background_hover_color2", true)) . " ";
                    }

                    if ($is_second_button_shown) {
                        $second_button_icon_html = '';
                        $second_button_icon_class = '';

                        if(get_post_meta(get_the_ID(), 'button2_icon_pack', true) !== 'no_icon') {
                            $second_btn_icon_collection = $eltdIconCollections->getIconCollection(get_post_meta(get_the_ID(), 'button2_icon_pack', true));

                            if(is_object($second_btn_icon_collection) && method_exists($second_btn_icon_collection, 'render')
                                && get_post_meta(get_the_ID(), 'button2_icon_'.$second_btn_icon_collection->param, true) !== '') {
                                $second_button_icon_html = $second_btn_icon_collection->render(
                                    get_post_meta(get_the_ID(), 'button2_icon_'.$second_btn_icon_collection->param, true),
                                    array(
                                        'icon_attributes' => array(
                                            'class' => 'button_icon',
                                            'style' => 'font-size: inherit; width: auto'
                                        )
                                    )
                                );

                                if(get_post_meta(get_the_ID(), "eltd_slide-button-label2", true) !== '') {
                                    $second_button_icon_class .= ' icon_right';
                                }
                            }
                        }

                        $html_text .= '<a class="qbutton '.esc_attr($second_button_icon_class).'" ' . $data_attr2 . ' '.eltd_get_inline_style($button_text_style2).' '.$slide_button_2_data.' href="' . esc_url(get_post_meta(get_the_ID(), "eltd_slide-button-link2", true)) . '" target="' . esc_attr($slide_button_target2) . '">' . esc_html(get_post_meta(get_the_ID(), "eltd_slide-button-label2", true)) .$second_button_icon_html. '</a>';
                    }

                    if ($is_any_button_shown) {
                        $html_text .= '</div></div>'; //close div.slide_button_holder
                    }

                    if (get_post_meta(get_the_ID(), "eltd_slide-anchor-button", true) !== '') {
                        $slide_anchor_style = array();
                        if (get_post_meta(get_the_ID(), "eltd_slide-text-color", true) !== '') {
                            $slide_anchor_style[] = "color:" . esc_attr(get_post_meta(get_the_ID(), "eltd_slide-text-color", true));
                        }

                        if ($slide_anchor_style !== '') {
                            $slide_anchor_style = 'style="' . implode(';', $slide_anchor_style) . '"';
                        }

                        $html_text .= '<div class="slide_anchor_holder el"><a ' . $slide_anchor_style . ' class="slide_anchor_button anchor" href="' . esc_url(get_post_meta(get_the_ID(), "eltd_slide-anchor-button", true)) . '"><i class="fa fa-angle-down"></i></a></div>';
                    }

                    $html_text .= '</div>';
                    $html .= '<div class="slider_content_outer '. esc_attr($content_predefined_position) .'">';

                    if ($separate_text_graphic != 'yes') {
                        $html .= '<div class="slider_content ' . esc_attr($content_alignment) .'" '.eltd_get_inline_style($content_width . $content_xaxis . $content_yaxis_start).' '.$slide_data_start.' '.$slide_data_end.'>';
                        $html .= $html_thumb;
                        $html .= $html_text;
                        $html .= '</div>';
                    } else {
                        $html .= '<div class="slider_content graphic_content ' . esc_attr($graphic_alignment) . '" '.eltd_get_inline_style($graphic_width . $graphic_xaxis . $graphic_yaxis_start).'>';
                        $html .= $html_thumb;
                        $html .= '</div>';
                        $html .= '<div class="slider_content ' . esc_attr($content_alignment) . '" '.eltd_get_inline_style($content_width . $content_xaxis . $content_yaxis_start).' '.$slide_data_start.' '.$slide_data_end.'>';
                        $html .= $html_text;
                        $html .= '</div>';
                    }

                    $html .= '</div>';
                    $html .= '</div>';

                    $postCount++;
                endwhile;
            else:
                $html .= __('Sorry, no slides matched your criteria.', 'eltd_cpt');
            endif;
            wp_reset_query();

            $html .= '</div>';
            if ($found_slides > 1) {
                if ($show_navigation_circles == "yes") {

                    $triangle_bkg='';

                    $html .= '<ol class="carousel-indicators '.esc_attr($triangle_bkg).'" data-start="opacity: 1;" data-300="opacity:0;">';

                    query_posts($args);
                    if (have_posts()) : $postCount = 0;
                        while (have_posts()) : the_post();

                            $html .= '<li data-target="#eltd-' . esc_attr($slider) . '" data-slide-to="' . esc_attr($postCount) . '"';
                            if ($postCount == 0) {
                                $html .= ' class="active"';
                            }
                            $html .= '></li>';

                            $postCount++;
                        endwhile;
                    else:
                        $html .= __('Sorry, no posts matched your criteria.', 'eltd_cpt');
                    endif;

                    wp_reset_query();
                    $html .= '</ol>';
                }

                if ($show_navigation_arrows == "yes") {

                    $icon_navigation_class = 'arrow_carrot-';
                    if (isset($eltd_options['navigation_arrows_type']) && $eltd_options['navigation_arrows_type'] != '') {
                        $icon_navigation_class = $eltd_options['navigation_arrows_type'];
                    }
                    $direction_nav_classes = eltd_horizontal_slider_icon_classes($icon_navigation_class);

                    $html .= '<div class="controls_holder">';
                    $html .= '<a class="left carousel-control" href="#eltd-' . esc_attr($slider) . '" data-slide="prev" data-start="opacity: 1;" data-300="opacity:0;">';
                    if ($slider_thumbs == 'yes') {
                        $html .= '<span class="thumb_holder" '.$navigation_margin_top.'><span class="thumb-arrow arrow_carrot-left"></span><span class="numbers"><span class="prev"></span><span class="max-number"> / ' . esc_html($postCount) . '</span></span><span class="img"></span></span>';
                    }
                    //For Cabin theme, numbers above navigation
                    $html .= '<span class="prev_nav" ' . $navigation_margin_top . '>';
                    if($slider_numbers == 'yes') {

                        $html .= '<span class="numbers"><span class="prev"></span><span class="max-number"> / ' . esc_html($postCount) . '</span></span>';

                    }
                    $html .= '<span class="'.$direction_nav_classes['left_icon_class'].'"></span></span>';
                    $html .= '</a>';
                    $html .= '<a class="right carousel-control" href="#eltd-' . esc_attr($slider) . '" data-slide="next" data-start="opacity: 1;" data-300="opacity:0;">';
                    if ($slider_thumbs == 'yes') {
                        $html .= '<span class="thumb_holder" '.$navigation_margin_top.'><span class="numbers"> <span class="next"></span><span class="max-number"> / ' . esc_html($postCount) . '</span></span><span class="thumb-arrow arrow_carrot-right"></span><span class="img"></span></span>';
                    }
                    //For Cabin theme, numbers above navigation
                    $html .= '<span class="next_nav" ' . $navigation_margin_top . '>';
                    if($slider_numbers == 'yes') {

                        $html .= '<span class="numbers"> <span class="next"></span><span class="max-number"> / ' . esc_html($postCount) . '</span></span>';

                    }
                    $html .= '<span class="'.esc_attr($direction_nav_classes['right_icon_class']).'"></span></span>';
                    $html .= '</a>';
                    $html .= '</div>';
                }
            }
            $html .= '</div>';
        }
        return $html;
    }
}

new EltdSliderShortcode();