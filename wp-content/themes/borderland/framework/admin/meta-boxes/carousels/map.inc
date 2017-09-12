<?php

//Carousels

$eltdCarousels = new ElatedMetaBox("carousels", "Carousels");
$eltdFramework->eltdMetaBoxes->addMetaBox("carousels",$eltdCarousels);

	$eltd_carousel_image = new ElatedMetaField("image","eltd_carousel-image","","Carousel Image","Choose carousel image (min width needs to be 215px)");
	$eltdCarousels->addChild("eltd_carousel-image",$eltd_carousel_image);

	$eltd_carousel_hover_image = new ElatedMetaField("image","eltd_carousel-hover-image","","Carousel Hover Image","Choose carousel hover image (min width needs to be 215px)");
	$eltdCarousels->addChild("eltd_carousel-hover-image",$eltd_carousel_hover_image);

	$eltd_carousel_item_link = new ElatedMetaField("text","eltd_carousel-item-link","","Link","Enter the URL to which you want the image to link to (e.g. http://www.example.com)");
	$eltdCarousels->addChild("eltd_carousel-item-link",$eltd_carousel_item_link);

	$eltd_carousel_item_target = new ElatedMetaField("selectblank","eltd_carousel-item-target","","Target","Specify where to open the linked document", array(
        "_self" => "Self",
        "_blank" => "Blank"
    ));
	$eltdCarousels->addChild("eltd_carousel-item-target",$eltd_carousel_item_target);