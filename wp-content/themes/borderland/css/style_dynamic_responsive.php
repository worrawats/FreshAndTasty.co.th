<?php
$root = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
if ( file_exists( $root.'/wp-load.php' ) ) {
    require_once( $root.'/wp-load.php' );
//    require_once( $root.'/wp-config.php' );
} else {
	$root = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
	if ( file_exists( $root.'/wp-load.php' ) ) {
    require_once( $root.'/wp-load.php' );
//    require_once( $root.'/wp-config.php' );
	}
}
header("Content-type: text/css; charset=utf-8");
?>

@media only screen and (max-width: 1000px){
	
	<?php if (!empty($eltd_options['header_background_color'])) { ?>
	.header_bottom {
		background-color: <?php echo esc_attr($eltd_options['header_background_color']);  ?>;
	}
	<?php } ?>
	<?php if (!empty($eltd_options['mobile_background_color'])) { ?>
		.header_bottom,
		nav.mobile_menu{
				background-color: <?php echo esc_attr($eltd_options['mobile_background_color']);  ?> !important;
		}
	<?php } ?>
	
	 <?php if (isset($eltd_options['page_subtitle_fontsize']) && ($eltd_options['page_subtitle_fontsize']) < 28 && ($eltd_options['page_subtitle_fontsize']) !== '') { ?>
		.subtitle{
			font-size: <?php echo esc_attr($eltd_options['page_subtitle_fontsize']) *0.8;  ?>px;
		}
	 <?php }?>
	<?php if(isset($eltd_options['h1_fontsize']) && ($eltd_options['h1_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($eltd_options['h1_fontsize'])*0.8; ?>px;			
		}
	<?php } ?>
	<?php if(isset($eltd_options['h1_fontsize']) && ($eltd_options['h1_fontsize'])>80) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($eltd_options['h1_fontsize'])*0.7; ?>px;			
		}
	<?php } ?>
	<?php if(isset($eltd_options['page_title_fontsize']) && ($eltd_options['page_title_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($eltd_options['page_title_fontsize'])*0.8; ?>px;
		}
	<?php } ?>	
	<?php if(isset($eltd_options['page_title_fontsize']) && ($eltd_options['page_title_fontsize'])>80) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($eltd_options['page_title_fontsize'])*0.7; ?>px;
		}
	<?php } ?>	
	<?php if(isset($eltd_options['h2_fontsize']) && ($eltd_options['h2_fontsize'])>35) { ?>
		.content h2{
			font-size:<?php echo esc_attr($eltd_options['h2_fontsize'])*0.8; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h2_fontsize']) && ($eltd_options['h2_fontsize'])>70) { ?>
		.content h2{
			font-size:<?php echo esc_attr($eltd_options['h2_fontsize'])*0.7; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h3_fontsize']) && ($eltd_options['h3_fontsize'])>35) { ?>
		.content h3{
			font-size:<?php echo esc_attr($eltd_options['h3_fontsize'])*0.8; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h3_fontsize']) && ($eltd_options['h3_fontsize'])>70) { ?>
		.content h3{
			font-size:<?php echo esc_attr($eltd_options['h3_fontsize'])*0.7; ?>px;
		}
	<?php } ?>		
	<?php if(isset($eltd_options['h4_fontsize']) && ($eltd_options['h4_fontsize'])>35) { ?>
		.content h4{
			font-size:<?php echo esc_attr($eltd_options['h4_fontsize'])*0.8; ?>px;
		}
	<?php } ?>
		
	<?php if(isset($eltd_options['h4_fontsize']) && ($eltd_options['h4_fontsize'])>70) { ?>
		.content h4{
			font-size:<?php echo esc_attr($eltd_options['h4_fontsize'])*0.7; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h5_fontsize']) && ($eltd_options['h5_fontsize'])>35) { ?>
		.content h5{
			font-size:<?php echo esc_attr($eltd_options['h5_fontsize'])*0.8; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h5_fontsize']) && ($eltd_options['h5_fontsize'])>70) { ?>
		.content h5{
			font-size:<?php echo esc_attr($eltd_options['h5_fontsize'])*0.7; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h6_fontsize']) && ($eltd_options['h6_fontsize'])>32) { ?>
		.content h6{
			font-size:<?php echo esc_attr($eltd_options['h6_fontsize'])*0.8; ?>px;
		}
	<?php } ?>	
	<?php if(isset($eltd_options['h6_fontsize']) && ($eltd_options['h6_fontsize'])>70) { ?>
		.content h6{
			font-size:<?php echo esc_attr($eltd_options['h6_fontsize'])*0.7; ?>px;
		}
	<?php } ?>

	<?php if(isset($eltd_options['portfolio_list_filter_height']) && $eltd_options['portfolio_list_filter_height'] !== '') { ?>
		.filter_outer.filter_portfolio{
			line-height: 2em;	
		}
	<?php } ?>
}

@media only screen and (min-width: 600px) and (max-width: 768px){
	<?php if(isset($eltd_options['h1_fontsize']) && ($eltd_options['h1_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($eltd_options['h1_fontsize'])*0.7; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['page_title_fontsize']) && ($eltd_options['page_title_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($eltd_options['page_title_fontsize'])*0.6; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h2_fontsize']) && ($eltd_options['h2_fontsize'])>35) { ?>
		.content h2{
			font-size:<?php echo esc_attr($eltd_options['h2_fontsize'])*0.6; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h3_fontsize']) && ($eltd_options['h3_fontsize'])>35) { ?>
		.content h3{
			font-size:<?php echo esc_attr($eltd_options['h3_fontsize'])*0.6; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h4_fontsize']) && ($eltd_options['h4_fontsize'])>35) { ?>
		.content h4{
			font-size:<?php echo esc_attr($eltd_options['h4_fontsize'])*0.6; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h5_fontsize']) && ($eltd_options['h5_fontsize'])>35) { ?>
		.content h5{
			font-size:<?php echo esc_attr($eltd_options['h5_fontsize'])*0.6; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h6_fontsize']) && ($eltd_options['h6_fontsize'])>35) { ?>
		.content h6{
			font-size:<?php echo esc_attr($eltd_options['h6_fontsize'])*0.6; ?>px;
		}
	<?php } ?>
	
	<?php if (isset($eltd_options['page_subtitle_fontsize']) && ($eltd_options['page_subtitle_fontsize']) < 28 && ($eltd_options['page_subtitle_fontsize']) !== '') { ?>
		.subtitle{
			font-size: <?php echo esc_attr($eltd_options['page_subtitle_fontsize']) *0.7;  ?>px;
		}
	 <?php } ?>
}

@media only screen and (min-width: 480px) and (max-width: 768px){
	<?php if (isset($eltd_options['parallax_minheight']) && !empty($eltd_options['parallax_minheight'])) { ?>
        section.parallax_section_holder{
		height: auto !important;
		min-height: <?php echo esc_attr($eltd_options['parallax_minheight']); ?>px !important;
	}
	<?php } ?>
	
	<?php if (isset($eltd_options['header_background_color_mobile']) &&  !empty($eltd_options['header_background_color_mobile'])) { ?>
	header
	{
		 background-color: <?php echo esc_attr($eltd_options['header_background_color_mobile']);  ?> !important;
		 background-image:none;
	}
	<?php } ?>
}

@media only screen and (max-width: 600px){
	<?php if(isset($eltd_options['h1_fontsize']) && ($eltd_options['h1_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($eltd_options['h1_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['page_title_fontsize']) && ($eltd_options['page_title_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($eltd_options['page_title_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h2_fontsize']) && ($eltd_options['h2_fontsize'])>35) { ?>
			.content h2{
				font-size:<?php echo esc_attr($eltd_options['h2_fontsize'])*0.5; ?>px;
			}
	<?php } ?>
	<?php if(isset($eltd_options['h3_fontsize']) && ($eltd_options['h3_fontsize'])>35) { ?>
		.content h3{
			font-size:<?php echo esc_attr($eltd_options['h3_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h4_fontsize']) && ($eltd_options['h4_fontsize'])>35) { ?>
		.content h4{
			font-size:<?php echo esc_attr($eltd_options['h4_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h5_fontsize']) && ($eltd_options['h5_fontsize'])>35) { ?>
		.content h5{
			font-size:<?php echo esc_attr($eltd_options['h5_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h6_fontsize']) && ($eltd_options['h6_fontsize'])>35) { ?>
		.content h6{
			font-size:<?php echo esc_attr($eltd_options['h6_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['title_span_background_color']) && !empty($eltd_options['title_span_background_color'])) { ?>
		.title h1 span{
			padding: 0 5px;
		}
	<?php } ?>

	<?php if(isset($eltd_options['portfolio_list_filter_height']) && $eltd_options['portfolio_list_filter_height'] !== '') { ?>
		.filter_outer.filter_portfolio{
			height:auto;	
		}
	<?php } ?>
}

@media only screen and (max-width: 480px){

	<?php if(isset($eltd_options['h1_fontsize']) && ($eltd_options['h1_fontsize'])>35) { ?>
			.title h1,
			.title h1.title_like_separator .vc_text_separator.full .separator_content{
				font-size:<?php echo esc_attr($eltd_options['h1_fontsize'])*0.4; ?>px;
			}
	<?php } ?>
	<?php if(isset($eltd_options['page_title_fontsize']) && ($eltd_options['page_title_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($eltd_options['page_title_fontsize'])*0.4; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h2_fontsize']) && ($eltd_options['h2_fontsize'])>35) { ?>
			.content h2{
				font-size:<?php echo esc_attr($eltd_options['h2_fontsize'])*0.4; ?>px;
			}
	<?php } ?>
	<?php if(isset($eltd_options['h3_fontsize']) && ($eltd_options['h3_fontsize'])>35) { ?>
		.content h3{
			font-size:<?php echo esc_attr($eltd_options['h3_fontsize'])*0.4; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h4_fontsize']) && ($eltd_options['h4_fontsize'])>35) { ?>
		.content h4{
			font-size:<?php echo esc_attr($eltd_options['h4_fontsize'])*0.4; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h5_fontsize']) && ($eltd_options['h5_fontsize'])>35) { ?>
		.content h5{
			font-size:<?php echo esc_attr($eltd_options['h5_fontsize'])*0.4; ?>px;
		}
	<?php } ?>
	<?php if(isset($eltd_options['h6_fontsize']) && ($eltd_options['h6_fontsize'])>35) { ?>
		.content h6{
			font-size:<?php echo esc_attr($eltd_options['h6_fontsize'])*0.4; ?>px;
		}
	<?php } ?>
		
	<?php if (isset($eltd_options['parallax_minheight']) && !empty($eltd_options['parallax_minheight'])) { ?>
	section.parallax_section_holder{
		height: auto !important;
		min-height: <?php echo esc_attr($eltd_options['parallax_minheight']); ?>px !important;
	}
	<?php } ?>
	
	
	<?php if (isset($eltd_options['header_background_color_mobile']) &&  !empty($eltd_options['header_background_color_mobile'])) { ?>
	header
	{
		 background-color: <?php echo esc_attr($eltd_options['header_background_color_mobile']);  ?> !important;
		 background-image:none;
	}
	<?php } ?>
}