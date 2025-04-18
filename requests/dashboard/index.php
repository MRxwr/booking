<?php
SESSION_START();
header("Content-Type: application/json");
require_once("../../admin/includes/config.php");
require_once("../../admin/includes/functions.php");

// get user token from auth bearer
if( isset($_SERVER["HTTP_AUTHORIZATION"]) && !empty($_SERVER["HTTP_AUTHORIZATION"]) ){
	$token = explode(" ", $_SERVER["HTTP_AUTHORIZATION"]);
	if( isset($token[1]) && !empty($token[1]) ){
		$token = $token[1];
	}else{
		$token = "";
	}
}else{
	$token = "";
}

$titleDB = checkAPILanguege("enTitle","arTitle");

// get viewed page from pages folder \\
if( isset($_GET["endpoint"]) && searchFile("views","api{$_GET["endpoint"]}.php") ){
	require_once("views/".searchFile("views","api{$_GET["endpoint"]}.php"));
}else{
	$error = array("msg"=>"Wrong Action Request 404");
	echo outputError($error);die();
}
?>