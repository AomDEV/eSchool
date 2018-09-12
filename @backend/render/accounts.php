<meta charset="utf-8" />
<h1 align="left"><i class="icon users"></i> ACCOUNTS</h1>

<?php
$dropdown = array();
$dropdown["role"] = array("Admin","Teacher","Student");
foreach($db->getRows("SELECT * FROM class",array()) as $index=>$row){
	$dropdown["class_id"][$row["id"]] = $row["class_name"];
}

$backend = new backend($_CONFIG,$db);
$backend->setTable("accounts");
$backend->setReadonly(array("uid"));
$backend->setPrimaryName("uid");
$backend->allowAddButton(true);	
$backend->md5Input("password");
$backend->setDropdown($dropdown);
$backend->setColumn(array("uid"=>"UID","username"=>"Username","password"=>"Password","first_name"=>"First Name","last_name"=>"Last Name","role"=>"Role","class_id"=>"Class ID"));
$backend->render('table',$_REQUEST);
?>