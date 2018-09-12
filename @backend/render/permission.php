<meta charset="utf-8" />
<h1 align="left"><i class="icon ban"></i> Permission</h1>

<?php
if($db->getNumber("SELECT * FROM accounts WHERE uid=? AND role=0",array($_SESSION["admin"]["uid"])) >= 1){
$dropdown = array();
$dropdown["allow_subject"][-1] = "All";
foreach($db->getRows("SELECT * FROM subjects") as $row){
	$dropdown["allow_subject"][$row["id"]] = $row["subject_name"]." (".$row["subject_code"].")";
}
foreach($db->getRows("SELECT * FROM class",array()) as $index=>$row){
	$dropdown["class_id"][$row["id"]] = $row["class_name"];
}

$backend = new backend($_CONFIG,$db);
$backend->setTable("permission");
$backend->setReadonly(array("perm_id"));
$backend->setPrimaryName("perm_id");
$backend->allowAddButton(true);	
$backend->setDropdown($dropdown);
$backend->setColumn(array("perm_id"=>"PermID","uid"=>"UserID","allow_subject"=>"SubjectID"));
$backend->render('table',$_REQUEST);
} else{
	echo "<div class='alert alert-danger'><i class='icon warning circle'></i> Access denied!</div>";
}
?>