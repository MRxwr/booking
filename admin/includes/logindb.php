<?php
require_once("functions.php");
die("succeess");
if( $login = selectDB("employees","`email` LIKE '{$_POST["email"]}' AND `password` LIKE '".sha1($_POST["password"])."' AND `hidden` != '2' AND `status` = '0'") ){
	$GenerateNewCC = md5(rand());
	if( updateDB("employees",array("keepMeAlive"=>$GenerateNewCC),"`id` = '{$login[0]["id"]}'") ){
		$_SESSION["createkuwaitAdmin"] = $email;
		header("Location: ../index.php");
		setcookie("createkuwaitAdmin", $GenerateNewCC, time() + (86400*30 ), "/");die();
	}
}else{
	header("Location: ../login.php?error=p");die();
}
?>