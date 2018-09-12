<?php
class aom{
	private $config = array();
	
	public function __construct($config=array()){
		$this->config = $config;
	}

	public function request($key){
		return isset($_REQUEST[$key]) ? $_REQUEST[$key] : false;
	}

	public function has_request($key){
		return $this->request($key)==true;
	}

	public function requireLogin($session){
		return isset($session["account"]["uid"]);
	}

	public function render($page_name){
		$realPath = $this->config["web_path"] . "/public/pages/" . str_replace(".","_",$page_name) . ".php";
		if(file_exists($realPath)){
			include ($realPath);
		} else{
			include ($this->config["web_path"] . "/public/pages/404.php");
		}
	}

	public function getFullName($accountInfo){
		return $accountInfo["first_name"]." ".$accountInfo["last_name"];
	}

	public function IsAdmin($accountInfo){
		return ($accountInfo["role"]==0);
	}

	public function timeago($time_ago){
		$current_time = time();
		$time_difference = $current_time - $time_ago;
		$seconds = $time_difference;
		$minutes = round($seconds / 60 );
		$hours = round($seconds / 3600);
		$days = round($seconds / 86400);
		$weeks = round($seconds / 604800);
		$months = round($seconds / 2629440);
		$years = round($seconds / 31553280);
		if($seconds <= 60) {  
     		return "Just Now";  
		} else if($minutes <=60){  
			if($minutes==1){  
				return "1 min ago";  
			} else{  
				return "$minutes mins ago";  
			}  
		} else if($hours <=24){  
			if($hours==1) {  
				return "an hour ago";  
			} else{  
				return "$hours hrs ago";  
			}  
		} else if($days <= 7){  
			if($days==1) {  
				return "yesterday";  
			} else{  
				return "$days days ago";  
			}  
		} else if($weeks <= 4.3) {  
			if($weeks==1) {  
				return "a week ago";  
			} else{  
				return "$weeks weeks ago";  
			}  
		} else if($months <=12) {  
			if($months==1) {  
				return "a month ago";  
			} else{  
				return "$months months ago";  
			}  
		} else {  
			if($years==1) {  
				return "one year ago";  
			} else{  
				return "$years years ago";  
			}  
		}  
	}
}
?>