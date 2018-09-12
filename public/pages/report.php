<?php 
require("public/core/settings.php");
if(!class_exists('aom')){ require("public/classes/class.aom.php"); }
if(!class_exists('database')){ require("public/classes/class.database.php"); }
$db = new database($_CONFIG);
$aom = new aom($_CONFIG);
if($aom->requireLogin($_SESSION)){
?>
<h1 align="left"><i class="icon file"></i> <span tkey="menu-report"></span></h1>

<div id="select-subject" align="left" style="margin-bottom: 10px;">
<i class="icon tag"></i>
<b tkey="label-selectsubject"></b>
<div align="center">
	<!--Subject Dropdown-->
	<div class="ui fluid search selection dropdown" style="margin-top:5px;">
		<input type="hidden" name="subject">
		<i class="dropdown icon"></i>
		<div class="default text"><span tkey="label-selectsubject"></span></div>
		<div class="menu">
			<?php foreach($db->getRows("SELECT * FROM subjects ORDER BY id DESC") as $row): ?>
			<div class="item" data-value="<?=$row["id"]?>"><i class="icon bookmark"></i><?=$row["subject_name"]?> (<?=$row["subject_code"]?>)</div>
			<?php endforeach; ?>
		</div>
	</div>
	<script>$('.ui.selection.dropdown').dropdown({onChange: function(value,text,$selectedItem){window.location="./?page=report&id="+value;}});</script>
</div>
</div>

<?php
if(isset($_GET["id"]) and is_numeric($_GET["id"])):
	$totalScore = 0;
	$fullTotal = 0;
	$subjectInfo = $db->getRow("SELECT * FROM subjects WHERE id=?",array(intval($_GET["id"])));
	if($db->getNumber("SELECT * FROM subjects WHERE id=?",array(intval($_GET["id"]))) > 0):
?>
<div class="panel panel-info" align="left">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="icon tag"></i> <?=$subjectInfo["subject_name"]?></h3>
	</div>
	<!--Score Board-->
	<div class="table-responsive">
	<table class="table table-bordered table-hover">
		<?php
		foreach($db->getRows("SELECT * FROM score_slot WHERE subject_id=? ORDER BY slot_id DESC",array(intval($_GET["id"]))) as $row):
			$fullTotal+=$row["full_score"];
			$scoreInfo = $db->getRow("SELECT * FROM score WHERE slot_id=? AND score_owner=?",array($row["slot_id"],$_SESSION["account"]["uid"]));
			$totalScore+=$scoreInfo["score"];
		?>
			<tr>
				<td width="50%"><i class="icon file"></i> <b><?=$row["slot_name"]?></b> <i class="text-muted">(<?=$row["full_score"]?> <span tkey="label-score"></span>)</i></td>
				<td><center><b><?=intval($scoreInfo["score"])?></b></center></td>
			</tr>
		<?php endforeach; ?>
		<tr class="active">
			<th><b tkey="label-total"></b> <i class="text-muted">(<?=$fullTotal?> <span tkey="label-score"></span>)</i></th>
			<th><div align="center"><?=$totalScore?> <span tkey="label-score"></span></div></th>
		</tr>
	</table>
	</div>

</div>

<?php $userData = $db->getRow("SELECT * FROM accounts WHERE uid=?",array($_SESSION["account"]["uid"])); ?>
<?php if($aom->IsAdmin( $userData )){ ?>
<div align="left"><a href="./@backend/?page=report&subject=<?=intval($_GET["id"])?>&class=<?=intval($userData["class_id"])?>" class="btn btn-success" target="_blank"><i class="icon setting"></i> MANAGE</a></div>
<?php } ?>
<?php
	else:
		echo "Not found subject!";
	endif;
endif;
} else{
	echo "Require login!";
}
?>