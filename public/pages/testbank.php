<?php 
require("public/core/settings.php");
if(!class_exists('aom')){ require("public/classes/class.aom.php"); }
if(!class_exists('database')){ require("public/classes/class.database.php"); }
$db = new database($_CONFIG);
$aom = new aom($_CONFIG);
if($aom->requireLogin($_SESSION)){
if(isset($_GET["id"]) and is_numeric($_GET["id"])):
	$testInfo = $db->getRow("SELECT * FROM testbank WHERE id=?",array(intval($_GET["id"])));
	$questionNums = 0;
	$sqlHistorySubject = "SELECT score FROM testbank_history WHERE owner_id=? AND test_id=?";
	if($db->getNumber($sqlHistorySubject,array($_SESSION["account"]["uid"],$_GET["id"])) > 0 and $db->getRow("SELECT onetime FROM testbank WHERE id=?",array(intval($_GET["id"])))["onetime"]==true ):
?>
<h1 align="left"><i class="icon file"></i> <b><?=$testInfo["test_title"]?></b></h1>
<div class="ui segment inverted pink" style="max-width:200px;padding-bottom: 20px;">
	<h2 align="center" tkey="label-score"></h2>
	<b><font size="86"><?php echo $db->getRow($sqlHistorySubject,array($_SESSION["account"]["uid"],$_GET["id"]))["score"]; ?></font></b>
</div>
<div class="alert alert-warning"><i class="icon warning circle"></i> <font tkey="message-warning-onetimequiz"></font></div>
<?php else: ?>
	<?php $subjectCode = $db->getRow("SELECT subject_code FROM subjects WHERE id=?",array($testInfo["test_subject"])); ?>
<h1 align="left"><i class="icon file"></i> <b><?=$testInfo["test_title"]?> <font class="text-muted">(<?=$subjectCode["subject_code"]?>)</font></b></h1>

<?php
if( $db->getNumber($sqlHistorySubject,array($_SESSION["account"]["uid"],$_GET["id"])) > 0 ){
?>
<div class="alert alert-warning" align="center"><i class="icon wraning circle"></i> 
	<span tkey="label-lastscore"></span> <b><?php echo $db->getRow($sqlHistorySubject,array($_SESSION["account"]["uid"],$_GET["id"]))["score"]; ?></b> <span tkey="label-score"></span>
</div>
<?php } ?>

<div class="testbank-box" align="left">
<?php if($db->getNumber("SELECT * FROM testbank_question WHERE test_id=?",array(intval($_GET["id"]))) > 0 and !($db->getNumber("SELECT * FROM testbank_history WHERE test_id=? AND owner_id=?",array(intval($_GET["id"]),$_SESSION["account"]["uid"])) > 0 and $db->getRow("SELECT onetime FROM testbank WHERE id=?",array(intval($_GET["id"])))["onetime"]==true)): ?>
	<?php foreach($db->getRows("SELECT * FROM testbank_question WHERE test_id=? ORDER BY qid",array(intval($_GET["id"]))) as $link=>$row): $questionNums++; ?>
		<!--ITEM: <?=$link+1?>-->
		<div class="ui segment">
		<?php if(strlen($row["image"])>4){echo "<center><a href='{$row["image"]}' target='_blank'><img src='{$row["image"]}' style='max-height:150px;' class='img-responsive' /></a></center>";} ?>
		<h3><?=$link+1?>. <?=$row["question"]?> <i class="text-muted" style="font-size:14px;">[<?=$row["score"]?> <span tkey="label-score"></span>]</i></h3>
		<?php $rand=null;if($_CONFIG["random_answer"]){$rand="ORDER BY RAND()";} ?>
		<?php foreach($db->getRows("SELECT * FROM testbank_answer WHERE question_id=? ".$rand,array($row["qid"])) as $row0): ?>
			<div style="margin-left:30px;">
				<label class="radio">
					<?php $ansText = $row0["answer"];$ansImage="<div style='display:inline;'><img class='img-responsive' style='max-height:150px;' src='{$ansText}' /><a href='{$ansText}' target='_blank' class='btn btn-info btn-xs'><i class='icon zoom'></i> View</a></div>"; ?>
					<input type="radio" data-question="<?=$row["qid"]?>" name="question<?=$row["qid"]?>" value="<?=$row0["aid"]?>"> <?php if($row0["is_image"]==true){echo $ansImage;} else{echo $ansText;} ?>
				</label>
			</div>
		<?php endforeach; ?>
		</div>
	<?php endforeach; ?>
	<div align="right"><a href="#" class="ui button positive submit-testbank"><i class="icon check circle"></i> <span tkey="label-submit"></span></a></div>
<?php else: ?>
	<div class="alert alert-warning"><i class="icon warning circle"></i> Not found question!</div>
<?php endif; ?>
</div>
<div style="display:none;" class="result-testbank">
	<div class="ui segment inverted pink" style="max-width:200px;padding-bottom: 20px;">
		<h2 align="center" tkey="label-score"></h2>
		<font size="86" id="score_testbank">1</font>
	</div>
</div>
<script>var ans=[]; var items = <?=$questionNums?>;var tid = <?=intval($_GET["id"])?>;</script>
<script src="<?=$_CONFIG["web_path"]?>/assets/js/testbank.js"></script>

<?php endif;else: ?>
<h1 align="left"><i class="icon check circle"></i> <b tkey="menu-testbank"></b> </h1>

<div align="left">
	<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
	<?php foreach($db->getRows("SELECT * FROM subjects ORDER BY id DESC") as $row): ?>
	<div class="panel panel-default">
		<div class="panel-heading" role="tab" id="headingOne">
			<h4 class="panel-title">
				<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$row["id"]?>" aria-expanded="true" aria-controls="collapseOne"><?=$row["subject_name"]?></a>
			</h4>
		</div>
		<div id="collapse<?=$row["id"]?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">

			<div class="list-group">
			<?php foreach($db->getRows("SELECT * FROM testbank WHERE test_subject=? AND visible=1",array($row["id"])) as $row0): ?>
				<a href="./?page=testbank&id=<?=$row0["id"]?>" class="list-group-item">
					<i class="icon file"></i> <?=$row0["test_title"]?> 
					<span class="badge"><?=$db->getNumber("SELECT * FROM testbank_question WHERE test_id=?",array($row0["id"]))?> <span tkey="label-testitem"></span></span>
				</a>
			<?php endforeach; ?>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
	</div>
</div>
<?php endif;} else{echo "Require login!";} ?>