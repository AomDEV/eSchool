<meta charset="utf-8" />
<h1 align="left"><i class="icon file"></i> PORTFOLIO</h1>

<?php
foreach($db->getRows("SELECT * FROM subjects ORDER BY id DESC") as $row){$dropdown["subject_id"][$row["id"]] = $row["subject_name"]." ({$row["subject_code"]})";}
$backend = new backend($_CONFIG,$db);
$backend->setTable("subject_describe");
$backend->setPrimaryName("id");
$backend->allowAddButton(true);
$backend->setReadonly(array("id"));
$backend->setDropdown($dropdown);
$backend->setColumn(array("id"=>"ID","subject_id"=>"Subject","content"=>"Content"));
$backend->render('table',$_REQUEST);
?>


<script src="../public/core/ckeditor/ckeditor.js"></script>
<script>
var getDefaultVal = unescape($("input[name=content]").val());
CKEDITOR.replace( 'content' );
CKEDITOR.instances['content'].setData(getDefaultVal);
$('.ui.form').submit(function(ev) {
	var getText = CKEDITOR.instances['content'].getData();
	if($("input[name=content]").length>0){
		//$("input[name=content]").val(btoa(unescape(encodeURIComponent(getText))));
		$("input[name=content]").val((getText));
	} else{
		//$(".ui.form").append("<input type='hidden' name='content' value='"+btoa(unescape(encodeURIComponent(getText)))+"' />");
		$(".ui.form").append("<input type='hidden' name='content' value='"+getText+"' />");
	}
})
</script>