<meta charset="utf-8" />
<h1 align="left"><i class="icon check square"></i> SCORE SLOT</h1>

<div align="left">
	<form action="" class="form-inline" method="get">
		<input type="hidden" name="page" value="<?=$_GET["page"]?>" />
		<select name="id" class="form-control">
			<?php
			foreach($db->getRows("SELECT * FROM subjects ORDER BY id DESC") as $row){
				$selected = null;
				if(isset($_GET["id"]) and is_numeric($_GET["id"]) and $_GET["id"]==$row["id"]){$selected="selected";}
				echo "<option value='".$row["id"]."' {$selected}>{$row["subject_name"]} ({$row["subject_code"]})</option>";
			}
			?>
		</select>
		<button type="submit" class="btn btn-primary">SEARCH</button>
	</form>
</div>

<?php
if(isset($_GET["id"]) and is_numeric($_GET["id"])){
	if($db->getNumber("SELECT * FROM subjects WHERE id=?",array(intval($_GET["id"])))>0){
		if(isset($_GET["delete"]) and is_numeric($_GET["delete"])){
			$db->insertRow("DELETE FROM score_slot WHERE slot_id=?;",array( intval($_GET["delete"]) ));
			echo "<script>window.location='./?page=scoreslot&id={$_GET["id"]}';</script>";
		}
		if(isset($_GET["update"]) and is_numeric($_GET["update"]) and isset($_POST["slot"])){
			$db->insertRow("UPDATE score_slot SET slot_name=?,full_score=? WHERE slot_id=?;",array($_POST["slot"],$_POST["score"],intval($_GET["update"])));
			echo "<script>window.location='./?page=scoreslot&id={$_GET["id"]}';</script>";
		}
		foreach($db->getRows("SELECT * FROM score_slot WHERE subject_id=?",array(intval($_GET["id"]))) as $row){
			echo "<div align='left' style='margin-bottom:10px;'><form class='form-inline' method='post' action='./?page=scoreslot&id={$_GET["id"]}&update={$row["slot_id"]}'>";
			echo "<b style='margin-right:10px;'>#{$row["slot_id"]}</b> <input type='text' class='form-control' name='slot' value='{$row["slot_name"]}' autocomplete='off' /> ";
			echo "<input type='text' class='form-control' name='score' value='{$row["full_score"]}' placeholder='Full Score' autocomplete='off' /> ";
			echo "<button class='btn btn-info' type='submit' onclick='return confirm(\"Sure?\")'><i class='glyphicon glyphicon-pencil'></i></button> ";
			echo "<a class='btn btn-danger' onclick='return confirm(\"Sure?\")' href='./?page=scoreslot&id={$_GET["id"]}&delete={$row["slot_id"]}'><i class='glyphicon glyphicon-remove-sign'></i></a>";
			echo "</form></div>";
		}
?>
<div class="ui segment">
<form class="form-inline" action="./?page=scoreslot&id=<?=intval($_GET["id"])?>" method="post">
<?php
if(isset($_POST["add"]) and is_array($_POST["add"])){
	foreach($_POST["add"] as $post){
		$db->insertRow("INSERT INTO score_slot (slot_id,slot_name,full_score,subject_id) VALUES (NULL,?,?,?);",array($post,0,intval($_GET["id"])));
	}
	echo "<div class='alert alert-success'><i class='icon circle check'></i> Successful!</div>";
	echo "<script>window.location='./?page=scoreslot&id={$_GET["id"]}';</script>";
}
?>
<div class='add-slot'></div>
<div align='left'><a href='#' class='add-slot-btn btn btn-xs btn-success'>Add</a> <button type="submit" class="btn btn-primary btn-xs pull-right">Submit</button></div>
</form>
</div>
<script>var id=0;$("a.add-slot-btn").click(function(){
	id++;
	$(".add-slot").append( 
		"<div align='left' style='margin-bottom:10px;' id='add"+id+"'><input type='text' name='add[]' placeholder='Score Slot Name' class='form-control' /> "+
		"<a href='#' class='btn btn-danger' data-id='add"+id+"' onclick='r(this);'><i class='glyphicon glyphicon-remove-sign'></i></a></div>"
	);
});function r(c){
	$("#"+$(c).data("id")).html("");
};</script>
<?php

	} else{
		echo "Please select subject!";
	}
}
?>