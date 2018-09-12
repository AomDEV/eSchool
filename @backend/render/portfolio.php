<meta charset="utf-8" />
<h1 align="left"><i class="icon file"></i> PORTFOLIO</h1>

<?php
$backend = new backend($_CONFIG,$db);
$backend->setTable("portfolio");
$backend->setPrimaryName("id");
$backend->allowAddButton(true);
$backend->setLastTime("post_time");
$backend->setReadonly(array("post_by","id"));
$backend->autoFill("post_by",$_SESSION["admin"]["uid"]);
//$backend->InputBase64(array("content"));
$backend->setColumn(array("id"=>"ID","post_by"=>"UID","title"=>"Title","content"=>"Content","title_image"=>"Image URL"));
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