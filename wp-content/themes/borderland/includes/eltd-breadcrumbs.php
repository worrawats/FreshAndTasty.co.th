<?php

if(!function_exists('eltd_custom_breadcrumbs')) {
	/**
	 * Function that renders breadcrumbs
	 *
	 * @see home_url()
	 * @see get_option()
	 * @see get_post_meta()
	 * @see is_home()
	 * @see is_front_page()
	 * @see is_category()
	 * @see eltd_is_product_category()
	 * @see get_search_query()
	 */
	function eltd_custom_breadcrumbs() {
		global $post, $wp_query;

		$output = "";
		$homeLink = home_url();
		$pageid = $wp_query->get_queried_object_id();
		$bread_style = "";

		if(get_post_meta($pageid, "eltd_page_breadcrumbs_color", true) != ""){
			$bread_style="color:". get_post_meta($pageid, "eltd_page_breadcrumbs_color", true);
		}

		$showOnHome = 1; // 1 - show breadcrumbs on the homepage, 0 - don't show
		$delimiter = '<span class="delimiter" '.eltd_get_inline_style($bread_style).'>&nbsp;/&nbsp;</span>'; // delimiter between crumbs
		$home = get_bloginfo('name'); // text for the 'Home' link
		$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
		$before = '<span class="current" '.eltd_get_inline_style($bread_style).'>'; // tag before the current crumb
		$after = '</span>'; // tag after the current crumb

		if (is_home() && !is_front_page()) {
			$output = '<div class="breadcrumbs"><div class="breadcrumbs_inner"><a '.eltd_get_inline_style($bread_style).' href="' . $homeLink . '">' . $home . '</a>' . $delimiter . ' <a '.eltd_get_inline_style($bread_style).' href="' . $homeLink . '">'. get_the_title($pageid) .'</a></div></div>';

		} elseif(is_home()) {
			$output = '<div class="breadcrumbs"><div class="breadcrumbs_inner">'.$before.$home.$after.'</div></div>';
		}

		elseif(is_front_page()) {
			if ($showOnHome == 1) $output = '<div class="breadcrumbs"><div class="breadcrumbs_inner"><a '.eltd_get_inline_style($bread_style).' href="' . $homeLink . '">' . $home . '</a></div></div>';
		}

		else {

			$output .= '<div class="breadcrumbs"><div class="breadcrumbs_inner"><a '.eltd_get_inline_style($bread_style).' href="' . $homeLink . '">' . $home . '</a>' . $delimiter;

			if ( is_category() || eltd_is_product_category()) {
				$thisCat = get_category(get_query_var('cat'), false);
				if (isset($thisCat->parent) && $thisCat->parent != 0) $output .= get_category_parents($thisCat->parent, TRUE, ' ' . $delimiter);
				$output .= $before . single_cat_title('', false) . $after;

			} elseif ( is_search() ) {
				$output .= $before . 'Search results for "' . get_search_query() . '"' . $after;

			} elseif ( is_day() ) {
				$output .= '<a '.eltd_get_inline_style($bread_style).' href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $delimiter;
				$output .= '<a '.eltd_get_inline_style($bread_style).' href="' . get_month_link(get_the_time('Y'),get_the_time('m')) . '">' . get_the_time('F') . '</a>' . $delimiter;
				$output .= $before . get_the_time('d') . $after;

			} elseif ( is_month() ) {
				$output .= '<a '.eltd_get_inline_style($bread_style).' href="' . get_year_link(get_the_time('Y')) . '">' . get_the_time('Y') . '</a>' . $delimiter;
				$output .= $before . get_the_time('F') . $after;

			} elseif ( is_year() ) {
				$output .= $before . get_the_time('Y') . $after;

			} elseif ( is_single() && !is_attachment() ) {
				if ( get_post_type() != 'post' ) {
					$post_type = get_post_type_object(get_post_type());
					$slug = $post_type->rewrite;
					if ($showCurrent == 1) $output .= $before . get_the_title() . $after;
				} else {
					$cat = get_the_category(); $cat = $cat[0];
					$cats = get_category_parents($cat, TRUE, ' ' . $delimiter);
					if ($showCurrent == 0) $cats = preg_replace("#^(.+)\s$delimiter\s$#", "$1", $cats);
					$output .= $cats;
					if ($showCurrent == 1) $output .= $before . get_the_title() . $after;
				}

			}  elseif ( is_attachment() && !$post->post_parent ) {
				if ($showCurrent == 1) $output .= $before . get_the_title() . $after;

			} elseif ( is_attachment() ) {
				$parent = get_post($post->post_parent);
				$cat = get_the_category($parent->ID);
				if($cat) {
					$cat = $cat[0];
					$output .= get_category_parents($cat, TRUE, ' ' . $delimiter);
				}
				$output .= '<a '.eltd_get_inline_style($bread_style).' href="' . get_permalink($parent) . '">' . $parent->post_title . '</a>';
				if ($showCurrent == 1) $output .= $delimiter . $before . get_the_title() . $after;

			} elseif ( is_page() && !$post->post_parent ) {
				if ($showCurrent == 1) $output .= $before . get_the_title() . $after;

			} elseif ( is_page() && $post->post_parent ) {
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = '<a '.eltd_get_inline_style($bread_style).' href="' . get_permalink($page->ID) . '">' . get_the_title($page->ID) . '</a>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				for ($i = 0; $i < count($breadcrumbs); $i++) {
					$output .= $breadcrumbs[$i];
					if ($i != count($breadcrumbs)-1) $output .= ' ' . $delimiter;
				}
				if ($showCurrent == 1) $output .= $delimiter . $before . get_the_title() . $after;

			} elseif ( is_tag() ) {
				$output .= $before . 'Posts tagged "' . single_tag_title('', false) . '"' . $after;

			} elseif ( is_author() ) {
				global $author;
				$userdata = get_userdata($author);
				$output .= $before . 'Articles posted by ' . $userdata->display_name . $after;

			} elseif ( is_404() ) {
				$output .= $before . 'Error 404' . $after;
			} elseif(function_exists("is_woocommerce") && is_shop()){
				global $woocommerce;
				$shop_id = get_option('woocommerce_shop_page_id');
				$shop= get_page($shop_id);
				$output .= $before .  $shop->post_title . $after;
			}

			if ( get_query_var('paged') ) {

				$output .= $before . " (" . __('Page', 'eltd') . ' ' . get_query_var('paged') . ")" . $after;

			}

			$output .= '</div></div>';

		}

		echo wp_kses($output, array(
			'div' => array(
				'id' => true,
				'class' => true,
				'style' => true
			),
			'span' => array(
				'class' => true,
				'id' => true,
				'style' => true
			),
			'a' => array(
				'class' => true,
				'id' => true,
				'href' => true,
				'style' => true
			)
		));
	}
}