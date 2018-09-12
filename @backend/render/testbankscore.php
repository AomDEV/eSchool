<meta charset="utf-8" />
<h1 align="left"><i class="icon file outlime"></i> TESTBANK SCORE REPORT</h1>

<div align="left">
<form class='form-inline' method="get">
	<input type="hidden" name="page" value="<?=$_GET["page"]?>" />
	<select name="subject" class="form-control">
		<?php
		foreach($db->getRows("SELECT * FROM testbank ORDER BY id DESC") as $row){
			$getSubject = $db->getRow("SELECT subject_code  FROM subjects WHERE id=?",array($row["test_subject"]));
			$s = null;
			if(isset($_GET["subject"]) and $_GET["subject"]==$row["id"]){$s = "selected";}
			echo "<option value='{$row["id"]}' {$s}>{$row["test_title"]} ({$getSubject["subject_code"]})</option>";
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
</form>
</div>

<div class="table-responsive">
<?php
if(isset($_GET["subject"]) and is_numeric($_GET["subject"]) and isset($_GET["class"]) and is_numeric($_GET["class"])){
?>
<table border="1" class="" style="width: 100%;">
	<tr style="background-color: #ccc;"><th colspan="2"><center>#</center></th>
		<th align='center' height='100'><center><span>Score</b></span></center></th>
	</tr>
	<?php
	foreach($db->getRows("SELECT * FROM accounts WHERE class_id=?",array(intval($_GET["class"]))) as $row){
		$getScore = $db->getRow("SELECT score FROM testbank_history WHERE owner_id=?",array($row["uid"]));
		echo "<tr class='active'>";
		echo "<td><center>{$row["uid"]}</center></td>";
		echo "<td><div align=left style='margin-left:10px;'>{$row["first_name"]} {$row["last_name"]}</div></td>";
		echo "<td><center>".intval($getScore["score"])."</center></td>";
		echo "</tr>";
	}
	?>
</table>
<?php if(isset($_GET["action"]) and $_GET["action"]=="edit"){ ?>
<div align="right" style="margin-top:10px;">
<button type="submit" class="btn btn-primary"><i class="icon check circle"></i> SAVE</button>
</div>
<?php } } ?>
</div>