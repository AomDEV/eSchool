$("input[type=radio]").click(function(){
	ans[""+$(this).data("question")] = $(this).val();
});
$("a.submit-testbank").click(function(){
	var emptyQuestion = (ans.length - ans.filter(String).length);
	if(items == (ans.length - emptyQuestion)){
		$.post("public/actions/testbank.php",{answer:ans,test_id:tid},function(data){
			var m = JSON.parse(data);
			$(".testbank-box").hide(200);
			$(".result-testbank").show(200);
			$("#score_testbank").html(m.score);
		});
	} else{
		alert("Please complete the quiz!");
	}
});