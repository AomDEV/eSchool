<?php
require("public/core/settings.php");
if(!class_exists('aom')){ require("public/classes/class.aom.php"); }
if(!class_exists('database')){ require("public/classes/class.database.php"); }
$db = new database($_CONFIG);
$aom = new aom($_CONFIG);
?>
<!--LOGIN UI/USER INFO-->
<div align="left" class="panel panel-primary" style="margin-bottom: 5px;">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="icon user"></i> <?php if(isset($_SESSION["account"]["uid"])){echo "ACCOUNT INFO";} else{echo "LOGIN";} ?></h3>
	</div>
	<div class="panel-body" style="margin:-5px;">

<?php
if(isset($_SESSION["account"]["uid"])){
	$owner_info = $db->getAccountByUID($_SESSION["account"]["uid"]);
?>
	<div><b tkey="label-fullname"></b>: <?=$aom->getFullName($owner_info)?></div>
	<?php if(isset($_SESSION["account"]["admin"]) and $_SESSION["account"]["admin"]==true){echo "<a href='./@backend' class='ui button fluid positive'><i class='icon users'></i> ADMIN</a>";} ?>
	<a href="./?page=logout" class="ui button negative fluid" style="margin-top:5px;"><i class="icon power off"></i> LOGOUT</a>
<?php } else{ ?>

<!--LOGIN FORM-->
<form autocomplete="off" onsubmit="return false">
<div class="login-form">
<div class="form-group">
<input type="text" class="form-control" name="username" placeholder="Username" autocomplete="off">
</div>
<div class="form-group">
<input type="password" class="form-control" name="password" placeholder="Password" autocomplete="off">
</div>
</div>
<button class="ui button positive fluid api-submit" data-api="login" data-inputgroup="login-form"><i class="icon check circle"></i> LOGIN</button>
</form>

<?php } ?>

	</div>
</div>

<?php
if(isset($_SESSION["account"]["uid"])){
?>
<!--USER MENU-->
<div class="ui inverted vertical menu fluid" align="left" style="margin-top: 0px;margin-bottom: 5px;">
	<a class="item" href="./#"><i class="icon home"></i> <span tkey="menu-home"></span></a>
	<a class="item" href="./?page=subject"><i class="icon clipboard outline"></i> <span tkey="menu-subject"></span></a>
	<a class="item" href="./?page=testbank"><i class="icon check circle"></i> <span tkey="menu-testbank"></span></a>
	<a class="item" href="./?page=report"><i class="icon file"></i> <span tkey="menu-report"></span></a>
	<a class="item" href="./?page=portfolio"><i class="icon folder"></i> <span tkey="menu-portfolio"></span></a>
	<a class="item" href="./?page=discussion"><i class="icon envelope"></i> <span tkey="menu-discussion"></span></a>
	<a class="item" href="./?page=contact"><i class="icon phone"></i> <span tkey="menu-contract"></span></a>
</div>
<?php
}
?>

<!--Facebook Fanpage-->
<div align="left" class="panel panel-primary" style="margin-bottom: 5px;">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="icon facebook"></i> Facebook</h3>
	</div>
	<div class="panel-body" style="padding:0px;">
		<div id="fb-root"></div>
		<script>(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/th_TH/sdk.js#xfbml=1&version=v2.12&appId=816651428371261&autoLogAppEvents=1';
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));</script>
		<div class="fb-page" data-href="<?=$_CONFIG['facebook_page']?>" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true">
			<blockquote cite="<?=$_CONFIG['facebook_page']?>" class="fb-xfbml-parse-ignore"><a href="<?=$_CONFIG['facebook_page']?>"><?=$_CONFIG['short_web_name']?></a></blockquote>
		</div>
	</div>
</div>