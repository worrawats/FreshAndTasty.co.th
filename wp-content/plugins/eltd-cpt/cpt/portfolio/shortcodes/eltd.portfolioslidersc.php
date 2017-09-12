<?php

class EltdPortfolioSliderShortcode {
    public function __construct() {
        add_shortcode('no_portfolio_slider', array($this, 'render'));
        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function render($atts, $content = null) {
        global $eltd_options;
        $portfolio_eltd_like = "on";
        if (isset($eltd_options['portfolio_eltd_like'])) {
            $portfolio_eltd_like = $eltd_options['portfolio_eltd_like'];
        }

        $args = array(
            "hover_type" => "gradient_hover",
            "overlay_background_color" => "",
            "hover_box_color" => "",
            "order_by" => "menu_order",
            "order" => "ASC",
            "number" => "-1",
            "portfolios_shown" => "",
            "category" => "",
            "selected_projects" => "",
            "show_icons" => "yes",
            "link_icon" => "yes",
            "lightbox" => "yes",
            "show_like" => "yes",
            "disable_link" => "no",
            "show_categories" => "yes",
            "category_color" => "",
            "separator" => "",
            "separator_thickness" => "",
            "separator_color" => "",
            "separator_animation" => "",
            "title_tag" => "h5",
            "title_font_size" => "",
            "title_color" => "",
            "image_size" => "portfolio-square",
            "enable_navigation" => ""
        );
        extract(shortcode_atts($args, $atts));


        $overlay_background_color = esc_attr($overlay_background_color);
        $hover_box_color = esc_attr($hover_box_color);
        $number = esc_attr($number);
        $category = esc_attr($category);
        $selected_projects = esc_attr($selected_projects);
        $category_color = esc_attr($category_color);
        $separator_thickness = esc_attr($separator_thickness);
        $separator_color = esc_attr($separator_color);
        $title_font_size = esc_attr($title_font_size);
        $title_color = esc_attr($title_color);


        $headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

        //get correct heading value. If provided heading isn't valid get the default one
        $title_tag = (in_array($title_tag, $headings_array)) ? $title_tag : $args['title_tag'];

        $html = "";
        $lightbox_slug = 'portfolio_slider_' . rand();
        $data_attribute = "";

        if ($portfolios_shown !== "") {
            $data_attribute .= " data-portfolios_shown='" . $portfolios_shown. "'";
        }

        // for this type holder needs to be shown
        if ($hover_type == 'slide_from_left_hover' && $show_icons == 'no') {
            $show_icons = 'yes';
            $link_icon = 'no';
            $lightbox = 'no';
            $show_like = 'no';
        }

        // disable link if icons are shown for these hover type
        if ((($hover_type == 'subtle_vertical_hover' || $hover_type == 'image_subtle_rotate_zoom_hover' || $hover_type == 'image_text_zoom_hover') && $show_icons == 'yes')
            || $hover_type == 'gradient_hover' || $hover_type == 'prominent_plain_hover' || $hover_type == 'prominent_blur_hover') {
            $disable_link = "yes";
        }

        // adding element style and class
        $separator_animation_class = "";
        if ($separator_animation == 'yes') {
            $separator_animation_class = "animate";
        }

        $separator_style = "";
        if ($separator_color != '' || $separator_thickness != '') {
            $separator_style = 'style="';
            if ($separator_color != '') {
                $separator_style .= 'background-color: ' . $separator_color . ';';
            }
            if ($separator_thickness != '') {
                $valid_height = (strstr($separator_thickness, 'px', true)) ? $separator_thickness : $separator_thickness . "px";
                $separator_style .= 'height: ' . $valid_height . ';';
            }
            $separator_style .= '"';
        }


        $portfolio_shader_style = "";
        if ($overlay_background_color != '') {
            if ($hover_type == "gradient_hover") {
                if (substr($overlay_background_color, 0, 3) === "rgba") { // if rgba is set, portfolio uses default color
                    $portfolio_shader_style = '';
                } else {

                    $rgb = eltd_hex2rgb($overlay_background_color);

                    $opacity = 0;
                    $overlay_background_color1 = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $opacity . ')';
                    $opacity = 0.9;
                    $overlay_background_color2 = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $opacity . ')';

                    $portfolio_shader_style = 'style="background: -webkit-linear-gradient(to bottom, ' . $overlay_background_color1 . ' 10%, ' . $overlay_background_color2 . ' 100%);';
                    $portfolio_shader_style .= 'background: linear-gradient(to bottom, ' . $overlay_background_color1 . ' 10%, ' . $overlay_background_color2 . ' 100%);"';
                }
            } elseif ($hover_type == "upward_hover") {
                // disabled
            } else {
                $portfolio_shader_style = 'style="background-color:' . $overlay_background_color . ';"';
            }
        }

        $title_style = '';
        $title_link_style = ''; // with or without 'a' tag
        if ($title_font_size != "" || $title_color != "") {
            $title_link_style .= 'style="';
            $title_style .= 'style="';
            if ($title_font_size != "") {
                $title_style .= 'font-size: ' . $title_font_size . 'px;';
                $title_link_style .= 'font-size: inherit;';
            }
            if ($title_color != "") {
                $title_style .= 'color: ' . $title_color . ';';
                $title_link_style .= 'color: inherit;';
            }
            $title_style .= '"';
            $title_link_style .= '"';
        }

        $category_style = '';
        if ($category_color != '') {
            $category_style = 'style="color: ' . $category_color . ';"';
        }

        $hover_box_style = "";
        if ($hover_type == 'upward_hover' || $hover_type == 'slide_from_left_hover') {

            if ($hover_box_color != '') {
                $hover_box_style = 'style="background-color:' . $hover_box_color . ';"';
            }
        }

        //get proper image size
        switch ($image_size) {
            case 'landscape':
                $thumb_size = 'portfolio-landscape';
                break;
            case 'portrait':
                $thumb_size = 'portfolio-portrait';
                break;
            case 'square':
                $thumb_size = 'portfolio-square';
                break;
            case 'full':
                $thumb_size = 'full';
                break;
            default:
                $thumb_size = 'full';
                break;
        }

        $html .= "<div class='portfolio_main_holder portfolio_slider_holder clearfix'><div class='portfolio_slider'" . $data_attribute . "><ul class='portfolio_slides'>";

        if ($category == "") {
            $q = array(
                'post_type' => 'portfolio_page',
                'orderby' => $order_by,
                'order' => $order,
                'posts_per_page' => $number
            );
        } else {
            $q = array(
                'post_type' => 'portfolio_page',
                'portfolio_category' => $category,
                'orderby' => $order_by,
                'order' => $order,
                'posts_per_page' => $number
            );
        }

        $project_ids = null;
        if ($selected_projects != "") {
            $project_ids = explode(",", $selected_projects);
            $q['post__in'] = $project_ids;
        }

        query_posts($q);

        if (have_posts()) : $postCount = 0;
            while (have_posts()) : the_post();

                $title = get_the_title();
                $terms = wp_get_post_terms(get_the_ID(), 'portfolio_category');

                $overlay_background_color_custom = $overlay_background_color;
                $portfolio_shader_style_custom = $portfolio_shader_style;
                // If Portfolio Single have chosen Image Overlay color for custom field
                if (get_post_meta(get_the_ID(), 'eltd_portfolio-hover-color', true) != "") {
                    $overlay_background_color_custom =  esc_attr(get_post_meta(get_the_ID(), "eltd_portfolio-hover-color", true));
                    $portfolio_shader_style_custom = "";
                    if ($overlay_background_color_custom != '') {
                        if ($hover_type == "gradient_hover") {
                            if (substr($overlay_background_color_custom, 0, 3) === "rgba") { // if rgba is set, portfolio uses default color
                                $portfolio_shader_style_custom = '';
                            } else {

                                $rgb = eltd_hex2rgb($overlay_background_color_custom);

                                $opacity = 0;
                                $overlay_background_color1 = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $opacity . ')';
                                $opacity = 0.9;
                                $overlay_background_color2 = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $opacity . ')';

                                $portfolio_shader_style_custom = 'style="background: -webkit-linear-gradient(to bottom, ' . $overlay_background_color1 . ' 10%, ' . $overlay_background_color2 . ' 100%);';
                                $portfolio_shader_style_custom .= 'background: linear-gradient(to bottom, ' . $overlay_background_color1 . ' 10%, ' . $overlay_background_color2 . ' 100%);"';
                            }
                        } elseif ($hover_type == "upward_hover") {
                            // disabled
                        } else {
                            $portfolio_shader_style_custom = 'style="background-color:' . $overlay_background_color_custom . ';"';
                        }
                    }
                }

                $featured_image_array = wp_get_attachment_image_src(get_post_thumbnail_id(), $thumb_size);

                if (get_post_meta(get_the_ID(), 'eltd_portfolio-lightbox-link', true) != "") {
                    $large_image = get_post_meta(get_the_ID(), 'eltd_portfolio-lightbox-link', true);
                } else {
                    $large_image = $featured_image_array[0];
                }

                $slug_list_ = "pretty_photo_gallery";

                $custom_portfolio_link = get_post_meta(get_the_ID(), 'eltd_portfolio-external-link', true);
                $portfolio_link = $custom_portfolio_link != "" ? $custom_portfolio_link : get_permalink();
                $target = $custom_portfolio_link != "" ? '_blank' : '_self';

                // get categories for specific article
                $category_html = "";
                $category_html .= '<span>' . __('In ', 'eltd_cpt') . '</span>';
                $k = 1;
                foreach ($terms as $term) {
                    $category_html .= "$term->name";
                    if (count($terms) != $k) {
                        $category_html .= ' / ';
                    }
                    $k++;
                }

                $html .= "<li class='item'>";
                $html .= '<div class="item_holder ' . $hover_type . '">';

                switch ($hover_type) {
                    case 'gradient_hover':
                    case 'upward_hover':
                    case 'subtle_vertical_hover':
                    case 'image_subtle_rotate_zoom_hover':
                    case 'slide_up_hover':
                    case 'cursor_change_hover':
                    case 'image_text_zoom_hover':
                    case 'text_slides_with_image': {
                        $html .= '<div class="text_holder" ' . $hover_box_style . '>';
                        $html .= '<div class="text_holder_outer">';
                        $html .= '<div class="text_holder_inner">';
                        if ($disable_link != "yes") {
                            $html .= '<' . $title_tag . ' class="portfolio_title" ' . $title_style . '><a href="' . $portfolio_link . '" ' . $title_link_style . '>' . get_the_title() . '</a></' . $title_tag . '>';
                        } else {
                            $html .= '<' . $title_tag . ' class="portfolio_title" ' . $title_style . '>' . get_the_title() . '</' . $title_tag . '>';
                        }
                        if ($separator == 'yes') {
                            $html .= '<span class="separator ' . $separator_animation_class . '" ' . $separator_style . '></span>';
                        }
                        if ($show_categories == 'yes') {
                            $html .= '<span class="project_category" ' . $category_style . '>' . $category_html . '</span>';
                        }

                        if ($show_icons == 'yes') {
                            $html .= '<div class="icons_holder">';
                            if ($lightbox == "yes") {
                                $html .= '<a class="portfolio_lightbox" title="' . $title . '" href="' . $large_image . '" data-rel="prettyPhoto[' . $slug_list_ . ']" rel="prettyPhoto[' . $slug_list_ . ']"></a>';
                            }
                            if ($portfolio_eltd_like == "on" && $show_like == "yes") {
                                if (function_exists('eltd_like_portfolio_list')) {
                                    $html .= eltd_like_portfolio_list(get_the_ID());
                                }
                            }
                            if ($link_icon == "yes") {
                                $html .= '<a class="preview" title="Go to Project" href="' . $portfolio_link . '" data-type="portfolio_list" target="' . $target . '" ></a>';
                            }
                            $html .= '</div>'; // icons_holder
                        }

                        $html .= '</div>'; // text_holder_inner
                        $html .= '</div>';  // text_holder_outer
                        $html .= '</div>'; // text_holder
                    }
                        break;
                    case 'opposite_corners_hover':
                    case 'slide_from_left_hover':
                    case 'prominent_plain_hover':
                    case 'prominent_blur_hover':
                    case 'icons_bottom_corner':
                    case 'slow_zoom':
                    case 'split_up': {
                        $html .= '<div class="text_holder">';
                        $html .= '<div class="text_holder_outer">';
                        $html .= '<div class="text_holder_inner">';
                        if ($disable_link != "yes") {
                            $html .= '<' . $title_tag . ' class="portfolio_title" ' . $title_style . '><a href="' . $portfolio_link . '" ' . $title_link_style . '>' . get_the_title() . '</a></' . $title_tag . '>';
                        } else {
                            $html .= '<' . $title_tag . ' class="portfolio_title" ' . $title_style . '>' . get_the_title() . '</' . $title_tag . '>';
                        }
                        if ($separator == 'yes') {
                            $html .= '<span class="separator ' . $separator_animation_class . '" ' . $separator_style . '></span>';
                        }
                        if ($show_categories == 'yes') {
                            $html .= '<span class="project_category" ' . $category_style . '>' . $category_html . '</span>';
                        }
                        $html .= '</div>'; //text_holder_inner
                        $html .= '</div>';  // text_holder_outer
                        $html .= '</div>'; // text_holder
                        if ($show_icons == 'yes') {
                            $html .= '<div class="icons_holder" ' . $hover_box_style . '>';
                            if ($lightbox == "yes") {
                                $html .= '<a class="portfolio_lightbox" title="' . $title . '" href="' . $large_image . '" data-rel="prettyPhoto[' . $slug_list_ . ']" rel="prettyPhoto[' . $slug_list_ . ']"></a>';
                            }
                            if ($portfolio_eltd_like == "on" && $show_like == "yes") {
                                if (function_exists('eltd_like_portfolio_list')) {
                                    $html .= eltd_like_portfolio_list(get_the_ID());
                                }
                            }
                            if ($link_icon == "yes") {
                                $html .= '<a class="preview" title="Go to Project" href="' . $portfolio_link . '" data-type="portfolio_list" target="' . $target . '" ></a>';
                            }
                            $html .= '</div>';  // icons_holder
                        }
                    }
                        break;
                }

                $html .= '<div class="portfolio_shader" ' . $portfolio_shader_style_custom . '></div>';
                $html .= '<div class="image_holder">';
                $html .= '<span class="image">';
                $html .= get_the_post_thumbnail(get_the_ID(), $thumb_size);
                $html .= '</span>';
                $html .= '</div>'; // close image_holder
                $html .= '</div>'; // close item_holder
                $html .= "</li>";

                $postCount++;

            endwhile;

        else:
            $html .= __('Sorry, no posts matched your criteria.', 'eltd_cpt');
        endif;

        wp_reset_query();

        $html .= "</ul>";
        if ($enable_navigation) {

            $icon_navigation_class = 'arrow_carrot-';
            if (isset($eltd_options['carousel_navigation_arrows_type']) && $eltd_options['carousel_navigation_arrows_type'] != '') {
                $icon_navigation_class = $eltd_options['carousel_navigation_arrows_type'];
            }

            $direction_nav_classes = eltd_horizontal_slider_icon_classes($icon_navigation_class);

            $html .= '<ul class="caroufredsel-direction-nav"><li><a id="caroufredsel-prev" class="caroufredsel-prev" href="#"><span class="' .$direction_nav_classes['left_icon_class']. '"></span></a></li><li><a class="caroufredsel-next" id="caroufredsel-next" href="#"><span class="' .$direction_nav_classes['right_icon_class']. '"></span></a></li></ul>';
        }
        $html .= "</div></div>";

        return $html;
    }

    public function vcMap() {
        if(function_exists('vc_map')) {
            vc_map( array(
                "name" => "Portfolio Slider",
                "base" => 'no_portfolio_slider',
                "category" => 'by Elated',
                "icon" => "icon-wpb-portfolio-slider extended-custom-icon",
                "allowed_container_element" => 'vc_row',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Hover Animation Type",
                        "param_name" => "hover_type",
                        "value" => array(
                            "Gradient" => "gradient_hover",
                            "Upward" => "upward_hover",
                            "Opposite Corners" => "opposite_corners_hover",
                            "Slide from left" => "slide_from_left_hover",
                            "Subtle Vertical" => "subtle_vertical_hover",
                            "Image Subtle Rotate Zoom" => "image_subtle_rotate_zoom_hover",
                            "Image Text Zoom" => "image_text_zoom_hover",
                            "Prominent Plain" => "prominent_plain_hover",
                            "Prominent Blur" => "prominent_blur_hover",
                            "Slide Up" => "slide_up_hover"
                        ),
                        'save_always' => true
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Image Color Overlay",
                        "param_name" => "overlay_background_color",
                        "value" => "",
                        "description" => "Disabled on Upward Hover",
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Info Box Hover Color",
                        "param_name" => "hover_box_color",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "hover_type", 'value' => array('upward_hover','slide_from_left_hover'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Image size",
                        "param_name" => "image_size",
                        "value" => array(
                            "Default" => "",
                            "Original Size" => "full",
                            "Square" => "square",
                            "Landscape" => "landscape",
                            "Portrait" => "portrait"
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Order By",
                        "param_name" => "order_by",
                        "value" => array(
                            "" => "",
                            "Menu Order" => "menu_order",
                            "Title" => "title",
                            "Date" => "date"
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Order",
                        "param_name" => "order",
                        "value" => array(
                            "" => "",
                            "ASC" => "ASC",
                            "DESC" => "DESC",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Number",
                        "param_name" => "number",
                        "value" => "-1",
                        "description" => "Number of portolios on page (-1 is all)"
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Number of Portfolios Shown",
                        "param_name" => "portfolios_shown",
                        "value" => array(
                            "" => "",
                            "4" => "4",
                            "5" => "5",
                            "6" => "6"
                        ),
                        "description" => "Number of portfolios that are showing at the same time in full width (on smaller screens is responsive so there will be less items shown)",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Category",
                        "param_name" => "category",
                        "value" => "",
                        "description" => "Category Slug (leave empty for all)"
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Enable Icons on Portfolio Image",
                        "param_name" => "show_icons",
                        "value" => array(
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        'save_always' => true,
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Link Icon",
                        "param_name" => "link_icon",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "Default value is Yes",
                        "dependency" => array('element' => "show_icons", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Lightbox Icon",
                        "param_name" => "lightbox",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "Default value is Yes",
                        "dependency" => array('element' => "show_icons", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Like Icon",
                        "param_name" => "show_like",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "Default value is Yes",
                        "dependency" => array('element' => "show_icons", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Separator",
                        "param_name" => "separator",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Separator thickness (px)",
                        "param_name" => "separator_thickness",
                        "description" => "",
                        "dependency" => array('element' => "separator", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Separator Color",
                        "param_name" => "separator_color",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "separator", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Animate Separator",
                        "param_name" => "separator_animation",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "",
                        "dependency" => array('element' => "separator", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Category Names",
                        "param_name" => "show_categories",
                        "value" => array(
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        'save_always' => true,
                        "description" => "Default value is Yes",
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Category Name Color",
                        "param_name" => "category_color",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "show_categories", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Selected Projects",
                        "param_name" => "selected_projects",
                        "value" => "",
                        "description" => "Selected Projects (leave empty for all, delimit by comma)"
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Disable Portfolio Link",
                        "param_name" => "disable_link",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "Default value is No, but it is always disabled on hover type 'gradient', 'prominent_plain' and 'prominent_blur' (Also disabled on subtle_vertical, image_subtle_rotate_zoom and image_text_zoom if icons are used)"
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Title Tag",
                        "param_name" => "title_tag",
                        "value" => array(
                            ""   => "",
                            "h2" => "h2",
                            "h3" => "h3",
                            "h4" => "h4",
                            "h5" => "h5",
                            "h6" => "h6",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Title Color",
                        "param_name" => "title_color",
                        "value" => "",
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Title Font Size (px)",
                        "param_name" => "title_font_size",
                        "value" => ""
                    ),
                    array(
                        "type" => "checkbox",
                        "class" => "",
                        "heading" => "Prev/Next navigation",
                        "value" => array("Enable prev/next navigation?" => "enable_navigation"),
                        "param_name" => "enable_navigation"
                    )
                )
            ) );
        }
    }
}

new EltdPortfolioSliderShortcode();