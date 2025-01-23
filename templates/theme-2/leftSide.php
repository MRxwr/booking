<div class="col-12" id="leftSide">
	<!-- header -->
	<?php require_once("templates/{$theme}/header.php") ?>
	<!-- end of header -->

	<!-- mobile hero section -->
	<?php require_once("templates/{$theme}/hero.php") ?>
	<!-- end of mobile hero section -->

	<!-- social Media Bar -->
	<?php require_once("templates/{$theme}/socialMedia.php") ?>
	<!-- end of social media bar -->
	 
	<!-- rest of page -->
	<?php
	if( isset($_GET["status"]) && $_GET["status"] == "success" ){
		//cal success
		require_once("templates/{$theme}/success.php");
	}elseif( isset($_GET["status"]) && $_GET["status"] == "failure" ){
		//call failure
		require_once("templates/{$theme}/failure.php");
	}else{
		//call selections
		require_once("templates/{$theme}/selections.php");
		var_dump($theme);
		//call info
		require_once("templates/{$theme}/info.php");
	}
	?>
	<!-- end of rest of page -->
	
	<!-- mobile footer -->
	<?php require_once("templates/{$theme}/powered.php") ?>
	<!-- end of mobile footer -->
</div>