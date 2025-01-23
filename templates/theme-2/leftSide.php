<div class="col-12" id="leftSide">
	<!-- header -->
	<?php require_once("templates/{$vendorTheme}/header.php") ?>
	<!-- end of header -->

	<!-- mobile hero section -->
	<?php require_once("templates/{$vendorTheme}/hero.php") ?>
	<!-- end of mobile hero section -->

	<!-- social Media Bar -->
	<?php require_once("templates/{$vendorTheme}/socialMedia.php") ?>
	<!-- end of social media bar -->
	 
	<!-- rest of page -->
	<?php
	if( isset($_GET["status"]) && $_GET["status"] == "success" ){
		//cal success
		require_once("templates/{$vendorTheme}/success.php");
	}elseif( isset($_GET["status"]) && $_GET["status"] == "failure" ){
		//call failure
		require_once("templates/{$vendorTheme}/failure.php");
	}else{
		//call selections
		require_once("templates/{$vendorTheme}/selections.php");

		//call info
		require_once("templates/{$vendorTheme}/info.php");
	}
	?>
	<!-- end of rest of page -->
	
	<!-- mobile footer -->
	<?php require_once("templates/{$vendorTheme}/powered.php") ?>
	<!-- end of mobile footer -->
</div>