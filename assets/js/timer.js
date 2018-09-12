$(document).ready(function(){
	var totalTime = 10;
	//var timer_start = "10:00";
	var interval = setInterval(function() {
	  var timer = timer_start.split(':');
	  //by parsing integer, I avoid all extra string processing
	  var minutes = parseInt(timer[0], 10);
	  var seconds = parseInt(timer[1], 10);
	  --seconds;
	  minutes = (seconds < 0) ? --minutes : minutes;
	  if (minutes < 0) clearInterval(interval);
	  seconds = (seconds < 0) ? 59 : seconds;
	  seconds = (seconds < 10) ? '0' + seconds : seconds;
	  //minutes = (minutes < 10) ?  minutes : minutes;
	  $('.timer').html(minutes + ':' + seconds);
	  timer_start = minutes + ':' + seconds;
	  totalTime = parseInt(minutes)*60 + parseInt(seconds);
	  if(totalTime<=0){timed_out=true;window.location="./?timeout"}
	}, 1000);
});
