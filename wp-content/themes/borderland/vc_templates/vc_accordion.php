<?php
$output = $title = $interval = $el_class = $collapsible = $active_tab = $style = '';
//
   
extract(shortcode_atts(array(
    'title' => '',
    'interval' => 0,
    'el_class' => '',
    'collapsible' => 'no',
    'active_tab' => '',
    'accordion_border_radius' => '',
    'hide_icon' => '',
	'style' => 'accordion',
	'title_alignment' => '',
	'title_icon_alignment' => ''
), $atts));

$accordion_border_radius = esc_attr($accordion_border_radius);
$el_class = esc_attr($el_class);
$active_tab = esc_attr($active_tab);

//define accordion type classes
$acc_class = "";
switch($style) {
    case "toggle":
        $acc_class .= "toggle";
        break;
    case "boxed_accordion":
        $acc_class .= "accordion boxed";
        break;
    case "boxed_toggle":
        $acc_class .= "toggle boxed";
        break;
    default:
        $acc_class = "accordion";
}
if ($hide_icon == "yes") {
    $acc_class .= " accordion_hide_icon";
	
	if($title_alignment !=''){
		
		if($title_alignment == 'left'){			
			$acc_class .= " accordion_left_align";			
		}elseif ($title_alignment == 'right') {
			$acc_class .= " accordion_right_align";
		}else{
			$acc_class .= " accordion_center_align";
		}
	}
}else{
	$acc_class .= " accordion_show_icon";
	if($title_icon_alignment != ""){		
		if($title_icon_alignment == "icon_left"){
			$acc_class .= " icon_left_align";
		}elseif($title_icon_alignment == "text_left"){
			$acc_class .= " text_left_align";
		}
	}
}

$el_class = $this->getExtraClass($el_class);
$css_class = apply_filters(VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, 'eltd_accordion_holder clearfix wpb_content_element '. $acc_class ." " . $el_class.' not-column-inherit', $this->settings['base']);

$output .= "\n\t".'<div class="'.$css_class.'" data-active-tab="'.$active_tab.'" data-collapsible="'.$collapsible.'" data-border-radius="'.$accordion_border_radius.'">';
$output .= "\n\t\t\t".wpb_js_remove_wpautop($content);
$output .= "\n\t".'</div> '.$this->endBlockComment('.wpb_accordion');

print $output;