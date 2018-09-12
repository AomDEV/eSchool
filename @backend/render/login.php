<div class="ui segment" style="max-width:400px;">
	<form action="" method="post">
	<h2><i class="icon user"></i> LOGIN</h2><hr />
	<?php
	if(isset($_REQUEST["username"]) and isset($_REQUEST["password"])){
		$sqlAdmin="SELECT * FROM accounts WHERE role=0 AND username=? AND password=?";
		if($db->getNumber($sqlAdmin,array($_REQUEST["username"],md5($_REQUEST["password"]))) > 0){
			$_SESSION["admin"]["uid"] = $db->getRow($sqlAdmin,array($_REQUEST["username"],md5($_REQUEST["password"])))["uid"];
			echo "<div class='alert alert-success'>Login successful!</div><script>setTimeout(function(){location.reload();},1000);</script>";
		} else{ echo "<div class='alert alert-danger'>Username or Password is Incorrect</div>"; }
	}
	?>
	<div align="left" style="margin-bottom:10px;"><input type="text" class="form-control input-lg" placeholder="Username" autocomplete="off" required="" name="username" /></div>
	<div align="left" style="margin-bottom:10px;"><input type="password" class="form-control input-lg" placeholder="Password" autocomplete="off" required="" name="password" /></div>

	<div align="right">
		<button class="btn btn-success" type="submit"><i class="icon check"></i> LOGIN</button> <a href="../" class="btn btn-default"><i class="icon home"></i> Home</a>
	</div>
	</form>
</div>