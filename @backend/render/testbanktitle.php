<meta charset="utf-8" />
<h1 align="left"><i class="icon file outline"></i> TESTBANK TITLE</h1>

<?php
$backend = new backend($_CONFIG,$db);
$backend->setTable("testbank");
$backend->setPrimaryName("id");
$backend->allowAddButton(true);
$backend->setReadonly(array("id"));
$dropdown = array();
foreach($db->getRows("SELECT * FROM subjects ORDER BY id DESC") as $row){$dropdown["test_subject"][$row["id"]] = $row["subject_name"]." ({$row["subject_code"]})";}
$dropdown["onetime"] = array("False","True");
$dropdown["visible"] = array("False","True");
$backend->setDropdown($dropdown);
$backend->setColumn(array("id"=>"ID","test_title"=>"Title","test_subject"=>"Subject","slot_id"=>"Slot ID","onetime"=>"One Time","visible"=>"Visible"));
$backend->render('table',$_REQUEST);
?>