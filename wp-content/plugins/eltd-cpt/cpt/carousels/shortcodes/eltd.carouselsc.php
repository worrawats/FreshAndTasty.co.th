<?php

class EltdCarouselShortcode {
    public function __construct() {
        add_shortcode('no_carousel', array($this, 'render'));
        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function vcMap() {
        if(function_exists('vc_map')) {
            vc_map( array(
                "name" => "Elated Carousel",
                "base" => 'no_carousel',
                "category" => 'by Elated',
                "icon" => "icon-wpb-carousel-slider extended-custom-icon",
                "allowed_container_element" => 'vc_row',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Carousel Slider",
                        "param_name" => "carousel",
                        "value" => eltdcpt_get_carousel_slider_array_vc(),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Order By",
                        "param_name" => "orderby",
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
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Number of items showing",
                        "param_name" => "number_of_items",
                        "value" => array(
                            "Default" => "",
                            "3" => "3",
                            "4" => "4",
                            "5" => "5"
                        ),
                        "save_always" => true,
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show navigation?",
                        "param_name" => "show_navigation",
                        "value" => array(
                            "Yes" => "yes",
                            "No" => "no",
                        ),
                        'save_always' => true,
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Items In Two Rows?",
                        "param_name" => "show_in_two_rows",
                        "value" => array(
                            "No" => "",
                            "Yes" => "yes",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Margin Between Two Rows (px)",
                        "param_name" => "margin_between_rows",
                        "description" => "Default value is 50",
                        "dependency" => array('element' => "show_in_two_rows", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Item Margin Left(px)",
                        "param_name" => "item_margin_left",
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Item Margin Right(px)",
                        "param_name" => "item_margin_right",
                        "description" => ""
                    )
                )
            ) );
        }

    }

    public function render($atts, $content = null) {
        global $eltd_options;

        $args = array(
            "carousel" => "",
            "orderby" => "date",
            "order" => "ASC",
            "number_of_items" => "",
            "show_navigation" => "",
            "show_in_two_rows" => "",
            "margin_between_rows" => "",
            "item_margin_left" => "",
            "item_margin_right" => ""
        );

        extract(shortcode_atts($args, $atts));

        $carousel = esc_attr($carousel);
        $margin_between_rows = esc_attr($margin_between_rows);
        $item_margin_left = esc_attr($item_margin_left);
        $item_margin_right = esc_attr($item_margin_right);

        $item_margin_style = array();

        if($item_margin_left !=''){
            $item_margin_style[] = 'margin-left: '. $item_margin_left .'px';
        }

        if($item_margin_right !=''){
            $item_margin_style[] = 'margin-right: '. $item_margin_right .'px';
        }


        $item_margin_style_string = '';

        if(is_array($item_margin_style) && count($item_margin_style)) {
            $item_margin_style_string = 'style="'.implode(';', $item_margin_style).'"';
        }

        $data_attribute = "";
        if ($number_of_items !== "") {
            $data_attribute .= " data-number_of_items='" . $number_of_items. "'";
        }


        $html = "";
        $margin_between_rows_style = '';

        if ($carousel != "") {
            $carousel_holder_classes = array();

            if ($show_in_two_rows == 'yes') {
                $carousel_holder_classes[] = 'two_rows';

                $margin_between_rows_style = '';
                if ($margin_between_rows != '') {
                    $valid_margin_between_rows = (strstr($margin_between_rows, 'px', true)) ? $margin_between_rows : $margin_between_rows . 'px';
                    $margin_between_rows_style = 'style="margin-bottom:' . $valid_margin_between_rows . ';"';
                }
            }

            $html .= "<div class='eltd_carousels_holder clearfix " . implode(' ', $carousel_holder_classes) . "'><div class='eltd_carousels' " . $data_attribute . "><ul class='slides'>";

            $q = array('post_type' => 'carousels', 'carousels_category' => $carousel, 'orderby' => $orderby, 'order' => $order, 'posts_per_page' => '-1');

            query_posts($q);
            $have_posts = false;

            if (have_posts()) : $post_count = 1;
                $have_posts = true;
                while (have_posts()) : the_post();

                    if (get_post_meta(get_the_ID(), "eltd_carousel-image", true) != "") {
                        $image = get_post_meta(get_the_ID(), "eltd_carousel-image", true);
                    } else {
                        $image = "";
                    }

                    if (get_post_meta(get_the_ID(), "eltd_carousel-hover-image", true) != "") {
                        $hover_image = get_post_meta(get_the_ID(), "eltd_carousel-hover-image", true);
                        $has_hover_image = "has_hover_image";
                    } else {
                        $hover_image = "";
                        $has_hover_image = "";
                    }

                    if (get_post_meta(get_the_ID(), "eltd_carousel-item-link", true) != "") {
                        $link = get_post_meta(get_the_ID(), "eltd_carousel-item-link", true);
                    } else {
                        $link = "";
                    }

                    if (get_post_meta(get_the_ID(), "eltd_carousel-item-target", true) != "") {
                        $target = get_post_meta(get_the_ID(), "eltd_carousel-item-target", true);
                    } else {
                        $target = "_self";
                    }

                    $title = get_the_title();

                    //is current item not on even position in array and two rows option is chosen?
                    if ($post_count % 2 !== 0 && $show_in_two_rows == 'yes') {
                        $html .= "<li class='item'>";
                    } elseif ($show_in_two_rows == '') {
                        $html .= "<li class='item'>";
                    }

                    $html .= '<div class="carousel_item_holder" ' . $margin_between_rows_style . '>';
                    $html .= '<div class="carousel_item_holder_inner" '.$item_margin_style_string.'>';

                    if ($link != "") {
                        $html .= "<a href='" . $link . "' target='" . $target . "'>";
                    }

                    if ($image != "") {
                        $html .= "<span class='first_image_holder " . $has_hover_image . "'><img src='" . $image . "' alt='" . $title . "'></span>";
                    }

                    if ($hover_image != "") {
                        $html .= "<span class='second_image_holder " . $has_hover_image . "'><img src='" . $hover_image . "' alt='" . $title . "'></span>";
                    }

                    if ($link != "") {
                        $html .= "</a>";
                    }

                    $html .= '</div>'; //close carousel_item_holder_inner div
                    $html .= '</div>'; //close carousel_item_holder div

                    //is current item on even position in array and two rows option is chosen?
                    if ($post_count % 2 == 0 && $show_in_two_rows == 'yes') {
                        $html .= "</li>";
                    } elseif ($show_in_two_rows == '') {
                        $html .= "</li>";
                    }

                    $post_count++;

                endwhile;

            else:
                $html .= __('Sorry, no posts matched your criteria.', 'eltd_cpt');
            endif;

            wp_reset_query();

            $html .= "</ul>";

            if ($show_navigation != 'no' && $have_posts) {

                $icon_navigation_class = 'arrow_carrot-';
                if (isset($eltd_options['carousel_navigation_arrows_type']) && $eltd_options['carousel_navigation_arrows_type'] != '') {
                    $icon_navigation_class = $eltd_options['carousel_navigation_arrows_type'];
                }

                $direction_nav_classes['left_icon_class'] = 'arrow_carrot-left';
                $direction_nav_classes['right_icon_class'] = 'arrow_carrot-right';

                if(eltdcpt_theme_installed()) {
                    $direction_nav_classes = eltd_horizontal_slider_icon_classes($icon_navigation_class);
                }

                //generate navigation html
                $html .= '<ul class="caroufredsel-direction-nav">';

                $html .= '<li class="caroufredsel-prev-holder">';

                $html .= '<a id="caroufredsel-prev" class="eltd_carousel_prev caroufredsel-navigation-item caroufredsel-prev" href="javascript: void(0)">';

                $html .= '<span class="'.$direction_nav_classes['left_icon_class'].'"></span>';

                $html .= '</a>';

                $html .= '</li>'; //close li.caroufredsel-prev-holder

                $html .= '<li class="caroufredsel-next-holder">';
                $html .= '<a class="eltd_carousel_next caroufredsel-next caroufredsel-navigation-item" id="caroufredsel-next" href="javascript: void(0)">';

                $html .= '<span class="'.$direction_nav_classes['right_icon_class'].'"></span>';

                $html .= '</a>';

                $html .= '</li>'; //close li.caroufredsel-next-holder

                $html .= '</ul>'; //close ul.caroufredsel-direction-nav
            }
            $html .= "</div></div>";
        }

        return $html;
    }
}

new EltdCarouselShortcode();