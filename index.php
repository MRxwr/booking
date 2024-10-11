<?php
require_once("admin/includes/config.php");
require_once("admin/includes/functions.php");
var_dump(selectDBNew("vendors",$_REQUEST["vendorURL"],"`url` LIKE ? AND `hidden` = '0' AND `status` = '0'",""));
/*
if( isset($_REQUEST["vendorURL"]) && !empty($_REQUEST["vendorURL"]) && $vendor = selectDBNew("vendors",$_REQUEST["vendorURL"],"`url` LIKE ? AND `hidden` = '0' AND `status` = '0'","") ){
	$vendor = $vendor[0];
}else{
	header("Location: default");die();
}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>Booking System - <?php echo direction($vendor["enTitle"],$vendor["arTitle"]) ?></title>
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
		<script src="https://use.fontawesome.com/245c9398b0.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
		<style>
			<?php require_once("templates/main/style.css") ?>
		</style>
	</head>
	<body>
		<div class="container-fluid p-0">
			<div class="row w-100 m-0">
			<?php require_once("templates/main/leftSide.php") ?>
			<?php require_once("templates/main/rightSide.php") ?>
			</div>
		</div>
		<script>
			<?php require_once("templates/main/script.js") ?>
		</script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
	</body> 
</html>
*/