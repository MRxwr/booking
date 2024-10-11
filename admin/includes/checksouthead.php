<?php
if ( isset($_COOKIE["createkuwaitAdmin"]) && !empty($_COOKIE["createkuwaitAdmin"]) ){
	if ( $user = selectDBNew("employees",[$_COOKIE["createkuwaitAdmin"]],"`keepMeAlive` LIKE ? AND `status` = '0'","") ){
		$userID = $user[0]["id"];
		$email = $user[0]["email"];
		$username = $user[0]["fullName"];
		$userType = $user[0]["empType"];
		$vendorId = 0;
	}else{
		header("Location: logout.php");die();
	}
}else{
	header("Location: login.php");die();
}
?>