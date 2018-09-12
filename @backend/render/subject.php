<meta charset="utf-8" />
<h1 align="left"><i class="icon check circle"></i> SUBJECTS</h1>

<?php
$backend = new backend($_CONFIG,$db);
$backend->setTable("subjects");
$backend->setPrimaryName("id");
$backend->allowAddButton(true);
$backend->setReadonly(array("id"));
$backend->setColumn(array("id"=>"ID","subject_name"=>"Subject Name","subject_code"=>"Subject Code","teacher_uid"=>"Teacher UID"));
$backend->render('table',$_REQUEST);
?>