function isEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
$(".ui.button.forgot").click(function(){
	var email = $("input[name=email]").val();
	if(email.length<=0){
		$("#forgot_alert").addClass("alert-danger").show(100).html("Please enter email");
	} else if(!isEmail(email)){
		$("#forgot_alert").addClass("alert-danger").show(100).html("Email is incorrect");
	} else{
		$(".ui.segment.forgot").toggleClass("loading");
		$.post("public/api/email_center.php",{"method":1,"email":email},function(data){
			$(".ui.segment.forgot").toggleClass("loading");
			data = JSON.parse(data);
			if(data.status=="successful"){
				$(".ui.button.forgot").prop("disabled",true);
				$("#forgot_alert").removeClass("alert-danger").addClass("alert-success").show(100).html("Email sent.");
			} else{
				$("#forgot_alert").removeClass("alert-success").addClass("alert-danger").show(100).html(data.message);
			}
		});
	}
});

$(".ui.button.reset").click(function(){
	var new_pass = $("input[name=new_password]").val();
	var con_pass = $("input[name=confirm_password]").val();
	if(new_pass.length<=0 || con_pass.length<=0){
		$("#reset_alert").addClass("alert-danger").show(100).html("Please complete the form");
	} else if(new_pass!=con_pass){
		$("#reset_alert").addClass("alert-danger").show(100).html("Password doesn't match");
	} else{
		$(".ui.segment.forgot").toggleClass("loading");
		$.post("public/api/reset_pass.php",{"new_password":new_pass,"con_password":con_pass,"token":token},function(data){
			$(".ui.segment.forgot").toggleClass("loading");
			data = JSON.parse(data);
			if(data.status=="successful"){
				$(".ui.button.forgot").prop("disabled",true);
				$("#reset_alert").removeClass("alert-danger").addClass("alert-success").show(100).html("Password reset successful");
				setTimeout(function(){window.location="./?page=login";},2000);
			} else{
				$("#reset_alert").removeClass("alert-success").addClass("alert-danger").show(100).html(data.message);
			}
		});
	}
});