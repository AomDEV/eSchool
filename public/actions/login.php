<?php
session_start();
require("../core/settings.php");
require("../classes/class.database.php");

if(isset($_POST) and isset($_POST["username"]) and isset($_POST["password"])){
	$username = $_POST["username"];
	$password = md5($_POST["password"]);
	$db = new database($_CONFIG);
	$accountInfo = $db->getAccountByUsername($username);
	if($accountInfo["password"] == $password and ($accountInfo["role"]==0 or $accountInfo["role"]==1 or $accountInfo["role"]==2)){
		//Successful!
		$_SESSION["account"]["uid"] = $accountInfo["uid"];
		if($accountInfo["role"]==0 or $accountInfo["role"]==1){
			$_SESSION["account"]["admin"] = true;
		}
		$return = array("status"=>true,"message"=>"Login successful!","type"=>"success");
	} else{
		//Failure
		$return = array("status"=>false,"message"=>"Login Failure!","type"=>"error");
	}
} else{
	$return = array("status"=>false,"message"=>"Wrong request","type"=>"error");
}
echo json_encode($return);
?>