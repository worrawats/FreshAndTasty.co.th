<?php

$resetPage = new ElatedAdminPage("21", "Reset", "fa fa-retweet");
$eltdFramework->eltdOptions->addAdminPage("Reset",$resetPage);

//Reset

$panel1 = new ElatedPanel("Reset to Defaults","reset_panel");
$resetPage->addChild("panel1",$panel1);

	$reset_to_defaults = new ElatedField("yesno","reset_to_defaults","no","Reset to Defaults","This option will reset all Elated Options values to defaults");
	$panel1->addChild("reset_to_defaults",$reset_to_defaults);