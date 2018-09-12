<?php
session_start();
require("../core/settings.php");
require("../classes/class.database.php");

if(isset($_SESSION["account"]["uid"]) and is_numeric($_SESSION["account"]["uid"])){
	if(isset($_POST) and isset($_POST["answer"]) and is_array($_POST["answer"]) and isset($_POST["test_id"]) and is_numeric($_POST["test_id"])){
		$db = new database($_CONFIG);
		$testID = intval($_POST["test_id"]);
		$correct = 0;
		$score = 0;

		foreach($db->getRows("SELECT * FROM testbank_question WHERE test_id=?",array($testID)) as $row){
			if(isset($_POST["answer"][$row["qid"]]) and is_numeric($_POST["answer"][$row["qid"]])){
				$answer = intval($_POST["answer"][$row["qid"]]);
				$getAnswerInfo = $db->getRow("SELECT * FROM testbank_answer WHERE aid=?",array($answer));
				if($getAnswerInfo["is_correct"]==true){
					$correct++;
					$score+=$row["score"];
				}
			}
		}

		$testInfo = $db->getRow("SELECT * FROM testbank WHERE id=?",array($testID));
		$numSlotScore = $db->getNumber("SELECT * FROM score WHERE slot_id=? AND score_owner=?",array($testInfo["slot_id"],$_SESSION["account"]["uid"]));
		if($numSlotScore > 0){
			//Update
			$slotScoreInfo = $db->getRow("SELECT * FROM score WHERE slot_id=? AND score_owner=?",array($testInfo["slot_id"],$_SESSION["account"]["uid"]));
			$db->insertRow("UPDATE score SET score=? WHERE score_id=?;",array($score,$slotScoreInfo["score_id"]));
		} else{
			//Insert
			$db->insertRow("INSERT INTO score (score_id,slot_id,score,score_owner) VALUES (NULL,?,?,?);",array($testInfo["slot_id"],$score,$_SESSION["account"]["uid"]));
		}
		if($testInfo["onetime"]==true){
			$db->insertRow("INSERT INTO testbank_history (id,owner_id,test_id,time,score) VALUES (NULL,?,?,?,?);",array($_SESSION["account"]["uid"],$testID,time(),$score));
		}
		$return = array("status"=>false,"message"=>"Successful!","score"=>$score);
	} else{
		$return = array("status"=>false,"message"=>"Wrong Request!","score"=>0);
	}
} else{
	$return = array("status"=>false,"message"=>"Require login data!","score"=>0);
}
printf(json_encode($return));
?>