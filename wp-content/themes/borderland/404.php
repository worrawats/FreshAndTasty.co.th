<?php 
	global $eltd_options;
?>

<?php get_header(); ?>

	<?php get_template_part( 'title' ); ?>

	<div class="container">
	<?php if($eltd_options['overlapping_content'] == 'yes') {?>
		<div class="overlapping_content"><div class="overlapping_content_inner">
	<?php } ?>
		<div class="container_inner eltd_404_page default_template_holder">
			<div class="page_not_found">
				<h3><?php if($eltd_options['404_title'] != ""): echo esc_html($eltd_options['404_title']); else: ?> <?php _e('Page you are looking is Not Found', 'eltd'); ?> <?php endif;?></h3>

                <h4><?php if($eltd_options['404_text'] != ""): echo esc_html($eltd_options['404_text']); else: ?> <?php _e('The page you are looking for does not exist. It may have been moved, or removed altogether. Perhaps you can return back to the site’s homepage and see if you can find what you are looking for.', 'eltd'); ?> <?php endif;?></h4>
				<a class="qbutton with-shadow" href="<?php echo esc_url(home_url()); ?>/"><?php if($eltd_options['404_backlabel'] != ""): echo esc_html($eltd_options['404_backlabel']); else: ?> <?php _e('Back to homepage', 'eltd'); ?> <?php endif;?></a>
			</div>
		</div>
		<?php if($eltd_options['overlapping_content'] == 'yes') {?>
				</div></div>
		<?php } ?>
	</div>
<?php get_footer(); ?>