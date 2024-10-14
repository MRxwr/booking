<div class="col-5 p-0" id="leftSide">
	<!-- header -->
	<?php require_once("templates/main/header.php") ?>
	<!-- end of header -->

	<!-- mobile hero section -->
	<?php require_once("templates/main/hero.php") ?>
	<!-- end of mobile hero section -->

	<!-- social Media Bar -->
	<?php require_once("templates/main/socialMedia.php") ?>
	<!-- end of social media bar -->
	<div id="loading-screen" style="display: none;">
		<img src="img/loading.png" alt="Loading...">
	</div>
	<!-- rest of page -->
	<?php
	if( isset($_GET["status"]) && $_GET["status"] == "success" ){
		//cal success
		require_once("templates/main/success.php");
	}elseif( isset($_GET["status"]) && $_GET["status"] == "failure" ){
		//call failure
		require_once("templates/main/failure.php");
	}else{
		//call selections
		require_once("templates/main/selections.php");
		
		//call info
		require_once("templates/main/info.php");
	}
	?>
	<!-- end of rest of page -->
	
	<!-- mobile footer -->
	<?php require_once("templates/main/powered.php") ?>
	<!-- end of mobile footer -->
</div>