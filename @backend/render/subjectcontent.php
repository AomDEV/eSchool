<meta charset="utf-8" />
<h1 align="left"><i class="icon file"></i> SUBJECT CONTENT</h1>

<?php
foreach($db->getRows("SELECT * FROM subjects ORDER BY id DESC") as $row){$dropdown["subject_id"][$row["id"]] = $row["subject_name"]." ({$row["subject_code"]})";}
$dropdown["visible"] = array("False","True");
$backend = new backend($_CONFIG,$db);
$backend->setTable("subject_content");
$backend->setPrimaryName("id");
$backend->allowAddButton(true);
$backend->setReadonly(array("id"));
$backend->setDropdown($dropdown);
$backend->setColumn(array("id"=>"ID","subject_id"=>"Subject ID","content_tab"=>"Content Tab","exercise_tab"=>"Exercise Tab","video_tab"=>"Video Tab","lesson"=>"Lesson","visible"=>"Visible"));
$backend->render('table',$_REQUEST);
?>


<script src="../public/core/ckeditor/ckeditor.js"></script>
<script>
var getDefaultVal = unescape($("input[name=content_tab]").val());
CKEDITOR.replace( 'content_tab' );
CKEDITOR.instances['content_tab'].setData(getDefaultVal);
$('.ui.form').submit(function(ev) {
	var getText = CKEDITOR.instances['content_tab'].getData();
	if($("input[name=content_tab]").length>0){
		$("input[name=content_tab]").val((getText));
	} else{
		$(".ui.form").append("<input type='hidden' name='content_tab' value='"+getText+"' />");
	}
});

var getDefaultVal0 = unescape($("input[name=video_tab]").val());
CKEDITOR.replace( 'video_tab' );
CKEDITOR.instances['video_tab'].setData(getDefaultVal0);
$('.ui.form').submit(function(ev) {
	var getText = CKEDITOR.instances['video_tab'].getData();
	if($("input[name=video_tab]").length>0){
		$("input[name=video_tab]").val((getText));
	} else{
		$(".ui.form").append("<input type='hidden' name='video_tab' value='"+getText+"' />");
	}
});

var getDefaultVal1 = unescape($("input[name=exercise_tab]").val());
CKEDITOR.replace( 'exercise_tab' );
CKEDITOR.instances['exercise_tab'].setData(getDefaultVal1);
$('.ui.form').submit(function(ev) {
	var getText = CKEDITOR.instances['exercise_tab'].getData();
	if($("input[name=exercise_tab]").length>0){
		$("input[name=exercise_tab]").val((getText));
	} else{
		$(".ui.form").append("<input type='hidden' name='exercise_tab' value='"+getText+"' />");
	}
});
</script>