<?php
session_start();
//LOAD CORE FILES
require("public/core/settings.php");
require("public/classes/class.aom.php");

//CONFIG VARIABLES
$aom = new aom($_CONFIG);

//INIT PAGE RENDERER
$aom->render("html_assets");
$aom->render("html_start");
if($aom->has_request("page")){
	if(in_array($aom->request("page"), $_CONFIG["single_page"])){
		$aom->render($aom->request("page"));
	} else{
		$aom->render("navbar");
		echo "<div class='row' style='padding:0 10px 0 10px;'><div class='col-md-3' style='margin-top:10px;'>";
		$aom->render("left_menu");
		echo "</div><div class='col-md-9' style='margin-top:10px;'>";
		$aom->render($aom->request("page"));
		echo "</div></div>";
	}
} else{
	header("Location:./?page=home");
}

$aom->render("footer");
$aom->render("html_end");
?>