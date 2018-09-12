<meta charset="utf-8" />
<h1 align="left"><i class="icon chat"></i> ANNOUCEMENT</h1>

<?php
$backend = new backend($_CONFIG,$db);
$backend->setTable("annoucement");
$backend->setPrimaryName("id");
$backend->allowAddButton(true);
$backend->setLastTime("time");
$backend->setReadonly(array("owner_uid","id"));
$backend->autoFill("owner_uid",$_SESSION["admin"]["uid"]);
$backend->setColumn(array("id"=>"ID","owner_uid"=>"UID","title"=>"Title","content"=>"Content","attachment"=>"Attachment URL"));
$backend->render('table',$_REQUEST);
?>