<?php
global $eltd_options;
?>

<?php if(isset($eltd_options['enable_social_share'])  && $eltd_options['enable_social_share'] == "yes") { ?>
	<div class="portfolio_social_holder">
		<?php echo do_shortcode('[no_social_share_list]'); // XSS OK ?>
	</div> <!-- close div.portfolio_social_holder -->
<?php } ?>