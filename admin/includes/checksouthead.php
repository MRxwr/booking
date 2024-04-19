<?php
if ( isset($_COOKIE["createkuwaitAdmin"]) && !empty($_COOKIE["createkuwaitAdmin"]) && $login = selectDB("employees","`keepMeAlive` LIKE '%{$_COOKIE["createkuwaitAdmin"]}%'") ){
	var_dump($login);die();
	$userID = $login[0]["id"];
	$email = $login[0]["email"];
	$username = $login[0]["fullName"];
	$userType = $login[0]["empType"];
}else{
	header("Location: logout.php");die();
}
?>