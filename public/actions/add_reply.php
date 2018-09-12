<?php
session_start();
require("../core/settings.php");
require("../classes/class.database.php");

if(isset($_SESSION["account"]["uid"]) and is_numeric($_SESSION["account"]["uid"])){
	if(isset($_POST) and isset($_POST["reply"]) and isset($_POST["id"]) and is_numeric($_POST["id"])){
		if(strlen($_POST["reply"]) >= 10){
			$db = new database($_CONFIG);
			$topicID = intval($_POST["id"]);
			$reply = htmlspecialchars(htmlentities($_POST["reply"]));
			$db->insertRow("INSERT INTO board_comment (id,topic_id,comment,post_by,time) VALUES (NULL,?,?,?,?);",array($topicID,$reply,$_SESSION["account"]["uid"],time()));
			$return = array("status"=>true,"message"=>"Successful","type"=>"success");
		} else{
			$return = array("status"=>false,"message"=>"Comments must contain more than 10 characters","type"=>"error");
		}
	} else{
		$return = array("status"=>false,"message"=>"Wrong request!","type"=>"error","request"=>$_POST);
	}
} else{
	$return = array("status"=>false,"message"=>"Required login!","type"=>"error");
}
echo json_encode($return);
?>