<meta charset="utf-8" />
<h1 align="left"><i class="icon time"></i> TESTBANK HISTORY</h1>

<?php
$dropdown = array();
foreach($db->getRows("SELECT * FROM testbank",array()) as $index=>$row){
	$subject = $db->getRow("SELECT * FROM subjects WHERE id=?",array($row["test_subject"]));
	$dropdown["test_id"][$row["id"]] = $row["test_title"]." (".$subject["subject_code"].")";
}

$backend = new backend($_CONFIG,$db);
$backend->setTable("testbank_history");
$backend->setReadonly(array("id"));
$backend->setPrimaryName("id");
$backend->allowAddButton(true);	
$backend->setDropdown($dropdown);
$backend->setDatetimeField(array("time"));
$backend->setColumn(array("id"=>"#","owner_id"=>"UID","test_id"=>"Test ID","time"=>"Time","score"=>"Score"));
$backend->render('table',$_REQUEST);
?>