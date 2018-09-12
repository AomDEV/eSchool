$("button.do-login").click(function(){
	$(".login-segment").toggleClass("loading");
	var email = $("input[name=email]").val();
	var password = $("input[name=password]").val();
	if(email.length<=0 && email.length>20 || password.length<=0){
		$(".login-segment").toggleClass("loading");
		$("#login_alert").toggleClass("alert-danger").show().html("Please complete the form");
	} else{
		$.post("public/api/authenticator.php",{"email":email,"pass":password},function(data){
			$(".login-segment").toggleClass("loading");
			data = JSON.parse(data);
			if(data.status=="successful"){
				$("#login_alert").toggleClass("alert-danger").toggleClass("alert-success").show().html(data.message);
				window.location="./";
			}
			$("#login_alert").toggleClass("alert-danger").show().html(data.message);
			console.log(data);
		});
	}
});

$("button.do-register").click(function(){
	$(".register-segment").toggleClass("loading");
	var email = $("input[name=email]").val();
	var password = $("input[name=password]").val();
	var firstname = $("input[name=firstname]").val();
	var lastname = $("input[name=lastname]").val();
	if((email.length<=0 && email.length>20) || (password.length<=0) || (firstname.length<=0) || (lastname.length<=0)){
		$(".register-segment").toggleClass("loading");
		$("#register_alert").toggleClass("alert-danger").show().html("Please complete the form");
	} else{
		$.post("public/api/authenticator.php",{"email":email,"pass":password,"firstname":firstname,"lastname":lastname},function(data){
			$(".login-segment").toggleClass("loading");
			data = JSON.parse(data);
			if(data.status=="successful"){
				$("#register_alert").toggleClass("alert-danger").toggleClass("alert-success").show().html(data.message);
				window.location="./?page=login";
			}
			$("#register_alert").toggleClass("alert-danger").show().html(data.message);
			console.log(data);
		});
	}
});