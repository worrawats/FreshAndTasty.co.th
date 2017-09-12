<?php

global $eltdIconCollections;

$socialPage = new ElatedAdminPage("12", "Social", "fa fa-share-alt");
$eltdFramework->eltdOptions->addAdminPage("socialPage",$socialPage);

//Enable Social Share

$panel2 = new ElatedPanel("Enable Social Share","social_sharing_panel");
$socialPage->addChild("panel2",$panel2);

	$enable_social_share = new ElatedField("yesno","enable_social_share","no","Enable Social Share","Enabling this option will allow social share on networks of your choice", array(),
		array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#eltdf_social_networks_panel,#eltdf_show_social_share_panel"));
	$panel2->addChild("enable_social_share",$enable_social_share);

//Show Social Share

$panel3 = new ElatedPanel("Show Social Share On","show_social_share_panel","enable_social_share","no");
$socialPage->addChild("panel3",$panel3);

	$post_types_names_post = new ElatedField("flagpost","post_types_names_post","","Posts","Show Social Share on Blog Posts");
	$panel3->addChild("post_types_names_post",$post_types_names_post);

	$post_types_names_page = new ElatedField("flagpage","post_types_names_page","","Pages","Show Social Share on Pages");
	$panel3->addChild("post_types_names_page",$post_types_names_page);

	$post_types_names_attachment = new ElatedField("flagmedia","post_types_names_attachment","","Media","Show Social Share for Images and Videos");
	$panel3->addChild("post_types_names_attachment",$post_types_names_attachment);

	$post_types_names_portfolio_page = new ElatedField("flagportfolio","post_types_names_portfolio_page","","Portfolio Item","Show Social Share for Portfolio Items");
	$panel3->addChild("post_types_names_portfolio_page",$post_types_names_portfolio_page);

	if(eltd_is_woocommerce_installed()){
		$post_types_names_product = new ElatedField("flagproduct","post_types_names_product","","Product","Show Social Share for Product Items");
		$panel3->addChild("post_types_names_product",$post_types_names_product);
	}

//Social Share Networks

$panel4 = new ElatedPanel("Social Networks","social_networks_panel","enable_social_share","no");
$socialPage->addChild("panel4",$panel4);

//Facebook

$facebook_subtitle = new ElatedTitle("facebook_subtitle", "Share on Facebook");
$panel4->addChild("facebook_subtitle", $facebook_subtitle);

$enable_facebook_share = new ElatedField("yesno","enable_facebook_share","no","Enable Share","Enabling this option will allow sharing via Facebook", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_enable_facebook_share_container"));
	$panel4->addChild("enable_facebook_share",$enable_facebook_share);

	$enable_facebook_share_container = new ElatedContainer("enable_facebook_share_container","enable_facebook_share","no");
	$panel4->addChild("enable_facebook_share_container",$enable_facebook_share_container);

		$facebook_icon = new ElatedField("image","facebook_icon","","Upload Icon","");
		$enable_facebook_share_container->addChild("facebook_icon",$facebook_icon);

//Twitter
$twitter_subtitle = new ElatedTitle("twitter_subtitle", "Share on Twitter");
$panel4->addChild("twitter_subtitle", $twitter_subtitle);

	$enable_twitter_share = new ElatedField("yesno","enable_twitter_share","no","Enable Share","Enabling this option will allow sharing via Twitter", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_enable_twitter_share_container"));
	$panel4->addChild("enable_twitter_share",$enable_twitter_share);
	$enable_twitter_share_container = new ElatedContainer("enable_twitter_share_container","enable_twitter_share","no");
	$panel4->addChild("enable_twitter_share_container",$enable_twitter_share_container);
		$twitter_icon = new ElatedField("image","twitter_icon","","Upload Icon","");
		$enable_twitter_share_container->addChild("twitter_icon",$twitter_icon);
		$twitter_via = new ElatedField("text","twitter_via","","Via","");
		$enable_twitter_share_container->addChild("twitter_via",$twitter_via);

//Google Plus

$google_plus_subtitle = new ElatedTitle("google_plus_subtitle", "Share on Google Plus");
$panel4->addChild("google_plus_subtitle", $google_plus_subtitle);

$enable_google_plus = new ElatedField("yesno","enable_google_plus","no","Enable Share","Enabling this option will allow sharing via Google Plus", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_enable_google_plus_container"));
	$panel4->addChild("enable_google_plus",$enable_google_plus);
	$enable_google_plus_container = new ElatedContainer("enable_google_plus_container","enable_google_plus","no");
	$panel4->addChild("enable_google_plus_container",$enable_google_plus_container);
		$google_plus_icon = new ElatedField("image","google_plus_icon","","Upload Icon","");
		$enable_google_plus_container->addChild("google_plus_icon",$google_plus_icon);

//LinkedIn

$linkedin_subtitle = new ElatedTitle("linkedin_subtitle", "Share on LinkedIn");
$panel4->addChild("linkedin_subtitle", $linkedin_subtitle);

	$enable_linkedin = new ElatedField("yesno","enable_linkedin","no","Enable Share","Enabling this option will allow sharing via LinkedIn", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_enable_linkedin_container"));
	$panel4->addChild("enable_linkedin",$enable_linkedin);
	$enable_linkedin_container = new ElatedContainer("enable_linkedin_container","enable_linkedin","no");
	$panel4->addChild("enable_linkedin_container",$enable_linkedin_container);
		$linkedin_icon = new ElatedField("image","linkedin_icon","","Upload Icon","");
		$enable_linkedin_container->addChild("linkedin_icon",$linkedin_icon);

//Tumblr

$tumblr_subtitle = new ElatedTitle("tumblr_subtitle", "Share on Tumblr");
$panel4->addChild("tumblr_subtitle", $tumblr_subtitle);

	$enable_tumblr = new ElatedField("yesno","enable_tumblr","no","Enable Share","Enabling this option will allow sharing via Tumblr", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_enable_tumblr_container"));
	$panel4->addChild("enable_tumblr",$enable_tumblr);

	$enable_tumblr_container = new ElatedContainer("enable_tumblr_container","enable_tumblr","no");
	$panel4->addChild("enable_tumblr_container",$enable_tumblr_container);

		$tumblr_icon = new ElatedField("image","tumblr_icon","","Upload Icon","");
		$enable_tumblr_container->addChild("tumblr_icon",$tumblr_icon);

// Pinterest

$pinterest_subtitle = new ElatedTitle("pinterest_subtitle", "Share on Pinterest");
$panel4->addChild("pinterest_subtitle", $pinterest_subtitle);

	$enable_pinterest = new ElatedField("yesno","enable_pinterest","no","Enable Share","Enabling this option will allow sharing via Pinterest", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_enable_pinterest_container"));
	$panel4->addChild("enable_pinterest",$enable_pinterest);
	$enable_pinterest_container = new ElatedContainer("enable_pinterest_container","enable_pinterest","no");
	$panel4->addChild("enable_pinterest_container",$enable_pinterest_container);
		$pinterest_icon = new ElatedField("image","pinterest_icon","","Upload Icon","");
		$enable_pinterest_container->addChild("pinterest_icon",$pinterest_icon);


//VK

$vk_subtitle = new ElatedTitle("vk_subtitle", "Share on VK");
$panel4->addChild("vk_subtitle", $vk_subtitle);

	$enable_vk = new ElatedField("yesno","enable_vk","no","Enable Share","Enabling this option will allow sharing via VK", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#eltdf_enable_vk_container"));
	$panel4->addChild("enable_vk",$enable_vk);
	$enable_vk_container = new ElatedContainer("enable_vk_container","enable_vk","no");
	$panel4->addChild("enable_vk_container",$enable_vk_container);
		$vk_icon = new ElatedField("image","vk_icon","","Upload Icon","");
		$enable_vk_container->addChild("vk_icon",$vk_icon);