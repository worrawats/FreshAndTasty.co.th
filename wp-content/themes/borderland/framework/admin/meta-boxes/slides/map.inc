<?php

global $eltdIconCollections;

$eltd_blog_categories = array();
$categories = get_categories(); 
foreach($categories as $category) {
	$eltd_blog_categories[$category->term_id] = $category->name;
}

//Slide Type

$eltdSlideType = new ElatedMetaBox("slides", "Slide Background Type");
$eltdFramework->eltdMetaBoxes->addMetaBox("slides_type",$eltdSlideType);

	$eltd_slide_background_type = new ElatedMetaField("imagevideo","eltd_slide-background-type","image","Slide Background Type","Do you want to upload an image or video?", array(), array("dependence" => true, "dependence_hide_on_yes" => "#eltdf-meta-box-slides_video_settings", "dependence_show_on_yes" => "#eltdf-meta-box-slides_image_settings"));
	$eltdSlideType->addChild("eltd_slide-background-type",$eltd_slide_background_type);

//Slide Image

$eltdSlideImageSettings = new ElatedMetaBox("slides", "Slide Background Image","eltd_slide-background-type",array("video"));
$eltdFramework->eltdMetaBoxes->addMetaBox("slides_image_settings",$eltdSlideImageSettings);

	$eltd_slide_image = new ElatedMetaField("image","eltd_slide-image","","Slide Image","Choose background image");
	$eltdSlideImageSettings->addChild("eltd_title-image",$eltd_slide_image);
	
	$eltd_slide_overlay_image = new ElatedMetaField("image","eltd_slide-overlay-image","","Overlay Image","Choose overlay image (pattern) for background image");
	$eltdSlideImageSettings->addChild("eltd_slide-overlay-image",$eltd_slide_overlay_image);

//Slide Video

$eltdSlideVideoSettings = new ElatedMetaBox("slides", "Slide Background Video","eltd_slide-background-type",array("image"));
$eltdFramework->eltdMetaBoxes->addMetaBox("slides_video_settings",$eltdSlideVideoSettings);

	$eltd_slide_video_webm = new ElatedMetaField("text","eltd_slide-video-webm","","Video - webm","Path to the webm file that you have previously uploaded in Media Section");
	$eltdSlideVideoSettings->addChild("eltd_slide-video-webm",$eltd_slide_video_webm);
	
	$eltd_slide_video_mp4 = new ElatedMetaField("text","eltd_slide-video-mp4","","Video - mp4","Path to the mp4 file that you have previously uploaded in Media Section");
	$eltdSlideVideoSettings->addChild("eltd_slide-video-mp4",$eltd_slide_video_mp4);
	
	$eltd_slide_video_ogv = new ElatedMetaField("text","eltd_slide-video-ogv","","Video - ogv","Path to the ogv file that you have previously uploaded in Media Section");
	$eltdSlideVideoSettings->addChild("eltd_slide-video-ogv",$eltd_slide_video_ogv);

	$eltd_slide_video_image = new ElatedMetaField("image","eltd_slide-video-image","","Video Preview Image","Choose background image that will be visible until video is loaded. This image will be shown on touch devices too.");
	$eltdSlideVideoSettings->addChild("eltd_slide-video-image",$eltd_slide_video_image);
	
	$eltd_slide_video_overlay = new ElatedMetaField("yesempty","eltd_slide-video-overlay","","Video Overlay Image","Do you want to have a overlay image on video? ", array(),
			array("dependence" => true,
			"dependence_hide_on_yes" => "",
			"dependence_show_on_yes" => "#eltdf_eltd_slide-video-overlay_container"));
	$eltdSlideVideoSettings->addChild("eltd_slide-video-overlay",$eltd_slide_video_overlay);
	
	$eltd_slide_video_overlay_container = new ElatedContainer("eltd_slide-video-overlay_container","eltd_slide-video-overlay","");
	$eltdSlideVideoSettings->addChild("eltd_slide_video_overlay_container",$eltd_slide_video_overlay_container);
	
		$eltd_slide_video_overlay_image = new ElatedMetaField("image","eltd_slide-video-overlay-image","","Overlay Image","Choose overlay image (pattern) for background video");
		$eltd_slide_video_overlay_container->addChild("eltd_slide-video-overlay-image",$eltd_slide_video_overlay_image);

//Slide General

$eltdSlideGeneral = new ElatedMetaBox("slides", "Slide General");
$eltdFramework->eltdMetaBoxes->addMetaBox("slides_layout",$eltdSlideGeneral);

    $section_title_1 = new ElatedTitle('section_title_1', 'Slide Text Content');
    $eltdSlideGeneral->addChild('section_title_1', $section_title_1);

    $eltd_slide_hide_title = new ElatedMetaField("yesempty","eltd_slide-hide-title","","Hide Slide Title","Do you want to hide slide title?", array(), array("dependence" => true, "dependence_hide_on_yes" => "#eltdf-meta-box-slides_title, #eltdf_eltd_slide_hide_title_container, #eltdf_eltd_slide_scroll_title_container", "dependence_show_on_yes" => ""));
    $eltdSlideGeneral->addChild("eltd_slide-hide-title",$eltd_slide_hide_title);

    $eltd_slide_hide_title_container = new ElatedContainer('eltd_slide_hide_title_container', 'eltd_slide-hide-title', 'yes');
    $eltdSlideGeneral->addChild('eltd_slide_hide_title_container', $eltd_slide_hide_title_container);

    $title_link_group = new ElatedGroup("Title Link","Define styles for title");
    $eltd_slide_hide_title_container->addChild("title_link_group",$title_link_group);
        $row1 = new ElatedRow();
        $title_link_group->addChild("row1",$row1);

        $title_link = new ElatedMetaField("textsimple","eltd_slide-title-link","","Link","This is some description");
        $row1->addChild("eltd_slide-title-link",$title_link);
        $title_target = new ElatedMetaField("selectsimple","eltd_slide-title-target","_self","Target","This is some description", array(
            "_self" => "Self",
            "_blank" => "Blank"
        ));
        $row1->addChild("eltd_slide-title-target",$title_target);

    $eltd_slide_subtitle = new ElatedMetaField("text","eltd_slide-subtitle","","Subtitle Text","Enter text for subtitle");
    $eltdSlideGeneral->addChild("eltd_slide-subtitle",$eltd_slide_subtitle);

    $eltd_slide_text = new ElatedMetaField("text","eltd_slide-text","","Body Text","Enter slide body text");
    $eltdSlideGeneral->addChild("eltd_slide-text",$eltd_slide_text);

    $button1_label = new ElatedMetaField("text","eltd_slide-button-label","","Button 1 Text"," Enter text to be displayed on button 1");
    $eltdSlideGeneral->addChild("eltd_slide-button-label",$button1_label);

$button1_group1 = new ElatedGroup("Button 1 Link", "");
$eltdSlideGeneral->addChild("button1_group1",$button1_group1);

$row1 = new ElatedRow();
$button1_group1->addChild("row1",$row1);

$button1_link = new ElatedMetaField("textsimple","eltd_slide-button-link","","Link","This is some description");
$row1->addChild("eltd_slide-button-link",$button1_link);
$button1_target = new ElatedMetaField("selectsimple","eltd_slide-button-target","_self","Target","This is some description", array(
    "_self" => "Self",
    "_blank" => "Blank"
));
$row1->addChild("eltd_slide-button-target",$button1_target);

    $button2_label = new ElatedMetaField("text","eltd_slide-button-label2","","Button 2 Text"," Enter text to be displayed on button 2");
    $eltdSlideGeneral->addChild("eltd_slide-button-label2",$button2_label);

$button2_group1 = new ElatedGroup("Button 2 Link","");
$eltdSlideGeneral->addChild("button2_group1",$button2_group1);
$row1 = new ElatedRow();
$button2_group1->addChild("row1",$row1);

$button2_link = new ElatedMetaField("textsimple","eltd_slide-button-link2","","Link","This is some description");
$row1->addChild("eltd_slide-button-link2",$button2_link);
$button2_target = new ElatedMetaField("selectsimple","eltd_slide-button-target2","_self","Target","This is some description", array(
    "_self" => "Self",
    "_blank" => "Blank"
));
$row1->addChild("eltd_slide-button-target",$button2_target);

    $section_title_2 = new ElatedTitle('section_title_2', 'Slide Graphics');
    $eltdSlideGeneral->addChild('section_title_2', $section_title_2);

    $eltd_slide_graphic = new ElatedMetaField("image","eltd_slide-thumbnail","","Slide Graphic","Choose slide graphic");
    $eltdSlideGeneral->addChild("eltd_slide-thumbnail",$eltd_slide_graphic);

    $eltd_slide_graphic_link = new ElatedMetaField("text","eltd_slide-thumbnail-link","","Graphic Link","Enter URL to link slide graphic");
    $eltdSlideGeneral->addChild("eltd_slide-thumbnail-link",$eltd_slide_graphic_link);

    $eltd_slide_svg_source = new ElatedMetaField("textarea", "eltd_slide_svg_source", "", "SVG Source code", "Paste SVG Source code. (Note: all CSS styling for SVG you may put in Options > General > Custom SVG CSS)");
    $eltdSlideGeneral->addChild("eltd_slide_svg_source", $eltd_slide_svg_source);

    $eltd_slide_svg_link = new ElatedMetaField("text","eltd_slide-svg-link","","SVG Link","Enter URL to link SVG");
    $eltdSlideGeneral->addChild("eltd_slide-svg-link",$eltd_slide_svg_link);

    $section_title_3 = new ElatedTitle('section_title_3', 'General Styling');
    $eltdSlideGeneral->addChild('section_title_3', $section_title_3);
	
	$eltd_slide_header_style = new ElatedMetaField("selectblank","eltd_slide-header-style","","Header Style","Header style will be applied when this slide is in focus", array(
	    "light" => "Light",
	    "dark" => "Dark"
	));
	$eltdSlideGeneral->addChild("eltd_slide-header-style",$eltd_slide_header_style);

    $eltd_slide_content_background = new ElatedMetaField("color","eltd_slide-content-background-color","","Slide Content Background Color","Choose background color for slide content");
    $eltdSlideGeneral->addChild("eltd_slide-content-background-color",$eltd_slide_content_background);
/*
	$eltd_slide_navigation_color = new ElatedMetaField("color","eltd_slide-navigation-color","","Navigation Color","Navigation color will be applied when this slide is in focus");
	$eltdSlideGeneral->addChild("eltd_slide-navigation-color",$eltd_slide_navigation_color);
*/

    $eltd_slide_hide_shadow = new ElatedMetaField("yesempty","eltd_slide-hide-shadow","","Show Slide Text Shadow","Do you want to show text shadow?");
    $eltdSlideGeneral->addChild("eltd_slide-hide-shadow",$eltd_slide_hide_shadow);


$eltdSlideBehaviour = new ElatedMetaBox("slides", "Slide Behaviours");
$eltdFramework->eltdMetaBoxes->addMetaBox("slides_behaviour", $eltdSlideBehaviour);

    $eltd_slide_scroll_to_section = new ElatedMetaField("text","eltd_slide-anchor-button","","Scroll to Section","An arrow will appear to take viewers to the next section of the page. Enter the section anchor here, for example, '#contact'");
    $eltdSlideBehaviour->addChild("eltd_slide-anchor-button",$eltd_slide_scroll_to_section);

    $section_title_1 = new ElatedTitle('section_title_1', 'SVG Line Drawing Animation');
    $eltdSlideBehaviour->addChild('section_title_1', $section_title_1);

    $eltd_slide_svg_drawing = new ElatedMetaField("yesno", "eltd_slide_svg_drawing", "no", "SVG Drawing Animation", "Enable SVG drawing animation", array(), array(
        "dependence" => "true",
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_slide_svg_drawing_container"
    ));
    $eltdSlideBehaviour->addChild("eltd_slide_svg_drawing", $eltd_slide_svg_drawing);

    $eltd_slide_svg_drawing_container = new ElatedContainer("eltd_slide_svg_drawing_container", "eltd_slide_svg_drawing", "no");
    $eltdSlideBehaviour->addChild("eltd_slide_svg_drawing_container", $eltd_slide_svg_drawing_container);

    $eltd_slide_svg_frame_rate = new ElatedMetaField("text", "eltd_slide_svg_frame_rate", "", "SVG Frame Rate", "FPS (frames per second) value, defines speed of drawing");
    $eltd_slide_svg_drawing_container->addChild("eltd_slide_svg_frame_rate", $eltd_slide_svg_frame_rate);
	
	$section_title_2 = new ElatedTitle('section_title_2', 'Slide Image Animation');
    $eltdSlideBehaviour->addChild('section_title_2', $section_title_2);
	
	$eltd_enable_image_animation = new ElatedMetaField("yesno", "eltd_enable_image_animation", "no", "Enable Image Animation", "Enabling this option will turn on a motion animation on the slide image", array(), array(
        "dependence" => "true",
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_enable_image_animation_container"
    ));
	$eltdSlideBehaviour->addChild('eltd_enable_image_animation', $eltd_enable_image_animation);
	
	$eltd_enable_image_animation_container = new ElatedContainer("eltd_enable_image_animation_container", "eltd_enable_image_animation", "no");
	$eltdSlideBehaviour->addChild("eltd_enable_image_animation_container", $eltd_enable_image_animation_container);
	
	$eltd_enable_image_animation_type = new ElatedMetaField("select","eltd_enable_image_animation_type","zoom_center","Animation Type","", array(
        "zoom_center" => "Zoom In Center",
        "zoom_top_left" => "Zoom In to Top Left",
        "zoom_top_right" => "Zoom In to Top Right",
        "zoom_bottom_left" => "Zoom In to Bottom Left",
        "zoom_bottom_right" => "Zoom In to Bottom Right"
    ));
    $eltd_enable_image_animation_container->addChild("eltd_enable_image_animation_type",$eltd_enable_image_animation_type);
	
	$section_title_3 = new ElatedTitle('section_title_3', 'Slide Content Entry Animations');
    $eltdSlideBehaviour->addChild('section_title_3', $section_title_3);
	
    $eltd_slide_thumbnail_animation = new ElatedMetaField("select","eltd_slide-thumbnail-animation","flip","Graphic Entry Animation","Choose entry animation for graphic", array(
        "flip" => "Flip",
        "fade" => "Fade In",
        "from_bottom" => "From Bottom",
        "from_top" => "From Top",
        "from_left" => "From Left",
        "from_right" => "From Right",
        "clip_anim_hor" => "Clip Animation Horizontal",
        "clip_anim_ver" => "Clip Animation Vertical",
        "clip_anim_puzzle" => "Clip Animation Puzzle",
        "without_animation"	=>	"No Animation"
    ));
    $eltdSlideBehaviour->addChild("eltd_slide-thumbnail-animation",$eltd_slide_thumbnail_animation);

    $eltd_slide_content_animation = new ElatedMetaField("select","eltd_slide-content-animation","all_at_once","Content Entry Animation","Choose entry animation for whole slide content group (title, subtitle, text, button)", array(
        "all_at_once" => "All At Once",
        "one_by_one" => "One By One",
        "without_animation"	=>	"No Animation"
    ),
        array("dependence" => true,
            "hide" => array(
                "all_at_once"=>"",
                "one_by_one"=>"",
                "without_animation"=>"#eltdf_eltd_slide_content_animation_container"),
            "show" => array(
                "all_at_once"=>"#eltdf_eltd_slide_content_animation_container",
                "one_by_one"=>"#eltdf_eltd_slide_content_animation_container",
                "without_animation"=>""
            )
        ));
    $eltdSlideBehaviour->addChild("eltd_slide-content-animation",$eltd_slide_content_animation);

    $eltd_slide_content_animation_container = new ElatedContainer("eltd_slide_content_animation_container","eltd_slide-content-animation","without_animation");
    $eltdSlideBehaviour->addChild("eltd_slide_content_animation_container",$eltd_slide_content_animation_container);

    $eltd_slide_content_animation_direction = new ElatedMetaField("select","eltd_slide-content-animation-direction","from_bottom","Animation Direction","", array(
        "from_bottom" => "From Bottom",
        "from_top" => "From Top",
        "from_left" => "From Left",
        "from_right" => "From Right",
        "fade" => "Fade In"

    ));
    $eltd_slide_content_animation_container->addChild("eltd_slide-content-animation-direction",$eltd_slide_content_animation_direction);

    $section_title_4 = new ElatedTitle('section_title_4', 'Slide Content Animations Controlled by Scrolling');
    $eltdSlideBehaviour->addChild('section_title_4', $section_title_4);

    $eltd_slide_general_animation = new ElatedMetaField("yesno", "eltd_slide_general_animation", "no", "Animate Whole Slide Content Group at Once on Scroll", "All parts of slide content will animate on scroll as group", array(), array(
        "dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_slide_general_animation_container"
    ));
    $eltdSlideBehaviour->addChild('eltd_slide_general_animation', $eltd_slide_general_animation);

        $eltd_slide_general_animation_container = new ElatedContainer('eltd_slide_general_animation_container', 'eltd_slide_general_animation', 'no');
        $eltdSlideBehaviour->addChild('eltd_slide_general_animation_container', $eltd_slide_general_animation_container);

            $eltd_slide_content_animation_data_start = new ElatedGroup("Scrolling Animation Start Point", "These are starting properties for the scrolling animation of the slide content group");
            $eltd_slide_general_animation_container->addChild("eltd_slide_content_animation_data_start", $eltd_slide_content_animation_data_start);

            $row1 = new ElatedRow();
            $eltd_slide_content_animation_data_start->addChild("row1", $row1);

                $eltd_slide_data_start = new ElatedMetaField("textsimple", "eltd_slide_data_start", "","Scrollbar Top Distance (px)", "", array(), array("col_width" => 1));
                $row1->addChild("eltd_slide_data_start", $eltd_slide_data_start);

                $eltd_slide_data_start_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_start_custom_style", "", "Enter CSS declarations separated by semicolons", "", array(), array("col_width" => 4));
                $row1->addChild("eltd_slide_data_start_custom_style", $eltd_slide_data_start_custom_style);

            $eltd_slide_content_animation_data_end = new ElatedGroup("Scrolling Animation End Point", "These are ending properties for the scrolling animation of the slide content group");
            $eltd_slide_general_animation_container->addChild("eltd_slide_content_animation_data_end", $eltd_slide_content_animation_data_end);

            $row2 = new ElatedRow();
            $eltd_slide_content_animation_data_end->addChild('row2', $row2);

                $eltd_slide_data_end = new ElatedMetaField("textsimple", "eltd_slide_data_end", "", "Scrollbar Top Distance (px)", "");
                $row2->addChild("eltd_slide_data_end", $eltd_slide_data_end);

                $eltd_slide_data_end_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_end_custom_style", "", "Enter CSS declarations separated by semicolons", "");
                $row2->addChild("eltd_slide_data_end_custom_style", $eltd_slide_data_end_custom_style);

    //Title scroll animation
    $eltd_slide_scroll_title_container = new ElatedContainerNoStyle('eltd_slide_scroll_title_container', 'eltd_slide-hide-title', 'yes');
    $eltdSlideBehaviour->addChild('eltd_slide_scroll_title_container', $eltd_slide_scroll_title_container);

    $eltd_slide_title_animation_scroll = new ElatedMetaField("yesno", "eltd_slide_title_animation_scroll", "no", "Animate Title on Scroll", "Enable title text to animate separately", array(), array(
        "dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_slide_title_animation_scroll_container"
    ));
    $eltd_slide_scroll_title_container->addChild('eltd_slide_title_animation_scroll', $eltd_slide_title_animation_scroll);

        $eltd_slide_title_animation_scroll_container = new ElatedContainer('eltd_slide_title_animation_scroll_container', 'eltd_slide_title_animation_scroll', 'no');
        $eltd_slide_scroll_title_container->addChild('eltd_slide_title_animation_scroll_container', $eltd_slide_title_animation_scroll_container);

            $eltd_slide_title_animation_data_start = new ElatedGroup("Scrolling Animation Start Point", "These are properties for the first keyframe in scrolling animation");
            $eltd_slide_title_animation_scroll_container->addChild("eltd_slide_title_animation_data_start", $eltd_slide_title_animation_data_start);

                $row1 = new ElatedRow();
                $eltd_slide_title_animation_data_start->addChild("row1", $row1);

                    $eltd_slide_data_title_start = new ElatedMetaField("textsimple", "eltd_slide_data_title_start", "", "Scrollbar Top Distance (px)", "");
                    $row1->addChild("eltd_slide_data_title_start", $eltd_slide_data_title_start);

                    $eltd_slide_data_title_start_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_title_start_custom_style", "", "Enter CSS declarations separated by semicolons", "");
                    $row1->addChild("eltd_slide_data_title_start_custom_style", $eltd_slide_data_title_start_custom_style);

            $eltd_slide_title_animation_data_end = new ElatedGroup("Scrolling Animation End Point", "These are properties for the last keyframe in scrolling animation");
            $eltd_slide_title_animation_scroll_container->addChild("eltd_slide_title_animation_data_end", $eltd_slide_title_animation_data_end);

                $row2 = new ElatedRow();
                $eltd_slide_title_animation_data_end->addChild("row2", $row2);

                    $eltd_slide_data_title_end = new ElatedMetaField("textsimple", "eltd_slide_data_title_end", "", "Scrollbar Top Distance (px)", "");
                    $row2->addChild("eltd_slide_data_title_end", $eltd_slide_data_title_end);

                    $eltd_slide_data_title_end_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_title_end_custom_style", "", "Enter CSS declarations separated by semicolons", "");
                    $row2->addChild("eltd_slide_data_title_end_custom_style", $eltd_slide_data_title_end_custom_style);


    //Subtitle scroll animation
    $eltd_slide_subtitle_animation_scroll = new ElatedMetaField("yesno", "eltd_slide_subtitle_animation_scroll", "no", "Animate Subtitle on Scroll", "Enable subtitle text to animate separately", array(), array(
        "dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_slide_subtitle_animation_scroll_container"
    ));
    $eltdSlideBehaviour->addChild('eltd_slide_subtitle_animation_scroll', $eltd_slide_subtitle_animation_scroll);

    $eltd_slide_subtitle_animation_scroll_container = new ElatedContainer('eltd_slide_subtitle_animation_scroll_container', 'eltd_slide_subtitle_animation_scroll', 'no');
    $eltdSlideBehaviour->addChild('eltd_slide_subtitle_animation_scroll_container', $eltd_slide_subtitle_animation_scroll_container);

        $eltd_slide_subtitle_animation_data_start = new ElatedGroup("Scrolling Animation Start Point", "These are properties for the first keyframe in scrolling animation");
        $eltd_slide_subtitle_animation_scroll_container->addChild("eltd_slide_subtitle_animation_data_start", $eltd_slide_subtitle_animation_data_start);

            $row1 = new ElatedRow();
            $eltd_slide_subtitle_animation_data_start->addChild("row1", $row1);

                $eltd_slide_data_subtitle_start = new ElatedMetaField("textsimple", "eltd_slide_data_subtitle_start", "", "Scrollbar Top Distance (px)", "");
                $row1->addChild("eltd_slide_data_subtitle_start", $eltd_slide_data_subtitle_start);

                $eltd_slide_data_subtitle_start_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_subtitle_start_custom_style", "", "Enter CSS declarations separated by semicolons", "");
                $row1->addChild("eltd_slide_data_subtitle_start_custom_style", $eltd_slide_data_subtitle_start_custom_style);

        $eltd_slide_subtitle_animation_data_end = new ElatedGroup("Scrolling Animation End Point", "These are properties for the last keyframe in scrolling animation");
        $eltd_slide_subtitle_animation_scroll_container->addChild("eltd_slide_subtitle_animation_data_end", $eltd_slide_subtitle_animation_data_end);

            $row2 = new ElatedRow();
            $eltd_slide_subtitle_animation_data_end->addChild("row2", $row2);

                $eltd_slide_data_subtitle_end = new ElatedMetaField("textsimple", "eltd_slide_data_subtitle_end", "", "Scrollbar Top Distance (px)", "");
                $row2->addChild("eltd_slide_data_subtitle_end", $eltd_slide_data_subtitle_end);

                $eltd_slide_data_subtitle_end_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_subtitle_end_custom_style", "", "Enter CSS declarations separated by semicolons", "");
                $row2->addChild("eltd_slide_data_subtitle_end_custom_style", $eltd_slide_data_subtitle_end_custom_style);


    //Graphics scroll animation
    $eltd_slide_graphic_animation_scroll = new ElatedMetaField("yesno", "eltd_slide_graphic_animation_scroll", "no", "Animate Graphic on Scroll", "Enable graphic to animate separately", array(), array(
        "dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_slide_graphic_animation_scroll_container"
    ));
    $eltdSlideBehaviour->addChild('eltd_slide_graphic_animation_scroll', $eltd_slide_graphic_animation_scroll);

    $eltd_slide_graphic_animation_scroll_container = new ElatedContainer('eltd_slide_graphic_animation_scroll_container', 'eltd_slide_graphic_animation_scroll', 'no');
    $eltdSlideBehaviour->addChild('eltd_slide_graphic_animation_scroll_container', $eltd_slide_graphic_animation_scroll_container);

        $eltd_slide_graphics_animation_data_start = new ElatedGroup("Scrolling Animation Start Point", "These are properties for the first keyframe in scrolling animation");
        $eltd_slide_graphic_animation_scroll_container->addChild("eltd_slide_graphics_animation_data_start", $eltd_slide_graphics_animation_data_start);

            $row1 = new ElatedRow();
            $eltd_slide_graphics_animation_data_start->addChild("row1", $row1);

                $eltd_slide_data_graphics_start = new ElatedMetaField("textsimple", "eltd_slide_data_graphics_start", "", "Scrollbar Top Distance (px)", "");
                $row1->addChild("eltd_slide_data_graphics_start", $eltd_slide_data_graphics_start);

                $eltd_slide_data_graphics_start_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_graphics_start_custom_style", "", "Enter CSS declarations separated by semicolons", "");
                $row1->addChild("eltd_slide_data_graphics_start_custom_style", $eltd_slide_data_graphics_start_custom_style);

        $eltd_slide_graphics_animation_data_end = new ElatedGroup("Scrolling Animation End Point", "These are properties for the last keyframe in scrolling animation");
        $eltd_slide_graphic_animation_scroll_container->addChild("eltd_slide_graphics_animation_data_end", $eltd_slide_graphics_animation_data_end);

            $row2 = new ElatedRow();
            $eltd_slide_graphics_animation_data_end->addChild("row2", $row2);

                $eltd_slide_data_graphics_end = new ElatedMetaField("textsimple", "eltd_slide_data_graphics_end", "", "Scrollbar Top Distance (px)", "");
                $row2->addChild("eltd_slide_data_graphics_end", $eltd_slide_data_graphics_end);

                $eltd_slide_data_graphics_end_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_graphics_end_custom_style", "", "Enter CSS declarations separated by semicolons", "");
                $row2->addChild("eltd_slide_data_graphics_end_custom_style", $eltd_slide_data_graphics_end_custom_style);

    //Text scroll animation
    $eltd_slide_text_animation_scroll = new ElatedMetaField("yesno", "eltd_slide_text_animation_scroll", "no", "Animate Text on Scroll", "Enable text to animate separately", array(), array(
        "dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_slide_text_animation_scroll_container"
    ));
    $eltdSlideBehaviour->addChild('eltd_slide_text_animation_scroll', $eltd_slide_text_animation_scroll);

        $eltd_slide_text_animation_scroll_container = new ElatedContainer('eltd_slide_text_animation_scroll_container', 'eltd_slide_text_animation_scroll', 'no');
        $eltdSlideBehaviour->addChild('eltd_slide_text_animation_scroll_container', $eltd_slide_text_animation_scroll_container);

            $eltd_slide_text_animation_data_start = new ElatedGroup("Scrolling Animation Start Point", "These are properties for the first keyframe in scrolling animation");
            $eltd_slide_text_animation_scroll_container->addChild("eltd_slide_text_animation_data_start", $eltd_slide_text_animation_data_start);

                $row1 = new ElatedRow();
                $eltd_slide_text_animation_data_start->addChild("row1", $row1);

                    $eltd_slide_data_text_start = new ElatedMetaField("textsimple", "eltd_slide_data_text_start", "", "Scrollbar Top Distance (px)", "");
                    $row1->addChild("eltd_slide_data_text_start", $eltd_slide_data_text_start);

                    $eltd_slide_data_text_start_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_text_start_custom_style", "", "Enter CSS declarations separated by semicolons", "");
                    $row1->addChild("eltd_slide_data_text_start_custom_style", $eltd_slide_data_text_start_custom_style);

            $eltd_slide_text_animation_data_end = new ElatedGroup("Scrolling Animation End Point", "These are properties for the last keyframe in scrolling animation");
            $eltd_slide_text_animation_scroll_container->addChild("eltd_slide_text_animation_data_end", $eltd_slide_text_animation_data_end);

                $row2 = new ElatedRow();
                $eltd_slide_text_animation_data_end->addChild("row2", $row2);

                    $eltd_slide_data_text_end = new ElatedMetaField("textsimple", "eltd_slide_data_text_end", "", "Scrollbar Top Distance (px)", "");
                    $row2->addChild("eltd_slide_data_text_end", $eltd_slide_data_text_end);

                    $eltd_slide_data_text_end_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_text_end_custom_style", "", "Enter CSS declarations separated by semicolons", "");
                    $row2->addChild("eltd_slide_data_text_end_custom_style", $eltd_slide_data_text_end_custom_style);


    //Button 1 scroll animation
    $eltd_slide_button1_animation_scroll = new ElatedMetaField("yesno", "eltd_slide_button1_animation_scroll", "no", "Animate Button 1 on Scroll", "Enable button 1 to animate separately", array(), array(
        "dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_slide_button1_animation_scroll_container"
    ));
    $eltdSlideBehaviour->addChild('eltd_slide_button1_animation_scroll', $eltd_slide_button1_animation_scroll);

    $eltd_slide_button1_animation_scroll_container = new ElatedContainer('eltd_slide_button1_animation_scroll_container', 'eltd_slide_button1_animation_scroll', 'no');
    $eltdSlideBehaviour->addChild('eltd_slide_button1_animation_scroll_container', $eltd_slide_button1_animation_scroll_container);

        $eltd_slide_button_1_animation_data_start = new ElatedGroup("Scrolling Animation Start Point", "These are properties for the first keyframe in scrolling animation");
        $eltd_slide_button1_animation_scroll_container->addChild("eltd_slide_button_1_animation_data_start", $eltd_slide_button_1_animation_data_start);

            $row1 = new ElatedRow();
            $eltd_slide_button_1_animation_data_start->addChild("row1", $row1);

                $eltd_slide_data_button_1_start = new ElatedMetaField("textsimple", "eltd_slide_data_button_1_start", "", "Scrollbar Top Distance (px)");
                $row1->addChild("eltd_slide_data_button_1_start", $eltd_slide_data_button_1_start);

                $eltd_slide_data_button_1_start_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_button_1_start_custom_style", "", "Enter CSS declarations separated by semicolons");
                $row1->addChild("eltd_slide_data_button_1_start_custom_style", $eltd_slide_data_button_1_start_custom_style);

        $eltd_slide_button_1_animation_data_end = new ElatedGroup("Scrolling Animation End Point", "These are properties for the last keyframe in scrolling animation");
        $eltd_slide_button1_animation_scroll_container->addChild("eltd_slide_button_1_animation_data_end", $eltd_slide_button_1_animation_data_end);

            $row2 = new ElatedRow();
            $eltd_slide_button_1_animation_data_end->addChild("row2", $row2);

                $eltd_slide_data_button_1_end = new ElatedMetaField("textsimple", "eltd_slide_data_button_1_end", "", "Scrollbar Top Distance (px)");
                $row2->addChild("eltd_slide_data_button_1_end", $eltd_slide_data_button_1_end);

                $eltd_slide_data_button_1_end_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_button_1_end_custom_style", "", "Enter CSS declarations separated by semicolons");
                $row2->addChild("eltd_slide_data_button_1_end_custom_style", $eltd_slide_data_button_1_end_custom_style);



    //Button 2 scroll animation
    $eltd_slide_button2_animation_scroll = new ElatedMetaField("yesno", "eltd_slide_button2_animation_scroll", "no", "Animate Button 2 on Scroll", "Enable button 2 to animate separately", array(), array(
        "dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_slide_button2_animation_scroll_container"
    ));
    $eltdSlideBehaviour->addChild('eltd_slide_button2_animation_scroll', $eltd_slide_button2_animation_scroll);

    $eltd_slide_button2_animation_scroll_container = new ElatedContainer('eltd_slide_button2_animation_scroll_container', 'eltd_slide_button2_animation_scroll', 'no');
    $eltdSlideBehaviour->addChild('eltd_slide_button2_animation_scroll_container', $eltd_slide_button2_animation_scroll_container);

        $eltd_slide_button_2_animation_data_start = new ElatedGroup("Scrolling Animation Start Point", "These are properties for the first keyframe in scrolling animation");
        $eltd_slide_button2_animation_scroll_container->addChild("eltd_slide_button_2_animation_data_start", $eltd_slide_button_2_animation_data_start);

            $row1 = new ElatedRow();
            $eltd_slide_button_2_animation_data_start->addChild("row1", $row1);

                $eltd_slide_data_button_2_start = new ElatedMetaField("textsimple", "eltd_slide_data_button_2_start", "", "Scrollbar Top Distance (px)");
                $row1->addChild("eltd_slide_data_button_2_start", $eltd_slide_data_button_2_start);

                $eltd_slide_data_button_2_start_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_button_2_start_custom_style", "", "Enter CSS declarations separated by semicolons");
                $row1->addChild("eltd_slide_data_button_2_start_custom_style", $eltd_slide_data_button_2_start_custom_style);

        $eltd_slide_button_2_animation_data_end = new ElatedGroup("Scrolling Animation End Point", "These are properties for the last keyframe in scrolling animation");
        $eltd_slide_button2_animation_scroll_container->addChild("eltd_slide_button_2_animation_data_end", $eltd_slide_button_2_animation_data_end);

            $row2 = new ElatedRow();
            $eltd_slide_button_2_animation_data_end->addChild("row2", $row2);

                $eltd_slide_data_button_2_end = new ElatedMetaField("textsimple", "eltd_slide_data_button_2_end", "", "Scrollbar Top Distance (px)");
                $row2->addChild("eltd_slide_data_button_2_end", $eltd_slide_data_button_2_end);

                $eltd_slide_data_button_2_end_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_button_2_end_custom_style", "", "Enter CSS declarations separated by semicolons");
                $row2->addChild("eltd_slide_data_button_2_end_custom_style", $eltd_slide_data_button_2_end_custom_style);



    $eltd_slide_scroll_separator_container = new ElatedContainerNoStyle('eltd_slide_scroll_separator_container', 'eltd_slide-separator-title', 'no');
    $eltdSlideBehaviour->addChild('eltd_slide_scroll_separator_container', $eltd_slide_scroll_separator_container);

    //Separator Top scroll animation
    $eltd_slide_separator_top_animation_scroll = new ElatedMetaField("yesno", "eltd_slide_separator_top_animation_scroll", "no", "Animate Separator Top on Scroll", "Enable separator top to animate separately", array(), array(
        "dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_slide_separator_top_animation_scroll_container"
    ));
    $eltd_slide_scroll_separator_container->addChild('eltd_slide_separator_top_animation_scroll', $eltd_slide_separator_top_animation_scroll);

    $eltd_slide_separator_top_animation_scroll_container = new ElatedContainer('eltd_slide_separator_top_animation_scroll_container', 'eltd_slide_separator_top_animation_scroll', 'no');
    $eltd_slide_scroll_separator_container->addChild('eltd_slide_separator_top_animation_scroll_container', $eltd_slide_separator_top_animation_scroll_container);

        $eltd_slide_separator_top_animation_data_start = new ElatedGroup("Scrolling Animation Start Point", "These are properties for the first keyframe in scrolling animation");
        $eltd_slide_separator_top_animation_scroll_container->addChild("eltd_slide_separator_top_animation_data_start", $eltd_slide_separator_top_animation_data_start);

            $row1 = new ElatedRow();
            $eltd_slide_separator_top_animation_data_start->addChild("row1", $row1);

                $eltd_slide_data_separator_top_start = new ElatedMetaField("textsimple", "eltd_slide_data_separator_top_start", "", "Scrollbar Top Distance (px)");
                $row1->addChild("eltd_slide_data_separator_top_start", $eltd_slide_data_separator_top_start);

                $eltd_slide_data_separator_top_start_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_separator_top_start_custom_style", "", "Enter CSS declarations separated by semicolons");
                $row1->addChild("eltd_slide_data_separator_top_start_custom_style", $eltd_slide_data_separator_top_start_custom_style);

        $eltd_slide_separator_top_animation_data_end = new ElatedGroup("Scrolling Animation End Point", "These are properties for the last keyframe in scrolling animation");
        $eltd_slide_separator_top_animation_scroll_container->addChild("eltd_slide_separator_top_animation_data_end", $eltd_slide_separator_top_animation_data_end);

            $row2 = new ElatedRow();
            $eltd_slide_separator_top_animation_data_end->addChild("row2", $row2);

                $eltd_slide_data_separator_top_end = new ElatedMetaField("textsimple", "eltd_slide_data_separator_top_end", "", "Scrollbar Top Distance (px)");
                $row2->addChild("eltd_slide_data_separator_top_end", $eltd_slide_data_separator_top_end);

                $eltd_slide_data_separator_top_end_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_separator_top_end_custom_style", "", "Enter CSS declarations separated by semicolons");
                $row2->addChild("eltd_slide_data_separator_top_end_custom_style", $eltd_slide_data_separator_top_end_custom_style);


    //Separator Bottom scroll animation
    $eltd_slide_separator_bottom_animation_scroll = new ElatedMetaField("yesno", "eltd_slide_separator_bottom_animation_scroll", "no", "Animate Separator Bottom on Scroll", "Enable separator bottom to animate separately", array(), array(
        "dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_slide_separator_bottom_animation_scroll_container"
    ));
    $eltd_slide_scroll_separator_container->addChild('eltd_slide_separator_bottom_animation_scroll', $eltd_slide_separator_bottom_animation_scroll);

    $eltd_slide_separator_bottom_animation_scroll_container = new ElatedContainer('eltd_slide_separator_bottom_animation_scroll_container', 'eltd_slide_separator_bottom_animation_scroll', 'no');
    $eltd_slide_scroll_separator_container->addChild('eltd_slide_separator_bottom_animation_scroll_container', $eltd_slide_separator_bottom_animation_scroll_container);

        $eltd_slide_separator_bottom_animation_data_start = new ElatedGroup("Scrolling Animation Start Point", "These are properties for the first keyframe in scrolling animation");
        $eltd_slide_separator_bottom_animation_scroll_container->addChild("eltd_slide_separator_bottom_animation_data_start", $eltd_slide_separator_bottom_animation_data_start);

            $row1 = new ElatedRow();
            $eltd_slide_separator_bottom_animation_data_start->addChild("row1", $row1);

                $eltd_slide_data_separator_bottom_start = new ElatedMetaField("textsimple", "eltd_slide_data_separator_bottom_start", "", "Scrollbar Top Distance (px)");
                $row1->addChild("eltd_slide_data_separator_bottom_start", $eltd_slide_data_separator_bottom_start);

                $eltd_slide_data_separator_bottom_start_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_separator_bottom_start_custom_style", "", "Enter CSS declarations separated by semicolons");
                $row1->addChild("eltd_slide_data_separator_bottom_start_custom_style", $eltd_slide_data_separator_bottom_start_custom_style);

        $eltd_slide_separator_bottom_animation_data_end = new ElatedGroup("Scrolling Animation End Point", "These are properties for the last keyframe in scrolling animation");
        $eltd_slide_separator_bottom_animation_scroll_container->addChild("eltd_slide_separator_bottom_animation_data_end", $eltd_slide_separator_bottom_animation_data_end);

            $row2 = new ElatedRow();
            $eltd_slide_separator_bottom_animation_data_end->addChild("row2", $row2);

                $eltd_slide_data_separator_bottom_end = new ElatedMetaField("textsimple", "eltd_slide_data_separator_bottom_end", "", "Scrollbar Top Distance (px)");
                $row2->addChild("eltd_slide_data_separator_bottom_end", $eltd_slide_data_separator_bottom_end);

                $eltd_slide_data_separator_bottom_end_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_separator_bottom_end_custom_style", "", "Enter CSS declarations separated by semicolons");
                $row2->addChild("eltd_slide_data_separator_bottom_end_custom_style", $eltd_slide_data_separator_bottom_end_custom_style);


    //SVG scroll animation
    $eltd_slide_svg_animation_scroll = new ElatedMetaField("yesno", "eltd_slide_svg_animation_scroll", "no", "Animate SVG on Scroll", "Enable SVG to animate separately", array(), array(
        "dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_eltd_slide_svg_animation_scroll_container"
    ));
    $eltdSlideBehaviour->addChild('eltd_slide_svg_animation_scroll', $eltd_slide_svg_animation_scroll);

    $eltd_slide_svg_animation_scroll_container = new ElatedContainer('eltd_slide_svg_animation_scroll_container', 'eltd_slide_svg_animation_scroll', 'no');
    $eltdSlideBehaviour->addChild('eltd_slide_svg_animation_scroll_container', $eltd_slide_svg_animation_scroll_container);

        $eltd_slide_svg_animation_data_start = new ElatedGroup("Scrolling Animation Start Point", "These are properties for the first keyframe in scrolling animation");
        $eltd_slide_svg_animation_scroll_container->addChild("eltd_slide_svg_animation_data_start", $eltd_slide_svg_animation_data_start);

            $row1 = new ElatedRow();
            $eltd_slide_svg_animation_data_start->addChild("row1", $row1);

                $eltd_slide_data_svg_start = new ElatedMetaField("textsimple", "eltd_slide_data_svg_start", "", "Scrollbar Top Distance (px)");
                $row1->addChild("eltd_slide_data_svg_start", $eltd_slide_data_svg_start);

                $eltd_slide_data_svg_start_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_svg_start_custom_style", "", "Enter CSS declarations separated by semicolons");
                $row1->addChild("eltd_slide_data_svg_start_custom_style", $eltd_slide_data_svg_start_custom_style);

        $eltd_slide_svg_animation_data_end = new ElatedGroup("Scrolling Animation End Point", "These are properties for the last keyframe in scrolling animation");
        $eltd_slide_svg_animation_scroll_container->addChild("eltd_slide_svg_animation_data_end", $eltd_slide_svg_animation_data_end);

            $row2 = new ElatedRow();
            $eltd_slide_svg_animation_data_end->addChild("row2", $row2);

                $eltd_slide_data_svg_end = new ElatedMetaField("textsimple", "eltd_slide_data_svg_end", "", "Scrollbar Top Distance (px)");
                $row2->addChild("eltd_slide_data_svg_end", $eltd_slide_data_svg_end);

                $eltd_slide_data_svg_end_custom_style = new ElatedMetaField("textareasimple", "eltd_slide_data_svg_end_custom_style", "", "Enter CSS declarations separated by semicolons");
                $row2->addChild("eltd_slide_data_svg_end_custom_style", $eltd_slide_data_svg_end_custom_style);

//Slide Title

$eltdSlideTitle = new ElatedMetaBox("slides", "Slide Title Style","eltd_slide-hide-title",array("yes"));
$eltdFramework->eltdMetaBoxes->addMetaBox("slides_title",$eltdSlideTitle);

    $title_text_group = new ElatedGroup("Title Text Style","Define styles for title text");
    $eltdSlideTitle->addChild("title_text_group",$title_text_group);
        $row1 = new ElatedRow();
        $title_text_group->addChild("row1",$row1);
            $title_color = new ElatedMetaField("colorsimple","eltd_slide-title-color","","Font Color","This is some description");
            $row1->addChild("eltd_slide-title-color",$title_color);
            $title_fontsize = new ElatedMetaField("textsimple","eltd_slide-title-font-size","","Font Size (px)","This is some description");
            $row1->addChild("eltd_slide-title-font-size",$title_fontsize);
            $title_lineheight = new ElatedMetaField("textsimple","eltd_slide-title-line-height","","Line Height (px)","This is some description");
            $row1->addChild("eltd_slide-title-line-height",$title_lineheight);
            $title_letterspacing = new ElatedMetaField("textsimple","eltd_slide-title-letter-spacing","","Letter Spacing (px)","This is some description");
            $row1->addChild("eltd_slide-title-letter-spacing",$title_letterspacing);

        $row2 = new ElatedRow(true);
        $title_text_group->addChild("row2",$row2);
            $title_google_fonts = new ElatedMetaField("Fontsimple","eltd_slide-title-font-family","","Font Family","This is some description");
            $row2->addChild("eltd_slide-title-font-family",$title_google_fonts);
            $title_fontstyle = new ElatedMetaField("selectblanksimple","eltd_slide-title-font-style","","Font Style","This is some description",$eltd_options_fontstyle);
            $row2->addChild("eltd_slide-title-font-style",$title_fontstyle);
            $title_fontweight = new ElatedMetaField("selectblanksimple","eltd_slide-title-font-weight","","Font Weight","This is some description",$eltd_options_fontweight);
            $row2->addChild("eltd_slide-title-font-weight",$title_fontweight);
            $title_texttransform = new ElatedMetaField("selectblanksimple","eltd_slide-title-text-transform","","Text Transform","This is some description",$eltd_options_texttransform);
            $row2->addChild("eltd_slide-title-text-transform",$title_texttransform);

    $title_background_group = new ElatedGroup("Background","Define background for title");
    $eltdSlideTitle->addChild("title_background_group",$title_background_group);
        $row1 = new ElatedRow();
        $title_background_group->addChild("row1",$row1);
            $title_background_color = new ElatedMetaField("colorsimple","eltd_slide-title-background-color","","Background Color","This is some description");
            $row1->addChild("eltd_slide-title-background-color",$title_background_color);
            $title_background_color_transparency = new ElatedMetaField("textsimple","eltd_slide-title-bg-color-transparency","","Background Color Transparency (values 0-1)","This is some description");
            $row1->addChild("eltd_slide-title-bg-color-transparency",$title_background_color_transparency);

    $title_margin_group = new ElatedGroup("Margin Bottom (px)","Enter value for title bottom margin (default value is 14)");
    $eltdSlideTitle->addChild("title_margin_group",$title_margin_group);
        $row1 = new ElatedRow();
        $title_margin_group->addChild("row1",$row1);
            $title_margin_bottom = new ElatedMetaField("textsimple","eltd_slide_title_margin_bottom","","","This is some description");
            $row1->addChild("eltd_slide_title_margin_bottom",$title_margin_bottom);

    $title_padding_group = new ElatedGroup("Padding","Define padding for title");
    $eltdSlideTitle->addChild("title_padding_group",$title_padding_group);
        $row1 = new ElatedRow();
        $title_padding_group->addChild("row1",$row1);
            $title_padding_top = new ElatedMetaField("textsimple","eltd_slide_title_padding_top","","Top Padding (px)","This is some description");
            $row1->addChild("eltd_slide_title_padding_top",$title_padding_top);
            $title_padding_right = new ElatedMetaField("textsimple","eltd_slide_title_padding_right","","Right Padding (px)","This is some description");
            $row1->addChild("eltd_slide_title_padding_right",$title_padding_right);
            $title_padding_bottom = new ElatedMetaField("textsimple","eltd_slide_title_padding_bottom","","Bottom Padding (px)","This is some description");
            $row1->addChild("eltd_slide_title_padding_bottom",$title_padding_bottom);
            $title_padding_left = new ElatedMetaField("textsimple","eltd_slide_title_padding_left","","Left Padding (px)","This is some description");
            $row1->addChild("eltd_slide_title_padding_left",$title_padding_left);

    $eltd_slide_title_border = new ElatedMetaField('yesno', 'eltd_slide_title_border', 'no', 'Border', 'Do you want to have a title border?', array(), array(
        'dependence' => true,
        'dependence_hide_on_yes' => '',
        'dependence_show_on_yes' => '#eltdf_title_border_container'
    ));
    $eltdSlideTitle->addChild('eltd_slide_title_border', $eltd_slide_title_border);

    $title_border_container = new ElatedContainer('title_border_container', 'eltd_slide_title_border', 'no');
    $eltdSlideTitle->addChild('title_border_container', $title_border_container);


    $title_border_group = new ElatedGroup("Title Border", "Define border for title");
    $title_border_container->addChild("title_border_group", $title_border_group);
        $row1 = new ElatedRow();
        $title_border_group->addChild("row1", $row1);
            $title_border_thickness = new ElatedMetaField("textsimple", "eltd_slide_title_border_thickness", "", "Thickness (px)", "");
            $row1->addChild("title_border_thickness", $title_border_thickness);
            $title_border_style = new ElatedMetaField("selectsimple", "eltd_slide_title_border_style", "", "Style", "", array(
                "solid" => "solid",
                "dashed" => "dashed",
                "dotted" => "dotted",
                "double" => "double",
                "groove" => "groove",
                "ridge" => "ridge",
                "inset" => "inset",
                "outset" => "outset"
            ));
            $row1->addChild("title_border_style", $title_border_style);
            $title_border_color = new ElatedMetaField("colorsimple", "eltd_slider_title_border_color", "", "Color", "");
            $row1->addChild("eltd_slider_title_border_color", $title_border_color);

    $eltd_slide_title_separator = new ElatedMetaField("yesno","eltd_slide-separator-title","no","Title Separator","Do you want to have a title separator?", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_eltd_slide_title_separator_container, #eltdf_eltd_slide_scroll_separator_container"));
    $eltdSlideTitle->addChild("eltd_slide-separator-title",$eltd_slide_title_separator);

    $eltd_slide_title_separator_container = new ElatedContainer("eltd_slide_title_separator_container","eltd_slide-separator-title","no");
    $eltdSlideTitle->addChild("eltd_slide_title_separator_container",$eltd_slide_title_separator_container);


    //Separator with or without icon
    $eltd_slide_title_separator_type = new ElatedMetaField('select', 'eltd_slide_title_separator_type', '', 'Separator Type', '', array(
        'without_icon' => 'Without Icon',
        'with_icon' => 'With Icon',
        'with_custom_icon' => 'With Custom Icon'
    ), array(
        'dependence' => true,
        'hide' => array(
            'without_icon' => '#eltdf_eltd_slide_title_separator_with_icon_container, #eltdf_eltd_slide_title_separator_with_custom_icon_container',
            'with_icon' => '#eltdf_eltd_slide_title_separator_without_icon_container, #eltdf_eltd_slide_title_separator_with_custom_icon_container',
            'with_custom_icon' => '#eltdf_eltd_slide_title_separator_with_icon_container, #eltdf_eltd_slide_title_separator_without_icon_container'
        ),
        'show' => array(
            'without_icon' => '#eltdf_eltd_slide_title_separator_without_icon_container',
            'with_icon' => '#eltdf_eltd_slide_title_separator_with_icon_container',
            'with_custom_icon' => '#eltdf_eltd_slide_title_separator_with_custom_icon_container'
        )
    ));
    $eltd_slide_title_separator_container->addChild('eltd_slide_title_separator_type', $eltd_slide_title_separator_type);

    //Separator without Icon Container
    $eltd_slide_title_separator_without_icon_container = new ElatedContainer('eltd_slide_title_separator_without_icon_container', 'eltd_slide_title_separator_type', '', array('with_icon', 'with_custom_icon'));
    $eltd_slide_title_separator_container->addChild('eltd_slide_title_separator_without_icon_container', $eltd_slide_title_separator_without_icon_container);


    $eltd_slide_title_separator_align_container = new ElatedContainerNoStyle('eltd_slide_title_separator_align_container', 'eltd_slide-title-separator-position', 'left_right');
    $eltd_slide_title_separator_without_icon_container->addChild('eltd_slide_title_separator_align_container', $eltd_slide_title_separator_align_container);

    $eltd_slide_title_separator_align = new ElatedMetaField("select","eltd_slide-title-separator-align","both","Alignment","Choose alignment of slider separator", array(
        "none" => "Center",
        "left" => "Left",
        "right" => "Right"
    ));
    $eltd_slide_title_separator_align_container->addChild("eltd_slide-title-separator-align",$eltd_slide_title_separator_align);

        $eltd_slide_separator_color_group = new ElatedGroup("Separator Color","Define color for slider separator");
        $eltd_slide_title_separator_without_icon_container->addChild("eltd_slide_separator_color_group",$eltd_slide_separator_color_group);

            $row1 = new ElatedRow();
            $eltd_slide_separator_color_group->addChild("row1",$row1);

                $eltd_slide_title_separator_color = new ElatedMetaField("colorsimple","eltd_slide-separator-color","","Separator Color","Choose a color for the separator");
                $row1->addChild("eltd_slide-separator-color",$eltd_slide_title_separator_color);

                    $eltd_slide_title_separator_transparency = new ElatedMetaField("textsimple","eltd_slide-separator-transparency","","Separator transparency (values 0-1)","This is some description");
                    $row1->addChild("eltd_slide-separator-transparency",$eltd_slide_title_separator_transparency);

        $eltd_slide_separator_border_group = new ElatedGroup("Separator Border","Define border for slider separator");
        $eltd_slide_title_separator_without_icon_container->addChild("eltd_slide_separator_border_group",$eltd_slide_separator_border_group);

            $row1 = new ElatedRow();
            $eltd_slide_separator_border_group->addChild("row1",$row1);

                $eltd_slide_separator_border_color = new ElatedMetaField("colorsimple","eltd_slide-separator-border-color","","Color","Choose a color for the separator");
                $row1->addChild("eltd_slide-separator-border-color",$eltd_slide_separator_border_color);

                $eltd_slide_separator_border_width = new ElatedMetaField("textsimple","eltd_slide-separator-border-width","","Thickness (px)","This is some description");
                $row1->addChild("eltd_slide-separator-border-width",$eltd_slide_separator_border_width);

                $eltd_slide_separator_border_style = new ElatedMetaField('selectsimple', 'eltd_slide-separator-border-style', 'solid', 'Style', '', array(
                    "solid" => "Solid",
                    "dashed" => "Dashed",
                    "dotted" => "Dotted",
                    "transparent" => "Transparent"
                ));
                $row1->addChild("eltd_slide-separator-border-style",$eltd_slide_separator_border_style);


        $eltd_slide_separator_size_group = new ElatedGroup("Separator Size","Define size for slider separator");
        $eltd_slide_title_separator_without_icon_container->addChild("eltd_slide_separator_size_group",$eltd_slide_separator_size_group);

            $row1 = new ElatedRow();
            $eltd_slide_separator_size_group->addChild("row1",$row1);

                $eltd_slide_title_separator_width = new ElatedMetaField("textsimple","eltd_slide-separator-width","","Separator Width (%)","Enter value from 0% to 100%. Enter just number.");
                $row1->addChild("eltd_slide-separator-width",$eltd_slide_title_separator_width);

                $eltd_slide_title_separator_thickness = new ElatedMetaField("textsimple","eltd_slide-separator-thickness","","Separator Thickness (px)","This is some description");
                $row1->addChild("eltd_slide-separator-thickness",$eltd_slide_title_separator_thickness);

    //Separator with icon container
    $eltd_slide_title_separator_with_icon_container = new ElatedContainer('eltd_slide_title_separator_with_icon_container', 'eltd_slide_title_separator_type', '', array('without_icon', 'with_custom_icon'));
    $eltd_slide_title_separator_container->addChild('eltd_slide_title_separator_with_icon_container', $eltd_slide_title_separator_with_icon_container);

        $eltd_slide_separator_icon_hide_array = array();
        $eltd_slide_separator_icon_show_array = array();

        if(is_array($eltdIconCollections->iconCollections) && count($eltdIconCollections->iconCollections)) {

            $eltd_slide_separator_icon_collections_params = $eltdIconCollections->getIconCollectionsParams();

            foreach ($eltdIconCollections->iconCollections as $dep_collection_key => $dep_collection_object) {
                $eltd_slide_separator_icon_hide_array[$dep_collection_key] = '';

                $eltd_slide_separator_icon_show_array[$dep_collection_key] = '#eltdf_eltd_slide_title_separator_with_icon_'.$dep_collection_object->param.'_container';

                foreach ($eltd_slide_separator_icon_collections_params as $eltd_slide_separator_icon_collections_param) {

                    if($eltd_slide_separator_icon_collections_param !== $dep_collection_object->param) {
                        $eltd_slide_separator_icon_hide_array[$dep_collection_key].= '#eltdf_eltd_slide_title_separator_with_icon_'.$eltd_slide_separator_icon_collections_param.'_container,';
                    }

                }

                $eltd_slide_separator_icon_hide_array[$dep_collection_key] = rtrim($eltd_slide_separator_icon_hide_array[$dep_collection_key], ',');
            }

        }

        $eltd_slide_title_separator_with_icon_icon_pack = new ElatedMetaField(
            'select',
            'eltd_slide_title_separator_with_icon_icon_pack',
            'font_awesome',
            'Icon Package',
            'Choose Icon Package',
            $eltdIconCollections->getIconCollections(),
            array(
                'dependence' => true,
                'hide' => $eltd_slide_separator_icon_hide_array,
                'show' => $eltd_slide_separator_icon_show_array
            )
        );
        $eltd_slide_title_separator_with_icon_container->addChild('eltd_slide_title_separator_with_icon_icon_pack', $eltd_slide_title_separator_with_icon_icon_pack);

        if(is_array($eltdIconCollections->iconCollections) && count($eltdIconCollections->iconCollections)) {

            foreach ($eltdIconCollections->iconCollections as $collection_key => $collection_object) {
                $icons_array = $collection_object->getIconsArray();

                $icon_collections_keys = $eltdIconCollections->getIconCollectionsKeys();

                unset($icon_collections_keys[array_search($collection_key, $icon_collections_keys)]);

                $eltd_slide_title_separator_icon_hide_values = $icon_collections_keys;

                $eltd_slide_title_separator_with_icon_icon_pack_container = new ElatedContainer('eltd_slide_title_separator_with_icon_'.$collection_object->param.'_container', 'eltd_slide_title_separator_with_icon_icon_pack', '', $eltd_slide_title_separator_icon_hide_values);
                $eltd_slide_title_separator_with_icon_container->addChild('eltd_slide_title_separator_with_icon_'.$collection_object->param.'_container', $eltd_slide_title_separator_with_icon_icon_pack_container);

                $eltd_slide_title_separator_with_icon_icon_type = new ElatedMetaField('select', 'eltd_slide_title_separator_with_icon_'.$collection_object->param, '', $collection_object->title, 'Icon Package', $icons_array);
                $eltd_slide_title_separator_with_icon_icon_pack_container->addChild('eltd_slide_title_separator_with_icon_'.$collection_object->param, $eltd_slide_title_separator_with_icon_icon_type);

            }

        }

        $eltd_slide_title_separator_with_icon_separator_size_group = new ElatedGroup('Separator Size and Style', 'Define size, color and margins');
        $eltd_slide_title_separator_with_icon_container->addChild('eltd_slide_title_separator_with_icon_separator_size_group', $eltd_slide_title_separator_with_icon_separator_size_group);

            $row1 = new ElatedRow();
            $eltd_slide_title_separator_with_icon_separator_size_group->addChild('row1', $row1);

                $eltd_slide_title_separator_with_icon_line_style = new ElatedMetaField('selectsimple', 'eltd_slide_title_separator_with_icon_line_style', 'normal', 'Separator Line Style', '', array(
                    "solid" => "Solid",
                    "dashed" => "Dashed",
                    "dotted" => "Dotted",
                    "transparent" => "Transparent"
                ));
                $row1->addChild('eltd_slide_title_separator_with_icon_line_style', $eltd_slide_title_separator_with_icon_line_style);

                $eltd_slide_title_separator_with_icon_separator_width = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_icon_separator_width', '', 'Width (px)', '');
                $row1->addChild('eltd_slide_title_separator_with_icon_separator_width', $eltd_slide_title_separator_with_icon_separator_width);

                $eltd_slide_title_separator_with_icon_separator_margin_top = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_icon_separator_margin_top', '', 'Top Margin (px)', '');
                $row1->addChild('eltd_slide_title_separator_with_icon_separator_margin_top', $eltd_slide_title_separator_with_icon_separator_margin_top);

                $eltd_slide_title_separator_with_icon_separator_margin_bottom = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_icon_separator_margin_bottom', '', 'Bottom Margin (px)', '');
                $row1->addChild('eltd_slide_title_separator_with_icon_separator_margin_bottom', $eltd_slide_title_separator_with_icon_separator_margin_bottom);



            $row2 = new ElatedRow(true);
            $eltd_slide_title_separator_with_icon_separator_size_group->addChild('row2', $row2);

                $eltd_slide_title_separator_with_icon_separator_thickness = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_icon_separator_thickness', '', 'Thickness (px)', '');
                $row2->addChild('eltd_slide_title_separator_with_icon_separator_thickness', $eltd_slide_title_separator_with_icon_separator_thickness);

                $eltd_slide_title_separator_with_icon_separator_color = new ElatedMetaField('colorsimple', 'eltd_slide_title_separator_with_icon_separator_color', '', 'Separator Color', '');
                $row2->addChild('eltd_slide_title_separator_with_icon_separator_color', $eltd_slide_title_separator_with_icon_separator_color);


        $eltd_slide_title_separator_with_icon_icon_size_group = new ElatedGroup('Icon Position and Size', 'Define icon position, size and type');
        $eltd_slide_title_separator_with_icon_container->addChild('eltd_slide_title_separator_with_icon_icon_size_group', $eltd_slide_title_separator_with_icon_icon_size_group);

            $row1 = new ElatedRow();
            $eltd_slide_title_separator_with_icon_icon_size_group->addChild('row1', $row1);

                $eltd_slide_title_separator_with_icon_icon_type = new ElatedMetaField('selectsimple', 'eltd_slide_title_separator_with_icon_icon_type', 'normal', 'Icon Type', '', array(
                    'normal' => 'Normal',
                    'circle' => 'Circle',
                    'square' => 'Square'
                ));
                $row1->addChild('eltd_slide_title_separator_with_icon_icon_type', $eltd_slide_title_separator_with_icon_icon_type);

                $eltd_slide_title_separator_with_icon_icon_postition = new ElatedMetaField('selectsimple', 'eltd_slide_title_separator_with_icon_icon_postition', 'normal', 'Icon Position', '', array(
                    'center' => 'Center',
                    'left' => 'Left',
                    'right' => 'Right'
                ));
                $row1->addChild('eltd_slide_title_separator_with_icon_icon_postition', $eltd_slide_title_separator_with_icon_icon_postition);

                $eltd_slide_title_separator_with_icon_icon_custom_size = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_icon_icon_custom_size', '', 'Icon Custom Size (px)', '');
                $row1->addChild('eltd_slide_title_separator_with_icon_icon_custom_size', $eltd_slide_title_separator_with_icon_icon_custom_size);

                $eltd_slide_title_separator_with_icon_icon_shape_size = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_icon_icon_shape_size', '', 'Icon Shape Size (px)', '');
                $row1->addChild('eltd_slide_title_separator_with_icon_icon_shape_size', $eltd_slide_title_separator_with_icon_icon_shape_size);

            $row2 = new ElatedRow(true);
            $eltd_slide_title_separator_with_icon_icon_size_group->addChild('row2', $row2);

                $eltd_slide_title_separator_with_icon_icon_margin = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_icon_icon_margin', '', 'Icon Margin (px)', '');
                $row2->addChild('eltd_slide_title_separator_with_icon_icon_margin', $eltd_slide_title_separator_with_icon_icon_margin);

                $eltd_slide_title_separator_with_icon_icon_border_radius = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_icon_icon_border_radius', '', 'Icon Border Radius (px)', '');
                $row2->addChild('eltd_slide_title_separator_with_icon_icon_border_radius', $eltd_slide_title_separator_with_icon_icon_border_radius);

                $eltd_slide_title_separator_with_icon_icon_border_width = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_icon_icon_border_width', '', 'Icon Border Width (px)', '');
                $row2->addChild('eltd_slide_title_separator_with_icon_icon_border_width', $eltd_slide_title_separator_with_icon_icon_border_width);


        $eltd_slide_title_separator_with_icon_icon_colour_group = new ElatedGroup('Icon Color', 'Define icon, icon background and icon hover colors');
        $eltd_slide_title_separator_with_icon_container->addChild('eltd_slide_title_separator_with_icon_icon_colour_group', $eltd_slide_title_separator_with_icon_icon_colour_group);

            $row3 = new ElatedRow();
            $eltd_slide_title_separator_with_icon_icon_colour_group->addChild('row3', $row3);

                $eltd_slide_title_separator_with_icon_icon_color = new ElatedMetaField('colorsimple', 'eltd_slide_title_separator_with_icon_icon_color', '', 'Icon Color', '');
                $row3->addChild('eltd_slide_title_separator_with_icon_icon_color', $eltd_slide_title_separator_with_icon_icon_color);

                $eltd_slide_title_separator_with_icon_icon_border_color = new ElatedMetaField('colorsimple', 'eltd_slide_title_separator_with_icon_icon_border_color', '', 'Icon Border Color', '');
                $row3->addChild('eltd_slide_title_separator_with_icon_icon_border_color', $eltd_slide_title_separator_with_icon_icon_border_color);


                $eltd_slide_title_separator_with_icon_icon_background_color = new ElatedMetaField('colorsimple', 'eltd_slide_title_separator_with_icon_icon_background_color', '', 'Icon Background Color', '');
                $row3->addChild('eltd_slide_title_separator_with_icon_icon_background_color', $eltd_slide_title_separator_with_icon_icon_background_color);

                $eltd_slide_title_separator_with_icon_icon_hover_color = new ElatedMetaField('colorsimple', 'eltd_slide_title_separator_with_icon_icon_hover_color', '', 'Icon Hover Color', '');
                $row3->addChild('eltd_slide_title_separator_with_icon_icon_hover_color', $eltd_slide_title_separator_with_icon_icon_hover_color);

            $row4 = new ElatedRow(true);
            $eltd_slide_title_separator_with_icon_icon_colour_group->addChild('row4', $row4);

                $eltd_slide_title_separator_with_icon_icon_hover_border_color = new ElatedMetaField('colorsimple', 'eltd_slide_title_separator_with_icon_icon_hover_border_color', '', 'Icon Hover Border Color', '');
                $row4->addChild('eltd_slide_title_separator_with_icon_icon_hover_border_color', $eltd_slide_title_separator_with_icon_icon_hover_border_color);

                $eltd_slide_title_separator_with_icon_icon_hover_background_color = new ElatedMetaField('colorsimple', 'eltd_slide_title_separator_with_icon_icon_hover_background_color', '', 'Icon Hover Background Color', '');
                $row4->addChild('eltd_slide_title_separator_with_icon_icon_hover_background_color', $eltd_slide_title_separator_with_icon_icon_hover_background_color);

    //Separator with custom icon container
    $eltd_slide_title_separator_with_custom_icon_container = new ElatedContainer('eltd_slide_title_separator_with_custom_icon_container', 'eltd_slide_title_separator_type', '', array('without_icon', 'with_icon'));
    $eltd_slide_title_separator_container->addChild('eltd_slide_title_separator_with_custom_icon_container', $eltd_slide_title_separator_with_custom_icon_container);

        $eltd_slide_title_separator_with_custom_icon_custom_icon = new ElatedMetaField('image', 'eltd_slide_title_separator_with_custom_icon_custom_icon', '', 'Custom Icon', '');
        $eltd_slide_title_separator_with_custom_icon_container->addChild('eltd_slide_title_separator_with_custom_icon_custom_icon', $eltd_slide_title_separator_with_custom_icon_custom_icon);

        $eltd_slide_title_separator_with_custom_icon_separator_style_group = new ElatedGroup('Style', '');
        $eltd_slide_title_separator_with_custom_icon_container->addChild('eltd_slide_title_separator_with_custom_icon_separator_style_group', $eltd_slide_title_separator_with_custom_icon_separator_style_group);

            $row1 = new ElatedRow();
            $eltd_slide_title_separator_with_custom_icon_separator_style_group->addChild('row1', $row1);

                $eltd_slide_title_separator_with_custom_icon_line_style = new ElatedMetaField('selectsimple', 'eltd_slide_title_separator_with_custom_icon_line_style', 'normal', 'Separator Line Style', '', array(
                    "solid" => "Solid",
                    "dashed" => "Dashed",
                    "dotted" => "Dotted",
                    "transparent" => "Transparent"
                ));
                $row1->addChild('eltd_slide_title_separator_with_custom_icon_line_style', $eltd_slide_title_separator_with_custom_icon_line_style);

                $eltd_slide_title_separator_with_custom_icon_separator_width = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_custom_icon_separator_width', '', 'Width (px)', '');
                $row1->addChild('eltd_slide_title_separator_with_custom_icon_separator_width', $eltd_slide_title_separator_with_custom_icon_separator_width);

                $eltd_slide_title_separator_with_custom_icon_separator_margin_top = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_custom_icon_separator_margin_top', '', 'Top Margin (px)', '');
                $row1->addChild('eltd_slide_title_separator_with_custom_icon_separator_margin_top', $eltd_slide_title_separator_with_custom_icon_separator_margin_top);

                $eltd_slide_title_separator_with_custom_icon_separator_margin_bottom = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_custom_icon_separator_margin_bottom', '', 'Bottom Margin (px)', '');
                $row1->addChild('eltd_slide_title_separator_with_custom_icon_separator_margin_bottom', $eltd_slide_title_separator_with_custom_icon_separator_margin_bottom);

            $row2 = new ElatedRow(true);
            $eltd_slide_title_separator_with_custom_icon_separator_style_group->addChild('row2', $row2);

                $eltd_slide_title_separator_with_custom_icon_separator_thickness = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_custom_icon_separator_thickness', '', 'Thickness (px)', '');
                $row2->addChild('eltd_slide_title_separator_with_custom_icon_separator_thickness', $eltd_slide_title_separator_with_custom_icon_separator_thickness);

                $eltd_slide_title_separator_with_custom_icon_separator_color = new ElatedMetaField('colorsimple', 'eltd_slide_title_separator_with_custom_icon_separator_color', '', 'Separator Color', '');
                $row2->addChild('eltd_slide_title_separator_with_custom_icon_separator_color', $eltd_slide_title_separator_with_custom_icon_separator_color);

                $eltd_slide_title_separator_with_custom_icon_icon_postition = new ElatedMetaField('selectsimple', 'eltd_slide_title_separator_with_custom_icon_icon_postition', 'normal', 'Icon Position', '', array(
                    'center' => 'Center',
                    'left' => 'Left',
                    'right' => 'Right'
                ));
                $row2->addChild('eltd_slide_title_separator_with_custom_icon_icon_postition', $eltd_slide_title_separator_with_custom_icon_icon_postition);

                $eltd_slide_title_separator_with_custom_icon_icon_margin = new ElatedMetaField('textsimple', 'eltd_slide_title_separator_with_custom_icon_icon_margin', '', 'Icon Margin (px)', '');
                $row2->addChild('eltd_slide_title_separator_with_custom_icon_icon_margin', $eltd_slide_title_separator_with_custom_icon_icon_margin);

        //Separator Position Without Icon
        $eltd_slide_title_separator_position = new ElatedMetaField("select","eltd_slide-title-separator-position","both","Position","Choose position of slider separator", array(
            "both" => "Top and Bottom",
            "left_right" => "Left and Right",
            "top" => "Top",
            "bottom" => "Bottom"
        ),
        array("dependence" => true,
            "hide" => array(
                "both"=>"#eltdf_eltd_slide_left_right_separator_container",
                "left_right" => "#eltdf_eltd_slide_top_separator_container, #eltdf_eltd_slide_bottom_separator_container, #eltdf_eltd_slide_title_separator_align_container",
                "top"=>"#eltdf_eltd_slide_bottom_separator_container, #eltdf_eltd_slide_left_right_separator_container",
                "bottom"=>"#eltdf_eltd_slide_top_separator_container, #eltdf_eltd_slide_left_right_separator_container"),
            "show" => array(
                "both"=>"#eltdf_eltd_slide_top_separator_container,#eltdf_eltd_slide_bottom_separator_container, #eltdf_eltd_slide_title_separator_align_container",
                "top"=>"#eltdf_eltd_slide_top_separator_container, #eltdf_eltd_slide_title_separator_align_container",
                "bottom"=>"#eltdf_eltd_slide_bottom_separator_container, #eltdf_eltd_slide_title_separator_align_container",
                "left_right" => "#eltdf_eltd_slide_left_right_separator_container"
            )
        ));
        $eltd_slide_title_separator_without_icon_container->addChild("eltd_slide-title-separator-position",$eltd_slide_title_separator_position);

        $eltd_slide_top_separator_container = new ElatedContainer("eltd_slide_top_separator_container","eltd_slide-title-separator-position","", array("bottom", "left_right"));
        $eltd_slide_title_separator_without_icon_container->addChild("eltd_slide_top_separator_container",$eltd_slide_top_separator_container);

            $group1 = new ElatedGroup("Top Separator Margins","Enter top separator margins");
            $eltd_slide_top_separator_container->addChild("group1",$group1);

                $row1 = new ElatedRow();
                $group1->addChild("row1",$row1);

                    $eltd_slide_top_separator_margin_top = new ElatedMetaField("textsimple","eltd_slide-top-separator-margin-top","","Margin Top (px)","This is some description");
                    $row1->addChild("eltd_slide-top-separator-margin-top",$eltd_slide_top_separator_margin_top);

                    $eltd_slide_top_separator_margin_bottom = new ElatedMetaField("textsimple","eltd_slide-top-separator-margin-bottom","","Margin Bottom (px)","This is some description");
                    $row1->addChild("eltd_slide-top-separator-margin-bottom",$eltd_slide_top_separator_margin_bottom);

        $eltd_slide_bottom_separator_container = new ElatedContainer("eltd_slide_bottom_separator_container","eltd_slide-title-separator-position","", array("top", "left_right"));
        $eltd_slide_title_separator_without_icon_container->addChild("eltd_slide_bottom_separator_container",$eltd_slide_bottom_separator_container);

            $group2 = new ElatedGroup("Bottom Separator Margins","Enter bottom separator margins");
            $eltd_slide_bottom_separator_container->addChild("group2",$group2);

                $row1 = new ElatedRow();
                $group2->addChild("row1",$row1);

                    $eltd_slide_bottom_separator_margin_top = new ElatedMetaField("textsimple","eltd_slide-bottom-separator-margin-top","","Margin Top (px)","This is some description");
                    $row1->addChild("eltd_slide-bottom-separator-margin-top",$eltd_slide_bottom_separator_margin_top);

                    $eltd_slide_bottom_separator_margin_bottom = new ElatedMetaField("textsimple","eltd_slide-bottom-separator-margin-bottom","","Margin Bottom (px)","This is some description");
                    $row1->addChild("eltd_slide-bottom-separator-margin-bottom",$eltd_slide_bottom_separator_margin_bottom);

        $eltd_slide_left_right_separator_container = new ElatedContainer("eltd_slide_left_right_separator_container","eltd_slide-title-separator-position","", array("top", "bottom", "both"));
        $eltd_slide_title_separator_without_icon_container->addChild('eltd_slide_left_right_separator_container', $eltd_slide_left_right_separator_container);

            $eltd_slide_left_right_separator_style = new ElatedMetaField('select', 'eltd_slide_left_right_separator_style', 'solid', 'Line Style', 'Separator Line Style', array(
                "solid" => "Solid",
                "dashed" => "Dashed",
                "dotted" => "Dotted"
            ));
            $eltd_slide_left_right_separator_container->addChild('eltd_slide_left_right_separator_style', $eltd_slide_left_right_separator_style);

            $group3 = new ElatedGroup('Left/Right Separator Margins', 'Enter left and right separator margins');
            $eltd_slide_left_right_separator_container->addChild('group3', $group3);

                $row1 = new ElatedRow();
                $group3->addChild('row1',$row1);

                    $eltd_slide_left_separator_margin_right = new ElatedMetaField("textsimple","eltd_slide_left_separator_margin_right","","Left Separator Margin Right (px)","");
                    $row1->addChild("eltd_slide_left_separator_margin_right",$eltd_slide_left_separator_margin_right);

                    $eltd_slide_right_separator_margin_left = new ElatedMetaField("textsimple","eltd_slide_right_separator_margin_left","","Right Separator Margin Right (px)","");
                    $row1->addChild("eltd_slide_right_separator_margin_left",$eltd_slide_right_separator_margin_left);

            $group4 = new ElatedGroup('Dots on Line End', 'Add dots on line end');
            $eltd_slide_left_right_separator_container->addChild('group4', $group4);

                $row2 = new ElatedRow();
                $group4->addChild('row2', $row2);

                    $eltd_slide_left_right_separator_linedots = new ElatedMetaField('selectsimple', 'eltd_slide_left_right_separator_linedots', 'no', 'Dots on line end', '', array(
                        'no' => 'No',
                        'yes' => 'Yes',
                    ));
                    $row2->addChild('eltd_slide_left_right_separator_linedots', $eltd_slide_left_right_separator_linedots);

                    $eltd_slide_left_right_separator_line_dots_size = new ElatedMetaField('textsimple', 'eltd_slide_left_right_separator_line_dots_size', '', 'Dots Size (px)', '');
                    $row2->addChild('eltd_slide_left_right_separator_line_dots_size', $eltd_slide_left_right_separator_line_dots_size);

                    $eltd_slide_left_right_separator_dots_color = new ElatedMetaField('colorsimple', 'eltd_slide_left_right_separator_dots_color', '', 'Dots Color', '');
                    $row2->addChild('eltd_slide_left_right_separator_dots_color', $eltd_slide_left_right_separator_dots_color);

        //Separator Position With Icon
        $eltd_slide_title_separator_with_icon_position = new ElatedMetaField("select","eltd_slide_title_separator_with_icon_position","both","Position","Choose position of slider separator", array(
            "top" => "Top",
            "bottom" => "Bottom"
        ));
        $eltd_slide_title_separator_with_icon_container->addChild("eltd_slide_title_separator_with_icon_position",$eltd_slide_title_separator_with_icon_position);

        //Separator Position With Custom Icon
        $eltd_slide_title_separator_with_custom_icon_position = new ElatedMetaField("select","eltd_slide_title_separator_with_custom_icon_position","both","Position","Choose position of slider separator", array(
            "top" => "Top",
            "bottom" => "Bottom"
        ));
        $eltd_slide_title_separator_with_custom_icon_container->addChild('eltd_slide_title_separator_with_custom_icon_position', $eltd_slide_title_separator_with_custom_icon_position);

//Slide Subtitle

$eltdSlideSubtitle = new ElatedMetaBox("slides", "Slide Subtitle Style");
$eltdFramework->eltdMetaBoxes->addMetaBox("slides_subtitle",$eltdSlideSubtitle);

    $subtitle_text_group = new ElatedGroup("Subtitle Text Style","Define styles for subtitle text");
    $eltdSlideSubtitle->addChild("subtitle_text_group",$subtitle_text_group);
        $row1 = new ElatedRow();
        $subtitle_text_group->addChild("row1",$row1);
            $subtitle_color = new ElatedMetaField("colorsimple","eltd_slide-subtitle-color","","Font Color","This is some description");
            $row1->addChild("eltd_slide-subtitle-color",$subtitle_color);
            $subtitle_fontsize = new ElatedMetaField("textsimple","eltd_slide-subtitle-font-size","","Font Size (px)","This is some description");
            $row1->addChild("eltd_slide-subtitle-font-size",$subtitle_fontsize);
            $subtitle_lineheight = new ElatedMetaField("textsimple","eltd_slide-subtitle-line-height","","Line Height (px)","This is some description");
            $row1->addChild("eltd_slide-subtitle-line-height",$subtitle_lineheight);
            $subtitle_letterspacing = new ElatedMetaField("textsimple","eltd_slide-subtitle-letter-spacing","","Letter Spacing (px)","This is some description");
            $row1->addChild("eltd_slide-subtitle-letter-spacing",$subtitle_letterspacing);

        $row2 = new ElatedRow(true);
        $subtitle_text_group->addChild("row2",$row2);
            $subtitle_google_fonts = new ElatedMetaField("Fontsimple","eltd_slide-subtitle-font-family","","Font Family","This is some description");
            $row2->addChild("eltd_slide-subtitle-font-family",$subtitle_google_fonts);
            $subtitle_fontstyle = new ElatedMetaField("selectblanksimple","eltd_slide-subtitle-font-style","","Font Style","This is some description",$eltd_options_fontstyle);
            $row2->addChild("eltd_slide-subtitle-font-style",$subtitle_fontstyle);
            $subtitle_fontweight = new ElatedMetaField("selectblanksimple","eltd_slide-subtitle-font-weight","","Font Weight","This is some description",$eltd_options_fontweight);
            $row2->addChild("eltd_slide-subtitle-font-weight",$subtitle_fontweight);
            $subtitle_transform = new ElatedMetaField("selectblanksimple","eltd_slide-subtitle-text-transform","","Text Transform","This is some description",$eltd_options_texttransform);
            $row2->addChild("eltd_slide-subtitle-text-transform",$subtitle_transform);

    $subtitle_background_group = new ElatedGroup("Background","Define background for subtitle");
    $eltdSlideSubtitle->addChild("subtitle_background_group",$subtitle_background_group);
        $row1 = new ElatedRow(true);
        $subtitle_background_group->addChild("row1",$row1);
            $subtitle_background_color = new ElatedMetaField("colorsimple","eltd_slide-subtitle-background-color","","Background Color","This is some description");
            $row1->addChild("eltd_slide-subtitle-background-color",$subtitle_background_color);
            $subtitle_background_color_transparency = new ElatedMetaField("textsimple","eltd_slide-subtitle-bg-color-transparency","","Background Color Transparency (values: 0-1)","This is some description");
            $row1->addChild("eltd_slide-subtitle-bg-color-transparency",$subtitle_background_color_transparency);

    $subtitle_margin_group = new ElatedGroup("Margin Bottom (px)","Enter value for subtitle bottom margin (default value is 14)");
    $eltdSlideSubtitle->addChild("subtitle_margin_group",$subtitle_margin_group);
        $row1 = new ElatedRow(true);
        $subtitle_margin_group->addChild("row1",$row1);
            $subtitle_margin_bottom = new ElatedMetaField("textsimple","eltd_slide_subtitle_margin_bottom","","","This is some description");
            $row1->addChild("eltd_slide_subtitle_margin_bottom",$subtitle_margin_bottom);

    $subtitle_padding_group = new ElatedGroup("Padding","Define padding for subtitle");
    $eltdSlideSubtitle->addChild("subtitle_padding_group",$subtitle_padding_group);
        $row1 = new ElatedRow(true);
        $subtitle_padding_group->addChild("row1",$row1);
            $subtitle_padding_top = new ElatedMetaField("textsimple","eltd_slide_subtitle_padding_top","","Top Padding (px)","This is some description");
            $row1->addChild("eltd_slide_subtitle_padding_top",$subtitle_padding_top);
            $subtitle_padding_right = new ElatedMetaField("textsimple","eltd_slide_subtitle_padding_right","","Right Padding (px)","This is some description");
            $row1->addChild("eltd_slide_subtitle_padding_right",$subtitle_padding_right);
            $subtitle_padding_bottom = new ElatedMetaField("textsimple","eltd_slide_subtitle_padding_bottom","","Bottom Padding (px)","This is some description");
            $row1->addChild("eltd_slide_subtitle_padding_bottom",$subtitle_padding_bottom);
            $subtitle_padding_left = new ElatedMetaField("textsimple","eltd_slide_subtitle_padding_left","","Left Padding (px)","This is some description");
            $row1->addChild("eltd_slide_subtitle_padding_left",$subtitle_padding_left);

//Slide Text

$eltdSlideText = new ElatedMetaBox("slides", "Slide Text Style");
$eltdFramework->eltdMetaBoxes->addMetaBox("slides_text",$eltdSlideText);

    $text_common_text_group = new ElatedGroup('Text Color and Size', 'Define text color and size');
    $eltdSlideText->addChild('text_common_text_group', $text_common_text_group);

        $row1 = new ElatedRow();
        $text_common_text_group->addChild('row1', $row1);

            $text_color = new ElatedMetaField("colorsimple","eltd_slide-text-color","","Font Color","This is some description");
            $row1->addChild("eltd_slide-text-color",$text_color);
            $text_background_color = new ElatedMetaField("colorsimple","eltd_slide-text-background-color","","Background Color","This is some description");
            $row1->addChild("eltd_slide-text-background-color",$text_background_color);
            $text_fontsize = new ElatedMetaField("textsimple","eltd_slide-text-font-size","","Font Size (px)","This is some description");
            $row1->addChild("eltd_slide-text-font-size",$text_fontsize);
            $text_lineheight = new ElatedMetaField("textsimple","eltd_slide-text-line-height","","Line Height (px)","This is some description");
            $row1->addChild("eltd_slide-text-line-height",$text_lineheight);

    $text_separator_text = new ElatedMetaField('yesno', 'text_separator_text', 'no', 'Separator Around Text', 'Do you want to have a separator around text', array(), array(
        'dependence' => true,
        'dependence_hide_on_yes' => '#eltdf_text_without_separator_container',
        'dependence_show_on_yes' => '#eltdf_text_with_separator_container'
    ));
    $eltdSlideText->addChild('text_separator_text', $text_separator_text);

    $text_without_separator_container = new ElatedContainerNoStyle('text_without_separator_container', 'text_separator_text', 'yes');
    $eltdSlideText->addChild('text_without_separator_container', $text_without_separator_container);

        $text_without_separator_padding_group = new ElatedGroup("Padding","Define padding for text");
        $text_without_separator_container->addChild("text_without_separator_padding_group",$text_without_separator_padding_group);

            $row1 = new ElatedRow(true);
            $text_without_separator_padding_group->addChild("row1",$row1);

                $text_padding_top = new ElatedMetaField("textsimple","eltd_slide_text_padding_top","","Top Padding (px)","This is some description");
                $row1->addChild("eltd_slide_text_padding_top",$text_padding_top);
                $text_padding_right = new ElatedMetaField("textsimple","eltd_slide_text_padding_right","","Right Padding (px)","This is some description");
                $row1->addChild("eltd_slide_text_padding_right",$text_padding_right);
                $text_padding_bottom = new ElatedMetaField("textsimple","eltd_slide_text_padding_bottom","","Bottom Padding (px)","This is some description");
                $row1->addChild("eltd_slide_text_padding_bottom",$text_padding_bottom);
                $text_padding_left = new ElatedMetaField("textsimple","eltd_slide_text_padding_left","","Left Padding (px)","This is some description");
                $row1->addChild("eltd_slide_text_padding_left",$text_padding_left);

        $text_without_separator_text_group = new ElatedGroup("Text Text Style","Define styles for text text");
        $text_without_separator_container->addChild("text_without_separator_text_group",$text_without_separator_text_group);

            $row1 = new ElatedRow();
            $text_without_separator_text_group->addChild("row1",$row1);

                $text_letterspacing = new ElatedMetaField("textsimple","eltd_slide-text-letter-spacing","","Letter Spacing (px)","This is some description");
                $row1->addChild("eltd_slide-text-letter-spacing",$text_letterspacing);

            $row2 = new ElatedRow(true);
            $text_without_separator_text_group->addChild("row2",$row2);

                $text_google_fonts = new ElatedMetaField("Fontsimple","eltd_slide-text-font-family","","Font Family","This is some description");
                $row2->addChild("eltd_slide-text-font-family",$text_google_fonts);
                $text_fontstyle = new ElatedMetaField("selectblanksimple","eltd_slide-text-font-style","","Font Style","This is some description",$eltd_options_fontstyle);
                $row2->addChild("eltd_slide-text-font-style",$text_fontstyle);
                $text_fontweight = new ElatedMetaField("selectblanksimple","eltd_slide-text-font-weight","","Font Weight","This is some description",$eltd_options_fontweight);
                $row2->addChild("eltd_slide-text-font-weight",$text_fontweight);
                $text_transform = new ElatedMetaField("selectblanksimple","eltd_slide-text-text-transform","","Text Transform","This is some description",$eltd_options_texttransform);
                $row2->addChild("eltd_slide-text-text-transform",$text_transform);

        $text_without_separator_background_group = new ElatedGroup("Background","Define background for text");
        $text_without_separator_container->addChild("text_without_separator_background_group",$text_without_separator_background_group);

            $row1 = new ElatedRow(true);
            $text_without_separator_background_group->addChild("row1",$row1);

                $text_background_color_transparency = new ElatedMetaField("textsimple","eltd_slide-text-bg-color-transparency","","Background Color Transparency (values 0-1)","This is some description");
                $row1->addChild("eltd_slide-text-bg-color-transparency",$text_background_color_transparency);

    $text_with_separator_container = new ElatedContainer('text_with_separator_container', 'text_separator_text', 'no');
    $eltdSlideText->addChild('text_with_separator_container', $text_with_separator_container);

        $text_with_separator_border_styles = new ElatedGroup('Separator Line Style', 'Define separator line style');
        $text_with_separator_container->addChild('text_with_separator_border_styles', $text_with_separator_border_styles);

            $row1 = new ElatedRow();
            $text_with_separator_border_styles->addChild('row1', $row1);

                $eltd_separator_line_border_style = new ElatedMetaField('selectsimple', 'eltd_separator_line_border_style', 'solid', 'Line Border Style', '', array(
                    'solid' => 'Solid',
                    'dashed' => 'Dashed',
                    'dotted' => 'Dotted',
                    'transparent' => 'Transparent'
                ));
                $row1->addChild('eltd_separator_line_border_style', $eltd_separator_line_border_style);

                $eltd_separator_line_width = new ElatedMetaField('textsimple', 'eltd_separator_line_width', '', 'Line Width (px)', '');
                $row1->addChild('eltd_separator_line_width', $eltd_separator_line_width);

                $eltd_separator_line_thickness = new ElatedMetaField('textsimple', 'eltd_separator_line_thickness', '', 'Line Thickness (px)', '');
                $row1->addChild('eltd_separator_line_thickness', $eltd_separator_line_thickness);

                $eltd_separator_line_color = new ElatedMetaField('colorsimple', 'eltd_separator_line_color', '', 'Line Color', '');
                $row1->addChild('eltd_separator_line_color', $eltd_separator_line_color);

        $text_with_separator_boxed = new ElatedGroup('Boxed Text', 'Add box around text');
        $text_with_separator_container->addChild('text_with_separator_boxed', $text_with_separator_boxed);

            $row1 = new ElatedRow();
            $text_with_separator_boxed->addChild('row1', $row1);

                $eltd_separator_text_in_box = new ElatedMetaField('selectsimple', 'eltd_separator_text_in_box', 'no', 'Text in Box', '', array(
                    'yes' => 'Yes',
                    'no' => 'No'
                ));
                $row1->addChild('eltd_separator_text_in_box', $eltd_separator_text_in_box);

                $eltd_separator_box_border_style = new ElatedMetaField('selectsimple', 'eltd_separator_box_border_style', 'solid', 'Box Border Style', '', array(
                    'solid' => 'Solid',
                    'dashed' => 'Dashed',
                    'dotted' => 'Dotted',
                    'transparent' => 'Transparent'
                ));
                $row1->addChild('eltd_separator_box_border_style', $eltd_separator_box_border_style);

                $eltd_separator_box_border_width = new ElatedMetaField('textsimple', 'eltd_separator_box_border_width', '', 'Box Border Width (px)', '');
                $row1->addChild('eltd_separator_box_border_width', $eltd_separator_box_border_width);

                $eltd_separator_box_border_radius = new ElatedMetaField('textsimple', 'eltd_separator_box_border_radius', '', 'Box Border Radius (px)', '');
                $row1->addChild('eltd_separator_box_border_radius', $eltd_separator_box_border_radius);

            $row2 = new ElatedRow(true);
            $text_with_separator_boxed->addChild('row2', $row2);

                $eltd_separator_box_border_color = new ElatedMetaField('colorsimple', 'eltd_separator_box_border_color', '', 'Box Border Color', '');
                $row2->addChild('eltd_separator_box_border_color', $eltd_separator_box_border_color);

        $text_with_separator_position = new ElatedGroup('Text Position', 'Define position of text');
        $text_with_separator_container->addChild('text_with_separator_position', $text_with_separator_position);

            $row1 = new ElatedRow();
            $text_with_separator_position->addChild('row1', $row1);

                $eltd_separator_text_position = new ElatedMetaField('selectsimple', 'eltd_separator_text_position', 'center', 'Text position', '', array(
                    'center' => 'Center',
                    'left' => 'Left',
                    'right' => 'Right'
                ));
                $row1->addChild('eltd_separator_text_position', $eltd_separator_text_position);

                $eltd_separator_text_leftright_padding = new ElatedMetaField('textsimple', 'eltd_separator_text_leftright_padding', '', 'Left/Right Text padding (px)', '');
                $row1->addChild('eltd_separator_text_leftright_padding', $eltd_separator_text_leftright_padding);

                $eltd_separator_text_top_margin = new ElatedMetaField('textsimple', 'eltd_separator_text_top_margin', '', 'Top Margin (px)', '');
                $row1->addChild('eltd_separator_text_top_margin', $eltd_separator_text_top_margin);

                $eltd_separator_text_bottom_margin = new ElatedMetaField('textsimple', 'eltd_separator_text_bottom_margin', '', 'Bottom Margin (px)', '');
                $row1->addChild('eltd_separator_text_bottom_margin', $eltd_separator_text_bottom_margin);

            $row2= new ElatedRow(true);
            $text_with_separator_position->addChild('row2', $row2);

                $eltd_separator_box_margin = new ElatedMetaField('textsimple', 'eltd_separator_box_margin', '', 'Box Margins Left/Right (px)', '');
                $row2->addChild('eltd_separator_box_margin', $eltd_separator_box_margin);

        $text_with_separator_linedots = new ElatedGroup('Dots on Line End', 'Add dots on line end');
        $text_with_separator_container->addChild('text_with_separator_linedots', $text_with_separator_linedots);

            $row1 = new ElatedRow();
            $text_with_separator_linedots->addChild('row1', $row1);

                $eltd_separator_linedots = new ElatedMetaField('selectsimple', 'eltd_separator_linedots', 'no', 'Dots on line end', '', array(
                    'no' => 'No',
                    'yes' => 'Yes',
                ));
                $row1->addChild('eltd_separator_linedots', $eltd_separator_linedots);

                $eltd_separator_line_dots_size = new ElatedMetaField('textsimple', 'eltd_separator_line_dots_size', '', 'Dots Size (px)', '');
                $row1->addChild('eltd_separator_line_dots_size', $eltd_separator_line_dots_size);

                $eltd_separator_dots_color = new ElatedMetaField('colorsimple', 'eltd_separator_dots_color', '', 'Dots Color', '');
                $row1->addChild('eltd_separator_dots_color', $eltd_separator_dots_color);


//Slide Buttons
//Button 1
$eltdSlideButtons = new ElatedMetaBox("slides", "Slide Buttons Style");
$eltdFramework->eltdMetaBoxes->addMetaBox("slides_buttons",$eltdSlideButtons);

$button1_section = new ElatedTitle("button1_section", "Button 1");
$eltdSlideButtons->addChild("button1_section", $button1_section);

$button1_group2 = new ElatedGroup("Text Style","Define text style");
$eltdSlideButtons->addChild("button1_group2",$button1_group2);

        $row1 = new ElatedRow();
        $button1_group2->addChild("row1",$row1);
            $button1_font_family = new ElatedMetaField("Fontsimple","eltd_slide-button_font_family","-1","Font Family","This is some description");
            $row1->addChild("eltd_slide-button_font_family",$button1_font_family);
            $button1_font_size = new ElatedMetaField("textsimple","eltd_slide-button_font_size","","Text Size(px)","This is some description");
            $row1->addChild("eltd_slide-button_font_size",$button1_font_size);
            $button1_font_style = new ElatedMetaField("selectblanksimple","eltd_slide-button_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
            $row1->addChild("eltd_slide-button_font_style",$button1_font_style);
            $button1_font_weight = new ElatedMetaField("selectblanksimple","eltd_slide-button_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
            $row1->addChild("eltd_slide-button_font_weight",$button1_font_weight);

        $row2 = new ElatedRow();
        $button1_group2->addChild("row2",$row2);

            $button1_letter_spacing= new ElatedMetaField("textsimple","eltd_slide-button_letter_spacing","","Letter Spacing(px)","This is some description");
            $row2->addChild("eltd_slide-button_letter_spacing",$button1_letter_spacing);

            $button1_line_height = new ElatedMetaField("textsimple","eltd_slide-button_line_height","","Line Height (px)","This is some description");
            $row2->addChild("eltd_slide-button_line_height",$button1_line_height);

            $button1_text_color = new ElatedMetaField("colorsimple","eltd_slide-button_text_color","","Text Color","This is some description");
            $row2->addChild("eltd_slide-button_text_color",$button1_text_color);

            $button1_text_hover_color = new ElatedMetaField("colorsimple","eltd_slide-button_text_hover_color","","Text Hover Color","This is some description");
            $row2->addChild("eltd_slide-button_text_hover_color",$button1_text_hover_color);

        $row3 = new ElatedRow();
        $button1_group2->addChild("row3",$row3);

            $button1_text_align = new ElatedMetaField("selectblanksimple","eltd_slide-button_text_align","","Text Align","This is some description", array(
                "left" => "Left",
                "center" => "Center",
                "right" => "Right"
            ));
            $row3->addChild("eltd_slide-button_text_align",$button1_text_align);
            $button1_text_transform = new ElatedMetaField("selectblanksimple","eltd_slide-button_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
            $row3->addChild("eltd_slide-button_text_transform",$button1_text_transform);

    $button1_group3 = new ElatedGroup("Background","Define background");
    $eltdSlideButtons->addChild("button1_group3",$button1_group3);

            $row1 = new ElatedRow();
            $button1_group3->addChild("row1",$row1);

                $button1_background_color = new ElatedMetaField("colorsimple","eltd_slide-button_background_color","","Background Color","This is some description");
                $row1->addChild("eltd_slide-button_background_color",$button1_background_color);

                $button1_background_hover_color = new ElatedMetaField("colorsimple","eltd_slide-button_background_hover_color","","Background Hover Color","This is some description");
                $row1->addChild("eltd_slide-button_background_hover_color",$button1_background_hover_color);

    $button1_group4 = new ElatedGroup("Size","Define button size");
    $eltdSlideButtons->addChild("button1_group4",$button1_group4);

        $row1 = new ElatedRow();
        $button1_group4->addChild("row1",$row1);

            $button1_width = new ElatedMetaField("textsimple","eltd_slide-button_width","","Width (px)","This is some description");
            $row1->addChild("eltd_slide-button_width",$button1_width);

            $button1_height = new ElatedMetaField("textsimple","eltd_slide-button_height","","Height (px)","This is some description");
            $row1->addChild("eltd_slide-button_height",$button1_height);

    $button1_group5 = new ElatedGroup("Border","Define border style");
    $eltdSlideButtons->addChild("button1_group5",$button1_group5);

        $row1 = new ElatedRow();
        $button1_group5->addChild("row1",$row1);

            $button1_border_width = new ElatedMetaField("textsimple","eltd_slide-button_border_width","","Border Width (px)","This is some description");
            $row1->addChild("eltd_slide-button_border_width",$button1_border_width);

            $button1_border_radius = new ElatedMetaField("textsimple","eltd_slide-button_border_radius","","Border Radius (px)","This is some description");
            $row1->addChild("eltd_slide-button_border_radius",$button1_border_radius);

            $button1_border_color = new ElatedMetaField("colorsimple","eltd_slide-button_border_color","","Border Color","This is some description");
            $row1->addChild("eltd_slide-button_border_color",$button1_border_color);

            $button1_border_hover_color = new ElatedMetaField("colorsimple","eltd_slide-button_border_hover_color","","Border Hover Color","This is some description");
            $row1->addChild("eltd_slide-button_border_hover_color",$button1_border_hover_color);

            $button1_margin = new ElatedMetaField("text","eltd_slide-button_margin1","","Margin (px)","Please insert margin in format (top right bottom left) i.e. 5px 5px 5px 5px",array(), array("col_width" => 3));
            $eltdSlideButtons->addChild("eltd_slide-button_margin1",$button1_margin);

    $button1_group6 = new ElatedGroup("Padding","Define left/right padding for button (px)");
    $eltdSlideButtons->addChild("button1_group6",$button1_group6);

        $row1 = new ElatedRow(true);
        $button1_group6->addChild("row1",$row1);

        $button1_padding = new ElatedMetaField("textsimple","eltd_slide-button_padding","","","This is some description");
        $row1->addChild("eltd_slide-button_padding",$button1_padding);

    //init icon pack hide and show array. It will be populated dinamically from collections array
    $button1_icon_pack_hide_array = array();
    $button1_icon_pack_show_array = array();

    //do we have some collection added in collections array?
    if(is_array($eltdIconCollections->iconCollections) && count($eltdIconCollections->iconCollections)) {
        //get collections params array. It will contain values of 'param' property for each collection
        $button1_icon_collections_params = $eltdIconCollections->getIconCollectionsParams();

        //foreach collection generate hide and show array
        foreach ($eltdIconCollections->iconCollections as $dep_collection_key => $dep_collection_object) {
            $button1_icon_pack_hide_array[$dep_collection_key] = '';
            $button1_icon_pack_hide_array["no_icon"] = "";

            //we need to include only current collection in show string as it is the only one that needs to show
            $button1_icon_pack_show_array[$dep_collection_key] = '#eltdf_button1_icon_'.$dep_collection_object->param.'_container';

            //for all collections param generate hide string
            foreach ($button1_icon_collections_params as $button1_icon_collections_param) {
                //we don't need to include current one, because it needs to be shown, not hidden
                if($button1_icon_collections_param !== $dep_collection_object->param) {
                    $button1_icon_pack_hide_array[$dep_collection_key].= '#eltdf_button1_icon_'.$button1_icon_collections_param.'_container,';
                }

                $button1_icon_pack_hide_array["no_icon"] .= '#eltdf_button1_icon_'.$button1_icon_collections_param.'_container,';
            }

            //remove remaining ',' character
            $button1_icon_pack_hide_array[$dep_collection_key] = rtrim($button1_icon_pack_hide_array[$dep_collection_key], ',');
            $button1_icon_pack_hide_array["no_icon"] = rtrim($button1_icon_pack_hide_array["no_icon"], ',');
        }

    }

    $button1_icon_pack = new ElatedMetaField(
        "select",
        "button1_icon_pack",
        "no_icon",
        "Button 1 Icon Pack",
        "Choose icon pack for first button",
        $eltdIconCollections->getIconCollectionsEmpty("no_icon"),
        array(
            "dependence" => true,
            "hide" => $button1_icon_pack_hide_array,
            "show" => $button1_icon_pack_show_array
        ));

    $eltdSlideButtons->addChild("button1_icon_pack", $button1_icon_pack);

    if(is_array($eltdIconCollections->iconCollections) && count($eltdIconCollections->iconCollections)) {
        //foreach icon collection we need to generate separate container that will have dependency set
        //it will have one field inside with icons dropdown
        foreach ($eltdIconCollections->iconCollections as $collection_key => $collection_object) {
            $icons_array = $collection_object->getIconsArray();

            //get icon collection keys (keys from collections array, e.g 'font_awesome', 'font_elegant' etc.)
            $icon_collections_keys = $eltdIconCollections->getIconCollectionsKeys();

            //unset current one, because it doesn't have to be included in dependency that hides icon container
            unset($icon_collections_keys[array_search($collection_key, $icon_collections_keys)]);

            $button1_icon_hide_values = $icon_collections_keys;
            $button1_icon_hide_values[] = "no_icon";
            $button1_icon_container = new ElatedContainer("button1_icon_".$collection_object->param."_container", "button1_icon_pack", "", $button1_icon_hide_values);
            $button1_icon = new ElatedMetaField("select", "button1_icon_".$collection_object->param, "", "Button 1 Icon","Choose First Button Icon", $icons_array, array("col_width" => 3));
            $button1_icon_container->addChild("button1_icon_".$collection_object->param, $button1_icon);

            $eltdSlideButtons->addChild("button1_icon_".$collection_object->param."_container", $button1_icon_container);
        }

    }

//Button 2
    $button2_section = new ElatedTitle("button2_section", "Button 2");
    $eltdSlideButtons->addChild("button2_section", $button2_section);

        $button2_group2 = new ElatedGroup("Text Style","Define text style");
        $eltdSlideButtons->addChild("button2_group2",$button2_group2);
            $row1 = new ElatedRow();
            $button2_group2->addChild("row1",$row1);

                $button2_font_family = new ElatedMetaField("Fontsimple","eltd_slide-button_font_family2","-1","Font Family","This is some description");
                $row1->addChild("eltd_slide-button_font_family2",$button2_font_family);
                $button2_font_size = new ElatedMetaField("textsimple","eltd_slide-button_font_size2","","Font Size (px)","This is some description");
                $row1->addChild("eltd_slide-button_font_size2",$button2_font_size);
                $button2_font_style = new ElatedMetaField("selectblanksimple","eltd_slide-button_font_style2","","Font Style","This is some description",$eltd_options_fontstyle);
                $row1->addChild("eltd_slide-button_font_style2",$button2_font_style);
                $button2_font_weight = new ElatedMetaField("selectblanksimple","eltd_slide-button_font_weight2","","Font Weight","This is some description",$eltd_options_fontweight);
                $row1->addChild("eltd_slide-button_font_weight2",$button2_font_weight);

            $row2 = new ElatedRow();
            $button2_group2->addChild("row2",$row2);
                $button2_letter_spacing= new ElatedMetaField("textsimple","eltd_slide-button_letter_spacing2","","Letter Spacing(px)","This is some description");
                $row2->addChild("eltd_slide-button_letter_spacing2",$button2_letter_spacing);
                $button2_line_height = new ElatedMetaField("textsimple","eltd_slide-button_line_height2","","Line Height (px)","This is some description");
                $row2->addChild("eltd_slide-button_line_height2",$button2_line_height);
                $button2_text_color = new ElatedMetaField("colorsimple","eltd_slide-button_text_color2","","Text Color","This is some description");
                $row2->addChild("eltd_slide-button_text_color2",$button2_text_color);
                $button2_text_hover_color = new ElatedMetaField("colorsimple","eltd_slide-button_text_hover_color2","","Text Hover Color","This is some description");
                $row2->addChild("eltd_slide-button_text_hover_color2",$button2_text_hover_color);

            $row3 = new ElatedRow();
            $button2_group2->addChild("row3",$row3);
                $button2_text_align = new ElatedMetaField("selectblanksimple","eltd_slide-button_text_align2","","Text Align","This is some description", array(
                    "left" => "Left",
                    "center" => "Center",
                    "right" => "Right"
                ));
                $row3->addChild("eltd_slide-button_text_align2",$button2_text_align);
                $button2_text_transform = new ElatedMetaField("selectblanksimple","eltd_slide-button_text_transform2","","Text Transform","This is some description",$eltd_options_texttransform);
                $row3->addChild("eltd_slide-button_text_transform2",$button2_text_transform);

        $button2_group3 = new ElatedGroup("Background","Define background");
        $eltdSlideButtons->addChild("button2_group3",$button2_group3);
            $row4 = new ElatedRow();
        $button2_group3->addChild("row4",$row4);
                $button2_background_color = new ElatedMetaField("colorsimple","eltd_slide-button_background_color2","","Background Color","This is some description");
                $row4->addChild("eltd_slide-button_background_color2",$button2_background_color);
                $button2_background_hover_color = new ElatedMetaField("colorsimple","eltd_slide-button_background_hover_color2","","Background Hover Color","This is some description");
                $row4->addChild("eltd_slide-button_background_hover_color2",$button2_background_hover_color);

        $button2_group4 = new ElatedGroup("Size","Define button size");
        $eltdSlideButtons->addChild("button2_group4",$button2_group4);
            $row1 = new ElatedRow();
            $button2_group4->addChild("row1",$row1);
                $button2_width = new ElatedMetaField("textsimple","eltd_slide-button_width2","","Width (px)","This is some description");
                $row1->addChild("eltd_slide-button_width2",$button2_width);
                $button2_height = new ElatedMetaField("textsimple","eltd_slide-button_height2","","Height (px)","This is some description");
                $row1->addChild("eltd_slide-button_height2",$button2_height);

        $button2_group5 = new ElatedGroup("Border","Define border style");
        $eltdSlideButtons->addChild("button2_group5",$button2_group5);
            $row1 = new ElatedRow();
            $button2_group5->addChild("row1",$row1);
                $button2_border_width = new ElatedMetaField("textsimple","eltd_slide-button_border_width2","","Border Width (px)","This is some description");
                $row1->addChild("eltd_slide-button_border_width2",$button2_border_width);
                $button2_border_radius = new ElatedMetaField("textsimple","eltd_slide-button_border_radius2","","Border Radius (px)","This is some description");
                $row1->addChild("eltd_slide-button_border_radius2",$button2_border_radius);
                $button2_border_color = new ElatedMetaField("colorsimple","eltd_slide-button_border_color2","","Border Color","This is some description");
                $row1->addChild("eltd_slide-button_border_color2",$button2_border_color);
                $button2_border_hover_color = new ElatedMetaField("colorsimple","eltd_slide-button_border_hover_color2","","Border Hover Color","This is some description");
                $row1->addChild("eltd_slide-button_border_hover_color2",$button2_border_hover_color);

        $button2_margin = new ElatedMetaField("text","eltd_slide-button_margin2","","Margin (px)","Please insert margin in format (top right bottom left) i.e. 5px 5px 5px 5px", array(), array("col_width" => 3));
        $eltdSlideButtons->addChild("eltd_slide-button_margin2",$button2_margin);

        $button2_group6 = new ElatedGroup("Padding","Define left/right padding for button (px)");
        $eltdSlideButtons->addChild("button2_group6",$button2_group6);

            $row1 = new ElatedRow(true);
            $button2_group6->addChild("row1",$row1);

            $button2_padding = new ElatedMetaField("textsimple","eltd_slide-button_padding2","","","This is some description");
            $row1->addChild("eltd_slide-button_padding2",$button2_padding);

    //init icon pack hide and show array. It will be populated dinamically from collections array
    $button2_icon_pack_hide_array = array();
    $button2_icon_pack_show_array = array();
    
    //do we have some collection added in collections array?
    if(is_array($eltdIconCollections->iconCollections) && count($eltdIconCollections->iconCollections)) {
        //get collections params array. It will contain values of 'param' property for each collection
        $button2_icon_collections_params = $eltdIconCollections->getIconCollectionsParams();
    
        //foreach collection generate hide and show array
        foreach ($eltdIconCollections->iconCollections as $dep_collection_key => $dep_collection_object) {
            $button2_icon_pack_hide_array[$dep_collection_key] = '';
            $button2_icon_pack_hide_array["no_icon"] = "";
    
            //we need to include only current collection in show string as it is the only one that needs to show
            $button2_icon_pack_show_array[$dep_collection_key] = '#eltdf_button2_icon_'.$dep_collection_object->param.'_container';
    
            //for all collections param generate hide string
            foreach ($button2_icon_collections_params as $button2_icon_collections_param) {
                //we don't need to include current one, because it needs to be shown, not hidden
                if($button2_icon_collections_param !== $dep_collection_object->param) {
                    $button2_icon_pack_hide_array[$dep_collection_key].= '#eltdf_button2_icon_'.$button2_icon_collections_param.'_container,';
                }
    
                $button2_icon_pack_hide_array["no_icon"] .= '#eltdf_button2_icon_'.$button2_icon_collections_param.'_container,';
            }
    
            //remove remaining ',' character
            $button2_icon_pack_hide_array[$dep_collection_key] = rtrim($button2_icon_pack_hide_array[$dep_collection_key], ',');
            $button2_icon_pack_hide_array["no_icon"] = rtrim($button2_icon_pack_hide_array["no_icon"], ',');
        }
    
    }
    
    $button2_icon_pack = new ElatedMetaField(
        "select",
        "button2_icon_pack",
        "no_icon",
        "Button 2 Icon Pack",
        "Choose icon pack for first button",
        $eltdIconCollections->getIconCollectionsEmpty("no_icon"),
        array(
            "dependence" => true,
            "hide" => $button2_icon_pack_hide_array,
            "show" => $button2_icon_pack_show_array
        ));
    
    $eltdSlideButtons->addChild("button2_icon_pack", $button2_icon_pack);
    
    if(is_array($eltdIconCollections->iconCollections) && count($eltdIconCollections->iconCollections)) {
        //foreach icon collection we need to generate separate container that will have dependency set
        //it will have one field inside with icons dropdown
        foreach ($eltdIconCollections->iconCollections as $collection_key => $collection_object) {
            $icons_array = $collection_object->getIconsArray();
    
            //get icon collection keys (keys from collections array, e.g 'font_awesome', 'font_elegant' etc.)
            $icon_collections_keys = $eltdIconCollections->getIconCollectionsKeys();
    
            //unset current one, because it doesn't have to be included in dependency that hides icon container
            unset($icon_collections_keys[array_search($collection_key, $icon_collections_keys)]);
    
            $button2_icon_hide_values = $icon_collections_keys;
            $button2_icon_hide_values[] = "no_icon";
            $button2_icon_container = new ElatedContainer("button2_icon_".$collection_object->param."_container", "button2_icon_pack", "", $button2_icon_hide_values);
            $button2_icon = new ElatedMetaField("select", "button2_icon_".$collection_object->param, "", "Button 2 Icon","Choose First Button Icon", $icons_array, array("col_width" => 3));
            $button2_icon_container->addChild("button2_icon_".$collection_object->param, $button2_icon);
    
            $eltdSlideButtons->addChild("button2_icon_".$collection_object->param."_container", $button2_icon_container);
        }
    
    }

//Slide Content Positioning

$eltdSlideContentPositioning = new ElatedMetaBox("slides", "Slide Content Positioning");
$eltdFramework->eltdMetaBoxes->addMetaBox("slides_content_positioning",$eltdSlideContentPositioning);
	
	$eltd_slide_predefined_content_position = new ElatedMetaField("selectblank","eltd_slide_predefined_content_position","","Predefined content position","Choose position of slide content", array(
	    "" => "",
		"content_bottom_left" => "Bottom Left",
		"content_bottom_right" => "Bottom Right"
	),
	array("dependence" => true,
      	"hide" => array(
      		""=>"#eltdf_eltd_slide_predefined_content_position_width_container",
			"content_bottom_left" => "#eltdf_eltd_slide_predefined_content_position_container",
			"content_bottom_right" => "#eltdf_eltd_slide_predefined_content_position_container"),
      	"show" => array(
      		""=>"#eltdf_eltd_slide_predefined_content_position_container",
			"content_bottom_left" => "#eltdf_eltd_slide_predefined_content_position_width_container",
			"content_bottom_right" => "#eltdf_eltd_slide_predefined_content_position_width_container")
	));
	$eltdSlideContentPositioning->addChild("eltd_slide_predefined_content_position",$eltd_slide_predefined_content_position);
	
	$eltd_slide_predefined_content_position_width_container = new ElatedContainerNoStyle("eltd_slide_predefined_content_position_width_container","eltd_slide_predefined_content_position","");
    $eltdSlideContentPositioning->addChild("eltd_slide_predefined_content_position_width_container",$eltd_slide_predefined_content_position_width_container);
	
		$eltd_slide_predefined_content_position_width = new ElatedMetaField("text","eltd_slide_predefined_content_position_width","","Content Width","Enter Width for Content Area (px)",array(), array("col_width" => 3));
		$eltd_slide_predefined_content_position_width_container->addChild("eltd_slide_predefined_content_position_width",$eltd_slide_predefined_content_position_width);
	
	$eltd_slide_predefined_content_position_container = new ElatedContainerNoStyle("eltd_slide_predefined_content_position_container","eltd_slide_predefined_content_position","content_bottom_left",array( "content_bottom_left","content_bottom_right"));
    $eltdSlideContentPositioning->addChild("eltd_slide_predefined_content_position_container",$eltd_slide_predefined_content_position_container);
	
		$eltd_slide_text_alignment = new ElatedMetaField("selectblank","eltd_slide-content-alignment","","Text Alignment","Choose an alignment for the slide text", array(
			"left" => "Left",
			"center" => "Center",
			"right" => "Right"
		));
		$eltd_slide_predefined_content_position_container->addChild("eltd_slide-content-alignment",$eltd_slide_text_alignment);
		
		$eltd_slide_separate_text_graphic = new ElatedMetaField("selectblank","eltd_slide-separate-text-graphic","no","Separate Graphic and Text Positioning","Do you want to separately position graphic and text?", array(
			"no" => "No",
			"yes" => "Yes"
		), array("dependence" => true,
				 "hide" => array(
					"" => "#eltdf_eltd_slide_graphic_positioning_container, #eltdf_eltd_slide_general_animation_separate_container",
					"no" => "#eltdf_eltd_slide_graphic_positioning_container, #eltdf_eltd_slide_general_animation_separate_container"
				 ),
				 "show" => array(
					 "yes" => "#eltdf_eltd_slide_graphic_positioning_container, #eltdf_eltd_slide_general_animation_separate_container"
				 )));
		$eltd_slide_predefined_content_position_container->addChild("eltd_slide-separate-text-graphic",$eltd_slide_separate_text_graphic);



		$eltd_slide_content_vertical_middle = new ElatedMetaField("yesno","eltd_slide-content-vertical-middle","no","Vertically Align Content to Middle","", array(), array("dependence" => true, "dependence_hide_on_yes" => "#eltdf_eltd_slide-content-vertical-middle-container", "dependence_show_on_yes" => "#eltdf_eltd_slide-content-vertical-middle-type-container"));
		$eltd_slide_predefined_content_position_container->addChild("eltd_slide-content-vertical-middle",$eltd_slide_content_vertical_middle);

		$eltd_slide_content_vertical_middle_type_container = new ElatedContainer("eltd_slide-content-vertical-middle-type-container","eltd_slide-content-vertical-middle","no");
		$eltd_slide_predefined_content_position_container->addChild("eltd_slide-content-vertical-middle-type-container",$eltd_slide_content_vertical_middle_type_container);

			$eltd_slide_content_vertical_middle_type = new ElatedMetaField("selectblank","eltd_slide-content-vertical-middle-type","","Align Content Vertically Relative to the Height Measured From","", array(
				"bottom_of_header" => "Bottom of Header",
				"window_top" => "Window Top"
			));
			$eltd_slide_content_vertical_middle_type_container->addChild("eltd_slide-content-vertical-middle-type",$eltd_slide_content_vertical_middle_type);


		$eltd_slide_content_vertical_middle_container = new ElatedContainer("eltd_slide-content-vertical-middle-container","eltd_slide-content-vertical-middle","yes");
		$eltd_slide_predefined_content_position_container->addChild("eltd_slide-content-vertical-middle-container",$eltd_slide_content_vertical_middle_container);

			$eltd_slide_content_full_width = new ElatedMetaField("yesno","eltd_slide-content-full-width","no","Content Full Width","Do you want to set slide content to full width?", array(), array("dependence" => true, "dependence_hide_on_yes" => "#eltdf_eltd_slide_content_width_container", "dependence_show_on_yes" => ""));
			$eltd_slide_content_vertical_middle_container->addChild("eltd_slide-content-full-width",$eltd_slide_content_full_width);

			$eltd_slide_content_width_container = new ElatedContainer("eltd_slide_content_width_container","eltd_slide-content-full-width","yes");
			$eltd_slide_content_vertical_middle_container->addChild("eltd_slide_content_width_container",$eltd_slide_content_width_container);

			$eltd_slide_content_width = new ElatedMetaField("text","eltd_slide-content-width","","Content Width","Enter Width for Content Area (%)",array(), array("col_width" => 3));
			$eltd_slide_content_width_container->addChild("eltd_slide-content-width",$eltd_slide_content_width);

			$content_positioning_group = new ElatedGroup("Space Around Content in Slide","Enter values for margins around slide content");
			$eltd_slide_content_vertical_middle_container->addChild("content_positioning_group",$content_positioning_group);
				$row1 = new ElatedRow(true);
				$content_positioning_group->addChild("row1",$row1);
					$eltd_slide_content_top = new ElatedMetaField("textsimple","eltd_slide-content-top","","From Top (%)","This is some description");
					$row1->addChild("eltd_slide-content-top",$eltd_slide_content_top);
					$eltd_slide_content_left = new ElatedMetaField("textsimple","eltd_slide-content-left","","From Left (%)","This is some description");
					$row1->addChild("eltd_slide-content-left",$eltd_slide_content_left);
					$eltd_slide_content_bottom = new ElatedMetaField("textsimple","eltd_slide-content-bottom","","From Bottom (%)","This is some description");
					$row1->addChild("eltd_slide-content-bottom",$eltd_slide_content_bottom);
					$eltd_slide_content_right = new ElatedMetaField("textsimple","eltd_slide-content-right","","From Right (%)","This is some description");
					$row1->addChild("eltd_slide-content-right",$eltd_slide_content_right);


		$eltd_slide_graphic_positioning_container = new ElatedContainer("eltd_slide_graphic_positioning_container","eltd_slide-separate-text-graphic","no");
		$eltd_slide_content_vertical_middle_container->addChild("eltd_slide_graphic_positioning_container",$eltd_slide_graphic_positioning_container);


		$eltd_slide_graphic_alignment = new ElatedMetaField("selectblank","eltd_slide-graphic-alignment","","Graphic Alignment","Choose an alignment for the slide graphic", array(
			"left" => "Left",
			"center" => "Center",
			"right" => "Right"
		));
		$eltd_slide_graphic_positioning_container->addChild("eltd_slide-graphic-alignment",$eltd_slide_graphic_alignment);

		$graphic_positioning_group = new ElatedGroup("Graphic Positioning","Positioning for slide graphic");
		$eltd_slide_graphic_positioning_container->addChild("graphic_positioning_group",$graphic_positioning_group);

		
			$row1 = new ElatedRow();
			$graphic_positioning_group->addChild("row1",$row1);

				$eltd_slide_content_top = new ElatedMetaField("textsimple","eltd_slide-graphic-top","","From Top (%)","This is some description");
				$row1->addChild("eltd_slide-graphic-top",$eltd_slide_content_top);

				$eltd_slide_content_left = new ElatedMetaField("textsimple","eltd_slide-graphic-left","","From Left (%)","This is some description");
				$row1->addChild("eltd_slide-graphic-left",$eltd_slide_content_left);

				$eltd_slide_content_bottom = new ElatedMetaField("textsimple","eltd_slide-graphic-bottom","","From Bottom (%)","This is some description");
				$row1->addChild("eltd_slide-graphic-bottom",$eltd_slide_content_bottom);

				$eltd_slide_content_right = new ElatedMetaField("textsimple","eltd_slide-graphic-right","","From Right (%)","This is some description");
				$row1->addChild("eltd_slide-graphic-right",$eltd_slide_content_right);

			$row2 = new ElatedRow(true);
			$graphic_positioning_group->addChild("row2",$row2);

				$eltd_slide_content_width = new ElatedMetaField("textsimple","eltd_slide-graphic-width","","Width (%)","This is some description");
				$row2->addChild("eltd_slide-graphic-width",$eltd_slide_content_width);

    $eltd_slide_content_padding = new ElatedMetaField("text","eltd_slide-content-text-padding","","Slide Content Text Padding","Define some padding around text (top right bottom left) - Default value is 0px 0px 0px 0px");
    $eltdSlideContentPositioning->addChild("eltd_slide-content-text-padding",$eltd_slide_content_padding);    