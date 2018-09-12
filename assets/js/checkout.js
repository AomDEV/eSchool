$(document).ready(function(){
	$("#old_price").html(total_price+" <sup>THB</sup>");
});
function animateScrollToPointer(pointer){
	$('html, body').animate({
		scrollTop: $(pointer).offset().top
	}, 1000);
}
function validateEmail(email) {
  var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  return re.test(email);
}
function validatePhone (phone){
	var re = /^((06|08|09)[0-9]{8})/;
	return re.test(phone);
}
function applyPromotion(promo){
	$("button.use-promo").prop("disabled",true);
	setTimeout(function(){$("button.use-promo").prop("disabled",false);},5000);
	$.post("public/api/check_coupon.php",{"promocode":promo},function(data){
		data = JSON.parse(data);
		var typeText = ["THB","%"];
		if(data.status=="successful"){
			$(".promotion.ui.input").hide();
			$(".symbol.icon").hide();
			$(".promo-info.ui.label").show();$("span.label-promo").html("-"+data.amount+typeText[data.type]);
			var newPrice = total_price*((100-data.amount)/100);
			if(data.type==0){newPrice = total_price-data.amount;}
			$("#old_price").html("<span class='pull-right' style='margin-left:10px;'>"+newPrice+" <sup>THB</sup> </span> <font style='font-size:14px;' class='pull-right'><s>"+total_price+" THB</s></font>");
		} else{
			$(".symbol.icon").show();
		}
	});
}
$("button.use-promo").click(function(){
	var promo = $('input[name=promocode]').val();
	if(promo.length<=0){$(".symbol.icon").show();}
	applyPromotion(promo);
});
$(".remove-promo.icon").click(function(){
	$('input[name=promocode]').val("");
	$("#old_price").html(total_price + " <sup>THB</sup>");
	$(".promotion.ui.input").show();
	$(".promo-info.ui.label").hide();
});
function requestAction(params,btn_elem,modal_pointer){
	var alert_pointer = "#omise_alert";
	$("div.main-segment").toggleClass("loading");
	$(modal_pointer).modal('toggle');
	var email = $("input[name=email]").val();
	var phone = $("input[name=phone]").val();
	if(!validateEmail(email)){
		$(this).prop("disabled",false);
		$("div.main-segment").toggleClass("loading");
		$(alert_pointer).removeClass("alert-success").addClass("alert-danger").show().html("Email is not valid");
		animateScrollToPointer(alert_pointer);
		return;
	}
	if(!validatePhone(phone)){
		$(this).prop("disabled",false);
		$("div.main-segment").toggleClass("loading");
		$(alert_pointer).removeClass("alert-success").addClass("alert-danger").show().html("Phone is not valid");
		animateScrollToPointer(alert_pointer);
		return;
	}
	params["email"] = email;
	params["phone"] = phone;
	$.post("public/api/payment.php",params,function(data){
		$("div.main-segment").toggleClass("loading");
		console.log(data);
		data = JSON.parse(data);
		$(btn_elem).prop("disabled",false);
		if(data.status=="failure"){
			$(alert_pointer).removeClass("alert-success").addClass("alert-danger").show().html(data.message);
		} else{
			$("div.ui.order-info").hide(500);
			$(alert_pointer).removeClass("alert-danger").addClass("alert-success").show().html(data.message);
			timed_out = true;
			if(data.method==0){
				window.location = "./?view="+data.serial;
			} else{
				window.location = data.authorize_uri;
			}
		}
		animateScrollToPointer(alert_pointer);
		console.log(data);
	});
}
$("button.creditcard.pay").click(function(){
	var email	= $('input.email'),
		phone	= $('input.phone'),
		ccnum	= $('.card-no'),
		expiry	= $('.card-exp'),
		cvc 	= $('.card-cvv'),
		promocode = $('input[name=promocode]').val();

	if(ccnum.val().length <= 0 || expiry.val().length <= 0 || cvc.val().length <= 0){
		$("#omise_alert").show().html("Please complete the form.");
		return;
	}

	var parse_exp = $.trim(expiry.val()).split('/');

	// Disable the submit button to avoid repeated click.
	$(this).prop("disabled", true);

	var card = {
		"name": $(".card-name[data-omise=holder_name]").val(),
		"number": $(".card-no[data-omise=number]").val(),
		"expiration_month": parseInt(parse_exp[0]),
		"expiration_year": parseInt(parse_exp[1]),
		"security_code": $(".card-cvv[data-omise=security_code]").val()
	};

	var method_id = 0;
	requestAction({"seats":seats,"method":method_id,"promocode":promocode,"time":time,"omise_card_info":card},this,".modal-creditcard");
});
var payment_option = "select[name=payment-option]";
var initOptions = function(options,method){
	$(payment_option).attr("data-payment",method);
	$(payment_option).html("");
	for(var i=0;i<options.length;i++){
		$(payment_option).append("<option value='"+i+"'>"+options[i]+"</option>");
	}
}
$("button.internet-banking").click(function(){
	var options = ["Krungsri Online","KTB Netbank","SCB Easy Net","Bualuang iBanking"];
	initOptions(options,1);
});
$("button.counter-service").click(function(){
	var options = ["Tesco lotus Bill Payment"];
	initOptions(options,2);
});
$("button.options.pay").click(function(){
	console.log("init");
	var promocode = $('input[name=promocode]').val();
	requestAction({"seats":seats,"method":1,"promocode":promocode,"time":time,"type":parseInt($('select[name=payment-option]').val())},this,".modal-options");
});
window.onbeforeunload = function(){
	if(timed_out!=true){
		$.post("public/api/leave.php",{"seats":seats,"time":time},function(data){console.log(data);});
		return 'Are you sure you want to leave?';
	}
};