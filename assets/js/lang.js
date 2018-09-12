$(document).ready(function(){
	var langList = ["en","th"];
	var langCode = 'th';
	var langJS = null;

	var translate = function (jsdata)
	{	
		$("[tkey]").each (function (index)
		{
			var strTr = "###";
			if(jsdata [$(this).attr ('tkey')] != undefined){
				strTr = jsdata [$(this).attr ('tkey')];
			}
		    $(this).html (strTr);
		});
	}
	var changeLang = window.location.href.substring(window.location.href.length-2);
	if($.inArray(changeLang,langList) > 0){
		Cookies.set("lang",changeLang);
		langCode = changeLang;
	} else{
		Cookies.set("lang","th");
		langCode = "th";
	}
	if ($.inArray(langCode,langList) > 0){
		$.getJSON('assets/js/lang/' + langCode + '.json', translate);
	} else {
		$.getJSON('assets/js/lang/en.json', translate);
	}
});