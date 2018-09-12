<?php
require("public/core/settings.php");
if(!class_exists('aom')){ require("public/classes/class.aom.php"); }
if(!class_exists('database')){ require("public/classes/class.database.php"); }
$db = new database($_CONFIG);
$aom = new aom($_CONFIG);
$aom->render("carousel");
?>
<h3 align="left"><b><i class="glyphicon glyphicon-comment"></i> <span tkey="header-annoucement"></span></b></h3><hr />
<?php
foreach($db->getRows("SELECT * FROM annoucement ORDER BY id") as $row){
	$owner_info = $db->getAccountByUID($row["owner_uid"]);
?>
<div class="panel panel-primary" align="left">
	<div class="panel-heading" style="padding:5px;"><i class="icon comment"></i> <?=$row["title"]?></div>
	<div class="panel-body" style="padding:10px;">
		<?=$row["content"]?>
	</div>
	<div class="panel-footer text-muted" style="padding:5px;">
		<span style="margin-right: 10px;"><i class="icon user"></i> <?=$aom->getFullName($owner_info)?></span>
		<span style="margin-right: 10px;"><i class="icon time"></i> <?=date("d/m/Y H:i",$row["time"])?></span>
		<?php if(isset($row["attachment"]) and strlen($row["attachment"]) >= 6){ ?>
		<span><i class="glyphicon glyphicon-paperclip"></i> <a href="<?=$row['attachment']?>"><span tkey="label-attachment"></span></a></span>
		<?php } ?>
	</div>
</div>
<?php

}
?>