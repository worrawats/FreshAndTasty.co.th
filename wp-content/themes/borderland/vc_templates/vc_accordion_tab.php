<?php
$output = $title = $icon = $title_color = $background_color = $el_id = '';

extract(shortcode_atts(array(
	'title'            => __("Accordion Title", "js_composer"),
	'title_color'      => "",
	'background_color' => "",
    'title_tag'        => 'h4',
	'el_id' => ''
), $atts));

$title = esc_html($title);
$title_color = esc_attr($title_color);
$background_color = esc_attr($background_color);

$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'wpb_accordion_section group', $this->settings['base']);
	$heading_styles = '';
	
	if($title_color != "") {
        $heading_styles .= "color: ".$title_color.";";
    }

    if($title_tag == ""){
    	$title_tag = 'h4';
    }

    if($background_color != "") {
        $heading_styles .= " background-color: ".$background_color.";";
    }

    $output .= "\n\t\t\t\t" . '<'.$title_tag.' class="clearfix title-holder" style="'.$heading_styles.'">';

	$output .= '<span class="accordion_mark left_mark"><span class="accordion_mark_icon"><span class="arrow_carrot-right"></span><span class="arrow_carrot-down"></span></span></span>';
	$output .= '<span class="tab-title"><span class="tab-title-inner">'.$title.'</span></span>';

	$output .= '</'.$title_tag.'>';
    $output .= "\n\t\t\t\t" . '<div ' . ( isset( $el_id ) && ! empty( $el_id ) ? "id='" . esc_attr( $el_id ) . "'" : "" ) . ' class="accordion_content">';
		$output .= "\n\t\t\t" . '<div class="accordion_content_inner">';
			$output .= ($content=='' || $content==' ') ? __("Empty section. Edit page to add content here.", "js_composer") : "\n\t\t\t\t" . wpb_js_remove_wpautop($content);
			$output .= "\n\t\t\t" . '</div>';
		 $output .= "\n\t\t\t\t" . '</div>' . $this->endBlockComment('.wpb_accordion_section') . "\n";

print $output;