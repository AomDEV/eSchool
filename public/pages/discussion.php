<?php 
date_default_timezone_set('Asia/Bangkok');  
require("public/core/settings.php");
if(!class_exists('database')){ require("public/classes/class.database.php"); }
if(!class_exists('aom')){ require("public/classes/class.database.php"); }
$db = new database($_CONFIG);
$aom = new aom($_CONFIG);
$aom->requireLogin($_SESSION);
if(isset($_GET["id"]) and is_numeric($_GET["id"])):
	if($db->getNumber("SELECT * FROM board_topic WHERE id=?",array(intval($_GET["id"]))) <= 0):
?>
	<div class="alert alert-danger"><i class="glyphicon glyphicon-exclamation-sign"></i> Not found this topic</div>
<?php
	else:
	$discussionInfo = $db->getRow("SELECT * FROM board_topic WHERE id=?",array(intval($_GET["id"])));
?>
<h1 align="left"><i class="icon envelope"></i> <b><?=$discussionInfo["topic"]?></b></h1>
<div class="ui segments">
	<div class="ui segment green stacked " align="left"><?=$discussionInfo["content"]?></div>
	<div class="ui secondary segment" style="padding:5px;" align="left">
		Post by : <b><?=$aom->getFullName($db->getAccountByUID($discussionInfo["post_by"]))?></b> 
		(<?=$aom->timeago($discussionInfo["time"])?>)
	</div>
</div>

<?php foreach($db->getRows("SELECT * FROM board_comment WHERE topic_id=? ORDER BY time DESC",array(intval($_GET["id"]))) as $row): ?>
	<div class="ui segments" style="margin-left: 40px;">
		<div class="ui segment grey" align="left"><?=$row["comment"]?></div>
		<div class="ui segment secondary" align="left" style="padding:5px;">
			<b>#<?=$row["id"]?></b>,  Comment by : <b><?=$aom->getFullName($db->getAccountByUID($row["post_by"]))?></b> 
			(<?=$aom->timeago($row["time"])?>)
		</div>
	</div>
<?php endforeach; ?>

<form class="ui reply form" style="margin-left: 40px;"">
	<div class="field">
		<textarea placeholder="Reply this topic" name="reply" class="form-control" style="margin-top: 0px; margin-bottom: 0px; height: 80px;"></textarea>
		<input type="hidden" class="form-control" name="id" value="<?=$_GET["id"]?>" />
	</div>
	<div align="right">
		<button class="ui blue labeled submit icon button api-submit" type="button" data-api="add_reply" data-inputgroup="field"><i class="icon edit"></i> Add Reply</button>
	</div>
</form>

<?php
endif;else:if(isset($_GET["action"]) and $_GET["action"]=="create"):
if(isset($_POST) and isset($_POST["topic"]) and isset($_POST["content"])):
	$sql = "INSERT INTO board_topic (id,topic,content,post_by,time) VALUES (NULL,?,?,?,?)";
	$arr = array(htmlentities($_POST["topic"]),$_POST["content"],$_SESSION["account"]["uid"],time());
	$db->insertRow($sql,$arr);
	echo '<h1 align="left"><i class="icon envelope"></i> <b>CREATE TOPIC</b></h1>';
	echo "<div class='alert alert-success'><i class='icon check circle'></i> Successful!</div>";
	echo '<script>setTimeout(function(){window.location="./?page=discussion";},2000);</script>';
else:
?>
<h1 align="left"><i class="icon envelope"></i> <b>CREATE TOPIC</b></h1>
<form class="ui form" action="./?page=<?=$_GET["page"]?>&action=create" method="post">
<div class="form-group" align="left">
	<label for="topic" tkey="label-topic"></label>
	<input type="text" class="form-control" autocomplete="off" placeholder="Topic" name="topic">
</div>

<div class="form-group" align="left">
	<label for="content" tkey="label-content"></label>
	<input type="text" class="form-control" autocomplete="off" placeholder="Content" name="content">
</div>

<div align="right">
	<button type="submit" class="btn btn-primary"><i class="icon plus circle"></i> CREATE</button>
</div>
</form>

<script src="public/core/ckeditor/ckeditor.js"></script>
<script>
var getDefaultVal = unescape($("input[name=content]").val());
CKEDITOR.replace( 'content' );
CKEDITOR.instances['content'].setData(getDefaultVal);
$('.ui.form').submit(function(ev) {
	var getText = CKEDITOR.instances['content'].getData();
	if($("input[name=content]").length>0){
		$("input[name=content]").val((getText));
	} else{
		$(".ui.form").append("<input type='hidden' name='content' value='"+getText+"' />");
	}
})
</script>
<?php
endif;
else:
$page = isset($_GET['n']) ? intval($_GET['n']) : 1;
$recordsPerPage = 10;
$fromRecordNum = ($recordsPerPage * $page);
$toRecord = $fromRecordNum-$recordsPerPage;
?>
	<h1 align="left"><b><i class="icon envelope"></i> <font tkey="menu-discussion"></font></b></h1>

	<div class="table-responsive ui segment" style="padding-left:0px;padding-right:0px;">
		<table class="table table-hover" style="margin:-14px;">
			<tr class="active"> <th width="10%"><center>#</center></th> <th><center>Topic</center></th> <th width="20%"><center>Time</center></th> <th><center>By</center></th> </tr> 
			<?php $topicCount = 0;foreach($db->getRows("SELECT * FROM board_topic ORDER BY id DESC LIMIT $toRecord,$fromRecordNum") as $link=>$row):$topicCount++; ?>
				<tr>
					<td><center><?=$row["id"]?></center></td>
					<td><center><a href="./?page=discussion&id=<?=$row["id"]?>"><?=$row["topic"]?></a></center></td>
					<td><center><?=$aom->timeago($row["time"])?></center></td>
					<td><center><?=$aom->getFullName($db->getAccountByUID($row["post_by"]))?></center></td>
				</tr>
			<?php endforeach;if($topicCount<=0): ?>
			<tr> <th colspan=4><center>Not found topic</center></th> </tr> 
		<?php endif; ?>
		</table>
	</div>

<div align="right">
	<a href="./?page=<?=$_GET["page"]?>&action=create" class="btn btn-sm btn-primary"><i class="icon plus circle"></i> Create Topic</a>
</div>

<?php
$total_rows = $db->getNumber("SELECT * FROM board_topic",array());
$total_pages = ceil($total_rows / $recordsPerPage);
$range = 2;
$initial_num = $page - $range;
$condition_limit_num = ($page + $range)  + 1;
for ($x=$initial_num; $x<$condition_limit_num; $x++) {
    if (($x > 0) && ($x <= $total_pages)) {
        if ($x == $page) {
            echo "<a href='#' class='btn btn-sm btn-primary disabled'>$x</a>";
        } 
        else {
            echo " <a href='./?page=discussion&n=$x' class='btn btn-sm btn-default'>$x</a> ";
        }
    }
}
endif;
endif;
?>