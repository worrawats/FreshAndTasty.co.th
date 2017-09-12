<?php
global $eltdFramework;

$pageContent = new ElatedAdminPage("content", "Content", "fa fa-align-justify");
$eltdFramework->eltdOptions->addAdminPage("content",$pageContent);

$panelGeneral = new ElatedPanel("General Settings", "general_settings");
$pageContent->addChild("panel_general", $panelGeneral);

$background_color = new ElatedField("color","background_color","","Content Background Color","Choose the background color for page content area. Default color is #f5f5f5.");
$panelGeneral->addChild("background_color",$background_color);

$background_color_grid = new ElatedField("color","background_color_grid","","Content Background Color for Templates in Grid","Choose the background color for the page templates in grid.");
$panelGeneral->addChild("background_color_grid",$background_color_grid);

$content_top_padding = new ElatedField("text","content_top_padding","0","Content Top Padding (px)","Enter top padding for content area. If you set this value then it's important to set also Content top padding for mobile header value.", array(), array("col_width" => 3));
$panelGeneral->addChild("content_top_padding",$content_top_padding);

$content_top_padding_default_template = new ElatedField("text","content_top_padding_default_template","44","Content Top Padding for Templates in Grid (px)","Enter top padding for content area for Templates in grid. If you set this value then it's important to set also Content top padding for mobile header value.", array(), array("col_width" => 3));
$panelGeneral->addChild("content_top_padding_default_template",$content_top_padding_default_template);

$content_top_padding_mobile = new ElatedField("text","content_top_padding_mobile","44","Content Top Padding for Mobile Header (px)","Enter top padding for content area for Mobile Header.", array(), array("col_width" => 3));
$panelGeneral->addChild("content_top_padding_mobile",$content_top_padding_mobile);

$overlapping_content = new ElatedField("yesno","overlapping_content","no","Enable Overlapping Content","Enabling this option will make content overlap title area or slider for set amount of pixels", array(),
    array("dependence" => true,
        "dependence_hide_on_yes" => "",
        "dependence_show_on_yes" => "#eltdf_overlapping_content_container"));
$panelGeneral->addChild("overlapping_content",$overlapping_content);

$overlapping_content_container = new ElatedContainer("overlapping_content_container","overlapping_content","no");
$panelGeneral->addChild("overlapping_content_container",$overlapping_content_container);

$overlapping_content_amount = new ElatedField("text","overlapping_content_amount","","Overlapping amount (px)","Enter amount of pixels you would like content to overlap title area or slider", array(), array("col_width" => 1));
$overlapping_content_container->addChild("overlapping_content_amount",$overlapping_content_amount);

$overlapping_content_padding = new ElatedField("text","overlapping_content_padding","","Overlapping left/right padding (px)","This option takes effect only on Default (in grid) templates", array(), array("col_width" => 1));
$overlapping_content_container->addChild("overlapping_content_padding",$overlapping_content_padding);

$content_grid_position = new ElatedField("select","content_grid_position","","Position of Content in Grid","Set position of content in grid", array(
    "default" => "Default",
    "left" => "Left",
    "right" => "Right"
));
$panelGeneral->addChild("content_grid_position",$content_grid_position);

$content_predefined_width = new ElatedField("select","content_predefined_width","","Initial Width of Content","Choose the initial width of content which is in grid (Applies to pages set to 'Default Template' and rows set to 'In Grid' )", array(
    "" => "1100px - default",
    "grid_1300" => "1300px",
    "grid_1200" => "1200px",
    "grid_800" => "800px"
));
$panelGeneral->addChild("content_predefined_width",$content_predefined_width);

//Content Bottom Area

$panelContentBottom = new ElatedPanel("Content Bottom Area","content_bottom_area_panel");
$pageContent->addChild("panel_content_bottom",$panelContentBottom);

$enable_content_bottom_area = new ElatedField("yesno","enable_content_bottom_area","no","Enable Content Bottom Area","This option will enable Content Bottom area on pages", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_enable_content_bottom_area_container"));
$panelContentBottom->addChild("enable_content_bottom_area",$enable_content_bottom_area);

$enable_content_bottom_area_container = new ElatedContainer("enable_content_bottom_area_container","enable_content_bottom_area","no");
$panelContentBottom->addChild("enable_content_bottom_area_container",$enable_content_bottom_area_container);

$custom_sidebars = eltd_get_custom_sidebars();

$content_bottom_sidebar_custom_display = new ElatedField("selectblank","content_bottom_sidebar_custom_display","","Sidebar to Display","Choose a Content Bottom sidebar to display", $custom_sidebars);
$enable_content_bottom_area_container->addChild("content_bottom_sidebar_custom_display",$content_bottom_sidebar_custom_display);

$content_bottom_in_grid = new ElatedField("yesno","content_bottom_in_grid","yes","Display in Grid","Enabling this option will place Content Bottom in grid");
$enable_content_bottom_area_container->addChild("content_bottom_in_grid",$content_bottom_in_grid);

$content_bottom_background_color = new ElatedField("color","content_bottom_background_color","","Background Color","Choose a background color for Content Bottom area");
$enable_content_bottom_area_container->addChild("content_bottom_background_color",$content_bottom_background_color);