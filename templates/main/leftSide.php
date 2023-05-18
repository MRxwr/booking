<div class="col-12 p-0" id="leftSide">
	<!-- header -->
	<?php require_once("templates/main/header.php") ?>
	<!-- end of header -->

	<!-- mobile hero section -->
	<?php require_once("templates/main/hero.php") ?>
	<!-- end of mobile hero section -->

	<!-- social Media Bar -->
	<?php require_once("templates/main/socialMedia.php") ?>
	<!-- end of social media bar -->
	
	<!-- rest of page -->
	<?php
	if( isset($_GET["status"]) && $_GET["status"] == "success" ){
		//cal success
		require_once("templates/main/success.php");
	}else{
		//call selections
		require_once("templates/main/selections.php");
		
		// call services
		require_once("templates/main/services.php");
		
		// call services
		require_once("templates/main/times.php");
		
		//call info
		require_once("templates/main/info.php");
	}
	?>
	<!-- end of rest of page -->
	
	<!-- mobile footer -->
	<?php require_once("templates/main/powered.php") ?>
	<!-- end of mobile footer -->
</div>