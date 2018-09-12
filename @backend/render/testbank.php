<meta charset="utf-8" />
<h1 align="left"><i class="icon check circle"></i> TESTBANK</h1>

<div align="left">
	<form action="" class="form-inline" method="get">
		<input type="hidden" name="page" value="<?=$_GET["page"]?>" />
		<select name="subject" class="form-control">
			<?php
			foreach($db->getRows("SELECT * FROM subjects ORDER BY id DESC") as $row){
				$selected = null;
				if(isset($_GET["subject"]) and is_numeric($_GET["subject"]) and $_GET["subject"]==$row["id"]){$selected="selected";}
				echo "<option value='".$row["id"]."' {$selected}>{$row["subject_name"]} ({$row["subject_code"]})</option>";
			}
			?>
		</select>
		<?php
		if(isset($_GET["subject"]) and is_numeric($_GET["subject"])){
			echo '<select name="test" class="form-control">';
			foreach($db->getRows("SELECT * FROM testbank WHERE test_subject=? ORDER BY id DESC",array(intval($_GET["subject"]))) as $row){
				$selected = null;
				if(isset($_GET["test"]) and is_numeric($_GET["test"]) and $_GET["test"]==$row["id"]){$selected="selected";}
				echo "<option value='".$row["id"]."' {$selected}>{$row["test_title"]}</option>";
			}
			echo '</select>';
		}
		?>
		</select>
		<button type="submit" class="btn btn-primary">SEARCH</button>
	</form>
</div>

<?php
if(isset($_GET["subject"]) and is_numeric($_GET["subject"]) and isset($_GET["test"]) and is_numeric($_GET["test"])){
	if($db->getNumber("SELECT * FROM subjects WHERE id=?",array(intval($_GET["subject"])))>0){
		if(isset($_GET["delete"]) and is_numeric($_GET["delete"])){
			$db->insertRow("DELETE FROM testbank_question WHERE qid=?;",array( intval($_GET["delete"]) ));
			echo "<script>window.location='./?page=testbank&subject={$_GET["subject"]}&test={$_GET["test"]}';</script>";
		}
		if(isset($_GET["update"]) and is_numeric($_GET["update"]) and isset($_POST["question"]) and isset($_POST["score"])){
			$image = filter_input(INPUT_POST, "image");
			$db->insertRow("UPDATE testbank_question SET question=?,score=?,image=? WHERE qid=?;",array($_POST["question"],intval($_POST["score"]),$image,intval($_GET["update"])));
			echo "<script>window.location='./?page=testbank&subject={$_GET["subject"]}&test={$_GET["test"]}';</script>";
		}

		if(isset($_GET["ans_delete"]) and is_numeric($_GET["ans_delete"])){
			$db->insertRow("DELETE FROM testbank_answer WHERE aid=?;",array( intval($_GET["ans_delete"]) ));
			echo "<script>window.location='./?page=testbank&subject={$_GET["subject"]}&test={$_GET["test"]}';</script>";
		}
		if(isset($_GET["ans_update"]) and is_numeric($_GET["ans_update"]) and isset($_POST["answer"])){
			$db->insertRow("UPDATE testbank_answer SET answer=?,is_correct=?,is_image=? WHERE aid=?;",array($_POST["answer"],isset($_POST["correct"]),isset($_POST["image"]),intval($_GET["ans_update"])));
			echo "<script>window.location='./?page=testbank&subject={$_GET["subject"]}&test={$_GET["test"]}';</script>";
		}

		if(isset($_POST["ans"]) and is_array($_POST["ans"]) and isset($_POST["question_id"]) and is_numeric($_POST["question_id"])){
			$intqid = intval($_POST["question_id"]);
			foreach($_POST["ans"] as $link=>$post){
				$db->insertRow("INSERT INTO testbank_answer(aid,question_id,answer,is_correct,is_image)VALUES(NULL,?,?,?,?);",array($intqid,$post,isset($_POST["correct"][$link]),isset($_POST["image"][$link])));
			}
		}
		foreach($db->getRows("SELECT * FROM testbank_question WHERE test_id=?",array(intval($_GET["test"]))) as $order=>$row){
			$order++;
			echo "<div align='left'>";
			echo "<div style='margin-bottom:10px'><form class='form-inline' method='post' action='./?page=testbank&subject={$_GET["subject"]}&test={$_GET["test"]}&update={$row["qid"]}'>";
			echo "<b style='margin-right:10px;'>{$order}.</b> ";
			echo "<input type='text' class='form-control' name='question' placeholder='Question' value='{$row["question"]}' /> ";
			echo "<input type='text' class='form-control' name='image' placeholder='Image' value='{$row["image"]}' /> ";
			echo "<input type='text' class='form-control' style='max-width:100px;' placeholder='Score' name='score' maxlength='3' value='{$row["score"]}' /> ";
			echo "<button class='btn btn-info' type='submit' onclick='return confirm(\"Sure?\")'><i class='glyphicon glyphicon-pencil'></i></button> ";
			echo "<a class='btn btn-danger' onclick='return confirm(\"Sure?\")' href='./?page=testbank&subject={$_GET["subject"]}&test={$_GET["test"]}&delete={$row["qid"]}'>";
			echo "<i class='glyphicon glyphicon-remove-sign'></i></a> ";
			echo "<button class='btn btn-primary' type='button' onclick='add({$row["qid"]})'><i class='glyphicon glyphicon-plus-sign'></i></button> ";
			echo "</form></div></div>";

			foreach($db->getRows("SELECT * FROM testbank_answer WHERE question_id=?",array($row["qid"])) as $row0){
				$checked=null;if($row0["is_correct"]==true){$checked = "checked";}
				$image=null;if($row0["is_image"]==true){$image = "checked";}
				echo "<div align=left style='margin-left:40px;margin-bottom:10px;'>";
				echo "<form class='form-inline' method=post action='./?page=testbank&subject={$_GET["subject"]}&test={$_GET["test"]}&ans_update={$row0["aid"]}'>";
				echo "<input type='text' class='form-control' name='answer' value='{$row0["answer"]}' /> ";
				echo "<label style='margin-left:10px;margin-right:10px;'><input type='checkbox' name='correct' value='1' {$checked}> Correct</label> ";
				echo "<label style='margin-left:10px;margin-right:10px;'><input type='checkbox' name='image' value='1' {$image}> Image</label> ";
				echo "<button class='btn btn-info' type='submit' onclick='return confirm(\"Sure?\")'><i class='glyphicon glyphicon-pencil'></i></button> ";
				echo "<a class='btn btn-danger' onclick='return confirm(\"Sure?\")' href='./?page=testbank&subject={$_GET["subject"]}&test={$_GET["test"]}&ans_delete={$row0["aid"]}'>";
				echo "<i class='glyphicon glyphicon-remove-sign'></i></a>";
				echo "</form>";
				echo "</div>";
			}

			echo "<form method='post' action='./?page=testbank&subject={$_GET["subject"]}&test={$_GET["test"]}'>";
			echo "<input type='hidden' name='question_id' value='{$row["qid"]}' />";
			echo "<div id='ans{$row["qid"]}'></div>";
			echo "<div align=left style='margin-left:20px;display:none;' id='save{$row["qid"]}'><button type=submit class='btn btn-info'>Save</button></div>";
			echo "</form>";
		}
?>
<div class="ui segment">
<form class="form-inline" action="./?page=testbank&subject=<?=intval($_GET["subject"])?>&test=<?=intval($_GET["test"])?>" method="post">
<?php
if(isset($_POST["add"]) and is_array($_POST["add"]) and isset($_POST["score"]) and is_array($_POST["score"])){
	foreach($_POST["add"] as $link=>$post){
		$db->insertRow("INSERT INTO testbank_question (qid,question,test_id,score) VALUES (NULL,?,?,?);",array($post,intval($_GET["test"]),$_POST["score"][$link]));
	}
	echo "<div class='alert alert-success'><i class='icon circle check'></i> Successful!</div>";
	echo "<script>window.location='./?page=testbank&subject={$_GET["subject"]}&test={$_GET["test"]}';</script>";
}
?>
<div class='add-slot'></div>
<div align='left'><a href='#' class='add-slot-btn btn btn-xs btn-success'>Add</a> <button type="submit" class="btn btn-primary btn-xs pull-right">Submit</button></div>
</form>
</div>
<script>var id=0;var qids=0;$("a.add-slot-btn").click(function(){
	id++;
	$(".add-slot").append( 
		"<div align='left' style='margin-bottom:10px;' id='add"+id+"'><input type='text' name='add[]' autocomplete='off' class='form-control' placeholder='Question' /> "+
		"<input type='text' name='score[]' class='form-control' autocomplete='off' placeholder='Score' /> " +
		"<a href='#' class='btn btn-danger' data-id='add"+id+"' onclick='r(this);'><i class='glyphicon glyphicon-remove-sign'></i></a></div>"
	);
});function r(c){
	$("#"+$(c).data("id")).html("");
	if($("#ans"+c).find(":input").length <= 0){$("#save"+qid).hide(200);}
};function add(qid){qids++;$("#save"+qid).show(200);$("#ans"+qid).append("<div style='margin-bottom:10px;margin-left:20px;' align='left' id='ans"+qid+"_"+qids+"' class='form-inline'><input class='form-control' name='ans[]' placeholder='Answer' /> "+
"<label style='margin-left:10px;margin-right:10px;'><input type='checkbox' name='correct' value='1'> Correct</label> "+
"<label style='margin-left:10px;margin-right:10px;'><input type='checkbox' name='image' value='1'> Image</label> "+
"<a href='#' class='btn btn-danger' data-id='ans"+qid+"_"+qids+"' onclick='r(this);'><i class='glyphicon glyphicon-remove-sign'></i></a></div>");}</script>
<?php

	} else{
		echo "Please select subject!";
	}
}
?>