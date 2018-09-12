<meta charset="utf-8" />
<h1 align="left"><i class="icon file outline"></i> REPORT</h1>

<?php
$permSQL = $db->getRows("SELECT * FROM permission WHERE uid=?",array($_SESSION["admin"]["uid"]));
$perm = array();
foreach($permSQL as $row){
	$perm[] = $row["allow_subject"];
}
?>
<div align="left">
<form class='form-inline' method="get">
	<input type="hidden" name="page" value="<?=$_GET["page"]?>" />
	<select name="subject" class="form-control">
		<?php
		foreach($db->getRows("SELECT * FROM subjects ORDER BY id DESC") as $row){
			if(in_array($row["id"], $perm) or in_array("-1", $perm)){
				$s = null;
				if(isset($_GET["subject"]) and $_GET["subject"]==$row["id"]){$s = "selected";}
				echo "<option value='{$row["id"]}' {$s}>{$row["subject_name"]} ({$row["subject_code"]})</option>";
			}
		}
		?>
	</select>
	<select name='class' class='form-control'>
		<?php
		foreach($db->getRows("SELECT * FROM class ORDER BY id DESC") as $row){
			$s = null;
			if(isset($_GET["class"]) and $_GET["class"]==$row["id"]){$s = "selected";}
			echo "<option value='{$row["id"]}' {$s}>{$row["class_name"]}</option>";
		}
		?>
	</select>
	<button type="submit" class="btn btn-success"><i class="icon search"></i> SEARCH</button>
	<?php if(isset($_GET["subject"]) and isset($_GET["class"]) and isset($_GET["page"])){ ?>
	<a href="./?page=<?=$_GET["page"]?>&subject=<?=$_GET["subject"]?>&class=<?=$_GET["class"]?>&action=edit" class="btn btn-primary"><i class="icon pencil"></i> EDIT</a>
	<?php } ?>
</form>
</div>

<style>
.vertTable {
    display:block;
    filter: flipv fliph;
    -webkit-transform: rotate(-90deg); 
    -moz-transform: rotate(-90deg); 
    transform: rotate(-90deg); 
    position:relative;
    width:20px;
    margin-bottom: 10px;
    white-space:nowrap;
}
table {
    text-align:center;
}
</style>
<div class="table-responsive">
<?php
if(isset($_GET["subject"]) and is_numeric($_GET["subject"]) and isset($_GET["class"]) and is_numeric($_GET["class"])){

?>
<form id="form" action="./?page=<?=$_GET["page"]?>&subject=<?=$_GET["subject"]?>&class=<?=$_GET["class"]?>" method="post">
<table border="1" class="" style="width: 100%;">
	<tr style="background-color: #ccc;"><th colspan="2"><center>#</center></th>
		<?php
		$totalScore=0;
		foreach($db->getRows("SELECT * FROM score_slot WHERE subject_id=?",array(intval($_GET["subject"]))) as $row){
			$totalScore+=$row["full_score"];
			echo "<th align='center' valign='bottom' height='140'><center><span class='vertTable'>{$row["slot_name"]} <b>({$row["full_score"]})</b></span></center></th>";
		}
		?>
		<th align='center' valign='bottom'><centeR><span class="vertTable">Total (<?=$totalScore?>)</span></centeR></th>
	</tr>
	<?php
	foreach($db->getRows("SELECT * FROM accounts WHERE class_id=?",array(intval($_GET["class"]))) as $row){
		$total=0;
		echo "<tr class='active'>";
		echo "<td><center>{$row["uid"]}</center></td>";
		echo "<td><div align=left style='margin-left:10px;'>{$row["first_name"]} {$row["last_name"]}</div></td>";
		foreach($db->getRows("SELECT * FROM score_slot WHERE subject_id=?",array(intval($_GET["subject"]))) as $row0){
			$getScore = $db->getRow("SELECT * FROM score WHERE slot_id=? AND score_owner=?",array($row0["slot_id"],$row["uid"]));
			$total+=intval($getScore["score"]);
			$score = intval($getScore["score"]);
			if(isset($_GET["action"]) and $_GET["action"]=="edit"){
				echo "<td><center style='margin-left:-18px;margin-right:-18px;margin-top:2px;margin-bottom:2px;'>";
				echo "<input type='text' class='form-control' autocomplete='off' onkeyup='c({$row["uid"]})' name='score[{$row["uid"]}][{$row0["slot_id"]}]' value='{$score}' style='width:60px;text-align:center;background-color:#2c3e50;color:#fff;' />";
				echo "</center></td>";
			} else{
				echo "<td><center>".$score."</center></td>";
			}
			if(isset($_POST) and isset($_POST["score"]) and is_array($_POST["score"])){
				if(isset($getScore["score"])){
					$sql = "UPDATE score SET score=? WHERE score_id=?;";
					$arr = array($_POST["score"][$row["uid"]][$row0["slot_id"]],$getScore["score_id"]);
				} else{
					$sql = "INSERT INTO score(score_id,slot_id,score,score_owner) VALUES (NULL,?,?,?)";
					$arr = array($row0["slot_id"],$_POST["score"][$row["uid"]][$row0["slot_id"]],$row["uid"]);
				}
				$db->insertRow($sql,$arr);
				echo "<script>window.location='./?page={$_GET["page"]}&subject={$_GET["subject"]}&class={$_GET["class"]}';</script>";
			}
		}
		echo "<td><center id='t_{$row["uid"]}'>{$total}</center></td>";
		echo "</tr>";
	}
	?>
</table>
<?php if(isset($_GET["action"]) and $_GET["action"]=="edit"){ ?>
<div align="right" style="margin-top:10px;">
<button type="submit" class="btn btn-primary"><i class="icon check circle"></i> SAVE</button>
</div>
<?php } ?>
</form>
<?php
}
?>
</div>
<script>
function c(uid){
	var total = 0;
	$('input[name^="score['+uid+']"]').each(function() {
		total+=parseInt($(this).val());
	});
	$("#t_"+uid).html(total);
}
</script>