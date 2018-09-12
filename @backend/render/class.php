<meta charset="utf-8" />
<h1 align="left"><i class="icon home square"></i> CLASS</h1>

<?php
$backend = new backend($_CONFIG,$db);
$backend->setTable("class");
$backend->setPrimaryName("id");
$backend->allowAddButton(true);
$backend->setReadonly(array("id"));
$backend->setColumn(array("id"=>"ID","class_name"=>"Class Name"));
$backend->render('table',$_REQUEST);
?>