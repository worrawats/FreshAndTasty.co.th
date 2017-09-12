<?php

$args = array(
    "background_color" => ""
);
extract(shortcode_atts($args, $atts));

$background_color = esc_attr($background_color);

$eltd_preloader_style = '';
if($background_color != "") {
    $eltd_preloader_style .= "style='";

    if ($background_color != "") {
        $eltd_preloader_style .= "background-color:".$background_color.";";
    }

    $eltd_preloader_style .= "'";
}

$html = "";

$html .= '<div class="vertical_split_slider_preloader" '.$eltd_preloader_style.'><div class="ajax_loader"><div class="ajax_loader_1">'.eltd_loading_spinners(true).'</div></div></div>';
$html .= '<div class="vertical_split_slider">';
$html .= do_shortcode($content);
$html .= '</div>';

print $html;

