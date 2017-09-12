<?php

//Testimonials

$eltdTestimonials = new ElatedMetaBox("testimonials", "Testimonials");
$eltdFramework->eltdMetaBoxes->addMetaBox("testimonials",$eltdTestimonials);

	$eltd_show_testimonial_title_text = new ElatedMetaField("yesno","eltd_show_testimonial_title_text","no","Hide Testimonial Title Text","Enable this option to hide the title text", array(), array("dependence" => true, "dependence_hide_on_yes" => "#eltdf_eltd_testimonial_title_container", "dependence_show_on_yes" => ""));
	$eltdTestimonials->addChild("eltd_show_testimonial_title_text",$eltd_show_testimonial_title_text);

		$eltd_testimonial_title_container = new ElatedContainer("eltd_testimonial_title_container","eltd_show_testimonial_title_text","yes");
		$eltdTestimonials->addChild("eltd_testimonial_title_container",$eltd_testimonial_title_container);
	
			$eltd_testimonial_title= new ElatedMetaField("text","eltd_testimonial_title","","Title","Enter testimonial title");
			$eltd_testimonial_title_container->addChild("eltd_testimonial_title",$eltd_testimonial_title);
	
	$eltd_testimonial_author = new ElatedMetaField("text","eltd_testimonial-author","","Author","Enter author name");
	$eltdTestimonials->addChild("eltd_testimonial-author",$eltd_testimonial_author);

	$eltd_testimonial_author_position = new ElatedMetaField("text","eltd_testimonial_author_position","","Job Position","Enter job position name");
	$eltdTestimonials->addChild("eltd_testimonial_author_position",$eltd_testimonial_author_position);

	$eltd_testimonial_text = new ElatedMetaField("textarea","eltd_testimonial-text","","Text","Enter testimonial text");
	$eltdTestimonials->addChild("eltd_testimonial-text",$eltd_testimonial_text);