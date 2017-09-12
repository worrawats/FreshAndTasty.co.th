<?php
$slider_shortcode = get_post_meta($id, "eltd_revolution-slider", true);
if (!empty($slider_shortcode)) { ?>
	<div class="eltd_slider">
		<div class="eltd_slider_inner">
			<?php echo do_shortcode(wp_kses_post($slider_shortcode)); // XSS OK ?>
		</div>
	</div>
<?php } ?>