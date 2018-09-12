<?php
session_start();
require("assets.php");
require("../public/core/settings.php");
require("../public/classes/class.database.php");
require("../public/classes/class.backend.php");

$db = new database($_CONFIG);
date_default_timezone_set("Asia/Bangkok");
?>
<style>body{background-color: #ccc}</style>
<title>ADMIN</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<div align="center">
<div class="container" style="padding:10px;">
<?php if(!isset($_SESSION["admin"]["uid"])){include("render/login.php");} else{ ?>
<div class="row">

<div class="col-md-3">
<div class="ui vertical pointing menu fluid" align="left" style="margin-bottom:10px;">
	<a class="item" href="./"><i class="icon home"></i> Home</a>
	<a class="item" href="./?page=accounts"><i class="icon users"></i> Accounts</a>
	<a class="item" href="./?page=annoucement"><i class="icon chat"></i> Annoucement</a>
	<a class="item" href="./?page=class"><i class="icon home square"></i> Class</a>
	<a class="item" href="./?page=portfolio"><i class="icon chat"></i> Portfolio</a>
	<a class="item" href="./?page=subject"><i class="icon check circle"></i> Subject</a>
	<a class="item" href="./?page=scoreslot"><i class="icon check square"></i> Score Slot</a>
	<a class="item" href="./?page=report"><i class="icon file outline"></i> Report</a>
	<a class="item" href="./?page=subjectcontent"><i class="icon file square"></i> Subject Content</a>
	<a class="item" href="./?page=subjectdescribe"><i class="icon file square"></i> Subject Describe</a>
	<a class="item" href="./?page=testbanktitle"><i class="icon file outline"></i> Testbank Title</a>
	<a class="item" href="./?page=testbank"><i class="icon check circle"></i> Testbank</a>
	<a class="item" href="./?page=testbankhistory"><i class="icon time"></i> Testbank History</a>
	<a class="item" href="./?page=testbankscore"><i class="icon file outline"></i> Testbank Score Report</a>
	<a class="active item red" href="./?page=permission"><i class="icon ban"></i> Permission</a>
	<a class="item" href="./?page=logout"><i class="icon power off"></i> Logout</a>
</div>
</div>

<div class="col-md-9" align="center">
	<div class="ui segment">

    <?php
    $page_name = "home";
    if(isset($_REQUEST["page"])){$page_name = $_REQUEST["page"];}
    $path = "render/{$page_name}.php";
    if(file_exists($path)){
      include($path);
    } else{
      echo "<h1>404</h1>";
    }
    ?>

  </div>
</div>

</div>
<?php } ?>
</div>
</div>