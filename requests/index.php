<?php
SESSION_START();
header("Content-Type: application/json");
require_once("../admin/includes/config.php");
require_once("../admin/includes/functions.php");

if( isset($_GET["page"]) && $_GET["page"] == "success" ){
	die();
}elseif( isset($_GET["page"]) && $_GET["page"] == "failure" ){
	die();
}

if( isset($_GET["lang"]) && !empty($_GET["lang"]) ){
	$requestLang = $_GET["lang"];
}else{
	$requestLang = "en";
}

if ( isset(getallheaders()["Authorization"]) && !empty(getallheaders()["Authorization"])){
	var_dump(selectDBNew("tokens",[getallheaders()["Authorization"]],"`token` LIKE ?",""));
	if( $checkToken = selectDBNew("tokens",[getallheaders()["Authorization"]],"`token` LIKE ?","") ){
		$token = $checkToken[0];
	}else{
		outputError(array("msg"=>"Invalid Authorization Token"));die();
	}
}else{
	$error = array("msg"=>"Please Set Authorization Token");
	echo outputError($error);die();
}

// get viewed page from pages folder \\
if( isset($_GET["a"]) && searchFile("views","api{$_GET["a"]}.php") ){
	require_once("views/".searchFile("views","api{$_GET["a"]}.php"));
}else{
	$error = array("msg"=>"Wrong Action Request");
	echo outputError($error);die();
}
?>