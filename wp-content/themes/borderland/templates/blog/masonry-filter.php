<?php
global $eltd_page_id;
global $eltd_options;
global $eltd_template_name;

$blog_style = "1";
if(isset($eltd_options['blog_style'])){
	$blog_style = $eltd_options['blog_style'];
}

$filter = "no";
if(isset($eltd_options['blog_masonry_filter'])){
	$filter = $eltd_options['blog_masonry_filter'];
}

$show_filter_title = "no";
if(isset($eltd_options['blog_masonry_enable_filter_title'])){
	$show_filter_title = $eltd_options['blog_masonry_enable_filter_title'];
}

$blog_masnory_filter_class = "";
if (isset($eltd_options['blog_masonry_filter_disable_separator']) && !empty($eltd_options['blog_masonry_filter_disable_separator'])){
	if($eltd_options['blog_masonry_filter_disable_separator'] == "yes"){
		$blog_masnory_filter_class = "without_separator";
	} else {
		$blog_masnory_filter_class = "";
	}
}

$page_category = get_post_meta($eltd_page_id, "eltd_choose-blog-category", true);
if(is_category()){
	$page_category = get_query_var( 'cat' );
}
if ($page_category == "" && !is_category()) {
                $args = array(
                    'parent' => 0
                );
                $categories = get_categories( $args );
            } else {
                $args = array(
                    'parent' => $page_category
                );
                $categories = get_categories( $args );
            }
if ($filter == "yes" && count($categories) > 0) {	?>

			<div class="filter_outer filter_blog">
				<div class="filter_holder <?php echo esc_attr($blog_masnory_filter_class); ?>">
					<ul>
                        <?php if($show_filter_title == "yes"){ ?>
                            <li class='filter_title'><span><?php _e('Sort Blog:', 'eltd'); ?></span></li>
                       <?php }?>
						<li class="filter" data-filter="*"><span><?php _e('All', 'eltd'); ?></span></li>
						<?php foreach ($categories as $category) { ?>
							 <li class="filter" data-filter="<?php echo ".category-" . esc_attr($category->slug); ?>"><span><?php echo esc_html($category->name); ?></span></li>
						<?php } ?>
					</ul>
				</div>
			</div>

      <?php  }
?>
