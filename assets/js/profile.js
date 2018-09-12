$(".save-profile.button").click(function(){
	var firstname = $("input[name=firstname]").val();
	var lastname = $("input[name=lastname]").val();
	var old_pass = $("input[name=old_password]").val();
	var new_pass = $("input[name=new_password]").val();
	var cnew_pwd = $("input[name=confirm_new_password]").val();
	var notice = $("#profile_alert");

	$(this).attr("disabled","disabled");
	$(".ui.segment.profile").toggleClass("loading");
	if(firstname.length<=0 || lastname.length<=0){
		notice.removeClass("alert-danger").addClass("alert-danger").show(500).html("Please complete the form");
	} else if((new_pass.length>0 && new_pass.length<6) || (old_pass.length>0 && old_pass.length<6)){
		notice.removeClass("alert-danger").addClass("alert-danger").show(500).html("Password must more than 6 chars");
	} else if(new_pass != cnew_pwd){
		notice.removeClass("alert-danger").addClass("alert-danger").show(500).html("Old password and New password is incorrect");
	} else{
		if(new_pass.length<=0 || old_pass.length<=0){new_pass = "0";old_pass = "0";}
		$.post("public/api/profile.php",{"firstname":firstname,"lastname":lastname,"old_password":old_pass,"new_password":new_pass},function(data){
			$(".save-profile.button").removeAttr("disabled","disabled");
			$(".ui.segment.profile").toggleClass("loading");
			data = JSON.parse(data);
			if(data.status=="successful"){
				notice.removeClass("alert-danger").addClass("alert-success").show(500).html(data.message);
				setTimeout(function(){location.reload();},2000);
			} else{
				notice.removeClass("alert-danger").addClass("alert-danger").show(500).html(data.message);
			}
		});
	}
});

$("a.send-mail.btn").click(function(){
	$(".profile.ui.segment").toggleClass("loading");
	$.post("public/api/email_center.php",{"method":0},function(data){
		$(".profile.ui.segment").toggleClass("loading");
		data = JSON.parse(data);
		if(data.status=="successful"){
			$("#profile_alert").removeClass("alert-danger").addClass("alert-success").show(100).html("Email sent.");
		} else{
			$("#profile_alert").removeClass("alert-success").addClass("alert-danger").show(100).html("Something is incorrect");
		}
	});
});