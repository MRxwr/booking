<?php
SESSION_START();
header("Content-Type: application/json");
require_once("../../admin/includes/config.php");
require_once("../../admin/includes/functions.php");

if( isset($_GET["lang"]) && !empty($_GET["lang"]) ){
	$requestLang = $_GET["lang"];
}else{
	$requestLang = "en";
}

// get viewed page from pages folder \\
if( isset($_GET["a"]) && searchFile("views","api{$_GET["a"]}.php") ){
	require_once("views/".searchFile("views","api{$_GET["a"]}.php"));
}else{
	$error = array("msg"=>"Wrong Action Request 404");
	echo outputError($error);die();
}
?>