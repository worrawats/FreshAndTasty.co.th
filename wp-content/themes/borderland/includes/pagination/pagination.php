<?php

if (!function_exists('eltd_pagination')) {
	function eltd_pagination($pages = '', $range = 4, $paged = 1){
		global $eltd_options;
		$showitems = $range+1;

		if($pages == ''){
			global $wp_query;
			$pages = $wp_query->max_num_pages;
			if(!$pages){
				$pages = 1;
			}
		}
		$pagination_classes = '';
		if( isset($eltd_options['pagination_type']) && $eltd_options['pagination_type'] == 'standard' ) {
			if( isset($eltd_options['pagination_standard_position']) && $eltd_options['pagination_standard_position'] !== '' ) {
				$pagination_classes .= "standard_".esc_attr($eltd_options['pagination_standard_position']);
			}
		}
		elseif ( isset($eltd_options['pagination_type']) && $eltd_options['pagination_type'] == 'arrows_on_sides' ) {
			$pagination_classes .= "arrows_on_sides";
		}

		$pagination_style = "";
		if ( isset($eltd_options['blog_pagination_border_above_yesno']) && $eltd_options['blog_pagination_border_above_yesno'] == 'yes' ){
			$pagination_classes .= " pagination_with_border";
			if ( isset($eltd_options['blog_pgn_border_color']) && $eltd_options['blog_pgn_border_color'] != '' ){
				$pagination_style .= "border-top-color:" . $eltd_options['blog_pgn_border_color'] . "; ";
			}
			else {
				$pagination_style .= "border-top-color: #dedede; ";
			}

			if ( isset($eltd_options['blog_pgn_border_width']) && $eltd_options['blog_pgn_border_width'] != '' ){
				$pagination_style .= "border-top-width:" . $eltd_options['blog_pgn_border_width'] . "px; ";
			}
			else {
				$pagination_style .= "border-top-width: 1px; ";
			}

			if ( isset($eltd_options['blog_pgn_border_style']) && $eltd_options['blog_pgn_border_style'] != '' ){
				$pagination_style .= "border-top-style:" . $eltd_options['blog_pgn_border_style'] . "; ";
			}
			else {
				$pagination_style .= "border-top-style: solid; ";
			}

			if ( isset($eltd_options['blog_pagination_border_margin']) && $eltd_options['blog_pagination_border_margin'] != '' ){
				$pagination_style .= "padding-top:" . $eltd_options['blog_pagination_border_margin'] . "px; ";
			}
			else {
				$pagination_style .= "padding-top: 40px; ";
			}

		}
		if(1 != $pages){

			echo "<div class='pagination ".esc_attr($pagination_classes)."' ".eltd_get_inline_style($pagination_style)."><ul>";

			$icon_first_left_html =  "<span class='pagination_arrow arrow_carrot-2left'></span>";
			if (isset($eltd_options['pagination_double_arrows_type']) && $eltd_options['pagination_double_arrows_type'] != '') {
				$icon_navigation_class = $eltd_options['pagination_double_arrows_type'];
				$direction_nav_classes = eltd_horizontal_slider_icon_classes($icon_navigation_class);
				$icon_first_left_html = '<span class="pagination_arrow ' . esc_attr($direction_nav_classes['left_icon_class']). '"></span>';
			}
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li class='first'><a href='".esc_url(get_pagenum_link(1))."'>$icon_first_left_html</a></li>";
			echo "<li class='prev";
			if($paged > 2 && $paged > $range+1 && $showitems < $pages) {
				echo " prev_first";
			}

			$icon_left_html =  "<i class='pagination_arrow arrow_carrot-left'></i>";
			if (isset($eltd_options['pagination_arrows_type']) && $eltd_options['pagination_arrows_type'] != '') {
				$icon_navigation_class = $eltd_options['pagination_arrows_type'];
				$direction_nav_classes = eltd_horizontal_slider_icon_classes($icon_navigation_class);
				$icon_left_html = '<span class="pagination_arrow ' . $direction_nav_classes['left_icon_class']. '"></span>';
			}

			echo "'><a href='".esc_url(get_pagenum_link($paged - 1))."'>$icon_left_html</a></li>";

			for ($i=1; $i <= $pages; $i++){
				if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
					echo ($paged == $i)? "<li class='active'><span>".$i."</span></li>":"<li><a href='".get_pagenum_link($i)."' class='inactive'>".$i."</a></li>";
				}
			}

			echo "<li class='next";
			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages){
				echo " next_last";
			}
			echo "'><a href=\"";
			if($pages > $paged){
				echo esc_url(get_pagenum_link($paged + 1));
			} else {
				echo esc_url(get_pagenum_link($paged));
			}

			$icon_right_html =  "<i class='pagination_arrow arrow_carrot-right'></i>";

			if (isset($eltd_options['pagination_arrows_type']) && $eltd_options['pagination_arrows_type'] != '') {
				$icon_navigation_class = $eltd_options['pagination_arrows_type'];
				$direction_nav_classes = eltd_horizontal_slider_icon_classes($icon_navigation_class);
				$icon_right_html = '<span class="pagination_arrow ' . $direction_nav_classes['right_icon_class']. '"></span>';
			}

			echo "\">$icon_right_html</a></li>";


			$icon_last_right_html =  "<span class='pagination_arrow arrow_carrot-2right'></span>";

			if (isset($eltd_options['pagination_double_arrows_type']) && $eltd_options['pagination_double_arrows_type'] != '') {
				$icon_navigation_class = $eltd_options['pagination_double_arrows_type'];
				$direction_nav_classes = eltd_horizontal_slider_icon_classes($icon_navigation_class);
				$icon_last_right_html = '<span class="pagination_arrow ' . $direction_nav_classes['right_icon_class']. '"></span>';
			}

			if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<li class='last'><a href='".esc_url(get_pagenum_link($pages))."'>$icon_last_right_html</a></li>";
			echo "</ul></div>\n";
		}
	}
}
?>