<?php
	global $wp_query;
	global $eltd_options;
    global $eltd_template_name;
	$id = $wp_query->get_queried_object_id();

	if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
	elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
	else { $paged = 1; }

	$sidebar = $eltd_options['category_blog_sidebar'];

	if(isset($eltd_options['blog_page_range']) && $eltd_options['blog_page_range'] != ""){
		$blog_page_range = esc_attr($eltd_options['blog_page_range']);
	} else{
		$blog_page_range = $wp_query->max_num_pages;
	}
	
	$blog_style = "1";
	if(isset($eltd_options['blog_style'])){
		$blog_style = $eltd_options['blog_style'];
	}

	$filter = "no";
	if(isset($eltd_options['blog_masonry_filter'])){
		$filter = $eltd_options['blog_masonry_filter'];
	}
	
	$blog_list = "";
	if($eltd_template_name != "") {
		if($eltd_template_name == "blog-masonry.php"){
			$blog_list = "blog_masonry";
			$blog_list_class = "masonry";
		}elseif($eltd_template_name == "blog-masonry-full-width.php"){
			$blog_list = "blog_masonry";
			$blog_list_class = "masonry_full_width";
		}elseif($eltd_template_name == "blog-standard.php"){
            $blog_list = "blog_standard";
            $blog_list_class = "blog_standard_type";
        }elseif($eltd_template_name == "blog-standard-whole-post.php"){
			$blog_list = "blog_standard_whole_post";
			$blog_list_class = "blog_standard_type";
		}else{
			$blog_list = "blog_standard";
			$blog_list_class = "blog_standard_type";
		}
	} else {
		if($blog_style=="1"){
			$blog_list = "blog_standard";
			$blog_list_class = "blog_standard_type";
		}elseif($blog_style=="2"){
			$blog_list = "blog_masonry";
			$blog_list_class = "masonry";
        }elseif($blog_style=="3"){
			$blog_list = "blog_masonry";
			$blog_list_class = "masonry_full_width";
        }elseif($blog_style=="4"){
			$blog_list = "blog_standard_whole_post";
			$blog_list_class = "blog_standard_type";
        }else {
			$blog_list = "blog_standard";
			$blog_list_class = "blog_standard_type";
		}
	}

    $pagination_masonry = "pagination";
    if(isset($eltd_options['pagination_masonry'])){
       $pagination_masonry = $eltd_options['pagination_masonry'];
		if($blog_list == "blog_masonry") {
			$blog_list_class .= " masonry_" . $pagination_masonry;
		}
    }

?>
<?php

	if($blog_list == "blog_masonry" && $filter == "yes") {
		get_template_part('templates/blog/masonry', 'filter');
	}

	$blog_masonry_columns = 'two_columns';
	if (isset($eltd_options['blog_masonry_columns']) && $eltd_options['blog_masonry_columns'] !== '') {
		$blog_masonry_columns = $eltd_options['blog_masonry_columns'];
	}
	

	$blog_masonry_full_width_columns = 'three_columns';
	if (isset($eltd_options['blog_masonry_full_width_columns']) && $eltd_options['blog_masonry_full_width_columns'] !== '') {
		$blog_masonry_full_width_columns = $eltd_options['blog_masonry_full_width_columns'];
	}
	
	if($eltd_template_name == "blog-masonry.php" || $blog_style == 2 ){
		$blog_list_class .= " " .$blog_masonry_columns;
	}
	
	if($eltd_template_name == "blog-masonry-full-width.php" || $blog_style == 3){
		$blog_list_class .= " " .$blog_masonry_full_width_columns;
	}

	$icon_left_html =  "<i class='pagination_arrow arrow_carrot-left'></i>";
	if (isset($eltd_options['pagination_arrows_type']) && $eltd_options['pagination_arrows_type'] != '') {
		$icon_navigation_class = $eltd_options['pagination_arrows_type'];
		$direction_nav_classes = eltd_horizontal_slider_icon_classes($icon_navigation_class);
		$icon_left_html = '<span class="pagination_arrow ' . $direction_nav_classes['left_icon_class']. '"></span>';
	}
	
	$icon_left_html .= '<span class="pagination_label">';
	if (isset($eltd_options['blog_pagination_next_label']) && $eltd_options['blog_pagination_next_label'] != '') {
		$icon_left_html.= $eltd_options['blog_pagination_next_label'];
	}
	else{
		$icon_left_html .= "Next";
	}
	$icon_left_html .= '</span>';


	$icon_right_html = '<span class="pagination_label">';
	if (isset($eltd_options['blog_pagination_previous_label']) && $eltd_options['blog_pagination_previous_label'] != '') {
		$icon_right_html .= $eltd_options['blog_pagination_previous_label'];
	}
	else {
		$icon_right_html .= "Previous";
	}
	$icon_right_html .= '</span>';

	if (isset($eltd_options['pagination_arrows_type']) && $eltd_options['pagination_arrows_type'] != '') {
		$icon_navigation_class = $eltd_options['pagination_arrows_type'];
		$direction_nav_classes = eltd_horizontal_slider_icon_classes($icon_navigation_class);
		$icon_right_html .= '<span class="pagination_arrow ' . $direction_nav_classes['right_icon_class']. '"></span>';
	}
	else{
		$icon_right_html .=  "<i class='pagination_arrow arrow_carrot-right'></i>";
	}

	?>

	<div class="blog_holder <?php echo esc_attr($blog_list_class); ?>">
		
	<?php if($blog_list == "blog_masonry") { ?>
		<div class="blog_holder_grid_sizer"></div>
		<div class="blog_holder_grid_gutter"></div>
	<?php } ?>
	<?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
		<?php
			get_template_part('templates/blog/'.$blog_list, 'loop');
		?>
	<?php endwhile; ?>
	<?php if($blog_list != "blog_masonry") {
		if ($eltd_options['blog_pagination_type'] == 'standard'){
				eltd_pagination($wp_query->max_num_pages, $blog_page_range, $paged);
			}
		elseif ($eltd_options['blog_pagination_type'] == 'prev_and_next'){?>
			<div class="pagination_prev_and_next_only">
				<ul>
					<li class='prev'><?php echo wp_kses_post(get_previous_posts_link($icon_left_html)); ?></li>
					<li class='next'><?php echo wp_kses_post(get_next_posts_link($icon_right_html)); ?></li>
				</ul>
			</div>
		<?php } ?>
	<?php } ?>
	<?php else: //If no posts are present ?>
	<div class="entry">
			<p><?php _e('No posts were found.', 'eltd'); ?></p>
	</div>
	<?php endif; ?>
</div>
<?php if($blog_list == "blog_masonry") {
    if($pagination_masonry == "load_more") {
		if (get_next_posts_link()) { ?>
			<div class="blog_load_more_button_holder">
				<div class="blog_load_more_button"><span data-rel="<?php echo esc_attr($wp_query->max_num_pages); ?>"><?php echo wp_kses_post(get_next_posts_link(__('Show more', 'eltd'))); ?></span></div>
			</div>
		<?php } ?>
	 <?php } elseif($pagination_masonry == "infinite_scroll") { ?>
		<div class="blog_infinite_scroll_button"><span data-rel="<?php echo esc_attr($wp_query->max_num_pages); ?>"><?php echo wp_kses_post(get_next_posts_link(__('Show more', 'eltd'))); ?></span></div>
    <?php }else { ?>
        <?php if($eltd_options['blog_pagination_type'] == 'standard' && $eltd_options['pagination'] != "0") {
				eltd_pagination($wp_query->max_num_pages, $blog_page_range, $paged);
            }
        	elseif ($eltd_options['blog_pagination_type'] == 'prev_and_next'){ ?>
				<div class="pagination_prev_and_next_only">
					<ul>
						<li class='prev'><?php echo wp_kses_post(get_previous_posts_link($icon_left_html)); ?></li>
						<li class='next'><?php echo wp_kses_post(get_next_posts_link($icon_right_html)); ?></li>
					</ul>
				</div>
		<?php } ?>
    <?php } ?>
<?php } ?>
