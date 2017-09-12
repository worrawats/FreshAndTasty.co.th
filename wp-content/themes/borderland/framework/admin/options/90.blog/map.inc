<?php

$blogPage = new ElatedAdminPage("8", "Blog", "fa fa-files-o");
$eltdFramework->eltdOptions->addAdminPage("blogPage",$blogPage);

// Blog Post Lists - General

$panel1 = new ElatedPanel("Blog Lists","post_lists_general_panel");
$blogPage->addChild("panel1",$panel1);

$blog_style = new ElatedField("select","blog_style","1","Archive and Category Layout","Choose a default blog layout for archived Blog Post Lists and Category Blog Lists", array(
	"1"	=> "Blog: Standard",
	"2" => "Blog: Masonry",
	"3" => "Blog: Masonry Full Width",
	"4" => "Blog: Standard Whole Post"
));
$panel1->addChild("blog_style",$blog_style);

$category_blog_sidebar = new ElatedField("select","category_blog_sidebar","default","Archive and Category Sidebar","Choose a sidebar layout for archived Blog Post Lists and Category Blog Lists", array(
	"default" => "No Sidebar",
	"1" => "Sidebar 1/3 right",
	"2" => "Sidebar 1/4 right",
	"3" => "Sidebar 1/3 left",
	"4" => "Sidebar 1/4 left"
));
$panel1->addChild("category_blog_sidebar",$category_blog_sidebar);

$pagination = new ElatedField("yesno","pagination","yes","Pagination","Enabling this option will display pagination links on bottom of Blog Post List", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_hide_pagination_list_container"));
$panel1->addChild("pagination",$pagination);

$blog_hide_pagination_list_container = new ElatedContainer("blog_hide_pagination_list_container","pagination","");
$panel1->addChild("blog_hide_pagination_list_container",$blog_hide_pagination_list_container);

$blog_pagination_type = new ElatedField("select","blog_pagination_type","standard","Pagination type","Choose type of pagination",array(
	"standard" => "Standard",
	"prev_and_next" => "Only Previous and Next"
	),array(
	"dependence" => true,
	"hide" => array("prev_and_next" => "#eltdf_blog_page_range_container", "standard" => "#eltdf_blog_pagination_text_container"),
	"show" => array("standard" => "#eltdf_blog_page_range_container", "prev_and_next" => "#eltdf_blog_pagination_text_container")
	));
$blog_hide_pagination_list_container->addChild("blog_pagination_type",$blog_pagination_type);

$blog_page_range_container = new ElatedContainer("blog_page_range_container","blog_pagination_type","prev_and_next");
$blog_hide_pagination_list_container->addChild("blog_page_range_container",$blog_page_range_container);

	$blog_page_range = new ElatedField("text","blog_page_range","","Pagination Range limit","Enter a number that will limit pagination to a certain range of links",array(), array("col_width" => 3));
	$blog_page_range_container->addChild("blog_page_range",$blog_page_range);

$blog_pagination_text_container = new ElatedContainer("blog_pagination_text_container","blog_pagination_type","standard");
$blog_hide_pagination_list_container->addChild("blog_pagination_text_container",$blog_pagination_text_container);

	$group17 = new ElatedGroup("Labels for Buttons","Enter labels you want for Previous and Next buttons (Previous and Next are standard labels)");
	$blog_pagination_text_container->addChild("group17",$group17);

		$row1 = new ElatedRow();
		$group17->addChild("row1",$row1);

			$blog_pagination_previous_label = new ElatedField("textsimple","blog_pagination_previous_label","","Previous Label","This is some description");
			$row1->addChild("blog_pagination_previous_label",$blog_pagination_previous_label);

			$blog_pagination_next_label = new ElatedField("textsimple","blog_pagination_next_label","","Next Label","This is some description");
			$row1->addChild("blog_pagination_next_label",$blog_pagination_next_label);

$blog_pagination_border_above_yesno = new ElatedField("yesno","blog_pagination_border_above_yesno","no","Border Above Pagination","Enabling this option will display border above pagination",array(),array(
	"dependence" => true,
	"dependence_show_on_yes" => "#eltdf_blog_pagination_border_container"
	));
$blog_page_range_container->addChild("blog_pagination_border_above_yesno",$blog_pagination_border_above_yesno);

$blog_pagination_border_container = new ElatedContainer("blog_pagination_border_container","blog_pagination_border_above_yesno","no");
$blog_page_range_container->addChild("blog_pagination_border_container",$blog_pagination_border_container);

	$group18 = new ElatedGroup("Border Style","Define style for border top on pagination");
	$blog_pagination_border_container->addChild("group18",$group18);

		$row1 = new ElatedRow();
		$group18->addChild("row1",$row1);

			$blog_pgn_border_color = new ElatedField("colorsimple","blog_pgn_border_color","","Color","This is some description");
			$row1->addChild("blog_pgn_border_color",$blog_pgn_border_color);

			$blog_pgn_border_width = new ElatedField("textsimple","blog_pgn_border_width","","Width (px)","This is some description");
			$row1->addChild("blog_pgn_border_width",$blog_pgn_border_width);

			$blog_pgn_border_style = new ElatedField("selectsimple","blog_pgn_border_style","","Style","This is some description",array(
				"solid" => "Solid",
				"dotted" => "Dotted",
				"dashed" => "Dashed"
				));
			$row1->addChild("blog_pgn_border_style",$blog_pgn_border_style);

	$blog_pagination_border_margin = new ElatedField("text","blog_pagination_border_margin","","Margin from Border (px)","Set margin from border to pagination buttons",array(),array("col_width" => 3));
	$blog_pagination_border_container->addChild("blog_pagination_border_margin",$blog_pagination_border_margin);

$number_of_chars = new ElatedField("text","number_of_chars","45","Number of Words in Excerpt",' Enter a number of words in excerpt (article summary)', array(), array("col_width" => 3));
$panel1->addChild("number_of_chars",$number_of_chars);

// Blog Single

$panel20 = new ElatedPanel("Blog Single", "blog_single_panel");
$blogPage->addChild("panel20",$panel20);

$blog_single_sidebar = new ElatedField("select","blog_single_sidebar","default","Sidebar Layout","Choose a sidebar layout for Blog Single pages", array(
	"default" => "No Sidebar",
	"1" => "Sidebar 1/3 right",
	"2" => "Sidebar 1/4 right",
	"3" => "Sidebar 1/3 left",
	"4" => "Sidebar 1/4 left"
));
$panel20->addChild("blog_single_sidebar",$blog_single_sidebar);

$custom_sidebars = eltd_get_custom_sidebars();

$blog_single_sidebar_custom_display = new ElatedField("selectblank","blog_single_sidebar_custom_display","","Sidebar to Display","Choose a sidebar to display on Blog Single pages", $custom_sidebars);
$panel20->addChild("blog_single_sidebar_custom_display",$blog_single_sidebar_custom_display);

$blog_single_show_ql_icon = new ElatedField("yesno","blog_single_show_ql_icon","yes","Enable Quote/Link Icon","Enabling this option will show Quote/Link Icon on Blog Single posts");
$panel20->addChild("blog_single_show_ql_icon",$blog_single_show_ql_icon);

$blog_show_subtitle_on_single = new ElatedField("yesno","blog_show_subtitle_on_single","no","Enable Subtitle on Single Post Pages","Enable Subtitle on Single Post Pages");
$panel20->addChild("blog_show_subtitle_on_single",$blog_show_subtitle_on_single);

$blog_single_navigation = new ElatedField("yesno","blog_single_navigation","no","Enable Prev/Next Single Post Navigation Links","Enable navigation links through the blog posts (left and right arrows will appear)", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_hide_pagination_container"));
$panel20->addChild("blog_single_navigation",$blog_single_navigation);

$blog_hide_pagination_container = new ElatedContainer("blog_hide_pagination_container","blog_single_navigation","no");
$panel20->addChild("blog_hide_pagination_container",$blog_hide_pagination_container);

$blog_navigation_through_same_category = new ElatedField("yesno","blog_navigation_through_same_category","no","Enable Navigation Only in Current Category","Limit your navigation only through current category");
$blog_hide_pagination_container->addChild("blog_navigation_through_same_category",$blog_navigation_through_same_category);

$blog_single_title_tags = new ElatedField("select","blog_single_title_tags","h5","Headlines Below Post Content",'Choose a tag for headlines below post content ("Tags", "Post a comment", etc)', array(
	"h2" => "h2",
	"h3" => "h3",
	"h4" => "h4",
	"h5" => "h5",
	"h6" => "h6"
));
$panel20->addChild("blog_single_title_tags",$blog_single_title_tags);

$group1 = new ElatedGroup("Blog Single Spacing","Set spacing for single post pages");
$panel20->addChild("group1",$group1);

$row1 = new ElatedRow();
$group1->addChild("row1",$row1);

$blog_single_tags_holder_margin_top = new ElatedField("textsimple","blog_single_tags_holder_margin_top","","Margin Above Tags(px)","This is some description");
$row1->addChild("blog_single_tags_holder_margin_top",$blog_single_tags_holder_margin_top);

$blog_single_navigation_margin = new ElatedField("textsimple","blog_single_navigation_margin","","Margin Above and Under Navigation(px)","This is some description");
$row1->addChild("blog_single_navigation_margin",$blog_single_navigation_margin);

$blog_single_comments_holder_margin = new ElatedField("textsimple","blog_single_comments_holder_margin","","Margin Above and Under Comments(px)","This is some description");
$row1->addChild("blog_single_comments_holder_margin",$blog_single_comments_holder_margin);

$post_info_data_single = new ElatedTitle("post_info_data_single", "Post Info Data Fields");
$panel20->addChild("post_info_data_single", $post_info_data_single);

$blog_single_show_date = new ElatedField("yesno","blog_single_show_date","yes","Show Date","Enabling this option will show date on Blog Single posts");
$panel20->addChild("blog_single_show_date",$blog_single_show_date);

$blog_single_show_like = new ElatedField("yesno","blog_single_show_like","no","Show Like","Enabling this option will turn on 'Likes' on Blog Single posts");
$panel20->addChild("blog_single_show_like",$blog_single_show_like);

$blog_single_show_social_share = new ElatedField("yesno","blog_single_show_social_share","no","Show Share","Enabling this option will show share on Single Post", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_single_share_options_container"));
$panel20->addChild("blog_single_show_social_share",$blog_single_show_social_share);

$blog_single_share_options_container = new ElatedContainer("blog_single_share_options_container","blog_single_show_social_share","no");
$panel20->addChild("blog_single_share_options_container",$blog_single_share_options_container);

$blog_single_select_share_option = new ElatedField("select","blog_single_select_share_option","dropdown","Social Share Style","Choose Social Share Style for Single Post",array(
	"dropdown" => "Social Share Dropdown",
	"list" => "Social Share List"
));

$blog_single_share_options_container->addChild("blog_single_select_share_option",$blog_single_select_share_option);

$blog_single_show_category = new ElatedField("yesno","blog_single_show_category","yes","Show Category","Enabling this option will show category/categories on Blog Single posts");
$panel20->addChild("blog_single_show_category",$blog_single_show_category);

$blog_author_info = new ElatedField("yesno","blog_author_info","no","Show Author Info","Enabling this option will display author name and descriptions on Blog Single pages", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_enable_blog_author_info_container"));
$panel20->addChild("blog_author_info",$blog_author_info);

$enable_blog_author_info_container = new ElatedContainer("enable_blog_author_info_container","blog_author_info","no");
$panel20->addChild("enable_blog_author_info_container",$enable_blog_author_info_container);

$enable_author_info_email = new ElatedField("yesno","enable_author_info_email","no","Show Author Email","Enabling this option will show author email");
$enable_blog_author_info_container->addChild("enable_author_info_email",$enable_author_info_email);

$group1 = new ElatedGroup("Blog Single Author Info Box Style","Set styles for author info box on single post pages");
$enable_blog_author_info_container->addChild("group1",$group1);

$row1 = new ElatedRow();
$group1->addChild("row1",$row1);

$blog_single_post_author_info_margin_top = new ElatedField("textsimple","blog_single_post_author_info_margin_top","","Margin Top for Author Info Holder (px)","This is some description");
$row1->addChild("blog_single_post_author_info_margin_top",$blog_single_post_author_info_margin_top);

$blog_single_post_author_info_background_color = new ElatedField("colorsimple","blog_single_post_author_info_background_color","","Background Color","This is some description");
$row1->addChild("blog_single_post_author_info_background_color",$blog_single_post_author_info_background_color);

$blog_single_post_author_info_border_width = new ElatedField("textsimple","blog_single_post_author_info_border_width","","Border width(px)","This is some description");
$row1->addChild("blog_single_post_author_info_border_width",$blog_single_post_author_info_border_width);

$blog_single_post_author_info_border_color = new ElatedField("colorsimple","blog_single_post_author_info_border_color","","Border Color","This is some description");
$row1->addChild("blog_single_post_author_info_border_color",$blog_single_post_author_info_border_color);

$row2 = new ElatedRow();
$group1->addChild("row2",$row2);

$blog_single_post_author_info_padding_top = new ElatedField("textsimple","blog_single_post_author_info_padding_top","","Padding Top (px)","This is some description");
$row2->addChild("blog_single_post_author_info_padding_top",$blog_single_post_author_info_padding_top);

$blog_single_post_author_info_padding_bottom = new ElatedField("textsimple","blog_single_post_author_info_padding_bottom","","Padding Bottom (px)","This is some description");
$row2->addChild("blog_single_post_author_info_padding_bottom",$blog_single_post_author_info_padding_bottom);

$blog_single_post_author_info_padding_left = new ElatedField("textsimple","blog_single_post_author_info_padding_left","","Padding Left (px)","This is some description");
$row2->addChild("blog_single_post_author_info_padding_left",$blog_single_post_author_info_padding_left);

$blog_single_post_author_info_padding_right = new ElatedField("textsimple","blog_single_post_author_info_padding_right","","Padding Right (px)","This is some description");
$row2->addChild("blog_single_post_author_info_padding_right",$blog_single_post_author_info_padding_right);

$group2 = new ElatedGroup("Blog Single Author Info Title Style","Set styles for author info title on single post pages");
$enable_blog_author_info_container->addChild("group2",$group2);	
		
$row1 = new ElatedRow();
$group2->addChild("row1",$row1);
	
$blog_single_post_author_info_title_color = new ElatedField("colorsimple","blog_single_post_author_info_title_color","","Text Color","This is some description");
$row1->addChild("blog_single_post_author_info_title_color",$blog_single_post_author_info_title_color);
			
$blog_single_post_author_info_title_font_family = new ElatedField("Fontsimple","blog_single_post_author_info_title_font_family","-1","Font Family","This is some description");
$row1->addChild("blog_single_post_author_info_title_font_family",$blog_single_post_author_info_title_font_family);

$blog_single_post_author_info_title_fontsize = new ElatedField("textsimple","blog_single_post_author_info_title_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_single_post_author_info_title_fontsize",$blog_single_post_author_info_title_fontsize);

$blog_single_post_author_info_title_lineheight = new ElatedField("textsimple","blog_single_post_author_info_title_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_single_post_author_info_title_lineheight",$blog_single_post_author_info_title_lineheight);

$row2 = new ElatedRow(true);
$group2->addChild("row2",$row2);			

$blog_single_post_author_info_title_fontstyle = new ElatedField("selectblanksimple","blog_single_post_author_info_title_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_single_post_author_info_title_fontstyle",$blog_single_post_author_info_title_fontstyle);

$blog_single_post_author_info_title_fontweight = new ElatedField("selectblanksimple","blog_single_post_author_info_title_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_single_post_author_info_title_fontweight",$blog_single_post_author_info_title_fontweight);

$blog_single_post_author_info_title_texttransform = new ElatedField("selectblanksimple","blog_single_post_author_info_title_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_single_post_author_info_title_texttransform",$blog_single_post_author_info_title_texttransform);

$blog_single_post_author_info_title_letterspacing = new ElatedField("textsimple","blog_single_post_author_info_title_letterspacing","","Letter Spacing (px)","This is some description");
$row2->addChild("blog_single_post_author_info_title_letterspacing",$blog_single_post_author_info_title_letterspacing);
			
$row3 = new ElatedRow();
$group2->addChild("row3",$row3);
		
$blog_single_post_author_info_title_margin_bottom = new ElatedField("textsimple","blog_single_post_author_info_title_margin_bottom","","Margin Bottom for Author Info Title (px)","This is some description");
$row3->addChild("blog_single_post_author_info_title_margin_bottom",$blog_single_post_author_info_title_margin_bottom);
	
$group3 = new ElatedGroup("Blog Single Author Info Text Style","Set styles for author info text on single post pages");
$enable_blog_author_info_container->addChild("group3",$group3);	
		
$row1 = new ElatedRow();
$group3->addChild("row1",$row1);
	
$blog_single_post_author_info_text_color = new ElatedField("colorsimple","blog_single_post_author_info_text_color","","Text Color","This is some description");
$row1->addChild("blog_single_post_author_info_text_color",$blog_single_post_author_info_text_color);
			
$blog_single_post_author_info_text_font_family = new ElatedField("Fontsimple","blog_single_post_author_info_text_font_family","-1","Font Family","This is some description");
$row1->addChild("blog_single_post_author_info_text_font_family",$blog_single_post_author_info_text_font_family);

$blog_single_post_author_info_text_fontsize = new ElatedField("textsimple","blog_single_post_author_info_text_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_single_post_author_info_text_fontsize",$blog_single_post_author_info_text_fontsize);

$blog_single_post_author_info_text_lineheight = new ElatedField("textsimple","blog_single_post_author_info_text_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_single_post_author_info_text_lineheight",$blog_single_post_author_info_text_lineheight);

$row2 = new ElatedRow(true);
$group3->addChild("row2",$row2);			

$blog_single_post_author_info_text_fontstyle = new ElatedField("selectblanksimple","blog_single_post_author_info_text_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_single_post_author_info_text_fontstyle",$blog_single_post_author_info_text_fontstyle);

$blog_single_post_author_info_text_fontweight = new ElatedField("selectblanksimple","blog_single_post_author_info_text_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_single_post_author_info_text_fontweight",$blog_single_post_author_info_text_fontweight);

$blog_single_post_author_info_text_texttransform = new ElatedField("selectblanksimple","blog_single_post_author_info_text_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_single_post_author_info_text_texttransform",$blog_single_post_author_info_text_texttransform);

$blog_single_post_author_info_text_letterspacing = new ElatedField("textsimple","blog_single_post_author_info_text_letterspacing","","Letter Spacing (px)","This is some description");
$row2->addChild("blog_single_post_author_info_text_letterspacing",$blog_single_post_author_info_text_letterspacing);

$blog_single_post_author_image_border_radius = new ElatedField("text","blog_single_post_author_image_border_radius","","Border Radius Around Image (px)","Define border radius around image", array(), array("col_width" => 3));
$enable_blog_author_info_container->addChild("blog_single_post_author_image_border_radius",$blog_single_post_author_image_border_radius);

$blog_single_show_comments = new ElatedField("yesno","blog_single_show_comments","yes","Show Comments","Enabling this option will show comments on Blog Single posts", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_enable_blog_comments_container"));
	$panel20->addChild("blog_single_show_comments",$blog_single_show_comments);

	$enable_blog_comments_container = new ElatedContainer("enable_blog_comments_container","blog_single_show_comments","no");
	$panel20->addChild("enable_blog_comments_container",$enable_blog_comments_container);
	
	$group1 = new ElatedGroup("Comments Box Style","Set styles for comments box on single post pages");
	$enable_blog_comments_container->addChild("group1",$group1);

		$row1 = new ElatedRow();
		$group1->addChild("row1",$row1);

			$blog_single_post_comments_background_color = new ElatedField("colorsimple","blog_single_post_comments_background_color","","Background Color","This is some description");
			$row1->addChild("blog_single_post_comments_background_color",$blog_single_post_comments_background_color);

			$blog_single_post_comments_border_width = new ElatedField("textsimple","blog_single_post_comments_border_width","","Border width(px)","This is some description");
			$row1->addChild("blog_single_post_comments_border_width",$blog_single_post_comments_border_width);

			$blog_single_post_comments_border_color = new ElatedField("colorsimple","blog_single_post_comments_border_color","","Border Color","This is some description");
			$row1->addChild("blog_single_post_comments_border_color",$blog_single_post_comments_border_color);
			
			$blog_single_post_comments_margin_bottom= new ElatedField("textsimple","blog_single_post_comments_margin_bottom","","Margin Bottom (px)","This is some description");
			$row1->addChild("blog_single_post_comments_margin_bottom",$blog_single_post_comments_margin_bottom);


		$row2 = new ElatedRow();
		$group1->addChild("row2",$row2);

			$blog_single_post_comments_padding_top = new ElatedField("textsimple","blog_single_post_comments_padding_top","","Padding Top (px)","This is some description");
			$row2->addChild("blog_single_post_comments_padding_top",$blog_single_post_comments_padding_top);

			$blog_single_post_comments_padding_bottom = new ElatedField("textsimple","blog_single_post_comments_padding_bottom","","Padding Bottom (px)","This is some description");
			$row2->addChild("blog_single_post_comments_padding_bottom",$blog_single_post_comments_padding_bottom);

			$blog_single_post_comments_padding_left = new ElatedField("textsimple","blog_single_post_comments_padding_left","","Padding Left (px)","This is some description");
			$row2->addChild("blog_single_post_comments_padding_left",$blog_single_post_comments_padding_left);

			$blog_single_post_comments_padding_right = new ElatedField("textsimple","blog_single_post_comments_padding_right","","Padding Right (px)","This is some description");
			$row2->addChild("blog_single_post_comments_padding_right",$blog_single_post_comments_padding_right);
	
	$group2 = new ElatedGroup("Comments Color Style","Set styles for comments on single post pages");
	$enable_blog_comments_container->addChild("group2",$group2);
		
		$row1 = new ElatedRow();
		$group2->addChild("row1",$row1);
	
			$blog_single_post_comments_title_color = new ElatedField("colorsimple","blog_single_post_comments_title_color","","Title Color","This is some description");
			$row1->addChild("blog_single_post_comments_title_color",$blog_single_post_comments_title_color);
			
			$blog_single_post_comments_text_color = new ElatedField("colorsimple","blog_single_post_comments_text_color","","Text Color","This is some description");
			$row1->addChild("blog_single_post_comments_text_color",$blog_single_post_comments_text_color);
			
			$blog_single_post_comments_link_color = new ElatedField("colorsimple","blog_single_post_comments_link_color","","Link Color","This is some description");
			$row1->addChild("blog_single_post_comments_link_color",$blog_single_post_comments_link_color);	
			
			$blog_single_post_comments_date_color = new ElatedField("colorsimple","blog_single_post_comments_date_color","","Date Color","This is some description");
			$row1->addChild("blog_single_post_comments_date_color",$blog_single_post_comments_date_color);
			
$blog_single_comments_image_border_radius = new ElatedField("text","blog_single_comments_image_border_radius","","Border Radius Around Image (px)","Define border radius around image", array(), array("col_width" => 3));
$enable_blog_comments_container->addChild("blog_single_comments_image_border_radius",$blog_single_comments_image_border_radius);			

// Advanced Options

$panel_advanced_options = new ElatedPanel("Advanced Options","panel_advanced_options");
$blogPage->addChild("panel_advanced_options",$panel_advanced_options);

$blog_standard_type_show_options = new ElatedField("yesno","blog_standard_type_show_options","no","Show Standard Template Options","Editing these options will have affect on Post List & Single Post", array(),
	array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#eltdf_blog_standard_type_post_lists"));
$panel_advanced_options->addChild("blog_standard_type_show_options",$blog_standard_type_show_options);

$blog_masonry_show_options = new ElatedField("yesno","blog_masonry_show_options","no","Show Masonry & Masonry Full Width Template Options","Editing these options will have affect on Post List & Single Post", array(),
	array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#eltdf_blog_masonry_post_lists"));
$panel_advanced_options->addChild("blog_masonry_show_options", $blog_masonry_show_options);


$blog_vertical_loop_show_options = new ElatedField("yesno","blog_vertical_loop_show_options","no","Show Vertical Loop Template Options","Editing these options will have affect on Post List & Single Post", array(),
	array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#eltdf_blog_vertical_loop_post_lists"));
$panel_advanced_options->addChild("blog_vertical_loop_show_options",$blog_vertical_loop_show_options);

// Blog Post List - Blog: Masonry
$panel10 = new ElatedPanel("Blog List Templates Options: Masonry & Masonry Full Width","blog_masonry_post_lists", "blog_masonry_show_options", "no");
$blogPage->addChild("panel10",$panel10);

$blog_masonry_number_of_chars = new ElatedField("text","blog_masonry_number_of_chars","45","Number of Words in Excerpt",' Enter a number of words in excerpt (article summary)', array(), array("col_width" => 3));
$panel10->addChild("blog_masonry_number_of_chars",$blog_masonry_number_of_chars);

$blog_masonry_read_more_button = new ElatedField("yesno","blog_masonry_read_more_button","no","Read More Button","Enable Read More Button");
$panel10->addChild("blog_masonry_read_more_button",$blog_masonry_read_more_button);

$pagination_masonry = new ElatedField("select","pagination_masonry","pagination","Pagination on Masonry",'Choose a pagination style for "Masonry" Blog List', array(
	"pagination" => "Pagination",
	"load_more" => "Load More",
	"infinite_scroll" => "Infinite Scroll"
));
$panel10->addChild("pagination_masonry",$pagination_masonry);

$blog_masonry_columns = new ElatedField('select', 'blog_masonry_columns', 'two_columns', 'Masonry Blog Columns', 'Choose a number of columns for "Masonry" Blog List without sidebar', array(
	'two_columns' => '2',
	'three_columns' => '3'
));
$panel10->addChild('blog_masonry_columns', $blog_masonry_columns);

$blog_masonry_full_width_columns = new ElatedField('select', 'blog_masonry_full_width_columns', 'three_columns', 'Full Width Masonry Blog Columns', 'Choose a number of columns for "Masonry" Blog List', array(
	'three_columns' => '3',
	'four_columns' => '4',
	'five_columns' => '5'
));
$panel10->addChild('blog_masonry_full_width_columns', $blog_masonry_full_width_columns);

$blog_masonry_full_width_margin = new ElatedField("text","blog_masonry_full_width_margin","","Full Width Masonry Margin",'Please insert margin in px (i.e. 5px), or in % (i.e 5%)', array(), array("col_width" => 3));
$panel10->addChild("blog_masonry_full_width_margin",$blog_masonry_full_width_margin);

$blog_masonry_filter = new ElatedField("yesno","blog_masonry_filter","no","Show Category Filter on Masonry",'Enabling this option will display a Category Filter on "Masonry" Blog List', array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_masonry_filter_container"));
$panel10->addChild("blog_masonry_filter",$blog_masonry_filter);

$blog_masonry_filter_container = new ElatedContainer("blog_masonry_filter_container","blog_masonry_filter","no");
$panel10->addChild("blog_masonry_filter_container",$blog_masonry_filter_container);


// Blog Masonry Filter
$blog_masonry_filter_background_color = new ElatedField("color","blog_masonry_filter_background_color","","Background Color","Choose color for background of filter area",array(), array("col_width" => 3));
$blog_masonry_filter_container->addChild("blog_masonry_filter_background_color",$blog_masonry_filter_background_color);

$blog_masonry_filter_height = new ElatedField("text","blog_masonry_filter_height","","Height (px)","Enter height for filter area",array(), array("col_width" => 3));
$blog_masonry_filter_container->addChild("blog_masonry_filter_height", $blog_masonry_filter_height);

$blog_masonry_filter_margin_bottom = new ElatedField("text","blog_masonry_filter_margin_bottom","","Bottom Margin (px)","Enter bottom margin for filter area. Default value is 36",array(), array("col_width" => 3));
$blog_masonry_filter_container->addChild("blog_masonry_filter_margin_bottom",$blog_masonry_filter_margin_bottom);

$blog_masonry_filter_alignment = new ElatedField("select","blog_masonry_filter_alignment","","Horizontal Alignment","Choose filter alignment", array(
	"left" => "Left",
	"center" => "Center",
	"right" => "Right"
));
$blog_masonry_filter_container->addChild("blog_masonry_filter_alignment",$blog_masonry_filter_alignment);

$blog_masonry_enable_filter_title = new ElatedField("yesno","blog_masonry_enable_filter_title","no","Enable Filter Title","Enabling this option will show category filter title");
$blog_masonry_filter_container->addChild("blog_masonry_enable_filter_title",$blog_masonry_enable_filter_title);

$group1 = new ElatedGroup("Title","Define text styles for filter title");
$blog_masonry_filter_container->addChild("group1",$group1);

$row1 = new ElatedRow();
$group1->addChild("row1",$row1);
$blog_masonry_filter_title_color = new ElatedField("colorsimple","blog_masonry_filter_title_color","","Text Color","This is some description");
$row1->addChild("blog_masonry_filter_title_color",$blog_masonry_filter_title_color);
$blog_masonry_filter_title_font_size = new ElatedField("textsimple","blog_masonry_filter_title_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_masonry_filter_title_font_size",$blog_masonry_filter_title_font_size);
$blog_masonry_filter_title_line_height = new ElatedField("textsimple","blog_masonry_filter_title_line_height","","Line Height (px)","This is some description");
$row1->addChild("blog_masonry_filter_title_line_height",$blog_masonry_filter_title_line_height);
$blog_masonry_filter_title_text_transform = new ElatedField("selectblanksimple","blog_masonry_filter_title_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row1->addChild("blog_masonry_filter_title_text_transform",$blog_masonry_filter_title_text_transform);

$row2 = new ElatedRow(true);
$group1->addChild("row2",$row2);
$blog_masonry_filter_title_font_family = new ElatedField("Fontsimple","blog_masonry_filter_title_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_masonry_filter_title_font_family",$blog_masonry_filter_title_font_family);
$blog_masonry_filter_title_font_style = new ElatedField("selectblanksimple","blog_masonry_filter_title_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_masonry_filter_title_font_style",$blog_masonry_filter_title_font_style);
$blog_masonry_filter_title_font_weight = new ElatedField("selectblanksimple","blog_masonry_filter_title_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_masonry_filter_title_font_weight",$blog_masonry_filter_title_font_weight);
$blog_masonry_filter_title_letter_spacing = new ElatedField("textsimple","blog_masonry_filter_title_letter_spacing","","Letter Spacing (px)","This is some description");
$row2->addChild("blog_masonry_filter_title_letter_spacing",$blog_masonry_filter_title_letter_spacing);

$group2 = new ElatedGroup("Categories","Define text styles for filter categories");
$blog_masonry_filter_container->addChild("group2",$group2);

$row1 = new ElatedRow();
$group2->addChild("row1",$row1);
$blog_masonry_filter_color = new ElatedField("colorsimple","blog_masonry_filter_color","","Text Color","This is some description");
$row1->addChild("blog_masonry_filter_color",$blog_masonry_filter_color);
$blog_masonry_filter_hovercolor = new ElatedField("colorsimple","blog_masonry_filter_hovercolor","","Hover/Active Color","This is some description");
$row1->addChild("blog_masonry_filter_hovercolor",$blog_masonry_filter_hovercolor);
$blog_masonry_filter_font_size = new ElatedField("textsimple","blog_masonry_filter_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_masonry_filter_font_size",$blog_masonry_filter_font_size);
$blog_masonry_filter_line_height = new ElatedField("textsimple","blog_masonry_filter_line_height","","Line Height (px)","This is some description");
$row1->addChild("blog_masonry_filter_line_height",$blog_masonry_filter_line_height);

$row2 = new ElatedRow(true);
$group2->addChild("row2",$row2);
$blog_masonry_filter_font_family = new ElatedField("Fontsimple","blog_masonry_filter_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_masonry_filter_font_family",$blog_masonry_filter_font_family);
$blog_masonry_filter_font_style = new ElatedField("selectblanksimple","blog_masonry_filter_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_masonry_filter_font_style",$blog_masonry_filter_font_style);
$blog_masonry_filter_font_weight = new ElatedField("selectblanksimple","blog_masonry_filter_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_masonry_filter_font_weight",$blog_masonry_filter_font_weight);
$blog_masonry_filter_text_transform = new ElatedField("selectblanksimple","blog_masonry_filter_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_masonry_filter_text_transform",$blog_masonry_filter_text_transform);

$row3 = new ElatedRow(true);
$group2->addChild("row3",$row3);
$blog_masonry_filter_letter_spacing = new ElatedField("textsimple","blog_masonry_filter_letter_spacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_masonry_filter_letter_spacing",$blog_masonry_filter_letter_spacing);

$blog_masonry_filter_disable_separator = new ElatedField("yesno","blog_masonry_filter_disable_separator","yes","Disable Separator Between Categories","Disabling this option will remove separator between filter categories.");
$blog_masonry_filter_container->addChild("blog_masonry_filter_disable_separator",$blog_masonry_filter_disable_separator);

$blog_masonry_type = new ElatedField("select","blog_masonry_type","post_info_below_title","Post Info Position","Choose Post Info Position for Masonry Blog List", array(
	"post_info_below_title" => "Post Info Section Below Title",
	"post_info_at_bottom" => "Post Info Section at Bottom"
));
$panel10->addChild("blog_masonry_type",$blog_masonry_type);

$blog_masonry_content_position = new ElatedField("select","blog_masonry_content_position","content_above_blog_list","Content Position","Choose content position for blog list template when sidebar is enabled. Note: This settings in only for template, not for archive pages", array(
	"content_above_blog_list" => "Content Above Blog List",
	"content_above_blog_list_and_sidebar" => "Content Above Blog List and Sidebar"
));
$panel10->addChild("blog_masonry_content_position",$blog_masonry_content_position);

$blog_masonry_post_meta_data_section = new ElatedTitle("blog_masonry_post_meta_data_section", "Post Info Data Fields");
$panel10->addChild("blog_masonry_post_meta_data_section", $blog_masonry_post_meta_data_section);

$blog_masonry_show_categories= new ElatedField("yesno","blog_masonry_show_categories","no","Show Categories","Enabling this option will Show Categories on Post List");
$panel10->addChild("blog_masonry_show_categories",$blog_masonry_show_categories);

$blog_masonry_show_comments = new ElatedField("yesno","blog_masonry_show_comments","no","Show Comments","Enabling this option will Show Comments on Post List");
$panel10->addChild("blog_masonry_show_comments",$blog_masonry_show_comments);

$blog_masonry_show_author = new ElatedField("yesno","blog_masonry_show_author","no","Show Author Name","Enabling this option will show author name on Post List and Blog Post Single");
$panel10->addChild("blog_masonry_show_author",$blog_masonry_show_author);

$blog_masonry_show_date = new ElatedField("yesno","blog_masonry_show_date","no","Show Date","Enabling this option will show date on Post List");
$panel10->addChild("blog_masonry_show_date",$blog_masonry_show_date);

$blog_masonry_show_share = new ElatedField("yesno","blog_masonry_show_share","no","Show Share","Enabling this option will show share on Post List", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_masonry_share_options_container"));
$panel10->addChild("blog_masonry_show_share",$blog_masonry_show_share);

$blog_masonry_share_options_container = new ElatedContainer("blog_masonry_share_options_container","blog_masonry_show_share","no");
$panel10->addChild("blog_masonry_share_options_container",$blog_masonry_share_options_container);

$blog_masonry_select_share_options_masonry_type = new ElatedField("select","blog_masonry_select_share_options_masonry_type","dropdown","Social Share Style","Choose Social Share Style for Masonry Type",array(
	"dropdown" => "Social Share Dropdown",
	"list" => "Social Share List"
));

$blog_masonry_share_options_container->addChild("blog_masonry_select_share_options_masonry_type",$blog_masonry_select_share_options_masonry_type);

$blog_masonry_share_icon_color = new ElatedField("color","blog_masonry_share_icon_color","","Icon Color","Choose icon color for share dropdown");
$blog_masonry_share_options_container->addChild("blog_masonry_share_icon_color",$blog_masonry_share_icon_color);

$blog_masonry_share_icon_hover_color = new ElatedField("color","blog_masonry_share_icon_hover_color","","Icon Hover Color","Choose icon hover color for share dropdown");
$blog_masonry_share_options_container->addChild("blog_masonry_share_icon_hover_color",$blog_masonry_share_icon_hover_color);

$blog_masonry_share_background_color = new ElatedField("color","blog_masonry_share_background_color","","Background Color","Choose background color for share dropdown list field");
$blog_masonry_share_options_container->addChild("blog_masonry_share_background_color",$blog_masonry_share_background_color);

$blog_masonry_show_like = new ElatedField("yesno","blog_masonry_show_like","no","Show Likes",'Enabling this option will turn on "Likes"');
$panel10->addChild("blog_masonry_show_like",$blog_masonry_show_like);

$blog_masonry_post_design_style = new ElatedTitle("blog_masonry_post_design_style", "Post Design Style");
$panel10->addChild("blog_masonry_post_design_style", $blog_masonry_post_design_style);

$blog_masonry_post_alignment = new ElatedField("select","blog_masonry_post_alignment","","Post Alignment","Choose alignment for whole post",array(
	"left" => "Left",
	"center" => "Center",
	"right" => "Right"
));
$panel10->addChild("blog_masonry_post_alignment",$blog_masonry_post_alignment);

$blog_masonry_enable_text_box = new ElatedField("yesno","blog_masonry_enable_text_box","no","Enable Boxed Styled Post Content","Enable post text boxed features", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_masonry_enable_text_box_container"));
$panel10->addChild("blog_masonry_enable_text_box",$blog_masonry_enable_text_box);

$blog_masonry_enable_text_box_container = new ElatedContainer("blog_masonry_enable_text_box_container","blog_masonry_enable_text_box","no");
$panel10->addChild("blog_masonry_enable_text_box_container",$blog_masonry_enable_text_box_container);

$blog_masonry_box_background_color = new ElatedField("color","blog_masonry_box_background_color","","Background Color","Choose background color for post text box");
$blog_masonry_enable_text_box_container->addChild("blog_masonry_box_background_color",$blog_masonry_box_background_color);

$blog_masonry_box_border_color = new ElatedField("color","blog_masonry_box_border_color","","Border Color","Choose border color for post text box");
$blog_masonry_enable_text_box_container->addChild("blog_masonry_box_border_color",$blog_masonry_box_border_color);

$blog_masonry_box_padding = new ElatedField("text","blog_masonry_box_padding","","Text box padding","Please insert padding in format (top right bottom left) i.e. 5px 5px 5px 5px", array(), array("col_width" => 3));
$blog_masonry_enable_text_box_container->addChild("blog_masonry_box_padding",$blog_masonry_box_padding);

$group7 = new ElatedGroup("Paragraph","Set paragraph color");
$panel10->addChild("group7",$group7);

$blog_masonry_paragraph_color = new ElatedField("colorsimple","blog_masonry_paragraph_color","","Color","This is some description");
$group7->addChild("blog_masonry_paragraph_color",$blog_masonry_paragraph_color);

$group_masonry_read_more_button = new ElatedGroup("Read More Button Style","Set read more button styles");
$panel10->addChild("group_masonry_read_more_button",$group_masonry_read_more_button);

	$row1 = new ElatedRow();
	$group_masonry_read_more_button->addChild("row1",$row1);
	
		$blog_masonry_read_more_button_color = new ElatedField("colorsimple","blog_masonry_read_more_button_color","","Text Color","Choose text color for read more button");
		$row1->addChild("blog_masonry_read_more_button_color",$blog_masonry_read_more_button_color);
	
		$blog_masonry_read_more_button_color_hover = new ElatedField("colorsimple","blog_masonry_read_more_button_color_hover","","Text Hover Color","Choose text hover color for read more button");
		$row1->addChild("blog_masonry_read_more_button_color_hover",$blog_masonry_read_more_button_color_hover);

		$blog_masonry_read_more_button_back_color = new ElatedField("colorsimple","blog_masonry_read_more_button_back_color","","Background Color","Choose background color for read more button");
		$row1->addChild("blog_masonry_read_more_button_back_color",$blog_masonry_read_more_button_back_color);
		
		$blog_masonry_read_more_button_back_color_hover = new ElatedField("colorsimple","blog_masonry_read_more_button_back_color_hover","","Background Hover Color","Choose background hover color for read more button");
		$row1->addChild("blog_masonry_read_more_button_back_color_hover",$blog_masonry_read_more_button_back_color_hover);
		
	$row2 = new ElatedRow();
	$group_masonry_read_more_button->addChild("row2",$row2);	
	
		$blog_masonry_read_more_button_border_color = new ElatedField("colorsimple","blog_masonry_read_more_button_border_color","","Border Color","Choose border color for read more button");
		$row2->addChild("blog_masonry_read_more_button_border_color",$blog_masonry_read_more_button_border_color);		
		
		$blog_masonry_read_more_button_border_color_hover = new ElatedField("colorsimple","blog_masonry_read_more_button_border_color_hover","","Border Hover Color","Choose border hover color for read more button");
		$row2->addChild("blog_masonry_read_more_button_border_color_hover",$blog_masonry_read_more_button_border_color_hover);
		
$group_masonry_share_button = new ElatedGroup("Share Button Style","Set share button styles");
$panel10->addChild("group_masonry_share_button",$group_masonry_share_button);

	$row1 = new ElatedRow();
	$group_masonry_share_button->addChild("row1",$row1);
	
		$blog_masonry_share_button_color = new ElatedField("colorsimple","blog_masonry_share_button_color","","Text Color","Choose text color for read more button");
		$row1->addChild("blog_masonry_share_button_color",$blog_masonry_share_button_color);
	
		$blog_masonry_share_button_color_hover = new ElatedField("colorsimple","blog_masonry_share_button_color_hover","","Text Hover Color","Choose text hover color for read more button");
		$row1->addChild("blog_masonry_share_button_color_hover",$blog_masonry_share_button_color_hover);

		$blog_masonry_share_button_back_color = new ElatedField("colorsimple","blog_masonry_share_button_back_color","","Background Color","Choose background color for read more button");
		$row1->addChild("blog_masonry_share_button_back_color",$blog_masonry_share_button_back_color);
		
		$blog_masonry_share_button_back_color_hover = new ElatedField("colorsimple","blog_masonry_share_button_back_color_hover","","Background Hover Color","Choose background hover color for read more button");
		$row1->addChild("blog_masonry_share_button_back_color_hover",$blog_masonry_share_button_back_color_hover);
		
	$row2 = new ElatedRow();
	$group_masonry_share_button->addChild("row2",$row2);	
	
		$blog_masonry_share_button_border_color = new ElatedField("colorsimple","blog_masonry_share_button_border_color","","Border Color","Choose border color for read more button");
		$row2->addChild("blog_masonry_share_button_border_color",$blog_masonry_share_button_border_color);		
		
		$blog_masonry_share_button_border_color_hover = new ElatedField("colorsimple","blog_masonry_share_button_border_color_hover","","Border Hover Color","Choose border hover color for read more button");
		$row2->addChild("blog_masonry_share_button_border_color_hover",$blog_masonry_share_button_border_color_hover);

$group1 = new ElatedGroup("Quote/Link Background","Set background of Quote/Link post type");
$panel10->addChild("group1",$group1);

$row1 = new ElatedRow();
$group1->addChild("row1",$row1);

$blog_masonry_ql_background_image = new ElatedField("yesnosimple","blog_masonry_ql_background_image","no","Background Image","");
$row1->addChild("blog_masonry_ql_background_image",$blog_masonry_ql_background_image);

$blog_masonry_ql_background_color = new ElatedField("colorsimple","blog_masonry_ql_background_color","","Background Color","Default color is #ffffff.");
$row1->addChild("blog_masonry_ql_background_color",$blog_masonry_ql_background_color);

$blog_masonry_ql_hover_background_color = new ElatedField("colorsimple","blog_masonry_ql_hover_background_color","","Background Hover Color","Default color is #e6ae48.");
$row1->addChild("blog_masonry_ql_hover_background_color",$blog_masonry_ql_hover_background_color);

$blog_masonry_show_ql_mark = new ElatedField("yesno","blog_masonry_show_ql_mark","yes","Enable Quote/Link Icon","Show Icons for quote/link post format", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_masonry_show_ql_mark_container"));
$panel10->addChild("blog_masonry_show_ql_mark",$blog_masonry_show_ql_mark);

$blog_masonry_show_ql_mark_container = new ElatedContainer("blog_masonry_show_ql_mark_container","blog_masonry_show_ql_mark","no");
$panel10->addChild("blog_masonry_show_ql_mark_container",$blog_masonry_show_ql_mark_container);

$row1 = new ElatedRow();
$blog_masonry_show_ql_mark_container->addChild("row1",$row1);

$blog_masonry_ql_mark_color = new ElatedField("color","blog_masonry_ql_mark_color","","Icon Color","Choose icon color for quote/link post");
$row1->addChild("blog_masonry_ql_mark_color",$blog_masonry_ql_mark_color);

$blog_masonry_ql_mark_hover_color = new ElatedField("color","blog_masonry_ql_mark_hover_color","","Icon Hover Color","Choose hover icon color for quote/link post.");
$row1->addChild("blog_masonry_ql_mark_hover_color",$blog_masonry_ql_mark_hover_color);

$blog_masonry_quote_size = new ElatedField("text","blog_masonry_quote_size","","Quote Icon Size (px)","Define font size for quote post.", array(), array("col_width" => 3));
$row1->addChild("blog_masonry_quote_size",$blog_masonry_quote_size);

$blog_masonry_link_size = new ElatedField("text","blog_masonry_link_size","","Link Icon Size (px)","Define font size for link post.", array(), array("col_width" => 3));
$row1->addChild("blog_masonry_link_size",$blog_masonry_link_size);

$group8 = new ElatedGroup("Blog List Spacing","Set spacing for blog layouts");
$panel10->addChild("group8",$group8);

$row1 = new ElatedRow();
$group8->addChild("row1",$row1);

$blog_masonry_image_margin_bottom = new ElatedField("textsimple","blog_masonry_image_margin_bottom","","Margin Under Image (px)","This is some description");
$row1->addChild("blog_masonry_image_margin_bottom",$blog_masonry_image_margin_bottom);

$blog_masonry_title_margin_bottom = new ElatedField("textsimple","blog_masonry_title_margin_bottom","","Margin Under Title (px)","This is some description");
$row1->addChild("blog_masonry_title_margin_bottom",$blog_masonry_title_margin_bottom);

$blog_masonry_post_info_margin_bottom = new ElatedField("textsimple","blog_masonry_post_info_margin_bottom","","Margin Under Post Info (px)","This is some description");
$row1->addChild("blog_masonry_post_info_margin_bottom",$blog_masonry_post_info_margin_bottom);

$blog_masonry_read_more_margin_top = new ElatedField("textsimple","blog_masonry_read_more_margin_top","","Margin Above Read More Button (px)","This is some description");
$row1->addChild("blog_masonry_read_more_margin_top",$blog_masonry_read_more_margin_top);

$row2 = new ElatedRow();
$group8->addChild("row2",$row2);

$blog_masonry_social_share_list_margin_top = new ElatedField("textsimple","blog_masonry_social_share_list_margin_top","","Margin Above Social Share List Holder (px)","This is some description");
$row2->addChild("blog_masonry_social_share_list_margin_top",$blog_masonry_social_share_list_margin_top);

$blog_masonry_article_margin_bottom = new ElatedField("textsimple","blog_masonry_article_margin_bottom","","Margin Between Articles (px)","This is some description");
$row2->addChild("blog_masonry_article_margin_bottom",$blog_masonry_article_margin_bottom);

$blog_masonry_post_info_bottom_margin_top = new ElatedField("textsimple","blog_masonry_post_info_bottom_margin_top","","Margin Above Post Info When Post Info is on the bottom (px)","This is some description");
$row2->addChild("blog_masonry_post_info_bottom_margin_top",$blog_masonry_post_info_bottom_margin_top);

$group9 = new ElatedGroup("Blog List Spacing for Quote and Link Post Type","Set spacing for blog layouts");
$panel10->addChild("group9",$group9);

$row1 = new ElatedRow();
$group9->addChild("row1",$row1);

$blog_masonry_ql_info_margin_bottom = new ElatedField("textsimple","blog_masonry_ql_info_margin_bottom","","Margin Under Post Info (px)","This is some description");
$row1->addChild("blog_masonry_ql_info_margin_bottom",$blog_masonry_ql_info_margin_bottom);

$blog_masonry_ql_quote_author_margin_top = new ElatedField("textsimple","blog_masonry_ql_quote_author_margin_top","","Margin Above Quote Author (px)","This is some description");
$row1->addChild("blog_masonry_ql_quote_author_margin_top",$blog_masonry_ql_quote_author_margin_top);

$blog_masonry_ql_social_share_list_margin_top = new ElatedField("textsimple","blog_masonry_ql_social_share_list_margin_top","","Margin Above Social Share List Holder (px)","This is some description");
$row1->addChild("blog_masonry_ql_social_share_list_margin_top",$blog_masonry_ql_social_share_list_margin_top);


$group10 = new ElatedGroup("Border Arround Article","Set border style for articles");
$panel10->addChild("group10",$group10);

$row1 = new ElatedRow();
$group10->addChild("row1",$row1);

$blog_masonry_article_border_width = new ElatedField("textsimple","blog_masonry_article_border_width","","Border Width (px)","This is some description");
$row1->addChild("blog_masonry_article_border_width",$blog_masonry_article_border_width);

$blog_masonry_article_border_color = new ElatedField("colorsimple","blog_masonry_article_border_color","","Border Color","This is some description");
$row1->addChild("blog_masonry_article_border_color",$blog_masonry_article_border_color);

$post_text_styling= new ElatedTitle("post_text_styling", "Post Text Style");
$panel10->addChild("post_text_styling", $post_text_styling);

$group2 = new ElatedGroup("Post Title","Define title styles in this blog post template.");
$panel10->addChild("group2",$group2);

$row1 = new ElatedRow();
$group2->addChild("row1",$row1);

$blog_masonry_title_color = new ElatedField("colorsimple","blog_masonry_title_color","","Text Color","This is some description");
$row1->addChild("blog_masonry_title_color",$blog_masonry_title_color);

$blog_masonry_title_hover_color = new ElatedField("colorsimple","blog_masonry_title_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_masonry_title_hover_color",$blog_masonry_title_hover_color);

$blog_masonry_title_fontsize = new ElatedField("textsimple","blog_masonry_title_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_masonry_title_fontsize",$blog_masonry_title_fontsize);

$row2 = new ElatedRow(true);
$group2->addChild("row2",$row2);


$blog_masonry_title_lineheight = new ElatedField("textsimple","blog_masonry_title_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_masonry_title_lineheight",$blog_masonry_title_lineheight);

$blog_masonry_title_google_fonts = new ElatedField("Fontsimple","blog_masonry_title_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_masonry_title_google_fonts",$blog_masonry_title_google_fonts);

$blog_masonry_title_fontstyle = new ElatedField("selectblanksimple","blog_masonry_title_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_masonry_title_fontstyle",$blog_masonry_title_fontstyle);

$blog_masonry_title_fontweight = new ElatedField("selectblanksimple","blog_masonry_title_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_masonry_title_fontweight",$blog_masonry_title_fontweight);

$row3 = new ElatedRow(true);
$group2->addChild("row3",$row3);


$blog_masonry_title_texttransform = new ElatedField("selectblanksimple","blog_masonry_title_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_masonry_title_texttransform",$blog_masonry_title_texttransform);

$blog_masonry_title_letterspacing = new ElatedField("textsimple","blog_masonry_title_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_masonry_title_letterspacing",$blog_masonry_title_letterspacing);

$group4 = new ElatedGroup("Post Info Data","Define post info text styles (date, category names etc.) Note: Single Posts will take the same styles as in list");
$panel10->addChild("group4",$group4);

$row1 = new ElatedRow();
$group4->addChild("row1",$row1);

$blog_masonry_info_color = new ElatedField("colorsimple","blog_masonry_info_color","","Text Color","This is some description");
$row1->addChild("blog_masonry_info_color",$blog_masonry_info_color);

$blog_masonry_info_link_color = new ElatedField("colorsimple","blog_masonry_info_link_color","","Link Color","This is some description");
$row1->addChild("blog_masonry_info_link_color",$blog_masonry_info_link_color);

$blog_masonry_info_hover_color = new ElatedField("colorsimple","blog_masonry_info_hover_color","","Link Hover Color","This is some description");
$row1->addChild("blog_masonry_info_hover_color",$blog_masonry_info_hover_color);

$blog_masonry_info_fontsize = new ElatedField("textsimple","blog_masonry_info_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_masonry_info_fontsize",$blog_masonry_info_fontsize);

$row2 = new ElatedRow(true);
$group4->addChild("row2",$row2);


$blog_masonry_info_lineheight = new ElatedField("textsimple","blog_masonry_info_lineheight","","Line Height (px)","This is some description");
$row2->addChild("blog_masonry_info_lineheight",$blog_masonry_info_lineheight);

$blog_masonry_info_google_fonts = new ElatedField("Fontsimple","blog_masonry_info_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_masonry_info_google_fonts",$blog_masonry_info_google_fonts);

$blog_masonry_info_fontstyle = new ElatedField("selectblanksimple","blog_masonry_info_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_masonry_info_fontstyle",$blog_masonry_info_fontstyle);

$blog_masonry_info_fontweight = new ElatedField("selectblanksimple","blog_masonry_info_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_masonry_info_fontweight",$blog_masonry_info_fontweight);

$row3 = new ElatedRow(true);
$group4->addChild("row3",$row3);

$blog_masonry_info_texttransform = new ElatedField("selectblanksimple","blog_masonry_info_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row3->addChild("blog_masonry_info_texttransform",$blog_masonry_info_texttransform);

$blog_masonry_info_letterspacing = new ElatedField("textsimple","blog_masonry_info_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_masonry_info_letterspacing",$blog_masonry_info_letterspacing);

$group3 = new ElatedGroup("Quote/Link Title Style","Define title styles for Quote/Link articles");
$panel10->addChild("group3",$group3);

$row1 = new ElatedRow();
$group3->addChild("row1",$row1);

$blog_masonry_ql_title_color = new ElatedField("colorsimple","blog_masonry_ql_title_color","","Text Color","This is some description");
$row1->addChild("blog_masonry_ql_title_color",$blog_masonry_ql_title_color);

$blog_masonry_ql_title_hover_color = new ElatedField("colorsimple","blog_masonry_ql_title_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_masonry_ql_title_hover_color",$blog_masonry_ql_title_hover_color);

$blog_masonry_ql_title_fontsize = new ElatedField("textsimple","blog_masonry_ql_title_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_masonry_ql_title_font_size",$blog_masonry_ql_title_fontsize);

$blog_masonry_ql_title_lineheight = new ElatedField("textsimple","blog_masonry_ql_title_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_masonry_ql_title_lineheight",$blog_masonry_ql_title_lineheight);

$row2 = new ElatedRow(true);
$group3->addChild("row2",$row2);

$blog_masonry_ql_title_texttransform = new ElatedField("selectblanksimple","blog_masonry_ql_title_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_masonry_ql_title_texttransform",$blog_masonry_ql_title_texttransform);

$blog_masonry_ql_title_google_fonts = new ElatedField("Fontsimple","blog_masonry_ql_title_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_masonry_ql_title_google_fonts",$blog_masonry_ql_title_google_fonts);

$blog_masonry_ql_title_fontstyle = new ElatedField("selectblanksimple","blog_masonry_ql_title_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_masonry_ql_title_fontstyle",$blog_masonry_ql_title_fontstyle);

$blog_masonry_ql_title_fontweight = new ElatedField("selectblanksimple","blog_masonry_ql_title_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_masonry_ql_title_fontweight",$blog_masonry_ql_title_fontweight);

$row3 = new ElatedRow(true);
$group3->addChild("row3",$row3);

$blog_masonry_ql_title_letterspacing = new ElatedField("textsimple","blog_masonry_ql_title_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_masonry_ql_title_letterspacing",$blog_masonry_ql_title_letterspacing);

$group5 = new ElatedGroup("Quote/Link Post Info Data","Define quote/link post info text styles (date, category names etc.) Note: Single Posts will take the same styles as in list.");
$panel10->addChild("group5",$group5);

$row1 = new ElatedRow();
$group5->addChild("row1",$row1);

$blog_masonry_ql_info_color = new ElatedField("colorsimple","blog_masonry_ql_info_color","","Text Color","This is some description");
$row1->addChild("blog_masonry_ql_info_color",$blog_masonry_ql_info_color);

$blog_masonry_ql_info_link_color = new ElatedField("colorsimple","blog_masonry_ql_info_link_color","","Link Color","This is some description");
$row1->addChild("blog_masonry_ql_info_link_color",$blog_masonry_ql_info_link_color);

$blog_masonry_ql_info_hover_color = new ElatedField("colorsimple","blog_masonry_ql_info_hover_color","","Hover Color","This is some description");
$row1->addChild("blog_masonry_ql_info_hover_color",$blog_masonry_ql_info_hover_color);

$blog_masonry_ql_info_fontsize = new ElatedField("textsimple","blog_masonry_ql_info_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_masonry_ql_info_fontsize",$blog_masonry_ql_info_fontsize);

$row2 = new ElatedRow(true);
$group5->addChild("row2",$row2);

$blog_masonry_ql_info_lineheight = new ElatedField("textsimple","blog_masonry_ql_info_lineheight","","Line Height (px)","This is some description");
$row2->addChild("blog_masonry_ql_info_lineheight",$blog_masonry_ql_info_lineheight);

$blog_masonry_ql_info_google_fonts = new ElatedField("Fontsimple","blog_masonry_ql_info_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_masonry_ql_info_google_fonts",$blog_masonry_ql_info_google_fonts);

$blog_masonry_ql_info_fontstyle = new ElatedField("selectblanksimple","blog_masonry_ql_info_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_masonry_ql_info_fontstyle",$blog_masonry_ql_info_fontstyle);

$blog_masonry_ql_info_fontweight = new ElatedField("selectblanksimple","blog_masonry_ql_info_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_masonry_ql_info_fontweight",$blog_masonry_ql_info_fontweight);

$row3 = new ElatedRow(true);
$group5->addChild("row3",$row3);

$blog_masonry_ql_info_texttransform = new ElatedField("selectblanksimple","blog_masonry_ql_info_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row3->addChild("blog_masonry_ql_info_texttransform",$blog_masonry_ql_info_texttransform);

$blog_masonry_ql_info_letterspacing = new ElatedField("textsimple","blog_masonry_ql_info_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_masonry_ql_info_letterspacing",$blog_masonry_ql_info_letterspacing);

$group6 = new ElatedGroup("Quote Author Style","Define author styles for Quote articles");
$panel10->addChild("group6",$group6);

$row1 = new ElatedRow();
$group6->addChild("row1",$row1);

$blog_masonry_ql_author_color = new ElatedField("colorsimple","blog_masonry_ql_author_color","","Text Color","This is some description");
$row1->addChild("blog_masonry_ql_author_color",$blog_masonry_ql_author_color);

$blog_masonry_ql_author_hover_color = new ElatedField("colorsimple","blog_masonry_ql_author_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_masonry_ql_author_hover_color",$blog_masonry_ql_author_hover_color);

$blog_masonry_ql_author_fontsize = new ElatedField("textsimple","blog_masonry_ql_author_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_masonry_ql_author_font_size",$blog_masonry_ql_author_fontsize);

$blog_masonry_ql_author_lineheight = new ElatedField("textsimple","blog_masonry_ql_author_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_masonry_ql_author_lineheight",$blog_masonry_ql_author_lineheight);

$row2 = new ElatedRow(true);
$group6->addChild("row2",$row2);

$blog_masonry_ql_author_texttransform = new ElatedField("selectblanksimple","blog_masonry_ql_author_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_masonry_ql_author_texttransform",$blog_masonry_ql_author_texttransform);

$blog_masonry_ql_author_google_fonts = new ElatedField("Fontsimple","blog_masonry_ql_author_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_masonry_ql_author_google_fonts",$blog_masonry_ql_author_google_fonts);

$blog_masonry_ql_author_fontstyle = new ElatedField("selectblanksimple","blog_masonry_ql_author_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_masonry_ql_author_fontstyle",$blog_masonry_ql_author_fontstyle);

$blog_masonry_ql_author_fontweight = new ElatedField("selectblanksimple","blog_masonry_ql_author_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_masonry_ql_author_fontweight",$blog_masonry_ql_author_fontweight);

$row3 = new ElatedRow(true);
$group6->addChild("row3",$row3);

$blog_masonry_ql_author_letterspacing = new ElatedField("textsimple","blog_masonry_ql_author_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_masonry_ql_author_letterspacing",$blog_masonry_ql_author_letterspacing);

// Blog Post List - Blog: Standard
$panel21 = new ElatedPanel("Blog List Template Options: Standard","blog_standard_type_post_lists", "blog_standard_type_show_options", "no");
$blogPage->addChild("panel21",$panel21);

$blog_standard_type_number_of_chars = new ElatedField("text","blog_standard_type_number_of_chars","45","Number of Words in Excerpt",' Enter a number of words in excerpt (article summary)', array(), array("col_width" => 3));
$panel21->addChild("blog_standard_type_number_of_chars",$blog_standard_type_number_of_chars);

$blog_standard_type_read_more_button = new ElatedField("yesno","blog_standard_type_read_more_button","yes","Read More Button","Enable Read More Button");
$panel21->addChild("blog_standard_type_read_more_button",$blog_standard_type_read_more_button);

$blog_standard_type_content_position = new ElatedField("select","blog_standard_type_content_position","content_above_blog_list","Content Position","Choose content position for blog list template when sidebar is enabled. Note: This settings in only for template, not for archive pages", array(
	"content_above_blog_list" => "Content Above Blog List",
	"content_above_blog_list_and_sidebar" => "Content Above Blog List and Sidebar"
));
$panel21->addChild("blog_standard_type_content_position",$blog_standard_type_content_position);

$blog_standard_type_post_meta_data_section = new ElatedTitle("blog_standard_type_post_meta_data_section", "Post Info Data Fields");
$panel21->addChild("blog_standard_type_post_meta_data_section", $blog_standard_type_post_meta_data_section);

$blog_standard_type_show_categories = new ElatedField("yesno","blog_standard_type_show_categories","yes","Show Categories","Enabling this option will Show Categories on Post List");
$panel21->addChild("blog_standard_type_show_categories",$blog_standard_type_show_categories);

$blog_standard_type_show_comments = new ElatedField("yesno","blog_standard_type_show_comments","no","Show Comments","Enabling this option will Show Comments on Post List");
$panel21->addChild("blog_standard_type_show_comments",$blog_standard_type_show_comments);

$blog_standard_type_show_author = new ElatedField("yesno","blog_standard_type_show_author","yes","Show Author Name","Enabling this option will show author name on Post List and Blog Post Single");
$panel21->addChild("blog_standard_type_show_author",$blog_standard_type_show_author);

$blog_standard_type_show_date = new ElatedField("yesno","blog_standard_type_show_date","yes","Show Date","Enabling this option will show date on Post List");
$panel21->addChild("blog_standard_type_hide_date",$blog_standard_type_show_date);

$blog_standard_type_show_share = new ElatedField("yesno","blog_standard_type_show_share","no","Show Share","Enabling this option will show share on Post List", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_standard_type_share_options_container"));
$panel21->addChild("blog_standard_type_show_share",$blog_standard_type_show_share);

$blog_standard_type_share_options_container = new ElatedContainer("blog_standard_type_share_options_container","blog_standard_type_show_share","no");
$panel21->addChild("blog_standard_type_share_options_container",$blog_standard_type_share_options_container);

$blog_standard_type_select_share_option = new ElatedField("select","blog_standard_type_select_share_option","dropdown","Social Share Style","Choose Social Share Style for Standard Type",array(
	"dropdown" => "Social Share Dropdown",
	"list" => "Social Share List"
));

$blog_standard_type_share_options_container->addChild("blog_standard_type_select_share_option",$blog_standard_type_select_share_option);

$blog_standard_type_share_icon_color = new ElatedField("color","blog_standard_type_share_icon_color","","Icon Color","Choose icon color for dropdown and list share type");
$blog_standard_type_share_options_container->addChild("blog_standard_type_share_icon_color",$blog_standard_type_share_icon_color);

$blog_standard_type_share_icon_hover_color = new ElatedField("color","blog_standard_type_share_icon_hover_color","","Icon Hover Color","Choose icon hover color for dropdown and list Share Type");
$blog_standard_type_share_options_container->addChild("blog_standard_type_share_icon_hover_color",$blog_standard_type_share_icon_hover_color);

$blog_standard_type_share_background_color = new ElatedField("color","blog_standard_type_share_background_color","","Background Color","Choose background color for dropdown share type");
$blog_standard_type_share_options_container->addChild("blog_standard_type_share_background_color",$blog_standard_type_share_background_color);

$blog_standard_type_show_like = new ElatedField("yesno","blog_standard_type_show_like","no","Show Likes",'Enabling this option will turn on "Likes"');
$panel21->addChild("blog_standard_type_show_like",$blog_standard_type_show_like);

$blog_standard_type_post_design_style = new ElatedTitle("blog_standard_type_post_design_style", "Post Design Style");
$panel21->addChild("blog_standard_type_post_design_style", $blog_standard_type_post_design_style);

$blog_standard_type_enable_text_box = new ElatedField("yesno","blog_standard_type_enable_text_box","no","Enable Boxed Styled Post Content","Enable post text boxed features", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_standard_type_enable_text_box_container"));
$panel21->addChild("blog_standard_type_enable_text_box",$blog_standard_type_enable_text_box);

$blog_standard_type_enable_text_box_container = new ElatedContainer("blog_standard_type_enable_text_box_container","blog_standard_type_enable_text_box","no");
$panel21->addChild("blog_standard_type_enable_text_box_container",$blog_standard_type_enable_text_box_container);

$blog_standard_type_box_background_color = new ElatedField("color","blog_standard_type_box_background_color","","Background Color","Choose background color for post text box");
$blog_standard_type_enable_text_box_container->addChild("blog_standard_type_box_background_color",$blog_standard_type_box_background_color);

$blog_standard_type_box_border_color = new ElatedField("color","blog_standard_type_box_border_color","","Border Color","Choose border color for post text box");
$blog_standard_type_enable_text_box_container->addChild("blog_standard_type_box_border_color",$blog_standard_type_box_border_color);

$blog_standard_type_box_padding = new ElatedField("text","blog_standard_type_box_padding","","Text box padding","Please insert padding in format (top right bottom left) i.e. 5px 5px 5px 5px", array(), array("col_width" => 3));
$blog_standard_type_enable_text_box_container->addChild("blog_standard_type_box_padding",$blog_standard_type_box_padding);

$group10 = new ElatedGroup("Paragraph","Set paragraph color");
$panel21->addChild("group10",$group10);

$blog_standard_type_paragraph_color = new ElatedField("colorsimple","blog_standard_type_paragraph_color","","Color","This is some description");
$group10->addChild("blog_standard_type_paragraph_color",$blog_standard_type_paragraph_color);

$group_read_more_button = new ElatedGroup("Read More Button Style","Set read more button styles");
$panel21->addChild("group_read_more_button",$group_read_more_button);

	$row1 = new ElatedRow();
	$group_read_more_button->addChild("row1",$row1);
	
		$blog_stand_read_more_button_color = new ElatedField("colorsimple","blog_stand_read_more_button_color","","Text Color","Choose text color for read more button");
		$row1->addChild("blog_stand_read_more_button_color",$blog_stand_read_more_button_color);
	
		$blog_stand_read_more_button_color_hover = new ElatedField("colorsimple","blog_stand_read_more_button_color_hover","","Text Hover Color","Choose text hover color for read more button");
		$row1->addChild("blog_stand_read_more_button_color_hover",$blog_stand_read_more_button_color_hover);

		$blog_stand_read_more_button_back_color = new ElatedField("colorsimple","blog_stand_read_more_button_back_color","","Background Color","Choose background color for read more button");
		$row1->addChild("blog_stand_read_more_button_back_color",$blog_stand_read_more_button_back_color);
		
		$blog_stand_read_more_button_back_color_hover = new ElatedField("colorsimple","blog_stand_read_more_button_back_color_hover","","Background Hover Color","Choose background hover color for read more button");
		$row1->addChild("blog_stand_read_more_button_back_color_hover",$blog_stand_read_more_button_back_color_hover);
		
	$row2 = new ElatedRow();
	$group_read_more_button->addChild("row2",$row2);	
	
		$blog_stand_read_more_button_border_color = new ElatedField("colorsimple","blog_stand_read_more_button_border_color","","Border Color","Choose border color for read more button");
		$row2->addChild("blog_stand_read_more_button_border_color",$blog_stand_read_more_button_border_color);		
		
		$blog_stand_read_more_button_border_color_hover = new ElatedField("colorsimple","blog_stand_read_more_button_border_color_hover","","Border Hover Color","Choose border hover color for read more button");
		$row2->addChild("blog_stand_read_more_button_border_color_hover",$blog_stand_read_more_button_border_color_hover);
		
$group_share_button = new ElatedGroup("Share Button Style","Set share button styles");
$panel21->addChild("group_share_button",$group_share_button);

	$row1 = new ElatedRow();
	$group_share_button->addChild("row1",$row1);
	
		$blog_stand_share_button_color = new ElatedField("colorsimple","blog_stand_share_button_color","","Text Color","Choose text color for read more button");
		$row1->addChild("blog_stand_share_button_color",$blog_stand_share_button_color);
	
		$blog_stand_share_button_color_hover = new ElatedField("colorsimple","blog_stand_share_button_color_hover","","Text Hover Color","Choose text hover color for read more button");
		$row1->addChild("blog_stand_share_button_color_hover",$blog_stand_share_button_color_hover);

		$blog_stand_share_button_back_color = new ElatedField("colorsimple","blog_stand_share_button_back_color","","Background Color","Choose background color for read more button");
		$row1->addChild("blog_stand_share_button_back_color",$blog_stand_share_button_back_color);
		
		$blog_stand_share_button_back_color_hover = new ElatedField("colorsimple","blog_stand_share_button_back_color_hover","","Background Hover Color","Choose background hover color for read more button");
		$row1->addChild("blog_stand_share_button_back_color_hover",$blog_stand_share_button_back_color_hover);
		
	$row2 = new ElatedRow();
	$group_share_button->addChild("row2",$row2);	
	
		$blog_stand_share_button_border_color = new ElatedField("colorsimple","blog_stand_share_button_border_color","","Border Color","Choose border color for read more button");
		$row2->addChild("blog_stand_share_button_border_color",$blog_stand_share_button_border_color);		
		
		$blog_stand_share_button_border_color_hover = new ElatedField("colorsimple","blog_stand_share_button_border_color_hover","","Border Hover Color","Choose border hover color for read more button");
		$row2->addChild("blog_stand_share_button_border_color_hover",$blog_stand_share_button_border_color_hover);		

$group1 = new ElatedGroup("Quote/Link Background","Set background of Quote/Link post type");
$panel21->addChild("group1",$group1);

$row1 = new ElatedRow();
$group1->addChild("row1",$row1);

$blog_standard_type_ql_background_image = new ElatedField("yesnosimple","blog_standard_type_ql_background_image","no","Background Image","");
$row1->addChild("blog_standard_type_ql_background_image",$blog_standard_type_ql_background_image);

$blog_standard_type_ql_background_color = new ElatedField("colorsimple","blog_standard_type_ql_background_color","","Background Color","Default color is #ffffff.");
$row1->addChild("blog_standard_type_ql_background_color",$blog_standard_type_ql_background_color);

$blog_standard_type_ql_hover_background_color = new ElatedField("colorsimple","blog_standard_type_ql_hover_background_color","","Background Hover Color","Default color is #e6ae48.");
$row1->addChild("blog_standard_type_ql_hover_background_color",$blog_standard_type_ql_hover_background_color);

$blog_standard_type_show_ql_mark = new ElatedField("yesno","blog_standard_type_show_ql_mark","yes","Enable Quote/Link Icon","Show Icons for Quote/Link Post Format", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_standard_type_show_ql_mark_container"));
$panel21->addChild("blog_standard_type_show_ql_mark",$blog_standard_type_show_ql_mark);

$blog_standard_type_show_ql_mark_container = new ElatedContainer("blog_standard_type_show_ql_mark_container","blog_standard_type_show_ql_mark","no");
$panel21->addChild("blog_standard_type_show_ql_mark_container",$blog_standard_type_show_ql_mark_container);

$row1 = new ElatedRow();
$blog_standard_type_show_ql_mark_container->addChild("row1",$row1);

$blog_standard_type_ql_mark_color = new ElatedField("color","blog_standard_type_ql_mark_color","","Icon Color","Choose icon color for quote/link post.");
$row1->addChild("blog_standard_type_ql_mark_color",$blog_standard_type_ql_mark_color);

$blog_standard_type_ql_mark_hover_color = new ElatedField("color","blog_standard_type_ql_mark_hover_color","","Icon Hover Color","Choose hover icon color for quote/link post.");
$row1->addChild("blog_standard_type_ql_mark_hover_color",$blog_standard_type_ql_mark_hover_color);

$blog_standard_type_quote_size = new ElatedField("text","blog_standard_type_quote_size","","Quote Icon Size (px)","Define font size for quote post.", array(), array("col_width" => 3));
$row1->addChild("blog_standard_type_quote_size",$blog_standard_type_quote_size);

$blog_standard_type_link_size = new ElatedField("text","blog_standard_type_link_size","","Link Icon Size (px)","Define font size for link post.", array(), array("col_width" => 3));
$row1->addChild("blog_standard_type_link_size",$blog_standard_type_link_size);

$group11 = new ElatedGroup("Blog List Spacing","Set spacing for blog layouts");
$panel21->addChild("group11",$group11);

$row1 = new ElatedRow();
$group11->addChild("row1",$row1);

$blog_standard_type_image_margin_bottom = new ElatedField("textsimple","blog_standard_type_image_margin_bottom","","Margin Under Image (px)","This is some description");
$row1->addChild("blog_standard_type_image_margin_bottom",$blog_standard_type_image_margin_bottom);

$blog_standard_type_title_margin_bottom = new ElatedField("textsimple","blog_standard_type_title_margin_bottom","","Margin Under Title (px)","This is some description");
$row1->addChild("blog_standard_type_title_margin_bottom",$blog_standard_type_title_margin_bottom);

$blog_standard_type_read_more_margin_top = new ElatedField("textsimple","blog_standard_type_read_more_margin_top","","Margin Above Read More Button Holder (px)","This is some description");
$row1->addChild("blog_standard_type_read_more_margin_top",$blog_standard_type_read_more_margin_top);

$blog_standard_type_post_info_margin_bottom = new ElatedField("textsimple","blog_standard_type_post_info_margin_bottom","","Margin Under Post Info (px)","This is some description");
$row1->addChild("blog_standard_type_post_info_margin_bottom",$blog_standard_type_post_info_margin_bottom);

$row2 = new ElatedRow();
$group11->addChild("row2",$row2);

$blog_standard_type_article_margin_bottom = new ElatedField("textsimple","blog_standard_type_article_margin_bottom","","Margin Between Articles (px)","This is some description");
$row2->addChild("blog_standard_type_article_margin_bottom",$blog_standard_type_article_margin_bottom);

$blog_standard_type_single_article_social_share_list_margin_top = new ElatedField("textsimple","blog_standard_type_single_article_social_share_list_margin_top","","Margin Above Social Share List Holder (px)","This is some description");
$row2->addChild("blog_standard_type_single_article_social_share_list_margin_top",$blog_standard_type_single_article_social_share_list_margin_top);

$group12 = new ElatedGroup("Blog List Spacing for Quote and Link Post Type","Set spacing for blog layouts");
$panel21->addChild("group12",$group12);

$row1 = new ElatedRow();
$group12->addChild("row1",$row1);

$blog_standard_type_ql_post_info_margin_bottom = new ElatedField("textsimple","blog_standard_type_ql_post_info_margin_bottom","","Margin Under Post Info (px)","This is some description");
$row1->addChild("blog_standard_type_ql_post_info_margin_bottom",$blog_standard_type_ql_post_info_margin_bottom);

$blog_standard_type_ql_social_share_list_margin_top = new ElatedField("textsimple","blog_standard_type_ql_social_share_list_margin_top","","Margin Above Social Share List (px)","This is some description");
$row1->addChild("blog_standard_type_ql_social_share_list_margin_top",$blog_standard_type_ql_social_share_list_margin_top);

$blog_standard_type_ql_quote_author_margin_top = new ElatedField("textsimple","blog_standard_type_ql_quote_author_margin_top","","Margin Above Quote Author (px)","This is some description");
$row1->addChild("blog_standard_type_ql_quote_author_margin_top",$blog_standard_type_ql_quote_author_margin_top);

$post_text_styling= new ElatedTitle("post_text_styling", "Post Text Style");
$panel21->addChild("post_text_styling", $post_text_styling);

$group5 = new ElatedGroup("Post Title","Define title styles in this blog post template.");
$panel21->addChild("group5",$group5);

$row1 = new ElatedRow();
$group5->addChild("row1",$row1);

$blog_standard_type_title_color = new ElatedField("colorsimple","blog_standard_type_title_color","","Text Color","This is some description");
$row1->addChild("blog_standard_type_title_color",$blog_standard_type_title_color);

$blog_standard_type_title_hover_color = new ElatedField("colorsimple","blog_standard_type_title_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_standard_type_title_hover_color",$blog_standard_type_title_hover_color);

$blog_standard_type_title_fontsize = new ElatedField("textsimple","blog_standard_type_title_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_standard_type_title_fontsize",$blog_standard_type_title_fontsize);

$blog_standard_type_title_lineheight = new ElatedField("textsimple","blog_standard_type_title_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_standard_type_title_lineheight",$blog_standard_type_title_lineheight);

$row2 = new ElatedRow(true);
$group5->addChild("row2",$row2);

$blog_standard_type_title_texttransform = new ElatedField("selectblanksimple","blog_standard_type_title_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_standard_type_title_texttransform",$blog_standard_type_title_texttransform);

$blog_standard_type_title_google_fonts = new ElatedField("Fontsimple","blog_standard_type_title_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_standard_type_title_google_fonts",$blog_standard_type_title_google_fonts);

$blog_standard_type_title_fontstyle = new ElatedField("selectblanksimple","blog_standard_type_title_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_standard_type_title_fontstyle",$blog_standard_type_title_fontstyle);

$blog_standard_type_title_fontweight = new ElatedField("selectblanksimple","blog_standard_type_title_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_standard_type_title_fontweight",$blog_standard_type_title_fontweight);

$row3 = new ElatedRow(true);
$group5->addChild("row3",$row3);

$blog_standard_type_title_letterspacing = new ElatedField("textsimple","blog_standard_type_title_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_standard_type_title_letterspacing",$blog_standard_type_title_letterspacing);

$group7 = new ElatedGroup("Post Info Data","Define post info text styles (date, category names etc.) Note: Single Posts will take the same styles as in list");
$panel21->addChild("group7",$group7);

$row1 = new ElatedRow();
$group7->addChild("row1",$row1);

$blog_standard_type_info_color = new ElatedField("colorsimple","blog_standard_type_info_color","","Text Color","This is some description");
$row1->addChild("blog_standard_type_info_color",$blog_standard_type_info_color);

$blog_standard_type_info_link_color = new ElatedField("colorsimple","blog_standard_type_info_link_color","","Link Color","This is some description");
$row1->addChild("blog_standard_type_info_link_color",$blog_standard_type_info_link_color);

$blog_standard_type_info_hover_color = new ElatedField("colorsimple","blog_standard_type_info_hover_color","","Link Hover Color","This is some description");
$row1->addChild("blog_standard_type_info_hover_color",$blog_standard_type_info_hover_color);

$blog_standard_type_info_fontsize = new ElatedField("textsimple","blog_standard_type_info_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_standard_type_info_fontsize",$blog_standard_type_info_fontsize);

$row2 = new ElatedRow(true);
$group7->addChild("row2",$row2);

$blog_standard_type_info_lineheight = new ElatedField("textsimple","blog_standard_type_info_lineheight","","Line Height (px)","This is some description");
$row2->addChild("blog_standard_type_info_lineheight",$blog_standard_type_info_lineheight);

$blog_standard_type_info_google_fonts = new ElatedField("Fontsimple","blog_standard_type_info_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_standard_type_info_google_fonts",$blog_standard_type_info_google_fonts);

$blog_standard_type_info_fontstyle = new ElatedField("selectblanksimple","blog_standard_type_info_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_standard_type_info_fontstyle",$blog_standard_type_info_fontstyle);

$blog_standard_type_info_fontweight = new ElatedField("selectblanksimple","blog_standard_type_info_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_standard_type_info_fontweight",$blog_standard_type_info_fontweight);

$row3 = new ElatedRow(true);
$group7->addChild("row3",$row3);

$blog_standard_type_info_texttransform = new ElatedField("selectblanksimple","blog_standard_type_info_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row3->addChild("blog_standard_type_info_texttransform",$blog_standard_type_info_texttransform);

$blog_standard_type_info_letterspacing = new ElatedField("textsimple","blog_standard_type_info_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_standard_type_info_letterspacing",$blog_standard_type_info_letterspacing);

$group6 = new ElatedGroup("Quote/Link Title Style","Define title styles for Quote/Link articles");
$panel21->addChild("group6",$group6);

$row1 = new ElatedRow();
$group6->addChild("row1",$row1);

$blog_standard_type_ql_title_color = new ElatedField("colorsimple","blog_standard_type_ql_title_color","","Text Color","This is some description");
$row1->addChild("blog_standard_type_ql_title_color",$blog_standard_type_ql_title_color);

$blog_standard_type_ql_title_hover_color = new ElatedField("colorsimple","blog_standard_type_ql_title_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_standard_type_ql_title_hover_color",$blog_standard_type_ql_title_hover_color);

$blog_standard_type_ql_title_fontsize = new ElatedField("textsimple","blog_standard_type_ql_title_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_standard_type_ql_title_font_size",$blog_standard_type_ql_title_fontsize);

$blog_standard_type_ql_title_lineheight = new ElatedField("textsimple","blog_standard_type_ql_title_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_standard_type_ql_title_lineheight",$blog_standard_type_ql_title_lineheight);


$row2 = new ElatedRow(true);
$group6->addChild("row2",$row2);

$blog_standard_type_ql_title_texttransform = new ElatedField("selectblanksimple","blog_standard_type_ql_title_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_standard_type_ql_title_texttransform",$blog_standard_type_ql_title_texttransform);

$blog_standard_type_ql_title_google_fonts = new ElatedField("Fontsimple","blog_standard_type_ql_title_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_standard_type_ql_title_google_fonts",$blog_standard_type_ql_title_google_fonts);

$blog_standard_type_ql_title_fontstyle = new ElatedField("selectblanksimple","blog_standard_type_ql_title_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_standard_type_ql_title_fontstyle",$blog_standard_type_ql_title_fontstyle);

$blog_standard_type_ql_title_fontweight = new ElatedField("selectblanksimple","blog_standard_type_ql_title_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_standard_type_ql_title_fontweight",$blog_standard_type_ql_title_fontweight);

$row3 = new ElatedRow(true);
$group6->addChild("row3",$row3);

$blog_standard_type_ql_title_letterspacing = new ElatedField("textsimple","blog_standard_type_ql_title_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_standard_type_ql_title_letterspacing",$blog_standard_type_ql_title_letterspacing);

$group8 = new ElatedGroup("Quote/Link Post Info Data","Define quote/link post info text styles (date, category names etc.) Note: Single Posts will take the same styles as in list.");
$panel21->addChild("group8",$group8);

$row1 = new ElatedRow();
$group8->addChild("row1",$row1);

$blog_standard_type_ql_info_color = new ElatedField("colorsimple","blog_standard_type_ql_info_color","","Text Color","This is some description");
$row1->addChild("blog_standard_type_ql_info_color",$blog_standard_type_ql_info_color);

$blog_standard_type_ql_info_link_color = new ElatedField("colorsimple","blog_standard_type_ql_info_link_color","","Link Color","This is some description");
$row1->addChild("blog_standard_type_ql_info_link_color",$blog_standard_type_ql_info_link_color);

$blog_standard_type_ql_info_hover_color = new ElatedField("colorsimple","blog_standard_type_ql_info_hover_color","","Hover Color","This is some description");
$row1->addChild("blog_standard_type_ql_info_hover_color",$blog_standard_type_ql_info_hover_color);

$blog_standard_type_ql_info_fontsize = new ElatedField("textsimple","blog_standard_type_ql_info_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_standard_type_ql_info_fontsize",$blog_standard_type_ql_info_fontsize);

$row2 = new ElatedRow(true);
$group8->addChild("row2",$row2);


$blog_standard_type_ql_info_lineheight = new ElatedField("textsimple","blog_standard_type_ql_info_lineheight","","Line Height (px)","This is some description");
$row2->addChild("blog_standard_type_ql_info_lineheight",$blog_standard_type_ql_info_lineheight);

$blog_standard_type_ql_info_google_fonts = new ElatedField("Fontsimple","blog_standard_type_ql_info_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_standard_type_ql_info_google_fonts",$blog_standard_type_ql_info_google_fonts);

$blog_standard_type_ql_info_fontstyle = new ElatedField("selectblanksimple","blog_standard_type_ql_info_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_standard_type_ql_info_fontstyle",$blog_standard_type_ql_info_fontstyle);

$blog_standard_type_ql_info_fontweight = new ElatedField("selectblanksimple","blog_standard_type_ql_info_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_standard_type_ql_info_fontweight",$blog_standard_type_ql_info_fontweight);

$row3 = new ElatedRow(true);
$group8->addChild("row3",$row3);

$blog_standard_type_ql_info_texttransform = new ElatedField("selectblanksimple","blog_standard_type_ql_info_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row3->addChild("blog_standard_type_ql_info_texttransform",$blog_standard_type_ql_info_texttransform);

$blog_standard_type_ql_info_letterspacing = new ElatedField("textsimple","blog_standard_type_ql_info_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_standard_type_ql_info_letterspacing",$blog_standard_type_ql_info_letterspacing);

$group9 = new ElatedGroup("Quote Author Style","Define author styles for Quote articles");
$panel21->addChild("group9",$group9);

$row1 = new ElatedRow();
$group9->addChild("row1",$row1);

$blog_standard_type_ql_author_color = new ElatedField("colorsimple","blog_standard_type_ql_author_color","","Text Color","This is some description");
$row1->addChild("blog_standard_type_ql_author_color",$blog_standard_type_ql_author_color);

$blog_standard_type_ql_author_hover_color = new ElatedField("colorsimple","blog_standard_type_ql_author_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_standard_type_ql_author_hover_color",$blog_standard_type_ql_author_hover_color);

$blog_standard_type_ql_author_fontsize = new ElatedField("textsimple","blog_standard_type_ql_author_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_standard_type_ql_author_font_size",$blog_standard_type_ql_author_fontsize);

$blog_standard_type_ql_author_lineheight = new ElatedField("textsimple","blog_standard_type_ql_author_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_standard_type_ql_author_lineheight",$blog_standard_type_ql_author_lineheight);


$row2 = new ElatedRow(true);
$group9->addChild("row2",$row2);

$blog_standard_type_ql_author_texttransform = new ElatedField("selectblanksimple","blog_standard_type_ql_author_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_standard_type_ql_author_texttransform",$blog_standard_type_ql_author_texttransform);

$blog_standard_type_ql_author_google_fonts = new ElatedField("Fontsimple","blog_standard_type_ql_author_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_standard_type_ql_author_google_fonts",$blog_standard_type_ql_author_google_fonts);

$blog_standard_type_ql_author_fontstyle = new ElatedField("selectblanksimple","blog_standard_type_ql_author_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_standard_type_ql_author_fontstyle",$blog_standard_type_ql_author_fontstyle);

$blog_standard_type_ql_author_fontweight = new ElatedField("selectblanksimple","blog_standard_type_ql_author_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_standard_type_ql_author_fontweight",$blog_standard_type_ql_author_fontweight);

$row3 = new ElatedRow(true);
$group9->addChild("row3",$row3);

$blog_standard_type_ql_author_letterspacing = new ElatedField("textsimple","blog_standard_type_ql_author_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_standard_type_ql_author_letterspacing",$blog_standard_type_ql_author_letterspacing);

// Blog Post List - Blog: Vertical Loop
$panel22 = new ElatedPanel("Blog List Template Options: Vertical Loop","blog_vertical_loop_post_lists", "blog_vertical_loop_show_options", "no");
$blogPage->addChild("panel22",$panel22);

$blog_vertical_loop_type_number_of_chars = new ElatedField("text","blog_vertical_loop_type_number_of_chars","45","Number of Words in Excerpt",' Enter a number of words in excerpt (article summary)', array(), array("col_width" => 3));
$panel22->addChild("blog_vertical_loop_type_number_of_chars",$blog_vertical_loop_type_number_of_chars);

$blog_vertical_loop_type_post_meta_data_section = new ElatedTitle("blog_vertical_loop_type_post_meta_data_section", "Post Info Data Fields");
$panel22->addChild("blog_vertical_loop_type_post_meta_data_section", $blog_vertical_loop_type_post_meta_data_section);

$blog_vertical_loop_type_show_categories = new ElatedField("yesno","blog_vertical_loop_type_show_categories","yes","Show Categories","Enabling this option will Show Categories on Post List");
$panel22->addChild("blog_vertical_loop_type_show_categories",$blog_vertical_loop_type_show_categories);

$blog_vertical_loop_type_show_comments = new ElatedField("yesno","blog_vertical_loop_type_show_comments","no","Show Comments","Enabling this option will Show Comments on Post List");
$panel22->addChild("blog_vertical_loop_type_show_comments",$blog_vertical_loop_type_show_comments);

$blog_vertical_loop_type_show_author = new ElatedField("yesno","blog_vertical_loop_type_show_author","yes","Show Author Name","Enabling this option will show author name on Post List and Blog Post Single");
$panel22->addChild("blog_vertical_loop_type_show_author",$blog_vertical_loop_type_show_author);

$blog_vertical_loop_type_show_date = new ElatedField("yesno","blog_vertical_loop_type_show_date","yes","Show Date","Enabling this option will show date on Post List");
$panel22->addChild("blog_vertical_loop_type_hide_date",$blog_vertical_loop_type_show_date);

$blog_vertical_loop_type_show_share = new ElatedField("yesno","blog_vertical_loop_type_show_share","no","Show Share","Enabling this option will show share on Post List", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_vertical_loop_type_share_options_container"));
$panel22->addChild("blog_vertical_loop_type_show_share",$blog_vertical_loop_type_show_share);

$blog_vertical_loop_type_share_options_container = new ElatedContainer("blog_vertical_loop_type_share_options_container","blog_vertical_loop_type_show_share","no");
$panel22->addChild("blog_vertical_loop_type_share_options_container",$blog_vertical_loop_type_share_options_container);

$blog_vertical_loop_type_select_share_option = new ElatedField("select","blog_vertical_loop_type_select_share_option","dropdown","Social Share Style","Choose Social Share Style for Standard Type",array(
	"dropdown" => "Social Share Dropdown",
	"list" => "Social Share List"
));

$blog_vertical_loop_type_share_options_container->addChild("blog_vertical_loop_type_select_share_option",$blog_vertical_loop_type_select_share_option);

$blog_vertical_loop_type_share_icon_color = new ElatedField("color","blog_vertical_loop_type_share_icon_color","","Icon Color","Choose icon color for dropdown and list share type");
$blog_vertical_loop_type_share_options_container->addChild("blog_vertical_loop_type_share_icon_color",$blog_vertical_loop_type_share_icon_color);

$blog_vertical_loop_type_share_icon_hover_color = new ElatedField("color","blog_vertical_loop_type_share_icon_hover_color","","Icon Hover Color","Choose icon hover color for dropdown and list Share Type");
$blog_vertical_loop_type_share_options_container->addChild("blog_vertical_loop_type_share_icon_hover_color",$blog_vertical_loop_type_share_icon_hover_color);

$blog_vertical_loop_type_share_background_color = new ElatedField("color","blog_vertical_loop_type_share_background_color","","Background Color","Choose background color for dropdown share type");
$blog_vertical_loop_type_share_options_container->addChild("blog_vertical_loop_type_share_background_color",$blog_vertical_loop_type_share_background_color);

$blog_vertical_loop_type_show_like = new ElatedField("yesno","blog_vertical_loop_type_show_like","no","Show Likes",'Enabling this option will turn on "Likes"');
$panel22->addChild("blog_vertical_loop_type_show_like",$blog_vertical_loop_type_show_like);

$blog_vertical_loop_type_post_design_style = new ElatedTitle("blog_vertical_loop_type_post_design_style", "Post Design Style");
$panel22->addChild("blog_vertical_loop_type_post_design_style", $blog_vertical_loop_type_post_design_style);

$blog_vertical_loop_subtitle_on_single = new ElatedField("yesno","blog_vertical_loop_subtitle_on_single","no","Enable Subtitle on single post pages","Enable Subtitle on single post pages", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_vertical_loop_type_enable_text_box_container"));
$panel22->addChild("blog_vertical_loop_subtitle_on_single",$blog_vertical_loop_subtitle_on_single);

$blog_vertical_loop_type_enable_text_box = new ElatedField("yesno","blog_vertical_loop_type_enable_text_box","no","Enable Boxed Styled Post Content","Enable post text boxed features", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_vertical_loop_type_enable_text_box_container"));
$panel22->addChild("blog_vertical_loop_type_enable_text_box",$blog_vertical_loop_type_enable_text_box);

$blog_vertical_loop_type_enable_text_box_container = new ElatedContainer("blog_vertical_loop_type_enable_text_box_container","blog_vertical_loop_type_enable_text_box","no");
$panel22->addChild("blog_vertical_loop_type_enable_text_box_container",$blog_vertical_loop_type_enable_text_box_container);

$blog_vertical_loop_type_box_background_color = new ElatedField("color","blog_vertical_loop_type_box_background_color","","Background Color","Choose background color for post text box");
$blog_vertical_loop_type_enable_text_box_container->addChild("blog_vertical_loop_type_box_background_color",$blog_vertical_loop_type_box_background_color);

$blog_vertical_loop_type_box_border_color = new ElatedField("color","blog_vertical_loop_type_box_border_color","","Border Color","Choose border color for post text box");
$blog_vertical_loop_type_enable_text_box_container->addChild("blog_vertical_loop_type_box_border_color",$blog_vertical_loop_type_box_border_color);

$blog_vertical_loop_type_box_padding = new ElatedField("text","blog_vertical_loop_type_box_padding","","Text box padding","Please insert padding in format (top right bottom left) i.e. 5px 5px 5px 5px", array(), array("col_width" => 3));
$blog_vertical_loop_type_enable_text_box_container->addChild("blog_vertical_loop_type_box_padding",$blog_vertical_loop_type_box_padding);

$group1 = new ElatedGroup("Quote/Link Background","Set background of Quote/Link post type");
$panel22->addChild("group1",$group1);

$row1 = new ElatedRow();
$group1->addChild("row1",$row1);

$blog_vertical_loop_type_ql_background_color = new ElatedField("colorsimple","blog_vertical_loop_type_ql_background_color","","Background Color","Default color is #ffffff.");
$row1->addChild("blog_vertical_loop_type_ql_background_color",$blog_vertical_loop_type_ql_background_color);

$blog_vertical_loop_type_ql_hover_background_color = new ElatedField("colorsimple","blog_vertical_loop_type_ql_hover_background_color","","Background Hover Color","Default color is #e6ae48.");
$row1->addChild("blog_vertical_loop_type_ql_hover_background_color",$blog_vertical_loop_type_ql_hover_background_color);

$blog_vertical_loop_type_show_ql_mark = new ElatedField("yesno","blog_vertical_loop_type_show_ql_mark","yes","Enable Quote/Link Icon","Show Icons for Quote/Link Post Format", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_blog_vertical_loop_type_show_ql_mark_container"));
$panel22->addChild("blog_vertical_loop_type_show_ql_mark",$blog_vertical_loop_type_show_ql_mark);

$blog_vertical_loop_type_show_ql_mark_container = new ElatedContainer("blog_vertical_loop_type_show_ql_mark_container","blog_vertical_loop_type_show_ql_mark","no");
$panel22->addChild("blog_vertical_loop_type_show_ql_mark_container",$blog_vertical_loop_type_show_ql_mark_container);

$row1 = new ElatedRow();
$blog_vertical_loop_type_show_ql_mark_container->addChild("row1",$row1);

$blog_vertical_loop_type_ql_mark_color = new ElatedField("color","blog_vertical_loop_type_ql_mark_color","","Icon Color","Choose icon color for quote/link post.");
$row1->addChild("blog_vertical_loop_type_ql_mark_color",$blog_vertical_loop_type_ql_mark_color);

$blog_vertical_loop_type_ql_mark_hover_color = new ElatedField("color","blog_vertical_loop_type_ql_mark_hover_color","","Icon Hover Color","Choose hover icon color for quote/link post.");
$row1->addChild("blog_vertical_loop_type_ql_mark_hover_color",$blog_vertical_loop_type_ql_mark_hover_color);

$blog_vertical_loop_type_image_height = new ElatedField("text","blog_vertical_loop_type_image_height","","Image Height","Define image height for current and next article",array(), array("col_width" => 3));
$panel22->addChild("blog_vertical_loop_type_image_height",$blog_vertical_loop_type_image_height);

$group11 = new ElatedGroup("Blog List Spacing","Set spacing for blog layouts");
$panel22->addChild("group11",$group11);

$row1 = new ElatedRow();
$group11->addChild("row1",$row1);

$blog_vertical_loop_type_image_margin_bottom = new ElatedField("textsimple","blog_vertical_loop_type_image_margin_bottom","","Margin Under Image (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_image_margin_bottom",$blog_vertical_loop_type_image_margin_bottom);

$blog_vertical_loop_type_title_margin_bottom = new ElatedField("textsimple","blog_vertical_loop_type_title_margin_bottom","","Margin Under Title (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_title_margin_bottom",$blog_vertical_loop_type_title_margin_bottom);

$blog_vertical_loop_type_post_info_margin_bottom = new ElatedField("textsimple","blog_vertical_loop_type_post_info_margin_bottom","","Margin Under Post Info (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_post_info_margin_bottom",$blog_vertical_loop_type_post_info_margin_bottom);

$blog_vertical_loop_type_article_margin_bottom = new ElatedField("textsimple","blog_vertical_loop_type_article_margin_bottom","","Margin Between Articles (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_article_margin_bottom",$blog_vertical_loop_type_article_margin_bottom);

$row2 = new ElatedRow();
$group11->addChild("row2",$row2);

$blog_vertical_loop_subtitle_margin_bottom = new ElatedField("textsimple","blog_vertical_loop_subtitle_margin_bottom","","Margin Under Post Subtitle (px)","This is some description");
$row2->addChild("blog_vertical_loop_subtitle_margin_bottom",$blog_vertical_loop_subtitle_margin_bottom);

$blog_vertical_loop_type_single_article_social_share_list_margin_top = new ElatedField("textsimple","blog_vertical_loop_type_single_article_social_share_list_margin_top","","Margin Above Social Share List Holder (px)","This is some description");
$row2->addChild("blog_vertical_loop_type_single_article_social_share_list_margin_top",$blog_vertical_loop_type_single_article_social_share_list_margin_top);

$group12 = new ElatedGroup("Blog List Spacing for Quote and Link Post Type","Set spacing for blog layouts");
$panel22->addChild("group12",$group12);

$row1 = new ElatedRow();
$group12->addChild("row1",$row1);

$blog_vertical_loop_type_ql_title_margin_bottom = new ElatedField("textsimple","blog_vertical_loop_type_ql_title_margin_bottom","","Margin Under Title (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_title_margin_bottom",$blog_vertical_loop_type_ql_title_margin_bottom);

$blog_vertical_loop_type_ql_social_share_list_margin_top = new ElatedField("textsimple","blog_vertical_loop_type_ql_social_share_list_margin_top","","Margin Above Social Share List (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_social_share_list_margin_top",$blog_vertical_loop_type_ql_social_share_list_margin_top);

$blog_vertical_loop_type_ql_quote_author_margin_bottom = new ElatedField("textsimple","blog_vertical_loop_type_ql_quote_author_margin_bottom","","Margin Under Quote Author (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_quote_author_margin_bottom",$blog_vertical_loop_type_ql_quote_author_margin_bottom);

$post_text_styling= new ElatedTitle("post_text_styling", "Post Text Style");
$panel22->addChild("post_text_styling", $post_text_styling);

$group5 = new ElatedGroup("Post Title","Define title styles in this blog post template.");
$panel22->addChild("group5",$group5);

$row1 = new ElatedRow();
$group5->addChild("row1",$row1);

$blog_vertical_loop_type_title_color = new ElatedField("colorsimple","blog_vertical_loop_type_title_color","","Text Color","This is some description");
$row1->addChild("blog_vertical_loop_type_title_color",$blog_vertical_loop_type_title_color);

$blog_vertical_loop_type_title_hover_color = new ElatedField("colorsimple","blog_vertical_loop_type_title_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_vertical_loop_type_title_hover_color",$blog_vertical_loop_type_title_hover_color);

$blog_vertical_loop_type_title_fontsize = new ElatedField("textsimple","blog_vertical_loop_type_title_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_title_fontsize",$blog_vertical_loop_type_title_fontsize);

$blog_vertical_loop_type_title_lineheight = new ElatedField("textsimple","blog_vertical_loop_type_title_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_title_lineheight",$blog_vertical_loop_type_title_lineheight);

$row2 = new ElatedRow(true);
$group5->addChild("row2",$row2);

$blog_vertical_loop_type_title_texttransform = new ElatedField("selectblanksimple","blog_vertical_loop_type_title_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_vertical_loop_type_title_texttransform",$blog_vertical_loop_type_title_texttransform);

$blog_vertical_loop_type_title_google_fonts = new ElatedField("Fontsimple","blog_vertical_loop_type_title_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_vertical_loop_type_title_google_fonts",$blog_vertical_loop_type_title_google_fonts);

$blog_vertical_loop_type_title_fontstyle = new ElatedField("selectblanksimple","blog_vertical_loop_type_title_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_vertical_loop_type_title_fontstyle",$blog_vertical_loop_type_title_fontstyle);

$blog_vertical_loop_type_title_fontweight = new ElatedField("selectblanksimple","blog_vertical_loop_type_title_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_vertical_loop_type_title_fontweight",$blog_vertical_loop_type_title_fontweight);

$row3 = new ElatedRow(true);
$group5->addChild("row3",$row3);

$blog_vertical_loop_type_title_letterspacing = new ElatedField("textsimple","blog_vertical_loop_type_title_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_vertical_loop_type_title_letterspacing",$blog_vertical_loop_type_title_letterspacing);

$group_vertical_subtitle = new ElatedGroup("Post Subtitle","Define subtitle styles in this blog post template.");
$panel22->addChild("group_vertical_subtitle",$group_vertical_subtitle);

$row1 = new ElatedRow();
$group_vertical_subtitle->addChild("row1",$row1);

$blog_vertical_loop_subtitle_color = new ElatedField("colorsimple","blog_vertical_loop_subtitle_color","","Text Color","This is some description");
$row1->addChild("blog_vertical_loop_subtitle_color",$blog_vertical_loop_subtitle_color);

$blog_vertical_loop_subtitle_hover_color = new ElatedField("colorsimple","blog_vertical_loop_subtitle_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_vertical_loop_subtitle_hover_color",$blog_vertical_loop_subtitle_hover_color);

$blog_vertical_loop_subtitle_fontsize = new ElatedField("textsimple","blog_vertical_loop_subtitle_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_vertical_loop_subtitle_fontsize",$blog_vertical_loop_subtitle_fontsize);

$blog_vertical_loop_subtitle_lineheight = new ElatedField("textsimple","blog_vertical_loop_subtitle_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_vertical_loop_subtitle_lineheight",$blog_vertical_loop_subtitle_lineheight);

$row2 = new ElatedRow(true);
$group_vertical_subtitle->addChild("row2",$row2);

$blog_vertical_loop_subtitle_texttransform = new ElatedField("selectblanksimple","blog_vertical_loop_subtitle_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_vertical_loop_subtitle_texttransform",$blog_vertical_loop_subtitle_texttransform);

$blog_vertical_loop_subtitle_google_fonts = new ElatedField("Fontsimple","blog_vertical_loop_subtitle_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_vertical_loop_subtitle_google_fonts",$blog_vertical_loop_subtitle_google_fonts);

$blog_vertical_loop_subtitle_fontstyle = new ElatedField("selectblanksimple","blog_vertical_loop_subtitle_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_vertical_loop_subtitle_fontstyle",$blog_vertical_loop_subtitle_fontstyle);

$blog_vertical_loop_subtitle_fontweight = new ElatedField("selectblanksimple","blog_vertical_loop_subtitle_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_vertical_loop_subtitle_fontweight",$blog_vertical_loop_subtitle_fontweight);

$row3 = new ElatedRow(true);
$group_vertical_subtitle->addChild("row3",$row3);

$blog_vertical_loop_subtitle_letterspacing = new ElatedField("textsimple","blog_vertical_loop_subtitle_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_vertical_loop_subtitle_letterspacing",$blog_vertical_loop_subtitle_letterspacing);

$group7 = new ElatedGroup("Post Info Data","Define post info text styles (date, category names etc.) Note: Single Posts will take the same styles as in list");
$panel22->addChild("group7",$group7);

$row1 = new ElatedRow();
$group7->addChild("row1",$row1);

$blog_vertical_loop_type_info_color = new ElatedField("colorsimple","blog_vertical_loop_type_info_color","","Text Color","This is some description");
$row1->addChild("blog_vertical_loop_type_info_color",$blog_vertical_loop_type_info_color);

$blog_vertical_loop_type_info_link_color = new ElatedField("colorsimple","blog_vertical_loop_type_info_link_color","","Link Color","This is some description");
$row1->addChild("blog_vertical_loop_type_info_link_color",$blog_vertical_loop_type_info_link_color);

$blog_vertical_loop_type_info_hover_color = new ElatedField("colorsimple","blog_vertical_loop_type_info_hover_color","","Link Hover Color","This is some description");
$row1->addChild("blog_vertical_loop_type_info_hover_color",$blog_vertical_loop_type_info_hover_color);

$blog_vertical_loop_type_info_fontsize = new ElatedField("textsimple","blog_vertical_loop_type_info_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_info_fontsize",$blog_vertical_loop_type_info_fontsize);

$row2 = new ElatedRow(true);
$group7->addChild("row2",$row2);

$blog_vertical_loop_type_info_lineheight = new ElatedField("textsimple","blog_vertical_loop_type_info_lineheight","","Line Height (px)","This is some description");
$row2->addChild("blog_vertical_loop_type_info_lineheight",$blog_vertical_loop_type_info_lineheight);

$blog_vertical_loop_type_info_google_fonts = new ElatedField("Fontsimple","blog_vertical_loop_type_info_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_vertical_loop_type_info_google_fonts",$blog_vertical_loop_type_info_google_fonts);

$blog_vertical_loop_type_info_fontstyle = new ElatedField("selectblanksimple","blog_vertical_loop_type_info_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_vertical_loop_type_info_fontstyle",$blog_vertical_loop_type_info_fontstyle);

$blog_vertical_loop_type_info_fontweight = new ElatedField("selectblanksimple","blog_vertical_loop_type_info_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_vertical_loop_type_info_fontweight",$blog_vertical_loop_type_info_fontweight);

$row3 = new ElatedRow(true);
$group7->addChild("row3",$row3);

$blog_vertical_loop_type_info_texttransform = new ElatedField("selectblanksimple","blog_vertical_loop_type_info_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row3->addChild("blog_vertical_loop_type_info_texttransform",$blog_vertical_loop_type_info_texttransform);

$blog_vertical_loop_type_info_letterspacing = new ElatedField("textsimple","blog_vertical_loop_type_info_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_vertical_loop_type_info_letterspacing",$blog_vertical_loop_type_info_letterspacing);

$group6 = new ElatedGroup("Quote/Link Title Style","Define title styles for Quote/Link articles");
$panel22->addChild("group6",$group6);

$row1 = new ElatedRow();
$group6->addChild("row1",$row1);

$blog_vertical_loop_type_ql_title_color = new ElatedField("colorsimple","blog_vertical_loop_type_ql_title_color","","Text Color","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_title_color",$blog_vertical_loop_type_ql_title_color);

$blog_vertical_loop_type_ql_title_hover_color = new ElatedField("colorsimple","blog_vertical_loop_type_ql_title_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_title_hover_color",$blog_vertical_loop_type_ql_title_hover_color);

$blog_vertical_loop_type_ql_title_fontsize = new ElatedField("textsimple","blog_vertical_loop_type_ql_title_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_title_font_size",$blog_vertical_loop_type_ql_title_fontsize);

$blog_vertical_loop_type_ql_title_lineheight = new ElatedField("textsimple","blog_vertical_loop_type_ql_title_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_title_lineheight",$blog_vertical_loop_type_ql_title_lineheight);


$row2 = new ElatedRow(true);
$group6->addChild("row2",$row2);

$blog_vertical_loop_type_ql_title_texttransform = new ElatedField("selectblanksimple","blog_vertical_loop_type_ql_title_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_vertical_loop_type_ql_title_texttransform",$blog_vertical_loop_type_ql_title_texttransform);

$blog_vertical_loop_type_ql_title_google_fonts = new ElatedField("Fontsimple","blog_vertical_loop_type_ql_title_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_vertical_loop_type_ql_title_google_fonts",$blog_vertical_loop_type_ql_title_google_fonts);

$blog_vertical_loop_type_ql_title_fontstyle = new ElatedField("selectblanksimple","blog_vertical_loop_type_ql_title_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_vertical_loop_type_ql_title_fontstyle",$blog_vertical_loop_type_ql_title_fontstyle);

$blog_vertical_loop_type_ql_title_fontweight = new ElatedField("selectblanksimple","blog_vertical_loop_type_ql_title_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_vertical_loop_type_ql_title_fontweight",$blog_vertical_loop_type_ql_title_fontweight);

$row3 = new ElatedRow(true);
$group6->addChild("row3",$row3);

$blog_vertical_loop_type_ql_title_letterspacing = new ElatedField("textsimple","blog_vertical_loop_type_ql_title_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_vertical_loop_type_ql_title_letterspacing",$blog_vertical_loop_type_ql_title_letterspacing);

$group8 = new ElatedGroup("Quote/Link Post Info Data","Define quote/link post info text styles (date, category names etc.) Note: Single Posts will take the same styles as in list.");
$panel22->addChild("group8",$group8);

$row1 = new ElatedRow();
$group8->addChild("row1",$row1);

$blog_vertical_loop_type_ql_info_color = new ElatedField("colorsimple","blog_vertical_loop_type_ql_info_color","","Text Color","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_info_color",$blog_vertical_loop_type_ql_info_color);

$blog_vertical_loop_type_ql_info_link_color = new ElatedField("colorsimple","blog_vertical_loop_type_ql_info_link_color","","Link Color","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_info_link_color",$blog_vertical_loop_type_ql_info_link_color);

$blog_vertical_loop_type_ql_info_hover_color = new ElatedField("colorsimple","blog_vertical_loop_type_ql_info_hover_color","","Hover Color","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_info_hover_color",$blog_vertical_loop_type_ql_info_hover_color);

$blog_vertical_loop_type_ql_info_fontsize = new ElatedField("textsimple","blog_vertical_loop_type_ql_info_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_info_fontsize",$blog_vertical_loop_type_ql_info_fontsize);

$row2 = new ElatedRow(true);
$group8->addChild("row2",$row2);


$blog_vertical_loop_type_ql_info_lineheight = new ElatedField("textsimple","blog_vertical_loop_type_ql_info_lineheight","","Line Height (px)","This is some description");
$row2->addChild("blog_vertical_loop_type_ql_info_lineheight",$blog_vertical_loop_type_ql_info_lineheight);

$blog_vertical_loop_type_ql_info_google_fonts = new ElatedField("Fontsimple","blog_vertical_loop_type_ql_info_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_vertical_loop_type_ql_info_google_fonts",$blog_vertical_loop_type_ql_info_google_fonts);

$blog_vertical_loop_type_ql_info_fontstyle = new ElatedField("selectblanksimple","blog_vertical_loop_type_ql_info_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_vertical_loop_type_ql_info_fontstyle",$blog_vertical_loop_type_ql_info_fontstyle);

$blog_vertical_loop_type_ql_info_fontweight = new ElatedField("selectblanksimple","blog_vertical_loop_type_ql_info_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_vertical_loop_type_ql_info_fontweight",$blog_vertical_loop_type_ql_info_fontweight);

$row3 = new ElatedRow(true);
$group8->addChild("row3",$row3);

$blog_vertical_loop_type_ql_info_texttransform = new ElatedField("selectblanksimple","blog_vertical_loop_type_ql_info_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row3->addChild("blog_vertical_loop_type_ql_info_texttransform",$blog_vertical_loop_type_ql_info_texttransform);

$blog_vertical_loop_type_ql_info_letterspacing = new ElatedField("textsimple","blog_vertical_loop_type_ql_info_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_vertical_loop_type_ql_info_letterspacing",$blog_vertical_loop_type_ql_info_letterspacing);

$group9 = new ElatedGroup("Quote Author Style","Define author styles for Quote articles");
$panel22->addChild("group9",$group9);

$row1 = new ElatedRow();
$group9->addChild("row1",$row1);

$blog_vertical_loop_type_ql_author_color = new ElatedField("colorsimple","blog_vertical_loop_type_ql_author_color","","Text Color","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_author_color",$blog_vertical_loop_type_ql_author_color);

$blog_vertical_loop_type_ql_author_hover_color = new ElatedField("colorsimple","blog_vertical_loop_type_ql_author_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_author_hover_color",$blog_vertical_loop_type_ql_author_hover_color);

$blog_vertical_loop_type_ql_author_fontsize = new ElatedField("textsimple","blog_vertical_loop_type_ql_author_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_author_font_size",$blog_vertical_loop_type_ql_author_fontsize);

$blog_vertical_loop_type_ql_author_lineheight = new ElatedField("textsimple","blog_vertical_loop_type_ql_author_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_ql_author_lineheight",$blog_vertical_loop_type_ql_author_lineheight);


$row2 = new ElatedRow(true);
$group9->addChild("row2",$row2);

$blog_vertical_loop_type_ql_author_texttransform = new ElatedField("selectblanksimple","blog_vertical_loop_type_ql_author_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_vertical_loop_type_ql_author_texttransform",$blog_vertical_loop_type_ql_author_texttransform);

$blog_vertical_loop_type_ql_author_google_fonts = new ElatedField("Fontsimple","blog_vertical_loop_type_ql_author_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_vertical_loop_type_ql_author_google_fonts",$blog_vertical_loop_type_ql_author_google_fonts);

$blog_vertical_loop_type_ql_author_fontstyle = new ElatedField("selectblanksimple","blog_vertical_loop_type_ql_author_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_vertical_loop_type_ql_author_fontstyle",$blog_vertical_loop_type_ql_author_fontstyle);

$blog_vertical_loop_type_ql_author_fontweight = new ElatedField("selectblanksimple","blog_vertical_loop_type_ql_author_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_vertical_loop_type_ql_author_fontweight",$blog_vertical_loop_type_ql_author_fontweight);

$row3 = new ElatedRow(true);
$group9->addChild("row3",$row3);

$blog_vertical_loop_type_ql_author_letterspacing = new ElatedField("textsimple","blog_vertical_loop_type_ql_author_letterspacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_vertical_loop_type_ql_author_letterspacing",$blog_vertical_loop_type_ql_author_letterspacing);

$post_vertical_loop_type_next_article_title = new ElatedTitle("post_vertical_loop_type_next_article_title", "Next Article Styles");
$panel22->addChild("post_vertical_loop_type_next_article_title", $post_vertical_loop_type_next_article_title);

$group10 = new ElatedGroup("Title Style","Define title styles for next article");
$panel22->addChild("group10",$group10);

$row1 = new ElatedRow();
$group10->addChild("row1",$row1);

$blog_vertical_loop_type_next_article_title_color = new ElatedField("colorsimple","blog_vertical_loop_type_next_article_title_color","","Text Color","This is some description");
$row1->addChild("blog_vertical_loop_type_next_article_title_color",$blog_vertical_loop_type_next_article_title_color);

$blog_vertical_loop_type_next_article_title_fontsize = new ElatedField("textsimple","blog_vertical_loop_type_next_article_title_fontsize","","Font Size (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_next_article_title_fontsize",$blog_vertical_loop_type_next_article_title_fontsize);

$blog_vertical_loop_type_next_article_title_lineheight = new ElatedField("textsimple","blog_vertical_loop_type_next_article_title_lineheight","","Line Height (px)","This is some description");
$row1->addChild("blog_vertical_loop_type_next_article_title_lineheight",$blog_vertical_loop_type_next_article_title_lineheight);

$blog_vertical_loop_type_next_article_title_texttransform = new ElatedField("selectblanksimple","blog_vertical_loop_type_next_article_title_texttransform","","Text Transform","This is some description",$eltd_options_texttransform);
$row1->addChild("blog_vertical_loop_type_next_article_title_texttransform",$blog_vertical_loop_type_next_article_title_texttransform);

$row2 = new ElatedRow(true);
$group10->addChild("row2",$row2);

$blog_vertical_loop_type_next_article_title_google_fonts = new ElatedField("Fontsimple","blog_vertical_loop_type_next_article_title_google_fonts","-1","Font Family","This is some description");
$row2->addChild("blog_vertical_loop_type_next_article_title_google_fonts",$blog_vertical_loop_type_next_article_title_google_fonts);

$blog_vertical_loop_type_next_article_title_fontstyle = new ElatedField("selectblanksimple","blog_vertical_loop_type_next_article_title_fontstyle","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_vertical_loop_type_next_article_title_fontstyle",$blog_vertical_loop_type_next_article_title_fontstyle);

$blog_vertical_loop_type_next_article_title_fontweight = new ElatedField("selectblanksimple","blog_vertical_loop_type_next_article_title_fontweight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_vertical_loop_type_next_article_title_fontweight",$blog_vertical_loop_type_next_article_title_fontweight);

$blog_vertical_loop_type_next_article_title_letterspacing = new ElatedField("textsimple","blog_vertical_loop_type_next_article_title_letterspacing","","Letter Spacing (px)","This is some description");
$row2->addChild("blog_vertical_loop_type_next_article_title_letterspacing",$blog_vertical_loop_type_next_article_title_letterspacing);

$row3 = new ElatedRow(true);
$group10->addChild("row3",$row3);

$blog_vertical_loop_type_next_article_title_position = new ElatedField("selectsimple","blog_vertical_loop_type_next_article_title_position","dropdown","Title Position","Choose title position for next article",array(
	"center" => "Center",
	"left" => "Left",
	"right" => "Right"
));

$row3->addChild("blog_vertical_loop_type_next_article_title_position",$blog_vertical_loop_type_next_article_title_position);

$post_vertical_loop_type_next_previous_arrow_title = new ElatedTitle("post_vertical_loop_type_next_previous_arrow_title", "Previous/Next Article Arrow Style");
$panel22->addChild("post_vertical_loop_type_next_previous_arrow_title", $post_vertical_loop_type_next_previous_arrow_title);

$group13 = new ElatedGroup("Article Arrow Style","Define arrow styles for next article");
$panel22->addChild("group13",$group13);

$row1 = new ElatedRow();
$group13->addChild("row1",$row1);

$blog_vertical_loop_type_next_article_arrow_background_color = new ElatedField("colorsimple","blog_vertical_loop_type_next_article_arrow_background_color","","Background Color","This is some description");
$row1->addChild("blog_vertical_loop_type_next_article_arrow_background_color",$blog_vertical_loop_type_next_article_arrow_background_color);

$blog_vertical_loop_type_next_article_arrow_color = new ElatedField("colorsimple","blog_vertical_loop_type_next_article_arrow_color","","Arrow Color","This is some description");
$row1->addChild("blog_vertical_loop_type_next_article_arrow_color",$blog_vertical_loop_type_next_article_arrow_color);

$blog_vertical_loop_type_next_article_arrow_background_hover_color = new ElatedField("colorsimple","blog_vertical_loop_type_next_article_arrow_background_hover_color","","Background Hover Color","This is some description");
$row1->addChild("blog_vertical_loop_type_next_article_arrow_background_hover_color",$blog_vertical_loop_type_next_article_arrow_background_hover_color);

$blog_vertical_loop_type_next_article_arrow_color_hover = new ElatedField("colorsimple","blog_vertical_loop_type_next_article_arrow_color_hover","","Arrow Hover Color","This is some description");
$row1->addChild("blog_vertical_loop_type_next_article_arrow_color_hover",$blog_vertical_loop_type_next_article_arrow_color_hover);

$row2 = new ElatedRow();
$group13->addChild("row2",$row2);

$blog_vertical_loop_type_next_article_arrow_size = new ElatedField("textsimple","blog_vertical_loop_type_next_article_arrow_size","","Arrow Size","This is some description");
$row2->addChild("blog_vertical_loop_type_next_article_arrow_size",$blog_vertical_loop_type_next_article_arrow_size);

$blog_vertical_loop_type_next_article_font_weight = new ElatedField("selectblanksimple","blog_vertical_loop_type_next_article_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_vertical_loop_type_next_article_font_weight",$blog_vertical_loop_type_next_article_font_weight);

//Blog List Shortcodes

$panel28 = new ElatedPanel("Blog List Shortcodes","blog_list_panel");
$blogPage->addChild("panel28",$panel28);

//Blog List Boxes

$blog_list_boxes_section_subtitle = new ElatedTitle("blog_list_boxes_section_subtitle", "Blog List - Boxes");
$panel28->addChild("blog_list_boxes_section_subtitle", $blog_list_boxes_section_subtitle);

$group6 = new ElatedGroup("Blog List Padding","Enter Boxes Blog List padding");
$panel28->addChild("group6",$group6);
$row1 = new ElatedRow();
$group6->addChild("row1",$row1);

$blog_list_boxes_padding_top = new ElatedField("textsimple","blog_list_boxes_padding_top","","Padding Top (px)","This is some description");
$row1->addChild("blog_list_boxes_padding_top",$blog_list_boxes_padding_top);

$blog_list_boxes_padding_right = new ElatedField("textsimple","blog_list_boxes_padding_right","","Padding Right (px)","This is some description");
$row1->addChild("blog_list_boxes_padding_right",$blog_list_boxes_padding_right);

$blog_list_boxes_padding_bottom = new ElatedField("textsimple","blog_list_boxes_padding_bottom","","Padding Bottom (px)","This is some description");
$row1->addChild("blog_list_boxes_padding_bottom",$blog_list_boxes_padding_bottom);

$blog_list_boxes_padding_left = new ElatedField("textsimple","blog_list_boxes_padding_left","","Padding Left (px)","This is some description");
$row1->addChild("blog_list_boxes_padding_left",$blog_list_boxes_padding_left);

$group16 = new ElatedGroup("Blog List Spacing","Define blog list spacing");
$panel28->addChild("group16",$group16);

$row1 = new ElatedRow();
$group16->addChild("row1",$row1);

$blog_list_boxes_title_margin_bottom = new ElatedField("textsimple","blog_list_boxes_title_margin_bottom","","Margin Under Title (px)","This is some description");
$row1->addChild("blog_list_boxes_title_margin_bottom",$blog_list_boxes_title_margin_bottom);

$blog_list_boxes_post_info_margin_bottom = new ElatedField("textsimple","blog_list_boxes_post_info_margin_bottom","","Margin Under Post Info (px)","This is some description");
$row1->addChild("blog_list_boxes_post_info_margin_bottom",$blog_list_boxes_post_info_margin_bottom);

$blog_list_boxes_read_more_margin_top = new ElatedField("textsimple","blog_list_boxes_read_more_margin_top","","Margin Above Read More Button (px)","This is some description");
$row1->addChild("blog_list_boxes_read_more_margin_top",$blog_list_boxes_read_more_margin_top);

$group17 = new ElatedGroup("Blog List Title","Define Blog List title style");
$panel28->addChild("group17",$group17);

$row1 = new ElatedRow();
$group17->addChild("row1",$row1);

$blog_list_boxes_title_color = new ElatedField("colorsimple","blog_list_boxes_title_color","","Text Color","This is some description");
$row1->addChild("blog_list_boxes_title_color",$blog_list_boxes_title_color);

$blog_list_boxes_title_hover_color = new ElatedField("colorsimple","blog_list_boxes_title_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_list_boxes_title_hover_color",$blog_list_boxes_title_hover_color);

$blog_list_boxes_title_font_size = new ElatedField("textsimple","blog_list_boxes_title_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_list_boxes_title_font_size",$blog_list_boxes_title_font_size);

$blog_list_boxes_title_line_height = new ElatedField("textsimple","blog_list_boxes_title_line_height","","Line Height (px)","This is some description");
$row1->addChild("blog_list_boxes_title_line_height",$blog_list_boxes_title_line_height);

$row2 = new ElatedRow();
$group17->addChild("row2",$row2);

$blog_list_boxes_title_text_transform = new ElatedField("selectblanksimple","blog_list_boxes_title_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_list_boxes_title_text_transform",$blog_list_boxes_title_text_transform);

$blog_list_boxes_title_font_family = new ElatedField("Fontsimple","blog_list_boxes_title_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_list_boxes_title_font_family",$blog_list_boxes_title_font_family);

$blog_list_boxes_title_font_style = new ElatedField("selectblanksimple","blog_list_boxes_title_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_list_boxes_title_font_style",$blog_list_boxes_title_font_style);

$blog_list_boxes_title_font_weight = new ElatedField("selectblanksimple","blog_list_boxes_title_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_list_boxes_title_font_weight",$blog_list_boxes_title_font_weight);


$row3 = new ElatedRow();
$group17->addChild("row3",$row3);

$blog_list_boxes_title_letter_spacing = new ElatedField("textsimple","blog_list_boxes_title_letter_spacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_list_boxes_title_letter_spacing",$blog_list_boxes_title_letter_spacing);


$group18 = new ElatedGroup("Blog List Post Info","Define blog list post info style");
$panel28->addChild("group18",$group18);

$row1 = new ElatedRow();
$group18->addChild("row1",$row1);

$blog_list_boxes_post_info_color = new ElatedField("colorsimple","blog_list_boxes_post_info_color","","Text Color","This is some description");
$row1->addChild("blog_list_boxes_post_info_color",$blog_list_boxes_post_info_color);

$blog_list_boxes_post_info_link_color = new ElatedField("colorsimple","blog_list_boxes_post_info_link_color","","Link Color","This is some description");
$row1->addChild("blog_list_boxes_post_info_link_color",$blog_list_boxes_post_info_link_color);

$blog_list_boxes_post_info_link_hover_color = new ElatedField("colorsimple","blog_list_boxes_post_info_link_hover_color","","Link Hover Color","This is some description");
$row1->addChild("blog_list_boxes_post_info_link_hover_color",$blog_list_boxes_post_info_link_hover_color);

$blog_list_boxes_post_info_font_size = new ElatedField("textsimple","blog_list_boxes_post_info_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_list_boxes_post_info_font_size",$blog_list_boxes_post_info_font_size);


$row2 = new ElatedRow();
$group18->addChild("row2",$row2);

$blog_list_boxes_post_info_line_height = new ElatedField("textsimple","blog_list_boxes_post_info_line_height","","Line Height (px)","This is some description");
$row2->addChild("blog_list_boxes_post_info_line_height",$blog_list_boxes_post_info_line_height);

$blog_list_boxes_post_info_text_transform = new ElatedField("selectblanksimple","blog_list_boxes_post_info_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_list_boxes_post_info_text_transform",$blog_list_boxes_post_info_text_transform);

$blog_list_boxes_post_info_font_family = new ElatedField("Fontsimple","blog_list_boxes_post_info_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_list_boxes_post_info_font_family",$blog_list_boxes_post_info_font_family);

$blog_list_boxes_post_info_font_style = new ElatedField("selectblanksimple","blog_list_boxes_post_info_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_list_boxes_post_info_font_style",$blog_list_boxes_post_info_font_style);

$row3 = new ElatedRow();
$group18->addChild("row3",$row3);

$blog_list_boxes_post_info_font_weight = new ElatedField("selectblanksimple","blog_list_boxes_post_info_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row3->addChild("blog_list_boxes_post_info_font_weight",$blog_list_boxes_post_info_font_weight);

$blog_list_boxes_post_info_letter_spacing = new ElatedField("textsimple","blog_list_boxes_post_info_letter_spacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_list_boxes_post_info_letter_spacing",$blog_list_boxes_post_info_letter_spacing);

$blog_list_boxes_date_color = new ElatedField("color","blog_list_boxes_date_color","","Date Color", "Choose color for date");
$panel28->addChild("blog_list_boxes_date_color",$blog_list_boxes_date_color);



$blog_list_minimal_subtitle = new ElatedTitle("blog_list_minimal_subtitle", "Blog List - Minimal");
$panel28->addChild("blog_list_minimal_subtitle", $blog_list_minimal_subtitle);

$group5 = new ElatedGroup("Blog List Spacing","Define blog list spacing");
$panel28->addChild("group5",$group5);

$row1 = new ElatedRow(true);
$group5->addChild("row1",$row1);

$blog_list_minimal_title_margin_bottom = new ElatedField("textsimple","blog_list_minimal_title_margin_bottom","","Margin Under Title (px)","This is some description");
$row1->addChild("blog_list_minimal_title_margin_bottom",$blog_list_minimal_title_margin_bottom);

$blog_list_minimal_post_info_margin_bottom = new ElatedField("textsimple","blog_list_minimal_post_info_margin_bottom","","Margin Under Post Info (px)","This is some description");
$row1->addChild("blog_list_minimal_post_info_margin_bottom",$blog_list_minimal_post_info_margin_bottom);

$blog_list_minimal_read_more_margin_top = new ElatedField("textsimple","blog_list_minimal_read_more_margin_top","","Margin Above Read More Button (px)","This is some description");
$row1->addChild("blog_list_minimal_read_more_margin_top",$blog_list_minimal_read_more_margin_top);


// Image in left box

$image_in_left_box = new ElatedTitle("image_in_left_box", "Blog List - Image in Left Box");
$panel28->addChild("image_in_left_box", $image_in_left_box);

$group28 = new ElatedGroup("Blog List Title","Define Blog List title style");
$panel28->addChild("group28",$group28);
$row1 = new ElatedRow();
$group28->addChild("row1",$row1);

$blog_list_img_in_lbox_title_color = new ElatedField("colorsimple","blog_list_img_in_lbox_title_color","","Text Color","This is some description");
$row1->addChild("blog_list_img_in_lbox_title_color",$blog_list_img_in_lbox_title_color);

$blog_list_img_in_lbox_title_hover_color = new ElatedField("colorsimple","blog_list_img_in_lbox_title_hover_color","","Text Hover Color","This is some description");
$row1->addChild("blog_list_img_in_lbox_title_hover_color",$blog_list_img_in_lbox_title_hover_color);

$blog_list_img_in_lbox_title_font_size = new ElatedField("textsimple","blog_list_img_in_lbox_title_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_list_img_in_lbox_title_font_size",$blog_list_img_in_lbox_title_font_size);

$blog_list_img_in_lbox_title_line_height = new ElatedField("textsimple","blog_list_img_in_lbox_title_line_height","","Line Height (px)","This is some description");
$row1->addChild("blog_list_img_in_lbox_title_line_height",$blog_list_img_in_lbox_title_line_height);

$row2 = new ElatedRow(true);
$group28->addChild("row2",$row2);

$blog_list_img_in_lbox_title_text_transform = new ElatedField("selectblanksimple","blog_list_img_in_lbox_title_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_list_img_in_lbox_title_text_transform",$blog_list_img_in_lbox_title_text_transform);

$blog_list_img_in_lbox_title_font_family = new ElatedField("Fontsimple","blog_list_img_in_lbox_title_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_list_img_in_lbox_title_font_family",$blog_list_img_in_lbox_title_font_family);

$blog_list_img_in_lbox_title_font_style = new ElatedField("selectblanksimple","blog_list_img_in_lbox_title_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_list_img_in_lbox_title_font_style",$blog_list_img_in_lbox_title_font_style);

$blog_list_img_in_lbox_title_font_weight = new ElatedField("selectblanksimple","blog_list_img_in_lbox_title_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_list_img_in_lbox_title_font_weight",$blog_list_img_in_lbox_title_font_weight);


$row3 = new ElatedRow(true);
$group28->addChild("row3",$row3);

$blog_list_img_in_lbox_title_letter_spacing = new ElatedField("textsimple","blog_list_img_in_lbox_title_letter_spacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_list_img_in_lbox_title_letter_spacing",$blog_list_img_in_lbox_title_letter_spacing);


$group29 = new ElatedGroup("Blog List Post Info","Define blog list post info style");
$panel28->addChild("group29",$group29);
$row1 = new ElatedRow();
$group29->addChild("row1",$row1);

$blog_list_img_in_lbox_post_info_color = new ElatedField("colorsimple","blog_list_img_in_lbox_post_info_color","","Text Color","This is some description");
$row1->addChild("blog_list_img_in_lbox_post_info_color",$blog_list_img_in_lbox_post_info_color);

$blog_list_img_in_lbox_post_info_link_color = new ElatedField("colorsimple","blog_list_img_in_lbox_post_info_link_color","","Link Color","This is some description");
$row1->addChild("blog_list_img_in_lbox_post_info_link_color",$blog_list_img_in_lbox_post_info_link_color);

$blog_list_img_in_lbox_post_info_link_hover_color = new ElatedField("colorsimple","blog_list_img_in_lbox_post_info_link_hover_color","","Link Hover Color","This is some description");
$row1->addChild("blog_list_img_in_lbox_post_info_link_hover_color",$blog_list_img_in_lbox_post_info_link_hover_color);

$blog_list_img_in_lbox_post_info_font_size = new ElatedField("textsimple","blog_list_img_in_lbox_post_info_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_list_img_in_lbox_post_info_font_size",$blog_list_img_in_lbox_post_info_font_size);


$row2 = new ElatedRow(true);
$group29->addChild("row2",$row2);

$blog_list_img_in_lbox_post_info_line_height = new ElatedField("textsimple","blog_list_img_in_lbox_post_info_line_height","","Line Height (px)","This is some description");
$row2->addChild("blog_list_img_in_lbox_post_info_line_height",$blog_list_img_in_lbox_post_info_line_height);

$blog_list_img_in_lbox_post_info_text_transform = new ElatedField("selectblanksimple","blog_list_img_in_lbox_post_info_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_list_img_in_lbox_post_info_text_transform",$blog_list_img_in_lbox_post_info_text_transform);

$blog_list_img_in_lbox_post_info_font_family = new ElatedField("Fontsimple","blog_list_img_in_lbox_post_info_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_list_img_in_lbox_post_info_font_family",$blog_list_img_in_lbox_post_info_font_family);

$blog_list_img_in_lbox_post_info_font_style = new ElatedField("selectblanksimple","blog_list_img_in_lbox_post_info_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_list_img_in_lbox_post_info_font_style",$blog_list_img_in_lbox_post_info_font_style);

$row3 = new ElatedRow(true);
$group29->addChild("row3",$row3);

$blog_list_img_in_lbox_post_info_font_weight = new ElatedField("selectblanksimple","blog_list_img_in_lbox_post_info_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row3->addChild("blog_list_img_in_lbox_post_info_font_weight",$blog_list_img_in_lbox_post_info_font_weight);

$blog_list_img_in_lbox_post_info_letter_spacing = new ElatedField("textsimple","blog_list_img_in_lbox_post_info_letter_spacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_list_img_in_lbox_post_info_letter_spacing",$blog_list_img_in_lbox_post_info_letter_spacing);

$group30 = new ElatedGroup("Blog List Date Style","Define blog list date style");
$panel28->addChild("group30",$group30);
$row1 = new ElatedRow();
$group30->addChild("row1",$row1);

$blog_list_img_in_lbox_date_color = new ElatedField("colorsimple","blog_list_img_in_lbox_date_color","","Text Color","This is some description");
$row1->addChild("blog_list_img_in_lbox_date_color",$blog_list_img_in_lbox_date_color);

$blog_list_img_in_lbox_date_font_size = new ElatedField("textsimple","blog_list_img_in_lbox_date_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_list_img_in_lbox_date_font_size",$blog_list_img_in_lbox_date_font_size);

$blog_list_img_in_lbox_date_line_height = new ElatedField("textsimple","blog_list_img_in_lbox_date_line_height","","Line Height (px)","This is some description");
$row1->addChild("blog_list_img_in_lbox_date_line_height",$blog_list_img_in_lbox_date_line_height);

$blog_list_img_in_lbox_date_text_transform = new ElatedField("selectblanksimple","blog_list_img_in_lbox_date_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row1->addChild("blog_list_img_in_lbox_date_text_transform",$blog_list_img_in_lbox_date_text_transform);

$row2 = new ElatedRow(true);
$group30->addChild("row2",$row2);

$blog_list_img_in_lbox_date_font_family = new ElatedField("Fontsimple","blog_list_img_in_lbox_date_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_list_img_in_lbox_date_font_family",$blog_list_img_in_lbox_date_font_family);

$blog_list_img_in_lbox_date_font_style = new ElatedField("selectblanksimple","blog_list_img_in_lbox_date_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_list_img_in_lbox_date_font_style",$blog_list_img_in_lbox_date_font_style);

$blog_list_img_in_lbox_date_font_weight = new ElatedField("selectblanksimple","blog_list_img_in_lbox_date_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_list_img_in_lbox_date_font_weight",$blog_list_img_in_lbox_date_font_weight);

$blog_list_img_in_lbox_date_letter_spacing = new ElatedField("textsimple","blog_list_img_in_lbox_date_letter_spacing","","Letter Spacing (px)","This is some description");
$row2->addChild("blog_list_img_in_lbox_date_letter_spacing",$blog_list_img_in_lbox_date_letter_spacing);

$group31 = new ElatedGroup("Blog List Spacing","Define blog list spacing");
$panel28->addChild("group31",$group31);

$row1 = new ElatedRow(true);
$group31->addChild("row1",$row1);

$blog_list_img_in_lbox_title_margin_bttm = new ElatedField("textsimple","blog_list_img_in_lbox_title_margin_bttm","","Margin Under Title (px)","This is some description");
$row1->addChild("blog_list_img_in_lbox_title_margin_bttm",$blog_list_img_in_lbox_title_margin_bttm);

$blog_list_img_in_lbox_post_info_margin_bttm = new ElatedField("textsimple","blog_list_img_in_lbox_post_info_margin_bttm","","Margin Under Post Info (px)","This is some description");
$row1->addChild("blog_list_img_in_lbox_post_info_margin_bttm",$blog_list_img_in_lbox_post_info_margin_bttm);

$blog_list_img_in_lbox_read_more_margin_top = new ElatedField("textsimple","blog_list_img_in_lbox_read_more_margin_top","","Margin Above Read More Button (px)","This is some description");
$row1->addChild("blog_list_img_in_lbox_read_more_margin_top",$blog_list_img_in_lbox_read_more_margin_top);

/*** Blog Slider ***/

$panel31 = new ElatedPanel("Blog Slider","blog_slider");
$blogPage->addChild("panel31",$panel31);

$blog_slider_default_and_with_info_always_title = new ElatedTitle("blog_slider_default_and_with_info_always_title","Default and Post Info Visible");
$panel31->addChild("blog_slider_default_and_with_info_always_title",$blog_slider_default_and_with_info_always_title);

$group23 = new ElatedGroup("Title style", "Blog slider title style");
$panel31->addChild("group23",$group23);

$row1 = new ElatedRow();
$group23->addChild("row1",$row1);

$blog_slider_title_color = new ElatedField("colorsimple","blog_slider_title_color","","Title Color","This is some description");
$row1->addChild("blog_slider_title_color",$blog_slider_title_color);

$blog_slider_title_hover_color = new ElatedField("colorsimple","blog_slider_title_hover_color","","Title Hover Color","This is some description");
$row1->addChild("blog_slider_title_hover_color",$blog_slider_title_hover_color);

$blog_slider_title_font_size = new ElatedField("textsimple","blog_slider_title_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_slider_title_font_size",$blog_slider_title_font_size);

$blog_slider_title_line_height = new ElatedField("textsimple","blog_slider_title_line_height","","Line Height (px)","This is some description");
$row1->addChild("blog_slider_title_line_height",$blog_slider_title_line_height);

$row2 = new ElatedRow();
$group23->addChild("row2",$row2);

$blog_slider_title_text_transform = new ElatedField("selectblanksimple","blog_slider_title_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_slider_title_text_transform",$blog_slider_title_text_transform);

$blog_slider_title_font_family = new ElatedField("Fontsimple","blog_slider_title_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_slider_title_font_family",$blog_slider_title_font_family);

$blog_slider_title_font_style = new ElatedField("selectblanksimple","blog_slider_title_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_slider_title_font_style",$blog_slider_title_font_style);

$blog_slider_title_font_weight = new ElatedField("selectblanksimple","blog_slider_title_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_slider_title_font_weight",$blog_slider_title_font_weight);


$row3 = new ElatedRow();
$group23->addChild("row3",$row3);

$blog_slider_title_letter_spacing = new ElatedField("textsimple","blog_slider_title_letter_spacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_slider_title_letter_spacing",$blog_slider_title_letter_spacing);

$group24 = new ElatedGroup("Category style", "Blog slider categories style");
$panel31->addChild("group24",$group24);

$row1 = new ElatedRow();
$group24->addChild("row1",$row1);

$blog_slider_category_color = new ElatedField("colorsimple","blog_slider_category_color","","Category Color","This is some description");
$row1->addChild("blog_slider_category_color",$blog_slider_category_color);

$blog_slider_category_hover_color = new ElatedField("colorsimple","blog_slider_category_hover_color","","Category Hover Color","This is some description");
$row1->addChild("blog_slider_category_hover_color",$blog_slider_category_hover_color);

$blog_slider_category_font_size = new ElatedField("textsimple","blog_slider_category_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_slider_category_font_size",$blog_slider_category_font_size);

$blog_slider_category_line_height = new ElatedField("textsimple","blog_slider_category_line_height","","Line Height (px)","This is some description");
$row1->addChild("blog_slider_category_line_height",$blog_slider_category_line_height);

$row2 = new ElatedRow();
$group24->addChild("row2",$row2);

$blog_slider_category_text_transform = new ElatedField("selectblanksimple","blog_slider_category_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_slider_category_text_transform",$blog_slider_category_text_transform);

$blog_slider_category_font_family = new ElatedField("Fontsimple","blog_slider_category_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_slider_category_font_family",$blog_slider_category_font_family);

$blog_slider_category_font_style = new ElatedField("selectblanksimple","blog_slider_category_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_slider_category_font_style",$blog_slider_category_font_style);

$blog_slider_category_font_weight = new ElatedField("selectblanksimple","blog_slider_category_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_slider_category_font_weight",$blog_slider_category_font_weight);


$row3 = new ElatedRow();
$group24->addChild("row3",$row3);

$blog_slider_category_letter_spacing = new ElatedField("textsimple","blog_slider_category_letter_spacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_slider_category_letter_spacing",$blog_slider_category_letter_spacing);

$group25 = new ElatedGroup("Date style", "Blog slider date style");
$panel31->addChild("group25",$group25);

$row1 = new ElatedRow();
$group25->addChild("row1",$row1);

$blog_slider_date_color = new ElatedField("colorsimple","blog_slider_date_color","","Date Color","This is some description");
$row1->addChild("blog_slider_date_color",$blog_slider_date_color);

$blog_slider_date_font_size = new ElatedField("textsimple","blog_slider_date_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_slider_date_font_size",$blog_slider_date_font_size);

$blog_slider_date_line_height = new ElatedField("textsimple","blog_slider_date_line_height","","Line Height (px)","This is some description");
$row1->addChild("blog_slider_date_line_height",$blog_slider_date_line_height);

$blog_slider_date_text_transform = new ElatedField("selectblanksimple","blog_slider_date_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row1->addChild("blog_slider_date_text_transform",$blog_slider_date_text_transform);

$row2 = new ElatedRow();
$group25->addChild("row2",$row2);

$blog_slider_date_font_family = new ElatedField("Fontsimple","blog_slider_date_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_slider_date_font_family",$blog_slider_date_font_family);

$blog_slider_date_font_style = new ElatedField("selectblanksimple","blog_slider_date_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_slider_date_font_style",$blog_slider_date_font_style);

$blog_slider_date_font_weight = new ElatedField("selectblanksimple","blog_slider_date_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_slider_date_font_weight",$blog_slider_date_font_weight);

$blog_slider_date_letter_spacing = new ElatedField("textsimple","blog_slider_date_letter_spacing","","Letter Spacing (px)","This is some description");
$row2->addChild("blog_slider_date_letter_spacing",$blog_slider_date_letter_spacing);


$blog_slider_info_in_bottom_title = new ElatedTitle("blog_slider_info_in_bottom_title","Post Info in Bottom");
$panel31->addChild("blog_slider_info_in_bottom_title",$blog_slider_info_in_bottom_title);

$group26 = new ElatedGroup("Title style", "Blog slider title style");
$panel31->addChild("group26",$group26);

$row1 = new ElatedRow();
$group26->addChild("row1",$row1);

$blog_slider_post_info_in_bottom_title_color = new ElatedField("colorsimple","blog_slider_post_info_in_bottom_title_color","","Title Color","This is some description");
$row1->addChild("blog_slider_post_info_in_bottom_title_color",$blog_slider_post_info_in_bottom_title_color);

$blog_slider_post_info_in_bottom_title_hover_color = new ElatedField("colorsimple","blog_slider_post_info_in_bottom_title_hover_color","","Title Hover Color","This is some description");
$row1->addChild("blog_slider_post_info_in_bottom_title_hover_color",$blog_slider_post_info_in_bottom_title_hover_color);

$blog_slider_post_info_in_bottom_title_font_size = new ElatedField("textsimple","blog_slider_post_info_in_bottom_title_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_slider_post_info_in_bottom_title_font_size",$blog_slider_post_info_in_bottom_title_font_size);

$blog_slider_post_info_in_bottom_title_line_height = new ElatedField("textsimple","blog_slider_post_info_in_bottom_title_line_height","","Line Height (px)","This is some description");
$row1->addChild("blog_slider_post_info_in_bottom_title_line_height",$blog_slider_post_info_in_bottom_title_line_height);

$row2 = new ElatedRow();
$group26->addChild("row2",$row2);

$blog_slider_post_info_in_bottom_title_text_transform = new ElatedField("selectblanksimple","blog_slider_post_info_in_bottom_title_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_slider_post_info_in_bottom_title_text_transform",$blog_slider_post_info_in_bottom_title_text_transform);

$blog_slider_post_info_in_bottom_title_font_family = new ElatedField("Fontsimple","blog_slider_post_info_in_bottom_title_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_slider_post_info_in_bottom_title_font_family",$blog_slider_post_info_in_bottom_title_font_family);

$blog_slider_post_info_in_bottom_title_font_style = new ElatedField("selectblanksimple","blog_slider_post_info_in_bottom_title_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_slider_post_info_in_bottom_title_font_style",$blog_slider_post_info_in_bottom_title_font_style);

$blog_slider_post_info_in_bottom_title_font_weight = new ElatedField("selectblanksimple","blog_slider_post_info_in_bottom_title_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row2->addChild("blog_slider_post_info_in_bottom_title_font_weight",$blog_slider_post_info_in_bottom_title_font_weight);

$row3 = new ElatedRow();
$group26->addChild("row3",$row3);

$blog_slider_post_info_in_bottom_title_letter_spacing = new ElatedField("textsimple","blog_slider_post_info_in_bottom_title_letter_spacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_slider_post_info_in_bottom_title_letter_spacing",$blog_slider_post_info_in_bottom_title_letter_spacing);

$group27 = new ElatedGroup("Post Info style", "Blog slider post info style");
$panel31->addChild("group27",$group27);

$row1 = new ElatedRow();
$group27->addChild("row1",$row1);

$blog_slider_post_info_in_bottom_post_info_color = new ElatedField("colorsimple","blog_slider_post_info_in_bottom_post_info_color","","Text Color","This is some description");
$row1->addChild("blog_slider_post_info_in_bottom_post_info_color",$blog_slider_post_info_in_bottom_post_info_color);

$blog_slider_post_info_in_bottom_post_info_link_color = new ElatedField("colorsimple","blog_slider_post_info_in_bottom_post_info_link_color","","Link Color","This is some description");
$row1->addChild("blog_slider_post_info_in_bottom_post_info_link_color",$blog_slider_post_info_in_bottom_post_info_link_color);

$blog_slider_post_info_in_bottom_post_info_link_hover_color = new ElatedField("colorsimple","blog_slider_post_info_in_bottom_post_info_link_hover_color","","Link Hover Color","This is some description");
$row1->addChild("blog_slider_post_info_in_bottom_post_info_link_hover_color",$blog_slider_post_info_in_bottom_post_info_link_hover_color);

$blog_slider_post_info_in_bottom_post_info_font_size = new ElatedField("textsimple","blog_slider_post_info_in_bottom_post_info_font_size","","Font Size (px)","This is some description");
$row1->addChild("blog_slider_post_info_in_bottom_post_info_font_size",$blog_slider_post_info_in_bottom_post_info_font_size);

$row2 = new ElatedRow();
$group27->addChild("row2",$row2);

$blog_slider_post_info_in_bottom_post_info_line_height = new ElatedField("textsimple","blog_slider_post_info_in_bottom_post_info_line_height","","Line Height (px)","This is some description");
$row2->addChild("blog_slider_post_info_in_bottom_post_info_line_height",$blog_slider_post_info_in_bottom_post_info_line_height);

$blog_slider_post_info_in_bottom_post_info_text_transform = new ElatedField("selectblanksimple","blog_slider_post_info_in_bottom_post_info_text_transform","","Text Transform","This is some description",$eltd_options_texttransform);
$row2->addChild("blog_slider_post_info_in_bottom_post_info_text_transform",$blog_slider_post_info_in_bottom_post_info_text_transform);

$blog_slider_post_info_in_bottom_post_info_font_family = new ElatedField("Fontsimple","blog_slider_post_info_in_bottom_post_info_font_family","-1","Font Family","This is some description");
$row2->addChild("blog_slider_post_info_in_bottom_post_info_font_family",$blog_slider_post_info_in_bottom_post_info_font_family);

$blog_slider_post_info_in_bottom_post_info_font_style = new ElatedField("selectblanksimple","blog_slider_post_info_in_bottom_post_info_font_style","","Font Style","This is some description",$eltd_options_fontstyle);
$row2->addChild("blog_slider_post_info_in_bottom_post_info_font_style",$blog_slider_post_info_in_bottom_post_info_font_style);

$row3 = new ElatedRow();
$group27->addChild("row3",$row3);

$blog_slider_post_info_in_bottom_post_info_font_weight = new ElatedField("selectblanksimple","blog_slider_post_info_in_bottom_post_info_font_weight","","Font Weight","This is some description",$eltd_options_fontweight);
$row3->addChild("blog_slider_post_info_in_bottom_post_info_font_weight",$blog_slider_post_info_in_bottom_post_info_font_weight);

$blog_slider_post_info_in_bottom_post_info_letter_spacing = new ElatedField("textsimple","blog_slider_post_info_in_bottom_post_info_letter_spacing","","Letter Spacing (px)","This is some description");
$row3->addChild("blog_slider_post_info_in_bottom_post_info_letter_spacing",$blog_slider_post_info_in_bottom_post_info_letter_spacing);
