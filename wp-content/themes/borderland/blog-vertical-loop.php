<?php
/*
Template Name: Blog: Vertical Loop
*/
?>
<?php get_header(); ?>
<?php
global $wp_query;
global $eltd_template_name;

$id = $wp_query->get_queried_object_id();
$eltd_template_name = get_page_template_slug($id);
$category = get_post_meta($id, "eltd_choose-blog-category", true);
$post_number = esc_attr(get_post_meta($id, "eltd_show-posts-per-page", true));
if ( get_query_var('paged') ) { $paged = get_query_var('paged'); }
elseif ( get_query_var('page') ) { $paged = get_query_var('page'); }
else { $paged = 1; }
$page_object = get_post( $id );

$sidebar = get_post_meta($id, "eltd_show-sidebar", true);

if(get_post_meta($id, "eltd_page_background_color", true) != ""){
    $background_color = 'background-color: '.esc_attr(get_post_meta($id, "eltd_page_background_color", true));
}else{
    $background_color = "";
}

$content_style = "";
if(get_post_meta($id, "eltd_content-top-padding", true) != ""){
    if(get_post_meta($id, "eltd_content-top-padding-mobile", true) == 'yes'){
        $content_style = "padding-top:".esc_attr(get_post_meta($id, "eltd_content-top-padding", true))."px !important";
    }else{
        $content_style = "padding-top:".esc_attr(get_post_meta($id, "eltd_content-top-padding", true))."px";
    }
}

if(isset($eltd_options['blog_vertical_loop_type_number_of_chars']) && $eltd_options['blog_vertical_loop_type_number_of_chars'] != "") {
    eltd_set_blog_word_count(esc_attr($eltd_options['blog_vertical_loop_type_number_of_chars']));
}

?>
<?php if(get_post_meta($id, "eltd_page_scroll_amount_for_sticky", true)) { ?>
    <script>
        var page_scroll_amount_for_sticky = <?php echo esc_attr(get_post_meta($id, "eltd_page_scroll_amount_for_sticky", true)); ?>;
    </script>
<?php } ?>

<?php
query_posts('post_type=post&paged='. $paged . '&cat=' . $category .'&posts_per_page=1');
?>
    <div class="full_width blog_vertical_loop" <?php eltd_inline_style($background_color); ?>>
        <div class="full_width_inner" <?php eltd_inline_style($content_style); ?>>
            <div class="blog_holder blog_vertical_loop_type">
                <?php if(have_posts()) : while ( have_posts() ) : the_post(); ?>
                    <?php get_template_part('templates/blog/blog_vertical', 'loop'); ?>
                <?php endwhile; ?>

                <?php else: //If no posts are present ?>
                    <div class="entry">
                        <p><?php _e('No posts were found.', 'eltd'); ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
<?php wp_reset_query(); ?>
<?php get_footer(); ?>