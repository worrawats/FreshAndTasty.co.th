<?php

$args = array(
    "columns"         => "four_columns"
);

$html = "";

extract(shortcode_atts($args, $atts));

$html = '<div class="eltd_pricing_tables clearfix '.$columns.'">';

$html .= do_shortcode($content);

$html .= '</div>';

print $html;