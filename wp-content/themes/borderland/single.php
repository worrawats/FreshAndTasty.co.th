<?php

$id = get_the_ID();

$chosen_sidebar = get_post_meta(get_the_ID(), "eltd_show-sidebar", true);
$default_array = array('default', '');

if(!in_array($chosen_sidebar, $default_array)){
	$sidebar = get_post_meta(get_the_ID(), "eltd_show-sidebar", true);
}else{
	$sidebar = $eltd_options['blog_single_sidebar'];
}

$blog_single_show_comments = "";
if (isset($eltd_options['blog_single_show_comments']))
	$blog_single_show_comments = $eltd_options['blog_single_show_comments'];

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
?>
<?php get_header(); ?>
<?php if (have_posts()) : ?>
<?php while (have_posts()) : the_post(); ?>
		<?php if(get_post_meta($id, "eltd_page_scroll_amount_for_sticky", true)) { ?>
			<script>
			var page_scroll_amount_for_sticky = <?php echo esc_attr(get_post_meta($id, "eltd_page_scroll_amount_for_sticky", true)); ?>;
			</script>
		<?php } ?>

		<?php get_template_part( 'title' ); ?>
		<?php get_template_part('slider'); ?>

		<div class="container"<?php eltd_inline_style($background_color); ?>>
		<?php if($eltd_options['overlapping_content'] == 'yes') {?>
			<div class="overlapping_content"><div class="overlapping_content_inner">
		<?php } ?>
			<div class="container_inner default_template_holder" <?php eltd_inline_style($content_style); ?>>

			<?php if(($sidebar == "default")||($sidebar == "")) : ?>
				<div class="blog_holder blog_single blog_standard_type">
				<?php
					get_template_part('templates/blog/blog_single', 'loop');
				?>
				<?php
					if($blog_single_show_comments == "yes"){
						comments_template('', true);
					}else{
						echo "<br/><br/>";
					}
				?>

			<?php elseif($sidebar == "1" || $sidebar == "2"): ?>
				<?php if($sidebar == "1") : ?>
					<div class="two_columns_66_33 background_color_sidebar grid2 clearfix">
					<div class="column1 content_left_from_sidebar">
				<?php elseif($sidebar == "2") : ?>
					<div class="two_columns_75_25 background_color_sidebar grid2 clearfix">
						<div class="column1 content_left_from_sidebar">
				<?php endif; ?>

							<div class="column_inner">
								<div class="blog_holder blog_single blog_standard_type">
									<?php
										get_template_part('templates/blog/blog_single', 'loop');
									?>
								</div>

								<?php
									if($blog_single_show_comments == "yes"){
										comments_template('', true);
									}else{
										echo "<br/><br/>";
									}
								?>
							</div>
						</div>
						<div class="column2">
							<?php get_sidebar(); ?>
						</div>
					</div>
				<?php elseif($sidebar == "3" || $sidebar == "4"): ?>
					<?php if($sidebar == "3") : ?>
						<div class="two_columns_33_66 background_color_sidebar grid2 clearfix">
						<div class="column1">
							<?php get_sidebar(); ?>
						</div>
						<div class="column2 content_right_from_sidebar">
					<?php elseif($sidebar == "4") : ?>
						<div class="two_columns_25_75 background_color_sidebar grid2 clearfix">
							<div class="column1">
								<?php get_sidebar(); ?>
							</div>
							<div class="column2 content_right_from_sidebar">
					<?php endif; ?>

								<div class="column_inner">
									<div class="blog_holder blog_single blog_standard_type">
										<?php
											get_template_part('templates/blog/blog_single', 'loop');
										?>
									</div>
									<?php
										if($blog_single_show_comments == "yes"){
											comments_template('', true);
										}else{
											echo "<br/><br/>";
										}
									?>
								</div>
							</div>

						</div>
				<?php endif; ?>
			</div>
		</div>
		<?php if($eltd_options['overlapping_content'] == 'yes') {?>
			</div></div>
		<?php } ?>
	</div>
<?php endwhile; ?>
<?php endif; ?>	


<?php get_footer(); ?>	