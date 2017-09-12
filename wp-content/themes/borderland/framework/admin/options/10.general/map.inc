<?php
global $eltdIconCollections;

$generalPage = new ElatedAdminPage("", "General", "fa fa-institution");
$eltdFramework->eltdOptions->addAdminPage("general",$generalPage);

// Design Style

$panel1 = new ElatedPanel("Design Style","design_style");
$generalPage->addChild("panel1",$panel1);

	$google_fonts = new ElatedField("font","google_fonts","-1","Font Family","Choose a default Google font for your site");
	$panel1->addChild("google_fonts",$google_fonts);

    $additional_google_fonts = new ElatedField("yesno","additional_google_fonts","no","Additional Google Fonts","", array(),
        array("dependence" => true,
            "dependence_hide_on_yes" => "",
            "dependence_show_on_yes" => "#eltdf_additional_google_font_container"));
    $panel1->addChild("additional_google_fonts",$additional_google_fonts);

    $additional_google_font_container = new ElatedContainer("additional_google_font_container","additional_google_fonts","no");
    $panel1->addChild("additional_google_font_container",$additional_google_font_container);

    $additional_google_font1 = new ElatedField("font","additional_google_font1","-1","Font Family","Choose additional Google font for your site");
    $additional_google_font_container->addChild("additional_google_font1",$additional_google_font1);

    $additional_google_font2 = new ElatedField("font","additional_google_font2","-1","Font Family","Choose additional Google font for your site");
    $additional_google_font_container->addChild("additional_google_font2",$additional_google_font2);

    $additional_google_font3 = new ElatedField("font","additional_google_font3","-1","Font Family","Choose additional Google font for your site");
    $additional_google_font_container->addChild("additional_google_font3",$additional_google_font3);

    $additional_google_font4 = new ElatedField("font","additional_google_font4","-1","Font Family","Choose additional Google font for your site");
    $additional_google_font_container->addChild("additional_google_font4",$additional_google_font4);

    $additional_google_font5 = new ElatedField("font","additional_google_font5","-1","Font Family","Choose additional Google font for your site");
    $additional_google_font_container->addChild("additional_google_font5",$additional_google_font5);
	
	$first_color = new ElatedField("color","first_color","","First Main Color","Choose the most dominant theme color. Default color is #e6ae48.");
	$panel1->addChild("first_color",$first_color);
	
	$selection_color = new ElatedField("color","selection_color","","Text Selection Color","Choose the color users see when selecting text");
	$panel1->addChild("selection_color",$selection_color);

    $transparent_content = new ElatedField("yesno","transparent_content","no","Enable Uniform Site Background","If enabled, content background on pages will be transparent (unless set otherwise) and the background you set here will show", array(),
        array("dependence" => true,
            "dependence_hide_on_yes" => "",
            "dependence_show_on_yes" => "#eltdf_transparent_content_container"));
    $panel1->addChild("transparent_content",$transparent_content);

    $transparent_content_container = new ElatedContainer("transparent_content_container","transparent_content","no");
    $panel1->addChild("transparent_content_container",$transparent_content_container);

        $transparent_content_background_color = new ElatedField("color","transparent_content_background_color","","Background Color","Choose body background color. Default color is #ffffff.");
        $transparent_content_container->addChild("transparent_content_background_color",$transparent_content_background_color);

        $transparent_content_background_image = new ElatedField("image","transparent_content_background_image","","Background Image","Choose an image to be displayed in background");
        $transparent_content_container->addChild("transparent_content_background_image",$transparent_content_background_image);

        $transparent_content_pattern_background_image = new ElatedField("image","transparent_content_pattern_background_image","","Background Pattern","Choose an image to be used as background pattern");
        $transparent_content_container->addChild("transparent_content_pattern_background_image",$transparent_content_pattern_background_image);


    $boxed = new ElatedField("yesno","boxed","no","Boxed layout","Enabling this option will display site content in grid", array(),
		array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#eltdf_boxed_container"));
	$panel1->addChild("boxed",$boxed);
	
	$boxed_container = new ElatedContainer("boxed_container","boxed","no");
	$panel1->addChild("boxed_container",$boxed_container);
	
		$background_color_box = new ElatedField("color","background_color_box","","Page Background Color","Choose the page background (body) color. Default color is #f5f5f5.");
		$boxed_container->addChild("background_color_box",$background_color_box);
		
		$background_image = new ElatedField("image","background_image","","Background Image","Choose an image to be displayed in background");
		$boxed_container->addChild("background_image",$background_image);
		
		$pattern_background_image = new ElatedField("image","pattern_background_image","","Background Pattern","Choose an image to be used as background pattern");
		$boxed_container->addChild("pattern_background_image",$pattern_background_image);

		$background_image_attachment = new ElatedField("select","background_image_attachment","fixed","Background Attachment","Choose background attachment behavior",array(
			"fixed" => "Fixed",
			"scroll" => "Scroll"
			));
		$boxed_container->addChild("background_image_attachment",$background_image_attachment);

		$boxed_padding_general = new ElatedField("text","boxed_padding_general","","Left/Right Padding on Content (%)","Insert left(right) padding that will apply generaly", array(), array("col_width" => 3));
		$boxed_container->addChild("boxed_padding_general",$boxed_padding_general);

        $boxed_padding_on_header_footer = new ElatedField("yesno","boxed_padding_on_header_footer","no","Left/Right Padding Affects Header and Footer","By enabling this option the left/right padding will affect header and footer also");
        $boxed_container->addChild("boxed_padding_on_header_footer",$boxed_padding_on_header_footer);

        $boxed_padding_on_title_content = new ElatedField("yesno","boxed_padding_on_title_content","no","Left/Right Padding Affects Title Content","By enabling this option the left/right padding will affect title content");
        $boxed_container->addChild("boxed_padding_on_title_content",$boxed_padding_on_title_content);

        $boxed_padding_on_title_container = new ElatedField("yesno","boxed_padding_on_title_container","no","Left/Right Padding Affects Title Container","By enabling this option the left/right padding will affect title container (including title image)");
        $boxed_container->addChild("boxed_padding_on_title_container",$boxed_padding_on_title_container);

    $paspartu = new ElatedField("yesno","paspartu","no","Passepartout","Enabling this option will display passepartout around site content", array(),
        array("dependence" => true,
            "dependence_hide_on_yes" => "",
            "dependence_show_on_yes" => "#eltdf_paspartu_container"));
    $panel1->addChild("paspartu",$paspartu);

    $paspartu_container = new ElatedContainer("paspartu_container","paspartu","no");
    $panel1->addChild("paspartu_container",$paspartu_container);

        $paspartu_color = new ElatedField("color","paspartu_color","","Passepartout Color","Choose passepartout color, default value is #ffffff");
        $paspartu_container->addChild("paspartu_color",$paspartu_color);

        $paspartu_width = new ElatedField("text","paspartu_width","","Passepartout Size (%)","Enter size amount for passepartout, default value is 2% (the percent is in relation to site width)", array(), array("col_width" => 3));
        $paspartu_container->addChild("paspartu_width",$paspartu_width);

        $paspartu_header_alignment = new ElatedField("yesno","paspartu_header_alignment","no","Align Header With Passepartout","Enabling this option will align header content with passepartout borders");
        $paspartu_container->addChild("paspartu_header_alignment",$paspartu_header_alignment);
		
		$paspartu_header_inside = new ElatedField("yesno","paspartu_header_inside","no","Set Header Inside Passepartout","Enabling this option will set the whole header between the left and right border of passepartout");
        $paspartu_container->addChild("paspartu_header_inside",$paspartu_header_inside);
		
		$vertical_menu_inside_paspartu = new ElatedField("yesno","vertical_menu_inside_paspartu","yes","Vertical Menu Inside Passepartout","");
        $paspartu_container->addChild("vertical_menu_inside_paspartu",$vertical_menu_inside_paspartu);

        $paspartu_on_top = new ElatedField("yesno","paspartu_on_top","yes","Top Passepartout","Disabling this option will disable top part of passepartout", array(),
            array("dependence" => true,
                "dependence_hide_on_yes" => "",
                "dependence_show_on_yes" => "#eltdf_paspartu_on_top_fixed_container"));
        $paspartu_container->addChild("paspartu_on_top",$paspartu_on_top);
		
		$paspartu_on_top_fixed_container = new ElatedContainer("paspartu_on_top_fixed_container","paspartu_on_top","no");
        $paspartu_container->addChild("paspartu_on_top_fixed_container",$paspartu_on_top_fixed_container);

        $paspartu_on_top_fixed = new ElatedField("yesno","paspartu_on_top_fixed","no","Fix Top Passepartout","Enabling this option will fix top part of passepartout to the top of the screen");
        $paspartu_on_top_fixed_container->addChild("paspartu_on_top_fixed",$paspartu_on_top_fixed);

        $paspartu_on_bottom_slider_container = new ElatedContainer("paspartu_on_bottom_slider_container","","");
        $paspartu_container->addChild("paspartu_on_bottom_slider_container",$paspartu_on_bottom_slider_container);

        $paspartu_on_bottom_slider = new ElatedField("yesno","paspartu_on_bottom_slider","no","Show Bottom Passepartout on Elated Slider","Enabling this option will show bottom passepartout on Elated Slider");
        $paspartu_on_bottom_slider_container->addChild("paspartu_on_bottom_slider",$paspartu_on_bottom_slider);

        $paspartu_on_bottom = new ElatedField("yesno","paspartu_on_bottom","yes","Bottom Passepartout","Disabling this option will disable bottom part of passepartout", array(),
            array("dependence" => true,
                "dependence_hide_on_yes" => "",
                "dependence_show_on_yes" => "#eltdf_paspartu_on_bottom_fixed_container"));
        $paspartu_container->addChild("paspartu_on_bottom",$paspartu_on_bottom);

        $paspartu_on_bottom_fixed_container = new ElatedContainer("paspartu_on_bottom_fixed_container","paspartu_on_bottom","no");
        $paspartu_container->addChild("paspartu_on_bottom_fixed_container",$paspartu_on_bottom_fixed_container);

        $paspartu_on_bottom_fixed = new ElatedField("yesno","paspartu_on_bottom_fixed","no","Fix Bottom Passepartout","Enabling this option will fix bottom part of passepartout to the bottom of the screen");
        $paspartu_on_bottom_fixed_container->addChild("paspartu_on_bottom_fixed",$paspartu_on_bottom_fixed);

    $preload_pattern_image = new ElatedField("image","preload_pattern_image",ELTD_ROOT."/img/preload_pattern.png","Preload Pattern Image","Choose preload pattern image to be displayed until images are loaded ");
    $panel1->addChild("preload_pattern_image",$preload_pattern_image);

    $element_appear_amount = new ElatedField("text","element_appear_amount","","Element Appearance (px)","For animated elements, set distance (related to browser bottom) to start the animation", array(), array("col_width" => 3));
    $panel1->addChild("element_appear_amount",$element_appear_amount);

// Settings

$panel4 = new ElatedPanel("Settings","settings");
$generalPage->addChild("panel4",$panel4);

	$page_transitions = new ElatedField("select","page_transitions","0","Page Transition",'Choose a a type of transition between loading pages. In order for animation to work properly, you must choose "Post name" in permalinks settings',
		array( 
			0 => "No animation",
			1 => "Up/Down",
			2 => "Fade",
			3 => "Up/Down (In) / Fade (Out)",
			4 => "Left/Right"
		),
		array("dependence" => true,
			"hide" => array(
				"0"=>"#eltdf_ajax_animate_header_container",
				"1"=>"",
				"2"=>"",
				"3"=>"",
				"4"=>""
			),
			"show" => array(
				"0"=>"",
				"1"=>"#eltdf_ajax_animate_header_container",
				"2"=>"#eltdf_ajax_animate_header_container",
				"3"=>"#eltdf_ajax_animate_header_container",
				"4"=>"#eltdf_ajax_animate_header_container"
			) 
		), "enable_grid_elements",array("yes")
	);
	$panel4->addChild("page_transitions",$page_transitions);

	$page_transitions_notice = new ElatedNotice("Page Transition",'Choose a a type of transition between loading pages. In order for animation to work properly, you must choose "Post name" in permalinks settings', "Page transition is disabled because VC Grid is Enabled", "enable_grid_elements","no");
	$panel4->addChild("page_transitions_notice",$page_transitions_notice);
	
	$ajax_animate_header_container = new ElatedContainer("ajax_animate_header_container","page_transitions","0");
	$panel4->addChild("ajax_animate_header_container",$ajax_animate_header_container);
	
	$ajax_animate_header = new ElatedField("yesno","ajax_animate_header","no","Animate Header","Enabling this option will include the header area in the Ajax Page Transition Animations");
	$ajax_animate_header_container->addChild("ajax_animate_header",$ajax_animate_header);
	
	$loading_animation = new ElatedField("onoff","loading_animation","off","Loading Animation","Enabling this option will display animation while page loads", array(),
		array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#eltdf_loading_animation_container"));
	$panel4->addChild("loading_animation",$loading_animation);
	
	$loading_animation_container = new ElatedContainer("loading_animation_container","loading_animation","off");
	$panel4->addChild("loading_animation_container",$loading_animation_container);
	
		$group1 = new ElatedGroup("Loading Animation Graphic","Choose type and color of preload graphic animation");
		$loading_animation_container->addChild("group1",$group1);
		
			$row1 = new ElatedRow();
			$group1->addChild("row1",$row1);
			
				$loading_animation_spinner = new ElatedField("selectsimple","loading_animation_spinner","pulse","Spinner","This is some description", array( "pulse" => "Pulse",
	       "double_pulse" => "Double Pulse",
	       "cube" => "Cube",
	       "rotating_cubes" => "Rotating Cubes",
	       "stripes" => "Stripes",
	       "wave" => "Wave",
	       "two_rotating_circles" => "2 Rotating Circles",
	       "five_rotating_circles" => "5 Rotating Circles",
		   "atom" => "Atom",
		   "clock" => "Clock",
		   "mitosis" => "Mitosis",
		   "lines" => "Lines",
		   "fussion" => "Fussion",
		   "wave_circles" => "Wave Circles",
		   "pulse_circles" => "Pulse Circles"
	      ));
				$row1->addChild("loading_animation_spinner",$loading_animation_spinner);
				
				$spinner_color = new ElatedField("colorsimple","spinner_color","","Spinner Color","This is some description");
				$row1->addChild("spinner_color",$spinner_color);
				
		$loading_image = new ElatedField("image","loading_image","","Loading Image",'Upload custom image to be displayed while page loads (Note: Page Transition must not be set to "No Animation")');
		$loading_animation_container->addChild("loading_image",$loading_image);
		
	$smooth_scroll = new ElatedField("yesno","smooth_scroll","yes","Smooth Scroll","Enabling this option will perform a smooth scrolling effect on every page (except on Mac and touch devices)");
	$panel4->addChild("smooth_scroll",$smooth_scroll);
	
	$elements_animation_on_touch = new ElatedField("yesno","elements_animation_on_touch","no","Elements Animation on Mobile/Touch Devices","Enabling this option will allow elements (shortcodes) to animate on mobile / touch devices");
	$panel4->addChild("elements_animation_on_touch",$elements_animation_on_touch);
	
	$show_back_button = new ElatedField("yesno","show_back_button","yes","Show 'Back To Top Button'","Enabling this option will display a Back to Top button on every page");
	$panel4->addChild("show_back_button",$show_back_button);
	
	$responsiveness = new ElatedField("yesno","responsiveness","yes","Responsiveness","Enabling this option will make all pages responsive");
	$panel4->addChild("responsiveness",$responsiveness);
	
	$favicon_image = new ElatedField("image","favicon_image",ELTD_ROOT."/img/favicon.ico","Favicon Image","Choose a favicon image to be displayed");
	$panel4->addChild("favicon_image",$favicon_image);
	
	$internal_no_ajax_links = new ElatedField("textarea","internal_no_ajax_links","","List of Internal URLs Loaded Without AJAX (Separated With Comma)","To disable AJAX transitions on certain pages, enter their full URLs here (for example: http://www.mydomain.com/forum/)");
	$panel4->addChild("internal_no_ajax_links",$internal_no_ajax_links);

// Custom Code

$panel3 = new ElatedPanel("Custom Code","custom_code");
$generalPage->addChild("panel3",$panel3);

	$custom_css = new ElatedField("textarea","custom_css","","Custom CSS","Enter your custom CSS here");
	$panel3->addChild("custom_css",$custom_css);

	$custom_svg_css = new ElatedField("textarea", "custom_svg_css", "", "Custom SVG CSS", "Enter your SVG CSS here");
	$panel3->addChild("custom_svg_css", $custom_svg_css);
	
	$custom_js = new ElatedField("textarea","custom_js","","Custom JS",'Enter your custom Javascript here (jQuery selector is "$j" because of the conflict mode)');
	$panel3->addChild("custom_js",$custom_js);

// SEO

$panel2 = new ElatedPanel("SEO","seo");
$generalPage->addChild("panel2",$panel2);

	$disable_eltd_seo = new ElatedField("yesno","disable_eltd_seo","no","Disable SEO","Enabling this option will turn off SEO", array(),
		array("dependence" => true,
		"dependence_hide_on_yes" => "#eltdf_disable_eltd_seo_container",
		"dependence_show_on_yes" => ""));
	$panel2->addChild("disable_eltd_seo",$disable_eltd_seo);
	
	$disable_eltd_seo_container = new ElatedContainer("disable_eltd_seo_container","disable_eltd_seo","yes");
	$panel2->addChild("disable_eltd_seo_container",$disable_eltd_seo_container);
	
		$meta_keywords = new ElatedField("textarea","meta_keywords","","Meta Keywords","Add relevant keywords separated with commas to improve SEO");
		$disable_eltd_seo_container->addChild("meta_keywords",$meta_keywords);
		
		$meta_description = new ElatedField("textarea","meta_description","","Meta Description","Enter a short description of the website for SEO");
		$disable_eltd_seo_container->addChild("meta_description",$meta_description);

//Maintenance Mode
$eltd_pages = array();
$pages = get_posts(array(
    'post_type' => 'page',
    'meta_key' => '_wp_page_template',
    'meta_value' => 'landing_page.php'
));
foreach($pages as $page) {
    $eltd_pages[$page->ID] = $page->post_title;
}

$panel_maintenance = new ElatedPanel("Maintenance Mode","maintenance_panel");
$generalPage->addChild("panel_maintenance",$panel_maintenance);

$maintenance_mode = new ElatedField("yesno","eltd_maintenance_mode","no","Maintenance Mode","Turn on this option if you want to enable maintenance mode on your site", array(),
    array("dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_maintenance_container"
    ));
$panel_maintenance->addChild("eltd_maintenance_mode",$maintenance_mode);

$maintenance_container = new ElatedContainer("maintenance_container","eltd_maintenance_mode","no");
$panel_maintenance->addChild("maintenance_container",$maintenance_container);

$maintenance_page = new ElatedField("selectblank","eltd_maintenance_page","",'Maintenance Page','Choose maintenance page to display when user visits your site',$eltd_pages);
$maintenance_container->addChild("eltd_maintenance_page",$maintenance_page);