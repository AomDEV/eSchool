<?php 
require("public/core/settings.php");
if(!class_exists('aom')){ require("public/classes/class.aom.php"); }
if(!class_exists('database')){ require("public/classes/class.database.php"); }
$db = new database($_CONFIG);
$aom = new aom($_CONFIG);

if($aom->requireLogin($_SESSION)){
if(isset($_GET["id"]) and is_numeric($_GET["id"])):
	$portfolioInfo = $db->getRow("SELECT * FROM portfolio WHERE id=?",array(intval($_GET["id"])));
?>
<div class="ui segment">
<h1 align="left">
	<i class="icon folder"></i> <b><?=$portfolioInfo["title"]?></b> 
	<a href="./?page=portfolio" class="btn btn-xs btn-primary"><i class="icon home"></i> <font tkey="label-back"></font></a>
</h1><hr style="margin-top:-5px;" />
<img src="<?=$portfolioInfo["title_image"]?>" style="max-width: 100%;height: auto;" />
<div id="content" align="left" style="margin-top:10px;margin-bottom: 10px;"><?=($portfolioInfo["content"])?></div>
</div>
<?php else: ?>
<h1 align="left"><i class="icon folder"></i> <font tkey="menu-portfolio"></font></h1>

<div class="row">
	<?php foreach($db->getRows("SELECT * FROM portfolio") as $row): ?>
	<div class="col-md-6">
		<div class="thumbnail">
			<img src="<?=$row["title_image"]?>">
			<div class="caption">
				<p><?=$row["title"]?></p>
				<a href="./?page=portfolio&id=<?=$row["id"]?>" class="ui button fluid"><i class="icon eye"></i> <font tkey="label-view"></font></a>
			</div>
		</div>
	</div>
	<?php endforeach; ?>
</div>

<?php endif;} else{echo "Require login!";} ?>