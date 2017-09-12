<?php

class EltdTestimonialsShortcode {
    public function __construct() {
        add_shortcode('no_testimonials', array($this, 'render'));
        add_action('vc_before_init', array($this, 'vcMap'));
    }

    public function vcMap() {
        if(function_exists('vc_map')) {
            vc_map( array(
                "name" => "Testimonials",
                "base" => 'no_testimonials',
                "category" => 'by Elated',
                "icon" => "icon-wpb-testimonials extended-custom-icon",
                "allowed_container_element" => 'vc_row',
                "params" => array(
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
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Number",
                        "param_name" => "number",
                        "value" => "",
                        "description" => "Number of Testimonials"
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Title",
                        "param_name" => "show_title",
                        "value" => array(
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        'save_always' => true,
                        "description" => ""
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Title Color",
                        "param_name" => "title_color",
                        "description" => "",
                        "dependency" => array("element" => "show_title", "value" => array("yes"))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Title Separator",
                        "param_name" => "show_title_separator",
                        "value" => array(
                            "No" => "no",
                            "Yes" => "yes"

                        ),
                        'save_always' => true,
                        "description" => ""
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Separator Color",
                        "param_name" => "separator_color",
                        "description" => "",
                        "dependency" => array("element" => "show_title_separator", "value" => array("yes"))
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Separator Width",
                        "param_name" => "separator_width",
                        "description" => "",
                        "dependency" => array("element" => "show_title_separator", "value" => array("yes"))
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Separator Height",
                        "param_name" => "separator_height",
                        "description" => "",
                        "dependency" => array("element" => "show_title_separator", "value" => array("yes"))
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Text Color",
                        "param_name" => "text_color",
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Text Font Size",
                        "param_name" => "text_font_size",
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Author",
                        "param_name" => "show_author",
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
                        "heading" => "Author Position",
                        "param_name" => "author_position",
                        "value" => array(
                            "Below Text" => "below_text",
                            "Above Text" => "above_text"
                        ),
                        'save_always' => true,
                        "description" => ""
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Author Text Color",
                        "param_name" => "author_text_color",
                        "description" => "",
                        "dependency" => array("element" => "show_author", "value" => array("yes"))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Author Job Position",
                        "param_name" => "show_position",
                        "value" => array(
                            "No" => "no",
                            "Yes" => "yes"
                        ),
                        'save_always' => true,
                        "dependency" => array("element" => "show_author", "value" => array("yes")),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Job Position Placement",
                        "param_name" => "job_position_placement",
                        "value" => array(
                            "In line with name" => "inline",
                            "Below name" => "below"
                        ),
                        'save_always' => true,
                        "dependency" => array("element" => "show_position", "value" => array("yes")),
                        "description" => ""
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Job Color",
                        "param_name" => "job_color",
                        "dependency" => array("element" => "show_position", "value" => array("yes")),
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Job Font size (px)",
                        "param_name" => "job_font_size",
                        "dependency" => array("element" => "show_position", "value" => array("yes")),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Job Font style",
                        "param_name" => "job_font_style",
                        "value" => array(
                            "" => "",
                            "Normal" => "normal",
                            "Italic" => "italic"
                        ),
                        "dependency" => array("element" => "show_position", "value" => array("yes")),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Image",
                        "param_name" => "show_image",
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
                        "heading" => "Image Position Related to Testimonial Content",
                        "param_name" => "image_position",
                        "value" => array(
                            "Top" => "top",
                            "Bottom" => "bottom"
                        ),
                        'save_always' => true,
                        "description" => "",
                        "dependency" => array("element" => "show_image", "value" => array("yes"))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Image Position Related to Testimonial Slide",
                        "param_name" => "image_position_slide",
                        "value" => array(
                            "Over the Edge" => "over",
                            "Inside" => "inside"

                        ),
                        'save_always' => true,
                        "description" => "Image size when the image position is over the edge of testimonial slide is fixed (113x113px). Image size when the image position is inside of testimonial slide is original.",
                        "dependency" => array("element" => "show_image", "value" => array("yes"))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Image Border",
                        "param_name" => "show_image_border",
                        "value" => array(
                            "No" => "no",
                            "Yes" => "yes"

                        ),
                        'save_always' => true,
                        "description" => "",
                        "dependency" => array("element" => "show_image", "value" => array("yes"))
                    ),

                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Image Border Color",
                        "param_name" => "image_border_color",
                        "description" => "",
                        "dependency" => array("element" => "show_image_border", "value" => array("yes"))
                    ),

                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Image Border Width",
                        "param_name" => "image_border_width",
                        "description" => "",
                        "dependency" => array("element" => "show_image_border", "value" => array("yes"))
                    ),

                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Text Align",
                        "param_name" => "text_align",
                        "value" => array(
                            "Left"   => "left_align",
                            "Center" => "center_align",
                            "Right"  => "right_align"
                        ),
                        'save_always' => true
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Navigation Arrows",
                        "param_name" => "show_navigation_arrows",
                        "value" => array(
                            "No" => "no",
                            "Yes" => "yes"
                        ),
                        'save_always' => true,
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Navigation",
                        "param_name" => "show_navigation",
                        "value" => array(
                            "No" => "no",
                            "Yes" => "yes"

                        ),
                        'save_always' => true,
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Auto rotate slides",
                        "param_name" => "auto_rotate_slides",
                        "value" => array(
                            "3"         => "3",
                            "5"         => "5",
                            "10"        => "10",
                            "15"        => "15",
                            "Disable"   => "0"
                        ),
                        'save_always' => true,
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Animation speed",
                        "param_name" => "animation_speed",
                        "value" => "",
                        "description" => __("Speed of slide animation in miliseconds", "eltd_cpt")
                    )
                )
            ) );
        }
    }

    public function render($atts, $content = null) {
        global $eltd_options;

        $deafult_args = array(
            "number" => "-1",
            "category" => "",
            "show_title" => "",
            "title_color" => "",
            "show_title_separator" => "no",
            "separator_color" => "",
            "separator_width" => "",
            "separator_height" => "",
            "text_color" => "",
            "text_font_size" => "",
            "show_author" => "yes",
            "author_position" => "below_text",
            "author_text_color" => "",
            "show_position" => "no",
            "job_position_placement" => "",
            "job_color" => "",
            "job_font_size" => "",
            "job_font_style" => "",
            "text_align" => "left_align",
            "show_navigation" => "no",
            "show_navigation_arrows" => "no",
            "auto_rotate_slides" => "",
            "animation_speed" => "",
            "show_image" => "yes",
            "image_position" => "top",
            "show_image_border" => "no",
            "image_border_color" => "",
            "image_border_width" => "",
            "image_position_slide" => ""
        );

        extract(shortcode_atts($deafult_args, $atts));

        $number = esc_attr($number);
        $category = esc_attr($category);
        $title_color = esc_attr($title_color);
        $separator_color = esc_attr($separator_color);
        $separator_width = esc_attr($separator_width);
        $separator_height = esc_attr($separator_height);
        $text_color = esc_attr($text_color);
        $text_font_size = esc_attr($text_font_size);
        $author_text_color = esc_attr($author_text_color);
        $job_color = esc_attr($job_color);
        $job_font_size = esc_attr($job_font_size);
        $job_font_style = esc_attr($job_font_style);
        $animation_speed = esc_attr($animation_speed);
        $image_border_color = esc_attr($image_border_color);
        $image_border_width = esc_attr($image_border_width);

        $html = "";
        $html_author = "";
        $testimonial_p_style = "";
        $testimonial_separator_style = "";
        $testimonial_title_style = "";
        $navigation_button_radius = "";
        $testimonial_name_styles = "";
        $testimonials_clasess = "";
        $image_clasess = "";
        $testimonial_image_border_style = "";
        $job_style = "";


        if ($show_navigation_arrows == "yes") {
            $testimonials_clasess .= ' with_arrows';
        }

        if ($show_image == "yes" && $image_position == "top") {
            $image_clasess .= ' image_top';
        }

        if ($show_image == "yes" && $image_position == "bottom") {
            $image_clasess .= ' image_bottom';
        }


        if ($show_image == "yes" && $image_position_slide == "inside") {
            $image_clasess .= ' relative_position';
        }

        if ($show_image == "yes" && $image_position_slide == "over") {
            $image_clasess .= ' absolute_position';
        }

        if ($separator_color != "") {
            $testimonial_separator_style .= "background-color: " . $separator_color . ";";
        }
        if ($separator_width != "") {
            $testimonial_separator_style .= "width: " . $separator_width . "px;";
        }
        if ($separator_height != "") {
            $testimonial_separator_style .= "height: " . $separator_height . "px;";
        }
        if ($title_color != "") {
            $testimonial_title_style .= "color: " . $title_color . ";";
        }

        if ( $show_image_border == "yes" ) {
            if ($image_border_color != "") {
                $testimonial_image_border_style .= "border-color: " . $image_border_color . ";";
            }

            if ($image_border_width != "") {
                $testimonial_image_border_style .= "border-width: " . $image_border_width . "px;";
            }
        }


        if ($text_font_size != "" || $text_color != "") {
            $testimonial_p_style = " style='";
            if ($text_font_size != "") {
                $testimonial_p_style .= "font-size:" . $text_font_size . "px;";
            }
            if ($text_color != "") {
                $testimonial_p_style .= "color:" . $text_color . ";";
            }
            $testimonial_p_style .= "'";
        }

        if ($author_text_color != "") {
            $testimonial_name_styles .= "color: " . $author_text_color . ";";
        }

        if ($job_color != "") {
            $job_style .= 'color: '.$job_color.';';
        }
        if ($job_font_size != "") {
            $job_font_size = (strstr($job_font_size, 'px', true)) ? $job_font_size : $job_font_size . 'px';
            $job_style .= 'font-size: '.$job_font_size.'px;';
        }
        if ($job_font_style != "") {
            $job_style .= 'font-style: '.$job_font_style.';';
        }

        $args = array(
            'post_type' => 'testimonials',
            'orderby' => "date",
            'order' => "DESC",
            'posts_per_page' => $number
        );

        if ($category != "") {
            $args['testimonials_category'] = $category;
        }


        $html .= "<div class='testimonials_holder clearfix'>";
        $html .= '<div class="testimonials testimonials_carousel ' . $testimonials_clasess . '" data-show-navigation="' . $show_navigation . '" data-show-navigation-arrows="' . $show_navigation_arrows . '" data-animation-speed="' . $animation_speed . '" data-auto-rotate-slides="' . $auto_rotate_slides . '">';
        $html .= '<ul class="slides">';

        query_posts($args);
        if (have_posts()) :
            while (have_posts()) : the_post();
                $author = get_post_meta(get_the_ID(), "eltd_testimonial-author", true);
                $text = get_post_meta(get_the_ID(), "eltd_testimonial-text", true);
                $title = get_post_meta(get_the_ID(), "eltd_testimonial_title", true);
                $job = get_post_meta(get_the_ID(), "eltd_testimonial_author_position", true);


                $html .= '<li id="testimonials-' . get_the_ID() . '" class="testimonial_content ' . $text_align . ' '
                    . $image_clasess . '">';

                if ($show_image == "yes" && !($image_position == "bottom" && $image_position_slide == "inside")) {
                    $html .= '<div class="testimonial_image_holder" style="' . $testimonial_image_border_style . '">' . get_the_post_thumbnail(get_the_ID()) . '</div>';
                }
                $html .= '<div class="testimonial_content_inner"';

                $html .= '>';
                $html .= '<div class="testimonial_text_holder ' . $text_align . '">';

                if ($show_author == "yes") {
                    $html_author = '<p class="testimonial_author" style="' . $testimonial_name_styles . '">- ' . $author;
                    if ($show_position == "yes" && $job !== '') {
                        if( $job_position_placement == "inline" ) {
                            $html_author .= ', <span class="testimonials_job" style="'.$job_style.'">'.$job.'</span>';
                        }
                        elseif ( $job_position_placement == "below") {
                            $html_author .= '<span class="testimonials_job below" style="'.$job_style.'">'.$job.'</span>';
                        }
                    }
                    $html_author .= '</p>';
                }

                $testimonial_text_inner_class = '';
                if($show_title == "no") {
                    $testimonial_text_inner_class .= ' without_title';
                }

                $html .= '<div class="testimonial_text_inner'. $testimonial_text_inner_class .'">';
                if ($show_title == "yes") {
                    $html .= '<p class="testimonial_title" style="' . $testimonial_title_style . '">' . $title . '</p>';
                }
                if ($show_title_separator == "yes") {
                    $html .= '<span class="testimonial_separator" style="' . $testimonial_separator_style . '"></span>';
                }
                if ($author_position == "below_text") {
                    $html .= '<p class="testimonial_text"' . $testimonial_p_style . '>' . trim($text) . '</p>';
                    $html .= $html_author;
                } elseif ($author_position == "above_text") {
                    $html .= $html_author;
                    $html .= '<p class="testimonial_text"' . $testimonial_p_style . '>' . trim($text) . '</p>';
                }


                $html .= '</div>'; //close testimonial_text_inner
                $html .= '</div>'; //close testimonial_text_holder

                $html .= '</div>'; //close testimonial_content_inner
                if ($show_image == "yes" && $image_position == "bottom" && $image_position_slide == "inside") {
                    $html .= '<div class="testimonial_image_holder" style="' . $testimonial_image_border_style . '">' . get_the_post_thumbnail(get_the_ID()) . '</div>';
                }
                $html .= '</li>'; //close testimonials
            endwhile;
        else:
            $html .= __('Sorry, no posts matched your criteria.', 'eltd_cpt');
        endif;

        wp_reset_query();
        $html .= '</ul>'; //close slides
        $html .= '</div>';
        $html .= '</div>';
        return $html;
    }
}

new EltdTestimonialsShortcode();