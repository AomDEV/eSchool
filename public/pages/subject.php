<?php
require("public/core/settings.php");
if(!class_exists('aom')){ require("public/classes/class.aom.php"); }
if(!class_exists('database')){ require("public/classes/class.database.php"); }
$db = new database($_CONFIG);
$aom = new aom($_CONFIG);
if($aom->requireLogin($_SESSION)){
$subjectID = 0;
?>

<?php
if(isset($_GET["id"]) and is_numeric($_GET["id"]) and $db->getNumber("SELECT * FROM subjects WHERE id=?;",array(intval($_GET["id"]))) > 0):
	$subjectID = intval($_GET["id"]);
	$subjectInfo = $db->getRow("SELECT * FROM subjects WHERE id=?;",array(intval($_GET["id"])));
	$lesson =1;
	if(isset($_GET["lesson"]) and is_numeric($_GET["lesson"])){$lesson = intval($_GET["lesson"]);}
	$subjectContent = $db->getRow("SELECT * FROM subject_content WHERE subject_id=? AND visible=1 AND lesson=?",array($subjectID,$lesson));
?>
<h1 align="left">
	<i class="icon clipboard outline"></i> <b><?=$subjectInfo["subject_name"]?></b> 
	<a href="./?page=subject" class="btn btn-xs btn-info" style="margin-left:10px;"><i class="glyphicon glyphicon-home"></i> <span tkey="label-back"></span></a>
</h1>

<div class="ui segment" align="left">
	<h3 align="left"><b tkey="label-subjectinfo"></b></h3>
	<?php echo $db->getRow("SELECT * FROM subject_describe WHERE subject_id=?",array(intval($_GET["id"])))["content"]; ?>
</div>

<?php
if($db->getNumber("SELECT * FROM subject_content WHERE subject_id=?",array(intval($_GET["id"]))) > 0){
?>
<div class="ui fluid search selection dropdown" style="margin-top:5px;">
	<input type="hidden" name="subject">
	<i class="dropdown icon"></i>
	<div class="default text"><span tkey="label-lesson"></span></div>
	<div class="menu">
		<?php foreach($db->getRows("SELECT * FROM subject_content WHERE subject_id=?",array(intval($_GET["id"]))) as $row): ?>
		<div class="item" data-value="<?=$row["lesson"]?>"><i class="icon bookmark"></i><span tkey="label-lesson"></span> <?=$row["lesson"]?></div>
		<?php endforeach; ?>
	</div>
</div>
<script>$('.ui.selection.dropdown').dropdown({onChange: function(value,text,$selectedItem){window.location="./?page=subject&id=<?=intval($_GET["id"])?>&lesson="+value;}});</script>
<?php } ?>

<div class="ui top attached tabular menu">
  <a class="item active" data-tab="describe"><span tkey="label-lessoninfo"></span></a>
  <a class="item" data-tab="exercise"><span tkey="label-exercise"></span></a>
  <a class="item" data-tab="video"><span tkey="label-video"></span></a>
</div>
<div class="ui bottom attached tab segment active" data-tab="describe" align="left">
	<?php if(strlen($subjectContent["content_tab"]) > 4): echo $subjectContent["content_tab"]; else: ?>
	<div class="alert alert-warning"><i class="icon warning circle"></i> Not found content!</div>
	<?php endif; ?>
</div>
<div class="ui bottom attached tab segment" data-tab="exercise" align="left">
	<!--Exercise-->
	<?php if(strlen($subjectContent["exercise_tab"]) > 4): echo $subjectContent["exercise_tab"]; else: ?>
	<div class="alert alert-warning"><i class="icon warning circle"></i> Not found content!</div>
	<?php endif; ?>
</div>
<div class="ui bottom attached tab segment" data-tab="video" align="left">
	<?php if(strlen($subjectContent["video_tab"]) > 4): ?>
	<div class="embed-responsive embed-responsive-16by9">
		<?php echo $subjectContent["video_tab"]; ?>
	</div>
	<?php else: ?>
	<div class="alert alert-warning"><i class="icon warning circle"></i> Not found video!</div>
	<?php endif; ?>
</div>
<script>$('.menu .item').tab();</script>

<?php else: ?>
<h1 align="left"><i class="icon clipboard outline"></i> <b><span tkey="menu-subject"></span></b></h1>

<div class="list-group" align="left">
	<?php foreach($db->getRows("SELECT * FROM subjects ORDER BY id DESC") as $row): $teacherName = $aom->getFullName($db->getAccountByUID($row["teacher_uid"])); ?>
	<a href="./?page=subject&id=<?=$row['id']?>" class="list-group-item">
		<i class="icon tag"></i> <?=$row["subject_name"]?> (<?=$row["subject_code"]?>) <span class="badge"><span tkey="label-teacher"></span> <?=$teacherName?></span>
	</a>
	<?php endforeach; ?>
</div>

<?php endif; ?>

<?php } else{echo "Require login!";} ?>