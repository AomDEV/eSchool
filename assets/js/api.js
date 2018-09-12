$(".api-submit").click(function(){
	var actionFile = $(this).data("api");
	var request = {};

	$("." + $(this).data("inputgroup")).each( function(){
		$(".form-control").each( function(){
			request[$(this).attr('name')] = $(this).val();
			$(this).val("");
		});
	} );

	$.post("public/actions/" + actionFile + ".php",request,function(callback){
		console.log(callback);
		var messages = $.parseJSON(callback);
		$.notify(messages.message, messages.type);
		if(messages.status==true){
			setTimeout(function(){ location.reload(); },3000);
		}
	});
});