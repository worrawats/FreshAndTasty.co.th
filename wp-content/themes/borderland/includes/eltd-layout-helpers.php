<?php

if(!function_exists('eltd_get_header_options')) {
    /**
     * Function that returns an array of variables needed in header template file.
     * Complete logic is in this function and it is calling other helper functions
     * @return array
     */
    function eltd_get_header_options() {
        global $eltd_options;

        //init variables
        $id = eltd_get_page_id();
        $loading_animation = eltd_is_loading_anim_enabled();
        $loading_image = eltd_get_loading_image();
        $enable_side_area = eltd_is_side_area_enabled();
        $enable_popup_menu = eltd_is_popup_menu_enabled();
        $popup_menu_animation_style = eltd_get_popup_animation_style();
        $enable_fullscreen_search = eltd_is_fullscreen_search_enabled();
        $fullscreen_search_animation = eltd_get_fullscreen_search_anim_type();
        $enable_vertical_menu = eltd_is_vertical_menu_enabled();
        $header_button_size = '';
        $paspartu_header_alignment = eltd_is_paspartu_header_aligned();
        $header_in_grid = eltd_is_header_in_grid();
        $header_bottom_class = ' header_in_grid';
        $menu_item_icon_position = "";
        $menu_position = "";
        $centered_logo = eltd_is_logo_centered();
        $enable_border_top_bottom_menu = false;
        $enable_border_left_right_menu = false;
        $menu_dropdown_appearance_class = "";
        $logo_wrapper_style = "";
        $divided_left_menu_padding = "";
        $divided_right_menu_padding = "";
        $display_header_top = eltd_is_header_top_enabled();
        $header_top_area_scroll = "no";
        $header_style = eltd_get_header_style();
        $header_color_transparency_per_page = eltd_get_header_bg_transparency();
        $header_color_per_page = eltd_get_header_bottom_bg_color();
        $header_top_color_per_page = eltd_get_header_top_bg_color();
        $header_color_transparency_on_scroll="";
        $header_bottom_border_style = '';
        $header_bottom_appearance = 'fixed';
        $vertical_area_background_image = "";
        $vertical_menu_style = "";
        $vertical_area_scroll = "";
        $page_vertical_area_background_transparency = "";
        $vertical_area_background_color = "";
        $page_vertical_area_background = "";

        if(isset($eltd_options['header_buttons_size'])){
            $header_button_size = $eltd_options['header_buttons_size'];
        }

        if(isset($eltd_options['menu_item_icon_position'])){
            $menu_item_icon_position = $eltd_options['menu_item_icon_position'];
        }

        if(eltd_is_header_in_grid()) {
            $header_bottom_class = ' header_in_grid';
        } else {
            $header_bottom_class = ' header_full_width';
        }

        if(isset($eltd_options['menu_item_icon_position'])) {
            $menu_item_icon_position = $eltd_options['menu_item_icon_position'];
        }

        if(isset($eltd_options['menu_position'])){
            $menu_position = $eltd_options['menu_position'];
        }

        if (isset($eltd_options['enable_border_top_bottom_menu'])) {
            if($eltd_options['enable_border_top_bottom_menu'] == "yes") {
                $enable_border_top_bottom_menu = true;
            }
        }

        if (isset($eltd_options['enable_border_left_right_menu'])) {
            if($eltd_options['enable_border_left_right_menu'] == "yes") {
                $enable_border_left_right_menu = true;
            }
        }

        if(isset($eltd_options['menu_dropdown_appearance']) && $eltd_options['menu_dropdown_appearance'] != "default"){
            $menu_dropdown_appearance_class = $eltd_options['menu_dropdown_appearance'];
        }

        //check if header is sticky divided and set width of logo wrapper
        if(isset($eltd_options['header_bottom_appearance']) && $eltd_options['header_bottom_appearance'] == "stick_with_left_right_menu"){
            $logo_wrapper_style = 'width:'.(esc_attr($eltd_options['logo_width'])/2).'px;';
            $divided_left_menu_padding = 'padding-right:'.(esc_attr($eltd_options['logo_width'])/4).'px;';
            $divided_right_menu_padding = 'padding-left:'.(esc_attr($eltd_options['logo_width'])/4).'px;';
        }
        if($eltd_options['center_logo_image'] == "yes" && $eltd_options['header_bottom_appearance'] == "regular"){
            $logo_wrapper_style = 'height:'.(esc_attr($eltd_options['logo_height'])/2).'px;';
        }

        if(isset($eltd_options['header_bottom_appearance']) && $eltd_options['header_bottom_appearance'] == "fixed_top_header"){
            $logo_wrapper_style = 'height:'.(esc_attr($eltd_options['logo_height'])/2).'px;';
        }

        if(eltd_is_header_top_enabled() == 'yes'){
            $header_top_area_scroll = $eltd_options['header_top_area_scroll'];
        }

        if(isset($eltd_options['header_botom_border_in_grid']) && $eltd_options['header_botom_border_in_grid'] != "yes" && get_post_meta($id, "eltd_header_bottom_border_color", true) != ""){
            $header_color_per_page .= "border-bottom: 1px solid ".esc_attr(get_post_meta($id, "eltd_header_bottom_border_color", true)).";";
        }

        if(isset($eltd_options['header_background_transparency_sticky']) && $eltd_options['header_background_transparency_sticky'] != ""){
            $header_color_transparency_on_scroll = esc_attr($eltd_options['header_background_transparency_sticky']);
        }

        if(isset($eltd_options['header_botom_border_in_grid']) && $eltd_options['header_botom_border_in_grid'] == "yes" && get_post_meta($id, "eltd_header_bottom_border_color", true) != ""){
            $header_bottom_border_style = 'border-bottom: 1px solid '.esc_attr(get_post_meta($id, "eltd_header_bottom_border_color", true)).';';
        }

        if(isset($eltd_options['header_bottom_appearance'])){
            $header_bottom_appearance = $eltd_options['header_bottom_appearance'];
        }

        if(isset($eltd_options['vertical_area_background_image']) && $eltd_options['vertical_area_background_image'] != "" && isset($eltd_options['vertical_area_dropdown_showing']) && $eltd_options['vertical_area_dropdown_showing'] != "side") {
            $vertical_area_background_image = $eltd_options['vertical_area_background_image'];
        }
        if(get_post_meta($id, "eltd_page_vertical_area_background_image", true) != "" && isset($eltd_options['vertical_area_dropdown_showing']) && $eltd_options['vertical_area_dropdown_showing'] != "side"){
            $vertical_area_background_image = get_post_meta($id, "eltd_page_vertical_area_background_image", true);
        }

        $vertical_area_dropdown_showing = $eltd_options['vertical_area_dropdown_showing'];

        switch($vertical_area_dropdown_showing){
            case 'hover':
                $vertical_menu_style = "toggle";
                break;
            case 'click':
                $vertical_menu_style = "toggle click";
                break;
            case 'side':
                $vertical_menu_style = "side";
                break;
            case 'to_content':
                $vertical_menu_style = "to_content";
                break;
            default:
                $vertical_menu_style = "toggle";

        }
        $vertical_area_scroll = " with_scroll";
        if ($vertical_area_dropdown_showing == 'to_content') {
            $vertical_area_scroll = "";
        }

        if(isset($eltd_options['paspartu']) && $eltd_options['paspartu'] == 'yes' && isset($eltd_options['vertical_menu_inside_paspartu']) && $eltd_options['vertical_menu_inside_paspartu'] == 'yes'){
            if($eltd_options['vertical_area_background_transparency'] != "") {
                $page_vertical_area_background_transparency = esc_attr($eltd_options['vertical_area_background_transparency']);
            }
            if(get_post_meta($id, "eltd_page_vertical_area_background_opacity", true) != ""){
                $page_vertical_area_background_transparency = esc_attr(get_post_meta($id, "eltd_page_vertical_area_background_opacity", true));
            }

            if(isset($eltd_options['vertical_area_dropdown_showing']) && $eltd_options['vertical_area_dropdown_showing'] == "side"){
                $page_vertical_area_background_transparency = 1;
            }
        }
		else if(isset($eltd_options['paspartu']) && $eltd_options['paspartu'] == 'no') {
			if($eltd_options['vertical_area_background_transparency'] != "") {
				$page_vertical_area_background_transparency = esc_attr($eltd_options['vertical_area_background_transparency']);
			}
			if(get_post_meta($id, "eltd_page_vertical_area_background_opacity", true) != ""){
				$page_vertical_area_background_transparency = esc_attr(get_post_meta($id, "eltd_page_vertical_area_background_opacity", true));
			}
			
			if(isset($eltd_options['vertical_area_dropdown_showing']) && $eltd_options['vertical_area_dropdown_showing'] == "side"){
				$page_vertical_area_background_transparency = 1;
			}
		}

        $page_vertical_area_background = "";

        if(get_post_meta($id, "eltd_page_vertical_area_background", true) != ""){
            if($page_vertical_area_background_transparency != ""){
                $vertical_area_background_color = eltd_hex2rgb(esc_attr(get_post_meta($id, "eltd_page_vertical_area_background", true)));
                $page_vertical_area_background = 'background-color:rgba(' . $vertical_area_background_color[0] . ', ' . $vertical_area_background_color[1] . ', ' . $vertical_area_background_color[2] . ', ' . $page_vertical_area_background_transparency . ');';
            }else{
                $page_vertical_area_background = 'background-color:' . esc_attr(get_post_meta($id, 'eltd_page_vertical_area_background', true)) . ';';
            }

        }else if($page_vertical_area_background_transparency != "" && get_post_meta($id, "eltd_page_vertical_area_background", true) == ""){
            $vertical_area_background_color = $eltd_options['vertical_area_background'] ? eltd_hex2rgb(esc_attr($eltd_options['vertical_area_background'])) : eltd_hex2rgb("#ffffff");
            $page_vertical_area_background = 'background-color:rgba(' . esc_attr($vertical_area_background_color[0]) . ', ' . esc_attr($vertical_area_background_color[1]) . ', ' . esc_attr($vertical_area_background_color[2]) . ', ' . esc_attr($page_vertical_area_background_transparency) . ');';
        }

        return array(
            'id' => $id,
            'loading_animation' => $loading_animation,
            'loading_image' => $loading_image,
            'enable_side_area' => $enable_side_area,
            'enable_popup_menu' => $enable_popup_menu,
            'popup_menu_animation_style' => $popup_menu_animation_style,
            'enable_fullscreen_search' => $enable_fullscreen_search,
            'fullscreen_search_animation' => $fullscreen_search_animation,
            'enable_vertical_menu' => $enable_vertical_menu,
            'header_button_size' => $header_button_size,
            'paspartu_header_alignment' => $paspartu_header_alignment,
            'header_in_grid' => $header_in_grid,
            'header_bottom_class' => $header_bottom_class,
            'menu_item_icon_position' => $menu_item_icon_position,
            'menu_position' => $menu_position,
            'centered_logo' => $centered_logo,
            'enable_border_top_bottom_menu' => $enable_border_top_bottom_menu,
            'enable_border_left_right_menu' => $enable_border_left_right_menu,
            'menu_dropdown_appearance_class' => $menu_dropdown_appearance_class,
            'logo_wrapper_style' => $logo_wrapper_style,
            'divided_left_menu_padding' => $divided_left_menu_padding,
            'divided_right_menu_padding' => $divided_right_menu_padding,
            'display_header_top' => $display_header_top,
            'header_top_area_scroll' => $header_top_area_scroll,
            'header_style' => $header_style,
            'header_color_transparency_per_page' => $header_color_transparency_per_page,
            'header_color_per_page' => $header_color_per_page,
            'header_top_color_per_page' => $header_top_color_per_page,
            'header_color_transparency_on_scroll' => $header_color_transparency_on_scroll,
            'header_bottom_border_style' => $header_bottom_border_style,
            'header_bottom_appearance' => $header_bottom_appearance,
            'header_transparency' => $header_color_transparency_per_page,
            'vertical_area_background_image' => $vertical_area_background_image,
            'vertical_menu_style' => $vertical_menu_style,
            'vertical_area_scroll' => $vertical_area_scroll,
            'page_vertical_area_background_transparency' => $page_vertical_area_background_transparency,
            'page_vertical_area_background' => $page_vertical_area_background
        );
    }
}

if(!function_exists('eltd_get_footer_options')) {
    /**
     * Returns an array of variables that are needed in footer.php
     *
     * @return array
     */
    function eltd_get_footer_options() {
        global $eltd_options;

        $footer_classes_array				= array();
        $footer_classes						= '';
        $footer_border_columns				= 'yes';
        $footer_top_border_color            = '';
        $footer_top_border_in_grid          = '';
        $footer_bottom_border_color         = '';
        $footer_bottom_border_bottom_color  = '';
        $footer_bottom_border_in_grid       = '';
        $display_footer_text                = false;
        $footer_in_grid                     = true;
        $display_footer_top                 = true;
        $footer_top_columns                 = 4;
        $footer_bottom_columns              = 3;



        if(isset($eltd_options['footer_border_columns']) && $eltd_options['footer_border_columns'] !== '') {
            $footer_border_columns = $eltd_options['footer_border_columns'];
        }

        if(!empty($eltd_options['footer_top_border_color'])) {
            if (isset($eltd_options['footer_top_border_width']) && $eltd_options['footer_top_border_width'] !== '') {
                $footer_border_height = $eltd_options['footer_top_border_width'];
            }
            else{
                $footer_border_height = '1';
            }
            $footer_top_border_color = 'height: '.esc_attr($footer_border_height).'px;background-color: '.esc_attr($eltd_options['footer_top_border_color']).';';
        }

        if(isset($eltd_options['footer_top_border_in_grid']) && $eltd_options['footer_top_border_in_grid'] == 'yes') {
            $footer_top_border_in_grid = 'in_grid';
        }

        if(!empty($eltd_options['footer_bottom_border_color'])) {
            if(!empty($eltd_options['footer_bottom_border_width'])) {
                $footer_bottom_border_width = $eltd_options['footer_bottom_border_width'].'px';
            }
            else{
                $footer_bottom_border_width = '1px';
            }

            $footer_bottom_border_color = 'height: '.esc_attr($footer_bottom_border_width).';background-color: '.esc_attr($eltd_options['footer_bottom_border_color']).';';
        }

        if(isset($eltd_options['footer_bottom_border_in_grid']) && $eltd_options['footer_bottom_border_in_grid'] == 'yes') {
            $footer_bottom_border_in_grid = 'in_grid';
        }

        if(!empty($eltd_options['footer_bottom_border_bottom_color'])) {
            if(!empty($eltd_options['footer_bottom_border_bottom_width'])) {
                $footer_bottom_border_bottom_width = $eltd_options['footer_bottom_border_bottom_width'].'px';
            }
            else{
                $footer_bottom_border_bottom_width = '1px';
            }

            $footer_bottom_border_bottom_color = 'height: '.esc_attr($footer_bottom_border_bottom_width).';background-color: '.esc_attr($eltd_options['footer_bottom_border_bottom_color']).';';
        }

        //is uncovering footer option set in theme options?
        if(isset($eltd_options['uncovering_footer']) && $eltd_options['uncovering_footer'] == "yes" && isset($eltd_options['paspartu']) && $eltd_options['paspartu'] == 'no') {
            //add uncovering footer class to array
            $footer_classes_array[] = 'uncover';
        }


        if($footer_border_columns == 'yes') {
            $footer_classes_array[] = 'footer_border_columns';
        }

        //is some class added to footer classes array?
        if(is_array($footer_classes_array) && count($footer_classes_array)) {
            //concat all classes and prefix it with class attribute
            $footer_classes = esc_attr(implode(' ', $footer_classes_array));
        }

        if (isset($eltd_options['footer_text']) && $eltd_options['footer_text'] == "yes") {
            $display_footer_text = true;
        }

        if(isset($eltd_options['footer_in_grid']) && $eltd_options['footer_in_grid'] != "yes"){
            $footer_in_grid = false;
        }

        if (isset($eltd_options['show_footer_top']) && $eltd_options['show_footer_top'] == "no") {
            $display_footer_top = false;
        }

        if (isset($eltd_options['footer_top_columns'])) {
            $footer_top_columns = $eltd_options['footer_top_columns'];
        }

        if (isset($eltd_options['footer_bottom_columns'])) {
            $footer_bottom_columns = $eltd_options['footer_bottom_columns'];
        }

        return array(
            'footer_border_columns' => $footer_border_columns,
            'footer_top_border_color' => $footer_top_border_color,
            'footer_top_border_in_grid' => $footer_top_border_in_grid,
            'footer_bottom_border_color' => $footer_bottom_border_color,
            'footer_bottom_border_in_grid' => $footer_bottom_border_in_grid,
            'footer_bottom_border_bottom_color' => $footer_bottom_border_bottom_color,
            'footer_classes' => $footer_classes,
            'display_footer_text' => $display_footer_text,
            'footer_in_grid' => $footer_in_grid,
            'display_footer_top' => $display_footer_top,
            'footer_top_columns' => $footer_top_columns,
            'footer_bottom_columns' => $footer_bottom_columns
        );
    }
}

if(!function_exists('eltd_is_loading_anim_enabled')) {
    /**
     * Checks if loading animation is enabled in theme options or not
     * @return bool
     */
    function eltd_is_loading_anim_enabled() {
        global $eltd_options;

        return isset($eltd_options['loading_animation']) && $eltd_options['loading_animation'] == "off" ? false : true;
    }
}

if(!function_exists('eltd_get_loading_image')) {
    /**
     * Checks if loading image for loading animation is set
     * @return string
     */
    function eltd_get_loading_image() {
        global $eltd_options;

        return isset($eltd_options['loading_image']) && $eltd_options['loading_image'] != "" ?
            $eltd_options['loading_image'] : '';
    }
}

if(!function_exists('eltd_is_side_area_enabled')) {
    /**
     * Checks if side area is enabled in theme options or not
     * @return string
     */
    function eltd_is_side_area_enabled() {
        global $eltd_options;

        return isset($eltd_options['enable_side_area']) && $eltd_options['enable_side_area'] == "no" ? "no" : "yes";
    }
}

if(!function_exists('eltd_is_popup_menu_enabled')) {
    /**
     * Checks if full screen menu is enabled
     * @return string
     */
    function eltd_is_popup_menu_enabled() {
        global $eltd_options;

        return $eltd_options['enable_popup_menu'] == "yes" && has_nav_menu('popup-navigation') ? "yes" : "no";
    }
}

if(!function_exists('eltd_get_popup_animation_style')) {
    /**
     * Returns chosen full screen menu animation style
     *
     * @return string
     *
     * * @see eltd_is_popup_menu_enabled()
     */
    function eltd_get_popup_animation_style() {
        global $eltd_options;

        if(eltd_is_popup_menu_enabled() == 'yes' && !empty($eltd_options['popup_menu_animation_style'])) {
            return $eltd_options['popup_menu_animation_style'];
        }

        return '';
    }
}

if(!function_exists('eltd_is_fullscreen_search_enabled')) {
    /**
     * Checks if full screen search is enabled
     *
     * @return string
     *
     * @see eltd_is_eltd_search_enabled()
     */
    function eltd_is_fullscreen_search_enabled() {
        global $eltd_options;

        if(eltd_is_eltd_search_enabled()) {
            if(isset($eltd_options['search_type']) && $eltd_options['search_type'] == "fullscreen_search") {
                return "yes";
            }
        }

        return "no";
    }
}

if(!function_exists('eltd_is_eltd_search_enabled')) {
    /**
     * Checks if search is enabled
     * @return bool
     */
    function eltd_is_eltd_search_enabled() {
        global $eltd_options;

        return isset($eltd_options['enable_search']) && $eltd_options['enable_search'] == "yes";
    }
}

if(!function_exists('eltd_get_fullscreen_search_anim_type')) {
    /**
     * Returns full screen search animation type if enabled
     * @return string
     *
     * @see eltd_is_fullscreen_search_enabled()
     */
    function eltd_get_fullscreen_search_anim_type() {
        global $eltd_options;

        if(eltd_is_fullscreen_search_enabled() && $eltd_options['search_animation'] !== "") {
            return $eltd_options['search_animation'];
        }

        return "fade";
    }
}

if(!function_exists('eltd_is_vertical_menu_enabled')) {
    /**
     * Checks if vertical menu is turned on
     * @return bool
     */
    function eltd_is_vertical_menu_enabled() {
        global $eltd_options;

        return isset($eltd_options['vertical_area']) && $eltd_options['vertical_area'] =='yes' ? true : false;
    }
}

if(!function_exists('eltd_is_paspartu_header_aligned')) {
    /**
     * Checks if paspartu is aligned with header
     * @return bool
     */
    function eltd_is_paspartu_header_aligned() {
        global $eltd_options;

        return isset($eltd_options['paspartu_header_alignment']) && $eltd_options['paspartu_header_alignment'] ==
        'yes' && isset($eltd_options['paspartu']) && $eltd_options['paspartu'] == 'yes';
    }
}

if(!function_exists('eltd_is_header_in_grid')) {
    /**
     * Checks if header is in grid
     * @return bool
     *
     * @see eltd_is_paspartu_header_aligned()
     */
    function eltd_is_header_in_grid() {
        global $eltd_options;

        $header_in_grid = true;
        if(isset($eltd_options['header_in_grid'])){
            if ($eltd_options['header_in_grid'] == "no"){
                $header_in_grid = false;
            }
            if (eltd_is_paspartu_header_aligned()) {
                $header_in_grid = false;
            }
        }

        return $header_in_grid;
    }
}

if(!function_exists('eltd_is_logo_centered')) {
    /**
     * Checks if logo is centered
     * @return bool
     */
    function eltd_is_logo_centered() {
        global $eltd_options;

        if($eltd_options['header_bottom_appearance'] == "fixed_hiding"){
            return true;
        }

        if($eltd_options['center_logo_image'] == "yes" && $eltd_options['header_bottom_appearance'] !== "stick_with_left_right_menu") {
            return true;
        }

        return false;
    }
}

if(!function_exists('eltd_is_header_top_enabled')) {
    /**
     * Checks if header top area is enabled or not
     * @return mixed
     */
    function eltd_is_header_top_enabled() {
        global $eltd_options;

        $display_header_top = "yes";
        if(isset($eltd_options['header_top_area'])){
            $display_header_top = $eltd_options['header_top_area'];
        }

        return $display_header_top;
    }
}

if(!function_exists('eltd_get_header_style')) {
    /**
     * Returns header style for current page.
     * First it checks in custom fields for current page and if it isn't set there
     * it looks in theme options
     * @return mixed
     *
     * @see eltd_get_page_id()
     */
    function eltd_get_header_style() {
        global $eltd_options;

        $id = eltd_get_page_id();
        $header_style = "";

        if(get_post_meta($id, "eltd_header-style", true) != "") {
            $header_style = get_post_meta($id, "eltd_header-style", true);
        } else if(isset($eltd_options['header_style'])) {
            $header_style = $eltd_options['header_style'];
        }

        return $header_style;
    }
}

if(!function_exists('eltd_get_header_bg_transparency')) {
    /**
     * Returns header background color transparency.
     * Looks first in custom field for current page and if not found
     * looks in theme options
     * @return string|void
     *
     * @see eltd_get_page_id()
     */
    function eltd_get_header_bg_transparency() {
        global $eltd_options;

        $id = eltd_get_page_id();

        $header_color_transparency_per_page = '';

        if(get_post_meta($id, "eltd_header_color_transparency_per_page", true) != ""){
            $header_color_transparency_per_page = esc_attr(get_post_meta($id, "eltd_header_color_transparency_per_page", true));
        } elseif($eltd_options['header_background_transparency_initial'] != "") {
            $header_color_transparency_per_page = esc_attr($eltd_options['header_background_transparency_initial']);
        }

        return $header_color_transparency_per_page;
    }
}

if(!function_exists('eltd_get_header_bottom_bg_color')) {
    /**
     * Returns string containing background color for header bottom with transparency if set
     * @return string
     */
    function eltd_get_header_bottom_bg_color() {
        global $eltd_options;

        $id = eltd_get_page_id();
        $header_color_transparency_per_page = eltd_get_header_bg_transparency();
        $header_color_per_page = '';

        if(get_post_meta($id, "eltd_header_color_per_page", true) != ""){
            if($header_color_transparency_per_page != ""){
                $header_background_color = eltd_hex2rgb(esc_attr(get_post_meta($id, "eltd_header_color_per_page", true)));
                $header_color_per_page .= "background-color:rgba(" . $header_background_color[0] . ", " . $header_background_color[1] . ", " . $header_background_color[2] . ", " . $header_color_transparency_per_page . ");";
            }else{
                $header_color_per_page .= "background-color:" . esc_attr(get_post_meta($id, "eltd_header_color_per_page", true)) . ";";
            }
        } else if($header_color_transparency_per_page != "" && get_post_meta($id, "eltd_header_color_per_page", true) == ""){
            $header_background_color = $eltd_options['header_background_color'] ? eltd_hex2rgb(esc_attr($eltd_options['header_background_color'])) : eltd_hex2rgb("#ffffff");
            $header_color_per_page .= "background-color:rgba(" . $header_background_color[0] . ", " . $header_background_color[1] . ", " . $header_background_color[2] . ", " . $header_color_transparency_per_page . ");";
        }

        return $header_color_per_page;
    }
}

if(!function_exists('eltd_get_header_top_bg_color')) {
    /**
     * Returns string that contains header top background color with transparency if set
     * @return string
     */
    function eltd_get_header_top_bg_color() {
        global $eltd_options;

        $id = eltd_get_page_id();
        $header_color_transparency_per_page = eltd_get_header_bg_transparency();
        $header_top_color_per_page = '';

        if(get_post_meta($id, "eltd_header_color_per_page", true) != ""){
            if($header_color_transparency_per_page != ""){
                $header_background_color = eltd_hex2rgb(esc_attr(get_post_meta($id, "eltd_header_color_per_page", true)));
                $header_top_color_per_page .= "background-color:rgba(" . esc_attr($header_background_color[0]) . ", " . esc_attr($header_background_color[1]) . ", " . esc_attr($header_background_color[2]) . ", " . esc_attr($header_color_transparency_per_page) . ");";
            }else{
                $header_top_color_per_page .= "background-color:" . esc_attr(get_post_meta($id, "eltd_header_color_per_page", true)) . ";";
            }
        } else if($header_color_transparency_per_page != "" && get_post_meta($id, "eltd_header_color_per_page", true) == ""){
            $header_background_color = $eltd_options['header_top_background_color'] ? eltd_hex2rgb(esc_attr($eltd_options['header_top_background_color'])) : eltd_hex2rgb("#ffffff");
            $header_top_color_per_page .= "background-color:rgba(" . esc_attr($header_background_color[0]) . ", " . esc_attr($header_background_color[1]) . ", " . esc_attr($header_background_color[2]) . ", " . esc_attr($header_color_transparency_per_page) . ");";
        }

        return $header_top_color_per_page;
    }
}